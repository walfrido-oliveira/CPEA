<?php

namespace App\Http\Controllers;

use App\Models\Unity;
use Illuminate\Http\Request;
use App\Http\Requests\UnityRequest;

class UnityController extends Controller
{
    /**
     * Display a listing of the unity.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $unities =  Unity::filter($request->all());
        $unitiesList = Unity::all()->pluck('name', 'id');

        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'id';

        return view('unity.index', compact('unities', 'unitiesList', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unities = Unity::all()->pluck('name', 'id');
        return view('unity.create', compact('unities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UnityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnityRequest $request)
    {
        $input = $request->all();

        $unity = Unity::create([
            'name' => $input['name'],
            'unity_cod' => $input['unity_cod'],
            'unity_id' => $input['unity_id'],
            'conversion_amount' => $input['conversion_amount'],
        ]);

        return redirect()->route('registers.unity.index')->with(defaultSaveMessagemNotification());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $unity = Unity::findOrFail($id);

        return view('unity.show', compact('unity'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unity = Unity::findOrFail($id);
        $unities = Unity::all()->pluck('name', 'id');

        return view('unity.edit', compact('unity', 'unities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UnityRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UnityRequest $request, $id)
    {
        $input = $request->all();

        $unity = Unity::findOrFail($id);

        $unity->update([
            'name' => $input['name'],
            'unity_cod' => $input['unity_cod'],
            'unity_id' => $input['unity_id'],
            'conversion_amount' => $input['conversion_amount'],
        ]);

        return redirect()->route('registers.unity.index', ['unity' => $unity->id])->with(defaultSaveMessagemNotification());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unity = Unity::findOrFail($id);

        $unity->delete();

        return response()->json([
            'message' => __('Unidade Apagada com Sucesso!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter Unity
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $unities = Unity::filter($request->all());
        $unities = $unities->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginate_per_page = $request->get('paginate_per_page');

        return response()->json([
        'filter_result' => view('unity.filter-result', compact('unities', 'orderBy', 'ascending'))->render(),
        'pagination' => view('layouts.pagination', [
            'models' => $unities,
            'order_by' => $orderBy,
            'ascending' => $ascending,
            'paginate_per_page' => $paginate_per_page,
            ])->render(),
        ]);
    }
}
