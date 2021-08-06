<x-app-layout>
    <div class="py-6 show-customers">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Detalhes do Cliente') }}</h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2 ">
                        <a class="btn-outline-info" href="{{ route('customers.index') }}">{{ __('Listar') }}</a>
                    </div>
                    <div class="m-2">
                        <a class="btn-outline-warning" href="{{ route('customers.edit', ['customer' => $customer->id]) }}">{{ __('Editar') }}</a>
                    </div>
                    <div class="m-2">
                        <button type="button" class="btn-outline-danger delete-customer" id="customer_delete" data-toggle="modal" data-target="#delete_modal" data-id="{{ $customer->id }}">{{ __('Apagar') }}</button>
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
                            <p class=   "text-gray-500 font-bold">{{ $customer->id }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Nome do Cliente') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $customer->name }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Situação') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">
                                <span class="w-24 py-1 @if($customer->status == "active") badge-success @elseif($customer->status == 'inactive') badge-danger @endif" >
                                    {{ __($customer->status) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Criado em') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $customer->created_at->format('d/m/Y h:i:s')}}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Ultima Edição') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $customer->updated_at->format('d/m/Y h:i:s')}}</p>
                        </div>
                    </div>
                </div>

                <h2 class="mx-4 px-3 py-2 mt-4">{{ __('Identificação do Ponto') }}</h2>

                <div class="mx-4 px-3 py-2 ">
                    <div class="flex flex-wrap md:mx-6">
                        <div class="w-full">
                            @foreach ($customer->pointIdentifications as $pointIdentification)
                                <p class="text-gray-500 font-bold">
                                    {{ $pointIdentification->area . ', ' . $pointIdentification->identification }}
                                </p>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <x-modal title="{{ __('Excluir cliente') }}"
             msg="{{ __('Deseja realmente apagar esse cliente?') }}"
             confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_customer_modal"
             method="DELETE"
             url="{{ route('customers.destroy', ['customer' => $customer->id]) }}"
             redirect-url="{{ route('customers.index') }}"/>

    <script>
        function eventsDeleteCallback() {
            document.querySelectorAll('.delete-customer').forEach(item => {
            item.addEventListener("click", function() {
                var modal = document.getElementById("delete_customer_modal");
                modal.classList.remove("hidden");
                modal.classList.add("block");
            })
        });
        }

        eventsDeleteCallback();
    </script>
</x-app-layout>
