<x-app-layout>
    <div class="py-6 edit-customers">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="{{ route('customers.update', ['customer' => $customer->id]) }}">
                @csrf
                @method("PUT")
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Editar Cliente') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('customers.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="name" value="{{ __('Nome do Cliente') }}" required/>
                            <x-jet-input id="name" class="form-control block mt-1 w-full" type="text" name="name" maxlength="255" required autofocus autocomplete="name" :value="$customer->name"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="status" value="{{ __('Status') }}" required/>
                            <x-custom-select :options="$status" name="status" id="status" :value="$customer->status" placeholder="{{ __('Situação do Cliente') }}" required class="mt-1"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                            <x-jet-label for="adress" value="{{ __('Endereço') }}"/>
                            <x-jet-input id="adress" class="form-control block mt-1 w-full" type="text" name="adress" maxlength="255" autofocus autocomplete="adress" :value="$customer->adress"/>
                        </div>
                        <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                            <x-jet-label for="number" value="{{ __('Número') }}"/>
                            <x-jet-input id="number" class="form-control block mt-1 w-full" type="text" name="number" maxlength="255" autofocus autocomplete="number" :value="$customer->number"/>
                        </div>
                        <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                            <x-jet-label for="district" value="{{ __('Bairro') }}"/>
                            <x-jet-input id="district" class="form-control block mt-1 w-full" type="text" name="district" maxlength="255" autofocus autocomplete="district" :value="$customer->district"/>
                        </div>
                        <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                            <x-jet-label for="city" value="{{ __('Cidade') }}"/>
                            <x-jet-input id="city" class="form-control block mt-1 w-full" type="text" name="city" maxlength="255" autofocus autocomplete="city" :value="$customer->city"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                            <x-jet-label for="state" value="{{ __('Estado') }}"/>
                            <x-custom-select :options="states()" name="state" id="state" :value="$customer->state" placeholder="{{ __('Estado') }}" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                            <x-jet-label for="cep" value="{{ __('CEP') }}"/>
                            <x-jet-input id="cep" class="form-control block mt-1 w-full" type="text" name="cep" maxlength="255" autofocus autocomplete="cep" :value="$customer->cep"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('customers.scripts')

</x-app-layout>
