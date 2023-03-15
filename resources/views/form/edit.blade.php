<x-app-layout>
    <div class="py-6 form">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="{{ route('fields.form.update', ['form' => $form->id]) }}">
                @csrf
                @method("PUT")
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Formulário') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('fields.form.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="name" value="{{ __('Nome') }}" required/>
                            <x-jet-input id="name" class="form-control block mt-1 w-full" :value="$form->name" type="text" name="name" maxlength="255" required autofocus autocomplete="name" placeholder="{{ __('Nome') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="identification" value="{{ __('Identificação') }}" required/>
                            <x-jet-input id="identification" class="form-control block mt-1 w-full" type="text" :value="$form->identification" name="identification" maxlength="255" required autofocus autocomplete="identification" placeholder="{{ __('Identificação') }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="ref" value="{{ __('Referência') }}" required/>
                            <x-jet-input id="ref" class="form-control block mt-1 w-full" type="text" :value="$form->ref" name="ref" maxlength="255" required autofocus autocomplete="ref" placeholder="{{ __('Referência') }}"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="version" value="{{ __('Versão') }}" required/>
                            <x-jet-input id="version" class="form-control block mt-1 w-full" type="text" :value="$form->version" name="version" maxlength="255" required autofocus autocomplete="version" placeholder="{{ __('Versão') }}"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="published_at" value="{{ __('Publicação') }}" required/>
                            <x-jet-input id="published_at" class="form-control block mt-1 w-full" :value="$form->published_at ? $form->published_at->format('Y-m-d') : null" type="date" name="published_at" required autofocus autocomplete="published_at" />
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="infos" value="{{ __('Informações') }}" />
                            <textarea class="editor form-input w-full ckeditor" name="infos" id="additional_info" cols="30" rows="10">{{ $form->infos }}</textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
