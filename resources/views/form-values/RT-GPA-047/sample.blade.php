<div class="flex flex-wrap mx-4 px-3 py-2 mt-4 sample" x-data="showDetails()" id="sample_{{ isset($i) ? $i : 0 }}">
    <div class="flex w-full">
        <h3 class="w-full md:w-1/2 px-3 mb-6 md:mb-0 title">AMOSTRA <span>{{ 1 }}</span></h3>
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
                <div>
                    <input type="hidden" id="sample_index_{{ isset($i) ? $i : 0 }}" name="sample_index" value="row_{{ isset($i) ? $i : 0 }}">
                    <button type="button" class="btn-transition-primary edit-sample px-1" title="Editar Amostra" data-index="sample_{{ isset($i) ? $i : 0 }}" @if(!isset($i)) style="display: none" @endif>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-wiph="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </button>
                    <button type="button" class="btn-transition-primary save-sample px-1" title="Salvar Amostra" data-index="sample_{{ isset($i) ? $i : 0 }}" data-row="{{ isset($i) ? $i : 0 }}"
                    style="display: none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-8 w-8">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-wiph="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </button>
                </div>
            @endif
            <button class="btn-transition-secondary" type="button" id="show_details" @click="isOpen() ? close() : show();">
                <svg xmlns="http://www.w3.org/2000/svg"
                    :class="{ 'rotate-180': isOpen(), 'rotate-0': !isOpen() }"
                    class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7m14-8l-7 7-7-7" />
                </svg>
            </button>
        </div>
    </div>
    <div class="w-full flex">
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
            <x-jet-label for="collect_point" value="{{ __('Ponto de Coleta') }}" />
            <x-jet-input id="collect_point" class="form-control block mt-1 w-full" type="text"  value="{{ isset($formValue) ? $formValue->values['collect_point'] : old('collect_point') }}" name="collect_point" maxlength="255"  placeholder="{{ __('Ponto de Coleta') }}"/>
        </div>
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
            <x-jet-label for="collected_at" value="{{ __('Data/Hora da Coleta') }}" />
            <x-jet-input id="collected_at" class="form-control block mt-1 w-full" type="datetime-local"  name="collected_at" value="{{ isset($formValue) ? $formValue->values['collected_at'] : old('collected_at') }}"/>
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
                    <x-jet-label for="environmental_conditions" value="{{ __('Condições Ambientais nas Últimas 24 hs*') }}" />
                    <x-custom-select  :options="['Com Chuva' => 'Com Chuva', 'Sem Chuva' => 'Sem Chuva']" value="{{ isset($formValue) ? $formValue->values['environmental_conditions'] : old('environmental_conditions') }}" name="environmental_conditions" id="environmental_conditions" class="mt-1"/>
                </div>
            </div>
            <div class="flex flex-wrap mt-4">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="well_depth" value="{{ __('Profundidade do poço (m)') }}" />
                    <x-jet-input id="well_depth" class="form-control block mt-1 w-full" type="number"  step="any" name="well_depth" value="{{ isset($formValue) ? $formValue->values['well_depth'] : old('well_depth') }}"/>
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="water_level" value="{{ __('Nível d´água (m)') }}" />
                    <x-jet-input id="water_level" class="form-control block mt-1 w-full" type="number"  step="any" name="water_level" value="{{ isset($formValue) ? $formValue->values['water_level'] : old('water_level') }}"/>
                </div>
            </div>
            <div class="flex flex-wrap mt-4">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="water_column" value="{{ __('Coluna d\'água (m)') }}"/>
                    <x-jet-input id="water_column" class="form-control block mt-1 w-full" readonly type="number" step="any" name="water_column" value="{{ isset($formValue) ? $formValue->values['water_column'] : old('water_column') }}"/>
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="pump_depth" value="{{ __('Profundidade da bomba') }}" />
                    <x-jet-input id="pump_depth" class="form-control block mt-1 w-full" type="number"  step="any" name="pump_depth" value="{{ isset($formValue) ? $formValue->values['pump_depth'] : old('pump_depth') }}"/>
                </div>
            </div>
            <div class="flex flex-wrap mt-4">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="pressure" value="{{ __('Pressão (psi)') }}" />
                    <x-jet-input id="pressure" class="form-control block mt-1 w-full" type="number"  step="any" name="pressure" value="{{ isset($formValue) ? $formValue->values['pressure'] : old('pressure') }}"/>
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="flow_rate" value="{{ __('Vazão (mL/min)') }}" />
                    <x-jet-input id="flow_rate" class="form-control block mt-1 w-full" type="number"  step="any" name="flow_rate" value="{{ isset($formValue) ? $formValue->values['flow_rate'] : old('flow_rate') }}"/>
                </div>
            </div>
            <div class="flex flex-wrap mt-4">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="fq_parameters" value="{{ __('Intervalo de leitura dos parâmetros FQ após estabilização (min)') }}"/>
                    <x-jet-input id="fq_parameters" class="form-control block mt-1 w-full" readonly type="number"  step="any" name="fq_parameters" value="{{ isset($formValue) ? $formValue->values['fq_parameters'] : old('fq_parameters') }}"/>
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="purged_volume" value="{{ __('Volume purgado (L)') }}" />
                    <x-jet-input id="purged_volume" class="form-control block mt-1 w-full" type="number"  step="any" name="purged_volume" value="{{ isset($formValue) ? $formValue->values['purged_volume'] : old('purged_volume') }}"/>
                </div>
            </div>
            <div class="flex flex-wrap mt-4">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="multiparameters" value="{{ __('Multiparâmetros') }}" />
                    <x-jet-input id="multiparameters" class="form-control block mt-1 w-full" type="text"  name="multiparameters" maxlength="255"  placeholder="{{ __('Multiparâmetros') }}" value="{{ isset($formValue) ? $formValue->values['multiparameters'] : old('multiparameters') }}"/>
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="flow_cell" value="{{ __('Célula de fluxo') }}" />
                    <x-jet-input id="flow_cell" class="form-control block mt-1 w-full" type="text"  name="flow_cell" maxlength="255"  placeholder="{{ __('Célula de fluxo') }}" value="{{ isset($formValue) ? $formValue->values['flow_cell'] : old('flow_cell') }}"/>
                </div>
            </div>
            <div class="flex flex-wrap mt-4">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="bladder_pump" value="{{ __('Bomba de bexiga') }}" />
                    <x-jet-input id="bladder_pump" class="form-control block mt-1 w-full" type="text"  name="bladder_pump" maxlength="255"  placeholder="{{ __('Bomba de bexiga') }}" value="{{ isset($formValue) ? $formValue->values['bladder_pump'] : old('bladder_pump') }}"/>
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="hose_lot" value="{{ __('Lote da mangueira') }}" />
                    <x-jet-input id="hose_lot" class="form-control block mt-1 w-full" type="text"  name="hose_lot" maxlength="255"  placeholder="{{ __('Lote da mangueira') }}" value="{{ isset($formValue) ? $formValue->values['hose_lot'] : old('hose_lot') }}"/>
                </div>
            </div>
            <div class="flex flex-wrap mt-4">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="filter_batch" value="{{ __('Lote do filtro') }}" />
                    <x-jet-input id="filter_batch" class="form-control block mt-1 w-full" type="text"  name="filter_batch" maxlength="255"  placeholder="{{ __('Lote do filtro') }}" value="{{ isset($formValue) ? $formValue->values['filter_batch'] : old('filter_batch') }}"/>
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="end_collection" value="{{ __('Hora (final da coleta)') }}" />
                    <x-jet-input id="end_collection" class="form-control block mt-1 w-full" type="time"  name="end_collection" value="{{ isset($formValue) ? $formValue->values['end_collection'] : old('end_collection') }}"/>
                </div>
            </div>
            <div class="flex flex-wrap mt-4">
                <div class="w-full md:w-1/2 pl-3 mb-6 md:mb-0">
                    <x-jet-label for="suspended" value="{{ __('Material em suspensão?') }}" />
                    <x-custom-select  :options="['SIM' => 'SIM', 'NÃO' => 'NÃO']" name="suspended" id="suspended" value="{{ isset($formValue) ? $formValue->values['suspended'] : old('suspended') }}" class="mt-1"/>
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="ph" value="{{ __('pH (frasco com ácido)') }}" />
                    <x-jet-input id="ph" class="form-control block mt-1 w-full" type="number"  step="any" name="ph" value="{{ isset($formValue) ? $formValue->values['ph'] : old('ph') }}"/>
                </div>
            </div>
            <div class="flex flex-wrap mt-4">
                <div class="w-full pl-3 mb-6 md:mb-0">
                    <x-jet-label for="technician" value="{{ __('Técnico Responsável') }}" />
                    <x-custom-select :options="$users" value="{{ isset($formValue->values['technician']) ? $formValue->values['technician'] : null }}" name="technician" id="technician" class="mt-1"/>
                </div>
            </div>
            <div class="flex flex-wrap mt-4">
                <div class="w-full pl-3 mb-6 md:mb-0">
                    <x-jet-label for="obs" value="{{ __('Observações') }}" />
                   <textarea class="form-input w-full" name="obs" id="obs" cols="30" rows="10"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
