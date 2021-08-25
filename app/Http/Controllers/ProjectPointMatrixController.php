<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectPointMatrix;

class ProjectPointMatrixController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = ProjectPointMatrix::findOrFail($id);

        //$user->delete();

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
