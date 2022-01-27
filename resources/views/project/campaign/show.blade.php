<x-app-layout>
    <div class="py-6 show-users">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
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
                        <div class="m-2">
                            <a class="btn-outline-info" href="{{ route('project.edit', ['project' => $campaign->project_id]) }}">Voltar</a>
                        </div>
                    </div>
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex md:flex-row flex-col w-full justify-end">
                        <div class="flex justify-end">
                            <button type="button" class="btn-transition-primary" id="point_create" title="Adicionar novo ponto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                        </div>
                        <div class="md:mr-4 md:px-3 pr-2 flex justify-end" x-data="{ open: false }">
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
                            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                <x-jet-label for="areas" value="{{ __('Área') }}" />
                                <x-custom-select :options="$areas" name="areas" id="areas" value="" class="mt-1" no-filter="no-filter"/>
                            </div>
                            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                <x-jet-label for="point_identifications" value="{{ __('Identificação Ponto') }}"/>
                                <x-custom-select :options="[]" name="point_identifications" id="point_identifications" value="" class="mt-1" no-filter="no-filter"/>
                            </div>
                            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                <x-jet-label for="date_collection" value="{{ __('DT/HR da Coleta') }}" required/>
                                <x-jet-input id="date_collection" class="form-control block mt-1 w-full" type="datetime-local" name="date_collection" maxlength="255" autofocus autocomplete="date_collection"/>
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

    @include('project.campaign.point-alert-modal')
    @include('project.point-create-modal')

  <script>
    document.getElementById("point_confirm_modal").addEventListener("click", function() {
        var url = document.querySelector("#poinst_create_form").action;
        var token = document.querySelector('meta[name="csrf-token"]').content;
        var method = document.querySelector("#poinst_create_form").method;
        var ajax = new XMLHttpRequest();

        ajax.open(method, url);

        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var resp = JSON.parse(ajax.response);
                toastr.success(resp.message);

                let areas = document.getElementById("areas");
                var i, L = areas.options.length - 1;
                for (i = L; i >= 0; i--) {
                    areas.remove(i);
                }

                let pointIdentifications = resp.point_identifications;

                pointIdentifications.forEach((item, index, arr) => {
                    var opt = document.createElement('option');
                    opt.value = item.area;
                    opt.text = item.area;
                    areas.add(opt);
                });

                var modal = document.getElementById("point_create_modal");
                modal.classList.add("hidden");
                modal.classList.remove("block");

                window.customSelectArray["areas"].update();

            } else if (this.readyState == 4 && this.status != 200) {
                var resp = JSON.parse(ajax.response);
                var obj = resp;
                for (var key in obj){
                    var value = obj[key];
                    toastr.error("<br>" + value);
                }
            }
        }

        var data = new FormData();
        data.append('_token', token);
        data.append('_method', method);
        data.append('area', document.getElementById("area").value)
        data.append('identification', document.getElementById("identification").value)
        data.append('no-redirect', 'no-redirect')

        ajax.send(data);

    });
    document.getElementById("point_create").addEventListener("click", function() {
        show();
    });

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

    document.getElementById("point_cancel_alert_modal").addEventListener("click", function(e) {
        var modal = document.getElementById("point_create_modal");
        modal.classList.add("hidden");
    });

    document.getElementById("point_confirm_alert_modal").addEventListener("click", function() {
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
