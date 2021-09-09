<script>
    window.addEventListener("load", function() {
        var filterCallbackCampaigns = function (event) {
            var ajax = new XMLHttpRequest();
            var url = "{!! route('registers.point-identification.filter-campaigns') !!}";
            var token = document.querySelector('meta[name="csrf-token"]').content;
            var method = 'POST';
            var paginationPerPage = document.getElementById("paginate_per_page_campaigns").value;
            var name = document.getElementById("name_campaign").value;

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);
                    document.getElementById("campaign_table").innerHTML = resp.filter_result;
                    document.getElementById("pagination_campaigns").innerHTML = resp.pagination;
                    eventsFilterCallbackCampaigns();
                } else if(this.readyState == 4 && this.status != 200) {
                    toastr.error("{!! __('Um erro ocorreu ao gerar a consulta') !!}");
                    eventsFilterCallbackCampaigns();
                }
            }

            var data = new FormData();
            data.append('_token', token);
            data.append('_method', method);
            data.append('paginate_per_page', paginationPerPage);
            data.append('ascending', ascendingCampaigns);
            data.append('order_by', orderBYCampaigns);
            data.append('actions', '{{ $actions }}');
            data.append('point_identification_id', '{{ $pointIdentification->id }}');
            if(name) data.append('name', name);

            ajax.send(data);
        }

        var ascendingCampaigns = "{!! $ascending !!}";
        var orderBYCampaigns = "{!! $orderBy !!}";

        var orderByCallbackCampaigns = function (event) {
            orderBYCampaigns = this.dataset.name;
            ascendingCampaigns = this.dataset.ascending;
            var that = this;
            var ajax = new XMLHttpRequest();
            var url = "{!! route('registers.point-identification.filter-campaigns') !!}";
            var token = document.querySelector('meta[name="csrf-token"]').content;
            var method = 'POST';
            var paginationPerPage =  document.getElementById("paginate_per_page_campaigns").value;
            var name = document.getElementById("name_campaign").value;

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);
                    document.getElementById("campaign_table").innerHTML = resp.filter_result;
                    document.getElementById("pagination_campaigns").innerHTML = resp.pagination;
                    that.dataset.ascending = that.dataset.ascending == 'asc' ? that.dataset.ascending = 'desc' : that.dataset.ascending = 'asc';
                    eventsFilterCallbackCampaigns();
                } else if(this.readyState == 4 && this.status != 200) {
                    toastr.error("{!! __('Um erro ocorreu ao gerar a consulta') !!}");
                    eventsFilterCallbackCampaigns();
                }
            }

            var data = new FormData();
            data.append('_token', token);
            data.append('_method', method);
            data.append('paginate_per_page', paginationPerPage);
            data.append('ascending', ascendingCampaigns);
            data.append('order_by', orderBYCampaigns);
            data.append('actions', '{{ $actions }}');
            data.append('point_identification_id', '{{ $pointIdentification->id }}');
            if(name) data.append('name', name);
            ajax.send(data);
        }

        function eventsFilterCallbackCampaigns() {
            document.querySelectorAll('#name_campaign, #paginate_per_page_campaigns').forEach(item => {
                item.addEventListener('change', filterCallbackCampaigns, false);
                item.addEventListener('keyup', filterCallbackCampaigns, false);
            });
            document.querySelectorAll("#campaign_table thead [data-name]").forEach(item => {
                item.addEventListener("click", orderByCallbackCampaigns, false);
            });
        }
        eventsFilterCallbackCampaigns();
    });
</script>
