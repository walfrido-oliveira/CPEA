<x-app-layout>
    <div class="py-6 index-field">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">

            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Registros de Campos') }}</h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2 ">
                        <a class="btn-outline-info" href="#" id="btn_projetc_add">{{ __('Criar Projeto') }}</a>
                    </div>
                </div>
            </div>

            <div class="px-2 my-2 bg-white rounded-lg min-h-screen">
                <div class="flex md:flex-row flex-col w-full">
                    <div class="mx-4 px-3 py-2 w-full flex justify-end" x-data="{ open: false }">
                        <div class="pr-4 flex">
                            <button @click="open = !open" id="nav-toggle" class="w-full block btn-transition-secondary">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                              </svg>
                            </button>
                        </div>
                        <!--Search-->
                        <div :class="{'block': open, 'hidden': !open}" class="w-full block" id="search-content">
                            <div class="container mx-auto">
                                <input id="q" name="q" type="search" placeholder="Buscar..." autofocus="autofocus" class="filter-field w-full form-control no-border">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex mt-4">
                    <table id="field_table" class="table table-responsive md:table w-full">
                        @include('field.filter-result', ['fields' => $fields, 'ascending' => $ascending, 'orderBy' => $orderBy])
                    </table>
                </div>
                <div class="flex mt-4 p-2" id="pagination">
                    {{ $fields->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>

    @include('field.create-modal')
    <x-spin-load />

    <x-modal title="{{ __('Excluir Registros de Campos') }}"
             msg="{{ __('Deseja realmente apagar esse Registros de Campos?') }}"
             confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_field_modal"
             method="DELETE"
             redirect-url="{{ route('fields.index', ['type' => $id]) }}"/>

    <script>
    document.getElementById("btn_projetc_add").addEventListener("click", function() {
        var modal = document.getElementById("field_modal");
        modal.classList.remove("hidden");
        modal.classList.add("block");
    });

    document.getElementById("field_cancel_modal").addEventListener("click", function(e) {
        var modal = document.getElementById("field_modal");
        modal.classList.add("hidden");
    });

    document.getElementById("field_confirm_modal").addEventListener("click", function(e) {
        document.getElementById("spin_load").classList.remove("hidden");

        let ajax = new XMLHttpRequest();
        let url = "{!! route('fields.store') !!}";
        let token = document.querySelector('meta[name="csrf-token"]').content;
        let method = 'POST';
        let project_id = document.querySelector("#field_modal #project_id").value;
        let obs = document.querySelector("#obs").value;

        ajax.open(method, url);

        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var resp = JSON.parse(ajax.response);
                document.getElementById("spin_load").classList.add("hidden");
                toastr.success(resp.message);

                location.reload();
            } else if(this.readyState == 4 && this.status != 200) {
                document.getElementById("spin_load").classList.add("hidden");
                toastr.error("{!! __('Um erro ocorreu ao solicitar a consulta') !!}");
            }
        }

        var data = new FormData();
        data.append('_token', token);
        data.append('_method', method);
        data.append('project_id', project_id);
        data.append('obs', obs);
        data.append('field_type_id', {{ $id }});

        ajax.send(data);

    });

</script>

    <script>
        window.addEventListener("load", function() {
            var filterCallback = function (event) {
                var ajax = new XMLHttpRequest();
                var url = "{!! route('fields.filter') !!}";
                var token = document.querySelector('meta[name="csrf-token"]').content;
                var method = 'POST';
                var paginationPerPage = document.getElementById("paginate_per_page").value;
                var q = document.getElementById("q").value;

                ajax.open(method, url);

                ajax.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var resp = JSON.parse(ajax.response);
                        document.getElementById("field_table").innerHTML = resp.filter_result;
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
                if(q) data.append('q', q);

                ajax.send(data);
            }

            var ascending = "{!! $ascending !!}";
            var orderBY = "{!! $orderBy !!}";

            var orderByCallback = function (event) {
                orderBY = this.dataset.name;
                ascending = this.dataset.ascending;
                var that = this;
                var ajax = new XMLHttpRequest();
                var url = "{!! route('fields.filter') !!}";
                var token = document.querySelector('meta[name="csrf-token"]').content;
                var method = 'POST';
                var paginationPerPage = document.getElementById("paginate_per_page").value;

                var q = document.getElementById("q").value;

                ajax.open(method, url);

                ajax.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var resp = JSON.parse(ajax.response);
                        document.getElementById("field_table").innerHTML = resp.filter_result;
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
                if(q) data.append('q', q);


                ajax.send(data);
            }

            function eventsFilterCallback() {
                document.querySelectorAll('#q').forEach(item => {
                    item.addEventListener('change', filterCallback, false);
                    item.addEventListener('keyup', filterCallback, false);
                });
                document.querySelectorAll("#field_table thead [data-name]").forEach(item => {
                    item.addEventListener("click", orderByCallback, false);
                });
            }

            function eventsDeleteCallback() {
                document.querySelectorAll('.delete-field').forEach(item => {
                item.addEventListener("click", function() {
                    if(this.dataset.type != 'multiple') {
                        var url = this.dataset.url;
                        var modal = document.getElementById("delete_field_modal");
                        modal.dataset.url = url;
                        modal.classList.remove("hidden");
                        modal.classList.add("block");
                    }
                    else {
                        var urls = '';
                        document.querySelectorAll('input:checked.field-url').forEach((item, index, arr) => {
                            urls += item.value ;
                            if(index < (arr.length - 1)) {
                                urls += ',';
                            }
                        });

                        if(urls.length > 0) {
                            var modal = document.getElementById("delete_field_modal");
                            modal.dataset.url = urls;
                            modal.classList.remove("hidden");
                            modal.classList.add("block");
                        }
                    }
                })
            });
            }

            eventsDeleteCallback();
            eventsFilterCallback();
        });
    </script>

</x-app-layout>
