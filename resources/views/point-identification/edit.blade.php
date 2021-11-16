<x-app-layout>
    <div class="py-6 edit-point-identification">
        <div class="max-w-6xl mx-auto px-4">
            <form method="POST" action="{{ route('registers.point-identification.update', ['point_identification' => $pointIdentification->id]) }}">
                @csrf
                @method("PUT")
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Editar Ponto') }}</h1>
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
                            <x-jet-label for="area" value="{{ __('Área') }}" />
                            <x-jet-input id="area" class="form-control block mt-1 w-full" type="text" name="area" maxlength="255" :value="$pointIdentification->area" required autofocus autocomplete="area" placeholder="{{ __('Área') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="identification" value="{{ __('Identificação do Ponto') }}" />
                            <x-jet-input id="identification" class="form-control block mt-1 w-full" type="text" name="identification" maxlength="255" :value="$pointIdentification->identification" required autofocus autocomplete="identification" placeholder="{{ __('Identificação') }}"/>
                        </div>
                    </div>

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="utm_me_coordinate" value="{{ __('Coordenada UTM ME') }}" />
                            <x-jet-input id="utm_me_coordinate" class="form-control block mt-1 w-full" type="number" name="utm_me_coordinate" maxlength="18" step="any" autofocus autocomplete="utm_me_coordinate" :value="$pointIdentification->utm_me_coordinate"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="utm_mm_coordinate" value="{{ __('Coordenada UTM MM') }}" />
                            <x-jet-input id="utm_mm_coordinate" class="form-control block mt-1 w-full" type="number" name="utm_mm_coordinate" maxlength="18" step="any"  autofocus autocomplete="utm_mm_coordinate" :value="$pointIdentification->utm_mm_coordinate"/>
                        </div>
                    </div>

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="pool_depth" value="{{ __('Profundidade Poço') }}" />
                            <x-jet-input id="pool_depth" class="form-control block mt-1 w-full" type="number" name="pool_depth" maxlength="18" step="any" autofocus autocomplete="pool_depth" :value="$pointIdentification->pool_depth"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="geodetic_system_id" value="{{ __('Sistema Geodesico') }}" />
                            <x-custom-select :options="$geodeticSystems" name="geodetic_system_id" id="geodetic_system_id" :value="$pointIdentification->geodeticSystem->id" />
                        </div>
                    </div>

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="pool_diameter" value="{{ __('Diâmetro Poço') }}" />
                            <x-jet-input id="pool_diameter" class="form-control block mt-1 w-full" type="number" name="pool_diameter" maxlength="18" step="any" autofocus autocomplete="pool_diameter" :value="$pointIdentification->pool_diameter" />
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="water_depth" value="{{ __('Profundidade Nível Água') }}" />
                            <x-jet-input id="water_depth" class="form-control block mt-1 w-full" type="number" name="water_depth" maxlength="18" step="any" autofocus autocomplete="water_depth" :value="$pointIdentification->water_depth"/>
                        </div>
                    </div>

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="sedimentary_collection_depth" value="{{ __('Profundidade Col. Sedmentar') }}"  />
                            <x-jet-input id="sedimentary_collection_depth" class="form-control block mt-1 w-full" type="number" name="sedimentary_collection_depth" maxlength="18" step="any" autofocus autocomplete="sedimentary_collection_depth" :value="$pointIdentification->sedimentary_collection_depth"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="pool_volume" value="{{ __('Volume Poço') }}" />
                            <x-jet-input id="pool_volume" class="form-control block mt-1 w-full" type="number" name="pool_volume" maxlength="18" step="any" autofocus autocomplete="pool_volume"  :value="$pointIdentification->pool_volume"/>
                        </div>
                    </div>

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="collection_depth" value="{{ __('Profundidade Col Coleta') }}"  />
                            <x-jet-input id="collection_depth" class="form-control block mt-1 w-full" type="number" name="collection_depth" maxlength="18" step="any" autofocus autocomplete="collection_depth" :value="$pointIdentification->collection_depth"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="water_collection_depth" value="{{ __('Profundidade Col Água') }}" />
                            <x-jet-input id="water_collection_depth" class="form-control block mt-1 w-full" type="number" name="water_collection_depth" step="any" maxlength="18" autofocus autocomplete="water_collection_depth" :value="$pointIdentification->water_collection_depth"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
