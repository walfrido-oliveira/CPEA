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
        ->paginate(DEFAULT_PAGINATE_PER_PAGE, ['*'], 'point_matrix');

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

        $resp = [
            'campaigns' => $project->campaigns
        ];

        return response()->json($resp);
    }
}
