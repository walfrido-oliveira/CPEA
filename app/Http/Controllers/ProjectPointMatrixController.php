<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\ProjectPointMatrix;

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
                'parameter_analysis_id' => $input['parameter_analysis_id']
            ]);
        } else {
            $projectPointMatrix = ProjectPointMatrix::create([
                'project_id' => $input['project_id'],
                'point_identification_id' => $input['point_identification_id'],
                'analysis_matrix_id' => $input['analysis_matrix_id'],
                'plan_action_level_id' => $input['plan_action_level_id'],
                'guiding_parameter_id' => $input['guiding_parameter_id'],
                'parameter_analysis_id' => $input['parameter_analysis_id']
            ]);
        }

        $id = $projectPointMatrix->id;
        $className = 'edit-point-matrix';

        $resp = [
            'message' => __('Ponto/Matriz Atualizado com Sucesso!'),
            'alert-type' => 'success',
            'point_matrix' => view('project.saved-point-matrix', compact('projectPointMatrix', 'key', 'id', 'className'))->render(),
            'point_matrices' => $projectPointMatrix->project->projectPointMatrices
        ];

        return response()->json($resp);
    }

    /**
     * Update the specified resource in storage.
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
        $user = ProjectPointMatrix::findOrFail($id);

        $user->delete();

        return response()->json([
            'message' => __('Ponto/Matriz Apagado com Sucesso!'),
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
        $projectPointMatrices = ProjectPointMatrix::filter($request->all());
        $projects = $projectPointMatrices->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginate_per_page = $request->get('paginate_per_page');

        return response()->json([
        'filter_result' => view('project.point-matrix-result', compact('projectPointMatrices', 'orderBy', 'ascending'))->render(),
        'pagination' => view('layouts.pagination', [
            'models' => $projects,
            'order_by' => $orderBy,
            'ascending' => $ascending,
            'paginate_per_page' => $paginate_per_page,
            ])->render(),
        ]);
    }
}
