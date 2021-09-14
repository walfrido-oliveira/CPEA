<x-app-layout>
    <div class="py-6 index-project">
        <div class="max-w-6xl mx-auto px-4">

            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Listar Projetos') }}</h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2 ">
                        <a class="btn-outline-info" href="{{ route('project.create') }}" >{{ __('Cadastrar') }}</a>
                    </div>
                    <div class="m-2">
                        <button type="button" class="btn-outline-danger delete-project" data-type="multiple">{{ __('Apagar') }}</a>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                <div class="filter-container">
                    <div class="flex -mx-3 mb-6 p-3 md:flex-row flex-col w-full">
                        <div class="w-full md:w-1/2 px-2 mb-6 md:mb-0">
                            <x-jet-label for="project_cod" value="{{ __('Projeto') }}" />
                            <x-jet-input id="project_cod" class="form-control block w-full filter-field" type="text" name="project_cod" :value="app('request')->input('project_cod')" autofocus autocomplete="project_cod" />
                        </div>
                        <div class="w-full md:w-1/2 px-2 mb-6 md:mb-0">
                            <x-jet-label for="customer_id" value="{{ __('Cliente') }}" />
                            <x-custom-select :options="$customers" name="customer_id" id="customer_id" :value="app('request')->input('customer_id')"/>
                        </div>
                    </div>
                </div>
                <div class="flex mt-4">
                    <table id="project_table" class="table table-responsive md:table w-full">
                        @include('project.filter-result', ['projetcs' => $projetcs , 'ascending' => $ascending, 'orderBy' => $orderBy])
                    </table>
                </div>
                <div class="flex mt-4 p-2" id="pagination">
                        {{ $projetcs ->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>

    <x-modal title="{{ __('Excluir Projeto') }}"
             msg="{{ __('Deseja realmente apagar esse Projeto?') }}"
             confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_project_modal"
             method="DELETE"
             redirect-url="{{ route('project.index') }}"/>

    <script>
        window.addEventListener("load", function() {
            var filterCallback = function (event) {
                var ajax = new XMLHttpRequest();
                var url = "{!! route('project.filter') !!}";
                var token = document.querySelector('meta[name="csrf-token"]').content;
                var method = 'POST';
                var paginationPerPage = document.getElementById("paginate_per_page").value;
                var customerId = document.getElementById("customer_id").value;
                var projectCod = document.getElementById("project_cod").value;

                ajax.open(method, url);

                ajax.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var resp = JSON.parse(ajax.response);
                        document.getElementById("project_table").innerHTML = resp.filter_result;
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
                if(customerId) data.append('customer_id', customerId);
                if(projectCod) data.append('project_cod', projectCod);

                ajax.send(data);
            }

            var ascending = "{!! $ascending !!}";
            var orderBY = "{!! $orderBy !!}";

            var orderByCallback = function (event) {
                orderBY = this.dataset.name;
                ascending = this.dataset.ascending;
                var that = this;
                var ajax = new XMLHttpRequest();
                var url = "{!! route('project.filter') !!}";
                var token = document.querySelector('meta[name="csrf-token"]').content;
                var method = 'POST';
                var paginationPerPage = document.getElementById("paginate_per_page").value;
                var customerId = document.getElementById("customer_id").value;
                var projectCod = document.getElementById("project_cod").value;

                ajax.open(method, url);

                ajax.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var resp = JSON.parse(ajax.response);
                        document.getElementById("project_table").innerHTML = resp.filter_result;
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
                if(customerId) data.append('customer_id', customerId);
                if(projectCod) data.append('project_cod', projectCod);

                ajax.send(data);
            }

            function eventsFilterCallback() {
                document.querySelectorAll('.filter-field').forEach(item => {
                    item.addEventListener('change', filterCallback, false);
                    item.addEventListener('keyup', filterCallback, false);
                });
                document.querySelectorAll("#project_table thead [data-name]").forEach(item => {
                    item.addEventListener("click", orderByCallback, false);
                });
            }


            function eventsDeleteCallback() {
                document.querySelectorAll('.delete-project').forEach(item => {
                    item.addEventListener("click", function() {
                        if(this.dataset.type != 'multiple') {
                            var url = this.dataset.url;
                            var modal = document.getElementById("delete_project_modal");
                            modal.dataset.url = url;
                            modal.classList.remove("hidden");
                            modal.classList.add("block");
                        }
                        else {
                            var urls = '';
                            document.querySelectorAll('input:checked.project-url').forEach((item, index, arr) => {
                                urls += item.value ;
                                if(index < (arr.length - 1)) {
                                    urls += ',';
                                }
                            });

                            if(urls.length > 0) {
                                var modal = document.getElementById("delete_project_modal");
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
