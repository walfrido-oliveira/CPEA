<x-app-layout>
    <div class="py-6 show-users">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Registros de Campos') }}</h1>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                <div class="mx-4 px-3 py-2 mt-4">
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Matrizes') }}</p>
                        </div>

                        <div class="w-full md:w-1/2">
                            @foreach ($fields as $field)
                                <p class="text-gray-500 font-bold">{{ $field }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
