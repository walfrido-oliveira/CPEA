<thead>
    <tr class="thead-green header-fixed top-14 lg:top-16">
        <th></th>
        <th>{{ __('Área/Ponto/Param. Análise') }}</th>
        <th class="whitespace-nowrap">{{ __('nº do Pedido') }}</th>
        <th>{{ __('Laboratório') }}</th>
        <th class="whitespace-nowrap">{{ __('Data de Envio') }}</th>
        <th>{{ __('Status') }}</th>
    </tr>
</thead>
<tbody>
    @forelse ($projectPointMatrices as $index => $point)
        @if (($index > 0 && $projectPointMatrices[$index]->point_identification_id !=
                            $projectPointMatrices[$index - 1]->point_identification_id) || $index == 0)
            <tr>
                <td class="bg-gray-100" style="width: 1%">
                    <input class="form-checkbox parameter-analysis-identification" type="checkbox"
                           data-identification-id="{{ $point->pointIdentification ? $point->pointIdentification->id : null }}"
                           value="{{ $point->pointIdentification ? $point->pointIdentification->id : null }}">
                </td>
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

        @if($index > 0)
            @if($projectPointMatrices[$index]->parameterAnalysis && $projectPointMatrices[$index - 1]->parameterAnalysis)
                @if (($index > 0 && $projectPointMatrices[$index]->parameterAnalysis->parameter_analysis_group_id !=
                                    $projectPointMatrices[$index - 1]->parameterAnalysis->parameter_analysis_group_id) || $index == 0 ||
                                    ($projectPointMatrices[$index]->pointIdentification->identification !=
                                    $projectPointMatrices[$index - 1]->pointIdentification->identification))
                    <tr class="point-items-{{ $point->pointIdentification->id }}">
                        @if ($point->parameterAnalysis)
                            <td class="bg-gray-100" style="width: 1%; background-color:#e1ede1">
                                <input class="form-checkbox parameter-analysis-group" type="checkbox"
                                    data-group-id="{{ $point->parameterAnalysis->parameterAnalysisGroup->id }}"
                                    data-identification-id="{{ $point->pointIdentification->id }}"
                                    value="{{ $point->parameterAnalysis->parameterAnalysisGroup->id }}">
                            </td>
                            <td colspan="5" class="font-bold text-black" style="background-color:#e1ede1">
                                {{ $point->parameterAnalysis->parameterAnalysisGroup->name }}
                                ({{ count($point->where("point_identification_id", $point->point_identification_id)->where('campaign_id', $point->campaign_id)->whereHas("parameterAnalysis", function($q) use($point) {
                                    $q->where("parameter_analysis_group_id", $point->parameterAnalysis->parameterAnalysisGroup->id);
                                })->get()) }})
                            </td>
                        @endif
                    </tr>
                @endif
            @endif
        @endif

        <tr class="point-items-{{ $point->pointIdentification ? $point->pointIdentification->id : null }}">
            @php
                $status = $point->getStatusLab($campaign->id);
                $statusMsg = 'Pendente de Analise';
                $statusColor = "#374151";

                switch ($status) {
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
                }
            @endphp
            <td style="width: 1%" data-status="{{ $status }}">
                @if (!$status || $status == 'canceled')
                    <input class="form-checkbox parameter-analysis-item" name="parameter_analysis_item[{{ $index }}]"
                        type="checkbox" @if ($point->parameterAnalysis) data-group-id="{{ $point->parameterAnalysis->parameterAnalysisGroup->id }}" @endif
                        data-identification-id="{{ $point->pointIdentification->id }}" value="{{ $point->id }}">
                @endif
            </td>
            <td>
                @if ($point->parameterAnalysis)
                    @if (!$status)
                        <button class="inline add-parameter-analysis-item" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 btn-transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                    @endif

                    <span title="{{ $statusMsg }}" class="cursor-help">
                        @if(count($point->analysisResult) == 0)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" style="color: {{ $statusColor }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        @endif
                    </span>

                    @if (count($point->analysisResult) > 0)
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
                @if (count($point->analysisOrders) > 0)
                    <a class="text-item-table inline font-bold text-green-700 underline" href="{{ route('analysis-order.show', ['analysis_order' => $point->analysisOrders()->first()->id]) }}">
                        {{ $point->analysisOrders()->orderBy('created_at', 'desc')->first()->formatted_id }}
                    </a>
                @else
                    -
                @endif
            </td>
            <td>
                {{ count($point->analysisOrders) > 0 ? $point->analysisOrders()->orderBy('created_at', 'desc')->first()->lab->name : '-' }}
            </td>
            <td style="width: 12%">
                {{ count($point->analysisOrders) > 0 ? $point->analysisOrders()->orderBy('created_at', 'desc')->first()->lab->created_at->format('d/m/Y h:m') : '-' }}
            </td>
            <td>
                <span class="w-24 py-1 badge text-white text-center" style="background-color: {{ $statusColor }}">
                    {{ $statusMsg }}
                </span>
            </td>
        </tr>
    @empty
        <tr>
            <td class="text-center" colspan="6">{{ __("Nenhum resultado encontrado") }}</td>
        </tr>
    @endforelse
</tbody>
