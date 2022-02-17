<?php

namespace App\Http\Controllers;

use App\Models\To;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ToController extends Controller
{
     /**
     * Store a newly created resource in storage.
     *
     * @param  ToRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function simpleCreate(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }

        $to = To::create([
            'name' => $input['name'],
        ]);

        $resp = [
            'message' => __('Para cadastrado com Sucesso!'),
            'alert-type' => 'success',
            'tos' => To::orderBy("name")->get()
        ];

        return response()->json($resp);

    }
}
