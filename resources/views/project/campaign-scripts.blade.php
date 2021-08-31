<script>
    window.addEventListener("load", function() {

        function deleteCampaignCallback() {
            document.querySelectorAll(".delete-campaign").forEach(item => {
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

        function campaignEventsDeleteCallback() {
            document.querySelectorAll('.delete-campaign').forEach(item => {
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
                        document.querySelectorAll('input:checked.campaign-url').forEach((item, index, arr) => {
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

        campaignEventsDeleteCallback();

        document.getElementById("point_create").addEventListener("click", function() {
            var modal = document.getElementById("point_create_modal");
            modal.classList.remove("hidden");
            modal.classList.add("block");
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

                    campaignEventsFilterCallback();
                    selectAllCampaigns();
                    deleteCampaignCallback();
                    campaignEventsDeleteCallback();
                    editCampaignCallback();

                } else if (this.readyState == 4 && this.status != 200) {
                    toastr.error("{!! __('Um erro ocorreu ao gerar a consulta') !!}");
                    campaignEventsFilterCallback();
                    selectAllCampaigns();
                    deleteCampaignCallback();
                    campaignEventsDeleteCallback();
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

        function campaignEventsFilterCallback() {
            document.querySelectorAll('.filter-field').forEach(item => {
                item.addEventListener('change', campaignOrderByCallback, false);
                item.addEventListener('keyup', campaignOrderByCallback, false);
            });
            document.querySelectorAll("#campaign_table thead [data-name]").forEach(item => {
                item.addEventListener("click", campaignOrderByCallback, false);
            });
        }

        campaignEventsFilterCallback();

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
            var key = this.dataset.row ? this.dataset.row : document.querySelectorAll('.campaign-row').length;
            var that = this;
            var ajax = new XMLHttpRequest();
            var url = "{!! route('project.campaign.update-ajax', ['campaign' => '#']) !!}".replace('#', id);
            var token = document.querySelector('meta[name="csrf-token"]').content;
            var method = 'POST';

            let campaignName = document.getElementById("campaign_name").value;
            let campaignStatus = document.getElementById("campaign_status").value;
            let dateCollection = document.getElementById("date_collection").value;
            let campaignPointMatrix = document.getElementById("campaign_point_matrix").value;

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

                    campaignEventsFilterCallback();
                    selectAllCampaigns();
                    deleteCampaignCallback();
                    campaignEventsDeleteCallback();
                    editCampaignCallback();
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
            data.append('campaign_name', campaignName);
            data.append('campaign_status', campaignStatus);
            data.append('date_collection', dateCollection);
            data.append('campaign_point_matrix', campaignPointMatrix);
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

            let campaignName = document.getElementById("campaign_name");
            let campaignStatus = document.getElementById("campaign_status");
            let dateCollection = document.getElementById("date_collection");
            let campaignPointMatrix = document.getElementById("campaign_point_matrix");

            clearCampaignFields()

            campaignName.value = document.getElementById('campaign_'+ row + '_campaign_name') ?
            document.getElementById('campaign_'+ row + '_campaign_name').value : null;

            campaignStatus.value = document.getElementById('campaign_'+ row + '_campaign_status') ?
            document.getElementById('campaign_'+ row + '_campaign_status').value : null;

            dateCollection.value = document.getElementById('campaign_'+ row + '_date_collection') ?
            document.getElementById('campaign_'+ row + '_date_collection').value : null;

            campaignPointMatrix.value = document.getElementById('campaign_'+ row + '_campaign_point_matrix') ?
            document.getElementById('campaign_'+ row + '_campaign_point_matrix').value : null;

        }

        function clearCampaignFields() {
            let campaignName = document.getElementById("campaign_name");
            let areas = document.getElementById("areas");
            let campaignStatus = document.getElementById("campaign_status");
            let dateCollection = document.getElementById("date_collection");
            let campaignPointMatrix = document.getElementById("campaign_point_matrix");

            campaignName.value = ''
            campaignStatus.value = ''
            dateCollection.value = ''
            campaignPointMatrix.value = ''
        }

    });
</script>
