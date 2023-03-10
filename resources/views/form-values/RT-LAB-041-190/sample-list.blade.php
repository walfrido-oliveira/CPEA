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
                    <p class="font-bold">{{ __('Temperatura [ºC]') }}</p>
                    <p class="font-bold">{{ __('pH') }}</p>
                    <p class="font-bold">{{ __('ORP [mV]') }}</p>
                    <p class="font-bold">{{ __('Condutividade [µS/cm]') }}</p>
                    <p class="font-bold">{{ __('Salinidade [psu]') }}</p>
                    <p class="font-bold">{{ __('Oxigênio Dissolvido (SAT) [%]') }}</p>
                    <p class="font-bold">{{ __('Oxigênio Dissolvido (CONC) [mg/l]') }}</p>
                    <p class="font-bold">{{ __('EH [mV]') }}</p>
                    <p class="font-bold">{{ __('Turbidez [NTU]') }}</p>
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
                        @if(isset($formValue->svgs[$key]))
                            @include('form-values.RT-LAB-041-190.sample-list-fields')
                        @endif
                    </div>
                @endif
                @if ($type == "duplicates" && count(array_chunk($value['results'], 3)) > 1 && count($value['results']) >=6)
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
                        @if(isset($formValue->svgs[$key]))
                            @include('form-values.RT-LAB-041-190.sample-list-fields')
                        @endif
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endforeach
