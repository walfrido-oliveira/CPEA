
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
                                <div class="mx-1 px-1" id="status_project_badge">
                                    @include('sample-analysis.status-project', ['status' => $campaign->project->status ])
                                </div>
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
                            @forelse ($orders as $order)
                                <tr>
                                    <td>
                                        <a class="text-item-table" href="{{ route('analysis-order.show', ['analysis_order' => $order->id]) }}">
                                            {{ $order->formatted_id }}
                                        </a>
                                    </td>
                                    <td>
                                        <a class="text-item-table" href="{{ route('analysis-order.show', ['analysis_order' => $order->id]) }}">
                                            {{ $order->created_at->format('d/m/Y h:m') }}
                                        </a>
                                    </td>
                                    <td>
                                        <a class="text-item-table" href="{{ route('analysis-order.show', ['analysis_order' => $order->id]) }}">
                                            {{ $order->lab->name }}
                                        </a>
                                    </td>
                                    <td>
                                        <a class="text-item-table" href="{{ route('analysis-order.show', ['analysis_order' => $order->id]) }}">
                                            @switch($order->status)
                                                @case("sent")
                                                    <span class="w-24 py-1 badge-light-primary">{{ __($order->status) }}</span>
                                                    @break
                                                @case("canceled")
                                                    <span class="w-24 py-1 badge-light-danger">{{ __($order->status) }}</span>
                                                    @break
                                                @case("analyzing")
                                                    <span class="w-24 py-1 badge-light-warning">{{ __($order->status) }}</span>
                                                    @break
                                                @case("concluded")
                                                    <span class="w-24 py-1 badge-light-success">{{ __($order->status) }}</span>
                                                    @break
                                                @default
                                            @endswitch
                                        </a>
                                    </td>
                                    <td>
                                        <a class="text-item-table" href="{{ route('analysis-order.show', ['analysis_order' => $order->id]) }}">
                                            {{ $order->updated_at->format('d/m/Y h:m') }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="5">{{ __("Nenhum pedido encontrado") }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <form method="POST" action="{{ route('analysis-order.cart') }}" id="parameter_analysis_form">
                @csrf
                @method("POST")

                <input type="hidden" name="cart" id="cart">
                <input type="hidden" name="campaign_id" id="campaign_id" value="{{ $campaign->id }}">

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
                            <div :class="{'block': open, 'hidden': !open}" class="w-full block" id="search-content">
                                <div class="container mx-auto">
                                    <input id="q" name="q" type="search" placeholder="Buscar..." autofocus="autofocus" class="filter-field w-full form-control no-border">
                                </div>
                            </div>
                        </div>
                        <div class="flex md:justify-end justify-center md:mx-0 mx-auto">
                            <div class="m-2 ">
                                <button type="button" class="btn-outline-info" id="add-parameter-analysis-items">{{ __('Adicionar') }}</button>
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
                    updateStatusProjectCallback();
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

        updateStatusProjectCallback();

        function updateStatusProjectCallback() {
            document.querySelectorAll(".status-project-edit").forEach(item => {
                item.addEventListener("click", function(){
                    updateStatusProject(item.dataset.status);
                });
            });
        }
    </script>

    <script>
        var cart = [];
        var groups = [];
        var identifications = [];

        var filterCallback = function (event) {
            var ajax = new XMLHttpRequest();
            var url = "{!! route('sample-analysis.filter-point-matrix') !!}";
            var token = document.querySelector('meta[name="csrf-token"]').content;
            var method = 'POST';

            var q = document.getElementById("q").value;

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);
                    document.getElementById("parameter_analysis_table").innerHTML = resp.filter_result;

                    for (let index = 0; index < identifications.length; index++) {
                        const element = identifications[index];
                        document.querySelectorAll(".parameter-analysis-identification").forEach(item => {
                            if(item.value == element) item.checked = true;
                        });
                    }

                    for (let index = 0; index < groups.length; index++) {
                        const element = groups[index];
                        document.querySelectorAll(".parameter-analysis-group").forEach(item => {
                            if(item.value == element.group &&
                              item.dataset.identificationId == element.identification) item.checked = true;
                        });
                    }

                    for (let index = 0; index < cart.length; index++) {
                        const element = cart[index];
                        document.querySelectorAll(".parameter-analysis-item").forEach(item => {
                            if(item.value == element) item.checked = true;
                        });
                    }

                    eventsFilterCallback();
                    checkItems();
                } else if(this.readyState == 4 && this.status != 200) {
                    toastr.error("{!! __('Um erro ocorreu ao gerar a consulta') !!}");
                    eventsFilterCallback();
                    checkItems();
                }
            }

            var data = new FormData();
            data.append('_token', token);
            data.append('_method', method);
            if(q) data.append('q', q);
            data.append('ascending', 'asc');
            data.append('order_by', 'point_identifications.identification');
            data.append('campaign_id', "{{ $campaign->id }}");

            ajax.send(data);
        }

        function eventsFilterCallback() {
            document.querySelectorAll('.filter-field').forEach(item => {
                item.addEventListener('change', filterCallback, false);
                item.addEventListener('keyup', filterCallback, false);
            });
            document.querySelectorAll("#parameter_analysis_table thead [data-name]").forEach(item => {
                item.addEventListener("click", orderByCallback, false);
            });
        }

        eventsFilterCallback();

        checkItems();

        function checkItems() {
            document.querySelectorAll(".parameter-analysis-identification").forEach(item => {

                item.addEventListener("change", function() {
                    if(item.checked) {
                        document.querySelectorAll(".parameter-analysis-group").forEach(item2 => {
                            if(item.dataset.identificationId == item2.dataset.identificationId) {
                                item2.checked = true;
                                item2.dispatchEvent(new Event('change'));
                            }
                        });
                    } else {
                        document.querySelectorAll(".parameter-analysis-group").forEach(item2 => {
                            if(item.dataset.identificationId == item2.dataset.identificationId) {
                                item2.checked = false;
                                item2.dispatchEvent(new Event('change'));
                            }
                        });
                    }
                });
            });

            document.querySelectorAll(".parameter-analysis-group").forEach(item => {
                item.addEventListener("change", function() {
                    if(item.checked) {
                        document.querySelectorAll(".parameter-analysis-item").forEach(item2 => {
                            if(item.dataset.groupId == item2.dataset.groupId &&
                            item.dataset.identificationId == item2.dataset.identificationId) {
                                item2.checked = true;
                            }
                        });
                    } else {
                        document.querySelectorAll(".parameter-analysis-item").forEach(item2 => {
                            if(item.dataset.groupId == item2.dataset.groupId &&
                            item.dataset.identificationId == item2.dataset.identificationId) {
                                item2.checked = false;
                            }
                        });
                    }
                })
            });

            document.querySelectorAll(".parameter-analysis-item").forEach(item => {
                item.addEventListener("change", function() {
                    if(!item.checked) {
                        document.querySelectorAll(".parameter-analysis-group").forEach(item2 => {
                            if(item.dataset.groupId == item2.dataset.groupId &&
                                item.dataset.identificationId == item2.dataset.identificationId) {
                                    item2.checked = false;
                            }
                        });
                    }
                })
            });

            document.querySelectorAll(".add-parameter-analysis-item").forEach(item =>{
                item.addEventListener("click", function() {
                    let item = this.parentNode.parentNode.querySelector('td input');
                    item.checked = !item.checked;
                    setSelectedItems();
                });
            });

            document.getElementById("add-parameter-analysis-items").addEventListener("click", function() {
                setSelectedItems();
            });
        }

        function setSelectedItems() {
            let count = document.getElementById("cart_amount");

            identifications = [];
            document.querySelectorAll("input:checked.parameter-analysis-identification").forEach(item => {
                identifications.push(item.value);
            });

            groups = [];
            document.querySelectorAll("input:checked.parameter-analysis-group").forEach(item => {
                groups.push({
                    group: item.value,
                    identification: item.dataset.identificationId
                });
            });

            cart = [];
            document.querySelectorAll("input:checked.parameter-analysis-item").forEach(item => {
                cart.push(item.value);
            });

            document.getElementById("cart").value = cart;

            count.innerHTML = cart.length;
        }
    </script>
</x-app-layout>
