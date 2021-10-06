<x-app-layout>
    <div class="py-6 index-project">
        <div class="max-w-6xl mx-auto px-4">

            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Amostras') }}</h1>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                <div class="filter-container">
                    <div class="flex -mx-3 mb-6 p-3 md:flex-row flex-col w-full">
                        <div class="w-full md:w-1/4 px-2 mb-6 md:mb-0">
                            <x-jet-label for="project_cod" value="{{ __('Projeto') }}" />
                            <x-jet-input id="project_cod" class="form-control block w-full filter-field" type="text" name="project_cod" :value="app('request')->input('project_cod')" autofocus autocomplete="project_cod" />
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-6 md:mb-0">
                            <x-jet-label for="campaign" value="{{ __('Campanha') }}" />
                            <x-jet-input id="campaign" class="form-control block w-full filter-field" type="text" name="campaign" :value="app('request')->input('campaign')" autofocus autocomplete="campaign" />
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-6 md:mb-0">
                            <x-jet-label for="lab" value="{{ __('Laboratório') }}" />
                            <x-custom-select :options="$labs" name="lab" id="lab" :value="app('request')->input('lab')" placeholder="Selecione um Laboratório"/>
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-6 md:mb-0">
                            <x-jet-label for="status" value="{{ __('Status') }}" />
                            <x-custom-select :options="$status" name="status" id="status" :value="app('request')->input('status')"/>
                        </div>
                    </div>
                </div>
                <div class="flex mt-4">
                    <table id="sample_analysis_table" class="table table-responsive md:table w-full">
                        @include('sample-analysis.filter-result', ['projetcs' => $projetcs , 'ascending' => $ascending, 'orderBy' => $orderBy])
                    </table>
                </div>
                <div class="flex mt-4 p-2" id="pagination">
                        {{ $projetcs->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener("load", function() {
            var filterCallback = function (event) {
                var ajax = new XMLHttpRequest();
                var url = "{!! route('sample-analysis.filter') !!}";
                var token = document.querySelector('meta[name="csrf-token"]').content;
                var method = 'POST';
                var paginationPerPage = document.getElementById("paginate_per_page_campaigns").value;
                var status = document.getElementById("status").value;
                var projectCod = document.getElementById("project_cod").value;
                var campaign = document.getElementById("campaign").value;
                var lab = document.getElementById("lab").value;

                ajax.open(method, url);

                ajax.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var resp = JSON.parse(ajax.response);
                        document.getElementById("sample_analysis_table").innerHTML = resp.filter_result;
                        document.getElementById("pagination").innerHTML = resp.pagination;
                        eventsFilterCallback();
                    } else if(this.readyState == 4 && this.status != 200) {
                        toastr.error("{!! __('Um erro ocorreu ao gerar a consulta') !!}");
                        eventsFilterCallback();
                    }
                }

                var data = new FormData();
                data.append('_token', token);
                data.append('_method', method);
                data.append('paginate_per_page', paginationPerPage);
                if(status) data.append('status', status);
                if(projectCod) data.append('project_cod', projectCod);
                if(campaign) data.append('name', campaign);
                if(lab) data.append('lab_id', lab);

                ajax.send(data);
            }

            var ascending = "{!! $ascending !!}";
            var orderBY = "{!! $orderBy !!}";

            var orderByCallback = function (event) {
                orderBY = this.dataset.name;
                ascending = this.dataset.ascending;
                var that = this;
                var ajax = new XMLHttpRequest();
                var url = "{!! route('sample-analysis.filter') !!}";
                var token = document.querySelector('meta[name="csrf-token"]').content;
                var method = 'POST';
                var paginationPerPage = document.getElementById("paginate_per_page_campaigns").value;
                var status = document.getElementById("status").value;
                var projectCod = document.getElementById("project_cod").value;
                var campaign = document.getElementById("campaign").value;
                var lab = document.getElementById("lab").value;

                ajax.open(method, url);

                ajax.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var resp = JSON.parse(ajax.response);
                        document.getElementById("sample_analysis_table").innerHTML = resp.filter_result;
                        document.getElementById("pagination").innerHTML = resp.pagination;
                        that.dataset.ascending = that.dataset.ascending == 'asc' ? that.dataset.ascending = 'desc' : that.dataset.ascending = 'asc';
                        eventsFilterCallback();
                    } else if(this.readyState == 4 && this.status != 200) {
                        toastr.error("{!! __('Um erro ocorreu ao gerar a consulta') !!}");
                        eventsFilterCallback();
                    }
                }

                var data = new FormData();
                data.append('_token', token);
                data.append('_method', method);
                data.append('paginate_per_page', paginationPerPage);
                data.append('ascending', ascending);
                data.append('order_by', orderBY);
                if(status) data.append('status', status);
                if(projectCod) data.append('project_cod', projectCod);
                if(campaign) data.append('name', campaign);
                if(lab) data.append('lab_id', lab);

                ajax.send(data);
            }

            function eventsFilterCallback() {
                document.querySelectorAll('.filter-field').forEach(item => {
                    item.addEventListener('change', filterCallback, false);
                    item.addEventListener('keyup', filterCallback, false);
                });
                document.querySelectorAll("#sample_analysis_table thead [data-name]").forEach(item => {
                    item.addEventListener("click", orderByCallback, false);
                });
            }

            eventsFilterCallback();
        });
    </script>

</x-app-layout>
