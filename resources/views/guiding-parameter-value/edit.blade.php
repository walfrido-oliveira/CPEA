<x-app-layout>
    <div class="py-6 edit-point-identification">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="{{ route('guiding-parameter-value.update', ['guiding_parameter_value' => $guidingParameterValue->id]) }}">
                @csrf
                @method("PUT")
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Editar Valor Param. Orientador') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('guiding-parameter-value.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="guiding_parameter_id" value="{{ __('Param. Orietador Ambiental') }}" required/>
                            <x-custom-select class="mt-1" :options="$guidingParameters" name="guiding_parameter_id" id="guiding_parameter_id" :value="$guidingParameterValue->guiding_parameter_id" required/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="analysis_matrix_id" value="{{ __('Matriz') }}" required/>
                            <x-custom-select class="mt-1" :options="$analysisMatrices" name="analysis_matrix_id" id="analysis_matrix_id" :value="$guidingParameterValue->analysis_matrix_id" required/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="parameter_analysis_id" value="{{ __('Param. Análise') }}" required/>
                            <x-custom-select class="mt-1" :options="$parameterAnalysises" name="parameter_analysis_id" id="parameter_analysis_id" :value="$guidingParameterValue->parameter_analysis_id" required/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="guiding_parameter_ref_value_id" value="{{ __('Ref. Param. Valor Orientador') }}"/>
                            <x-custom-select class="mt-1" :options="$guidingParameterRefValues" name="guiding_parameter_ref_value_id" id="guiding_parameter_ref_value_id" :value="$guidingParameterValue->guiding_parameter_ref_value_id"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="guiding_value_id" value="{{ __('Tipo Valor Orientador') }}" required/>
                            <x-custom-select class="mt-1" :options="$guidingValues" name="guiding_value_id" id="guiding_value_id" :value="$guidingParameterValue->guiding_value_id" required/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="unity_legislation_id" value="{{ __('Unidade Legislação') }}" required/>
                            <x-custom-select class="mt-1" :options="$unities" name="unity_legislation_id" id="unity_legislation_id" :value="$guidingParameterValue->unity_legislation_id" required/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="guiding_legislation_value" value="{{ __('Valor Orientador Legislaçao') }}" required/>
                            <x-jet-input id="guiding_legislation_value" class="form-control block mt-1 w-full" type="number" name="guiding_legislation_value" required maxlength="18" step="any" autofocus autocomplete="guiding_legislation_value" :value="$guidingParameterValue->guiding_legislation_value"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="guiding_legislation_value_1" value="{{ __('Valor Orientador Legislaçao 1') }}" required/>
                            <x-jet-input id="guiding_legislation_value_1" class="form-control block mt-1 w-full" type="number" name="guiding_legislation_value_1" maxlength="18" step="any" autofocus autocomplete="guiding_legislation_value_1" :value="$guidingParameterValue->guiding_legislation_value_1"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="guiding_legislation_value_2" value="{{ __('Valor Orientador Legislaçao 2') }}" />
                            <x-jet-input id="guiding_legislation_value_2" class="form-control block mt-1 w-full" type="number" name="guiding_legislation_value_2" maxlength="18" step="any" autofocus autocomplete="guiding_legislation_value_2" :value="$guidingParameterValue->guiding_legislation_value_2"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="unity_analysis_id" value="{{ __('Unidade Análise') }}" required/>
                            <x-custom-select class="mt-1" :options="$unities" name="unity_analysis_id" id="unity_analysis_id" :value="$guidingParameterValue->unity_analysis_id" required/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="guiding_analysis_value" value="{{ __('Valor Orientador Análise') }}" />
                            <x-jet-input id="guiding_analysis_value" class="form-control block mt-1 w-full" type="number" name="guiding_analysis_value" maxlength="18" step="any" autofocus autocomplete="guiding_analysis_value" :value="$guidingParameterValue->guiding_analysis_value"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="guiding_analysis_value_1" value="{{ __('Valor Orientador Análise 1') }}" required/>
                            <x-jet-input id="guiding_analysis_value_1" class="form-control block mt-1 w-full" type="number" name="guiding_analysis_value_1" maxlength="18" step="any" autofocus autocomplete="guiding_analysis_value_1" :value="$guidingParameterValue->guiding_analysis_value_1"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="guiding_analysis_value_2" value="{{ __('Valor Orientador Análise 2') }}" />
                            <x-jet-input id="guiding_analysis_value_2" class="form-control block mt-1 w-full" type="number" name="guiding_analysis_value_2" maxlength="18" step="any" autofocus autocomplete="guiding_analysis_value_2" :value="$guidingParameterValue->guiding_analysis_value_2"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
