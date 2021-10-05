
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
                    <div class="flex md:flex-row flex-col">
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
                            <div class="grid" style="grid-template-columns: 8ch auto;">
                                <div class="mx-1 px-1">
                                    <p class="font-bold">{{ __('Status') }}</p>
                                </div>
                                <div class="flex">
                                    <p class="text-gray-500 font-bold inline" id="status_project_badge">
                                        @include('sample-analysis.status-project', ['status' => $campaign->project->status ])
                                    </p>
                                    <button type="button" class="btn-transition-warning inline status-project-edit" title="{{ __('Analisando') }}" data-status="{{ 'analyzing' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                        </svg>
                                    </button>
                                    <button type="button" class="btn-transition-primary inline status-project-edit" title="{{ __('Enviado') }}" data-status="{{ 'sent' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                        </svg>
                                    </button>
                                    <button type="button" class="btn-transition-success inline status-project-edit" title="{{ __('Concluído') }}" data-status="{{ 'concluded' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
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
            <form method="POST" action="{{ route('sample-analysis.cart') }}">
                @csrf
                @method("POST")

                <div class="py-2 my-2 bg-white rounded-lg flex md:flex-row flex-col flex-wrap">
                    <div class="flex w-full md:flex-nowrap flex-wrap">
                        <div class="mx-4 px-3 py-2 flex items-center md:justify-start justify-center md:w-auto w-full">
                            <h2>{{ __('Amostras') }}</h2>
                        </div>
                        <div class="py-2 flex md:justify-end justify-start w-full" x-data="{ open: false }">
                            <div class="flex">
                                <button type="button" @click="open = !open" id="nav-toggle" class="w-full block btn-transition-secondary">
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
                        <div class="flex md:justify-end justify-center md:mx-0 mx-auto">
                            <div class="m-2 ">
                                <button type="button" class="btn-outline-info" id="add-parameter-analysis-items">Adicionar</button>
                            </div>
                        </div>
                        <div class="flex md:justify-end justify-center md:mx-0 mx-auto">
                            <div class="my-2 mr-2">
                                <button type="submit" class="btn-transition relative flex py-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-1 w-6 h-6" style="-webkit-transform: scaleX(-1); transform: scaleX(-1);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span id="cart_amount" class="absolute left-0 top-0 rounded-full bg-green-600 w-4 h-4 top right p-0 m-0 text-white font-mono text-sm  leading-tight text-center">
                                        0
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
            </form>
        </div>
    </div>

    <script>
        function updateStatusProject(status) {
            let ajax = new XMLHttpRequest();
            let url = "{!! route('project.status', ['project' => $campaign->project->id]) !!}";
            let token = document.querySelector('meta[name="csrf-token"]').content;
            let method = 'POST';

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);
                    document.getElementById("status_project_badge").innerHTML = resp.result;
                } else if(this.readyState == 4 && this.status != 200) {
                    toastr.error("{!! __('Um erro ocorreu ao solicitar a consulta') !!}");
                }
            }

            var data = new FormData();
            data.append('_token', token);
            data.append('_method', method);
            data.append('status', status);
            data.append('id', {{ $campaign->project->id }});

            ajax.send(data);
        }

        document.querySelectorAll(".status-project-edit").forEach(item => {
            item.addEventListener("click", function(){
                updateStatusProject(item.dataset.status);
            });
        });
    </script>

</x-app-layout>
