<div class="mx-1 p-3 bg-gray-100">
    @if (isset($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results'] ))
        <p>
            @if(isset($sample['point']))
                {{ $sample['point'] }}
            @endif
        </p>
        <p>
            @if(isset($sample['environment']))
                {{ $sample['environment'] }}
            @endif
        </p>
        <p>
            @if(isset($sample['collect']))
                {{ Carbon\Carbon::parse($sample['collect'])->format("d/m/Y h:i") }}
            @endif
        </p>
        <p style="background-color: #FFF; margin-left: -12px; margin-right: -12px; margin-top: 12px; margin-bottom: 12px;">&nbsp;</p>
        <p class="font-bold">
            @php
                $sum = 0;
                $size = count(array_chunk($sample['results'], 3)[0]);

                foreach (array_chunk($sample['results'], 3)[0] as $value) {
                    $sum += $value['temperature'];
                }
                $svg = $sum / $size;
            @endphp
            {{ number_format($svg, 3, ",", ".") }}
        </p>
        <p class="font-bold">
            @php
                $sum = 0;
                foreach (array_chunk($sample['results'], 3)[0] as $value) {
                    $sum += $value['ph'];
                }
                $svg = $sum / $size;
            @endphp
            {{ number_format($svg, 1, ",", ".") }}
        </p>
        <p class="font-bold">
            @php
                $sum = 0;
                foreach (array_chunk($sample['results'], 3)[0] as $value) {
                    $sum += $value['orp'];
                }
                $svgORP = $sum / $size;
            @endphp
            {{ number_format($svgORP, 1, ",", ".") }}
        </p>
        <p class="font-bold">
            @php
                $sum = 0;
                foreach (array_chunk($sample['results'], 3)[0] as $value) {
                    $sum += $value['conductivity'];
                }
                $svg = $sum / $size;
            @endphp
            {{ number_format($svg, 3, ",", ".") }}
        </p>
        <p class="font-bold">
            @php
                $sum = 0;
                foreach (array_chunk($sample['results'], 3)[0] as $value) {
                    $sum += $value['salinity'];
                }
                $svg = $sum / $size;
            @endphp
            {{ number_format($svg, 3, ",", ".") }}
        </p>
        <p class="font-bold">-</p>
        <p class="font-bold">
            @php
                $sum = 0;
                foreach (array_chunk($sample['results'], 3)[0] as $value) {
                    $sum += $value['sat'];
                }
                $svg = $sum / $size;
            @endphp
            {{ number_format($svg, 1, ",", ".") }}
        </p>
        <p class="font-bold">
            @php
                $sum = 0;
                foreach (array_chunk($sample['results'], 3)[0] as $value) {
                    $sum += $value['conc'];
                }
                $svg = $sum / $size;
            @endphp
            {{ number_format($svg, 3, ",", ".") }}
        </p>
        <p class="font-bold">
            @php
                $svg = $svgORP + 199;
            @endphp
            {{ number_format($svg, 0, ",", ".") }}
        </p>
        <p class="font-bold">
            @php
                $sum = 0;
                foreach (array_chunk($sample['results'], 3)[0] as $value) {
                    if(isset($value['ntu'])) $sum += $value['ntu'];
                }
                $svg = $sum / $size;
            @endphp
            {{ number_format($svg, 1, ",", ".") }}
        </p>
    @endif
</div>
