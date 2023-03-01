<div class="w-full px-3 mt-4 mb-6 md:mb-0 flex flex-wrap sample
            @if(isset($sample['results']))
                @if(count(array_chunk($sample['results'], 3)) > 1) duplicates-table
                 @else default-table
                @endif
            @else
            default-table
            @endif"
            id="sample_{{ isset($i) ? $i : 0 }}">
    <div class="flex w-full">
        <h3 class="w-full mt-4 mb-6 md:mb-0 title">
            AMOSTRA <span>{{ isset($amostraIndex) ? $amostraIndex : 1 }}</span>
            @if(isset($sample["invalid_rows"]))
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 @if($sample["invalid_rows"]) text-red-900 @else text-gray-400 @endif inline">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400 inline">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
            @endif
            @if(isset($sample['results']))
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 @if(count($sample['results'])>= 6) text-blue-900 @else text-gray-400 @endif inline">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                </svg>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400 inline">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                </svg>
            @endif
        </h3>
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 flex justify-end align-baseline buttons" style="align-items: baseline;">
            <button class="add-sample btn-transition-primary px-1" type="button" title="Adicionar Amostra">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-900" fill="none" viewBox="0 0 24 24" stroke-wiph="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
            <button type="button" class="btn-transition-primary remove-sample px-1" title="Remover Amostra" style="{{ isset($i) ? '': 'display:none' }}" data-index="sample_{{ isset($i) ? $i : 0 }}" data-row="{{ isset($i) ? $i : 0 }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-wiph="1.5" stroke="currentColor" class="h-8 w-8 text-red-900">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
            @if(isset($formValue))
                <div id="import_result_form_row_{{ isset($i) ? $i : 0 }}">
                    <input type="hidden" id="sample_index_{{ isset($i) ? $i : 0 }}" name="sample_index" value="row_{{ isset($i) ? $i : 0 }}">
                    <button type="button" class="btn-transition-primary import-sample-result px-1" title="Importar Amostra" data-index="sample_{{ isset($i) ? $i : 0 }}" data-row="{{ isset($i) ? $i : 0 }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-wiph="1.5" stroke="currentColor" class="h-8 w-8 text-blue-900">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" />
                        </svg>
                    </button>

                    <input type="file" name="file" id="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet|application/vnd.ms-excel" class="hidden"
                    data-index="import_result_form_row_{{ isset($i) ? $i : 0 }}" data-row="{{ isset($i) ? $i : 0 }}">

                    <button type="button" class="btn-transition-primary edit-sample px-1" title="Editar Amostra" data-index="sample_{{ isset($i) ? $i : 0 }}" @if(!isset($i)) style="display: none" @endif>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-wiph="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </button>
                    <button type="button" class="btn-transition-primary save-sample px-1" title="Salvar Amostra" data-index="sample_{{ isset($i) ? $i : 0 }}" data-row="{{ isset($i) ? $i : 0 }}"
                    @if(isset($i)) style="display: none" @endif>
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
                <x-jet-label for="equipment_{{ isset($i) ? $i : 0 }}" value="{{ __('Equipamento') }}" />
                @if(isset($sample['equipment']))
                    <x-jet-input readonly="{{ !$formValue ? false : true}}" id="equipment_{{ isset($i) ? $i : 0 }}" class="form-control block mt-1 w-full" data-index="{{ isset($i) ? $i : 0 }}"
                    type="text" value="{{ $sample['equipment'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][equipment]' : 'samples[row_0][equipment]' }}" maxlength="255" />
                @else
                    <x-jet-input id="equipment_0" class="form-control block mt-1 w-full" type="text" value="" name="samples[row_0][equipment]" maxlength="255" data-index="{{ isset($i) ? $i : 0 }}"/>
                @endif
            </div>
            <div class="w-full md:w-1/2 pr-3 mb-6 md:mb-0">
                <x-jet-label for="point_{{ isset($i) ? $i : 0 }}" value="{{ __('Ponto de Coleta') }}" />
                @if(isset($sample['point']))
                    <x-jet-input readonly="{{ !$formValue ? false : true}}" id="point_{{ isset($i) ? $i : 0 }}" class="form-control block mt-1 w-full point" data-index="{{ isset($i) ? $i : 0 }}"
                    type="text" value="{{ $sample['point'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][point]' : 'samples[row_0][point]' }}" maxlength="255" />
                @else
                    <x-jet-input id="point_0" class="form-control block mt-1 w-full point" type="text" value="" name="samples[row_0][point]" maxlength="255" data-index="{{ isset($i) ? $i : 0 }}"/>
                @endif
            </div>
        </div>
        <div class="flex flex-wrap mt-2 w-full">
            <div class="w-full md:w-1/2 pr-3 mb-6 md:mb-0">
                <x-jet-label for="environment_{{ isset($i) ? $i : 0 }}" value="{{ __('Condições ambientais nas últimas 24 hs') }}" />
                @if(isset($sample['environment']))
                    <x-jet-input readonly="{{ !$formValue ? false : true}}" id="environment_{{ isset($i) ? $i : 0 }}" class="form-control block mt-1 w-full environment" data-index="{{ isset($i) ? $i : 0 }}"
                    type="text" value="{{ $sample['environment'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][environment]' : 'samples[row_0][environment]' }}" maxlength="255" />
                @else
                    <x-jet-input id="environment_0" class="form-control block mt-1 w-full environment" type="text" value="" name="samples[row_0][environment]" maxlength="255" data-index="{{ isset($i) ? $i : 0 }}"/>
                @endif
            </div>
            <div class="w-full md:w-1/2 pr-3 mb-6 md:mb-0">
                <x-jet-label for="collect_{{ isset($i) ? $i : 0 }}" value="{{ __('DT/HR da Coleta') }}" />
                @if(isset($sample['collect']))
                    <x-jet-input readonly="{{ !$formValue ? false : true}}" id="collect_{{ isset($i) ? $i : 0 }}" class="form-control block mt-1 w-full collect" data-index="{{ isset($i) ? $i : 0 }}"
                    type="datetime-local" value="{{ $sample['collect'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][collect]' : 'samples[row_0][collect]' }}" />
                @else
                    <x-jet-input id="collect_0" class="form-control block mt-1 w-full collect" type="datetime-local" value="" name="samples[row_0][collect]" data-index="{{ isset($i) ? $i : 0 }}"/>
                @endif
            </div>
        </div>
    </div>
    @if(isset($sample['results']))
        <div class="flex flex-wrap mt-2 w-full mode-table pr-3">
            <div class="w-full">
                <table class="table table-responsive md:table w-full ">
                    <thead>
                        <tr class="thead-light">
                            <th scope="col"  class="custom-th">
                                {{ __('Temperatura [ºC]') }}
                                <input type="checkbox" name="visible_temperature"
                                id="visible_temperature_{{ isset($i) ? $i : 0 }}"
                                @if(isset($sample['visible_temperature']))  checked @endif>
                            </th>
                            <th scope="col"  class="custom-th">
                                {{ __('pH') }}
                                <input type="checkbox" name="visible_ph"
                                id="visible_ph_{{ isset($i) ? $i : 0 }}"
                                @if(isset($sample['visible_ph']))  checked @endif>
                            </th>
                            <th scope="col"  class="custom-th">
                                {{ __('ORP [mV]') }}
                                <input type="checkbox" name="visible_orp"
                                id="visible_orp_{{ isset($i) ? $i : 0 }}"
                                @if(isset($sample['visible_orp']))  checked @endif>
                            </th>
                            <th scope="col"  class="custom-th">
                                {{ __('Condutividade [µS/cm]') }}
                                <input type="checkbox" name="visible_conductivity"
                                id="visible_conductivity_{{ isset($i) ? $i : 0 }}"
                                @if(isset($sample['visible_conductivity']))  checked @endif>
                            </th>
                            <th scope="col"  class="custom-th">
                                {{ __('Salinidade [psu]') }}
                                <input type="checkbox" name="visible_salinity"
                                id="visible_salinity_{{ isset($i) ? $i : 0 }}"
                                @if(isset($sample['visible_salinity']))  checked @endif>
                            </th>
                            <th scope="col"  class="custom-th">
                                {{ __('Press. [psi]') }}
                                <input type="checkbox" name="visible_psi"
                                id="visible_psi_{{ isset($i) ? $i : 0 }}"
                                @if(isset($sample['visible_psi']))  checked @endif>
                            </th>
                            <th scope="col"  class="custom-th">
                                {{ __('Oxigênio Dissolvido (SAT) [%]') }}
                                <input type="checkbox" name="visible_sat"
                                id="visible_sat_{{ isset($i) ? $i : 0 }}"
                                @if(isset($sample['visible_sat']))  checked @endif>
                            </th>
                            <th scope="col"  class="custom-th">
                                {{ __('Oxigênio Dissolvido (CONC) [mg/l]') }}
                                <input type="checkbox" name="visible_conc"
                                id="visible_conc_{{ isset($i) ? $i : 0 }}"
                                @if(isset($sample['visible_conc']))  checked @endif>
                            </th>
                            <th scope="col"  class="custom-th">
                                {{ __('EH [mV]') }}
                                <input type="checkbox" name="visible_eh"
                                id="visible_eh_{{ isset($i) ? $i : 0 }}"
                                @if(isset($sample['visible_eh']))  checked @endif>
                            </th>
                            <th scope="col"  class="custom-th">
                                {{ __('Turbidez [NTU]') }}
                                <input type="checkbox" name="visible_ntu"
                                id="visible_ntu_{{ isset($i) ? $i : 0 }}"
                                @if(isset($sample['visible_ntu']))  checked @endif>
                            </th>
                            <th scope="col"  class="custom-th">
                                {{ __('Incerteza') }}
                                <input type="checkbox" name="visible_uncertainty"
                                id="visible_uncertainty_{{ isset($i) ? $i : 0 }}"
                                @if(isset($sample['visible_uncertainty']))  checked @endif>
                            </th>
                            <th scope="col"  class="custom-th">
                                {{ __('Cloro [mg/l]') }}
                                <input type="checkbox" name="visible_chlorine"
                                id="visible_chlorine_{{ isset($i) ? $i : 0 }}"
                                @if(isset($sample['visible_chlorine'])) checked @endif>
                            </th>
                            <th scope="col"  class="custom-th">
                                {{ __('Materiais Flutuantes') }}
                                <input type="checkbox" name="visible_floating_materials"
                                id="visible_visible_floating_materials_{{ isset($i) ? $i : 0 }}"
                                @if(isset($sample['visible_floating_materials']))  checked @endif>
                            </th>
                            <th scope="col"  class="custom-th">
                                {{ __('VOC [mg/l]') }}
                                <input type="checkbox" name="samples[row_0][visible_voc"
                                id="visible_voc_{{ isset($i) ? $i : 0 }}"
                                @if(isset($sample['visible_voc']))  checked @endif>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="table_result">
                        @foreach (array_chunk($sample['results'], 3)[0] as $key => $value)
                            <tr>
                                <td class="@if(!isset($sample['visible_temperature'])) disabled-col @endif">
                                    <x-jet-input readonly="true" id="temperature" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['temperature']) ? number_format($value['temperature'], 2) : ''}}"
                                    name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][temperature]' : 'samples[row_0][results]['. $key . '][temperature]' }}" step="any" />
                                </td>
                                <td class="@if(!isset($sample['visible_ph'])) disabled-col @endif">
                                    <x-jet-input readonly="true" id="ph" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['ph']) ? number_format($value['ph'], 2) : ''}}"
                                    name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][ph]' : 'samples[row_0][results]['. $key . '][ph]' }}" step="any" />
                                </td>
                                <td class="@if(!isset($sample['visible_orp'])) disabled-col @endif">
                                    <x-jet-input readonly="true" id="orp" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['orp']) ? number_format($value['orp'], 1) : ''}}"
                                    name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][orp]' : 'samples[row_0][results]['. $key . '][orp]' }}" step="any" />
                                </td>
                                <td class="@if(!isset($sample['visible_conductivity'])) disabled-col @endif">
                                    <x-jet-input readonly="true" id="conductivity" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['conductivity']) ? number_format($value['conductivity'], 3, '.', '') : ''}}"
                                    name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][conductivity]' : 'samples[row_0][results]['. $key . '][conductivity]' }}" step="any" />
                                </td>
                                <td class="@if(!isset($sample['visible_salinity'])) disabled-col @endif">
                                    <x-jet-input readonly="true" id="salinity" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['salinity']) ? number_format($value['salinity'], 3) : ''}}"
                                    name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][salinity]' : 'samples[row_0][results]['. $key . '][salinity]' }}" step="any" />
                                </td>
                                <td class="@if(!isset($sample['visible_psi'])) disabled-col @endif">
                                    <x-jet-input readonly="true" id="psi" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['psi']) ? number_format($value['psi'], 3) : ''}}"
                                    name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][psi]' : 'samples[row_0][results]['. $key . '][psi]' }}" step="any" />
                                </td>
                                <td class="@if(!isset($sample['visible_sat'])) disabled-col @endif">
                                    <x-jet-input readonly="true" id="sat" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['sat']) ? number_format($value['sat'], 1) : ''}}"
                                    name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][sat]' : 'samples[row_0][results]['. $key . '][sat]' }}" step="any" />
                                </td>
                                <td class="@if(!isset($sample['visible_conc'])) disabled-col @endif">
                                    <x-jet-input readonly="true" id="conc" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['conc']) ? number_format($value['conc'], 3) : ''}}"
                                    name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][conc]' : 'samples[row_0][results]['. $key . '][conc]' }}" step="any" />
                                </td>
                                <td class="@if(!isset($sample['visible_eh'])) disabled-col @endif">-</td>
                                <td class="@if(!isset($sample['visible_ntu'])) disabled-col @endif">-</td>
                                <td class="@if(!isset($sample['visible_uncertainty'])) disabled-col @endif">-</td>
                                <td class="@if(!isset($sample['visible_chlorine'])) disabled-col @endif">
                                    <x-jet-input readonly="true" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['chlorine']) ? number_format($value['chlorine'], 3) : ''}}"
                                    name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][chlorine]' : 'samples[row_0][results]['. $key . '][chlorine]' }}" step="any" />
                                </td>
                                <td class="@if(!isset($sample['visible_floating_materials'])) disabled-col @endif">
                                    <x-custom-select :options="$floatingMaterials" disabled="true"
                                        value="{{ isset($value['floating_materials']) ? $value['floating_materials'] : ''}}"
                                        name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][floating_materials]' : 'samples[row_0][results]['. $key . '][floating_materials]' }}"
                                        class="mt-1"/>
                                </td>
                                <td class="@if(!isset($sample['visible_voc'])) disabled-col @endif">
                                    <x-jet-input readonly="true" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['voc']) ? number_format($value['voc'], 3) : ''}}"
                                    name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][voc]' : 'samples[row_0][results]['. $key . '][voc]' }}" step="any" />
                                </td>
                            <tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="@if(!isset($sample['visible_temperature'])) disabled-col @endif">
                                @if(isset($value['temperature']))
                                    {{ number_format($formValue->svgs['row_' . ($i)]['temperature'], 2, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="@if(!isset($sample['visible_ph'])) disabled-col @endif">
                                @if(isset($value['ph']))
                                    {{ number_format($formValue->svgs['row_' . ($i)]['ph'], 2, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="@if(!isset($sample['visible_orp'])) disabled-col @endif">
                                @if(isset($value['orp']))
                                    {{ number_format($formValue->svgs['row_' . ($i)]['orp'], 1, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="@if(!isset($sample['visible_conductivity'])) disabled-col @endif">
                                @if(isset($value['conductivity']))
                                    {{ number_format($formValue->svgs['row_' . ($i)]['conductivity'], 3, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="@if(!isset($sample['visible_salinity'])) disabled-col @endif">
                                @if(isset($value['salinity']))
                                    {{ number_format($formValue->svgs['row_' . ($i)]['salinity'], 3, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="@if(!isset($sample['visible_psi'])) disabled-col @endif">
                               -
                            </td>
                            <td class="@if(!isset($sample['visible_sat'])) disabled-col @endif">
                                @if(isset($value['sat']))
                                    {{ number_format($formValue->svgs['row_' . ($i)]['sat'], 1, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="@if(!isset($sample['visible_conc'])) disabled-col @endif">
                                @if(isset($value['conc']))
                                    {{ number_format($formValue->svgs['row_' . ($i)]['conc'], 3, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="@if(!isset($sample['visible_eh'])) disabled-col @endif">
                                @php
                                    if(!isset($sample['eh_footer'])) :
                                        $sample['eh_footer'] = $formValue->svgs['row_' . ($i)]['eh'];
                                    endif;
                                @endphp
                                @if(isset($sample['eh_footer']))
                                    <x-jet-input readonly="{{ !$formValue ? false : true}}" id="eh_footer_{{ isset($i) ? $i : 0 }}"
                                    class="form-control block mt-1 w-full eh_footer" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                                    type="number" value="{{ $sample['eh_footer'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][eh_footer]' : 'samples[row_0][eh_footer]' }}" />
                                @else
                                    <x-jet-input id="point_0" class="form-control block mt-1 w-full point" type="number" value="" name="samples[row_0][point]" step="any" data-index="{{ isset($i) ? $i : 0 }}"/>
                                @endif
                            </td>
                            <td class="@if(!isset($sample['visible_ntu'])) disabled-col @endif">
                                @php
                                    if(!isset($sample['ntu_footer'])) :
                                        $sample['ntu_footer'] = $formValue->svgs['row_' . ($i)]['ntu'];
                                    endif;
                                @endphp
                                @if(isset($sample['ntu_footer']))
                                    <x-jet-input readonly="{{ !$formValue ? false : true}}" id="ntu_footer_{{ isset($i) ? $i : 0 }}"
                                    class="form-control block mt-1 w-full ntu_footer" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                                    type="number" value="{{ $sample['ntu_footer'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][ntu_footer]' : 'samples[row_0][ntu_footer]' }}" />
                                @else
                                    <x-jet-input id="point_0" class="form-control block mt-1 w-full point" type="number" value="" name="samples[row_0][point]" step="any" data-index="{{ isset($i) ? $i : 0 }}"/>
                                @endif
                            </td>
                            <td class="@if(!isset($sample['visible_uncertainty'])) disabled-col @endif">
                                @php
                                    if(!isset($sample['uncertainty_footer'])) :
                                        $sample['uncertainty_footer'] = "-";
                                    endif;
                                @endphp
                                @if(isset($sample['uncertainty_footer']))
                                    <x-jet-input readonly="{{ !$formValue ? false : true}}" id="uncertainty_footer_{{ isset($i) ? $i : 0 }}"
                                    class="form-control block mt-1 w-full uncertainty_footer" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                                    type="number" value="{{ $sample['uncertainty_footer'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][uncertainty_footer]' : 'samples[row_0][uncertainty_footer]' }}" />
                                @else
                                    <x-jet-input id="point_0" class="form-control block mt-1 w-full point" type="number" value="" name="samples[row_0][point]" step="any" data-index="{{ isset($i) ? $i : 0 }}"/>
                                @endif
                            </td>
                            <td class="@if(!isset($sample['visible_chlorine'])) disabled-col @endif">-</td>
                            <td class="@if(!isset($sample['visible_floating_materials'])) disabled-col @endif">-</td>
                            <td class="@if(!isset($sample['visible_voc'])) disabled-col @endif">-</td>
                        <tr>
                    </tfoot>
                </table>
            </div>
            @if (isset(array_chunk($sample['results'], 3)[1]))
                <div class="w-full mt-2 duplicate fade">
                    <h2 class="text-center text-white opacity-100 p-2 w-full" style="background-color: rgb(0, 94, 16)">DUPLICATA</h2>
                    @if(count($sample['results'])>= 6)
                        <table class="table table-responsive md:table w-full">
                            <thead>
                                <tr class="thead-light">
                                    <th scope="col"  class="custom-th">{{ __('Temperatura [ºC]') }}</th>
                                    <th scope="col"  class="custom-th">{{ __('pH') }}</th>
                                    <th scope="col"  class="custom-th">{{ __('ORP [mV]') }}</th>
                                    <th scope="col"  class="custom-th">{{ __('Condutividade [µS/cm]') }}</th>
                                    <th scope="col"  class="custom-th">{{ __('Salinidade [psu]') }}</th>
                                    <th scope="col"  class="custom-th">{{ __('Press. [psi]') }}</th>
                                    <th scope="col"  class="custom-th">{{ __('Oxigênio Dissolvido (SAT) [%]') }}</th>
                                    <th scope="col"  class="custom-th">{{ __('Oxigênio Dissolvido (CONC) [mg/l]') }}</th>
                                    <th scope="col"  class="custom-th">{{ __('EH [mV]') }}</th>
                                    <th scope="col"  class="custom-th">{{ __('Turbidez [NTU]') }}</th>
                                    <th scope="col"  class="custom-th">{{ __('Incerteza') }}</th>
                                    <th scope="col"  class="custom-th">{{ __('Cloro [mg/l]') }}</th>
                                    <th scope="col"  class="custom-th">{{ __('Materiais Flutuantes') }}</th>
                                    <th scope="col"  class="custom-th">{{ __('VOC [mg/l]') }}</th>
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
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>
                                            <x-jet-input readonly="true" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['chlorine']) ? number_format($value['chlorine'], 3) : ''}}"
                                            name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][chlorine]' : 'samples[row_0][results]['. $key . '][chlorine]' }}" step="any" />
                                        </td>
                                        <td>
                                            <x-custom-select :options="$floatingMaterials"
                                                value="{{ isset($value['floating_materials']) ? $value['floating_materials'] : ''}}"
                                                name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][floating_materials]' : 'samples[row_0][results]['. $key . '][floating_materials]' }}"
                                                class="mt-1"/>
                                        </td>
                                        <td>
                                            <x-jet-input readonly="true" class="form-control block mt-1 w-full" type="number" value="{{ isset($value['voc']) ? number_format($value['voc'], 3) : ''}}"
                                            name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][voc]' : 'samples[row_0][results]['. $key . '][voc]' }}" step="any" />
                                        </td>
                                    <tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>
                                        @if(isset($value['temperature']))
                                            {{ number_format($formValue->duplicates['row_' . ($i)]['temperature'], 2, ",", ".") }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($value['ph']))
                                            {{ number_format($formValue->duplicates['row_' . ($i)]['ph'], 2, ",", ".") }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($value['orp']))
                                            {{ number_format($formValue->duplicates['row_' . ($i)]['orp'], 1, ",", ".") }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($value['conductivity']))
                                            {{ number_format($formValue->duplicates['row_' . ($i)]['conductivity'], 3, ",", ".") }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($value['salinity']))
                                            {{ number_format($formValue->duplicates['row_' . ($i)]['conductivity'], 3, ",", ".") }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        -
                                    </td>
                                    <td>
                                        @if(isset($value['sat']))
                                            {{ number_format($formValue->duplicates['row_' . ($i)]['sat'], 1, ",", ".") }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($value['conc']))
                                            {{ number_format($formValue->duplicates['row_' . ($i)]['conc'], 3, ",", ".") }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>
                                        @php
                                            if(!isset($sample['eh_footer_duplicates'])) :
                                                $sample['eh_footer_duplicates'] = $formValue->duplicates['row_' . ($i)]['eh'];
                                            endif;
                                        @endphp
                                        @if(isset($sample['eh_footer_duplicates']))
                                            <x-jet-input readonly="{{ !$formValue ? false : true}}" id="eh_footer_duplicates_{{ isset($i) ? $i : 0 }}"
                                            class="form-control block mt-1 w-full eh_footer_duplicates" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                                            type="number" value="{{ $sample['eh_footer_duplicates'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][eh_footer_duplicates]' : 'samples[row_0][eh_footer_duplicates]' }}" />
                                        @else
                                            <x-jet-input id="point_0" class="form-control block mt-1 w-full point" type="number" value="" name="samples[row_0][point]" step="any" data-index="{{ isset($i) ? $i : 0 }}"/>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            if(!isset($sample['ntu_footer_duplicates'])) :
                                                $sample['ntu_footer_duplicates'] = $formValue->duplicates['row_' . ($i)]['ntu'];
                                            endif;
                                        @endphp
                                        @if(isset($sample['ntu_footer_duplicates']))
                                            <x-jet-input readonly="{{ !$formValue ? false : true}}" id="ntu_footer_duplicates_{{ isset($i) ? $i : 0 }}"
                                            class="form-control block mt-1 w-full ntu_footer_duplicates" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                                            type="number" value="{{ $sample['ntu_footer_duplicates'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][ntu_footer_duplicates]' : 'samples[row_0][ntu_footer_duplicates]' }}" />
                                        @else
                                            <x-jet-input id="point_0" class="form-control block mt-1 w-full point" type="number" value="" name="samples[row_0][point]" step="any" data-index="{{ isset($i) ? $i : 0 }}"/>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            if(!isset($sample['uncertainty_footer_duplicates'])) :
                                                $sample['uncertainty_footer_duplicates'] = "-";
                                            endif;
                                        @endphp
                                        @if(isset($sample['uncertainty_footer_duplicates']))
                                            <x-jet-input readonly="{{ !$formValue ? false : true}}" id="uncertainty_footer_duplicates_{{ isset($i) ? $i : 0 }}"
                                            class="form-control block mt-1 w-full uncertainty_footer_duplicates" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                                            type="number" value="{{ $sample['uncertainty_footer_duplicates'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][uncertainty_footer_duplicates]' : 'samples[row_0][uncertainty_footer_duplicates]' }}" />
                                        @else
                                            <x-jet-input id="point_0" class="form-control block mt-1 w-full point" type="number" value="" name="samples[row_0][point]" step="any" data-index="{{ isset($i) ? $i : 0 }}"/>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11" class="text-center text-white" style="background-color: rgb(0, 94, 16)">% DPR</td>
                                </tr>
                                <tr>
                                    <td>
                                        @if(isset($value['temperature']) && $formValue->svgs['row_' . ($i)]['temperature'] != 0)
                                            {{ number_format($formValue->dpr['row_' . ($i)]['temperature'], 2, ",", ".") }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($value['ph']) && $formValue->svgs['row_' . ($i)]['ph'] != 0)
                                            {{ number_format($formValue->dpr['row_' . ($i)]['ph'], 2, ",", ".") }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($value['orp']) && $formValue->svgs['row_' . ($i)]['orp'] != 0)
                                            {{ number_format($formValue->dpr['row_' . ($i)]['orp'], 2, ",", ".") }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($value['conductivity']) && $formValue->svgs['row_' . ($i)]['conductivity'] != 0)
                                            {{ number_format($formValue->dpr['row_' . ($i)]['conductivity'], 2, ",", ".") }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($value['salinity']) && $formValue->svgs['row_' . ($i)]['salinity'] != 0)
                                            {{ number_format($formValue->dpr['row_' . ($i)]['salinity'], 2, ",", ".") }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($value['psi']) && $formValue->svgs['row_' . ($i)]['psi'] != 0)
                                            {{ number_format($formValue->dpr['row_' . ($i)]['psi'], 2, ",", ".") }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($value['sat']) && $formValue->svgs['row_' . ($i)]['sat'] != 0)
                                            {{ number_format($formValue->dpr['row_' . ($i)]['sat'], 2, ",", ".") }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($value['conc']) && $formValue->svgs['row_' . ($i)]['conc'] != 0)
                                            {{ number_format($formValue->dpr['row_' . ($i)]['conc'], 2, ",", ".") }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($value['eh']) && $formValue->svgs['row_' . ($i)]['eh'] != 0)
                                            {{ number_format($formValue->dpr['row_' . ($i)]['eh'], 1, ",", ".") }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($value['ntu']) && $formValue->svgs['row_' . ($i)]['ntu'] != 0)
                                            {{ number_format($formValue->dpr['row_' . ($i)]['ntu'], 1, ",", ".") }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>-</td>
                                <tr>
                            </tfoot>
                        </table>
                    @endif
                </div>
            @endif
        </div>
    @endif
</div>
