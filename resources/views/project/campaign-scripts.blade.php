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

        var ascendingCampaign = "asc";
        var orderByCampaign = 'name';

        var campaignOrderByCallback = function(event) {
            orderByCampaign = this.dataset.name ? this.dataset.name : orderByCampaign;
            ascendingCampaign = this.dataset.ascending ? this.dataset.ascending : ascendingCampaign;
            var that = this;
            var ajax = new XMLHttpRequest();
            var url = "{!! route('project.campaign.filter') !!}";
            var token = document.querySelector('meta[name="csrf-token"]').content;
            var method = 'POST';
            var paginationPerPage = document.getElementById("paginate_per_page_campaigns").value;
            var page = this.dataset.page ? this.dataset.page : document.getElementById("page_campaigns").value;

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
            data.append('ascending', ascendingCampaign);
            data.append('order_by', orderByCampaign);
            data.append('page', page);
            data.append('project_id', {{ $project->id }});

            ajax.send(data);
        }

        function campaignEventsFilterCallback() {
            document.querySelectorAll('#paginate_per_page_campaigns').forEach(item => {
                item.addEventListener('change', campaignOrderByCallback, false);
                item.addEventListener('keyup', campaignOrderByCallback, false);
            });
            document.querySelectorAll("#campaign_table thead [data-name]").forEach(item => {
                item.addEventListener("click", campaignOrderByCallback, false);
            });
            document.querySelectorAll("#campaign_pagination .pagination-item").forEach(item => {
                item.addEventListener("click", function(e) {
                    e.preventDefault();
                });
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

                    document.querySelectorAll(".cancel-campaign").forEach(item => {
                        item.addEventListener("click", cancelCampaign, false);
                    });
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

        var campaign = document.getElementById("campaign_id");

        var saveCampaignAjax = function(event) {
            if(!this.dataset) return;
            if(this.dataset.type != 'save') return;

            let id = this.dataset.id;
            let key = this.dataset.row ? this.dataset.row : document.querySelectorAll('.campaign-row').length;
            let that = this;
            let ajax = new XMLHttpRequest();
            let url = "{!! route('project.campaign.update-ajax', ['campaign' => '#']) !!}".replace('#', id);
            let token = document.querySelector('meta[name="csrf-token"]').content;
            let method = 'POST';

            let campaignName = document.getElementById("campaign_name").value;
            let campaignStatus = document.getElementById("campaign_status").value;
            let paginationPerPage = document.getElementById("paginate_per_page_campaigns").value;

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);
                    toastr.success(resp.message);

                    if(id > 0) {
                        let rowUpdated = document.getElementById("campaign_row_" + that.dataset.row);
                        rowUpdated.innerHTML = resp.campaign;
                    } else {
                        document.getElementById("campaign_table_content").insertAdjacentHTML('beforeend', resp.campaign);
                    }

                    let buttom = document.getElementById("campaign_table_add");
                    buttom.dataset.id = 0;
                    buttom.dataset.row = 0;
                    buttom.innerHTML = "Cadastrar";

                    document.getElementById("campaign_pagination").innerHTML = resp.pagination;

                    let campaigns = resp.campaigns;

                    let i, L = campaign.options.length - 1;
                    for (i = L; i >= 0; i--) {
                        campaign.remove(i);
                    }

                    for (let index = 0; index < campaigns.length; index++) {
                        const item = campaigns[index];
                        var opt = document.createElement('option');
                        opt.value = item.id;
                        opt.text = item.name;
                        campaign.add(opt);
                    }

                    window.customSelectArray["campaign_id"].update();

                    campaignEventsFilterCallback();
                    selectAllCampaigns();
                    deleteCampaignCallback();
                    campaignEventsDeleteCallback();
                    editCampaignCallback();
                    clearCampaignFields();

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
            data.append('ascending', ascendingCampaign);
            data.append('order_by', orderByCampaign);

            data.append('campaign_name', campaignName);
            data.append('campaign_status', campaignStatus);

            data.append('project_id', {{ isset($project) ? $project->id : null }});

            ajax.send(data);
        }

        function editCampaignCallback() {
            document.querySelectorAll('.edit-campaign').forEach(item => {
                item.addEventListener('click', editCampaign.bind(null, item, item.dataset.row), false);
                item.addEventListener("click", editCampaignAjax, false);
                item.addEventListener("click", function(e) {
                    saveCampaignAjax();
                });
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

            let saveButtom = document.getElementById("campaign_table_add");
            saveButtom.dataset.id = elem.dataset.id;
            saveButtom.dataset.row = elem.dataset.row;
            saveButtom.innerHTML = "Salvar";

            let campaignPointMatrix = document.getElementById("campaign_point_matrix");
            let campaignName = document.getElementById("campaign_name");
            let campaignStatus = document.getElementById("campaign_status");
            let dateCollection = document.getElementById("date_collection");

            campaignName.value = document.getElementById('campaign_'+ row + '_campaign_name') ?
            document.getElementById('campaign_'+ row + '_campaign_name').value : null;

            campaignStatus.value = document.getElementById('campaign_'+ row + '_campaign_status') ?
            document.getElementById('campaign_'+ row + '_campaign_status').value : null;

            document.querySelectorAll("#campaign_container select").forEach(item => {
                window.customSelectArray[item.id].update();
            });

        }

        document.getElementById('point_matrix_confirm_id').addEventListener('resp', campaignOrderByCallback, false);

        function clearCampaignFields() {
            let campaignName = document.getElementById("campaign_name");
            let campaignStatus = document.getElementById("campaign_status");

            campaignName.value = '';
            campaignStatus.value = '';
            dateCollection.value = '';

            document.querySelectorAll("#campaign_container select.custom-select").forEach(item => {
                window.customSelectArray[item.id].update();
            });
        }

        function cancelCampaign() {
            let id = this.dataset.id;
            let key = this.dataset.row ? this.dataset.row : document.querySelectorAll('.campaign-row').length;
            let that = this;
            let ajax = new XMLHttpRequest();
            let url = "{!! route('project.campaign.cancel', ['campaign' => '#']) !!}".replace('#', id);
            let token = document.querySelector('meta[name="csrf-token"]').content;
            let method = 'POST';

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);

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
                    clearCampaignFields();
                }
            }

            var data = new FormData();
            data.append('_token', token);
            data.append('_method', method);
            data.append('id', id);
            data.append('key', key);

            ajax.send(data);
        }

        document.getElementById("delete_point_matrix_modal").addEventListener("resp", function() {
            let ajax = new XMLHttpRequest();
            let url = "{!! route('project.campaign.get-campaign-by-project', ['project' => $project->id]) !!}"
            let token = document.querySelector('meta[name="csrf-token"]').content;
            let method = 'POST';

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);
                    let campaigns = resp.campaigns;
                    console.log(campaigns);

                    let i, L = campaign.options.length - 1;
                    for (i = L; i >= 0; i--) {
                        campaign.remove(i);
                    }

                    for (let index = 0; index < campaigns.length; index++) {
                        const item = campaigns[index];
                        var opt = document.createElement('option');
                        opt.value = item.id;
                        opt.text = item.name;
                        campaign.add(opt);
                    }

                    window.customSelectArray["campaign_id"].update();
                }
            }

            var data = new FormData();
            data.append('_token', token);
            data.append('_method', method);

            ajax.send(data);
        });

    });
</script>
