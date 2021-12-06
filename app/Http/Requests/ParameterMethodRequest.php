<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParameterMethodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'analysis_matrix_id' => ['required', 'exists:analysis_matrices,id'],
            'parameter_analysis_id' => ['required', 'exists:parameter_analyses,id'],
            'preparation_method_id' => ['required', 'exists:preparation_methods,id'],
            'analysis_method_id' => ['required', 'exists:analysis_methods,id'],
            'time_preparation' => ['required', 'numeric', 'max:999'],
            'time_analysis' => ['required', 'numeric', 'max:999']
        ];
    }
}
