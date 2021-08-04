<script>
    window.addEventListener("load", function() {
        var filterCallback = function (event) {
            var area = document.getElementById("areas").value;
            cleanPointidentifications();

            if(area) {
                var ajax = new XMLHttpRequest();
                var url = "{!! route('registers.point-identification.filter-by-area', ['area' => '#']) !!}".replace("#", area);
                var token = document.querySelector('meta[name="csrf-token"]').content;
                var method = 'POST';

                ajax.open(method, url);

                ajax.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var resp = JSON.parse(ajax.response);
                        console.log(resp.point_identifications);

                        let pointIdentifications = resp.point_identifications;
                        for (let index = 0; index < pointIdentifications.length; index++) {
                            const item = pointIdentifications[index];
                            var opt = document.createElement('option');
                            opt.value = item.id;
                            opt.text = item.identification;
                            pointIdentification.add(opt);
                        }
                    } else if(this.readyState == 4 && this.status != 200) {
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
            item.addEventListener('change', filterCallback, false);
        });

        var pointIdentification = document.getElementById("point_identifications");
        function cleanPointidentifications() {
            var i, L = pointIdentification.options.length - 1;
            for(i = L; i >= 0; i--) {
                pointIdentification.remove(i);
            }
        }

        document.getElementById("point_identifications_add").addEventListener("click", function() {
            let list = document.getElementById("point_identifications_list");
            let li = document.createElement("li");

            let pointIdentificationsSelected = document.getElementById("point_identifications");
            let pointIdentificationsSelectedText = pointIdentificationsSelected.options[pointIdentificationsSelected.selectedIndex].text;

            let areasSelectedSelected = document.getElementById("areas");
            let areasSelectedText = areasSelectedSelected.options[areasSelectedSelected.selectedIndex].text;

            let pointIdentificationsSelectedValue = pointIdentificationsSelected.options[pointIdentificationsSelected.selectedIndex].value;
            let id = "point_identification_" + pointIdentificationsSelectedValue;
            let length = list.getElementsByTagName("li").length;

            if(document.getElementById(id)) {
                toastr.error("{!! __('Ponto já adicionado') !!}");
                return;
            }

            if(!document.getElementById("point_identifications").value) {
                toastr.error("{!! __('Nenhum ponto selecionado') !!}");
                return;
            }

            let trashIcon = document.createElement("button");
            trashIcon.classList.add("btn-transition-danger");
            trashIcon.classList.add("delete-point-identification");
            trashIcon.type = "button";

            let icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">' +
                           '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />' +
                        '</svg>' ;

            trashIcon.innerHTML = icon;

            let input = document.createElement("input");
            input.type = "hidden";
            input.name = "point_identification[" + (length) + "]";
            input.value = pointIdentificationsSelectedValue;

            li.id = id;

            let text = document.createTextNode(areasSelectedText + ', ' + pointIdentificationsSelectedText);

            li.appendChild(trashIcon);
            li.appendChild(text);
            li.appendChild(input);

            list.appendChild(li);

            deletePointIdentificationCallback();
        });

        function deletePointIdentificationCallback() {
            document.querySelectorAll(".delete-point-identification").forEach(item => {
                item.addEventListener("click", function() {
                    this.parentElement.parentElement.innerHTML = "";
                })
            });
        }
        deletePointIdentificationCallback();
    });
</script>
