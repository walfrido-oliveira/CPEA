<x-app-layout>
    <div class="py-6 show-users">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Campanha: ') }} <span class="font-normal">{{ $campaign->name }}</span></h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2">
                        <a href="{{ route('project.campaign.duplicate', ['campaign' => $campaign->id])}}" class="btn-outline-info">{{ __('Duplicar') }}</a>
                    </div>
                    <div class="m-2">
                        <button type="button" class="btn-outline-danger delete-campaign" id="campaign_delete" data-toggle="modal" data-target="#delete_modal" data-id="{{ $campaign->id }}">{{ __('Apagar') }}</button>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                <div class="filter-container md:block">
                    <div class="flex flex-wrap mx-4 px-3 py-2">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="q" value="{{ __('Pesquisa') }}" />
                            <x-jet-input id="q" class="form-control block w-full filter-field" type="text" name="q" :value="app('request')->input('q')" autofocus autocomplete="project_cod" />
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
        </div>
    </div>

    <x-modal title="{{ __('Excluir Campanha') }}"
             msg="{{ __('Deseja realmente apagar essa Campanha?') }}"
             confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_campaign_modal"
             method="DELETE"
             url="{{ route('project.campaign.destroy', ['campaign' => $campaign->id]) }}"
             redirect-url="{{ route('project.campaign.index') }}"/>

    <script>
        function eventsDeleteCallback() {
            document.querySelectorAll('.delete-campaign').forEach(item => {
            item.addEventListener("click", function() {
                var modal = document.getElementById("delete_campaign_modal");
                modal.classList.remove("hidden");
                modal.classList.add("block");
            })
        });
        }

        eventsDeleteCallback();
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

                    eventsDeleteCallback();
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
                    eventsDeleteCallback();
                    editPointMatrixCallback();
                } else if(this.readyState == 4 && this.status != 200) {
                    toastr.error("{!! __('Um erro ocorreu ao gerar a consulta') !!}");
                    eventsFilterCallback();
                    eventsDeleteCallback();
                    editPointMatrixCallback();
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

    </script>
</x-app-layout>
