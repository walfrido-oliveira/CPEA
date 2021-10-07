<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Models\AnalysisOrder;
use App\Models\ProjectPointMatrix;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\AnalysisOrderRequest;

class AnalysisOrderController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $analysisOrder = AnalysisOrder::findOrFail($id);
        $projectPointMatrices  = $analysisOrder->projectPointMatrices;
        $campaign = $analysisOrder->campaign;

        return view('analysis-order.show', compact('analysisOrder', 'projectPointMatrices', 'campaign'));
    }

    /**
     * Display cart.
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
        $totalPoints = count($projectPointMatrices->groupBy("point_identification_id"));
        $totalGroups = 0;
        $groupArray = [];

        foreach ($projectPointMatrices as $key => $projectPointMatrix)
        {
            $name = $projectPointMatrix->parameterAnalysis->parameterAnalysisGroup->name;
            if(!in_array($name, $groupArray)) $groupArray[] = $name;
        }

        $totalGroups = count($groupArray);
        $totalParamAnalysis = count($projectPointMatrices);

        Cookie::queue(Cookie::make('projectPointMatrices', $projectPointMatrices->pluck('id'), 60));
        Cookie::queue(Cookie::make('labs', $labs, 60));
        Cookie::queue(Cookie::make('campaign', $campaign->id, 60));
        Cookie::queue(Cookie::make('totalPoints', $totalPoints, 60));
        Cookie::queue(Cookie::make('totalGroups', $totalGroups, 60));
        Cookie::queue(Cookie::make('totalParamAnalysis', $totalParamAnalysis, 60));

        return view('analysis-order.cart', compact('projectPointMatrices', 'labs', 'campaign', 'totalPoints', 'totalGroups', 'totalParamAnalysis'));
    }

    /**
     * Display cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCart(Request $request)
    {
        if(!$request->cookie('projectPointMatrices'))
        {
            return redirect()->route('sample-analysis.index');
        }

        $projectPointMatrices = ProjectPointMatrix::whereIn('id', json_decode($request->cookie('projectPointMatrices')))->get();
        $labs = json_decode($request->cookie('labs'));
        $campaign = Campaign::findOrFail($request->cookie('campaign'));
        $totalPoints = $request->cookie('totalPoints');
        $totalGroups = $request->cookie('totalGroups');
        $totalParamAnalysis = $request->cookie('totalParamAnalysis');

        return view('analysis-order.cart', compact('projectPointMatrices', 'labs', 'campaign', 'totalPoints', 'totalGroups', 'totalParamAnalysis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lab_id' => ['required', 'exists:labs,id'],
            'obs' => ['nullable', 'string', 'max:255'],
            'campaign_id' => ['required', 'exists:campaigns,id'],
            'project_point_matrices.*' => ['required', 'unique:analysis_order_project_point_matrix,project_point_matrix_id']
        ]);

        $input = $request->all();

        if($validator->fails())
        {
            $projectPointMatrices = ProjectPointMatrix::whereIn('id', $input['project_point_matrices'])->get();
            $campaign = isset($input['campaign_id']) ? Campaign::findOrFail($input['campaign_id']) : null;
            $labs = Lab::pluck('name', 'id');
            $totalPoints = $request->cookie('totalPoints');
            $totalGroups = $request->cookie('totalGroups');
            $totalParamAnalysis = $request->cookie('totalParamAnalysis');
            $erros = $validator->errors();

            return view('analysis-order.cart',
            compact('projectPointMatrices', 'campaign', 'labs', 'erros', 'totalPoints', 'totalGroups', 'totalParamAnalysis'))->withErrors($validator);
        }

        $analysisOrder = AnalysisOrder::create([
            'lab_id' => $input['lab_id'],
            'obs' => $input['obs'],
            'campaign_id' => $input['campaign_id'],
        ]);

        $analysisOrder->projectPointMatrices()->sync($input['project_point_matrices']);

        Cookie::queue(Cookie::make('projectPointMatrices', null, 60));
        Cookie::queue(Cookie::make('labs', null, 60));
        Cookie::queue(Cookie::make('campaign', 0, 60));
        Cookie::queue(Cookie::make('totalPoints', 0, 60));
        Cookie::queue(Cookie::make('totalGroups', 0, 60));
        Cookie::queue(Cookie::make('totalParamAnalysis', 0, 60));

        return redirect()->route('analysis-order.show', ['analysis_order' => $analysisOrder->id])->with(defaultSaveMessagemNotification());

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

        $analysisOrder = AnalysisOrder::findOrFail($request->get('id'));
        $query = $request->all();

        $projectPointMatrices = $request->has('q') ? $analysisOrder->projectPointMatrices()
        ->where(function($q) use ($query) {
            $q->whereHas('pointIdentification', function($q) use($query) {
                $q->where('point_identifications.area', 'like', '%' . $query['q'] . '%')
                  ->orWhere('point_identifications.identification', 'like', '%' . $query['q'] . '%');
            })
            ->orWhereHas('analysisMatrix', function($q) use($query) {
                $q->where('analysis_matrices.name', 'like', '%' . $query['q'] . '%');
            })
            ->orWhereHas('planActionLevel', function($q) use($query) {
                $q->where('plan_action_levels.name', 'like', '%' . $query['q'] . '%');
            })
            ->orWhereHas('guidingParameter', function($q) use($query) {
                $q->where('guiding_parameters.environmental_guiding_parameter_id', 'like', '%' . $query['q'] . '%');
            })
            ->orWhereHas('parameterAnalysis', function($q) use($query) {
                $q->where('parameter_analyses.analysis_parameter_name', 'like', '%' . $query['q'] . '%');
            });
        })
        ->get() : $analysisOrder->projectPointMatrices;

        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $campaign = Campaign::findOrFail($request->get('campaign_id'));

        return response()->json([
            'filter_result' => view('analysis-order.parameter-analysis-result',
            compact('projectPointMatrices', 'orderBy', 'ascending', 'campaign'))->render(),
        ]);
    }

    /**
     * Change analysis order status
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request, $id)
    {
        $validated = $request->validate([
            'id' => 'required|exists:analysis_orders,id',
            'status' => 'required|in:sent,analyzing,concluded,canceled',
        ]);

        $analysisOrder = AnalysisOrder::findOrFail($request->get('id'));

        $analysisOrder->update([
            'status' => $request->get('status')
        ]);

        if($request->get('status') == 'analyzing')
        {
            $analysisOrder->update([
                'analyzing_at' => now(),
                'concluded_at' => null
            ]);
        }

        if($request->get('status') == 'concluded')
        {
            $analysisOrder->update([
                'concluded_at' => now()
            ]);
        }

        if($request->get('status') == 'canceled')
        {
            $analysisOrder->update([
                'analyzing_at' => null,
                'concluded_at' => null
            ]);
        }

        return response()->json([
            'message' => __('Pedido Atualizado com Sucesso!'),
            'alert-type' => 'success',
            'result' => view('analysis-order.status', compact('analysisOrder'))->render()
        ]);

    }

}
