
@foreach (array_chunk($formValue->values['samples'], $count, true) as $sampleArray)
    <div class="flex mt-4 w-full">
        <div class="mx-1 p-3">
            <p class="font-bold">{{ __('Ponto de Coleta') }}</p>
            <p style="background-color: #FFF; margin-left: -12px; margin-right: -12px; margin-top: 3px; margin-bottom: 4px; height: 3px">&nbsp;</p>
            <p class="font-bold">{{ __('pH') }}</p>
            <p class="font-bold">{{ __('EH (mV)') }}</p>
        </div>
        @foreach ($sampleArray as $key => $value)
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
        @endforeach
    </div>
@endforeach
