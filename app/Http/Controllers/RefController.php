<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Ref;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RefController extends Controller
{
    /**
     * Display a listing of the Ref.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $refs =  Ref::filter($request->all());
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';

         return view('ref.index', compact('refs', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fields = Field::getFieldsArray();

        return view('ref.create', compact('fields'));
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
            'name' => ['required', 'string', 'max:255', Rule::unique('guiding_values', 'name')],
            'field' => ['required', 'string', 'max:255'],
        ]);

        $input = $request->all();

        Ref::create([
            'name' => $input['name'],
            'field' => $input['field'],
            'turbidity' => isset($input['turbidity']) ? true : false,
        ]);

        $resp = [
            'message' => __('Referências Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('fields.ref.index')->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ref = Ref::findOrFail($id);
        return view('ref.show', compact('ref'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ref = Ref::findOrFail($id);
        $fields = Field::getFieldsArray();

        return view('ref.edit', compact('ref', 'fields'));
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
        $ref = Ref::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('guiding_values', 'name')],
            'field' => ['required', 'string', 'max:255'],
        ]);

        $input = $request->all();

        $ref->update([
            'name' => $input['name'],
            'field' => $input['field'],
            'turbidity' => isset($input['turbidity']) ? true : false,
        ]);

        $resp = [
            'message' => __('Referências Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('fields.ref.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ref = Ref::findOrFail($id);

        $ref->delete();

        return response()->json([
            'message' => __('Referências Apagado com Sucesso!!'),
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
        $refs = Ref::filter($request->all());
        $refs = $refs->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('ref.filter-result', compact('refs', 'orderBy', 'ascending'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $refs,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
                ])->render(),
            ]);
    }
}
