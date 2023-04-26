<?php

namespace App\Http\Controllers;

use App\Models\FieldType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FieldTypeController extends Controller
{
    /**
     * Display a listing of the user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fieldTypes =  FieldType::filter($request->all());
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';

        return view('field-type.index', compact('fieldTypes', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('field-type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('campaign_statuses', 'name')],
            'report_name' => ['required', 'string', 'max:255'],
        ]);

        $input = $request->all();

        FieldType::create([
            'name' => $input['name'],
            'report_name' => $input['report_name'],
        ]);

        $resp = [
            'message' => __('Status Matriz Cadastrada com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.field-type.index')->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fieldTypes = FieldType::findOrFail($id);
        return view('field-type.show', compact('fieldTypes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fieldType = FieldType::findOrFail($id);
        return view('field-type.edit', compact('fieldType'));
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
        $fieldType = FieldType::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('campaign_statuses', 'name')],
            'report_name' => ['required', 'string', 'max:255'],
        ]);

        $input = $request->all();

        $fieldType->update([
            'name' => $input['name'],
            'report_name' => $input['report_name'],
        ]);

        $resp = [
            'message' => __('Status Matriz Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.field-type.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fieldType = FieldType::findOrFail($id);

        $fieldType->delete();

        return response()->json([
            'message' => __('Status Matriz Apagado com Sucesso!!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter Field Type
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $fieldType = FieldType::filter($request->all());
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('field-type.filter-result', compact('fieldType', 'orderBy', 'ascending'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $fieldType,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
                ])->render(),
            ]);
    }
}
