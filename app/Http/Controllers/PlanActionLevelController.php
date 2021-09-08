<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlanActionLevel;
use Illuminate\Validation\Rule;

class PlanActionLevelController extends Controller
{
    /**
     * Display a listing of the user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $planActionLevels =  PlanActionLevel::filter($request->all());
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';

        return view('plan-action-level.index', compact('planActionLevels', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('plan-action-level.create');
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
            'name' => ['required', 'string', 'max:255', Rule::unique('plan_action_levels', 'name')],
        ]);

        $input = $request->all();

        $planActionLevel =   PlanActionLevel::create([
            'name' => $input['name']
        ]);

        $resp = [
            'message' => __('Tipo Nível Ação Plano Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.plan-action-level.index')->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $planActionLevel = PlanActionLevel::findOrFail($id);
        return view('plan-action-level.show', compact('planActionLevel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $planActionLevel = PlanActionLevel::findOrFail($id);
        return view('plan-action-level.edit', compact('planActionLevel'));
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
        $planActionLevel = PlanActionLevel::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('plan_action_levels', 'name')->ignore($planActionLevel->id)],
        ]);

        $input = $request->all();

        $planActionLevel->update([
            'name' => $input['name'],
        ]);

        $resp = [
            'message' => __('Tipo Nível Ação Plano Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.plan-action-level.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $planActionLevel = PlanActionLevel::findOrFail($id);

        $planActionLevel->delete();

        return response()->json([
            'message' => __('Tipo Nível Ação Plano Apagado com Sucesso!!'),
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
        $planActionLevels = PlanActionLevel::filter($request->all());
        $planActionLevels = $planActionLevels->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('plan-action-level.filter-result', compact('planActionLevels', 'orderBy', 'ascending', 'paginatePerPage'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $planActionLevels,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
                ])->render(),
            ]);
    }
}
