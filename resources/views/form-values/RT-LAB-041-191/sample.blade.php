<div class="w-full px-3 mt-4 mb-6 md:mb-0 flex flex-wrap sample
    @if(isset($sample['results']))
        @if(count(array_chunk($sample['results'], $chuckSize)) > 1) duplicates-table
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
                    <button type="button" class="btn-transition-primary add-results px-1" title="Adicionar Linhas" data-index="sample_{{ isset($i) ? $i : 0 }}" data-row="{{ isset($i) ? $i : 0 }}" @if(!isset($i)) style="display: none" @endif>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 text-blue-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                        </svg>
                    </button>
                </div>
            @endif
        </div>
    </div>
    <div class="inputs w-full">
        <div class="flex flex-wrap mt-2 w-full">
            <div class="w-full md:w-1/3 pr-3 mb-6 md:mb-0">
                <x-jet-label for="equipment_{{ isset($i) ? $i : 0 }}" value="{{ __('Equipamento') }}" />
                @if(isset($sample['equipment']))
                    <x-jet-input readonly="{{ !$formValue ? false : true}}" id="equipment_{{ isset($i) ? $i : 0 }}" class="form-control block mt-1 w-full" data-index="{{ isset($i) ? $i : 0 }}"
                    type="text" value="{{ $sample['equipment'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][equipment]' : 'samples[row_0][equipment]' }}" maxlength="255" />
                @else
                    <x-jet-input id="equipment_0" class="form-control block mt-1 w-full" type="text" value="" name="samples[row_0][equipment]" maxlength="255" data-index="{{ isset($i) ? $i : 0 }}"/>
                @endif
            </div>
            <div class="w-full md:w-1/3 pr-3 mb-6 md:mb-0 turbidity-equipment">
                <x-jet-label for="turbidity_equipment_{{ isset($i) ? $i : 0 }}" value="{{ __('Equipamento Turbidez') }}" />
                @if(isset($sample['turbidity_equipment']))
                    <x-jet-input readonly="{{ !$formValue ? false : true}}" id="turbidity_equipment_{{ isset($i) ? $i : 0 }}" class="form-control block mt-1 w-full" data-index="{{ isset($i) ? $i : 0 }}"
                    type="text" value="{{ $sample['turbidity_equipment'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][turbidity_equipment]' : 'samples[row_0][turbidity_equipment]' }}" maxlength="255" />
                @else
                    <x-jet-input id="turbidity_equipment_0" class="form-control block mt-1 w-full" type="text" value="" name="samples[row_0][turbidity_equipment]" maxlength="255" data-index="{{ isset($i) ? $i : 0 }}"/>
                @endif
            </div>
            <div class="w-full md:w-1/3 pr-3 mb-6 md:mb-0">
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
        <div class="flex flex-wrap mt-2 w-full mode-table @if(app('request')->has('filter_duplicate')) fade @endif pr-3">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr class="thead-light">
                            @include('form-values.RT-LAB-041-191.sample-headers')
                        </tr>
                    </thead>
                    <tbody id="table_result">
                        @foreach (array_chunk($sample['results'], $chuckSize)[0] as $key => $value)
                            @include('form-values.RT-LAB-041-191.sample-fields', ['key' => $key, 'value' => $value])
                        @endforeach
                    </tbody>
                    <tfoot id="table_result_footer">
                        @include('form-values.RT-LAB-041-191.sample-footer')
                    </tfoot>
                </table>
            </div>
            @include('form-values.RT-LAB-041-191.sample-duplicate-footer')
        </div>
    @endif
</div>
