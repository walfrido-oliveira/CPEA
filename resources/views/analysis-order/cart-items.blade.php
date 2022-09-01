<thead>
    <tr class="" style="border: 0">
        <th style="border: 0; padding: 0"></th>
    </tr>
</thead>
<tbody>
    @forelse ($projectPointMatrices as $index => $point)
        @if (($index > 0 && $projectPointMatrices[$index]->pointIdentification->identification !=
                            $projectPointMatrices[$index - 1]->pointIdentification->identification) || $index == 0)
            <tr>
                <td colspan="5" class="bg-gray-100 font-bold">
                    @if ($point->pointIdentification)
                        <button type="button" class="show-point" data-point="{{ $point->pointIdentification->id }}">
                            {{ $point->pointIdentification->area }} - {{ $point->pointIdentification->identification }}
                            ({{ count($point->where("point_identification_id", $point->point_identification_id)->where('campaign_id', $point->campaign_id)->get()) }})
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline btn-transition-secondary" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M15.707 4.293a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-5-5a1 1 0 011.414-1.414L10 8.586l4.293-4.293a1 1 0 011.414 0zm0 6a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-5-5a1 1 0 111.414-1.414L10 14.586l4.293-4.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    @endif
                </td>
            </tr>
        @endif

        @if (($index > 0 && $projectPointMatrices[$index]->parameterAnalysis->parameter_analysis_group_id !=
                            $projectPointMatrices[$index - 1]->parameterAnalysis->parameter_analysis_group_id) || $index == 0 ||
                            ($projectPointMatrices[$index]->pointIdentification->identification !=
                            $projectPointMatrices[$index - 1]->pointIdentification->identification))
            <tr class="point-items-{{ $point->pointIdentification->id }}">
                @if ($point->parameterAnalysis)
                    <td colspan="5" class="font-bold text-black" style="background-color:#e1ede1">
                        {{ $point->parameterAnalysis->parameterAnalysisGroup->name }}
                        ({{ count($point->where("point_identification_id", $point->point_identification_id)->where('campaign_id', $point->campaign_id)->whereHas("parameterAnalysis", function($q) use($point) {
                            $q->where("parameter_analysis_group_id", $point->parameterAnalysis->parameterAnalysisGroup->id);
                        })->get()) }})
                    </td>
                @endif
            </tr>
        @else
            <tr class="point-items-{{ $point->pointIdentification->id }}">
                @if ($point->parameterAnalysis)
                    <td colspan="5" class="font-bold text-black" style="background-color:#e1ede1">
                        {{ $point->parameterAnalysis->parameterAnalysisGroup->name }}
                        ({{ count($point->where("point_identification_id", $point->point_identification_id)->where('campaign_id', $point->campaign_id)->whereHas("parameterAnalysis", function($q) use($point) {
                            $q->where("parameter_analysis_group_id", $point->parameterAnalysis->parameterAnalysisGroup->id);
                        })->get()) }})
                    </td>
                @endif
            </tr>
        @endif

        <tr class="point-items-{{ $point->pointIdentification->id }}">
            <td style="border-top: 0">
                @if ($point->parameterAnalysis)
                    <input class="parameter-analysis" type="hidden" name="project_point_matrices[{{ $index }}]" value="{{ $point->id }}">
                    <button class="inline delete-parameter-analysis-item btn-transition-danger" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                    <a class="text-item-table inline font-bold text-gray-500" href="{{ route('parameter-analysis.show', ['parameter_analysis' => $point->parameterAnalysis->id]) }}">
                        ({{ $point->parameterAnalysis->cas_rn }})
                        {{ $point->parameterAnalysis->analysis_parameter_name }} -
                        {{ $point->parameterAnalysis->parameterAnalysisGroup ? $point->parameterAnalysis->parameterAnalysisGroup->name : '' }}
                    </a>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td class="text-center" style="border-top: 0" colspan="5">{{ __("Carrinho vázio") }}</td>
        </tr>
    @endforelse
</tbody>
