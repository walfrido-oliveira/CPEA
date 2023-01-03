<x-app-layout>
    <div class="py-6 ref">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="@if(!$formValue) {{ route('fields.forms.store') }} @else {{ route('fields.forms.update', ['form_value' => $formValue->id]) }} @endif">
                @csrf
                @if(!$formValue) @method("POST") @endif
                @if($formValue) @method("PUT") @endif

                @if($formValue)
                    <input type="hidden" id="form_value_id" name="form_value_id" value="{{ $formValue->id }}">
                @endif

                <input type="hidden" id="form_id" name="form_id" value="{{ $form->id }}">

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

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="emission" value="{{ __('Data/Hora da Emissão do Relatório') }}" />
                            <x-jet-input id="emission" class="form-control block mt-1 w-full" type="datetime-local" value="{{ isset($formValue->values['emission']) ? $formValue->values['emission'] : null }}" name="emission"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="responsible" value="{{ __('Responsável') }}" />
                            <x-custom-select :options="\App\Models\User::all()->pluck('full_name', 'full_name')" value="{{ isset($formValue->values['responsible']) ? $formValue->values['responsible'] : null }}" name="responsible" id="responsible" class="mt-1"/>
                        </div>
                    </div>

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4" id="samples">
                        <div class="flex w-full flex-wrap">
                            <h2 class="w-full md:w-1/2 px-3 mb-6 md:mb-0">AMOSTRAS</h2>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 flex justify-end align-baseline" style="align-items: baseline;">
                                <button type="button" id="view_table" class="btn-transition-primary px-1" title="TABELA DOS PARÂMETROS FÍSICO-QUÍMICOS - DADOS">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 text-green-900">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0112 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" />
                                    </svg>
                                </button>
                                <button type="button" id="view_list" class="btn-transition-primary px-1" title="RESULTADOS DOS PARÂMETROS FÍSICO-QUÍMICOS - FINAL">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 text-blue-900">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                </button>
                                <button type="button" id="view_sample_table" class="btn-transition-primary px-1" title="RESULTADOS DOS PARÂMETROS FÍSICO-QUÍMICOS - RELATÓRIO">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 text-green-900">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" />
                                    </svg>
                                </button>
                                <button type="button" id="view_chart" class="btn-transition-primary px-1" title="GRÁFICO pH x EH">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 text-blue-500">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
                                    </svg>
                                </button>
                                <button type="button" class="btn-transition-primary coordinates px-1" id="view_coordinates" title="COORDENADAS">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 text-blue-900">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                </button>
                                <button type="button" id="view_considerations" class="btn-transition-primary px-1" title="CONSIDERAÇÕES">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="w-full px-3 mb-6 md:mb-0 justify-end flex mt-2">
                                <button type="button" class="btn-transition-primary edit-coordinate px-1" title="Editar Coodernada" style="margin-top: 0.2rem;">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-wiph="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <input type="file" name="file_coordinates" id="file_coordinates" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet|application/vnd.ms-excel" class="hidden">
                                <button type="button" class="btn-transition-primary import-sample-coordinates px-1" title="Importar Coodernadas">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-wiph="1.5" stroke="currentColor" class="h-8 w-8 text-blue-900">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        @if(isset($formValue->values['samples']) && count($formValue->values['samples']) > 0)
                            <div id="mode_table" class="w-full">
                                <h3 class="w-full md:w-1/2 px-3 mb-6 md:mb-0">RESULTADOS DOS PARÂMETROS FÍSICO-QUÍMICOS - DADOS</h3>
                                @for ($i = 0; $i < count($formValue->values['samples']); $i++)
                                    @include('form.sample', ['sample' => $formValue->values['samples']["row_$i"]])
                                @endfor
                            </div>
                            <div id="mode_list" class="w-full">
                                <h3 class="w-full md:w-1/2 px-3 mb-6 md:mb-0">TABELA DOS PARÂMETROS FÍSICO-QUÍMICOS - FINAL</h3>
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
                            <div id="mode_sample_table" class="w-full">
                                <h3 class="w-full md:w-1/2 px-3 mb-6 md:mb-0">TABELA DOS PARÂMETROS FÍSICO-QUÍMICOS - RELATÓRIO</h3>
                                @for ($i = 0; $i < count($formValue->values['samples']); $i++)
                                    @include('form.sample-table', ['sample' => $formValue->values['samples']["row_$i"]])
                                @endfor
                            </div>
                            <div class="block w-full" id="chart">
                              <h3 class="w-full md:w-1/2 px-3 mb-6 md:mb-0">GRÁFICO pH x EH</h3>
                              <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                  <canvas id="myChart" width="800" height="400" style="display: block; box-sizing: border-box; height: 400px; width: 800px; max-height: 400px"></canvas>
                              </div>
                              <div class="flex flex-wrap mt-2 w-full">
                                @foreach (array_chunk($formValue->values['samples'], 5) as $key => $sample)
                                  <div class="grid mt-4 w-full" style="grid-template-columns: repeat(6, 1fr);">
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
                                              <p style="background-color: #FFF; margin-left: -12px; margin-right: -12px; margin-top: 8px; margin-bottom: 8px; height: 8px">&nbsp;</p>
                                              <p class="font-bold">
                                                  {{ isset($svgs['row_' . ($i)]['ph']) ? number_format($svgs['row_' . ($i)]['ph'], 1, ",", ".") : '' }}
                                              </p>
                                              <p class="font-bold">
                                                  {{ isset($svgs['row_' . ($i)]['eh']) ? number_format($svgs['row_' . ($i)]['eh'], 0, ",", ".") : '' }}
                                              </p>
                                          </div>
                                      @endfor
                                  </div>
                                @endforeach
                          </div>
                        @else
                            @include('form.sample')
                        @endif

                    </div>

                    @include('form.coordinates-table')

                    <div class="flex flex-wrap mt-2 w-full flex-col" id="mode_considerations" style="display: none">
                        <h3 class="w-full md:w-1/2 px-3 mb-6 md:mb-0">CONSIDERAÇÕES</h3>
                        <div class="flex flex-wrap mt-4">
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <x-jet-label for="additional_info" value="{{ __('Informações Adicionais') }}" />
                                <textarea class="editor form-input w-full ckeditor" name="additional_info" id="additional_info" cols="30" rows="10">{{ isset($formValue->values['additional_info']) ? $formValue->values['additional_info'] : null }}</textarea>
                            </div>
                        </div>

                        <div class="flex flex-wrap mt-4">
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <x-jet-label for="approval_text" value="{{ __('Aprovação do Relatório') }}" />
                                <textarea class="form-input w-full ckeditor" name="approval_text" id="approval_text" cols="30" rows="10">{{ isset($formValue->values['approval_text']) ? $formValue->values['approval_text'] : null }}</textarea>
                            </div>
                        </div>
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

    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>

    <script type="text/javascript">
        CKEDITOR.replace('editor', {
            filebrowserUploadUrl: "{{route('image-upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
    </script>

    <script>
        window.addEventListener("load", function() {
            var ctx = document.getElementById('myChart').getContext('2d');
            const data = {
                datasets: [{
                    labels: [
                        @if($formValue)
                            @foreach ($formValue->values['samples'] as $key => $sample)
                                "{{ $sample['point'] }} - pH {{ isset($svgs[$key]['ph']) ? number_format($svgs[$key]['ph'], 2, ",", ".") : '' }} e EH {{ isset($svgs[$key]['eh']) ? number_format($svgs[$key]['eh'], 1, ",", ".") : '' }}",
                            @endforeach
                        @endif
                    ],
                    label: '',
                    data: [
                        @if($formValue)
                            @foreach ($formValue->values['samples'] as $key => $sample)
                                { x: {{ isset($svgs[$key]['eh']) ? $svgs[$key]['eh'] : 0  }} , y: {{ isset($svgs[$key]['ph']) ? $svgs[$key]['ph'] : 0  }} },
                            @endforeach
                        @endif
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

            document.querySelectorAll("#chart").forEach(item => {
                item.style.display = "none";
            });

            document.querySelectorAll("#mode_coordinates_table").forEach(item => {
                item.style.display = "none";
            });

            document.querySelectorAll("#mode_considerations").forEach(item => {
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

            document.querySelectorAll("#chart").forEach(item => {
                item.style.display = "none";
            });

            document.querySelectorAll("#mode_coordinates_table").forEach(item => {
                item.style.display = "none";
            });

            document.querySelectorAll("#mode_considerations").forEach(item => {
                item.style.display = "none";
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

            document.querySelectorAll("#chart").forEach(item => {
                item.style.display = "none";
            });

            document.querySelectorAll("#mode_coordinates_table").forEach(item => {
                item.style.display = "none";
            });

            document.querySelectorAll("#mode_considerations").forEach(item => {
                item.style.display = "none";
            });

            localStorage.setItem("view_mode", "view_sample_table");
        });

        document.getElementById("view_chart").addEventListener("click", function() {
          document.querySelectorAll("#mode_table").forEach(item => {
                item.style.display = "none";
            });

            document.querySelectorAll("#mode_sample_table").forEach(item => {
                item.style.display = "none";
            });

            document.querySelectorAll("#mode_list").forEach(item => {
                item.style.display = "none";
            });

            document.querySelectorAll("#chart").forEach(item => {
                item.style.display = "block";
            });

            document.querySelectorAll("#mode_coordinates_table").forEach(item => {
                item.style.display = "none";
            });

            document.querySelectorAll("#mode_considerations").forEach(item => {
                item.style.display = "none";
            });

            localStorage.setItem("view_mode", "view_chart");

        });

        document.getElementById("view_coordinates").addEventListener("click", function() {
          document.querySelectorAll("#mode_table").forEach(item => {
                item.style.display = "none";
            });

            document.querySelectorAll("#mode_sample_table").forEach(item => {
                item.style.display = "none";
            });

            document.querySelectorAll("#mode_list").forEach(item => {
                item.style.display = "none";
            });

            document.querySelectorAll("#chart").forEach(item => {
                item.style.display = "none";
            });

            document.querySelectorAll("#mode_coordinates_table").forEach(item => {
                item.style.display = "block";
            });

            document.querySelectorAll("#mode_considerations").forEach(item => {
                item.style.display = "none";
            });

            localStorage.setItem("view_mode", "view_coordinates");

        });

        document.getElementById("view_considerations").addEventListener("click", function() {
          document.querySelectorAll("#mode_table").forEach(item => {
                item.style.display = "none";
            });

            document.querySelectorAll("#mode_sample_table").forEach(item => {
                item.style.display = "none";
            });

            document.querySelectorAll("#mode_list").forEach(item => {
                item.style.display = "none";
            });

            document.querySelectorAll("#chart").forEach(item => {
                item.style.display = "none";
            });

            document.querySelectorAll("#mode_coordinates_table").forEach(item => {
                item.style.display = "none";
            });

            document.querySelectorAll("#mode_considerations").forEach(item => {
                item.style.display = "block";
            });

            localStorage.setItem("view_mode", "view_considerations");

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
            let form_value_id = document.querySelector(`#form_value_id`).value;
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
            let form_value_id = document.querySelector(`#form_value_id`).value;
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
                uploadResults(this);
            });
        });

        document.querySelectorAll(".import-sample-coordinates").forEach(item =>{
            item.addEventListener("click", function() {
                document.querySelector(`#file_coordinates`).click();
            });
        });

        document.querySelectorAll("#file_coordinates").forEach(item =>{
            item.addEventListener("change", function(e) {
                uploadCoordinates(this);
            });
        });

        function uploadCoordinates(that)  {
            document.getElementById("spin_load").classList.remove("hidden");

            let ajax = new XMLHttpRequest();
            let url = "{!! route('fields.forms.import-coordinates') !!}";
            let token = document.querySelector('meta[name="csrf-token"]').content;
            let method = 'POST';
            let files = that.files;
            let form_value_id = document.querySelector(`#form_value_id`).value;

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

            ajax.send(data);
        }

        function uploadResults(that)  {
            document.getElementById("spin_load").classList.remove("hidden");

            let ajax = new XMLHttpRequest();
            let url = "{!! route('fields.forms.import') !!}";
            let token = document.querySelector('meta[name="csrf-token"]').content;
            let method = 'POST';
            let files = that.files;
            let form_value_id = document.querySelector(`#form_value_id`).value;
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
                uploadResults(this);
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
