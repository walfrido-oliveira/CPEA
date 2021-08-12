<x-app-layout>
    <div class="py-6 show-parameter-analysis-group">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Detalhes do Grupo Param. Análise') }}</h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2 ">
                        <a class="btn-outline-info" href="{{ route('registers.parameter-analysis-group.index') }}">{{ __('Listar') }}</a>
                    </div>
                    <div class="m-2">
                        <a class="btn-outline-warning" href="{{ route('registers.parameter-analysis-group.edit', ['parameter_analysis_group' => $parameterAnalysisGroup->id]) }}">{{ __('Editar') }}</a>
                    </div>
                    <div class="m-2">
                        <button type="button" class="btn-outline-danger delete-parameter-analysis-group" id="parameter_analysis_group_delete" data-toggle="modal" data-target="#delete_modal" data-id="{{ $parameterAnalysisGroup->id }}">{{ __('Apagar') }}</button>
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
                            <p class = "text-gray-500 font-bold">{{ $parameterAnalysisGroup->id }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __('Nome Grupo Param. Análise') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $parameterAnalysisGroup->name }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __('Grupo Param. Análise Pai') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $parameterAnalysisGroup->parameterAnalysisGroup ? $parameterAnalysisGroup->parameterAnalysisGroup->name : '' }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __('Ordem') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $parameterAnalysisGroup->order }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __('Data Fim Validade') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $parameterAnalysisGroup->final_validity->format('d/m/Y h:i:s')}}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __('Data de Cadastro') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $parameterAnalysisGroup->created_at->format('d/m/Y h:i:s')}}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __('Última Edição') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $parameterAnalysisGroup->updated_at->format('d/m/Y h:i:s')}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-modal title="{{ __('Excluir Grupo Param. Análise') }}"
             msg="{{ __('Deseja realmente apagar esse Grupo Param. Análise?') }}"
             confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_parameter_analysis_group_modal"
             method="DELETE"
             url="{{ route('registers.parameter-analysis-group.destroy', ['parameter_analysis_group' => $parameterAnalysisGroup->id]) }}"
             redirect-url="{{ route('registers.parameter-analysis-group.index') }}"/>

    <script>
        function eventsDeleteCallback() {
            document.querySelectorAll('.delete-parameter-analysis-group').forEach(item => {
            item.addEventListener("click", function() {
                var modal = document.getElementById("delete_parameter_analysis_group_modal");
                modal.classList.remove("hidden");
                modal.classList.add("block");
            })
        });
        }

        eventsDeleteCallback();
    </script>
</x-app-layout>
