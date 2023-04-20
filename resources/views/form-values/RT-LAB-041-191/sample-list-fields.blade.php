<p style="background-color: #FFF; margin-left: -12px; margin-right: -12px; margin-top: 3px; margin-bottom: 4px; height: 3px">&nbsp;</p>
@if(isset($formValue->values["temperature_column"]))
    <p class="font-bold">
        {{ number_format($formValue->svgs[$key]['temperature'], $formPrint->places['temperature'], ',', '.') }}
    </p>
@endif
@if(isset($formValue->values["ph_column"]))
    <p class="font-bold">
        {{ number_format($formValue->svgs[$key]['ph'], $formPrint->places['ph'], ',', '.') }}
    </p>
@endif
@if(isset($formValue->values["orp_column"]))
    <p class="font-bold">
        {{ number_format($formValue->svgs[$key]['orp'], $formPrint->places['orp'], ',', '.') }}
    </p>
@endif
@if(isset($formValue->values["conductivity_column"]))
    <p class="font-bold">
        {{ number_format($formValue->svgs[$key]['conductivity'], $formPrint->places['conductivity'], ',', '.') }}
    </p>
@endif
@if(isset($formValue->values["salinity_column"]))
    <p class="font-bold">
        {{ number_format($formValue->svgs[$key]['salinity'], $formPrint->places['salinity'], ',', '.') }}
    </p>
@endif
@if(isset($formValue->values["sat_column"]))
    <p class="font-bold">
        {{ number_format($formValue->svgs[$key]['sat'], $formPrint->places['sat'], ',', '.') }}
    </p>
@endif
@if(isset($formValue->values["conc_column"]))
    <p class="font-bold">
        {{ number_format($formValue->svgs[$key]['conc'], $formPrint->places['conc'], ',', '.') }}
    </p>
@endif
@if(isset($formValue->values["eh_column"]))
    <p class="font-bold">
        @if(isset($samples[$key]["eh_footer"]))
            {{ number_format($samples[$key]["eh_footer"], $formPrint->places['eh'], ',', '.') }}
        @else
            {{ $formValue->svgs[$key]['eh'] > 0 ? number_format($formValue->svgs[$key]['eh'], $formPrint->places['eh'], ',', '.') : ''}}
        @endif
    </p>
@endif
@if(isset($formValue->values["ntu_column"]))
    <p class="font-bold">
        @if(isset($samples[$key]["ntu_footer"]))
            {{ number_format($samples[$key]["ntu_footer"], $formPrint->places['ntu'], ',', '.') }}
        @else
            {{ $formValue->svgs[$key]['ntu'] > 0 ? number_format($formValue->svgs[$key]['ntu'], $formPrint->places['ntu'], ',', '.') : ''}}
        @endif
    </p>
@endif
@if(isset($formValue->values["ntu_column"]))
    <p class="font-bold">
        @if(isset($samples[$key]["ntu_footer"]))
            {{ number_format($samples[$key]["ntu_footer"], $formPrint->places['ntu'], ',', '.') }}
        @else
            {{ $formValue->svgs[$key]['ntu'] > 0 ? number_format($formValue->svgs[$key]['ntu'], $formPrint->places['ntu'], ',', '.') : ''}}
        @endif
    </p>
@endif
@if(isset($formValue->values["chlorine_column"]))
    <p class="font-bold">
        @if(isset($samples[$key]["chlorine_footer"]))
            {{ number_format($samples[$key]["chlorine_footer"], $formPrint->places['chlorine'], ',', '.') }}
        @else
            {{ $formValue->svgs[$key]['chlorine'] > 0 ? number_format($formValue->svgs[$key]['chlorine'], $formPrint->places['chlorine'], ',', '.') : ''}}
        @endif
    </p>
@endif
@if(isset($formValue->values["residualchlorine_column"]))
    <p class="font-bold">
        @if(isset($samples[$key]["residualchlorine_footer"]))
            {{ number_format($samples[$key]["residualchlorine_footer"], $formPrint->places['residualchlorine'], ',', '.') }}
        @else
            {{ $formValue->svgs[$key]['residualchlorine'] > 0 ? number_format($formValue->svgs[$key]['residualchlorine'], $formPrint->places['residualchlorine'], ',', '.') : ''}}
        @endif
    </p>
@endif
