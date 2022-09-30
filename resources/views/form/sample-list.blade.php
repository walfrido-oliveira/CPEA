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
            {{ number_format($svgs['row_' . ($i)]['temperature'], 2, ",", ".") }}
        </p>
        <p class="font-bold">
            {{ number_format($svgs['row_' . ($i)]['ph'], 1, ",", ".") }}
        </p>
        <p class="font-bold">
            {{ number_format($svgs['row_' . ($i)]['orp'], 1, ",", ".") }}
        </p>
        <p class="font-bold">
            {{ number_format($svgs['row_' . ($i)]['conductivity'], 3, ",", ".") }}
        </p>
        <p class="font-bold">
            {{ number_format($svgs['row_' . ($i)]['salinity'], 3, ",", ".") }}
        </p>
        <p class="font-bold">
            {{ number_format($svgs['row_' . ($i)]['sat'], 1, ",", ".") }}
        </p>
        <p class="font-bold">
            {{ number_format($svgs['row_' . ($i)]['conc'], 3, ",", ".") }}
        </p>
        <p class="font-bold">
            {{ number_format($svgs['row_' . ($i)]['eh'], 0, ",", ".") }}
        </p>
        <p class="font-bold">
            {{ number_format($svgs['row_' . ($i)]['ntu'], 1, ",", ".") }}
        </p>
    @endif
</div>
