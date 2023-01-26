<div class="flex flex-wrap mx-4 px-3 py-2 mt-4 sample" x-data="showDetails()" id="sample_{{ isset($i) ? $i : 0 }}">
    <div class="flex w-full">
        <h3 class="w-full md:w-1/2 px-3 mb-6 md:mb-0 title">AMOSTRA <span>{{ $amostraIndex }}</span></h3>
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 flex justify-end align-baseline buttons" style="align-items: baseline;">
            @if (!$first)
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
            @endif
            @if(isset($formValue))
                <div>
                    <input type="hidden" id="sample_index_{{ isset($i) ? $i : 0 }}" name="sample_index" value="row_{{ isset($i) ? $i : 0 }}">
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
            <button class="btn-transition-secondary" type="button" id="show_details" @click="isOpen() ? close() : show();">
                <svg xmlns="http://www.w3.org/2000/svg" :class="{ 'rotate-180': isOpen(), 'rotate-0': !isOpen() }" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7m14-8l-7 7-7-7" />
                </svg>
            </button>
        </div>
    </div>
    <div class="w-full flex">
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
            <x-jet-label for="collect_point_{{ isset($i) ? $i : 0 }}" value="{{ __('Ponto de Coleta') }}" />
            @if(isset($sample))
                <x-jet-input readonly="true" id="collect_point_{{ isset($i) ? $i : 0 }}" class="form-control block mt-1 w-full" data-index="{{ isset($i) ? $i : 0 }}"
                type="text" value="{{ $sample['collect_point'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][collect_point]' : 'samples[row_0][collect_point]' }}" maxlength="255" />
            @else
                <x-jet-input id="collect_point_0" class="form-control block mt-1 w-full" type="text" value="" name="samples[row_0][collect_point]" maxlength="255" data-index="{{ isset($i) ? $i : 0 }}"/>
            @endif
        </div>
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
            <x-jet-label for="collected_at_{{ isset($i) ? $i : 0 }}" value="{{ __('Data/Hora da Coleta') }}" />
            @if(isset($sample))
                <x-jet-input readonly="true" id="collected_at_{{ isset($i) ? $i : 0 }}" class="form-control block mt-1 w-full" data-index="{{ isset($i) ? $i : 0 }}"
                type="datetime-local" value="{{ $sample['collected_at'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][collected_at]' : 'samples[row_0][collected_at]' }}" maxlength="255" />
            @else
                <x-jet-input id="collected_at_0" class="form-control block mt-1 w-full" type="datetime-local" value="" name="samples[row_0][collected_at]" maxlength="255" data-index="{{ isset($i) ? $i : 0 }}"/>
            @endif
        </div>
    </div>
    <div class="w-full mt-2">
        <div class="details w-full" x-show="isOpen()"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 transform scale-90"
                                    x-transition:enter-end="opacity-100 transform scale-100"
                                    x-transition:leave="transition ease-in duration-300"
                                    x-transition:leave-start="opacity-100 transform scale-100"
                                    x-transition:leave-end="opacity-0 transform scale-90 hidden">
            <div class="flex flex-wrap mt-4">
                <div class="w-full md:w-1/2 pl-3 mb-6 md:mb-0">
                    <x-jet-label for="environmental_conditions_{{ isset($i) ? $i : 0 }}" value="{{ __('Condições Ambientais nas Últimas 24 hs*') }}" />
                    @if(isset($sample))
                        <x-custom-select select-class="no-nice-select" id="environmental_conditions_{{ isset($i) ? $i : 0 }}"  :disabled="true"
                        :options="['Com Chuva' => 'Com Chuva', 'Sem Chuva' => 'Sem Chuva']" value="{{ $sample['environmental_conditions'] }}"
                        name="{{ isset($i) ? 'samples[row_' . ($i) . '][environmental_conditions]' : 'samples[row_0][environmental_conditions]' }}" class="mt-1"/>
                    @else
                        <x-custom-select select-class="no-nice-select" id="environmental_conditions_{{ isset($i) ? $i : 0 }}"
                        :options="['Com Chuva' => 'Com Chuva', 'Sem Chuva' => 'Sem Chuva']" value=""
                        name="samples[row_0][environmental_conditions]" class="mt-1"/>
                    @endif
            </div>
            </div>
            <div class="flex flex-wrap mt-4">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="well_depth_{{ isset($i) ? $i : 0 }}" value="{{ __('Profundidade do poço (m)') }}" />
                    @if(isset($sample))
                        <x-jet-input   readonly="true" id="well_depth_{{ isset($i) ? $i : 0 }}" class="form-control block mt-1 w-full well-depth" data-index="{{ isset($i) ? $i : 0 }}"
                        type="number" step="any" value="{{ $sample['well_depth'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][well_depth]' : 'samples[row_0][well_depth]' }}" />
                    @else
                        <x-jet-input id="well_depth_0" class="form-control block mt-1 w-full well-depth" step="any" type="number" value="" name="samples[row_0][well_depth]" data-index="{{ isset($i) ? $i : 0 }}"/>
                    @endif
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="water_level_{{ isset($i) ? $i : 0 }}" value="{{ __('Nível d´água (m)') }}" />
                    @if(isset($sample))
                        <x-jet-input readonly="true" id="water_level_{{ isset($i) ? $i : 0 }}" class="form-control block mt-1 w-full water-level" data-index="{{ isset($i) ? $i : 0 }}"
                        type="number" step="any" value="{{ $sample['water_level'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][water_level]' : 'samples[row_0][water_level]' }}" />
                    @else
                        <x-jet-input id="water_level_0" class="form-control block mt-1 w-full water-level" step="any" type="number" value="" name="samples[row_0][water_level]" data-index="{{ isset($i) ? $i : 0 }}"/>
                    @endif
                </div>
            </div>
            <div class="flex flex-wrap mt-4">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="water_column_{{ isset($i) ? $i : 0 }}" value="{{ __('Coluna d\'água (m)') }}"/>
                    @if(isset($sample))
                        <x-jet-input readonly="true" id="water_column_{{ isset($i) ? $i : 0 }}" class="form-control block mt-1 w-full water-column" data-index="{{ isset($i) ? $i : 0 }}"
                        type="number" step="any" value="{{ $sample['water_column'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][water_column]' : 'samples[row_0][water_column]' }}" />
                    @else
                        <x-jet-input readonly="true" id="water_column_0" class="form-control block mt-1 w-full water-column" step="any" type="number" value="" name="samples[row_0][water_column]" data-index="{{ isset($i) ? $i : 0 }}"/>
                    @endif
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="pump_depth_{{ isset($i) ? $i : 0 }}" value="{{ __('Profundidade da bomba') }}" />
                    @if(isset($sample))
                        <x-jet-input readonly="true" id="pump_depth_{{ isset($i) ? $i : 0 }}" class="form-control block mt-1 w-full pump-depth" data-index="{{ isset($i) ? $i : 0 }}"
                        type="number" step="any" value="{{ $sample['pump_depth'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][pump_depth]' : 'samples[row_0][pump_depth]' }}" />
                    @else
                        <x-jet-input id="pump_depth_0" class="form-control block mt-1 w-full pump-depth" step="any" type="number" value="" name="samples[row_0][pump_depth]" data-index="{{ isset($i) ? $i : 0 }}"/>
                    @endif
                </div>
            </div>
            <div class="flex flex-wrap mt-4">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="pressure_{{ isset($i) ? $i : 0 }}" value="{{ __('Pressão (psi)') }}" />
                    @if(isset($sample))
                        <x-jet-input readonly="true" id="pressure_{{ isset($i) ? $i : 0 }}" class="form-control block mt-1 w-full" data-index="{{ isset($i) ? $i : 0 }}"
                        type="number" step="any" value="{{ $sample['pressure'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][pressure]' : 'samples[row_0][pressure]' }}" />
                    @else
                        <x-jet-input id="pressure_0" class="form-control block mt-1 w-full" step="any" type="number" value="" name="samples[row_0][pressure]" data-index="{{ isset($i) ? $i : 0 }}"/>
                    @endif
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="flow_rate_{{ isset($i) ? $i : 0 }}" value="{{ __('Vazão (mL/min)') }}" />
                    @if(isset($sample))
                        <x-jet-input readonly="true" id="flow_rate_{{ isset($i) ? $i : 0 }}" class="form-control block mt-1 w-full flow-rate" data-index="{{ isset($i) ? $i : 0 }}"
                        type="number" step="any" value="{{ $sample['flow_rate'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][flow_rate]' : 'samples[row_0][flow_rate]' }}" />
                    @else
                        <x-jet-input id="flow_rate_0" class="form-control block mt-1 w-full flow-rate" step="any" type="number" value="" name="samples[row_0][flow_rate]" data-index="{{ isset($i) ? $i : 0 }}"/>
                    @endif
                </div>
            </div>
            <div class="flex flex-wrap mt-4">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="fq_parameters_{{ isset($i) ? $i : 0 }}" value="{{ __('Intervalo de leitura dos parâmetros FQ após estabilização (min)') }}"/>
                    @if(isset($sample))
                        <x-jet-input readonly="true" id="fq_parameters_{{ isset($i) ? $i : 0 }}" class="form-control block mt-1 w-full fq-parameters" data-index="{{ isset($i) ? $i : 0 }}"
                        type="number" step="any" value="{{ $sample['fq_parameters'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][fq_parameters]' : 'samples[row_0][fq_parameters]' }}" />
                    @else
                        <x-jet-input readonly="true" id="fq_parameters_0" class="form-control block mt-1 w-full fq-parameters" step="any" type="number" value="" name="samples[row_0][fq_parameters]" data-index="{{ isset($i) ? $i : 0 }}"/>
                    @endif
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="purged_volume_{{ isset($i) ? $i : 0 }}" value="{{ __('Volume purgado (L)') }}" />
                    @if(isset($sample))
                        <x-jet-input readonly="true" id="purged_volume_{{ isset($i) ? $i : 0 }}" class="form-control block mt-1 w-full" data-index="{{ isset($i) ? $i : 0 }}"
                        type="number" step="any" value="{{ $sample['purged_volume'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][purged_volume]' : 'samples[row_0][purged_volume]' }}" />
                    @else
                        <x-jet-input id="purged_volume_0" class="form-control block mt-1 w-full" step="any" type="number" value="" name="samples[row_0][purged_volume]" data-index="{{ isset($i) ? $i : 0 }}"/>
                    @endif
                </div>
            </div>
            <div class="flex flex-wrap mt-4">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="multiparameters_{{ isset($i) ? $i : 0 }}" value="{{ __('Multiparâmetros') }}" />
                    @if(isset($sample))
                        <x-jet-input readonly="true" id="multiparameters_{{ isset($i) ? $i : 0 }}" class="form-control block mt-1 w-full" data-index="{{ isset($i) ? $i : 0 }}"
                        type="text" value="{{ $sample['multiparameters'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][multiparameters]' : 'samples[row_0][multiparameters]' }}" maxlength="255" />
                    @else
                        <x-jet-input id="multiparameters_0" class="form-control block mt-1 w-full" type="text" value="" name="samples[row_0][multiparameters]" maxlength="255" data-index="{{ isset($i) ? $i : 0 }}"/>
                    @endif
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="flow_cell_{{ isset($i) ? $i : 0 }}" value="{{ __('Célula de fluxo') }}" />
                    @if(isset($sample))
                        <x-jet-input readonly="true" id="flow_cell_{{ isset($i) ? $i : 0 }}" class="form-control block mt-1 w-full" data-index="{{ isset($i) ? $i : 0 }}"
                        type="text" value="{{ $sample['flow_cell'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][flow_cell]' : 'samples[row_0][flow_cell]' }}" maxlength="255" />
                    @else
                        <x-jet-input id="flow_cell_0" class="form-control block mt-1 w-full" type="text" value="" name="samples[row_0][flow_cell]" maxlength="255" data-index="{{ isset($i) ? $i : 0 }}"/>
                    @endif
                </div>
            </div>
            <div class="flex flex-wrap mt-4">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="bladder_pump_{{ isset($i) ? $i : 0 }}" value="{{ __('Bomba de bexiga') }}" />
                    @if(isset($sample))
                        <x-jet-input readonly="true" id="bladder_pump_{{ isset($i) ? $i : 0 }}" class="form-control block mt-1 w-full" data-index="{{ isset($i) ? $i : 0 }}"
                        type="text" value="{{ $sample['bladder_pump'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][bladder_pump]' : 'samples[row_0][bladder_pump]' }}" maxlength="255" />
                    @else
                        <x-jet-input id="bladder_pump_0" class="form-control block mt-1 w-full" type="text" value="" name="samples[row_0][bladder_pump]" maxlength="255" data-index="{{ isset($i) ? $i : 0 }}"/>
                    @endif
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="hose_lot_{{ isset($i) ? $i : 0 }}" value="{{ __('Lote da mangueira') }}" />
                    @if(isset($sample))
                        <x-jet-input readonly="true" id="hose_lot_{{ isset($i) ? $i : 0 }}" class="form-control block mt-1 w-full" data-index="{{ isset($i) ? $i : 0 }}"
                        type="text" value="{{ $sample['hose_lot'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][hose_lot]' : 'samples[row_0][hose_lot]' }}" maxlength="255" />
                    @else
                        <x-jet-input id="hose_lot_0" class="form-control block mt-1 w-full" type="text" value="" name="samples[row_0][hose_lot]" maxlength="255" data-index="{{ isset($i) ? $i : 0 }}"/>
                    @endif
                </div>
            </div>
            <div class="flex flex-wrap mt-4">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="filter_batch_{{ isset($i) ? $i : 0 }}" value="{{ __('Lote do filtro') }}" />
                    @if(isset($sample))
                        <x-jet-input readonly="true" id="filter_batch_{{ isset($i) ? $i : 0 }}" class="form-control block mt-1 w-full" data-index="{{ isset($i) ? $i : 0 }}"
                        type="text" value="{{ $sample['filter_batch'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][filter_batch]' : 'samples[row_0][filter_batch]' }}" maxlength="255" />
                    @else
                        <x-jet-input id="filter_batch_0" class="form-control block mt-1 w-full" type="text" value="" name="samples[row_0][filter_batch]" maxlength="255" data-index="{{ isset($i) ? $i : 0 }}"/>
                    @endif
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="end_collection_{{ isset($i) ? $i : 0 }}" value="{{ __('Hora (final da coleta)') }}" />
                    @if(isset($sample))
                        <x-jet-input readonly="true" id="end_collection_{{ isset($i) ? $i : 0 }}" class="form-control block mt-1 w-full" data-index="{{ isset($i) ? $i : 0 }}"
                        type="datetime-local" value="{{ $sample['end_collection'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][end_collection]' : 'samples[row_0][end_collection]' }}" />
                    @else
                        <x-jet-input id="end_collection_0" class="form-control block mt-1 w-full" type="datetime-local" value="" name="samples[row_0][end_collection]" data-index="{{ isset($i) ? $i : 0 }}"/>
                    @endif
                </div>
            </div>
            <div class="flex flex-wrap mt-4">
                <div class="w-full md:w-1/2 pl-3 mb-6 md:mb-0">
                    <x-jet-label for="suspended_{{ isset($i) ? $i : 0 }}" value="{{ __('Material em suspensão?') }}" />
                    @if(isset($sample))
                        <x-custom-select id="suspended_{{ isset($i) ? $i : 0 }}"  select-class="no-nice-select" :disabled="true"
                        :options="['SIM' => 'SIM', 'NÃO' => 'NÃO']" value="{{ $sample['suspended'] }}"
                        name="{{ isset($i) ? 'samples[row_' . ($i) . '][suspended]' : 'samples[row_0][suspended]' }}" class="mt-1"/>
                    @else
                        <x-custom-select id="suspended_{{ isset($i) ? $i : 0 }}"  select-class="no-nice-select"
                        :options="['SIM' => 'SIM', 'NÃO' => 'NÃO']" value=""
                        name="samples[row_0][suspended]" class="mt-1"/>
                    @endif
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="ph_{{ isset($i) ? $i : 0 }}" value="{{ __('pH (frasco com ácido)') }}" />
                    @if(isset($sample))
                        <x-jet-input readonly="true" id="ph_{{ isset($i) ? $i : 0 }}" class="form-control block mt-1 w-full" data-index="{{ isset($i) ? $i : 0 }}"
                        type="number" step="any" value="{{ $sample['ph'] }}" name="{{ isset($i) ? 'samples[row_' . ($i) . '][ph]' : 'samples[row_0][ph]' }}" maxlength="255" />
                    @else
                        <x-jet-input id="ph_0" class="form-control block mt-1 w-full" step="any" type="number" value="" name="samples[row_0][ph]" maxlength="255" data-index="{{ isset($i) ? $i : 0 }}"/>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
