<x-app-layout>
    <div class="py-6 create-users">
        <div class="max-w-6xl mx-auto px-4">
            <form method="POST" action="{{ route('registers.parameter-analysis-group.update', ['parameter_analysis_group' => $parameterAnalysisGroup->id]) }}">
                @csrf
                @method("PUT")
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Editar Grupo Param. Análise') }}</h1>
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
                            <x-jet-label for="name" value="{{ __('Nome Grupo Param. Análise') }}" />
                            <x-jet-input id="name" class="form-control block mt-1 w-full" type="text" name="name" maxlength="255" required autofocus autocomplete="name" :value="$parameterAnalysisGroup->name"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="name" value="{{ __('Grupo Param. Análise Pai') }}" />
                            <x-custom-select :options="$parameterAnalysisGroups" name="parameter_analysis_group_id" id="parameter_analysis_group_id" :value="$parameterAnalysisGroup->parameter_analysis_group_id" class="mt-1"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="order" value="{{ __('Ordem') }}" />
                            <x-jet-input id="order" class="form-control block mt-1 w-full" type="text" name="order" maxlength="255" required autofocus autocomplete="order" :value="$parameterAnalysisGroup->order"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="final_validity" value="{{ __('Dt. Fim Validade') }}" />
                            <x-jet-input id="final_validity" class="form-control block mt-1 w-full" type="datetime-local" name="final_validity"  required autofocus autocomplete="final_validity" :value="$parameterAnalysisGroup->final_validity->format('Y-m-d\TH:i')"/>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>


</x-app-layout>
