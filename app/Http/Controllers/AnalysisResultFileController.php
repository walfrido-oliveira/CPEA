<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnalysisOrder;
use App\Models\AnalysisResultFile;
use Illuminate\Support\Facades\Storage;

class AnalysisResultFileController extends Controller
{
    /**
     * Download file
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $analysisOrder = AnalysisOrder::findOrFail($id);
        $analysisResultsFiles = $analysisOrder->analysisResultsFiles;
        return response()->json([
            'modal' => view('analysis-order.analysis-result-files-modal', compact('analysisResultsFiles'))->render()
        ]);
    }

    /**
     * Download file
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        $analysisResultFile = AnalysisResultFile::findOrFail($id);
        return Storage::download($analysisResultFile->file);
    }
}
