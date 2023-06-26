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
                    @if(isset($formValue->values["temperature_column"]))<p class="font-bold">{{ __('Temperatura [ºC]') }}</p>@endif
                    @if(isset($formValue->values["ph_column"]))<p class="font-bold">{{ __('pH') }}</p>@endif
                    @if(isset($formValue->values["orp_column"]))<p class="font-bold">{{ __('ORP [mV]') }}</p>@endif
                    @if(isset($formValue->values["conductivity_column"]))<p class="font-bold">{{ __('Condutividade [µS/cm]') }}</p>@endif
                    @if(isset($formValue->values["salinity_column"]))<p class="font-bold">{{ __('Salinidade [psu]') }}</p>@endif
                    @if(isset($formValue->values["sat_column"]))<p class="font-bold">{{ __('Oxigênio Dissolvido (SAT) [%]') }}</p>@endif
                    @if(isset($formValue->values["conc_column"]))<p class="font-bold">{{ __('Oxigênio Dissolvido (CONC) [mg/l]') }}</p>@endif
                    @if(isset($formValue->values["eh_column"]))<p class="font-bold">{{ __('EH [mV]') }}</p>@endif
                    @if(isset($formValue->values["ntu_column"]))<p class="font-bold">{{ __('Turbidez [NTU]') }}</p>@endif
                    @if(isset($formValue->values["chlorine_column"]))<p class="font-bold">{{ __('Cloro Total [mg/L]') }}</p>@endif
                    @if(isset($formValue->values["residualchlorine_column"]))<p class="font-bold">{{ __('Cloro Livre Residual [mg/L]') }}</p>@endif
                    @if(isset($formValue->values["aspect_column"]))<p class="font-bold">{{ __('Aspecto') }}</p>@endif
                    @if(isset($formValue->values["artificialdyes_column"]))<p class="font-bold">{{ __('Corantes Artificiais') }}</p>@endif
                    @if(isset($formValue->values["floatingmaterials_column"]))<p class="font-bold">{{ __('Materiais Flutuantes') }}</p>@endif
                    @if(isset($formValue->values["visibleoilsandgreases_column"]))<p class="font-bold">{{ __('Resíduos Sólidos Objetáveis') }}</p>@endif
                    @if(isset($formValue->values["visibleoilsandgreases_column"]))<p class="font-bold">{{ __('Óleos e Graxas Visíveis') }}</p>@endif
                    @if(isset($formValue->values["voc_column"]))<p class="font-bold">{{ __('VOC [ppm]') }}</p>@endif
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
                                {{ Carbon\Carbon::parse($value['collect'])->format("d/m/Y H:i") }}
                            @endif
                        </p>
                        @if(isset($formValue->svgs[$key]))
                            @include('form-values.RT-LAB-020-1.sample-list-fields')
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
                            @include('form-values.RT-LAB-020-1.sample-list-fields')
                        @endif
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endforeach
