<x-app-layout>
    <div class="py-6 index-calculation-parameter">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">

            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Lista de Param. Fórmula Cálculo') }}</h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2 ">
                        <a class="btn-outline-info" href="{{ route('registers.calculation-parameter.create') }}" >{{ __('Cadastrar') }}</a>
                    </div>
                    <div class="m-2">
                        <button type="button" class="btn-outline-danger delete-calculation-parameter" data-type="multiple">{{ __('Apagar') }}</a>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                <div class="filter-container">
                    <div class="flex -mx-3 mb-6 p-3 md:flex-row flex-col w-full">
                        <div class="w-full px-2 mb-6 md:mb-0">
                            <x-jet-label for="parameter_analysis_id" value="{{ __('Param. Analise') }}" />
                            <x-custom-select :options="$parameterAnalysis" name="parameter_analysis_id" id="parameter_analysis_id" :value="app('request')->input('parameter_analysis_id')"/>
                        </div>
                    </div>
                </div>
                <div class="flex mt-4">
                    <table id="calculation_parameter_table" class="table table-responsive md:table w-full">
                        @include('calculation-parameter.filter-result', ['calculationParameters' => $calculationParameters, 'ascending' => $ascending, 'orderBy' => $orderBy])
                    </table>
                </div>
                <div class="flex mt-4 p-2" id="pagination">
                        {{ $calculationParameters->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>

    <x-modal title="{{ __('Excluir Param. Fórmula Cálculo') }}"
             msg="{{ __('Deseja realmente apagar essa Param. Fórmula Cálculo?') }}"
             confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_calculation_parameter_modal"
             method="DELETE"
             redirect-url="{{ route('registers.calculation-parameter.index') }}"/>

    <script>
        window.addEventListener("load", function() {
            var filterCallback = function (event) {
                var ajax = new XMLHttpRequest();
                var url = "{!! route('registers.calculation-parameter.filter') !!}";
                var token = document.querySelector('meta[name="csrf-token"]').content;
                var method = 'POST';
                var paginationPerPage = document.getElementById("paginate_per_page").value;
                var parameter_analysis_id = document.getElementById("parameter_analysis_id").value;

                ajax.open(method, url);

                ajax.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var resp = JSON.parse(ajax.response);
                        document.getElementById("calculation_parameter_table").innerHTML = resp.filter_result;
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
                var url = "{!! route('registers.calculation-parameter.filter') !!}";
                var token = document.querySelector('meta[name="csrf-token"]').content;
                var method = 'POST';
                var paginationPerPage = document.getElementById("paginate_per_page").value;
                var parameter_analysis_id = document.getElementById("parameter_analysis_id").value;

                ajax.open(method, url);

                ajax.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var resp = JSON.parse(ajax.response);
                        document.getElementById("calculation_parameter_table").innerHTML = resp.filter_result;
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
                if(parameter_analysis_id) data.append('parameter_analysis_id', parameter_analysis_id);

                ajax.send(data);
            }

            function eventsFilterCallback() {
                document.querySelectorAll('.filter-field').forEach(item => {
                    item.addEventListener('change', filterCallback, false);
                    item.addEventListener('keyup', filterCallback, false);
                });
                document.querySelectorAll("#calculation_parameter_table thead [data-name]").forEach(item => {
                    item.addEventListener("click", orderByCallback, false);
                });
            }

            function eventsDeleteCallback() {
                document.querySelectorAll('.delete-calculation-parameter').forEach(item => {
                    item.addEventListener("click", function() {
                        if(this.dataset.type != 'multiple') {
                            var url = this.dataset.url;
                            var modal = document.getElementById("delete_calculation_parameter_modal");
                            modal.dataset.url = url;
                            modal.classList.remove("hidden");
                            modal.classList.add("block");
                        }
                        else {
                            var urls = '';
                            document.querySelectorAll('input:checked.calculation-parameter-url').forEach((item, index, arr) => {
                                urls += item.value ;
                                if(index < (arr.length - 1)) {
                                    urls += ',';
                                }
                            });

                            if(urls.length > 0) {
                                var modal = document.getElementById("delete_calculation_parameter_modal");
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

</x-app-layout>
