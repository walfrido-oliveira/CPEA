<x-app-layout>
    <div class="py-6 show-parameter-analysis">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Detalhes do Param. Análise') }}</h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2 ">
                        <a class="btn-outline-info" href="{{ route('parameter-analysis.index') }}">{{ __('Listar') }}</a>
                    </div>
                    <div class="m-2">
                        <a class="btn-outline-warning" href="{{ route('parameter-analysis.edit', ['parameter_analysis' => $parameterAnalysis->id]) }}">{{ __('Editar') }}</a>
                    </div>
                    <div class="m-2">
                        <button type="button" class="btn-outline-danger delete-parameter-analysis" id="user_parameter_analysis" data-toggle="modal" data-target="#delete_modal" data-id="{{ $parameterAnalysis->id }}">{{ __('Apagar') }}</button>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                <div class="mx-4 px-3 py-2 mt-4">
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __('ID') }}</p>
                        </div>

                        <div class="w-full md:w-1/2">
                            <p class = "text-gray-500 font-bold">{{ $parameterAnalysis->id }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __('Tipo Param. Análise') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            @if ($parameterAnalysis->AnalysisParameter)
                                <p class="text-gray-500 font-bold">
                                    <a class="text-green-600 underline" href="{{ route('registers.analysis-parameter.show', ['analysis_parameter' => $parameterAnalysis->analysisParameter->id]) }}" target="_blank" rel="noopener noreferrer">
                                        {{ $parameterAnalysis->analysisParameter->name }}
                                    </a>
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __('CAS RN') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $parameterAnalysis->cas_rn }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __('Nome Param. Análise') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $parameterAnalysis->analysis_parameter_name }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __('Grupo Param. Análise') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">
                                <a class="text-green-600 underline" href="{{ route('registers.parameter-analysis-group.show', ['parameter_analysis_group' => $parameterAnalysis->parameterAnalysisGroup->id]) }}" target="_blank" rel="noopener noreferrer">
                                    {{ $parameterAnalysis->parameterAnalysisGroup->name }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <x-modal title="{{ __('Excluir usuário') }}"
             msg="{{ __('Deseja realmente apagar esse usuário?') }}"
             confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_parameter_analysis_modal"
             method="DELETE"
             url="{{ route('parameter-analysis.destroy', ['parameter_analysis' => $parameterAnalysis->id]) }}"
             redirect-url="{{ route('parameter-analysis.index') }}"/>

    <script>
        function eventsDeleteCallback() {
            document.querySelectorAll('.delete-parameter-analysis').forEach(item => {
            item.addEventListener("click", function() {
                var modal = document.getElementById("delete_parameter_analysis_modal");
                modal.classList.remove("hidden");
                modal.classList.add("block");
            })
        });
        }

        eventsDeleteCallback();
    </script>
</x-app-layout>
