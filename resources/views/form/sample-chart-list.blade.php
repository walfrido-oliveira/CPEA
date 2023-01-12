
@foreach (array_chunk($formValue->values['samples'], $count, true) as $sampleArray)
    <div class="flex mt-4 w-full">
        @php $countDefault = 0; @endphp
        @php $countDeuplicates = 0; @endphp
        @foreach ($sampleArray as $key => $value)
            @if ($type == "default") @php $countDefault++; @endphp @endif
            @if ($type == "duplicates" && count(array_chunk($value['results'], 3)) > 1) @php $countDeuplicates++; @endphp @endif
        @endforeach

        @if ($countDefault > 0 || $countDeuplicates > 0)
            <div class="mx-1 p-3">
                <p class="font-bold">{{ __('Ponto de Coleta') }}</p>
                <p style="background-color: #FFF; margin-left: -12px; margin-right: -12px; margin-top: 3px; margin-bottom: 4px; height: 3px">&nbsp;</p>
                <p class="font-bold">{{ __('pH') }}</p>
                <p class="font-bold">{{ __('EH (mV)') }}</p>
            </div>
        @endif

        @foreach ($sampleArray as $key => $value)
            @if ($type == "default")
                <div class="mx-1 p-3 bg-gray-100" style="width: 106px;">
                    <p>
                        @if(isset($value['point'])) {{ $value['point'] }} @endif
                    </p>
                    <p style="background-color: #FFF; margin-left: -12px; margin-right: -12px; margin-top: 3px; margin-bottom: 4px; height: 3px">&nbsp;</p>
                    <p class="font-bold">
                        {{ isset($svgs[$key]['ph']) ? number_format($svgs[$key]['ph'], 1, ",", ".") : '' }}
                    </p>
                    <p class="font-bold">
                        {{ isset($svgs[$key]['eh']) ? number_format($svgs[$key]['eh'], 0, ",", ".") : '' }}
                    </p>
                </div>
            @endif

            @if ($type == "duplicates" && count(array_chunk($value['results'], 3)) > 1)
                <div class="mx-1 p-3 bg-gray-100" style="width: 106px;">
                    <p>
                        @if(isset($value['point'])) {{ $value['point'] }} @endif
                    </p>
                    <p style="background-color: #FFF; margin-left: -12px; margin-right: -12px; margin-top: 3px; margin-bottom: 4px; height: 3px">&nbsp;</p>
                    <p class="font-bold">
                        {{ isset($svgs[$key]['ph']) ? number_format($svgs[$key]['ph'], 1, ",", ".") : '' }}
                    </p>
                    <p class="font-bold">
                        {{ isset($svgs[$key]['eh']) ? number_format($svgs[$key]['eh'], 0, ",", ".") : '' }}
                    </p>
                </div>
            @endif

        @endforeach
    </div>
@endforeach
