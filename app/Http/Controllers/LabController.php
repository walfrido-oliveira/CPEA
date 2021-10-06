<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LabController extends Controller
{
     /**
     * Display a listing of the user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $labs =  Lab::filter($request->all());
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';

        return view('lab.index', compact('labs', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = ['external' => 'Laboratório (Externo)', 'internal' => 'Laboratório (Interno)'];
        return view('lab.create', compact('types'));
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
            'name' => ['required', 'string', 'max:255', Rule::unique('labs', 'name')],
            'type' => ['required', 'string', 'in:external,internal'],
            'cod' => ['required', 'string', 'max:255', Rule::unique('labs', 'cod')],
        ]);

        $input = $request->all();

        $lab =   Lab::create([
            'type' => $input['type'],
            'name' => $input['name'],
            'cod' => $input['cod'],
        ]);

        $resp = [
            'message' => __('Laboratório Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.lab.index')->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lab = Lab::findOrFail($id);
        return view('lab.show', compact('lab'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lab = Lab::findOrFail($id);
        $types = ['external' => 'Laboratório (Externo)', 'internal' => 'Laboratório (Interno)'];

        return view('lab.edit', compact('lab', 'types'));
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
        $lab = Lab::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('labs', 'name')],
            'type' => ['required', 'string', 'in:external,internal'],
            'cod' => ['required', 'string', 'max:255', Rule::unique('labs', 'cod')],
        ]);

        $input = $request->all();

        $lab->update([
            'type' => $input['type'],
            'name' => $input['name'],
            'cod' => $input['cod'],
        ]);

        $resp = [
            'message' => __('Laboratório Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('registers.lab.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lab = Lab::findOrFail($id);

        $lab->delete();

        return response()->json([
            'message' => __('Laboratório Apagado com Sucesso!!'),
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
        $labs = Lab::filter($request->all());
        $labs = $labs->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('lab.filter-result', compact('labs', 'orderBy', 'ascending'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $labs,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
                ])->render(),
            ]);
    }
}
