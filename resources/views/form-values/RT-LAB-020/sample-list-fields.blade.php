<p
    style="background-color: #FFF; margin-left: -12px; margin-right: -12px; margin-top: 3px; margin-bottom: 4px; height: 3px">
    &nbsp;</p>
<p class="font-bold">
    {{ number_format($formValue->svgs[$key]['temperature'], $formPrint->places['temperature'], ',', '.') }}
</p>
<p class="font-bold">
    {{ number_format($formValue->svgs[$key]['ph'], $formPrint->places['ph'], ',', '.') }}
</p>
<p class="font-bold">
    {{ number_format($formValue->svgs[$key]['orp'], $formPrint->places['orp'], ',', '.') }}
</p>
<p class="font-bold">
    {{ number_format($formValue->svgs[$key]['conductivity'], $formPrint->places['conductivity'], ',', '.') }}
</p>
<p class="font-bold">
    {{ number_format($formValue->svgs[$key]['salinity'], $formPrint->places['salinity'], ',', '.') }}
</p>
<p class="font-bold">
    {{ number_format($formValue->svgs[$key]['sat'], $formPrint->places['sat'], ',', '.') }}
</p>
<p class="font-bold">
    {{ number_format($formValue->svgs[$key]['conc'], $formPrint->places['conc'], ',', '.') }}
</p>
<p class="font-bold">
    @if(isset($samples[$key]["eh_footer"]))
        {{ number_format($samples[$key]["eh_footer"], $formPrint->places['eh'], ',', '.') }}
    @else
        {{ $formValue->svgs[$key]['eh'] > 0 ? number_format($formValue->svgs[$key]['eh'], $formPrint->places['eh'], ',', '.') : ''}}
    @endif
</p>
<p class="font-bold">
    @if(isset($samples[$key]["ntu_footer"]))
        {{ number_format($samples[$key]["ntu_footer"], $formPrint->places['ntu'], ',', '.') }}
    @else
        {{ $formValue->svgs[$key]['ntu'] > 0 ? number_format($formValue->svgs[$key]['ntu'], $formPrint->places['ntu'], ',', '.') : ''}}
    @endif
</p>
