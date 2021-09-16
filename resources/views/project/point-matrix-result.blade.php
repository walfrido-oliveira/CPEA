<thead>
    <tr class="thead-light">
        <x-table-sort-header :orderBy="null" :ascending="null" columnName="" columnText="<input class='form-checkbox' id='select_all_point_matrix' type='checkbox' value='all'>"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="campaign_id" columnText="{{ __('Campanha') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="area" columnText="{{ __('Área') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="identification" columnText="{{ __('Ponto') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="analysis_matrix_id" columnText="{{ __('Matriz') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="plan_action_level_id" columnText="{{ __('Tipo Nível Ação') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="guiding_parameter_id" columnText="{{ __('Param. Orientador Ambiental') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="parameter_analysis_id" columnText="{{ __('Param. Análise') }}"/>
        <th scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Ações
        </th>
    </tr>
</thead>
<tbody id="point_matrix_table_content">
    @forelse ($projectPointMatrices as $key => $projectPointMatrix)
        @include('project.saved-point-matrix', ['id' => $projectPointMatrix->id, 'key' => $key])
    @empty
    @endforelse
</tbody>
