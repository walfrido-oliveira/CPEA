<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\EnvironmentalArea;

class EnvironmentalAreaController extends Controller
{
     /**
     * Display a listing of the EnvironmentalArea.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $environmentalAreas =  EnvironmentalArea::filter($request->all());
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';

        return view('environmental-area.index', compact('environmentalAreas', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('environmental-area.create');
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
            'name' => ['required', 'string', 'max:255', Rule::unique('environmental_areas', 'name')],
        ]);

        $input = $request->all();

        $environmentalArea =   EnvironmentalArea::create([
            'name' => $input['name']
        ]);

        $resp = [
            'message' => __('Tipo Área Ambiental Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.environmental-area.index')->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $environmentalArea = EnvironmentalArea::findOrFail($id);
        return view('environmental-area.show', compact('environmentalArea'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $environmentalArea = EnvironmentalArea::findOrFail($id);
        return view('environmental-area.edit', compact('environmentalArea'));
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
        $environmentalArea = EnvironmentalArea::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('environmental_areas', 'name')->ignore($environmentalArea->id)],
        ]);

        $input = $request->all();

        $environmentalArea->update([
            'name' => $input['name'],
        ]);

        $resp = [
            'message' => __('Tipo Área Ambiental Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.environmental-area.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $environmentalArea = EnvironmentalArea::findOrFail($id);

        $environmentalArea->delete();

        return response()->json([
            'message' => __('Tipo Área Ambiental Apagado com Sucesso!!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter EnvironmentalArea
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $environmentalAreas = EnvironmentalArea::filter($request->all());
        $environmentalAreas = $environmentalAreas->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('environmental-area.filter-result', compact('environmentalAreas', 'orderBy', 'ascending'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $environmentalAreas,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
                ])->render(),
            ]);
    }
}
