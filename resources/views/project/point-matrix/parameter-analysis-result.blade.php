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
                        {{ $point->pointIdentification->area }} - {{ $point->pointIdentification->identification }}
                    @endif
                </td>
            </tr>
        @endif

        @if ($point->parameterAnalysis->parameterAnalysisGroup)
            @if (($index > 0 && $projectPointMatrices[$index]->pointIdentification->parameterAnalysis->parameterAnalysisGroup->name !=
            $projectPointMatrices[$index - 1]->parameterAnalysis->parameterAnalysisGroup->name) || $index == 0)
                <tr>
                    <td class="font-bold text-black" style="background-color:#ccc">
                        {{ $point->parameterAnalysis->parameterAnalysisGroup->name }}
                    </td>
                </tr>
            @endif
        @endif

        <tr>
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
