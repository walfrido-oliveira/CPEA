<div class="block w-full" id="chart" style="display: none">
  <h3 class="w-full md:w-1/2 px-3 mb-6 md:mb-0">GRÁFICO pH x EH</h3>
  <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
      <canvas id="myChart" width="800" height="400" style="display: block; box-sizing: border-box; height: 400px; width: 800px; max-height: 400px"></canvas>
  </div>
  <div class="flex flex-wrap mt-2 w-full">
    @foreach (array_chunk($formValue->values['samples'], 5, true) as $sampleArray)
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
  </div>
</div>
