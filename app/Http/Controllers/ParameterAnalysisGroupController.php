<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParameterAnalysisGroup;
use App\Http\Requests\ParamAnalysisGroupRequest;

class ParameterAnalysisGroupController extends Controller
{
    /**
    * Display a listing of the items.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $parameterAnalysisGroups =  ParameterAnalysisGroup::filter($request->all());
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';
        $parameterAnalysisGroupParents = ParameterAnalysisGroup::pluck('name', 'id');

        return view('parameter-analysis-group.index', compact('parameterAnalysisGroups', 'parameterAnalysisGroupParents', 'ascending', 'orderBy'));
    }

    /**
     * Filter
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $parameterAnalysisGroups = ParameterAnalysisGroup::filter($request->all());
        $parameterAnalysisGroups = $parameterAnalysisGroups->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginate_per_page = $request->get('paginate_per_page');

        return response()->json([
        'filter_result' => view('parameter-analysis-group.filter-result', compact('parameterAnalysisGroups', 'orderBy', 'ascending'))->render(),
        'pagination' => view('layouts.pagination', [
            'models' => $parameterAnalysisGroups,
            'order_by' => $orderBy,
            'ascending' => $ascending,
            'paginate_per_page' => $paginate_per_page,
            ])->render(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parameterAnalysisGroups = ParameterAnalysisGroup::pluck('name', 'id');

        return view('parameter-analysis-group.create', compact('parameterAnalysisGroups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ParamAnalysisGroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParamAnalysisGroupRequest $request)
    {
        $input = $request->all();

        $parameterAnalysisGroup = ParameterAnalysisGroup::create([
            'name' => $input['name'],
            'parameter_analysis_group_id' => $input['parameter_analysis_group_id'],
            'order' => $input['order'],
            'final_validity' => $input['final_validity'],
        ]);

        return redirect()->route('registers.parameter-analysis-group.index')->with(defaultSaveMessagemNotification());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $parameterAnalysisGroup = ParameterAnalysisGroup::findOrFail($id);
        $parameterAnalysisGroups = ParameterAnalysisGroup::pluck('name', 'id');

        return view('parameter-analysis-group.edit', compact('parameterAnalysisGroup', 'parameterAnalysisGroups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ParamAnalysisGroupRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ParamAnalysisGroupRequest $request, $id)
    {
        $input = $request->all();

        $parameterAnalysisGroup = ParameterAnalysisGroup::findOrFail($id);

        $parameterAnalysisGroup->update([
            'name' => $input['name'],
            'parameter_analysis_group_id' => $input['parameter_analysis_group_id'],
            'order' => $input['order'],
            'final_validity' => $input['final_validity'],
        ]);

        return redirect()->route('registers.parameter-analysis-group.index')->with(defaultSaveMessagemNotification());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $parameterAnalysisGroup = ParameterAnalysisGroup::findOrFail($id);

        return view('parameter-analysis-group.show', compact('parameterAnalysisGroup'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $parameterAnalysisGroup = ParameterAnalysisGroup::findOrFail($id);

        $parameterAnalysisGroup->delete();

        return response()->json([
            'message' => __('Grupo Param. Análise Apagado com Sucesso!'),
            'alert-type' => 'success'
        ]);
    }
}
