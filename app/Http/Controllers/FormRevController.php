<?php

namespace App\Http\Controllers;

use App\Models\FormRev;
use App\Models\FormValue;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class FormRevController extends Controller
{
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "form_value_id" => ["required", "exists:form_values,id"],
            "reason" => ["required", "string"],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }

        $input = $request->except("_method", "_token", "form_id");

        $formRev = FormRev::create([
            'form_value_id' => $input['form_value_id'],
            'user_id' => auth()->user()->id,
            'reason' => $input['reason'],
        ]);


        $resp = [
            "message" => __("Revisão adicionada com Sucesso!"),
            "form_rev" => $formRev,
            "alert-type" => "success",
        ];

        return response()->json($resp);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function signed(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "form_value_id" => ["required", "exists:form_values,id"],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }

        $input = $request->except("_method", "_token");

        $formValue = FormValue::findOrFail($input['form_value_id']);


        $resp = [
            "signed" => $formValue->signed,
        ];

        return response()->json($resp);
    }
}
