<x-app-layout>
    <div class="py-6 create-users">
        <div class="max-w-6xl mx-auto px-4">
            <form method="POST" action="{{ route('registers.calculation-parameter.store') }}">
                @csrf
                @method("POST")
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Cadastrar Param. Fórmula Cálculo') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('registers.calculation-parameter.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="parameter_analysis_id" value="{{ __('Param. Analise') }}" required/>
                            <x-custom-select :options="$parameterAnalysis" name="parameter_analysis_id" id="parameter_analysis_id" :value="old('parameter_analysis_id')"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="formula" value="{{ __('Formula Cálculo') }}" required/>
                            <textarea class="form-input w-full" name="formula" id="formula" cols="30" rows="3" required ></textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
