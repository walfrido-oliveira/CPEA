@if (isset(array_chunk($sample['results'], 3)[1]))
    <div class="w-full mt-2 duplicate fade">
        <h2 class="text-center text-white opacity-100 p-2 w-full" style="background-color: rgb(0, 94, 16)">DUPLICATA</h2>
        @if(count($sample['results'])>= 6)
            <table class="table table-responsive md:table w-full">
                <thead>
                    <tr class="thead-light">
                        @include('form-values.RT-LAB-020.sample-headers')
                    </tr>
                </thead>
                <tbody id="table_result">
                    @foreach (array_chunk($sample['results'], 3)[1] as $key2 => $value)
                        @include('form-values.RT-LAB-020.sample-fields', ['key' => ($key2 + $key + 1), 'value' => $value])
                    @endforeach
                </tbody>
                <tfoot id="table_result_footer">
                    <tr>
                        <td colspan="10" class="text-center text-white" style="background-color: rgb(0, 94, 16)">Resultados</td>
                    </tr>
                    <tr>
                        <td>
                            {{ number_format($formValue->duplicates_svgs['row_' . ($i)]['temperature'], $formPrint->places['temperature'], ",", ".") }}
                        </td>
                        <td>
                            {{ number_format($formValue->duplicates_svgs['row_' . ($i)]['ph'], $formPrint->places['ph'], ",", ".") }}
                        </td>
                        <td>
                            {{ number_format($formValue->duplicates_svgs['row_' . ($i)]['orp'], $formPrint->places['orp'], ",", ".") }}
                        </td>
                        <td>
                            {{ number_format($formValue->duplicates_svgs['row_' . ($i)]['conductivity'], $formPrint->places['conductivity'], ",", ".") }}
                        </td>
                        <td>
                            {{ number_format($formValue->duplicates_svgs['row_' . ($i)]['salinity'], $formPrint->places['salinity'], ",", ".") }}
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            {{ number_format($formValue->duplicates_svgs['row_' . ($i)]['sat'], $formPrint->places['sat'], ",", ".") }}
                        </td>
                        <td>
                            {{ number_format($formValue->duplicates_svgs['row_' . ($i)]['conc'], $formPrint->places['conc'], ",", ".") }}
                        </td>
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
                    </tr>
                    <tr>
                        <td colspan="100%" class="text-center text-white" style="background-color: rgb(0, 94, 16)">% DPR</td>
                    </tr>
                    <tr>
                        <td>
                            @if(isset($value['temperature']) && $formValue->svgs['row_' . ($i)]['temperature'] != 0)
                                {{ number_format($formValue->dpr['row_' . ($i)]['temperature'], 2, ",", ".") }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if(isset($value['ph']) && $formValue->svgs['row_' . ($i)]['ph'] != 0)
                                {{ number_format($formValue->dpr['row_' . ($i)]['ph'], 2, ",", ".") }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if(isset($value['orp']) && $formValue->svgs['row_' . ($i)]['orp'] != 0)
                                {{ number_format($formValue->dpr['row_' . ($i)]['orp'], 2, ",", ".") }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if(isset($value['conductivity']) && $formValue->svgs['row_' . ($i)]['conductivity'] != 0)
                                {{ number_format($formValue->dpr['row_' . ($i)]['conductivity'], 2, ",", ".") }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if(isset($value['salinity']) && $formValue->svgs['row_' . ($i)]['salinity'] != 0)
                                {{ number_format($formValue->dpr['row_' . ($i)]['salinity'], 2, ",", ".") }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if(isset($value['psi']) && $formValue->svgs['row_' . ($i)]['psi'] != 0)
                                {{ number_format($formValue->dpr['row_' . ($i)]['psi'], 2, ",", ".") }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if(isset($value['sat']) && $formValue->svgs['row_' . ($i)]['sat'] != 0)
                                {{ number_format($formValue->dpr['row_' . ($i)]['sat'], 2, ",", ".") }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if(isset($value['conc']) && $formValue->svgs['row_' . ($i)]['conc'] != 0)
                                {{ number_format($formValue->dpr['row_' . ($i)]['conc'], 2, ",", ".") }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if(isset($sample["ntu_footer_duplicate"]))
                                {{ number_format($formValue->dpr['row_' . ($i)]['eh'], 1, ",", ".") }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if(isset($formPrint->formValue->values['turbidity']) && isset($sample["ntu_footer_duplicate"]))
                                {{ number_format($formValue->dpr['row_' . ($i)]['ntu'], 1, ",", ".") }}
                            @else
                                -
                            @endif
                        </td>
                    <tr>
                </tfoot>
            </table>
        @endif
    </div>
@endif


