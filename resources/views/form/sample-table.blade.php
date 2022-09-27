@if(isset($sample['results']))
    @php

        $parameters = [ "Temperatura", "pH", "ORP", "Condutividade", "Salinidade", "OD" ];
        $unities = [ "°C", "-", "mV", "µS/cm", "-", "mg/L" ];
        $LQ = ["-", "-", "-", "20", "0,01", "0,3"];
        $places = [2, 2, 1, 3, 3, 3];
        $range = ["4 a 40", "1 a 13", "-1400 a +1400", "-", "-", "-" ];

        $svg = [];
        $size = count(array_chunk($sample['results'], 3)[0]);

        $sum = 0;
        foreach (array_chunk($sample['results'], 3)[0] as $value) {
            $sum += $value['temperature'];
        }
        $svg[] = $sum / $size;

        $sum = 0;
        foreach (array_chunk($sample['results'], 3)[0] as $value) {
            $sum += $value['ph'];
        }
        $svg[] = $sum / $size;

        $sum = 0;
        foreach (array_chunk($sample['results'], 3)[0] as $value) {
            $sum += $value['orp'];
        }
        $svg[] = $sum / $size;

        $sum = 0;
        foreach (array_chunk($sample['results'], 3)[0] as $value) {
            $sum += $value['conductivity'];
        }
        $svg[] = $sum / $size;

        $sum = 0;
        foreach (array_chunk($sample['results'], 3)[0] as $value) {
            $sum += $value['salinity'];
        }
        $svg[] = $sum / $size;

        $sum = 0;
        foreach (array_chunk($sample['results'], 3)[0] as $value) {
            $sum += $value['conc'];
        }
        $svg[] = $sum / $size;

        $svg[] = $svg[3] + 199;


    @endphp

    <div class="flex flex-wrap mt-2 w-full flex-col mode-sample-table" style="display: none">
        <div class="border-2 my-2">
            <table class="table table-responsive md:table w-full">
                <thead>
                    <tr class="thead-light">
                        <x-table-sort-header :orderBy="null" :ascending="null" columnName="point" columnText="{{ __('Amostra') }}"/>
                        <x-table-sort-header :orderBy="null" :ascending="null" columnName="collect" columnText="{{ __('Data da Coleta') }}"/>
                        <x-table-sort-header :orderBy="null" :ascending="null" columnName="hour" columnText="{{ __('Hora') }}"/>
                        <x-table-sort-header :orderBy="null" :ascending="null" columnName="environment" columnText="{{ __('Condições Ambientais') }}"/>
                        <x-table-sort-header :orderBy="null" :ascending="null" columnName="matrix" columnText="{{ __('Matriz') }}"/>
                    </tr>
                </thead>
                <tbody id="table_result">
                    <tr>
                        <td>
                            {{ $sample['point'] }}
                        </td>
                        <td>
                            {{ Carbon\Carbon::parse($sample['collect'])->format("d/m/Y") }}
                        </td>
                        <td>
                            {{ Carbon\Carbon::parse($sample['collect'])->format("h:i") }}
                        </td>
                        <td>
                            {{ $sample['environment'] }}
                        </td>
                        <td>
                            {{ $form->fieldType->name }}
                        </td>
                    <tr>
                </tbody>
            </table>
        </div>
        <div class="border-2 my-2">
            <table  class="table table-responsive md:table w-full">
                <thead>
                    <tr class="thead-light">
                        <x-table-sort-header :orderBy="null" :ascending="null" columnName="" columnText="{{ __('Parâmetro') }}"/>
                        <x-table-sort-header :orderBy="null" :ascending="null" columnName="" columnText="{{ __('Unidade') }}"/>
                        <x-table-sort-header :orderBy="null" :ascending="null" columnName="" columnText="{{ __('Resultado') }}"/>
                        <x-table-sort-header :orderBy="null" :ascending="null" columnName="" columnText="{{ __('LQ') }}"/>
                        <x-table-sort-header :orderBy="null" :ascending="null" columnName="" columnText="{{ __('Faixa') }}"/>
                    </tr>
                </thead>
                <tbody id="table_result">
                    @foreach ($parameters as $key => $value)
                    <tr>
                        <td>
                            {{ $value }}
                        </td>
                        <td>
                            {{ $unities[$key] }}
                        </td>
                        <td>
                            {{ number_format($svg[$key], $places[$key], ",", ".") }}
                        </td>
                        <td>
                            {{ $LQ[$key] }}
                        </td>
                        <td>
                            {{ $range[$key] }}
                        </td>
                    <tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
