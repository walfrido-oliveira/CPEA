<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalculationVariable;
use App\Models\CalculationParameter;
use App\Http\Requests\CalculationVariableRequest;

class CalculationVariableController extends Controller
{
    /**
     * Display a listing of the calculation-variables.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $calculationVariables =  CalculationVariable::filter($request->all());
        $calculationParameters = CalculationParameter::all()->pluck('parameter_analysis_name', 'id');

        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';

        return view('calculation-variable.index', compact('calculationVariables', 'calculationParameters', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $calculationParameters = CalculationParameter::all()->pluck('parameter_analysis_name', 'id');
        return view('calculation-variable.create', compact('calculationParameters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CalculationVariableRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CalculationVariableRequest $request)
    {
        $input = $request->all();

        CalculationVariable::create([
            'calculation_parameter_id' => $input['calculation_parameter_id'],
            'name' => $input['name'],
        ]);

        return redirect()->route('registers.calculation-variable.index')->with(defaultSaveMessagemNotification());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $calculationVariable = CalculationVariable::findOrFail($id);

        return view('calculation-variable.show', compact('calculationVariable'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $calculationVariable = CalculationVariable::findOrFail($id);
        $calculationParameters = CalculationParameter::all()->pluck('parameter_analysis_name', 'id');
        return view('calculation-variable.edit', compact('calculationVariable', 'calculationParameters'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CalculationVariableRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CalculationVariableRequest $request, $id)
    {
        $input = $request->all();

        $calculationParameter = CalculationVariable::findOrFail($id);

        $calculationParameter->update([
            'calculation_parameter_id' => $input['calculation_parameter_id'],
            'name' => $input['name'],
        ]);

        return redirect()->route('registers.calculation-variable.index', ['calculationParameter' => $calculationParameter->id])->with(defaultSaveMessagemNotification());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $calculationParameter = CalculationVariable::findOrFail($id);

        $calculationParameter->delete();

        return response()->json([
            'message' => __('Param. Variável Fórmula Cálculo com Sucesso!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter CalculationVariable
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $calculationVariables = CalculationVariable::filter($request->all());
        $calculationVariables = $calculationVariables->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginate_per_page = $request->get('paginate_per_page');

        return response()->json([
        'filter_result' => view('calculation-variable.filter-result', compact('calculationVariables', 'orderBy', 'ascending'))->render(),
        'pagination' => view('layouts.pagination', [
            'models' => $calculationVariables,
            'order_by' => $orderBy,
            'ascending' => $ascending,
            'paginate_per_page' => $paginate_per_page,
            ])->render(),
        ]);
    }

    /**
     * Filter by calculition parameter
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function filterByCalculationParameter($id)
    {
        $calculationVariables = CalculationVariable::where('calculation_parameter_id', $id)->get();

        return response()->json([
            'result' => view('calculation-parameter.calculation-variables-list', compact('calculationVariables'))->render()
        ]);
    }
}
