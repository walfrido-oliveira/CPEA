<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\FormPrint;
use App\Models\FormValue;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
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

    /**
     * Create XLSX
     */
    public function createSheet($id)
    {
        $formValue = FormValue::findOrFail($id);

        $spreadsheet = new Spreadsheet();
        $spreadsheet->createSheet();
        $sheet = $spreadsheet->getActiveSheet();

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

        $sheet->setCellValueByColumnAndRow(2, 2, 'TABELA DOS PARÂMETROS FÍSICO-QUÍMICOS - FINAL');
        $sheet->getStyleByColumnAndRow(2, 2, 13, 2)->applyFromArray(
            [
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
            ]
        );
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

        $drawing = new Drawing();
        $drawing->setName('logo');
        $drawing->setDescription('logo');
        $drawing->setPath(public_path() . '/img/logo.png');
        $drawing->setResizeProportional(true);
        $drawing->setHeight(100);
        $drawing->setWidth(100);
        $drawing->setCoordinates('N2');
        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        $writer = new Xls($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
        $writer->save("php://output");
        }, "Final_Ordem_.xls");
    }
}
