<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnalysisMatrix;
use App\Http\Requests\AnalysisMatrixRequest;

class AnalysisMatrixController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $analysisMatrices =  AnalysisMatrix::filter($request->all());
        $names = AnalysisMatrix::pluck('name', 'name');
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'analysis_matrix_id';

        return view('analysis-matrix.index', compact('analysisMatrices', 'ascending', 'orderBy', 'names'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('analysis-matrix.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AnalysisMatrixRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnalysisMatrixRequest $request)
    {
        $input = $request->all();

        $analysisMatrix= AnalysisMatrix::create([
            'name' => $input['name'],
            'analysis_matrix_id' => $input['analysis_matrix_id'],
        ]);

        return redirect()->route('registers.analysis-matrix.index')->with(defaultSaveMessagemNotification());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $analysisMatrix= AnalysisMatrix::findOrFail($id);

        return view('analysis-matrix.show', compact('analysisMatrix'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $analysisMatrix = AnalysisMatrix::findOrFail($id);

        return view('analysis-matrix.edit', compact('analysisMatrix'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AnalysisMatrixRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AnalysisMatrixRequest $request, $id)
    {
        $input = $request->all();

        $analysisMatrix= AnalysisMatrix::findOrFail($id);

        $analysisMatrix->update([
            'name' => $input['name'],
            'analysis_matrix_id' => $input['analysis_matrix_id'],
        ]);

         return redirect()->route('registers.analysis-matrix.index')->with(defaultSaveMessagemNotification());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $analysisMatrix= AnalysisMatrix::findOrFail($id);

        $analysisMatrix->delete();

        return response()->json([
            'message' => __('Matriz Análise Apagado com Sucesso!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter AnalysisMatrix
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $analysisMatrices = AnalysisMatrix::filter($request->all());
        $analysisMatrices = $analysisMatrices->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginate_per_page = $request->get('paginate_per_page');

        return response()->json([
        'filter_result' => view('analysis-matrix.filter-result', compact('analysisMatrices', 'orderBy', 'ascending'))->render(),
        'pagination' => view('layouts.pagination', [
            'models' => $analysisMatrices,
            'order_by' => $orderBy,
            'ascending' => $ascending,
            'paginate_per_page' => $paginate_per_page,
            ])->render(),
        ]);
    }
}
