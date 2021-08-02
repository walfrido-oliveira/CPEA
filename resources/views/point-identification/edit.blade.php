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
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
