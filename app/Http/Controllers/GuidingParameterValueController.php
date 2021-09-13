<?php

namespace App\Http\Controllers;

use App\Models\Unity;
use App\Models\GuidingValue;
use Illuminate\Http\Request;
use App\Models\AnalysisMatrix;
use App\Models\GuidingParameter;
use App\Models\ParameterAnalysis;
use App\Models\GuidingParameterValue;
use App\Models\GuidingParameterRefValue;
use App\Http\Requests\GuidingParameterValueRequest;

class GuidingParameterValueController extends Controller
{
    /**
     * Display a listing of the Guiding Parameter Value.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $guidingParameterValues =  GuidingParameterValue::filter($request->all());
        $guidingParameters = GuidingParameter::pluck('name', 'id');
        $analysisMatrices = AnalysisMatrix::pluck('name', 'id');
        $parameterAnalysises = ParameterAnalysis::pluck('analysis_parameter_name', 'id');

        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'guiding_parameter_id';

        return view('guiding-parameter-value.index',
        compact('guidingParameterValues', 'ascending', 'orderBy', 'guidingParameters', 'analysisMatrices', 'parameterAnalysises'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $guidingParameters = GuidingParameter::pluck('name', 'id');
        $analysisMatrices = AnalysisMatrix::pluck('name', 'id');
        $parameterAnalysises = ParameterAnalysis::pluck('analysis_parameter_name', 'id');
        $guidingParameterRefValues = GuidingParameterRefValue::pluck('guiding_parameter_ref_value_id', 'id');
        $guidingValues = GuidingValue::pluck('name', 'id');
        $unities = Unity::pluck('unity_cod', 'id');

        return view('guiding-parameter-value.create',
        compact('guidingParameters', 'analysisMatrices', 'parameterAnalysises', 'guidingParameterRefValues', 'guidingValues', 'unities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  GuidingParameterValueRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuidingParameterValueRequest $request)
    {
        $input = $request->all();

        $guidingParameterValue =   GuidingParameterValue::create([
            'guiding_parameter_id' => $input['guiding_parameter_id'],
            'analysis_matrix_id' => $input['analysis_matrix_id'],
            'parameter_analysis_id' => $input['parameter_analysis_id'],
            'guiding_parameter_ref_value_id' => $input['guiding_parameter_ref_value_id'],
            'guiding_value_id' => $input['guiding_value_id'],
            'unity_legislation_id' => $input['unity_legislation_id'],
            'unity_analysis_id' => $input['unity_legislation_id'],
            'guiding_legislation_value' => $input['guiding_legislation_value'],
            'guiding_legislation_value_1' => $input['guiding_legislation_value_1'],
            'guiding_legislation_value_2' => $input['guiding_legislation_value_2'],
            'guiding_analysis_value' => $input['guiding_analysis_value'],
            'guiding_analysis_value_1' => $input['guiding_analysis_value_1'],
            'guiding_analysis_value_2' => $input['guiding_analysis_value_2'],
        ]);

        $resp = [
            'message' => __('Valor Param. Orientador Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('guiding-parameter-value.index')->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $guidingParameterValue = GuidingParameterValue::findOrFail($id);
        return view('guiding-parameter-value.show', compact('guidingParameterValue'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $guidingParameterValue = GuidingParameterValue::findOrFail($id);
        $guidingParameters = GuidingParameter::pluck('name', 'id');
        $analysisMatrices = AnalysisMatrix::pluck('name', 'id');
        $parameterAnalysises = ParameterAnalysis::pluck('analysis_parameter_name', 'id');
        $guidingParameterRefValues = GuidingParameterRefValue::pluck('guiding_parameter_ref_value_id', 'id');
        $guidingValues = GuidingValue::pluck('name', 'id');
        $unities = Unity::pluck('unity_cod', 'id');

        return view('guiding-parameter-value.edit', compact('guidingParameterValue',
        'guidingParameters', 'analysisMatrices', 'parameterAnalysises', 'guidingParameterRefValues', 'guidingValues', 'unities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  GuidingParameterValueRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GuidingParameterValueRequest $request, $id)
    {
        $guidingParameterValue = GuidingParameterValue::findOrFail($id);

        $input = $request->all();

        $guidingParameterValue->update([
            'guiding_parameter_id' => $input['guiding_parameter_id'],
            'analysis_matrix_id' => $input['analysis_matrix_id'],
            'parameter_analysis_id' => $input['parameter_analysis_id'],
            'guiding_parameter_ref_value_id' => $input['guiding_parameter_ref_value_id'],
            'guiding_value_id' => $input['guiding_value_id'],
            'unity_legislation_id' => $input['unity_legislation_id'],
            'unity_analysis_id' => $input['unity_analysis_id'],
            'guiding_legislation_value' => $input['guiding_legislation_value'],
            'guiding_legislation_value_1' => $input['guiding_legislation_value_1'],
            'guiding_legislation_value_2' => $input['guiding_legislation_value_2'],
            'guiding_analysis_value' => $input['guiding_analysis_value'],
            'guiding_analysis_value_1' => $input['guiding_analysis_value_1'],
            'guiding_analysis_value_2' => $input['guiding_analysis_value_2'],
        ]);

        $resp = [
            'message' => __('Valor Param. Orientador Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('guiding-parameter-value.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $guidingParameterValue = GuidingParameterValue::findOrFail($id);

        $guidingParameterValue->delete();

        return response()->json([
            'message' => __('Valor Param. Orientador Apagado com Sucesso!!'),
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
        $guidingParameterValues = GuidingParameterValue::filter($request->all());
        $guidingParameterValues = $guidingParameterValues->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginate_per_page = $request->get('paginate_per_page');

        return response()->json([
        'filter_result' => view('guiding-parameter-value.filter-result', compact('guidingParameterValues', 'orderBy', 'ascending'))->render(),
        'pagination' => view('layouts.pagination', [
            'models' => $guidingParameterValues,
            'order_by' => $orderBy,
            'ascending' => $ascending,
            'paginate_per_page' => $paginate_per_page,
            ])->render(),
        ]);
    }

}
