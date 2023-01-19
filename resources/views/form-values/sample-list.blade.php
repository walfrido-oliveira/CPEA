@foreach (array_chunk($samples, $count, true) as $sampleArray)

    @php $countDefault = 0; @endphp
    @php $countDeuplicates = 0; @endphp
    @foreach ($sampleArray as $key => $value)
        @if ($type == "default") @php $countDefault++; @endphp @endif
        @if ($type == "duplicates" && count(array_chunk($value['results'], 3)) > 1) @php $countDeuplicates++; @endphp @endif
    @endforeach

    <div class="flex flex-wrap mt-2 w-full mode-list">
        <div class="flex flex-wrap mt-2 w-full">
            @if ($countDefault > 0 || $countDeuplicates > 0)
                <div class="mx-1 p-3">
                    <p class="font-bold">{{ __('Ponto de Coleta') }}</p>
                    <p class="font-bold">{{ __('Condições ambientais nas últimas 24 hs') }}</p>
                    <p class="font-bold">{{ __('DT/HR da Coleta') }}</p>
                    <p style="background-color: #FFF; margin-left: -12px; margin-right: -12px; margin-top: 3px; margin-bottom: 4px; height: 3px">&nbsp;</p>
                    <p class="font-bold">{{ __('Temperatura ºC') }}</p>
                    <p class="font-bold">{{ __('pH') }}</p>
                    <p class="font-bold">{{ __('ORP (mV)') }}</p>
                    <p class="font-bold">{{ __('Condutividade µS/cm') }}</p>
                    <p class="font-bold">{{ __('Salinidade (psu)') }}</p>
                    <p class="font-bold">{{ __('Oxigênio Dissolvido (sat) (%)') }}</p>
                    <p class="font-bold">{{ __('Oxigênio Dissolvido (conc) (mg/L)') }}</p>
                    <p class="font-bold">{{ __('EH (mV)') }}</p>
                    <p class="font-bold">{{ __('Turbidez (NTU)') }}</p>
                </div>
            @endif
            @foreach ($sampleArray as $key => $value)
                @if ($type == "default")
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
                            {{ number_format($formValue->svgs[$key]['temperature'], 2, ",", ".") }}
                        </p>
                        <p class="font-bold">
                            {{ number_format($formValue->svgs[$key]['ph'], 1, ",", ".") }}
                        </p>
                        <p class="font-bold">
                            {{ number_format($formValue->svgs[$key]['orp'], 1, ",", ".") }}
                        </p>
                        <p class="font-bold">
                            {{ number_format($formValue->svgs[$key]['conductivity'], 3, ",", ".") }}
                        </p>
                        <p class="font-bold">
                            {{ number_format($formValue->svgs[$key]['salinity'], 3, ",", ".") }}
                        </p>
                        <p class="font-bold">
                            {{ number_format($formValue->svgs[$key]['sat'], 1, ",", ".") }}
                        </p>
                        <p class="font-bold">
                            {{ number_format($formValue->svgs[$key]['conc'], 3, ",", ".") }}
                        </p>
                        <p class="font-bold">
                            {{ number_format($formValue->svgs[$key]['eh'], 0, ",", ".") }}
                        </p>
                        <p class="font-bold">
                            {{ number_format($formValue->svgs[$key]['ntu'], 1, ",", ".") }}
                        </p>
                    </div>
                @endif
                @if ($type == "duplicates" && count(array_chunk($value['results'], 3)) > 1)
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
                            {{ number_format($formValue->svgs[$key]['temperature'], 2, ",", ".") }}
                        </p>
                        <p class="font-bold">
                            {{ number_format($formValue->svgs[$key]['ph'], 1, ",", ".") }}
                        </p>
                        <p class="font-bold">
                            {{ number_format($formValue->svgs[$key]['orp'], 1, ",", ".") }}
                        </p>
                        <p class="font-bold">
                            {{ number_format($formValue->svgs[$key]['conductivity'], 3, ",", ".") }}
                        </p>
                        <p class="font-bold">
                            {{ number_format($formValue->svgs[$key]['salinity'], 3, ",", ".") }}
                        </p>
                        <p class="font-bold">
                            {{ number_format($formValue->svgs[$key]['sat'], 1, ",", ".") }}
                        </p>
                        <p class="font-bold">
                            {{ number_format($formValue->svgs[$key]['conc'], 3, ",", ".") }}
                        </p>
                        <p class="font-bold">
                            {{ number_format($formValue->svgs[$key]['eh'], 0, ",", ".") }}
                        </p>
                        <p class="font-bold">
                            {{ number_format($formValue->svgs[$key]['ntu'], 1, ",", ".") }}
                        </p>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endforeach
