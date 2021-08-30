<script>
    window.addEventListener("load", function() {

        function deleteCampaignCallback() {
            document.querySelectorAll(".delete-point-matrix").forEach(item => {
                item.addEventListener("click", function() {
                    if (!this.dataset.type)
                        this.parentElement.parentElement.parentElement.innerHTML = "";
                })
            });
        }
        deleteCampaignCallback();

        function selectAllCampaigns() {
            document.getElementById('select_all_campaign').addEventListener('change', function() {
                if (this.checked) {
                    document.querySelectorAll(".campaign-url").forEach(item => {
                        item.checked = true;
                    });
                } else {
                    document.querySelectorAll(".campaign-url").forEach(item => {
                        item.checked = false;
                    });
                }
            });
        }
        selectAllCampaigns();


        document.getElementById('delete_campaign').addEventListener('click', function() {
            if (this.dataset.type) return;

            if (document.getElementsByClassName(".campaign-url").length == 0) {
                toastr.error("{!! __('Nenhum ponto selecionado') !!}");
                return;
            }
            document.querySelectorAll(".campaign-url").forEach(item => {
                if (item.checked) {
                    item.parentElement.parentElement.parentElement.innerHTML = "";
                }
            });
        });

        function eventsDeleteCallback() {
            document.querySelectorAll('.delete-campaign').forEach(item => {
                item.addEventListener("click", function() {
                    if (this.dataset.type == 'edit') {
                        var url = this.dataset.url;
                        var modal = document.getElementById("delete_campaign_modal");
                        modal.dataset.url = url;
                        modal.dataset.elements = this.id;
                        modal.classList.remove("hidden");
                        modal.classList.add("block");
                    } else if (this.dataset.type == 'multiple') {
                        var urls = '';
                        var elements = '';
                        document.querySelectorAll('input:checked.campaign-url').forEach((item, index, arr) => {
                            urls += item.value;
                            elements += item.dataset.id;
                            if (index < (arr.length - 1)) {
                                urls += ',';
                                elements += ',';
                            }
                        });

                        if (urls.length > 0) {
                            var modal = document.getElementById("delete_campaign_modal");
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

                    if (resp.area) {
                        toastr.error(resp.area);
                    }
                    if (resp.geodetic_system_id) {
                        toastr.error(resp.geodetic_system_id);
                    }
                    if (resp.identification) {
                        toastr.error(resp.identification);
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

        var campaignOrderByCallback = function(event) {
            console.log(this.nodeName);
            orderBY = this.dataset.name ? this.dataset.name : orderBY;
            ascending = this.dataset.ascending ? this.dataset.ascending : ascending;
            var that = this;
            var ajax = new XMLHttpRequest();
            var url = "{!! route('project.campaign.filter') !!}";
            var token = document.querySelector('meta[name="csrf-token"]').content;
            var method = 'POST';
            var paginationPerPage = document.getElementById("paginate_per_page_project-campaigns").value;

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);
                    document.getElementById("campaign_table").innerHTML = resp.filter_result;
                    document.getElementById("campaign_pagination").innerHTML = resp.pagination;
                    that.dataset.ascending = that.dataset.ascending == 'asc' ? that.dataset.ascending = 'desc' : that.dataset.ascending = 'asc';

                    eventsFilterCallback();
                    selectAllCampaigns();
                    deleteCampaignCallback();
                    eventsDeleteCallback();
                    editCampaignCallback();

                } else if (this.readyState == 4 && this.status != 200) {
                    toastr.error("{!! __('Um erro ocorreu ao gerar a consulta') !!}");
                    eventsFilterCallback();
                    selectAllCampaigns();
                    deleteCampaignCallback();
                    eventsDeleteCallback();
                    editCampaignCallback();
                }
            }

            var data = new FormData();
            data.append('_token', token);
            data.append('_method', method);
            data.append('paginate_per_page', paginationPerPage);
            data.append('ascending', ascending);
            data.append('order_by', orderBY);

            ajax.send(data);
        }

        function eventsFilterCallback() {
            document.querySelectorAll('.filter-field').forEach(item => {
                item.addEventListener('change', campaignOrderByCallback, false);
                item.addEventListener('keyup', campaignOrderByCallback, false);
            });
            document.querySelectorAll("#campaign_table thead [data-name]").forEach(item => {
                item.addEventListener("click", campaignOrderByCallback, false);
            });
        }

        eventsFilterCallback();

        var editCampaignAjax = function(event) {
            if(this.dataset.type != 'edit') return;

            if(document.getElementsByClassName('save-campaign').length > 0) {
                return;
            }

            var id = this.dataset.id;
            var key = this.dataset.row;
            var that = this;
            var ajax = new XMLHttpRequest();
            var url = "{!! route('project.campaign.edit-ajax', ['campaign' => '#']) !!}".replace('#', id);
            var token = document.querySelector('meta[name="csrf-token"]').content;
            var method = 'POST';

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);
                    that.parentElement.innerHTML = resp;
                    saveCampaignCallback();

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

        var saveCampaignAjax = function(event) {
            if(this.dataset.type != 'save') return;

            var id = this.dataset.id;
            var key = this.dataset.row;
            var that = this;
            var ajax = new XMLHttpRequest();
            var url = "{!! route('project.campaign.update-ajax', ['campaign' => '#']) !!}".replace('#', id);
            var token = document.querySelector('meta[name="csrf-token"]').content;
            var method = 'POST';
            let pointIdentifications = document.getElementById("point_identifications").value;
            let matriz = document.getElementById("matriz_id").value;
            let plaActionLevel = document.getElementById("plan_action_level_id").value;
            let guidingParameter = document.getElementById("guiding_parameters_id").value;
            let analysisParameter = document.getElementById("analysis_parameter_id").value;

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);
                    toastr.success(resp.message);

                    if(id > 0) {
                        that.parentElement.parentElement.parentElement.innerHTML = resp.campaign;
                    } else {
                        document.getElementById("campaign_table_content").insertAdjacentHTML('beforeend', resp.campaign);
                    }

                    eventsFilterCallback();
                    selectAllCampaigns();
                    deleteCampaignCallback();
                    eventsDeleteCallback();
                    editCampaignCallback();
                } else if (this.readyState == 4 && this.status != 200) {
                    toastr.error("{!! __('Um erro ocorreu ao gerar a consulta') !!}");
                }
            }

            var data = new FormData();
            data.append('_token', token);
            data.append('_method', method);
            data.append('id', id);
            data.append('key', key);
            data.append('point_identification_id', pointIdentifications);
            data.append('analysis_matrix_id', matriz);
            data.append('plan_action_level_id', plaActionLevel);
            data.append('guiding_parameter_id', guidingParameter);
            data.append('parameter_analysis_id', analysisParameter);
            data.append('project_id', {{ isset($project) ? $project->id : null }});

            ajax.send(data);
        }

        function editCampaignCallback() {
            document.querySelectorAll('.edit-campaign').forEach(item => {
                item.addEventListener('click', editCampaign.bind(null, item, item.dataset.row), false);
                item.addEventListener("click", editCampaignAjax, false);
                item.addEventListener("click", saveCampaignAjax, false);
            });
        }

        function saveCampaignCallback() {
            document.querySelectorAll('.save-campaign').forEach(item => {
                item.addEventListener("click", saveCampaignAjax, false);
            });
            document.getElementById("campaign_table_add").addEventListener("click", saveCampaignAjax, false);
        }

        saveCampaignCallback();
        editCampaignCallback();

        function editCampaign(elem, row) {
            if(elem.dataset.type != 'edit') return;
            if(document.getElementsByClassName('save-campaign').length > 0) {
                toastr.error("{!! __('Salve primeira a linha atual') !!}");
                return;
            }

            let pointIdentifications = document.getElementById("point_identifications");
            let areas = document.getElementById("areas");
            let matriz = document.getElementById("matriz_id");
            let plaActionLevel = document.getElementById("plan_action_level_id");
            let guidingParameter = document.getElementById("guiding_parameters_id");
            let analysisParameter = document.getElementById("analysis_parameter_id");

            clearCampaignFields()

            areas.value = document.getElementById('campaign_'+ row + '_area').value

            filterAreas();

            pointIdentifications.value = document.getElementById('campaign_'+ row + '_point_identification_id') ?
            document.getElementById('campaign_'+ row + '_point_identification_id').value : null;
            matriz.value = document.getElementById('campaign_'+ row + '_analysis_matrix_id') ?
            document.getElementById('campaign_'+ row + '_analysis_matrix_id').value : null;
            plaActionLevel.value = document.getElementById('campaign_'+ row + '_plan_action_level_id') ?
            document.getElementById('campaign_'+ row + '_plan_action_level_id').value : null;
            guidingParameter.value = document.getElementById('campaign_'+ row + '_guiding_parameter_id') ?
            document.getElementById('campaign_'+ row + '_guiding_parameter_id').value : null;
            analysisParameter.value = document.getElementById('campaign_'+ row + '_parameter_analysis_id') ?
            document.getElementById('campaign_'+ row + '_parameter_analysis_id').value : null;
        }

        function clearCampaignFields() {
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

    });
</script>
