<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnalysisMethod;
use Illuminate\Validation\Rule;

class AnalysisMethodController extends Controller
{
     /**
     * Display a listing of the user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $analysisMethods =  AnalysisMethod::filter($request->all());
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';

        return view('analysis-method.index', compact('analysisMethods', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('analysis-method.create');
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
            'name' => ['required', 'string', 'max:255', Rule::unique('analysis_methods', 'name')],
        ]);

        $input = $request->all();

        $campaignStatus =   AnalysisMethod::create([
            'name' => $input['name']
        ]);

        $resp = [
            'message' => __('Método Análise Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.analysis-method.index')->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $campaignStatus = AnalysisMethod::findOrFail($id);
        return view('analysis-method.show', compact('campaignStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $campaignStatus = AnalysisMethod::findOrFail($id);
        return view('analysis-method.edit', compact('campaignStatus'));
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
        $campaignStatus = AnalysisMethod::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('analysis_methods', 'name')->ignore($campaignStatus->id)],
        ]);

        $input = $request->all();

        $campaignStatus->update([
            'name' => $input['name'],
        ]);

        $resp = [
            'message' => __('Método Análise Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.analysis-method.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $campaignStatus = AnalysisMethod::findOrFail($id);

        $campaignStatus->delete();

        return response()->json([
            'message' => __('Método Análise Apagado com Sucesso!!'),
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
        $analysisMethods = AnalysisMethod::filter($request->all());
        $analysisMethods = $analysisMethod->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('analysis-method.filter-result', compact('analysisMethods', 'orderBy', 'ascending'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $analysisMethod,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
                ])->render(),
            ]);
    }
}
