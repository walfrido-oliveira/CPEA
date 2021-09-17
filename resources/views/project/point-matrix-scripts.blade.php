<script>
    window.addEventListener("load", function() {
        function filterAreas() {
            var area = document.getElementById("areas").value;
            cleanPointidentifications();

            if (area) {
                var ajax = new XMLHttpRequest();
                var url = "{!! route('registers.point-identification.filter-by-area', ['area' => '#']) !!}".replace("#", area);
                var token = document.querySelector('meta[name="csrf-token"]').content;
                var method = 'POST';

                ajax.open(method, url);

                ajax.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var resp = JSON.parse(ajax.response);

                        let pointIdentifications = resp.point_identifications;
                        for (let index = 0; index < pointIdentifications.length; index++) {
                            const item = pointIdentifications[index];
                            var opt = document.createElement('option');
                            opt.value = item.id;
                            opt.text = item.identification;
                            pointIdentification.add(opt);
                        }
                    } else if (this.readyState == 4 && this.status != 200) {
                        toastr.error("{!! __('Um erro ocorreu ao gerar a consulta') !!}");
                    }
                }

                var data = new FormData();
                data.append('_token', token);
                data.append('_method', method);
                data.append('area', area);

                ajax.send(data);
            }
        }

        document.querySelectorAll('#areas').forEach(item => {
            item.addEventListener('change', filterAreas, false);
        });

        var pointIdentification = document.getElementById("point_identifications");

        function cleanPointidentifications() {
            var i, L = pointIdentification.options.length - 1;
            for (i = L; i >= 0; i--) {
                pointIdentification.remove(i);
            }
        }

        function getPointMatrices() {
            var id = '{{ $project->id }}';
            var ajax = new XMLHttpRequest();
            var url = "{!! route('project.point-matrix.get-point-matrices-by-project', ['project' => '#']) !!}".replace('#', id);
            var token = document.querySelector('meta[name="csrf-token"]').content;
            var method = 'POST';

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);

                    let pointMatrices = resp.point_matrices;
                    for (let index = 0; index < pointMatrices.length; index++) {
                        const item = pointMatrices[index];
                        var opt = document.createElement('option');
                        opt.value = item.id;
                        opt.text = item.custom_name;
                        campaignPointMatrix.add(opt);
                    }
                } else if (this.readyState == 4 && this.status != 200) {
                    toastr.error("{!! __('Um erro ocorreu ao gerar a consulta') !!}");
                }
            }

            var data = new FormData();
            data.append('_token', token);
            data.append('_method', method);
            data.append('id', id);

            ajax.send(data);
        }

        function deletePointIdentificationCallback() {
            document.querySelectorAll(".delete-point-matrix").forEach(item => {
                item.addEventListener("click", function() {
                    if (!this.dataset.type)
                        this.parentElement.parentElement.parentElement.innerHTML = "";
                })
            });
        }
        deletePointIdentificationCallback();

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


        document.getElementById('delete_point_matrix').addEventListener('click', function() {
            if (this.dataset.type) return;

            if (document.getElementsByClassName(".point-matrix-url").length == 0) {
                toastr.error("{!! __('Nenhum ponto selecionado') !!}");
                return;
            }
            document.querySelectorAll(".point-matrix-url").forEach(item => {
                if (item.checked) {
                    item.parentElement.parentElement.parentElement.innerHTML = "";
                }
            });
        });

        function eventsDeleteCallback() {
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

        eventsDeleteCallback();

        document.getElementById("point_create").addEventListener("click", function() {
            var modal = document.getElementById("point_create_modal");
            modal.classList.remove("hidden");
            modal.classList.add("block");
        });


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

                    close();
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
            data.append('geodetic_system_id', document.getElementById("geodetic_system_id").value)
            data.append('no-redirect', 'no-redirect')

            ajax.send(data);

        });

        function close() {
            var modal = document.getElementById("point_create_modal");
            modal.classList.add("hidden");
            modal.classList.remove("block");
        }

        document.getElementById("point_cancel_modal").addEventListener("click", function(e) {
            close();
        });

        var ascending = "asc";
        var orderBY = 'created_at';

        var orderByCallback = function(event) {
            console.log(this.nodeName);
            orderBY = this.dataset.name ? this.dataset.name : orderBY;
            ascending = this.dataset.ascending ? this.dataset.ascending : ascending;
            var that = this;
            var ajax = new XMLHttpRequest();
            var url = "{!! route('project.point-matrix.filter') !!}";
            var token = document.querySelector('meta[name="csrf-token"]').content;
            var method = 'POST';
            var paginationPerPage = document.getElementById("paginate_per_page_project-point-matrices").value;

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);
                    document.getElementById("point_matrix_table").innerHTML = resp.filter_result;
                    document.getElementById("point_matrix_pagination").innerHTML = resp.pagination;
                    that.dataset.ascending = that.dataset.ascending == 'asc' ? that.dataset.ascending = 'desc' : that.dataset.ascending = 'asc';

                    eventsFilterCallback();
                    selectAllPointMatrices();
                    deletePointIdentificationCallback();
                    eventsDeleteCallback();
                    editPointMatrixCallback();

                } else if (this.readyState == 4 && this.status != 200) {
                    toastr.error("{!! __('Um erro ocorreu ao gerar a consulta') !!}");
                    eventsFilterCallback();
                    selectAllPointMatrices();
                    deletePointIdentificationCallback();
                    eventsDeleteCallback();
                    editPointMatrixCallback();
                }
            }

            var data = new FormData();
            data.append('_token', token);
            data.append('_method', method);
            data.append('paginate_per_page', paginationPerPage);
            data.append('ascending', ascending);
            data.append('order_by', orderBY);
            data.append('project_id', "{{ $project->id }}");

            ajax.send(data);
        }

        function eventsFilterCallback() {
            document.querySelectorAll('#paginate_per_page_project-point-matrices').forEach(item => {
                item.addEventListener('change', orderByCallback, false);
                item.addEventListener('keyup', orderByCallback, false);
            });
            document.querySelectorAll("#point_matrix_table thead [data-name]").forEach(item => {
                item.addEventListener("click", orderByCallback, false);
            });
        }

        eventsFilterCallback();

        var editPointMatrixAjax = function(event) {
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

        var savePointMatrixAjax = function(event) {
            if(this.dataset.type != 'save') return;

            let id = this.dataset.id;
            let key = this.dataset.row ? this.dataset.row : document.querySelectorAll('.point-matrix-row').length;
            let that = this;
            let ajax = new XMLHttpRequest();
            let url = "{!! route('project.point-matrix.update-ajax', ['point_matrix' => '#']) !!}".replace('#', id);
            let token = document.querySelector('meta[name="csrf-token"]').content;
            let method = 'POST';

            let pointIdentifications = document.getElementById("point_identifications").value;
            let matriz = document.getElementById("matriz_id").value;
            let plaActionLevel = document.getElementById("plan_action_level_id").value;
            let guidingParameter = document.getElementById("guiding_parameters_id").value;
            let analysisParameter = document.getElementById("analysis_parameter_id").value;
            let paginationPerPage = document.getElementById("paginate_per_page_campaigns").value;
            let campaignId = document.getElementById("campaign_id").value;

            /* DINAMIC FIELDS */
            let customFields = [];
            document.querySelectorAll('[data-type="campaign-fields"]').forEach(item => {
                customFields.push(item);
            });

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);
                    toastr.success(resp.message);

                    if(id > 0) {
                        that.parentElement.parentElement.parentElement.innerHTML = resp.point_matrix;
                    } else {
                        document.getElementById("point_matrix_table_content").insertAdjacentHTML('beforeend', resp.point_matrix);
                    }

                    document.getElementById("point_matrix_pagination").innerHTML = resp.pagination;

                    eventsFilterCallback();
                    selectAllPointMatrices();
                    deletePointIdentificationCallback();
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

            data.append('paginate_per_page', paginationPerPage);
            data.append('ascending', ascending);
            data.append('order_by', orderBY);

            data.append('point_identification_id', pointIdentifications);
            data.append('analysis_matrix_id', matriz);
            data.append('plan_action_level_id', plaActionLevel);
            data.append('guiding_parameter_id', guidingParameter);
            data.append('parameter_analysis_id', analysisParameter);
            data.append('campaign_id', campaignId);
            data.append('project_id', {{ isset($project) ? $project->id : null }});

            customFields.forEach(item => {
                data.append(item.id, item.value);
            });


            ajax.send(data);
        }

        function editPointMatrixCallback() {
            document.querySelectorAll('.edit-point-matrix').forEach(item => {
                item.addEventListener('click', editPointMatrix.bind(null, item, item.dataset.row), false);
                item.addEventListener("click", editPointMatrixAjax, false);
                item.addEventListener("click", savePointMatrixAjax, false);
            });
        }

        function savePointMatrixCallback() {
            document.querySelectorAll('.save-point-matrix').forEach(item => {
                item.addEventListener("click", savePointMatrixAjax, false);
            });
            document.getElementById("point_matrix_table_add").addEventListener("click", savePointMatrixAjax, false);
        }

        savePointMatrixCallback();
        editPointMatrixCallback();

        function editPointMatrix(elem, row) {
            if(elem.dataset.type != 'edit') return;
            if(document.getElementsByClassName('save-point-matrix').length > 0) {
                toastr.error("{!! __('Salve primeira a linha atual') !!}");
                return;
            }

            let pointIdentifications = document.getElementById("point_identifications");
            let areas = document.getElementById("areas");
            let matriz = document.getElementById("matriz_id");
            let plaActionLevel = document.getElementById("plan_action_level_id");
            let guidingParameter = document.getElementById("guiding_parameters_id");
            let analysisParameter = document.getElementById("analysis_parameter_id");
            let campaignId = document.getElementById("campaign_id");

            clearPointMatrixFields()

            areas.value = document.getElementById('point_matrix_'+ row + '_area').value

            filterAreas();

            pointIdentifications.value = document.getElementById('point_matrix_'+ row + '_point_identification_id') ?
            document.getElementById('point_matrix_'+ row + '_point_identification_id').value : null;

            matriz.value = document.getElementById('point_matrix_'+ row + '_analysis_matrix_id') ?
            document.getElementById('point_matrix_'+ row + '_analysis_matrix_id').value : null;

            plaActionLevel.value = document.getElementById('point_matrix_'+ row + '_plan_action_level_id') ?
            document.getElementById('point_matrix_'+ row + '_plan_action_level_id').value : null;

            guidingParameter.value = document.getElementById('point_matrix_'+ row + '_guiding_parameter_id') ?
            document.getElementById('point_matrix_'+ row + '_guiding_parameter_id').value : null;

            analysisParameter.value = document.getElementById('point_matrix_'+ row + '_parameter_analysis_id') ?
            document.getElementById('point_matrix_'+ row + '_parameter_analysis_id').value : null;

            campaignId.value = document.getElementById('point_matrix_'+ row + '_campaign_id') ?
            document.getElementById('point_matrix_'+ row + '_campaign_id').value : null;

            getFieldsPointMatrix(matriz.value)
            .then(function(result) {
                document.getElementById("point_matrix_fields").innerHTML = result;

                /* DINAMIC FIELDS */
                let customFields = [];
                document.querySelectorAll('[data-type="campaign-fields"]').forEach(item => {
                    customFields.push(item);
                });

                customFields.forEach(item => {
                    let field = document.getElementById('point_matrix_'+ row + '_' + item.id);
                    item.value = '';
                    item.value =  field ? field.value : null;
                });
            });
        }

        function clearPointMatrixFields() {
            let pointIdentifications = document.getElementById("point_identifications");
            let areas = document.getElementById("areas");
            let matriz = document.getElementById("matriz_id");
            let plaActionLevel = document.getElementById("plan_action_level_id");
            let guidingParameter = document.getElementById("guiding_parameters_id");
            let analysisParameter = document.getElementById("analysis_parameter_id");

            areas.value = '';

            filterAreas();

            pointIdentifications.value = ''
            matriz.value = ''
            plaActionLevel.value = ''
            guidingParameter.value = ''
            analysisParameter.value = ''
        }

        document.getElementById('confirm_modal').addEventListener('resp', function(e) {
            cleanCampaigns();
            getPointMatrices();
        }, false);

        document.getElementById('confirm_modal').addEventListener('resp', orderByCallback, false);

        document.getElementById("matriz_id").addEventListener("change", function() {
            getFieldsPointMatrix(this.value)
            .then(function(result) {
                document.getElementById("point_matrix_fields").innerHTML = result;
            });
        });

        function getFieldsPointMatrix(id) {
            let ajax = new XMLHttpRequest();
            let url = "{!! route('project.point-matrix.get-fields', ['analysis_matrix' => '#']) !!}".replace('#', id);
            let token = document.querySelector('meta[name="csrf-token"]').content;
            let method = 'POST';

            return new Promise(function(resolve, reject) {
                ajax.open(method, url);

                ajax.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var resp = JSON.parse(ajax.response);
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
                data.append('id', id);

                ajax.send(data);
            });
        }
    });
</script>
