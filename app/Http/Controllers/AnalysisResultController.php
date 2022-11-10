<?php

namespace App\Http\Controllers;

use stdClass;
use Carbon\Carbon;
use App\Models\Lab;
use Colors\RandomColor;
use App\Models\Campaign;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AnalysisOrder;
use App\Models\AnalysisResult;
use App\Models\GuidingParameter;
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
            foreach ($analysisResult as $key1 => $value) {
                if (!$value->labname) continue;
                $column = 1;
                foreach ($value->getAttributes() as $key2 => $value2) {
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

        $RandomColors = [];
        $guidingParameters = [];
        $guidingParameterOrders = [];

        if (is_array($project->colors) && count($project->colors) > 0) {
            $RandomColors = $project->colors;
        } else {
            $RandomColors = RandomColor::many(30, array('luminosity' => 'light', 'format' => 'hex'));

            while (in_array(["#FFCC99", "#FFFF99", "#DAEEF3"], $RandomColors)) {
                $RandomColors = RandomColor::many(30, array('luminosity' => 'light', 'format' => 'hex'));
            }

            $RandomColors[0] = "#FFCC99";
            $RandomColors[1] = "#FFFF99";
            $RandomColors[2] = "#DAEEF3";
        }

        if ($project->guiding_parameter_order && !is_array($project->guiding_parameter_order)) {
            foreach (explode(",", $project->guiding_parameter_order) as $key => $value) {
                $guidingParameter = GuidingParameter::find($value);
                if ($guidingParameter) {
                    $guidingParameters[] = $guidingParameter->environmental_guiding_parameter_id;
                    $guidingParameterOrders[] = $guidingParameter->id;
                }
            }
        } else {
            foreach ($project->guiding_parameter_order as $key => $value) {
                $guidingParameter = GuidingParameter::find($value);
                if ($guidingParameter) {
                    $guidingParameters[] = $guidingParameter->environmental_guiding_parameter_id;
                    $guidingParameterOrders[] = $guidingParameter->id;
                }
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
        $sheet->setCellValue('A2', 'Data de Coleta');
        $sheet->setCellValue('A3', 'Hora de Coleta');
        $sheet->setCellValue('A4', 'Grupo do Laboratório');
        $sheet->setCellValue('A5', 'Identificação do Laboratório');

        $sheet->getStyle('A1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');

        $sheet->getStyle("A1:A5")->applyFromArray($border);

        foreach (range('A1', 'A5') as $columnID) : $sheet->getColumnDimension($columnID)->setAutoSize(true);
        endforeach;

        $sheet->setCellValue('B1', 'Unid');
        $sheet->getStyle('B1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');
        $sheet->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->mergeCells('B1:B5');

        $sheet->getStyle("B1:B5")->applyFromArray($border);

        $column = "B";

        foreach ($guidingParameters as $key => $value) : $column++;
        endforeach;

        $sheet->setCellValue('C1', 'Valores Orientadores');
        $sheet->getStyle('C1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('C1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');

        $sheet->getStyle("C1")->applyFromArray($border);

        if (count($guidingParameters) > 1) $sheet->mergeCells('C1:' . $column . '1');

        foreach (range($column . "1", $column . "1") as $columnID) : $sheet->getColumnDimension($columnID)->setAutoSize(true);
        endforeach;

        $column2 = "C";
        foreach ($guidingParameters as $key => $value) {
            $sheet->setCellValue($column2 . "2", $value);
            $sheet->getStyle($column2 . "2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($column2 . "2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle($column2 . "2")->applyFromArray($border);

            foreach (range($column2 . "2", $column2 . "2") as $columnID) : $sheet->getColumnDimension($columnID)->setAutoSize(true);
            endforeach;

            $sheet->getStyle($column2 . "2")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Str::replace("#", "", $RandomColors[$key]));
            $spreadsheet->getActiveSheet()->mergeCells($column2 . "2:" . $column2 . "5");

            $sheet->getStyle($column2 . "5")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');
            $sheet->getStyle($column2 . "5")->applyFromArray($border);

            $column2++;
        }

        $projectPointMatrices = $campaign->projectPointMatrices;
        $pointIdentification = [];

        $analysisResult = AnalysisResult::leftJoin('analysis_order_project_point_matrix', 'analysis_order_project_point_matrix.project_point_matrix_id', '=', 'analysis_results.project_point_matrix_id')
            ->leftJoin('analysis_orders',  'analysis_orders.id', 'analysis_order_project_point_matrix.analysis_order_id')
            ->where('analysis_orders.campaign_id', $campaign->id)
            ->groupBy('samplename')->get();

        foreach ($analysisResult as $key => $value) {
            $pointIdentification[] = $value->samplename;

            $sheet->setCellValueByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 1, $value->samplename);
            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 1)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 1)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 1)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');
            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 1)->applyFromArray($border);
            $sheet->getColumnDimensionByColumn(2 + count($guidingParameters) + 1  + $key)->setAutoSize(true);

            $sheet->setCellValueByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 2, $value->projectPointMatrix->date_collection->format("d/m/Y"));
            $sheet->setCellValueByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 3, $value->projectPointMatrix->date_collection->format("H:i"));
            $sheet->setCellValueByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 4, $value->batch);
            $sheet->setCellValueByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 5, $value->labsampid);


            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 2)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 2)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 2)->applyFromArray($border);

            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 3)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 3)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 3)->applyFromArray($border);

            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 4)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 4)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 4)->applyFromArray($border);

            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 5)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 5)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 5)->applyFromArray($border);

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

        if (count($projectPointMatrices) > 0) {
            $sheet->setCellValueByColumnAndRow(1, 6, $projectPointMatrices[0]->parameterAnalysis->parameterAnalysisGroup->name);

            $groupParameterAnalysis[] = $projectPointMatrices[0]->parameterAnalysis->parameterAnalysisGroup->name;

            $sheet->getStyleByColumnAndRow(1, 6)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');
            $sheet->getStyleByColumnAndRow(2, 6)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');

            $sheet->getStyleByColumnAndRow(2, 6)->applyFromArray($border);
            $sheet->getStyleByColumnAndRow(3, 6)->applyFromArray($border);
            $sheet->getStyle("A6")->applyFromArray($border);

            $spreadsheet->getActiveSheet()->mergeCellsByColumnAndRow(1, 6, 3 + count($guidingParameters) + count($analysisResult) - 1, 6);

            foreach ($analysisResult as $analysisIndex => $value) {
                $sheet->getStyleByColumnAndRow(3 + count($guidingParameters) + $analysisIndex, 6)->applyFromArray($border);
            }
        }


        foreach ($projectPointMatrices as $point) {
            if ($index > 0) {
                if (
                    $projectPointMatrices[$index]->parameterAnalysis->parameter_analysis_group_id !=
                    $projectPointMatrices[$index - 1]->parameterAnalysis->parameter_analysis_group_id
                ) {
                    if (!in_array($point->parameterAnalysis->parameterAnalysisGroup->name, $groupParameterAnalysis)) {
                        $sheet->setCellValueByColumnAndRow(1,  $key + 7, $point->parameterAnalysis->parameterAnalysisGroup->name);

                        $groupParameterAnalysis[] = $point->parameterAnalysis->parameterAnalysisGroup->name;

                        $sheet->getStyleByColumnAndRow(1,  $key + 7)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');
                        $sheet->getStyleByColumnAndRow(2,  $key + 7)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');

                        $sheet->getStyleByColumnAndRow(1,  $key + 7)->applyFromArray($border);
                        $sheet->getStyleByColumnAndRow(2,  $key + 7)->applyFromArray($border);
                        $sheet->getStyleByColumnAndRow(3,  $key + 7)->applyFromArray($border);

                        $spreadsheet->getActiveSheet()->mergeCellsByColumnAndRow(1, 7 + $key, 3 + count($guidingParameters) + count($analysisResult) - 1, 7 + $key);

                        foreach ($guidingParameterOrders as $key2 => $value) {
                            $sheet->getStyleByColumnAndRow(2 + ($key2 + 1),  $key + 7)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');
                        }

                        foreach ($analysisResult as $analysisIndex => $value) {
                            $sheet->getStyleByColumnAndRow(3 + count($guidingParameters) + $analysisIndex, $key + 7)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');
                            $sheet->getStyleByColumnAndRow(3 + count($guidingParameters) + $analysisIndex, 7 + $key)->applyFromArray($border);
                        }

                        $key++;
                    }
                }
            }

            if (!in_array($point->parameterAnalysis->analysis_parameter_name, $parameterAnalysis) || $index == 0) {
                $sheet->setCellValueByColumnAndRow(1, $key + 7, $point->parameterAnalysis->analysis_parameter_name);
                $sheet->getStyleByColumnAndRow(1, $key + 7)->applyFromArray($border);

                for ($i = 0; $i < count($guidingParameters); $i++) {
                    $sheet->getStyleByColumnAndRow(4 + $i, $key + 7)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyleByColumnAndRow(4 + $i, $key + 7)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $sheet->getStyleByColumnAndRow(4 + $i, $key + 7)->applyFromArray($border);
                }

                $parameterAnalysis[] = $point->parameterAnalysis->analysis_parameter_name;

                foreach ($guidingParameterOrders as $key2 => $value) {

                    $guidingParametersValue = GuidingParameterValue::where("guiding_parameter_id", $value)
                        ->where('parameter_analysis_id', $point->parameterAnalysis->id)
                        ->first();

                    if ($guidingParametersValue) {
                        if ($guidingParametersValue->guidingValue) {
                            if (Str::contains($guidingParametersValue->guidingValue->name, ['Quantitativo'])) {
                                $sheet->setCellValueByColumnAndRow(3 + $key2,  $key + 7, $guidingParametersValue->guiding_legislation_value);
                            }
                            if (Str::contains($guidingParametersValue->guidingValue->name, ['Qualitativo'])) {
                                $sheet->setCellValueByColumnAndRow(3 + $key2,  $key + 7, 'Virtualmente ausente');
                            }
                            if (Str::contains($guidingParametersValue->guidingValue->name, ['Intervalo'])) {
                                $sheet->setCellValueByColumnAndRow(
                                    3 + $key2,
                                    $key + 7,
                                    $guidingParametersValue->guiding_legislation_value . ' - ' . $guidingParametersValue->guiding_legislation_value_1
                                );
                            }
                        } else {
                            $sheet->setCellValueByColumnAndRow(3 + $key2,  $key + 7, $guidingParametersValue->guiding_legislation_value);
                        }
                    } else {
                        $sheet->setCellValueByColumnAndRow(3 + $key2,  $key + 7, "-");
                    }

                    foreach ($analysisResult as $row => $item) {
                        $sheet->setCellValueByColumnAndRow((3 + $key2) + $row + 1,  $key + 7, 'N/A');
                        $sheet->getStyleByColumnAndRow((3 + $key2) + $row + 1,  $key + 7)->applyFromArray($border);
                        $sheet->getStyleByColumnAndRow((3 + $key2) + $row + 1,  $key + 7)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $sheet->getStyleByColumnAndRow((3 + $key2) + $row + 1,  $key + 7)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    }


                    $sheet->getStyleByColumnAndRow(3 + $key2,  $key + 7)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyleByColumnAndRow(3 + $key2,  $key + 7)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $sheet->getStyleByColumnAndRow(3 + $key2,  $key + 7)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Str::replace("#", "", $RandomColors[$key2]));
                    $sheet->getStyleByColumnAndRow(3 + $key2,  $key + 7)->applyFromArray($border);
                }
                $key++;
            }
            $index++;
        }

        $key = 0;
        $index = 0;
        $groupParameterAnalysis = [];

        $analysisResults = $campaign->analysisResults()
            ->with('projectPointMatrix')
            ->leftJoin('project_point_matrices', 'analysis_results.project_point_matrix_id', '=', 'project_point_matrices.id')
            ->leftJoin('point_identifications', 'point_identifications.id', '=', 'project_point_matrices.point_identification_id')
            ->leftJoin('parameter_analyses', 'parameter_analyses.id', '=', 'project_point_matrices.parameter_analysis_id')
            ->leftJoin('parameter_analysis_groups', 'parameter_analysis_groups.id', '=', 'parameter_analyses.parameter_analysis_group_id')
            ->orderBy('parameter_analysis_groups.order', 'asc')
            ->orderBy('parameter_analyses.analysis_parameter_name', 'asc')
            ->get();

        $column = 0;
        $resultValue = 0;

        foreach ($pointIdentification as $value1) {
            $key = 0;
            $index = 0;

            $groupParameterAnalysis = [];

            if (count($analysisResults) > 0) $groupParameterAnalysis[] = $analysisResults[0]->projectPointMatrix->parameterAnalysis->parameterAnalysisGroup->name;

            foreach ($analysisResults as $value) {
                if (strcasecmp(Str::replace(' ', '', $value->projectPointMatrix->pointIdentification->identification), Str::replace(' ', '', $value1)) != 0) {
                    continue;
                }

                $index = 0;

                while ($sheet->getCellByColumnAndRow(1, 7 + $index) != $value->projectPointMatrix->parameterAnalysis->analysis_parameter_name) {
                    $index++;
                    $sheet->getStyleByColumnAndRow(2,  $index + 7)->applyFromArray($border);
                }

                $sheet->setCellValueByColumnAndRow(2,  $index + 7, $value->units);
                $sheet->getStyleByColumnAndRow(2,  $index + 7)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyleByColumnAndRow(2,  $index + 7)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyleByColumnAndRow(2,  $index + 7)->applyFromArray($border);
                $sheet->getColumnDimensionByColumn(2,  $index + 7)->setAutoSize(true);

                $result =  Str::replace(["*J", " [1]"], "", $value->result);
                $result = Str::replace(["<", "< "], "", $result);
                $result = Str::replace(",", ".", $result);
                $result = $result == '' ? 0 : $result;

                $rl =  Str::replace(["*J", " [1]"], "", $value->rl);
                $rl = Str::replace(["<", "< "], "", $rl);
                $rl = Str::replace(",", ".", $rl);
                $rl = $rl == '' ? 0 : $rl;

                $resultValue = $result;
                $rlValue = $rl;

                $result =  Str::contains($value->result, '*J') ? $result : ($resultValue >= $rlValue ? $resultValue : $rlValue);
                $resultValue = $result;

                $token = $resultValue < $rlValue || !$value->result;
                $bold = $resultValue >= $rlValue && !Str::contains($value->result, ["<", "< "]);

                if (is_numeric($result)) $result = number_format($result, 5, ",", ".");
                $result = $result == '0,000' ? 'N/A' : $result;
                $result = $token || Str::contains($value->result, ["<", "< "]) && !Str::contains($result, 'N/A') ? "< $result" : $result;

                $sheet->setCellValueByColumnAndRow($column + 2 + count($guidingParameters) + 1, 7 + $index, $result);
                $sheet->getStyleByColumnAndRow($column + 2 + count($guidingParameters) + 1, 7 + $index)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyleByColumnAndRow($column + 2 + count($guidingParameters) + 1, 7 + $index)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyleByColumnAndRow($column + 2 + count($guidingParameters) + 1, 7 + $index)->applyFromArray($border);


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
                        $sheet->getStyleByColumnAndRow($column + 2 + count($guidingParameters) + 1, 7 + $index)->applyFromArray($styleArray);
                    }
                }

                foreach ($guidingParameterOrders as $key2 => $value3) {
                    $guidingParametersValue = GuidingParameterValue::where("guiding_parameter_id", $value3)
                        ->where('parameter_analysis_id', $value->projectPointMatrix->parameterAnalysis->id)
                        ->first();

                    if ($guidingParametersValue) {
                        if (Str::contains($guidingParametersValue->guidingValue->name, ['Quantitativo'])) {
                            if ($resultValue > $guidingParametersValue->guiding_legislation_value) {
                                $sheet->getStyleByColumnAndRow($column + 2 + count($guidingParameters) + 1, 7 + $index)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Str::replace("#", "", $RandomColors[$key2]));
                                break;
                            }
                        }
                        if ($guidingParametersValue->guidingValue->name == 'Intervalo') {
                            if (($resultValue < $guidingParametersValue->guiding_legislation_value || $resultValue > $guidingParametersValue->guiding_legislation_value_1)) {
                                $sheet->getStyleByColumnAndRow($column + 2 + count($guidingParameters) + 1, 7 + $index)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Str::replace("#", "", $RandomColors[$key2]));
                                break;
                            }
                        }
                        if ($guidingParametersValue->guidingValue->name == 'Intervalo de Aceitação') {
                            if ($resultValue > $rlValue) {
                                $sheet->getStyleByColumnAndRow($column + 2 + count($guidingParameters) + 1, 7 + $index)->getFont()->setBold(true);
                                break;
                            }
                        }
                        if (Str::contains($guidingParametersValue->guidingValue->name, ['Qualitativo'])) {
                            if (is_numeric($resultValue)) {
                                if ($resultValue > $rlValue) {
                                    $sheet->getStyleByColumnAndRow($column + 2 + count($guidingParameters) + 1, 7 + $index)->getFont()->setBold(true);
                                    $sheet->getStyleByColumnAndRow($column + 2 + count($guidingParameters) + 1, 7 + $index)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Str::replace("#", "", $RandomColors[$key2]));
                                    break;
                                }
                            } else {
                                if ($resultValue == 'Presente' || $resultValue == 'Presença') {
                                    $sheet->getStyleByColumnAndRow($column + 2 + count($guidingParameters) + 1, 7 + $index)->getFont()->setBold(true);
                                    $sheet->getStyleByColumnAndRow($column + 2 + count($guidingParameters) + 1, 7 + $index)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Str::replace("#", "", $RandomColors[$key2]));
                                    break;
                                }
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
        $row = 6;
        $index = 0;
        $groupParameterAnalysis = [];
        $parameterAnalysis = [];

        for ($i = 0; $i < $count; $i++) : $column++;
        endfor;

        $groupParameterAnalysis[] = $projectPointMatrices[0]->parameterAnalysis->parameterAnalysisGroup->name;
        $sheet->mergeCells('A' . $row . ':' . $column . $row);

        foreach ($projectPointMatrices as $point) {
            if ($index > 0) {
                if (
                    $projectPointMatrices[$index]->parameterAnalysis->parameter_analysis_group_id !=
                    $projectPointMatrices[$index - 1]->parameterAnalysis->parameter_analysis_group_id
                ) {
                    if (!in_array($point->parameterAnalysis->parameterAnalysisGroup->name, $groupParameterAnalysis)) {
                        $groupParameterAnalysis[] = $point->parameterAnalysis->parameterAnalysisGroup->name;
                        $row++;
                        $sheet->mergeCells('A' . $row . ':' . $column . $row);
                    }
                }
            }

            if (!in_array($point->parameterAnalysis->analysis_parameter_name, $parameterAnalysis) || $index == 0) {
                $parameterAnalysis[] = $point->parameterAnalysis->analysis_parameter_name;
                $row++;
            }
            $index++;
        }

        $writer = new Xls($spreadsheet);

        $writer->save(tmpfile());

        return response()->streamDownload(function () use ($writer) {
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

            if(is_array($projectPointMatrices->project->guiding_parameter_order)) {
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
                        $item2->unityLegislation->unity_cod !=  $obj->units
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

            if($obj->snote10 && is_numeric($result) && is_numeric($rl)) {
                if($result < $rl) $obj->result = "<" . $obj->snote10;
            }

            if(Str::contains($obj->result, ["*j", "*J", "J", "J"])) {
                $obj->result = Str::replace(["*J", "J"], "", $obj->result);
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
