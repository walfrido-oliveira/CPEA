<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnalysisOrder;
use App\Models\AnalysisResult;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;

class AnalysisResultController extends Controller
{
    /**
     * Import results
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'file' => 'required|mimes:xls|max:4096',
            'order' =>  ['required', 'exists:analysis_orders,id'],
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->with(
              array(
                'message' => implode("<br>", $validator->messages()->all()),
                'alert-type' => 'error'
              )
            );
        }

        $orderId = $request->get('order');
        $spreadsheet = IOFactory::load($request->file->path());
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        $totalImport = 0;
        $totalRows = count($rows);

        foreach($rows as $key => $value)
        {
            if($key == 0) continue;

            $pointIdentifciation = explode("-", $value[4]);
            #$pointIdentifciation[1] = explode(" ", $pointIdentifciation[1])[0];

            #dd($pointIdentifciation);

            $order = AnalysisOrder::findOrFail($orderId);
            $projectPointMatrices = $order->projectPointMatrices()
            ->whereHas('parameterAnalysis', function($q) use($value) {
                $q->where('parameter_analyses.cas_rn', $value[21]);
            })->whereHas('pointIdentification', function($q) use($pointIdentifciation) {
                $q->where('point_identifications.area', $pointIdentifciation[0])
                  ->where('point_identifications.identification', 'like', $pointIdentifciation[1]);
            })
            ->first();

            if(!$projectPointMatrices) continue;

            $analysisResult = AnalysisResult::firstOrCreate([
                'project_point_matrix_id' => $projectPointMatrices->id,
            ]);

            $analysisResult->update([
              'client' => $value[0],
              'project' => $value[1],
              'projectnum' => $value[2],
              'labname' => $value[3],
              'samplename' => $value[4],
              'labsampid' => $value[5],
              'matrix' => $value[6],
              'rptmatrix' => $value[7],
              'solidmatrix' => $value[8],
              'sampdate' => $value[9],
              'prepdate' => $value[10],
              'anadate' => $value[11],
              'batch' => $value[12],
              'analysis' => $value[13],
              'anacode' => $value[14],
              'methodcode' => $value[15],
              'methodname' => $value[16],
              'description' => $value[17],
              'prepname' => $value[18],
              'analyte' => $value[19],
              'analyteorder' => $value[20],
              'casnumber' => $value[21],
              'surrogate' => $value[22],
              'tic' => $value[23],
              'result' => $value[24],
              'dl' => $value[25],
              'rl' => $value[26],
              'units' => $value[27],
              'rptomdl' => $value[28],
              'mrlsolids' => $value[29],
              'basis' => $value[30],
              'dilution' => $value[31],
              'spikelevel' => $value[32],
              'recovery' => $value[33],
              'uppercl' => $value[34],
              'lowercl' => $value[35],
              'analyst' => $value[36],
              'psolids' => $value[37],
              'lnote' => $value[38],
              'anote' => $value[39],
              'latitude' => $value[40],
              'longitude' => $value[41],
              'scomment' => $value[42],
              'snote1' => $value[43],
              'snote2' => $value[44],
              'snote3' => $value[45],
              'snote4' => $value[46],
              'snote5' => $value[47],
              'snote6' => $value[48],
              'snote7' => $value[49],
              'snote8' => $value[50],
              'snote9' => $value[51],
              'snote10' => $value[52],
            ]);

            $totalImport++;
        }

        return redirect()->route('analysis-order.show', ['analysis_order' => $orderId])->with(
            array(
                'message' => __("$totalImport importada(s) no total de $totalRows pontos"),
                'alert-type' => 'success'
            )
        );

    }
}
