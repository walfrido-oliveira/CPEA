<x-app-layout>
    <div class="py-6 create-environmental-agency">
        <div class="max-w-6xl mx-auto px-4">
            <form method="POST" action="{{ route('registers.environmental-agency.store') }}">
                @csrf
                @method("POST")
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Órgão Ambiental') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('registers.environmental-agency.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="internal_id" value="{{ __('Cod Órgão Ambiental') }}" />
                            <x-jet-input id="internal_id" class="form-control block mt-1 w-full" type="text" name="internal_id" maxlength="255" required autofocus autocomplete="internal_id" placeholder="{{ __('Código') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="name" value="{{ __('Nome Órgão Ambiental') }}" />
                            <x-jet-input id="name" class="form-control block mt-1 w-full" type="text" name="name" maxlength="255" required autofocus autocomplete="name" placeholder="{{ __('Nome') }}"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
