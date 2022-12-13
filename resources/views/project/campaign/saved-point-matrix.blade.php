<tr id="point_matrix_row_{{ $key }}" class="point-matrix-row">
    <td width="5%">
    </td>
    <td>
        @if ($projectPointMatrix->pointIdentification)
            <div class="w-full">
                <div class="w-full flex">
                    <div class="font-bold pr-4">
                        {{ __('Área') }}
                    </div>
                    <div class="text-gray-500 font-bold ">
                        <div class="content">
                            @if ($projectPointMatrix->pointIdentification)
                                <a class="text-green-600 underline" href="{{ route('registers.point-identification.show', ['point_identification' => $projectPointMatrix->pointIdentification->id]) }}" target="_blank" rel="noopener noreferrer">
                                    {{ $projectPointMatrix->pointIdentification->area }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="w-full flex">
                    <div class="font-bold pr-4">
                        {{ __('Identificação Ponto') }}
                    </div>
                    <div class="text-gray-500 font-bold">
                        <div class="content">
                            @if ($projectPointMatrix->pointIdentification)
                                <a class="text-green-600 underline" href="{{ route('registers.point-identification.show', ['point_identification' => $projectPointMatrix->pointIdentification->id]) }}" target="_blank" rel="noopener noreferrer">
                                    {{ $projectPointMatrix->pointIdentification ? $projectPointMatrix->pointIdentification->identification : '' }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="w-full flex">
                    <div class="font-bold pr-4">
                        {{ __('Matriz') }}
                    </div>
                    <div class="text-gray-500 font-bold ">
                        <div class="content">
                            @if ($projectPointMatrix->analysisMatrix)
                                {{ $projectPointMatrix->analysisMatrix->name }}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="w-full flex">
                    <div class="font-bold pr-4">
                        {{ __('Param. Orientador Ambiental') }}
                    </div>
                    <div class="text-gray-500 font-bold ">
                        <div class="content">
                            @if ($projectPointMatrix->guidingParameters)
                                {!! implode("<br/>", $projectPointMatrix->guidingParameters()->pluck('environmental_guiding_parameter_id')->toArray()) !!}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="w-full flex">
                    <div class="font-bold pr-4">
                        {{ __('Param. Análise') }}
                    </div>
                    <div class="text-gray-500 font-bold ">
                        <div class="content">
                            @if ($projectPointMatrix->parameterAnalysis)
                                {{ $projectPointMatrix->parameterAnalysis->analysis_parameter_name }}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="w-full flex">
                    <div class="font-bold pr-4">
                        {{ __('Método Preparação') }}
                    </div>
                    <div class="text-gray-500 font-bold ">
                        <div class="content">
                            @if ($projectPointMatrix->parameter_method_preparation_id)
                                <a class="text-green-600 underline" href="{{ route('registers.parameter-method.show', ['parameter_method' => $projectPointMatrix->parameter_method_preparation_id]) }}" target="_blank" rel="noopener noreferrer">
                                    {{ $projectPointMatrix->parameterMethodPreparation->name }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="w-full flex">
                    <div class="font-bold pr-4">
                        {{ __('Método Análise') }}
                    </div>
                    <div class="text-gray-500 font-bold ">
                        <div class="content">
                            @if ($projectPointMatrix->parameter_method_analysis_id)
                                <a class="text-green-600 underline" href="{{ route('registers.parameter-method.show', ['parameter_method' => $projectPointMatrix->parameter_method_analysis_id]) }}" target="_blank" rel="noopener noreferrer">
                                    {{ $projectPointMatrix->parameterMethodAnalysis->name }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="w-full flex">
                    <div class="font-bold pr-4">
                        {{ __('DT/HR da Coleta') }}
                    </div>
                    <div class="text-gray-500 font-bold ">
                        <div class="content">
                            {{ $projectPointMatrix->date_collection->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>
                <div class="w-full flex">
                    <div class="font-bold pr-4">
                        {{ __('Idet Lab Amostra') }}
                    </div>
                    <div class="text-gray-500 font-bold ">
                        <div class="content">
                            @if (count($projectPointMatrix->analysisOrders))
                                {{ $projectPointMatrix->analysisOrders[0]->lab->name }}
                            @else
                                {{ '-' }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </td>
    <td width="20%">
        <div class="delete inline">
            <button type="button" class="btn-transition-danger delete-point-matrix" data-type="edit" id="point_matrix_{{ $projectPointMatrix->id }}" data-url="{!! route('project.point-matrix.destroy', ['point_matrix' => $projectPointMatrix->id]) !!}" data-id="point_matrix_row_{{ $key }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </div>
    </td>
<tr>
