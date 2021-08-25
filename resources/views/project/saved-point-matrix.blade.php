<tr id="point_matrix_row_{{ $key }}">
    <td>
        <input class="form-checkbox point-matrix-url" type="checkbox" name="point_matrix[{{ $projectPointMatrix->id }}]" value="{!! route('project.point-matrix.destroy', ['point_matrix' => $projectPointMatrix->id]) !!}" data-id="point_matrix_row_{{ $key }}">
        <input type="hidden" name="point_matrix[{{ $key }}][id]" id="point_matrix_{{ $key }}_id" value="{{ $projectPointMatrix->id }}">
    </td>
    <td>
        @if ($projectPointMatrix->pointIdentification)
            <a class="text-green-600 underline" href="{{ route('registers.point-identification.show', ['point_identification' => $projectPointMatrix->pointIdentification->id]) }}" target="_blank" rel="noopener noreferrer">
                {{ $projectPointMatrix->pointIdentification->area }}
            </a>
            <input type="hidden" name="point_matrix[{{ $key }}][point_identification_id]" id="point_matrix_{{ $key }}_point_identification_id" value="{{ $projectPointMatrix->pointIdentification->id }}">
            <input type="hidden" name="point_matrix[{{ $key }}][area]" id="point_matrix_{{ $key }}_area" value="{{ $projectPointMatrix->pointIdentification->area }}">
        @endif
    </td>
    <td>
        @if ($projectPointMatrix->pointIdentification)
            <a class="text-green-600 underline" href="{{ route('registers.point-identification.show', ['point_identification' => $projectPointMatrix->pointIdentification->id]) }}" target="_blank" rel="noopener noreferrer">
                {{ $projectPointMatrix->pointIdentification->identification }}
            </a>
        @endif
    </td>
    <td>
        @if ($projectPointMatrix->analysisMatrix)
            {{ $projectPointMatrix->analysisMatrix->name }}
            <input type="hidden" name="point_matrix[{{ $key }}][analysis_matrix_id]" id="point_matrix_{{ $key }}_analysis_matrix_id" value="{{ $projectPointMatrix->analysisMatrix->id }}">
        @endif
    </td>
    <td>
        @if ($projectPointMatrix->planActionLevel)
            {{ $projectPointMatrix->planActionLevel->name }}
            <input type="hidden" name="point_matrix[{{ $key }}][plan_action_level_id]" id="point_matrix_{{ $key }}_plan_action_level_id" value="{{ $projectPointMatrix->planActionLevel->id }}">
        @endif
    </td>
    <td>
        @if ($projectPointMatrix->guidingParameter)
            {{ $projectPointMatrix->guidingParameter->environmental_guiding_parameter_id }}
            <input type="hidden" name="point_matrix[{{ $key }}][guiding_parameter_id]" id="point_matrix_{{ $key }}_guiding_parameter_id" value="{{ $projectPointMatrix->guidingParameter->id }}">
        @endif
    </td>
    <td>
        @if ($projectPointMatrix->parameterAnalysis)
            {{ $projectPointMatrix->parameterAnalysis->analysis_parameter_name }}
            <input type="hidden" name="point_matrix[{{ $key }}][parameter_analysis_id]" id="point_matrix_{{ $key }}_parameter_analysis_id" value="{{ $projectPointMatrix->parameterAnalysis->id }}">
        @endif
    </td>
    <td>
        <div class="edit inline">
            @include('project.edit-icon')
        </div>
        <div class="edit inline">
            <button type="button" class="btn-transition-danger delete-point-matrix" data-type="edit" id="point_matrix_{{ $projectPointMatrix->id }}" data-url="{!! route('project.point-matrix.destroy', ['point_matrix' => $projectPointMatrix->id]) !!}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </div>
    </td>
<tr>
