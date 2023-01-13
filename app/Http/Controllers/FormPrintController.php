<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Dompdf\Dompdf;
use App\Models\User;
use App\Models\FormValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FormPrintController extends Controller
{
        /**
     * Print Form
     */
    public function print($id)
    {
      $formValue = FormValue::findOrFail($id);
      $svgs = $formValue->getSvgs();

      $pathLogo = Config::get("form_logo");
      $pathCert = Config::get("form_cert");
      $header = Config::get("form_header");
      $footer = Config::get("form_footer");
      $user = User::find($formValue->values["responsible"]);
      $pathSigner = User::getSignerPath() . '/' . $user->signer;

      $logo = File::exists($pathLogo) ? base64_encode(file_get_contents($pathLogo)) : null;
      $crl = File::exists($pathCert) ? base64_encode(file_get_contents($pathCert)) : null;
      $signer = File::exists($pathSigner) ? base64_encode(file_get_contents($pathSigner)) : null;

      $html = view('form.print.index', compact('formValue', 'logo', 'crl', 'svgs', 'signer', 'header','footer'))->render();

      //return view('form.print', compact('formValue', 'logo', 'crl', 'svgs', 'signer'));

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
