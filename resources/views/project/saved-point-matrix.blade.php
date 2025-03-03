<tr id="point_matrix_row_{{ $key }}" class="point-matrix-row">
    <td>
        <input class="form-checkbox point-matrix-url" type="checkbox" name="point_matrix[{{ $projectPointMatrix->id }}]" value="{!! route('project.point-matrix.destroy', ['point_matrix' => $projectPointMatrix->id]) !!}" data-id="point_matrix_row_{{ $key }}">
        <input type="hidden" name="point_matrix[{{ $key }}][id]" id="point_matrix_{{ $key }}_id" value="{{ $projectPointMatrix->id }}">
        <input type="hidden" name="point_matrix[{{ $key }}][campaign_id]" id="point_matrix_{{ $key }}_campaign_id" value="{{ $projectPointMatrix->campaign_id }}">
        <input type="hidden" name="point_matrix[{{ $key }}][parameter_method_preparation_id]" id="point_matrix_{{ $key }}_parameter_method_preparation_id" value="{{ $projectPointMatrix->parameter_method_preparation_id }}">
        <input type="hidden" name="point_matrix[{{ $key }}][parameter_method_analysis_id]" id="point_matrix_{{ $key }}_parameter_method_analysis_id" value="{{ $projectPointMatrix->parameter_method_analysis_id }}">
        @include('project.project-point-matrix-row-fields')
    </td>
    <td>
        <a class="text-green-600 underline" href="{{ route('project.campaign.show', ['campaign' => $projectPointMatrix->campaign->id]) }}" target="_blank" rel="noopener noreferrer">
            {{ $projectPointMatrix->campaign->name }}
        </a>
    </td>
    <td>
        <input type="hidden" name="point_matrix[{{ $key }}][point_identification_id]" id="point_matrix_{{ $key }}_point_identification_id" value="{{ $projectPointMatrix->pointIdentification ? $projectPointMatrix->pointIdentification->id : null }}">
            <input type="hidden" name="point_matrix[{{ $key }}][area]" id="point_matrix_{{ $key }}_area" value="{{ $projectPointMatrix->pointIdentification ? $projectPointMatrix->pointIdentification->area : null }}">
        @if ($projectPointMatrix->pointIdentification)
            <a class="text-green-600 underline" href="{{ route('registers.point-identification.show', ['point_identification' => $projectPointMatrix->pointIdentification->id]) }}" target="_blank" rel="noopener noreferrer">
                {{ $projectPointMatrix->pointIdentification->area }} - {{ $projectPointMatrix->pointIdentification->identification }}
            </a>
        @endif
    </td>
    <td>
        <input type="hidden" name="point_matrix[{{ $key }}][analysis_matrix_id]" id="point_matrix_{{ $key }}_analysis_matrix_id" value="{{ $projectPointMatrix->analysisMatrix ? $projectPointMatrix->analysisMatrix->id : null }}">
        @if ($projectPointMatrix->analysisMatrix)
            {{ $projectPointMatrix->analysisMatrix->name }}
        @endif
    </td>
    <td>
        @if ($projectPointMatrix->parameterAnalysis)
            {{ $projectPointMatrix->parameterAnalysis->parameterAnalysisGroup->name }}
        @endif
    </td>
    <td>
        <input type="hidden" name="point_matrix[{{ $key }}][guiding_parameter_id]" id="point_matrix_{{ $key }}_guiding_parameter_id"
        value="{{ $projectPointMatrix->guidingParameters ? implode(",", $projectPointMatrix->guidingParameters()->pluck('guiding_parameters.id')->toArray()) : null }}">
        @if ($projectPointMatrix->guidingParameters)
            {!! implode("<br/>", $projectPointMatrix->guidingParameters()->pluck('environmental_guiding_parameter_id')->toArray()) !!}
        @endif
    </td>
    <td>
        <input type="hidden" name="point_matrix[{{ $key }}][parameter_analysis_id]" id="point_matrix_{{ $key }}_parameter_analysis_id" value="{{ $projectPointMatrix->parameterAnalysis ? $projectPointMatrix->parameterAnalysis->id : null }}">
        @if ($projectPointMatrix->parameterAnalysis)
            {{ $projectPointMatrix->parameterAnalysis->analysis_parameter_name }}
        @endif
    </td>
    <td>
        <input type="hidden" name="point_matrix_[{{ $key }}][date_collection]" id="point_matrix_{{ $key }}_date_collection" value="{{ $projectPointMatrix->date_collection->format('Y-m-d\TH:i')  }}">
        {{ $projectPointMatrix->date_collection->format('d/m/Y H:i') }}
    </td>
    <td>
        <div class="edit inline">
            @include('project.edit-point-matrix-icon', ['key' => $key, 'id' => $projectPointMatrix->id, 'className' => 'edit-point-matrix'])
        </div>
        <div class="delete inline">
            <button type="button" class="btn-transition-danger delete-point-matrix" data-type="edit" id="point_matrix_{{ $projectPointMatrix->id }}" data-url="{!! route('project.point-matrix.destroy', ['point_matrix' => $projectPointMatrix->id]) !!}" data-id="point_matrix_row_{{ $key }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </div>
        <div class="duplicate inline">
            <button type="button" class="btn-transition-primary duplicate-point-matrix"
                    data-row="{{ $key }}" data-type="duplicate" data-id="{{ $id }}" x-on:click="open">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
            </button>
        </div>
    </td>
<tr>
