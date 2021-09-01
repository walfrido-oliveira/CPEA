<thead>
    <tr class="thead-light">
        <x-table-sort-header :orderBy="null" :ascending="null" columnName="" columnText="<input class='form-checkbox' id='select_all_campaign' type='checkbox' value='all'>"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="name" columnText="{{ __('Campanha') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="identification" columnText="{{ __('Identificação Ponto (Matriz)') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="date_collection" columnText="{{ __('DT/HR da Coleta') }}"/>
        <th scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Ações
        </th>
    </tr>
</thead>
<tbody id="campaign_table_content">
    @forelse ($projectCampaigns as $key => $projectCampaign)
        <tr id="campaign_row_{{ $key }}">
            <td>
                <input class="form-checkbox campaign-url" type="checkbox" name="campaign[{{ $projectCampaign->id }}]" value="{!! route('project.campaign.destroy', ['campaign' => $projectCampaign->id]) !!}" data-id="campaign_row_{{ $key }}">
                <input type="hidden" name="campaign[{{ $key }}][id]" id="campaign_{{ $key }}_id" value="{{ $projectCampaign->id }}">
            </td>
            <td>
                {{ $projectCampaign->name }}
                @include('project.campaign-row-fields')
            </td>
            <td>
                @if ($projectCampaign->projectPointMatrix)

                    @if ($projectCampaign->projectPointMatrix->pointIdentification)
                        {{ $projectCampaign->projectPointMatrix->pointIdentification->identification }},
                    @endif

                    @if ($projectCampaign->projectPointMatrix->analysisMatrix)
                        {{ $projectCampaign->projectPointMatrix->analysisMatrix->name }},
                    @endif

                    @if ($projectCampaign->projectPointMatrix->planActionLevel)
                        {{ $projectCampaign->projectPointMatrix->planActionLevel->name }},
                    @endif

                    @if ($projectCampaign->projectPointMatrix->guidingParameter)
                        {{ $projectCampaign->projectPointMatrix->guidingParameter->environmental_guiding_parameter_id }},
                    @endif

                    @if ($projectCampaign->projectPointMatrix->parameterAnalysis)
                        {{ $projectCampaign->projectPointMatrix->parameterAnalysis->analysis_parameter_name }},
                    @endif

                    <input type="hidden" name="campaign[{{ $key }}][campaign_point_matrix]" id="campaign_{{ $key }}_campaign_point_matrix" value="{{ $projectCampaign->projectPointMatrix->id }}">
                @endif
            </td>
            <td>
                {{ $projectCampaign->date_collection->format('d/m/Y H:m') }}
                <input type="hidden" name="campaign[{{ $key }}][date_collection]" id="campaign_{{ $key }}_date_collection" value="{{ $projectCampaign->date_collection->format('Y-m-d\TH:m')  }}">
            </td>
            <td>
                <div class="edit inline">
                    @include('project.edit-icon', ['key' => $key, 'id' => $projectCampaign->id, 'className' => 'edit-campaign'])
                </div>
                <div class="delete inline">
                    <button type="button" class="btn-transition-danger delete-campaign" data-type="edit" id="campaign_{{ $projectCampaign->id }}"
                            data-url="{!! route('project.campaign.destroy', ['campaign' => $projectCampaign->id]) !!}" data-id="campaign_row_{{ $key }}">
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
