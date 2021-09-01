<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Campaign;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\AnalysisMatrix;
use App\Models\CampaignStatus;
use App\Models\GeodeticSystem;
use App\Models\PlanActionLevel;
use App\Models\GuidingParameter;
use App\Models\ParameterAnalysis;
use App\Models\ProjectPointMatrix;
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
        $projetcs =  Project::filter($request->all());

        $customers = Customer::all()->pluck('name', 'id');
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'id';

        return view('project.index', compact('projetcs', 'customers', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all()->pluck('name', 'id');

        return view('project.create', compact('customers'));
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

        $project =  Project::create([
            'project_cod' => $input['project_cod'],
            'customer_id' => $input['customer_id'],
        ]);

        $resp = [
            'message' => __('Projeto Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('project.edit', ['project' => $project->id])->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::findOrFail($id);

        return view('project.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $customers = Customer::all()->pluck('name', 'id');
        $areas = PointIdentification::pluck('area', 'area');
        $identifications = PointIdentification::pluck('identification', 'identification');
        $matrizeces = AnalysisMatrix::pluck('name', 'id');
        $planActionLevels = PlanActionLevel::pluck('name', 'id');
        $guidingParameters = GuidingParameter::pluck('environmental_guiding_parameter_id', 'id');
        $parameterAnalyses = ParameterAnalysis::pluck('analysis_parameter_name', 'id');
        $geodeticSystems = GeodeticSystem::pluck("name", "id");
        $campaignStatuses = CampaignStatus::pluck("name", "id");
        $pointMatrices = $project->getPointMatricesCustomFields();

        $projectPointMatrices = $project->projectPointMatrices()->paginate(10, ['*'], 'project-point-matrices')->appends(request()->input());
        $projectCampaigns = $project->campaigns()->paginate(10, ['*'], 'project-campaigns')->appends(request()->input());

        return view('project.edit', compact('project','customers', 'areas', 'identifications', 'campaignStatuses', 'projectCampaigns',
        'matrizeces', 'planActionLevels', 'guidingParameters', 'parameterAnalyses', 'projectPointMatrices', 'geodeticSystems',
        'pointMatrices'));
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
        $input = $request->all();

        $project = Project::findOrFail($id);

        $project->update([
            'project_cod' => $input['project_cod'],
            'customer_id' => $input['customer_id'],
        ]);

        $resp = [
            'message' => __('Projeto Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('project.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Project::findOrFail($id);

        $user->delete();

        return response()->json([
            'message' => __('Projeto Apagado com Sucesso!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter Project
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $projetcs  = Project::filter($request->all());
        $projetcs  = $projetcs->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginate_per_page = $request->get('paginate_per_page');
        $actions = $request->has('actions') ? $request->get('actions') : 'show';

        return response()->json([
        'filter_result' => view('project.filter-result', compact('projetcs', 'orderBy', 'ascending', 'actions'))->render(),
        'pagination' => view('layouts.pagination', [
            'models' => $projetcs ,
            'order_by' => $orderBy,
            'ascending' => $ascending,
            'paginate_per_page' => $paginate_per_page,
            ])->render(),
        ]);
    }
}
