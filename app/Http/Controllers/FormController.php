<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FieldType;
use App\Models\FormValue;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
     /**
     * Display a listing of the Ref.
     *
     * @param  Request  $request
     * @param int $id
     * @param string $project_id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id, $project_id)
    {
        $forms = Form::where('field_type_id', $id)->get();
        $fieldType = FieldType::findOrFail($id);
        return view('form.show', compact('forms', 'fieldType', 'project_id'));
    }

    /**
     * Display a listing of the Ref.
     *
     * @param  Request  $request
     * @param int $id
     * @param string $project_id
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id, $project_id)
    {
        $form = Form::findOrFail($id);

        return view('form.RT-GPA-047', compact('form', 'project_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'form_id' => ['required', 'exists:forms,id']
        ]);

        if ($validator->fails())
        {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }

        $input = $request->except('_method', '_token', 'form_id');

        $formValue = FormValue::create([
            'form_id' => $request->get('form_id'),
            'values' => $input,
        ]);

        $resp = [
            'message' => __('Formulário adicionado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('fields.forms.edit', ['form_value' => $formValue->id])->with($resp);
    }

    /**
     * Display a listing of the Ref.
     *
     * @param  Request  $request
     * @param int $id
     * @param string $project_id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $formValue = FormValue::findOrFail($id);
        $form = $formValue->form;
        $project_id = $formValue->values['project_id'];

        return view('form.RT-GPA-047', compact('form', 'project_id', 'formValue'));
    }
}
