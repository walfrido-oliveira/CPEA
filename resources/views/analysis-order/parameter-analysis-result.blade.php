<thead>
    <tr class="" style="border: 0">
        <th style="border: 0; padding: 0"></th>
    </tr>
</thead>
<tbody>
    @foreach ($projectPointMatrices as $index => $point)
        @if (($index > 0 && $projectPointMatrices[$index]->pointIdentification->identification !=
                            $projectPointMatrices[$index - 1]->pointIdentification->identification) || $index == 0)
            <tr>
                <td class="bg-gray-100 font-bold">
                    @if ($point->pointIdentification)
                        {{ $point->pointIdentification->area }} - {{ $point->pointIdentification->identification }}
                        ({{ count($point->where("point_identification_id", $point->point_identification_id)->where('campaign_id', $point->campaign_id)->get()) }})
                    @endif
                </td>
            </tr>
        @endif

        @if (($index > 0 && $projectPointMatrices[$index]->parameterAnalysis->parameter_analysis_group_id !=
                            $projectPointMatrices[$index - 1]->parameterAnalysis->parameter_analysis_group_id) || $index == 0 ||
                            ($projectPointMatrices[$index]->pointIdentification->identification !=
                            $projectPointMatrices[$index - 1]->pointIdentification->identification))
            <tr class="point-items-{{ $point->pointIdentification->id }}">
                <td class="font-bold text-black" style="background-color:#e1ede1">
                    {{ $point->parameterAnalysis->parameterAnalysisGroup->name }}
                    ({{ count($point->where("point_identification_id", $point->point_identification_id)->where('campaign_id', $point->campaign_id)->whereHas("parameterAnalysis", function($q) use($point) {
                        $q->where("parameter_analysis_group_id", $point->parameterAnalysis->parameterAnalysisGroup->id);
                    })->get()) }})
                </td>
            </tr>
        @endif

        <tr class="point-items-{{ $point->pointIdentification->id }}">
            @php
                $status = $point->getStatusLab($campaign->id);
                $statusMsg = 'Pendente de Analise';
                $statusColor = "#374151";

                switch ($status) {
                    case 'sent':
                        $statusColor = "#2A96A7";
                        $statusMsg = 'Encaminhado para Laboratório';
                        break;

                    case 'analyzing':
                        $statusColor = "#C3D412";
                        $statusMsg = 'Em Análise';
                        break;

                    case 'concluded':
                        $statusColor = "#4DB15D";
                        $statusMsg = 'Análise Concluída';
                        break;

                    default:
                        $statusColor = "#374151";
                        $statusMsg = 'Pendente de Analise';
                        break;
                }
            @endphp
            <td style="padding-left: 2rem">
                @if ($point->parameterAnalysis)
                    @if (!$status)
                        <button class="inline add-parameter-analysis-item" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 btn-transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                    @endif

                    <span title="{{ $statusMsg }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" style="color: {{ $statusColor }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </span>
                    <a class="text-item-table inline font-bold text-gray-500" href="{{ route('parameter-analysis.show', ['parameter_analysis' => $point->parameterAnalysis->id]) }}">
                        ({{ $point->parameterAnalysis->cas_rn }})
                        {{ $point->parameterAnalysis->analysis_parameter_name }} -
                        {{ $point->parameterAnalysis->parameterAnalysisGroup ? $point->parameterAnalysis->parameterAnalysisGroup->name : '' }}
                    </a>
                @endif
            </td>
        </tr>
    @endforeach
</tbody>
