<x-app-layout>
    <div class="py-6 ref">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="@if(!$formValue) {{ route('fields.form-values.store') }} @else {{ route('fields.form-values.update', ['form_value' => $formValue->id]) }} @endif" id="form_form">
                @csrf
                @if(!$formValue) @method("POST") @endif
                @if($formValue) @method("PUT") @endif

                @if($formValue)
                    <input type="hidden" id="form_value_id" name="form_value_id" value="{{ $formValue->id }}">
                @endif

                <input type="hidden" id="form_id" name="form_id" value="{{ $form->id }}">

                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Formulário')}}  {{ $form->name }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success" id="save_form">{{ __('Salvar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('fields.form-values.index') }}" class="btn-outline-danger">{{ __('Voltar') }}</a>
                        </div>
                        @if($formValue)
                            <div class="m-2">
                                <a href="{{ route('fields.form-values.print', ['form_value' => $formValue->id, 'project_id' => isset($formValue) ? $formValue->values['project_id'] : '' . ".pdf"]) }}" target="_blank" class="btn-outline-info">{{ __('Imprimir') }}</a>
                            </div>
                            <div class="m-2">
                                <a href="{{ route('fields.form-values.signer', ['form_value' => $formValue->id, 'project_id' => isset($formValue) ? $formValue->values['project_id'] : '' . ".pdf"]) }}" target="_blank" class="btn-outline-info">{{ __('Assinar') }}</a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <h1 class="w-full md:w-1/2 px-3 mb-6 md:mb-0"></h1>
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
                            <x-jet-input id="project_id" class="form-control block mt-1 w-full" type="text" name="project_id" maxlength="255" value="{{ isset($formValue) ? $formValue->values['project_id'] : old('project_id') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="client" value="{{ __('Cliente') }}" />
                            <x-custom-select :options="$customers" value="{{ isset($formValue->values['client']) ? $formValue->values['client'] : null }}" name="client" id="client" class="mt-1"/>
                        </div>
                    </div>

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="matrix" value="{{ __('Matriz') }}" />
                            <x-custom-select :options="$fields" value="{{ isset($formValue->values['matrix']) ? $formValue->values['matrix'] : null }}" name="matrix" id="matrix" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="emission" value="{{ __('Data/Hora da Emissão do Relatório') }}" />
                            <x-jet-input id="emission" class="form-control block mt-1 w-full" type="datetime-local" value="{{ isset($formValue->values['emission']) ? $formValue->values['emission'] : null }}" name="emission"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="responsible" value="{{ __('Responsável') }}" />
                            <x-custom-select :options="$users" value="{{ isset($formValue->values['responsible']) ? $formValue->values['responsible'] : null }}" name="responsible" id="responsible" class="mt-1"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0 grid gap-1 grid-cols-2">
                            <label for="turbidity" class="flex items-center">
                                <input id="turbidity" type="checkbox" class="form-checkbox" name="turbidity" value="true" @if(isset($formValue->values['turbidity'])) checked @endif>
                                <span class="ml-2 text-sm text-gray-600">{{ __('Turbidez?') }}</span>
                            </label>
                            <label for="accreditation" class="flex items-center">
                                <input id="accreditation" type="checkbox" class="form-checkbox" name="accreditation" value="true" @if(isset($formValue->values['accreditation'])) checked @endif>
                                <span class="ml-2 text-sm text-gray-600">{{ __('Acreditado?') }}</span>
                            </label>
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
                                <button type="button" class="btn-transition-primary import-samples px-1" title="Importar Amostras" data-index="sample_{{ isset($i) ? $i : 0 }}" data-row="{{ isset($i) ? $i : 0 }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-wiph="1.5" stroke="currentColor" class="h-8 w-8 text-green-900">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" />
                                    </svg>
                                </button>
                                <input type="file" name="files[]" id="files" multiple accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet|application/vnd.ms-excel" class="hidden">
                            </div>
                        </div>

                        <div class="border-b border-gray-200 dark:border-gray-700 flex px-3 w-full my-4">
                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400" style="width:70%" id="filter_samples">
                                <li class="mr-2">
                                    <a href="#" data-status="default" id="filter_default" class="active inline-flex p-4 border-b-2 border-green-900 rounded-t-lg  dark:text-blue-500 dark:border-blue-500 active" aria-current="page">
                                        Dados
                                    </a>
                                </li>
                                @if($formValue)
                                    <li class="mr-2">
                                        <a href="#" data-status="duplicates" id="filter_duplicate" class="inline-flex p-4 border-b-2 rounded-t-lg  dark:text-blue-500 dark:border-blue-500" >
                                            Duplicatas
                                        </a>
                                    </li>
                                @endif
                            </ul>
                            <div class="flex justify-end" style="width:30%" id="search_container">
                                <div class="py-2 m-2 flex md:justify-end justify-start w-full" x-data="{ shearch: false }">
                                    <div class="w-full block" id="search-content">
                                        <div class="container mx-auto">
                                            <input id="q" name="q" type="search" placeholder="Buscar.."
                                                autofocus="autofocus" class="filter-field w-full form-control no-border">
                                        </div>
                                    </div>
                                    <div class="ml-2">
                                        <button type="button" id="search_sample"
                                            class="w-full block btn-transition-secondary filter-field">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <button type="button" class="btn-transition-primary" title="Ajustar Condições Ambientais"id="environment_edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div id="mode_table" class="w-full">
                            <h3 class="w-full md:w-1/2 px-3 mb-6 md:mb-0">RESULTADOS DOS PARÂMETROS FÍSICO-QUÍMICOS - DADOS</h3>
                            @if(isset($formValue->values['samples']) && count($formValue->values['samples']) > 0)
                                @php $amostraIndex = 1; @endphp
                                @foreach ($formValue->values['samples'] as $key => $sample)
                                    @include('form-values.RT-LAB-041-191.sample', ['sample' => $sample, 'i' => Str::replace('row_', '', $key), 'amostraIndex' => $amostraIndex])
                                    @php $amostraIndex++; @endphp
                                @endforeach
                            @else
                                @include('form-values.RT-LAB-041-191.sample')
                            @endif
                        </div>

                        <div id="mode_list" class="w-full" style="display: none">
                            <h3 class="w-full md:w-1/2 px-3 mb-6 md:mb-0">TABELA DOS PARÂMETROS FÍSICO-QUÍMICOS - FINAL</h3>
                            <div id="sample_list_container">
                                @if(isset($formValue->values['samples']) && count($formValue->values['samples']) > 0)
                                    @include('form-values.RT-LAB-041-191.sample-list', ['count' => 3, 'type' => 'default', 'samples' => $formValue->values['samples']])
                                @endif
                            </div>

                            <div class="w-5/6 items-center flex">
                                <p class="text-sm text-gray-700 leading-5 m-0 inline-flex">
                                    Mostrando
                                    <div class="w-24 inline-flex ml-1 mr-1">
                                        <x-custom-select data-reverse="true" select-class="no-nice-select" :options="[3 => 3, 5 => 5, 10 => 10]" name="mode_list_count" id="mode_list_count" :value="3"/>
                                    </div>
                                    <span class="text-sm text-gray-700 leading-5 m-0 inline-flex">colunas por linha</span>
                                </p>
                            </div>
                        </div>

                        <div id="mode_sample_table" class="w-full" style="display: none">
                            <h3 class="w-full md:w-1/2 px-3 mb-6 md:mb-0">TABELA DOS PARÂMETROS FÍSICO-QUÍMICOS - RELATÓRIO</h3>
                            @if(isset($formValue->values['samples']) && count($formValue->values['samples']) > 0)
                                @for ($i = 0; $i < count($formValue->values['samples']); $i++)
                                    @if(isset($formValue->values['samples']["row_$i"]))  @include('form-values.RT-LAB-041-191.sample-table', ['sample' => $formValue->values['samples']["row_$i"]]) @endif
                                @endfor
                            @endif
                        </div>

                        <div id="mode_sample_char" style="display: none" class="w-full">
                            <div id="sample_chart_container">
                                @if(isset($formValue->values['samples']) && count($formValue->values['samples']) > 0)
                                    @include('form-values.RT-LAB-041-191.sample-chart', ['count' => 5, 'type' => 'default'])
                                @endif
                            </div>
                            <div class="w-5/6 items-center flex mt-5">
                                <p class="text-sm text-gray-700 leading-5 m-0 inline-flex">
                                    Mostrando
                                    <div class="w-24 inline-flex ml-1 mr-1">
                                        <x-custom-select data-reverse="true" select-class="no-nice-select" :options="[3 => 3, 5 => 5, 10 => 10]" name="mode_chart_count" id="mode_chart_count" :value="5"/>
                                    </div>
                                    <span class="text-sm text-gray-700 leading-5 m-0 inline-flex">colunas por linha</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    @include('form-values.RT-LAB-041-191.coordinates-table')

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4" id="mode_considerations" style="display: none">
                        <div class="w-full px-3 mb-6 md:mb-0 justify-start flex mt-2" id="coodinates_button">
                            <h3 class="w-full md:w-1/2 mb-6 md:mb-0">CONSIDERAÇÕES</h3>
                        </div>
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


    @include('form-values.infos-modal')
    @include('form-values.delete-modal')
    @include("form-values.RT-LAB-041-191.environment-modal")
    @include("form-values.RT-LAB-041-191.scripts")

</x-app-layout>
