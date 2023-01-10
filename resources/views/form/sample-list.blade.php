@foreach (array_chunk($formValue->values['samples'], $count, true) as $sampleArray)
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
            @foreach ($sampleArray as $key => $value)
                <div class="mx-1 p-3 bg-gray-100">
                    <p>
                        @if(isset($value['point']))
                            {{ $value['point'] }}
                        @endif
                    </p>
                    <p>
                        @if(isset($value['environment']))
                            {{ $value['environment'] }}
                        @endif
                    </p>
                    <p>
                        @if(isset($value['collect']))
                            {{ Carbon\Carbon::parse($value['collect'])->format("d/m/Y h:i") }}
                        @endif
                    </p>
                    <p style="background-color: #FFF; margin-left: -12px; margin-right: -12px; margin-top: 3px; margin-bottom: 4px; height: 3px">&nbsp;</p>
                    <p class="font-bold">
                        {{ number_format($svgs[$key]['temperature'], 2, ",", ".") }}
                    </p>
                    <p class="font-bold">
                        {{ number_format($svgs[$key]['ph'], 1, ",", ".") }}
                    </p>
                    <p class="font-bold">
                        {{ number_format($svgs[$key]['orp'], 1, ",", ".") }}
                    </p>
                    <p class="font-bold">
                        {{ number_format($svgs[$key]['conductivity'], 3, ",", ".") }}
                    </p>
                    <p class="font-bold">
                        {{ number_format($svgs[$key]['salinity'], 3, ",", ".") }}
                    </p>
                    <p class="font-bold">
                        {{ number_format($svgs[$key]['sat'], 1, ",", ".") }}
                    </p>
                    <p class="font-bold">
                        {{ number_format($svgs[$key]['conc'], 3, ",", ".") }}
                    </p>
                    <p class="font-bold">
                        {{ number_format($svgs[$key]['eh'], 0, ",", ".") }}
                    </p>
                    <p class="font-bold">
                        {{ number_format($svgs[$key]['ntu'], 1, ",", ".") }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
@endforeach
