<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\EnvironmentalAgency;

class EnvironmentalAgencyController extends Controller
{
    /**
     * Display a listing of the EnvironmentalAgency.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $environmentalAgencys =  EnvironmentalAgency::filter($request->all());
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';

        return view('environmental-agency.index', compact('environmentalAgencys', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('environmental-agency.create');
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
            'internal_id' => ['required', 'string', 'max:255', Rule::unique('environmental_agencies', 'internal_id')],
            'name' => ['required', 'string', 'max:255', Rule::unique('environmental_agencies', 'name')],
        ]);

        $input = $request->all();

        $environmentalArea =   EnvironmentalAgency::create([
            'internal_id' => $input['internal_id'],
            'name' => $input['name']
        ]);

        $resp = [
            'message' => __('Órgão Ambiental Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.environmental-agency.index')->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $environmentalAgency = EnvironmentalAgency::findOrFail($id);
        return view('environmental-agency.show', compact('environmentalAgency'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $environmentalAgency = EnvironmentalAgency::findOrFail($id);
        return view('environmental-agency.edit', compact('environmentalAgency'));
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
        $environmentalAgency = EnvironmentalAgency::findOrFail($id);

        $request->validate([
            'internal_id' => ['required', 'string', 'max:255', Rule::unique('environmental_agencies', 'internal_id')->ignore($environmentalAgency->id)],
            'name' => ['required', 'string', 'max:255', Rule::unique('environmental_agencies', 'name')->ignore($environmentalAgency->id)],
        ]);

        $input = $request->all();

        $environmentalAgency->update([
            'internal_id' => $input['internal_id'],
            'name' => $input['name'],
        ]);

        $resp = [
            'message' => __('Órgão Ambiental Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.environmental-agency.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $environmentalAgency = EnvironmentalAgency::findOrFail($id);

        $environmentalAgency->delete();

        return response()->json([
            'message' => __('Órgão Ambiental Apagado com Sucesso!!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter EnvironmentalAgency
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $environmentalAgencys = EnvironmentalAgency::filter($request->all());
        $environmentalAgencys = $environmentalAgencys ->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('environmental-agency.filter-result', compact('environmentalAgencys', 'orderBy', 'ascending', 'paginatePerPage'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $environmentalAgencys,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
                ])->render(),
            ]);
    }
}
