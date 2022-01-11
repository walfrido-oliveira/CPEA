<x-app-layout>
    <div class="py-6 edit-point-identification">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="{{ route('project.update', ['project' => $project->id]) }}">
                @csrf
                @method("PUT")
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Editar Projeto') }}</h1>
                    </div>
                    <div class="w-full flex md:justify-end md:flex-nowrap flex-wrap">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('project.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                        <div class="m-2">
                            <button type="button" class="btn-outline-danger delete-project" id="project_delete" data-toggle="modal" data-target="#delete_modal" data-id="{{ $project->id }}">{{ __('Apagar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('project.duplicate', ['project' => $project->id])}}" class="btn-outline-info">{{ __('Duplicar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="project_cod" value="{{ __('Cód. do Projeto') }}" required />
                            <x-jet-input id="project_cod" class="form-control block mt-1 w-full" type="text" name="project_cod" maxlength="255" required autofocus autocomplete="project_cod" :value="$project->project_cod"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="customer_id" value="{{ __('Cliente') }}"/>
                            <x-custom-select :options="$customers" name="customer_id" id="customer_id" :value="$project->customer_id" class="mt-1"/>
                        </div>
                    </div>
                </div>

                <div class="py-2 my-2 bg-white rounded-lg" x-data="campaignShowFields()">
                    <div class="flex md:flex-row flex-col mx-4 px-3 py-2">
                        <div class="w-full flex items-center">
                            <h2 class="">{{ __("Campanha") }}</h2>
                        </div>
                        <div class="w-full flex justify-end">
                            <div class="m-2 ">
                                <button type="button" class="btn-outline-info" id="campaign_table_add" data-type="save" data-id="0" data-row="0" title="Cadastrar Campanha">{{ __('Cadastrar') }}</button>
                            </div>
                            <div class="m-2 ">
                                <button type="button" id="delete_campaign" class="btn-outline-danger delete-campaign" data-type="multiple" title="Apagar Campanha">{{ __('Apagar') }}</button>
                            </div>
                        </div>
                    </div>
                    <div id="campaign_container"
                        x-show="isOpen() || true"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-90"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-90 hidden">
                        <div class="flex flex-wrap mx-4 px-3 py-2">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="campaign_name" value="{{ __('Nome da Campanha') }}" required />
                                <x-jet-input id="campaign_name" class="form-control block mt-1 w-full" type="text" name="campaign_name" maxlength="255" autofocus autocomplete="campaign_name"/>
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="campaign_status" value="{{ __('Status') }}" required/>
                                <x-custom-select :options="$campaignStatuses" name="campaign_status" id="campaign_status" value="" class="mt-1" no-filter="no-filter"/>
                            </div>
                        </div>
                    </div>
                    <div class="flex mt-4">
                        <table id="campaign_table" class="table table-responsive md:table w-full">
                            @include('project.campaign-result',
                            ['projectCampaigns' => $projectCampaigns, 'orderBy' => 'name', 'ascending' => 'asc', 'actions' => 'show'])
                        </table>
                    </div>
                    <div class="flex w-full mt-4 p-2" id="campaign_pagination">
                        {{ $projectCampaigns->links() }}
                    </div>
                </div>

                <div class="py-2 my-2 bg-white rounded-lg" x-data="pointMatrixShowFields()">
                    <div class="flex md:flex-row flex-col mx-4 px-3 py-2">
                        <div class="w-full flex items-center">
                            <h2 class="">{{ __("Identificação do Ponto/Matriz") }}</h2>
                        </div>
                        <div class="w-full grid md:flex md:justify-end md:flex-nowrap flex-wrap">
                            <div class="m-2 ">
                                <button type="button" class="btn-transition-secondary" id="guiding_parameter_order" title="Ordenar param. orientador ambiental">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                    </svg>
                                </button>
                            </div>
                            <div class="m-2 ">
                                <button type="button" class="btn-transition-primary" id="point_create" title="Adicionar novo ponto">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="m-2 ">
                                <button type="button" class="btn-outline-info" id="point_matrix_table_add" data-type="save" data-id="0" data-row="0" title="Cadastrar Ponto/Matriz">{{ __('Cadastrar') }}</button>
                            </div>
                            <div class="m-2 ">
                                <button type="button" id="delete_point_matrix" class="btn-outline-danger delete-point-matrix" data-type="multiple" title="Apagar Ponto/Matriz">{{ __('Apagar') }}</button>
                            </div>
                        </div>
                    </div>
                    <div id="point_matrix_container">

                    </div>
                    <div class="flex mt-4">
                        <table id="point_matrix_table" class="table table-responsive md:table w-full">
                            <thead>
                                <tr class="thead-light">
                                    <x-table-sort-header orderBy="created_at" ascending="asc" columnName="" columnText="<input class='form-checkbox' id='select_all_point_matrix' type='checkbox' value='all'>"/>
                                    <x-table-sort-header orderBy="created_at" ascending="asc" columnName="campaign_id" columnText="{{ __('Campanha') }}" :searchable="true"/>
                                    <x-table-sort-header orderBy="created_at" ascending="asc" columnName="point_identifications.area" columnText="{{ __('Área') }}" :searchable="true"/>
                                    <x-table-sort-header orderBy="created_at" ascending="asc" columnName="point_identifications.identification" columnText="{{ __('Ponto') }}" :searchable="true"/>
                                    <x-table-sort-header orderBy="created_at" ascending="asc" columnName="analysis_matrix_id" columnText="{{ __('Matriz') }}" :searchable="true"/>
                                    <x-table-sort-header orderBy="created_at" ascending="asc" columnName="guiding_parameter_project_point_matrix.guiding_parameter_id" columnText="{{ __('Param. Orientador Ambiental') }}" :searchable="true"/>
                                    <x-table-sort-header orderBy="created_at" ascending="asc" columnName="parameter_analysis_id" columnText="{{ __('Param. Análise') }}" :searchable="true"/>
                                    <x-table-sort-header orderBy="created_at" ascending="asc" columnName="date_collection" columnText="{{ __('DT/HR da Coleta') }}" :searchable="true"/>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            @include('project.point-matrix-result',
                            ['projectPointMatrices' => $projectPointMatrices, 'orderBy' => 'campaign_id', 'ascending' => 'asc'])
                        </table>
                    </div>
                    <div class="flex w-full mt-4 p-2" id="point_matrix_pagination">
                        {{ $projectPointMatrices->links() }}
                    </div>
                </div>
            </form>
        </div>
    </div>

    <x-spin-load />

    <x-modal title="{{ __('Excluir') }}"
             msg="{{ __('Deseja realmente apagar esse Item?') }}"
             confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_point_matrix_modal"
             confirm_id="point_matrix_confirm_id"
             cancel_modal="point_matrix_cancel_modal"
             method="DELETE"
             />

    <x-modal    title="{{ __('Excluir Projeto') }}"
                msg="{{ __('Deseja realmente apagar esse Projeto?') }}"
                confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_project_modal"
                method="DELETE"
                url="{{ route('project.destroy', ['project' => $project->id]) }}"
                redirect-url="{{ route('project.index') }}"
                confirm_id="project_confirm_id"
                cancel_modal="project_cancel_modal"/>

    <script>
        function pointMatrixShowFields() {
            return {
                show: false,
                open() {
                    this.show = true;
                },
                close() { this.show = false },
                isOpen() { return this.show === true },
            }
        }

        function campaignShowFields() {
            return {
                show: false,
                open() {
                    this.show = true;
                },
                close() { this.show = false },
                isOpen() { return this.show === true },
            }
        }
    </script>

    <script>
        function eventsDeleteCallback() {
            document.querySelectorAll('.delete-project').forEach(item => {
                item.addEventListener("click", function() {
                    var modal = document.getElementById("delete_project_modal");
                    modal.classList.remove("hidden");
                    modal.classList.add("block");
                });
            });
        }

        eventsDeleteCallback();
    </script>

    @include('project.point-create-modal')
    @include('project.guiding-parameter-order-modal')
    @include('project.point-matrix-edit-modal')
    @include('project.point-matrix-scripts')
    @include('project.campaign-scripts')

</x-app-layout>
