<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnalysisMatrix;
use App\Models\AnalysisMethod;
use App\Models\ParameterMethod;
use App\Models\ParameterAnalysis;
use App\Models\PreparationMethod;
use App\Http\Requests\ParameterMethodRequest;

class ParameterMethodController extends Controller
{
    /**
     * Display a listing of the user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $parameterMethods =  ParameterMethod::filter($request->all());

        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'type';

        return view('parameter-method.index', compact('parameterMethods', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $preparationMethod = PreparationMethod::all()->pluck('name', 'id');
        $type = ['preparation' => __('Preparação'), 'analysis' => __('Análise')];

        return view('parameter-method.create', compact('preparationMethod', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ParameterMethodRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParameterMethodRequest $request)
    {
        $input = $request->all();

        $parameterMethod =   ParameterMethod::create([
            'preparation_method_id' => $input['preparation_method_id'],
            'validate_preparation' => isset($input['validate_preparation']) ? true : false,
            'time_preparation' => $input['time_preparation'],
            'type' => $input['type'],
        ]);

        $resp = [
            'message' => __('Método Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.parameter-method.index')->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $parameterMethod = ParameterMethod::findOrFail($id);
        return view('parameter-method.show', compact('parameterMethod'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $parameterMethod = ParameterMethod::findOrFail($id);
        $preparationMethod = PreparationMethod::all()->pluck('name', 'id');
        $type = ['preparation' => __('Preparação'), 'analysis' => __('Análise')];

        return view('parameter-method.edit', compact('preparationMethod', 'type', 'parameterMethod'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ParameterMethodRequest $request, $id)
    {
        $parameterMethod = ParameterMethod::findOrFail($id);

        $input = $request->all();

        $parameterMethod->update([
            'preparation_method_id' => $input['preparation_method_id'],
            'validate_preparation' => isset($input['validate_preparation']) ? true : false,
            'time_preparation' => $input['time_preparation'],
            'type' => $input['type'],
        ]);

        $resp = [
            'message' => __('Método Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.parameter-method.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $parameterMethod = ParameterMethod::findOrFail($id);

        $parameterMethod->delete();

        return response()->json([
            'message' => __('Método Apagado com Sucesso!!'),
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
        $parameterMethods = ParameterMethod::filter($request->all());
        $parameterMethods = $parameterMethods->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('parameter-method.filter-result', compact('parameterMethods', 'orderBy', 'ascending'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $parameterMethods,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
                ])->render(),
            ]);
    }
}
