<script>
    window.addEventListener("load", function() {
        var filterCallback = function (event) {
            var ajax = new XMLHttpRequest();
            var url = "{!! route('customers.filter') !!}";
            var token = document.querySelector('meta[name="csrf-token"]').content;
            var method = 'POST';
            var paginationPerPage = document.getElementById("paginate_per_page") ? document.getElementById("paginate_per_page").value : document.getElementById("paginate_per_page_customers").value;
            var id = document.getElementById("id") ? document.getElementById("id").value : null;
            var name = document.getElementById("name") ? document.getElementById("name").value : null;

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);
                    document.getElementById("customer_table").innerHTML = resp.filter_result;
                    document.getElementById("pagination_customers").innerHTML = resp.pagination;
                    eventsFilterCallback();
                    eventsDeleteCallback();
                } else if(this.readyState == 4 && this.status != 200) {
                    toastr.error("{!! __('Um erro ocorreu ao gerar a consulta') !!}");
                    eventsFilterCallback();
                    eventsDeleteCallback();
                }
            }

            var data = new FormData();
            data.append('_token', token);
            data.append('_method', method);
            data.append('paginate_per_page', paginationPerPage);
            data.append('actions', '{{ $actions }}');
            data.append('ascending', ascending);
            data.append('order_by', orderBY);
            if(id) data.append('id', id);
            if(name) data.append('name', name);

            ajax.send(data);
        }

        var ascending = "{!! $ascending !!}";
        var orderBY = "{!! $orderBy !!}";

        var orderByCallback = function (event) {
            orderBY = this.dataset.name;
            ascending = this.dataset.ascending;
            var that = this;
            var ajax = new XMLHttpRequest();
            var url = "{!! route('customers.filter') !!}";
            var token = document.querySelector('meta[name="csrf-token"]').content;
            var method = 'POST';
            var paginationPerPage = document.getElementById("paginate_per_page") ? document.getElementById("paginate_per_page").value : document.getElementById("paginate_per_page_customers").value;
            var id = document.getElementById("id") ? document.getElementById("id").value : null;
            var name = document.getElementById("name") ? document.getElementById("name").value : null;

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);
                    document.getElementById("customer_table").innerHTML = resp.filter_result;
                    document.getElementById("pagination_customers").innerHTML = resp.pagination;
                    that.dataset.ascending = that.dataset.ascending == 'asc' ? that.dataset.ascending = 'desc' : that.dataset.ascending = 'asc';
                    eventsFilterCallback();
                    eventsDeleteCallback();
                } else if(this.readyState == 4 && this.status != 200) {
                    toastr.error("{!! __('Um erro ocorreu ao gerar a consulta') !!}");
                    eventsFilterCallback();
                    eventsDeleteCallback();
                }
            }

            var data = new FormData();
            data.append('_token', token);
            data.append('_method', method);
            data.append('paginate_per_page', paginationPerPage);
            data.append('ascending', ascending);
            data.append('order_by', orderBY);
            data.append('actions', '{{ $actions }}');
            if(id) data.append('id', id);
            if(name) data.append('name', name);
            ajax.send(data);
        }

        function eventsFilterCallback() {
            document.querySelectorAll('#paginate_per_page_customers, #name, #id').forEach(item => {
                item.addEventListener('change', filterCallback, false);
                item.addEventListener('keyup', filterCallback, false);
            });
            document.querySelectorAll("#customer_table thead [data-name]").forEach(item => {
                item.addEventListener("click", orderByCallback, false);
            });
        }

        function eventsDeleteCallback() {
            document.querySelectorAll('.delete-customer').forEach(item => {
                item.addEventListener("click", function() {
                    if(this.dataset.type != 'multiple') {
                        var url = this.dataset.url;
                        var modal = document.getElementById("delete_customer_modal");
                        modal.dataset.url = url;
                        modal.classList.remove("hidden");
                        modal.classList.add("block");
                    }
                    else {
                        var urls = '';
                        document.querySelectorAll('input:checked.customer-url').forEach((item, index, arr) => {
                            urls += item.value ;
                            if(index < (arr.length - 1)) {
                                urls += ',';
                            }
                        });

                        if(urls.length > 0) {
                            var modal = document.getElementById("delete_customer_modal");
                            modal.dataset.url = urls;
                            modal.classList.remove("hidden");
                            modal.classList.add("block");
                        }
                    }
                });
            });
        }

        eventsDeleteCallback();
        eventsFilterCallback();
    });
</script>
