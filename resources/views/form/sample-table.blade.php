@php
    $parameters = [ "OD", "ORP", "pH", "Condutividade", "Salinidade", "Temperatura" ];
    $unities = [ "mg/L", "mV", "-", "µS/cm", "-", "°C" ];
    $LQ = ["0,3", "-", "-", "20", "0,01", "-"];

    $svg = [];

    $sum = 0;
    foreach ($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results'] as $value) {
        $sum += $value['temperature'];
    }
    $size = count($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results']);
    $svg[] = $sum / $size;

    $sum = 0;
    foreach ($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results'] as $value) {
        $sum += $value['ph'];
    }
    $size = count($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results']);
    $svg[] = $sum / $size;

    $sum = 0;
    foreach ($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results'] as $value) {
        $sum += $value['orp'];
    }
    $size = count($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results']);
    $svg[] = $sum / $size;

    $sum = 0;
    foreach ($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results'] as $value) {
        $sum += $value['conductivity'];
    }
    $size = count($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results']);
    $svg[] = $sum / $size;

    $sum = 0;
    foreach ($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results'] as $value) {
        $sum += $value['salinity'];
    }
    $size = count($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results']);
    $svg[] = $sum / $size;

    $sum = 0;
    foreach ($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results'] as $value) {
        $sum += $value['sat'];
    }
    $size = count($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results']);
    $svg[] = $sum / $size;

    $sum = 0;
    foreach ($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results'] as $value) {
        $sum += $value['conc'];
    }
    $size = count($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results']);
    $svg[] = $sum / $size;

    $svg[] = $svg[3] + 199;

    $places = [1, 0, 2, 0, 2, 2];

    $range = ['-', '-1400 +1400', '1 a 13', '-', '4 a 40'];

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
                        {{ $$range[$key] }}
                    </td>
                <tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
