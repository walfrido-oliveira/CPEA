<x-app-layout>
    <div class="py-6 create-point-identification">
        <div class="max-w-6xl mx-auto px-4">
            <form method="POST" action="{{ route('registers.point-identification.store') }}">
                @csrf
                @method("POST")
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Cadastrar Ponto') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('registers.point-identification.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="area" value="{{ __('Área') }}" required />
                            <x-jet-input id="area" class="form-control block mt-1 w-full" type="text" name="area" maxlength="255" required autofocus autocomplete="area" :value="old('area')"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="identification" value="{{ __('Identificação do Ponto') }}" required/>
                            <x-jet-input id="identification" class="form-control block mt-1 w-full" type="text" name="identification" maxlength="255" required autofocus autocomplete="identification" :value="old('identification')" />
                        </div>
                    </div>

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="utm_me_coordinate" value="{{ __('Coordenada UTM ME') }}" />
                            <x-jet-input id="utm_me_coordinate" class="form-control block mt-1 w-full" type="number" name="utm_me_coordinate" maxlength="18" autofocus autocomplete="utm_me_coordinate" :value="old('utm_me_coordinate')"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="utm_mm_coordinate" value="{{ __('Coordenada UTM MM') }}" />
                            <x-jet-input id="utm_mm_coordinate" class="form-control block mt-1 w-full" type="number" name="utm_mm_coordinate" maxlength="18" autofocus autocomplete="utm_mm_coordinate" :value="old('utm_mm_coordinate')"/>
                        </div>
                    </div>

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="pool_depth" value="{{ __('Profundidade Poço') }}" />
                            <x-jet-input id="pool_depth" class="form-control block mt-1 w-full" type="number" name="pool_depth" maxlength="18" autofocus autocomplete="pool_depth" :value="old('pool_depth')"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="utm_mm_coordinate" value="{{ __('Sistema Geodesico') }}" required/>
                            <x-custom-select :options="$geodeticSystems" name="geodetic_system_id" id="geodetic_system_id" :value="old('geodetic_system_id')" required/>
                        </div>
                    </div>

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="pool_diameter" value="{{ __('Diâmetro Poço') }}" />
                            <x-jet-input id="pool_diameter" class="form-control block mt-1 w-full" type="number" name="pool_diameter" maxlength="18" autofocus autocomplete="pool_diameter" :value="old('pool_diameter')" />
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="water_depth" value="{{ __('Profundidade Nível Água') }}" />
                            <x-jet-input id="water_depth" class="form-control block mt-1 w-full" type="number" name="water_depth" maxlength="18" autofocus autocomplete="water_depth" :value="old('water_depth')"/>
                        </div>
                    </div>

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="sedimentary_collection_depth" value="{{ __('Profundidade Col. Sedmentar') }}"  />
                            <x-jet-input id="sedimentary_collection_depth" class="form-control block mt-1 w-full" type="number" name="sedimentary_collection_depth" maxlength="18" autofocus autocomplete="sedimentary_collection_depth" :value="old('sedimentary_collection_depth')"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="pool_volume" value="{{ __('Volue Poço') }}" />
                            <x-jet-input id="pool_volume" class="form-control block mt-1 w-full" type="number" name="pool_volume" maxlength="18" autofocus autocomplete="pool_volume"  :value="old('pool_volume')"/>
                        </div>
                    </div>

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="collection_depth" value="{{ __('Profundidade Col Coleta') }}"  />
                            <x-jet-input id="collection_depth" class="form-control block mt-1 w-full" type="number" name="collection_depth" maxlength="18" autofocus autocomplete="collection_depth" :value="old('collection_depth')"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="water_collection_depth" value="{{ __('Profundidade Col Água') }}" />
                            <x-jet-input id="water_collection_depth" class="form-control block mt-1 w-full" type="number" name="water_collection_depth" maxlength="18" autofocus autocomplete="water_collection_depth" :value="old('water_collection_depth')"/>
                        </div>
                    </div>

                    <div class="sm:flex sm:items-start mx-4 px-3 py-2 mt-4">
                        <div class="relative w-full max-w-xs md:max-w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="utm_mm_coordinate" value="{{ __('Cliente') }}"/>
                            <x-custom-select :options="[]" name="customer" id="customer" :value="null"/>
                        </div>
                        <div class="relative w-full sm:w-auto block md:mt-5">
                            <button class="btn-transition-warning" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-700"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex flex-wrap mx-4 px-3 py-2 md:mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <span class="block font-medium text-sm text-gray-700">{{ __("Clientes Associados") }}</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
