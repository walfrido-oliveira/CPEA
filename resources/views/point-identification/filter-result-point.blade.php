<thead>
    <tr class="thead-light">
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="projects.project_cod" columnText="{{ __('Projeto') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="name" columnText="{{ __('Campanha') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="analysis_matrices.name" columnText="{{ __('Matriz') }}"/>
        <x-table-sort-header :orderBy="null" :ascending="null" columnName="" columnText="{{ __('Param. Orientador Ambiental') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="parameter_analyses.analysis_parameter_name" columnText="{{ __('Param. Análise') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="project_point_matrices.date_collection" columnText="{{ __('DT/HR Coleta') }}"/>
    </tr>
</thead>
<tbody id="campaign_table_content">
    @forelse ($projectCampaigns as $key => $projectCampaign)
        @foreach ($projectCampaign->projectPointMatrices as $point)
            <tr id="campaign_row_{{ $key }}">
                <td>
                    {{ $projectCampaign->project->project_cod }}
                </td>
                <td>
                    <a class="text-green-600 underline text-item-table" href="{{ route('project.campaign.show', ['campaign' => $projectCampaign->id]) }}">
                        {{ $projectCampaign->name }}
                    </a>
                </td>
                <td>
                    @if ($point->analysisMatrix)
                        {{ $point->analysisMatrix->name }}
                    @endif
                </td>
                <td>
                    @if ($point->guidingParameters)
                        {!! implode("<br/>", $point->guidingParameters()->pluck('environmental_guiding_parameter_id')->toArray()) !!}
                    @endif
                </td>
                <td>
                    @if ($point->parameterAnalysis)
                        {{ $point->parameterAnalysis->analysis_parameter_name }}
                    @endif
                </td>
                <td>
                    {{ $point->date_collection->format('d/m/Y H:m') }}
                </td>
            <tr>
        @endforeach
    @empty
    @endforelse
</tbody>
