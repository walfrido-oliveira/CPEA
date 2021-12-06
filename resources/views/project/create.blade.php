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
                </div>
            </form>
        </div>
    </div>

    @include('project.customer-create-modal')

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
