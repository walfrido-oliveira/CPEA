<x-app-layout>
    <div class="py-6 index-point-identification">
        <div class="max-w-6xl mx-auto px-4">

            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Listar Pontos') }}</h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2 ">
                        <a class="btn-outline-info" href="{{ route('registers.point-identification.create') }}" >{{ __('Cadastrar') }}</a>
                    </div>
                    <div class="m-2">
                        <button type="button" class="btn-outline-danger delete-point-identification" data-type="multiple">{{ __('Apagar') }}</a>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                <div class="filter-container">
                    <div class="flex -mx-3 mb-6 p-3 md:flex-row flex-col w-full">
                        <div class="w-full md:w-1/2 px-2 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="area">
                                {{ __('Área') }}
                            </label>
                            <x-jet-input id="area" class="form-control block w-full filter-field" type="text" name="area" :value="app('request')->input('area')" autofocus autocomplete="area" />
                        </div>
                        <div class="w-full md:w-1/2 px-2 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="identification">
                                {{ __('identificação do Ponto') }}
                            </label>
                            <x-jet-input id="identification" class="form-control block w-full filter-field" type="text" name="identification" :value="app('request')->input('identification')" autofocus autocomplete="identification" />
                        </div>
                    </div>
                </div>
                <div class="flex mt-4">
                    <table class="table table-responsive md:table w-full">
                        <thead>
                            <tr class="thead-light">
                                <th width="5%"></th>
                                <th width="5%" data-name="id" data-ascending="id">{{ __('ID') }}</th>
                                <th width="30%" data-name="area" data-ascending="area">{{ __('Área') }}</th>
                                <th width="30%" data-name="identification" data-ascending="identification">{{ __('Identificação do Ponto') }}</th>
                                <th>{{ __('Ações') }}</th>
                            </tr>
                        </thead>
                        <tbody id="point_identification_table_content">
                            @include('point-identification.filter-result', ['pointIdentifications' => $pointIdentifications])
                        </tbody>
                    </table>
                </div>
                <div class="flex mt-4 p-2" id="pagination">
                        {{ $pointIdentifications->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>

    <x-modal title="{{ __('Excluir Ponto') }}"
             msg="{{ __('Deseja realmente apagar esse Ponto?') }}"
             confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_point_identification_modal"
             method="DELETE"
             redirect-url="{{ route('registers.point-identification.index') }}"/>

    <script>
        window.addEventListener("load", function() {
            var filterCallback = function (event) {
                var ajax = new XMLHttpRequest();
                var url = "{!! route('registers.point-identification.filter') !!}";
                var token = document.querySelector('meta[name="csrf-token"]').content;
                var method = 'POST';
                var paginationPerPage = document.getElementById("paginate_per_page").value;
                var area = document.getElementById("area").value;
                var identification = document.getElementById("identification").value;

                ajax.open(method, url);

                ajax.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var resp = JSON.parse(ajax.response);
                        document.getElementById("point_identification_table_content").innerHTML = resp.filter_result;
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
                if(area) data.append('area', area);
                if(identification) data.append('identification', identification);

                ajax.send(data);
            }

            function eventsFilterCallback() {
                document.querySelectorAll('.filter-field').forEach(item => {
                    item.addEventListener('change', filterCallback, false);
                    item.addEventListener('keyup', filterCallback, false);
                });
            }

            function eventsDeleteCallback() {
                document.querySelectorAll('.delete-point-identification').forEach(item => {
                item.addEventListener("click", function() {
                    if(this.dataset.type != 'multiple') {
                        var url = this.dataset.url;
                        var modal = document.getElementById("delete_point_identification_modal");
                        modal.dataset.url = url;
                        modal.classList.remove("hidden");
                        modal.classList.add("block");
                    }
                    else {
                        var urls = '';
                        document.querySelectorAll('input:checked.point-identification-url').forEach((item, index, arr) => {
                            urls += item.value ;
                            if(index < (arr.length - 1)) {
                                urls += ',';
                            }
                        });

                        if(urls.length > 0) {
                            var modal = document.getElementById("delete_point_identification_modal");
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
