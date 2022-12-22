<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\AnalysisMatrix;
use App\Models\GeodeticSystem;
use App\Models\ParameterMethod;
use App\Models\PlanActionLevel;
use App\Models\GuidingParameter;
use App\Models\ParameterAnalysis;
use App\Models\ProjectPointMatrix;
use App\Models\PointIdentification;
use Illuminate\Support\Facades\Validator;

class CampaignController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $campaign = Campaign::findOrFail($id);

        $campaign = Campaign::findOrFail($id);
        $ids = $campaign->projectPointMatrices()->select('point_identification_id')->groupBy('point_identification_id')->pluck('point_identification_id')->toArray();
        $areasRef =  PointIdentification::whereIn('id', $ids)->pluck('area', 'area');
        $areas =  PointIdentification::pluck('area', 'area');
        //$identifications =  PointIdentification::whereIn('id', $ids)->pluck('identification', 'identification');
        $matrizeces = AnalysisMatrix::pluck('name', 'id');

        $planActionLevels = []; //PlanActionLevel::pluck('name', 'id');
        $guidingParameters = []; //GuidingParameter::pluck('environmental_guiding_parameter_id', 'id');
        $parameterAnalyses = []; //ParameterAnalysis::pluck('analysis_parameter_name', 'id');
        $geodeticSystems = [];//GeodeticSystem::pluck("name", "id");
        $preparationMethods = []; //ParameterMethod::where('type', 'preparation')->get()->pluck('name', 'id');
        $analysisMethods = []; //ParameterMethod::where('type', 'analysis')->get()->pluck('name', 'id');

        $perPage = $request->has('paginate_per_page') ? $request->get('paginate_per_page') : DEFAULT_PAGINATE_PER_PAGE;

        $isNBR = false;
        $guidingParametersNBR = GuidingParameter::where("name", "NBR 10.004 - Massa Bruta")
                                                ->orWhere("name", "NBR 10.004 Anexo F - Extrato Lixiviado")
                                                ->orWhere("name", "NBR 10.004 Anexo G - Extrato Solubilizado")->pluck("id")->toArray();

        if(is_array($campaign->project->guiding_parameter_order)) {
            foreach ($campaign->project->guiding_parameter_order as $key => $value) {
                $isNBR = in_array($value, $guidingParametersNBR);
                if(!$isNBR) break;
            }
        }

        $projectPointMatrices = $campaign->projectPointMatrices()
        ->orderBy("campaign_id", "asc")
        ->paginate($perPage, ['*']);

        return view('project.campaign.show',
        compact('campaign', 'areas', 'matrizeces', 'planActionLevels',
                'guidingParameters', 'parameterAnalyses', 'geodeticSystems',
                'projectPointMatrices', 'preparationMethods', 'analysisMethods', 'isNBR', 'areasRef'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editAjax(Request $request, $id)
    {
        $projectCampaign = Campaign::findOrFail($id);
        $key = $request->get('key');
        $className = 'save-campaign';
        $id = $projectCampaign->id;

        return response()->json(view('project.save-campaign-icon',
        compact('key', 'projectCampaign', 'className', 'id'))
        ->render());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel(Request $request, $id)
    {
        $input = $request->all();

        $projectCampaign = Campaign::find($id);
        $id = $projectCampaign->id;
        $className = 'edit-campaign';
        $key = $input['key'];
        $actions = 'show';

        $resp = [
            'campaign' => view('project.saved-campaign', compact('projectCampaign', 'key', 'id', 'className', 'actions'))->render(),
        ];

        return response()->json($resp);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAjax(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'campaign_name' => ['required', 'string', 'max:255'],
            'campaign_status' => ['required', 'exists:campaign_statuses,id'],
        ]);

        if ($validator->fails())
        {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }

        $key = $input['key'];
        $projectCampaign = Campaign::find($id);


        if($projectCampaign)
        {
            $projectCampaign->fill([
                'project_id' => $input['project_id'],
                'campaign_status_id' => $input['campaign_status'],
                'name' => $input['campaign_name'],
            ]);
            $projectCampaign->save();
        } else {

            if(Campaign::where('project_id', $input['project_id'])->where('name', $input['campaign_name'])->first())
            {
                return response()->json([
                    "campaign_name" => _("Não é permitido cadastrar Campanha de mesmo nome")
                ], Response::HTTP_BAD_REQUEST);
            }

            $projectCampaign = Campaign::create([
                'project_id' => $input['project_id'],
                'campaign_status_id' => $input['campaign_status'],
                'name' => $input['campaign_name'],
            ]);
        }

        $id = $projectCampaign->id;
        $className = 'edit-campaign';
        $actions = 'show';
        $orderBy = $request->has('order_by') ?  $request->get('order_by') : 'id';
        $ascending = $request->has('ascending') ? $request->get('ascending') : 'desc';
        $paginatePerPage = $request->has('paginate_per_page') ? $request->get('paginate_per_page') : 5;
        $projectCampaigns = $projectCampaign->project->campaigns() ->paginate($paginatePerPage, ['*'], 'campaigns');

        $resp = [
            'message' => __('Campanha Atualizada com Sucesso!'),
            'alert-type' => 'success',
            'campaign' => view('project.saved-campaign', compact('projectCampaign', 'key', 'id', 'className', 'actions'))->render(),
            'campaigns' => $projectCampaign->project->campaigns,
            'pagination' => $this->setPagination($projectCampaigns, $orderBy, $ascending, $paginatePerPage),
        ];

        return response()->json($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaigns = $campaign->project->campaigns;
        $campaign->delete();

        return response()->json([
            'message' => __('Campanha Apagada com Sucesso!'),
            'alert-type' => 'success',
            'campaigns' => $campaigns,
        ]);
    }

    /**
     * Filter
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $projectCampaigns = Campaign::filter($request->all());
        $projectCampaigns = $projectCampaigns->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');
        $actions = $request->has('actions') ? $request->get('actions') : 'show';

        return response()->json([
            'filter_result' => view('project.campaign-result', compact('projectCampaigns', 'orderBy', 'ascending', 'actions'))->render(),
            'pagination' => $this->setPagination($projectCampaigns, $orderBy, $ascending, $paginatePerPage),
        ]);
    }

    /**
     * @param Collection $projectCampaigns
     * @param string $orderBy
     * @param string $ascending
     * @param string $paginatePerPage
     *
     * @return view
     */
    private function setPagination($projectCampaigns, $orderBy, $ascending, $paginatePerPage)
    {
        return view('layouts.pagination', [
            'models' => $projectCampaigns,
            'order_by' => $orderBy,
            'ascending' => $ascending,
            'paginate_per_page' => $paginatePerPage,
            ])->render();
    }

    /**
     * Get campaign by project
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCampaignByProject(Request $request, $id)
    {
        $project = Project::find($id);
        $campaigns = $project->campaigns()->pluck("name", "id");
        $resp = [
            'campaigns' => $campaigns
        ];

        return response()->json($resp);
    }

    /**
     * Duplicate campaign
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function duplicate(Request $request, $id)
    {
        $campaign = Campaign::findOrFail($id);

        $input = $request->all();

        if(!isset($input['type'])) $input['type'] = 'campaign';

        switch ($input['type']) {
            case 'campaign':
                $result = $this->duplicateCampaign($input, $campaign);
                break;
            case 'point':
                $result = $campaign;
                $this->duplicatePoint($input, $campaign, $input['point_identifications_ref']);
                break;
            default:
                $result = $this->duplicateCampaign($input, $campaign);
                break;
        }

        $resp = [
            'message' => __('Campanha duplicada com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('project.campaign.show', ['campaign' => $result->id])->with($resp);
    }

    /**
     * Duplicate point in DB
     *
     * @param Array $input
     * @param Campaign $campaign
     * @param PointIdentification $point
     * @return Campaign
     */
    private function duplicatePoint($input, $campaign, $point)
    {
        $projectPointMatrices = $campaign->projectPointMatrices()->where('point_identification_id', $point)->get();

        foreach ($projectPointMatrices as $point)
        {
            foreach ($input['inputs'] as $value2)
            {
                $result = $campaign->projectPointMatrices()
                ->where('point_identification_id', $value2['point_identifications'])
                ->where('parameter_analysis_id', $point->parameter_analysis_id)
                ->where('analysis_matrix_id', $point->analysis_matrix_id)
                ->get();

                if($result->count() > 0) continue;

                $projectPointMatrix = ProjectPointMatrix::create([
                    'project_id' => $point->project_id,
                    'point_identification_id' => $value2['point_identifications'],
                    'analysis_matrix_id' => isset($value2['matriz_id']) ? $value2['matriz_id'] :  $point->analysis_matrix_id,
                    'parameter_analysis_id' => $point->parameter_analysis_id,
                    'campaign_id' => $campaign->id,
                    'parameter_method_preparation_id' => $point->parameter_method_preparation_id,
                    'parameter_method_analysis_id' => $point->parameter_method_analysis_id,

                    'date_collection' => $value2['date_collection'],

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

                if(isset($value2['guiding_parameters_id']))
                {
                    $projectPointMatrix->guidingParameters()->sync(array_filter($value2['guiding_parameters_id']));
                }
                else
                {
                    $projectPointMatrix->guidingParameters()->sync($point->guidingParameters()->pluck("guiding_parameter_id")->toArray());
                }
            }
        }
    }

    /**
     * Duplicate campaingn in DB
     *
     * @param Array $input
     * @param Campaign $campaign
     * @return Campaign
     */
    private function duplicateCampaign($input, $campaign)
    {
        $result = Campaign::create([
            'name' => $input['name'],
            'project_id' => $campaign->project_id,
            'campaign_status_id' => $campaign->campaign_status_id,
        ]);

        $pointsIds = [];

        if(isset($input['points'])) {
            foreach ($input['points'] as $point) {
                $pointsIds[] = $point['id'];
            }
        }

        foreach ($campaign->projectPointMatrices()->whereIn("point_identification_id", $pointsIds)->get() as $key => $point)
        {
            $projectPointMatrix = ProjectPointMatrix::create([
                'project_id' => $point->project_id,
                'point_identification_id' => $point->point_identification_id,
                'analysis_matrix_id' => $point->analysis_matrix_id,
                'parameter_analysis_id' => $point->parameter_analysis_id,
                'parameter_method_preparation_id' => $point->parameter_method_preparation_id,
                'parameter_method_analysis_id' => $point->parameter_method_analysis_id,
                'campaign_id' => $result->id,

                'date_collection' => $input['points'][$point->point_identification_id]['date_collection'] ? $input['points'][$point->point_identification_id]['date_collection'] : $point->date_collection,

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

        return $result;
    }
}
