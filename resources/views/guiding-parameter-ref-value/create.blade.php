<x-app-layout>
    <div class="py-6 create-guiding-parameter-ref-value">
        <div class="max-w-6xl mx-auto px-4">
            <form method="POST" action="{{ route('guiding-parameter-ref-value.store') }}">
                @csrf
                @method("POST")
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Cadastrar Ref. Vlr. Param. Orientador') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('guiding-parameter-ref-value.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="guiding_parameter_ref_value_id" value="{{ __('Ref. Vlr. Param. Orientador') }}" required />
                            <x-jet-input id="guiding_parameter_ref_value_id" class="form-control block mt-1 w-full" type="text" name="guiding_parameter_ref_value_id" maxlength="255" required autofocus autocomplete="guiding_parameter_ref_value_id" :value="old('guiding_parameter_ref_value_id')"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="observation" value="{{ __('Obs') }}" />
                            <x-jet-input id="observation" class="form-control block mt-1 w-full" type="text" name="observation" maxlength="255"  autofocus autocomplete="observation" :value="old('observation')" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
