<x-app-layout>
    <div class="py-6 ref">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="{{ route('fields.ref.update', ['ref' => $ref->id]) }}">
                @csrf
                @method("PUT")
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
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="name" value="{{ __('Nome da Referência') }}" required/>
                            <x-jet-input id="name" class="form-control block mt-1 w-full" type="text" name="name" maxlength="255" :value="$ref->name" required/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="field_type_id" value="{{ __('Matriz') }}" />
                            <x-custom-select :options="$fields" name="field_type_id" id="field_type_id" :value="$ref->field_type_id" class="mt-1"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="type" value="{{ __('Tipo') }}" />
                            <x-custom-select :options="$types" name="type" id="type" :value="$ref->type" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="params" value="{{ __('Parametros') }}" />
                            @php $paramsValue = []; @endphp
                            @if(is_array($ref->params))
                                @foreach ($params as $key => $param)
                                    @if(in_array($key, $ref->params))
                                        @php
                                            $paramsValue[$key] = $param;
                                        @endphp
                                    @endif
                                @endforeach
                            @endif
                            <x-custom-multi-select multiple :options="$params" name="params[]" id="params" :value="$paramsValue" select-class="form-input" class="mt-1" no-filter="no-filter"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="additional_info" value="{{ __('Descrição') }}" />
                            <textarea class="form-input w-full" name="desc" id="desc" cols="30" rows="10">{{ $ref->desc }}</textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
