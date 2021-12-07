<script>
    window.addEventListener("load", function() {
        document.querySelectorAll('#areas').forEach(item => {
            item.addEventListener('change', function() {
                filterAreas().then(function() {
                    window.customSelectArray["point_identifications"].update();
                });
            });
        });

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

        var ascending = "asc";
        var orderBY = 'created_at';

        var orderByCallback = function(event) {
            orderBY = this.dataset.name ? this.dataset.name : orderBY;
            ascending = this.dataset.ascending ? this.dataset.ascending : ascending;

            var that = this;
            var ajax = new XMLHttpRequest();
            var url = "{!! route('project.point-matrix.filter') !!}";
            var token = document.querySelector('meta[name="csrf-token"]').content;
            var method = 'POST';
            var paginationPerPage = document.getElementById("paginate_per_page_project-point-matrices").value;
            var page = this.dataset.page ? this.dataset.page : document.getElementById("page_project-point-matrices").value;

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
            data.append('page', page);
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
            document.querySelectorAll("#point_matrix_pagination .pagination-item").forEach(item => {
                item.addEventListener("click", function(e) {
                    e.preventDefault();
                });
                item.addEventListener("click", orderByCallback, false);
            });
        }

        eventsFilterCallback();

        var editPointMatrixAjax = function(event) {
            if(this.dataset.type != 'edit') return;

            if(document.getElementsByClassName('save-point-matrix').length > 0) return;

            var id = this.dataset.id;
            var key = this.dataset.row;
            var that = this;
            var ajax = new XMLHttpRequest();
            var url = "{!! route('project.point-matrix.edit-ajax', ['point_matrix' => '#']) !!}".replace('#', id);
            var token = document.querySelector('meta[name="csrf-token"]').content;
            var method = 'POST';
            var that = this;

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);
                    that.parentElement.innerHTML = resp;

                    savePointMatrixCallback();
                    document.querySelectorAll(".cancel-point-matrix").forEach(item => {
                        item.addEventListener("click", cancelPointMatrix, false);
                    });

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

            document.getElementById("spin_load").classList.toggle("hidden");

            let id = this.dataset.id;
            let key = this.dataset.row ? this.dataset.row : document.querySelectorAll('.point-matrix-row').length;
            let that = this;
            let ajax = new XMLHttpRequest();
            let url = "{!! route('project.point-matrix.update-ajax', ['point_matrix' => '#']) !!}".replace('#', id);
            let token = document.querySelector('meta[name="csrf-token"]').content;
            let method = 'POST';

            let pointIdentifications = document.getElementById("point_identifications").value;
            let matriz = document.getElementById("matriz_id").value;
            let guidingParameter = Array.from(document.getElementById("guiding_parameters_id").options).filter(o => o.selected).map(o => o.value);
            let analysisParameter = document.getElementById("analysis_parameter_id").value;
            let analysisParameters = Array.from(document.getElementById("analysis_parameter_ids").options).filter(o => o.selected).map(o => o.value);
            let paginationPerPage = document.getElementById("paginate_per_page_campaigns").value;
            let campaignId = document.getElementById("campaign_id").value;
            let parameterMethodPreparationId = document.getElementById("parameter_method_preparation_id").value;
            let parameterMethodAnalysisId = document.getElementById("parameter_method_analysis_id").value;
            let dateCollection = document.getElementById("date_collection").value;

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
                        let rowUpdated = document.getElementById("point_matrix_row_" + that.dataset.row);
                        rowUpdated.innerHTML = resp.point_matrix;
                    } else {
                        document.getElementById("point_matrix_table_content").insertAdjacentHTML('beforeend', resp.point_matrix);
                    }

                    let buttom = document.getElementById("point_matrix_table_add");
                    buttom.dataset.id = 0;
                    buttom.dataset.row = 0;
                    buttom.innerHTML = "Cadastrar";

                    document.getElementById("point_matrix_pagination").innerHTML = resp.pagination;

                    eventsFilterCallback();
                    selectAllPointMatrices();
                    deletePointIdentificationCallback();
                    eventsDeleteCallback();
                    editPointMatrixCallback();
                    clearPointMatrixFields();

                    document.getElementById("spin_load").classList.toggle("hidden");

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
            data.append('guiding_parameter_id', guidingParameter);
            data.append('parameter_analysis_id', analysisParameter);
            if(analysisParameters) data.append('analysis_parameter_ids', analysisParameters);
            data.append('campaign_id', campaignId);
            data.append('parameter_method_preparation_id', parameterMethodPreparationId);
            data.append('parameter_method_analysis_id', parameterMethodAnalysisId);
            data.append('date_collection', dateCollection);
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

            let saveButtom = document.getElementById("point_matrix_table_add");
            saveButtom.dataset.id = elem.dataset.id;
            saveButtom.dataset.row = elem.dataset.row;
            saveButtom.innerHTML = "Salvar";

            let pointIdentifications = document.getElementById("point_identifications");
                let areas = document.getElementById("areas");
                let matriz = document.getElementById("matriz_id");
                let guidingParameter = document.getElementById("guiding_parameters_id");
                let guidingParameterOptions = Array.from(document.querySelectorAll('#guiding_parameters_id option'));
                let analysisParameter = document.getElementById("analysis_parameter_id");
                let dateCollection = document.getElementById("date_collection");
                let campaignId = document.getElementById("campaign_id");
                let parameterMethodPreparationId = document.getElementById("parameter_method_preparation_id");
                let parameterMethodAnalysisId = document.getElementById("parameter_method_analysis_id");

                clearPointMatrixFields()
                areas.value = document.getElementById('point_matrix_'+ row + '_area').value

                filterAreas().then(function(result) {
                    pointIdentifications.value = document.getElementById('point_matrix_'+ row + '_point_identification_id') ?
                    document.getElementById('point_matrix_'+ row + '_point_identification_id').value : null;
                    window.customSelectArray["point_identifications"].update();
                });

                matriz.value = document.getElementById('point_matrix_'+ row + '_analysis_matrix_id') ?
                document.getElementById('point_matrix_'+ row + '_analysis_matrix_id').value : null;

                var values = document.getElementById('point_matrix_'+ row + '_guiding_parameter_id').value.split(',').map(Number);

                values.forEach(item => {
                    for (var i = 0; i < guidingParameter.options.length; i++) {
                        if(guidingParameter.options[i].value == '') {
                            guidingParameter.options[i].selected = false;
                            continue;
                        }
                        if(item == guidingParameter.options[i].value) guidingParameter.options[i].selected = true;
                    }
                });

                analysisParameter.value = document.getElementById('point_matrix_'+ row + '_parameter_analysis_id') ?
                document.getElementById('point_matrix_'+ row + '_parameter_analysis_id').value : null;

                campaignId.value = document.getElementById('point_matrix_'+ row + '_campaign_id') ?
                document.getElementById('point_matrix_'+ row + '_campaign_id').value : null;

                parameterMethodPreparationId.value = document.getElementById('point_matrix_'+ row + '_parameter_method_preparation_id') ?
                document.getElementById('point_matrix_'+ row + '_parameter_method_preparation_id').value : null;

                parameterMethodAnalysisId.value = document.getElementById('point_matrix_'+ row + '_parameter_method_analysis_id') ?
                document.getElementById('point_matrix_'+ row + '_parameter_method_analysis_id').value : null;

                dateCollection.value = document.getElementById('point_matrix_'+ row + '_date_collection') ?
                document.getElementById('point_matrix_'+ row + '_date_collection').value : null;

                getFieldsPointMatrix(matriz.value)
                .then(function(result) {
                    document.getElementById("point_matrix_fields").innerHTML = result;

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

                document.querySelectorAll("#point_matrix_container select.custom-select").forEach(item => {
                    if(window.customSelectArray[item.id]) window.customSelectArray[item.id].update();
                });

        }

        function clearPointMatrixFields() {
            let campaign = document.getElementById("campaign_id");
            let parameterMethodPreparationId = document.getElementById("parameter_method_preparation_id");
            let parameterMethodAnalysisId = document.getElementById("parameter_method_analysis_id");
            let pointIdentifications = document.getElementById("point_identifications");
            let areas = document.getElementById("areas");
            let matriz = document.getElementById("matriz_id");
            let guidingParameter = document.getElementById("guiding_parameters_id");
            let analysisParameterGroup = document.getElementById("analysis_parameter_group_id");
            let analysisParameter = document.getElementById("analysis_parameter_id");
            let analysisParameters = document.getElementById("analysis_parameter_ids");
            let dateCollection = document.getElementById("date_collection");

            areas.value = '';

            filterAreas();

            campaign.value = '';
            parameterMethodPreparationId.value = '';
            parameterMethodAnalysisId.value = '';
            pointIdentifications.value = '';
            matriz.value = '';
            guidingParameter.value = '';
            analysisParameter.value = '';
            analysisParameters.value = '';
            analysisParameterGroup.value = '';
            dateCollection.value = '';

            document.querySelectorAll("#point_matrix_container select.custom-select").forEach(item => {
                if(window.customSelectArray[item.id]) window.customSelectArray[item.id].update();
            });
        }

        document.getElementById('point_matrix_confirm_id').addEventListener('resp', orderByCallback, false);

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

        var campaign = document.getElementById("campaign_id");

        function cancelPointMatrix() {
            let id = this.dataset.id;
            let key = this.dataset.row ? this.dataset.row : document.querySelectorAll('.point-matrix-row').length;
            let that = this;
            let ajax = new XMLHttpRequest();
            let url = "{!! route('project.point-matrix.cancel', ['point_matrix' => '#']) !!}".replace('#', id);
            let token = document.querySelector('meta[name="csrf-token"]').content;
            let method = 'POST';

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);

                    if(id > 0) {
                        that.parentElement.parentElement.parentElement.innerHTML = resp.point_matrix;
                    } else {
                        document.getElementById("point_matrix_table_content").insertAdjacentHTML('beforeend', resp.point_matrix);
                    }

                    eventsFilterCallback();
                    selectAllPointMatrices();
                    deletePointIdentificationCallback();
                    eventsDeleteCallback();
                    editPointMatrixCallback();
                    clearPointMatrixFields();
                }
            }

            var data = new FormData();
            data.append('_token', token);
            data.append('_method', method);
            data.append('id', id);
            data.append('key', key);

            ajax.send(data);
        }

        function getGuidingParameters(event) {
            var id = this.value;
            var that = this;
            var ajax = new XMLHttpRequest();
            var url = "{!! route('guiding-parameter-value.list-by-matrix', ['matrix' => '#']) !!}".replace('#', id);
            var token = document.querySelector('meta[name="csrf-token"]').content;
            var method = 'POST';

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);

                    let guidingParametersId = document.getElementById("guiding_parameters_id");

                    let i, L = guidingParametersId.options.length - 1;
                    for (i = L; i >= 0; i--) {
                        guidingParametersId.remove(i);
                    }

                    let guidingParameters = resp.guiding_parameters;

                    for (let index = 0; index < guidingParameters.length; index++) {
                        const item = guidingParameters[index];
                        var opt = document.createElement('option');
                        opt.value = item.guiding_parameter_id;
                        opt.text = item.name;
                        guidingParametersId.add(opt);
                    }

                    if(window.customSelectArray["guiding_parameters_id"]) window.customSelectArray["guiding_parameters_id"].update();

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

        document.getElementById("matriz_id").addEventListener("change", getGuidingParameters, false);

        function getParameterAnalyses(event) {
            var ids = [...this].map(option => option.value);
            var that = this;
            var ajax = new XMLHttpRequest();
            var url = "{!! route('guiding-parameter-value.list-by-guiding-parameter') !!}";
            var token = document.querySelector('meta[name="csrf-token"]').content;
            var method = 'POST';

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);

                    let analysisParameterId = document.getElementById("analysis_parameter_id");

                    let i, L = analysisParameterId.options.length - 1;
                    for (i = L; i >= 0; i--) {
                        analysisParameterId.remove(i);
                    }

                    let parameterAnalyses = resp.parameter_analyses;

                    for (let index = 0; index < parameterAnalyses.length; index++) {
                        const item = parameterAnalyses[index];
                        var opt = document.createElement('option');
                        opt.value = item.parameter_analysis_id;
                        opt.text = item.analysis_parameter_name;
                        analysisParameterId.add(opt);
                    }

                    if(window.customSelectArray["analysis_parameter_id"]) window.customSelectArray["analysis_parameter_id"].update();

                } else if (this.readyState == 4 && this.status != 200) {
                    toastr.error("{!! __('Um erro ocorreu ao gerar a consulta') !!}");
                }
            }

            var data = new FormData();
            data.append('_token', token);
            data.append('_method', method);
            data.append('ids', ids);

            ajax.send(data);
        }

        document.getElementById("guiding_parameters_id").addEventListener("change", getParameterAnalyses, false);

        document.getElementById("change_point_add_method").addEventListener("click", function() {
            let parameterAnalysis = document.getElementById("analysis_parameter_id");
            let parameterAnalysisList = document.getElementById("analysis_parameter_ids");
            let parameterAnalysisLabel= document.getElementById("analysis_parameter_id_label");
            let parameterAnalysisGroup = document.getElementById("analysis_parameter_group_id");
            let parameterAnalysisGroupLabel = document.getElementById("analysis_parameter_group_id_label");
            let analysisParameterIdsLabel = document.getElementById("analysis_parameter_ids_label");

            parameterAnalysis.parentNode.classList.toggle("hidden");
            parameterAnalysisLabel.classList.toggle("hidden");
            analysisParameterIdsLabel.classList.toggle("hidden");
            parameterAnalysisGroup.parentNode.classList.toggle("hidden");
            parameterAnalysisGroupLabel.classList.toggle("hidden");
            parameterAnalysisList.parentNode.classList.toggle("hidden");

            parameterAnalysis.value = '';
            parameterAnalysisGroup.value = '';

            window.customSelectArray["analysis_parameter_id"].update();
            window.customSelectArray["analysis_parameter_group_id"].update();
        });

        function getParameterAnalysesByGroup(event) {
            var id = this.value;
            var that = this;
            var ajax = new XMLHttpRequest();
            var url = "{!! route('parameter-analysis.list-by-group', ['group' => '#']) !!}".replace('#', id);
            var token = document.querySelector('meta[name="csrf-token"]').content;
            var method = 'POST';

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);

                    let guidingParametersId = document.getElementById("analysis_parameter_ids");

                    let i, L = guidingParametersId.options.length - 1;
                    for (i = L; i >= 0; i--) {
                        guidingParametersId.remove(i);
                    }

                    let guidingParameters = resp.result;

                    for (let index = 0; index < guidingParameters.length; index++) {
                        const item = guidingParameters[index];
                        var opt = document.createElement('option');
                        opt.value = item.id;
                        opt.text = item.analysis_parameter_name;
                        guidingParametersId.add(opt);
                    }

                    if(window.customSelectArray["analysis_parameter_ids"]) window.customSelectArray["analysis_parameter_ids"].update();

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

        document.getElementById("analysis_parameter_group_id").addEventListener("change", getParameterAnalysesByGroup, false);

    });
</script>
