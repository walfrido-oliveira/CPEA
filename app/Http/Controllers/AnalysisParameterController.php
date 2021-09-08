<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\AnalysisParameter;

class AnalysisParameterController extends Controller
{
    /**
     * Display a listing of the user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $analysisParameters =  AnalysisParameter::filter($request->all());
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';

        return view('analysis-parameter.index', compact('analysisParameters', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('analysis-parameter.create');
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
            'name' => ['required', 'string', 'max:255', Rule::unique('analysis_parameters', 'name')],
        ]);

        $input = $request->all();

        $analysisParameter =   AnalysisParameter::create([
            'name' => $input['name']
        ]);

        $resp = [
            'message' => __('Tipo Param. Análise Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.analysis-parameter.index')->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $analysisParameter = AnalysisParameter::findOrFail($id);
        return view('analysis-parameter.show', compact('analysisParameter'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $analysisParameter = AnalysisParameter::findOrFail($id);
        return view('analysis-parameter.edit', compact('analysisParameter'));
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
        $analysisParameter = AnalysisParameter::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('analysis_parameters', 'name')->ignore($analysisParameter->id)],
        ]);

        $input = $request->all();

        $analysisParameter->update([
            'name' => $input['name'],
        ]);

        $resp = [
            'message' => __('Tipo Param. Análise Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.analysis-parameter.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $analysisParameter = AnalysisParameter::findOrFail($id);

        $analysisParameter->delete();

        return response()->json([
            'message' => __('Tipo Param. Análise Apagado com Sucesso!!'),
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
        $analysisParameters = AnalysisParameter::filter($request->all());
        $analysisParameters = $analysisParameters->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('analysis-parameter.filter-result', compact('analysisParameters', 'orderBy', 'ascending'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $analysisParameters,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
                ])->render(),
            ]);
    }
}
