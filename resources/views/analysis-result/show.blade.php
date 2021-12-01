<x-app-layout>
    <div class="py-6 show-analysis-result">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>({{ $analysisResult->projectPointMatrix->parameterAnalysis->cas_rn }})
                        {{ $analysisResult->projectPointMatrix->parameterAnalysis->analysis_parameter_name }} -
                        [{{ $analysisResult->analysisOrder->formatted_id }}]
                    </h1>
                </div>
                <div class="w-1/4 flex justify-end">
                    <div class="m-2 ">
                        <a class="btn-outline-info"
                            href="{{ route('analysis-order.show', ['analysis_order' => $analysisResult->analysisOrder->id]) }}">{{ __('Voltar') }}</a>
                    </div>
                    <div class="m-2">
                        <a class="btn-outline-warning"
                            href="{{ route('analysis-result.edit', ['project_point_matrix_id' => $analysisResult->projectPointMatrix->id]) }}">{{ __('Editar') }}</a>
                    </div>
                    <div class="m-2">
                        <button type="button" class="btn-outline-danger delete-analysis-result"
                            id="user_analysis_result" data-toggle="modal" data-target="#delete_modal"
                            data-id="{{ $analysisResult->id }}">{{ __('Apagar') }}</button>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg">
                <div class="mx-4 px-3 py-2 flex md:flex-row flex-col w-full">
                    <div class="flex md:flex-row flex-col">
                        <div>
                            <div class="grid grid-cols-1">
                                <div class="mx-1 px-1">
                                    <p class="font-bold">{{ __('Área') }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1">
                                <div class="mx-1 px-1">
                                    <p class="text-gray-500 font-bold">
                                        {{ $analysisResult->projectPointMatrix->pointIdentification->area }}</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="grid grid-cols-1">
                                <div class="mx-1 px-1">
                                    <p class="font-bold">{{ __('Ponto') }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1">
                                <div class="mx-1 px-1">
                                    <p class="text-gray-500 font-bold">
                                        {{ $analysisResult->projectPointMatrix->pointIdentification->identification }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="grid grid-cols-1">
                                <div class="mx-1 px-1">
                                    <p class="font-bold">{{ __('Matriz') }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1">
                                <div class="mx-1 px-1">
                                    <p class="text-gray-500 font-bold">
                                        {{ $analysisResult->projectPointMatrix->analysisMatrix->name }}</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="grid grid-cols-1">
                                <div class="mx-1 px-1">
                                    <p class="font-bold">{{ __('Param. Orientador Ambiental') }}
                                    </p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1">
                                <div class="mx-1 px-1">
                                    <p class="text-gray-500 font-bold">
                                        @if($analysisResult->projectPointMatrix->guidingParameters)
                                            {!! implode("<br />",
                                            $analysisResult->projectPointMatrix->guidingParameters()->pluck('environmental_guiding_parameter_id')->toArray())
                                            !!}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="grid grid-cols-1">
                                <div class="mx-1 px-1">
                                    <p class="font-bold">{{ __('Param. Análise') }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1">
                                <div class="mx-1 px-1">
                                    <p class="text-gray-500 font-bold">
                                        @if($analysisResult->projectPointMatrix->parameterAnalysis)
                                            {{ $analysisResult->projectPointMatrix->parameterAnalysis->analysis_parameter_name }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                <div class="flex md:flex-row flex-col w-full">
                    <div class="mx-4 px-3 py-2 w-full flex items-center">
                        <h2>{{ __('Análise da Amostra') }}</h2>
                    </div>
                </div>
                <div class="mx-4 px-3 py-2 mt-4">
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Client") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->client }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Project") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->project }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Projectnum") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->projectnum }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Labname") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->labname }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Samplename") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->samplename }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Labsampid") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->labsampid }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Matrix") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->matrix }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Rptmatrix") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->rptmatrix }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Solidmatrix") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->solidmatrix }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Sampdate") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->sampdate }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Prepdate") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->prepdate }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Anadate") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->anadate }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Batch") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->batch }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Analysis") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->analysis }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Anacode") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->anacode }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Methodcode") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->methodcode }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Methodname") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->methodname }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Description") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->description }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Prepname") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->prepname }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Analyte") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->analyte }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Analyteorder") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->analyteorder }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Casnumber") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->casnumber }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Surrogate") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->surrogate }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Tic") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->tic }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Result") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->result }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Dl") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->dl }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Rl") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->rl }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Units") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->units }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Rptomdl") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->rptomdl }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Mrlsolids") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->mrlsolids }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Basis") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->basis }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Dilution") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->dilution }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Spikelevel") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->spikelevel }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Recovery") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->recovery }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Uppercl") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->uppercl }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Lowercl") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->lowercl }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Analyst") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->analyst }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Psolids") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->psolids }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Lnote") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->lnote }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Anote") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->anote }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Latitude") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->latitude }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Longitude") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->longitude }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Scomment") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->scomment }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Snote1") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->snote1 }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Snote2") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->snote2 }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Snote3") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->snote3 }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Snote4") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->snote4 }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Snote5") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->snote5 }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Snote6") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->snote6 }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Snote7") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->snote7 }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Snote8") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->snote8 }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Snote9") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->snote9 }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-3/12 mr-2">
                            <p class="font-bold text-right">{{ __("Snote10") }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $analysisResult->snote10 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-modal title="{{ __('Excluir Amostra') }}"
        msg="{{ __('Deseja realmente apagar essa Amostra?') }}"
        confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}"
        id="delete_analysis_result_modal" method="DELETE"
        url="{{ route('analysis-result.destroy', ['analysis_result' => $analysisResult->id]) }}"
        redirect-url="{{ route('analysis-order.show', ['analysis_order' => $analysisResult->analysisOrder->id]) }}" />

    <script>
        function eventsDeleteCallback() {
            document.querySelectorAll('.delete-analysis-result').forEach(item => {
                item.addEventListener("click", function () {
                    var modal = document.getElementById("delete_analysis_result_modal");
                    modal.classList.remove("hidden");
                    modal.classList.add("block");
                })
            });
        }

        eventsDeleteCallback();

    </script>
</x-app-layout>
