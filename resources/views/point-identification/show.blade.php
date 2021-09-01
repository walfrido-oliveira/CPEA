<x-app-layout>
    <div class="py-6 show-point-identification">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Detalhes do Ponto') }}</h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2 ">
                        <a class="btn-outline-info" href="{{ route('registers.point-identification.index') }}">{{ __('Listar') }}</a>
                    </div>
                    <div class="m-2">
                        <a class="btn-outline-warning" href="{{ route('registers.point-identification.edit', ['point_identification' => $pointIdentification->id]) }}">{{ __('Editar') }}</a>
                    </div>
                    <div class="m-2">
                        <button type="button" class="btn-outline-danger delete-point-identification" id="point_identification_delete" data-toggle="modal" data-target="#delete_modal" data-id="{{ $pointIdentification->id }}">{{ __('Apagar') }}</button>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg">
                <div class="mx-4 px-3 py-2 mt-4">
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('ID') }}</p>
                        </div>

                        <div class="w-full md:w-1/2">
                            <p class=   "text-gray-500 font-bold">{{ $pointIdentification->id }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Área') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $pointIdentification->area }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Identificação do Ponto') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $pointIdentification->identification }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Coordenada UTM ME') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ number_format($pointIdentification->utm_me_coordinate, 5, ",", ".")   }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Coordenada UTM MM') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ number_format($pointIdentification->utm_mm_coordinate, 5, ",", ".") }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Profundidade Poço') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ number_format($pointIdentification->pool_depth, 5, ",", ".") }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Sistema Geodesico') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $pointIdentification->geodeticSystem->name }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Diâmetro Poço') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ number_format($pointIdentification->pool_diameter, 5, ",", ".") }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Profundidade Nível Água') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ number_format($pointIdentification->water_depth, 5, ",", ".") }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Profundidade Col. Sedmentar') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ number_format($pointIdentification->sedimentary_collection_depth, 5, ",", ".") }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Volume Poço') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ number_format($pointIdentification->pool_volume, 5, ",", ".") }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Profundidade Col Coleta') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ number_format($pointIdentification->collection_depth, 5, ",", ".") }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Profundidade Col Água') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ number_format($pointIdentification->water_collection_depth, 5, ",", ".") }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Data de Cadastro') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $pointIdentification->created_at->format('d/m/Y h:i:s')}}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/4">
                            <p class="font-bold">{{ __('Última Edição') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $pointIdentification->updated_at->format('d/m/Y h:i:s')}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg flex md:flex-row flex-col flex-wrap">
                <div class="flex md:flex-row flex-col w-full">
                    <div class="mx-4 px-3 py-2 w-full flex items-center">
                        <h1>{{ __('Clientes') }}</h1>
                    </div>
                    <div class="mx-4 px-3 py-2 w-full flex justify-end" x-data="{ open: false }">
                        <div class="pr-4 flex">
                            <button @click="open = !open" id="nav-toggle" class="w-full block btn-transition-secondary">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                              </svg>
                            </button>
                        </div>
                        <!--Search-->
                        <div :class="{'block': open, 'hidden': !open}" class="w-full block" id="search-content">
                            <div class="container mx-auto">
                                <input id="name" name="name" type="search" placeholder="Buscar..." autofocus="autofocus" class="filter-field w-full form-control border-t-0 border-r-0 border-l-0 focus:outline-none focus:ring-0 focus:border-black pt-0 pb-0">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex w-full">
                    <table id="customer_table" class="table table-responsive md:table w-full">
                        @include('customers.filter-result', ['customers' => $customers, 'ascending' => null, 'orderBy' => null, 'actions' => 'hidden'])
                    </table>
                </div>

                <div class="flex w-full mt-4 p-2" id="pagination">
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
    </div>

    <x-modal title="{{ __('Excluir Ponto') }}"
             msg="{{ __('Deseja realmente apagar esse Ponto?') }}"
             confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_point_identification_modal"
             method="DELETE"
             url="{{ route('registers.point-identification.destroy', ['point_identification' => $pointIdentification->id]) }}"
             redirect-url="{{ route('registers.point-identification.index') }}"/>

    @include('customers.filter-result-scripts', ['actions' => 'hidden'])

    <script>
        function eventsDeleteCallback() {
            document.querySelectorAll('.delete-point-identification').forEach(item => {
            item.addEventListener("click", function() {
                var modal = document.getElementById("delete_point_identification_modal");
                modal.classList.remove("hidden");
                modal.classList.add("block");
            })
        });
        }

        eventsDeleteCallback();
    </script>
</x-app-layout>
