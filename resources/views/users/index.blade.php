<x-app-layout>
    <div class="py-6 users">
        <div class="max-w-6xl mx-auto px-4">

            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Lista de Usuários') }}</h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2 ">
                        <a class="btn-outline-info" href="{{ route('users.create') }}" >{{ __('Cadastrar') }}</a>
                    </div>
                </div>
            </div>

            <div class="px-4 py-2 my-6  bg-white rounded-lg">
                <div class="flex mt-4 filter-container">
                    <div class="flex -mx-3 mb-6 p-2 md:flex-row flex-col w-full">
                        <div class="w-full md:w-1/3 px-2 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="id">
                                {{ __('ID') }}
                            </label>
                            <x-jet-input id="id" class="form-control block w-full filter-field" type="text" name="id" :value="app('request')->input('id')" autofocus autocomplete="id" />
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
                                {{ __('Nome') }}
                            </label>
                            <x-jet-input id="name" class="form-control block w-full filter-field" type="text" name="name" :value="app('request')->input('name')" autofocus autocomplete="name" />
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="status">
                                {{ __('Nível de Acesso') }}
                            </label>
                            <x-custom-select :options="$roles" name="roles" id="roles" :value="app('request')->input('roles')"/>
                        </div>
                    </div>
                </div>
                <div class="flex mt-4">
                    <table class="table table-responsive md:table w-full">
                        <thead>
                            <tr class="thead-light">
                                <th data-name="id" data-ascending="desc">{{ __('ID') }}</th>
                                <th data-name="name" data-ascending="desc">{{ __('Nome') }}</th>
                                <th data-name="email" data-ascending="desc">{{ __('E-mail') }}</th>
                                <th data-name="roles" data-ascending="desc">{{ __('Nível de Acesso') }}</th>
                                <th>{{ __('Ações') }}</th>
                            </tr>
                        </thead>
                        <tbody id="users_table_content">
                            @include('users.filter-result', ['users' => $users])
                        </tbody>
                    </table>
                </div>
                <div class="flex mt-4" id="pagination">
                        {{ $users->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>

    <x-modal title="{{ __('Excluir usuário') }}"
             msg="{{ __('Deseja realmente apagar esse usuário?') }}"
            confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_user_modal"
            method="DELETE"/>

    <script>
        window.addEventListener("load", function() {
            var filterCallback = function (event) {
                var ajax = new XMLHttpRequest();
                var url = "{!! route('users.filter') !!}";
                var token = document.querySelector('meta[name="csrf-token"]').content;
                var method = 'POST';
                var paginationPerPage = document.getElementById("paginate_per_page").value;
                var id = document.getElementById("id").value;
                var name = document.getElementById("name").value;
                var roles = document.getElementById("roles").value;

                ajax.open(method, url);

                ajax.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var resp = JSON.parse(ajax.response);
                        document.getElementById("users_table_content").innerHTML = resp.filter_result;
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
                if(id) data.append('id', id);
                if(name) data.append('name', name);
                if(roles) data.append('roles', roles);

                ajax.send(data);
            }

            function eventsFilterCallback() {
                document.querySelectorAll('.filter-field').forEach(item => {
                    item.addEventListener('change', filterCallback, false);
                    item.addEventListener('keyup', filterCallback, false);
                });
            }

            function eventsDeleteCallback() {
                document.querySelectorAll('.delete-user').forEach(item => {
                item.addEventListener("click", function() {
                    var id = this.dataset.id;
                    var modal = document.getElementById("delete_user_modal");
                    modal.dataset.url = "{!! route('users.destroy', ['user' => '#']) !!}".replace("#", id);
                    modal.classList.remove("hidden");
                    modal.classList.add("block");
                })
            });
            }

            eventsDeleteCallback();
            eventsFilterCallback();
        });
    </script>

</x-app-layout>
