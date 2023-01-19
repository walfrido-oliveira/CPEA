<x-app-layout>
    <div class="py-6 ref">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="{{ route('fields.ref.store') }}">
                @csrf
                @method("POST")
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Referências') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('fields.ref.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        @foreach ($form->formFields as $field)
                            <div class="{{ $field->class }}">
                                <x-jet-label for="{{ $field->name }}" value="{{ $field->label }}" required/>

                                @switch($field->type)
                                    @case('text')
                                        <x-jet-input id="{{ $field->name }}" class="form-control block mt-1 w-full" type="{{ $field->type }}" name="{{ $field->name }}" maxlength="255" required/>
                                        @break
                                    @case('select')
                                        <div class="inline-block relative w-full">
                                            <select class="block w-full custom-select">
                                                <option value="">Selecione um valor</option>
                                                @php
                                                    $index = 0;
                                                @endphp
                                                @foreach (call_user_func($field->options) as $key => $item)
                                                    <option  value="{{ $key }}">{{ __($item) }}</option>
                                                    @php
                                                        $index++;
                                                    @endphp
                                                @endforeach
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                            </div>
                                        </div>

                                        @break
                                    @default

                                @endswitch
                            </div>
                        @endforeach
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
