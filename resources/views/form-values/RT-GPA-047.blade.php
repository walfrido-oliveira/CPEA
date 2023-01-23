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
                    <div id="samples" class="w-full mt-4">
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <h2 class="w-full md:w-1/2 px-3 mb-6 md:mb-0">AMOSTRAS</h2>
                        </div>
                        <div id="samples_items">
                            @if(isset($formValue->values['samples']))
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

<!-- Modal -->
<div class="modal fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="modal" data-url="">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
              <h3 class="text-lg leading-6 font-medium text-gray-900 sm:ml-4 " id="modal-title">
                {{ __('Informações Adicionais') }}
              </h3>
              <div class="mt-2">
                {!! $form->renderizedInfos !!}
              </div>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button type="button" id="confirm_modal" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
            {{ __('OK') }}
          </button>
        </div>
      </div>
    </div>
</div>



<x-spin-load />

@include('form-values.infos-modal')
@include('form-values.delete-modal')
@include("form-values.RT-GPA-047.scripts")


</x-app-layout>
