<tr id="campaign_row_{{ $key }}">
    @if($actions == 'show')
        <td>
            <input class="form-checkbox campaign-url" type="checkbox" name="campaign[{{ $projectCampaign->id }}]" value="{!! route('project.campaign.destroy', ['campaign' => $projectCampaign->id]) !!}" data-id="campaign_row_{{ $key }}">
            <input type="hidden" name="campaign[{{ $key }}][id]" id="campaign_{{ $key }}_id" value="{{ $projectCampaign->id }}">
            <input type="hidden" name="campaign[{{ $key }}][campaign_name]" id="campaign_{{ $key }}_campaign_name" value="{{ $projectCampaign->name }}">
            <input type="hidden" name="campaign[{{ $key }}][campaign_status]" id="campaign_{{ $key }}_campaign_status" value="{{ $projectCampaign->campaignStatus->id }}">
        </td>
    @endif

    @if($actions == 'hidden')
        <td>
            {{ $projectCampaign->project->project_cod }}
        </td>
    @endif

    <td>
        <a class="text-green-600 underline text-item-table" href="{{ route('project.campaign.show', ['campaign' => $projectCampaign->id]) }}">
            {{ $projectCampaign->name }}
        </a>
    </td>
    <td>
        {{ $projectCampaign->campaignStatus->name }}
    </td>
    @if($actions == 'show')
        <td>
            <div class="result inline">
                <a href="{{ route('sample-analysis.show', ['campaign' => $projectCampaign->id]) }}" class="btn-transition text-purple-900" data-row="{{ $key }}" data-type="result" data-id="{{ $id }}" title="Análise de Amostrar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </a>
            </div>
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
    @endif
<tr>
