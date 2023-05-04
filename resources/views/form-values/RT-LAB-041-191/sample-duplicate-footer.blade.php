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
                                @php
                                    if(!isset($sample['eh_footer_duplicate'])) :
                                        $sample['eh_footer_duplicate'] = $formValue->duplicates_svgs['row_' . ($i)]['eh'];
                                    endif;
                                @endphp
                                @if(isset($sample['eh_footer_duplicate']))
                                    <x-jet-input readonly="{{ !$formValue ? false : true}}" id="eh_footer_duplicate_{{ isset($i) ? $i : 0 }}"
                                                class="form-control block mt-1 w-full eh_footer_duplicate" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                                                type="number" value="{{ number_format($sample['eh_footer_duplicate'], $formPrint->places['eh']) }}"
                                                name="{{ isset($i) ? 'samples[row_' . ($i) . '][eh_footer_duplicate]' : 'samples[row_0][eh_footer_duplicate]' }}" />
                                @else
                                    <x-jet-input id="eh_footer_duplicate_0" class="form-control block mt-1 w-full eh_footer_duplicate" type="number" value=""
                                                name="samples[row_0][eh_footer_duplicate]" step="any" data-index="{{ isset($i) ? $i : 0 }}"/>
                                @endif
                            </td>
                        @endif
                        @if(isset($formValue->values["ntu_column"]))
                            <td>
                                @if(isset($sample['ntu_footer_duplicate']))
                                    <x-jet-input readonly="{{ !$formValue ? false : true}}" id="ntu_footer_duplicate_{{ isset($i) ? $i : 0 }}"
                                                class="form-control block mt-1 w-full ntu_footer_duplicate" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                                                type="number" value="{{ $sample['ntu_footer_duplicate'] != 0 ? number_format($sample['ntu_footer_duplicate'], $formPrint->places['ntu']) : '' }}"
                                                name="{{ isset($i) ? 'samples[row_' . ($i) . '][ntu_footer_duplicate]' : 'samples[row_0][ntu_footer_duplicate]' }}" />
                                @else
                                    <x-jet-input id="ntu_footer_duplicate_0" class="form-control block mt-1 w-full ntu_footer_duplicate" type="number" value=""
                                                name="samples[row_0][ntu_footer_duplicate]" step="any" data-index="{{ isset($i) ? $i : 0 }}"/>
                                @endif
                            </td>
                        @endif
                        @if(isset($formValue->values["chlorine_column"]))
                            <td>
                                @if(isset($sample['chlorine_footer_duplicate']))
                                    <x-jet-input readonly="{{ !$formValue ? false : true}}" id="chlorine_footer_duplicate_{{ isset($i) ? $i : 0 }}"
                                                class="form-control block mt-1 w-full chlorine_footer_duplicate" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                                                type="number" value="{{ $sample['chlorine_footer_duplicate'] != 0 ? number_format($sample['chlorine_footer_duplicate'], $formPrint->places['chlorine']) : '' }}"
                                                name="{{ isset($i) ? 'samples[row_' . ($i) . '][chlorine_footer_duplicate]' : 'samples[row_0][chlorine_footer_duplicate]' }}" />
                                @else
                                    <x-jet-input id="chlorine_footer_duplicate_0" class="form-control block mt-1 w-full chlorine_footer_duplicate" type="number" value=""
                                                name="samples[row_0][chlorine_footer_duplicate]" step="any" data-index="{{ isset($i) ? $i : 0 }}"/>
                                @endif
                            </td>
                        @endif
                        @if(isset($formValue->values["residualchlorine_column"]))
                            <td>
                                @if(isset($sample['residualchlorine_footer_duplicate']))
                                    <x-jet-input readonly="{{ !$formValue ? false : true}}" id="residualchlorine_footer_duplicate_{{ isset($i) ? $i : 0 }}"
                                                class="form-control block mt-1 w-full residualchlorine_footer_duplicate" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                                                type="number" value="{{ $sample['residualchlorine_footer_duplicate'] != 0 ? number_format($sample['residualchlorine_footer_duplicate'], $formPrint->places['residualchlorine']) : '' }}"
                                                name="{{ isset($i) ? 'samples[row_' . ($i) . '][residualchlorine_footer_duplicate]' : 'samples[row_0][residualchlorine_footer_duplicate]' }}" />
                                @else
                                    <x-jet-input id="residualchlorine_footer_duplicate_0" class="form-control block mt-1 w-full residualchlorine_footer_duplicate" type="number" value=""
                                                name="samples[row_0][residualchlorine_footer_duplicate]" step="any" data-index="{{ isset($i) ? $i : 0 }}"/>
                                @endif
                            </td>
                        @endif
                        @if(isset($formValue->values["aspect_column"]))
                            <td>
                                <x-custom-select disabled="true" :options="$choises" value="{{ isset($value['aspect_footer_duplicate']) ? $value['aspect_footer_duplicate'] : null }}"
                                name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][aspect_footer_duplicate]' : 'samples[row_0][results]['. $key . '][aspect_footer_duplicate]' }}"
                                id="aspect_footer_duplicate" class="mt-1" select-class="no-nice-select"/>
                            </td>
                        @endif
                        @if(isset($formValue->values["artificialdyes_column"]))
                            <td>
                                <x-custom-select disabled="true" :options="$choises" value="{{ isset($value['floatingmaterials_footer_duplicate']) ? $value['floatingmaterials_footer_duplicate'] : null }}"
                                name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][floatingmaterials_footer_duplicate]' : 'samples[row_0][results]['. $key . '][floatingmaterials_footer_duplicate]' }}"
                                id="floatingmaterials_footer_duplicate" class="mt-1" select-class="no-nice-select"/>
                            </td>
                        @endif
                        @if(isset($formValue->values["floatingmaterials_column"]))
                            <td>
                                <x-custom-select disabled="true" :options="$choises" value="{{ isset($value['floatingmaterials_footer_duplicate']) ? $value['floatingmaterials_footer_duplicate'] : null }}"
                                name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][floatingmaterials_footer_duplicate]' : 'samples[row_0][results]['. $key . '][floatingmaterials_footer_duplicate]' }}"
                                id="floatingmaterials_footer_duplicate" class="mt-1" select-class="no-nice-select"/>
                            </td>
                        @endif
                        @if(isset($formValue->values["objectablesolidwaste_column"]))
                            <td>
                                <x-custom-select disabled="true" :options="$choises" value="{{ isset($value['objectablesolidwaste_footer_duplicate']) ? $value['objectablesolidwaste_footer_duplicate'] : null }}"
                                name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][objectablesolidwaste_footer_duplicate]' : 'samples[row_0][results]['. $key . '][objectablesolidwaste_footer_duplicate]' }}"
                                id="objectablesolidwaste_footer_duplicate" class="mt-1" select-class="no-nice-select"/>
                            </td>
                        @endif
                        @if(isset($formValue->values["visibleoilsandgreases_column"]))
                            <td>
                                <x-custom-select disabled="true" :options="$choises" value="{{ isset($value['visibleoilsandgreases_footer_duplicate']) ? $value['visibleoilsandgreases_footer_duplicate'] : null }}"
                                name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][visibleoilsandgreases_footer_duplicate]' : 'samples[row_0][results]['. $key . '][visibleoilsandgreases_footer_duplicate]' }}"
                                id="visibleoilsandgreases_footer_duplicate" class="mt-1" select-class="no-nice-select"/>
                            </td>
                        @endif
                        @if(isset($formValue->values["voc_column"]))
                            <td>
                                @if(isset($sample['voc_footer_duplicate']))
                                    <x-jet-input readonly="{{ !$formValue ? false : true}}" id="voc_footer_duplicate_{{ isset($i) ? $i : 0 }}"
                                                class="form-control block mt-1 w-full voc_footer_duplicate" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                                                type="number" value="{{ $sample['voc_footer_duplicate'] != 0 ? number_format($sample['voc_footer_duplicate'], $formPrint->places['voc']) : '' }}"
                                                name="{{ isset($i) ? 'samples[row_' . ($i) . '][voc_footer_duplicate]' : 'samples[row_0][voc_footer_duplicate]' }}" />
                                @else
                                    <x-jet-input id="voc_footer_duplicate_0" class="form-control block mt-1 w-full voc_footer_duplicate" type="number" value=""
                                                name="samples[row_0][voc_footer_duplicate]" step="any" data-index="{{ isset($i) ? $i : 0 }}"/>
                                @endif
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
                        @if(isset($formValue->values["ntu_column"]) && $sample["ntu_footer_duplicate"] != 0)
                            <td>
                                {{ number_format($formValue->dpr['row_' . ($i)]['ntu'], 1, ",", ".") }}
                            </td>
                        @endif
                        @if(isset($formValue->values["chlorine_column"]) && $sample["chlorine_footer_duplicate"] != 0)
                            <td>
                                {{ number_format($formValue->dpr['row_' . ($i)]['chlorine'], 1, ",", ".") }}
                            </td>
                        @endif
                        @if(isset($formValue->values["residualchlorine_column"]) && $sample["residualchlorine_footer_duplicate"] != 0)
                            <td>
                                {{ number_format($formValue->dpr['row_' . ($i)]['residualchlorine'], 1, ",", ".") }}
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
                        @if(isset($formValue->values["voc_column"]) && $sample["voc_footer_duplicate"] != 0)
                            <td>
                                {{ number_format($formValue->dpr['row_' . ($i)]['voc'], 1, ",", ".") }}
                            </td>
                        @endif
                    <tr>
                </tfoot>
            </table>
        @endif
    </div>
@endif
