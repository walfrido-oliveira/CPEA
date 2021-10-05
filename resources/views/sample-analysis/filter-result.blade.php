<thead>
    <tr class="thead-light">
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="projects.customer_id" columnText="{{ __('Cliente') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="projects.project_cod" columnText="{{ __('Projeto') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="campaigns.name" columnText="{{ __('Campanha') }}"/>
        <x-table-sort-header :orderBy="null" :ascending="null" columnName="" columnText="{{ __('Laboratório') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="status" columnText="{!! __('Status') !!}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="updated_at" columnText="{!! __('Modificação') !!}"/>
    </tr>
</thead>
<tbody id="project_table_content">

    @forelse ($projetcs as $key => $campaign)
        <tr>
            <td>
                @if ($campaign->project->customer)
                    <a class="text-item-table" href="{{ route('sample-analysis.show', ['campaign' => $campaign->id]) }}">{{ $campaign->project->customer->name }}</a>
                @endif
            </td>
            <td>
                <a class="text-item-table" href="{{ route('sample-analysis.show', ['campaign' => $campaign->id]) }}">{{ $campaign->project->project_cod }}</a>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('sample-analysis.show', ['campaign' => $campaign->id]) }}">
                    {{ $campaign->name }}
                </a>
            </td>
            <td>-</td>
            <td>
                <a class="text-item-table" href="{{ route('sample-analysis.show', ['campaign' => $campaign->id]) }}">
                    @switch($campaign->project->status)
                        @case("sent")
                            <span class="w-24 py-1 badge-light-primary">{{ __($campaign->project->status) }}</span>
                            @break
                        @case("pending")
                            <span class="w-24 py-1 badge-light-danger">{{ __($campaign->project->status) }}</span>
                            @break
                        @case("analyzing")
                            <span class="w-24 py-1 badge-light-warning">{{ __($campaign->project->status) }}</span>
                            @break
                        @case("concluded")
                            <span class="w-24 py-1 badge-light-success">{{ __($campaign->project->status) }}</span>
                            @break
                        @default
                    @endswitch
                </a>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('sample-analysis.show', ['campaign' => $campaign->id]) }}">
                    <span class="block">{{ $campaign->project->updated_at->format('d/m/Y') }}</span>
                    <span class="block">{{ $campaign->project->updated_at->format('h:m') }}</span>
                </a>
            </td>
        <tr>
    @empty
        <tr>
            <td class="text-center" colspan="5">{{ __("Nenhum resultado encontrado") }}</td>
        </tr>
    @endforelse
</tbody>
