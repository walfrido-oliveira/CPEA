<x-app-layout>
    <div class="py-6 create-users">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="{{ route('registers.parameter-analysis-group.store') }}">
                @csrf
                @method("POST")
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Cadastrar Grupo Param. Análise') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('registers.parameter-analysis-group.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="name" value="{{ __('Nome Grupo Param. Análise') }}" required/>
                            <x-jet-input id="name" class="form-control block mt-1 w-full" type="text" name="name" maxlength="255" required autofocus autocomplete="name"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="name" value="{{ __('Grupo Param. Análise Pai') }}" />
                            <x-custom-select :options="$parameterAnalysisGroups" name="parameter_analysis_group_id" id="parameter_analysis_group_id" value="" class="mt-1"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="order" value="{{ __('Ordem') }}" required/>
                            <x-jet-input id="order" class="form-control block mt-1 w-full" type="text" name="order" maxlength="255" required autofocus autocomplete="order"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="final_validity" value="{{ __('Dt. Fim Validade') }}" required/>
                            <x-jet-input id="final_validity" class="form-control block mt-1 w-full" type="datetime-local" name="final_validity"  required autofocus autocomplete="final_validity"/>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>


</x-app-layout>
