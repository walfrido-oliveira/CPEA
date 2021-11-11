<x-app-layout>
    <div class="py-6 edit-users">
        <div class="max-w-6xl mx-auto px-4">
            <form method="POST"
                action="{{ route('analysis-result.update', ['analysis_result' => $analysisResult->id]) }}">
                @csrf
                @method("PUT")
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Editar Análise da Amostra') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('analysis-result.show', ['project_point_matrix_id' => $analysisResult->projectPointMatrix->id]) }}"
                                class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="client" value="{{ __('Client') }}" />
                                <x-jet-input id="client" class="form-control block mt-1 w-full" type="text"
                                    name="client" maxlength="255" autofocus autocomplete="client"
                                    :value="$analysisResult->client" />
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="project" value="{{ __('Project') }}" />
                                <x-jet-input id="project" class="form-control block mt-1 w-full" type="text"
                                    name="project" maxlength="255" autofocus autocomplete="project"
                                    :value="$analysisResult->project" />
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="projectnum" value="{{ __('Projectnum') }}" />
                                <x-jet-input id="projectnum" class="form-control block mt-1 w-full" type="text"
                                    name="projectnum" maxlength="255" autofocus autocomplete="projectnum"
                                    :value="$analysisResult->projectnum" />
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="labname" value="{{ __('Labname') }}" />
                                <x-jet-input id="labname" class="form-control block mt-1 w-full" type="text"
                                    name="labname" maxlength="255" autofocus autocomplete="labname"
                                    :value="$analysisResult->labname" />
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="samplename" value="{{ __('Samplename') }}" />
                                <x-jet-input id="samplename" class="form-control block mt-1 w-full" type="text"
                                    name="samplename" maxlength="255" autofocus autocomplete="samplename"
                                    :value="$analysisResult->samplename" />
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="labsampid" value="{{ __('Labsampid') }}" />
                                <x-jet-input id="labsampid" class="form-control block mt-1 w-full" type="text"
                                    name="labsampid" maxlength="255" autofocus autocomplete="labsampid"
                                    :value="$analysisResult->labsampid" />
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="matrix" value="{{ __('Matrix') }}" />
                                <x-jet-input id="matrix" class="form-control block mt-1 w-full" type="text"
                                    name="matrix" maxlength="255" autofocus autocomplete="matrix"
                                    :value="$analysisResult->matrix" />
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="rptmatrix" value="{{ __('Rptmatrix') }}" />
                                <x-jet-input id="rptmatrix" class="form-control block mt-1 w-full" type="text"
                                    name="rptmatrix" maxlength="255" autofocus autocomplete="rptmatrix"
                                    :value="$analysisResult->rptmatrix" />
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="solidmatrix" value="{{ __('Solidmatrix') }}" />
                                <x-jet-input id="solidmatrix" class="form-control block mt-1 w-full" type="text"
                                    name="solidmatrix" maxlength="255" autofocus autocomplete="solidmatrix"
                                    :value="$analysisResult->solidmatrix" />
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="sampdate" value="{{ __('Sampdate') }}" />
                                <x-jet-input id="sampdate" class="form-control block mt-1 w-full" type="text"
                                    name="sampdate" maxlength="255" autofocus autocomplete="sampdate"
                                    :value="$analysisResult->sampdate" />
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="prepdate" value="{{ __('Prepdate') }}" />
                                <x-jet-input id="prepdate" class="form-control block mt-1 w-full" type="text"
                                    name="prepdate" maxlength="255" autofocus autocomplete="prepdate"
                                    :value="$analysisResult->prepdate" />
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="anadate" value="{{ __('Anadate') }}" />
                                <x-jet-input id="anadate" class="form-control block mt-1 w-full" type="text"
                                    name="anadate" maxlength="255" autofocus autocomplete="anadate"
                                    :value="$analysisResult->anadate" />
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="batch" value="{{ __('Batch') }}" />
                                <x-jet-input id="batch" class="form-control block mt-1 w-full" type="text" name="batch"
                                    maxlength="255" autofocus autocomplete="batch" :value="$analysisResult->batch" />
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="analysis" value="{{ __('Analysis') }}" />
                                <x-jet-input id="analysis" class="form-control block mt-1 w-full" type="text"
                                    name="analysis" maxlength="255" autofocus autocomplete="analysis"
                                    :value="$analysisResult->analysis" />
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="anacode" value="{{ __('Anacode') }}" />
                                <x-jet-input id="anacode" class="form-control block mt-1 w-full" type="text"
                                    name="anacode" maxlength="255" autofocus autocomplete="anacode"
                                    :value="$analysisResult->anacode" />
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="methodcode" value="{{ __('Methodcode') }}" />
                                <x-jet-input id="methodcode" class="form-control block mt-1 w-full" type="text"
                                    name="methodcode" maxlength="255" autofocus autocomplete="methodcode"
                                    :value="$analysisResult->methodcode" />
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="methodname" value="{{ __('Methodname') }}" />
                                <x-jet-input id="methodname" class="form-control block mt-1 w-full" type="text"
                                    name="methodname" maxlength="255" autofocus autocomplete="methodname"
                                    :value="$analysisResult->methodname" />
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="description" value="{{ __('Description') }}" />
                                <x-jet-input id="description" class="form-control block mt-1 w-full" type="text"
                                    name="description" maxlength="255" autofocus autocomplete="description"
                                    :value="$analysisResult->description" />
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="prepname" value="{{ __('Prepname') }}" />
                                <x-jet-input id="prepname" class="form-control block mt-1 w-full" type="text"
                                    name="prepname" maxlength="255" autofocus autocomplete="prepname"
                                    :value="$analysisResult->prepname" />
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="analyte" value="{{ __('Analyte') }}" />
                                <x-jet-input id="analyte" class="form-control block mt-1 w-full" type="text"
                                    name="analyte" maxlength="255" autofocus autocomplete="analyte"
                                    :value="$analysisResult->analyte" />
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="analyteorder" value="{{ __('Analyteorder') }}" />
                                <x-jet-input id="analyteorder" class="form-control block mt-1 w-full" type="text"
                                    name="analyteorder" maxlength="255" autofocus autocomplete="analyteorder"
                                    :value="$analysisResult->analyteorder" />
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="casnumber" value="{{ __('Casnumber') }}" />
                                <x-jet-input id="casnumber" class="form-control block mt-1 w-full" type="text"
                                    name="casnumber" maxlength="255" autofocus autocomplete="casnumber"
                                    :value="$analysisResult->casnumber" />
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="surrogate" value="{{ __('Surrogate') }}" />
                                <x-jet-input id="surrogate" class="form-control block mt-1 w-full" type="text"
                                    name="surrogate" maxlength="255" autofocus autocomplete="surrogate"
                                    :value="$analysisResult->surrogate" />
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="tic" value="{{ __('Tic') }}" />
                                <x-jet-input id="tic" class="form-control block mt-1 w-full" type="text" name="tic"
                                    maxlength="255" autofocus autocomplete="tic" :value="$analysisResult->tic" />
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="result" value="{{ __('Result') }}" />
                                <x-jet-input id="result" class="form-control block mt-1 w-full" type="text"
                                    name="result" maxlength="255" autofocus autocomplete="result"
                                    :value="$analysisResult->result" />
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="dl" value="{{ __('Dl') }}" />
                                <x-jet-input id="dl" class="form-control block mt-1 w-full" type="text" name="dl"
                                    maxlength="255" autofocus autocomplete="dl" :value="$analysisResult->dl" />
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="rl" value="{{ __('Rl') }}" />
                                <x-jet-input id="rl" class="form-control block mt-1 w-full" type="text" name="rl"
                                    maxlength="255" autofocus autocomplete="rl" :value="$analysisResult->rl" />
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="units" value="{{ __('Units') }}" />
                                <x-jet-input id="units" class="form-control block mt-1 w-full" type="text" name="units"
                                    maxlength="255" autofocus autocomplete="units" :value="$analysisResult->units" />
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="rptomdl" value="{{ __('Rptomdl') }}" />
                                <x-jet-input id="rptomdl" class="form-control block mt-1 w-full" type="text"
                                    name="rptomdl" maxlength="255" autofocus autocomplete="rptomdl"
                                    :value="$analysisResult->rptomdl" />
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="mrlsolids" value="{{ __('Mrlsolids') }}" />
                                <x-jet-input id="mrlsolids" class="form-control block mt-1 w-full" type="text"
                                    name="mrlsolids" maxlength="255" autofocus autocomplete="mrlsolids"
                                    :value="$analysisResult->mrlsolids" />
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="basis" value="{{ __('Basis') }}" />
                                <x-jet-input id="basis" class="form-control block mt-1 w-full" type="text" name="basis"
                                    maxlength="255" autofocus autocomplete="basis" :value="$analysisResult->basis" />
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="dilution" value="{{ __('Dilution') }}" />
                                <x-jet-input id="dilution" class="form-control block mt-1 w-full" type="text"
                                    name="dilution" maxlength="255" autofocus autocomplete="dilution"
                                    :value="$analysisResult->dilution" />
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="spikelevel" value="{{ __('Spikelevel') }}" />
                                <x-jet-input id="spikelevel" class="form-control block mt-1 w-full" type="text"
                                    name="spikelevel" maxlength="255" autofocus autocomplete="spikelevel"
                                    :value="$analysisResult->spikelevel" />
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="recovery" value="{{ __('Recovery') }}" />
                                <x-jet-input id="recovery" class="form-control block mt-1 w-full" type="text"
                                    name="recovery" maxlength="255" autofocus autocomplete="recovery"
                                    :value="$analysisResult->recovery" />
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="uppercl" value="{{ __('Uppercl') }}" />
                                <x-jet-input id="uppercl" class="form-control block mt-1 w-full" type="text"
                                    name="uppercl" maxlength="255" autofocus autocomplete="uppercl"
                                    :value="$analysisResult->uppercl" />
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="lowercl" value="{{ __('Lowercl') }}" />
                                <x-jet-input id="lowercl" class="form-control block mt-1 w-full" type="text"
                                    name="lowercl" maxlength="255" autofocus autocomplete="lowercl"
                                    :value="$analysisResult->lowercl" />
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="analyst" value="{{ __('Analyst') }}" />
                                <x-jet-input id="analyst" class="form-control block mt-1 w-full" type="text"
                                    name="analyst" maxlength="255" autofocus autocomplete="analyst"
                                    :value="$analysisResult->analyst" />
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="psolids" value="{{ __('Psolids') }}" />
                                <x-jet-input id="psolids" class="form-control block mt-1 w-full" type="text"
                                    name="psolids" maxlength="255" autofocus autocomplete="psolids"
                                    :value="$analysisResult->psolids" />
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="lnote" value="{{ __('Lnote') }}" />
                                <x-jet-input id="lnote" class="form-control block mt-1 w-full" type="text" name="lnote"
                                    maxlength="255" autofocus autocomplete="lnote" :value="$analysisResult->lnote" />
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="anote" value="{{ __('Anote') }}" />
                                <x-jet-input id="anote" class="form-control block mt-1 w-full" type="text" name="anote"
                                    maxlength="255" autofocus autocomplete="anote" :value="$analysisResult->anote" />
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="latitude" value="{{ __('Latitude') }}" />
                                <x-jet-input id="latitude" class="form-control block mt-1 w-full" type="text"
                                    name="latitude" maxlength="255" autofocus autocomplete="latitude"
                                    :value="$analysisResult->latitude" />
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="longitude" value="{{ __('Longitude') }}" />
                                <x-jet-input id="longitude" class="form-control block mt-1 w-full" type="text"
                                    name="longitude" maxlength="255" autofocus autocomplete="longitude"
                                    :value="$analysisResult->longitude" />
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="scomment" value="{{ __('Scomment') }}" />
                                <x-jet-input id="scomment" class="form-control block mt-1 w-full" type="text"
                                    name="scomment" maxlength="255" autofocus autocomplete="scomment"
                                    :value="$analysisResult->scomment" />
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="snote1" value="{{ __('Snote1') }}" />
                                <x-jet-input id="snote1" class="form-control block mt-1 w-full" type="text"
                                    name="snote1" maxlength="255" autofocus autocomplete="snote1"
                                    :value="$analysisResult->snote1" />
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="snote2" value="{{ __('Snote2') }}" />
                                <x-jet-input id="snote2" class="form-control block mt-1 w-full" type="text"
                                    name="snote2" maxlength="255" autofocus autocomplete="snote2"
                                    :value="$analysisResult->snote2" />
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="snote3" value="{{ __('Snote3') }}" />
                                <x-jet-input id="snote3" class="form-control block mt-1 w-full" type="text"
                                    name="snote3" maxlength="255" autofocus autocomplete="snote3"
                                    :value="$analysisResult->snote3" />
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="snote4" value="{{ __('Snote4') }}" />
                                <x-jet-input id="snote4" class="form-control block mt-1 w-full" type="text"
                                    name="snote4" maxlength="255" autofocus autocomplete="snote4"
                                    :value="$analysisResult->snote4" />
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="snote5" value="{{ __('Snote5') }}" />
                                <x-jet-input id="snote5" class="form-control block mt-1 w-full" type="text"
                                    name="snote5" maxlength="255" autofocus autocomplete="snote5"
                                    :value="$analysisResult->snote5" />
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="snote6" value="{{ __('Snote6') }}" />
                                <x-jet-input id="snote6" class="form-control block mt-1 w-full" type="text"
                                    name="snote6" maxlength="255" autofocus autocomplete="snote6"
                                    :value="$analysisResult->snote6" />
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="snote7" value="{{ __('Snote7') }}" />
                                <x-jet-input id="snote7" class="form-control block mt-1 w-full" type="text"
                                    name="snote7" maxlength="255" autofocus autocomplete="snote7"
                                    :value="$analysisResult->snote7" />
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="snote8" value="{{ __('Snote8') }}" />
                                <x-jet-input id="snote8" class="form-control block mt-1 w-full" type="text"
                                    name="snote8" maxlength="255" autofocus autocomplete="snote8"
                                    :value="$analysisResult->snote8" />
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="snote9" value="{{ __('Snote9') }}" />
                                <x-jet-input id="snote9" class="form-control block mt-1 w-full" type="text"
                                    name="snote9" maxlength="255" autofocus autocomplete="snote9"
                                    :value="$analysisResult->snote9" />
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="snote10" value="{{ __('Snote10') }}" />
                                <x-jet-input id="snote10" class="form-control block mt-1 w-full" type="text"
                                    name="snote10" maxlength="255" autofocus autocomplete="snote10"
                                    :value="$analysisResult->snote10" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
