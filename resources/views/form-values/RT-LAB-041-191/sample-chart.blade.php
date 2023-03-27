<div class="block w-full" id="chart">
  <h3 class="w-full md:w-1/2 px-3 mb-6 md:mb-0">GRÁFICO pH x EH</h3>
  <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
      <canvas id="myChart" width="800" height="400" style="display: block; box-sizing: border-box; height: 400px; width: 800px; max-height: 400px"></canvas>
  </div>
  <div class="flex flex-wrap mt-2 w-full" id="sample_chart_list">
    @include('form-values.RT-LAB-020.sample-chart-list', ['count' => $count, 'type' => $type, 'samples' => $formValue->values['samples']])
  </div>
</div>
