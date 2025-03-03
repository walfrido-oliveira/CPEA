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
                    $unityLegislation = Unity::where('unity_cod', utf8_encode($value[5]))->first();
                    $unityAnalysis = Unity::where('unity_cod', utf8_encode($value[9]))->first();

                    $obj = new stdClass();
                    $obj->gruidingParameter = $gruidingParameter ? $gruidingParameter->name : "($value[0])";
                    $obj->analysisMatrix = $analysisMatrix ? $analysisMatrix->name : "($value[1])";
                    $obj->parameterAnalysis = $parameterAnalysis ? $parameterAnalysis->analysis_parameter_name : "($value[2])";
                    $obj->guidingParameterRefValue = $guidingParameterRefValue ? $guidingParameterRefValue->guiding_parameter_ref_value_id : "($value[3])";
                    $obj->guidingValue = $guidingValue ? $guidingValue->name : "($value[4])";
                    $obj->unityLegislation = $unityLegislation ? $unityLegislation->name : "($value[5])";
                    $obj->unityAnalysis = $unityAnalysis ? $unityAnalysis->name : "($value[9])";
                    $obj->status = $gruidingParameter && $analysisMatrix && $parameterAnalysis ? 'found' : 'not_found';
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
                    $gruidingParameter = GuidingParameter::where('name', utf8_encode($value[0]))->first();
                    $analysisMatrix = AnalysisMatrix::where('name', utf8_encode($value[1]))->first();
                    $parameterAnalysis = ParameterAnalysis::where('analysis_parameter_name', utf8_encode($value[2]))->first();
                    $guidingParameterRefValue = GuidingParameterRefValue::where('guiding_parameter_ref_value_id', utf8_encode($value[3]))->first();
                    $guidingValue = GuidingValue::where('name', utf8_encode($value[4]))->first();
                    $unityLegislation = Unity::where('unity_cod', utf8_encode($value[5]))->first();
                    $unityAnalysis = Unity::where('unity_cod', utf8_encode($value[9]))->first();

                    $obj = new stdClass();
                    $obj->gruidingParameter = $gruidingParameter ? $gruidingParameter->name : "($value[0])";
                    $obj->analysisMatrix = $analysisMatrix ? $analysisMatrix->name : "($value[1])";
                    $obj->parameterAnalysis = $parameterAnalysis ? $parameterAnalysis->analysis_parameter_name : "($value[2])";
                    $obj->guidingParameterRefValue = $guidingParameterRefValue ? $guidingParameterRefValue->guiding_parameter_ref_value_id : "($value[3])";
                    $obj->guidingValue = $guidingValue ? $guidingValue->name : "($value[4])";
                    $obj->unityLegislation = $unityLegislation ? $unityLegislation->name : "($value[5])";
                    $obj->unityAnalysis = $unityAnalysis ? $unityAnalysis->name : "($value[9])";
                    $obj->status = $gruidingParameter && $analysisMatrix && $parameterAnalysis ? 'found' : 'not_found';
                    $imports[] = $obj;

                    if(!$gruidingParameter || !$analysisMatrix || !$parameterAnalysis) continue;

                    GuidingParameterValue::create([
                        'guiding_parameter_id' => $gruidingParameter ? $gruidingParameter->id : null,
                        'analysis_matrix_id' => $analysisMatrix ? $analysisMatrix->id : null,
                        'parameter_analysis_id'=> $parameterAnalysis ? $parameterAnalysis->id : null,
                        'guiding_parameter_ref_value_id' => $guidingParameterRefValue ? $guidingParameterRefValue->id : null,
                        'guiding_value_id' => $guidingValue ? $guidingValue->id : null,
                        'unity_legislation_id' => $unityLegislation ? $unityLegislation->id : null,
                        'unity_analysis_id' => $unityAnalysis ? $unityAnalysis->id : null,
                        'guiding_legislation_value' => $value[6],
                        'guiding_legislation_value_1' => $value[7],
                        'guiding_legislation_value_2' => $value[8],
                        'guiding_analysis_value' => $value[10],
                        'guiding_analysis_value_1' => $value[11],
                        'guiding_analysis_value_2' => $value[12],
                    ]);
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
}
