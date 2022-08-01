<?php

namespace App\Http\Controllers;

use App\Models\FieldType;
use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
     /**
     * Display a listing of the Ref.
     *
     * @param  Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $forms = Form::where('field_type_id', $id)->get();
        $fieldType = FieldType::findOrFail($id);
        return view('form.show', compact('forms', 'fieldType'));
    }
}
