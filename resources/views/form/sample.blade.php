<div class="w-full px-3 mt-4 mb-6 md:mb-0 flex flex-wrap sample @if(isset($sample))@if(count(array_chunk($sample['results'], 3)) > 1) duplicates-table @else default-table @endif default-table @endif" id="sample_{{ isset($i) ? $i : 0 }}" data-index="1">
    <div class="flex w-full">
        <h3 class="w-full mt-4 mb-6 md:mb-0 title">AMOSTRA <span>{{ isset($i) ? $i + 1 : 1 }}</span></h3>
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 flex justify-end align-baseline buttons" style="align-items: baseline;">
            <button class="add-sample btn-transition-primary px-1" type="button" title="Adicionar Amostra">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-900" fill="none" viewBox="0 0 24 24" stroke-wiph="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
            <button type="button" class="btn-transition-primary remove-sample px-1" title="Remover Amostra" style="{{ isset($i) ? '': 'display:none' }}" data-index="sample_{{ isset($i) ? $i : 0 }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-wiph="1.5" stroke="currentColor" class="h-8 w-8 text-red-900">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
            @if(isset($formValue))
                <div id="import_result_form_row_{{ isset($i) ? $i : 0 }}" class="">
                    <input type="hidden" id="sample_index" name="sample_index" value="row_{{ isset($i) ? $i : 0 }}">
                    <button type="button" class="btn-transition-primary import-sample-result px-1" title="Importar Amostra" data-index="sample_{{ isset($i) ? $i : 0 }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-wiph="1.5" stroke="currentColor" class="h-8 w-8 text-blue-900">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" />
                        </svg>
                    </button>
                    <input type="file" name="file" id="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet|application/vnd.ms-excel" class="hidden" data-index="import_result_form_row_{{ isset($i) ? $i : 0 }}">
                    <button type="button" class="btn-transition-primary edit-sample px-1" title="Editar Amostra" data-index="sample_{{ isset($i) ? $i : 0 }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-wiph="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </button>
                    <button type="button" class="btn-transition-primary save-sample px-1" title="Salvar Amostra" data-index="sample_{{ isset($i) ? $i : 0 }}" style="display: none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-8 w-8">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-wiph="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </button>
                </div>
            @endif
        </div>
    </div>
    <div class="inputs w-full">
        <div class="flex flex-wrap mt-2 w-full">
            <div class="w-full md:w-1/2 pr-3 mb-6 md:mb-0">
                <x-jet-label for="equipment" value="{{ __('Equipamento') }}" />
                @if(isset($sample['equipment']))
                    <x-jet-input readonly="{{ !$formValue ? false : true}}" id="equipment" class="form-control block mt-1 w-full"
                    type="text" value="{{ $sample['equipment'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][equipment]' : 'samples[row_0][equipment]' }}" maxlength="255" />
                @else
                    <x-jet-input id="equipment" class="form-control block mt-1 w-full"
                    type="text" value="" name="samples[row_0][equipment]" maxlength="255" />
                @endif
            </div>
            <div class="w-full md:w-1/2 pr-3 mb-6 md:mb-0">
                <x-jet-label for="point" value="{{ __('Ponto de Coleta') }}" />
                @if(isset($sample['point']))
                    <x-jet-input readonly="{{ !$formValue ? false : true}}" id="point" class="form-control block mt-1 w-full"
                    type="text" value="{{ $sample['point'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][point]' : 'samples[row_0][point]' }}" maxlength="255" />
                @else
                    <x-jet-input id="point" class="form-control block mt-1 w-full"
                    type="text" value="" name="samples[row_0][point]" maxlength="255" />
                @endif
            </div>
        </div>
        <div class="flex flex-wrap mt-2 w-full">
            <div class="w-full md:w-1/2 pr-3 mb-6 md:mb-0">
                <x-jet-label for="environment" value="{{ __('Condições ambientais nas últimas 24 hs') }}" />
                @if(isset($sample['environment']))
                    <x-jet-input readonly="{{ !$formValue ? false : true}}" id="environment" class="form-control block mt-1 w-full"
                    type="text" value="{{ $sample['environment'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][environment]' : 'samples[row_0][environment]' }}" maxlength="255" />
                @else
                    <x-jet-input id="environment" class="form-control block mt-1 w-full"
                    type="text" value="" name="samples[row_0][environment]" maxlength="255" />
                @endif
            </div>
            <div class="w-full md:w-1/2 pr-3 mb-6 md:mb-0">
                <x-jet-label for="collect" value="{{ __('DT/HR da Coleta') }}" />
                @if(isset($sample['collect']))
                    <x-jet-input readonly="{{ !$formValue ? false : true}}" id="collect" class="form-control block mt-1 w-full"
                    type="datetime-local" value="{{ $sample['collect'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][collect]' : 'samples[row_0][collect]' }}" maxlength="255" />
                @else
                    <x-jet-input id="collect" class="form-control block mt-1 w-full"
                    type="datetime-local" value="" name="samples[row_0][collect]" maxlength="255" />
                @endif
            </div>
        </div>
    </div>
    @if(isset($sample['results']))
        <div class="flex flex-wrap mt-2 w-full mode-table">
            <div class="w-full">
                <table class="table table-responsive md:table w-full">
                    <thead>
                        <tr class="thead-light">
                            <x-table-sort-header :orderBy="null" :ascending="null" columnName="temperature" columnText="{{ __('Temperatura ºC') }}"/>
                            <x-table-sort-header :orderBy="null" :ascending="null" columnName="ph" columnText="{{ __('pH') }}"/>
                            <x-table-sort-header :orderBy="null" :ascending="null" columnName="orp" columnText="{{ __('ORP (mV)') }}"/>
                            <x-table-sort-header :orderBy="null" :ascending="null" columnName="conductivity" columnText="{{ __('Condutividade') }}"/>
                            <x-table-sort-header :orderBy="null" :ascending="null" columnName="salinity" columnText="{{ __('Salinidade') }}"/>
                            <x-table-sort-header :orderBy="null" :ascending="null" columnName="psi" columnText="{{ __('Press.[psi]') }}"/>
                            <x-table-sort-header :orderBy="null" :ascending="null" columnName="sat" columnText="{{ __('Oxigênio Dissolvido (sat) (%)') }}"/>
                            <x-table-sort-header :orderBy="null" :ascending="null" columnName="conc" columnText="{{ __('Oxigênio Dissolvido (conc) (mg/L)') }}"/>
                            <x-table-sort-header :orderBy="null" :ascending="null" columnName="eh" columnText="{{ __('EH (mV)') }}"/>
                            <x-table-sort-header :orderBy="null" :ascending="null" columnName="ntu" columnText="{{ __('Turbidez (NTU)') }}"/>
                            <x-table-sort-header :orderBy="null" :ascending="null" columnName="uncertainty" columnText="{{ __('Incerteza') }}"/>
                        </tr>
                    </thead>
                    <tbody id="table_result">
                        @foreach (array_chunk($sample['results'], 3)[0] as $key => $value)
                            <tr>
                                <td>
                                    <x-jet-input readonly="true" id="temperature" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['temperature']) ? number_format($value['temperature'], 2) : ''}}"
                                    name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][temperature]' : 'samples[row_0][results]['. $key . '][temperature]' }}" step="any" />
                                </td>
                                <td>
                                    <x-jet-input readonly="true" id="ph" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['ph']) ? number_format($value['ph'], 2) : ''}}"
                                    name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][ph]' : 'samples[row_0][results]['. $key . '][ph]' }}" step="any" />
                                </td>
                                <td>
                                    <x-jet-input readonly="true" id="orp" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['orp']) ? number_format($value['orp'], 1) : ''}}"
                                    name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][orp]' : 'samples[row_0][results]['. $key . '][orp]' }}" step="any" />
                                </td>
                                <td>
                                    <x-jet-input readonly="true" id="conductivity" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['conductivity']) ? number_format($value['conductivity'], 3, '.', '') : ''}}"
                                    name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][conductivity]' : 'samples[row_0][results]['. $key . '][conductivity]' }}" step="any" />
                                </td>
                                <td>
                                    <x-jet-input readonly="true" id="salinity" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['salinity']) ? number_format($value['salinity'], 3) : ''}}"
                                    name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][salinity]' : 'samples[row_0][results]['. $key . '][salinity]' }}" step="any" />
                                </td>
                                <td>
                                    <x-jet-input readonly="true" id="psi" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['psi']) ? number_format($value['psi'], 3) : ''}}"
                                    name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][psi]' : 'samples[row_0][results]['. $key . '][psi]' }}" step="any" />
                                </td>
                                <td>
                                    <x-jet-input readonly="true" id="sat" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['sat']) ? number_format($value['sat'], 1) : ''}}"
                                    name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][sat]' : 'samples[row_0][results]['. $key . '][sat]' }}" step="any" />
                                </td>
                                <td><x-jet-input readonly="true" id="conc" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['conc']) ? number_format($value['conc'], 3) : ''}}"
                                    name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][conc]' : 'samples[row_0][results]['. $key . '][conc]' }}" step="any" />
                                </td>
                                <td>
                                    <x-jet-input readonly="true" id="eh" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['eh']) ? number_format($value['eh'], 1) : ''}}"
                                    name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][eh]' : 'samples[row_0][results]['. $key . '][eh]' }}" step="any" />
                                </td>
                                <td>
                                    <x-jet-input readonly="true" id="ntu" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['ntu']) ? number_format($value['ntu'], 1) : ''}}"
                                    name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][ntu]' : 'samples[row_0][results]['. $key . '][ntu]' }}" step="any" />
                                </td>
                                <td>
                                    <x-jet-input readonly="true" id="uncertainty" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['uncertainty']) ? number_format($value['uncertainty'], 1) : ''}}"
                                    name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][uncertainty]' : 'samples[row_0][results]['. $key . '][uncertainty]' }}" step="any" />
                                </td>
                            <tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>
                                @if(isset($value['temperature']))
                                    {{ number_format($svgs['row_' . ($i)]['temperature'], 2, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if(isset($value['ph']))
                                    {{ number_format($svgs['row_' . ($i)]['ph'], 2, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if(isset($value['orp']))
                                    {{ number_format($svgs['row_' . ($i)]['orp'], 1, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if(isset($value['conductivity']))
                                    {{ number_format($svgs['row_' . ($i)]['conductivity'], 3, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if(isset($value['salinity']))
                                    {{ number_format($svgs['row_' . ($i)]['salinity'], 3, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                               -
                            </td>
                            <td>
                                @if(isset($value['sat']))
                                    {{ number_format($svgs['row_' . ($i)]['sat'], 1, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if(isset($value['conc']))
                                    {{ number_format($svgs['row_' . ($i)]['conc'], 3, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                -
                            </td>
                            <td>
                                @if(isset($value['ntu']))
                                    {{ number_format($svgs['row_' . ($i)]['ntu'], 1, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>-</td>
                        <tr>
                    </tfoot>
                </table>
            </div>
            @if (isset(array_chunk($sample['results'], 3)[1]))
                <div class="w-full mt-2 duplicate" style="display: none;">
                    <h2 class="text-center text-white opacity-100 p-2 w-full" style="background-color: rgb(0, 94, 16)">DUPLICATA</h2>
                    <table class="table table-responsive md:table w-full">
                        <thead>
                            <tr class="thead-light">
                                <x-table-sort-header :orderBy="null" :ascending="null" columnName="temperature" columnText="{{ __('Temperatura ºC') }}"/>
                                <x-table-sort-header :orderBy="null" :ascending="null" columnName="ph" columnText="{{ __('pH') }}"/>
                                <x-table-sort-header :orderBy="null" :ascending="null" columnName="orp" columnText="{{ __('ORP (mV)') }}"/>
                                <x-table-sort-header :orderBy="null" :ascending="null" columnName="conductivity" columnText="{{ __('Condutividade') }}"/>
                                <x-table-sort-header :orderBy="null" :ascending="null" columnName="salinity" columnText="{{ __('Salinidade') }}"/>
                                <x-table-sort-header :orderBy="null" :ascending="null" columnName="psi" columnText="{{ __('Press.[psi]') }}"/>
                                <x-table-sort-header :orderBy="null" :ascending="null" columnName="sat" columnText="{{ __('Oxigênio Dissolvido (sat) (%)') }}"/>
                                <x-table-sort-header :orderBy="null" :ascending="null" columnName="conc" columnText="{{ __('Oxigênio Dissolvido (conc) (mg/L)') }}"/>
                                <x-table-sort-header :orderBy="null" :ascending="null" columnName="ntu" columnText="{{ __('Turbidez (NTU)') }}"/>
                                <x-table-sort-header :orderBy="null" :ascending="null" columnName="uncertainty" columnText="{{ __('Incerteza') }}"/>
                            </tr>
                        </thead>
                        <tbody id="table_result">
                            @foreach (array_chunk($sample['results'], 3)[1] as $key2 => $value)
                                @php
                                    $key++;
                                @endphp
                                <tr>
                                    <td>
                                        <x-jet-input readonly="true" id="temperature" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['temperature']) ? number_format($value['temperature'], 2) : ''}}"
                                        name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][temperature]' : 'samples[row_0][results]['. $key . '][temperature]' }}" step="any" />
                                    </td>
                                    <td>
                                        <x-jet-input readonly="true" id="ph" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['ph']) ? number_format($value['ph'], 2) : ''}}"
                                        name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][ph]' : 'samples[row_0][results]['. $key . '][ph]' }}" step="any" />
                                    </td>
                                    <td>
                                        <x-jet-input readonly="true" id="orp'" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['orp']) ? number_format($value['orp'], 1) : ''}}"
                                        name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][orp]' : 'samples[row_0][results]['. $key . '][orp]' }}" step="any" />
                                    </td>
                                    <td>
                                        <x-jet-input readonly="true" id="conductivity" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['conductivity']) ? number_format($value['conductivity'], 3, '.', '') : ''}}"
                                        name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][conductivity]' : 'samples[row_0][results]['. $key . '][conductivity]' }}" step="any" />
                                    </td>
                                    <td>
                                        <x-jet-input readonly="true" id="salinity" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['salinity']) ? number_format($value['salinity'], 3) : ''}}"
                                        name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][salinity]' : 'samples[row_0][results]['. $key . '][salinity]' }}" step="any" />
                                    </td>
                                    <td>
                                        <x-jet-input readonly="true" id="psi" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['psi']) ? number_format($value['psi'], 3) : ''}}"
                                        name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][psi]' : 'samples[row_0][results]['. $key . '][psi]' }}" step="any" />
                                    </td>
                                    <td>
                                        <x-jet-input readonly="true" id="sat" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['sat']) ? number_format($value['sat'], 1) : ''}}"
                                        name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][sat]' : 'samples[row_0][results]['. $key . '][sat]' }}" step="any" />
                                    </td>
                                    <td><x-jet-input readonly="true" id="conc" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['conc']) ? number_format($value['conc'], 3) : ''}}"
                                        name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][conc]' : 'samples[row_0][results]['. $key . '][conc]' }}" step="any" />
                                    </td>
                                    <td>
                                        <x-jet-input readonly="true" id="ntu" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['ntu']) ? number_format($value['ntu'], 1) : ''}}"
                                        name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][ntu]' : 'samples[row_0][results]['. $key . '][ntu]' }}" step="any" />
                                    </td>
                                    <td>
                                        <x-jet-input readonly="true" id="uncertainty" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['uncertainty']) ? number_format($value['uncertainty'], 1) : ''}}"
                                        name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][uncertainty]' : 'samples[row_0][results]['. $key . '][uncertainty]' }}" step="any" />
                                    </td>
                                <tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>
                                    @if(isset($value['temperature']))
                                        {{ number_format($duplicates['row_' . ($i)]['temperature'], 2, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(isset($value['ph']))
                                        {{ number_format($duplicates['row_' . ($i)]['ph'], 2, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(isset($value['orp']))
                                        {{ number_format($duplicates['row_' . ($i)]['orp'], 1, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(isset($value['conductivity']))
                                        {{ number_format($duplicates['row_' . ($i)]['conductivity'], 3, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(isset($value['salinity']))
                                        {{ number_format($duplicates['row_' . ($i)]['conductivity'], 3, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    -
                                </td>
                                <td>
                                    @if(isset($value['sat']))
                                        {{ number_format($duplicates['row_' . ($i)]['sat'], 1, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(isset($value['conc']))
                                        {{ number_format($duplicates['row_' . ($i)]['conc'], 3, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(isset($value['ntu']))
                                        {{ number_format($duplicates['row_' . ($i)]['ntu'], 1, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td colspan="11" class="text-center text-white" style="background-color: rgb(0, 94, 16)">% DPR</td>
                            </tr>
                            <tr>
                                <td>
                                    @if(isset($value['temperature']) && $svgs['row_' . ($i)]['temperature'] != 0)
                                        {{ number_format($dpr['row_' . ($i)]['temperature'], 2, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(isset($value['ph']) && $svgs['row_' . ($i)]['ph'] != 0)
                                        {{ number_format($dpr['row_' . ($i)]['ph'], 2, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(isset($value['orp']) && $svgs['row_' . ($i)]['orp'] != 0)
                                        {{ number_format($dpr['row_' . ($i)]['orp'], 2, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(isset($value['conductivity']) && $svgs['row_' . ($i)]['conductivity'] != 0)
                                        {{ number_format($dpr['row_' . ($i)]['conductivity'], 2, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(isset($value['salinity']) && $svgs['row_' . ($i)]['salinity'] != 0)
                                        {{ number_format($dpr['row_' . ($i)]['salinity'], 2, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(isset($value['psi']) && $svgs['row_' . ($i)]['psi'] != 0)
                                        {{ number_format($dpr['row_' . ($i)]['psi'], 2, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(isset($value['sat']) && $svgs['row_' . ($i)]['sat'] != 0)
                                        {{ number_format($dpr['row_' . ($i)]['sat'], 2, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(isset($value['conc']) && $svgs['row_' . ($i)]['conc'] != 0)
                                        {{ number_format($dpr['row_' . ($i)]['conc'], 2, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(isset($value['eh']) && $svgs['row_' . ($i)]['eh'] != 0)
                                        {{ number_format($dpr['row_' . ($i)]['eh'], 1, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(isset($value['ntu']) && $svgs['row_' . ($i)]['ntu'] != 0)
                                        {{ number_format($dpr['row_' . ($i)]['ntu'], 1, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>-</td>
                            <tr>
                        </tfoot>
                    </table>
                </div>
            @endif

        </div>
    @endif
</div>
