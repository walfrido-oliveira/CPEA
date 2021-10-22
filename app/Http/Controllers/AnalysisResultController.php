<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AnalysisOrder;
use App\Models\AnalysisResult;
use App\Models\GuidingParameter;
use App\Models\GuidingParameterValue;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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
        $order = AnalysisOrder::findOrFail($id);
        $project = $order->campaign->project;

        if($project->guiding_parameter_order && count(explode(",", $project->guiding_parameter_order)))
        {
            $guidingParameters = [];
            foreach (explode(",", $project->guiding_parameter_order) as $key => $value)
            {
                $guidingParameters[] = GuidingParameter::find($value)->environmental_guiding_parameter_id;
            }
        }

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

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
        $guidingParametersColors = [];
        foreach ($guidingParameters as $key => $value)
        {
            $sheet->setCellValue($column2 . "2", $value);
            $sheet->getStyle($column2 . "2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($column2 . "2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            foreach(range($column2 . "2", $column2 . "2") as $columnID) : $sheet->getColumnDimension($columnID)->setAutoSize(true); endforeach;

            $guidingParametersColors[] = sprintf('%06X', mt_rand(0, 0xFFFFFF));

            $sheet->getStyle($column2 . "2")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($guidingParametersColors[$key]);
            $spreadsheet->getActiveSheet()->mergeCells($column2 . "2:" . $column2 . "4");

            $column2++;
        }

        $column++;
        $projectPointMatrices = $order->projectPointMatrices;
        $pointIdentification = [];
        $dataResults = [];

        foreach ($projectPointMatrices->sortByDesc('point_identification_id') as $key => $point)
        {
            if(!in_array($point->pointIdentification->area . "-" . $point->pointIdentification->identification, $pointIdentification))
            {
                $pointIdentification[] = $point->pointIdentification->area . "-" . $point->pointIdentification->identification;
                if($point->analysisResult()->first())
                {
                    $dataResults[] = [
                        "sampdate" => $point->analysisResult()->first()->sampdate,
                        "labsampid" => $point->analysisResult()->first()->labsampid,
                    ];
                }
            }
        }

        foreach ($pointIdentification as $key => $value)
        {
            $sheet->setCellValueByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 1, $value);
            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 1)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 1)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getColumnDimensionByColumn(2 + count($guidingParameters) + 1  + $key)->setAutoSize(true);
        }

        $key = 0;
        foreach ($dataResults as $index => $value)
        {
            $sheet->setCellValueByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 2, $value['sampdate']->format('d/m/Y'));
            $sheet->setCellValueByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 3, $value['sampdate']->format('h:m:i'));
            $sheet->setCellValueByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 4, $value['labsampid']);

            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 2)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 2)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 3)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 3)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 4)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1  + $key, 4)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getColumnDimensionByColumn(2 + count($guidingParameters) + 1  + $key)->setAutoSize(true);
            $key++;
        }

        $key = 0;
        $column = 0;

        foreach ($projectPointMatrices->sortByDesc('point_identification_id') as $index => $point)
        {
            if($index > 0)
            {
              if ($projectPointMatrices[$index]->parameterAnalysis->parameter_analysis_group_id !=
                  $projectPointMatrices[$index - 1]->parameterAnalysis->parameter_analysis_group_id)
              {
                  $key++;
              }
              if($point->pointIdentification->id != $projectPointMatrices[$index - 1]->pointIdentification->id)
              {
                $column++;
              }
            }

            if($point->analysisResult()->first())
            {
                $sheet->setCellValueByColumnAndRow(2 + count($guidingParameters) + 1, 6 + $key, $point->analysisResult()->first()->result);
                $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1, 6 + $key)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyleByColumnAndRow(2 + count($guidingParameters) + 1, 6 + $key)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            }
            $key++;
        }

        $sheet->setCellValueByColumnAndRow(1, 5, $projectPointMatrices[0]->parameterAnalysis->parameterAnalysisGroup->name);
        $sheet->getStyleByColumnAndRow(1, 5)->getFill() ->setFillType(Fill::FILL_SOLID) ->getStartColor()->setRGB('C0C0C0');
        $sheet->getStyleByColumnAndRow(2, 5)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');
        $key = 0;

        foreach ($projectPointMatrices as $index => $point)
        {
            if($index > 0)
            {
              if ($projectPointMatrices[$index]->parameterAnalysis->parameter_analysis_group_id !=
                  $projectPointMatrices[$index - 1]->parameterAnalysis->parameter_analysis_group_id)
              {
                  $sheet->setCellValueByColumnAndRow(1,  $key + 6, $point->parameterAnalysis->parameterAnalysisGroup->name);
                  $sheet->getStyleByColumnAndRow(1,  $key + 6)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');
                  $sheet->getStyleByColumnAndRow(2,  $key + 6)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C0C0C0');
                  $key++;
              }
            }
            $sheet->setCellValueByColumnAndRow(1, $key + 6, $point->parameterAnalysis->analysis_parameter_name);

            if($point->analysisResult()->first())
            {
                $sheet->setCellValueByColumnAndRow(2,  $key + 6, $point->analysisResult()->first()->units);
                $sheet->getStyleByColumnAndRow(2,  $key + 6)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyleByColumnAndRow(2,  $key + 6)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            }

            foreach (explode(",", $project->guiding_parameter_order) as $key2 => $value)
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
                   $sheet->getStyleByColumnAndRow(3 + $key2,  $key + 6)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                   $sheet->getStyleByColumnAndRow(3 + $key2,  $key + 6)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                   $sheet->getStyleByColumnAndRow(3 + $key2,  $key + 6)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($guidingParametersColors[$key2]);
                }
            }
            $key++;
        }

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

            $order = AnalysisOrder::findOrFail($orderId);
            $projectPointMatrices = $order->projectPointMatrices()
            ->whereHas('parameterAnalysis', function($q) use($value) {
                $q->where('parameter_analyses.cas_rn', $value[21]);
            })->whereHas('pointIdentification', function($q) use($pointIdentifciation) {
                $q->where('point_identifications.area', $pointIdentifciation[0])
                  ->where('point_identifications.identification', $pointIdentifciation[1]);
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
