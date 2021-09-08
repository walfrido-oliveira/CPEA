<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CampaignStatus;
use Illuminate\Validation\Rule;

class CampaignStatusController extends Controller
{
    /**
     * Display a listing of the user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $campaignStatuses =  CampaignStatus::filter($request->all());
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';

        return view('campaign-status.index', compact('campaignStatuses', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('campaign-status.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('campaign_statuses', 'name')],
        ]);

        $input = $request->all();

        $campaignStatus =   CampaignStatus::create([
            'name' => $input['name']
        ]);

        $resp = [
            'message' => __('Status Campanha Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.campaign-status.index')->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $campaignStatus = CampaignStatus::findOrFail($id);
        return view('campaign-status.show', compact('campaignStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $campaignStatus = CampaignStatus::findOrFail($id);
        return view('campaign-status.edit', compact('campaignStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $campaignStatus = CampaignStatus::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('campaign_statuses', 'name')->ignore($campaignStatus->id)],
        ]);

        $input = $request->all();

        $campaignStatus->update([
            'name' => $input['name'],
        ]);

        $resp = [
            'message' => __('Status Campanha Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.campaign-status.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $campaignStatus = CampaignStatus::findOrFail($id);

        $campaignStatus->delete();

        return response()->json([
            'message' => __('Status Campanha Apagado com Sucesso!!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter Plan Action Level
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $campaignStatuses = CampaignStatus::filter($request->all());
        $campaignStatuses = $campaignStatuses->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('campaign-status.filter-result', compact('campaignStatuses', 'orderBy', 'ascending'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $campaignStatuses,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
                ])->render(),
            ]);
    }
}
