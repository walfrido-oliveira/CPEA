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

    document.getElementById("point_matrix_table_add").addEventListener("click", function() {
        let list = document.getElementById("point_matrix_table_content");
        let row = document.createElement("tr");

        let pointIdentificationsSelected = document.getElementById("point_identifications");
        let pointIdentificationsSelectedText = pointIdentificationsSelected.options[pointIdentificationsSelected.selectedIndex].text;

        let areasSelectedSelected = document.getElementById("areas");
        let areasSelectedText = areasSelectedSelected.options[areasSelectedSelected.selectedIndex].text;

        let matrizSelected = document.getElementById("matriz_id");
        let matrizText = matrizSelected.options[matrizSelected.selectedIndex].text;

        let plaActionLevelSelected = document.getElementById("plan_action_level_id");
        let plaActionLevelText = plaActionLevelSelected.options[plaActionLevelSelected.selectedIndex].text;

        let guidingParameterSelected = document.getElementById("guiding_parameters_id");
        let guidingParameterText = guidingParameterSelected.options[guidingParameterSelected.selectedIndex].text;

        let analysisParameterSelected = document.getElementById("analysis_parameter_id");
        let analysisParameterText = analysisParameterSelected.options[analysisParameterSelected.selectedIndex].text;

        let pointIdentificationsSelectedValue = pointIdentificationsSelected.options[pointIdentificationsSelected.selectedIndex].value;
        let matrixSelectedValue = matrizSelected.options[matrizSelected.selectedIndex].value;
        let plaActionLevelSelectedValue = plaActionLevelSelected.options[plaActionLevelSelected.selectedIndex].value;
        let guidingParameterSelectedValue = guidingParameterSelected.options[guidingParameterSelected.selectedIndex].value;
        let analysisParameterSelectedValue = analysisParameterSelected.options[analysisParameterSelected.selectedIndex].value;

        let id = "point_identification_" + pointIdentificationsSelectedValue;

        let length = list ? list.getElementsByTagName("tr").length : 0;

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
        trashIcon.classList.add("delete-point-matrix");
        trashIcon.type = "button";

        let icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">' +
                       '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />' +
                    '</svg>' ;

        trashIcon.innerHTML = icon;

        let input0 = document.createElement("input");
        input0.type = "checkbox";
        input0.name = "point_matrix[" + (length) + "][id]";
        input0.classList.add('form-checkbox');
        input0.classList.add('point-matrix-url');
        input0.value = null;

        row.id = id;

        let text = document.createTextNode(areasSelectedText + ', ' + pointIdentificationsSelectedText);

        let td0 = document.createElement("td");
        td0.appendChild(input0);

        let td1 = document.createElement("td");
        let a1 = document.createElement("a");

        a1.classList.add('text-green-600');
        a1.classList.add('underline');
        a1.href = "{{ route('registers.point-identification.show', ['point_identification' => '#']) }}".replace("#", pointIdentificationsSelectedValue);
        a1.target = '_blank';
        a1.rel = 'noopener noreferrer';
        a1.innerText = areasSelectedText;

        td1.appendChild(a1);

        let input1 = document.createElement("input");
        input1.type = "hidden";
        input1.name = "point_matrix[" + (length) + "][point_identification_id]";
        input1.value = pointIdentificationsSelectedValue;

        td1.appendChild(input1);

        let td2 = document.createElement("td");
        let a2 = document.createElement("a");

        a2.classList.add('text-green-600');
        a2.classList.add('underline');
        a2.href = "{{ route('registers.point-identification.show', ['point_identification' => '#']) }}".replace("#", pointIdentificationsSelectedValue);
        a2.target = '_blank';
        a2.rel = 'noopener noreferrer';
        a2.innerText = pointIdentificationsSelectedText;

        td2.appendChild(a2);

        let td3 = document.createElement("td");
        td3.innerHTML = matrizText;

        let input2 = document.createElement("input");
        input2.type = "hidden";
        input2.name = "point_matrix[" + (length) + "][analysis_matrix_id]";
        input2.value = matrixSelectedValue;

        td3.appendChild(input2);

        let td4 = document.createElement("td");
        td4.innerHTML = plaActionLevelText;

        let input3 = document.createElement("input");
        input3.type = "hidden";
        input3.name = "point_matrix[" + (length) + "][plan_action_level_id]";
        input3.value = plaActionLevelSelectedValue;

        td4.appendChild(input3);

        let td5 = document.createElement("td");
        td5.innerHTML = guidingParameterText;

        let input4 = document.createElement("input");
        input4.type = "hidden";
        input4.name = "point_matrix[" + (length) + "][guiding_parameter_id]";
        input4.value = guidingParameterSelectedValue;

        td5.appendChild(input4);

        let td6 = document.createElement("td");
        td6.innerHTML = analysisParameterText;

        let input5 = document.createElement("input");
        input5.type = "hidden";
        input5.name = "point_matrix[" + (length) + "][parameter_analysis_id]";
        input5.value = analysisParameterSelectedValue;

        td6.appendChild(input5);

        let td7 = document.createElement("td");
        td7.appendChild(trashIcon);

        row.appendChild(td0);
        row.appendChild(td1);
        row.appendChild(td2);
        row.appendChild(td3);
        row.appendChild(td4);
        row.appendChild(td5);
        row.appendChild(td6);
        row.appendChild(td7);

        list.appendChild(row);

        deletePointIdentificationCallback();
    });

    function deletePointIdentificationCallback() {
        document.querySelectorAll(".delete-point-matrix").forEach(item => {
            item.addEventListener("click", function() {
                if(!this.dataset.type)
                    this.parentElement.parentElement.parentElement.innerHTML = "";
            })
        });
    }
    deletePointIdentificationCallback();

    document.getElementById('select_all_point_matrix').addEventListener('change', function() {
        if(this.checked) {
            document.querySelectorAll(".point-matrix-url").forEach(item => {
                item.checked = true;
            });
        } else {
            document.querySelectorAll(".point-matrix-url").forEach(item => {
                item.checked = false;
            });
        }
    });

    document.getElementById('delete_point_matrix').addEventListener('click', function() {
        if(this.dataset.type) return;

        if(document.getElementsByClassName(".point-matrix-url").length == 0) {
            toastr.error("{!! __('Nenhum ponto selecionado') !!}");
            return;
        }
        document.querySelectorAll(".point-matrix-url").forEach(item => {
            if(item.checked) {
               item.parentElement.parentElement.parentElement.innerHTML = "";
            }
        });
    });

    function eventsDeleteCallback() {
        document.querySelectorAll('.delete-point-matrix').forEach(item => {
            item.addEventListener("click", function() {
                console.log(this.dataset.type);
                if(this.dataset.type == 'edit') {
                    var url = this.dataset.url;
                    var modal = document.getElementById("delete_point_matrix_modal");
                    modal.dataset.url = url;
                    modal.classList.remove("hidden");
                    modal.classList.add("block");
                }
                else if(this.dataset.type == 'multiple') {
                    var urls = '';
                    document.querySelectorAll('input:checked.point-matrix-url').forEach((item, index, arr) => {
                        urls += item.value ;
                        if(index < (arr.length - 1)) {
                            urls += ',';
                        }
                    });

                    if(urls.length > 0) {
                        var modal = document.getElementById("delete_point_matrix_modal");
                        modal.dataset.url = urls;
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

});

</script>


<script>
    window.addEventListener("load", function() {
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
                    for(i = L; i >= 0; i--) {
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
                } else if(this.readyState == 4 && this.status != 200) {
                    var resp = JSON.parse(ajax.response);

                    if(resp.area) {
                        toastr.error(resp.area);
                    }
                    if(resp.geodetic_system_id) {
                        toastr.error(resp.geodetic_system_id);
                    }
                    if(resp.identification) {
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

    });
</script>
