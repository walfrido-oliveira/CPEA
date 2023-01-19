<thead>
    <tr class="thead-light">
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="id" columnText="{{ __('#') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="form_id" columnText="{{ __('Formulário') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="project_id" columnText="{{ __('Projeto') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="matrix" columnText="{{ __('Matriz') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="created_at" columnText="{{ __('DT Cadastro') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="updated_at" columnText="{{ __('DT Atualização') }}"/>
        <th scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Ações
        </th>
    </tr>
</thead>
<tbody id="ref_table_content">
    @forelse ($forms as $key => $form)
        <tr>
            <td>#{{ str_pad($form->id, 5, '0', STR_PAD_LEFT)}}</td>
            <td>{{ $form->form->name }}</td>
            <td>{{ isset($form->values['project_id']) ? $form->values['project_id'] : '' }}</td>
            <td>{{ isset($form->values['matrix']) ? App\Models\FieldType::find($form->values['matrix'])->name : '-' }}</td>
            <td>{{ $form->created_at ? $form->created_at->format("d/m/Y") : '-' }}</td>
            <td>{{ $form->updated_at ? $form->updated_at->format("d/m/Y") : '-' }}</td>
            <td>
                <a class="btn-transition-warning" href="{{ route('fields.form-values.edit', ['form_value' => $form->id]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </a>
            </td>
        <tr>
    @empty
        <tr>
            <td class="text-center" colspan="5">{{ __("Nenhum resultado encontrado") }}</td>
        </tr>
    @endforelse
</tbody>
