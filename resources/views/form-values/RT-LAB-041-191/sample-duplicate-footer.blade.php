@if (isset(array_chunk($sample['results'], $chuckSize)[1]))
    <div class="w-full mt-2 duplicate fade">
        <h2 class="text-center text-white opacity-100 p-2 w-full" style="background-color: rgb(0, 94, 16)">DUPLICATA</h2>
        @if(count($sample['results'])>= 1)
            <table class="table table-responsive md:table w-full">
                <thead>
                    <tr class="thead-light">
                        @include('form-values.RT-LAB-041-191.sample-headers')
                </thead>
                <tbody id="table_result">
                    @foreach (array_chunk($sample['results'], $chuckSize)[1] as $key2 => $value)
                        @include('form-values.RT-LAB-041-191.sample-fields', ['key' => ($key2 + $key + 1), 'value' => $value])
                    @endforeach
                </tbody>
                <tfoot id="table_result_footer">
                    <tr>
                        <td colspan="100%" class="text-center text-white" style="background-color: rgb(0, 94, 16)">Resultados</td>
                    </tr>
                    <tr>
                        @if(isset($formValue->values["temperature_column"]))
                            <td>
                                {{ number_format($formValue->duplicates_svgs['row_' . ($i)]['temperature'], $formPrint->places['temperature'], ",", ".") }}
                            </td>
                        @endif
                        @if(isset($formValue->values["ph_column"]))
                            <td>
                                {{ number_format($formValue->duplicates_svgs['row_' . ($i)]['ph'], $formPrint->places['ph'], ",", ".") }}
                            </td>
                        @endif
                        @if(isset($formValue->values["orp_column"]))
                            <td>
                                {{ number_format($formValue->duplicates_svgs['row_' . ($i)]['orp'], $formPrint->places['orp'], ",", ".") }}
                            </td>
                        @endif
                        @if(isset($formValue->values["conductivity_column"]))
                            <td>
                                {{ number_format($formValue->duplicates_svgs['row_' . ($i)]['conductivity'], $formPrint->places['conductivity'], ",", ".") }}
                            </td>
                        @endif
                        @if(isset($formValue->values["salinity_column"]))
                            <td>
                                {{ number_format($formValue->duplicates_svgs['row_' . ($i)]['salinity'], $formPrint->places['salinity'], ",", ".") }}
                            </td>
                        @endif
                        @if(isset($formValue->values["psi_column"]))
                            <td>
                                -
                            </td>
                        @endif
                        @if(isset($formValue->values["sat_column"]))
                            <td>
                                {{ number_format($formValue->duplicates_svgs['row_' . ($i)]['sat'], $formPrint->places['sat'], ",", ".") }}
                            </td>
                        @endif
                        @if(isset($formValue->values["conc_column"]))
                            <td>
                                {{ number_format($formValue->duplicates_svgs['row_' . ($i)]['conc'], $formPrint->places['conc'], ",", ".") }}
                            </td>
                        @endif
                        @if(isset($formValue->values["eh_column"]))
                            <td>
                                {{ number_format($formValue->duplicates_svgs['row_' . ($i)]['eh'], $formPrint->places['eh'], ",", ".") }}
                            </td>
                        @endif
                        @if(isset($formValue->values["ntu_column"]))
                            <td>
                                {{ number_format($formValue->duplicates_svgs['row_' . ($i)]['ntu'], $formPrint->places['eh'], ",", ".") }}
                            </td>
                        @endif
                        @if(isset($formValue->values["chlorine_column"]))
                            <td>
                                {{ number_format($formValue->duplicates_svgs['row_' . ($i)]['chlorine'], $formPrint->places['eh'], ",", ".") }}
                            </td>
                        @endif
                        @if(isset($formValue->values["residualchlorine_column"]))
                            <td>
                                {{ number_format($formValue->duplicates_svgs['row_' . ($i)]['residualchlorine'], $formPrint->places['eh'], ",", ".") }}
                            </td>
                        @endif
                        @if(isset($formValue->values["aspect_column"]))
                            <td>
                                -
                            </td>
                        @endif
                        @if(isset($formValue->values["artificialdyes_column"]))
                            <td>
                                -
                            </td>
                        @endif
                        @if(isset($formValue->values["floatingmaterials_column"]))
                            <td>
                                -
                            </td>
                        @endif
                        @if(isset($formValue->values["objectablesolidwaste_column"]))
                            <td>
                                -
                            </td>
                        @endif
                        @if(isset($formValue->values["visibleoilsandgreases_column"]))
                            <td>
                                -
                            </td>
                        @endif
                        @if(isset($formValue->values["voc_column"]))
                            <td>
                                {{ number_format($formValue->duplicates_svgs['row_' . ($i)]['voc'], $formPrint->places['eh'], ",", ".") }}
                            </td>
                        @endif
                    </tr>
                    <tr>
                        <td colspan="100%" class="text-center text-white" style="background-color: rgb(0, 94, 16)">% DPR</td>
                    </tr>
                    <tr>
                        @if(isset($formValue->values["temperature_column"]))
                            <td>
                                @if(isset($value['temperature']) && $formValue->svgs['row_' . ($i)]['temperature'] != 0)
                                    {{ number_format($formValue->dpr['row_' . ($i)]['temperature'], 2, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                        @endif
                        @if(isset($formValue->values["ph_column"]))
                            <td>
                                @if(isset($value['ph']) && $formValue->svgs['row_' . ($i)]['ph'] != 0)
                                    {{ number_format($formValue->dpr['row_' . ($i)]['ph'], 2, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                        @endif
                        @if(isset($formValue->values["orp_column"]))
                            <td>
                                @if(isset($value['orp']) && $formValue->svgs['row_' . ($i)]['orp'] != 0)
                                    {{ number_format($formValue->dpr['row_' . ($i)]['orp'], 2, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                        @endif
                        @if(isset($formValue->values["conductivity_column"]))
                            <td>
                                @if(isset($value['conductivity']) && $formValue->svgs['row_' . ($i)]['conductivity'] != 0)
                                    {{ number_format($formValue->dpr['row_' . ($i)]['conductivity'], 2, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                        @endif
                        @if(isset($formValue->values["salinity_column"]))
                            <td>
                                @if(isset($value['salinity']) && $formValue->svgs['row_' . ($i)]['salinity'] != 0)
                                    {{ number_format($formValue->dpr['row_' . ($i)]['salinity'], 2, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                        @endif
                        @if(isset($formValue->values["psi_column"]))
                            <td>
                                @if(isset($value['psi']) && $formValue->svgs['row_' . ($i)]['psi'] != 0)
                                    {{ number_format($formValue->dpr['row_' . ($i)]['psi'], 2, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                        @endif
                        @if(isset($formValue->values["sat_column"]))
                            <td>
                                @if(isset($value['sat']) && $formValue->svgs['row_' . ($i)]['sat'] != 0)
                                    {{ number_format($formValue->dpr['row_' . ($i)]['sat'], 2, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                        @endif
                        @if(isset($formValue->values["conc_column"]))
                            <td>
                                @if(isset($value['conc']) && $formValue->svgs['row_' . ($i)]['conc'] != 0)
                                    {{ number_format($formValue->dpr['row_' . ($i)]['conc'], 2, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                        @endif
                        @if(isset($formValue->values["eh_column"]))
                            <td>
                                @if(isset($value['eh']) && $formValue->svgs['row_' . ($i)]['eh'] != 0)
                                    {{ number_format($formValue->dpr['row_' . ($i)]['eh'], 1, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                        @endif
                        @if(isset($formValue->values["ntu_column"]))
                            <td>
                                @if(isset($value['ntu']) && $formValue->svgs['row_' . ($i)]['ntu'] != 0)
                                    {{ number_format($formValue->dpr['row_' . ($i)]['ntu'], 1, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                        @endif
                        @if(isset($formValue->values["chlorine_column"]))
                            <td>
                                @if(isset($value['chlorine']) && $formValue->svgs['row_' . ($i)]['chlorine'] != 0)
                                    {{ number_format($formValue->dpr['row_' . ($i)]['chlorine'], 1, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                        @endif
                        @if(isset($formValue->values["residualchlorine_column"]))
                            <td>
                                @if(isset($value['residualchlorine']) && $formValue->svgs['row_' . ($i)]['residualchlorine'] != 0)
                                    {{ number_format($formValue->dpr['row_' . ($i)]['residualchlorine'], 1, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                        @endif
                        @if(isset($formValue->values["aspect_column"]))
                            <td>
                                -
                            </td>
                        @endif
                        @if(isset($formValue->values["artificialdyes_column"]))
                            <td>
                                -
                            </td>
                        @endif
                        @if(isset($formValue->values["floatingmaterials_column"]))
                            <td>
                                -
                            </td>
                        @endif
                        @if(isset($formValue->values["objectablesolidwaste_column"]))
                            <td>
                                -
                            </td>
                        @endif
                        @if(isset($formValue->values["visibleoilsandgreases_column"]))
                            <td>
                                -
                            </td>
                        @endif
                        @if(isset($formValue->values["voc_column"]))
                            <td>
                                @if(isset($value['voc']) && $formValue->svgs['row_' . ($i)]['voc'] != 0)
                                    {{ number_format($formValue->dpr['row_' . ($i)]['voc'], 1, ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                        @endif
                    <tr>
                </tfoot>
            </table>
        @endif
    </div>
@endif
