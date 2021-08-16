<x-app-layout>
    <div class="py-6 show-guiding-parameter-ref-value">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Detalhes Ref. Vlr. Param. Orientador') }}</h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2 ">
                        <a class="btn-outline-info" href="{{ route('guiding-parameter-ref-value.index') }}">{{ __('Listar') }}</a>
                    </div>
                    <div class="m-2">
                        <a class="btn-outline-warning" href="{{ route('guiding-parameter-ref-value.edit', ['guiding_parameter_ref_value' => $guidingParameterRefValue->id]) }}">{{ __('Editar') }}</a>
                    </div>
                    <div class="m-2">
                        <button type="button" class="btn-outline-danger delete-environmental-area" id="guiding_parameter_ref_value_delete" data-toggle="modal" data-target="#delete_modal" data-id="{{ $guidingParameterRefValue->id }}">{{ __('Apagar') }}</button>
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
                            <p class="text-gray-500 font-bold">{{ $guidingParameterRefValue->id }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Ref. Vlr. Param. Orientador') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $guidingParameterRefValue->guiding_parameter_ref_value_id }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Obs') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $guidingParameterRefValue->observation }}</p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <x-modal title="{{ __('Excluir usuário') }}"
             msg="{{ __('Deseja realmente apagar esse Tipo Param. Análise?') }}"
             confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_guiding_parameter_ref_value_modal"
             method="DELETE"
             url="{{ route('guiding-parameter-ref-value.destroy', ['guiding_parameter_ref_value' => $guidingParameterRefValue->id]) }}"
             redirect-url="{{ route('guiding-parameter-ref-value.index') }}"/>

    <script>
        function eventsDeleteCallback() {
            document.querySelectorAll('.delete-environmental-area').forEach(item => {
            item.addEventListener("click", function() {
                var modal = document.getElementById("delete_guiding_parameter_ref_value_modal");
                modal.classList.remove("hidden");
                modal.classList.add("block");
            })
        });
        }

        eventsDeleteCallback();
    </script>
</x-app-layout>
