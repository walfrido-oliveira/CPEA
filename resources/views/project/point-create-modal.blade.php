<!-- Modal -->
<div class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="point_create_modal" data-url="">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
              <h3 class="text-lg leading-6 font-medium text-gray-900 sm:ml-4 " id="modal-title">
                {{ __('Adicionar novo Ponto') }}
              </h3>
              <div class="mt-2">
                <form method="POST" id="poinst_create_form" action="{{ route('registers.point-identification.simple-create') }}">
                    @csrf
                    @method("POST")

                    <div class="flex flex-wrap py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="area" value="{{ __('Área') }}" required />
                            <x-jet-input id="area" class="form-control block mt-1 w-full" type="text" name="area" maxlength="255" required autofocus autocomplete="area" :value="old('area')"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="identification" value="{{ __('Identificação do Ponto') }}" required/>
                            <x-jet-input id="identification" class="form-control block mt-1 w-full" type="text" name="identification" maxlength="255" required autofocus autocomplete="identification" :value="old('identification')" />
                        </div>
                    </div>
                    <div class="flex flex-wrap py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="geodetic_system_id" value="{{ __('Sistema Geodesico') }}" required/>
                            <x-custom-select :options="$geodeticSystems" name="geodetic_system_id" id="geodetic_system_id" :value="old('geodetic_system_id')" required/>
                        </div>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button type="button" id="point_confirm_modal" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
            {{ __('Confirmar') }}
          </button>
          <button type="button" id="point_cancel_modal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
            {{ __('Cancelar') }}
          </button>
        </div>
      </div>
    </div>
  </div>
