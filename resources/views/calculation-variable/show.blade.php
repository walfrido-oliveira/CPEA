<x-app-layout>
    <div class="py-6 show-calculation-variable">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Detalhes do Variável Fórmula Cálculo') }}</h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2 ">
                        <a class="btn-outline-info" href="{{ route('registers.calculation-variable.index') }}">{{ __('Listar') }}</a>
                    </div>
                    <div class="m-2">
                        <a class="btn-outline-warning" href="{{ route('registers.calculation-variable.edit', ['calculation_variable' => $calculationVariable->id]) }}">{{ __('Editar') }}</a>
                    </div>
                    <div class="m-2">
                        <button type="button" class="btn-outline-danger delete-calculation-variable" id="calculation_variable_delete" data-toggle="modal" data-target="#delete_modal" data-id="{{ $calculationVariable->id }}">{{ __('Apagar') }}</button>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                <div class="mx-4 px-3 py-2 mt-4">
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('ID') }}</p>
                        </div>

                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $calculationVariable->id }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Fórmula') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">
                                <a class="text-green-600 underline" href="{{ route('parameter-analysis.show', ['parameter_analysis' => $calculationVariable->calculationParameter->parameterAnalysis->id ]) }}" target="_blank" rel="noopener noreferrer">
                                    {{ $calculationVariable->calculationParameter->parameterAnalysis->analysis_parameter_name }}
                                </a>
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Nome') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $calculationVariable->name }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Data de Cadastro') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $calculationVariable->created_at->format('d/m/Y H:i:s')}}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Última Edição') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $calculationVariable->updated_at->format('d/m/Y H:i:s')}}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <x-modal title="{{ __('Excluir Matriz Análise') }}"
             msg="{{ __('Deseja realmente apagar essa Matriz Análise?') }}"
             confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_calculation_variable_modal"
             method="DELETE"
             url="{{ route('registers.calculation-variable.destroy', ['calculation_variable' => $calculationVariable->id]) }}"
             redirect-url="{{ route('registers.calculation-variable.index') }}"/>

    <script>
        function eventsDeleteCallback() {
            document.querySelectorAll('.delete-calculation-variable').forEach(item => {
            item.addEventListener("click", function() {
                var modal = document.getElementById("delete_calculation_variable_modal");
                modal.classList.remove("hidden");
                modal.classList.add("block");
            })
        });
        }

        eventsDeleteCallback();
    </script>
</x-app-layout>
