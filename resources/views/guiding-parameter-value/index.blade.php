<x-app-layout>
    <div class="py-6 index-guiding-parameter-value">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">

            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Listar Valor Param. Orientador') }}</h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2 ">
                        <a class="btn-outline-info" href="{{ route('guiding-parameter-value.create') }}" >{{ __('Cadastrar') }}</a>
                    </div>
                    <div class="m-2">
                        <button type="button" class="btn-outline-danger delete-guiding-parameter-value" data-type="multiple">{{ __('Apagar') }}</a>
                    </div>
                    <div class="m-2 ">
                        <form method="POST" action="{!! route('import.importGuidingParameterValue') !!}" enctype="multipart/form-data" id="import_result_form">
                             @csrf
                             @method("POST")
                             <button type="button" class="btn-outline-info" id="import_result">{{ __('Importar Análises') }}</button>
                             <input type="file" name="file" id="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet|application/vnd.ms-excel" class="hidden">
                        </form>
                     </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                <div class="filter-container">
                    <div class="flex -mx-3 mb-6 p-3 md:flex-row flex-col w-full">
                        <div class="w-full md:w-1/3 px-2 mb-6 md:mb-0">
                            <x-jet-label for="guiding_parameter_id" value="{{ __('Param. Orientador Ambiental') }}" />
                            <x-custom-select :options="$guidingParameters" name="guiding_parameter_id" id="guiding_parameter_id" :value="app('request')->input('guiding_parameter_id')"/>
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-6 md:mb-0">
                            <x-jet-label for="analysis_matrix_id" value="{{ __('Matriz') }}" />
                            <x-custom-select :options="$analysisMatrices" name="analysis_matrix_id" id="analysis_matrix_id" :value="app('request')->input('analysis_matrix_id')"/>
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-6 md:mb-0">
                            <x-jet-label for="parameter_analysis_id" value="{{ __('Param. Análise') }}" />
                            <x-custom-select :options="$parameterAnalysises" name="parameter_analysis_id" id="parameter_analysis_id" :value="app('request')->input('parameter_analysis_id')"/>
                        </div>
                    </div>
                </div>
                <div class="flex mt-4">
                    <table id="guiding_parameter_value_table" class="table table-responsive md:table w-full">
                        @include('guiding-parameter-value.filter-result', ['guidingParameterValues' => $guidingParameterValues, 'ascending' => $ascending, 'orderBy' => $orderBy])
                    </table>
                </div>
                <div class="flex mt-4 p-2" id="pagination">
                        {{ $guidingParameterValues->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>

    <x-spin-load />



    <x-modal title="{{ __('Excluir Ponto') }}"
             msg="{{ __('Deseja realmente apagar esse Ponto?') }}"
             confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_guiding_parameter_value_modal"
             method="DELETE"
             redirect-url="{{ route('guiding-parameter-value.index') }}"/>

    <div id="import_result_container_modal">

    </div>

    <script>
        window.addEventListener("load", function() {
            var filterCallback = function (event) {
                var ajax = new XMLHttpRequest();
                var url = "{!! route('guiding-parameter-value.filter') !!}";
                var token = document.querySelector('meta[name="csrf-token"]').content;
                var method = 'POST';
                var paginationPerPage = document.getElementById("paginate_per_page").value;
                var guiding_parameter_id = document.getElementById("guiding_parameter_id").value;
                var analysis_matrix_id = document.getElementById("analysis_matrix_id").value;
                var parameter_analysis_id = document.getElementById("parameter_analysis_id").value;

                ajax.open(method, url);

                ajax.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var resp = JSON.parse(ajax.response);
                        document.getElementById("guiding_parameter_value_table").innerHTML = resp.filter_result;
                        document.getElementById("pagination").innerHTML = resp.pagination;
                        eventsFilterCallback();
                        eventsDeleteCallback();
                    } else if(this.readyState == 4 && this.status != 200) {
                        toastr.error("{!! __('Um erro ocorreu ao gerar a consulta') !!}");
                        eventsFilterCallback();
                        eventsDeleteCallback();
                    }
                }

                var data = new FormData();
                data.append('_token', token);
                data.append('_method', method);
                data.append('paginate_per_page', paginationPerPage);
                data.append('ascending', ascending);
                data.append('order_by', orderBY);
                if(guiding_parameter_id) data.append('guiding_parameter_id', guiding_parameter_id);
                if(analysis_matrix_id) data.append('analysis_matrix_id', analysis_matrix_id);
                if(parameter_analysis_id) data.append('parameter_analysis_id', parameter_analysis_id);

                ajax.send(data);
            }

            var ascending = "{!! $ascending !!}";
            var orderBY = "{!! $orderBy !!}";

            var orderByCallback = function (event) {
                orderBY = this.dataset.name;
                ascending = this.dataset.ascending;
                var that = this;
                var ajax = new XMLHttpRequest();
                var url = "{!! route('guiding-parameter-value.filter') !!}";
                var token = document.querySelector('meta[name="csrf-token"]').content;
                var method = 'POST';
                var paginationPerPage = document.getElementById("paginate_per_page").value;
                var guiding_parameter_id = document.getElementById("guiding_parameter_id").value;
                var analysis_matrix_id = document.getElementById("analysis_matrix_id").value;
                var parameter_analysis_id = document.getElementById("parameter_analysis_id").value;

                ajax.open(method, url);

                ajax.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var resp = JSON.parse(ajax.response);
                        document.getElementById("guiding_parameter_value_table").innerHTML = resp.filter_result;
                        document.getElementById("pagination").innerHTML = resp.pagination;
                        that.dataset.ascending = that.dataset.ascending == 'asc' ? that.dataset.ascending = 'desc' : that.dataset.ascending = 'asc';
                        eventsFilterCallback();
                        eventsDeleteCallback();
                    } else if(this.readyState == 4 && this.status != 200) {
                        toastr.error("{!! __('Um erro ocorreu ao gerar a consulta') !!}");
                        eventsFilterCallback();
                        eventsDeleteCallback();
                    }
                }

                var data = new FormData();
                data.append('_token', token);
                data.append('_method', method);
                data.append('paginate_per_page', paginationPerPage);
                data.append('ascending', ascending);
                data.append('order_by', orderBY);
                if(guiding_parameter_id) data.append('guiding_parameter_id', guiding_parameter_id);
                if(analysis_matrix_id) data.append('analysis_matrix_id', analysis_matrix_id);
                if(parameter_analysis_id) data.append('parameter_analysis_id', parameter_analysis_id);

                ajax.send(data);
            }

            function eventsFilterCallback() {
                document.querySelectorAll('.filter-field').forEach(item => {
                    item.addEventListener('change', filterCallback, false);
                    item.addEventListener('keyup', filterCallback, false);
                });
                document.querySelectorAll("#guiding_parameter_value_table thead [data-name]").forEach(item => {
                    item.addEventListener("click", orderByCallback, false);
                });
            }


            function eventsDeleteCallback() {
                document.querySelectorAll('.delete-guiding-parameter-value').forEach(item => {
                    item.addEventListener("click", function() {
                        if(this.dataset.type != 'multiple') {
                            var url = this.dataset.url;
                            var modal = document.getElementById("delete_guiding_parameter_value_modal");
                            modal.dataset.url = url;
                            modal.classList.remove("hidden");
                            modal.classList.add("block");
                        }
                        else {
                            var urls = '';
                            document.querySelectorAll('input:checked.guiding-parameter-value-url').forEach((item, index, arr) => {
                                urls += item.value ;
                                if(index < (arr.length - 1)) {
                                    urls += ',';
                                }
                            });

                            if(urls.length > 0) {
                                var modal = document.getElementById("delete_guiding_parameter_value_modal");
                                modal.dataset.url = urls;
                                modal.classList.remove("hidden");
                                modal.classList.add("block");
                            }
                        }
                    });
                });
            }

            eventsDeleteCallback();
            eventsFilterCallback();
        });
    </script>

    <script>
        document.getElementById("file").addEventListener("change", function(e) {
            document.getElementById("spin_load").classList.remove("hidden");

            let ajax = new XMLHttpRequest();
            let url = "{!! route('import.viewImportGuidingParameterValue') !!}";
            let token = document.querySelector('meta[name="csrf-token"]').content;
            let method = 'POST';
            let that = document.querySelector('#file');
            let files = that.files;

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);
                    document.getElementById("spin_load").classList.add("hidden");
                    document.getElementById("import_result_container_modal").innerHTML = resp.result;
                    document.getElementById("import_result_confirm_modal").addEventListener("click", function() {
                        document.querySelector("#import_result_container_modal div").remove();
                    })
                    that.value='';
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

            ajax.send(data);

        });

        document.getElementById("import_result").addEventListener("click", function() {
            document.getElementById("file").click();
        });
    </script>

</x-app-layout>
