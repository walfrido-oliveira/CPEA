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
        @include('project.campaign.saved-point-matrix', ['id' => $projectPointMatrix->id])
    @empty
    @endforelse
</tbody>
