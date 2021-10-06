<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use App\Models\Project;
use App\Models\Campaign;
use App\Models\Customer;
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
        ->get();

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
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cart(Request $request)
    {
        $input = $request->all();
        $cart = isset($input['cart']) ? explode(",", $input['cart']) : [];
        $labs = Lab::pluck('name', 'id');
        $campaign = isset($input['campaign_id']) ? Campaign::findOrFail($input['campaign_id']) : null;

        $projectPointMatrices = ProjectPointMatrix::whereIn('id', $cart)->get();

        return view('sample-analysis.cart', compact('projectPointMatrices', 'labs', 'campaign'));
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
        $inputs = $request->except(['parameter_analysis_item']);

        $projectPointMatrices = ProjectPointMatrix::filter($inputs);
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $campaign = Campaign::findOrFail($request->get('campaign_id'));


        return response()->json([
            'filter_result' => view('sample-analysis.parameter-analysis-result',
            compact('projectPointMatrices', 'orderBy', 'ascending', 'campaign'))->render(),
        ]);
    }
}
