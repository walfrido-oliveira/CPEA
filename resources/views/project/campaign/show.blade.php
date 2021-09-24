<x-app-layout>
    <div class="py-6 show-users">
        <div class="max-w-6xl mx-auto px-4">
            <form method="POST" action="{{ route('project.campaign.duplicate', ['campaign' => $campaign->id]) }}">
                @csrf
                @method("POST")
                <input type="hidden" name="type" id="type" value="campaign">
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1 id="title">{{ __('Campanha: ') }} <span class="font-normal">{{ $campaign->name }}</span></h1>
                    </div>
                    <div class="flex justify-end">
                        <div class="m-2">
                            <button id="duplicate_campaign" type="button" class="btn-outline-info">{{ __('Duplicar Campanha') }}</button>
                            <button id="confirm" type="submit" class="btn-outline-success" style="display: none;">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <button id="duplicate_point" type="button" class="btn-outline-success">{{ __('Duplicar Pontos') }}</button>
                        </div>
                        <div class="m-2 hidden">
                            <button id="cancel" type="button" class="btn-outline-danger">{{ __('Cancelar') }}</button>
                        </div>
                        <div class="m-2">
                            <button type="button" id="delete_point_matrix" class="btn-outline-danger delete-point-matrix" data-type="multiple">{{ __('Apagar') }}</button>
                        </div>
                    </div>
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex md:flex-row flex-col w-full">
                        <div class="mx-4 px-3 py-2 w-full flex justify-end" x-data="{ open: false }">
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
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="area" value="{{ __('Área') }}" />
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

    <x-modal title="{{ __('Excluir Ponto(s)') }}"
            msg="{{ __('Deseja realmente apagar essa Ponto(s)?') }}"
            confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_point_matrix_modal"
            method="DELETE"
            cancel_modal="point_matrix_cancel_modal"
            confirm_id="point_matrix_confirm_modal"/>

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
        })

        /*document.getElementById("duplicate").addEventListener("click", function() {
            document.getElementById("duplicate_container").style.display = "block";
            document.getElementById("duplicate").style.display = "none"
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
            document.getElementById("duplicate_container").style.display = "none";
            document.getElementById("duplicate").style.display = "block"
            document.getElementById("confirm").style.display = "none"
            document.getElementById("cancel").parentNode.classList.add("hidden");
            document.getElementById("delete_point_matrix").parentNode.classList.remove("hidden");

            document.querySelectorAll(".edit-point-matrix").forEach(item => {
                item.style.display = "inline"
            });

            document.querySelectorAll(".delete-point-matrix").forEach(item => {
                item.style.display = "inline"
            });
        });*/
    </script>

    <script>
        function editPointMatrix(elem, row) {
            if(elem.dataset.type != 'edit') return;
            if(document.getElementsByClassName('save-point-matrix').length > 0) {
                toastr.error("Salve primeira a linha atual");
                return;
            }

            document.querySelectorAll("#point_matrix_row_" + row + " select").forEach(item => {
                item.parentNode.classList.remove("hidden");
            });

            document.querySelectorAll("#point_matrix_row_" + row + " .content").forEach(item => {
                item.classList.add("hidden");
            });

            let pointIdentifications = document.getElementById('point_matrix_edit_'+ row + '_point_identification_id');
            let areas = document.getElementById('point_matrix_edit_'+ row + '_area');
            let matriz = document.getElementById('point_matrix_edit_'+ row + '_analysis_matrix_id');
            let plaActionLevel = document.getElementById('point_matrix_edit_'+ row + '_plan_action_level_id');
            let guidingParameter = document.getElementById('point_matrix_edit_'+ row + '_guiding_parameter_id');
            let analysisParameter = document.getElementById('point_matrix_edit_'+ row + '_parameter_analysis_id');

            //clearPointMatrixFields()

            areas.value = document.getElementById('point_matrix_'+ row + '_area').value

            filterAreas(row)
            .then(function(result) {
                pointIdentifications.value = document.getElementById('point_matrix_'+ row + '_point_identification_id') ?
                document.getElementById('point_matrix_'+ row + '_point_identification_id').value : null;
            });

            matriz.value = document.getElementById('point_matrix_'+ row + '_analysis_matrix_id') ?
            document.getElementById('point_matrix_'+ row + '_analysis_matrix_id').value : null;

            plaActionLevel.value = document.getElementById('point_matrix_'+ row + '_plan_action_level_id') ?
            document.getElementById('point_matrix_'+ row + '_plan_action_level_id').value : null;

            guidingParameter.value = document.getElementById('point_matrix_'+ row + '_guiding_parameter_id') ?
            document.getElementById('point_matrix_'+ row + '_guiding_parameter_id').value : null;

            analysisParameter.value = document.getElementById('point_matrix_'+ row + '_parameter_analysis_id') ?
            document.getElementById('point_matrix_'+ row + '_parameter_analysis_id').value : null;
        }

        function editPointMatrixCallback() {
            document.querySelectorAll('.edit-point-matrix').forEach(item => {
                item.addEventListener('click', editPointMatrix.bind(null, item, item.dataset.row), false);
                item.addEventListener("click", editPointMatrixAjax, false);
                item.addEventListener("click", savePointMatrixAjax, false);
            });
        }

        editPointMatrixCallback();
        filterAreasCallback();

        function filterAreasCallback() {
            document.querySelectorAll('.areas').forEach(item => {
                let row = item.id.replace("point_matrix_edit_", "").replace("_area", "");
                item.addEventListener('click', filterAreas.bind(null, row), false);
            });
        }

        function filterAreas(row) {
            var area = document.getElementById('point_matrix_edit_'+ row + '_area').value;
            var pointIdentification = document.getElementById('point_matrix_edit_'+ row + '_point_identification_id');

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

                            let pointIdentifications = resp.point_identifications;

                            var i, L = pointIdentification.options.length - 1;
                            for (i = L; i >= 0; i--) {
                                pointIdentification.remove(i);
                            }

                            for (let index = 0; index < pointIdentifications.length; index++) {
                                const item = pointIdentifications[index];
                                var opt = document.createElement('option');
                                opt.value = item.id;
                                opt.text = item.identification;
                                pointIdentification.add(opt);
                            }

                            resolve(resp.fields);
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

        function editPointMatrixAjax(event) {
            if(this.dataset.type != 'edit') return;

            if(document.getElementsByClassName('save-point-matrix').length > 0) {
                return;
            }

            var id = this.dataset.id;
            var key = this.dataset.row;
            var that = this;
            var ajax = new XMLHttpRequest();
            var url = "{!! route('project.point-matrix.edit-ajax', ['point_matrix' => '#']) !!}".replace('#', id);
            var token = document.querySelector('meta[name="csrf-token"]').content;
            var method = 'POST';

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);
                    that.parentElement.innerHTML = resp;
                    savePointMatrixCallback();

                } else if (this.readyState == 4 && this.status != 200) {
                    toastr.error("{!! __('Um erro ocorreu ao gerar a consulta') !!}");
                }
            }

            var data = new FormData();
            data.append('_token', token);
            data.append('_method', method);
            data.append('id', id);
            data.append('key', key);

            ajax.send(data);
        }

        function savePointMatrixCallback() {
            document.querySelectorAll('.save-point-matrix').forEach(item => {
                item.addEventListener("click", savePointMatrixAjax, false);
            });
        }

        var savePointMatrixAjax = function(event) {
            if(this.dataset.type != 'save') return;

            let id = this.dataset.id;
            let key = this.dataset.row ? this.dataset.row : document.querySelectorAll('.point-matrix-row').length;
            let that = this;
            let ajax = new XMLHttpRequest();
            let url = "{!! route('project.point-matrix.update-ajax', ['point_matrix' => '#']) !!}".replace('#', id);
            let token = document.querySelector('meta[name="csrf-token"]').content;
            let method = 'POST';

            let pointIdentifications = document.getElementById('point_matrix_edit_'+ key + '_point_identification_id').value;
            let areas = document.getElementById('point_matrix_edit_'+ key + '_area').value;
            let matriz = document.getElementById('point_matrix_edit_'+ key + '_analysis_matrix_id').value;
            let plaActionLevel = document.getElementById('point_matrix_edit_'+ key + '_plan_action_level_id').value;
            let guidingParameter = document.getElementById('point_matrix_edit_'+ key + '_guiding_parameter_id').value;
            let analysisParameter = document.getElementById('point_matrix_edit_'+ key + '_parameter_analysis_id').value;

            let campaignId = "{{ $campaign->id }}";

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);
                    toastr.success(resp.message);

                    that.parentElement.parentElement.parentElement.innerHTML = resp.point_matrix_show;

                    document.getElementById("point_matrix_pagination").innerHTML = resp.pagination;

                    eventsPointMatrixDeleteCallback()
                    editPointMatrixCallback();

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
            data.append('id', id);
            data.append('key', key);

            data.append('paginate_per_page', '');
            data.append('ascending', '');
            data.append('order_by', '');

            data.append('point_identification_id', pointIdentifications);
            data.append('analysis_matrix_id', matriz);
            data.append('plan_action_level_id', plaActionLevel);
            data.append('guiding_parameter_id', guidingParameter);
            data.append('parameter_analysis_id', analysisParameter);
            data.append('campaign_id', campaignId);

            ajax.send(data);
        }

        var filterCallback = function (event) {
            let ajax = new XMLHttpRequest();
            let url = "{!! route('project.point-matrix.filter') !!}";
            let token = document.querySelector('meta[name="csrf-token"]').content;
            let method = 'POST';
            let q = document.getElementById("q").value;
            let paginationPerPage = document.getElementById("paginate_per_page_project-point-matrices").value;
            let campaignId = "{{ $campaign->id }}";

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);
                    document.getElementById("point_matrix_table").innerHTML = resp.filter_result_campaign_show;
                    document.getElementById("point_matrix_pagination").innerHTML = resp.pagination;
                    eventsFilterCallback();
                    eventsPointMatrixDeleteCallback()
                    editPointMatrixCallback();
                    selectAllPointMatrices();
                } else if(this.readyState == 4 && this.status != 200) {
                    toastr.error("{!! __('Um erro ocorreu ao gerar a consulta') !!}");
                    eventsFilterCallback();
                    eventsPointMatrixDeleteCallback()
                    editPointMatrixCallback();
                    selectAllPointMatrices();
                }
            }

            var data = new FormData();
            data.append('_token', token);
            data.append('_method', method);
            data.append('q', q);
            data.append('paginate_per_page', paginationPerPage);
            data.append('campaign_id', campaignId);

            ajax.send(data);
        }

        eventsFilterCallback();

        function eventsFilterCallback() {
            document.getElementById("q").addEventListener("keyup", filterCallback, false);
            document.getElementById("paginate_per_page_project-point-matrices").addEventListener("change", filterCallback, false);
        }

        function eventsPointMatrixDeleteCallback() {
            document.querySelectorAll('.delete-point-matrix').forEach(item => {
                item.addEventListener("click", function() {
                    if (this.dataset.type == 'edit') {
                        var url = this.dataset.url;
                        var modal = document.getElementById("delete_point_matrix_modal");
                        modal.dataset.url = url;
                        modal.dataset.elements = this.dataset.id;
                        modal.classList.remove("hidden");
                        modal.classList.add("block");
                    } else if (this.dataset.type == 'multiple') {
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
                    }
                });
            });
        }
        eventsPointMatrixDeleteCallback();

        document.getElementById('point_matrix_confirm_modal').addEventListener('resp', filterCallback, false);

        function selectAllPointMatrices() {
            document.getElementById('select_all_point_matrix').addEventListener('change', function() {
                if (this.checked) {
                    document.querySelectorAll(".point-matrix-url").forEach(item => {
                        item.checked = true;
                    });
                } else {
                    document.querySelectorAll(".point-matrix-url").forEach(item => {
                        item.checked = false;
                    });
                }
            });
        }
        selectAllPointMatrices();

    </script>

    <script>
        function filterAreas() {
            var area = document.getElementById("areas").value;

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

                            let pointIdentification = document.getElementById("point_identifications");

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
        document.getElementById("areas").addEventListener("change", filterAreas, false);
    </script>
</x-app-layout>
