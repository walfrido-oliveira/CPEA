
<tr>
    <td colspan="10" class="text-center text-white" style="background-color: rgb(0, 94, 16)">Resultados</td>
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
            @php
                if(!isset($sample['eh_footer'])) :
                    $sample['eh_footer'] = $formValue->svgs['row_' . ($i)]['eh'];
                endif;
            @endphp
            @if(isset($sample['eh_footer']))
                <x-jet-input readonly="{{ !$formValue ? false : true}}" id="eh_footer_{{ isset($i) ? $i : 0 }}"
                            class="form-control block mt-1 w-full eh_footer" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                            type="number" value="{{ number_format($sample['eh_footer'], $formPrint->places['eh']) }}"
                            name="{{ isset($i) ? 'samples[row_' . ($i) . '][eh_footer]' : 'samples[row_0][eh_footer]' }}" />
            @else
                <x-jet-input id="eh_footer_0" class="form-control block mt-1 w-full eh_footer" type="number" value=""
                            name="samples[row_0][eh_footer]" step="any" data-index="{{ isset($i) ? $i : 0 }}"/>
            @endif
        </td>
    @endif
    @if(isset($formValue->values["ntu_column"]))
        <td>
            @php
                if(!isset($sample['ntu_footer'])) :
                    $sample['ntu_footer'] = $formValue->svgs['row_' . ($i)]['ntu'];
                endif;
            @endphp
            @if(isset($sample['ntu_footer']))
                <x-jet-input readonly="{{ !$formValue ? false : true}}" id="ntu_footer_{{ isset($i) ? $i : 0 }}"
                            class="form-control block mt-1 w-full ntu_footer" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                            type="number" value="{{ $sample['ntu_footer'] != 0 ? number_format($sample['ntu_footer'], $formPrint->places['ntu']) : '' }}"
                            name="{{ isset($i) ? 'samples[row_' . ($i) . '][ntu_footer]' : 'samples[row_0][ntu_footer]' }}" />
            @else
                <x-jet-input id="ntu_footer_0" class="form-control block mt-1 w-full ntu_footer" type="number" value=""
                            name="samples[row_0][ntu_footer]" step="any" data-index="{{ isset($i) ? $i : 0 }}"/>
            @endif
        </td>
    @endif
    @if(isset($formValue->values["chlorine_column"]))
        <td>
            @php
                if(!isset($sample['chlorine_footer'])) :
                    $sample['chlorine_footer'] = $formValue->svgs['row_' . ($i)]['chlorine'];
                endif;
            @endphp
            @if(isset($sample['chlorine_footer']))
                <x-jet-input readonly="{{ !$formValue ? false : true}}" id="chlorine_footer_{{ isset($i) ? $i : 0 }}"
                            class="form-control block mt-1 w-full chlorine_footer" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                            type="number" value="{{ $sample['chlorine_footer'] != 0 ? number_format($sample['chlorine_footer'], $formPrint->places['chlorine']) : '' }}"
                            name="{{ isset($i) ? 'samples[row_' . ($i) . '][chlorine_footer]' : 'samples[row_0][chlorine_footer]' }}" />
            @else
                <x-jet-input id="chlorine_footer_0" class="form-control block mt-1 w-full chlorine_footer" type="number" value=""
                            name="samples[row_0][chlorine_footer]" step="any" data-index="{{ isset($i) ? $i : 0 }}"/>
            @endif
        </td>
    @endif
    @if(isset($formValue->values["residualchlorine_column"]))
        <td>
            @php
                if(!isset($sample['residualchlorine_footer'])) :
                    $sample['residualchlorine_footer'] = $formValue->svgs['row_' . ($i)]['residualchlorine'];
                endif;
            @endphp
            @if(isset($sample['residualchlorine_footer']))
                <x-jet-input readonly="{{ !$formValue ? false : true}}" id="residualchlorine_footer_{{ isset($i) ? $i : 0 }}"
                            class="form-control block mt-1 w-full residualchlorine_footer" data-index="{{ isset($i) ? $i : 0 }}" step="any"
                            type="number" value="{{ $sample['residualchlorine_footer'] != 0 ? number_format($sample['residualchlorine_footer'], $formPrint->places['residualchlorine']) : '' }}"
                            name="{{ isset($i) ? 'samples[row_' . ($i) . '][residualchlorine_footer]' : 'samples[row_0][residualchlorine_footer]' }}" />
            @else
                <x-jet-input id="residualchlorine_footer_0" class="form-control block mt-1 w-full residualchlorine_footer" type="number" value=""
                            name="samples[row_0][residualchlorine_footer]" step="any" data-index="{{ isset($i) ? $i : 0 }}"/>
            @endif
        </td>
    @endif
</tr>
<tr>
    <td colspan="10" class="text-center text-white" style="background-color: rgb(0, 94, 16)">Incertezas</td>
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
</tr>
