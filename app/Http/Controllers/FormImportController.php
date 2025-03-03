<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\FormValue;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;

class FormImportController extends Controller
{
    /**
     * Import results
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function importResults(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "file" => "required|mimes:xls,xlsx|max:4096",
            "form_value_id" => ["required", "exists:form_values,id"],
            "sample_index" => ["required"],
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

        $inputs = $request->all();

        $formValue = FormValue::findOrFail($inputs["form_value_id"]);

        $spreadsheet = IOFactory::load($request->file->path());
        $spreadsheet->setActiveSheetIndex(1);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        $samples = $formValue->values;
        $microseccondInMille = 1000;
        $micrometerInMetre = 1000000;
        $plusColumn = Str::contains($rows[0][4], 'ORP[mV]') ? 0 : 1;
        $size = count($rows);

        foreach ($rows as $key => $value) {
            if ($key == 0) continue;

            if($formValue->form->name == "RT-LAB-020-1" && ($size == 4 || $size == 5) && $key > 4) break;

            if (isset($value[1])) {
                $samples["samples"][$inputs["sample_index"]]["results"][$key - 1]["time"] = $value[1];
            }
            if (isset($value[2])) {
                $samples["samples"][$inputs["sample_index"]]["results"][$key - 1]["temperature"] = floatval($value[2]);
            }
            if (isset($value[3])) {
                $samples["samples"][$inputs["sample_index"]]["results"][$key - 1]["ph"] = floatval($value[3]);
            }
            if (isset($value[4])) {
                $samples["samples"][$inputs["sample_index"]]["results"][$key - 1]["orp"] = floatval($value[4]);
            }
            if (isset($value[5 + $plusColumn])) {
                $samples["samples"][$inputs["sample_index"]]["results"][$key - 1]["conductivity"] = Str::contains($rows[0][5 + $plusColumn], 'EC[µS/cm]') ? floatval($value[5 + $plusColumn]) : floatval($value[5 + $plusColumn]) * $microseccondInMille;
            }
            if (isset($value[6 + $plusColumn])) {
                $samples["samples"][$inputs["sample_index"]]["results"][$key - 1]["salinity"] = Str::contains($rows[0][5 + $plusColumn], 'EC[µS/cm]') ? floatval($value[6 + $plusColumn]) : floatval($value[6 + $plusColumn]) * $micrometerInMetre;
            }
            if (isset($value[7 + $plusColumn])) {
                $samples["samples"][$inputs["sample_index"]]["results"][$key - 1]["psi"] = floatval($value[7 + $plusColumn]);
            }
            if (isset($value[8 + $plusColumn])) {
                $samples["samples"][$inputs["sample_index"]]["results"][$key - 1]["sat"] = floatval($value[8 + $plusColumn]);
            }
            if (isset($value[9 + $plusColumn])) {
                $samples["samples"][$inputs["sample_index"]]["results"][$key - 1]["conc"] = floatval($value[9 + $plusColumn]);
            }
            if (isset($value[10 + $plusColumn])) {
                $samples["samples"][$inputs["sample_index"]]["results"][$key - 1]["eh"] = floatval($value[10 + $plusColumn]);
            }
            if (isset($value[11 + $plusColumn])) {
                $samples["samples"][$inputs["sample_index"]]["results"][$key - 1]["ntu"] = floatval($value[11 + $plusColumn]);
            }
            if (isset($value[12 + $plusColumn])) {
                $samples["samples"][$inputs["sample_index"]]["results"][$key - 1]["chlorine"] = floatval($value[12 + $plusColumn]);
            }
            if (isset($value[13 + $plusColumn])) {
                $samples["samples"][$inputs["sample_index"]]["results"][$key - 1]["residualchlorine"] = floatval($value[13 + $plusColumn]);
            }
            if (isset($value[14 + $plusColumn])) {
                $samples["samples"][$inputs["sample_index"]]["results"][$key - 1]["voc"] = floatval($value[14 + $plusColumn]);
            }
            if (isset($value[15 + $plusColumn])) {
                $samples["samples"][$inputs["sample_index"]]["results"][$key - 1]["aspect"] = $value[15 + $plusColumn];
            }
            if (isset($value[16 + $plusColumn])) {
                $samples["samples"][$inputs["sample_index"]]["results"][$key - 1]["artificialdyes"] = $value[16 + $plusColumn];
            }
            if (isset($value[17 + $plusColumn])) {
                $samples["samples"][$inputs["sample_index"]]["results"][$key - 1]["floatingmaterials"] = $value[17 + $plusColumn];
            }
            if (isset($value[18 + $plusColumn])) {
                $samples["samples"][$inputs["sample_index"]]["results"][$key - 1]["objectablesolidwaste"] = $value[18 + $plusColumn];
            }
            if (isset($value[19 + $plusColumn])) {
                $samples["samples"][$inputs["sample_index"]]["results"][$key - 1]["visibleoilsandgreases"] = $value[19 + $plusColumn];
            }
        }

        $sampleCount = count($samples["samples"][$inputs["sample_index"]]["results"]);

        if($formValue->form->name != "RT-LAB-020-1") {
            $samples = $this->validadeTime($samples, $inputs["sample_index"]);
            $samples = $this->validadeTemperature($samples, $inputs["sample_index"]);
            $samples = $this->validadePH($samples, $inputs["sample_index"]);
            $samples = $this->validadeOrp($samples, $inputs["sample_index"]);
            $samples = $this->validadeConductivity($samples, $inputs["sample_index"]);
            $samples = $this->validadeSat($samples, $inputs["sample_index"]);
        }

        $samples["samples"][$inputs["sample_index"]]["invalid_rows"] =  $sampleCount > count($samples["samples"][$inputs["sample_index"]]["results"]);

        $sampleCount = count($samples["samples"][$inputs["sample_index"]]["results"]);
        $sampleAdd = 3 - $sampleCount;

        if ($sampleAdd > 0) {
            for ($i=0; $i < $sampleAdd; $i++) {
                $samples["samples"][$inputs["sample_index"]]["results"][$sampleCount + $i]["temperature"] = null;
                $samples["samples"][$inputs["sample_index"]]["results"][$sampleCount + $i]["ph"] = null;
                $samples["samples"][$inputs["sample_index"]]["results"][$sampleCount + $i]["orp"] = null;
                $samples["samples"][$inputs["sample_index"]]["results"][$sampleCount + $i]["conductivity"] = null;
                $samples["samples"][$inputs["sample_index"]]["results"][$sampleCount + $i]["salinity"] = null;
                $samples["samples"][$inputs["sample_index"]]["results"][$sampleCount + $i]["psi"] = null;
                $samples["samples"][$inputs["sample_index"]]["results"][$sampleCount + $i]["sat"] = null;
                $samples["samples"][$inputs["sample_index"]]["results"][$sampleCount + $i]["conc"] = null;
                $samples["samples"][$inputs["sample_index"]]["results"][$sampleCount + $i]["eh"] = null;
                $samples["samples"][$inputs["sample_index"]]["results"][$sampleCount + $i]["ntu"] = null;
            }
        }

        $formValue->values = $samples;
        $formValue->save();

        $resp = [
            "message" => __("Dados importados com sucesso!"),
            "alert-type" => "success",
        ];

        return response()->json($resp);
    }

    /**
     * Import samples from files
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function importSamples(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "files.*" => "required|mimes:xls,xlsx|max:4096",
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

        $inputs = $request->all();

        $formValue = FormValue::findOrFail($inputs["form_value_id"]);
        $samples = $formValue->values;
        $max = 0;

        if(isset($samples["samples"])) {
            $keys = array_keys($samples["samples"]);
            foreach ($keys as $value) {
                $key = Str::replace("row_", "", $value);
                if($key > $max) $max = $key;
            }
        }

        $max++;

        foreach ($request->file()['file'] as $file) {
            $spreadsheet = IOFactory::load($file->path());

            $spreadsheet->setActiveSheetIndex(0);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();


            $samples["samples"]["row_$max"]["equipment"] = $rows[3][1];
            $samples["samples"]["row_$max"]["point"] = $rows[17][1];
            $samples["samples"]["row_$max"]["environment"] = 'Sem chuva';
            $samples["samples"]["row_$max"]["collect"] = Carbon::createFromFormat('Y/m/d - H:i:s',  $rows[19][1])->toDateTimeLocalString();


            $spreadsheet->setActiveSheetIndex(1);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            $microseccondInMille = 1000;
            $micrometerInMetre = 1000000;
            $plusColumn = Str::contains($rows[0][4], 'ORP[mV]') ? 0 : 1;
            $size = count($rows);

            foreach ($rows as $key => $value) {
                if ($key == 0) continue;

                if($formValue->form->name == "RT-LAB-020-1" && ($size == 4 || $size == 5) && $key > 4) break;

                if(is_numeric($value[2])) {
                    if (isset($value[1])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["time"] = $value[1];
                    }
                    if (isset($value[2])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["temperature"] = floatval($value[2]);
                    }
                    if (isset($value[3])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["ph"] = floatval($value[3]);
                    }
                    if (isset($value[4])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["orp"] = floatval($value[4]);
                    }
                    if (isset($value[5 + $plusColumn])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["conductivity"] = Str::contains($rows[0][5 + $plusColumn], 'EC[µS/cm]') ? floatval($value[5 + $plusColumn]) : floatval($value[5 + $plusColumn]) * $microseccondInMille;
                    }
                    if (isset($value[6 + $plusColumn])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["salinity"] = Str::contains($rows[0][5 + $plusColumn], 'EC[µS/cm]') ? floatval($value[6 + $plusColumn]) : floatval($value[6 + $plusColumn]) * $micrometerInMetre;
                    }
                    if (isset($value[7 + $plusColumn])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["psi"] = floatval($value[7 + $plusColumn]);
                    }
                    if (isset($value[8 + $plusColumn])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["sat"] = floatval($value[8 + $plusColumn]);
                    }
                    if (isset($value[9 + $plusColumn])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["conc"] = floatval($value[9 + $plusColumn]);
                    }
                    if (isset($value[10 + $plusColumn])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["eh"] = floatval($value[10 + $plusColumn]);
                    }
                    if (isset($value[11 + $plusColumn])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["ntu"] = floatval($value[11 + $plusColumn]);
                    }
                    if (isset($value[12 + $plusColumn])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["chlorine"] = floatval($value[12 + $plusColumn]);
                    }
                    if (isset($value[13 + $plusColumn])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["residualchlorine"] = floatval($value[13 + $plusColumn]);
                    }
                    if (isset($value[14 + $plusColumn])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["voc"] = floatval($value[14 + $plusColumn]);
                    }
                    if (isset($value[15 + $plusColumn])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["aspect"] = $value[15 + $plusColumn];
                    }
                    if (isset($value[16 + $plusColumn])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["artificialdyes"] = $value[16 + $plusColumn];
                    }
                    if (isset($value[17 + $plusColumn])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["floatingmaterials"] = $value[17 + $plusColumn];
                    }
                    if (isset($value[18 + $plusColumn])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["objectablesolidwaste"] = $value[18 + $plusColumn];
                    }
                    if (isset($value[19 + $plusColumn])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["visibleoilsandgreases"] = $value[19 + $plusColumn];
                    }
                }


            }

            $sampleCount = count($samples["samples"]["row_$max"]["results"]);

            if($formValue->form->name != "RT-LAB-020-1") {
                $samples = $this->validadeTime($samples, "row_$max");
                $samples = $this->validadeTemperature($samples, "row_$max");
                $samples = $this->validadePH($samples, "row_$max");
                $samples = $this->validadeOrp($samples, "row_$max");
                $samples = $this->validadeConductivity($samples, "row_$max");
                $samples = $this->validadeSat($samples, "row_$max");
            }

            $samples["samples"]["row_$max"]["invalid_rows"] = $sampleCount > count($samples["samples"]["row_$max"]["results"]);

            $sampleCount = count($samples["samples"]["row_$max"]["results"]);
            $sampleAdd = 3 - $sampleCount;

            if ($sampleAdd > 0) {
                for ($i=0; $i < $sampleAdd; $i++) {
                    $samples["samples"]["row_$max"]["results"][$sampleCount + $i]["temperature"] = null;
                    $samples["samples"]["row_$max"]["results"][$sampleCount + $i]["ph"] = null;
                    $samples["samples"]["row_$max"]["results"][$sampleCount + $i]["orp"] = null;
                    $samples["samples"]["row_$max"]["results"][$sampleCount + $i]["conductivity"] = null;
                    $samples["samples"]["row_$max"]["results"][$sampleCount + $i]["salinity"] = null;
                    $samples["samples"]["row_$max"]["results"][$sampleCount + $i]["psi"] = null;
                    $samples["samples"]["row_$max"]["results"][$sampleCount + $i]["sat"] = null;
                    $samples["samples"]["row_$max"]["results"][$sampleCount + $i]["conc"] = null;
                    $samples["samples"]["row_$max"]["results"][$sampleCount + $i]["eh"] = null;
                    $samples["samples"]["row_$max"]["results"][$sampleCount + $i]["ntu"] = null;
                }
            }

            $max++;
        }

        $formValue->values = $samples;
        $formValue->save();

        $resp = [
            "message" => __("Dados importados com sucesso!"),
            "alert-type" => "success",
        ];

        return response()->json($resp);
    }

     /**
     * Add results
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addResults(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "form_value_id" => ["required", "exists:form_values,id"],
            "sample_index" => ["required"],
            "amount" => ["required"],
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => implode("<br>", $validator->messages()->all()),
                    "alert-type" => "error",
                ],403
            );
        }

        $inputs = $request->all();
        $formValue = FormValue::findOrFail($inputs["form_value_id"]);
        $samples = $formValue->values;

        $max = -1;

        if(isset($samples["samples"][$inputs["sample_index"]]["results"])) {
            $keys = array_keys($samples["samples"][$inputs["sample_index"]]["results"]);
            foreach ($keys as $value) {
                if($value > $max) $max = $value;
            }
        }

        $max++;

        for ($i = 1; $i <= $inputs["amount"]; $i++) {

            $samples["samples"][$inputs["sample_index"]]["results"][$max]["temperature"] = null;
            $samples["samples"][$inputs["sample_index"]]["results"][$max]["ph"] = null;
            $samples["samples"][$inputs["sample_index"]]["results"][$max]["orp"] = null;
            $samples["samples"][$inputs["sample_index"]]["results"][$max]["conductivity"] = null;
            $samples["samples"][$inputs["sample_index"]]["results"][$max]["salinity"] = null;
            $samples["samples"][$inputs["sample_index"]]["results"][$max]["psi"] = null;
            $samples["samples"][$inputs["sample_index"]]["results"][$max]["sat"] = null;
            $samples["samples"][$inputs["sample_index"]]["results"][$max]["conc"] = null;
            $samples["samples"][$inputs["sample_index"]]["results"][$max]["eh"] = null;
            $samples["samples"][$inputs["sample_index"]]["results"][$max]["ntu"] = null;
            $samples["samples"][$inputs["sample_index"]]["results"][$max]["chlorine"] = null;
            $samples["samples"][$inputs["sample_index"]]["results"][$max]["residualchlorine"] = null;
            $samples["samples"][$inputs["sample_index"]]["results"][$max]["aspect"] = null;
            $samples["samples"][$inputs["sample_index"]]["results"][$max]["artificialdyes"] = null;
            $samples["samples"][$inputs["sample_index"]]["results"][$max]["floatingmaterials"] = null;
            $samples["samples"][$inputs["sample_index"]]["results"][$max]["objectablesolidwaste"] = null;
            $samples["samples"][$inputs["sample_index"]]["results"][$max]["visibleoilsandgreases"] = null;
            $samples["samples"][$inputs["sample_index"]]["results"][$max]["voc"] = null;
            $max++;
        }

        $formValue->values = $samples;
        $formValue->save();

        $resp = [
            "message" => __("Dados adicionados com sucesso!"),
            "alert-type" => "success",
        ];

        return response()->json($resp);
    }

    /**
     * Add coordinates
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addCoordinates(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "form_value_id" => ["required", "exists:form_values,id"],
            "amount" => ["required"],
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => implode("<br>", $validator->messages()->all()),
                    "alert-type" => "error",
                ],403
            );
        }

        $inputs = $request->all();
        $formValue = FormValue::findOrFail($inputs["form_value_id"]);
        $coordinates = $formValue->values;

        $max = 0;

        if(isset($coordinates["coordinates"])) {
            $keys = array_keys($coordinates["coordinates"]);
            foreach ($keys as $value) {
                if($value > $max) $max = $value;
            }
        }

        $max++;

        for ($i = 1; $i <= $inputs["amount"]; $i++) {
            $coordinates["coordinates"][$max]["point"] = null;
            $coordinates["coordinates"][$max]["zone"] = null;
            $coordinates["coordinates"][$max]["me"] = null;
            $coordinates["coordinates"][$max]["mn"] = null;
            $max++;
        }

        $formValue->values = $coordinates;
        $formValue->save();

        $resp = [
            "message" => __("Dados adicionados com sucesso!"),
            "alert-type" => "success",
        ];

        return response()->json($resp);
    }

    /**
     *  Check column time
     *
     * @param array $sample
     * @return array
     */
    private function validadeTime($samples, $index)
    {
        if (count($samples) < 3) return $samples;
        if (count($samples["samples"][$index]["results"]) < 4) return $samples;
        $deletedIndex = [];
        $diffs = [];
        foreach ($samples["samples"][$index]["results"] as $key => $result)
        {
            if(!isset($result["time"])) continue;
            if(!isset($samples["samples"][$index]["results"][$key - 1]["time"])) continue;
            if($key != 0) {
                $startTime = Carbon::createFromFormat('H:i:s', $result["time"]);
                $endTime = Carbon::createFromFormat('H:i:s', $samples["samples"][$index]["results"][$key - 1]["time"]);
                $diff = $endTime->diffInSeconds($startTime);
                $diffs["row_$key"] = $diff;
            }
        }
        $countvalues = array_count_values($diffs);
        foreach ($countvalues as $key => $value)
        {
           if($value == 1) {
                $deletedIndex[] = intval(Str::replace("row_", "", array_search($key, $diffs)));
           }
        }
        if(count($deletedIndex) > 0) {
            $maxKey = max($deletedIndex);
            $result = [];
            array_splice($samples["samples"][$index]["results"], 0, $maxKey - 1, $result);
        }
        return $samples;
    }

    /**
     *  Check column temperature
     *
     * @param array $sample
     * @return array
     */
    private function validadeTemperature($samples, $index)
    {
        if (count($samples) < 3) return $samples;
        $deletedIndex = [];

        foreach ($samples["samples"][$index]["results"] as $key => $result)
        {
            if(!isset($result["temperature"])) continue;
            if(!isset($samples["samples"][$index]["results"][$key - 1]["temperature"])) continue;
            if($key != 0) {
                $start = $result["temperature"];
                $end = $samples["samples"][$index]["results"][$key - 1]["temperature"];
                $diff = $end - $start;
                if($diff > 0.5 || $diff < -0.5) $deletedIndex[] = $key;
            }
        }
        if(count($deletedIndex) > 0) {
            $maxKey = max($deletedIndex);
            $result = [];
            array_splice($samples["samples"][$index]["results"], 0, $maxKey, $result);
        }
        return $samples;
    }

     /**
     *  Check column ph
     *
     * @param array $sample
     * @return array
     */
    private function validadePH($samples, $index)
    {
        if (count($samples) < 3) return $samples;
        $deletedIndex = [];

        foreach ($samples["samples"][$index]["results"] as $key => $result)
        {
            if(!isset($result["ph"])) continue;
            if(!isset($samples["samples"][$index]["results"][$key - 1]["ph"])) continue;
            if($key != 0) {
                $start = $result["ph"];
                $end = $samples["samples"][$index]["results"][$key - 1]["ph"];
                $diff = $end - $start;
                $diffs[] = $diff;
                if($diff > 0.20 || $diff < -0.20) $deletedIndex[] = $key;
            }
        }
        if(count($deletedIndex) > 0) {
            $maxKey = max($deletedIndex);
            $result = [];
            array_splice($samples["samples"][$index]["results"], 0, $maxKey, $result);
        }
        return $samples;
    }

    /**
     *  Check column ORP
     *
     * @param array $sample
     * @return array
     */
    private function validadeOrp($samples, $index)
    {
        if (count($samples) < 3) return $samples;
        $deletedIndex = [];

        foreach ($samples["samples"][$index]["results"] as $key => $result)
        {
            if(!isset($result["orp"])) continue;
            if(!isset($samples["samples"][$index]["results"][$key - 1]["orp"])) continue;
            if($key != 0) {
                $start = $result["orp"];
                $end = $samples["samples"][$index]["results"][$key - 1]["orp"];
                $diff = $end - $start;
                if($diff > 20 || $diff < -20) $deletedIndex[] = $key;
            }
        }
        if(count($deletedIndex) > 0) {
            $maxKey = max($deletedIndex);
            $result = [];
            array_splice($samples["samples"][$index]["results"], 0, $maxKey, $result);
        }
        return $samples;
    }

    /**
     *  Check column Condutivity
     *
     * @param array $sample
     * @return array
     */
    private function validadeConductivity($samples, $index)
    {
        if (count($samples) < 3) return $samples;
        $deletedIndex = [];

        foreach ($samples["samples"][$index]["results"] as $key => $result)
        {
            if(!isset($result["conductivity"])) continue;
            if(!isset($samples["samples"][$index]["results"][$key - 1]["conductivity"])) continue;
            if($key != 0) {
                $start = $result["conductivity"];
                $end = $samples["samples"][$index]["results"][$key - 1]["conductivity"];
                $upperLimit = $end + ($end * 0.05);
                $inferiorLimit = $end - ($end * 0.05);
                if($start > $upperLimit || $start < $inferiorLimit) $deletedIndex[] = $key;
            }
        }
        if(count($deletedIndex) > 0) {
            $maxKey = max($deletedIndex);
            $result = [];
            array_splice($samples["samples"][$index]["results"], 0, $maxKey + 1, $result);
        }
        return $samples;
    }

    /**
     *  Check column Sat
     *
     * @param array $sample
     * @return array
     */
    private function validadeSat($samples, $index)
    {
        if (count($samples) < 3) return $samples;
        $deletedIndex = [];

        foreach ($samples["samples"][$index]["results"] as $key => $result)
        {
            if(!isset($result["conc"])) continue;
            if(!isset($samples["samples"][$index]["results"][$key - 1]["conc"])) continue;
            if($key != 0) {
                $start = $result["conc"];
                $end = $samples["samples"][$index]["results"][$key - 1]["conc"];
                $upperLimit = $end + ($end * 0.10);
                $inferiorLimit = $end - ($end * 0.10);
                $diff = $end - $start;
                $results[] = [
                    "upper" => $upperLimit,
                    "inferior" => $inferiorLimit,
                    "diff" => $diff,
                    "value" => $start
                ];
                if(($start > $upperLimit || $start < $inferiorLimit) && ($diff > 0.20 || $diff < -0.20) ) $deletedIndex[] = $key;
            }
        }
        if(count($deletedIndex) > 0) {
            $maxKey = max($deletedIndex);
            $result = [];
            array_splice($samples["samples"][$index]["results"], 0, $maxKey, $result);
        }
        return $samples;
    }

    /**
     * Import coordinates from file
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function importCoordinates(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "file" => "required|mimes:xls,xlsx|max:4096",
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

        $inputs = $request->all();

        $formValue = FormValue::findOrFail($inputs["form_value_id"]);

        $spreadsheet = IOFactory::load($request->file->path());
        $spreadsheet->setActiveSheetIndex(0);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        $coordinates = $formValue->values;

        foreach ($rows as $key => $value) {
            if ($key <= 1) {
                continue;
            }

            if (isset($value[0])) {
                $coordinates["coordinates"][$key - 3]["point"] = $value[0];
            }
            if (isset($value[3])) {
                $coordinates["coordinates"][$key - 3]["zone"] = $value[3];
            }
            if (isset($value[5])) {
                $coordinates["coordinates"][$key - 3]["me"] = number_format(floatval(Str::replace(",", "", $value[5])), 0, ",", ".");
            }
            if (isset($value[9])) {
                $coordinates["coordinates"][$key - 3]["mn"] = number_format(floatval(Str::replace(",", "", $value[9])), 0, ",", ".");
            }
        }

        $formValue->values = $coordinates;
        $formValue->save();

        $resp = [
            "message" => __("Dados importados com sucesso!"),
            "alert-type" => "success",
        ];

        return response()->json($resp);
    }


}
