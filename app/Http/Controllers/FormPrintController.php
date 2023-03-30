<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Nette\Utils\Image;
use App\Models\FieldType;
use App\Models\FormPrint;
use App\Models\FormValue;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class FormPrintController extends Controller
{
    /**
     * Print Form
     */
    public function print($id)
    {
        $formValue = FormValue::findOrFail($id);
        $formPrint = new FormPrint($formValue, false);

        if(isset($formPrint->formValue->values['samples'])) {
            $values = $formPrint->formValue->values;
            $samples = $values['samples'];
            $coordinates = $values['coordinates'];
            $samples = $formValue->sortSamples('collect');
            $coordinates = $formValue->sortCoordinates();

            $values['samples'] = $samples;
            $values['coordinates'] = $coordinates;
            $formPrint->formValue->values = $values;
        }

        $html = view('form-values.print.index', compact('formPrint'))->render();

        return response()->stream(function () use ($formValue, $html) {

            $dompdf = new Dompdf(array('tempDir' => '/srv/www/xyz/tmp'));
            $dompdf->setPaper('A4');
            $dompdf->loadHtml($html);

            $dompdf->render();

            $canvas = $dompdf->get_canvas();
            $canvas->page_text(280, 820, "{PAGE_NUM} de {PAGE_COUNT}", null, 8, array(0, 0, 0));

            $fileName = $formValue->values['project_id'];
            $dompdf->stream("$fileName.pdf", array("Attachment" => false));
        }, 200);
    }

    /**
     * Print Form
     */
    public function signer(Request $request, $id)
    {
        $formValue = FormValue::findOrFail($id);
        $formPrint = new FormPrint($formValue, true);

        if (
            !isset($formValue->values["samples"]) || !isset($formValue->values["coordinates"]) ||
            !isset($formValue->values["additional_info"]) || !isset($formValue->values["approval_text"]) ||
            $formValue->values["additional_info"] == '' || $formValue->values["approval_text"] == ''
        ) {
            $resp = [
                "message" => __("Laudo não possuí todos dados preenchidos!"),
                "alert-type" => "error",
            ];
            return redirect()->route('fields.form-values.index')->with($resp);
        }

        if ($formValue->signed && !$request->has('rev_id')) {
            $resp = [
                "message" => __("Laudo não pode ser assiando sem uma revisão!"),
                "alert-type" => "error",
            ];
            return redirect()->route('fields.form-values.index')->with($resp);
        }

        $formValue->signed = true;

        $formValue->save();

        $html = view('form-values.print.index', compact('formPrint'))->render();

        return response()->stream(function () use ($formValue, $html) {

            $dompdf = new Dompdf(array('tempDir' => '/srv/www/xyz/tmp'));
            $dompdf->setPaper('A4');
            $dompdf->loadHtml($html);

            $dompdf->render();

            $canvas = $dompdf->get_canvas();
            $canvas->page_text(280, 820, "{PAGE_NUM} de {PAGE_COUNT}", null, 8, array(0, 0, 0));

            $fileName = $formValue->values['project_id'];
            $dompdf->stream("$fileName.pdf", array("Attachment" => false));
        }, 200);
    }

    private function setTitleSheet($title, $sheet, $formValue, $titleDefaultStyle, $boldDefaultStyle,
                                   $normalDefaultStyle, $bold10DefaultStyle, $normal10DefaultStyle, $borderGray)
    {
        $sheet->setCellValueByColumnAndRow(2, 2, $title);
        $sheet->getStyleByColumnAndRow(2, 2, 13, 2)->applyFromArray($titleDefaultStyle);
        $sheet->mergeCellsByColumnAndRow(2, 2, 13, 2);

        $sheet->setCellValueByColumnAndRow(2, 3, 'LABORATÓRIO CPEA');
        $sheet->getStyleByColumnAndRow(2, 3, 3, 4)->applyFromArray($boldDefaultStyle);
        $sheet->mergeCellsByColumnAndRow(2, 3, 3, 4);
        $sheet->getColumnDimensionByColumn(2)->setWidth(23.86);

        $sheet->setCellValueByColumnAndRow(4, 3, 'Identificação');
        $sheet->getStyleByColumnAndRow(4, 3, 7, 3)->applyFromArray($boldDefaultStyle);
        $sheet->mergeCellsByColumnAndRow(4, 3, 7, 3);

        $sheet->setCellValueByColumnAndRow(4, 4, $formValue->form->name);
        $sheet->getStyleByColumnAndRow(4, 4, 7, 4)->applyFromArray($normalDefaultStyle);
        $sheet->mergeCellsByColumnAndRow(4, 4, 7, 4);

        $sheet->setCellValueByColumnAndRow(8, 3, 'Referência');
        $sheet->getStyleByColumnAndRow(8, 3, 11, 3)->applyFromArray($boldDefaultStyle);
        $sheet->mergeCellsByColumnAndRow(8, 3, 11, 3);

        $sheet->setCellValueByColumnAndRow(8, 4, $formValue->form->ref);
        $sheet->getStyleByColumnAndRow(8, 4, 11, 4)->applyFromArray($normalDefaultStyle);
        $sheet->mergeCellsByColumnAndRow(8, 4, 11, 4);

        $sheet->setCellValueByColumnAndRow(12, 3, 'Versão');
        $sheet->getStyleByColumnAndRow(12, 3)->applyFromArray($boldDefaultStyle);

        $sheet->setCellValueByColumnAndRow(12, 4, $formValue->form->version);
        $sheet->getStyleByColumnAndRow(12, 4)->applyFromArray($normalDefaultStyle);

        $sheet->setCellValueByColumnAndRow(13, 3, 'Publicação');
        $sheet->getStyleByColumnAndRow(13, 3)->applyFromArray($boldDefaultStyle);
        $sheet->getColumnDimensionByColumn(13)->setAutoSize(true);

        $sheet->setCellValueByColumnAndRow(13, 4, $formValue->form->published_at ? $formValue->form->published_at->format('d/m/Y') : null);
        $sheet->getStyleByColumnAndRow(13, 4)->applyFromArray($normalDefaultStyle);

        $sheet->getStyleByColumnAndRow(14, 2, 14, 4)->applyFromArray($boldDefaultStyle);
        $sheet->mergeCellsByColumnAndRow(14, 2, 14, 4);
        $sheet->getColumnDimensionByColumn(14)->setWidth(15);

        $sheet->setCellValueByColumnAndRow(2, 7, 'Laboratório');
        $sheet->getStyleByColumnAndRow(2, 7)->applyFromArray($bold10DefaultStyle);

        $sheet->setCellValueByColumnAndRow(3, 7, 'CPEA');
        $sheet->getStyleByColumnAndRow(3, 7)->applyFromArray($normal10DefaultStyle);

        $sheet->setCellValueByColumnAndRow(2, 8, 'Projeto');
        $sheet->getStyleByColumnAndRow(2, 8)->applyFromArray($bold10DefaultStyle);

        $sheet->setCellValueByColumnAndRow(3, 8, $formValue->values['project_id']);
        $sheet->getStyleByColumnAndRow(3, 8)->applyFromArray($normal10DefaultStyle);
        $sheet->getColumnDimensionByColumn(3)->setAutoSize(true);

        $sheet->setCellValueByColumnAndRow(2, 9, 'Matriz');
        $sheet->getStyleByColumnAndRow(2, 9)->applyFromArray($bold10DefaultStyle);

        $matrix = null;
        if(isset($formValue->values['matrix'])) :
            $matrix = FieldType::find($formValue->values['matrix']);
        endif;
        if($matrix) :
            $matrix = $matrix->report_name ? $matrix->report_name : $matrix->name;
        endif;

        $sheet->setCellValueByColumnAndRow(3, 9, $matrix);
        $sheet->getStyleByColumnAndRow(3, 9)->applyFromArray($normal10DefaultStyle);

        $sheet->getStyleByColumnAndRow(2, 7, 3, 9)->applyFromArray($borderGray);

        $drawing = new Drawing();
        $drawing->setName('logo');
        $drawing->setDescription('logo');
        $drawing->setPath(public_path() . '/img/logo.png');
        $drawing->setResizeProportional(true);
        $drawing->setHeight(100);
        $drawing->setWidth(100);
        $drawing->setCoordinates('N2');
        $drawing->setWorksheet($sheet);
    }

    /**
     * Create XLSX
     */
    public function createSheet($id)
    {
        $formValue = FormValue::findOrFail($id);
        $formPrint = new FormPrint($formValue);

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->setTitle("FINAL_ORDEM");

        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getDefaultStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB("FFF");


        $boldDefaultStyle = [
            'font' => [ 'name' => 'Calibri Light',
                         'size' => 12,
                         'bold' => true,
                         'color' => [ 'rgb' => '000000' ] ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                  'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $bold10DefaultStyle = [
            'font' => [ 'name' => 'Calibri Light',
                         'size' => 10,
                         'bold' => true,
                         'color' => [ 'rgb' => '000000' ] ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                  'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'C0C0C0',
                ],
            ]
        ];

        $normalDefaultStyle = [
            'font' => [ 'name' => 'Calibri Light',
                         'size' => 12,
                         'bold' => false,
                         'color' => [ 'rgb' => '000000' ] ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                  'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $normal10DefaultStyle = [
            'font' => [ 'name' => 'Calibri Light',
                         'size' => 10,
                         'bold' => false,
                         'color' => [ 'rgb' => '000000' ] ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                  'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $titleDefaultStyle = [
            'font' => [ 'name' => 'Calibri Light',
                         'size' => 14,
                         'bold' => true,
                         'color' => [ 'rgb' => '00612F' ] ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                  'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $borderGray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['argb' => '808080'],
                ]
            ]
        ];

        $formPrint->parameters = [
            "conc" => "Oxigênio Dissolvido (mg/L)",
            "sat" => "Oxigênio Dissolvido ( % )",
            "orp" => "ORP (mV) correspondente às condições do meio",
            "eh" => "EH (mV) a 25ºC",
            "ph" => "Potencial hidrogeniônico - pH",
            "conductivity" => "Condutividade (µS/cm)",
            "salinity" => "Salinidade",
            "temperature" => "Temperatura (C°)",
        ];

        $columnsText = [
            "Ponto de coleta",
            "Data da coleta",
            "Hora da coleta",
            "Condições ambientais nas últimas 24hs",
            "",
            "Oxigênio Dissolvido (mg/L)",
            "Oxigênio Dissolvido ( % )",
            "ORP (mV) correspondente às condições do meio",
            "EH (mV) a 25ºC",
            "Potencial hidrogeniônico - pH",
            "Condutividade (µS/cm)",
            "Salinidade",
            "Temperatura (C°)",
        ];

        if(isset($formValue->values['turbidity'])) {
            $formPrint->parameters["ntu"] = "Turbidez (NTU)";
            $columnsText[] = "Turbidez (NTU)";
        }

        $this->setTitleSheet("TABELA DOS PARÂMETROS FÍSICO-QUÍMICOS - FINAL", $sheet, $formValue,
                             $titleDefaultStyle, $boldDefaultStyle, $normalDefaultStyle,
                             $bold10DefaultStyle, $normal10DefaultStyle, $borderGray);

        foreach ( $columnsText as $key => $column) {
            if($column != '') {
                $sheet->setCellValueByColumnAndRow(2, 11 + $key, $column);
                $sheet->getStyleByColumnAndRow(2, 11 + $key, 7, 11 + $key)->applyFromArray($bold10DefaultStyle);
                $sheet->mergeCellsByColumnAndRow(2, 11 + $key, 7, 11 + $key);
            }
        }

        $index = 0;
        foreach ($formValue->values['samples'] as $row => $sample) {
            $sheet->setCellValueByColumnAndRow(8 + $index, 11, $sample['point']);
            $sheet->getStyleByColumnAndRow(8 + $index, 11)->applyFromArray($bold10DefaultStyle);
            $sheet->getStyleByColumnAndRow(8 + $index, 11)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValueByColumnAndRow(8 + $index, 12, Carbon::parse($sample['collect'])->format("d/m/Y"));
            $sheet->getStyleByColumnAndRow(8 + $index, 12)->applyFromArray($normal10DefaultStyle);

            $sheet->setCellValueByColumnAndRow(8 + $index, 13, Carbon::parse($sample['collect'])->format("H:i"));
            $sheet->getStyleByColumnAndRow(8 + $index, 13)->applyFromArray($normal10DefaultStyle);

            $sheet->setCellValueByColumnAndRow(8 + $index, 14, $sample['environment']);
            $sheet->getStyleByColumnAndRow(8 + $index, 14)->applyFromArray($normal10DefaultStyle);

            $indexRow = 0;
            foreach ($formPrint->parameters as $key => $value) {
                if($key == "ntu" || $key == "eh") :
                    $v = isset($sample[$key . "_footer"]) ? $sample[$key . "_footer"] : $formValue->svgs[$row][$key];
                elseif($key == "sat" && (!$formValue->svgs[$row][$key] || $formValue->svgs[$row][$key] == 0)) :
                    $v = '< ' . number_format(4, $formPrint->places[$key], ",");
                elseif(!$formValue->svgs[$row][$key] || $formValue->svgs[$row][$key] == 0 || $formPrint->LQ[$key] > $formValue->svgs[$row][$key]) :
                    $v = '< ' . number_format($formPrint->LQ[$key], $formPrint->places[$key], ",");
                else :
                    $v =  number_format($formPrint->formValue->svgs[$row][$key], $formPrint->places[$key], ",", ".");
                endif;

                if(intval($formPrint->places[$key]) == 0) :
                    $v = Str::replace(".", "", $v);
                endif;

                $sheet->setCellValueByColumnAndRow(8 + $index, 16 + $indexRow, $v);

                $sheet->getStyleByColumnAndRow(8 + $index, 16 + $indexRow)->applyFromArray($normal10DefaultStyle);
                $sheet->getStyleByColumnAndRow(8 + $index, 16 + $indexRow)->getFont()->setBold(true);
                $sheet->getColumnDimensionByColumn(8 + $index)->setAutoSize(true);

                $indexRow++;
            }

            $index++;
        }

        $sheet->getStyleByColumnAndRow(2, 15, 8 + $index - 1, 15)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB("C0C0C0");
        $sheet->getStyleByColumnAndRow(2, 15, 8 + $index - 1, 15)->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ]
            ]
        ]);

        $sheet->getStyleByColumnAndRow(2, 11, 8 + $index - 1, 16 + $indexRow - 1)->applyFromArray($borderGray);

        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(1);
        $spreadsheet->getActiveSheet()->setTitle("pHxEH");
        $spreadsheet->getDefaultStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB("FFF");

        $sheet = $spreadsheet->getActiveSheet();

        $this->setTitleSheet("TABELA pH x EH", $sheet, $formValue,
                            $titleDefaultStyle, $boldDefaultStyle, $normalDefaultStyle,
                            $bold10DefaultStyle, $normal10DefaultStyle, $borderGray);

        $columnsText = [
            "Ponto de coleta",
            "EH (mV) a 25ºC",
            "Potencial hidrogeniônico - pH",
        ];

        foreach ( $columnsText as $key => $column) {
            if($column != '') {
                $sheet->setCellValueByColumnAndRow(2, 11 + $key, $column);
                $sheet->getStyleByColumnAndRow(2, 11 + $key, 7, 11 + $key)->applyFromArray($bold10DefaultStyle);
                $sheet->mergeCellsByColumnAndRow(2, 11 + $key, 7, 11 + $key);
            }
        }

        $index = 0;
        foreach ($formValue->values['samples'] as $row => $sample) {
            $sheet->setCellValueByColumnAndRow(8 + $index, 11, $sample['point']);
            $sheet->getStyleByColumnAndRow(8 + $index, 11)->applyFromArray($bold10DefaultStyle);
            $sheet->getStyleByColumnAndRow(8 + $index, 11)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $indexRow = 0;
            foreach (["eh", "ph"] as $key) {
                if($key == "eh") :
                    $v = isset($sample[$key . "_footer"]) ? $sample[$key . "_footer"] : $formValue->svgs[$row][$key];
                else :
                    $v =  $formPrint->formValue->svgs[$row][$key];
                endif;

                if(($formPrint->LQ[$key] > floatval($v) || !$v) && is_numeric($formPrint->LQ[$key])) :
                    $sheet->setCellValueByColumnAndRow(8 + $index, 12 + $indexRow, '< ' . number_format(floatval($formPrint->LQ[$key]), $formPrint->places[$key], ","));
                else :
                    $sheet->setCellValueByColumnAndRow(8 + $index, 12 + $indexRow, is_numeric($v) ? number_format($v, $formPrint->places[$key], ",") : $v);
                endif;

                $sheet->getStyleByColumnAndRow(8 + $index, 12 + $indexRow)->applyFromArray($normal10DefaultStyle);
                $sheet->getStyleByColumnAndRow(8 + $index, 12 + $indexRow)->getFont()->setBold(true);
                $sheet->getColumnDimensionByColumn(8 + $index)->setAutoSize(true);

                $indexRow++;
            }

            $index++;
        }

        $sheet->getStyleByColumnAndRow(2, 11, 8 + $index - 1, 12 + $indexRow - 1)->applyFromArray($borderGray);


        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(2);
        $spreadsheet->getActiveSheet()->setTitle("Gráf pHxEH");
        $spreadsheet->getDefaultStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB("FFF");

        $sheet = $spreadsheet->getActiveSheet();

        $drawing = new Drawing();
        $drawing->setName('logo');
        $drawing->setDescription('logo');
        $drawing->setPath(storage_path("app/charts/" . $formValue->id . "/chart.png"));
        $drawing->setResizeProportional(true);
        $drawing->setHeight(400);
        $drawing->setWidth(1488);
        $drawing->setCoordinates('B5');
        $drawing->setWorksheet($sheet);

        $writer = new Xls($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
        $writer->save("php://output");
        }, "Final_Ordem_.xls");
    }

    public function uploadChartImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "image" => "required",
            "form_value_id" => ["required", "exists:form_values,id"],
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "message" => implode("<br>", $validator->messages()->all()),
                    "alert-type" => "error",
                ],
                403
            );
        }

        $image = $request->image;
        $image = base64_decode($image);

        if($request->image){


            $img = $request->image;
            $folderPath = "charts/" . $request->get("form_value_id");

            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file = $folderPath . "\chart" . '.'.$image_type;
            Storage::put($file, $image_base64);
        }
    }
}
