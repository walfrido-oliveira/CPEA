<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\AnalysisMatrix;
use App\Models\PlanActionLevel;
use App\Models\GuidingParameter;
use App\Models\ParameterAnalysis;
use App\Models\PointIdentification;
use App\Http\Requests\ProjectRequest;

class ProjectController extends Controller
{
    /**
     * Display a listing of the project.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projects =  Project::filter($request->all());
        $customers = Customer::all()->pluck('name', 'id');
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'id';

        return view('project.index', compact('projects', 'customers', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all()->pluck('name', 'id');
        $areas = PointIdentification::pluck('area', 'area');
        $identifications = PointIdentification::pluck('identification', 'identification');
        $matrizeces = AnalysisMatrix::pluck('name', 'id');
        $planActionLevels = PlanActionLevel::pluck('name', 'id');
        $guidingParameters = GuidingParameter::pluck('environmental_guiding_parameter_id', 'id');
        $parameterAnalyses = ParameterAnalysis::pluck('analysis_parameter_name', 'id');

        return view('project.create', compact('customers', 'areas', 'identifications',
        'matrizeces', 'planActionLevels', 'guidingParameters', 'parameterAnalyses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProjectRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $input = $request->all();

        dd($input);

        $project =  PointIdentification::create([
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
}
