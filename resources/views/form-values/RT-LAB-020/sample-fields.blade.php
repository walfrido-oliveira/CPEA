<tr>
    <td>
        <x-jet-input readonly="true" id="temperature" class="form-control block mt-1 w-full" type="number"
        value="{{ isset($value['temperature']) ? number_format($value['temperature'], $formPrint->places['temperature']) : ''}}"
        name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][temperature]' : 'samples[row_0][results]['. $key . '][temperature]' }}" step="any" />
    </td>
    <td>
        <x-jet-input readonly="true" id="ph" class="form-control block mt-1 w-full" type="number"
        value="{{ isset($value['ph']) ? number_format($value['ph'], $formPrint->places['ph']) : ''}}"
        name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][ph]' : 'samples[row_0][results]['. $key . '][ph]' }}" step="any" />
    </td>
    <td>
        <x-jet-input readonly="true" id="orp" class="form-control block mt-1 w-full" type="number"
        value="{{ isset($value['orp']) ? number_format($value['orp'], $formPrint->places['orp']) : ''}}"
        name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][orp]' : 'samples[row_0][results]['. $key . '][orp]' }}" step="any" />
    </td>
    <td>
        <x-jet-input readonly="true" id="conductivity" class="form-control block mt-1 w-full" type="number"
        value="{{ isset($value['conductivity']) ? number_format($value['conductivity'], $formPrint->places['conductivity'], '.', '') : ''}}"
        name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][conductivity]' : 'samples[row_0][results]['. $key . '][conductivity]' }}" step="any" />
    </td>
    <td>
        <x-jet-input readonly="true" id="salinity" class="form-control block mt-1 w-full" type="number"
        value="{{ isset($value['salinity']) ? number_format($value['salinity'], $formPrint->places['salinity']) : ''}}"
        name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][salinity]' : 'samples[row_0][results]['. $key . '][salinity]' }}" step="any" />
    </td>
    <td>
        <x-jet-input readonly="true" id="psi" class="form-control block mt-1 w-full" type="number"
        value="{{ isset($value['psi']) ? number_format($value['psi'], $formPrint->places['psi']) : ''}}"
        name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][psi]' : 'samples[row_0][results]['. $key . '][psi]' }}" step="any" />
    </td>
    <td>
        <x-jet-input readonly="true" id="sat" class="form-control block mt-1 w-full" type="number"
        value="{{ isset($value['sat']) ? number_format($value['sat'], $formPrint->places['sat']) : ''}}"
        name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][sat]' : 'samples[row_0][results]['. $key . '][sat]' }}" step="any" />
    </td>
    <td>
        <x-jet-input readonly="true" id="conc" class="form-control block mt-1 w-full" type="number"
        value="{{ isset($value['conc']) ? number_format($value['conc'], $formPrint->places['conc']) : ''}}"
        name="{{ isset($i) ? 'samples[row_' . ($i) . '][results][' . $key . '][conc]' : 'samples[row_0][results]['. $key . '][conc]' }}" step="any" />
    </td>
    <td>-</td>
    <td>-</td>
<tr>
