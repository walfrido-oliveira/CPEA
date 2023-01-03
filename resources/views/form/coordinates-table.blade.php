
<div class="flex flex-wrap mt-2 w-full flex-col" id="mode_coordinates_table" style="display: none">
    <h3 class="w-full md:w-1/2 px-3 mb-6 md:mb-0">COORDENADAS</h3>
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
                    <th colspan="2" style="text-align: center" class="cursor-pointer px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
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
                </tr>
            </thead>

            <tbody id="table_coordinates">
                @if(isset($formValue->values['coordinates']))
                    @foreach ($formValue->values['coordinates'] as $key => $coordinate)
                        <tr>
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
                                <x-jet-input readonly="true" id="point" class="form-control block mt-1 w-full" type="text" value="{{ isset($coordinate['mn']) ? $coordinate['mn'] : '' }}"
                                             name="{{ 'coordinates[' . $key . '][mn]' }}"/>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

