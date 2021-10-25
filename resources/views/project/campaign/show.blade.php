<x-app-layout>
    <div class="py-6 show-users">
        <div class="max-w-6xl mx-auto px-4">
            <form method="POST" action="{{ route('project.campaign.duplicate', ['campaign' => $campaign->id]) }}">
                @csrf
                @method("POST")
                <input type="hidden" name="type" id="type" value="campaign">
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center md:justify-start justify-center">
                        <h1 id="title">{{ __('Campanha: ') }} <span class="font-normal">{{ $campaign->name }}</span></h1>
                    </div>
                    <div class="flex md:flex-row flex-col md:justify-end items-center">
                        <div class="m-2">
                            <button id="duplicate_campaign" type="button" class="btn-outline-info whitespace-nowrap">{{ __('Duplicar Campanha') }}</button>
                            <button id="confirm" type="submit" class="btn-outline-success" style="display: none;">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <button id="duplicate_point" type="button" class="btn-outline-success whitespace-nowrap">{{ __('Duplicar Pontos') }}</button>
                        </div>
                        <div class="m-2 hidden">
                            <button id="cancel" type="button" class="btn-outline-danger">{{ __('Cancelar') }}</button>
                        </div>
                        <div class="m-2">
                            <button type="button" id="delete_point_matrix" class="btn-outline-danger delete-point-matrix" data-type="multiple">{{ __('Apagar') }}</button>
                        </div>
                    </div>
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex md:flex-row flex-col w-full">
                        <div class="md:mx-4 md:px-3 py-2 w-full flex justify-end" x-data="{ open: false }">
                            <div class="pr-4 flex">
                                <button type="button" @click="open = !open" id="nav-toggle" class="w-full block btn-transition-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                </button>
                            </div>
                            <!--Search-->
                            <div :class="{'block': open, 'hidden': !open}" class="w-full block" id="search-content">
                                <div class="container mx-auto">
                                    <input id="q" name="q" type="search" placeholder="Buscar..." autofocus="autofocus" class="filter-field w-full form-control no-border">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filter-container md:block" id="duplicate_campaign_container" style="display: none;">
                        <div class="flex flex-wrap mx-4 px-3 py-2">
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <x-jet-label for="q" value="{{ __('Campanha') }}" />
                                <x-jet-input id="name" class="form-control block mt-1 w-full" type="text" name="name" maxlength="255" required autofocus autocomplete="name" :value="$campaign->name"/>
                            </div>
                        </div>
                    </div>
                    <div class="filter-container md:block" id="duplicate_point_container" style="display: none;">
                        <div class="flex flex-wrap mx-4 px-3 py-2">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="area" value="{{ __('Área') }}" />
                                <x-custom-select :options="$areas" name="areas" id="areas" value="" class="mt-1" no-filter="no-filter"/>
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="point_identifications" value="{{ __('Identificação Ponto') }}"/>
                                <x-custom-select :options="[]" name="point_identifications" id="point_identifications" value="" class="mt-1" no-filter="no-filter"/>
                            </div>
                        </div>
                    </div>
                    <div class="flex mt-4">
                        <table id="point_matrix_table" class="table table-responsive md:table w-full">
                            @include('project.campaign.point-matrix-result',
                            ['projectPointMatrices' => $projectPointMatrices, 'orderBy' => 'area', 'ascending' => 'asc'])
                        </table>
                    </div>
                    <div class="flex mt-4 p-2" id="point_matrix_pagination">
                            {{ $projectPointMatrices->appends(request()->input())->links() }}
                    </div>
                </div>
            </form>
        </div>
    </div>

    <x-modal title="{{ __('Excluir Ponto(s)') }}"
            msg="{{ __('Deseja realmente apagar essa Ponto(s)?') }}"
            confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_point_matrix_modal"
            method="DELETE"
            cancel_modal="point_matrix_cancel_modal"
            confirm_id="point_matrix_confirm_modal"/>

    <script>
        document.getElementById("duplicate_campaign").addEventListener("click", function() {
            document.getElementById("type").value = "campaign";
            document.getElementById("duplicate_campaign").style.display = "none"
            document.getElementById("duplicate_point").style.display = "none"
            document.getElementById("duplicate_campaign_container").style.display = "block";
            document.getElementById("confirm").style.display = "block"
            document.getElementById("cancel").parentNode.classList.remove("hidden");
            document.getElementById("delete_point_matrix").parentNode.classList.add("hidden");

            document.querySelectorAll(".edit-point-matrix").forEach(item => {
                item.style.display = "none"
            });

            document.querySelectorAll(".delete-point-matrix").forEach(item => {
                item.style.display = "none"
            });
        });

        document.getElementById("duplicate_point").addEventListener("click", function() {
            document.getElementById("type").value = "point";
            document.getElementById("duplicate_campaign").style.display = "none"
            document.getElementById("duplicate_point").style.display = "none"
            document.getElementById("duplicate_point_container").style.display = "block";
            document.getElementById("confirm").style.display = "block"
            document.getElementById("cancel").parentNode.classList.remove("hidden");
            document.getElementById("delete_point_matrix").parentNode.classList.add("hidden");

            document.querySelectorAll(".edit-point-matrix").forEach(item => {
                item.style.display = "none"
            });

            document.querySelectorAll(".delete-point-matrix").forEach(item => {
                item.style.display = "none"
            });
        });

        document.getElementById("cancel").addEventListener("click", function(){
            document.getElementById("duplicate_campaign_container").style.display = "none";
            document.getElementById("duplicate_point_container").style.display = "none";
            document.getElementById("duplicate_campaign").style.display = "block"
            document.getElementById("duplicate_point").style.display = "block"
            document.getElementById("confirm").style.display = "none"
            document.getElementById("cancel").parentNode.classList.add("hidden");
            document.getElementById("delete_point_matrix").parentNode.classList.remove("hidden");

            document.querySelectorAll(".edit-point-matrix").forEach(item => {
                item.style.display = "inline"
            });

            document.querySelectorAll(".delete-point-matrix").forEach(item => {
                item.style.display = "inline"
            });
        });
    </script>

    <script>
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
        document.querySelectorAll('#areas').forEach(item => {
            item.addEventListener('change', function() {
                filterAreas().then(function() {
                    window.customSelectArray["point_identifications"].update();
                });
            });
        });
    </script>
</x-app-layout>
