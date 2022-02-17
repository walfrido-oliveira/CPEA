<script>
    document.getElementById("to_create").addEventListener("click", function() {
        var modal = document.getElementById("to_create_modal");
        modal.classList.remove("hidden");
        modal.classList.add("block");
    });

    function close() {
        var modal = document.getElementById("to_create_modal");
        modal.classList.add("hidden");
        modal.classList.remove("block");
    }

    document.getElementById("to_cancel_modal").addEventListener("click", function(e) {
        var modal = document.getElementById("to_create_modal");
        modal.classList.add("hidden");
    });

    document.getElementById("to_create").addEventListener("click", function() {
        var modal = document.getElementById("to_create_modal");
        modal.classList.remove("hidden");
        modal.classList.add("block");
    });

    document.getElementById("to_confirm_modal").addEventListener("click", function() {
        var url = document.querySelector("#poinst_create_form").action;
        var token = document.querySelector('meta[name="csrf-token"]').content;
        var method = document.querySelector("#poinst_create_form").method;
        var ajax = new XMLHttpRequest();

        ajax.open(method, url);

        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var resp = JSON.parse(ajax.response);
                toastr.success(resp.message);

                let names = document.getElementById("to");
                var i, L = names.options.length - 1;
                for (i = L; i >= 0; i--) {
                    names.remove(i);
                }

                let tos = resp.tos;

                tos.forEach((item, index, arr) => {
                    var opt = document.createElement('option');
                    opt.value = item.name;
                    opt.text = item.name;
                    names.add(opt);
                });
                if(window.customSelectArray["to"]) window.customSelectArray["to"].update();

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
        data.append('name', document.getElementById("name").value);

        ajax.send(data);

    });
  </script>
