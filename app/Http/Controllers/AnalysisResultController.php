<?php

namespace App\Http\Controllers;

use stdClass;
use Carbon\Carbon;
use App\Models\Lab;
use App\Models\Project;
use Colors\RandomColor;
use App\Models\Campaign;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AnalysisOrder;
use App\Models\AnalysisResult;
use App\Models\GuidingParameter;
use App\Models\ParameterAnalysis;
use App\Models\AnalysisResultFile;
use Illuminate\Support\Facades\DB;
use App\Models\GuidingParameterValue;
use PhpOffice\PhpSpreadsheet\IOFactory;
use ChrisKonnertz\StringCalc\StringCalc;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class AnalysisResultController extends Controller
{

    /**
     * Download EDD results
     *
     * @param  Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function downloadEDD(Request $request, $id)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $analysisResult = AnalysisResult::where('analysis_order_id', $id)->get();
        $column = 1;
        $row = 1;

        if (count($analysisResult) > 0) {
            foreach ($analysisResult[0]->getAttributes() as $key => $value) {
                if (Str::contains($key, ['id', 'project_point_matrix_id', 'analysis_order_id', 'created_at', 'updated_at'])) continue;
                $sheet->setCellValueByColumnAndRow($column, $row, $key);
                $column++;
            }

            $row++;
            foreach ($analysisResult as $value) {
                if (!$value->labname) continue;
                $column = 1;
                foreach ($value->getAttributes() as $value2) {
                    $sheet->setCellValueByColumnAndRow($column, $row, $value2);
                    $column++;
                }
                $row++;
            }
        } else {
            return redirect()->route('analysis-order.show', ['analysis_order' => $id])->with([
                'message' => __('Nenhum item de EDD encontrado.'),
                'alert-type' => 'warning'
            ]);
        }

        $writer = new Xls($spreadsheet);

        $writer->save(tmpfile());

        return response()->streamDownload(function () use ($writer) {
            $writer->save("php://output");
        }, 'file.xls');
    }

    /**
     * Get Colors from projet
     *
     * @param Project $project
     *
     * @return Array
     */
    private function getColors(Project $project)
    {
        $colors = [];

        if (is_array($project->colors) && count($project->colors) > 0) {
            $colors = $project->colors;
        } else {
            $colors = RandomColor::many(30, array('luminosity' => 'light', 'format' => 'hex'));

            while (in_array(["#FFCC99", "#FFFF99", "#DAEEF3"], $colors)) {
                $colors = RandomColor::many(30, array('luminosity' => 'light', 'format' => 'hex'));
            }

            $colors[0] = "#FFCC99";
            $colors[1] = "#FFFF99";
            $colors[2] = "#DAEEF3";
        }

        return $colors;
    }

    /**
     * Get order from project
     *
     * @param Project $Project
     *
     * @return Array
     */
    private function getGuidingParametersOrder(Project $project)
    {
        $guidingParameters = [];

        if ($project->guiding_parameter_order && !is_array($project->guiding_parameter_order)) {
            foreach (explode(",", $project->guiding_parameter_order) as $value) {
                $guidingParameter = GuidingParameter::find($value);
                if ($guidingParameter) {
                    $guidingParameters[] = $guidingParameter;
                }
            }
        } else {
            foreach ($project->guiding_parameter_order as $value) {
                $guidingParameter = GuidingParameter::find($value);
                if ($guidingParameter) {
                    $guidingParameters[] = $guidingParameter;
                }
            }
        }

        return $guidingParameters;
    }

    /**
     * Get parameter Analysis group list
     *
     * @param ParameterAnalysis $parameterAnalysis
     * @return Array
     */
    private function getParameterAnalysisGroup(ParameterAnalysis $parameterAnalysis)
    {
        $parents[] = $parameterAnalysis->parameterAnalysisGroup;
        $parent = $parameterAnalysis->parameterAnalysisGroup->parameterAnalysisGroup;
        while ($parent) {
            $parents[] = $parent;
            $parent = $parent->parameterAnalysisGroup;
        }
        return $parents;
    }

    /**
     * Download results
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        $campaign = Campaign::findOrFail($id);
        $project = $campaign->project;
        $colors = $this->getColors($project);
        $guidingParameters = $this->getGuidingParametersOrder($project);

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $sheet->setCellValueByColumnAndRow(1, 1, 'Parâmetro');
        $sheet->getStyleByColumnAndRow(1, 1)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');

        $sheet->setCellValueByColumnAndRow(1, 2, 'Data de Coleta');
        $sheet->setCellValueByColumnAndRow(1, 3, 'Hora de Coleta');
        $sheet->setCellValueByColumnAndRow(1, 4, 'Grupo do Laboratório');
        $sheet->setCellValueByColumnAndRow(1, 5, 'Identificação do Laboratório');
        $sheet->getStyle("A1:A5")->applyFromArray($border);

        foreach (range('A1', 'A5') as $columnID) : $sheet->getColumnDimension($columnID)->setAutoSize(true);
        endforeach;

        $sheet->setCellValueByColumnAndRow(2, 1, 'Unid');
        $sheet->getStyleByColumnAndRow(2, 1)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');
        $sheet->getStyleByColumnAndRow(2, 1)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyleByColumnAndRow(2, 1)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->mergeCells('B1:B5');
        $sheet->getStyle("B1:B5")->applyFromArray($border);

        $sheet->setCellValueByColumnAndRow(3, 1, 'Valores Orientadores');
        $sheet->getStyleByColumnAndRow(3, 1)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyleByColumnAndRow(3, 1)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyleByColumnAndRow(3, 1)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');
        $sheet->getStyleByColumnAndRow(3, 1)->applyFromArray($border);

        $column = "B";
        for ($i = 0; $i < count($guidingParameters); $i++) : $column++;
        endfor;

        foreach (range("C", $column) as $columnID) :
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
            $sheet->getStyle($columnID . "1")->applyFromArray($border);
        endforeach;

        if (count($guidingParameters) > 1) $sheet->mergeCells('C1:' . $column . '1');

        $column = "C";
        /* PARAMETOS ORIENTADORES */
        for ($i = 0; $i < count($guidingParameters); $i++) {
            $sheet->setCellValueByColumnAndRow((3 + $i), 2, $guidingParameters[$i]->environmental_guiding_parameter_id);
            $sheet->getStyleByColumnAndRow((3 + $i), 2)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyleByColumnAndRow((3 + $i), 2)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyleByColumnAndRow((3 + $i), 2)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Str::replace("#", "", $colors[$i]));

            foreach (range($column . "2", $column . "2") as $columnID) : $sheet->getColumnDimension($columnID)->setAutoSize(true);
            endforeach;

            $spreadsheet->getActiveSheet()->mergeCells($column . "2:" . $column . "5");

            $sheet->getStyleByColumnAndRow((3 + $i), 2)->applyFromArray($border);
            $sheet->getStyleByColumnAndRow((3 + $i), 3)->applyFromArray($border);
            $sheet->getStyleByColumnAndRow((3 + $i), 4)->applyFromArray($border);
            $sheet->getStyleByColumnAndRow((3 + $i), 5)->applyFromArray($border);

            $column++;
        }

        /* PONTOS */
        $analysisResult = $campaign->analysisResults()->groupBy('samplename')->get();
        for ($i = 0; $i < count($analysisResult); $i++) {
            $sheet->setCellValueByColumnAndRow(2 + count($guidingParameters) + 1  + $i, 1, $analysisResult[$i]->samplename);
            $sheet->setCellValueByColumnAndRow(2 + count($guidingParameters) + 1  + $i, 2, $analysisResult[$i]->projectPointMatrix->date_collection->format("d/m/Y"));
            $sheet->setCellValueByColumnAndRow(2 + count($guidingParameters) + 1  + $i, 3, $analysisResult[$i]->projectPointMatrix->date_collection->format("H:i"));
            $sheet->setCellValueByColumnAndRow(2 + count($guidingParameters) + 1  + $i, 4, $analysisResult[$i]->batch);
            $sheet->setCellValueByColumnAndRow(2 + count($guidingParameters) + 1  + $i, 5, $analysisResult[$i]->labsampid);

            for ($j = 1; $j <= 5; $j++) {
                $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $i, $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $i, $j)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $i, $j)->applyFromArray($border);
            }

            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $i, 1)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');
            $sheet->getColumnDimensionByColumn(2 + count($guidingParameters) + 1  + $i)->setAutoSize(true);
        }

        /* PARAMETROS DE ANÁLISE */
        $projectPointMatrices = $campaign->projectPointMatrices()
            ->with('pointIdentification')
            ->leftJoin('point_identifications', 'point_identifications.id', '=', 'project_point_matrices.point_identification_id')
            ->leftJoin('parameter_analyses', 'parameter_analyses.id', '=', 'project_point_matrices.parameter_analysis_id')
            ->leftJoin('parameter_analysis_groups as t1', 't1.id', '=', 'parameter_analyses.parameter_analysis_group_id')
            ->orderBy('t1.order', 'asc')
            ->orderBy('parameter_analyses.order', 'asc')
            ->select('project_point_matrices.*')
            ->get();

        // dd($projectPointMatrices);



        $row = 6;
        $groupParameterAnalysis = [];
        $parameterAnalysis = [];

        for ($i = 0; $i < count($projectPointMatrices); $i++) {
            if ($i == 0) {
                if ($projectPointMatrices[$i]->parameterAnalysis->parameterAnalysisGroup) {
                    $parents = $this->getParameterAnalysisGroup($projectPointMatrices[$i]->parameterAnalysis);
                    for ($j = count($parents) - 1; $j >= 0; $j--) {
                        $groupParameterAnalysis[] = $parents[$j]->name;
                        $sheet->setCellValueByColumnAndRow(1, $row, $parents[$j]->name);
                        $sheet->getStyleByColumnAndRow(1, $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');
                        $sheet->getStyle("A" . $row . ":" . $column . $row)->applyFromArray($border);
                        $spreadsheet->getActiveSheet()->mergeCellsByColumnAndRow(1, $row, 3 + count($guidingParameters) + count($analysisResult) - 1, $row);
                        $row++;
                    }
                }
            } else {
                if (
                    $projectPointMatrices[$i]->parameterAnalysis->parameter_analysis_group_id !=
                    $projectPointMatrices[$i - 1]->parameterAnalysis->parameter_analysis_group_id
                ) {
                    $parents = $this->getParameterAnalysisGroup($projectPointMatrices[$i]->parameterAnalysis);
                    for ($j = count($parents) - 1; $j >= 0; $j--) {
                        if (in_array($parents[$j]->name, $groupParameterAnalysis)) continue;
                        $groupParameterAnalysis[] = $parents[$j]->name;
                        $sheet->setCellValueByColumnAndRow(1, $row, $parents[$j]->name);
                        $sheet->getStyleByColumnAndRow(1, $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');
                        $sheet->getStyle("A" . $row . ":" . $column . $row)->applyFromArray($border);
                        $spreadsheet->getActiveSheet()->mergeCellsByColumnAndRow(1, $row, 3 + count($guidingParameters) + count($analysisResult) - 1, $row);
                        $row++;
                    }
                }
            }

            if (!in_array($projectPointMatrices[$i]->parameterAnalysis->analysis_parameter_name, $parameterAnalysis) || $i == 0) {
                $sheet->setCellValueByColumnAndRow(1, $row, $projectPointMatrices[$i]->parameterAnalysis->analysis_parameter_name);
                if (isset($projectPointMatrices[$i]->analysisResult[0])) $sheet->setCellValueByColumnAndRow(2,  $row, $projectPointMatrices[$i]->analysisResult[0]->units);

                for ($k = 0; $k < count($guidingParameters); $k++) {
                    $guidingParametersValue = GuidingParameterValue::where("guiding_parameter_id", $guidingParameters[$k]->id)
                        ->where('parameter_analysis_id', $projectPointMatrices[$i]->parameter_analysis_id)
                        ->first();

                    if ($guidingParametersValue) {
                        if ($guidingParametersValue->guidingValue) {
                            if (Str::contains($guidingParametersValue->guidingValue->name, ['Quantitativo'])) {
                                $sheet->setCellValueByColumnAndRow($k + 3, $row, $guidingParametersValue->guiding_legislation_value);
                            }
                            if (Str::contains($guidingParametersValue->guidingValue->name, ['Qualitativo'])) {
                                $sheet->setCellValueByColumnAndRow($k + 3, $row, 'Virtualmente ausente');
                            }
                            if (Str::contains($guidingParametersValue->guidingValue->name, ['Intervalo'])) {
                                $sheet->setCellValueByColumnAndRow(
                                    $k + 3,
                                    $row,
                                    $guidingParametersValue->guiding_legislation_value . ' - ' . $guidingParametersValue->guiding_legislation_value_1
                                );
                            }
                        } else {
                            $sheet->setCellValueByColumnAndRow($k + 3,  $row, $guidingParametersValue->guiding_legislation_value);
                        }
                    } else {
                        $sheet->setCellValueByColumnAndRow($k + 3, $row, "-");
                    }

                    $sheet->getStyleByColumnAndRow($k + 3, $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyleByColumnAndRow($k + 3, $row)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $sheet->getStyleByColumnAndRow($k + 3, $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Str::replace("#", "", $colors[$k]));
                    $sheet->getStyleByColumnAndRow($k + 3, $row)->applyFromArray($border);
                }

                for ($l = 0; $l < count($analysisResult); $l++) {
                    $sheet->setCellValueByColumnAndRow($k + $l + 3, $row, "N/A");
                    $sheet->getStyleByColumnAndRow($k + $l + 3, $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyleByColumnAndRow($k + $l + 3, $row)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $sheet->getStyleByColumnAndRow($k + $l + 3, $row)->applyFromArray($border);
                }

                for ($a = 0; $a < count($analysisResult); $a++) {
                    $value =  $campaign->analysisResults()->with('projectPointMatrix')
                        ->with('projectPointMatrix')
                        ->leftJoin('project_point_matrices', 'analysis_results.project_point_matrix_id', '=', 'project_point_matrices.id')
                        ->leftJoin('point_identifications', 'point_identifications.id', '=', 'project_point_matrices.point_identification_id')
                        ->leftJoin('parameter_analyses', 'parameter_analyses.id', '=', 'project_point_matrices.parameter_analysis_id')
                        ->where("project_point_matrices.parameter_analysis_id", $projectPointMatrices[$i]->parameter_analysis_id)
                        ->where("project_point_matrices.point_identification_id", $analysisResult[$a]->projectPointMatrix->point_identification_id)
                        ->first();

                    if (!$value) continue;

                    $result =  Str::replace(["*J", " [1]"], "", $value->result);
                    $result = Str::replace(["<", "< "], "", $result);
                    $result = Str::replace(",", ".", $result);
                    //$result = $result == '' ? 0 : $result;

                    $rl =  Str::replace(["*J", " [1]"], "", $value->rl);
                    $rl = Str::replace(["<", "< "], "", $rl);
                    $rl = Str::replace(",", ".", $rl);
                    $rl = $rl == '' ? 0 : $rl;

                    $resultValue = $result;
                    $rlValue = $rl;

                    $token = ($resultValue < $rlValue || !$value->result) && !Str::contains($value->resultreal, ["j", "J"]);
                    $bold = $resultValue >= $rlValue && !Str::contains($value->resultreal, ["<", "< "]) && is_numeric($value->resultreal)
                        || (Str::contains($value->resultreal, ["J", "j"]) && !Str::contains($value->resultreal, ["<", "< "]));

                    if (is_numeric($result)) $result = number_format($result, 5, ",", ".");
                    $result = $result == '0,000' ? 'N/A' : $result;
                    $result = $token || Str::contains($value->resultreal, ["<"]) && !Str::contains($result, 'N/A') ? "< $result" : $result;
                    if ($value->resultreal == '') $result = "< " . number_format($rl, 5, ",", ".");

                    if ($value->snote10) {
                        if (Str::contains($value->snote10, ["*j", "*J"])) {
                            $resultSnote10 = Str::replace(["*J", " [1]"], "", $value->snote10);
                            $resultSnote10 = Str::replace(["<", "< "], "", $resultSnote10);
                            $resultSnote10 = Str::replace(",", ".", $resultSnote10);
                            $resultSnote10 = Str::replace(" ", "", $resultSnote10);

                            $bold = !Str::contains($value->snote10, ["<"]);

                            if (is_numeric($resultSnote10)) {
                                if ($value->resultreal != '') {
                                    if ($result >= $resultSnote10) {
                                        $result = number_format($resultSnote10, 5, ",", ".");
                                        $result = Str::contains($value->snote10, ["<"]) ? "< $result" : $result;
                                        $bold = !Str::contains($value->snote10, ["<"]);
                                    }
                                } else {
                                    $result = number_format($resultSnote10, 5, ",", ".");
                                    $result = Str::contains($value->snote10, ["<"]) ? "< $result" : $result;
                                }
                            }
                        }
                    }

                    $sheet->setCellValueByColumnAndRow($k + $a + 3, $row, $result);

                    if ((Str::contains($value->resultreal, ["j", "J"]) && !Str::contains($value->resultreal, ["<"])) || $bold) {
                        $sheet->getStyleByColumnAndRow($k + $a + 3, $row)->getFont()->setBold(true);
                    }

                    if ($value->anadate && $value->prepdate && $value->projectPointMatrix->parameterMethodPreparation) {
                        $anadate = Carbon::createFromFormat('d/m/Y', Str::substr($value->anadate, 0, 10));
                        $prepdate = Carbon::createFromFormat('d/m/Y', Str::substr($value->prepdate, 0, 10));

                        if ($prepdate->diffInDays($anadate) > $value->projectPointMatrix->parameterMethodPreparation->time_preparation) {
                            $styleArray = array(
                                'borders' => array(
                                    'allBorders' => array(
                                        'borderStyle' => Border::BORDER_THIN,
                                        'color' => array('argb' => 'FFFF0000'),
                                    ),
                                ),
                            );
                            $sheet->getStyleByColumnAndRow($k + $a + 3, $row)->applyFromArray($styleArray);
                        }
                    }

                    for ($b = 0; $b < count($guidingParameters); $b++) {
                        $guidingParametersValue = GuidingParameterValue::where("guiding_parameter_id", $guidingParameters[$b]->id)
                            ->where('parameter_analysis_id', $projectPointMatrices[$i]->parameter_analysis_id)
                            ->first();

                        if ($guidingParametersValue) {
                            if (Str::contains($guidingParametersValue->guidingValue->name, ['Quantitativo'])) {
                                if ($resultValue > $guidingParametersValue->guiding_legislation_value) {
                                    $sheet->getStyleByColumnAndRow($k + $a + 3, $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Str::replace("#", "", $colors[$b]));
                                    break;
                                }
                            }
                            if ($guidingParametersValue->guidingValue->name == 'Intervalo') {
                                if (($resultValue < $guidingParametersValue->guiding_legislation_value || $resultValue > $guidingParametersValue->guiding_legislation_value_1)) {
                                    $sheet->getStyleByColumnAndRow($k + $a + 3, $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Str::replace("#", "", $colors[$b]));
                                    break;
                                }
                            }
                            if ($guidingParametersValue->guidingValue->name == 'Intervalo de Aceitação') {
                                if ($resultValue > $rlValue) {
                                    $sheet->getStyleByColumnAndRow($k + $a + 3, $row)->getFont()->setBold(true);
                                    break;
                                }
                            }
                            if (Str::contains($guidingParametersValue->guidingValue->name, ['Qualitativo'])) {
                                if (is_numeric($resultValue)) {
                                    if ($resultValue >= $rlValue && !Str::contains($value->resultreal, ["<", "< "])) {
                                        $sheet->getStyleByColumnAndRow($k + $a + 3, $row)->getFont()->setBold(true);
                                        $sheet->getStyleByColumnAndRow($k + $a + 3, $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Str::replace("#", "", $colors[$b]));
                                        break;
                                    }
                                } else {
                                    if ($value->resultreal == 'Presente' || $value->resultreal == 'Presença') {
                                        $sheet->getStyleByColumnAndRow($k + $a + 3, $row)->getFont()->setBold(true);
                                        $sheet->getStyleByColumnAndRow($k + $a + 3, $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Str::replace("#", "", $colors[$b]));
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }

                $sheet->getStyleByColumnAndRow(1, $row)->applyFromArray($border);
                $sheet->getStyleByColumnAndRow(2, $row)->applyFromArray($border);
                $sheet->getColumnDimensionByColumn(1, $row)->setAutoSize(true);
                $sheet->getColumnDimensionByColumn(2, $row)->setAutoSize(true);

                $parameterAnalysis[] = $projectPointMatrices[$i]->parameterAnalysis->analysis_parameter_name;
                $row++;
            }
        }


        $writer = new Xls($spreadsheet);

        //$writer->save(tmpfile());

        return response()->streamDownload(function () use ($writer) {
            $writer->save("php://output");
        }, "$project->project_cod.xls");
    }

    /**
     * Import results
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'file' => 'required|mimes:xls,xlsx|max:4096',
                'order' =>  ['required', 'exists:analysis_orders,id'],
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => implode("<br>", $validator->messages()->all()),
                'alert-type' => 'error'
            ], 403);
        }

        $order = AnalysisOrder::findOrFail($request->get('order'));
        $spreadsheet = IOFactory::load($request->file->path());
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        $totalImport = 0;
        $totalRows = count($rows) - 1;
        $imports = [];

        $path = $request->file('file')->store('analises/' . $order->formatted_id);
        $analysisResultFile = AnalysisResultFile::create([
            'analysis_order_id' =>  $order->id,
            'file' => $path,
            'name' => $request->file('file')->getClientOriginalName()
        ]);

        foreach ($rows as $key => $value) {
            if ($key == 0) continue;

            $obj = new stdClass();
            $obj->client = $this->searchCellByValue("client", $rows[0], $order->lab, $value, 0); #$value[0];
            $obj->project = $this->searchCellByValue("project", $rows[0], $order->lab, $value, 1); #$value[1];
            $obj->projectnum = $this->searchCellByValue("projectnum", $rows[0], $order->lab, $value, 2); #$value[2];
            $obj->labname = $this->searchCellByValue("labname", $rows[0], $order->lab, $value, 3); #$value[3];
            $obj->samplename = Str::upper(Str::replace(" ", "", $this->searchCellByValue("samplename", $rows[0], $order->lab, $value, 4))); #$value[4];
            $obj->labsampid = $this->searchCellByValue("labsampid", $rows[0], $order->lab, $value, 5); #$value[5];
            $obj->matrix = $this->searchCellByValue("matrix", $rows[0], $order->lab, $value, 6); #$value[6];
            $obj->rptmatrix = $this->searchCellByValue("rptmatrix", $rows[0], $order->lab, $value, 7); #$value[7];
            $obj->solidmatrix = $this->searchCellByValue("solidmatrix", $rows[0], $order->lab, $value, 8); #$value[8];

            $obj->sampdate = $this->formatDate($this->searchCellByValue("sampdate", $rows[0], $order->lab, $value, 9), $order->lab); #$value[9];
            $obj->prepdate = $this->formatDate($this->searchCellByValue("prepdate", $rows[0], $order->lab, $value, 10), $order->lab); #$value[10];
            $obj->anadate = $this->formatDate($this->searchCellByValue("anadate", $rows[0], $order->lab, $value, 11), $order->lab); #$value[11];

            $obj->batch = $this->searchCellByValue("batch", $rows[0], $order->lab, $value, 12); #$value[12];
            $obj->analysis = $this->searchCellByValue("analysis", $rows[0], $order->lab, $value, 13); #$value[13];
            $obj->anacode = $this->formatDate($this->searchCellByValue("anacode", $rows[0], $order->lab, $value, 14), $order->lab); #$value[14];
            $obj->methodcode = $this->searchCellByValue("methodcode", $rows[0], $order->lab, $value, 15); #$value[15];
            $obj->methodname = $this->searchCellByValue("methodname", $rows[0], $order->lab, $value, 16); #$value[16];
            $obj->description = $this->searchCellByValue("description", $rows[0], $order->lab, $value, 17); #$value[17];
            $obj->prepname = $this->searchCellByValue("prepname", $rows[0], $order->lab, $value, 18); #$value[18];
            $obj->analyte = $this->toReplace($this->searchCellByValue("analyte", $rows[0], $order->lab, $value, 19), $order->lab); #$value[19];
            $obj->analyteorder = $this->searchCellByValue("analyteorder", $rows[0], $order->lab, $value, 20); #$value[20];
            $obj->casnumber = $this->searchCellByValue("casnumber", $rows[0], $order->lab, $value, 21); #$value[21];
            $obj->surrogate = $this->searchCellByValue("surrogate", $rows[0], $order->lab, $value, 22); #$value[22];
            $obj->tic = $this->searchCellByValue("tic", $rows[0], $order->lab, $value, 23); #$value[23];

            $obj->result = $this->searchCellByValue("result", $rows[0], $order->lab, $value, 24); #$value[24];
            $obj->resultreal = $obj->result;

            $obj->dl = $this->searchCellByValue("dl", $rows[0], $order->lab, $value, 25); #$value[25];
            $obj->rl = $this->searchCellByValue("rl", $rows[0], $order->lab, $value, 26); #$value[26];
            $obj->units = $this->toReplace($this->searchCellByValue("units", $rows[0], $order->lab, $value, 27), $order->lab); #$value[27];
            $obj->rptomdl = $this->searchCellByValue("rptomdl", $rows[0], $order->lab, $value, 28); #$value[28];
            $obj->mrlsolids = $this->searchCellByValue("mrlsolids", $rows[0], $order->lab, $value, 29); #$value[29];
            $obj->basis = $this->searchCellByValue("basis", $rows[0], $order->lab, $value, 30); #$value[30];
            $obj->dilution = $this->searchCellByValue("dilution", $rows[0], $order->lab, $value, 31); #$value[31];
            $obj->spikelevel = $this->searchCellByValue("spikelevel", $rows[0], $order->lab, $value, 32); #$value[32];
            $obj->recovery = $this->searchCellByValue("recovery", $rows[0], $order->lab, $value, 33); #$value[33];
            $obj->uppercl = $this->searchCellByValue("uppercl", $rows[0], $order->lab, $value, 34); #$value[34];
            $obj->lowercl = $this->searchCellByValue("lowercl", $rows[0], $order->lab, $value, 35); #$value[35];
            $obj->analyst = $this->searchCellByValue("analyst", $rows[0], $order->lab, $value, 36); #$value[36];
            $obj->psolids = $this->searchCellByValue("psolids", $rows[0], $order->lab, $value, 37); #$value[37];
            $obj->lnote = $this->searchCellByValue("lnote", $rows[0], $order->lab, $value, 38); #$value[38];
            $obj->anote = $this->searchCellByValue("anote", $rows[0], $order->lab, $value, 39); #$value[39];
            $obj->latitude = $this->searchCellByValue("latitude", $rows[0], $order->lab, $value, 40); #$value[40];
            $obj->longitude = $this->searchCellByValue("longitude", $rows[0], $order->lab, $value, 41); #$value[41];
            $obj->scomment = $this->searchCellByValue("scomment", $rows[0], $order->lab, $value, 42); #$value[42];
            $obj->snote1 = $this->searchCellByValue("snote1", $rows[0], $order->lab, $value, 43); #$value[43];
            $obj->snote2 = $this->searchCellByValue("snote2", $rows[0], $order->lab, $value, 44); #$value[44];
            $obj->snote3 = $this->searchCellByValue("snote3", $rows[0], $order->lab, $value, 45); #$value[45];
            $obj->snote4 = $this->searchCellByValue("snote4", $rows[0], $order->lab, $value, 46); #$value[46];
            $obj->snote5 = $this->searchCellByValue("snote5", $rows[0], $order->lab, $value, 47); #$value[47];
            $obj->snote6 = $this->searchCellByValue("snote6", $rows[0], $order->lab, $value, 48); #$value[48];
            $obj->snote7 = $this->searchCellByValue("snote7", $rows[0], $order->lab, $value, 49); #$value[49];
            $obj->snote8 = $this->searchCellByValue("snote8", $rows[0], $order->lab, $value, 50); #$value[50];
            $obj->snote9 = $this->searchCellByValue("snote9", $rows[0], $order->lab, $value, 51); #$value[51];
            $obj->snote10 = $this->searchCellByValue("snote10", $rows[0], $order->lab, $value, 52); #$value[52];

            $tokenResult = Str::contains($obj->result, "<");
            $tokenDl = Str::contains($obj->dl, "<");
            $tokenRl = Str::contains($obj->rl, "<");

            $result =  Str::replace(["*J", " [1]"], "", $obj->result);
            $result = Str::replace(["<", "< ", " "], "", $result);
            $result = Str::replace([","], ".", $result);

            $dl =  Str::replace(["*J", " [1]"], "", $obj->dl);
            $dl = Str::replace(["<", "< ", " "], "", $dl);
            $dl = Str::replace([","], ".", $dl);

            $rl =  Str::replace(["*J", " [1]"], "", $obj->rl);
            $rl = Str::replace(["<", "< ", " "], "", $rl);
            $rl = Str::replace([","], ".", $rl);

            $projectPointMatrices = $order->projectPointMatrices()
                ->whereHas("project", function ($q) use ($obj) {
                    $q->where(DB::raw("replace(project_cod, ' ', '')"), Str::of(Str::replace(' ', '', $obj->project))->trim());
                })
                ->whereHas('parameterAnalysis', function ($q) use ($obj) {
                    $q->where(DB::raw("replace(parameter_analyses.analysis_parameter_name, ' ', '')"), Str::of(Str::replace(' ', '', $obj->analyte))->trim());
                })->whereHas('pointIdentification', function ($q) use ($obj) {
                    $q->where(DB::raw("LOWER(replace(point_identifications.identification, ' ', ''))"), Str::lower(Str::of(Str::replace(' ', '',  $obj->samplename))->trim()));
                })->whereHas('analysisMatrix', function ($q) use ($obj) {
                    $q->where(DB::raw("replace(analysis_matrices.name, ' ', '')"), Str::of(Str::replace(' ', '', $obj->matrix))->trim());
                })
                ->first();

            if (!$projectPointMatrices) {
                $obj->status = "not_found";
                $imports[] = $obj;
                continue;
            }

            $obj->status = "found";
            $imports[] = $obj;

            $guidingParameterOrders = [];

            if (is_array($projectPointMatrices->project->guiding_parameter_order)) {
                $guidingParameterOrders = $projectPointMatrices->project->guiding_parameter_order;
            } else {
                $guidingParameterOrders = explode(",", $projectPointMatrices->project->guiding_parameter_order);
            }

            foreach ($projectPointMatrices->guidingParameters()->whereIn('guiding_parameter_id', $guidingParameterOrders)->get() as $item) {

                $item2 = $item
                    ->guidingParameterValues()
                    ->where('parameter_analysis_id', $projectPointMatrices->parameter_analysis_id)
                    ->where('analysis_matrix_id', $projectPointMatrices->analysis_matrix_id)
                    ->where('guiding_parameter_id',  $item->id)
                    ->first();

                if ($item2) {

                    if (
                        $item2->parameter_analysis_id == $projectPointMatrices->parameterAnalysis->id &&
                        $item2->unityLegislation->unity_cod !=  $obj->units && $item2->guidingValue->name != 'Qualitativo'
                    ) {
                        if (is_numeric($result)) $obj->result = $result * $item2->unityLegislation->conversion_amount;
                        if (is_numeric($dl)) $obj->dl = $dl * $item2->unityLegislation->conversion_amount;
                        if (is_numeric($rl)) $obj->rl = $rl * $item2->unityLegislation->conversion_amount;

                        if ($tokenResult) $obj->result = "< " . $obj->result;
                        if ($tokenDl) $obj->dl = "< " . $obj->dl;
                        if ($tokenRl) $obj->rl = "< " . $obj->rl;

                        $obj->units = $item2->unityLegislation->unity_cod;
                    }
                }
            }

            if (($obj->units == 'μg/kg' || $obj->units == 'µg/kg') && !$item2 && $projectPointMatrices->analysisMatrix->name == 'Solo') {
                if (is_numeric($result)) $obj->result = $result / 1000;
                if (is_numeric($dl)) $obj->dl = $dl / 1000;
                if (is_numeric($rl)) $obj->rl = $rl / 1000;

                if ($tokenResult) $obj->result = "< " . $obj->result;
                if ($tokenDl) $obj->dl = "< " . $obj->dl;
                if ($tokenRl) $obj->rl = "< " . $obj->rl;

                $obj->units = 'mg/kg';
            }

            if (Str::contains($obj->resultreal, ["J", "j"])) {
                $r2 =  Str::replace(["*J", " [1]"], "", $obj->result);
                $r2 = Str::replace(["<", "< ", " "], "", $r2);
                $r2 = Str::replace([","], ".", $r2);
                $obj->result = $r2;
            }

            if ($obj->project && $obj->samplename) {

                $analysisResult = AnalysisResult::firstOrCreate([
                    'project_point_matrix_id' => $projectPointMatrices->id,
                    'analysis_order_id' => $order->id
                ]);

                $analysisResult->update([
                    'client' => $obj->client,
                    'project' => $obj->project,
                    'projectnum' => $obj->projectnum,
                    'labname' => $obj->labname,
                    'samplename' => $obj->samplename,
                    'labsampid' => $obj->labsampid,
                    'matrix' => $obj->matrix,
                    'rptmatrix' => $obj->rptmatrix,
                    'solidmatrix' => $obj->solidmatrix,
                    'sampdate' => $obj->sampdate,
                    'prepdate' => $obj->prepdate,
                    'anadate' => $obj->anadate,
                    'batch' => $obj->batch,
                    'analysis' => $obj->analysis,
                    'anacode' => $obj->anacode,
                    'methodcode' => $obj->methodcode,
                    'methodname' => $obj->methodname,
                    'description' => $obj->description,
                    'prepname' => $obj->prepname,
                    'analyte' => $obj->analyte,
                    'analyteorder' => $obj->analyteorder,
                    'casnumber' => $obj->casnumber,
                    'surrogate' => $obj->surrogate,
                    'tic' => $obj->tic,

                    /** CONVERSÃO */
                    'result' => $obj->result,
                    'dl' => $obj->dl,
                    'rl' => $obj->rl,
                    'units' => $obj->units,
                    /*******/

                    'rptomdl' => $obj->rptomdl,
                    'mrlsolids' => $obj->mrlsolids,
                    'basis' => $obj->basis,
                    'dilution' => $obj->dilution,
                    'spikelevel' => $obj->spikelevel,
                    'recovery' => $obj->recovery,
                    'uppercl' => $obj->uppercl,
                    'lowercl' => $obj->lowercl,
                    'analyst' => $obj->analyst,
                    'psolids' => $obj->psolids,
                    'lnote' => $obj->lnote,
                    'anote' => $obj->anote,
                    'latitude' => $obj->latitude,
                    'longitude' => $obj->longitude,
                    'scomment' => $obj->scomment,
                    'snote1' => $obj->snote1,
                    'snote2' => $obj->snote2,
                    'snote3' => $obj->snote3,
                    'snote4' => $obj->snote4,
                    'snote5' => $obj->snote5,
                    'snote6' => $obj->snote6,
                    'snote7' => $obj->snote7,
                    'snote8' => $obj->snote8,
                    'snote9' => $obj->snote9,
                    'snote10' => $obj->snote10,
                    'resultreal' => $obj->resultreal,
                ]);

                $totalImport++;
            }
        }

        $projectPointMatrices = $order->projectPointMatrices;
        $samplename = null;
        $sampdate = null;
        $labsampid = null;
        $units = null;

        try {
            foreach ($projectPointMatrices as $key => $value) {
                if (count($value->calculationParameters) > 0) {


                    foreach ($value->calculationParameters as $calculation) {
                        if ($calculation->parameterAnalysis->parameter_analysis_group_id == $value->parameterAnalysis->parameter_analysis_group_id)  $formula = $calculation->formula;
                    }

                    $re = '/{(.*?)}/m';
                    preg_match_all($re, $formula, $matches, PREG_SET_ORDER, 0);
                    $zero = true;
                    $max = 0;
                    $maxConvert = null;
                    $isToken = false;
                    $guidingParameterValue = null;

                    foreach ($matches as $key2 => $value2) {
                        $result = explode("&", $value2[1]);

                        $projectPointMatrix = $result[1] ? $order->projectPointMatrices()
                            ->whereHas('parameterAnalysis', function ($q) use ($result) {
                                $q->where('parameter_analyses.analysis_parameter_name', $result[0])
                                    ->where('parameter_analyses.cas_rn', $result[1])
                                    ->whereHas('parameterAnalysisGroup', function ($q) use ($result) {
                                        $q->where('name', $result[2]);
                                    });
                            })
                            ->where('point_identification_id', $value->point_identification_id)
                            ->first() :
                            $order->projectPointMatrices()
                            ->whereHas('parameterAnalysis', function ($q) use ($result) {
                                $q->where('parameter_analyses.analysis_parameter_name', $result[0])
                                    ->whereNull('parameter_analyses.cas_rn')
                                    ->whereHas('parameterAnalysisGroup', function ($q) use ($result) {
                                        $q->where('name', $result[2]);
                                    });
                            })
                            ->where('point_identification_id', $value->point_identification_id)
                            ->first();

                        if ($projectPointMatrix) {

                            $analysisResult = AnalysisResult::where("project_point_matrix_id", $projectPointMatrix->id)->first();

                            if ($analysisResult) {

                                $guidingParameterValue = GuidingParameterValue::where('parameter_analysis_id', $value->parameter_analysis_id)
                                    ->where('analysis_matrix_id', $value->analysis_matrix_id)
                                    ->where('guiding_parameter_id',  explode(",", $value->project->guiding_parameter_order)[0])
                                    ->first();

                                $sampdate = $analysisResult->sampdate;
                                $samplename = $analysisResult->samplename;
                                $labsampid = $analysisResult->labsampid;
                                $units = $analysisResult->units;

                                $r = (float)Str::replace(["*J", " [1]", "< ", "<"],  "", $analysisResult->result ? $analysisResult->result : $analysisResult->rl);
                                $rl = (float)Str::replace(["*J", " [1]", "< ", "<"],  "", $analysisResult->rl);

                                if ($guidingParameterValue) {
                                    if ($guidingParameterValue->unityLegislation->unity_cod != $analysisResult->units) {
                                        $r *= $guidingParameterValue->unityLegislation->conversion_amount;
                                        $rl *= $guidingParameterValue->unityLegislation->conversion_amount;
                                        $maxConvert = $guidingParameterValue->unityLegislation->conversion_amount;
                                    }
                                }

                                $max =  $r > $max ? $r : $max;

                                $zero = Str::contains($analysisResult->result, "<") || !$analysisResult->result || $rl > $r;
                                $isToken = !$analysisResult->result || $rl > $r || Str::contains($analysisResult->result, "<");

                                if ($zero == true) {
                                    $formula = Str::replace($value2[0],  0, $formula);
                                } else {
                                    $formula = Str::replace($value2[0],  $r ? $r : $rl, $formula);
                                }
                            }
                        }
                    }

                    //if( $value->parameterAnalysis->analysis_parameter_name == 'Alifático (C8-C16)') dd($formula);

                    $token = Str::contains($formula, "<") || $isToken  ? "<" : "";

                    if (!$zero) {
                        $formula = Str::replace(["*J", " [1]", "< ", "<"],  "", $formula);
                        $formula = Str::replace([","],  ".", $formula);
                        $stringCalc = new StringCalc();

                        $result = "$token " . $stringCalc->calculate($formula);
                    } else {

                        if ($guidingParameterValue) {
                            if ($guidingParameterValue->unityLegislation->unity_cod != $analysisResult->units) $max *= $maxConvert;
                        }

                        $result = "$token " . $max;
                    }

                    if ($guidingParameterValue) {
                        if (
                            $guidingParameterValue->parameter_analysis_id == $value->parameterAnalysis->id &&
                            $guidingParameterValue->unityLegislation->unity_cod !=  $analysisResult->units
                        ) {
                            $units = $guidingParameterValue->unityLegislation->unity_cod;
                        }
                    }

                    if ($samplename) {
                        $analysisResult = AnalysisResult::firstOrCreate([
                            'project_point_matrix_id' => $value->id,
                            'analysis_order_id' => $order->id
                        ]);

                        $analysisResult->update([
                            'result' => $result,
                            'labsampid' => $labsampid,
                            'sampdate' => $sampdate,
                            'samplename' => $samplename,
                            'units' => $units
                        ]);
                    }
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        return response()->json([
            'result' => view('analysis-order.import-result-modal', compact('totalImport', 'totalRows', 'imports'))->render(),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param string $value
     * @param array $row
     * @param Lab $lab
     * @param array $value
     * @param int $original
     * @return string
     */
    private function searchCellByValue($search, $row, $lab, $ref, $original)
    {
        $replaces = $lab->replaces()->where('to', $search)->get();
        foreach ($replaces as $key => $replace) {
            $index = -1;
            if ($replace) {
                foreach ($row as $key => $value) {
                    if ($replace->from == $value) {
                        $index = $key;
                        break;
                    }
                }
                if ($index != -1) return $ref[$index];
            }
        }

        return isset($ref[$original]) ? $ref[$original] : null;
    }

    /**
     * @param string $value
     * @param Lab $lab
     * @return string
     */
    private function toReplace($value, $lab)
    {
        $replace = $lab->replaces->where('from', $value)->first();
        return $replace ? $replace->to : $value;
    }

    /**
     * @param string $value
     * @param Lab $lab
     * @return string
     */
    private function formatDate($value, $lab)
    {
        $formats = [
            'Y/m/d h:i',
            'm/Y/d h:i',
            'm/d/Y h:i',
            'd/m/Y h:i',
            'Y/m/d',
            'm/Y/d',
            'd/m/Y',
            'm/j/Y'
        ];

        foreach ($formats as $format) {
            $replace = $lab->replaces->where('from', $format)->first();
            if ($replace) {
                try {
                    return Carbon::createFromFormat($format, $value)->format($replace->to);
                } catch (\Exception $e) {
                    return $value;
                }
            }
        }

        return $value;
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
        if (!$analysisResult) {
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
        if (!$analysisResult) {
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
