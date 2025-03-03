<x-app-layout>
    <div class="py-6 create-parameter-method">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="{{ route('registers.parameter-method.store') }}">
                @csrf
                @method("POST")
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Método/Prazo') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('registers.parameter-method.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="preparation_method_id" value="{{ __('Método') }}" required/>
                            <x-custom-select :options="$preparationMethod" name="preparation_method_id" id="preparation_method_id" :value="old('preparation_method_id')" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="type" value="{{ __('Tipo') }}" required/>
                            <x-custom-select :options="$type" name="type" id="type" :value="old('type')" class="mt-1"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="time_preparation" value="{{ __('Prazo (dias)') }}" required/>
                            <x-jet-input id="time_preparation" class="form-control block mt-1 w-full" type="number" min="1" max="999" name="time_preparation" maxlength="255" autofocus autocomplete="time_preparation" :value="old('time_preparation')"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-input id="validate_preparation" class="form-control" type="checkbox" name="validate_preparation" maxlength="255" autofocus autocomplete="validate_preparation" :value="old('validate_preparation')"/>
                            <x-jet-label for="validate_preparation" value="{{ __('Validar Preparação') }}" class="inline"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
