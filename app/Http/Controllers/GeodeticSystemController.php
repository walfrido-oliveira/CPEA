<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\GeodeticSystem;

class GeodeticSystemController extends Controller
{
    /**
    * Display a listing of the user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $geodetics =  GeodeticSystem::filter($request->all());
         return view('geodetics.index', compact('geodetics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('geodetics.create');
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
            'name' => ['required', 'string', 'max:255', Rule::unique('geodetic_systems', 'name')],
        ]);

        $input = $request->all();

        $geodetic =   GeodeticSystem::create([
            'name' => $input['name']
        ]);

        $resp = [
            'message' => __('Tipo Sistema Geodésico Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.geodetics.index')->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $geodetic = GeodeticSystem::findOrFail($id);
        return view('geodetics.show', compact('geodetic'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $geodetic = GeodeticSystem::findOrFail($id);
        return view('geodetics.edit', compact('geodetic'));
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
        $geodetic = GeodeticSystem::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('geodetic_systems', 'name')->ignore($geodetic->id)],
        ]);

        $input = $request->all();

        $geodetic->update([
            'name' => $input['name'],
        ]);

        $resp = [
            'message' => __('Tipo Sistema Geodésico Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.geodetics.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $geodetic = GeodeticSystem::findOrFail($id);

        $geodetic->delete();

        return response()->json([
            'message' => __('Tipo Sistema Geodésico Apagado com Sucesso!!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter geodetic
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $geodetics = GeodeticSystem::filter($request->all());
        $geodetics = $geodetics->setPath('');

        return response()->json([
            'filter_result' => view('geodetics.filter-result', compact('geodetics'))->render(),
            'pagination' => view('layouts.pagination', ['models' => $geodetics])->render(),
        ]);
    }
}
