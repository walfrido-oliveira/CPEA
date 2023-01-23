<x-app-layout>
    <div class="py-6 ref">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="@if(!$formValue) {{ route('fields.form-values.store') }} @else {{ route('fields.form-values.update', ['form_value' => $formValue->id]) }} @endif">
                @csrf
                @if(!$formValue) @method("POST") @endif
                @if($formValue) @method("PUT") @endif

                @if($formValue)
                    <input type="hidden" id="form_value_id" name="form_value_id" value="{{ $formValue->id }}">
                @endif

                <input type="hidden" id="form_id" name="form_id" value="{{ $form->id }}">

                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Formulário')}}  {{ $form->name }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Salvar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('fields.form-values.index') }}" class="btn-outline-danger">{{ __('Voltar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <h1 class="w-full md:w-1/2 px-3 mb-6 md:mb-0"></h1>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 flex justify-end">
                            <button type="button" title="Ajuda" id="help">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="project_id" value="{{ __('Projeto') }}"/>
                            <x-jet-input id="project_id" class="form-control block mt-1 w-full" type="text" name="project_id" maxlength="255" value="{{ isset($formValue) ? $formValue->values['project_id'] : old('project_id') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="client" value="{{ __('Cliente') }}" />
                            <x-custom-select :options="$customers" value="{{ isset($formValue->values['client']) ? $formValue->values['client'] : null }}" name="client" id="client" class="mt-1"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full pl-3 mb-6 md:mb-0">
                            <x-jet-label for="field_team" value="{{ __('Equipe de Campo') }}" />
                            <select class="form-control custom-select multiselect" multiple="multiple" name="field_team[]" id="field_team">
                                @foreach ($users as $key => $user)
                                    <option @if(isset($formValue->values['field_team'])) @if(in_array($key, $formValue->values['field_team']))selected @endif @endif  value="{{ $key }}">{{ $user }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full pl-3 mb-6 md:mb-0">
                            <x-jet-label for="technician" value="{{ __('Técnico Responsável') }}" />
                            <x-custom-select :options="$users" value="{{ isset($formValue->values['technician']) ? $formValue->values['technician'] : null }}" name="technician" id="technician" class="mt-1"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full pl-3 mb-6 md:mb-0">
                            <x-jet-label for="obs" value="{{ __('Observações') }}" />
                           <textarea class="form-input w-full" name="obs" id="obs" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div id="samples" class="w-full mt-4">
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <h2 class="w-full md:w-1/2 px-3 mb-6 md:mb-0">AMOSTRAS</h2>
                        </div>
                        <div id="samples_items">
                            @if(isset($formValue->values['samples']) && count($formValue->values['samples']) > 0)
                                @foreach ($formValue->values['samples'] as $key => $sample)
                                    @include('form-values.RT-GPA-047.sample', ['sample' => $sample, 'i' => Str::replace('row_', '', $key)])
                                @endforeach
                            @else
                                @include('form-values.RT-GPA-047.sample')
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


<x-spin-load />

@include('form-values.infos-modal')
@include('form-values.delete-modal')
@include("form-values.RT-GPA-047.scripts")


</x-app-layout>
