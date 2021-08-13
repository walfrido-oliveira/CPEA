<x-app-layout>
    <div class="py-6 create-guiding-parameter">
        <div class="max-w-6xl mx-auto px-4">
            <form method="POST" action="{{ route('guiding-parameter.store') }}">
                @csrf
                @method("POST")
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Cadastrar param. Orientador') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('guiding-parameter.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="environmental_guiding_parameter_id" value="{{ __('Cod. Param. Orientador Ambiental') }}" required />
                            <x-jet-input id="environmental_guiding_parameter_id" class="form-control block mt-1 w-full" type="text" name="environmental_guiding_parameter_id" maxlength="255" required autofocus autocomplete="environmental_guiding_parameter_id" :value="old('environmental_guiding_parameter_id')"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="name" value="{{ __('Nome Param. Orientador') }}" required/>
                            <x-jet-input id="name" class="form-control block mt-1 w-full" type="text" name="name" maxlength="255" required autofocus autocomplete="name" :value="old('name')" />
                        </div>
                    </div>

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="environmental_area_id" value="{{ __('Tipo Área Ambiental') }}" />
                            <x-custom-select :options="$environmentalAreas" name="environmental_area_id" id="environmental_area_id" :value="old('environmental_area_id')"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="environmental_agency_id" value="{{ __('Órgão Ambiental') }}"/>
                            <x-custom-select :options="$environmentalAgencies" name="environmental_agency_id" id="environmental_agency_id" :value="old('environmental_agency_id')"/>
                        </div>
                    </div>

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="customer_id" value="{{ __('Cliente') }}" required/>
                            <x-custom-select :options="$customers" name="customer_id" id="customer_id" :value="old('customer_id')"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="resolutions" value="{{ __('Resoluções') }}"/>
                            <x-jet-input id="resolutions" class="form-control block mt-1 w-full" type="text" name="resolutions" maxlength="255" autofocus autocomplete="resolutions" :value="old('resolutions')" />
                        </div>
                    </div>

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="articles" value="{{ __('Artigos') }}" />
                            <x-jet-input id="articles" class="form-control block mt-1 w-full" type="text" name="articles" maxlength="255" autofocus autocomplete="articles" :value="old('articles')"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="observation" value="{{ __('Obs') }}"/>
                            <x-jet-input id="observation" class="form-control block mt-1 w-full" type="text" name="observation" maxlength="255" autofocus autocomplete="observation" :value="old('observation')" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
