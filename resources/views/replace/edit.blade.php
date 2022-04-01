<x-app-layout>
    <div class="py-6 edit-replace">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="{{ route('registers.replace.update', ['replace' => $replace->id]) }}">
                @csrf
                @method("PUT")
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Editar De Para') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('registers.replace.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="lab_id" value="{{ __('Custodiante') }}" required/>
                            <x-custom-select :options="$labs" name="lab_id" id="lab_id" :value="$replace->lab_id"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="from" value="{{ __('De') }}" required/>
                            <x-jet-input id="from" class="form-control block mt-1 w-full" type="text" name="from" maxlength="255" required autofocus autocomplete="from" :value="$replace->from" />
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="to" value="{{ __('Para') }}" required/>
                            <x-custom-select :options="$to" name="to" id="to" :value="$replace->to"/>
                            <small><a href="#" class="text-blue-500 underline" id="to_create" title="Adicionar Para">Adiciona novo Para</a></small>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('replace.to-create-modal')
    @include('replace.scripts')

</x-app-layout>
