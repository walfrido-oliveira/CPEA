<x-app-layout>
    <div class="py-6 create-project">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="{{ route('project.store') }}">
                @csrf
                @method("POST")
                @if ($type == "duplicate")
                    <input type="hidden" name="duplicated_id" value="{{ $project->id }}">
                @endif
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ $type == "duplicate" ? __('Duplicar Projeto') : __('Cadastrar Projeto') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="button" class="btn-transition-primary" id="customer_create" title="Adicionar novo cliente">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </button>
                        </div>
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
                            <x-jet-input id="project_cod" class="form-control block mt-1 w-full" type="text" name="project_cod" maxlength="255"
                            required autofocus autocomplete="project_cod" :value="isset($project) ? $project->project_cod : old('project_cod')"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="customer_id" value="{{ __('Cliente') }}"/>
                            <x-custom-select :options="$customers" name="customer_id" id="customer_id" :value="isset($project)  ? $project->customer_id : old('customer_id')" class="mt-1"/>
                        </div>
                    </div>

                    @if (isset($project))
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <h2 class="w-full">Campanhas</h2>
                            @foreach ($project->campaigns as $key => $campaign)
                                <div x-data="{ open: false }" class="w-full mb-6 mt-2 relative overflow-hidden">
                                    <div  @click="open = ! open" class="p-4 w-1/2 rounded flex justify-between items-center" style="background-color: #005e10">
                                      <div class="flex items-center gap-2">
                                          <h4 class="font-medium text-sm text-white">{{ '#' . ($key+1) . ' ' . $campaign->name }}</h4>
                                      </div>
                                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                      </svg>
                                    </div>
                                    <div x-show="open" x-transition:enter="transition ease-out duration-300"
                                          x-transition:enter-start="opacity-0 translate-y-0"
                                          x-transition:enter-end="opacity-100 translate-y-0"
                                          x-transition:leave="transition ease-in duration-300"
                                          x-transition:leave-start="opacity-100 translate-y-10"
                                          x-transition:leave-end="opacity-0 translate-y-0" class="w-1/2 bg-white px-2">
                                        <div class="flex flex-wrap mt-4">
                                            <x-jet-label for="campaign_name_{{ $key }}" value="{{ __('Nome da Campanha ') . '#' . ($key+1)  }}" required />
                                            <x-jet-input id="campaign_name_{{ $key }}" class="form-control block mt-1 w-full" type="text" name="campaigns[{{ $key }}][name]" maxlength="255" :value="$campaign->name"/>
                                            <input type="hidden" name="campaigns[{{ $key }}][id]" value="{{ $campaign->id }}">

                                            <h3 class="w-full mt-4">Pontos</h3>
                                            @foreach ($campaign->projectPointMatrices()->groupBy('point_identification_id')->get() as $key2 => $projectPointMatrix)
                                                <div class="w-full mb-6 md:mb-0 mt-2" id="point_identification_{{ $campaign->id }}_{{ $projectPointMatrix->point_identification_id }}">
                                                    <x-jet-label for="date_collection_{{ $key2 }}" value="{{ __('DT/HR da Coleta') . ' ' . $projectPointMatrix->pointIdentification->identification}}" required/>
                                                    <div class="flex w-full">
                                                        <x-jet-input id="date_collection_{{ $key2 }}" class="form-control block mt-1 w-full" type="datetime-local"
                                                        name="campaigns[{{ $key }}][points][{{ $projectPointMatrix->point_identification_id }}][date_collection]" />
                                                        <input type="hidden" name="campaigns[{{ $key }}][points][{{ $projectPointMatrix->point_identification_id }}][id]" value="{{ $projectPointMatrix->point_identification_id }}">
                                                        <button class="btn-transition-danger delete-point-identification inline-block" data-id="point_identification_{{ $campaign->id }}_{{ $projectPointMatrix->point_identification_id }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>


                    @endif

                </div>
            </form>
        </div>
    </div>

    @include('project.customer-create-modal')

    <x-modal title="{{ __('Excluir Ponto') }}"
             msg="{{ __('Deseja realmente apagar esse Ponto?') }}"
             confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_point_identification_modal"
             method="DELETE"/>

    <script>
        document.querySelectorAll('.delete-point-identification').forEach(item => {
            item.addEventListener("click", function(e) {
                e.preventDefault();
                var modal = document.getElementById("delete_point_identification_modal");
                modal.classList.remove("hidden");
                modal.classList.add("block");
                currentId = this.dataset.id;
            });
        });

        var currentId = null;

        document.querySelectorAll("#confirm_modal").forEach(item => {
            item.addEventListener("click", function(e) {
                e.preventDefault();
                document.getElementById(currentId).remove();
                var modal = document.getElementById("delete_point_identification_modal");
                modal.classList.add("hidden");
                modal.classList.remove("block");
            });
        });
    </script>

  <script>
    document.getElementById("customer_create").addEventListener("click", function() {
        var modal = document.getElementById("customer_create_modal");
        modal.classList.remove("hidden");
        modal.classList.add("block");
    });

    function close() {
        var modal = document.getElementById("customer_create_modal");
        modal.classList.add("hidden");
        modal.classList.remove("block");
    }

    document.getElementById("customer_cancel_modal").addEventListener("click", function(e) {
        var modal = document.getElementById("customer_create_modal");
        modal.classList.add("hidden");
    });

    document.getElementById("customer_create").addEventListener("click", function() {
        var modal = document.getElementById("customer_create_modal");
        modal.classList.remove("hidden");
        modal.classList.add("block");
    });

    document.getElementById("customer_confirm_modal").addEventListener("click", function() {
        var url = document.querySelector("#poinst_create_form").action;
        var token = document.querySelector('meta[name="csrf-token"]').content;
        var method = document.querySelector("#poinst_create_form").method;
        var ajax = new XMLHttpRequest();

        ajax.open(method, url);

        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var resp = JSON.parse(ajax.response);
                toastr.success(resp.message);

                let names = document.getElementById("customer_id");
                var i, L = names.options.length - 1;
                for (i = L; i >= 0; i--) {
                    names.remove(i);
                }

                let customers = resp.customers;

                customers.forEach((item, index, arr) => {
                    var opt = document.createElement('option');
                    opt.value = item.name;
                    opt.text = item.name;
                    names.add(opt);
                });
                if(window.customSelectArray["customer_id"]) window.customSelectArray["customer_id"].update();

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

</x-app-layout>
