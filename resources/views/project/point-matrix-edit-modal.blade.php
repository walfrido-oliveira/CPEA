<!-- Modal -->
<div class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="point_matrix_edit_modal" data-url="">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-5xl sm:w-full">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                <div class="flex md:flex-row flex-col">
                    <h3 class="flex items-center md:justify-start justify-center text-lg leading-6 font-medium text-gray-900 sm:ml-4 " id="modal-title">
                        {{ __('Ponto/Matriz') }}
                    </h3>
                      <div class="w-full flex md:justify-end justify-center md:flex-nowrap flex-wrap px-3">
                        <button type="button" class="btn-outline-info" id="point_create" title="Adicionar novo ponto">
                            Novo Ponto
                        </button>
                    </div>
                </div>
              <div class="flex flex-wrap py-2">
                <div class="w-full px-3 mb-6 md:mb-0">
                    <x-jet-label for="campaign_id" value="{{ __('Campanha') }}" required/>
                    <x-custom-select :options="$campaigns" name="campaign_id" id="campaign_id" value="" class="mt-1" no-filter="no-filter"/>
                </div>
                </div>
                <div class="flex flex-wrap py-2">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <x-jet-label for="area" value="{{ __('Área') }}" required />
                        <x-custom-select :options="$areas" name="areas" id="areas" value="" class="mt-1" no-filter="no-filter"/>
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <x-jet-label for="point_identifications" value="{{ __('Identificação Ponto') }}" required/>
                        <x-custom-select :options="[]" name="point_identifications" id="point_identifications" value="" class="mt-1" no-filter="no-filter"/>
                    </div>
                </div>
                <div class="flex flex-wrap py-2">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <x-jet-label for="matriz_id" value="{{ __('Matriz') }}" required/>
                        <x-custom-select :options="$matrizeces" name="matriz_id" id="matriz_id" value="" class="mt-1" no-filter="no-filter"/>
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <x-jet-label for="date_collection" value="{{ __('DT/HR da Coleta') }}" required/>
                        <x-jet-input id="date_collection" class="form-control block mt-1 w-full" type="datetime-local" name="date_collection" maxlength="255" autofocus autocomplete="date_collection"/>
                    </div>
                </div>
                <div class="flex flex-wrap py-2">
                    <div class="w-full px-3 mb-6 md:mb-0">
                        <x-jet-label for="guiding_parameters_id" value="{{ __('Param. Orientador Ambiental') }}"/>
                        <x-custom-multi-select multiple :options="$guidingParameters" name="guiding_parameters_id" id="guiding_parameters_id" value="" select-class="form-input" class="mt-1" no-filter="no-filter"/>
                    </div>
                </div>
                <div class="flex flex-wrap py-2">
                    <div class="w-full px-3 mb-6 md:mb-0">
                        <div>
                            <button type="button" class="btn-transition inline text-green-600" id="change_point_add_method" title="Mudar forma de adicionar ponto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M5 12a1 1 0 102 0V6.414l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L5 6.414V12zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z" />
                                </svg>
                            </button>
                            <x-jet-label class="inline" id="analysis_parameter_id_label" for="analysis_parameter_id" value="{{ __('Param. Análise') }}" required/>
                            <x-jet-label class="inline hidden" id="analysis_parameter_group_id_label" for="analysis_parameter_group_id" value="{{ __('Param. Análise Grupo') }}" required/>
                        </div>
                        <x-custom-select :options="$parameterAnalyses" name="analysis_parameter_id" id="analysis_parameter_id" value="" class="mt-1" no-filter="no-filter"/>
                        <x-custom-multi-select multiple :options="$parameterAnalyseGroups" name="analysis_parameter_group_id" id="analysis_parameter_group_id" value="" select-class="form-input" class="mt-1 hidden" no-filter="no-filter"/>
                        <x-jet-label class="inline hidden" id="analysis_parameter_ids_label" for="analysis_parameter_ids_label" value="{{ __('Param. Análise') }}" required/>
                        <x-custom-multi-select multiple :options="[]" name="analysis_parameter_ids" id="analysis_parameter_ids" value="" select-class="form-input" class="mt-1 hidden" no-filter="no-filter"/>
                    </div>
                </div>
                <div class="flex flex-wrap py-2">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <x-jet-label for="parameter_method_preparation_id" value="{{ __('Método Preparo') }}"/>
                        <x-custom-select :options="$preparationMethods" name="parameter_method_preparation_id" id="parameter_method_preparation_id" value="" select-class="form-input" class="mt-1" no-filter="no-filter"/>
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <x-jet-label for="parameter_method_analysis_id" value="{{ __('Método Análise') }}"/>
                        <x-custom-select :options="$analysisMethods" name="parameter_method_analysis_id" id="parameter_method_analysis_id" value="" select-class="form-input" class="mt-1" no-filter="no-filter"/>
                    </div>
                </div>
                <div id="point_matrix_fields">

                </div>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button type="button" id="point_matrix_confirm_modal" data-row="" data-type="save" data-id="" class="save-point-matrix w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
            {{ __('Confirmar') }}
          </button>
          <button type="button" id="point_matrix_cancel_modal_2" data-row="" data-type="cancel" data-id=""  class="cancel-point-matrix mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
            {{ __('Cancelar') }}
          </button>
        </div>
      </div>
    </div>
  </div>
