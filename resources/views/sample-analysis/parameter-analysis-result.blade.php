<thead>
    <tr class="" style="border: 0">
        <th style="border: 0; padding: 0"></th>
        <th style="border: 0; padding: 0"></th>
    </tr>
</thead>
<tbody>
    @foreach ($projectPointMatrices as $index => $point)
        @if (($index > 0 && $projectPointMatrices[$index]->pointIdentification->identification !=
                            $projectPointMatrices[$index - 1]->pointIdentification->identification) || $index == 0)
            <tr>
                <td class="bg-gray-100" style="width: 1%">
                    <input class="form-checkbox parameter-analysis-identification" type="checkbox"
                           data-identification-id="{{ $point->pointIdentification->id }}"
                           value="{{ $point->pointIdentification->id }}">
                </td>
                <td class="bg-gray-100 font-bold">
                    @if ($point->pointIdentification)
                        {{ $point->pointIdentification->area }} - {{ $point->pointIdentification->identification }}
                    @endif
                </td>
            </tr>
        @endif

        @if (($index > 0 && $projectPointMatrices[$index]->parameterAnalysis->parameter_analysis_group_id !=
                            $projectPointMatrices[$index - 1]->parameterAnalysis->parameter_analysis_group_id) || $index == 0 ||
                            ($projectPointMatrices[$index]->pointIdentification->identification !=
                            $projectPointMatrices[$index - 1]->pointIdentification->identification))
            <tr class="point-items-{{ $point->pointIdentification->id }}">
                <td class="bg-gray-100" style="width: 1%; background-color:#e1ede1">
                    <input class="form-checkbox parameter-analysis-group" type="checkbox"
                           data-group-id="{{ $point->parameterAnalysis->parameterAnalysisGroup->id }}"
                           data-identification-id="{{ $point->pointIdentification->id }}"
                           value="{{ $point->parameterAnalysis->parameterAnalysisGroup->id }}">
                </td>
                <td class="font-bold text-black" style="background-color:#e1ede1">
                    {{ $point->parameterAnalysis->parameterAnalysisGroup->name }}
                </td>
            </tr>
        @endif

        <tr class="point-items-{{ $point->pointIdentification->id }}">
            <td style="width: 1%">
                <input class="form-checkbox parameter-analysis-item" name="parameter_analysis_item[{{ $index }}]"
                       type="checkbox" data-group-id="{{ $point->parameterAnalysis->parameterAnalysisGroup->id }}"
                       data-identification-id="{{ $point->pointIdentification->id }}" value="{{ $point->id }}">
            </td>
            <td x-data="{ open: false }">
                @if ($point->parameterAnalysis)
                    <button class="inline add-parameter-analysis-item" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 btn-transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                    <span title="{{ __('Pendente de Analise') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" style="color: #374151" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </span>
                    <a class="text-green-600 underline text-item-table inline" href="{{ route('parameter-analysis.show', ['parameter_analysis' => $point->parameterAnalysis->id]) }}">
                        {{ $point->parameterAnalysis->cas_rn }} -
                        {{ $point->parameterAnalysis->analysis_parameter_name }} -
                        {{ $point->parameterAnalysis->parameterAnalysisGroup ? $point->parameterAnalysis->parameterAnalysisGroup->name : '' }}
                    </a>
                @endif
            </td>
        </tr>
    @endforeach
</tbody>
