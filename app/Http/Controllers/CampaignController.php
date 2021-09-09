<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ProjectPointMatrix;
use App\Http\Requests\CampaignRequest;
use Illuminate\Support\Facades\Validator;

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

            'campaign_point_matrix' => ['required', 'exists:project_point_matrices,id'],
            'tide' => ['nullable', 'in:enchente,vazante'],
            'environmental_conditions' => ['nullable', 'in:com-chuva,sem-chuva'],
            'sample_depth' => ['nullable', 'in:superficie,meio,fundo'],
            'environmental_regime' => ['nullable', 'in:lotico,lentico,intermediario'],
            'floating_materials' => ['nullable', 'in:ausente,presente'],
            'effluent_type' => ['nullable', 'in:bruto,tratado'],

            'water_depth' => ['regex:(\d+(?:,\d{1,2})?)', 'nullable'],
            'secchi_record' => ['regex:(\d+(?:,\d{1,2})?)', 'nullable'],
            'total_depth' => ['regex:(\d+(?:,\d{1,2})?)', 'nullable'],
            'pm_depth' => ['regex:(\d+(?:,\d{1,2})?)', 'nullable'],
            'pm_diameter' => ['regex:(\d+(?:,\d{1,2})?)', 'nullable'],
            'water_level' => ['regex:(\d+(?:,\d{1,2})?)', 'nullable'],
            'oil_level' => ['regex:(\d+(?:,\d{1,2})?)', 'nullable'],
            'temperature' => ['regex:(\d+(?:,\d{1,2})?)', 'nullable'],
            'humidity' => ['regex:(\d+(?:,\d{1,2})?)', 'nullable'],
            'pressure' => ['regex:(\d+(?:,\d{1,2})?)', 'nullable'],

        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }

        $key = $input['key'];
        $projectCampaign = Campaign::find($id);

        if($projectCampaign)
        {
            $projectCampaign->update([
                'project_point_matrix_id' => $input['campaign_point_matrix'],
                'project_id' => $input['project_id'],
                'campaign_status_id' => $input['campaign_status'],
                'name' => $input['campaign_name'],
                'date_collection' => $input['date_collection'],

                'refq' => isset($input['refq']) ? $input['refq'] : null,
                'tide' => isset($input['tide']) ? $input['tide'] : null,
                'environmental_conditions' => isset($input['environmental_conditions']) ? $input['environmental_conditions'] : null,
                'utm' => isset($input['utm']) ? $input['utm'] : null,
                'water_depth' => isset($input['water_depth']) ? $input['water_depth'] : null,
                'sample_depth' => isset($input['sample_depth']) ? $input['sample_depth'] : null,
                'environmental_regime' => isset($input['environmental_regime']) ? $input['environmental_regime'] : null,
                'secchi_record' => isset($input['secchi_record']) ? $input['secchi_record'] : null,
                'floating_materials' => isset($input['floating_materials']) ? $input['floating_materials'] : null,
                'total_depth' => isset($input['total_depth']) ? $input['total_depth'] : null,
                'sedimentary_layer' => isset($input['sedimentary_layer']) ? $input['sedimentary_layer'] : null,
                'report_identification' => isset($input['report_identification']) ? $input['report_identification'] : null,
                'sampling_area' => isset($input['sampling_area']) ? $input['sampling_area'] : null,
                'organism_type' => isset($input['organism_type']) ? $input['organism_type'] : null,
                'popular_name' => isset($input['popular_name']) ? $input['popular_name'] : null,
                'effluent_type' => isset($input['effluent_type']) ? $input['effluent_type'] : null,
                'identification_pm' => isset($input['identification_pm']) ? $input['identification_pm'] : null,
                'pm_depth' => isset($input['pm_depth']) ? $input['pm_depth'] : null,
                'pm_diameter' => isset($input['pm_diameter']) ? $input['pm_diameter'] : null,
                'water_level' => isset($input['water_level']) ? $input['water_level'] : null,
                'oil_level' => isset($input['oil_level']) ? $input['oil_level'] : null,
                'sample_horizon' => isset($input['sample_horizon']) ? $input['sample_horizon'] : null,
                'field_measurements' => isset($input['field_measurements']) ? $input['field_measurements'] : null,
                'temperature' => isset($input['temperature']) ? $input['temperature'] : null,
                'humidity' => isset($input['humidity']) ? $input['humidity'] : null,
                'pressure' => isset($input['pressure']) ? $input['pressure'] : null,
            ]);
        } else {
            $projectCampaign = Campaign::create([
                'project_point_matrix_id' => $input['campaign_point_matrix'],
                'project_id' => $input['project_id'],
                'campaign_status_id' => $input['campaign_status'],
                'name' => $input['campaign_name'],
                'date_collection' => $input['date_collection'],

                'refq' => isset($input['refq']) ? $input['refq'] : null,
                'tide' => isset($input['tide']) ? $input['tide'] : null,
                'environmental_conditions' => isset($input['environmental_conditions']) ? $input['environmental_conditions'] : null,
                'utm' => isset($input['utm']) ? $input['utm'] : null,
                'water_depth' => isset($input['water_depth']) ? $input['water_depth'] : null,
                'sample_depth' => isset($input['sample_depth']) ? $input['sample_depth'] : null,
                'environmental_regime' => isset($input['environmental_regime']) ? $input['environmental_regime'] : null,
                'secchi_record' => isset($input['secchi_record']) ? $input['secchi_record'] : null,
                'floating_materials' => isset($input['floating_materials']) ? $input['floating_materials'] : null,
                'total_depth' => isset($input['total_depth']) ? $input['total_depth'] : null,
                'sedimentary_layer' => isset($input['sedimentary_layer']) ? $input['sedimentary_layer'] : null,
                'report_identification' => isset($input['report_identification']) ? $input['report_identification'] : null,
                'sampling_area' => isset($input['sampling_area']) ? $input['sampling_area'] : null,
                'organism_type' => isset($input['organism_type']) ? $input['organism_type'] : null,
                'popular_name' => isset($input['popular_name']) ? $input['popular_name'] : null,
                'effluent_type' => isset($input['effluent_type']) ? $input['effluent_type'] : null,
                'identification_pm' => isset($input['identification_pm']) ? $input['identification_pm'] : null,
                'pm_depth' => isset($input['pm_depth']) ? $input['pm_depth'] : null,
                'pm_diameter' => isset($input['pm_diameter']) ? $input['pm_diameter'] : null,
                'water_level' => isset($input['water_level']) ? $input['water_level'] : null,
                'oil_level' => isset($input['oil_level']) ? $input['oil_level'] : null,
                'sample_horizon' => isset($input['sample_horizon']) ? $input['sample_horizon'] : null,
                'field_measurements' => isset($input['field_measurements']) ? $input['field_measurements'] : null,
                'temperature' => isset($input['temperature']) ? $input['temperature'] : null,
                'humidity' => isset($input['humidity']) ? $input['humidity'] : null,
                'pressure' => isset($input['pressure']) ? $input['pressure'] : null,
            ]);
        }

        $id = $projectCampaign->id;
        $className = 'edit-point-matrix';

        $orderBy = $request->has('order_by') ?  $request->get('order_by') : 'id';
        $ascending = $request->has('ascending') ? $request->get('ascending') : 'desc';
        $paginatePerPage = $request->has('paginate_per_page') ? $request->get('paginate_per_page') : 5;
        $projectCampaigns = $projectCampaign->project->campaigns() ->paginate($paginatePerPage, ['*'], 'project-campaigns');

        $resp = [
            'message' => __('Campanha Atualizada com Sucesso!'),
            'alert-type' => 'success',
            'campaign' => view('project.saved-campaign', compact('projectCampaign', 'key', 'id', 'className'))->render(),
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
     * Get Fields for specific point type
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getFields($id)
    {
        $pointIdentification = ProjectPointMatrix::findOrFail($id);

        $tides = ['enchente' => 'Enchente', 'vazante' => 'Vazante'];
        $environmentalConditions = ['com-chuva' => 'Com Chuva', 'sem-chuva' => 'Sem Chuva'];
        $sampleDepths = ['superficie' => 'Superficie', 'meio' => 'Meio', 'fundo' => 'Fundo'];
        $environmentalRegimes = ['lotico' => 'Lótico', 'lentico' => 'Lentico', 'intermediario' => 'Intermediário'];
        $floatingMaterials = ['ausente' => 'Ausente', 'presente' => 'Presente'];
        $effluentTypes = ['bruto' => 'Bruto', 'tratado' => 'Tratado'];

        if($pointIdentification->analysisMatrix)
        {
            switch ($pointIdentification->analysisMatrix->name)
            {
                case 'Água Supercial':
                    return response()->json([
                        'fields' => view('project.campaign-fields.campaign-fields-1',
                        compact('tides', 'environmentalConditions', 'sampleDepths', 'environmentalRegimes', 'floatingMaterials'))->render()
                    ]);
                    break;

                case 'Sedimento':
                    return response()->json([
                        'fields' => view('project.campaign-fields.campaign-fields-2', compact('environmentalConditions', 'environmentalRegimes'))->render()
                    ]);
                    break;

                case 'Organismos':
                    return response()->json([
                        'fields' => view('project.campaign-fields.campaign-fields-3')->render()
                    ]);
                    break;

                case ['Efluente', 'Água Residuária']:
                    return response()->json([
                        'fields' => view('project.campaign-fields.campaign-fields-4', compact('environmentalConditions', 'effluentTypes'))->render()
                    ]);
                    break;

                case 'Água Subterrânea':
                    return response()->json([
                        'fields' => view('project.campaign-fields.campaign-fields-5', compact('environmentalConditions'))->render()
                    ]);
                    break;

                case 'Solo':
                    return response()->json([
                        'fields' => view('project.campaign-fields.campaign-fields-6', compact('environmentalConditions'))->render()
                    ]);
                    break;

                case 'Solo':
                    return response()->json([
                        'fields' => view('project.campaign-fields.campaign-fields-7')->render()
                    ]);
                    break;
                default:
                    return response()->json([
                        'fields' => view('project.campaign-fields.campaign-fields-7')->render()
                    ]);
                    break;
            }
        }

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
}
