<x-app-layout>
    <div class="py-6 show-guiding-parameter">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Detalhes Param. Orientador') }}</h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2 ">
                        <a class="btn-outline-info" href="{{ route('guiding-parameter.index') }}">{{ __('Listar') }}</a>
                    </div>
                    <div class="m-2">
                        <a class="btn-outline-warning" href="{{ route('guiding-parameter.edit', ['guiding_parameter' => $guidingParameter->id]) }}">{{ __('Editar') }}</a>
                    </div>
                    <div class="m-2">
                        <button type="button" class="btn-outline-danger delete-environmental-area" id="guiding_parameter_delete" data-toggle="modal" data-target="#delete_modal" data-id="{{ $guidingParameter->id }}">{{ __('Apagar') }}</button>
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
                            <p class=   "text-gray-500 font-bold">{{ $guidingParameter->id }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Cod. Parm. Orientador Ambiental') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $guidingParameter->environmental_guiding_parameter_id }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Nome Param. Orientador') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $guidingParameter->name }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Tipo Área Ambiental') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">
                                @if ($guidingParameter->environmentalArea)
                                    <a class="text-green-600 underline" href="{{ route('registers.environmental-area.show', ['environmental_area' => $guidingParameter->environmentalArea->id]) }}">
                                        {{ $guidingParameter->environmentalArea->name }}
                                    </a>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Órgão Ambiental') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">
                                @if ($guidingParameter->environmentalAgency)
                                    <a class="text-green-600 underline" href="{{ route('registers.environmental-agency.show', ['environmental_agency' => $guidingParameter->environmentalAgency->id]) }}">
                                        {{ $guidingParameter->environmentalAgency->name }}
                                    </a>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Data de Cadastro') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $guidingParameter->created_at->format('d/m/Y h:i:s')}}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Última Edição') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $guidingParameter->updated_at->format('d/m/Y h:i:s')}}</p>
                        </div>
                    </div>
                </div>

                <div class="mx-4 px-3 py-2 mt-4">
                    <h1 class="mb-2">{{ __('Param. Valor(es) Orientador(es)') }}</h1>
                    @foreach ($guidingParameter->guidingParameterValues as $guidingParameterValue)
                        <p class="text-gray-500 font-bold text-center">
                            <a class="text-green-600 underline" href="{{ route('guiding-parameter-value.show', ['guiding_parameter_value' => $guidingParameterValue->id]) }}">
                                {{ $guidingParameterValue->guidingParameter->name . ' - ' .
                                   $guidingParameterValue->analysisMatrix->name . ' - ' .
                                   $guidingParameterValue->parameterAnalysis->analysis_parameter_name
                                }}
                            </a>
                        </p>
                    @endforeach
                </div>

            </div>
        </div>
    </div>

    <x-modal title="{{ __('Excluir usuário') }}"
             msg="{{ __('Deseja realmente apagar esse Tipo Param. Análise?') }}"
             confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_guiding_parameter_modal"
             method="DELETE"
             url="{{ route('guiding-parameter.destroy', ['guiding_parameter' => $guidingParameter->id]) }}"
             redirect-url="{{ route('guiding-parameter.index') }}"/>

    <script>
        function eventsDeleteCallback() {
            document.querySelectorAll('.delete-environmental-area').forEach(item => {
            item.addEventListener("click", function() {
                var modal = document.getElementById("delete_guiding_parameter_modal");
                modal.classList.remove("hidden");
                modal.classList.add("block");
            })
        });
        }

        eventsDeleteCallback();
    </script>
</x-app-layout>
