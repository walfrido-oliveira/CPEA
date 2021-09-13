<x-app-layout>
    <div class="py-6 show-users">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Campanha: ') }} <span class="font-normal">{{ $campaign->name }}</span></h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2">
                        <a href="{{ route('project.campaign.duplicate', ['campaign' => $campaign->id])}}" class="btn-outline-info">{{ __('Duplicar') }}</a>
                    </div>
                    <div class="m-2">
                        <button type="button" class="btn-outline-danger delete-campaign" id="campaign_delete" data-toggle="modal" data-target="#delete_modal" data-id="{{ $campaign->id }}">{{ __('Apagar') }}</button>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                <div class="filter-container md:block">
                    <div class="flex flex-wrap mx-4 px-3 py-2">
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="area" value="{{ __('Área') }}" />
                            <x-custom-select :options="$areas" name="areas" id="areas" value="" class="mt-1" no-filter="no-filter"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="point_identifications" value="{{ __('Identificação Ponto') }}"/>
                            <x-custom-select :options="[]" name="point_identifications" id="point_identifications" value="" class="mt-1" no-filter="no-filter"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="matriz_id" value="{{ __('Matriz') }}"/>
                            <x-custom-select :options="$matrizeces" name="matriz_id" id="matriz_id" value="" class="mt-1" no-filter="no-filter"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2">
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="plan_action_level_id" value="{{ __('Tipo Nível Ação Plano') }}"/>
                            <x-custom-select :options="$planActionLevels" name="plan_action_level_id" id="plan_action_level_id" value="" class="mt-1" no-filter="no-filter"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="guiding_parameters_id" value="{{ __('Param. Orientador Ambiental') }}"/>
                            <x-custom-select :options="$guidingParameters" name="guiding_parameters_id" id="guiding_parameters_id" value="" class="mt-1" no-filter="no-filter"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="analysis_parameter_id" value="{{ __('Param. Análise') }}"/>
                            <x-custom-select :options="$parameterAnalyses" name="analysis_parameter_id" id="analysis_parameter_id" value="" class="mt-1" no-filter="no-filter"/>
                        </div>
                    </div>
                </div>
                {{$campaign->projectPointMatrix}}
                <div class="flex mt-4">
                    <table id="point_matrix_table" class="table table-responsive md:table w-full">
                        @include('project.campaign.point-matrix-result',
                        ['projectPointMatrices' => $campaign->projectPointMatrix, 'orderBy' => 'area', 'ascending' => 'asc'])
                    </table>
                </div>
                <div class="flex mt-4 p-2" id="point_matrix_pagination">
                        {{ $campaign->projectPointMatrix()->paginate(10, ['*'], 'point_matrix')->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>

    <x-modal title="{{ __('Excluir Campanha') }}"
             msg="{{ __('Deseja realmente apagar essa Campanha?') }}"
             confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_campaign_modal"
             method="DELETE"
             url="{{ route('project.campaign.destroy', ['campaign' => $campaign->id]) }}"
             redirect-url="{{ route('project.campaign.index') }}"/>

    <script>
        function eventsDeleteCallback() {
            document.querySelectorAll('.delete-campaign').forEach(item => {
            item.addEventListener("click", function() {
                var modal = document.getElementById("delete_campaign_modal");
                modal.classList.remove("hidden");
                modal.classList.add("block");
            })
        });
        }

        eventsDeleteCallback();
    </script>
</x-app-layout>
