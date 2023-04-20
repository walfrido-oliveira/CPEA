@if(isset($sample['results']))
    <div class="flex flex-wrap mt-2 w-full flex-col mode-sample-table px-3">
        <div class="border-2 my-2 @if(count(array_chunk($sample['results'], $chuckSize)) > 1) duplicates-table @else default-table @endif">
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
                            @if(isset($sample['point'])) {{ $sample['point'] }} @endif
                        </td>
                        <td>
                            @if(isset($sample['collect']))  {{ Carbon\Carbon::parse($sample['collect'])->format("d/m/Y") }} @endif
                        </td>
                        <td>
                            @if(isset($sample['collect'])) {{ Carbon\Carbon::parse($sample['collect'])->format("H:i") }} @endif
                        </td>
                        <td>
                            @if(isset($sample['environment'])) {{ $sample['environment'] }} @endif
                        </td>
                        <td>
                            @if(isset($formPrint->formValue->values['matrix']))
                                @php
                                    $formType = App\Models\FieldType::find($formPrint->formValue->values['matrix']);
                                @endphp
                                {{  $formType->report_name ? $formType->report_name : $formType->name }}
                            @endif
                        </td>
                    <tr>
                </tbody>
            </table>
        </div>
        <div class="border-2 my-2 @if(count(array_chunk($sample['results'], $chuckSize)) > 1) duplicates-table @else default-table @endif">
            <table  class="table table-responsive md:table w-full">
                <thead>
                    <tr class="thead-light">
                        <x-table-sort-header :orderBy="null" :ascending="null" columnName="" columnText="{{ __('Parâmetro') }}"/>
                        <x-table-sort-header :orderBy="null" :ascending="null" columnName="" columnText="{{ __('Unidade') }}"/>
                        <x-table-sort-header :orderBy="null" :ascending="null" columnName="" columnText="{{ __('Resultado') }}"/>
                        <x-table-sort-header :orderBy="null" :ascending="null" columnName="" columnText="{{ __('Incerteza') }}"/>
                        <x-table-sort-header :orderBy="null" :ascending="null" columnName="" columnText="{{ __('LQ') }}"/>
                        <x-table-sort-header :orderBy="null" :ascending="null" columnName="" columnText="{{ __('Faixa') }}"/>
                    </tr>
                </thead>
                <tbody id="table_result">
                    @foreach ($formPrint->parameters as $key => $value)
                        @if(isset($formValue->values[$key . "_column"]))
                            <tr>
                                <td>
                                    {{ $value }}
                                </td>
                                <td>
                                    {{ $formPrint->unities[$key] }}
                                </td>
                                <td>
                                    @if(isset($formPrint->formValue->svgs[$row][$key]))
                                        @php
                                            if($key == "ntu" || $key == "eh") :
                                                $v = isset($sample[$key . "_footer"]) ? $sample[$key . "_footer"] : null;
                                            else :
                                                $v =  $formPrint->formValue->svgs[$row][$key];
                                            endif;
                                        @endphp

                                        @if((floatval($formPrint->LQ[$key]) > floatval($v) || !$v) && is_numeric($formPrint->LQ[$key]) && $v)
                                            {{'< ' . number_format(floatval($formPrint->LQ[$key]), $formPrint->places[$key], ",", ".") }}
                                        @elseif($key == "conductivity"  && $v >= 200000)
                                            {{ "> 200000" }}
                                        @elseif($key == "salinity"  && $v >= 70)
                                            {{ "> 70" }}
                                        @else
                                            {{ is_numeric($v) ? number_format($v, $formPrint->places[$key], ",", ".") : $v }}
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    {{ isset($sample[$key . "_uncertainty_footer"]) ?  '± ' . $sample[$key . "_uncertainty_footer"] : '-'}}
                                </td>
                                <td>
                                    {{ is_numeric($formPrint->LQ[$key]) ?  number_format(floatval($formPrint->LQ[$key]), $formPrint->places[$key], ",", ".") : $formPrint->LQ[$key] }}
                                </td>
                                <td>
                                    {{ $formPrint->range[$key] }}
                                </td>
                            <tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
