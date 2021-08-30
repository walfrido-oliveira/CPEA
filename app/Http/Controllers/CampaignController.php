<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
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

        return response()->json(view('project.save-icon', compact('key', 'projectCampaign'))->render());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAjax(Request $request, $id)
    {
        $input = $request->all();
        $key = $input['key'];
        $projectCampaign = Campaign::find($id);

        if($projectCampaign)
        {
            $projectCampaign->update([
                'project_point_matrix_id' => $projectCampaign->projectPointMatrix->id,
                'project_id' => $projectCampaign->project->id,
                'campaign_status_id' => $input['campaign_status_id'],
                'name' => $input['name'],
                'date_collection' => $input['date_collection'],
            ]);
        } else {
            $projectCampaign = Campaign::create([
                'project_point_matrix_id' => $projectCampaign->projectPointMatrix->id,
                'project_id' => $projectCampaign->project->id,
                'campaign_status_id' => $input['campaign_status_id'],
                'name' => $input['name'],
                'date_collection' => $input['date_collection'],
            ]);
        }

        $resp = [
            'message' => __('Campanha Atualizada com Sucesso!'),
            'alert-type' => 'success',
            'point_matrix' => view('project.saved-campaign', compact('projectCampaign', 'key'))->render()
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
        $user = Campaign::findOrFail($id);

        $user->delete();

        return response()->json([
            'message' => __('Campanha Apagada com Sucesso!'),
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
        $projectCampaigns = Campaign::filter($request->all());
        $projects = $projectCampaigns->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginate_per_page = $request->get('paginate_per_page');

        return response()->json([
        'filter_result' => view('project.campaign-result', compact('projectCampaigns', 'orderBy', 'ascending'))->render(),
        'pagination' => view('layouts.pagination', [
            'models' => $projects,
            'order_by' => $orderBy,
            'ascending' => $ascending,
            'paginate_per_page' => $paginate_per_page,
            ])->render(),
        ]);
    }
}
