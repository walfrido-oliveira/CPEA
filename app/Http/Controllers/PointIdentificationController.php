<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeodeticSystem;
use App\Models\PointIdentification;
use App\Http\Requests\PointIdentificationRequest;

class PointIdentificationController extends Controller
{
    /**
     * Display a listing of the user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pointIdentifications =  PointIdentification::filter($request->all());
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'id';

        return view('point-identification.index', compact('pointIdentifications', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $geodeticSystems = GeodeticSystem::pluck("name", "id");
        return view('point-identification.create', compact('geodeticSystems'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PointIdentificationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PointIdentificationRequest $request)
    {
        $input = $request->all();

        $pointIdentification =   PointIdentification::create([
            'area' => $input['area'],
            'identification' => $input['identification'],
            'geodetic_system_id' => $input['geodetic_system_id'],
            'utm_me_coordinate' => isset($input['utm_me_coordinate']) ? $input['utm_me_coordinate'] : null,
            'utm_mm_coordinate' => isset($input['utm_mm_coordinate']) ? $input['utm_mm_coordinate'] : null,
            'pool_depth' => isset($input['pool_depth']) ? $input['pool_depth'] : null,
            'pool_diameter' => isset($input['pool_diameter']) ? $input['pool_diameter'] : null,
            'pool_volume' => isset($input['pool_volume']) ? $input['pool_volume'] : null,
            'water_depth' => isset($input['water_depth']) ? $input['water_depth'] : null,
            'sedimentary_collection_depth' => isset($input['sedimentary_collection_depth']) ? $input['sedimentary_collection_depth'] : null,
            'collection_depth' => isset($input['collection_depth']) ? $input['collection_depth'] : null,
            'water_collection_depth' => isset($input['water_collection_depth']) ? $input['water_collection_depth'] : null,
        ]);

        $resp = [
            'message' => __('Ponto Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.point-identification.index')->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pointIdentification = PointIdentification::findOrFail($id);
        return view('point-identification.show', compact('pointIdentification'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pointIdentification = PointIdentification::findOrFail($id);
        $geodeticSystems = GeodeticSystem::pluck("name", "id");
        return view('point-identification.edit', compact('pointIdentification', 'geodeticSystems'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PointIdentificationRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PointIdentificationRequest $request, $id)
    {
        $pointIdentification = PointIdentification::findOrFail($id);

        $input = $request->all();

        $pointIdentification->update([
            'area' => $input['area'],
            'identification' => $input['identification'],
            'geodetic_system_id' => $input['geodetic_system_id'],
            'utm_me_coordinate' => isset($input['utm_me_coordinate']) ? $input['utm_me_coordinate'] : null,
            'utm_mm_coordinate' => isset($input['utm_mm_coordinate']) ? $input['utm_mm_coordinate'] : null,
            'pool_depth' => isset($input['pool_depth']) ? $input['pool_depth'] : null,
            'pool_diameter' => isset($input['pool_diameter']) ? $input['pool_diameter'] : null,
            'pool_volume' => isset($input['pool_volume']) ? $input['pool_volume'] : null,
            'water_depth' => isset($input['water_depth']) ? $input['water_depth'] : null,
            'sedimentary_collection_depth' => isset($input['sedimentary_collection_depth']) ? $input['sedimentary_collection_depth'] : null,
            'collection_depth' => isset($input['collection_depth']) ? $input['collection_depth'] : null,
            'water_collection_depth' => isset($input['water_collection_depth']) ? $input['water_collection_depth'] : null,
        ]);

        $resp = [
            'message' => __('Ponto Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.point-identification.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pointIdentification = PointIdentification::findOrFail($id);

        $pointIdentification->delete();

        return response()->json([
            'message' => __('Ponto Apagado com Sucesso!!'),
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
        $pointIdentifications = PointIdentification::filter($request->all());
        $pointIdentifications = $pointIdentifications->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginate_per_page = $request->get('paginate_per_page');

        return response()->json([
        'filter_result' => view('point-identification.filter-result', compact('pointIdentifications', 'orderBy', 'ascending'))->render(),
        'pagination' => view('layouts.pagination', [
            'models' => $pointIdentifications,
            'order_by' => $orderBy,
            'ascending' => $ascending,
            'paginate_per_page' => $paginate_per_page,
            ])->render(),
        ]);
    }

    /**
     * Filter by area
     * @param String $area
     * @return \Illuminate\Http\Response
     */
    public function filterByArea($area)
    {
        $pointIdentifications = PointIdentification::where('area', $area)->get();

        return response()->json([
            'point_identifications' => $pointIdentifications,
        ]);
    }
}
