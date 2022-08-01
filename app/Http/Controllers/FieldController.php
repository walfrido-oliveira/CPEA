<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\FieldType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class FieldController extends Controller
{
     /**
     * Display a listing of the Ref.
     *
     * @param  Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'project_id';

        $fields =  Field::where('field_type_id', $id)->orderBy($orderBy, $ascending)->paginate(10);

         return view('field.index', compact('fields', 'ascending', 'orderBy', 'id'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $fields = FieldType::all();
        return view('field.show', compact('fields'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'project_id' => ['required', 'string'],
            'obs' => ['nullable', 'string'],
            'field_type_id' => ['required', 'exists:field_types,id']
        ]);

        if ($validator->fails())
        {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }

       Field::create([
            'project_id' => $input['project_id'],
            'obs' => $input['obs'],
            'field_type_id' => $input['field_type_id'],
        ]);

        return response()->json([
            'message' => __('Projeto Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ]);
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $field = Field::findOrFail($id);

        return view('field.edit', compact('field'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $field = Field::findOrFail($id);

        $input = $request->all();

        $request->validate([
            'project_id' => ['required', 'string'],
            'obs' => ['nullable', 'string'],
            'field_type_id' => ['required', 'exists:field_types,id']
        ]);

        $field->update([
            'project_id' => $input['project_id'],
            'obs' => $input['obs'],
            'field_type_id' => $input['field_type_id'],
        ]);

        $resp = [
            'message' => __('Projeto Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('fields.index', ['type' => $input['field_type_id']])->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ref = Field::findOrFail($id);

        $ref->delete();

        return response()->json([
            'message' => __('Projeto Apagado com Sucesso!!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter Ref
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $fields = Field::filter($request->all());
        $fields = $fields->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('field.filter-result', compact('fields', 'orderBy', 'ascending'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $fields,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
                ])->render(),
            ]);
    }
}
