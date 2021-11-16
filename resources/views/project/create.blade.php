<x-app-layout>
    <div class="py-6 create-project">
        <div class="max-w-6xl mx-auto px-4">
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
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

<!-- Modal -->
<div class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="customer_create_modal" data-url="">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
              <h3 class="text-lg leading-6 font-medium text-gray-900 sm:ml-4 " id="modal-title">
                {{ __('Adicionar novo Cliente') }}
              </h3>
              <div class="mt-2">
                <form method="POST" id="poinst_create_form" action="{{ route('customers.simple-create') }}">
                    @csrf
                    @method("POST")

                    <div class="flex flex-wrap py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="name" value="{{ __('Nome') }}" required />
                            <x-jet-input id="name" class="form-control block mt-1 w-full" type="text" name="name" maxlength="255" required autofocus autocomplete="name" :value="old('name')"/>
                        </div>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button type="button" id="customer_confirm_modal" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
            {{ __('Confirmar') }}
          </button>
          <button type="button" id="customer_cancel_modal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
            {{ __('Cancelar') }}
          </button>
        </div>
      </div>
    </div>
  </div>

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
