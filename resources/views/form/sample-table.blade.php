@if(isset($sample['results']))
    @php
        $parameters = [
            "temperature" => "Temperatura",
            "ph" => "pH",
            "orp" => "ORP",
            "conductivity" => "Condutividade",
            "salinity" => "Salinidade",
            "conc" => "OD"
        ];

        $unities = [
            "temperature" => "°C",
            "ph" => "-",
            "orp" => "mV",
            "conductivity" => "µS/cm",
            "salinity" => "-",
            "conc" => "mg/L"
        ];

        $LQ = [
            "temperature" => "-",
            "ph" => "-",
            "orp" => "-",
            "conductivity" => "20",
            "salinity" => "0,01",
            "conc" => "0,3"
        ];

        $places = [
            "temperature" => 2,
            "ph" => 2,
            "orp" => 1,
            "conductivity" => 3,
            "salinity" => 3,
            "conc" => 3
        ];

        $range = [
            "temperature" => "4 a 40",
            "ph" => "1 a 13",
            "orp" => "-1400 a +1400",
            "conductivity" => "-",
            "salinity" => "-",
            "conc" => "-"
        ];
    @endphp

    <div class="flex flex-wrap mt-2 w-full flex-col mode-sample-table">
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
                            {{ number_format($svgs['row_' . ($i)][$key], $places[$key], ",", ".") }}
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
