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
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

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
        $projetcs =  Campaign::filter($request->all());

        $customers = Customer::all()->pluck('name', 'id');
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'projects.project_cod';

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

        if(isset($input['duplicated_id']))
        {
            foreach ($input['campaign'] as $key => $campaign)
            {
                $projectCampaign = Campaign::create([
                    'project_id' => $project->id,
                    'campaign_status_id' => $campaign['campaign_status'],
                    'name' => $campaign['campaign_name'],
                    'date_collection' => $campaign['date_collection'],

                    'refq' => isset($campaign['refq']) ? $campaign['refq'] : null,
                    'tide' => isset($campaign['tide']) ? $campaign['tide'] : null,
                    'environmental_conditions' => isset($campaign['environmental_conditions']) ? $campaign['environmental_conditions'] : null,
                    'utm' => isset($campaign['utm']) ? $campaign['utm'] : null,
                    'water_depth' => isset($campaign['water_depth']) ? $campaign['water_depth'] : null,
                    'sample_depth' => isset($campaign['sample_depth']) ? $campaign['sample_depth'] : null,
                    'environmental_regime' => isset($campaign['environmental_regime']) ? $campaign['environmental_regime'] : null,
                    'secchi_record' => isset($campaign['secchi_record']) ? $campaign['secchi_record'] : null,
                    'floating_materials' => isset($campaign['floating_materials']) ? $campaign['floating_materials'] : null,
                    'total_depth' => isset($campaign['total_depth']) ? $campaign['total_depth'] : null,
                    'sedimentary_layer' => isset($campaign['sedimentary_layer']) ? $campaign['sedimentary_layer'] : null,
                    'report_identification' => isset($campaign['report_identification']) ? $campaign['report_identification'] : null,
                    'sampling_area' => isset($campaign['sampling_area']) ? $campaign['sampling_area'] : null,
                    'organism_type' => isset($campaign['organism_type']) ? $campaign['organism_type'] : null,
                    'popular_name' => isset($campaign['popular_name']) ? $campaign['popular_name'] : null,
                    'effluent_type' => isset($campaign['effluent_type']) ? $campaign['effluent_type'] : null,
                    'identification_pm' => isset($campaign['identification_pm']) ? $campaign['identification_pm'] : null,
                    'pm_depth' => isset($campaign['pm_depth']) ? $campaign['pm_depth'] : null,
                    'pm_diameter' => isset($campaign['pm_diameter']) ? $campaign['pm_diameter'] : null,
                    'water_level' => isset($campaign['water_level']) ? $campaign['water_level'] : null,
                    'oil_level' => isset($campaign['oil_level']) ? $campaign['oil_level'] : null,
                    'sample_horizon' => isset($campaign['sample_horizon']) ? $campaign['sample_horizon'] : null,
                    'field_measurements' => isset($campaign['field_measurements']) ? $campaign['field_measurements'] : null,
                    'temperature' => isset($campaign['temperature']) ? $campaign['temperature'] : null,
                    'humidity' => isset($campaign['humidity']) ? $campaign['humidity'] : null,
                    'pressure' => isset($campaign['pressure']) ? $campaign['pressure'] : null,

                ]);

                foreach ($input['point_matrix'] as $key => $point)
                {
                    if($point['campaign_id'] == $campaign['id'])
                    {
                        $input['point_matrix'][$key]['campaign_id'] = $projectCampaign->id;
                    }
                }
            }

            foreach ($input['point_matrix'] as $key => $point)
            {
                $validator = Validator::make($point, [
                    'point_identification_id' => ['required', 'exists:point_identifications,id'],
                ]);

                if ($validator->fails()) {
                    return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
                }

                $projectPointMatrix = ProjectPointMatrix::create([
                    'project_id' => $project->id,
                    'campaign_id' => $point['campaign_id'],
                    'point_identification_id' => $point['point_identification_id'],
                    'analysis_matrix_id' => $point['analysis_matrix_id'],
                    'plan_action_level_id' => $point['plan_action_level_id'],
                    'guiding_parameter_id' => $point['guiding_parameter_id'],
                    'parameter_analysis_id' => $point['parameter_analysis_id']
                ]);
            }
        }

        $resp = [
            'message' => __('Projeto' . (isset($input['duplicated_id']) ? ' Duplicado ' : ' Cadastrado ') . 'com Sucesso!'),
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
        $campaigns = $project->campaigns()->pluck("name", "id");

        $projectPointMatrices = $project->projectPointMatrices()
        ->orderBy("campaign_id", "asc")
        ->paginate(DEFAULT_PAGINATE_PER_PAGE, ['*'], 'project-point-matrices')->appends(request()->input());

        $projectCampaigns = $project->campaigns()
        ->orderBy("name", "asc")
        ->paginate(DEFAULT_PAGINATE_PER_PAGE, ['*'], 'campaigns')->appends(request()->input());

        return view('project.edit', compact('project','customers', 'areas', 'identifications', 'campaignStatuses', 'projectCampaigns',
        'matrizeces', 'planActionLevels', 'guidingParameters', 'parameterAnalyses', 'projectPointMatrices', 'geodeticSystems',
        'pointMatrices', 'campaigns'));
    }

    /**
     * Show the form for duplicating the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function duplicate($id)
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
        $campaigns = $project->campaigns()->pluck("name", "id");

        $projectPointMatrices = $project->projectPointMatrices()
        ->orderBy("campaign_id", "asc")
        ->paginate(DEFAULT_PAGINATE_PER_PAGE, ['*'], 'project-point-matrices')->appends(request()->input());

        $projectCampaigns = $project->campaigns()
        ->orderBy("name", "asc")
        ->paginate(DEFAULT_PAGINATE_PER_PAGE, ['*'], 'campaigns')->appends(request()->input());

        return view('project.duplicate', compact('project','customers', 'areas', 'identifications', 'campaignStatuses', 'projectCampaigns',
        'matrizeces', 'planActionLevels', 'guidingParameters', 'parameterAnalyses', 'projectPointMatrices', 'geodeticSystems',
        'pointMatrices', 'campaigns'));
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
        $projetcs  = Campaign::filter($request->all());
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

    /**
     * Change project status
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request, $id)
    {
        $validated = $request->validate([
            'id' => 'required|exists:projects,id',
            'status' => 'required|in:sent,pending,analyzing,concluded',
        ]);

        $project= Project::findOrFail($request->get('id'));

        $project->update([
            'status' => $request->get('status')
        ]);

        return response()->json([
            'message' => __('Projeto Atualizado com Sucesso!'),
            'alert-type' => 'success',
            'result' => view('sample-analysis.status-project', ['status' => $project->status])->render()
        ]);

    }
}
