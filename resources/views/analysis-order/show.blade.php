<x-app-layout>
    <div class="py-6 show-sample-analysis">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>Pedido {{ $analysisOrder->formatted_id }}</h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2">
                        <a class="btn-outline-danger"
                            href="{{ route('sample-analysis.index') }}">{{ __('Cancelar') }}</a>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg flex md:flex-row flex-col flex-wrap">
                <div class="flex md:flex-row flex-col w-full">
                    <div class="mx-4 px-3 py-2 w-full flex items-center">
                        <h2>{{ __('Status') }}</h2>
                    </div>
                </div>
                <div class="mx-4 px-3 py-2 flex md:flex-row flex-col w-full">
                    <div class="flex md:flex-row flex-col w-full">
                        <div class="md:w-1/2 w-full">
                            <div class="grid" style="grid-template-columns: 1fr 3fr;">
                                <div class="mx-1 px-1">
                                    <p class="font-bold md:text-right">{{ __('Cliente:') }}</p>
                                </div>
                                <div class="mx-1 px-1">
                                    <p class="text-gray-500 font-bold">
                                        {{ $analysisOrder->campaign->project->customer->name }}</p>
                                </div>
                            </div>
                            <div class="grid " style="grid-template-columns: 1fr 3fr;">
                                <div class="mx-1 px-1">
                                    <p class="font-bold md:text-right">{{ __('Projeto:') }}</p>
                                </div>
                                <div class="mx-1 px-1">
                                    <p class="text-gray-500 font-bold">
                                        {{ $analysisOrder->campaign->project->project_cod }}</p>
                                </div>
                            </div>
                            <div class="grid " style="grid-template-columns: 1fr 3fr;">
                                <div class="mx-1 px-1">
                                    <p class="font-bold md:text-right">{{ __('Observações:') }}</p>
                                </div>
                                <div class="mx-1 px-1">
                                    <p class="text-gray-500 font-bold">{{ $analysisOrder->obs }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="md:w-1/2 w-full">
                            <div class="grid " style="grid-template-columns: 1fr 3fr;">
                                <div class="mx-1 px-1">
                                    <p class="font-bold md:text-right">{{ __('Campanha:') }}</p>
                                </div>
                                <div class="mx-1 px-1">
                                    <p class="text-gray-500 font-bold">{{ $analysisOrder->campaign->name }}</p>
                                </div>
                            </div>
                            <div class="grid " style="grid-template-columns: 1fr 3fr;">
                                <div class="mx-1 px-1">
                                    <p class="font-bold md:text-right">{{ __('Laboratório:') }}</p>
                                </div>
                                <div class="mx-1 px-1">
                                    <p class="text-gray-500 font-bold">{{ $analysisOrder->lab->name }}</p>
                                </div>
                            </div>
                            <div class="grid " style="grid-template-columns: 1fr 3fr;">
                                <div class="mx-1 px-1">
                                    <p class="font-bold md:text-right">{{ __('Pedido:') }}</p>
                                </div>
                                <div class="mx-1 px-1">
                                    <p class="text-gray-500 font-bold">{{ $analysisOrder->formatted_id }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block w-full justify-center">
                    <div class="p-5">
                        <div class="mx-4 p-4">
                            <div class="flex items-center">

                                <div class="flex items-center relative
                                    @if($analysisOrder->status == "sent")
                                        text-white
                                    @else
                                        text-green-900
                                    @endif">
                                    <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 border-green-900 @if($analysisOrder->status == "sent") bg-green-900 @endif">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                        </svg>
                                    </div>
                                    <div class="absolute top-0 -ml-10 text-center mt-14 w-32 text-gray-500 font-bold text-xs md:block hidden">
                                        {{ __('Pedido Enviado') }} <br />
                                        {{ $analysisOrder->created_at->format('d/M h:m') }}
                                    </div>
                                </div>

                                <div class="flex-auto border-t-2 transition duration-500 ease-in-out
                                    @if($analysisOrder->status != "sent")
                                        border-green-900
                                    @else
                                        border-gray-300
                                    @endif">
                                </div>

                                <div class="flex items-center
                                    @if($analysisOrder->status == "analyzing")
                                        text-white
                                    @elseif($analysisOrder->status == "concluded")
                                        text-green-900
                                    @else
                                        text-gray-500
                                    @endif

                                    relative">

                                    <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2
                                        @if($analysisOrder->status == "analyzing")
                                            border-green-900 bg-green-900
                                        @elseif($analysisOrder->status == "concluded")
                                            border-green-900
                                        @else
                                            border-gray-300
                                        @endif">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                        </svg>
                                    </div>
                                    <div class="absolute top-0 -ml-10 text-center mt-14 w-32 text-gray-500 font-bold text-xs md:block hidden">
                                        {{ __('Pedido em Análise') }}
                                    </div>
                                </div>

                                <div class="flex-auto border-t-2 transition duration-500 ease-in-out @if($analysisOrder->status == "concluded") border-green-900 @else border-gray-300 @endif ">
                                </div>

                                <div class="flex items-center
                                    @if($analysisOrder->status == "concluded")
                                        text-white
                                    @else
                                        text-gray-500
                                    @endif
                                    relative">
                                    <div
                                        class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2
                                            @if($analysisOrder->status == "concluded")
                                                border-green-900 bg-green-900
                                            @else
                                                border-gray-300
                                            @endif">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="absolute top-0 -ml-10 text-center mt-14 w-32 text-gray-500 font-bold text-xs md:block hidden">
                                        {{ __('Pedido Concluído') }}
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="mt-8 p-4">
                        </div>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg flex md:flex-row flex-col flex-wrap">
                <div class="flex w-full md:flex-nowrap flex-wrap">
                    <div class="mx-4 px-3 py-2 flex items-center md:justify-start justify-center md:w-auto w-full">
                        <h2>{{ __('Amostras') }}</h2>
                    </div>
                    <div class="py-2 flex md:justify-end justify-start w-full" x-data="{ open: false }">
                        <div class="flex">
                            <button type="button" @click="open = !open" id="nav-toggle"
                                class="w-full block btn-transition-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                        <div :class="{'block': open, 'hidden': !open}" class="w-full block" id="search-content">
                            <div class="container mx-auto">
                                <input id="q" name="q" type="search" placeholder="Buscar..." autofocus="autofocus"
                                    class="filter-field w-full form-control no-border">
                            </div>
                        </div>
                    </div>
                    <div class="flex md:justify-end justify-center md:mx-0 mx-auto md:w-1/4 w-full">
                        <div class="m-2 ">
                            <button type="button" class="btn-outline-info"
                                id="add-parameter-analysis-items">{{ __('Importar Análises') }}</button>
                        </div>
                    </div>
                </div>
                <div class="flex mt-4 w-full">
                    <table id="parameter_analysis_table" class="table table-responsive md:table w-full">
                        @include('analysis-order.parameter-analysis-result')
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        var filterCallback = function(event) {
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
                            if (item.value == element) item.checked = true;
                        });
                    }

                    for (let index = 0; index < groups.length; index++) {
                        const element = groups[index];
                        document.querySelectorAll(".parameter-analysis-group").forEach(item => {
                            if (item.value == element.group &&
                                item.dataset.identificationId == element.identification) item.checked =
                            true;
                        });
                    }

                    for (let index = 0; index < cart.length; index++) {
                        const element = cart[index];
                        document.querySelectorAll(".parameter-analysis-item").forEach(item => {
                            if (item.value == element) item.checked = true;
                        });
                    }

                    eventsFilterCallback();
                    checkItems();
                } else if (this.readyState == 4 && this.status != 200) {
                    toastr.error("{!! __('Um erro ocorreu ao gerar a consulta') !!}");
                    eventsFilterCallback();
                    checkItems();
                }
            }

            var data = new FormData();
            data.append('_token', token);
            data.append('_method', method);
            if (q) data.append('q', q);
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
    </script>
</x-app-layout>
