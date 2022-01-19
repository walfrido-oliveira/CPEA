<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Models\AnalysisOrder;
use App\Models\AnalysisResult;
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

        $ascending = isset($query['ascending']) ? $query['ascending'] : 'asc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'point_identifications.identification';

        $projectPointMatrices = $analysisOrder
        ->projectPointMatrices()
        ->with('pointIdentification')
        ->leftJoin('point_identifications', 'point_identifications.id', '=', 'project_point_matrices.point_identification_id')
        ->leftJoin('parameter_analyses', 'parameter_analyses.id', '=', 'project_point_matrices.parameter_analysis_id')
        ->leftJoin('parameter_analysis_groups', 'parameter_analysis_groups.id', '=', 'parameter_analyses.parameter_analysis_group_id')
        ->orderBy($orderBy, $ascending)
        ->orderBy('parameter_analysis_groups.name', 'asc')
        ->select('project_point_matrices.*')
        ->get();

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
            'project_point_matrices.*' => ['required']
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

        return redirect()->route('analysis-order.show', ['analysis_order' => $analysisOrder->id])->with(
            array(
                'message' => __('Pedido de Análise Encaminhado com Sucesso!'),
                'alert-type' => 'success'
            )
        );

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
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $campaign = Campaign::findOrFail($request->get('campaign_id'));

        $projectPointMatrices = $request->has('q') ? $analysisOrder->projectPointMatrices()
        ->where(function($q) use ($query) {
            $q->whereHas('pointIdentification', function($q) use($query) {
                $q->where('point_identifications.area', 'like', '%' . $query['q'] . '%')
                  ->orWhere('point_identifications.identification', 'like', '%' . $query['q'] . '%');
            })
            ->orWhereHas('analysisMatrix', function($q) use($query) {
                $q->where('analysis_matrices.name', 'like', '%' . $query['q'] . '%');
            })
            ->orWhereHas('parameterAnalysis', function($q) use($query) {
                $q->where('parameter_analyses.analysis_parameter_name', 'like', '%' . $query['q'] . '%');
            });
        })
        ->get() : $analysisOrder->projectPointMatrices;

        $projectPointMatrices
        ->orderBy($orderBy, $ascending)
        ->orderBy('parameter_analysis_groups.name', 'asc')
        ->select('project_point_matrices.*');

        return response()->json([
            'filter_result' => view('analysis-order.parameter-analysis-result',
            compact('projectPointMatrices', 'orderBy', 'ascending', 'campaign', 'analysisOrder'))->render(),
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

        if($request->get('status') == 'concluded' &&
           count($analysisOrder->projectPointMatrices) > count($analysisOrder->analysisResults))
        {
            return response()->json([
                'message' => __("Favor, incluir o EDD em todos os itens para Concluir o Pedido $analysisOrder->formatted_id!"),
                'alert-type' => 'warning'], 403);
        }

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
            $analysisOrder->analysisResults()->get()->each(function ($item, $key) {
                $item->delete();
            });
        }

        $msg = $request->get('status') == 'canceled' ? 'Cancelado' : 'Atualizado';

        switch ($request->get('type')) {
            case 'analysis-order':
                return response()->json([
                    'message' => __("Pedido $analysisOrder->formatted_id $msg com Sucesso!"),
                    'alert-type' => 'success',
                    'result' => view('analysis-order.status', compact('analysisOrder'))->render(),]);
                break;
            case 'sample-analysis':
                $campaign = $analysisOrder->campaign;
                $projectPointMatrices = $campaign
                ->projectPointMatrices()
                ->with('pointIdentification')
                ->leftJoin('point_identifications', 'point_identifications.id', '=', 'project_point_matrices.point_identification_id')
                ->leftJoin('parameter_analyses', 'parameter_analyses.id', '=', 'project_point_matrices.parameter_analysis_id')
                ->leftJoin('parameter_analysis_groups', 'parameter_analysis_groups.id', '=', 'parameter_analyses.parameter_analysis_group_id')
                ->orderBy('point_identifications.area', 'asc')
                ->orderBy('point_identifications.identification', 'asc')
                ->orderBy('parameter_analysis_groups.name', 'asc')
                ->select('project_point_matrices.*')
                ->get();

                return response()->json([
                    'message' => __("Pedido $analysisOrder->formatted_id $msg com Sucesso!"),
                    'alert-type' => 'success',
                    'status' => view('sample-analysis.status-order', compact('analysisOrder'))->render(),
                    'project_point_matrices' => view('sample-analysis.parameter-analysis-result', compact('projectPointMatrices', 'campaign'))->render(),
                ]);
                break;
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $analysisOrder
     * @param  int  $item
     * @return \Illuminate\Http\Response
     */
    public function destroyItem($analysisOrder, $item)
    {
        $analysisOrder = AnalysisOrder::findOrFail($analysisOrder);

        $analysisOrder->projectPointMatrices()->detach($item);

        $analysisResult = AnalysisResult::where("project_point_matrix_id", $item)->first();
        $analysisResult->delete();

        return response()->json([
            'message' => __('Ponto/Matriz Apagado com Sucesso!'),
            'alert-type' => 'success'
        ]);
    }

}
