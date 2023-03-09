<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\FormPrint;
use App\Models\FormValue;
use Illuminate\Http\Request;

class FormPrintController extends Controller
{
    /**
     * Print Form
     */
    public function print($id)
    {
        $formValue = FormValue::findOrFail($id);
        $formPrint = new FormPrint($formValue, false);

        $values = $formPrint->formValue->values;
        $samples = $values['samples'];
        $coordinates = $values['coordinates'];
        $samples = $formValue->sortSamples('collect');
        $coordinates = $formValue->sortCoordinates();

        $values['samples'] = $samples;
        $values['coordinates'] = $coordinates;
        $formPrint->formValue->values = $values;

        $html = view('form-values.print.index', compact('formPrint'))->render();

        return response()->stream(function () use ($formValue, $html) {

            $dompdf = new Dompdf(array('tempDir' => '/srv/www/xyz/tmp'));
            $dompdf->setPaper('A4');
            $dompdf->loadHtml($html);

            $dompdf->render();

            $canvas = $dompdf->get_canvas();
            $canvas->page_text(280, 820, "{PAGE_NUM} de {PAGE_COUNT}", null, 8, array(0, 0, 0));

            $fileName = $formValue->values['project_id'];
            $dompdf->stream("$fileName.pdf", array("Attachment" => false));
        }, 200);
    }

    /**
     * Print Form
     */
    public function signer(Request $request, $id)
    {
        $formValue = FormValue::findOrFail($id);
        $formPrint = new FormPrint($formValue, true);

        if (
            !isset($formValue->values["samples"]) || !isset($formValue->values["coordinates"]) ||
            !isset($formValue->values["additional_info"]) || !isset($formValue->values["approval_text"]) ||
            $formValue->values["additional_info"] == '' || $formValue->values["approval_text"] == ''
        ) {
            $resp = [
                "message" => __("Laudo não possuí todos dados preenchidos!"),
                "alert-type" => "error",
            ];
            return redirect()->route('fields.form-values.index')->with($resp);
        }

        if ($formValue->signed && !$request->has('rev_id')) {
            $resp = [
                "message" => __("Laudo não pode ser assiando sem uma revisão!"),
                "alert-type" => "error",
            ];
            return redirect()->route('fields.form-values.index')->with($resp);
        }

        $formValue->signed = true;

        $formValue->save();

        $html = view('form-values.print.index', compact('formPrint'))->render();

        return response()->stream(function () use ($formValue, $html) {

            $dompdf = new Dompdf(array('tempDir' => '/srv/www/xyz/tmp'));
            $dompdf->setPaper('A4');
            $dompdf->loadHtml($html);

            $dompdf->render();

            $canvas = $dompdf->get_canvas();
            $canvas->page_text(280, 820, "{PAGE_NUM} de {PAGE_COUNT}", null, 8, array(0, 0, 0));

            $fileName = $formValue->values['project_id'];
            $dompdf->stream("$fileName.pdf", array("Attachment" => false));
        }, 200);
    }
}
