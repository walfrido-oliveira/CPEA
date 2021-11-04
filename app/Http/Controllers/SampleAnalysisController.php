<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use App\Models\Project;
use App\Models\Campaign;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AnalysisOrder;
use App\Models\ProjectPointMatrix;

class SampleAnalysisController extends Controller
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

        $status = ['pending' => __('pending'), 'sent' => __('sent'), 'analyzing' => __('analyzing'), 'concluded' => __('concluded')];
        $labs = Lab::pluck('name', 'id');
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'projects.project_cod';

        return view('sample-analysis.index', compact('projetcs', 'status', 'ascending', 'orderBy', 'labs'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $campaign = Campaign::findOrFail($id);
        $status = ['sent' => __('sent'), 'pending' => __('pending'), 'analyzing' => __('analyzing'), 'concluded' => __('concluded')];
        $orders = $campaign->analysisOrders;

        $ascending = isset($query['ascending']) ? $query['ascending'] : 'asc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'point_identifications.identification';

        $projectPointMatrices = $campaign
        ->projectPointMatrices()
        ->with('pointIdentification')
        ->leftJoin('point_identifications', 'point_identifications.id', '=', 'project_point_matrices.point_identification_id')
        ->leftJoin('parameter_analyses', 'parameter_analyses.id', '=', 'project_point_matrices.parameter_analysis_id')
        ->leftJoin('parameter_analysis_groups', 'parameter_analysis_groups.id', '=', 'parameter_analyses.parameter_analysis_group_id')
        ->orderBy($orderBy, $ascending)
        ->orderBy('parameter_analysis_groups.name', 'asc')
        ->select('project_point_matrices.*')
        ->toSQL();

        dd($projectPointMatrices);

        return view('sample-analysis.show', compact('campaign', 'projectPointMatrices', 'status', 'orders'));
    }

    /**
     * Display the historic.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function historic($id)
    {
        $campaign= Campaign::findOrFail($id);
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
        'filter_result' => view('sample-analysis.filter-result', compact('projetcs', 'orderBy', 'ascending', 'actions'))->render(),
        'pagination' => view('layouts.pagination', [
            'models' => $projetcs ,
            'order_by' => $orderBy,
            'ascending' => $ascending,
            'paginate_per_page' => $paginate_per_page,
            ])->render(),
        ]);
    }

    /**
     * Filter
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function filterPointMatrix(Request $request)
    {
        $query = $request->except(['parameter_analysis_item']);

        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');

        $campaign = Campaign::findOrFail($request->get('campaign_id'));

        $projectPointMatrices = $campaign
        ->projectPointMatrices()
        ->with('pointIdentification')
        ->leftJoin('point_identifications', 'point_identifications.id', '=', 'project_point_matrices.point_identification_id')
        ->leftJoin('parameter_analyses', 'parameter_analyses.id', '=', 'project_point_matrices.parameter_analysis_id')
        ->leftJoin('parameter_analysis_groups', 'parameter_analysis_groups.id', '=', 'parameter_analyses.parameter_analysis_group_id')
        ->where(function($q) use ($query) {
            if(isset($query['q']))
            {
                if(!is_null($query['q']))
                {
                    $q->where( function($q) use($query){
                        $q->whereHas('pointIdentification', function($q) use($query) {
                            $area = Str::contains($query['q'], '-') ? trim(explode("-", $query['q'])[0]) : $query['q'];
                            $identification = Str::contains($query['q'], '-') ? trim(explode("-", $query['q'])[1]) : $query['q'];

                            $q->where('point_identifications.area', 'like', '%' . $area . '%')
                              ->orWhere('point_identifications.identification', 'like', '%' . $identification . '%');
                        })
                        ->orWhereHas('analysisMatrix', function($q) use($query) {
                            $q->where('analysis_matrices.name', 'like', '%' . $query['q'] . '%');
                        })
                        ->orWhereHas('guidingParameters', function($q) use($query) {
                            $q->where('guiding_parameters.environmental_guiding_parameter_id', 'like', '%' . $query['q'] . '%');
                        })
                        ->orWhereHas('parameterAnalysis', function($q) use($query) {
                            $q->where('parameter_analyses.analysis_parameter_name', 'like', '%' . $query['q'] . '%');
                        });
                    });

                }
            }
        })
        ->orderBy($orderBy, $ascending)
        ->orderBy('parameter_analysis_groups.name', 'asc')
        ->select('project_point_matrices.*')
        ->get();

        return response()->json([
            'filter_result' => view('sample-analysis.parameter-analysis-result',
            compact('projectPointMatrices', 'orderBy', 'ascending', 'campaign'))->render(),
        ]);
    }
}
