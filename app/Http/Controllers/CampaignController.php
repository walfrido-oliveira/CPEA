<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\AnalysisMatrix;
use App\Models\GeodeticSystem;
use App\Models\PlanActionLevel;
use App\Models\GuidingParameter;
use App\Models\ParameterAnalysis;
use App\Models\ProjectPointMatrix;
use App\Models\PointIdentification;
use App\Http\Requests\CampaignRequest;
use Illuminate\Support\Facades\Validator;

class CampaignController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $campaign = Campaign::findOrFail($id);

        $areas = PointIdentification::pluck('area', 'area');
        $identifications = PointIdentification::pluck('identification', 'identification');
        $matrizeces = AnalysisMatrix::pluck('name', 'id');
        $planActionLevels = PlanActionLevel::pluck('name', 'id');
        $guidingParameters = GuidingParameter::pluck('environmental_guiding_parameter_id', 'id');
        $parameterAnalyses = ParameterAnalysis::pluck('analysis_parameter_name', 'id');
        $geodeticSystems = GeodeticSystem::pluck("name", "id");

        $projectPointMatrices = $campaign->projectPointMatrices()
        ->orderBy("campaign_id", "asc")
        ->paginate(DEFAULT_PAGINATE_PER_PAGE, ['*'], 'project-point-matrices');

        return view('project.campaign.show', compact('campaign', 'areas', 'identifications', 'matrizeces', 'planActionLevels',
                                                     'guidingParameters', 'parameterAnalyses', 'geodeticSystems', 'projectPointMatrices'));
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

        return response()->json(view('project.save-icon',
        compact('key', 'projectCampaign', 'className', 'id'))
        ->render());
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
            'date_collection' => ['required', 'date'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }

        $key = $input['key'];
        $projectCampaign = Campaign::find($id);

        if($projectCampaign)
        {
            $projectCampaign->update([
                'project_id' => $input['project_id'],
                'campaign_status_id' => $input['campaign_status'],
                'name' => $input['campaign_name'],
                'date_collection' => $input['date_collection'],
            ]);
        } else {
            $projectCampaign = Campaign::create([
                'project_id' => $input['project_id'],
                'campaign_status_id' => $input['campaign_status'],
                'name' => $input['campaign_name'],
                'date_collection' => $input['date_collection'],
            ]);
        }

        $id = $projectCampaign->id;
        $className = 'edit-point-matrix';
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

        $campaign->delete();

        return response()->json([
            'message' => __('Campanha Apagada com Sucesso!'),
            'alert-type' => 'success'
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
            'campaigns' => view('project.campaign-select', compact('campaigns'))->render()
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
                $this->duplicatePoint($input, $campaign);
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
     * @return Campaign
     */
    private function duplicatePoint($input, $campaign)
    {
        foreach ($campaign->projectPointMatrices as $key => $point)
        {
            ProjectPointMatrix::create([
                'project_id' => $point->project_id,
                'point_identification_id' => isset($input['point_identifications']) ? $input['point_identifications'] : $point->point_identification_id,
                'analysis_matrix_id' => $point->analysis_matrix_id,
                'parameter_analysis_id' => $point->parameter_analysis_id,
                'campaign_id' => $campaign->id,

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
            'date_collection' => $campaign->date_collection,
        ]);

        foreach ($campaign->projectPointMatrices as $key => $point)
        {
            ProjectPointMatrix::create([
                'project_id' => $point->project_id,
                'point_identification_id' => $point->point_identification_id,
                'analysis_matrix_id' => $point->analysis_matrix_id,
                'parameter_analysis_id' => $point->parameter_analysis_id,
                'campaign_id' => $result->id,

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
        }

        return $result;
    }
}
