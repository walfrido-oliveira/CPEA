<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\GuidingParameter;
use App\Models\EnvironmentalArea;
use App\Models\EnvironmentalAgency;
use App\Http\Requests\GuidingParameterRequest;

class GuidingParameterController extends Controller
{
    /**
     * Display a listing of the user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $guidingParameters =  GuidingParameter::filter($request->all());
        $environmentalAgencies = EnvironmentalAgency::all()->pluck('name', 'id');
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'id';

        return view('guiding-parameter.index', compact('guidingParameters', 'environmentalAgencies', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $environmentalAgencies =  GuidingParameter::all()->pluck('name', 'id');
        $environmentalAreas = EnvironmentalArea::all()->pluck('name', 'id');
        $customers = Customer::all()->pluck('name', 'id');
        return view('guiding-parameter.create', compact('environmentalAgencies', 'environmentalAreas', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  GuidingParameterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuidingParameterRequest $request)
    {
        $input = $request->all();

        $guidingParameter = GuidingParameter::create([
            'environmental_area_id' => $input['environmental_area_id'],
            'environmental_agency_id' => $input['environmental_agency_id'],
            'customer_id' => $input['customer_id'],
            'environmental_guiding_parameter_id' => $input['environmental_guiding_parameter_id'],
            'name' => $input['name'],
            'resolutions' => $input['resolutions'],
            'articles' => $input['articles'],
            'observation' => $input['observation'],
        ]);

        return redirect()->route('guiding-parameter.index')->with(defaultSaveMessagemNotification());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $guidingParameter = GuidingParameter::findOrFail($id);

        return view('guiding-parameter.show', compact('guidingParameter'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $guidingParameter = GuidingParameter::findOrFail($id);
        $environmentalAgencies =  GuidingParameter::all()->pluck('name', 'id');
        $environmentalAreas = EnvironmentalArea::all()->pluck('name', 'id');
        $customers = Customer::all()->pluck('name', 'id');

        return view('guiding-parameter.edit', compact('guidingParameter', 'environmentalAgencies', 'environmentalAreas', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  GuidingParameterRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GuidingParameterRequest $request, $id)
    {
        $input = $request->all();

        $guidingParameter = GuidingParameter::findOrFail($id);

        $guidingParameter->update([
            'environmental_area_id' => $input['environmental_area_id'],
            'environmental_agency_id' => $input['environmental_agency_id'],
            'customer_id' => $input['customer_id'],
            'environmental_guiding_parameter_id' => $input['environmental_guiding_parameter_id'],
            'name' => $input['name'],
            'resolutions' => $input['resolutions'],
            'articles' => $input['articles'],
            'observation' => $input['observation'],
        ]);

        return redirect()->route('guiding-parameter.index')->with(defaultSaveMessagemNotification());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $guidingParameter = GuidingParameter::findOrFail($id);

        $guidingParameter->delete();

        return response()->json([
            'message' => __('Param. Orientador Apagado com Sucesso!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter GuidingParameter
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $guidingParameters = GuidingParameter::filter($request->all());
        $guidingParameters = $guidingParameters->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginate_per_page = $request->get('paginate_per_page');

        return response()->json([
        'filter_result' => view('guiding-parameter.filter-result', compact('guidingParameters', 'orderBy', 'ascending'))->render(),
        'pagination' => view('layouts.pagination', [
            'models' => $guidingParameters,
            'order_by' => $orderBy,
            'ascending' => $ascending,
            'paginate_per_page' => $paginate_per_page,
            ])->render(),
        ]);
    }
}
