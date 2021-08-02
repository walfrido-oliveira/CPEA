<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PointIdentification;

class PointIdentificationController extends Controller
{
    /**
     * Display a listing of the user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pointIdentifications =  PointIdentification::filter($request->all());
         return view('point-identification.index', compact('pointIdentifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('point-identification.create');
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
            'area' => ['required', 'string', 'max:255'],
            'identification' => ['required', 'string', 'max:255'],
        ]);

        $input = $request->all();

        $pointIdentification =   PointIdentification::create([
            'area' => $input['area'],
            'identification' => $input['identification']
        ]);

        $resp = [
            'message' => __('Ponto Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.point-identification.index')->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pointIdentification = PointIdentification::findOrFail($id);
        return view('point-identification.show', compact('pointIdentification'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pointIdentification = PointIdentification::findOrFail($id);
        return view('point-identification.edit', compact('pointIdentification'));
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
        $pointIdentification = PointIdentification::findOrFail($id);

        $request->validate([
            'area' => ['required', 'string', 'max:255'],
            'identification' => ['required', 'string', 'max:255'],
        ]);

        $input = $request->all();

        $pointIdentification->update([
            'area' => $input['area'],
            'identification' => $input['identification']
        ]);

        $resp = [
            'message' => __('Ponto Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.point-identification.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pointIdentification = PointIdentification::findOrFail($id);

        //$pointIdentification->delete();

        return response()->json([
            'message' => __('Ponto Apagado com Sucesso!!'),
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
        $pointIdentifications = PointIdentification::filter($request->all());
        $pointIdentifications = $pointIdentifications->setPath('');

        return response()->json([
            'filter_result' => view('point-identification.filter-result', compact('pointIdentifications'))->render(),
            'pagination' => view('layouts.pagination', ['models' => $pointIdentifications])->render(),
        ]);
    }
}
