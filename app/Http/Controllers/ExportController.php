<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GuidingParameterValue;

class ExportController extends Controller
{
    /**
     * Export All
     *
     * @return \Illuminate\Http\Response
     */
    public function exportGuidingParameterValue()
    {
        $data = GuidingParameterValue::all();
        $name = 'export.csv';
        $headers = [
            'Content-Disposition' => 'attachment; filename='. $name,
            "Content-Encoding"    => "UTF-8",
            "Content-type"        => "text/csv; charset=UTF-8",
        ];

        $headerColumn = [
            'Param. Analise',
            'Param. Orientador Ambiental',
            'Matriz',
            'Tipo Valor Param. Orientador',
            'Ref. Param. Orientador',
            'Unidade Legislacao',
            'Valor Legislacao',
            'Unidade Analise',
            'Valor Analise'
        ];

        return response()->stream(function() use($data, $headerColumn){
            $hadle = fopen('php://output', 'w+');

            fputcsv($hadle, $headerColumn, ";");

            foreach ($data as $row)
            {
                $item = [
                    $row->parameterAnalysis->analysis_parameter_name,
                    $row->guidingParameter->name,
                    $row->analysisMatrix->name,
                    '',
                    $row->guidingParameterRefValue ? $row->guidingParameterRefValue->guiding_parameter_ref_value_id : null,
                    $row->unityLegislation->name,
                    $row->guiding_legislation_value,
                    $row->unityAnalysis->name,
                    $row->guiding_analysis_value
                ];
                fputcsv($hadle, $item, ';');
            }

            fclose($hadle);
        }, 200, $headers);
    }
}
