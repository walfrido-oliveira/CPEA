<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GuidingParameterRefValue;
use App\Http\Requests\GuidingParameterRefValueRequest;

class GuidingParameterRefValueController extends Controller
{
    /**
     * Display a listing of the user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $guidingParameterRefValues =  GuidingParameterRefValue::filter($request->all());
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'guiding_parameter_ref_value_id';

        return view('guiding-parameter-ref-value.index', compact('guidingParameterRefValues', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('guiding-parameter-ref-value.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  GuidingParameterRefValueRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuidingParameterRefValueRequest $request)
    {
        $input = $request->all();

        $guidingParameterRefValue = GuidingParameterRefValue::create([
            'guiding_parameter_ref_value_id' => $input['guiding_parameter_ref_value_id'],
            'observation' => $input['observation'],
        ]);

        return redirect()->route('guiding-parameter-ref-value.index')->with(defaultSaveMessagemNotification());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $guidingParameterRefValue = GuidingParameterRefValue::findOrFail($id);

        return view('guiding-parameter-ref-value.show', compact('guidingParameterRefValue'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $guidingParameterRefValue = GuidingParameterRefValue::findOrFail($id);

        return view('guiding-parameter-ref-value.edit', compact('guidingParameterRefValue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  GuidingParameterRefValueRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GuidingParameterRefValueRequest $request, $id)
    {
        $input = $request->all();

        $guidingParameterRefValue = GuidingParameterRefValue::findOrFail($id);

        $guidingParameterRefValue->update([
            'guiding_parameter_ref_value_id' => $input['guiding_parameter_ref_value_id'],
            'observation' => $input['observation'],
        ]);

        return redirect()->route('guiding-parameter-ref-value.index')->with(defaultSaveMessagemNotification());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $guidingParameterRefValue = GuidingParameterRefValue::findOrFail($id);

        $guidingParameterRefValue->delete();

        return response()->json([
            'message' => __('Ref. Vlr. Param. Orientador Apagado com Sucesso!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter GuidingParameterRefValue
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $guidingParameterRefValues = GuidingParameterRefValue::filter($request->all());
        $guidingParameterRefValues = $guidingParameterRefValues->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginate_per_page = $request->get('paginate_per_page');

        return response()->json([
        'filter_result' => view('guiding-parameter-ref-value.filter-result', compact('guidingParameterRefValues', 'orderBy', 'ascending'))->render(),
        'pagination' => view('layouts.pagination', [
            'models' => $guidingParameterRefValues,
            'order_by' => $orderBy,
            'ascending' => $ascending,
            'paginate_per_page' => $paginate_per_page,
            ])->render(),
        ]);
    }
}
