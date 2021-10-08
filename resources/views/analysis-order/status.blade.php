<div class="py-2 my-2 bg-white rounded-lg flex md:flex-row flex-col flex-wrap">
    <div class="flex md:flex-row flex-col w-full">
        <div class="mx-4 px-3 py-2 w-full flex items-center">
            <h2>{{ __('Status') }}</h2>
        </div>
        <div class="block py-2 px-2 cursor-pointer" x-data="{ open: false }">
            <div class="hidden sm:flex sm:items-center justify-end w-full">
                <x-jet-dropdown align="right" width="48" contentClasses="p-0">
                    <x-slot name="trigger">
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
                    </x-slot>

                    <x-slot name="content">
                        <button class='status-analysis-order-edit block px-4 py-2 text-sm leading-5
                                     text-gray-700 hover:bg-gray-100 bg-yellow-100
                                      focus:outline-none focus:bg-gray-100
                                      transition w-full' data-status="{{ 'analyzing' }}">{{ __('analyzing') }}</button>

                        <div class="border-t border-gray-100"></div>

                        <button class='status-analysis-order-edit block px-4 py-2 text-sm leading-5
                                     text-gray-700 hover:bg-gray-100 bg-green-100
                                      focus:outline-none focus:bg-gray-100
                                      transition w-full' data-status="{{ 'concluded' }}">{{ __('concluded') }}</button>

                        <div class="border-t border-gray-100"></div>

                        <button class='status-analysis-order-edit block px-4 py-2 text-sm leading-5
                                     text-gray-700 hover:bg-gray-100 bg-red-100
                                      focus:outline-none focus:bg-gray-100
                                      transition w-full' data-status="{{ 'canceled' }}">{{ __('canceled') }}</button>
                    </x-slot>
                </x-jet-dropdown>
            </div>
        </div>
    </div>
    <div class="mx-4 px-3 py-2 flex md:flex-row flex-col w-full">
        <div class="flex md:flex-row flex-col w-full">
            <div class="md:w-1/2 w-full">
                <div class="grid" style="grid-template-columns: 1fr 3fr;">
                    <div class="mx-1 px-1">
                        <p class="font-bold md:text-right">{{ __('Cliente:') }}</p>
                    </div>
                    <div class="mx-1 px-1">
                        <p class="text-gray-500 font-bold">
                            {{ $analysisOrder->campaign->project->customer->name }}</p>
                    </div>
                </div>
                <div class="grid " style="grid-template-columns: 1fr 3fr;">
                    <div class="mx-1 px-1">
                        <p class="font-bold md:text-right">{{ __('Projeto:') }}</p>
                    </div>
                    <div class="mx-1 px-1">
                        <p class="text-gray-500 font-bold">
                            {{ $analysisOrder->campaign->project->project_cod }}</p>
                    </div>
                </div>
                <div class="grid " style="grid-template-columns: 1fr 3fr;">
                    <div class="mx-1 px-1">
                        <p class="font-bold md:text-right">{{ __('Observações:') }}</p>
                    </div>
                    <div class="mx-1 px-1">
                        <p class="text-gray-500 font-bold">{{ $analysisOrder->obs }}</p>
                    </div>
                </div>
            </div>
            <div class="md:w-1/2 w-full">
                <div class="grid " style="grid-template-columns: 1fr 3fr;">
                    <div class="mx-1 px-1">
                        <p class="font-bold md:text-right">{{ __('Campanha:') }}</p>
                    </div>
                    <div class="mx-1 px-1">
                        <p class="text-gray-500 font-bold">{{ $analysisOrder->campaign->name }}</p>
                    </div>
                </div>
                <div class="grid " style="grid-template-columns: 1fr 3fr;">
                    <div class="mx-1 px-1">
                        <p class="font-bold md:text-right">{{ __('Laboratório:') }}</p>
                    </div>
                    <div class="mx-1 px-1">
                        <p class="text-gray-500 font-bold">{{ $analysisOrder->lab->name }}</p>
                    </div>
                </div>
                <div class="grid " style="grid-template-columns: 1fr 3fr;">
                    <div class="mx-1 px-1">
                        <p class="font-bold md:text-right">{{ __('Pedido:') }}</p>
                    </div>
                    <div class="mx-1 px-1">
                        <p class="text-gray-500 font-bold">{{ $analysisOrder->formatted_id }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="block w-full justify-center">
        <div class="p-5">
            <div class="mx-4 p-4">
                <div class="flex items-center">

                    <div class="flex items-center relative
                        @if($analysisOrder->status == "sent")
                            text-white
                        @elseif($analysisOrder->status == "canceled")
                            text-gray-500
                        @else
                            text-green-900
                        @endif">
                        <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2
                            @if($analysisOrder->status == "sent")
                                bg-green-900
                            @elseif($analysisOrder->status == "canceled")
                                border-gray-300
                            @else
                                border-green-900
                            @endif">

                            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                            </svg>
                        </div>
                        <div class="absolute top-0 -ml-10 text-center mt-14 w-32 text-gray-500 font-bold text-xs md:block hidden">
                            {{ __('Pedido Enviado') }} <br />
                            @if ($analysisOrder->created_at)
                                {{ $analysisOrder->created_at->translatedFormat('d/M h:m') }}
                            @endif
                        </div>
                    </div>

                    <div class="flex-auto border-t-2 transition duration-500 ease-in-out
                        @if($analysisOrder->status != "sent" && $analysisOrder->status != "canceled")
                            border-green-900
                        @else
                            border-gray-300
                        @endif">
                    </div>

                    <div class="flex items-center relative
                        @if($analysisOrder->status == "analyzing")
                            text-white
                        @elseif($analysisOrder->status == "concluded")
                            text-green-900
                        @else
                            text-gray-500
                        @endif">

                        <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2
                            @if($analysisOrder->status == "analyzing")
                                border-green-900 bg-green-900
                            @elseif($analysisOrder->status == "concluded")
                                border-green-900
                            @else
                                border-gray-300
                            @endif">

                            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                        <div class="absolute top-0 -ml-10 text-center mt-14 w-32 text-gray-500 font-bold text-xs md:block hidden">
                            {{ __('Pedido em Análise') }} <br />
                            @if ($analysisOrder->analyzing_at)
                                {{ $analysisOrder->analyzing_at->translatedFormat('d/M h:m') }}
                            @endif
                        </div>
                    </div>

                    <div class="flex-auto border-t-2 transition duration-500 ease-in-out @if($analysisOrder->status == "concluded") border-green-900 @else border-gray-300 @endif ">
                    </div>

                    <div class="flex items-center
                        @if($analysisOrder->status == "concluded")
                            text-white
                        @else
                            text-gray-500
                        @endif
                        relative">
                        <div
                            class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2
                                @if($analysisOrder->status == "concluded")
                                    border-green-900 bg-green-900
                                @else
                                    border-gray-300
                                @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="absolute top-0 -ml-10 text-center mt-14 w-32 text-gray-500 font-bold text-xs md:block hidden">
                            {{ __('Pedido Concluído') }} <br />
                            @if ($analysisOrder->concluded_at)
                                {{ $analysisOrder->concluded_at->translatedFormat('d/M h:m') }}
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            <div class="mt-8 p-4">
            </div>
        </div>
    </div>
</div>
