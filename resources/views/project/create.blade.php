<x-app-layout>
    <div class="py-6 create-point-identification">
        <div class="max-w-6xl mx-auto px-4">
            <form method="POST" action="{{ route('project.store') }}">
                @csrf
                @method("POST")
                @if ($type == "duplicate")
                    <input type="hidden" name="duplicated_id" value="{{ $project->id }}">
                @endif
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ $type == "duplicate" ? __('Duplicar Projeto') : __('Cadastrar Projeto') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('project.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="project_cod" value="{{ __('Cód. do Projeto') }}" required />
                            <x-jet-input id="project_cod" class="form-control block mt-1 w-full" type="text" name="project_cod" maxlength="255"
                            required autofocus autocomplete="project_cod" :value="$project ? $project->project_cod : old('project_cod')"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="customer_id" value="{{ __('Cliente') }}"/>
                            <x-custom-select :options="$customers" name="customer_id" id="customer_id" :value="$project ? $project->customer_id : old('customer_id')" class="mt-1"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
