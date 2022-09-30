<x-app-layout>
    <div class="py-6 ref">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="@if(!$formValue) {{ route('fields.forms.store') }} @else {{ route('fields.forms.update', ['form_value' => $formValue->id]) }} @endif">
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
                            <button type="submit" class="btn-outline-success">{{ __('Salvar') }}</button>
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
                            <x-jet-input  id="doc_version" class="form-control block mt-1 w-full" type="text" name="doc_version" maxlength="255" value="{{ isset($formValue) ? $formValue->values['doc_version'] : old('doc_version') }}" placeholder="{{ __('Digite a Versão do Documento') }}"/>
                        </div>
                    </div>

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="client" value="{{ __('Cliente') }}" />
                            <x-jet-input  id="client" class="form-control block mt-1 w-full" type="text" value="{{ isset($formValue) ? $formValue->values['client'] : old('client') }}" name="client" maxlength="255"  placeholder="{{ __('Digite o Nome do Cliente') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="client_address" value="{{ __('Endereço do Cliente') }}" />
                            <x-jet-input  id="client_address" class="form-control block mt-1 w-full" type="text" value="{{ isset($formValue) ? $formValue->values['client_address'] : old('client_address') }}" name="client_address" maxlength="255"  placeholder="{{ __('Digite o Endereço do Cliente') }}"/>
                        </div>
                    </div>

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="matrix" value="{{ __('Matriz') }}" />
                            <x-jet-input  id="matrix" class="form-control block mt-1 w-full" type="text" value="{{ isset($formValue) ? $formValue->values['matrix'] : $form->name }}" name="matrix" maxlength="255" />
                        </div>
                    </div>

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4" id="samples">
                        <div class="flex w-full">
                            <h2 class="w-full md:w-1/2 px-3 mb-6 md:mb-0">AMOSTRAS</h2>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 flex justify-end align-baseline" style="align-items: baseline;">
                                <button type="button" id="view_table" class="btn-transition-primary px-1" title="Modo de visualização em tabela de edição">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 text-green-900">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0112 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" />
                                    </svg>
                                </button>
                                <button type="button" id="view_list" class="btn-transition-primary px-1" title="Modo de visualização em lista">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 text-blue-900">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                </button>
                                <button type="button" id="view_sample_table" class="btn-transition-primary px-1" title="Modo de visualização em tabela">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 text-green-900">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" />
                                    </svg>
                                </button>
                                <div class="block py-2 px-2" x-data="{ open: false }">
                                    <div class="flex sm:items-center justify-end w-full">
                                        <x-jet-dropdown align="right" width="48" contentClasses="p-0">
                                            <x-slot name="trigger">
                                                <button type="button" id="filter_results" class="btn-transition-primary px-1" title="Filtrar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 text-yellow-500">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                                                    </svg>
                                                </button>
                                            </x-slot>

                                            <x-slot name="content">
                                                <button class='status-analysis-order-edit block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 bg-yellow-100 focus:outline-none focus:bg-gray-100
                                                              transition w-full' data-status="default" id="filter_default" type="button">Dados</button>

                                                <div class="border-t border-gray-100"></div>

                                                <button class='status-analysis-order-edit block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 bg-green-100 focus:outline-none focus:bg-gray-100
                                                              transition w-full' data-status="duplicate" id="filter_duplicate" type="button">Duplicatas</button>

                                                <div class="border-t border-gray-100"></div>

                                            </x-slot>
                                        </x-jet-dropdown>
                                    </div>
                                </div>
                                <button type="button" id="view_chart" class="btn-transition-primary px-1" title="Visualizar Gráfico">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 text-blue-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
                                      </svg>
                                </button>
                            </div>
                        </div>

                        @if(isset($formValue->values['samples']) && count($formValue->values['samples']) > 0)
                            <div id="mode_table">
                                @for ($i = 0; $i < count($formValue->values['samples']); $i++)
                                    @include('form.sample', ['sample' => $formValue->values['samples']["row_$i"]])
                                @endfor
                            </div>
                            <div id="mode_list">
                                @foreach (array_chunk($formValue->values['samples'], 3) as $sampleArray)
                                    <div class="flex flex-wrap mt-2 w-full mode-list default-table">
                                        <div class="flex flex-wrap mt-2 w-full">
                                            <div class="mx-1 p-3">
                                                <p class="font-bold">{{ __('Ponto de Coleta') }}</p>
                                                <p class="font-bold">{{ __('Condições ambientais nas últimas 24 hs') }}</p>
                                                <p class="font-bold">{{ __('DT/HR da Coleta') }}</p>
                                                <p style="background-color: #FFF; margin-left: -12px; margin-right: -12px; margin-top: 12px; margin-bottom: 12px;">&nbsp;</p>
                                                <p class="font-bold">{{ __('Temperatura ºC') }}</p>
                                                <p class="font-bold">{{ __('pH') }}</p>
                                                <p class="font-bold">{{ __('ORP (mV)') }}</p>
                                                <p class="font-bold">{{ __('Condutividade') }}</p>
                                                <p class="font-bold">{{ __('Salinidade') }}</p>
                                                <p class="font-bold">{{ __('Oxigênio Dissolvido (sat) (%)') }}</p>
                                                <p class="font-bold">{{ __('Oxigênio Dissolvido (conc) (mg/L)') }}</p>
                                                <p class="font-bold">{{ __('EH (mV)') }}</p>
                                                <p class="font-bold">{{ __('Turbidez (NTU)') }}</p>
                                            </div>
                                            @for ($i = 0; $i < count($sampleArray); $i++)
                                                @if(isset($sampleArray[$i]['results'])) @include('form.sample-list', ['sample' => $sampleArray[$i]]) @endif
                                            @endfor
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div id="mode_sample_table">
                                @for ($i = 0; $i < count($formValue->values['samples']); $i++)
                                    @include('form.sample-table', ['sample' => $formValue->values['samples']["row_$i"]])
                                @endfor
                            </div>
                        @else
                            @include('form.sample')
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Chart -->
    <div class="modal fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="modal_chart">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full" style="max-width: 70rem;">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="block">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <canvas id="myChart" width="800" height="400" style="display: block; box-sizing: border-box; height: 400px; width: 800px; max-height: 400px"></canvas>
                        </div>
                        <div class="flex flex-wrap mt-2 w-full">
                          @foreach (array_chunk($formValue->values['samples'], 5) as $key => $sample)
                            <div class="grid mt-2 w-full" style="grid-template-columns: auto auto auto auto auto auto auto auto;">
                                <div class="mx-1 p-3">
                                    <p class="font-bold">{{ __('Ponto de Coleta') }}</p>
                                    <p style="background-color: #FFF; margin-left: -12px; margin-right: -12px; margin-top: 12px; margin-bottom: 12px;">&nbsp;</p>
                                    <p class="font-bold">{{ __('pH') }}</p>
                                    <p class="font-bold">{{ __('EH (mV)') }}</p>
                                </div>
                                @for ($i = 0; $i < count($sample); $i++)
                                    <div class="mx-1 p-3 bg-gray-100">
                                        <p>
                                            {{ $sample[$i]['point'] }}
                                        </p>
                                        <p style="background-color: #FFF; margin-left: -12px; margin-right: -12px; margin-top: 12px; margin-bottom: 12px;">&nbsp;</p>
                                        <p class="font-bold">
                                            {{ number_format($svgs['row_' . ($i)]['ph'], 1, ",", ".") }}
                                        </p>
                                        <p class="font-bold">
                                            {{ number_format($svgs['row_' . ($i)]['eh'], 0, ",", ".") }}
                                        </p>
                                    </div>
                                @endfor
                            </div>
                          @endforeach
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="confirm_modal_chart" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ __('OK') }}
                    </button>
                </div>
            </div>
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

    <div class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="delete_modal">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Deseja Deletar essa amostra?
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Deseja realmente deletar essa amostra?</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="confirm_delete_modal" class="btn-confirm">
                        Deletar
                    </button>
                    <button type="button" id="cancel_delete_modal" class="btn-cancel" data-index="">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.getElementById("view_chart").addEventListener("click", function() {
            var modal = document.getElementById("modal_chart");
            modal.classList.remove("hidden");
            modal.classList.add("block");
        });

        document.getElementById("confirm_modal_chart").addEventListener("click", function() {
            var modal = document.getElementById("modal_chart");
            modal.classList.add("hidden");
            modal.classList.remove("block");
        });
        window.addEventListener("load", function() {
            var ctx = document.getElementById('myChart').getContext('2d');
            const data = {
                datasets: [{
                    labels: [
                        @foreach ($formValue->values['samples'] as $key => $sample)
                            "{{ $sample['point'] }} - pH {{ number_format($svgs[$key]['ph'], 2, ",", ".") }} e EH {{ number_format($svgs[$key]['eh'], 1, ",", ".") }}",
                        @endforeach
                    ],
                    label: '',
                    data: [
                        @foreach ($formValue->values['samples'] as $key => $sample)
                            { x: {{ $svgs[$key]['eh'] ? $svgs[$key]['eh'] : 0  }} , y: {{ $svgs[$key]['ph'] ? $svgs[$key]['ph'] : 0  }} },
                        @endforeach
                    ],
                    backgroundColor: [
                        '#ff6384'
                    ]
                }],
            };
            const config = {
                type: 'scatter',
                data: data,
                options: {
                    backgroundRules: [{
                        backgroundColor: "rgb(253, 234, 218)",
                        yAxisSegement: 0
                    },
                    {
                        backgroundColor: "rgb(198,217,241)",
                        yAxisSegement: 400
                    },
                    {
                        backgroundColor: "rgb(236,202,201)",
                        yAxisSegement: 800
                    }
                    ],
                    scales: {
                        x: {
                            type: 'linear',
                            position: 'bottom',
                            title: {
                                display: true,
                                text: "EV (mV)"
                            },
                            min: -600,
                            max: 800,
                            ticks: {
                                stepSize: 100
                            },

                        },
                        y: {
                            min: 0,
                            max: 14,
                            ticks: {
                                stepSize: .5,
                                autoSkip: true,
                            },
                            title: {
                                display: true,
                                text: "pH"
                            },
                            grid: {
                                drawBorder: false,
                                lineWidth: function(context) {
                                    if (context.tick.value == 5 || context.tick.value == 8)
                                        return 2;
                                    return 1;
                                },
                                color: function(context) {
                                    if (context.tick.value == 5 || context.tick.value == 8)
                                        return '#000000';
                                    return '#ccc';
                                },
                            },
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    var label = context.dataset.labels[context.dataIndex];
                                    return `${label}`;
                                }
                            }
                        },
                    }
                }
            };

            Chart.register({
                id: 'customBg',
                beforeDraw: function(chart) {

                    var ctx = chart.ctx;
                    var ruleIndex = 0;
                    var rules = chart.options.backgroundRules;
                    var yaxis = chart.scales.y;
                    var xaxis = chart.scales.x;
                    var partPercentage = 1 / (yaxis.ticks.length - 1);

                    ctx.fillStyle = rules[0].backgroundColor;
                    ctx.fillRect(xaxis.left, yaxis.top, (xaxis.width * partPercentage) * 5, yaxis.height);

                    ctx.fillStyle = rules[1].backgroundColor;
                    ctx.fillRect(xaxis.left + (xaxis.width * partPercentage) * 5, yaxis.top, (xaxis.width * partPercentage) * 5, yaxis.height);

                    ctx.fillStyle = rules[2].backgroundColor;
                    ctx.fillRect(xaxis.left + (((xaxis.width * partPercentage) * 5) * 2), yaxis.top, (xaxis.width * partPercentage) * 4, yaxis.height);

                    ctx.save();

                    ctx.textAlign = "center";
                    ctx.fillStyle = "#000";
                    ctx.font = "bolder 12pt Nunito";

                    ctx.fillText("Redutor", (xaxis.width * partPercentage) * 4, yaxis.bottom - 10);
                    ctx.fillText("Moderadamente Oxidante", (xaxis.width * partPercentage) * 8, yaxis.bottom - 10);
                    ctx.fillText("Oxidante", (xaxis.width * partPercentage) * 13, yaxis.bottom - 10);

                    ctx.restore();

                    ctx.save();

                    var font, text, x, y;

                    text = "Ácido";

                    font = 20;
                    ctx.textAlign = "center";
                    ctx.fillStyle = "#000";
                    ctx.font = "bolder 12pt Nunito";

                    var metrics = ctx.measureText(text);
                    ctx.height = metrics.width;
                    x = font/2;
                    y = metrics.width/2;
                    ctx.fillStyle = 'black';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = "bottom";
                    ctx.save();
                    ctx.translate(x, y);
                    ctx.rotate(-Math.PI / 2);
                    ctx.fillText("Ácido", yaxis.top - 260, (xaxis.width * partPercentage) + 10);
                    ctx.fillText("Neutro", yaxis.top - 180, (xaxis.width * partPercentage) + 10);
                    ctx.fillText("Alcalino", yaxis.top - 70, (xaxis.width * partPercentage) + 10);
                    ctx.zindex = 99999999;
                    ctx.restore();

                },
            });

            var myChart = new Chart(ctx, config);
        });
    </script>

    <x-spin-load />
    <x-back-to-top element="mode_table" />

    <script>
        document.getElementById("filter_default").addEventListener("click", function() {
            document.querySelectorAll(".default-table, .duplicates-table").forEach(item => {
                item.style.display = "block";
            });
            document.querySelectorAll(".duplicate").forEach(item => {
                item.style.display = "none";
            });
        });

        document.getElementById("filter_duplicate").addEventListener("click", function() {
            document.querySelectorAll(".duplicates-table, .duplicate").forEach(item => {
                item.style.display = "block";
            });
            document.querySelectorAll(".default-table").forEach(item => {
                item.style.display = "none";
            });
        });
    </script>

    <script>
        window.addEventListener("load", function() {
            const view_table = localStorage.getItem("view_mode");
            document.getElementById(view_table).click();
        });

        document.getElementById("view_table").addEventListener("click", function() {
            document.querySelectorAll("#mode_table").forEach(item => {
                item.style.display = "block";
            });

            document.querySelectorAll("#mode_sample_table").forEach(item => {
                item.style.display = "none";
            });

            document.querySelectorAll("#mode_list").forEach(item => {
                item.style.display = "none";
            });

            localStorage.setItem("view_mode", "view_table");
        });

        document.getElementById("view_list").addEventListener("click", function() {
            document.querySelectorAll("#mode_table").forEach(item => {
                item.style.display = "none";
            });

            document.querySelectorAll("#mode_sample_table").forEach(item => {
                item.style.display = "none";
            });

            document.querySelectorAll("#mode_list").forEach(item => {
                item.style.display = "block";
            });

            localStorage.setItem("view_mode", "view_list");
        });

        document.getElementById("view_sample_table").addEventListener("click", function() {
            document.querySelectorAll("#mode_table").forEach(item => {
                item.style.display = "none";
            });

            document.querySelectorAll("#mode_sample_table").forEach(item => {
                item.style.display = "block";
            });

            document.querySelectorAll("#mode_list").forEach(item => {
                item.style.display = "none";
            });

            localStorage.setItem("view_mode", "view_sample_table");
        });
    </script>

    <script>
        document.querySelectorAll(".edit-sample").forEach(item =>{
            item.addEventListener("click", function() {
                item.nextElementSibling.style.display = "inline-block";
                item.style.display = "none";
                document.querySelectorAll(`#${this.dataset.index} input`).forEach(item => {
                    item.readOnly = false;
                });
            });
        });

        document.querySelectorAll(".save-sample").forEach(item =>{
            item.addEventListener("click", function() {
                save(this)
            });
        });

        function save(that) {
            document.getElementById("spin_load").classList.remove("hidden");
            let ajax = new XMLHttpRequest();
            let url = "{!! route('fields.forms.save-sample') !!}";
            let token = document.querySelector('meta[name="csrf-token"]').content;
            let method = 'POST';
            let files = that.files;
            let form_value_id = document.querySelector(`#${that.dataset.index} #form_value_id`).value;
            let sample_index = document.querySelector(`#${that.dataset.index} #sample_index`).value;

            let equipment = document.querySelector(`#${that.dataset.index} #equipment`).value;
            let point = document.querySelector(`#${that.dataset.index} #point`).value;
            let environment = document.querySelector(`#${that.dataset.index} #environment`).value;
            let collect = document.querySelector(`#${that.dataset.index} #collect`).value;

            const results = [...document.querySelectorAll(`#${that.dataset.index} #table_result input`)];

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
        }

        function deleteSample(that) {
            document.getElementById("spin_load").classList.remove("hidden");
            let ajax = new XMLHttpRequest();
            let url = "{!! route('fields.forms.delete-sample') !!}";
            let token = document.querySelector('meta[name="csrf-token"]').content;
            let method = 'POST';
            let files = that.files;
            let form_value_id = document.querySelector(`#${that.dataset.index} #form_value_id`).value;
            let sample_index = document.querySelector(`#${that.dataset.index} #sample_index`).value;

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
            data.append('form_value_id', form_value_id);
            data.append('sample_index', sample_index);

            ajax.send(data);
        }
    </script>

    <script>
        document.getElementById("help").addEventListener("click", function() {
            var modal = document.getElementById("modal");
            modal.classList.remove("hidden");
            modal.classList.add("block");
        });

        document.getElementById("cancel_delete_modal").addEventListener("click", function() {
            var modal = document.getElementById("modal");
            modal.classList.add("hidden");
            modal.classList.remove("block");
        });


        document.querySelectorAll(".remove-sample").forEach(item =>{
            item.addEventListener("click", function() {
                var modal = document.getElementById("delete_modal");
                modal.classList.remove("hidden");
                modal.classList.add("block");
                document.querySelector("#confirm_delete_modal").dataset.index = this.dataset.index;
            });
        });

        document.querySelector("#confirm_delete_modal").addEventListener("click", function() {
            deleteSample(this);
        });

        document.getElementById("confirm_modal").addEventListener("click", function(e) {
            var modal = document.getElementById("modal");
            modal.classList.add("hidden");
        });

        document.querySelectorAll(".import-sample-result").forEach(item =>{
            item.addEventListener("click", function() {
                document.querySelector(`#${this.dataset.index} #file`).click();
            });
        });

        document.querySelectorAll(".sample #file").forEach(item =>{
            item.addEventListener("change", function(e) {
                upload(this);
            });
        });

        function upload(that)  {
            document.getElementById("spin_load").classList.remove("hidden");

            let ajax = new XMLHttpRequest();
            let url = "{!! route('fields.forms.import') !!}";
            let token = document.querySelector('meta[name="csrf-token"]').content;
            let method = 'POST';
            let files = that.files;
            let form_value_id = document.querySelector(`#${that.dataset.index} #form_value_id`).value;
            let sample_index = document.querySelector(`#${that.dataset.index} #sample_index`).value;

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
        }
    </script>

    <script>
        document.querySelectorAll(`.add-sample`).forEach(item =>{
           item.addEventListener("click", function() {
                addInput();
           })
        });

        function addInput() {
            const nodes = document.querySelectorAll(".sample");
            const node = nodes[nodes.length - 1];
            const clone = node.cloneNode(true);
            const num = parseInt( clone.id.match(/\d+/g), 10 ) +1;
            const id = `sample_${num}`;
            clone.id = id;

            clone.innerHTML = clone.innerHTML.replaceAll(`row_${num-1}`, `row_${num}`);
            clone.innerHTML = clone.innerHTML.replaceAll(`sample_${num-1}`, `sample_${num}`);
            clone.innerHTML = clone.innerHTML.replaceAll(`AMOSTRA <span>${num-1}</span>`, `AMOSTRA <span>${num}</span>`);

            clone.querySelectorAll("#table_result tr").forEach(item => {
                item.remove();
            });

            document.getElementById("samples").appendChild(clone);

            document.querySelectorAll(`#${id} input:not(#form_value_id):not(#sample_index)`).forEach(item =>{
                item.value = "";
                item.disabled = false;
                document.querySelector(`#${id} .save-sample`).style.display = "inline-block";
                document.querySelector(`#${id} .edit-sample`).style.display = "none";
            });

            document.querySelectorAll(`#${id} tfoot td`).forEach(item =>{
                item.innerHTML = "";
            });

            document.querySelector(`#${id} .remove-sample`).style.display = "block";

            document.querySelector(`#${id} .remove-sample`).addEventListener("click", function() {
                var modal = document.getElementById("delete_modal");
                modal.classList.remove("hidden");
                modal.classList.add("block");
                document.querySelector("#confirm_delete_modal").dataset.index = this.dataset.index;
            });

            document.querySelector(`#${id} .add-sample`).addEventListener("click", function() {
                addInput();
            });

            document.querySelectorAll(`#${id} .import-sample-result`).forEach(item =>{
                item.addEventListener("click", function() {
                    document.querySelector(`#${this.dataset.index} #file`).click();
                });
            });

            document.querySelector(`#${id} #file`).addEventListener("click", function() {
                upload(this);
            });

            document.querySelectorAll(`#${id} .edit-sample`).forEach(item =>{
                item.addEventListener("click", function() {
                    item.nextElementSibling.style.display = "inline-block";
                    item.style.display = "none";
                    document.querySelectorAll(`#${this.dataset.index} input`).forEach(item => {
                        item.disabled = false;
                    });
                });
            });

            document.querySelectorAll(`#${id} .save-sample`).forEach(item =>{
                item.addEventListener("click", function() {
                    save(this)
                });
            });

        }

    </script>

</x-app-layout>
