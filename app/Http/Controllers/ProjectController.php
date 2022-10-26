<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Campaign;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\AnalysisMatrix;
use App\Models\CampaignStatus;
use App\Models\GeodeticSystem;
use App\Models\ParameterMethod;
use App\Models\GuidingParameter;
use App\Models\ParameterAnalysis;
use App\Models\ProjectPointMatrix;
use App\Models\PointIdentification;
use App\Http\Requests\ProjectRequest;
use Illuminate\Support\Facades\Cache;
use App\Models\ParameterAnalysisGroup;

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
        $customers = Customer::where('status', 'active')->orderBy("name")->pluck('name', 'id');
        $type = 'create';

        return view('project.create', compact('customers', 'type'));
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

            foreach ($input['campaigns'] as $key => $campaign)
            {
                $createdCampaign = Campaign::create([
                    'name' => $campaign['name'],
                    'project_id' => $project->id,
                    'campaign_status_id' => 1,
                ]);

                $clonedCampaign = Campaign::findOrFail($campaign['id']);
                $pointsIds = [];

                if(isset($campaign['points'])) {
                    foreach ($campaign['points'] as $key => $point) {
                        $pointsIds[] = $point['id'];
                    }
                }

                foreach ($clonedCampaign->projectPointMatrices()->whereIn("point_identification_id", $pointsIds)->get() as $key => $point)
                {
                    $projectPointMatrix = ProjectPointMatrix::create([
                        'project_id' => $project->id,
                        'campaign_id' => $createdCampaign->id,
                        'point_identification_id' => $point->point_identification_id,
                        'analysis_matrix_id' => $point->analysis_matrix_id,
                        'parameter_analysis_id' => $point->parameter_analysis_id,
                        'parameter_method_preparation_id' => $point->parameter_method_preparation_id,
                        'parameter_method_analysis_id' => $point->parameter_method_analysis_id,
                        'date_collection' => $campaign['points'][$point->point_identification_id]['date_collection'] ? $campaign['points'][$point->point_identification_id]['date_collection'] : $point->date_collection,

                        'refq' => $point->refq,
                        'tide' => $point->tide,
                        'environmental_conditions' => $point->environmental_conditions,
                        'utm' => $point->utm,
                        'water_depth' => $point->water_depth,
                        'sample_depth' => $point->sample_depth,
                        'environmental_regime' => $point->environmental_regime,
                        'secchi_record' => $point->secchi_record,
                        'floating_materials' => $point->floating_materials,
                        'total_depth' => $point->total_depth,
                        'sedimentary_layer' => $point->sedimentary_layer,
                        'report_identification' => $point->report_identification,
                        'sampling_area' => $point->sampling_area,
                        'organism_type' => $point->organism_type,
                        'popular_name' => $point->popular_name,
                        'effluent_type' => $point->effluent_type,
                        'identification_pm' => $point->identification_pm,
                        'pm_depth' => $point->pm_depth,
                        'pm_diameter' => $point->pm_diameter,
                        'water_level' => $point->water_level,
                        'oil_level' => $point->oil_level,
                        'sample_horizon' => $point->sample_horizon,
                        'field_measurements' => $point->field_measurements,
                        'temperature' => $point->temperature,
                        'humidity' => $point->humidity,
                        'pressure' => $point->pressure,
                    ]);

                    $projectPointMatrix->guidingParameters()->sync($point->guidingParameters()->pluck("guiding_parameter_id")->toArray());
                }
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
     * @param  ProjectRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $customers = Customer::where('status', 'active')->orderBy("name")->pluck('name', 'id');
        $areas = PointIdentification::distinct()->pluck('area', 'area');
        $identifications = PointIdentification::pluck('identification', 'identification');
        $matrizeces = AnalysisMatrix::pluck('name', 'id');
        $guidingParameters = GuidingParameter::orderBy("environmental_guiding_parameter_id", 'asc')->pluck('environmental_guiding_parameter_id', 'id');
        $parameterAnalyses = ParameterAnalysis::all()->pluck('with_group_name', 'id');
        $geodeticSystems = GeodeticSystem::pluck("name", "id");
        $preparationMethods = ParameterMethod::where('type', 'preparation')->get()->pluck('name', 'id');
        $analysisMethods = ParameterMethod::where('type', 'analysis')->get()->pluck('name', 'id');
        $campaigns = $project->campaigns()->pluck("name", "id");
        $parameterAnalyseGroups = ParameterAnalysisGroup::all()->pluck('name', 'id');
        $campaignStatuses = CampaignStatus::pluck("name", "id");
        $pointMatrices = $project->getPointMatricesCustomFields();

        $projectPointMatrices = $project->projectPointMatrices()
        ->orderBy(isset(request()->input()['order_by']) ? request()->input()['order_by'] : "created_at",
        isset(request()->input()['ascending']) ? request()->input()['ascending'] : "desc")
        ->paginate(isset(request()->input()['paginate_per_page']) ? request()->input()['paginate_per_page'] : DEFAULT_PAGINATE_PER_PAGE, ['*'], 'project-point-matrices')->appends(request()->input());

        $projectCampaigns = $project->campaigns()
        ->orderBy(isset(request()->input()['order_by']) ? request()->input()['order_by'] : "name",
        isset(request()->input()['ascending']) ? request()->input()['ascending'] : "asc")
        ->paginate(isset(request()->input()['paginate_per_page']) ? request()->input()['paginate_per_page'] : DEFAULT_PAGINATE_PER_PAGE, ['*'], 'campaigns')->appends(request()->input());

        return view('project.edit',
                    compact('project','customers', 'areas', 'identifications', 'campaignStatuses', 'projectCampaigns',
                    'matrizeces', 'guidingParameters', 'parameterAnalyses', 'projectPointMatrices', 'geodeticSystems',
                    'pointMatrices', 'campaigns', 'parameterAnalyseGroups', 'preparationMethods', 'analysisMethods'));

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
        $customers = Customer::all()->sortBy("name")->pluck('name', 'id');

        $type = 'duplicate';

        return view('project.create', compact('customers', 'type', 'project'));
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

        if(!$project->guiding_parameter_order)
        {
            $project->guiding_parameter_order = implode(",", $project->projectPointMatrices()
            ->select('guiding_parameters.*')
            ->whereHas('guidingParameters')
            ->leftJoin('guiding_parameter_project_point_matrix', function($join) {
                $join->on('project_point_matrices.id', '=', 'guiding_parameter_project_point_matrix.project_point_matrix_id');
            })
            ->leftJoin('guiding_parameters', function($join) {
                $join->on('guiding_parameters.id', '=', 'guiding_parameter_project_point_matrix.guiding_parameter_id');
            })
            ->orderBy('guiding_parameters.id')
            ->distinct()
            ->pluck('guiding_parameters.id')->toArray());
            $project->save();
        }

        $resp = [
            'message' => __('Projeto Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('project.index')->with($resp);
    }

    /**
     * Update order
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateOrder(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $input = $request->all();

        $project->update([
            'guiding_parameter_order' => isset($input['order']) ? $input['order'] : null
        ]);

        return response()->json([
            'message' => __('Projeto Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Update order
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOrder(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $guidingParameters = $project->projectPointMatrices()
        ->select('guiding_parameters.*')
        ->whereHas('guidingParameters')
        ->leftJoin('guiding_parameter_project_point_matrix', function($join) {
            $join->on('project_point_matrices.id', '=', 'guiding_parameter_project_point_matrix.project_point_matrix_id');
        })
        ->leftJoin('guiding_parameters', function($join) {
            $join->on('guiding_parameters.id', '=', 'guiding_parameter_project_point_matrix.guiding_parameter_id');
        })
        ->orderBy('guiding_parameters.id')
        ->distinct()
        ->get();

        return response()->json([
            'guiding_parameters' => view('project.guiding-parameter-list', compact('guidingParameters'))->render(),
        ]);
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
