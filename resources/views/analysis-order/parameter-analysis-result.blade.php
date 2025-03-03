<thead>
    <tr class="thead-green header-fixed top-14 lg:top-16">
        <th>{{ __('Área/Ponto/Param. Análise') }}</th>
        <th>{{ __('nº do Pedido') }}</th>
        <th>{{ __('Laboratório') }}</th>
        <th>{{ __('Data de Envio') }}</th>
        <th>{{ __('Status') }}</th>
    </tr>
</thead>
<tbody>
    @forelse ($projectPointMatrices as $index => $point)
        @if (($index > 0 && $projectPointMatrices[$index]->point_identification_id !=
              $projectPointMatrices[$index - 1]->point_identification_id) || $index == 0)
            <tr>
                <td colspan="5" class="bg-gray-100 font-bold">
                    @if ($point->pointIdentification)
                        <button type="button" class="show-point" data-point="{{ $point->pointIdentification->id }}">
                            {{ $point->pointIdentification->area }} - {{ $point->pointIdentification->identification }}
                            ({{ count($analysisOrder->projectPointMatrices()
                                ->where('project_point_matrices.point_identification_id', $point->pointIdentification->id)->get()) }})
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline btn-transition-secondary" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M15.707 4.293a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-5-5a1 1 0 011.414-1.414L10 8.586l4.293-4.293a1 1 0 011.414 0zm0 6a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-5-5a1 1 0 111.414-1.414L10 14.586l4.293-4.293a1 1 0 011.414 0z" clip-rule="evenodd" />
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
                    <tr class="point-items-{{ $point->pointIdentification->id }}">
                        <td colspan="5" class="font-bold text-black" style="background-color:#e1ede1">
                            {{ $point->parameterAnalysis->parameterAnalysisGroup->name }}
                            ({{ count($point->where("point_identification_id", $point->point_identification_id)->where('campaign_id', $point->campaign_id)->whereHas("parameterAnalysis", function($q) use($point) {
                                $q->where("parameter_analysis_group_id", $point->parameterAnalysis->parameterAnalysisGroup->id);
                            })->get()) }})
                        </td>
                    </tr>
                @endif
            @endif
        @else
            <tr class="point-items-{{ $point->pointIdentification ? $point->pointIdentification->id : null }}">
                @if ($point->parameterAnalysis)
                    <tr class="point-items-{{ $point->pointIdentification->id }}">
                        <td colspan="5" class="font-bold text-black" style="background-color:#e1ede1">
                            {{ $point->parameterAnalysis->parameterAnalysisGroup->name }}
                            ({{ count($point->where("point_identification_id", $point->point_identification_id)->where('campaign_id', $point->campaign_id)->whereHas("parameterAnalysis", function($q) use($point) {
                                $q->where("parameter_analysis_group_id", $point->parameterAnalysis->parameterAnalysisGroup->id);
                            })->get()) }})
                        </td>
                    </tr>
                @endif
            </tr>
        @endif

        <tr id="point_matrix_row_{{ $index }}" class="point-items-{{ $point->pointIdentification->id }}">
            @php
                $status = count($point->analysisResult);//$point->getStatusLab($campaign->id);
                $statusMsg = 'Pendente de Analise';
                $statusColor = "#374151";

                if($status > 0)
                {
                    $statusColor = "#4DB15D";
                    $statusMsg = 'Importado';
                } else {
                    $statusColor = "#374151";
                    $statusMsg = 'Pendente';
                }

                /*switch ($status) {
                    case 'sent':
                        $statusColor = "#2A96A7";
                        $statusMsg = 'Encaminhado';
                        break;

                    case 'analyzing':
                        $statusColor = "#C3D412";
                        $statusMsg = 'Em Análise';
                        break;

                    case 'concluded':
                        $statusColor = "#4DB15D";
                        $statusMsg = 'Concluído';
                        break;

                    default:
                        $statusColor = "#374151";
                        $statusMsg = 'Pendente';
                        break;
                }*/
            @endphp

            <td style="padding-left: 2rem">
                <input class="form-checkbox point-matrix-url" type="checkbox" name="point_matrix[{{ $point->id }}]" value="{!! route('analysis-order.destroy-item', ['analysis_order' => $analysisOrder->id, 'item' => $point->id]) !!}" data-id="point_matrix_row_{{ $index }}">
                @if ($point->parameterAnalysis)
                    <button class="inline delete-parameter-analysis-item delete-point-matrix" type="button" data-type="single" data-value="{!! route('analysis-order.destroy-item', ['analysis_order' => $analysisOrder->id, 'item' => $point->id]) !!}" data-id="point_matrix_row_{{ $index }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 btn-transition-danger" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>

                    <span title="{{ $statusMsg }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" style="color: {{ $statusColor }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </span>
                    @if ($point->getAnalysisResultById($analysisOrder->id))
                        <a class="text-item-table inline font-bold text-green-700 underline" href="{{ route('analysis-result.show', ['project_point_matrix_id' => $point->id]) }}">
                            ({{ $point->parameterAnalysis->cas_rn }})
                            {{ $point->parameterAnalysis->analysis_parameter_name }}
                        </a>
                    @else
                        <span>
                            ({{ $point->parameterAnalysis->cas_rn }})
                            {{ $point->parameterAnalysis->analysis_parameter_name }}
                        </span>
                    @endif
                @endif
            </td>
            <td class="whitespace-nowrap">
                @if ($point->getAnalysisOrderById($analysisOrder->id))
                    <a class="text-item-table inline font-bold text-green-700 underline" href="{{ route('analysis-order.show', ['analysis_order' => $point->getAnalysisOrderById($analysisOrder->id)->id]) }}">
                        {{ $point->getAnalysisOrderById($analysisOrder->id)->formatted_id }}
                    </a>
                @else
                    -
                @endif
            </td>
            <td>
                {{ $point->getAnalysisOrderById($analysisOrder->id) ? $point->getAnalysisOrderById($analysisOrder->id)->lab->name : '-' }}
            </td>
            <td style="width: 12%">
                {{ $point->getAnalysisOrderById($analysisOrder->id) ? $point->getAnalysisOrderById($analysisOrder->id)->lab->created_at->format('d/m/Y h:m') : '-' }}
            </td>
            <td>
                <span class="w-24 py-1 badge text-white text-center" style="background-color: {{ $statusColor }}">
                    {{ $statusMsg }}
                </span>
            </td>
        </tr>

    @empty
        <tr>
            <td class="text-center" colspan="5">{{ __("Nenhum resultado encontrado") }}</td>
        </tr>
    @endforelse
</tbody>
