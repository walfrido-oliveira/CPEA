<thead>
    <tr class="thead-light">
        <x-table-sort-header :orderBy="null" :ascending="null" columnName="" columnText="{{ __('') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="unity_cod" columnText="{{ __('Cod. Unidade') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="name" columnText="{{ __('Nome Unidade') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="conversion_amount" columnText="{{ __('Qtde. Conversão') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="unity_id" columnText="{{ __('Unidade Conversão') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="created_at" columnText="{{ __('DT Cadastro') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="updated_at" columnText="{{ __('DT Atualização') }}"/>
        <th scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Ações
        </th>
    </tr>
</thead>
<tbody id="unitys_table_content">
    @forelse ($unities as $key => $unity)
        <tr>
            <td>
                <input class="form-checkbox unity-url" type="checkbox" name="unity[{{ $unity->id }}]" value="{!! route('registers.unity.destroy', ['unity' => $unity->id]) !!}">
            </td>
            <td>
                <a class="text-item-table" href="{{ route('registers.unity.show', ['unity' => $unity->id]) }}">{{ $unity->unity_cod }}</a>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('registers.unity.show', ['unity' => $unity->id]) }}">{{ $unity->name }}</a>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('registers.unity.show', ['unity' => $unity->id]) }}">
                    @if($unity->conversion_amount) {{ number_format($unity->conversion_amount, 5, ",", ".") }} @endif
                </a>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('registers.unity.show', ['unity' => $unity->id]) }}">{{ $unity->unity ? $unity->unity->unity_cod : '' }}</a>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('registers.unity.show', ['unity' => $unity->id]) }}">{{ $unity->created_at->format("d/m/Y") }}</a>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('registers.unity.show', ['unity' => $unity->id]) }}">{{ $unity->updated_at->format("d/m/Y") }}</a>
            </td>
            <td>
                <a class="btn-transition-warning" href="{{ route('registers.unity.edit', ['unity' => $unity->id]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </a>
                <button class="btn-transition-danger delete-unity" data-url="{!! route('registers.unity.destroy', ['unity' => $unity->id]) !!}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </td>
        <tr>
    @empty
        <tr>
            <td class="text-center" colspan="5">{{ __("Nenhum unidade encontrado") }}</td>
        </tr>
    @endforelse
</tbody>
