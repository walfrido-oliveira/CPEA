<?php

namespace App\Http\Controllers;

use Colors\RandomColor;
use App\Models\Campaign;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AnalysisOrder;
use App\Models\AnalysisResult;
use App\Models\GuidingParameter;
use App\Models\GuidingParameterValue;
use PhpOffice\PhpSpreadsheet\IOFactory;
use ChrisKonnertz\StringCalc\StringCalc;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class AnalysisResultController extends Controller
{
    /**
     * Download results
     *
     * @param  Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function download(Request $request, $id)
    {
        $campaign = Campaign::findOrFail($id);

        $project = $campaign->project;
        $RandomColors = RandomColor::many(30, array('luminosity'=>'light', 'format'=>'hex'));
        $guidingParameters = [];

        if($project->guiding_parameter_order && count(explode(",", $project->guiding_parameter_order)))
        {
            foreach (explode(",", $project->guiding_parameter_order) as $key => $value)
            {
                $guidingParameters[] = GuidingParameter::find($value)->environmental_guiding_parameter_id;
            }
        }

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $sheet->setCellValue('A1', 'Parâmetro');
        $sheet->setCellValue('A2', 'Data Coleta');
        $sheet->setCellValue('A3', 'Hora Coleta');
        $sheet->setCellValue('A4', 'Ident.Laboratorio');

        $sheet->getStyle('A1')->getFill()->setFillType(Fill::FILL_SOLID) ->getStartColor()->setRGB('C0C0C0');

        foreach(range('A1','A4') as $columnID) : $sheet->getColumnDimension($columnID)->setAutoSize(true); endforeach;

        $sheet->setCellValue('B1', 'Unid');
        $sheet->getStyle('B1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');
        $sheet->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->mergeCells('B1:B4');

        $column = "B";

        foreach ($guidingParameters as $key => $value) : $column++; endforeach;

        $sheet->setCellValue('C1', 'Valores Orientadores');
        $sheet->getStyle('C1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('C1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');

        if(count($guidingParameters) > 1) $sheet->mergeCells('C1:' . $column . '1');

        foreach(range($column . "1", $column . "1") as $columnID) : $sheet->getColumnDimension($columnID)->setAutoSize(true); endforeach;

        $column2= "C";
        foreach ($guidingParameters as $key => $value)
        {
            $sheet->setCellValue($column2 . "2", $value);
            $sheet->getStyle($column2 . "2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($column2 . "2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            foreach(range($column2 . "2", $column2 . "2") as $columnID) : $sheet->getColumnDimension($columnID)->setAutoSize(true); endforeach;

            $sheet->getStyle($column2 . "2")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Str::replace("#", "", $RandomColors[$key]));
            $spreadsheet->getActiveSheet()->mergeCells($column2 . "2:" . $column2 . "4");

            $sheet->getStyle($column2 . "5")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');

            $column2++;
        }

        $projectPointMatrices = $campaign->projectPointMatrices;
        $pointIdentification = [];

        $analysisResult = AnalysisResult::leftJoin('analysis_order_project_point_matrix', 'analysis_order_project_point_matrix.project_point_matrix_id', '=', 'analysis_results.project_point_matrix_id')
        ->leftJoin('analysis_orders',  'analysis_orders.id', 'analysis_order_project_point_matrix.analysis_order_id')
        ->where('analysis_orders.campaign_id', $campaign->id)
        ->groupBy('samplename')->get();

        foreach ($analysisResult as $key => $value)
        {
            $pointIdentification[] = $value->samplename;

            $sheet->setCellValueByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 1, $value->samplename);
            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 1)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 1)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 1)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');
            $sheet->getColumnDimensionByColumn(2 + count($guidingParameters) + 1  + $key)->setAutoSize(true);

            $sheet->setCellValueByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 2, $value->sampdate->format('d/m/Y'));
            $sheet->setCellValueByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 3, $value->sampdate->format('h:m:i'));
            $sheet->setCellValueByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 4, $value->labsampid);

            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 2)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 2)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 3)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 3)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 4)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 4)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getColumnDimensionByColumn(2 + count($guidingParameters) + 1  + $key)->setAutoSize(true);
        }

        $groupParameterAnalysis = [];
        $parameterAnalysis = [];
        $column = 0;
        $key = 0;
        $index = 0;

        $projectPointMatrices = $campaign->projectPointMatrices()
        ->with('pointIdentification')
        ->leftJoin('point_identifications', 'point_identifications.id', '=', 'project_point_matrices.point_identification_id')
        ->leftJoin('parameter_analyses', 'parameter_analyses.id', '=', 'project_point_matrices.parameter_analysis_id')
        ->leftJoin('parameter_analysis_groups', 'parameter_analysis_groups.id', '=', 'parameter_analyses.parameter_analysis_group_id')
        ->orderBy('parameter_analysis_groups.order', 'asc')
        ->orderBy('parameter_analyses.analysis_parameter_name', 'asc')
        ->select('project_point_matrices.*')
        ->get();

        if(count($projectPointMatrices) > 0)
        {
            $sheet->setCellValueByColumnAndRow(1, 5, $projectPointMatrices[0]->parameterAnalysis->parameterAnalysisGroup->name);
            $groupParameterAnalysis[] = $projectPointMatrices[0]->parameterAnalysis->parameterAnalysisGroup->name;
            $sheet->getStyleByColumnAndRow(1, 5)->getFill() ->setFillType(Fill::FILL_SOLID) ->getStartColor()->setRGB('C0C0C0');
            $sheet->getStyleByColumnAndRow(2, 5)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');

            foreach ($analysisResult as $analysisIndex => $value)
            {
                $sheet->getStyleByColumnAndRow(3 + count($guidingParameters) + $analysisIndex, 5)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');
            }
        }

        $guidingParameterOrders = explode(",", $project->guiding_parameter_order);

        foreach ($projectPointMatrices as $point)
        {
            if($index > 0)
            {
              if ($projectPointMatrices[$index]->parameterAnalysis->parameter_analysis_group_id !=
                  $projectPointMatrices[$index - 1]->parameterAnalysis->parameter_analysis_group_id)
                {
                if(!in_array($point->parameterAnalysis->parameterAnalysisGroup->name, $groupParameterAnalysis))
                {
                    $sheet->setCellValueByColumnAndRow(1,  $key + 6, $point->parameterAnalysis->parameterAnalysisGroup->name);
                    $groupParameterAnalysis[] = $point->parameterAnalysis->parameterAnalysisGroup->name;

                    $sheet->getStyleByColumnAndRow(1,  $key + 6)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');
                    $sheet->getStyleByColumnAndRow(2,  $key + 6)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');

                    foreach ($guidingParameterOrders as $key2 => $value)
                    {
                        $sheet->getStyleByColumnAndRow(2 + ($key2 + 1),  $key + 6)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');
                    }

                    foreach ($analysisResult as $analysisIndex => $value)
                    {
                        $sheet->getStyleByColumnAndRow(3 + count($guidingParameters) + $analysisIndex, $key + 6)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');
                    }

                    $key++;
                }
              }
            }

            if(!in_array($point->parameterAnalysis->analysis_parameter_name, $parameterAnalysis) || $index == 0)
            {
              $sheet->setCellValueByColumnAndRow(1, $key + 6, $point->parameterAnalysis->analysis_parameter_name);
              $parameterAnalysis[] = $point->parameterAnalysis->analysis_parameter_name;

              foreach ($guidingParameterOrders as $key2 => $value)
              {
                $guidingParametersValue = GuidingParameterValue::where("guiding_parameter_id", $value)
                ->where('parameter_analysis_id', $point->parameterAnalysis->id)
                ->first();

                if($guidingParametersValue)
                {
                    if($guidingParametersValue->guidingValue)
                    {
                        if(Str::contains($guidingParametersValue->guidingValue->name, ['Quantitativo', 'Qualitativo']))
                        {
                            $sheet->setCellValueByColumnAndRow(3 + $key2,  $key + 6, $guidingParametersValue->guiding_legislation_value);
                        }
                        if(Str::contains($guidingParametersValue->guidingValue->name, ['Intervalo']))
                        {
                            $sheet->setCellValueByColumnAndRow(3 + $key2,  $key + 6,
                            $guidingParametersValue->guiding_legislation_value_1.' - '.$guidingParametersValue->guiding_legislation_value_2);
                        }
                    }
                    else
                    {
                        $sheet->setCellValueByColumnAndRow(3 + $key2,  $key + 6, $guidingParametersValue->guiding_legislation_value);
                    }
                }
                else
                {
                    $sheet->setCellValueByColumnAndRow(3 + $key2,  $key + 6, "-");
                }


                $sheet->getStyleByColumnAndRow(3 + $key2,  $key + 6)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyleByColumnAndRow(3 + $key2,  $key + 6)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyleByColumnAndRow(3 + $key2,  $key + 6)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Str::replace("#", "", $RandomColors[$key2]));
            }
              $key++;
            }
            $index++;
        }

        $key = 0;
        $index = 0;
        $groupParameterAnalysis = [];

        foreach ($pointIdentification as $value1)
        {
            $key=0;
            $index=0;
            $column = 0;
            $groupParameterAnalysis= [];

            $analysisResults = $campaign->analysisResults()
            ->with('projectPointMatrix')
            ->leftJoin('project_point_matrices', 'analysis_results.project_point_matrix_id', '=', 'project_point_matrices.id')
            ->leftJoin('point_identifications', 'point_identifications.id', '=', 'project_point_matrices.point_identification_id')
            ->leftJoin('parameter_analyses', 'parameter_analyses.id', '=', 'project_point_matrices.parameter_analysis_id')
            ->leftJoin('parameter_analysis_groups', 'parameter_analysis_groups.id', '=', 'parameter_analyses.parameter_analysis_group_id')
            ->orderBy('parameter_analysis_groups.order', 'asc')
            ->orderBy('parameter_analyses.analysis_parameter_name', 'asc')
            ->get();

            if(count($analysisResults) > 0) $groupParameterAnalysis[] = $analysisResults[0]->projectPointMatrix->parameterAnalysis->parameterAnalysisGroup->name;

            foreach ($analysisResults as $value)
            {
                if($value->projectPointMatrix->pointIdentification->area . "-" .
                   $value->projectPointMatrix->pointIdentification->identification != $value1)
                {
                    continue;
                }

                $break = false;
                $index = 0;

                while ($sheet->getCellByColumnAndRow(1, 6 + $index) != $value->projectPointMatrix->parameterAnalysis->analysis_parameter_name)
                {
                    $index++;
                    if($index >= count($analysisResults))
                    {
                        $break = true;
                        break;
                    }
                }

                if($break) continue;

                $sheet->setCellValueByColumnAndRow(2,  $index + 6, $value->units);
                $sheet->getStyleByColumnAndRow(2,  $index + 6)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyleByColumnAndRow(2,  $index + 6)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                $column = array_search($value->projectPointMatrix->pointIdentification->area . "-" .
                                       $value->projectPointMatrix->pointIdentification->identification,
                                       $pointIdentification);

                $result =  Str::replace(["*J", " [1]"], "", $value->result);
                $result = Str::replace("<", "< ", $result);

                $rl =  Str::replace(["*J", " [1]"], "", $value->rl);
                $rl = Str::replace("<", "< ", $rl);

                $resultValue = Str::replace("< ", "", $result);
                $rlValue = Str::replace("< ", "", $rl);

                $result =  Str::contains($value->result, '*J') ? $result : ($resultValue >= $rlValue ? $result : $rl);

                $sheet->setCellValueByColumnAndRow($column + 2 + count($guidingParameters) + 1, 6 + $index, $result);
                $sheet->getStyleByColumnAndRow($column + 2 + count($guidingParameters) + 1, 6 + $index)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyleByColumnAndRow($column + 2 + count($guidingParameters) + 1, 6 + $index)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                if($value->rl) if($resultValue > $rlValue) $sheet->getStyleByColumnAndRow($column + 2 + count($guidingParameters) + 1, 6 + $index)->getFont()->setBold(true);

                $result = Str::replace("< ", "", $result);

                foreach ($guidingParameterOrders as $key2 => $value3)
                {
                    $guidingParametersValue = GuidingParameterValue::where("guiding_parameter_id", $value3)
                    ->where('parameter_analysis_id', $value->projectPointMatrix->parameterAnalysis->id)
                    ->first();

                    if($guidingParametersValue)
                    {
                        if(Str::contains($guidingParametersValue->guidingValue->name, ['Quantitativo', 'Qualitativo']))
                        {
                            if($result > $guidingParametersValue->guiding_legislation_value)
                            {
                                $sheet->getStyleByColumnAndRow($column + 2 + count($guidingParameters) + 1, 6 + $index)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Str::replace("#", "", $RandomColors[$key2]));
                                break;
                            }
                        }
                        if(Str::contains($guidingParametersValue->guidingValue->name, ['Intervalo']))
                        {
                            if(($result < $guidingParametersValue->guiding_legislation_value || $result > $guidingParametersValue->guiding_legislation_value_1))
                            {
                                $sheet->getStyleByColumnAndRow($column + 2 + count($guidingParameters) + 1, 6 + $index)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Str::replace("#", "", $RandomColors[$key2]));
                                break;
                            }
                        }
                    }
                }

                $key++;
            }
            $column++;
        }

        $column = "A";
        $count = count($guidingParameters) + 1 + count($analysisResult);
        $row = 5;
        $index = 0;
        $groupParameterAnalysis = [];
        $parameterAnalysis = [];

        for ($i=0; $i < $count; $i++) : $column++; endfor;

        $groupParameterAnalysis[] = $projectPointMatrices[0]->parameterAnalysis->parameterAnalysisGroup->name;
        $sheet->mergeCells('A' . $row . ':' . $column . $row);

        foreach ($projectPointMatrices as $point)
        {
            if($index > 0)
            {
              if ($projectPointMatrices[$index]->parameterAnalysis->parameter_analysis_group_id !=
                  $projectPointMatrices[$index - 1]->parameterAnalysis->parameter_analysis_group_id)
                {
                if(!in_array($point->parameterAnalysis->parameterAnalysisGroup->name, $groupParameterAnalysis))
                {
                    $groupParameterAnalysis[] = $point->parameterAnalysis->parameterAnalysisGroup->name;
                    $row++;
                    $sheet->mergeCells('A' . $row . ':' . $column . $row);
                }
              }
            }

            if(!in_array($point->parameterAnalysis->analysis_parameter_name, $parameterAnalysis) || $index == 0)
            {
              $parameterAnalysis[] = $point->parameterAnalysis->analysis_parameter_name;
              $row++;
            }
            $index++;
        }

        $sheet->getStyle("A1:" . $column . $row)->applyFromArray($border);

        $writer = new Xls($spreadsheet);

        $writer->save(tmpfile());

        return response()->streamDownload(function() use($writer) {
            $writer->save("php://output");
        }, 'file.xls');
    }

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
            'file' => 'required|mimes:xls,xlsx|max:4096',
            'order' =>  ['required', 'exists:analysis_orders,id'],
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'message' => implode("<br>", $validator->messages()->all()),
                'alert-type' => 'error'
            ], 403);
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

            $order = AnalysisOrder::findOrFail($orderId);
            $projectPointMatrices = $order->projectPointMatrices()
            ->whereHas("project", function($q) use($value) {
                $q->where("project_cod", 'like', '%' . $value[2]);
            })
            ->whereHas('parameterAnalysis', function($q) use($value) {
                $q->where('parameter_analyses.cas_rn', $value[21]);
            })->whereHas('pointIdentification', function($q) use($pointIdentifciation) {
                $q->where('point_identifications.area', $pointIdentifciation[0])
                  ->where('point_identifications.identification', $pointIdentifciation[1]);
            })->whereHas('analysisMatrix', function($q) use($value) {
                $q->where('analysis_matrices.name', $value[7]);
            })
            ->first();

            if(!$projectPointMatrices) continue;

            $analysisResult = AnalysisResult::firstOrCreate([
                'project_point_matrix_id' => $projectPointMatrices->id,
                'analysis_order_id' => $order->id
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

        $projectPointMatrices = $order->projectPointMatrices()->whereHas("parameterAnalysis", function(){

        })->get();

        foreach ($projectPointMatrices as $key => $value)
        {
            if(count($value->calculationParameters) > 0)
            {
                $re = '/{(.*?)}/m';
                $formula = $value->calculationParameters[0]->formula;
                preg_match_all($re, $formula, $matches, PREG_SET_ORDER, 0);
                dd($matches);
                foreach ($matches as $key2 => $value2)
                {
                    $result = explode("&", $value2[1]);

                    $projectPointMatrix = $order->projectPointMatrices()->whereHas('parameterAnalysis', function($q) use($result) {
                        $q->where('parameter_analyses.analysis_parameter_name', $result[0])
                          ->where('parameter_analyses.cas_rn', $result[1]);
                    })->first();

                    if($projectPointMatrix)
                    {
                        $analysisResult = AnalysisResult::where("project_point_matrix_id", $projectPointMatrix->id)->first();
                        if($analysisResult)
                        {
                            $formula = Str::replace($value2[0],  $analysisResult->result, $formula);
                            $sampdate = $analysisResult->sampdate;
                            $samplename = $analysisResult->samplename;
                            $labsampid = $analysisResult->labsampid;
                        }
                    }
                }

                $formula = Str::replace(["*J", " [1]", "< ", "<"],  "", $formula);
                $formula = Str::replace([","],  ".", $formula);
                $stringCalc = new StringCalc();
                dd($formula);
                $result = $stringCalc->calculate($formula);

                $analysisResult = AnalysisResult::firstOrCreate([
                    'project_point_matrix_id' => $value->id,
                    'analysis_order_id' => $order->id
                ]);

                $analysisResult->update([
                    'result' => $result,
                    'labsampid' => $labsampid,
                    'sampdate' => $sampdate,
                    'samplename' => $samplename
                ]);
            }
        }

        return response()->json([
            'message' => __("$totalImport importada(s) no total de $totalRows pontos"),
            'alert-type' => 'success'
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $analysisResult = AnalysisResult::where("project_point_matrix_id", $id)->first();
        if(!$analysisResult)
        {
            $resp = [
                'message' => __('Amostra não localizada!'),
                'alert-type' => 'warning'
            ];

            return redirect()->back()->with($resp);
        }

        return view('analysis-result.edit', compact('analysisResult'));
    }

    /**
     * Show the form for details the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $analysisResult = AnalysisResult::where("project_point_matrix_id", $id)->first();
        if(!$analysisResult)
        {
            $resp = [
                'message' => __('Amostra não localizada!'),
                'alert-type' => 'warning'
            ];

            return redirect()->back()->with($resp);
        }

        return view('analysis-result.show', compact('analysisResult'));
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
        $analysisResult = AnalysisResult::findOrFail($id);

        $input = $request->all();

        $analysisResult->update([
            "client" => $input["client"],
            "project" => $input["project"],
            "projectnum" => $input["projectnum"],
            "labname" => $input["labname"],
            "samplename" => $input["samplename"],
            "labsampid" => $input["labsampid"],
            "matrix" => $input["matrix"],
            "rptmatrix" => $input["rptmatrix"],
            "solidmatrix" => $input["solidmatrix"],
            "sampdate" => $input["sampdate"],
            "prepdate" => $input["prepdate"],
            "anadate" => $input["anadate"],
            "batch" => $input["batch"],
            "analysis" => $input["analysis"],
            "anacode" => $input["anacode"],
            "methodcode" => $input["methodcode"],
            "methodname" => $input["methodname"],
            "description" => $input["description"],
            "prepname" => $input["prepname"],
            "analyte" => $input["analyte"],
            "analyteorder" => $input["analyteorder"],
            "casnumber" => $input["casnumber"],
            "surrogate" => $input["surrogate"],
            "tic" => $input["tic"],
            "result" => $input["result"],
            "dl" => $input["dl"],
            "rl" => $input["rl"],
            "units" => $input["units"],
            "rptomdl" => $input["rptomdl"],
            "mrlsolids" => $input["mrlsolids"],
            "basis" => $input["basis"],
            "dilution" => $input["dilution"],
            "spikelevel" => $input["spikelevel"],
            "recovery" => $input["recovery"],
            "uppercl" => $input["uppercl"],
            "lowercl" => $input["lowercl"],
            "analyst" => $input["analyst"],
            "psolids" => $input["psolids"],
            "lnote" => $input["lnote"],
            "anote" => $input["anote"],
            "latitude" => $input["latitude"],
            "longitude" => $input["longitude"],
            "scomment" => $input["scomment"],
            "snote1" => $input["snote1"],
            "snote2" => $input["snote2"],
            "snote3" => $input["snote3"],
            "snote4" => $input["snote4"],
            "snote5" => $input["snote5"],
            "snote6" => $input["snote6"],
            "snote7" => $input["snote7"],
            "snote8" => $input["snote8"],
            "snote9" => $input["snote9"],
            "snote10" => $input["snote10"],
        ]);

        $resp = [
            'message' => __('Análise da Amostra Atualizada com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('analysis-order.show', ['analysis_order' => $analysisResult->analysisOrder->id])->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $analysisResult = AnalysisResult::findOrFail($id);

        $analysisResult->delete();

        return response()->json([
            'message' => __('Amostra Apagada com Sucesso!!'),
            'alert-type' => 'success'
        ]);
    }
}
