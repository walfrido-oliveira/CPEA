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

        foreach ($rows as $key => $value) {
            if ($key == 0) {
                continue;
            }
            //if ($key == 4) break;

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
            if (isset($value[5])) {
                $samples["samples"][$inputs["sample_index"]]["results"][$key - 1]["conductivity"] = floatval($value[5]);
            }
            if (isset($value[6])) {
                $samples["samples"][$inputs["sample_index"]]["results"][$key - 1]["salinity"] = floatval($value[6]);
            }
            if (isset($value[7])) {
                $samples["samples"][$inputs["sample_index"]]["results"][$key - 1]["psi"] = floatval($value[7]);
            }
            if (isset($value[8])) {
                $samples["samples"][$inputs["sample_index"]]["results"][$key - 1]["sat"] = floatval($value[8]);
            }
            if (isset($value[9])) {
                $samples["samples"][$inputs["sample_index"]]["results"][$key - 1]["conc"] = floatval($value[9]);
            }
            if (isset($value[10])) {
                $samples["samples"][$inputs["sample_index"]]["results"][$key - 1]["eh"] = floatval($value[10]);
            }
            if (isset($value[11])) {
                $samples["samples"][$inputs["sample_index"]]["results"][$key - 1]["ntu"] = floatval($value[11]);
            }
        }

        $samples = $this->validadeTime($samples, $inputs["sample_index"]);
        /*dd($samples["samples"][$inputs["sample_index"]]["results"]);
        $samples = $this->validadeTemperature($samples, $inputs["sample_index"]);
        dd($samples["samples"][$inputs["sample_index"]]["results"]);
        $samples = $this->validadePH($samples, $inputs["sample_index"]);
        dd($samples["samples"][$inputs["sample_index"]]["results"]);
        $samples = $this->validadeOrp($samples, $inputs["sample_index"]);
        dd($samples["samples"][$inputs["sample_index"]]["results"]);
        $samples = $this->validadeConductivity($samples, $inputs["sample_index"]);
        dd($samples["samples"][$inputs["sample_index"]]["results"]);
        $samples = $this->validadeSat($samples, $inputs["sample_index"]);
        dd($samples["samples"][$inputs["sample_index"]]["results"]);*/

        $formValue->values = $samples;
        $formValue->save();

        $resp = [
            "message" => __("Dados importados com sucesso!"),
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
        if (count($samples["samples"][$index]["results"]) < 4) return $sample;
        $deletedIndex = [];
        $diffs = [];
        foreach ($samples["samples"][$index]["results"] as $key => $result)
        {
            if($key != 0) {
                $startTime = Carbon::createFromFormat('H:i:s', $result["time"]);
                $endTime = Carbon::createFromFormat('H:i:s', $samples["samples"][$index]["results"][$key - 1]["time"]);
                $diff = $endTime->diffInSeconds($startTime);
                $diffs["row_$key"] =
                [
                    "key" => $key,
                    "value" => $diff,
                    "equals" => in_array_r($diff, $diffs) ? true : false
                ];
            }
        }
        foreach ($diffs as $key => $value)
        {
            if(!$value["equals"]) $deletedIndex[] = $value["key"];
        }
        if(count($deletedIndex) > 0) {
            $maxKey = max($deletedIndex);
            $result = [];
            array_splice($samples["samples"][$index]["results"], 0, $maxKey, $result);
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
            if(isset($samples["samples"][$index]["results"][$key + 1]["temperature"])) {
                $start = $result["temperature"];
                $end = $samples["samples"][$index]["results"][$key + 1]["temperature"];
                $diff = $end - $start;
                if($diff > 0.5 || $diff < -0.5) $deletedIndex[] = $key;
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
            if(isset($samples["samples"][$index]["results"][$key + 1]["ph"])) {
                $start = $result["ph"];
                $end = $samples["samples"][$index]["results"][$key + 1]["ph"];
                $diff = $end - $start;
                if($diff > 0.2 || $diff > -0.2) $deletedIndex[] = $key;
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
            if(isset($samples["samples"][$index]["results"][$key + 1]["orp"])) {
                $start = $result["orp"];
                $end = $samples["samples"][$index]["results"][$key + 1]["orp"];
                $diff = $end - $start;
                if($diff > 20 || $diff > -20) $deletedIndex[] = $key;
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
            if(isset($samples["samples"][$index]["results"][$key + 1]["conductivity"])) {
                $start = $result["conductivity"];
                $end = $samples["samples"][$index]["results"][$key + 1]["conductivity"];
                $diff = ($end - $start) / 100;
                if($diff > 0.5 || $diff > -0.5) $deletedIndex[] = $key;
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
            if(isset($samples["samples"][$index]["results"][$key + 1]["sat"])) {
                $start = $result["sat"];
                $end = $samples["samples"][$index]["results"][$key + 1]["sat"];
                $diffNumeric = $end - $start;
                $diffPercentual = ($end - $start) / 100;
                if($diffNumeric > 0.20 || $diffNumeric > -0.20) $deletedIndex[] = $key;
                if($diffPercentual > 0.10 || $diffNumeric > -0.10) $deletedIndex[] = $key;
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
            if ($key <= 2) {
                continue;
            }

            if (isset($value[0])) {
                $coordinates["coordinates"][$key - 3]["point"] = $value[0];
            }
            if (isset($value[3])) {
                $coordinates["coordinates"][$key - 3]["zone"] = $value[3];
            }
            if (isset($value[5])) {
                $coordinates["coordinates"][$key - 3]["me"] = $value[5];
            }
            if (isset($value[9])) {
                $coordinates["coordinates"][$key - 3]["mn"] = $value[9];
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
        if($max > 0) $max++;

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

            foreach ($rows as $key => $value) {
                if ($key == 0) {
                    continue;
                }

                if(is_numeric($value[2])) {
                    if (isset($value[2])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["temperature"] = floatval($value[2]);
                    }
                    if (isset($value[3])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["ph"] = floatval($value[3]);
                    }
                    if (isset($value[4])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["orp"] = floatval($value[4]);
                    }
                    if (isset($value[5])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["conductivity"] = $rows[0][5] == 'EC[µS/cm]' ? floatval($value[5]) : floatval($value[5]) * $microseccondInMille;
                    }
                    if (isset($value[6])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["salinity"] = $rows[0][5] == 'EC[µS/cm]' ? floatval($value[6]) : floatval($value[6]) * $micrometerInMetre;
                    }
                    if (isset($value[7])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["psi"] = floatval($value[7]);
                    }
                    if (isset($value[8])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["sat"] = floatval($value[8]);
                    }
                    if (isset($value[9])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["conc"] = floatval($value[9]);
                    }
                    if (isset($value[10])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["eh"] = floatval($value[10]);
                    }
                    if (isset($value[11])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["ntu"] = floatval($value[11]);
                    }
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
}
