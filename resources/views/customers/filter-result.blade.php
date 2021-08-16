<thead>
    <tr class="thead-light">
        @if($actions == 'show') <x-table-sort-header :orderBy="null" :ascending="null" columnName="" columnText="{{ __('') }}"/> @endif
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="id" columnText="{{ __('#') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="name" columnText="{{ __('Nome') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="status" columnText="{{ __('Status') }}"/>
        @if($actions == 'show')
            <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Ações
            </th>
        @endif
    </tr>
</thead>
<tbody id="customers_table_content">
    @forelse ($customers as $key => $customer)
        <tr>
            @if($actions == 'show')
                <td>
                    <input class="form-checkbox customer-url" type="checkbox" name="customer[{{ $customer->id }}]" value="{!! route('customers.destroy', ['customer' => $customer->id]) !!}">
                </td>
            @endif

            <td>
                <a class="text-item-table" href="{{ route('customers.show', ['customer' => $customer->id]) }}">{{ $customer->id }}</a>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('customers.show', ['customer' => $customer->id]) }}">{{ $customer->name }}</a>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('customers.show', ['customer' => $customer->id]) }}">
                    <span class="w-24 py-1 @if($customer->status == "active") badge-success @elseif($customer->status == 'inactive') badge-danger @endif" >
                        {{ __($customer->status) }}
                    </span>
                </a>
            </td>
            @if($actions == 'show')
                <td>
                    <a class="btn-transition-warning" href="{{ route('customers.edit', ['customer' => $customer->id]) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </a>
                    <button class="btn-transition-danger delete-customer" data-url="{!! route('customers.destroy', ['customer' => $customer->id]) !!}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </td>
            @endif
        <tr>
    @empty
        <tr>
            <td class="text-center" colspan="5">{{ __("Nenhum cliente encontrado") }}</td>
        </tr>
    @endforelse
</tbody>
