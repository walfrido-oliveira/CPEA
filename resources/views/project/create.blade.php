<x-app-layout>
    <div class="py-6 create-point-identification">
        <div class="max-w-6xl mx-auto px-4">
            <form method="POST" action="{{ route('project.store') }}">
                @csrf
                @method("POST")
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Cadastrar Projeto') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('project.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="project_cod" value="{{ __('Cód. do Projeto') }}" required />
                            <x-jet-input id="project_cod" class="form-control block mt-1 w-full" type="text" name="project_cod" maxlength="255" required autofocus autocomplete="project_cod" :value="old('project_cod')"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="customer_id" value="{{ __('Cliente') }}"/>
                            <x-custom-select :options="$customers" name="customer_id" id="customer_id" :value="old('customer_id')"/>
                        </div>
                    </div>
                </div>

                <div class="py-2 my-2 bg-white rounded-lg">
                    <div class="flex md:flex-row flex-col mx-4 px-3 py-2">
                        <div class="w-full flex items-center">
                            <h2 class="">{{ __("Identificação do Ponto/Matriz") }}</h2>
                        </div>
                        <div class="w-full flex justify-end">
                            <div class="m-2 ">
                                <button type="button" class="btn-transition-primary" id="">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="m-2 ">
                                <button type="button" class="btn-outline-info" id="project_point_matrix_table_add">{{ __('Cadastrar') }}</button>
                            </div>
                            <div class="m-2 ">
                                <button type="button" id="point-matrix-delete" class="btn-outline-danger">{{ __('Apagar') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2">
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="area" value="{{ __('Área') }}" required />
                            <x-custom-select :options="$areas" name="areas" id="areas" value="" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="point_identifications" value="{{ __('Identificação Ponto') }}"/>
                            <x-custom-select :options="[]" name="point_identifications" id="point_identifications" value="" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="matriz_id" value="{{ __('Matriz') }}"/>
                            <x-custom-select :options="$matrizeces" name="matriz_id" id="matriz_id" value="" class="mt-1"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2">
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="plan_action_level_id" value="{{ __('Tipo Nível Ação Plano') }}" required />
                            <x-custom-select :options="$planActionLevels" name="plan_action_level_id" id="plan_action_level_id" value="" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="guiding_parameters_id" value="{{ __('Param. Orientador Ambiental') }}"/>
                            <x-custom-select :options="$guidingParameters" name="guiding_parameters_id" id="guiding_parameters_id" value="" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="analysis_parameter_id" value="{{ __('Param. Análise') }}"/>
                            <x-custom-select :options="$parameterAnalyses" name="analysis_parameter_id" id="analysis_parameter_id" value="" class="mt-1"/>
                        </div>
                    </div>
                    <div class="flex mt-4">
                        <table id="project_table" class="table table-responsive md:table w-full">
                            @include('project.point-matrix-result', ['projectPointMatrices' => [], 'orderBy' => 'area', 'ascending' => 'asc'])
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>

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

        document.getElementById("project_point_matrix_table_add").addEventListener("click", function() {
            let list = document.getElementById("project_point_matrix_table_content");
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

            let length = list.getElementsByTagName("tr").length;

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

            let input0 = document.createElement("input");
            input0.type = "checkbox";
            input0.name = "project_point_matrix[id][" + (length) + "]";
            input0.classList.add('form-checkbox');
            input0.classList.add('project-point-matrix-row');
            input0.value = null;

            row.id = id;

            let text = document.createTextNode(areasSelectedText + ', ' + pointIdentificationsSelectedText);

            let td0 = document.createElement("td");
            td0.appendChild(input0);

            let td1 = document.createElement("td");
            td1.innerHTML = areasSelectedText;

            let input1 = document.createElement("input");
            input1.type = "hidden";
            input1.name = "project_point_matrix[" + (length) + "][point_identification_id]";
            input1.value = pointIdentificationsSelectedValue;

            td1.appendChild(input1);

            let td2 = document.createElement("td");
            td2.innerHTML = pointIdentificationsSelectedText;

            let td3 = document.createElement("td");
            td3.innerHTML = matrizText;

            let input2 = document.createElement("input");
            input2.type = "hidden";
            input2.name = "project_point_matrix[" + (length) + "][analysis_matrix_id]";
            input2.value = matrixSelectedValue;

            td3.appendChild(input2);

            let td4 = document.createElement("td");
            td4.innerHTML = plaActionLevelText;

            let input3 = document.createElement("input");
            input3.type = "hidden";
            input3.name = "project_point_matrix[" + (length) + "][plan_action_level_id]";
            input3.value = plaActionLevelSelectedValue;

            td4.appendChild(input3);

            let td5 = document.createElement("td");
            td5.innerHTML = guidingParameterText;

            let input4 = document.createElement("input");
            input4.type = "hidden";
            input4.name = "project_point_matrix[" + (length) + "][guiding_parameter_id]";
            input4.value = guidingParameterSelectedValue;

            td5.appendChild(input4);

            let td6 = document.createElement("td");
            td6.innerHTML = analysisParameterText;

            let input5 = document.createElement("input");
            input5.type = "hidden";
            input5.name = "project_point_matrix[" + (length) + "][parameter_analysis_id]";
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
            document.querySelectorAll(".delete-point-identification").forEach(item => {
                item.addEventListener("click", function() {
                    this.parentElement.parentElement.parentElement.innerHTML = "";
                })
            });
        }
        deletePointIdentificationCallback();

        document.getElementById('select_all_point_matrix').addEventListener('change', function() {
            if(this.checked) {
                document.querySelectorAll(".project-point-matrix-row").forEach(item => {
                    item.checked = true;
                });
            } else {
                document.querySelectorAll(".project-point-matrix-row").forEach(item => {
                    item.checked = false;
                });
            }
        });

        document.getElementById('point-matrix-delete').addEventListener('click', function() {
            if(document.getElementsByClassName(".project-point-matrix-row").length == 0) {
                toastr.error("{!! __('Nenhum ponto selecionado') !!}");
                return;
            }
            document.querySelectorAll(".project-point-matrix-row").forEach(item => {
                if(item.checked) {
                    item.parentElement.parentElement.parentElement.innerHTML = "";
                }
            });
        });

    });

    </script>
</x-app-layout>
