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

      usort($samples, function($a, $b) {
        $firstDate = Carbon::parse($a['collect']);
        $secondDate = Carbon::parse($b['collect']);
        return (!$firstDate->gt($secondDate)) ? 1 : -1;
      });

      $values['samples'] = $samples;
      $formPrint->formValue->values = $values;

      $html = view('form-values.print.index', compact('formPrint'))->render();

      return response()->stream(function () use($formValue, $html) {

        $dompdf = new Dompdf(array('tempDir'=>'/srv/www/xyz/tmp'));
        $dompdf->setPaper('A4');
        $dompdf->loadHtml($html);

        $dompdf->render();

        $canvas = $dompdf->get_canvas();
        $canvas->page_text(280, 820, "{PAGE_NUM} de {PAGE_COUNT}", null, 8, array(0,0,0));

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

      if($formValue->signed && !$request->has('rev_id')) {
        $resp = [
            "message" => __("Laudo não pode ser assiando sem uma revisão!"),
            "alert-type" => "error",
        ];
        return redirect()->route('fields.form-values.index')->with($resp);
      }

      $formValue->signed = true;

      $formValue->save();

      $html = view('form-values.print.index', compact('formPrint'))->render();

      return response()->stream(function () use($formValue, $html) {

        $dompdf = new Dompdf(array('tempDir'=>'/srv/www/xyz/tmp'));
        $dompdf->setPaper('A4');
        $dompdf->loadHtml($html);

        $dompdf->render();

        $canvas = $dompdf->get_canvas();
        $canvas->page_text(280, 820, "{PAGE_NUM} de {PAGE_COUNT}", null, 8, array(0,0,0));

        $fileName = $formValue->values['project_id'];
        $dompdf->stream("$fileName.pdf", array("Attachment" => false));

      }, 200);

    }
}
