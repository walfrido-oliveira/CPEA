<x-app-layout>
    <div class="py-6 edit-unity">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="{{ route('registers.unity.update', ['unity' => $unity->id]) }}">
                @csrf
                @method("PUT")
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Editar Unidade') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('registers.unity.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="unity_cod" value="{{ __('Cod. Unidade') }}" required/>
                            <x-jet-input id="unity_cod" class="form-control block mt-1 w-full" type="text" name="unity_cod" maxlength="255" required autofocus autocomplete="unity_cod" :value="$unity->unity_cod"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="unity_cod" value="{{ __('Nome Unidade') }}" required/>
                            <x-jet-input id="name" class="form-control block mt-1 w-full" type="text" name="name" maxlength="255" autofocus autocomplete="name" required :value="$unity->name"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="conversion_amount" value="{{ __('Qtd. Conversão') }}" />
                            <x-jet-input id="conversion_amount" class="form-control block mt-1 w-full" type="number" name="conversion_amount" step="any" maxlength="18" autofocus autocomplete="conversion_amount" :value="$unity->conversion_amount"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="unity_id" value="{{ __('Unidade Conversão') }}" />
                            <x-custom-select :options="$unities" name="unity_id" id="unity_id" :value="$unity->unity_id" class="mt-1"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
