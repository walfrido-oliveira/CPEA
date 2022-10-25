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
                            <div class="w-full md:w-1/2  px-3 mb-6 md:mb-0">
                                <x-jet-label for="q" value="{{ __('Campanha') }}" />
                                <x-jet-input id="name" class="form-control block mt-1 w-full" type="text" name="name" maxlength="255" required autofocus autocomplete="name" :value="$campaign->name"/>
                            </div>
                            <h3 class="w-full mt-4 px-3">Pontos</h3>
                            @foreach ($campaign->projectPointMatrices()->groupBy('point_identification_id')->get() as $key2 => $projectPointMatrix)
                                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0" id="point_identification_{{ $campaign->id }}_{{ $projectPointMatrix->point_identification_id }}">
                                    <x-jet-label for="date_collection_{{ $key2 }}" value="{{ __('DT/HR da Coleta') . ' ' . $projectPointMatrix->pointIdentification->identification}}" required/>
                                    <div class="flex w-full">
                                        <x-jet-input id="date_collection_{{ $key2 }}" class="form-control block mt-1 w-full" type="datetime-local"
                                        name="points[{{ $key2 }}][date_collection]" />
                                        <input type="hidden" name="points[{{ $key2 }}][id]" value="{{ $projectPointMatrix->id }}">
                                        <button class="btn-transition-danger delete-point-identification inline-block" data-id="point_identification_{{ $campaign->id }}_{{ $projectPointMatrix->point_identification_id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div id="duplicate_point_container" style="display: none;">
                        <div class="flex flex-wrap mx-4 px-3 py-2">
                            <h2 class="w-full px-3">{{ __('Referência') }}</h2>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="area_ref" value="{{ __('Área') }}" required />
                                <x-custom-select :options="$areas" name="area_ref" id="area_ref" value="" class="mt-1" select-class="areas-ref no-nice-select" no-filter="no-filter"/>
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="point_identifications_ref" value="{{ __('Identificação Ponto') }}" required/>
                                <x-custom-select :options="[]" name="point_identifications_ref" id="point_identifications_ref" value="" class="mt-1" select-class="point-identifications-ref no-nice-select" no-filter="no-filter" />
                            </div>
                        </div>

                        <div class="filter-container md:block inputs" id="inputs_1" >
                            <div class="flex justify-end">
                                <button type="button" class="btn-transition-primary add-param-analysis" title="Adicionar mais ponto">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </button>
                                <button type="button" class="btn-transition-primary remove-param-analysis" title="Remover ponto" style="display: none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6" />
                                    </svg>
                                </button>
                            </div>

                            <div class="flex flex-wrap mx-4 px-3 py-2">
                                <h2 class="w-full px-3">{{ __('Novos valores') }}</h2>
                                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                    <x-jet-label for="area_1" value="{{ __('Área') }}" />
                                    <x-custom-select :options="$areas" name="inputs[row_1][areas]" id="area_1" value="" class="mt-1" no-filter="no-filter" select-class="areas no-nice-select"/>
                                </div>
                                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                    <x-jet-label for="point_identification_1" value="{{ __('Identificação Ponto') }}"/>
                                    <x-custom-select :options="[]" name="inputs[row_1][point_identifications]" id="point_identification_1" value="" class="mt-1" no-filter="no-filter" select-class="point-identifications no-nice-select"/>
                                </div>
                                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                    <x-jet-label for="date_collection_1" value="{{ __('DT/HR da Coleta') }}" required/>
                                    <x-jet-input id="date_collection_1" class="form-control block mt-1 w-full" type="datetime-local" name="inputs[row_1][date_collection]" maxlength="255" autofocus autocomplete="date_collection"/>
                                </div>
                            </div>
                            <div class="flex flex-wrap mx-4 px-3 py-2">
                                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                    <x-jet-label for="matriz_1" value="{{ __('Matriz') }}" required/>
                                    <x-custom-select :options="$matrizeces" name="inputs[row_1][matriz_id]" id="matriz_1" value="" class="mt-1" no-filter="no-filter" select-class="no-nice-select"/>
                                </div>
                                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                    <x-jet-label for="guiding_parameter_1" value="{{ __('Param. Orientador Ambiental') }}"/>
                                    <x-custom-multi-select multiple :options="$guidingParameters" name="inputs[row_1][guiding_parameters_id][]" id="guiding_parameter_1" value="" select-class="form-input no-nice-select" class="mt-1" no-filter="no-filter" />
                                </div>
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

    <x-modal title="{{ __('Excluir Ponto') }}"
             msg="{{ __('Deseja realmente apagar esse Ponto?') }}"
             confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_point_identification_modal"
             method="DELETE"/>
    <script>
        document.querySelectorAll('.delete-point-identification').forEach(item => {
            item.addEventListener("click", function(e) {
                e.preventDefault();
                var modal = document.getElementById("delete_point_identification_modal");
                modal.classList.remove("hidden");
                modal.classList.add("block");
                currentId = this.dataset.id;
            });
        });

        var currentId = null;

        document.querySelectorAll("#confirm_modal").forEach(item => {
            item.addEventListener("click", function(e) {
                e.preventDefault();
                document.getElementById(currentId).remove();
                var modal = document.getElementById("delete_point_identification_modal");
                modal.classList.add("hidden");
                modal.classList.remove("block");
            });
        });
    </script>

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

                document.querySelectorAll("select.areas-ref").forEach(item => {
                    var i, L = item.options.length - 1;
                    for (i = L; i >= 0; i--) {
                        item.remove(i);
                    }
                });

                document.querySelectorAll("select.areas").forEach(item => {
                    var i, L = item.options.length - 1;
                    for (i = L; i >= 0; i--) {
                        item.remove(i);
                    }
                });

                let pointIdentifications = resp.point_identifications;

                document.querySelectorAll("select.areas-ref").forEach(item2 => {
                    pointIdentifications.forEach((item, index, arr) => {
                        var opt = document.createElement('option');
                        opt.value = item.area;
                        opt.text = item.area;
                        item2.add(opt);
                    });
                });

                document.querySelectorAll("select.areas").forEach(item2 => {
                    pointIdentifications.forEach((item, index, arr) => {
                        var opt = document.createElement('option');
                        opt.value = item.area;
                        opt.text = item.area;
                        item2.add(opt);
                    });
                });

                var modal = document.getElementById("point_create_modal");
                modal.classList.add("hidden");
                modal.classList.remove("block");

                document.querySelectorAll("select.areas").forEach(item => {
                    selectsArray[item.id].update();
                });

                document.querySelectorAll("select.areas-ref").forEach(item => {
                    selectsArray[item.id].update();
                });

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

    document.getElementById("point_cancel_modal").addEventListener("click", function() {
        close();
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
        let campain = document.getElementById("name").value;

        if(pointIdentifications == pointIdentificationsRef && "{{ $campaign->name }}" == campain) {
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
            document.getElementById("point_matrix_table").style.display = "none"
            document.getElementById("point_matrix_pagination").style.display = "none"

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
            document.getElementById("point_matrix_table").style.display = "none"
            document.getElementById("point_matrix_pagination").style.display = "none"

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
            document.getElementById("point_matrix_table").style.display = "table"
            document.getElementById("point_matrix_pagination").style.display = "block"

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
        areasEvents();

        function areasEvents() {
            document.querySelectorAll(".areas").forEach(item => {
                item.addEventListener('change', function() {
                    const point = this.parentNode.parentNode.parentNode.querySelector(".point-identifications");
                    filterAreas(this.value, point).then(function() {
                        selectsArray[point.id].update();
                    });
                });
            });

            document.querySelectorAll('.areas-ref').forEach(item => {
                item.addEventListener('change', function() {
                    const point = this.parentNode.parentNode.parentNode.querySelector(".point-identifications-ref");
                    filterAreas(this.value, point).then(function() {
                        selectsArray[point.id].update();
                    });
                });
            });
        }

        function updateSelects() {
            for (let index = 0; index < selectsArray.length; index++) {
                const element = selectsArray[elem.id].update();
                element.update();
            }
            for (let index = 0; index < window.customSelectArray.length; index++) {
                const element = window.customSelectArray[index];
                element.update();
            }
        }

        var selectsArray = [];

        window.addEventListener("load", function() {
            document.querySelectorAll(`.custom-select.no-nice-select`).forEach(item => {
                selectsArray[item.id] = NiceSelect.bind(item, {searchable: true, reverse: item.dataset.reverse ? item.dataset.reverse : false});
            });
        });

        document.querySelector(".add-param-analysis").addEventListener("click", function() {
            addInput();
        });

        function addInput() {
            const nodes = document.querySelectorAll(".inputs");
            const node = nodes[nodes.length - 1];
            const clone = node.cloneNode(true);
            const num = parseInt( clone.id.match(/\d+/g), 10 ) +1;
            const id = `inputs_${num}`;
            clone.id = id;

            clone.innerHTML = clone.innerHTML.replaceAll(`row_${num-1}`, `row_${num}`);
            clone.innerHTML = clone.innerHTML.replaceAll(`area_${num-1}`, `area_${num}`);
            clone.innerHTML = clone.innerHTML.replaceAll(`point_identification_${num-1}`, `point_identification_${num}`);
            clone.innerHTML = clone.innerHTML.replaceAll(`date_collection_${num-1}`, `date_collection_${num}`);
            clone.innerHTML = clone.innerHTML.replaceAll(`matriz_${num-1}`, `matriz_${num}`);
            clone.innerHTML = clone.innerHTML.replaceAll(`guiding_parameter_${num-1}`, `guiding_parameter_${num}`);

            const selects = clone.getElementsByClassName("nice-select");
            while(selects.length > 0) {
                selects[0].parentNode.removeChild(selects[0]);
            }

            document.getElementById("duplicate_point_container").appendChild(clone);
            document.querySelector(`#${id} .remove-param-analysis`).style.display = "block";

            document.querySelector(`#${id} .remove-param-analysis`).addEventListener("click", function() {
                this.parentNode.parentNode.remove();
            });

            document.querySelector(`#${id} .add-param-analysis`).addEventListener("click", function() {
                addInput();
            });

            document.querySelectorAll(`#${id} .custom-select`).forEach(item => {
                selectsArray[item.id] = NiceSelect.bind(item, {searchable: true, reverse: item.dataset.reverse ? item.dataset.reverse : false});
            });

            areasEvents();
        }

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

        document.getElementById("paginate_per_page").addEventListener("change", function() {
            setTimeout(() => {
                location.reload();
            }, 100);
        });


    </script>

    <x-modal title="{{ __('Excluir') }}"
        msg="{{ __('Deseja realmente apagar esse(s) ponto(s)?') }}"
        confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_point_matrix_modal"
        confirm_id="point_matrix_confirm_id"
        cancel_modal="point_matrix_cancel_modal"
        method="DELETE"
    />
</x-app-layout>
