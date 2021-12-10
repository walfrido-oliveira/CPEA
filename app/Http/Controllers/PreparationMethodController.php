<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\PreparationMethod;

class PreparationMethodController extends Controller
{
     /**
     * Display a listing of the user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $preparationMethods =  PreparationMethod::filter($request->all());
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';

        return view('preparation-method.index', compact('preparationMethods', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('preparation-method.create');
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
            'name' => ['required', 'string', 'max:255', Rule::unique('preparation_methods', 'name')],
        ]);

        $input = $request->all();

        $preparationMethod =   PreparationMethod::create([
            'name' => $input['name']
        ]);

        $resp = [
            'message' => __('Método Preparo Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.preparation-method.index')->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $preparationMethod = PreparationMethod::findOrFail($id);
        return view('preparation-method.show', compact('preparationMethod'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $preparationMethod = PreparationMethod::findOrFail($id);
        return view('preparation-method.edit', compact('preparationMethod'));
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
        $preparationMethod = PreparationMethod::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('preparation_methods', 'name')->ignore($preparationMethod->id)],
        ]);

        $input = $request->all();

        $preparationMethod->update([
            'name' => $input['name'],
        ]);

        $resp = [
            'message' => __('Método Preparo Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.preparation-method.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $preparationMethod = PreparationMethod::findOrFail($id);

        $preparationMethod->delete();

        return response()->json([
            'message' => __('Método Preparo Apagado com Sucesso!!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter Plan Action Level
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $preparationMethods = PreparationMethod::filter($request->all());
        $preparationMethods = $preparationMethods->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('preparation-method.filter-result', compact('preparationMethods', 'orderBy', 'ascending'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $preparationMethods,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
                ])->render(),
            ]);
    }
}
