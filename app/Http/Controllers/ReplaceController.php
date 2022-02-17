<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use App\Models\Replace;
use App\Models\To;
use Illuminate\Http\Request;

class ReplaceController extends Controller
{
    /**
     * Display a listing of the user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $replaces =  Replace::filter($request->all());
        $labs = Lab::all()->pluck('name', 'id');
        $to = To::all()->pluck('name', 'name');

        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'lab_id';

        return view('replace.index', compact('replaces', 'ascending', 'orderBy', 'labs', 'to'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $labs = Lab::orderBy('name')->pluck('name', 'id');
        $to = To::all()->pluck('name', 'name');
        return view('replace.create', compact('labs', 'to'));
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
            'from' => ['required', 'string', 'max:255'],
            'to' => ['required', 'string', 'max:255'],
            'lab_id' => ['required', 'exists:labs,id'],
        ]);

        $input = $request->all();

        $replace =   Replace::create([
            'from' => $input['from'],
            'to' => $input['to'],
            'lab_id' => $input['lab_id'],
        ]);

        $resp = [
            'message' => __('De Para Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.replace.index')->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $replace = Replace::findOrFail($id);
        return view('replace.show', compact('replace'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $replace = Replace::findOrFail($id);
        $labs = Lab::orderBy('name')->pluck('name', 'id');
        $to = To::all()->pluck('name', 'name');

        return view('replace.edit', compact('replace', 'labs', 'to'));
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
        $replace = Replace::findOrFail($id);

        $request->validate([
            'from' => ['required', 'string', 'max:255'],
            'to' => ['required', 'string', 'max:255'],
            'lab_id' => ['required', 'exists:labs,id'],
        ]);

        $input = $request->all();

        $replace->update([
            'from' => $input['from'],
            'to' => $input['to'],
            'lab_id' => $input['lab_id'],
        ]);

        $resp = [
            'message' => __('De Para Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.replace.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $replace = Replace::findOrFail($id);

        $replace->delete();

        return response()->json([
            'message' => __('De Para Apagado com Sucesso!!'),
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
        $replaces = Replace::filter($request->all());
        $replaces = $replaces->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('replace.filter-result', compact('replaces', 'orderBy', 'ascending'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $replaces,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
                ])->render(),
            ]);
    }
}
