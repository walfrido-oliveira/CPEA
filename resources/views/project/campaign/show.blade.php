<x-app-layout>
    <div class="py-6 show-users">
        <div class="max-w-6xl mx-auto px-4">
            <form method="POST" action="{{ route('project.campaign.duplicate', ['campaign' => $campaign->id]) }}" id="duplicate_form">
                @csrf
                @method("POST")
                <input type="hidden" name="type" id="type" value="campaign">
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center md:justify-start justify-center">
                        <h1 id="title">{{ __('Campanha: ') }} <span class="font-normal">{{ $campaign->name }}</span></h1>
                    </div>
                    <div class="flex md:flex-row flex-col md:justify-end items-center">
                        <div class="m-2">
                            <button id="duplicate_campaign" type="button" class="btn-outline-info whitespace-nowrap">{{ __('Duplicar Campanha') }}</button>
                            <button id="confirm" type="submit" class="btn-outline-success" style="display: none;">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <button id="duplicate_point" type="button" class="btn-outline-success whitespace-nowrap">{{ __('Duplicar Pontos') }}</button>
                        </div>
                        <div class="m-2 hidden">
                            <button id="cancel" type="button" class="btn-outline-danger">{{ __('Cancelar') }}</button>
                        </div>
                        <div class="m-2">
                            <button type="button" id="delete_campaign'" class="btn-outline-danger delete-campaign" data-type="multiple">{{ __('Apagar') }}</button>
                        </div>
                    </div>
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex md:flex-row flex-col w-full">
                        <div class="md:mx-4 md:px-3 py-2 w-full flex justify-end" x-data="{ open: false }">
                            <div class="pr-4 flex">
                                <button type="button" @click="open = !open" id="nav-toggle" class="w-full block btn-transition-secondary">
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
                    <div class="filter-container md:block" id="duplicate_campaign_container" style="display: none;">
                        <div class="flex flex-wrap mx-4 px-3 py-2">
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <x-jet-label for="q" value="{{ __('Campanha') }}" />
                                <x-jet-input id="name" class="form-control block mt-1 w-full" type="text" name="name" maxlength="255" required autofocus autocomplete="name" :value="$campaign->name"/>
                            </div>
                        </div>
                    </div>
                    <div class="filter-container md:block" id="duplicate_point_container" style="display: none;">
                        <div class="flex flex-wrap mx-4 px-3 py-2">
                            <h2 class="w-full">{{ __('Referência') }}</h2>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="area_ref" value="{{ __('Área') }}" required />
                                <x-custom-select :options="$areas" name="area_ref" id="area_ref" value="" class="mt-1" no-filter="no-filter"/>
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="point_identifications_ref" value="{{ __('Identificação Ponto') }}" required/>
                                <x-custom-select :options="[]" name="point_identifications_ref" id="point_identifications_ref" value="" class="mt-1" no-filter="no-filter"/>
                            </div>
                        </div>

                        <div class="flex flex-wrap mx-4 px-3 py-2">
                            <h2 class="w-full">{{ __('Novos valores') }}</h2>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="areas" value="{{ __('Área') }}" />
                                <x-custom-select :options="$areas" name="areas" id="areas" value="" class="mt-1" no-filter="no-filter"/>
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="point_identifications" value="{{ __('Identificação Ponto') }}"/>
                                <x-custom-select :options="[]" name="point_identifications" id="point_identifications" value="" class="mt-1" no-filter="no-filter"/>
                            </div>
                        </div>
                    </div>
                    <div class="flex mt-4">
                        <table id="point_matrix_table" class="table table-responsive md:table w-full">
                            @include('project.campaign.point-matrix-result',
                            ['projectPointMatrices' => $projectPointMatrices, 'orderBy' => 'area', 'ascending' => 'asc'])
                        </table>
                    </div>
                    <div class="flex mt-4 p-2" id="point_matrix_pagination">
                            {{ $projectPointMatrices->appends(request()->input())->links() }}
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
<div class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="point_create_modal" data-url="">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
              <h3 class="text-lg leading-6 font-medium text-gray-900 sm:ml-4 " id="modal-title">
                {{ __("Atenção! Pontos iguais. Deseja continuar?") }}
              </h3>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button type="button" id="point_confirm_modal" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
            {{ __('Sim') }}
          </button>
          <button type="button" id="point_cancel_modal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
            {{ __('Não') }}
          </button>
        </div>
      </div>
    </div>
</div>

  <script>
    function show() {
        var modal = document.getElementById("point_create_modal");
        modal.classList.remove("hidden");
        modal.classList.add("block");
    }

    function close() {
        var modal = document.getElementById("point_create_modal");
        modal.classList.add("hidden");
        modal.classList.remove("block");
    }

    document.getElementById("point_cancel_modal").addEventListener("click", function(e) {
        var modal = document.getElementById("point_create_modal");
        modal.classList.add("hidden");
    });

    document.getElementById("point_confirm_modal").addEventListener("click", function() {
        document.getElementById("duplicate_form").submit();
    });

    document.getElementById("duplicate_form").addEventListener("submit", function(e){
        let pointIdentifications = document.getElementById("point_identifications").value
        let pointIdentificationsRef = document.getElementById("point_identifications_ref").value

        if(pointIdentifications == pointIdentificationsRef) {
            e.preventDefault();
            show();
        }
    });
  </script>

     <script>
        document.getElementById("duplicate_campaign").addEventListener("click", function() {
            document.getElementById("type").value = "campaign";
            document.getElementById("duplicate_campaign").style.display = "none"
            document.getElementById("duplicate_point").style.display = "none"
            document.getElementById("duplicate_campaign_container").style.display = "block";
            document.getElementById("confirm").style.display = "block"
            document.getElementById("cancel").parentNode.classList.remove("hidden");
            document.getElementById("delete_point_matrix").parentNode.classList.add("hidden");

            document.querySelectorAll(".edit-point-matrix").forEach(item => {
                item.style.display = "none"
            });

            document.querySelectorAll(".delete-point-matrix").forEach(item => {
                item.style.display = "none"
            });
        });

        document.getElementById("duplicate_point").addEventListener("click", function() {
            document.getElementById("type").value = "point";
            document.getElementById("duplicate_campaign").style.display = "none"
            document.getElementById("duplicate_point").style.display = "none"
            document.getElementById("duplicate_point_container").style.display = "block";
            document.getElementById("confirm").style.display = "block"
            document.getElementById("cancel").parentNode.classList.remove("hidden");
            document.getElementById("delete_point_matrix").parentNode.classList.add("hidden");

            document.querySelectorAll(".edit-point-matrix").forEach(item => {
                item.style.display = "none"
            });

            document.querySelectorAll(".delete-point-matrix").forEach(item => {
                item.style.display = "none"
            });
        });

        document.getElementById("cancel").addEventListener("click", function(){
            document.getElementById("duplicate_campaign_container").style.display = "none";
            document.getElementById("duplicate_point_container").style.display = "none";
            document.getElementById("duplicate_campaign").style.display = "block"
            document.getElementById("duplicate_point").style.display = "block"
            document.getElementById("confirm").style.display = "none"
            document.getElementById("cancel").parentNode.classList.add("hidden");
            document.getElementById("delete_point_matrix").parentNode.classList.remove("hidden");

            document.querySelectorAll(".edit-point-matrix").forEach(item => {
                item.style.display = "inline"
            });

            document.querySelectorAll(".delete-point-matrix").forEach(item => {
                item.style.display = "inline"
            });
        });
    </script>

    <script>
        function filterAreas(area, pointIdentification) {

            if (area) {
                var ajax = new XMLHttpRequest();
                var url = "{!! route('registers.point-identification.filter-by-area', ['area' => '#']) !!}".replace("#", area);
                var token = document.querySelector('meta[name="csrf-token"]').content;
                var method = 'POST';

                return new Promise(function(resolve, reject) {
                    ajax.open(method, url);

                    ajax.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            var resp = JSON.parse(ajax.response);

                            let i, L = pointIdentification.options.length - 1;
                            for (i = L; i >= 0; i--) {
                                pointIdentification.remove(i);
                            }

                            let pointIdentifications = resp.point_identifications;
                            for (let index = 0; index < pointIdentifications.length; index++) {
                                const item = pointIdentifications[index];
                                var opt = document.createElement('option');
                                opt.value = item.id;
                                opt.text = item.identification;
                                pointIdentification.add(opt);
                            }

                            resolve(resp.point_identifications);
                        } else if (this.readyState == 4 && this.status != 200) {
                            var resp = JSON.parse(ajax.response);
                            reject({
                                status: this.status,
                                statusText: ajax.statusText
                            });
                        }
                    }

                    var data = new FormData();
                    data.append('_token', token);
                    data.append('_method', method);
                    data.append('area', area);

                    ajax.send(data);
                });
            }
        }

        document.querySelectorAll('#areas').forEach(item => {
            item.addEventListener('change', function() {
                filterAreas(document.getElementById("areas").value, document.getElementById("point_identifications")).then(function() {
                    window.customSelectArray["point_identifications"].update();
                });
            });
        });

        document.querySelectorAll('#area_ref').forEach(item => {
            item.addEventListener('change', function() {
                filterAreas(document.getElementById("area_ref").value, document.getElementById("point_identifications_ref")).then(function() {
                    window.customSelectArray["point_identifications_ref"].update();
                });
            });
        });

        campaignEventsDeleteCallback();

        function campaignEventsDeleteCallback() {
            document.querySelectorAll('.delete-campaign').forEach(item => {
                item.addEventListener("click", function() {
                    var urls = '';
                    var elements = '';
                    document.querySelectorAll('input:checked.point-matrix-url').forEach((item, index, arr) => {
                        urls += item.value;
                        elements += item.dataset.id;
                        if (index < (arr.length - 1)) {
                            urls += ',';
                            elements += ',';
                        }
                    });

                    if (urls.length > 0) {
                        var modal = document.getElementById("delete_point_matrix_modal");
                        modal.dataset.url = urls;
                        modal.dataset.elements = elements;
                        modal.classList.remove("hidden");
                        modal.classList.add("block");
                    }
                });
            });
        }


    </script>

    <x-modal title="{{ __('Excluir') }}"
        msg="{{ __('Deseja realmente apagar esse(s) ponto(s)?') }}"
        confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_point_matrix_modal"
        confirm_id="point_matrix_confirm_id"
        cancel_modal="point_matrix_cancel_modal"
        method="DELETE"
    />
</x-app-layout>
