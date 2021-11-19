<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParameterAnalysis;
use App\Models\CalculationParameter;
use App\Http\Requests\CalculationParameterRequest;

class CalculationParameterController extends Controller
{
    /**
     * Display a listing of the calculation-parameter.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $calculationParameters =  CalculationParameter::filter($request->all());
        $parameterAnalysis = ParameterAnalysis::pluck('analysis_parameter_name', 'id');

        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'parameter_analysis_id';

        return view('calculation-parameter.index', compact('calculationParameters', 'parameterAnalysis', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parameterAnalysis = ParameterAnalysis::pluck('analysis_parameter_name', 'id');
        $parameterAnalysisCalc = ParameterAnalysis::all()->pluck('analysis_parameter_name', 'calc_name');
        return view('calculation-parameter.create', compact('parameterAnalysis', 'parameterAnalysisCalc'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CalculationParameterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CalculationParameterRequest $request)
    {
        $input = $request->all();

        $calculationParameter = CalculationParameter::create([
            'parameter_analysis_id' => $input['parameter_analysis_id'],
            'formula' => $input['formula'],
        ]);

        return redirect()->route('registers.calculation-parameter.index')->with(defaultSaveMessagemNotification());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $calculationParameter = CalculationParameter::findOrFail($id);

        return view('calculation-parameter.show', compact('calculationParameter'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $calculationParameter = CalculationParameter::findOrFail($id);
        $parameterAnalysis = ParameterAnalysis::pluck('analysis_parameter_name', 'id');
        $parameterAnalysisCalc = ParameterAnalysis::all()->pluck('analysis_parameter_name', 'calc_name');
        return view('calculation-parameter.edit', compact('calculationParameter', 'parameterAnalysis', 'parameterAnalysisCalc'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CalculationParameterRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CalculationParameterRequest $request, $id)
    {
        $input = $request->all();

        $calculationParameter = CalculationParameter::findOrFail($id);

        $calculationParameter->update([
            'parameter_analysis_id' => $input['parameter_analysis_id'],
            'formula' => $input['formula'],
        ]);

        return redirect()->route('registers.calculation-parameter.index', ['calculationParameter' => $calculationParameter->id])->with(defaultSaveMessagemNotification());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $calculationParameter = CalculationParameter::findOrFail($id);

        $calculationParameter->delete();

        return response()->json([
            'message' => __('Param. Fórmula Cálculo Apagada com Sucesso!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter CalculationParameter
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $calculationParameters = CalculationParameter::filter($request->all());
        $calculationParameters = $calculationParameters->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginate_per_page = $request->get('paginate_per_page');

        return response()->json([
        'filter_result' => view('calculation-parameter.filter-result', compact('calculationParameters', 'orderBy', 'ascending'))->render(),
        'pagination' => view('layouts.pagination', [
            'models' => $calculationParameters,
            'order_by' => $orderBy,
            'ascending' => $ascending,
            'paginate_per_page' => $paginate_per_page,
            ])->render(),
        ]);
    }
}
