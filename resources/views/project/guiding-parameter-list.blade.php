@foreach ($guidingParameters as $key => $item)
    <tr data-id="{{ $item->id }}">
        <td class="px-6 ">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11l7-7 7 7M5 19l7-7 7 7" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7m14-8l-7 7-7-7" />
            </svg>
            {{ $item->environmental_guiding_parameter_id }}
            <input class="color" type="color" id="color_{{ $key }}" name="colors[]" value="{{ isset($colors[$key]) ? $colors[$key] : null  }}">
        </td>
    </tr>
@endforeach
