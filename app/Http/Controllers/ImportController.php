<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\Unity;
use App\Models\GuidingValue;
use Illuminate\Http\Request;
use App\Models\AnalysisMatrix;
use App\Models\GuidingParameter;
use App\Models\ParameterAnalysis;
use App\Models\GuidingParameterValue;
use App\Models\GuidingParameterRefValue;

class ImportController extends Controller
{
    /**
     * Import All
     *
     * * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function viewImportGuidingParameterValue(Request $request)
    {
        if($request->file)
        {
            $imports = [];
            $index = 0;
            $file_handle = fopen($request->file, 'r');
            while (!feof($file_handle))
            {
                $items[] = fgetcsv($file_handle, 0, ";");
                $index++;
            }
            array_pop($items);

            foreach ($items as $key => $value)
            {
                if($key > 1)
                {
                    $gruidingParameter = GuidingParameter::where('name', utf8_encode($value[0]))->first();
                    $analysisMatrix = AnalysisMatrix::where('name', utf8_encode($value[1]))->first();
                    $parameterAnalysis = ParameterAnalysis::where('analysis_parameter_name', utf8_encode($value[2]))->first();
                    $guidingParameterRefValue = GuidingParameterRefValue::where('guiding_parameter_ref_value_id', utf8_encode($value[3]))->first();
                    $guidingValue = GuidingValue::where('name', utf8_encode($value[4]))->first();
                    $unityLegislation = Unity::where('name', utf8_encode($value[5]))->first();
                    $unityAnalysis = Unity::where('name', utf8_encode($value[6]))->first();

                    $obj = new stdClass();
                    $obj->gruidingParameter = $gruidingParameter ? $gruidingParameter->name : null;
                    $obj->analysisMatrix = $analysisMatrix ? $analysisMatrix->name : null;
                    $obj->parameterAnalysis = $parameterAnalysis ? $parameterAnalysis->analysis_parameter_name : null;
                    $obj->guidingParameterRefValue = $guidingParameterRefValue ? $guidingParameterRefValue->guiding_parameter_ref_value_id : null;
                    $obj->guidingValue = $guidingValue ? $guidingValue->name : null;
                    $obj->unityLegislation = $unityLegislation ? $unityLegislation->name : null;
                    $obj->unityAnalysis = $unityAnalysis ? $unityAnalysis->name : null;
                    $imports[] = $obj;
                }
            }
            return response()->json([
                'result' => view('guiding-parameter-value.import-result-modal', compact('imports'))->render(),
                'alert-type' => 'success'
            ]);
        }
        return response()->json([
            'message' => __('Arquivo não informado'),
            'alert-type' => 'error'
        ]);
    }
    /**
     * Import All
     *
     * * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function importGuidingParameterValue(Request $request)
    {
        if($request->file)
        {
            $imports = [];
            $index = 0;
            $file_handle = fopen($request->file, 'r');
            while (!feof($file_handle))
            {
                $items[] = fgetcsv($file_handle, 0, ";");
                $index++;
            }
            array_pop($items);

            foreach ($items as $key => $value)
            {
                if($key > 1)
                {
                    $gruidingParameter = GuidingParameter::where('name', $value[0])->first();
                    $analysisMatrix = AnalysisMatrix::where('name', $value[1])->first();
                    $parameterAnalysis = ParameterAnalysis::where('analysis_parameter_name', $value[2])->first();
                    $guidingParameterRefValue = GuidingParameterRefValue::where('guiding_parameter_ref_value_id', $value[3])->first();
                    $guidingValue = GuidingValue::where('name', $value[4])->first();
                    $unityLegislation = Unity::where('name', $value[5])->first();
                    $unityAnalysis = Unity::where('name', $value[6])->first();

                    $obj = new stdClass();
                    $obj->gruidingParameter = $gruidingParameter ? $gruidingParameter->name : null;
                    $obj->analysisMatrix = $analysisMatrix ? $analysisMatrix->name : null;
                    $obj->parameterAnalysis = $parameterAnalysis ? $parameterAnalysis->analysis_parameter_name : null;
                    $obj->guidingParameterRefValue = $guidingParameterRefValue ? $guidingParameterRefValue->guiding_parameter_ref_value_id : null;
                    $obj->guidingValue = $guidingValue ? $guidingValue->name : null;
                    $obj->unityLegislation = $unityLegislation ? $unityLegislation->name : null;
                    $obj->unityAnalysis = $unityAnalysis ? $unityAnalysis->name : null;
                    $imports[] = $obj;

                    if(!$gruidingParameter || !$analysisMatrix) continue;

                    $result = GuidingParameterValue::create([
                        'guiding_parameter_id' => $gruidingParameter ? $gruidingParameter->id : null,
                        'analysis_matrix_id' => $analysisMatrix ? $analysisMatrix->id : null,
                        'parameter_analysis_id'=> $parameterAnalysis ? $parameterAnalysis->id : null,
                        'guiding_parameter_ref_value_id' => $guidingParameterRefValue ? $guidingParameterRefValue->id : null,
                        'guiding_value_id' => $guidingValue ? $guidingValue->id : null,
                        'unity_legislation_id' => $unityLegislation ? $unityLegislation->id : null,
                        'unity_analysis_id' => $unityAnalysis ? $unityAnalysis->id : null,
                        'guiding_legislation_value' => $value[0][7],
                        'guiding_legislation_value_1' => $value[0][8],
                        'guiding_legislation_value_2' => $value[0][9],
                        'guiding_analysis_value' => $value[0][10],
                        'guiding_analysis_value_1' => $value[0][11],
                        'guiding_analysis_value_2' => $value[0][12],

                    ]);
                }
            }
            return response()->json([
                'message' => __('Importação realizada com sucesso!!'),
                'alert-type' => 'success'
            ]);
        }
        return response()->json([
            'message' => __('Arquivo não informado'),
            'alert-type' => 'error'
        ]);
    }
}
