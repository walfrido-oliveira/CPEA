<x-app-layout>
    <div class="py-6 show-preparation-method">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Método') }}</h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2 ">
                        <a class="btn-outline-info" href="{{ route('registers.preparation-method.index') }}">{{ __('Listar') }}</a>
                    </div>
                    <div class="m-2">
                        <a class="btn-outline-warning" href="{{ route('registers.preparation-method.edit', ['preparation_method' => $preparationMethod->id]) }}">{{ __('Editar') }}</a>
                    </div>
                    <div class="m-2">
                        <button type="button" class="btn-outline-danger delete-preparation-method" id="preparation_method_delete" data-toggle="modal" data-target="#delete_modal" data-id="{{ $preparationMethod->id }}">{{ __('Apagar') }}</button>
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
                            <p class=   "text-gray-500 font-bold">{{ $preparationMethod->id }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Nome') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $preparationMethod->name }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Data de Cadastro') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $preparationMethod->created_at->format('d/m/Y H:i:s')}}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Última Edição') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $preparationMethod->updated_at->format('d/m/Y H:i:s')}}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <x-modal title="{{ __('Excluir Método Preparo') }}"
             msg="{{ __('Deseja realmente apagar esse Método Preparo?') }}"
             confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_preparation_method_modal"
             method="DELETE"
             url="{{ route('registers.preparation-method.destroy', ['preparation_method' => $preparationMethod->id]) }}"
             redirect-url="{{ route('registers.preparation-method.index') }}"/>

    <script>
        function eventsDeleteCallback() {
            document.querySelectorAll('.delete-preparation-method').forEach(item => {
            item.addEventListener("click", function() {
                var modal = document.getElementById("delete_preparation_method_modal");
                modal.classList.remove("hidden");
                modal.classList.add("block");
            })
        });
        }

        eventsDeleteCallback();
    </script>
</x-app-layout>
