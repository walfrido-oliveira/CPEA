<thead>
    <tr class="thead-light">
        @if($actions == 'show') <x-table-sort-header :orderBy="null" :ascending="null" columnName="" columnText="<input class='form-checkbox' id='select_all_campaign' type='checkbox' value='all'>"/> @endif
        @if($actions == 'hidden') <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="projects.project_cod" columnText="{{ __('Projeto') }}"/> @endif
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="name" columnText="{{ __('Campanha') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="campaign_status_id" columnText="{{ __('Status') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="date_collection" columnText="{{ __('DT/HR da Coleta') }}"/>
        @if($actions == 'show')
            <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Ações
            </th>
        @endif
    </tr>
</thead>
<tbody id="campaign_table_content">
    @forelse ($projectCampaigns as $key => $projectCampaign)
        @include('project.saved-campaign', ['id' => $projectCampaign->id, 'key' => $key])
    @empty
    @endforelse
</tbody>
