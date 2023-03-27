<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\User;
use App\Models\Customer;
use App\Models\FieldType;
use App\Models\FormPrint;
use App\Models\FormValue;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class FormValueController extends Controller
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
        return view("form-values.index", compact("forms", "ascending", "orderBy", "formsTypes")
        );
    }

    /**
     * Display a listing of the Ref.
     *
     * @param Request  $request
     * @param int $id
     * @param string $project_id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $forms = Form::all();
        return view("form-values.show", compact("forms"));
    }

    /**
     * Display a listing of the Ref.
     *
     * @param  Request  $request
     * @param int $id
     * @param string $project_id
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        $form = Form::findOrFail($id);
        $formValue = null;
        $users = User::whereHas('occupation', function($q) {
            $q->where('occupations.name', 'Técnico de Campo');
        })->get()->pluck('full_name', 'id');
        $customers = Customer::where('status', 'active')->pluck('name', 'id');
        $fields = FieldType::pluck('name', 'id');

        return view("form-values.$form->name", compact("form", "formValue", "users", "customers", "fields")
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
            ->route("fields.form-values.edit", ["form_value" => $formValue->id])
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
            ->route("fields.form-values.edit", ["form_value" => $formValue->id])
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

        $usersSiger = User::whereHas('occupation', function($q) {
            $q->where('occupations.name', 'Técnico de Campo');
        })->get()->pluck('full_name', 'id');

        $users = User::whereHas('occupation', function($q) {
            $q->whereIn('occupations.name', ['Técnico de Campo', 'Auxiliar Técnico Analítico', 'Suporte Técnico Analítico', 'Analista da Qualidade', 'Estagiário']);
        })->get()->pluck('full_name', 'id');

        $customers = Customer::where('status', 'active')->pluck('name', 'id');
        $fields = FieldType::pluck('name', 'id');
        $floatingMaterials = ["Ausênte" => "Ausênte", "Presente" => "Presente"];
        $form = $formValue->form;
        $project_id = $formValue->values["project_id"];
        $formPrint = new FormPrint($formValue, false);

        $values = $formValue->values;
        $samplesTable = isset($values['samples']) ? $values['samples'] : [];
        $samplesTable = isset($values['samples']) ? $formValue->sortSamples("collect") : [];

        return view("form-values.$form->name", compact( "form", "project_id", "formValue", "users",
                                                        "customers", "fields", "floatingMaterials",
                                                        "formPrint", "samplesTable", "usersSiger"));
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
                "form-values.filter-result",
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ref = FormValue::findOrFail($id);

        $ref->delete();

        return response()->json([
            'message' => __('Formulário Apagado com Sucesso!!'),
            'alert-type' => 'success'
        ]);
    }


    /**
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
        $samples["samples"][$input["sample_index"]]["turbidity_equipment"] = $input["turbidity_equipment"];
        $samples["samples"][$input["sample_index"]]["point"] = $input["point"];
        $samples["samples"][$input["sample_index"]]["environment"] = $input["environment"];
        $samples["samples"][$input["sample_index"]]["collect"] = $input["collect"];

        if (isset($input["samples"])) {
            $samples["samples"][$input["sample_index"]]["eh_footer"] = $input["samples"][$input["sample_index"]]["eh_footer"];
            $samples["samples"][$input["sample_index"]]["ntu_footer"] = $input["samples"][$input["sample_index"]]["ntu_footer"];
            $samples["samples"][$input["sample_index"]]["temperature_uncertainty_footer"] = $input["samples"][$input["sample_index"]]["temperature_uncertainty_footer"];
            $samples["samples"][$input["sample_index"]]["ph_uncertainty_footer"] = $input["samples"][$input["sample_index"]]["ph_uncertainty_footer"];
            $samples["samples"][$input["sample_index"]]["orp_uncertainty_footer"] = $input["samples"][$input["sample_index"]]["orp_uncertainty_footer"];
            $samples["samples"][$input["sample_index"]]["conductivity_uncertainty_footer"] = $input["samples"][$input["sample_index"]]["conductivity_uncertainty_footer"];
            $samples["samples"][$input["sample_index"]]["salinity_uncertainty_footer"] = $input["samples"][$input["sample_index"]]["salinity_uncertainty_footer"];
            $samples["samples"][$input["sample_index"]]["conc_uncertainty_footer"] = $input["samples"][$input["sample_index"]]["conc_uncertainty_footer"];
            $samples["samples"][$input["sample_index"]]["ntu_uncertainty_footer"] = $input["samples"][$input["sample_index"]]["ntu_uncertainty_footer"];
        }

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

                $samples["samples"][$input["sample_index"]]["results"][$key]["chlorine"] = isset($value["chlorine"]) ? $value["chlorine"] : null;
                $samples["samples"][$input["sample_index"]]["results"][$key]["floating_materials"] = isset($value["floating_materials"]) ? $value["floating_materials"] : null;
                $samples["samples"][$input["sample_index"]]["results"][$key]["voc"] = isset($value["voc"]) ? $value["voc"] : null;
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveSampleColumn(Request $request)
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

        $samples["samples"][$input["sample_index"]]["visible_temperature"] = isset($input["visible_temperature"]) ? true : null;
        $samples["samples"][$input["sample_index"]]["visible_ph"] = isset($input["visible_ph"]) ? true: null;
        $samples["samples"][$input["sample_index"]]["visible_orp"] = isset($input["visible_orp"]) ? true : null;
        $samples["samples"][$input["sample_index"]]["visible_conductivity"] = isset($input["visible_conductivity"]) ? true: null;
        $samples["samples"][$input["sample_index"]]["visible_salinity"] = isset($input["visible_salinity"]) ? true : null;
        $samples["samples"][$input["sample_index"]]["visible_psi"] = isset($input["visible_psi"]) ? true : null;
        $samples["samples"][$input["sample_index"]]["visible_sat"] = isset($input["visible_sat"]) ? true : null;
        $samples["samples"][$input["sample_index"]]["visible_conc"] = isset($input["visible_conc"]) ? true : null;
        $samples["samples"][$input["sample_index"]]["visible_eh"] = isset($input["visible_eh"]) ? true: null;
        $samples["samples"][$input["sample_index"]]["visible_ntu"] = isset($input["visible_ntu"]) ? true : null;
        $samples["samples"][$input["sample_index"]]["visible_uncertainty"] = isset($input["visible_uncertainty"]) ? true : null;
        $samples["samples"][$input["sample_index"]]["visible_chlorine"] = isset($input["visible_chlorine"]) ? true : null;
        $samples["samples"][$input["sample_index"]]["visible_floating_materials"] = isset($input["visible_floating_materials"]) ? true: null;
        $samples["samples"][$input["sample_index"]]["visible_voc"] = isset($input["visible_voc"]) ? true : null;

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
    public function saveSampleFormRTGPA047(Request $request)
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

        foreach ($input['samples'] as $key => $field)
        {
            foreach ($field as $key => $value)
            {
                $samples["samples"][$input["sample_index"]][$key] = $value;
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteCoordinate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "form_value_id" => ["required", "exists:form_values,id"],
            "coordinate_index" => ["required"],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }

        $input = $request->except("_method", "_token", "form_id");
        $formValue = FormValue::findOrFail($input["form_value_id"]);

        $coordinates = $formValue->values;

        unset($coordinates["coordinates"][$input["coordinate_index"]]);

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
      $formPrint = new FormPrint($formValue, false);
      $svgsTemp = $formValue->svgs;
      $type = $request->has("type") ? $request->get("type") : "default";
      $filter = $request->has("mode_list_filter") ? $request->get("mode_list_filter") : "point";
      $samples = [];
      $svgs = [];
      $samplesValues = $formValue->values;

      if(isset($formValue->values["samples"])) {
        $samplesValues["samples"] = $formValue->sortSamples($filter);

        foreach ($samplesValues['samples'] as $key => $value) {
            if(isset($value['results'])) {
                if(count(array_chunk($value['results'], 3)) > 1 && $type == "duplicates") {
                    $samples[$key] = $value;
                    $svgs[$key] = $svgsTemp[$key];
                } else if($type == "default") {
                    $samples[$key] = $value;
                    $svgs[$key] = $svgsTemp[$key];
                }
            }
        }
      }

      return response()->json([
          'viwer' => view("form-values." . $formValue->form->name . ".sample-list",
          compact("formValue", "count", "svgs", "type", "samples", "formPrint"))->render()
      ]);
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
        $formPrint = new FormPrint($formValue, false);
        $svgs = [];
        $svgsTemp = $formValue->svgs;
        $type = $request->has("type") ? $request->get("type") : "default";
        $samples = [];

        if(isset($formValue->values["samples"])) {
            foreach ($formValue->values['samples'] as $key => $value) {
                if(isset($value['results'])) {
                    if(count(array_chunk($value['results'], 3)) > 1 && $type == "duplicates" && count($value['results']) >= 6) {
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
            }
        }

      return response()->json([
          'viwer' => view("form-values." . $formValue->form->name . ".sample-chart-list",
          compact("formValue", "count", "svgs", "type", "samples", "formPrint"))->render(),
          'samples' => $samples,
          'svgs' => $svgs,
      ]);
    }

}
