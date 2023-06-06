@if (isset(array_chunk($sample['results'], $chuckSize)[1]))
    <div class="w-full mt-2 duplicate fade">
        @if(count($sample['results'])>= 1)
            <table class="table md:table w-full">
                <thead>
                    <tr>
                        <td colspan="100%" class="text-center text-white" style="background-color: rgb(0, 94, 16)">Duplicata</td>
                    </tr>
                    <tr class="thead-light">
                        @include('form-values.RT-LAB-041-191.sample-headers')
                    </tr>
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
                        @if(isset($formValue->values["temperature_column"]) && isset($formValue->duplicates['row_' . ($i)]['temperature']))
                            <td>
                                {{ number_format($formValue->duplicates['row_' . ($i)]['temperature'], $formPrint->places['temperature'], ",", ".") }}
                            </td>
                        @endif
                        @if(isset($formValue->values["ph_column"]) && isset($formValue->duplicates['row_' . ($i)]['ph']))
                            <td>
                                {{ number_format($formValue->duplicates['row_' . ($i)]['ph'], $formPrint->places['ph'], ",", ".") }}
                            </td>
                        @endif
                        @if(isset($formValue->values["orp_column"]) && isset($formValue->duplicates['row_' . ($i)]['orp']))
                            <td>
                                {{ number_format($formValue->duplicates['row_' . ($i)]['orp'], $formPrint->places['orp'], ",", ".") }}
                            </td>
                        @endif
                        @if(isset($formValue->values["conductivity_column"]) && isset($formValue->duplicates['row_' . ($i)]['conductivity']))
                            <td>
                                {{ number_format($formValue->duplicates['row_' . ($i)]['conductivity'], $formPrint->places['conductivity'], ",", ".") }}
                            </td>
                        @endif
                        @if(isset($formValue->values["salinity_column"]) && isset($formValue->duplicates['row_' . ($i)]['salinity']))
                            <td>
                                {{ number_format($formValue->duplicates['row_' . ($i)]['salinity'], $formPrint->places['salinity'], ",", ".") }}
                            </td>
                        @endif
                        @if(isset($formValue->values["psi_column"]))
                            <td>
                                -
                            </td>
                        @endif
                        @if(isset($formValue->values["sat_column"]) && isset($formValue->duplicates['row_' . ($i)]['sat']))
                            <td>
                                {{ number_format($formValue->duplicates['row_' . ($i)]['sat'], $formPrint->places['sat'], ",", ".") }}
                            </td>
                        @endif
                        @if(isset($formValue->values["conc_column"]) && isset($formValue->duplicates['row_' . ($i)]['conc']))
                            <td>
                                {{ number_format($formValue->duplicates['row_' . ($i)]['conc'], $formPrint->places['conc'], ",", ".") }}
                            </td>
                        @endif
                        @if(isset($formValue->values["eh_column"]) && isset($formValue->duplicates['row_' . ($i)]['eh']))
                            <td>
                                {{ number_format($formValue->duplicates['row_' . ($i)]['eh'], $formPrint->places['eh'], ",", ".") }}
                            </td>
                        @endif
                        @if(isset($formValue->values["ntu_column"]))
                            <td>
                                <x-jet-input readonly="{{ !$formValue ? false : true}}" id="ntu_footer_duplicate_{{ isset($i) ? $i : 0 }}"
                                            class="form-control block mt-1 w-full ntu_footer_duplicate" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                                            type="number" value="{{ isset($sample['ntu_footer_duplicate']) ? number_format($sample['ntu_footer_duplicate'], $formPrint->places['ntu']) : '' }}"
                                            name="{{ isset($i) ? 'samples[row_' . ($i) . '][ntu_footer_duplicate]' : 'samples[row_0][ntu_footer_duplicate]' }}" />
                            </td>
                        @endif
                        @if(isset($formValue->values["chlorine_column"]))
                            <td>
                                <x-jet-input readonly="{{ !$formValue ? false : true}}" id="chlorine_footer_duplicate_{{ isset($i) ? $i : 0 }}"
                                            class="form-control block mt-1 w-full chlorine_footer_duplicate" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                                            type="number" value="{{ isset($sample['chlorine_footer_duplicate']) ? number_format($sample['chlorine_footer_duplicate'], $formPrint->places['chlorine']) : '' }}"
                                            name="{{ isset($i) ? 'samples[row_' . ($i) . '][chlorine_footer_duplicate]' : 'samples[row_0][chlorine_footer_duplicate]' }}" />
                            </td>
                        @endif
                        @if(isset($formValue->values["residualchlorine_column"]))
                            <td>
                                <x-jet-input readonly="{{ !$formValue ? false : true}}" id="residualchlorine_footer_duplicate_{{ isset($i) ? $i : 0 }}"
                                            class="form-control block mt-1 w-full residualchlorine_footer_duplicate" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                                            type="number" value="{{ isset($sample['residualchlorine_footer_duplicate']) ? number_format($sample['residualchlorine_footer_duplicate'], $formPrint->places['residualchlorine']) : '' }}"
                                            name="{{ isset($i) ? 'samples[row_' . ($i) . '][residualchlorine_footer_duplicate]' : 'samples[row_0][residualchlorine_footer_duplicate]' }}" />
                            </td>
                        @endif
                        @if(isset($formValue->values["aspect_column"]))
                            <td>
                                <x-custom-select disabled="true" :options="$choises" value="{{ isset($value['aspect_footer_duplicate']) ? $value['aspect_footer_duplicate'] : null }}"
                                name="{{ isset($i) ? 'samples[row_' . ($i) . '][aspect_footer_duplicate]' : 'samples[row_0][aspect_footer_duplicate]' }}"
                                id="aspect_footer_duplicate" class="mt-1" select-class="no-nice-select"/>
                            </td>
                        @endif
                        @if(isset($formValue->values["artificialdyes_column"]))
                            <td>
                                <x-custom-select disabled="true" :options="$choises" value="{{ isset($value['floatingmaterials_footer_duplicate']) ? $value['floatingmaterials_footer_duplicate'] : null }}"
                                name="{{ isset($i) ? 'samples[row_' . ($i) . '][floatingmaterials_footer_duplicate]' : 'samples[row_0][floatingmaterials_footer_duplicate]' }}"
                                id="floatingmaterials_footer_duplicate" class="mt-1" select-class="no-nice-select"/>
                            </td>
                        @endif
                        @if(isset($formValue->values["floatingmaterials_column"]))
                            <td>
                                <x-custom-select disabled="true" :options="$choises" value="{{ isset($value['floatingmaterials_footer_duplicate']) ? $value['floatingmaterials_footer_duplicate'] : null }}"
                                name="{{ isset($i) ? 'samples[row_' . ($i) . '][floatingmaterials_footer_duplicate]' : 'samples[row_0][floatingmaterials_footer_duplicate]' }}"
                                id="floatingmaterials_footer_duplicate" class="mt-1" select-class="no-nice-select"/>
                            </td>
                        @endif
                        @if(isset($formValue->values["objectablesolidwaste_column"]))
                            <td>
                                <x-custom-select disabled="true" :options="$choises" value="{{ isset($value['objectablesolidwaste_footer_duplicate']) ? $value['objectablesolidwaste_footer_duplicate'] : null }}"
                                name="{{ isset($i) ? 'samples[row_' . ($i) . '][objectablesolidwaste_footer_duplicate]' : 'samples[row_0][objectablesolidwaste_footer_duplicate]' }}"
                                id="objectablesolidwaste_footer_duplicate" class="mt-1" select-class="no-nice-select"/>
                            </td>
                        @endif
                        @if(isset($formValue->values["visibleoilsandgreases_column"]))
                            <td>
                                <x-custom-select disabled="true" :options="$choises" value="{{ isset($value['visibleoilsandgreases_footer_duplicate']) ? $value['visibleoilsandgreases_footer_duplicate'] : null }}"
                                name="{{ isset($i) ? 'samples[row_' . ($i) . '][visibleoilsandgreases_footer_duplicate]' : 'samples[row_0][visibleoilsandgreases_footer_duplicate]' }}"
                                id="visibleoilsandgreases_footer_duplicate" class="mt-1" select-class="no-nice-select"/>
                            </td>
                        @endif
                        @if(isset($formValue->values["voc_column"]))
                            <td>
                                <x-jet-input readonly="{{ !$formValue ? false : true}}" id="voc_footer_duplicate_{{ isset($i) ? $i : 0 }}"
                                            class="form-control block mt-1 w-full voc_footer_duplicate" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                                            type="number" value="{{ isset($sample['voc_footer_duplicate']) ? number_format($sample['voc_footer_duplicate'], $formPrint->places['voc']) : '' }}"
                                            name="{{ isset($i) ? 'samples[row_' . ($i) . '][voc_footer_duplicate]' : 'samples[row_0][voc_footer_duplicate]' }}" />
                            </td>
                        @endif
                    </tr>
                    <tr>
                        <td colspan="100%" class="text-center text-white" style="background-color: rgb(0, 94, 16)">% DPR</td>
                    </tr>
                    <tr>
                        @if(isset($formValue->values["temperature_column"]) && isset($formValue->dpr['row_' . ($i)]['temperature']))
                            <td>
                                @if($formValue->dpr['row_' . ($i)]['temperature'] != 0)
                                    {{ number_format($formValue->dpr['row_' . ($i)]['temperature'], $formPrint->places['temperature'], ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                        @endif
                        @if(isset($formValue->values["ph_column"]) && isset($formValue->dpr['row_' . ($i)]['ph']))
                            <td>
                                @if($formValue->dpr['row_' . ($i)]['ph'] != 0)
                                    {{ number_format($formValue->dpr['row_' . ($i)]['ph'], $formPrint->places['ph'], ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                        @endif
                        @if(isset($formValue->values["orp_column"]) && isset($formValue->dpr['row_' . ($i)]['orp']))
                            <td>
                                @if($formValue->dpr['row_' . ($i)]['orp'] != 0)
                                    {{ number_format($formValue->dpr['row_' . ($i)]['orp'], $formPrint->places['orp'], ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                        @endif
                        @if(isset($formValue->values["conductivity_column"]) && isset($formValue->dpr['row_' . ($i)]['conductivity']))
                            <td>
                                @if($formValue->dpr['row_' . ($i)]['conductivity'] != 0)
                                    {{ number_format($formValue->dpr['row_' . ($i)]['conductivity'], $formPrint->places['conductivity'], ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                        @endif
                        @if(isset($formValue->values["salinity_column"]) && isset($formValue->dpr['row_' . ($i)]['salinity']))
                            <td>
                                @if($formValue->dpr['row_' . ($i)]['salinity'] != 0)
                                    {{ number_format($formValue->dpr['row_' . ($i)]['salinity'], $formPrint->places['salinity'], ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                        @endif
                        @if(isset($formValue->values["psi_column"]) && isset($formValue->dpr['row_' . ($i)]['psi']))
                            <td>
                                @if($formValue->dpr['row_' . ($i)]['psi'] != 0)
                                    {{ number_format($formValue->dpr['row_' . ($i)]['psi'], $formPrint->places['psi'], ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                        @endif
                        @if(isset($formValue->values["sat_column"]) && isset($formValue->dpr['row_' . ($i)]['sat']))
                            <td>
                                @if($formValue->dpr['row_' . ($i)]['sat'] != 0)
                                    {{ number_format($formValue->dpr['row_' . ($i)]['sat'], $formPrint->places['sat'], ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                        @endif
                        @if(isset($formValue->values["conc_column"]) && isset($formValue->dpr['row_' . ($i)]['conc']))
                            <td>
                                @if($formValue->dpr['row_' . ($i)]['conc'] != 0)
                                    {{ number_format($formValue->dpr['row_' . ($i)]['conc'], $formPrint->places['conc'], ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                        @endif
                        @if(isset($formValue->values["eh_column"]) && isset($formValue->dpr['row_' . ($i)]['eh']))
                            <td>
                                @if($formValue->dpr['row_' . ($i)]['eh'] != 0)
                                    {{ number_format($formValue->dpr['row_' . ($i)]['eh'], $formPrint->places['eh'], ",", ".") }}
                                @else
                                    -
                                @endif
                            </td>
                        @endif
                        @if(isset($formValue->values["ntu_column"]) && isset($formValue->dpr['row_' . ($i)]['ntu']))
                            <td>
                                {{ number_format($formValue->dpr['row_' . ($i)]['ntu'], $formPrint->places['ntu'], ",", ".") }}
                            </td>
                        @endif
                        @if(isset($formValue->values["chlorine_column"]) && isset($formValue->dpr['row_' . ($i)]['chlorine']))
                            <td>
                                {{ isset($formValue->dpr['row_' . ($i)]['chlorine']) ? number_format($formValue->dpr['row_' . ($i)]['chlorine'], $formPrint->places['chlorine'], ",", ".") : '' }}
                            </td>
                        @endif
                        @if(isset($formValue->values["residualchlorine_column"]) && isset($formValue->dpr['row_' . ($i)]['residualchlorine']))
                            <td>
                                {{ isset($formValue->dpr['row_' . ($i)]['residualchlorine']) ? number_format($formValue->dpr['row_' . ($i)]['residualchlorine'], $formPrint->places['residualchlorine'], ",", ".") : '' }}
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
                        @if(isset($formValue->values["voc_column"]) && isset($sample["voc_footer_duplicate"]))
                            <td>
                                {{ isset($formValue->dpr['row_' . ($i)]['voc']) ? number_format($formValue->dpr['row_' . ($i)]['voc'], 1, ",", ".") : ''}}
                            </td>
                        @endif
                    <tr>
                </tfoot>
            </table>
        @endif
    </div>
@endif
