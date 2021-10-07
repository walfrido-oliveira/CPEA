<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Models\AnalysisOrder;
use App\Models\ProjectPointMatrix;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\AnalysisOrderRequest;

class AnalysisOrderController extends Controller
{
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
            $erros = $validator->errors();

            return view('sample-analysis.cart', compact('projectPointMatrices', 'campaign', 'labs', 'erros'))->withErrors($validator);
        }

        $analysisOrder = AnalysisOrder::create([
            'lab_id' => $input['lab_id'],
            'obs' => $input['obs'],
            'campaign_id' => $input['campaign_id'],
        ]);

        $analysisOrder->projectPointMatrix()->sync($input['project_point_matrices']);

        return redirect()->route('sample-analysis.show', ['campaign' => $input['campaign_id']])->with(defaultSaveMessagemNotification());

    }
}
