<x-app-layout>
    <div class="py-6 show-sample-analysis">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>Pedido {{ $analysisOrder->formatted_id }}</h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2 ">
                        <a class="btn-outline-danger" href="{{ route('sample-analysis.show', ['campaign' => $analysisOrder->campaign_id]) }}">{{ __('Voltar') }}</a>
                    </div>
                </div>
            </div>

            <div id="status_analysis_order">
                @include('analysis-order.status')
            </div>

            <div class="py-2 my-2 bg-white rounded-lg flex md:flex-row flex-col flex-wrap">
                <div class="flex w-full md:flex-nowrap flex-wrap">
                    <div class="mx-4 px-3 py-2 flex items-center md:justify-start justify-center md:w-auto w-full">
                        <h2>{{ __('Amostras') }}</h2>
                    </div>
                    <div class="py-2 m-2 flex md:justify-end justify-start w-full" x-data="{ shearch: false }">
                        <div class="w-full block" id="search-content">
                            <div class="container mx-auto">
                                <input id="q" name="q" type="search" placeholder="Buscar..." autofocus="autofocus" class="filter-field w-full form-control no-border">
                            </div>
                        </div>
                        <div class="ml-2">
                            <button type="button" id="nav-toggle" class="w-full block btn-transition-secondary filter-field">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex md:justify-end justify-center md:mx-0 mx-auto md:w-1/3 w-full">
                        <div class="m-2 py-2">
                            <a class="btn-transition-secondary" href="{{ route('analysis-result.download-edd', ['analysis_order' => $analysisOrder->id]) }}" target="_self" rel="noopener noreferrer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </a>
                        </div>
                        <div class="m-2 ">
                           <form method="POST" action="{!! route('analysis-result.import') !!}" enctype="multipart/form-data" id="import_result_form">
                                @csrf
                                @method("POST")
                                <input type="hidden" name="order" id="order" value="{{ $analysisOrder->id }}">
                                <button type="button" class="btn-outline-info" id="import_result">{{ __('Importar Análises') }}</button>
                                <input type="file" name="file" id="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet|application/vnd.ms-excel" class="hidden">
                           </form>
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
    <x-spin-load />

    <div id="import_result_container_modal">

    </div>

    <style>
        [class^='point-items-'] {
            opacity: 0;
            visibility: collapse;
            -webkit-transition: visibility 0.2s linear,
            opacity 0.2s linear;
            -moz-transition: visibility 0.2s linear,
            opacity 0.2s linear;
            -o-transition: visibility 0.2s linear,
            opacity 0.2s linear;
        }
        [class^='point-items-'].active {
            visibility: visible;
            opacity: 1;
        }
    </style>

    <script>
        document.querySelectorAll(".show-point").forEach(item => {
            item.addEventListener("click", function() {
                console.log(item.childNodes);
                item.childNodes[1].classList.toggle("rotate-180");
                document.querySelectorAll(".point-items-" + item.dataset.point).forEach(item => {
                    item.classList.toggle("active");
                });
            });
        });
      </script>

    <script>
        document.getElementById("import_result").addEventListener("click", function() {
            document.getElementById("file").click();
        });

        document.getElementById("file").addEventListener("change", function(e) {
            document.getElementById("spin_load").classList.remove("hidden");

            let ajax = new XMLHttpRequest();
            let url = "{!! route('analysis-result.import') !!}";
            let token = document.querySelector('meta[name="csrf-token"]').content;
            let method = 'POST';
            let that = document.querySelector('#file');
            let files = that.files;
            let order = document.getElementById("order").value;

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);
                    document.getElementById("spin_load").classList.add("hidden");
                    document.getElementById("import_result_container_modal").innerHTML = resp.result;
                    document.getElementById("import_result_confirm_modal").addEventListener("click", function() {
                        document.getElementById("import_result_modal").classList.add("hidden");
                    });
                    that.value = '';
                } else if(this.readyState == 4 && this.status != 200) {
                    document.getElementById("spin_load").classList.add("hidden");
                    toastr.error("{!! __('Um erro ocorreu ao solicitar a consulta') !!}");
                    that.value = '';
                }
            }

            var data = new FormData();
            data.append('_token', token);
            data.append('_method', method);
            data.append('_method', method);
            data.append('file', files[0]);
            data.append('order', order);

            ajax.send(data);

        });

        function importResults() {

        }
    </script>

    <script>
        function updateStatusProject(status) {
            let ajax = new XMLHttpRequest();
            let url = "{!! route('analysis-order.status', ['analysis_order' => $analysisOrder->id]) !!}";
            let token = document.querySelector('meta[name="csrf-token"]').content;
            let method = 'POST';

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);
                    document.getElementById("status_analysis_order").innerHTML = resp.result;
                    updateStatusProjectCallback();
                    toastr.success(resp.message);
                } else if(this.readyState == 4 && this.status != 200) {
                    toastr.error("{!! __('Um erro ocorreu ao solicitar a consulta') !!}");
                }
            }

            var data = new FormData();
            data.append('_token', token);
            data.append('_method', method);
            data.append('status', status);
            data.append('id', {{ $analysisOrder->id }});
            data.append('type', 'analysis-order');

            ajax.send(data);
        }

        updateStatusProjectCallback();

        function updateStatusProjectCallback() {
            document.querySelectorAll(".status-analysis-order-edit").forEach(item => {
                item.addEventListener("click", function(){
                    updateStatusProject(item.dataset.status);
                });
            });
        }

    </script>

    <script>
        var filterCallback = function(event) {
            var ajax = new XMLHttpRequest();
            var url = "{!! route('analysis-order.filter-point-matrix') !!}";
            var token = document.querySelector('meta[name="csrf-token"]').content;
            var method = 'POST';

            var q = document.getElementById("q").value;

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);
                    document.getElementById("parameter_analysis_table").innerHTML = resp.filter_result;
                    eventsFilterCallback();
                } else if (this.readyState == 4 && this.status != 200) {
                    toastr.error("{!! __('Um erro ocorreu ao gerar a consulta') !!}");
                    eventsFilterCallback();
                }
            }

            var data = new FormData();
            data.append('_token', token);
            data.append('_method', method);
            if (q) data.append('q', q);
            data.append('ascending', 'asc');
            data.append('order_by', 'point_identifications.identification');
            data.append('campaign_id', "{{ $campaign->id }}");
            data.append('id', "{{ $analysisOrder->id }}");

            ajax.send(data);
        }

        function eventsFilterCallback() {
            document.querySelectorAll('button.filter-field').forEach(item => {
                //item.addEventListener('change', filterCallback, false);
                item.addEventListener('click', filterCallback, false);
            });
            document.querySelectorAll("#parameter_analysis_table thead [data-name]").forEach(item => {
                item.addEventListener("click", orderByCallback, false);
            });
        }

        eventsFilterCallback();
    </script>
</x-app-layout>
