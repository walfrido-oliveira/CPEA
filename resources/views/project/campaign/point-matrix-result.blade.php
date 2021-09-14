<thead>
    <tr class="thead-light">
        <x-table-sort-header :orderBy="null" :ascending="null" columnName="" columnText="<input class='form-checkbox' id='select_all_point_matrix' type='checkbox' value='all'>"/>
        <x-table-sort-header :orderBy="null" :ascending="null" columnName="" columnText="{{ __('') }}"/>
        <th scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Ações
        </th>
    </tr>
</thead>
<tbody id="point_matrix_table_content">
    @forelse ($projectPointMatrices as $key => $projectPointMatrix)
        <tr id="point_matrix_row_{{ $key }}" class="point-matrix-row">
            <td width="5%">
                <input class="form-checkbox point-matrix-url" type="checkbox" name="point_matrix[{{ $projectPointMatrix->id }}]" value="{!! route('project.point-matrix.destroy', ['point_matrix' => $projectPointMatrix->id]) !!}" data-id="point_matrix_row_{{ $key }}">
                <input type="hidden" name="point_matrix[{{ $key }}][id]" id="point_matrix_{{ $key }}_id" value="{{ $projectPointMatrix->id }}">
            </td>
            <td>
                <input type="hidden" name="point_matrix[{{ $key }}][point_identification_id]" id="point_matrix_{{ $key }}_point_identification_id" value="{{ $projectPointMatrix->pointIdentification ? $projectPointMatrix->pointIdentification->id : null }}">
                    <input type="hidden" name="point_matrix[{{ $key }}][area]" id="point_matrix_{{ $key }}_area" value="{{ $projectPointMatrix->pointIdentification ? $projectPointMatrix->pointIdentification->area : null }}">
                @if ($projectPointMatrix->pointIdentification)
                    <div class="grid grid-flow-col grid-cols-2 grid-rows-2 gap-4" style="grid-template-rows: repeat(7, minmax(0, 1fr));">
                        <div class="font-bold text-right">
                            {{ __('Área') }}
                        </div>
                        <div class="font-bold text-right">
                            {{ __('Ponto') }}
                        </div>
                        <div class="font-bold text-right">
                            {{ __('Matriz') }}
                        </div>
                        <div class="font-bold text-right">
                            {{ __('Tipo Nível Ação Plano') }}
                        </div>
                        <div class="font-bold text-right">
                            {{ __('Param. Orientador Ambiental') }}
                        </div>
                        <div class="font-bold text-right">
                            {{ __('Param. Análise') }}
                        </div>
                        <div class="font-bold text-right">
                            {{ __('Idet Lab Amostra') }}
                        </div>
                        <div class="text-gray-500 font-bold">
                            <a class="text-green-600 underline" href="{{ route('registers.point-identification.show', ['point_identification' => $projectPointMatrix->pointIdentification->id]) }}" target="_blank" rel="noopener noreferrer">
                                {{ $projectPointMatrix->pointIdentification->area }}
                            </a>
                        </div>
                        <div class="text-gray-500 font-bold">
                            @if ($projectPointMatrix->pointIdentification)
                                <a class="text-green-600 underline" href="{{ route('registers.point-identification.show', ['point_identification' => $projectPointMatrix->pointIdentification->id]) }}" target="_blank" rel="noopener noreferrer">
                                    {{ $projectPointMatrix->pointIdentification->identification }}
                                </a>
                            @endif
                        </div>
                        <div class="text-gray-500 font-bold">
                            <input type="hidden" name="point_matrix[{{ $key }}][analysis_matrix_id]" id="point_matrix_{{ $key }}_analysis_matrix_id" value="{{ $projectPointMatrix->analysisMatrix ? $projectPointMatrix->analysisMatrix->id : null }}">
                            @if ($projectPointMatrix->analysisMatrix)
                                {{ $projectPointMatrix->analysisMatrix->name }}
                            @endif
                        </div>
                        <div class="text-gray-500 font-bold">
                            <input type="hidden" name="point_matrix[{{ $key }}][plan_action_level_id]" id="point_matrix_{{ $key }}_plan_action_level_id" value="{{ $projectPointMatrix->planActionLevel ? $projectPointMatrix->planActionLevel->id : null }}">
                            @if ($projectPointMatrix->planActionLevel)
                                {{ $projectPointMatrix->planActionLevel->name }}
                            @endif
                        </div>
                        <div class="text-gray-500 font-bold">
                            <input type="hidden" name="point_matrix[{{ $key }}][guiding_parameter_id]" id="point_matrix_{{ $key }}_guiding_parameter_id" value="{{ $projectPointMatrix->guidingParameter ? $projectPointMatrix->guidingParameter->id : null }}">
                            @if ($projectPointMatrix->guidingParameter)
                                {{ $projectPointMatrix->guidingParameter->environmental_guiding_parameter_id }}
                            @endif
                        </div>
                        <div class="text-gray-500 font-bold">
                            <input type="hidden" name="point_matrix[{{ $key }}][parameter_analysis_id]" id="point_matrix_{{ $key }}_parameter_analysis_id" value="{{ $projectPointMatrix->parameterAnalysis ? $projectPointMatrix->parameterAnalysis->id : null }}">
                            @if ($projectPointMatrix->parameterAnalysis)
                                {{ $projectPointMatrix->parameterAnalysis->analysis_parameter_name }}
                            @endif
                        </div>
                        <div class="text-gray-500 font-bold">
                            {{ '-' }}
                        </div>
                    </div>
                @endif
            </td>
            <td width="20%">
                <div class="edit inline">
                    @include('project.edit-icon', ['key' => $key, 'id' => $projectPointMatrix->id, 'className' => 'edit-point-matrix'])
                </div>
                <div class="delete inline">
                    <button type="button" class="btn-transition-danger delete-point-matrix" data-type="edit" id="point_matrix_{{ $projectPointMatrix->id }}" data-url="{!! route('project.point-matrix.destroy', ['point_matrix' => $projectPointMatrix->id]) !!}" data-id="point_matrix_row_{{ $key }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </td>
        <tr>
    @empty
    @endforelse
</tbody>
