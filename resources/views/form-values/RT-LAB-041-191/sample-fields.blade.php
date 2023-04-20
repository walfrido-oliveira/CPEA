<tr>
    @if(isset($formValue->values["temperature_column"]))
        <td>
            <x-jet-input readonly="true" id="temperature" class="form-control block mt-1 w-full" type="number"
            value="{{ isset($value['temperature']) ? number_format($value['temperature'], $formPrint->places['temperature']) : ''}}"
            name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][temperature]' : 'samples[row_0][results]['. $key . '][temperature]' }}" step="any" />
        </td>
    @endif
    @if(isset($formValue->values["ph_column"]))
        <td>
            <x-jet-input readonly="true" id="ph" class="form-control block mt-1 w-full" type="number"
            value="{{ isset($value['ph']) ? number_format($value['ph'], $formPrint->places['ph']) : ''}}"
            name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][ph]' : 'samples[row_0][results]['. $key . '][ph]' }}" step="any" />
        </td>
    @endif
    @if(isset($formValue->values["orp_column"]))
        <td>
            <x-jet-input readonly="true" id="orp" class="form-control block mt-1 w-full" type="number"
            value="{{ isset($value['orp']) ? number_format($value['orp'], $formPrint->places['orp']) : ''}}"
            name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][orp]' : 'samples[row_0][results]['. $key . '][orp]' }}" step="any" />
        </td>
    @endif
    @if(isset($formValue->values["conductivity_column"]))
        <td>
            <x-jet-input readonly="true" id="conductivity" class="form-control block mt-1 w-full" type="number"
            value="{{ isset($value['conductivity']) ? number_format($value['conductivity'], $formPrint->places['conductivity'], '.', '') : ''}}"
            name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][conductivity]' : 'samples[row_0][results]['. $key . '][conductivity]' }}" step="any" />
        </td>
    @endif
    @if(isset($formValue->values["salinity_column"]))
        <td>
            <x-jet-input readonly="true" id="salinity" class="form-control block mt-1 w-full" type="number"
            value="{{ isset($value['salinity']) ? number_format($value['salinity'], $formPrint->places['salinity']) : ''}}"
            name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][salinity]' : 'samples[row_0][results]['. $key . '][salinity]' }}" step="any" />
        </td>
    @endif
    @if(isset($formValue->values["psi_column"]))
        <td>
            <x-jet-input readonly="true" id="psi" class="form-control block mt-1 w-full" type="number"
            value="{{ isset($value['psi']) ? number_format($value['psi'], $formPrint->places['psi']) : ''}}"
            name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][psi]' : 'samples[row_0][results]['. $key . '][psi]' }}" step="any" />
        </td>
    @endif
    @if(isset($formValue->values["sat_column"]))
        <td>
            <x-jet-input readonly="true" id="sat" class="form-control block mt-1 w-full" type="number"
            value="{{ isset($value['sat']) ? number_format($value['sat'], $formPrint->places['sat']) : ''}}"
            name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][sat]' : 'samples[row_0][results]['. $key . '][sat]' }}" step="any" />
        </td>
    @endif
    @if(isset($formValue->values["conc_column"]))
        <td>
            <x-jet-input readonly="true" id="conc" class="form-control block mt-1 w-full" type="number"
            value="{{ isset($value['conc']) ? number_format($value['conc'], $formPrint->places['conc']) : ''}}"
            name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][conc]' : 'samples[row_0][results]['. $key . '][conc]' }}" step="any" />
        </td>
    @endif
    @if(isset($formValue->values["eh_column"]))
        <td>-</td>
    @endif
    @if(isset($formValue->values["ntu_column"]))
        <td>-</td>
    @endif
    @if(isset($formValue->values["chlorine_column"]))
        <td>
            <x-jet-input readonly="true" id="chlorine" class="form-control block mt-1 w-full" type="number"
            value="{{ isset($value['chlorine']) ? number_format($value['chlorine'], $formPrint->places['chlorine']) : ''}}"
            name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][chlorine]' : 'samples[row_0][results]['. $key . '][chlorine]' }}" step="any" />
        </td>
    @endif
    @if(isset($formValue->values["residualchlorine_column"]))
        <td>
            <x-jet-input readonly="true" id="residualchlorine" class="form-control block mt-1 w-full" type="number"
            value="{{ isset($value['residualchlorine']) ? number_format($value['residualchlorine'], $formPrint->places['residualchlorine']) : ''}}"
            name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][residualchlorine]' : 'samples[row_0][results]['. $key . '][residualchlorine]' }}" step="any" />
        </td>
    @endif
    @if(isset($formValue->values["aspect_column"]))
        <td>
            <x-custom-select disabled="true" :options="$choises" value="{{ isset($value['aspect']) ? $value['aspect'] : null }}"
            name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][aspect]' : 'samples[row_0][results]['. $key . '][aspect]' }}"
            id="aspect" class="mt-1" select-class="no-nice-select"/>
        </td>
    @endif
    @if(isset($formValue->values["artificialdyes_column"]))
    <td>
        <x-custom-select disabled="true" :options="$choises" value="{{ isset($value['artificialdyes']) ? $value['artificialdyes'] : null }}"
        name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][artificialdyes]' : 'samples[row_0][results]['. $key . '][artificialdyes]' }}"
        id="artificialdyes" class="mt-1" select-class="no-nice-select"/>
    </td>
    @endif
    @if(isset($formValue->values["floatingmaterials_column"]))
        <td>
            <x-custom-select disabled="true" :options="$choises" value="{{ isset($value['floatingmaterials']) ? $value['floatingmaterials'] : null }}"
            name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][floatingmaterials]' : 'samples[row_0][results]['. $key . '][floatingmaterials]' }}"
            id="floatingmaterials" class="mt-1" select-class="no-nice-select"/>
        </td>
    @endif
    @if(isset($formValue->values["objectablesolidwaste_column"]))
        <td>
            <x-custom-select disabled="true" :options="$choises" value="{{ isset($value['objectablesolidwaste']) ? $value['objectablesolidwaste'] : null }}"
            name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][objectablesolidwaste]' : 'samples[row_0][results]['. $key . '][objectablesolidwaste]' }}"
            id="objectablesolidwaste" class="mt-1" select-class="no-nice-select"/>
        </td>
    @endif
    @if(isset($formValue->values["visibleoilsandgreases_column"]))
        <td>
            <x-custom-select disabled="true" :options="$choises" value="{{ isset($value['visibleoilsandgreases']) ? $value['visibleoilsandgreases'] : null }}"
            name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][visibleoilsandgreases]' : 'samples[row_0][results]['. $key . '][visibleoilsandgreases]' }}"
            id="visibleoilsandgreases" class="mt-1" select-class="no-nice-select"/>
        </td>
    @endif
    @if(isset($formValue->values["voc_column"]))
        <td>
            <x-jet-input readonly="true" id="voc" class="form-control block mt-1 w-full" type="number"
            value="{{ isset($value['voc']) ? number_format($value['voc'], $formPrint->places['voc']) : ''}}"
            name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][voc]' : 'samples[row_0][results]['. $key . '][voc]' }}" step="any" />
        </td>
    @endif
    <td style="width: 64px;">
        <button type="button" class="btn-transition-primary remove-result px-1" title="Remover Resultado" style="" data-index="row_{{ isset($i) ? $i : 0 }}" data-row="{{ $key }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-wiph="1.5" stroke="currentColor" class="h-8 w-8 text-red-900">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </button>
    </td>
<tr>
