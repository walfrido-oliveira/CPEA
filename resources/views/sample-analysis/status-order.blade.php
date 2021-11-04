<div class="block py-2 px-2" x-data="{ open: false }">
    <div class="flex sm:items-center justify-start w-full">
        <x-jet-dropdown align="left" width="48" contentClasses="p-0">
            <x-slot name="trigger">
                <button type="button">
                    @switch($analysisOrder->status)
                        @case("sent")
                            <span class="w-24 py-1 badge-light-primary">{{ __($analysisOrder->status) }}</span>
                            @break
                        @case("canceled")
                            <span class="w-24 py-1 badge-light-danger">{{ __($analysisOrder->status) }}</span>
                            @break
                        @case("analyzing")
                            <span class="w-24 py-1 badge-light-warning">{{ __($analysisOrder->status) }}</span>
                            @break
                        @case("concluded")
                            <span class="w-24 py-1 badge-light-success">{{ __($analysisOrder->status) }}</span>
                            @break
                        @default
                    @endswitch
                </button>
            </x-slot>

            <x-slot name="content">
                <button class='status-analysis-order-edit block px-4 py-2 text-sm leading-5
                             text-gray-700 hover:bg-gray-100 bg-yellow-100
                              focus:outline-none focus:bg-gray-100
                              transition w-full'
                              data-status="{{ 'analyzing' }}"
                              data-id="{{ $analysisOrder->id }}">
                    {{ __('analyzing') }}
                </button>

                <div class="banalysisOrder-t banalysisOrder-gray-100"></div>

                <button class='status-analysis-order-edit block px-4 py-2 text-sm leading-5
                             text-gray-700 hover:bg-gray-100 bg-green-100
                              focus:outline-none focus:bg-gray-100
                              transition w-full'
                              data-status="{{ 'concluded' }}"
                              data-id="{{ $analysisOrder->id }}">
                    {{ __('concluded') }}
                </button>

                <div class="banalysisOrder-t banalysisOrder-gray-100"></div>

                <button class='status-analysis-order-edit block px-4 py-2 text-sm leading-5
                             text-gray-700 hover:bg-gray-100 bg-red-100
                              focus:outline-none focus:bg-gray-100
                              transition w-full'
                              data-status="{{ 'canceled' }}"
                              data-id="{{ $analysisOrder->id }}">
                    {{ __('canceled') }}
                </button>
            </x-slot>
        </x-jet-dropdown>
    </div>
</div>
