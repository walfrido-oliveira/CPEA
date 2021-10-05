
<x-app-layout>
    <div class="py-6 show-sample-analysis">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Custódia de Amostra(s)') }}</h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2 ">
                        <a class="btn-outline-info" href="{{ route('sample-analysis.historic', ['campaign' => $campaign->id]) }}">{{ __('Histórico') }}</a>
                    </div>
                    <div class="m-2">
                        <a class="btn-outline-danger" href="{{ route('sample-analysis.index') }}">{{ __('Voltar') }}</a>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg flex md:flex-row flex-col flex-wrap">
                <div class="flex md:flex-row flex-col w-full">
                    <div class="mx-4 px-3 py-2 w-full flex items-center">
                        <h2>{{ __('Projeto') }}</h2>
                    </div>
                </div>
                <div class="mx-4 px-3 py-2 flex md:flex-row flex-col w-full">
                    <div class="flex">
                        <div>
                            <div class="grid grid-cols-2">
                                <div class="mx-1 px-1">
                                    <p class="font-bold">{{ __('Cliente') }}</p>
                                </div>
                                <div class="mx-1 px-1">
                                    <p class="text-gray-500 font-bold">{{ $campaign->project->customer->name }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2">
                                <div class="mx-1 px-1">
                                    <p class="font-bold">{{ __('Projeto') }}</p>
                                </div>
                                <div class="mx-1 px-1">
                                    <p class="text-gray-500 font-bold">{{ $campaign->project->project_cod }}</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="grid grid-cols-2">
                                <div class="mx-1 px-1">
                                    <p class="font-bold">{{ __('Campanha') }}</p>
                                </div>
                                <div class="mx-1 px-1">
                                    <p class="text-gray-500 font-bold">{{ $campaign->name }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2">
                                <div class="mx-1 px-1">
                                    <p class="font-bold">{{ __('Dt. Modificação') }}</p>
                                </div>
                                <div class="mx-1 px-1">
                                    <p class="text-gray-500 font-bold">{{ $campaign->updated_at->format('d/m/Y h:m') }}</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="grid grid-cols-2">
                                <div class="mx-1 px-1">
                                    <p class="font-bold">{{ __('Status') }}</p>
                                </div>
                                <div class="mx-1 px-1">
                                    <p class="text-gray-500 font-bold">
                                        @switch($campaign->project->status)
                                            @case("sent")
                                                <span class="w-24 py-1 badge-light-primary">{{ __($campaign->project->status) }}</span>
                                                @break
                                            @case("pending")
                                                <span class="w-24 py-1 badge-light-danger">{{ __($campaign->project->status) }}</span>
                                                @break
                                            @case("analyzing")
                                                <span class="w-24 py-1 badge-light-warning">{{ __($campaign->project->status) }}</span>
                                                @break
                                            @case("concluded")
                                                <span class="w-24 py-1 badge-light-success">{{ __($campaign->project->status) }}</span>
                                                @break
                                            @default
                                        @endswitch
                                    </p>
                                </div>
                            </div>
                            <div class="grid">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg flex md:flex-row flex-col flex-wrap">
                <div class="flex md:flex-row flex-col w-full">
                    <div class="mx-4 px-3 py-2 w-full flex items-center">
                        <h2>{{ __('Pedidos de Análise') }}</h2>
                    </div>
                </div>
                <div class="flex mt-4 w-full">
                    <table id="order_table" class="table table-responsive md:table w-full">
                        <thead>
                            <tr class="thead-light">
                                <th>{{ __('Nº do Pedido') }}</th>
                                <th>{{ __('Data de Envio') }}</th>
                                <th>{{ __('Laboratório') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Dt. Modificação') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg flex md:flex-row flex-col flex-wrap">
                <div class="flex md:flex-row flex-col w-full">
                    <div class="mx-4 px-3 py-2 w-full flex items-center">
                        <h2>{{ __('Amostras') }}</h2>
                    </div>
                    <div class="py-2 flex justify-end" x-data="{ open: false }">
                        <div class="flex">
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
                    <div class="flex justify-end">
                        <div class="m-2 ">
                            <button class="btn-outline-info">Adicionar</button>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <div class="my-2 mr-2">
                            <a href="#" role="button" class="btn-transition relative flex py-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-1 w-6 h-6" style="-webkit-transform: scaleX(-1); transform: scaleX(-1);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span class="absolute left-0 top-0 rounded-full bg-green-600 w-4 h-4 top right p-0 m-0 text-white font-mono text-sm  leading-tight text-center">2
                                </span>
                              </a>
                        </div>
                    </div>
                </div>
                <div class="flex mt-4 w-full">
                    <table id="parameter_analysis_table" class="table table-responsive md:table w-full">
                        @include('sample-analysis.parameter-analysis-result')
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
