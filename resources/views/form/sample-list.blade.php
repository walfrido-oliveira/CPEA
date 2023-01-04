@foreach (array_chunk($formValue->values['samples'], $count) as $sampleArray)
    <div class="flex flex-wrap mt-2 w-full mode-list default-table">
        <div class="flex flex-wrap mt-2 w-full">
            <div class="mx-1 p-3">
                <p class="font-bold">{{ __('Ponto de Coleta') }}</p>
                <p class="font-bold">{{ __('Condições ambientais nas últimas 24 hs') }}</p>
                <p class="font-bold">{{ __('DT/HR da Coleta') }}</p>
                <p style="background-color: #FFF; margin-left: -12px; margin-right: -12px; margin-top: 3px; margin-bottom: 4px; height: 3px">&nbsp;</p>
                <p class="font-bold">{{ __('Temperatura ºC') }}</p>
                <p class="font-bold">{{ __('pH') }}</p>
                <p class="font-bold">{{ __('ORP (mV)') }}</p>
                <p class="font-bold">{{ __('Condutividade') }}</p>
                <p class="font-bold">{{ __('Salinidade') }}</p>
                <p class="font-bold">{{ __('Oxigênio Dissolvido (sat) (%)') }}</p>
                <p class="font-bold">{{ __('Oxigênio Dissolvido (conc) (mg/L)') }}</p>
                <p class="font-bold">{{ __('EH (mV)') }}</p>
                <p class="font-bold">{{ __('Turbidez (NTU)') }}</p>
            </div>
            @for ($i = 0; $i < count($sampleArray); $i++)
                @if (isset($sampleArray[$i]['results']))
                    <div class="mx-1 p-3 bg-gray-100">
                        @if (isset($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results'] ))
                            <p>
                                @if(isset($formValue->values['samples']["row_$i"]['point']))
                                    {{ $formValue->values['samples']["row_$i"]['point'] }}
                                @endif
                            </p>
                            <p>
                                @if(isset($formValue->values['samples']["row_$i"]['environment']))
                                    {{ $formValue->values['samples']["row_$i"]['environment'] }}
                                @endif
                            </p>
                            <p>
                                @if(isset($formValue->values['samples']["row_$i"]['collect']))
                                    {{ Carbon\Carbon::parse($formValue->values['samples']["row_$i"]['collect'])->format("d/m/Y h:i") }}
                                @endif
                            </p>
                            <p style="background-color: #FFF; margin-left: -12px; margin-right: -12px; margin-top: 3px; margin-bottom: 4px; height: 3px">&nbsp;</p>
                            <p class="font-bold">
                                {{ number_format($svgs['row_' . ($i)]['temperature'], 2, ",", ".") }}
                            </p>
                            <p class="font-bold">
                                {{ number_format($svgs['row_' . ($i)]['ph'], 1, ",", ".") }}
                            </p>
                            <p class="font-bold">
                                {{ number_format($svgs['row_' . ($i)]['orp'], 1, ",", ".") }}
                            </p>
                            <p class="font-bold">
                                {{ number_format($svgs['row_' . ($i)]['conductivity'], 3, ",", ".") }}
                            </p>
                            <p class="font-bold">
                                {{ number_format($svgs['row_' . ($i)]['salinity'], 3, ",", ".") }}
                            </p>
                            <p class="font-bold">
                                {{ number_format($svgs['row_' . ($i)]['sat'], 1, ",", ".") }}
                            </p>
                            <p class="font-bold">
                                {{ number_format($svgs['row_' . ($i)]['conc'], 3, ",", ".") }}
                            </p>
                            <p class="font-bold">
                                {{ number_format($svgs['row_' . ($i)]['eh'], 0, ",", ".") }}
                            </p>
                            <p class="font-bold">
                                {{ number_format($svgs['row_' . ($i)]['ntu'], 1, ",", ".") }}
                            </p>
                        @endif
                    </div>
                @endif
            @endfor
        </div>
    </div>
@endforeach
