<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\User;
use App\Models\Config;
use App\Models\Customer;
use App\Models\FieldType;
use App\Models\FormPrint;
use App\Models\FormValue;
use Illuminate\Http\Request;
use App\Models\DuplicateSize;
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
    return view(
      "form-values.index",
      compact("forms", "ascending", "orderBy", "formsTypes")
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

    $usersSiger = User::whereNotNull('signer')->get()->pluck('full_name', 'id');

    $users = User::whereHas('occupation', function ($q) {
      $q->whereIn('occupations.name', ['Técnico de Campo', 'Auxiliar Técnico Analítico', 'Suporte Técnico Analítico', 'Analista da Qualidade', 'Estagiário']);
    })->get()->pluck('full_name', 'id');

    $customers = Customer::where('status', 'active')->pluck('name', 'id');
    $fields = FieldType::orderBy("name", "ASC")->pluck('name', 'id');
    $chuckSize = Config::get("default_duplicate_size");
    $choises = ["Presente" => "Presente", "Ausente" => "Ausente"];

    return view(
      "form-values.$form->name",
      compact("form", "formValue", "users", "customers", "fields", "usersSiger", "chuckSize", "choises")
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

    $usersSiger = User::whereNotNull('signer')->get()->pluck('full_name', 'id');

    $users = User::whereHas('occupation', function ($q) {
      $q->whereIn('occupations.name', ['Técnico de Campo', 'Auxiliar Técnico Analítico', 'Suporte Técnico Analítico', 'Analista da Qualidade', 'Estagiário']);
    })->get()->pluck('full_name', 'id');

    $customers = Customer::where('status', 'active')->pluck('name', 'id');
    $fields = FieldType::orderBy("name", "ASC")->pluck('name', 'id');
    $floatingMaterials = ["Ausênte" => "Ausênte", "Presente" => "Presente"];
    $form = $formValue->form;
    $project_id = isset($formValue->values["project_id"]) ? $formValue->values["project_id"] : null;
    $formPrint = new FormPrint(FormValue::findOrFail($id), false);

    $values = $formValue->values;
    $samplesTable = isset($values['samples']) ? $values['samples'] : [];
    $samplesTable = isset($values['samples']) ? $formValue->sortSamples("collect") : [];
    $chuckSize = Config::get("default_duplicate_size");
    $choises = ["Presente" => "Presente", "Ausente" => "Ausente"];


    $duplicateSize = DuplicateSize::where("form_id", $form->id)->where("field_type_id", $formValue->values['matrix'])->first();

    if ($duplicateSize) $chuckSize = $duplicateSize->size;

    return view("form-values.$form->name", compact(
      "form",
      "project_id",
      "formValue",
      "users",
      "customers",
      "fields",
      "floatingMaterials",
      "formPrint",
      "samplesTable",
      "usersSiger",
      "chuckSize",
      "choises"
    ));
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
   * Remove result
   *
   * @param  Request  $request
   * @return \Illuminate\Http\Response
   */
  public function deleteResult(Request $request)
  {
    $validator = Validator::make($request->all(), [
      "form_value_id" => ["required", "exists:form_values,id"],
      "sample_index" => ["required"],
      "index" => ["required"],
    ]);

    $inputs = $request->all();

    if ($validator->fails() || $inputs['index'] == 0) {
      return response()->json(
        [
          "message" => implode("<br>", $validator->messages()->all()),
          "alert-type" => "error",
        ],
        403
      );
    }

    $formValue = FormValue::findOrFail($inputs["form_value_id"]);
    $samples = $formValue->values;
    unset($samples["samples"][$inputs["sample_index"]]["results"][$inputs['index']]);

    $formValue->values = $samples;
    $formValue->save();

    $resp = [
      "message" => __("Dados adicionados com sucesso!"),
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
    $samples["samples"][$input["sample_index"]]["chlorine_equipment"] = isset($input["chlorine_equipment"]) ? $input["chlorine_equipment"] : null;
    $samples["samples"][$input["sample_index"]]["voc_equipment"] = isset($input["voc_equipment"]) ? $input["voc_equipment"] : null;
    $samples["samples"][$input["sample_index"]]["orp_equipment"] = isset($input["orp_equipment"]) ? $input["orp_equipment"] : null;
    $samples["samples"][$input["sample_index"]]["point"] = $input["point"];
    $samples["samples"][$input["sample_index"]]["environment"] = $input["environment"];
    $samples["samples"][$input["sample_index"]]["collect"] = $input["collect"];

    if (isset($input["samples"])) {
      $samples["samples"][$input["sample_index"]]["eh_footer"] = isset($input["samples"][$input["sample_index"]]["eh_footer"]) ? $input["samples"][$input["sample_index"]]["eh_footer"] : null;
      $samples["samples"][$input["sample_index"]]["ntu_footer"] = isset($input["samples"][$input["sample_index"]]["ntu_footer"]) ? $input["samples"][$input["sample_index"]]["ntu_footer"] : null;
      $samples["samples"][$input["sample_index"]]["chlorine_footer"] = isset($input["samples"][$input["sample_index"]]["chlorine_footer"]) ? $input["samples"][$input["sample_index"]]["chlorine_footer"] : null;
      $samples["samples"][$input["sample_index"]]["residualchlorine_footer"] = isset($input["samples"][$input["sample_index"]]["residualchlorine_footer"]) ? $input["samples"][$input["sample_index"]]["residualchlorine_footer"] : null;
      $samples["samples"][$input["sample_index"]]["aspect_footer"] = isset($input["samples"][$input["sample_index"]]["aspect_footer"]) ? $input["samples"][$input["sample_index"]]["aspect_footer"] : null;
      $samples["samples"][$input["sample_index"]]["artificialdyes_footer"] = isset($input["samples"][$input["sample_index"]]["artificialdyes_footer"]) ? $input["samples"][$input["sample_index"]]["artificialdyes_footer"] : null;
      $samples["samples"][$input["sample_index"]]["floatingmaterials_footer"] = isset($input["samples"][$input["sample_index"]]["floatingmaterials_footer"]) ? $input["samples"][$input["sample_index"]]["floatingmaterials_footer"] : null;
      $samples["samples"][$input["sample_index"]]["objectablesolidwaste_footer"] = isset($input["samples"][$input["sample_index"]]["objectablesolidwaste_footer"]) ? $input["samples"][$input["sample_index"]]["objectablesolidwaste_footer"] : null;
      $samples["samples"][$input["sample_index"]]["visibleoilsandgreases_footer"] = isset($input["samples"][$input["sample_index"]]["visibleoilsandgreases_footer"]) ? $input["samples"][$input["sample_index"]]["visibleoilsandgreases_footer"] : null;
      $samples["samples"][$input["sample_index"]]["voc_footer"] = isset($input["samples"][$input["sample_index"]]["voc_footer"]) ? $input["samples"][$input["sample_index"]]["voc_footer"] : null;

      $samples["samples"][$input["sample_index"]]["eh_footer_duplicate"] = isset($input["samples"][$input["sample_index"]]["eh_footer_duplicate"]) ? $input["samples"][$input["sample_index"]]["eh_footer_duplicate"] : null;
      $samples["samples"][$input["sample_index"]]["ntu_footer_duplicate"] = isset($input["samples"][$input["sample_index"]]["ntu_footer_duplicate"]) ? $input["samples"][$input["sample_index"]]["ntu_footer_duplicate"] : null;
      $samples["samples"][$input["sample_index"]]["chlorine_footer_duplicate"] = isset($input["samples"][$input["sample_index"]]["chlorine_footer_duplicate"]) ? $input["samples"][$input["sample_index"]]["chlorine_footer_duplicate"] : null;
      $samples["samples"][$input["sample_index"]]["residualchlorine_footer_duplicate"] = isset($input["samples"][$input["sample_index"]]["residualchlorine_footer_duplicate"]) ? $input["samples"][$input["sample_index"]]["residualchlorine_footer_duplicate"] : null;
      $samples["samples"][$input["sample_index"]]["aspect_footer_duplicate"] = isset($input["samples"][$input["sample_index"]]["aspect_footer_duplicate"]) ? $input["samples"][$input["sample_index"]]["aspect_footer_duplicate"] : null;
      $samples["samples"][$input["sample_index"]]["artificialdyes_footer_duplicate"] = isset($input["samples"][$input["sample_index"]]["artificialdyes_footer_duplicate"]) ? $input["samples"][$input["sample_index"]]["artificialdyes_footer_duplicate"] : null;
      $samples["samples"][$input["sample_index"]]["floatingmaterials_footer_duplicate"] = isset($input["samples"][$input["sample_index"]]["floatingmaterials_footer_duplicate"]) ? $input["samples"][$input["sample_index"]]["floatingmaterials_footer_duplicate"] : null;
      $samples["samples"][$input["sample_index"]]["objectablesolidwaste_footer_duplicate"] = isset($input["samples"][$input["sample_index"]]["objectablesolidwaste_footer_duplicate"]) ? $input["samples"][$input["sample_index"]]["objectablesolidwaste_footer_duplicate"] : null;
      $samples["samples"][$input["sample_index"]]["visibleoilsandgreases_footer_duplicate"] = isset($input["samples"][$input["sample_index"]]["visibleoilsandgreases_footer_duplicate"]) ? $input["samples"][$input["sample_index"]]["visibleoilsandgreases_footer_duplicate"] : null;
      $samples["samples"][$input["sample_index"]]["voc_footer_duplicate"] = isset($input["samples"][$input["sample_index"]]["voc_footer_duplicate"]) ? $input["samples"][$input["sample_index"]]["voc_footer_duplicate"] : null;

      $samples["samples"][$input["sample_index"]]["temperature_uncertainty_footer"] = isset($input["samples"][$input["sample_index"]]["temperature_uncertainty_footer"]) ? $input["samples"][$input["sample_index"]]["temperature_uncertainty_footer"] : null;
      $samples["samples"][$input["sample_index"]]["ph_uncertainty_footer"] = isset($input["samples"][$input["sample_index"]]["ph_uncertainty_footer"]) ? $input["samples"][$input["sample_index"]]["ph_uncertainty_footer"] : null;
      $samples["samples"][$input["sample_index"]]["orp_uncertainty_footer"] = isset($input["samples"][$input["sample_index"]]["orp_uncertainty_footer"]) ? $input["samples"][$input["sample_index"]]["orp_uncertainty_footer"] : null;
      $samples["samples"][$input["sample_index"]]["conductivity_uncertainty_footer"] = isset($input["samples"][$input["sample_index"]]["conductivity_uncertainty_footer"]) ? $input["samples"][$input["sample_index"]]["conductivity_uncertainty_footer"] : null;
      $samples["samples"][$input["sample_index"]]["salinity_uncertainty_footer"] = isset($input["samples"][$input["sample_index"]]["salinity_uncertainty_footer"]) ? $input["samples"][$input["sample_index"]]["salinity_uncertainty_footer"] : null;
      $samples["samples"][$input["sample_index"]]["conc_uncertainty_footer"] = isset($input["samples"][$input["sample_index"]]["conc_uncertainty_footer"]) ? $input["samples"][$input["sample_index"]]["conc_uncertainty_footer"] : null;
      $samples["samples"][$input["sample_index"]]["ntu_uncertainty_footer"] = isset($input["samples"][$input["sample_index"]]["ntu_uncertainty_footer"]) ? $input["samples"][$input["sample_index"]]["ntu_uncertainty_footer"] : null;
      $samples["samples"][$input["sample_index"]]["chlorine_uncertainty_footer"] = isset($input["samples"][$input["sample_index"]]["chlorine_uncertainty_footer"]) ? $input["samples"][$input["sample_index"]]["chlorine_uncertainty_footer"] : null;
      $samples["samples"][$input["sample_index"]]["residualchlorine_uncertainty_footer"] = isset($input["samples"][$input["sample_index"]]["residualchlorine_uncertainty_footer"]) ? $input["samples"][$input["sample_index"]]["residualchlorine_uncertainty_footer"] : null;
      $samples["samples"][$input["sample_index"]]["voc_uncertainty_footer"] = isset($input["samples"][$input["sample_index"]]["voc_uncertainty_footer"]) ? $input["samples"][$input["sample_index"]]["voc_uncertainty_footer"] : null;
    }
    if (isset($input["samples"][$input["sample_index"]]["results"])) {
      foreach ($input["samples"][$input["sample_index"]]["results"] as $key => $value) {
        $samples["samples"][$input["sample_index"]]["results"][$key]["temperature"] = isset($value["temperature"]) ? $value["temperature"] : null;
        $samples["samples"][$input["sample_index"]]["results"][$key]["ph"] = isset($value["ph"]) ? $value["ph"] : null;
        $samples["samples"][$input["sample_index"]]["results"][$key]["eh"] = isset($value["eh"]) ? $value["eh"] : null;
        $samples["samples"][$input["sample_index"]]["results"][$key]["orp"] = isset($value["orp"]) ? $value["orp"] : null;
        $samples["samples"][$input["sample_index"]]["results"][$key]["conductivity"] = isset($value["conductivity"]) ? $value["conductivity"] : null;
        $samples["samples"][$input["sample_index"]]["results"][$key]["salinity"] = isset($value["salinity"]) ? $value["salinity"] : null;
        $samples["samples"][$input["sample_index"]]["results"][$key]["psi"] = isset($value["psi"]) ? $value["psi"] : null;
        $samples["samples"][$input["sample_index"]]["results"][$key]["sat"] = isset($value["sat"]) ? $value["sat"] : null;
        $samples["samples"][$input["sample_index"]]["results"][$key]["conc"] = isset($value["conc"]) ? $value["conc"] : null;

        $samples["samples"][$input["sample_index"]]["results"][$key]["eh"] = isset($value["eh"]) ? $value["eh"] : null;
        $samples["samples"][$input["sample_index"]]["results"][$key]["ntu"] = isset($value["ntu"]) ? $value["ntu"] : null;
        $samples["samples"][$input["sample_index"]]["results"][$key]["uncertainty"] = isset($value["uncertainty"]) ? $value["uncertainty"] : null;

        $samples["samples"][$input["sample_index"]]["results"][$key]["chlorine"] = isset($value["chlorine"]) ? $value["chlorine"] : null;
        $samples["samples"][$input["sample_index"]]["results"][$key]["residualchlorine"] = isset($value["residualchlorine"]) ? $value["residualchlorine"] : null;
        $samples["samples"][$input["sample_index"]]["results"][$key]["aspect"] = isset($value["aspect"]) ? $value["aspect"] : null;
        $samples["samples"][$input["sample_index"]]["results"][$key]["artificialdyes"] = isset($value["artificialdyes"]) ? $value["artificialdyes"] : null;
        $samples["samples"][$input["sample_index"]]["results"][$key]["floatingmaterials"] = isset($value["floatingmaterials"]) ? $value["floatingmaterials"] : null;
        $samples["samples"][$input["sample_index"]]["results"][$key]["objectablesolidwaste"] = isset($value["objectablesolidwaste"]) ? $value["objectablesolidwaste"] : null;
        $samples["samples"][$input["sample_index"]]["results"][$key]["visibleoilsandgreases"] = isset($value["visibleoilsandgreases"]) ? $value["visibleoilsandgreases"] : null;
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
  public function saveEnvironment(Request $request)
  {
    $validator = Validator::make($request->all(), [
      "form_value_id" => ["required", "exists:form_values,id"],
      "samples" => ["required"],
      "environments" => ["required"],
    ]);

    if ($validator->fails()) {
      return response()->json( $validator->messages(), Response::HTTP_BAD_REQUEST );
    }

    $input = $request->except("_method", "_token", "form_id");
    $formValue = FormValue::findOrFail($input["form_value_id"]);

    $samples = $formValue->values;

    foreach ($input["samples"] as $key => $sampleIndex) {
      $samples["samples"][$sampleIndex]["environment"] = $input["environments"][$key];
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

    foreach ($input['samples'] as $key => $field) {
      foreach ($field as $key => $value) {
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
      return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
    }

    $input = $request->except("_method", "_token", "form_id");
    $formValue = FormValue::findOrFail($input["form_value_id"]);

    $coordinates = $formValue->values;

    foreach ($input["coordinates"] as $key => $value) {
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

    if (isset($formValue->values["samples"])) {
      $samplesValues["samples"] = $formValue->sortSamples($filter);

      foreach ($samplesValues['samples'] as $key => $value) {
        if (isset($value['results'])) {
          if (count(array_chunk($value['results'], 3)) > 1 && $type == "duplicates") {
            $samples[$key] = $value;
            $svgs[$key] = $svgsTemp[$key];
          } else if ($type == "default") {
            $samples[$key] = $value;
            $svgs[$key] = $svgsTemp[$key];
          }
        }
      }
    }

    return response()->json([
      'viwer' => view(
        "form-values." . $formValue->form->name . ".sample-list",
        compact("formValue", "count", "svgs", "type", "samples", "formPrint")
      )->render()
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

    if (isset($formValue->values["samples"])) {
      foreach ($formValue->values['samples'] as $key => $value) {
        if (isset($value['results'])) {
          if (count(array_chunk($value['results'], 3)) > 1 && $type == "duplicates" && count($value['results']) >= 6) {
            $samples[$key] = $value;
            $svgs[$key] = $svgsTemp[$key];
            $svgs[$key]['ph_formatted'] = number_format($svgs[$key]['ph'], 1, ',', '.');
            $svgs[$key]['eh_formatted'] = number_format($svgs[$key]['eh'], 0, ',', '.');
          } else if ($type == "default") {
            $samples[$key] = $value;
            $svgs[$key] = $svgsTemp[$key];
            $svgs[$key]['ph_formatted'] = number_format($svgs[$key]['ph'], 1, ',', '.');
            $svgs[$key]['eh_formatted'] = number_format($svgs[$key]['eh'], 0, ',', '.');
          }
        }
      }
    }

    return response()->json([
      'viwer' => view(
        "form-values." . $formValue->form->name . ".sample-chart-list",
        compact("formValue", "count", "svgs", "type", "samples", "formPrint")
      )->render(),
      'samples' => $samples,
      'svgs' => $svgs,
    ]);
  }
}
