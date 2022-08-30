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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $forms = FormValue::filter($request->all());
        $formsTypes = Form::all()->pluck('name', 'id');

        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'form_id';
         return view('form.index', compact('forms', 'ascending', 'orderBy', 'formsTypes'));
    }

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
        $formValue = null;

        return view('form.RT-GPA-047', compact('form', 'project_id', 'formValue'));
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

    /**
     * Filter Ref
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $forms = FormValue::filter($request->all());
        $forms = $forms->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('form.filter-result', compact('forms', 'orderBy', 'ascending'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $forms,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
                ])->render(),
            ]);
    }
}
