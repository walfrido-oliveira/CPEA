<thead>
    <tr class="thead-light">
        <x-table-sort-header :orderBy="null" :ascending="null" columnName="null" columnText="{{ __('Amostra') }}"/>
    </tr>
</thead>
<tbody>
    @foreach ($projectPointMatrices as $index => $point)
        @if (($index > 0 && $projectPointMatrices[$index]->pointIdentification->identification !=
                            $projectPointMatrices[$index - 1]->pointIdentification->identification) || $index == 0)
            <tr>
                <td class="font-bold" x-data="{ open: false }">
                    @if ($point->pointIdentification)
                        <button @click="open = !open" type="button" class="point-open pl-4" data-id="{{ $point->pointIdentification->id }}">
                            {{ $point->pointIdentification->area }} - {{ $point->pointIdentification->identification }}
                            <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1 text-black">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd">
                                </path>
                            </svg>
                        </button>
                    @endif
                </td>
            </tr>
        @endif

        @if($index > 0)
            @if($projectPointMatrices[$index]->parameterAnalysis && $projectPointMatrices[$index - 1]->parameterAnalysis)
                @if (($index > 0 && $projectPointMatrices[$index]->parameterAnalysis->parameter_analysis_group_id !=
                                    $projectPointMatrices[$index - 1]->parameterAnalysis->parameter_analysis_group_id) || $index == 0 ||
                                    ($projectPointMatrices[$index]->pointIdentification->identification !=
                                    $projectPointMatrices[$index - 1]->pointIdentification->identification))
                    <tr class="hidden transition-transform duration-200 transform point-items-{{ $point->pointIdentification->id }}">
                        <td class="font-bold text-black" style="background-color:#e1ede1">
                            {{ $point->parameterAnalysis->parameterAnalysisGroup->name }}
                        </td>
                    </tr>
                @endif
            @endif
        @endif

        <tr class="hidden transition-transform duration-200 transform point-items-{{ $point->pointIdentification->id }}">
            <td>
                @if ($point->parameterAnalysis)
                    <a class="text-green-600 underline text-item-table" href="{{ route('analysis-result.show', ['project_point_matrix_id' => $point->id]) }}">
                        {{ $point->parameterAnalysis->cas_rn }} -
                        {{ $point->parameterAnalysis->analysis_parameter_name }} -
                        {{ $point->parameterAnalysis->parameterAnalysisGroup ? $point->parameterAnalysis->parameterAnalysisGroup->name : '' }}
                    </a>
                @endif
            </td>
        </tr>
    @endforeach
</tbody>
