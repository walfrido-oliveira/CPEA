<x-app-layout>
    <div class="py-6 show-point-identification">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ $pointIdentification->area }} - {{ $pointIdentification->identification }}</h1>
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

            <div class="bg-white rounded-lg py-2 my-2">
                <div class="mx-4 px-3 py-2">
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div class="">
                            <div class="flex">
                                <div class="w-full">
                                    <p class="font-bold">{{ __('ID') }}</p>
                                </div>

                                <div class="w-full">
                                    <p class="text-gray-500 font-bold">{{ $pointIdentification->id }}</p>
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-full">
                                    <p class="font-bold">{{ __('Área') }}</p>
                                </div>
                                <div class="w-full">
                                    <p class="text-gray-500 font-bold">{{ $pointIdentification->area }}</p>
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-full">
                                    <p class="font-bold">{{ __('Identificação do Ponto') }}</p>
                                </div>
                                <div class="w-full">
                                    <p class="text-gray-500 font-bold">{{ $pointIdentification->identification }}</p>
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-full">
                                    <p class="font-bold">{{ __('Coordenada UTM ME') }}</p>
                                </div>
                                <div class="w-full">
                                    <p class="text-gray-500 font-bold">{{ number_format($pointIdentification->utm_me_coordinate, 5, ",", ".")   }}</p>
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-full">
                                    <p class="font-bold">{{ __('Coordenada UTM MM') }}</p>
                                </div>
                                <div class="w-full">
                                    <p class="text-gray-500 font-bold">{{ number_format($pointIdentification->utm_mm_coordinate, 5, ",", ".") }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="flex">
                                <div class="w-full">
                                    <p class="font-bold">{{ __('Profundidade Poço') }}</p>
                                </div>
                                <div class="w-full">
                                    <p class="text-gray-500 font-bold">{{ number_format($pointIdentification->pool_depth, 5, ",", ".") }}</p>
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-full">
                                    <p class="font-bold">{{ __('Sistema Geodesico') }}</p>
                                </div>
                                <div class="w-full">
                                    <p class="text-gray-500 font-bold">{{ $pointIdentification->geodeticSystem ? $pointIdentification->geodeticSystem->name : '' }}</p>
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-full">
                                    <p class="font-bold">{{ __('Diâmetro Poço') }}</p>
                                </div>
                                <div class="w-full">
                                    <p class="text-gray-500 font-bold">{{ number_format($pointIdentification->pool_diameter, 5, ",", ".") }}</p>
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-full">
                                    <p class="font-bold">{{ __('Profundidade Nível Água') }}</p>
                                </div>
                                <div class="w-full">
                                    <p class="text-gray-500 font-bold">{{ number_format($pointIdentification->water_depth, 5, ",", ".") }}</p>
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-full">
                                    <p class="font-bold">{{ __('Profundidade Col. Sedmentar') }}</p>
                                </div>
                                <div class="w-full">
                                    <p class="text-gray-500 font-bold">{{ number_format($pointIdentification->sedimentary_collection_depth, 5, ",", ".") }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="flex">
                                <div class="w-full">
                                    <p class="font-bold">{{ __('Volume Poço') }}</p>
                                </div>
                                <div class="w-full">
                                    <p class="text-gray-500 font-bold">{{ number_format($pointIdentification->pool_volume, 5, ",", ".") }}</p>
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-full">
                                    <p class="font-bold">{{ __('Profundidade Col Coleta') }}</p>
                                </div>
                                <div class="w-full">
                                    <p class="text-gray-500 font-bold">{{ number_format($pointIdentification->collection_depth, 5, ",", ".") }}</p>
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-full">
                                    <p class="font-bold">{{ __('Profundidade Col Água') }}</p>
                                </div>
                                <div class="w-full">
                                    <p class="text-gray-500 font-bold">{{ number_format($pointIdentification->water_collection_depth, 5, ",", ".") }}</p>
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-full">
                                    <p class="font-bold">{{ __('Data de Cadastro') }}</p>
                                </div>
                                <div class="w-full">
                                    <p class="text-gray-500 font-bold">{{ $pointIdentification->created_at->format('d/m/Y H:i:s')}}</p>
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-full">
                                    <p class="font-bold">{{ __('Última Edição') }}</p>
                                </div>
                                <div class="w-full">
                                    <p class="text-gray-500 font-bold">{{ $pointIdentification->updated_at->format('d/m/Y H:i:s')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg flex md:flex-row flex-col flex-wrap">
                <div class="flex md:flex-row flex-col w-full">
                    <div class="mx-4 px-3 py-2 w-full flex items-center">
                        <h2>{{ __('Clientes') }}</h2>
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
                                <input id="name_customer" name="name" type="search" placeholder="Buscar..." autofocus="autofocus" class="filter-field w-full form-control no-border">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex w-full">
                    <table id="customer_table" class="table table-responsive md:table w-full">
                        @include('customers.filter-result', ['customers' => $customers, 'ascending' => 'asc', 'orderBy' => 'id', 'actions' => 'hidden'])
                    </table>
                </div>
                <div class="flex w-full mt-4 p-2" id="pagination_customers">
                    {{ $customers->links() }}
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg flex md:flex-row flex-col flex-wrap">
                <div class="flex md:flex-row flex-col w-full">
                    <div class="mx-4 px-3 py-2 w-full flex items-center">
                        <h2>{{ __('Projetos/Campanhas/Param Análise') }}</h2>
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
                                <input id="name_campaign" name="name" type="search" placeholder="Buscar..." autofocus="autofocus" class="w-full form-control no-border">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex w-full">
                    <table id="campaign_table" class="table table-responsive md:table w-full">
                        @include('point-identification.filter-result-point', ['orderBy' => 'projects.project_cod', 'ascending' => 'asc'])
                    </table>
                </div>
                <div class="flex w-full mt-4 p-2" id="pagination_campaigns">
                    {{ $projectCampaigns->links() }}
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

    @include('point-identification.customer-filter-result-scripts', ['actions' => 'hidden', 'ascending' => 'asc', 'orderBy' => 'id'])
    @include('point-identification.campaign-filter-result-scripts', ['actions' => 'hidden', 'ascending' => 'asc', 'orderBy' => 'name'])

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
