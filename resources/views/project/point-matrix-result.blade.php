<thead>
    <tr class="thead-light">
        <x-table-sort-header :orderBy="null" :ascending="null" columnName="" columnText="<input class='form-checkbox' id='select_all_point_matrix' type='checkbox' value='all'>"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="area" columnText="{{ __('Área') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="identification" columnText="{{ __('Ponto') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="matriz_id" columnText="{{ __('Matriz') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="plan_action_level_id" columnText="{{ __('Tipo Nível Ação') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="guiding_parameters_id" columnText="{{ __('Param. Orientador Ambiental') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="analysis_parameter_id" columnText="{{ __('Param. Análise') }}"/>
        <th scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Ações
        </th>
    </tr>
</thead>
<tbody id="project_point_matrix_table_content">
    @forelse ($projectPointMatrices as $key => $projectPointMatrix)
        <tr>
            <td>
                <input class="form-checkbox project-point-matrix-url" type="checkbox" name="project_point_matrix[{{ $projectPointMatrix->id }}]" value="{!! route('project-point-matrix.destroy', ['projectPointMatrix' => $projectPointMatrix->id]) !!}">
            </td>
            <td>
                { $projectPointMatrix->pointIdentification->area }}
            </td>
            <td>
                { $projectPointMatrix->pointIdentification->identification }}
            </td>
            <td>
                { $projectPointMatrix->analysisMatrix->name }}
            </td>
            <td>
                { $projectPointMatrix->planActionLevel->name }}
            </td>
            <td>
                { $projectPointMatrix->guidingParameter->environmental_guiding_parameter_id }}
            </td>
            <td>
                { $projectPointMatrix->parameterAnalysis->analysis_parameter_name }}
            </td>
            <td>
                <a class="btn-transition-warning" href="{{ route('project-point-matrix.edit', ['projectPointMatrix' => $projectPointMatrix->id]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>

                <button class="btn-transition-danger delete-project-point-matrix" data-url="{!! route('project-point-matrix.destroy', ['projectPointMatrix' => $projectPointMatrix->id]) !!}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </td>
        <tr>
    @empty
    @endforelse
</tbody>
