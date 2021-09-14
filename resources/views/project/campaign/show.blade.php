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
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="q" value="{{ __('Pesquisa') }}" />
                            <x-jet-input id="q" class="form-control block w-full filter-field" type="text" name="q" :value="app('request')->input('q')" autofocus autocomplete="project_cod" />
                        </div>
                    </div>
                </div>
                <div class="flex mt-4">
                    <table id="point_matrix_table" class="table table-responsive md:table w-full">
                        @include('project.campaign.point-matrix-result',
                        ['projectPointMatrices' => $projectPointMatrices, 'orderBy' => 'area', 'ascending' => 'asc'])
                    </table>
                </div>
                <div class="flex mt-4 p-2" id="point_matrix_pagination">
                        {{ $projectPointMatrices->appends(request()->input())->links() }}
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
