<x-app-layout>
    <div class="py-6 edit-parameter-analysis">
        <div class="max-w-6xl mx-auto px-4">
            <form method="POST" action="{{ route('parameter-analysis.update', ['parameter_analysis' => $parameterAnalysis->id]) }}">
                @csrf
                @method("PUT")
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Editar Param. Análise') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('parameter-analysis.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="analysis_parameter_id" value="{{ __('Tipo Param. Analise') }}" required/>
                            <x-custom-select :options="$analysisParameter" name="analysis_parameter_id" id="analysis_parameter_id" value="" required class="mt-1" :value="$parameterAnalysis->analysis_parameter_id"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="cas_rn" value="{{ __('CAS RN') }}"/>
                            <x-jet-input id="cas_rn" class="form-control block mt-1 w-full" type="text" name="cas_rn" maxlength="255" autofocus autocomplete="cas_rn" :value="$parameterAnalysis->cas_rn"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="ref_cas_rn" value="{{ __('Ref CasRN Param. Análise') }}"/>
                            <x-jet-input id="ref_cas_rn" class="form-control block mt-1 w-full" type="text" name="ref_cas_rn" maxlength="255" autofocus autocomplete="ref_cas_rn" :value="$parameterAnalysis->ref_cas_rn"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="analysis_parameter_name" value="{{ __('Nome Param. Análise') }}" required/>
                            <x-jet-input id="analysis_parameter_name" class="form-control block mt-1 w-full" type="text" name="analysis_parameter_name" maxlength="255" autofocus autocomplete="analysis_parameter_name" :value="$parameterAnalysis->analysis_parameter_name" required/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="parameter_analysis_group_id" value="{{ __('Grupo Param. Análise') }}" required/>
                            <x-custom-select :options="$parameterAnalysisGroup" name="parameter_analysis_group_id" id="parameter_analysis_group_id" value="" required class="mt-1" :value="$parameterAnalysis->parameter_analysis_group_id"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="order" value="{{ __('Ordem') }}" required/>
                            <x-jet-input id="order" class="form-control block mt-1 w-full" type="number" name="order" maxlength="18" autofocus autocomplete="order" :value="$parameterAnalysis->order" required/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="decimal_place" value="{{ __('casaDecimal') }}"/>
                            <x-jet-input id="decimal_place" class="form-control block mt-1 w-full" type="number" step="any" name="decimal_place" maxlength="18" autofocus autocomplete="decimal_place" :value="$parameterAnalysis->decimal_place"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="decimal_place" value="{{ __('Dt. Fim Validade') }}"/>
                            <x-jet-input id="final_validity" class="form-control block mt-1 w-full" type="datetime-local" name="final_validity"  autofocus autocomplete="final_validity" :value="$parameterAnalysis->final_validity->format('Y-m-d\TH:i')"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
