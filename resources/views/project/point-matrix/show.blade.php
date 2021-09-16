<x-app-layout>
    <div class="py-6 show-users">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Amostra: ') }} <span class="font-normal">{{ $pointMatrix->campaign->name }}</span></h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2">
                        <a href="{{ route('project.campaign.show', ['campaign' => $pointMatrix->campaign->id])}}" class="btn-outline-danger">{{ __('Voltar') }}</a>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg">
                <div class="mx-4 px-3 py-2">
                    <div class="flex md:flex-row flex-col">
                        <div class="mx-4 px-3 py-2">
                            <div class="w-full">
                                <p class="font-bold">{{ __('Área') }}</p>
                            </div>
                            <div class="w-full">
                                @if ($pointMatrix->pointIdentification)
                                    <p class="text-gray-500 font-bold">{{ $pointMatrix->pointIdentification->area }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="mx-4 px-3 py-2">
                            <div class="w-full">
                                <p class="font-bold">{{ __('Ponto') }}</p>
                            </div>
                            <div class="w-full">
                                @if ($pointMatrix->pointIdentification)
                                    <p class="text-gray-500 font-bold">{{ $pointMatrix->pointIdentification->identification }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="mx-4 px-3 py-2">
                            <div class="w-full">
                                <p class="font-bold">{{ __('Matriz') }}</p>
                            </div>
                            <div class="w-full">
                                @if ($pointMatrix->analysisMatrix)
                                    <p class="text-gray-500 font-bold"> {{ $pointMatrix->analysisMatrix->name }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="mx-4 px-3 py-2">
                            <div class="w-full">
                                <p class="font-bold">{{ __('Tipo Nível Ação') }}</p>
                            </div>
                            <div class="w-full">
                                @if ($pointMatrix->planActionLevel)
                                    <p class="text-gray-500 font-bold"> {{ $pointMatrix->planActionLevel->name }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="mx-4 px-3 py-2">
                            <div class="w-full">
                                <p class="font-bold">{{ __('Param Orientador Ambiental') }}</p>
                            </div>
                            <div class="w-full">
                                @if ($pointMatrix->guidingParameter)
                                    <p class="text-gray-500 font-bold"> {{ $pointMatrix->guidingParameter->environmental_guiding_parameter_id }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="mx-4 px-3 py-2">
                            <div class="w-full">
                                <p class="font-bold">{{ __('Param Análise') }}</p>
                            </div>
                            <div class="w-full">
                                @if ($pointMatrix->parameterAnalysis)
                                    <p class="text-gray-500 font-bold"> {{ $pointMatrix->parameterAnalysis->analysis_parameter_name }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg">
                <div class="ml-4 pl-3 py-2">
                    <div class="flex md:flex-row flex-col">
                        <div class="mx-4 px-3 py-2 w-full flex items-center">
                            <h1>{{ __('Amostras') }}</h1>
                        </div>
                        <div class="py-2 w-full flex justify-end" x-data="{ open: false }">
                            <div class="flex">
                                <button @click="open = !open" id="nav-toggle" class="w-full block btn-transition-secondary">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                  </svg>
                                </button>
                            </div>
                            <!--Search-->
                            <div :class="{'block': open, 'hidden': !open}" class="w-full block" id="search-content">
                                <div class="container mx-auto">
                                    <input id="name_customer" name="name" type="search" placeholder="Buscar..." autofocus="autofocus" class="filter-field w-full form-control no-border mt-4">
                                </div>
                            </div>
                            <div class="flex md:flex-row flex-col">
                                <div class="m-2">
                                    <button type="button" class="btn-outline-warning">{{ __('Pendentes') }}</button>
                                </div>
                                <div class="m-2">
                                    <button type="button" class="btn-outline-success">{{ __('Analisados') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex mt-4">
                    <table id="point_matrix_table" class="table table-responsive md:table w-full">
                        <thead>
                            <tr class="thead-light">
                                <th scope="col" class="cursor-pointer text-center">{{ __('Amostra') }}</th>
                                <th>{{ __('Ações') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            for
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
