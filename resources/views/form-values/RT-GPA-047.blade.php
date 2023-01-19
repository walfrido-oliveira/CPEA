<x-app-layout>
    <div class="py-6 ref">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="@if(!$formValue) {{ route('fields.form-values.store') }} @else {{ route('fields.form-values.update', ['form_value' => $formValue->id]) }} @endif">
                @csrf
                @if(!$formValue) @method("POST") @endif
                @if($formValue) @method("PUT") @endif

                <input type="hidden" name="form_id" value="{{ $form->id }}">
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Formulário')}}  {{ $form->name }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Salvar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('fields.form-values.index') }}" class="btn-outline-danger">{{ __('Voltar') }}</a>
                        </div>
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
                            <x-jet-label for="client" value="{{ __('Cliente') }}" />
                            <x-jet-input  id="client" class="form-control block mt-1 w-full" type="text" value="{{ isset($formValue) ? $formValue->values['client'] : old('client') }}" name="client" maxlength="255"  placeholder="{{ __('Cliente') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="project_id" value="{{ __('Projeto') }}"/>
                            <x-jet-input id="project_id" class="form-control block mt-1 w-full" type="text" name="project_id" maxlength="255" value="{{ isset($formValue) ? $formValue->values['project_id'] : old('project_id') }}" readonly placeholder="{{ __('Projeto') }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full pl-3 mb-6 md:mb-0">
                            <x-jet-label for="field_team" value="{{ __('Equipe de Campo') }}" />
                            <x-custom-select   :options="\App\Models\User::all()->pluck('full_name', 'full_name')" value="{{ isset($formValue) ? $formValue->values['field_team'] : old('field_team') }}" name="field_team" id="field_team" class="mt-1"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="collect_point" value="{{ __('Ponto de Coleta') }}" />
                            <x-jet-input id="collect_point" class="form-control block mt-1 w-full" type="text"  value="{{ isset($formValue) ? $formValue->values['collect_point'] : old('collect_point') }}" name="collect_point" maxlength="255"  placeholder="{{ __('Ponto de Coleta') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="collected_at" value="{{ __('Data/Hora da Coleta') }}" />
                            <x-jet-input id="collected_at" class="form-control block mt-1 w-full" type="date"  name="collected_at" value="{{ isset($formValue) ? $formValue->values['collected_at'] : old('collected_at') }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 pl-3 mb-6 md:mb-0">
                            <x-jet-label for="environmental_conditions" value="{{ __('Condições Ambientais nas Últimas 24 hs*') }}" />
                            <x-custom-select  :options="['Com Chuva' => 'Com Chuva', 'Sem Chuva' => 'Sem Chuva']" value="{{ isset($formValue) ? $formValue->values['environmental_conditions'] : old('environmental_conditions') }}" name="environmental_conditions" id="environmental_conditions" class="mt-1"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="well_depth" value="{{ __('Profundidade do poço (m)') }}" />
                            <x-jet-input id="well_depth" class="form-control block mt-1 w-full" type="number"  step="any" name="well_depth" value="{{ isset($formValue) ? $formValue->values['well_depth'] : old('well_depth') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="water_level" value="{{ __('Nível d´água (m)') }}" />
                            <x-jet-input id="water_level" class="form-control block mt-1 w-full" type="number"  step="any" name="water_level" value="{{ isset($formValue) ? $formValue->values['water_level'] : old('water_level') }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="water_column" value="{{ __('Coluna d\'água (m)') }}"/>
                            <x-jet-input id="water_column" class="form-control block mt-1 w-full" readonly type="number" step="any" name="water_column" value="{{ isset($formValue) ? $formValue->values['water_column'] : old('water_column') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="pump_depth" value="{{ __('Profundidade da bomba') }}" />
                            <x-jet-input id="pump_depth" class="form-control block mt-1 w-full" type="number"  step="any" name="pump_depth" value="{{ isset($formValue) ? $formValue->values['pump_depth'] : old('pump_depth') }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="pressure" value="{{ __('Pressão (psi)') }}" />
                            <x-jet-input id="pressure" class="form-control block mt-1 w-full" type="number"  step="any" name="pressure" value="{{ isset($formValue) ? $formValue->values['pressure'] : old('pressure') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="flow_rate" value="{{ __('Vazão (mL/min)') }}" />
                            <x-jet-input id="flow_rate" class="form-control block mt-1 w-full" type="number"  step="any" name="flow_rate" value="{{ isset($formValue) ? $formValue->values['flow_rate'] : old('flow_rate') }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="fq_parameters" value="{{ __('Intervalo de leitura dos parâmetros FQ após estabilização (min)') }}"/>
                            <x-jet-input id="fq_parameters" class="form-control block mt-1 w-full" readonly type="number"  step="any" name="fq_parameters" value="{{ isset($formValue) ? $formValue->values['fq_parameters'] : old('fq_parameters') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="purged_volume" value="{{ __('Volume purgado (L)') }}" />
                            <x-jet-input id="purged_volume" class="form-control block mt-1 w-full" type="number"  step="any" name="purged_volume" value="{{ isset($formValue) ? $formValue->values['purged_volume'] : old('purged_volume') }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="multiparameters" value="{{ __('Multiparâmetros') }}" />
                            <x-jet-input id="multiparameters" class="form-control block mt-1 w-full" type="text"  name="multiparameters" maxlength="255"  placeholder="{{ __('Multiparâmetros') }}" value="{{ isset($formValue) ? $formValue->values['multiparameters'] : old('multiparameters') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="flow_cell" value="{{ __('Célula de fluxo') }}" />
                            <x-jet-input id="flow_cell" class="form-control block mt-1 w-full" type="text"  name="flow_cell" maxlength="255"  placeholder="{{ __('Célula de fluxo') }}" value="{{ isset($formValue) ? $formValue->values['flow_cell'] : old('flow_cell') }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="bladder_pump" value="{{ __('Bomba de bexiga') }}" />
                            <x-jet-input id="bladder_pump" class="form-control block mt-1 w-full" type="text"  name="bladder_pump" maxlength="255"  placeholder="{{ __('Bomba de bexiga') }}" value="{{ isset($formValue) ? $formValue->values['bladder_pump'] : old('bladder_pump') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="hose_lot" value="{{ __('Lote da mangueira') }}" />
                            <x-jet-input id="hose_lot" class="form-control block mt-1 w-full" type="text"  name="hose_lot" maxlength="255"  placeholder="{{ __('Lote da mangueira') }}" value="{{ isset($formValue) ? $formValue->values['hose_lot'] : old('hose_lot') }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="filter_batch" value="{{ __('Lote do filtro') }}" />
                            <x-jet-input id="filter_batch" class="form-control block mt-1 w-full" type="text"  name="filter_batch" maxlength="255"  placeholder="{{ __('Lote do filtro') }}" value="{{ isset($formValue) ? $formValue->values['filter_batch'] : old('filter_batch') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="end_collection" value="{{ __('Hora (final da coleta)') }}" />
                            <x-jet-input id="end_collection" class="form-control block mt-1 w-full" type="time"  name="end_collection" value="{{ isset($formValue) ? $formValue->values['end_collection'] : old('end_collection') }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 pl-3 mb-6 md:mb-0">
                            <x-jet-label for="suspended" value="{{ __('Material em suspensão?') }}" />
                            <x-custom-select  :options="['SIM' => 'SIM', 'NÃO' => 'NÃO']" name="suspended" id="suspended" value="{{ isset($formValue) ? $formValue->values['suspended'] : old('suspended') }}" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="ph" value="{{ __('pH (frasco com ácido)') }}" />
                            <x-jet-input id="ph" class="form-control block mt-1 w-full" type="number"  step="any" name="ph" value="{{ isset($formValue) ? $formValue->values['ph'] : old('ph') }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full pl-3 mb-6 md:mb-0">
                            <x-jet-label for="technician" value="{{ __('Técnico Responsável') }}" />
                            <x-jet-input id="technician" class="form-control block mt-1 w-full"  type="text" name="technician" maxlength="255" value="{{ isset($formValue) ? $formValue->values['technician'] : old('technician') }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full pl-3 mb-6 md:mb-0">
                            <x-jet-label for="obs" value="{{ __('Observações') }}" />
                           <textarea class="form-input w-full" name="obs" id="obs" cols="30" rows="10" {{ $formValue ? "disabled" : '' }}></textarea>
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
                {!! $form->renderizedInfos !!}
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
    </script>

    <script>
        var wellDepth = document.getElementById("well_depth");
        var waterLevel = document.getElementById("water_level");
        var waterColumn = document.getElementById("water_column");

        var fqParameters =document.getElementById("fq_parameters");
        var pumpDepth = document.getElementById("pump_depth");
        var flowRate = document.getElementById("flow_rate");

        var fieldTeam = document.getElementById("field_team");
        var technician = document.getElementById("technician");

        function calcFqParameters() {
            const pumpDepthValue = pumpDepth.value;
            const flowRateValue = flowRate.value;
            fqParameters.value = (180 + (12 * pumpDepthValue) + 85) / flowRateValue;
        }

        function calcWaterColumn() {
            const wellDepthValue = wellDepth.value;
            const waterLevelValue = waterLevel.value;
            waterColumn.value = wellDepthValue - waterLevelValue;
        }

        fieldTeam.addEventListener("change", function() {
            technician.value = fieldTeam.value;
        });

        flowRate.addEventListener("change", function() {
            calcFqParameters();
        });

        pumpDepth.addEventListener("change", function() {
            calcFqParameters();
        });

        wellDepth.addEventListener("change", function() {
            calcWaterColumn();
        });

        waterLevel.addEventListener("change", function() {
            calcWaterColumn();
        });
    </script>


</x-app-layout>
