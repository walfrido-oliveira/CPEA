<div class="mx-1 p-3 bg-gray-100">
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
            foreach ($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results'] as $value) {
                $sum += $value['temperature'];
            }
            $size = count($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results']);
            $svg = $sum / $size;
        @endphp
        {{ number_format($svg, 2, ",", ".") }}
    </p>
    <p class="font-bold">
        @php
            $sum = 0;
            foreach ($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results'] as $value) {
                $sum += $value['ph'];
            }
            $size = count($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results']);
            $svg = $sum / $size;
        @endphp
        {{ number_format($svg, 2, ",", ".") }}
    </p>
    <p class="font-bold">
        @php
            $sum = 0;
            foreach ($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results'] as $value) {
                $sum += $value['orp'];
            }
            $size = count($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results']);
            $svgORP = $sum / $size;
        @endphp
        {{ number_format($svgORP, 1, ",", ".") }}
    </p>
    <p class="font-bold">
        @php
            $sum = 0;
            foreach ($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results'] as $value) {
                $sum += $value['conductivity'];
            }
            $size = count($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results']);
            $svg = $sum / $size;
        @endphp
        {{ number_format($svg, 3, ",", ".") }}
    </p>
    <p class="font-bold">
        @php
            $sum = 0;
            foreach ($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results'] as $value) {
                $sum += $value['salinity'];
            }
            $size = count($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results']);
            $svg = $sum / $size;
        @endphp
        {{ number_format($svg, 3, ",", ".") }}
    </p>
    <p class="font-bold">-</p>
    <p class="font-bold">
        @php
            $sum = 0;
            foreach ($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results'] as $value) {
                $sum += $value['sat'];
            }
            $size = count($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results']);
            $svg = $sum / $size;
        @endphp
        {{ number_format($svg, 1, ",", ".") }}
    </p>
    <p class="font-bold">
        @php
            $sum = 0;
            foreach ($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results'] as $value) {
                $sum += $value['conc'];
            }
            $size = count($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results']);
            $svg = $sum / $size;
        @endphp
        {{ number_format($svg, 3, ",", ".") }}
    </p>
    <p class="font-bold">
        @php
            $svg = $svgORP + 199;
        @endphp
        {{ number_format($svg, 1, ",", ".") }}
    </p>
    <p class="font-bold">
        @php
            $sum = 0;
            foreach ($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results'] as $value) {
                if(isset($value['ntu'])) $sum += $value['ntu'];
            }
            $size = count($formValue->values['samples']['row_' . (isset($i) ? $i : 0)]['results']);
            $svg = $sum / $size;
        @endphp
        {{ number_format($svg, 1, ",", ".") }}
    </p>
</div>
