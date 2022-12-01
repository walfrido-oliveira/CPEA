<x-app-layout>
    <div class="py-6 show-point-identification">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Valor Param. Orientador') }}</h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2 ">
                        <a class="btn-outline-info" href="{{ route('guiding-parameter-value.index') }}">{{ __('Listar') }}</a>
                    </div>
                    <div class="m-2">
                        <a class="btn-outline-warning" href="{{ route('guiding-parameter-value.edit', ['guiding_parameter_value' => $guidingParameterValue->id]) }}">{{ __('Editar') }}</a>
                    </div>
                    <div class="m-2">
                        <button type="button" class="btn-outline-danger delete-environmental-area" id="guiding_parameter_value_delete" data-toggle="modal" data-target="#delete_modal" data-id="{{ $guidingParameterValue->id }}">{{ __('Apagar') }}</button>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                <div class="mx-4 px-3 py-2 mt-4">
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('ID') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $guidingParameterValue->id }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Param. Orientador Ambiental') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">
                                @if ($guidingParameterValue->guidingParameter)
                                    <a class="text-green-600 underline" href="{{ route('guiding-parameter-value.show', ['guiding_parameter_value' => $guidingParameterValue->guidingParameter->id]) }}">
                                        {{ $guidingParameterValue->guidingParameter->name }}
                                    </a>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Matriz') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">
                                @if ($guidingParameterValue->analysisMatrix)
                                    <a class="text-green-600 underline" href="{{ route('registers.analysis-matrix.show', ['analysis_matrix' => $guidingParameterValue->analysisMatrix->id]) }}">
                                        {{ $guidingParameterValue->analysisMatrix->name }}
                                    </a>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Param. Análise') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">
                                @if ($guidingParameterValue->parameterAnalysis)
                                    <a class="text-green-600 underline" href="{{ route('parameter-analysis.show', ['parameter_analysis' => $guidingParameterValue->parameterAnalysis->id]) }}">
                                        {{ $guidingParameterValue->parameterAnalysis->analysis_parameter_name }}
                                    </a>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Tipo Valor Orientador') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">
                                @if ($guidingParameterValue->guidingValue)
                                    <a class="text-green-600 underline" href="{{ route('registers.guiding-value.show', ['guiding_value' => $guidingParameterValue->guidingValue->id]) }}">
                                        {{ $guidingParameterValue->guidingValue->name }}
                                    </a>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Unidade Legislaçao') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">
                                @if ($guidingParameterValue->unityLegislation)
                                    <a class="text-green-600 underline" href="{{ route('registers.unity.show', ['unity' => $guidingParameterValue->unityLegislation->id]) }}">
                                        {{ $guidingParameterValue->unityLegislation->name }}
                                    </a>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Valor Orientador Legislaçao') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ is_numeric($guidingParameterValue->guiding_legislation_value) ? number_format( $guidingParameterValue->guiding_legislation_value, 5, ",", "." ) : '' }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Unidade Análise') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">
                                @if ($guidingParameterValue->unityAnalysis)
                                    <a class="text-green-600 underline" href="{{ route('registers.unity.show', ['unity' => $guidingParameterValue->unityAnalysis->id]) }}">
                                        {{ $guidingParameterValue->unityAnalysis->name }}
                                    </a>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Valor Orientador Legislaçao') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">
                                @if ($guidingParameterValue->guiding_analysis_value)
                                    {{ number_format( $guidingParameterValue->guiding_analysis_value, 5, ",", "." ) }}
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Data de Cadastro') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $guidingParameterValue->created_at->format('d/m/Y H:i:s')}}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Última Edição') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $guidingParameterValue->updated_at->format('d/m/Y H:i:s')}}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <x-modal title="{{ __('Excluir usuário') }}"
             msg="{{ __('Deseja realmente apagar esse Tipo Param. Análise?') }}"
             confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_guiding_parameter_value_modal"
             method="DELETE"
             url="{{ route('guiding-parameter-value.destroy', ['guiding_parameter_value' => $guidingParameterValue->id]) }}"
             redirect-url="{{ route('guiding-parameter-value.index') }}"/>

    <script>
        function eventsDeleteCallback() {
            document.querySelectorAll('.delete-environmental-area').forEach(item => {
            item.addEventListener("click", function() {
                var modal = document.getElementById("delete_guiding_parameter_value_modal");
                modal.classList.remove("hidden");
                modal.classList.add("block");
            })
        });
        }

        eventsDeleteCallback();
    </script>
</x-app-layout>
