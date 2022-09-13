<thead>
    <tr class="thead-light">
        <x-table-sort-header :orderBy="null" :ascending="null" columnName="" columnText="{{ __('') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="parameter_analysis_id" columnText="{{ __('Param. Análise') }}"/>
        <x-table-sort-header :orderBy="null" :ascending="null" columnName="" columnText="{{ __('Formulá') }}"/>
        <th scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Ações
        </th>
    </tr>
</thead>
<tbody id="calculation_parameter_table_content">
    @forelse ($calculationParameters as $key => $calculationParameter)
        <tr>
            <td>
                <input class="form-checkbox calculation-parameter-url" type="checkbox" name="calculation_parameter[{{ $calculationParameter->id }}]" value="{!! route('registers.calculation-parameter.destroy', ['calculation_parameter' => $calculationParameter->id]) !!}">
            </td>
            <td>
                <a class="text-item-table" href="{{ route('registers.calculation-parameter.show', ['calculation_parameter' => $calculationParameter->id]) }}">
                    {{ $calculationParameter->parameterAnalysis ? $calculationParameter->parameterAnalysis->analysis_parameter_name : '' }}
                </a>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('registers.calculation-parameter.show', ['calculation_parameter' => $calculationParameter->id]) }}">{{ $calculationParameter->formula }}</a>
            </td>
            <td>
                <a class="btn-transition-warning" href="{{ route('registers.calculation-parameter.edit', ['calculation_parameter' => $calculationParameter->id]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </a>
                <button class="btn-transition-danger delete-calculation-parameter" data-url="{!! route('registers.calculation-parameter.destroy', ['calculation_parameter' => $calculationParameter->id]) !!}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </td>
        <tr>
    @empty
        <tr>
            <td class="text-center" colspan="5">{{ __("Nenhuma Param. Fórmula Cálculo encontrada") }}</td>
        </tr>
    @endforelse
</tbody>
