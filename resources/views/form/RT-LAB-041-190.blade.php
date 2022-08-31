<x-app-layout>
    <div class="py-6 ref">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="@if(!$formValue) {{ route('fields.forms.store') }} @else {{ route('fields.forms.index') }} @endif">
                @csrf
                @if(!$formValue) @method("POST") @endif
                @if($formValue) @method("PUT") @endif

                <input type="hidden" name="form_id" value="{{ $form->id }}">
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Project')}} {{ $project_id }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('fields.forms.show', ['field' => $form->fieldType, 'project_id' => $project_id])}}" class="btn-outline-danger">{{ __('Voltar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <h1 class="w-full md:w-1/2 px-3 mb-6 md:mb-0">Amostragem de {{ $form->fieldType->name }}</h1>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 flex justify-end">
                            <button type="button" title="Ajuda" id="help">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="project_id" value="{{ __('Projeto') }}"/>
                            <x-jet-input id="project_id" class="form-control block mt-1 w-full" type="text" name="project_id" maxlength="255" value="{{ $project_id }}" readonly placeholder="{{ __('Digite a Versão do Documento') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="doc_version" value="{{ __('Versão do Documento') }}"/>
                            <x-jet-input disabled="{{ !$formValue ? false : true}}" id="doc_version" class="form-control block mt-1 w-full" type="text" name="doc_version" maxlength="255" value="{{ isset($formValue) ? $formValue->values['doc_version'] : old('doc_version') }}" placeholder="{{ __('Digite a Versão do Documento') }}"/>
                        </div>
                    </div>

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="client" value="{{ __('Cliente') }}" />
                            <x-jet-input disabled="{{ !$formValue ? false : true}}" id="client" class="form-control block mt-1 w-full" type="text" value="{{ isset($formValue) ? $formValue->values['client'] : old('client') }}" name="client" maxlength="255"  placeholder="{{ __('Digite o Nome do Cliente') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="client_address" value="{{ __('Endereço do Cliente') }}" />
                            <x-jet-input disabled="{{ !$formValue ? false : true}}" id="client_address" class="form-control block mt-1 w-full" type="text" value="{{ isset($formValue) ? $formValue->values['client_address'] : old('client_address') }}" name="client_address" maxlength="255"  placeholder="{{ __('Digite o Endereço do Cliente') }}"/>
                        </div>
                    </div>

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="matrix" value="{{ __('Matriz') }}" />
                            <x-jet-input disabled="{{ !$formValue ? false : true}}" id="matrix" class="form-control block mt-1 w-full" type="text" value="{{ isset($formValue) ? $formValue->values['matrix'] : $form->name }}" name="matrix" maxlength="255" />
                        </div>
                    </div>

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4" id="samples">
                        <h2 class="w-full md:w-1/2 px-3 mb-6 md:mb-0">AMOSTRAS</h2>
                        @include('form.sample')
                        @if(isset($formValue))
                            @for ($i = 1; $i < count($formValue->values['samples']); $i++)
                                @include('form.sample')
                            @endfor
                        @endif
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="modal" data-url="">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                <h3 class="text-lg leading-6 font-medium text-gray-900 sm:ml-4 " id="modal-title">
                    {{ __('Informações Adicionais') }}
                </h3>
                <div class="mt-2">
                    {!! $form->infos !!}
                </div>
                </div>
            </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button type="button" id="confirm_modal" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                {{ __('OK') }}
            </button>
            </div>
        </div>
        </div>
    </div>

    <x-spin-load />

    <script>
        document.querySelectorAll(".edit-sample").forEach(item =>{
            item.addEventListener("click", function() {
                item.nextElementSibling.style.display = "inline-block";
                item.style.display = "none";
                document.querySelectorAll(`#${this.dataset.index} input`).forEach(item => {
                    item.disabled = false;
                });
            });
        });

        document.querySelectorAll(".save-sample").forEach(item =>{
            item.addEventListener("click", function() {
                document.getElementById("spin_load").classList.remove("hidden");

                let ajax = new XMLHttpRequest();
                let url = "{!! route('fields.forms.save-sample') !!}";
                let token = document.querySelector('meta[name="csrf-token"]').content;
                let method = 'POST';
                let that = this;
                let files = that.files;
                let form_value_id = document.querySelector(`#${this.dataset.index} #form_value_id`).value;
                let sample_index = document.querySelector(`#${this.dataset.index} #sample_index`).value;

                let equipment = document.querySelector(`#${this.dataset.index} #equipment`).value;
                let point = document.querySelector(`#${this.dataset.index} #point`).value;
                let environment = document.querySelector(`#${this.dataset.index} #environment`).value;
                let collect = document.querySelector(`#${this.dataset.index} #collect`).value;

                const results = [...document.querySelectorAll(`#${this.dataset.index} #table_result input`)];

                ajax.open(method, url);

                ajax.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var resp = JSON.parse(ajax.response);
                        toastr.success(resp.message);
                        location.reload();
                    } else if(this.readyState == 4 && this.status != 200) {
                        document.getElementById("spin_load").classList.add("hidden");
                        toastr.error("{!! __('Um erro ocorreu ao solicitar a consulta') !!}");
                        that.value = '';
                    }
                }

                var data = new FormData();
                data.append('_token', token);
                data.append('_method', method);
                data.append('_method', method);
                data.append('form_value_id', form_value_id);
                data.append('sample_index', sample_index);
                data.append('equipment', equipment);
                data.append('point', point);
                data.append('environment', environment);
                data.append('collect', collect);

                results.forEach(element => {
                    data.append(element.name, element.value);
                });

                ajax.send(data);
            });
        });
    </script>

    <script>
        document.getElementById("help").addEventListener("click", function() {
            var modal = document.getElementById("modal");
            modal.classList.remove("hidden");
            modal.classList.add("block");
        });

        document.getElementById("confirm_modal").addEventListener("click", function(e) {
            var modal = document.getElementById("modal");
            modal.classList.add("hidden");
        });

        document.querySelectorAll(".import-sample-result").forEach(item =>{
            item.addEventListener("click", function() {
                console.log(this.dataset.index);
                document.querySelector(`#${this.dataset.index} #file`).click();
            });
        });


        document.querySelectorAll(".sample #file").forEach(item =>{
            item.addEventListener("change", function(e) {
                document.getElementById("spin_load").classList.remove("hidden");

                let ajax = new XMLHttpRequest();
                let url = "{!! route('fields.forms.import') !!}";
                let token = document.querySelector('meta[name="csrf-token"]').content;
                let method = 'POST';
                let that = this;
                let files = that.files;
                let form_value_id = document.querySelector(`#${this.dataset.index} #form_value_id`).value;
                let sample_index = document.querySelector(`#${this.dataset.index} #sample_index`).value;

                ajax.open(method, url);

                ajax.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var resp = JSON.parse(ajax.response);
                        toastr.success(resp.message);
                        location.reload();
                    } else if(this.readyState == 4 && this.status != 200) {
                        document.getElementById("spin_load").classList.add("hidden");
                        toastr.error("{!! __('Um erro ocorreu ao solicitar a consulta') !!}");
                        that.value = '';
                    }
                }

                var data = new FormData();
                data.append('_token', token);
                data.append('_method', method);
                data.append('_method', method);
                data.append('file', files[0]);
                data.append('form_value_id', form_value_id);
                data.append('sample_index', sample_index);

                ajax.send(data);

            });
        });
    </script>

    <script>
        document.querySelector(".add-sample").addEventListener("click", function() {
            addInput();
        });

        function addInput() {
            const nodes = document.querySelectorAll(".sample");
            const node = nodes[nodes.length - 1];
            const clone = node.cloneNode(true);
            const num = parseInt( clone.id.match(/\d+/g), 10 ) +1;
            const id = `sample_${num}`;
            clone.id = id;

            clone.innerHTML = clone.innerHTML.replaceAll(`row_${num-1}`, `row_${num}`);
            clone.innerHTML = clone.innerHTML.replaceAll(`AMOSTRA <span>${num-1}</span>`, `AMOSTRA <span>${num}</span>`);

            document.getElementById("samples").appendChild(clone);

            document.querySelector(`#${id} .remove-sample`).style.display = "block";

            document.querySelector(`#${id} .remove-sample`).addEventListener("click", function() {
                document.querySelector(`#${id}`).remove();
            });

            document.querySelector(`#${id} .add-sample`).addEventListener("click", function() {
                addInput();
            });


        }
    </script>

</x-app-layout>
