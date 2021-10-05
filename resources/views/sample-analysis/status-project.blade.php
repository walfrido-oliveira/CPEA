@switch($status)
    @case("sent")
        <span class="w-24 py-1 badge-light-primary">{{ __($status) }}</span>
        @break
    @case("pending")
        <span class="w-24 py-1 badge-light-danger">{{ __($status) }}</span>
        @break
    @case("analyzing")
        <span class="w-24 py-1 badge-light-warning">{{ __($status) }}</span>
        @break
    @case("concluded")
        <span class="w-24 py-1 badge-light-success">{{ __($status) }}</span>
        @break
    @default
@endswitch
