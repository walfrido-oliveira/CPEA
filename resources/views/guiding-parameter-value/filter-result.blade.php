<thead>
    <tr class="thead-light">
        <x-table-sort-header :orderBy="null" :ascending="null" columnName="" columnText="{{ __('') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="guiding_parameter_id" columnText="{{ __('Param. Orietador Ambiental') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="analysis_matrix_id" columnText="{{ __('Matriz') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="parameter_analysis_id" columnText="{{ __('Param. Análise') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="guiding_parameter_ref_value_id" columnText="{{ __('Ref. Param. Valor Orientador') }}"/>
        <th scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Ações
        </th>
    </tr>
</thead>
<tbody id="guiding_parameter_value_table_content">
    @forelse ($guidingParameterValues as $key => $guidingParameterValue)
        {{ $guidingParameterValue->guidingParameter->name }}
        <tr>
            <td>
                <input class="form-checkbox guiding-parameter-value-url" type="checkbox" name="guiding-parameter-value[{{ $guidingParameterValue->id }}]" value="{!! route('guiding-parameter-value.destroy', ['guiding_parameter_value' => $guidingParameterValue->id]) !!}">
            </td>
            <td>
                @if ($guidingParameterValue->guidingParamete)
                    <a class="text-item-table" href="{{ route('guiding-parameter-value.show', ['guiding_parameter_value' => $guidingParameterValue->id]) }}">{{ $guidingParameterValue->guidingParameter->name }}</a>
                @endif
            </td>
            <td>
                <a class="text-item-table" href="{{ route('guiding-parameter-value.show', ['guiding_parameter_value' => $guidingParameterValue->id]) }}">{{ $guidingParameterValue->analysisMatrix->name }}</a>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('guiding-parameter-value.show', ['guiding_parameter_value' => $guidingParameterValue->id]) }}">{{ $guidingParameterValue->parameterAnalysis->analysis_parameter_name }}</a>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('guiding-parameter-value.show', ['guiding_parameter_value' => $guidingParameterValue->id]) }}">
                    @if ($guidingParameterValue->guidingParameterRefValue)
                        {{ $guidingParameterValue->guidingParameterRefValue->guiding_parameter_ref_value_id }}
                    @endif
                </a>
            </td>
            <td>
                <a class="btn-transition-warning" href="{{ route('guiding-parameter-value.edit', ['guiding_parameter_value' => $guidingParameterValue->id]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </a>
                <button class="btn-transition-danger delete-guiding-parameter-value" data-url="{!! route('guiding-parameter-value.destroy', ['guiding_parameter_value' => $guidingParameterValue->id]) !!}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </td>
        <tr>
    @empty
        <tr>
            <td class="text-center" colspan="5">{{ __("Nenhum resultado encontrado") }}</td>
        </tr>
    @endforelse
</tbody>
