<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FieldType;
use App\Models\FormValue;
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
        $formsTypes = Form::all()->pluck('name', 'id');

        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'form_id';
         return view('form.index', compact('forms', 'ascending', 'orderBy', 'formsTypes'));
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
        $forms = Form::where('field_type_id', $id)->get();
        $fieldType = FieldType::findOrFail($id);
        return view('form.show', compact('forms', 'fieldType', 'project_id'));
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

        return view("form.$form->name", compact('form', 'project_id', 'formValue'));
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
            'form_id' => ['required', 'exists:forms,id']
        ]);

        if ($validator->fails())
        {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }

        $input = $request->except('_method', '_token', 'form_id');

        $formValue = FormValue::create([
            'form_id' => $request->get('form_id'),
            'values' => $input,
        ]);

        $resp = [
            'message' => __('Formulário adicionado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('fields.forms.edit', ['form_value' => $formValue->id])->with($resp);
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
            'form_id' => ['required', 'exists:forms,id']
        ]);

        if ($validator->fails())
        {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }

        $formValue = FormValue::findOrFail($id);
        $input = $request->except('_method', '_token', 'form_id');

        $formValue->update([
            'values' => $input,
        ]);

        $resp = [
            'message' => __('Formulário atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('fields.forms.edit', ['form_value' => $formValue->id])->with($resp);
    }

    /**
     * Display a listing of the Ref.
     *
     * @param  Request  $request
     * @param int $id
     * @param string $project_id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $formValue = FormValue::findOrFail($id);
        $form = $formValue->form;
        $project_id = $formValue->values['project_id'];

        return view("form.$form->name", compact('form', 'project_id', 'formValue'));
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
        $forms = $forms->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('form.filter-result', compact('forms', 'orderBy', 'ascending'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $forms,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
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
        $validator = Validator::make(
            $request->all(),
            [
              'form_value_id' =>  ['required', 'exists:form_values,id'],
              'sample_index' => ['required']
            ]
        );

        if ($validator->fails())
        {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }

        $input = $request->except('_method', '_token', 'form_id');
        $formValue = FormValue::findOrFail($input['form_value_id']);

        $samples = $formValue->values;

        unset($samples['samples'][$input['sample_index']]);

        $formValue->values = $samples;
        $formValue->save();

        $resp = [
            'message' => __('Formulário atualizado com Sucesso!'),
            'alert-type' => 'success'
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
        $validator = Validator::make(
            $request->all(),
            [
              'form_value_id' =>  ['required', 'exists:form_values,id'],
              'sample_index' => ['required']
            ]
        );

        if ($validator->fails())
        {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }

        $input = $request->except('_method', '_token', 'form_id');
        $formValue = FormValue::findOrFail($input['form_value_id']);

        $samples = $formValue->values;


        $samples['samples'][$input['sample_index']]['equipment'] = $input['equipment'];
        $samples['samples'][$input['sample_index']]['point'] = $input['point'];
        $samples['samples'][$input['sample_index']]['environment'] = $input['environment'];
        $samples['samples'][$input['sample_index']]['collect'] = $input['collect'];

        if(isset($input['samples'][$input['sample_index']]['results']))
        {
            foreach ($input['samples'][$input['sample_index']]['results']  as $key => $value) {
                $samples['samples'][$input['sample_index']]['results'][$key]['temperature'] = $value['temperature'];
                $samples['samples'][$input['sample_index']]['results'][$key]['ph'] = $value['ph'];
                $samples['samples'][$input['sample_index']]['results'][$key]['eh'] = $value['eh'];
                $samples['samples'][$input['sample_index']]['results'][$key]['orp'] = $value['orp'];
                $samples['samples'][$input['sample_index']]['results'][$key]['conductivity'] = $value['conductivity'];
                $samples['samples'][$input['sample_index']]['results'][$key]['salinity'] = $value['salinity'];
                $samples['samples'][$input['sample_index']]['results'][$key]['psi'] = $value['psi'];
                $samples['samples'][$input['sample_index']]['results'][$key]['sat'] = $value['sat'];
                $samples['samples'][$input['sample_index']]['results'][$key]['conc'] = $value['conc'];

                $samples['samples'][$input['sample_index']]['results'][$key]['eh'] = $value['eh'];
                $samples['samples'][$input['sample_index']]['results'][$key]['ntu'] = $value['ntu'];
                $samples['samples'][$input['sample_index']]['results'][$key]['uncertainty'] = $value['uncertainty'];
            }
        }

        $formValue->values = $samples;
        $formValue->save();

        $resp = [
            'message' => __('Formulário atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return response()->json($resp);
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
        'form_value_id' =>  ['required', 'exists:form_values,id'],
        'sample_index' => ['required']
      ]
    );

    if ($validator->fails()) {
      return response()->json([
        'message' => implode("<br>", $validator->messages()->all()),
        'alert-type' => 'error'
      ], 403);
    }

    $inputs = $request->all();

    $formValue = FormValue::findOrFail($inputs['form_value_id']);

    $spreadsheet = IOFactory::load($request->file->path());
    $spreadsheet->setActiveSheetIndex(1);
    $worksheet = $spreadsheet->getActiveSheet();
    $rows = $worksheet->toArray();

    $samples = $formValue->values;

    foreach ($rows as $key => $value) {
        if ($key == 0) continue;
        //if ($key == 4) break;

        if(isset($value[2])) $samples['samples'][$inputs['sample_index']]['results'][$key - 1]['temperature'] = floatval($value[2]);
        if(isset($value[3])) $samples['samples'][$inputs['sample_index']]['results'][$key - 1]['ph'] = floatval($value[3]);
        if(isset($value[4])) $samples['samples'][$inputs['sample_index']]['results'][$key - 1]['orp'] = floatval($value[4]);
        if(isset($value[5])) $samples['samples'][$inputs['sample_index']]['results'][$key - 1]['conductivity'] = floatval($value[5]);
        if(isset($value[6])) $samples['samples'][$inputs['sample_index']]['results'][$key - 1]['salinity'] = floatval($value[6]);
        if(isset($value[7])) $samples['samples'][$inputs['sample_index']]['results'][$key - 1]['psi'] = floatval($value[7]);
        if(isset($value[8])) $samples['samples'][$inputs['sample_index']]['results'][$key - 1]['sat'] = floatval($value[8]);
        if(isset($value[9])) $samples['samples'][$inputs['sample_index']]['results'][$key - 1]['conc'] = floatval($value[9]);
        if(isset($value[10])) $samples['samples'][$inputs['sample_index']]['results'][$key - 1]['eh'] = floatval($value[10]);
        if(isset($value[11])) $samples['samples'][$inputs['sample_index']]['results'][$key - 1]['ntu'] = floatval($value[11]);
    }

    $formValue->values = $samples;
    $formValue->save();

    $resp = [
        'message' => __('Dados importados com sucesso!'),
        'alert-type' => 'success'
    ];

    return response()->json($resp);
 }
}
