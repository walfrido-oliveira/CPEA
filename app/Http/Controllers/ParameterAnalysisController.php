<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnalysisParameter;
use App\Models\ParameterAnalysis;
use App\Models\ParameterAnalysisGroup;
use App\Http\Requests\ParameterAnalysisRequest;

class ParameterAnalysisController extends Controller
{
    /**
     * Display a listing of the user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $parameterAnalyses =  ParameterAnalysis::filter($request->all());
        $analysisParameter = AnalysisParameter::all()->pluck('name', 'id');
        $parameterAnalysisGroup = ParameterAnalysisGroup::all()->pluck('name', 'id');

        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'id';

        return view('parameter-analysis.index', compact('parameterAnalyses', 'analysisParameter', 'parameterAnalysisGroup', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $analysisParameter = AnalysisParameter::all()->pluck('name', 'id');
        $parameterAnalysisGroup = ParameterAnalysisGroup::all()->pluck('name', 'id');

        return view('parameter-analysis.create', compact('analysisParameter', 'parameterAnalysisGroup'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ParameterAnalysisRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParameterAnalysisRequest $request)
    {
        $input = $request->all();

        $parameterAnalysis = ParameterAnalysis::create([
            'analysis_parameter_id' => $input['analysis_parameter_id'],
            'parameter_analysis_group_id' => $input['parameter_analysis_group_id'],
            'cas_rn' => $input['cas_rn'],
            'ref_cas_rn' => $input['ref_cas_rn'],
            'analysis_parameter_name' => $input['analysis_parameter_name'],
            'order' => $input['order'],
            'decimal_place' => $input['decimal_place'],
            'final_validity' => $input['final_validity'],
        ]);

        return redirect()->route('parameter-analysis.index')->with(defaultSaveMessagemNotification());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $parameterAnalysis = ParameterAnalysis::findOrFail($id);

        return view('parameter-analysis.show', compact('parameterAnalysis'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $parameterAnalysis = ParameterAnalysis::findOrFail($id);

        $analysisParameter = AnalysisParameter::all()->pluck('name', 'id');
        $parameterAnalysisGroup = ParameterAnalysisGroup::all()->pluck('name', 'id');

        return view('parameter-analysis.edit', compact('parameterAnalysis', 'analysisParameter', 'parameterAnalysisGroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ParameterAnalysisRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ParameterAnalysisRequest $request, $id)
    {
        $input = $request->all();

        $parameterAnalysis = ParameterAnalysis::findOrFail($id);

        $parameterAnalysis->update([
            'analysis_parameter_id' => $input['analysis_parameter_id'],
            'parameter_analysis_group_id' => $input['parameter_analysis_group_id'],
            'cas_rn' => $input['cas_rn'],
            'analysis_parameter_name' => $input['analysis_parameter_name'],
            'order' => $input['order'],
            'decimal_place' => $input['decimal_place'],
            'final_validity' => $input['final_validity'],
        ]);

        return redirect()->route('parameter-analysis.index', ['parameter_analysis' => $parameterAnalysis->id])->with(defaultSaveMessagemNotification());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $parameterAnalysis = ParameterAnalysis::findOrFail($id);

        $parameterAnalysis->delete();

        return response()->json([
            'message' => __('Param. Análise Apagado com Sucesso!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $parameterAnalyses = ParameterAnalysis::filter($request->all());
        $parameterAnalyses = $parameterAnalyses->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginate_per_page = $request->get('paginate_per_page');

        return response()->json([
        'filter_result' => view('parameter-analysis.filter-result', compact('parameterAnalyses', 'orderBy', 'ascending'))->render(),
        'pagination' => view('layouts.pagination', [
            'models' => $parameterAnalyses,
            'order_by' => $orderBy,
            'ascending' => $ascending,
            'paginate_per_page' => $paginate_per_page,
            ])->render(),
        ]);
    }
}
