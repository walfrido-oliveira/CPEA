<thead>
    <tr class="thead-light">
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="guiding_parameter_id" columnText="{{ __('Amostra') }}"/>
    </tr>
</thead>
<tbody>
    @foreach ($projectPointMatrices as $index => $point)
        @if (($index > 0 && $projectPointMatrices[$index]->pointIdentification->identification !=
                            $projectPointMatrices[$index - 1]->pointIdentification->identification) || $index == 0)
            <tr>
                <td class="font-bold" style="background-color:#e1ede1 ">
                    @if ($point->pointIdentification)
                        <button type="button" class="point-open" data-id="{{ $point->pointIdentification->id }}">{{ $point->pointIdentification->area }} - {{ $point->pointIdentification->identification }}</button>
                    @endif
                </td>
            </tr>
        @endif

        @if (($index > 0 && $projectPointMatrices[$index]->parameterAnalysis->parameter_analysis_group_id !=
                            $projectPointMatrices[$index - 1]->parameterAnalysis->parameter_analysis_group_id) || $index == 0)
            <tr class="hidden transition-transform duration-200 transform point-items-{{ $point->pointIdentification->id }}">
                <td class="font-bold text-black" style="background-color:#ccc">
                    {{ $point->parameterAnalysis->parameterAnalysisGroup->name }}
                </td>
            </tr>
        @endif

        <tr class="hidden transition-transform duration-200 transform point-items-{{ $point->pointIdentification->id }}">
            <td>
                @if ($point->parameterAnalysis)
                    <a class="text-green-600 underline text-item-table" href="{{ route('parameter-analysis.show', ['parameter_analysis' => $point->parameterAnalysis->id]) }}">
                        {{ $point->parameterAnalysis->cas_rn }} -
                        {{ $point->parameterAnalysis->analysis_parameter_name }} -
                        {{ $point->parameterAnalysis->parameterAnalysisGroup ? $point->parameterAnalysis->parameterAnalysisGroup->name : '' }}
                    </a>
                @endif
            </td>
        </tr>
    @endforeach
</tbody>

<script>
    document.querySelectorAll(".point-open").forEach(item => {
        item.addEventListener("click", function() {
            document.querySelectorAll(".point-items-" + this.dataset.id).forEach(item => {
                if(item.classList.contains("hidden")) {
                    item.classList.remove("hidden");
                } else {
                    item.classList.add("hidden");
                }
            });
        });
    });
</script>
