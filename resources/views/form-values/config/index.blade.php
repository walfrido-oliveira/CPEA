<x-app-layout>
    <div class="py-6 edit-users">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="{{ route('fields.config.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Configurações de Formulário') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('users.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <img src="{{ asset($logo) }}" alt="Logo formulário">
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 mt-2">
                            <x-jet-label :value="__('Logo')" for="logo"/>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="logo" type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" value="{{ old('logo') }}"  autocomplete="logo">
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <img src="{{ asset($cert) }}" alt="Acreditação formulário">
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 mt-2">
                            <x-jet-label :value="__('Selo Acreditação')" for="cert"/>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="cert" type="file" class="form-control @error('cert') is-invalid @enderror" name="cert" value="{{ old('cert') }}"  autocomplete="cert">
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Cabeçalho')" for="form_header" required/>
                            <textarea class="form-input w-full ckeditor" name="form_header" id="form_header" cols="30" rows="10" required >{{ $header ? $header : old('form_header')  }}</textarea>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Rodapé Capa')" for="form_footer" required/>
                            <textarea class="form-input w-full ckeditor" name="form_footer" id="form_footer" cols="30" rows="10" required >{{ $footer ? $footer : old('form_footer')  }}</textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>

<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
