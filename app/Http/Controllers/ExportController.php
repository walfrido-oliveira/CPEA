<?php

namespace App\Http\Controllers;

use App\Models\GuidingParameter;
use App\Models\ParameterAnalysis;
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
            'PARAM. ORIENTADOR AMBIENTAL',
            'MATRIZ',
            'PARAM. ANÁLISE',
            'REF. PARAM. VALOR ORIENTADOR',
            'TIPO VALOR ORIENTADOR',
            'UNIDADE LEGISLAÇAO',
            'VALOR ORIENTADOR LEGISLAÇAO',
            'VALOR ORIENTADOR LEGISLAÇAO 1',
            'VALOR ORIENTADOR LEGISLAÇAO 2',
            'UNIDADE ANÁLISE',
            'VALOR ORIENTADOR ANÁLISE',
            'VALOR ORIENTADOR ANÁLISE 1',
            'VALOR ORIENTADOR ANÁLISE 2'
        ];

        return response()->stream(function() use($data, $headerColumn){
            $hadle = fopen('php://output', 'w+');

            fputcsv($hadle, $headerColumn, ";");

            foreach ($data as $row)
            {
                $item = [
                    $row->guidingParameter->name,
                    $row->analysisMatrix->name,
                    $row->parameterAnalysis->analysis_parameter_name,
                    $row->guidingParameterRefValue ? $row->guidingParameterRefValue->guiding_parameter_ref_value_id : null,
                    $row->guidingParameter ? $row->guidingParameter->name : null,
                    $row->unityLegislation->name,
                    $row->guiding_legislation_value,
                    $row->guiding_legislation_value_1,
                    $row->guiding_legislation_value_2,
                    $row->unityAnalysis->name,
                    $row->guiding_analysis_value,
                    $row->guiding_analysis_value_1,
                    $row->guiding_analysis_value_2,
                ];
                fputcsv($hadle, $item, ';');
            }

            fclose($hadle);
        }, 200, $headers);
    }

    /**
     * Export All
     *
     * @return \Illuminate\Http\Response
     */
    public function exportParameterAnalysis()
    {
        $data = ParameterAnalysis::all();
        $name = 'export.csv';
        $headers = [
            'Content-Disposition' => 'attachment; filename='. $name,
            "Content-Encoding"    => "UTF-8",
            "Content-type"        => "text/csv; charset=UTF-8",
        ];

        $headerColumn = [
            'TIPO PARAM. ANALISE',
            'CAS RN',
            'REF CASRN PARAM. ANÁLISE',
            'NOME PARAM. ANÁLISE',
            'GRUPO PARAM. ANÁLISE',
            'ORDEM',
            'CASADECIMAL',
        ];

        return response()->stream(function() use($data, $headerColumn){
            $hadle = fopen('php://output', 'w+');

            fputcsv($hadle, $headerColumn, ";");

            foreach ($data as $row)
            {
                $item = [
                    $row->analysisParameter->name,
                    $row->cas_rn,
                    $row->ref_cas_rn,
                    $row->analysis_parameter_name,
                    $row->parameterAnalysisGroup ? $row->parameterAnalysisGroup->name : null,
                    $row->order,
                    $row->decimal_place,
                ];
                fputcsv($hadle, $item, ';');
            }

            fclose($hadle);
        }, 200, $headers);
    }

    /**
     * Export All
     *
     * @return \Illuminate\Http\Response
     */
    public function exportGuidingParameter()
    {
        $data = GuidingParameter::all();
        $name = 'export.csv';
        $headers = [
            'Content-Disposition' => 'attachment; filename='. $name,
            "Content-Encoding"    => "UTF-8",
            "Content-type"        => "text/csv; charset=UTF-8",
        ];

        $headerColumn = [
           'COD. PARAM. ORIENTADOR AMBIENTAL',
           'NOME PARAM. ORIENTADOR',
           'TIPO ÁREA AMBIENTAL',
           'ÓRGÃO AMBIENTAL',
           'CLIENTE',
           'RESOLUÇÕES',
           'ARTIGOS',
           'OBS'
        ];

        return response()->stream(function() use($data, $headerColumn){
            $hadle = fopen('php://output', 'w+');

            fputcsv($hadle, $headerColumn, ";");

            foreach ($data as $row)
            {
                $item = [
                    $row->environmental_guiding_parameter_id,
                    $row->name,
                    $row->environmentalArea ? $row->environmentalArea->name : null,
                    $row->environmentalAgency ? $row->environmentalAgency->name : null,
                    $row->customer ? $row->customer->name : null,
                    $row->resolutions,
                    $row->articles,
                    $row->observation
                ];
                fputcsv($hadle, $item, ';');
            }

            fclose($hadle);
        }, 200, $headers);
    }
}
