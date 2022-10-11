<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    /**
     * Upload a image to report content
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function imageUpload(Request $request)
    {
        if($request->hasFile('upload')) {
            $path = $request->file('upload')->store('public/img');
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/' . str_replace('public/', '', $path));
            $msg = __('Imagem carregada com sucesso!');
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
}
