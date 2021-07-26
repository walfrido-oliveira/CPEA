<x-app-layout>
    <div class="py-6 edit-users">
        <div class="max-w-6xl mx-auto px-4">
            <form method="POST" action="{{ route('config.emails.store') }}">
                @csrf
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Templates de E-mail') }}</h1>
                    </div>
                </div>

                <div class="pb-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex">
                        <table class="table table-responsive md:table" id="table">
                            <thead>
                                <tr class="thead-light">
                                    <th class="sortable" data-index="0">{{ __('Assunto') }}</th>
                                    <th class="sortable" data-index="0">{{ __('Descrição') }}</th>
                                    <th>{{ __('Ações') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($templates as $key => $template)
                                    <tr>
                                        <td>{{ $template->subject }}</td>
                                        <td>{{ $template->description }}</td>
                                        <td>
                                            <a class="btn btn-outline-warning md:my-0 my-2" href="{{ route('config.emails.templates.edit', ['template' => $template->id]) }}">{{ __('Editar') }}</a>
                                            <a target="_blank" rel="noopener noreferrer" href="{{ route('config.emails.templates.mail-preview', ['template' => $template->id]) }}" class="btn btn-outline-info" type="submit">{{ __('Pré-Visualizar') }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="flex mt-4 p-2" id="pagination">
                            {{ $templates->appends(request()->input())->links() }}
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
