<tr id="campaign_row_{{ $key }}">
    <td>
        <input class="form-checkbox campaign-url" type="checkbox" name="campaign[{{ $projectCampaign->id }}]" value="{!! route('project.campaign.destroy', ['campaign' => $projectCampaign->id]) !!}" data-id="campaign_row_{{ $key }}">
        <input type="hidden" name="campaign[{{ $key }}][id]" id="campaign_{{ $key }}_id" value="{{ $projectCampaign->id }}">
    </td>
    <td>
        {{ $projectCampaign->name }}
        <input type="hidden" name="campaign[{{ $key }}][campaign_name]" id="campaign_{{ $key }}_campaign_name" value="{{ $projectCampaign->name }}">
        <input type="hidden" name="campaign[{{ $key }}][campaign_status]" id="campaign_{{ $key }}_campaign_status" value="{{ $projectCampaign->campaignStatus->id }}">
        <input type="hidden" name="campaign[{{ $key }}][refq]" id="campaign_{{ $key }}_refq" value="{{ $projectCampaign->refq }}">
        <input type="hidden" name="campaign[{{ $key }}][tide]" id="campaign_{{ $key }}_tide" value="{{ $projectCampaign->tide }}">
        <input type="hidden" name="campaign[{{ $key }}][environmental_conditions]" id="campaign_{{ $key }}_environmental_conditions" value="{{ $projectCampaign->environmental_conditions }}">
        <input type="hidden" name="campaign[{{ $key }}][utm]" id="campaign_{{ $key }}_utm" value="{{ $projectCampaign->utm }}">
        <input type="hidden" name="campaign[{{ $key }}][water_depth]" id="campaign_{{ $key }}_water_depth" value="{{ $projectCampaign->water_depth }}">
        <input type="hidden" name="campaign[{{ $key }}][sample_depth]" id="campaign_{{ $key }}_sample_depth" value="{{ $projectCampaign->sample_depth }}">
        <input type="hidden" name="campaign[{{ $key }}][environmental_regime]" id="campaign_{{ $key }}_environmental_regime" value="{{ $projectCampaign->environmental_regime }}">
        <input type="hidden" name="campaign[{{ $key }}][secchi_record]" id="campaign_{{ $key }}_secchi_record" value="{{ $projectCampaign->secchi_record }}">
        <input type="hidden" name="campaign[{{ $key }}][floating_materials]" id="campaign_{{ $key }}_floating_materials" value="{{ $projectCampaign->floating_materials }}">
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
            <button type="button" class="btn-transition-danger delete-campaign" id="campaign_{{ $projectCampaign->id }}" data-url="{!! route('project.campaign.destroy', ['campaign' => $projectCampaign->id]) !!}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </div>
    </td>
<tr>
