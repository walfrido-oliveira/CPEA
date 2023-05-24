
<tr>
    <td colspan="100%" class="text-center text-white" style="background-color: rgb(0, 94, 16)">Resultados</td>
</tr>
<tr>
    @if(isset($formValue->values["temperature_column"]))
        <td>
            {{ number_format($formValue->svgs['row_' . ($i)]['temperature'], $formPrint->places['temperature'], ",", ".") }}
        </td>
    @endif
    @if(isset($formValue->values["ph_column"]))
        <td>
            {{ number_format($formValue->svgs['row_' . ($i)]['ph'], $formPrint->places['ph'], ",", ".") }}
        </td>
    @endif
    @if(isset($formValue->values["orp_column"]))
        <td>
            {{ number_format($formValue->svgs['row_' . ($i)]['orp'], $formPrint->places['orp'], ",", ".") }}
        </td>
    @endif
    @if(isset($formValue->values["conductivity_column"]))
        <td>
            {{ number_format($formValue->svgs['row_' . ($i)]['conductivity'], $formPrint->places['conductivity'], ",", ".") }}
        </td>
    @endif
    @if(isset($formValue->values["salinity_column"]))
        <td>
            {{ number_format($formValue->svgs['row_' . ($i)]['salinity'], $formPrint->places['salinity'], ",", ".") }}
        </td>
    @endif
    @if(isset($formValue->values["psi_column"]))
        <td>
            -
        </td>
    @endif
    @if(isset($formValue->values["sat_column"]))
        <td>
            {{ number_format($formValue->svgs['row_' . ($i)]['sat'], $formPrint->places['sat'], ",", ".") }}
        </td>
    @endif
    @if(isset($formValue->values["conc_column"]))
        <td>
            {{ number_format($formValue->svgs['row_' . ($i)]['conc'], $formPrint->places['conc'], ",", ".") }}
        </td>
    @endif
    @if(isset($formValue->values["eh_column"]))
        <td>
            {{ number_format($formValue->svgs['row_' . ($i)]['eh'], $formPrint->places['eh'], ",", ".") }}
        </td>
    @endif
    @if(isset($formValue->values["ntu_column"]))
        <td>
            <x-jet-input readonly="{{ !$formValue ? false : true}}" id="ntu_footer_{{ isset($i) ? $i : 0 }}"
                        class="form-control block mt-1 w-full ntu_footer" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                        type="number" value="{{ isset($sample['ntu_footer']) ? number_format($sample['ntu_footer'], $formPrint->places['ntu']) : '' }}"
                        name="{{ isset($i) ? 'samples[row_' . ($i) . '][ntu_footer]' : 'samples[row_0][ntu_footer]' }}" />
        </td>
    @endif
    @if(isset($formValue->values["chlorine_column"]))
        <td>
            <x-jet-input readonly="{{ !$formValue ? false : true}}" id="chlorine_footer_{{ isset($i) ? $i : 0 }}"
                        class="form-control block mt-1 w-full chlorine_footer" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                        type="number" value="{{ isset($sample['chlorine_footer']) ? number_format($sample['chlorine_footer'], $formPrint->places['chlorine']) : '' }}"
                        name="{{ isset($i) ? 'samples[row_' . ($i) . '][chlorine_footer]' : 'samples[row_0][chlorine_footer]' }}" />
        </td>
    @endif
    @if(isset($formValue->values["residualchlorine_column"]))
        <td>
            <x-jet-input readonly="{{ !$formValue ? false : true}}" id="residualchlorine_footer_{{ isset($i) ? $i : 0 }}"
                        class="form-control block mt-1 w-full residualchlorine_footer" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                        type="number" value="{{ isset($sample['residualchlorine_footer']) ? number_format($sample['residualchlorine_footer'], $formPrint->places['residualchlorine']) : '' }}"
                        name="{{ isset($i) ? 'samples[row_' . ($i) . '][residualchlorine_footer]' : 'samples[row_0][residualchlorine_footer]' }}" />
        </td>
    @endif
    @if(isset($formValue->values["aspect_column"]))
        <td>
            <x-custom-select disabled="true" :options="$choises" value="{{ isset($value['aspect_footer']) ? $value['aspect_footer'] : null }}"
            name="{{ isset($i) ? 'samples[row_' . ($i) . '][aspect_footer]' : 'samples[row_0][aspect_footer]' }}"
            id="aspect_footer" class="mt-1" select-class="no-nice-select"/>
        </td>
    @endif
    @if(isset($formValue->values["artificialdyes_column"]))
        <td>
            <x-custom-select disabled="true" :options="$choises" value="{{ isset($value['artificialdyes_footer']) ? $value['artificialdyes_footer'] : null }}"
            name="{{ isset($i) ? 'samples[row_' . ($i) . '][artificialdyes_footer]' : 'samples[row_0][artificialdyes_footer]' }}"
            id="artificialdyes_footer" class="mt-1" select-class="no-nice-select"/>
        </td>
    @endif
    @if(isset($formValue->values["floatingmaterials_column"]))
        <td>
            <x-custom-select disabled="true" :options="$choises" value="{{ isset($sample['floatingmaterials_footer']) ? $sample['floatingmaterials_footer'] : null }}"
            name="{{ isset($i) ? 'samples[row_' . ($i) . '][floatingmaterials_footer]' : 'samples[row_0][floatingmaterials_footer]' }}"
            id="floatingmaterials_footer" class="mt-1" select-class="no-nice-select"/>
        </td>
    @endif
    @if(isset($formValue->values["objectablesolidwaste_column"]))
        <td>
            <x-custom-select disabled="true" :options="$choises" value="{{ isset($sample['objectablesolidwaste_footer']) ? $sample['objectablesolidwaste_footer'] : null }}"
            name="{{ isset($i) ? 'samples[row_' . ($i) . '][objectablesolidwaste_footer]' : 'samples[row_0][objectablesolidwaste_footer]' }}"
            id="objectablesolidwaste_footer" class="mt-1" select-class="no-nice-select"/>
        </td>
    @endif
    @if(isset($formValue->values["visibleoilsandgreases_column"]))
        <td>
            <x-custom-select disabled="true" :options="$choises" value="{{ isset($sample['visibleoilsandgreases_footer']) ? $sample['visibleoilsandgreases_footer'] : null }}"
            name="{{ isset($i) ? 'samples[row_' . ($i) . '][visibleoilsandgreases_footer]' : 'samples[row_0][visibleoilsandgreases_footer]' }}"
            id="visibleoilsandgreases_footer" class="mt-1" select-class="no-nice-select"/>
        </td>
    @endif
    @if(isset($formValue->values["voc_column"]))
        <td>
            <x-jet-input readonly="{{ !$formValue ? false : true}}" id="voc_footer_{{ isset($i) ? $i : 0 }}"
                        class="form-control block mt-1 w-full voc_footer" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                        type="number" value="{{ isset($sample['voc_footer']) ? number_format($sample['voc_footer'], $formPrint->places['voc']) : '' }}"
                        name="{{ isset($i) ? 'samples[row_' . ($i) . '][voc_footer]' : 'samples[row_0][voc_footer]' }}" />
        </td>
    @endif
</tr>
<tr>
    <td colspan="100%" class="text-center text-white" style="background-color: rgb(0, 94, 16)">Incertezas</td>
</tr>
<tr>
    @if(isset($formValue->values["temperature_column"]))
        <td>
            @php
                if(!isset($sample['temperature_uncertainty_footer'])) :
                    $sample['temperature_uncertainty_footer'] = "";
                endif;
            @endphp
            @if(isset($sample['temperature_uncertainty_footer']))
                <x-jet-input readonly="{{ !$formValue ? false : true}}" id="temperature_uncertainty_footer_{{ isset($i) ? $i : 0 }}"
                            class="form-control block mt-1 w-full temperature_uncertainty_footer" data-index="{{ isset($i) ? $i : 0 }}"
                            type="text" value="{{ $sample['temperature_uncertainty_footer'] }}"
                            name="{{ isset($i) ? 'samples[row_' . ($i) . '][temperature_uncertainty_footer]' : 'samples[row_0][temperature_uncertainty_footer]' }}" />
            @else
                <x-jet-input id="temperature_uncertainty_footer_0" class="form-control block mt-1 w-full temperature_uncertainty_footer"
                            type="text" value="" name="samples[row_0][temperature_uncertainty_footer]"
                            data-index="{{ isset($i) ? $i : 0 }}"/>
            @endif
        </td>
    @endif
    @if(isset($formValue->values["ph_column"]))
        <td>
            @php
                if(!isset($sample['ph_uncertainty_footer'])) :
                    $sample['ph_uncertainty_footer'] = "";
                endif;
            @endphp
            @if(isset($sample['ph_uncertainty_footer']))
                <x-jet-input readonly="{{ !$formValue ? false : true}}" id="ph_uncertainty_footer_{{ isset($i) ? $i : 0 }}"
                            class="form-control block mt-1 w-full ph_uncertainty_footer" data-index="{{ isset($i) ? $i : 0 }}"
                            type="text" value="{{ $sample['ph_uncertainty_footer'] }}"
                            name="{{ isset($i) ? 'samples[row_' . ($i) . '][ph_uncertainty_footer]' : 'samples[row_0][ph_uncertainty_footer]' }}" />
            @else
                <x-jet-input id="ph_uncertainty_footer_0" class="form-control block mt-1 w-full ph_uncertainty_footer"
                            type="text" value="" name="samples[row_0][ph_uncertainty_footer]"
                            data-index="{{ isset($i) ? $i : 0 }}"/>
            @endif
        </td>
    @endif
    @if(isset($formValue->values["orp_column"]))
        <td>
            @php
                if(!isset($sample['orp_uncertainty_footer'])) :
                    $sample['orp_uncertainty_footer'] = "";
                endif;
            @endphp
            @if(isset($sample['orp_uncertainty_footer']))
                <x-jet-input readonly="{{ !$formValue ? false : true}}" id="orp_uncertainty_footer_{{ isset($i) ? $i : 0 }}"
                            class="form-control block mt-1 w-full orp_uncertainty_footer" data-index="{{ isset($i) ? $i : 0 }}"
                            type="text" value="{{ $sample['orp_uncertainty_footer'] }}"
                            name="{{ isset($i) ? 'samples[row_' . ($i) . '][orp_uncertainty_footer]' : 'samples[row_0][orp_uncertainty_footer]' }}" />
            @else
                <x-jet-input id="orp_uncertainty_footer_0" class="form-control block mt-1 w-full orp_uncertainty_footer" type="text" value="" name="samples[row_0][orp_uncertainty_footer]"
                            data-index="{{ isset($i) ? $i : 0 }}"/>
            @endif
        </td>
    @endif
    @if(isset($formValue->values["conductivity_column"]))
        <td>
            @php
                if(!isset($sample['conductivity_uncertainty_footer'])) :
                    $sample['conductivity_uncertainty_footer'] = "";
                endif;
            @endphp
            @if(isset($sample['conductivity_uncertainty_footer']))
                <x-jet-input readonly="{{ !$formValue ? false : true}}" id="conductivity_uncertainty_footer_{{ isset($i) ? $i : 0 }}"
                            class="form-control block mt-1 w-full conductivity_uncertainty_footer" data-index="{{ isset($i) ? $i : 0 }}"
                            type="text" value="{{ $sample['conductivity_uncertainty_footer'] }}"
                            name="{{ isset($i) ? 'samples[row_' . ($i) . '][conductivity_uncertainty_footer]' : 'samples[row_0][conductivity_uncertainty_footer]' }}" />
            @else
                <x-jet-input id="conductivity_uncertainty_footer_0" class="form-control block mt-1 w-full conductivity_uncertainty_footer" type="text" value=""
                            name="samples[row_0][conductivity_uncertainty_footer]" data-index="{{ isset($i) ? $i : 0 }}"/>
            @endif
        </td>
    @endif
    @if(isset($formValue->values["salinity_column"]))
        <td>
            @php
                if(!isset($sample['salinity_uncertainty_footer'])) :
                    $sample['salinity_uncertainty_footer'] = "";
                endif;
            @endphp
            @if(isset($sample['salinity_uncertainty_footer']))
                <x-jet-input readonly="{{ !$formValue ? false : true}}" id="salinity_uncertainty_footer_{{ isset($i) ? $i : 0 }}"
                            class="form-control block mt-1 w-full salinity_uncertainty_footer" data-index="{{ isset($i) ? $i : 0 }}"
                            type="text" value="{{ $sample['salinity_uncertainty_footer'] }}"
                            name="{{ isset($i) ? 'samples[row_' . ($i) . '][salinity_uncertainty_footer]' : 'samples[row_0][salinity_uncertainty_footer]' }}" />
            @else
                <x-jet-input id="salinity_uncertainty_footer_0" class="form-control block mt-1 w-full salinity_uncertainty_footer"
                            type="text" value="" name="samples[row_0][salinity_uncertainty_footer]" data-index="
                {{ isset($i) ? $i : 0 }}"/>
            @endif
        </td>
    @endif
    @if(isset($formValue->values["psi_column"]))
        <td>
            -
        </td>
    @endif
    @if(isset($formValue->values["sat_column"]))
        <td>
            -
        </td>
    @endif
    @if(isset($formValue->values["conc_column"]))
        <td>
            @php
                if(!isset($sample['conc_uncertainty_footer'])) :
                    $sample['conc_uncertainty_footer'] = "-";
                endif;
            @endphp
            @if(isset($sample['conc_uncertainty_footer']))
                <x-jet-input readonly="{{ !$formValue ? false : true}}" id="conc_uncertainty_footer_{{ isset($i) ? $i : 0 }}"
                            class="form-control block mt-1 w-full conc_uncertainty_footer" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                            type="number" value="{{ $sample['conc_uncertainty_footer'] }}"
                            name="{{ isset($i) ? 'samples[row_' . ($i) . '][conc_uncertainty_footer]' : 'samples[row_0][conc_uncertainty_footer]' }}" />
            @else
                <x-jet-input id="conc_uncertainty_footer_0" class="form-control block mt-1 w-full conc_uncertainty_footer" type="number" value=""
                            name="samples[row_0][conc_uncertainty_footer]" step="any" data-index="{{ isset($i) ? $i : 0 }}"/>
            @endif
        </td>
    @endif
    @if(isset($formValue->values["eh_column"]))
        <td>
            -
        </td>
    @endif
    @if(isset($formValue->values["ntu_column"]))
        <td>
            @php
                if(!isset($sample['ntu_uncertainty_footer'])) :
                    $sample['ntu_uncertainty_footer'] = "-";
                endif;
            @endphp
            @if(isset($sample['ntu_uncertainty_footer']))
                <x-jet-input readonly="{{ !$formValue ? false : true}}" id="ntu_uncertainty_footer_{{ isset($i) ? $i : 0 }}"
                            class="form-control block mt-1 w-full ntu_uncertainty_footer" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                            type="number" value="{{ $sample['ntu_uncertainty_footer'] }}"
                            name="{{ isset($i) ? 'samples[row_' . ($i) . '][ntu_uncertainty_footer]' : 'samples[row_0][ntu_uncertainty_footer]' }}" />
            @else
                <x-jet-input id="ntu_uncertainty_footer_0" class="form-control block mt-1 w-full ntu_uncertainty_footer" type="number" value=""
                            name="samples[row_0][ntu_uncertainty_footer]" step="any" data-index="{{ isset($i) ? $i : 0 }}"/>
            @endif
        </td>
    @endif
    @if(isset($formValue->values["chlorine_column"]))
        <td>
            @php
                if(!isset($sample['chlorine_uncertainty_footer'])) :
                    $sample['chlorine_uncertainty_footer'] = "-";
                endif;
            @endphp
            @if(isset($sample['chlorine_uncertainty_footer']))
                <x-jet-input readonly="{{ !$formValue ? false : true}}" id="chlorine_uncertainty_footer_{{ isset($i) ? $i : 0 }}"
                            class="form-control block mt-1 w-full chlorine_uncertainty_footer" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                            type="number" value="{{ $sample['chlorine_uncertainty_footer'] }}"
                            name="{{ isset($i) ? 'samples[row_' . ($i) . '][chlorine_uncertainty_footer]' : 'samples[row_0][chlorine_uncertainty_footer]' }}" />
            @else
                <x-jet-input id="chlorine_uncertainty_footer_0" class="form-control block mt-1 w-full chlorine_uncertainty_footer" type="number" value=""
                            name="samples[row_0][chlorine_uncertainty_footer]" step="any" data-index="{{ isset($i) ? $i : 0 }}"/>
            @endif
        </td>
    @endif
    @if(isset($formValue->values["residualchlorine_column"]))
        <td>
            @php
                if(!isset($sample['residualchlorine_uncertainty_footer'])) :
                    $sample['residualchlorine_uncertainty_footer'] = "-";
                endif;
            @endphp
            @if(isset($sample['residualchlorine_uncertainty_footer']))
                <x-jet-input readonly="{{ !$formValue ? false : true}}" id="residualchlorine_uncertainty_footer_{{ isset($i) ? $i : 0 }}"
                            class="form-control block mt-1 w-full residualchlorine_uncertainty_footer" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                            type="number" value="{{ $sample['residualchlorine_uncertainty_footer'] }}"
                            name="{{ isset($i) ? 'samples[row_' . ($i) . '][residualchlorine_uncertainty_footer]' : 'samples[row_0][residualchlorine_uncertainty_footer]' }}" />
            @else
                <x-jet-input id="residualchlorine_uncertainty_footer_0" class="form-control block mt-1 w-full residualchlorine_uncertainty_footer" type="number" value=""
                            name="samples[row_0][residualchlorine_uncertainty_footer]" step="any" data-index="{{ isset($i) ? $i : 0 }}"/>
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
            @php
                if(!isset($sample['voc_uncertainty_footer'])) :
                    $sample['voc_uncertainty_footer'] = "-";
                endif;
            @endphp
            @if(isset($sample['voc_uncertainty_footer']))
                <x-jet-input readonly="{{ !$formValue ? false : true}}" id="voc_uncertainty_footer_{{ isset($i) ? $i : 0 }}"
                            class="form-control block mt-1 w-full voc_uncertainty_footer" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                            type="number" value="{{ $sample['voc_uncertainty_footer'] }}"
                            name="{{ isset($i) ? 'samples[row_' . ($i) . '][voc_uncertainty_footer]' : 'samples[row_0][voc_uncertainty_footer]' }}" />
            @else
                <x-jet-input id="voc_uncertainty_footer_0" class="form-control block mt-1 w-full voc_uncertainty_footer" type="number" value=""
                            name="samples[row_0][voc_uncertainty_footer]" step="any" data-index="{{ isset($i) ? $i : 0 }}"/>
            @endif
        </td>
    @endif
</tr>
