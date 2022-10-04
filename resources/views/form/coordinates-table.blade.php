@if(isset($formValue->values['coordinates']))
    <div class="flex flex-wrap mt-2 w-full flex-col" id="mode_coordinates_table" style="display: none">
        <h2 class="w-full md:w-1/2 px-3 mb-6 md:mb-0">COODERNADAS</h2>
        <div class="my-2">
            <table class="table table-responsive md:table w-full">
                <thead>
                    <tr class="thead-light">
                        <th rowspan="2" style="vertical-align: middle;" class="align-middle cursor-pointer px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('identificação do Ponto') }}
                        </th>
                        <th rowspan="2" style="vertical-align: middle;"  class="cursor-pointer px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Zona') }}
                        </th>
                        <th colspan="2" class="cursor-pointer px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                            {{ __('Coordenadas UTM') }}
                        </th>
                    </tr>
                    <tr class="thead-light">
                        <th class="cursor-pointer px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Eastings (mE)') }}
                        </th>
                        <th class="cursor-pointer px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Northings (mN)') }}
                        </th>
                    </tr>
                </thead>
                <tbody id="table_coordinates">
                    @foreach ($formValue->values['coordinates'] as $coordinate)
                        <tr>
                            <td>{{ isset($coordinate['point']) ? $coordinate['point'] : '' }}</td>
                            <td>{{ isset($coordinate['zone']) ?$coordinate['zone'] : '' }}</td>
                            <td>{{ isset($coordinate['me']) ? $coordinate['me'] : '' }}</td>
                            <td>{{ isset($coordinate['mn']) ? $coordinate['mn'] : '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
