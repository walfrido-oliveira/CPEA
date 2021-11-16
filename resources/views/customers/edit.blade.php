<x-app-layout>
    <div class="py-6 edit-customers">
        <div class="max-w-6xl mx-auto px-4">
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

                    <h2 class="w-full mx-4 px-6 py-2 mt-4">{{ __("Identificação do Ponto") }}</h2>

                    <div class="flex mx-4 px-3 py-2 mt-2">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="areas" value="{{ __('Área') }}" />
                            <x-custom-select :options="$areas" name="areas" id="areas" value="" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-5/12 pl-3 mb-6 md:mb-0">
                            <x-jet-label for="point_identifications" value="{{ __('Identificação Ponto') }}" />
                            <x-custom-select :options="[]" name="point_identifications" id="point_identifications" value="" class="mt-1"/>
                        </div>
                        <div class="flex items-end justify-end pr-3 mb-6 md:mb-0 w-full md:w-1/12">
                            <button type="button" class="btn-transition-secondary" id="point_identifications_add" title="Adicionar novo ponto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                            <button type="button" class="btn-transition-secondary" style="display: none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <h3 class="w-full mx-4 px-6 py-2 mt-2">{{ __("Área") }}</h3>

                    <div class="flex mx-4 px-3 py-2">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <ul id="point_identifications_list" class="block font-medium text-sm text-gray-700">
                                @foreach ($customer->pointIdentifications as $key => $pointIdentification)
                                    <li id="point_identification_{{ $pointIdentification->id }}">
                                        <button type="button" class="btn-transition-danger delete-point-identification">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                             </svg>
                                        </button>
                                        {{ $pointIdentification->area . ', ' . $pointIdentification->identification }}
                                        <input type="hidden" name="point_identification[{{ $key }}]" value="{{ $pointIdentification->id }}">
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('customers.scripts')

</x-app-layout>
