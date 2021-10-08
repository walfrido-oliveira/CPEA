<div class="block" x-data="{ open: false }">
    <div class="flex sm:items-center justify-end w-full">
        <x-jet-dropdown align="right" width="48" contentClasses="p-0">
            <x-slot name="trigger">
                <button type="button">
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
                </button>
            </x-slot>

            <x-slot name="content">
                <button class='status-project-edit block px-4 py-2 text-sm leading-5
                             text-gray-700 hover:bg-gray-100 bg-yellow-100
                              focus:outline-none focus:bg-gray-100
                              transition w-full' data-status="{{ 'analyzing' }}">{{ __('analyzing') }}</button>

                <div class="border-t border-gray-100"></div>

                <button class='status-project-edit block px-4 py-2 text-sm leading-5
                             text-gray-700 hover:bg-gray-100 bg-blue-100
                              focus:outline-none focus:bg-gray-100
                              transition w-full' data-status="{{ 'sent' }}">{{ __('sent') }}</button>

                <div class="border-t border-gray-100"></div>

                <button class='status-project-edit block px-4 py-2 text-sm leading-5
                             text-gray-700 hover:bg-gray-100 bg-green-100
                              focus:outline-none focus:bg-gray-100
                              transition w-full' data-status="{{ 'concluded' }}">{{ __('concluded') }}</button>


            </x-slot>
        </x-jet-dropdown>
    </div>
</div>
