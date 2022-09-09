<div class="w-full px-3 mt-4 mb-6 md:mb-0 flex flex-wrap sample" id="sample_{{ isset($i) ? $i + 1 : 1 }}" data-index="1">
    <div class="flex w-full">
        <h3 class="w-full mt-4 mb-6 md:mb-0 title">AMOSTRA <span>{{ isset($i) ? $i + 1 : 1 }}</span></h3>
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 flex justify-end align-baseline" style="align-items: baseline;">
            <button class="add-sample btn-transition-primary" type="button" title="Adicionar Amostra">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-900" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
            <button type="button" class="btn-transition-primary remove-sample" title="Remover Amostra" style="{{ isset($i) ? '': 'display:none' }}" data-index="sample_{{ isset($i) ? $i + 1 : 1 }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 text-red-900">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
            @if(isset($formValue))
                <div id="import_result_form_row_{{ isset($i) ? $i + 1 : 1 }}" class="">
                    @csrf
                    @method("POST")
                    <input type="hidden" id="form_value_id" name="form_value_id" value="{{ $formValue->id }}">
                    <input type="hidden" id="sample_index" name="sample_index" value="row_{{ isset($i) ? $i + 1 : 1 }}">
                    <button type="button" class="btn-transition-primary import-sample-result" title="Importar Amostra" data-index="sample_{{ isset($i) ? $i + 1 : 1 }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 text-blue-900">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" />
                        </svg>
                    </button>
                    <input type="file" name="file" id="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet|application/vnd.ms-excel" class="hidden" data-index="import_result_form_row_{{ isset($i) ? $i + 1 : 1 }}">
                    <button type="button" class="btn-transition-primary edit-sample" title="Editar Amostra" data-index="sample_{{ isset($i) ? $i + 1 : 1 }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </button>
                    <button type="button" class="btn-transition-primary save-sample" title="Salvar Amostra" data-index="sample_{{ isset($i) ? $i + 1 : 1 }}" style="display: none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-8 w-8">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </button>
                </div>
            @endif
        </div>
    </div>
    <div class="flex flex-wrap mt-2 w-full">
        <div class="w-full md:w-1/2 pr-3 mb-6 md:mb-0">
            <x-jet-label for="equipment" value="{{ __('Equipamento') }}" />
            @if(isset($formValue->values['samples']['row_' . ($i + 1)]['equipment']) || isset($formValue->values['samples']['row_1']['equipment']))
                <x-jet-input disabled="{{ !$formValue ? false : true}}" id="equipment" class="form-control block mt-1 w-full"
                type="text" value="{{ isset($i) ? $formValue->values['samples']['row_' . ($i + 1)]['equipment'] : $formValue->values['samples']['row_1']['equipment'] }}"
                name="{{ isset($i) ? 'samples[row_' . ($i + 1) . '][equipment]' : 'samples[row_1][equipment]' }}" maxlength="255" />
            @else
                <x-jet-input disabled="{{ !$formValue ? false : true}}" id="equipment" class="form-control block mt-1 w-full"
                type="text" value=""
                name="samples[row_1][equipment]" maxlength="255" />
            @endif
        </div>
        <div class="w-full md:w-1/2 pr-3 mb-6 md:mb-0">
            <x-jet-label for="point" value="{{ __('Ponto de Coleta') }}" />
            @if(isset($formValue))
                <x-jet-input disabled="{{ !$formValue ? false : true}}" id="point" class="form-control block mt-1 w-full"
                type="text" value="{{ isset($i) ? $formValue->values['samples']['row_' . ($i + 1)]['point'] : $formValue->values['samples']['row_1']['point'] }}"
                name="{{ isset($i) ? 'samples[row_' . ($i + 1) . '][point]' : 'samples[row_1][point]' }}" maxlength="255" />
            @else
                <x-jet-input disabled="{{ !$formValue ? false : true}}" id="point" class="form-control block mt-1 w-full"
                type="text" value=""
                name="samples[row_1][point]" maxlength="255" />
            @endif
        </div>
    </div>
    <div class="flex flex-wrap mt-2 w-full">
        <div class="w-full md:w-1/2 pr-3 mb-6 md:mb-0">
            <x-jet-label for="environment" value="{{ __('Condições ambientais nas últimas 24 hs') }}" />
            @if(isset($formValue))
                <x-jet-input disabled="{{ !$formValue ? false : true}}" id="environment" class="form-control block mt-1 w-full"
                type="text" value="{{ isset($i) ? $formValue->values['samples']['row_' . ($i + 1)]['environment'] : $formValue->values['samples']['row_1']['environment'] }}"
                name="{{ isset($i) ? 'samples[row_' . ($i + 1) . '][environment]' : 'samples[row_1][environment]' }}" maxlength="255" />
            @else
                <x-jet-input disabled="{{ !$formValue ? false : true}}" id="environment" class="form-control block mt-1 w-full"
                type="text" value=""
                name="samples[row_1][environment]" maxlength="255" />
            @endif
        </div>
        <div class="w-full md:w-1/2 pr-3 mb-6 md:mb-0">
            <x-jet-label for="collect" value="{{ __('DT/HR da Coleta') }}" />
            @if(isset($formValue))
                <x-jet-input disabled="{{ !$formValue ? false : true}}" id="collect" class="form-control block mt-1 w-full"
                type="datetime-local" value="{{ isset($i) ? $formValue->values['samples']['row_' . ($i + 1)]['collect'] : $formValue->values['samples']['row_1']['collect'] }}"
                name="{{ isset($i) ? 'samples[row_' . ($i + 1) . '][collect]' : 'samples[row_1][collect]' }}" maxlength="255" />
            @else
                <x-jet-input disabled="{{ !$formValue ? false : true}}" id="collect" class="form-control block mt-1 w-full"
                type="datetime-local" value=""
                name="samples[row_1][collect]" maxlength="255" />
            @endif
        </div>
    </div>
    @if(isset($formValue))
        <div class="flex flex-wrap mt-2 w-full">
            <table id="guiding_value_table" class="table table-responsive md:table w-full">
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
                    </tr>
                </thead>
                <tbody id="table_result">
                    @if(isset($formValue))
                        @if(isset($formValue->values['samples']['row_' . (isset($i) ? $i + 1 : 1) ]['results']))
                            @foreach ($formValue->values['samples']['row_' . (isset($i) ? $i + 1 : 1)]['results'] as $key => $value)
                                <tr>
                                    <td>
                                        <x-jet-input disabled="true" id="temperature" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['temperature']) ? number_format($value['temperature'], 2) : 0}}"
                                        name="{{ isset($i) ? 'samples[row_' . ($i + 1) . '][results][' . $key . '][temperature]' : 'samples[row_1][results]['. $key . '][temperature]' }}" step="any" />
                                    </td>
                                    <td>
                                        <x-jet-input disabled="true" id="ph" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['ph']) ? number_format($value['ph'], 2) : 0}}"
                                        name="{{ isset($i) ? 'samples[row_' . ($i + 1) . '][results][' . $key . '][ph]' : 'samples[row_1][results]['. $key . '][ph]' }}" step="any" />
                                    </td>
                                    <td>
                                        <x-jet-input disabled="true" id="orp" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['orp']) ? number_format($value['orp'], 1) : 0}}"
                                        name="{{ isset($i) ? 'samples[row_' . ($i + 1) . '][results][' . $key . '][orp]' : 'samples[row_1][results]['. $key . '][orp]' }}" step="any" />
                                    </td>
                                    <td>
                                        <x-jet-input disabled="true" id="conductivity" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['conductivity']) ? number_format($value['conductivity'], 3, '.', '') : 0}}"
                                        name="{{ isset($i) ? 'samples[row_' . ($i + 1) . '][results][' . $key . '][conductivity]' : 'samples[row_1][results]['. $key . '][conductivity]' }}" step="any" />
                                    </td>
                                    <td>
                                        <x-jet-input disabled="true" id="salinity" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['salinity']) ? number_format($value['salinity'], 3) : 0}}"
                                        name="{{ isset($i) ? 'samples[row_' . ($i + 1) . '][results][' . $key . '][salinity]' : 'samples[row_1][results]['. $key . '][salinity]' }}" step="any" />
                                    </td>
                                    <td>
                                        <x-jet-input disabled="true" id="psi" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['psi']) ? number_format($value['psi'], 3) : 0}}"
                                        name="{{ isset($i) ? 'samples[row_' . ($i + 1) . '][results][' . $key . '][psi]' : 'samples[row_1][results]['. $key . '][psi]' }}" step="any" />
                                    </td>
                                    <td>
                                        <x-jet-input disabled="true" id="sat" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['sat']) ? number_format($value['sat'], 1) : 0}}"
                                        name="{{ isset($i) ? 'samples[row_' . ($i + 1) . '][results][' . $key . '][sat]' : 'samples[row_1][results]['. $key . '][sat]' }}" step="any" />
                                    </td>
                                    <td><x-jet-input disabled="true" id="conc" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['conc']) ? number_format($value['conc'], 3) : 0}}"
                                        name="{{ isset($i) ? 'samples[row_' . ($i + 1) . '][results][' . $key . '][conc]' : 'samples[row_1][results]['. $key . '][conc]' }}" step="any" />
                                    </td>
                                    <td>
                                        <x-jet-input disabled="true" id="eh" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['eh']) ? number_format($value['eh'], 1) : 0}}"
                                        name="{{ isset($i) ? 'samples[row_' . ($i + 1) . '][results][' . $key . '][eh]' : 'samples[row_1][results]['. $key . '][eh]' }}" step="any" />
                                    </td>
                                    <td>
                                        <x-jet-input disabled="true" id="ntu" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['ntu']) ? number_format($value['ntu'], 1) : 0}}"
                                        name="{{ isset($i) ? 'samples[row_' . ($i + 1) . '][results][' . $key . '][ntu]' : 'samples[row_1][results]['. $key . '][ntu]' }}" step="any" />
                                    </td>
                                <tr>
                            @endforeach
                        @endif
                    @endif
                </tbody>
                <tfoot>
                    @if(isset($formValue))
                        @if(isset($formValue->values['samples']['row_' . (isset($i) ? $i + 1 : 1) ]['results']))
                            <tr>
                                <td>
                                    @if(isset($value['temperature']))
                                        @php
                                            $sum = $formValue->values['samples']['row_' . (isset($i) ? $i + 1 : 1)]['results'][0]['temperature'] +
                                                    $formValue->values['samples']['row_' . (isset($i) ? $i + 1 : 1)]['results'][1]['temperature'] +
                                                    $formValue->values['samples']['row_' . (isset($i) ? $i + 1 : 1)]['results'][2]['temperature'];

                                            $svg = $sum / 3;
                                        @endphp
                                        {{ number_format($svg, 2, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(isset($value['ph']))
                                        @php
                                            $sum = $formValue->values['samples']['row_' . (isset($i) ? $i + 1 : 1)]['results'][0]['ph'] +
                                                $formValue->values['samples']['row_' . (isset($i) ? $i + 1 : 1)]['results'][1]['ph'] +
                                                $formValue->values['samples']['row_' . (isset($i) ? $i + 1 : 1)]['results'][2]['ph'];

                                            $svg = $sum / 3;
                                        @endphp
                                        {{ number_format($svg, 2, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(isset($value['orp']))
                                        @php
                                            $sum = $formValue->values['samples']['row_' . (isset($i) ? $i + 1 : 1)]['results'][0]['orp'] +
                                                $formValue->values['samples']['row_' . (isset($i) ? $i + 1 : 1)]['results'][1]['orp'] +
                                                $formValue->values['samples']['row_' . (isset($i) ? $i + 1 : 1)]['results'][2]['orp'];

                                            $svgORP = $sum / 3;
                                        @endphp
                                        {{ number_format($svgORP, 1, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(isset($value['conductivity']))
                                        @php
                                            $sum = $formValue->values['samples']['row_' . (isset($i) ? $i + 1 : 1)]['results'][0]['conductivity'] +
                                                $formValue->values['samples']['row_' . (isset($i) ? $i + 1 : 1)]['results'][1]['conductivity'] +
                                                $formValue->values['samples']['row_' . (isset($i) ? $i + 1 : 1)]['results'][2]['conductivity'];

                                            $svg = $sum / 3;
                                        @endphp
                                        {{ number_format($svg, 3, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(isset($value['conductivity']))
                                        @php
                                            $sum = $formValue->values['samples']['row_' . (isset($i) ? $i + 1 : 1)]['results'][0]['salinity'] +
                                                $formValue->values['samples']['row_' . (isset($i) ? $i + 1 : 1)]['results'][1]['salinity'] +
                                                $formValue->values['samples']['row_' . (isset($i) ? $i + 1 : 1)]['results'][2]['salinity'];

                                            $svg = $sum / 3;
                                        @endphp
                                        {{ number_format($svg, 3, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>-</td>
                                <td>
                                    @if(isset($value['sat']))
                                        @php
                                            $sum = $formValue->values['samples']['row_' . (isset($i) ? $i + 1 : 1)]['results'][0]['sat'] +
                                                $formValue->values['samples']['row_' . (isset($i) ? $i + 1 : 1)]['results'][1]['sat'] +
                                                $formValue->values['samples']['row_' . (isset($i) ? $i + 1 : 1)]['results'][2]['sat'];

                                            $svg = $sum / 3;
                                        @endphp
                                        {{ number_format($svg, 1, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(isset($value['conc']))
                                        @php
                                            $sum = $formValue->values['samples']['row_' . (isset($i) ? $i + 1 : 1)]['results'][0]['conc'] +
                                                $formValue->values['samples']['row_' . (isset($i) ? $i + 1 : 1)]['results'][1]['conc'] +
                                                $formValue->values['samples']['row_' . (isset($i) ? $i + 1 : 1)]['results'][2]['conc'];

                                            $svg = $sum / 3;
                                        @endphp
                                        {{ number_format($svg, 3, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(isset($value['eh']))
                                        @php
                                            $svg = $svgORP + 199;
                                        @endphp
                                        {{ number_format($svg, 1, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(isset($value['ntu']))
                                        @php
                                            $sum = $formValue->values['samples']['row_' . (isset($i) ? $i + 1 : 1)]['results'][0]['ntu'] +
                                                $formValue->values['samples']['row_' . (isset($i) ? $i + 1 : 1)]['results'][1]['ntu'] +
                                                $formValue->values['samples']['row_' . (isset($i) ? $i + 1 : 1)]['results'][2]['ntu'];

                                            $svg = $sum / 3;
                                        @endphp
                                        {{ number_format($svg, 1, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                            <tr>
                        @endif
                    @endif
                </tfoot>
            </table>
        </div>
    @endif
</div>
