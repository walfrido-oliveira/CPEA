
<div class="flex flex-wrap mx-4 px-3 py-2 mt-4" id="mode_coordinates_table" style="display: none">
    <div class="w-full flex">
        <h3 class="w-full md:w-1/2 px-3 mb-6 md:mb-0">COORDENADAS</h3>
        <div class="w-full md:w-1/2 flex justify-end">
            <button type="button" class="btn-transition-primary edit-coordinate px-1" title="Editar Coodernada" style="margin-top: 0.2rem;">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-wiph="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </button>
            <button type="button" class="btn-transition-primary save-coordinate px-1" title="Salvar Coodernada" style="display: none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-8 w-8">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-wiph="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </button>
            <input type="file" name="file_coordinates" id="file_coordinates" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet|application/vnd.ms-excel" class="hidden">
            <button type="button" class="btn-transition-primary import-sample-coordinates px-1" title="Importar Coodernadas">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-wiph="1.5" stroke="currentColor" class="h-8 w-8 text-blue-900">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" />
                </svg>
            </button>
        </div>
    </div>
    <div class="my-2 px-3">
        <table class="table table-responsive md:table w-full">
            <thead>
                <tr class="thead-light">
                    <th rowspan="2" style="vertical-align: middle;" class="align-middle cursor-pointer px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                        {{ __('identificação do Ponto') }}
                    </th>
                    <th rowspan="2" style="vertical-align: middle;"  class="cursor-pointer px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                        {{ __('Zona') }}
                    </th>
                    <th colspan="3" style="text-align: center" class="cursor-pointer px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                        {{ __('Coordenadas UTM') }}
                    </th>
                </tr>
                <tr class="thead-light">
                    <th class="cursor-pointer px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                        {{ __('Eastings (mE)') }}
                    </th>
                    <th class="cursor-pointer px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                        {{ __('Northings (mN)') }}
                    </th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody id="table_coordinates">
                @if(isset($formValue->values['coordinates']))
                    @foreach ($formValue->values['coordinates'] as $key => $coordinate)
                        <tr data-row="{{ $key }}">
                            <td>
                                <x-jet-input readonly="true" id="point" class="form-control block mt-1 w-full" type="text" value="{{ isset($coordinate['point']) ? $coordinate['point'] : '' }}"
                                             name="{{ 'coordinates[' . $key . '][point]' }}" />
                            </td>
                            <td>
                                <x-jet-input readonly="true" id="point" class="form-control block mt-1 w-full" type="text" value="{{ isset($coordinate['zone']) ? $coordinate['zone'] : '' }}"
                                             name="{{ 'coordinates[' . $key . '][zone]' }}"/>
                            </td>
                            <td>
                                <x-jet-input readonly="true" id="point" class="form-control block mt-1 w-full" type="text" value="{{ isset($coordinate['me']) ? $coordinate['me'] : '' }}"
                                             name="{{ 'coordinates[' . $key . '][me]' }}"/>
                            </td>
                            <td>
                                <x-jet-input readonly="true" id="point" class="form-control block mt-1 w-full" type="text" value="{{ isset($coordinate['mn']) ? Str::replaceFirst(',', '.', $coordinate['mn']) : '' }}"
                                             name="{{ 'coordinates[' . $key . '][mn]' }}"/>
                            </td>
                            <td>
                                <button type="button" class="btn-transition-primary remove-coordinate px-1" title="Remover Coodernada"  data-row="{{ $key }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-wiph="1.5" stroke="currentColor" class="h-8 w-8 text-red-900">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

