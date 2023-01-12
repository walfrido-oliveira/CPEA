<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Form;
use App\Models\User;
use Dompdf\FontMetrics;
use App\Models\Customer;
use App\Models\FieldType;
use App\Models\FormValue;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    /**
     * Display a listing of the Ref.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $forms = FormValue::filter($request->all());
        $formsTypes = Form::all()->pluck("name", "id");

        $ascending = isset($query["ascending"]) ? $query["ascending"] : "desc";
        $orderBy = isset($query["order_by"]) ? $query["order_by"] : "form_id";
        return view(
            "form.index",
            compact("forms", "ascending", "orderBy", "formsTypes")
        );
    }

    /**
     * Display a listing of the Ref.
     *
     * @param  Request  $request
     * @param int $id
     * @param string $project_id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id, $project_id)
    {
        $forms = Form::where("field_type_id", $id)->get();
        $fieldType = FieldType::findOrFail($id);
        return view("form.show", compact("forms", "fieldType", "project_id"));
    }

    /**
     * Display a listing of the Ref.
     *
     * @param  Request  $request
     * @param int $id
     * @param string $project_id
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id, $project_id)
    {
        $form = Form::findOrFail($id);
        $formValue = null;
        $users = User::all()->pluck('full_name', 'id');
        $customers = Customer::where('status', 'active')->pluck('name', 'id');

        return view(
            "form.$form->name",
            compact("form", "project_id", "formValue", "users", "customers")
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "form_id" => ["required", "exists:forms,id"],
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->messages(),
                Response::HTTP_BAD_REQUEST
            );
        }

        $input = $request->except("_method", "_token", "form_id", "mode_list_count", "files");

        $formValue = FormValue::create([
            "form_id" => $request->get("form_id"),
            "values" => $input,
        ]);

        $resp = [
            "message" => __("Formulário adicionado com Sucesso!"),
            "alert-type" => "success",
        ];

        return redirect()
            ->route("fields.forms.edit", ["form_value" => $formValue->id])
            ->with($resp);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "form_id" => ["required", "exists:forms,id"],
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->messages(),
                Response::HTTP_BAD_REQUEST
            );
        }

        $formValue = FormValue::findOrFail($id);
        $samples = isset($formValue->values['samples']) ? $formValue->values['samples'] : null;
        $coordinates = isset($formValue->values['coordinates']) ? $formValue->values['coordinates'] : null;

        $input = $request->except("_method", "_token", "form_id", "mode_list_count", "files");

        $formValue->update([
            "values" => $input,
        ]);

        $values = $formValue->values;
        $values['samples'] = $samples;
        $values['coordinates'] = $coordinates;
        $formValue->values = $values;
        $formValue->save();

        $resp = [
            "message" => __("Formulário atualizado com Sucesso!"),
            "alert-type" => "success",
        ];

        return redirect()
            ->route("fields.forms.edit", ["form_value" => $formValue->id])
            ->with($resp);
    }

    /**
     * Edit
     *
     * @param  Request  $request
     * @param int $id
     * @param string $project_id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $formValue = FormValue::findOrFail($id);
        $users = User::all()->pluck('full_name', 'id');
        $customers = Customer::where('status', 'active')->pluck('name', 'id');
        $form = $formValue->form;
        $project_id = $formValue->values["project_id"];
        $svgs = [];
        $duplicates = [];
        $duplicatesSvgs = [];
        $dpr = [];

        if(isset($formValue->values["samples"])) {
            foreach ($formValue->values["samples"] as $key => $sample) {
                if (isset($sample["results"])) {
                    $sum = [];
                    $size = count(array_chunk($sample["results"], 3)[0]);

                    $sum["temperature"] = 0;
                    $sum["ph"] = 0;
                    $sum["orp"] = 0;
                    $sum["conductivity"] = 0;
                    $sum["salinity"] = 0;
                    $sum["psi"] = 0;
                    $sum["sat"] = 0;
                    $sum["conc"] = 0;
                    $sum["ntu"] = 0;

                    foreach (array_chunk($sample["results"], 3)[0] as $key2 => $value ) {
                        if (isset($value["temperature"])) {
                            $sum["temperature"] += $value["temperature"];
                        }
                        if (isset($value["ph"])) {
                            $sum["ph"] += $value["ph"];
                        }
                        if (isset($value["orp"])) {
                            $sum["orp"] += $value["orp"];
                        }
                        if (isset($value["conductivity"])) {
                            $sum["conductivity"] += $value["conductivity"];
                        }
                        if (isset($value["salinity"])) {
                            $sum["salinity"] += $value["salinity"];
                        }
                        if (isset($value["psi"])) {
                            $sum["psi"] += $value["psi"];
                        }
                        if (isset($value["sat"])) {
                            $sum["sat"] += $value["sat"];
                        }
                        if (isset($value["conc"])) {
                            $sum["conc"] += $value["conc"];
                        }
                        if (isset($value["ntu"])) {
                            $sum["ntu"] += $value["ntu"];
                        }
                    }

                    $svgs[$key]["temperature"] = $sum["temperature"] / $size;
                    $svgs[$key]["ph"] = $sum["ph"] / $size;
                    $svgs[$key]["orp"] = $sum["orp"] / $size;
                    $svgs[$key]["conductivity"] = $sum["conductivity"] / $size;
                    $svgs[$key]["salinity"] = $sum["salinity"] / $size;
                    $svgs[$key]["psi"] = $sum["psi"] / $size;
                    $svgs[$key]["sat"] = $sum["sat"] / $size;
                    $svgs[$key]["conc"] = $sum["conc"] / $size;
                    $svgs[$key]["eh"] = $svgs[$key]["orp"] + 199;
                    $svgs[$key]["ntu"] = $sum["ntu"] / $size;

                    if (isset(array_chunk($sample["results"], 3)[1])) {
                        $sum["temperature"] = 0;
                        $sum["ph"] = 0;
                        $sum["orp"] = 0;
                        $sum["conductivity"] = 0;
                        $sum["salinity"] = 0;
                        $sum["psi"] = 0;
                        $sum["sat"] = 0;
                        $sum["conc"] = 0;
                        $sum["ntu"] = 0;

                        foreach (array_chunk($sample["results"], 3)[1] as $value) {
                            if (isset($value["temperature"])) {
                                $sum["temperature"] += $value["temperature"];
                            }
                            if (isset($value["ph"])) {
                                $sum["ph"] += $value["ph"];
                            }
                            if (isset($value["orp"])) {
                                $sum["orp"] += $value["orp"];
                            }
                            if (isset($value["conductivity"])) {
                                $sum["conductivity"] += $value["conductivity"];
                            }
                            if (isset($value["salinity"])) {
                                $sum["salinity"] += $value["salinity"];
                            }
                            if (isset($value["psi"])) {
                                $sum["psi"] += $value["psi"];
                            }
                            if (isset($value["sat"])) {
                                $sum["sat"] += $value["sat"];
                            }
                            if (isset($value["conc"])) {
                                $sum["conc"] += $value["conc"];
                            }
                            if (isset($value["ntu"])) {
                                $sum["ntu"] += $value["ntu"];
                            }
                        }

                        $duplicates[$key]["temperature"] = $sum["temperature"] / $size;
                        $duplicates[$key]["ph"] = $sum["ph"] / $size;
                        $duplicates[$key]["orp"] = $sum["orp"] / $size;
                        $duplicates[$key]["conductivity"] = $sum["conductivity"] / $size;
                        $duplicates[$key]["salinity"] = $sum["salinity"] / $size;
                        $duplicates[$key]["psi"] = $sum["psi"] / $size;
                        $duplicates[$key]["sat"] = $sum["sat"] / $size;
                        $duplicates[$key]["conc"] = $sum["conc"] / $size;
                        $duplicates[$key]["eh"] = $duplicates[$key]["orp"] + 199;
                        $duplicates[$key]["ntu"] = $sum["ntu"] / $size;

                        $duplicatesSvgs[$key]["temperature"] = ($svgs[$key]["temperature"] + $duplicates[$key]["temperature"]) / 2;
                        $duplicatesSvgs[$key]["ph"] = ($svgs[$key]["ph"] + $duplicates[$key]["ph"]) / 2;
                        $duplicatesSvgs[$key]["orp"] = ($svgs[$key]["orp"] + $duplicates[$key]["orp"]) / 2;
                        $duplicatesSvgs[$key]["conductivity"] = ($svgs[$key]["conductivity"] + $duplicates[$key]["conductivity"]) / 2;
                        $duplicatesSvgs[$key]["salinity"] = ($svgs[$key]["salinity"] + $duplicates[$key]["salinity"]) / 2;
                        $duplicatesSvgs[$key]["psi"] = ($svgs[$key]["psi"] + $duplicates[$key]["psi"]) / 2;
                        $duplicatesSvgs[$key]["sat"] = ($svgs[$key]["sat"] + $duplicates[$key]["sat"]) / 2;
                        $duplicatesSvgs[$key]["conc"] = ($svgs[$key]["conc"] + $duplicates[$key]["conc"]) / 2;
                        $duplicatesSvgs[$key]["eh"] = ($svgs[$key]["eh"] + $duplicates[$key]["eh"]) / 2;
                        $duplicatesSvgs[$key]["ntu"] = ($svgs[$key]["ntu"] + $duplicates[$key]["ntu"]) / 2;

                        if ($svgs[$key]["temperature"] != 0) {
                            $dpr[$key]["temperature"] = (($svgs[$key]["temperature"] - $duplicates[$key]["temperature"]) / $duplicatesSvgs[$key]["temperature"]) * 100;
                        }
                        if ($svgs[$key]["ph"] != 0) {
                            $dpr[$key]["ph"] = (($svgs[$key]["ph"] - $duplicates[$key]["ph"]) / $duplicatesSvgs[$key]["ph"]) * 100;
                        }
                        if ($svgs[$key]["orp"] != 0) {
                            $dpr[$key]["orp"] = (($svgs[$key]["orp"] - $duplicates[$key]["orp"]) / $duplicatesSvgs[$key]["orp"]) *  100;
                        }
                        if ($svgs[$key]["conductivity"] != 0) {
                            $dpr[$key]["conductivity"] = (($svgs[$key]["conductivity"] - $duplicates[$key]["conductivity"]) / $duplicatesSvgs[$key]["conductivity"]) * 100;
                        }
                        if ($svgs[$key]["salinity"] != 0) {
                            $dpr[$key]["salinity"] = (($svgs[$key]["salinity"] - $duplicates[$key]["salinity"]) / $duplicatesSvgs[$key]["salinity"]) * 100;
                        }
                        if ($svgs[$key]["psi"] != 0) {
                            $dpr[$key]["psi"] = (($svgs[$key]["psi"] - $duplicates[$key]["psi"]) / $duplicatesSvgs[$key]["psi"]) * 100;
                        }
                        if ($svgs[$key]["sat"] != 0) {
                            $dpr[$key]["sat"] = (($svgs[$key]["sat"] - $duplicates[$key]["sat"]) / $duplicatesSvgs[$key]["sat"]) * 100;
                        }
                        if ($svgs[$key]["conc"] != 0) {
                            $dpr[$key]["conc"] = (($svgs[$key]["conc"] - $duplicates[$key]["conc"]) / $duplicatesSvgs[$key]["conc"]) * 100;
                        }
                        if ($svgs[$key]["eh"] != 0) {
                            $dpr[$key]["eh"] = (($svgs[$key]["eh"] - $duplicates[$key]["eh"]) / $duplicatesSvgs[$key]["eh"]) * 100;
                        }
                        if ($svgs[$key]["ntu"] != 0) {
                            $dpr[$key]["ntu"] = (($svgs[$key]["ntu"] - $duplicates[$key]["ntu"]) / $duplicatesSvgs[$key]["ntu"]) * 100;
                        }
                    }
                }
            }
        }

        return view("form.$form->name", compact( "form", "project_id", "formValue", "svgs", "duplicates", "dpr", "users", "customers"));
    }

    /**
     * Filter Ref
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $forms = FormValue::filter($request->all());
        $forms = $forms->setPath("");
        $orderBy = $request->get("order_by");
        $ascending = $request->get("ascending");
        $paginatePerPage = $request->get("paginate_per_page");

        return response()->json([
            "filter_result" => view(
                "form.filter-result",
                compact("forms", "orderBy", "ascending")
            )->render(),
            "pagination" => view("layouts.pagination", [
                "models" => $forms,
                "order_by" => $orderBy,
                "ascending" => $ascending,
                "paginate_per_page" => $paginatePerPage,
            ])->render(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteSample(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "form_value_id" => ["required", "exists:form_values,id"],
            "sample_index" => ["required"],
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->messages(),
                Response::HTTP_BAD_REQUEST
            );
        }

        $input = $request->except("_method", "_token", "form_id");
        $formValue = FormValue::findOrFail($input["form_value_id"]);

        $samples = $formValue->values;

        unset($samples["samples"][$input["sample_index"]]);

        $formValue->values = $samples;
        $formValue->save();

        $resp = [
            "message" => __("Formulário atualizado com Sucesso!"),
            "alert-type" => "success",
        ];

        return response()->json($resp);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveSample(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "form_value_id" => ["required", "exists:form_values,id"],
            "sample_index" => ["required"],
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->messages(),
                Response::HTTP_BAD_REQUEST
            );
        }

        $input = $request->except("_method", "_token", "form_id");
        $formValue = FormValue::findOrFail($input["form_value_id"]);

        $samples = $formValue->values;

        $samples["samples"][$input["sample_index"]]["equipment"] = $input["equipment"];
        $samples["samples"][$input["sample_index"]]["point"] = $input["point"];
        $samples["samples"][$input["sample_index"]]["environment"] = $input["environment"];
        $samples["samples"][$input["sample_index"]]["collect"] = $input["collect"];

        if (isset($input["samples"][$input["sample_index"]]["results"])) {
            foreach ($input["samples"][$input["sample_index"]]["results"] as $key => $value ) {
                $samples["samples"][$input["sample_index"]]["results"][$key][ "temperature" ] = isset($value["temperature"]) ? $value["temperature"] : null;
                $samples["samples"][$input["sample_index"]]["results"][$key][ "ph" ] = isset($value["ph"]) ? $value["ph"] : null;
                $samples["samples"][$input["sample_index"]]["results"][$key][ "eh" ] = isset($value["eh"]) ? $value["eh"] : null;
                $samples["samples"][$input["sample_index"]]["results"][$key][ "orp" ] = isset($value["orp"]) ? $value["orp"] : null;
                $samples["samples"][$input["sample_index"]]["results"][$key][ "conductivity" ] = isset($value["conductivity"]) ? $value["conductivity"] : null;
                $samples["samples"][$input["sample_index"]]["results"][$key][ "salinity" ] = isset($value["salinity"]) ? $value["salinity"] : null;
                $samples["samples"][$input["sample_index"]]["results"][$key][ "psi" ] = isset($value["psi"]) ? $value["psi"] : null;
                $samples["samples"][$input["sample_index"]]["results"][$key][ "sat" ] = isset($value["sat"]) ? $value["sat"] : null;
                $samples["samples"][$input["sample_index"]]["results"][$key][ "conc" ] = isset($value["conc"]) ? $value["conc"] : null;

                $samples["samples"][$input["sample_index"]]["results"][$key]["eh"] = isset($value["eh"]) ? $value["eh"] : null;
                $samples["samples"][$input["sample_index"]]["results"][$key]["ntu"] = isset($value["ntu"]) ? $value["ntu"] : null;
                $samples["samples"][$input["sample_index"]]["results"][$key]["uncertainty"] = isset($value["uncertainty"]) ? $value["uncertainty"] : null;
            }
        }

        $formValue->values = $samples;
        $formValue->save();

        $resp = [
            "message" => __("Formulário atualizado com Sucesso!"),
            "alert-type" => "success",
        ];

        return response()->json($resp);
    }

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

        $formValue->values = $samples;
        $formValue->save();

        $resp = [
            "message" => __("Dados importados com sucesso!"),
            "alert-type" => "success",
        ];

        return response()->json($resp);
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
     * Save coordinate
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveCoordinate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "form_value_id" => ["required", "exists:form_values,id"],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST );
        }

        $input = $request->except("_method", "_token", "form_id");
        $formValue = FormValue::findOrFail($input["form_value_id"]);

        $coordinates = $formValue->values;


        foreach ( $input["coordinates"] as $key => $value ) {
            $coordinates["coordinates"][$key]["point"] = $value["point"];
            $coordinates["coordinates"][$key]["zone"] = $value["zone"];
            $coordinates["coordinates"][$key]["me"] = $value["me"];
            $coordinates["coordinates"][$key]["mn"] = $value["mn"];
        }

        $formValue->values = $coordinates;
        $formValue->save();

        $resp = [
            "message" => __("Formulário atualizado com Sucesso!"),
            "alert-type" => "success",
        ];

        return response()->json($resp);
    }

    /**
     * Get Simple list chuncked
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getSampleList(Request $request, $id, $count)
    {
      $formValue = FormValue::findOrFail($id);
      $svgsTemp = $this->getSvgs($formValue);
      $type = $request->has("type") ? $request->get("type") : "default";
      $samples = [];
      $svgs = [];

      foreach ($formValue->values['samples'] as $key => $value) {
        if(count(array_chunk($value['results'], 3)) > 1 && $type == "duplicates") {
            $samples[$key] = $value;
            $svgs[$key] = $svgsTemp[$key];
        } else if($type == "default") {
            $samples[$key] = $value;
            $svgs[$key] = $svgsTemp[$key];
        }
    }

      return response()->json([
          'viwer' => view("form.sample-list", compact("formValue", "count", "svgs", "type", "samples"))->render()
      ]);
    }

    /** Get SGVs sample Array
     *
     * @param  FormValue $formValue
     * @return array
     */
    private function getSvgs(FormValue $formValue)
    {
        $svgs = [];

        foreach ($formValue->values["samples"] as $key => $sample) {
          if (isset($sample["results"])) {
            $sum = [];
            $size = count(array_chunk($sample["results"], 3)[0]);

            $sum["temperature"] = 0;
            $sum["ph"] = 0;
            $sum["orp"] = 0;
            $sum["conductivity"] = 0;
            $sum["salinity"] = 0;
            $sum["psi"] = 0;
            $sum["sat"] = 0;
            $sum["conc"] = 0;
            $sum["ntu"] = 0;

            foreach (array_chunk($sample["results"], 3)[0] as $key2 => $value ) {
              if (isset($value["temperature"])) {
                $sum["temperature"] += $value["temperature"];
              }
              if (isset($value["ph"])) {
                $sum["ph"] += $value["ph"];
              }
              if (isset($value["orp"])) {
                $sum["orp"] += $value["orp"];
              }
              if (isset($value["conductivity"])) {
                $sum["conductivity"] += $value["conductivity"];
              }
              if (isset($value["salinity"])) {
                $sum["salinity"] += $value["salinity"];
              }
              if (isset($value["psi"])) {
                $sum["psi"] += $value["psi"];
              }
              if (isset($value["sat"])) {
                $sum["sat"] += $value["sat"];
              }
              if (isset($value["conc"])) {
                $sum["conc"] += $value["conc"];
              }
              if (isset($value["ntu"])) {
                $sum["ntu"] += $value["ntu"];
              }
            }

            $svgs[$key]["temperature"] = $sum["temperature"] / $size;
            $svgs[$key]["ph"] = $sum["ph"] / $size;
            $svgs[$key]["orp"] = $sum["orp"] / $size;
            $svgs[$key]["conductivity"] = $sum["conductivity"] / $size;
            $svgs[$key]["salinity"] = $sum["salinity"] / $size;
            $svgs[$key]["psi"] = $sum["psi"] / $size;
            $svgs[$key]["sat"] = $sum["sat"] / $size;
            $svgs[$key]["conc"] = $sum["conc"] / $size;
            $svgs[$key]["eh"] = $svgs[$key]["orp"] + 199;
            $svgs[$key]["ntu"] = $sum["ntu"] / $size;
          }
        }
        return $svgs;
    }

    /**
     * Get Simple chart chuncked
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getSampleChart(Request $request, $id, $count)
    {
        $formValue = FormValue::findOrFail($id);
        $svgs = [];
        $svgsTemp = $this->getSvgs($formValue);
        $type = $request->has("type") ? $request->get("type") : "default";
        $samples = [];

        foreach ($formValue->values['samples'] as $key => $value) {
            if(count(array_chunk($value['results'], 3)) > 1 && $type == "duplicates") {
                $samples[$key] = $value;
                $svgs[$key] = $svgsTemp[$key];
                $svgs[$key]['ph_formatted'] = number_format($svgs[$key]['ph'], 1, ',', '.');
                $svgs[$key]['eh_formatted'] = number_format($svgs[$key]['eh'], 0, ',', '.');
            } else if($type == "default") {
                $samples[$key] = $value;
                $svgs[$key] = $svgsTemp[$key];
                $svgs[$key]['ph_formatted'] = number_format($svgs[$key]['ph'], 1, ',', '.');
                $svgs[$key]['eh_formatted'] = number_format($svgs[$key]['eh'], 0, ',', '.');
            }
        }

      return response()->json([
          'viwer' => view("form.sample-chart-list", compact("formValue", "count", "svgs", "type", "samples"))->render(),
          'samples' => $samples,
          'svgs' => $svgs,
      ]);
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


            $samples["samples"]["row_$max"]["equipment"] = $rows[2][1];
            $samples["samples"]["row_$max"]["point"] = $rows[17][1];
            $samples["samples"]["row_$max"]["environment"] = 'Sem chuva';
            $samples["samples"]["row_$max"]["collect"] = Carbon::createFromFormat('Y/m/d - H:i',  $rows[19][1])->toDateTimeLocalString();


            $spreadsheet->setActiveSheetIndex(1);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

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
                        $samples["samples"]["row_$max"]["results"][$key - 1]["conductivity"] = floatval($value[5]);
                    }
                    if (isset($value[6])) {
                        $samples["samples"]["row_$max"]["results"][$key - 1]["salinity"] = floatval($value[6]);
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

    /**
     * Print Form
     */
    public function print($id)
    {
      $formValue = FormValue::findOrFail($id);
      $svgs = $this->getSvgs($formValue);

      $pathLogo = 'storage/img/cpea_logo.png';
      $pathCrl = 'storage/img/crl_0402_logo.png';

      $logo = base64_encode(file_get_contents($pathLogo));
      $crl = base64_encode(file_get_contents($pathCrl));


      //return view('form.print', compact('formValue', 'logo', 'crl', 'svgs'));

      return response()->stream(function () use($formValue, $logo, $crl, $svgs) {

        $dompdf = new Dompdf(array('tempDir'=>'/srv/www/xyz/tmp'));
        $dompdf->set_option("isPhpEnabled", true);
        $dompdf->setPaper('A4');
        $dompdf->loadHtml(view('form.print', compact('formValue', 'logo', 'crl', 'dompdf', 'svgs'))->render());

        $dompdf->render();

        $canvas = $dompdf->get_canvas();
        $canvas->page_text(280, 820, "{PAGE_NUM} de {PAGE_COUNT}", null, 8, array(0,0,0));

        $fileName = $formValue->values['project_id'];
        $dompdf->stream("$fileName.pdf", array("Attachment" => false));

      }, 200);


    }
}
