<x-app-layout>
    <div class="py-6 show-field">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Registros de Campos') }}</h1>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                <div class="mx-4 px-3 py-2 mt-4">
                    <div class="flex flex-wrap">
                        <table class="table table-responsive md:table w-full">
                            <thead>
                                <tr class="thead-light">
                                    <th class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Matrizes') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fields as $field)
                                <tr>
                                    <td>
                                        <a class="text-green-600 text-item-table" href="{{ route('fields.index', ['type' => $field->id]) }}" rel="noopener noreferrer">
                                            {{ $field->name }}
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
