<div class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="environment_modal">
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
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Condições Ambientais
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Adicione a condição ambiental para o período informado.</p>
                            <div class="flex flex-wrap mt-2 w-full">
                                <div class="w-full md:w-1/2 pr-3 mb-6 md:mb-0">
                                    <x-jet-label for="date_start" value="{{ __('Início') }}" />
                                    <x-jet-input id="date_start" class="form-control block mt-1 w-full" type="date" value="" name="date_start" />
                                </div>
                                <div class="w-full md:w-1/2 pr-3 mb-6 md:mb-0">
                                    <x-jet-label for="date_end" value="{{ __('Fim') }}" />
                                    <x-jet-input id="date_end" class="form-control block mt-1 w-full" type="date" value="" name="date_end" />
                                </div>
                            </div>
                            <div class="flex flex-wrap mt-2 w-full">
                                <div class="w-full md:w-1/2 pr-3 mb-6 md:mb-0">
                                    <x-jet-label for="environment_value" value="{{ __('Condições ambientais nas últimas 24 hs') }}" />
                                    <x-jet-input id="environment_value" class="form-control block mt-1 w-full" type="text" value="" name="environment_value" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="confirm_environment_modal" class="btn-confirm" data-index="" data-row="">
                    Confirmar
                </button>
                <button type="button" id="cancel_environment_modal" class="btn-cancel" >
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>
