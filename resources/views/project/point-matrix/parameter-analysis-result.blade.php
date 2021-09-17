<thead>
    <tr class="thead-light">
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="identification" columnText="{{ __('Amostra') }}"/>
    </tr>
</thead>
<tbody>
    @foreach ($projectPointMatrices as $index => $point)
        @if (($index > 0 && $projectPointMatrices[$index]->pointIdentification->identification !=
                            $projectPointMatrices[$index - 1]->pointIdentification->identification) || $index == 0)
            <tr>
                <td class="text-center font-bold" style="background-color:#e1ede1 ">
                    @if ($point->pointIdentification)
                        {{ $point->pointIdentification->area }} - {{ $point->pointIdentification->identification }}
                    @endif
                </td>
            </tr>
        @endif

        <tr>
            <td class="text-center">
                @if ($point->parameterAnalysis)
                    <a class="text-green-600 underline text-item-table" href="{{ route('parameter-analysis.show', ['parameter_analysis' => $point->parameterAnalysis->id]) }}">
                        {{ $point->parameterAnalysis->cas_rn }} -
                        {{ $point->parameterAnalysis->analysis_parameter_name }} -
                        {{ $point->parameterAnalysis->parameterAnalysisGroup ? $point->parameterAnalysis->parameterAnalysisGroup->name : '' }}</td>
                    </a>
                @endif
            </td>
        </tr>
    @endforeach
</tbody>
