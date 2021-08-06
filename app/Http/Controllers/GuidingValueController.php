<?php

namespace App\Http\Controllers;

use App\Models\GuidingValue;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GuidingValueController extends Controller
{
    /**
     * Display a listing of the GuidingValue.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $guidingValues =  GuidingValue::filter($request->all());
         return view('guiding-value.index', compact('guidingValues'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('guiding-value.create');
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
            'name' => ['required', 'string', 'max:255', Rule::unique('guiding_values', 'name')],
        ]);

        $input = $request->all();

        $guidingValue =   GuidingValue::create([
            'name' => $input['name']
        ]);

        $resp = [
            'message' => __('Tipo Valor Orientador Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.guiding-value.index')->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $guidingValue = GuidingValue::findOrFail($id);
        return view('guiding-value.show', compact('guidingValue'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $guidingValue = GuidingValue::findOrFail($id);
        return view('guiding-value.edit', compact('guidingValue'));
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
        $guidingValue = GuidingValue::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('guiding_values', 'name')->ignore($guidingValue->id)],
        ]);

        $input = $request->all();

        $guidingValue->update([
            'name' => $input['name'],
        ]);

        $resp = [
            'message' => __('Tipo Valor Orientador Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.guiding-value.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $guidingValue = GuidingValue::findOrFail($id);

        $guidingValue->delete();

        return response()->json([
            'message' => __('Tipo Valor Orientador Apagado com Sucesso!!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter GuidingValue
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $guidingValue = GuidingValue::filter($request->all());
        $guidingValue = $guidingValue->setPath('');

        return response()->json([
            'filter_result' => view('guiding-value.filter-result', compact('guidingValue'))->render(),
            'pagination' => view('layouts.pagination', ['models' => $guidingValue])->render(),
        ]);
    }
}
