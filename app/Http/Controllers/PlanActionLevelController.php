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
         return view('plan-action-level.index', compact('planActionLevels'));
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

        $geodetic =   PlanActionLevel::create([
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
        $environmental_area = PlanActionLevel::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('environmental_areas', 'name')->ignore($environmental_area->id)],
        ]);

        $input = $request->all();

        $environmental_area->update([
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

        //$planActionLevel->delete();

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
        $PlanActionLevels = PlanActionLevel::filter($request->all());
        $PlanActionLevels = $PlanActionLevels->setPath('');

        return response()->json([
            'filter_result' => view('plan-action-level.filter-result', compact('PlanActionLevels'))->render(),
            'pagination' => view('layouts.pagination', ['models' => $PlanActionLevels])->render(),
        ]);
    }
}
