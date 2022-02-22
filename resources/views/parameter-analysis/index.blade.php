<x-app-layout>
    <div class="py-6 index-parameter-analysis">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">

            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Lista de Param. Análise') }}</h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2 ">
                        <a class="btn-outline-info" href="{{ route('parameter-analysis.create') }}" >{{ __('Cadastrar') }}</a>
                    </div>
                    <div class="m-2">
                        <button type="button" class="btn-outline-danger delete-parameter-analysis" data-type="multiple">{{ __('Apagar') }}</a>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                <div class="filter-container" id="filter_container">
                    <div class="flex -mx-3 mb-6 p-3 md:flex-row flex-col w-full">
                        <div class="w-full md:w-1/3 px-2 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="analysis_parameter_id">
                                {{ __('Tipo Param. Análise') }}
                            </label>
                            <x-custom-select :options="$analysisParameter" placeholder="" name="analysis_parameter_id" id="analysis_parameter_id" :value="app('request')->input('analysis_parameter_id')"/>
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="analysis_parameter_name">
                                {{ __('Nome Param. Análise') }}
                            </label>
                            <x-jet-input id="analysis_parameter_name" class="form-control block w-full filter-field" type="text" name="analysis_parameter_name" :value="app('request')->input('analysis_parameter_name')" autofocus autocomplete="analysis_parameter_name" />
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="cas_rn">
                                {{ __('CAS RN') }}
                            </label>
                            <x-jet-input id="cas_rn" class="form-control block w-full filter-field" type="text" name="cas_rn" :value="app('request')->input('cas_rn')" autofocus autocomplete="cas_rn" />
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="parameter_analysis_group_id">
                                {{ __('Grupo Param. Análise') }}
                            </label>
                            <x-custom-select :options="$parameterAnalysisGroup" name="parameter_analysis_group_id" id="parameter_analysis_group_id" :value="app('request')->input('parameter_analysis_group_id')"/>
                        </div>
                    </div>
                </div>
                <div class="flex mt-4">
                    <table id="parameter_analysis_table" class="table table-responsive md:table w-full">
                        @include('parameter-analysis.filter-result', ['parameterAnalyses' => $parameterAnalyses, 'ascending' => $ascending, 'orderBy' => $orderBy])
                    </table>
                </div>
                <div class="flex mt-4 p-2" id="pagination">
                        {{ $parameterAnalyses->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>

    <x-modal title="{{ __('Excluir Param. Análise') }}"
             msg="{{ __('Deseja realmente apagar esse Param. Análise?') }}"
             confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_parameter_analysis_modal"
             method="DELETE"
             redirect-url="{{ route('parameter-analysis.index') }}"
             form-id="filter_container"/>

    <script>
        window.addEventListener("load", function() {
            var filterCallback = function (event) {
                var ajax = new XMLHttpRequest();
                var url = "{!! route('parameter-analysis.filter') !!}";
                var token = document.querySelector('meta[name="csrf-token"]').content;
                var method = 'POST';
                var paginationPerPage = document.getElementById("paginate_per_page").value;

                var analysis_parameter_id = document.getElementById("analysis_parameter_id").value;
                var parameter_analysis_group_id = document.getElementById("parameter_analysis_group_id").value;
                var analysis_parameter_name = document.getElementById("analysis_parameter_name").value;
                var cas_rn = document.getElementById("cas_rn").value;

                ajax.open(method, url);

                ajax.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var resp = JSON.parse(ajax.response);
                        document.getElementById("parameter_analysis_table").innerHTML = resp.filter_result;
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
                if(analysis_parameter_id) data.append('analysis_parameter_id', analysis_parameter_id);
                if(parameter_analysis_group_id) data.append('parameter_analysis_group_id', parameter_analysis_group_id);
                if(analysis_parameter_name) data.append('analysis_parameter_name', analysis_parameter_name);
                if(cas_rn) data.append('cas_rn', cas_rn);
                data.append('ascending', ascending);
                data.append('order_by', orderBY);

                ajax.send(data);
            }

            var ascending = "{!! $ascending !!}";
            var orderBY = "{!! $orderBy !!}";

            var orderByCallback = function (event) {
                orderBY = this.dataset.name;
                ascending = this.dataset.ascending;
                var that = this;
                var ajax = new XMLHttpRequest();
                var url = "{!! route('parameter-analysis.filter') !!}";
                var token = document.querySelector('meta[name="csrf-token"]').content;
                var method = 'POST';
                var paginationPerPage = document.getElementById("paginate_per_page").value;

                var analysis_parameter_id = document.getElementById("analysis_parameter_id").value;
                var parameter_analysis_group_id = document.getElementById("parameter_analysis_group_id").value;
                var analysis_parameter_name = document.getElementById("analysis_parameter_name").value;
                var cas_rn = document.getElementById("cas_rn").value;

                ajax.open(method, url);

                ajax.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var resp = JSON.parse(ajax.response);
                        document.getElementById("parameter_analysis_table").innerHTML = resp.filter_result;
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
                if(analysis_parameter_id) data.append('analysis_parameter_id', analysis_parameter_id);
                if(parameter_analysis_group_id) data.append('parameter_analysis_group_id', parameter_analysis_group_id);
                if(analysis_parameter_name) data.append('analysis_parameter_name', analysis_parameter_name);
                if(cas_rn) data.append('cas_rn', cas_rn);

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

            function eventsDeleteCallback() {
                document.querySelectorAll('.delete-parameter-analysis').forEach(item => {
                    item.addEventListener("click", function() {
                        if(this.dataset.type != 'multiple') {
                            var url = this.dataset.url;
                            var modal = document.getElementById("delete_parameter_analysis_modal");
                            modal.dataset.url = url;
                            modal.classList.remove("hidden");
                            modal.classList.add("block");
                        }
                        else {
                            var urls = '';
                            document.querySelectorAll('input:checked.parameter-analysis-url').forEach((item, index, arr) => {
                                urls += item.value ;
                                if(index < (arr.length - 1)) {
                                    urls += ',';
                                }
                            });

                            if(urls.length > 0) {
                                var modal = document.getElementById("delete_parameter_analysis_modal");
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
