<div class="inline-block relative w-full {{ $attributes['class'] }}">
    <select class="{{ $attributes['select-class'] }} block w-full @if(!isset($attributes['default'])) custom-select @endif focus:outline-none focus:shadow-outline @if(!isset($attributes['no-filter'])) filter-field @endif" {{ $attributes }}>
        <option value="">{{ $attributes['placeholder'] }}</option>
        @php
            $index = 0;
        @endphp
        @foreach ($options as $key => $item)
            <option  @if(isset($ids[$index])) data-id="{{ $ids[$index] }}" @endif @if($key == $value) {{ 'selected' }} @endif value="{{ $key }}">{{ __($item) }}</option>
            @php
                $index++;
            @endphp
        @endforeach
    </select>
</div>
