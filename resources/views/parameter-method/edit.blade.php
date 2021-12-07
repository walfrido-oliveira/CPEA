<x-app-layout>
    <div class="py-6 edit-parameter-method">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="{{ route('registers.parameter-method.update', ['parameter_method' => $parameterMethod->id]) }}">
                @csrf
                @method("PUT")
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
                            <x-custom-select :options="$preparationMethod" name="preparation_method_id" id="preparation_method_id" :value="$parameterMethod->preparation_method_id" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="type" value="{{ __('Tipo') }}" required/>
                            <x-custom-select :options="$type" name="type" id="type" :value="$parameterMethod->type" class="mt-1"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="time_preparation" value="{{ __('Prazo Preparo (dias)') }}" required/>
                            <x-jet-input id="time_preparation" class="form-control block mt-1 w-full" type="number" min="1" max="999" name="time_preparation" maxlength="255" autofocus autocomplete="time_preparation" :value="$parameterMethod->time_preparation"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <input id="validate_preparation" type="checkbox" class="form-checkbox" name="validate_preparation" @if($parameterMethod->validate_preparation) checked @endif>
                            <x-jet-label for="validate_preparation" value="{{ __('Validar Preparação') }}" class="inline"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
