<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\AnalysisMatrix;
use App\Models\ProjectPointMatrix;
use Illuminate\Support\Facades\Validator;

class ProjectPointMatrixController extends Controller
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
        $projectPointMatrix = ProjectPointMatrix::findOrFail($id);
        $key = $request->get('key');
        $className = 'save-point-matrix';
        $id = $projectPointMatrix->id;

        return response()->json(view('project.save-icon',
        compact('key', 'projectPointMatrix', 'className', 'id'))
        ->render());
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

        $validator = Validator::make($request->all(), [
            'point_identification_id' => ['required', 'exists:point_identifications,id'],

            'campaign_id' => ['required', 'exists:campaigns,id'],
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
        $projectPointMatrix = ProjectPointMatrix::find($id);

        if($projectPointMatrix)
        {
            $projectPointMatrix->update([
                'project_id' => $projectPointMatrix->project_id,
                'point_identification_id' => $input['point_identification_id'],
                'analysis_matrix_id' => $input['analysis_matrix_id'],
                'plan_action_level_id' => $input['plan_action_level_id'],
                'guiding_parameter_id' => $input['guiding_parameter_id'],
                'parameter_analysis_id' => $input['parameter_analysis_id'],
                'campaign_id' => $input['campaign_id'],

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
            $projectPointMatrix = ProjectPointMatrix::create([
                'project_id' => $input['project_id'],
                'point_identification_id' => $input['point_identification_id'],
                'analysis_matrix_id' => $input['analysis_matrix_id'],
                'plan_action_level_id' => $input['plan_action_level_id'],
                'guiding_parameter_id' => $input['guiding_parameter_id'],
                'parameter_analysis_id' => $input['parameter_analysis_id'],
                'campaign_id' => $input['campaign_id'],

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

        $id = $projectPointMatrix->id;
        $className = 'edit-point-matrix';

        $orderBy = $request->has('order_by') ?  $request->get('order_by') : 'id';
        $ascending = $request->has('ascending') ? $request->get('ascending') : 'desc';
        $paginatePerPage = $request->has('paginate_per_page') ? $request->get('paginate_per_page') : 5;
        $projectPointMatrices = $projectPointMatrix->project->projectPointMatrices() ->paginate($paginatePerPage, ['*'], 'project-point-matrices');

        $resp = [
            'message' => __('Ponto/Matriz Atualizado com Sucesso!'),
            'alert-type' => 'success',
            'point_matrix' => view('project.saved-point-matrix', compact('projectPointMatrix', 'key', 'id', 'className'))->render(),
            'pagination' => $this->setPagination($projectPointMatrices, $orderBy, $ascending, $paginatePerPage),
        ];

        return response()->json($resp);
    }

    /**
     * Get Point Matrices By Project
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPointMatricesByProject(Request $request, $id)
    {
        $project = Project::find($id);

        $resp = [
            'point_matrices' => $project->projectPointMatrices
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
        $projectPointMatrix = ProjectPointMatrix::findOrFail($id);

        $projectPointMatrix->delete();

        return response()->json([
            'message' => __('Ponto/Matriz Apagado com Sucesso!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request, $id)
    {
        $projectPointMatrices = ProjectPointMatrix::filter($request->all(), $id);
        $projectPointMatrices = $projectPointMatrices->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('project.point-matrix-result', compact('projectPointMatrices', 'orderBy', 'ascending'))->render(),
            'pagination' => $this->setPagination($projectPointMatrices, $orderBy, $ascending, $paginatePerPage),
        ]);
    }

    /**
     * @param Collection $projectPointMatrices
     * @param string $orderBy
     * @param string $ascending
     * @param string $paginatePerPage
     *
     * @return view
     */
    private function setPagination($projectPointMatrices, $orderBy, $ascending, $paginatePerPage)
    {
        return view('layouts.pagination', [
            'models' => $projectPointMatrices,
            'order_by' => $orderBy,
            'ascending' => $ascending,
            'paginate_per_page' => $paginatePerPage,
            ])->render();
    }

        /**
     * Get Fields for specific point type
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getFields($id)
    {
        $analysisMatrix = AnalysisMatrix::findOrFail($id);

        $tides = ['enchente' => 'Enchente', 'vazante' => 'Vazante'];
        $environmentalConditions = ['com-chuva' => 'Com Chuva', 'sem-chuva' => 'Sem Chuva'];
        $sampleDepths = ['superficie' => 'Superficie', 'meio' => 'Meio', 'fundo' => 'Fundo'];
        $environmentalRegimes = ['lotico' => 'Lótico', 'lentico' => 'Lentico', 'intermediario' => 'Intermediário'];
        $floatingMaterials = ['ausente' => 'Ausente', 'presente' => 'Presente'];
        $effluentTypes = ['bruto' => 'Bruto', 'tratado' => 'Tratado'];

        if($analysisMatrix)
        {
            switch ($analysisMatrix->name)
            {
                case 'Água Supercial':
                    return response()->json([
                        'fields' => view('project.point-matrix-fields.fields-1',
                        compact('tides', 'environmentalConditions', 'sampleDepths', 'environmentalRegimes', 'floatingMaterials'))->render()
                    ]);
                    break;

                case 'Sedimento':
                    return response()->json([
                        'fields' => view('project.point-matrix-fields.fields-2', compact('sampleDepths', 'environmentalConditions', 'environmentalRegimes'))->render()
                    ]);
                    break;

                case 'Organismos':
                    return response()->json([
                        'fields' => view('project.point-matrix-fields.fields-3')->render()
                    ]);
                    break;

                case ['Efluente', 'Água Residuária']:
                    return response()->json([
                        'fields' => view('project.point-matrix-fields.fields-4', compact('environmentalConditions', 'effluentTypes'))->render()
                    ]);
                    break;

                case 'Água Subterrânea':
                    return response()->json([
                        'fields' => view('project.point-matrix-fields.fields-5', compact('environmentalConditions'))->render()
                    ]);
                    break;

                case 'Solo':
                    return response()->json([
                        'fields' => view('project.point-matrix-fields.fields-6', compact('environmentalConditions'))->render()
                    ]);
                    break;

                case 'Solo':
                    return response()->json([
                        'fields' => view('project.point-matrix-fields.fields-7')->render()
                    ]);
                    break;
                default:
                    return response()->json([
                        'fields' => view('project.point-matrix-fields.fields-7')->render()
                    ]);
                    break;
            }
        }

    }
}
