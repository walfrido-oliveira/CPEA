<div class="block py-2 px-2" x-data="{ open: false }">
    <div class="flex sm:items-center justify-start w-full">
        <x-jet-dropdown align="left" width="48" contentClasses="p-0">
            <x-slot name="trigger">
                <button type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                <button
                    class='block px-4 py-2 text-sm leading-5
                           text-gray-700 hover:bg-gray-100 bg-yellow-100
                            focus:outline-none focus:bg-gray-100
                            transition w-full download-analysis-result'
                    id="download-result-default"
                    data-url="{{ route('analysis-result.download', ['campaign' => $campaign->id]) }}">
                    {{ __('Padrão') }}
                </button>

                <div class="banalysisOrder-t banalysisOrder-gray-100"></div>

                <button
                    class='block px-4 py-2 text-sm leading-5
                           text-gray-700 hover:bg-gray-100 bg-green-100
                            focus:outline-none focus:bg-gray-100
                            transition w-full download-analysis-result'
                    id="download-result-nbr"
                    data-url="{{ route('analysis-result.download-nbr', ['campaign' => $campaign->id]) }}">
                    {{ __('NBR') }}
                </button>

                <div class="banalysisOrder-t banalysisOrder-gray-100"></div>
            </x-slot>
        </x-jet-dropdown>
    </div>
</div>
