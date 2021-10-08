
<x-app-layout>
    <div class="py-6 show-sample-analysis">
        <div class="max-w-6xl mx-auto px-4">
            <form method="POST" action="{{ route('analysis-order.store') }}">
                @csrf
                @method("POST")
                <input type="hidden" name="campaign_id" id="campaign_id" value="{{ $campaign->id }}">

                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Carrinho de Amostra(s)') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Enviar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('sample-analysis.show', ['campaign' => $campaign->id])}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>


                @if ($errors)
                    <div>
                        <ul class="mt-3 list-none list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex md:flex-row flex-col">

                    <div class="py-2 my-2 md:mx-2 bg-white rounded-lg w-full md:w-2/3">
                        <div class="mx-4 px-3 py-2 w-full">
                            <h2>{{ __('Amostras') }}</h2>
                        </div>
                        <div class="mx-4 px-3 py-2 w-full">
                            <table id="parameter_analysis_table" class="table table-responsive md:table w-full">
                                @include('analysis-order.cart-items')
                            </table>
                        </div>
                    </div>

                    <div class="py-2 my-2 md:mx-2 bg-white rounded-lg w-full md:w-1/3">
                        <div class="">
                            <div class="mx-4 px-3 py-2 w-full">
                                <h2>{{ __('Custódia') }}</h2>
                            </div>
                            <div class="grid grid-rows-3">
                                <div class="grid" style="grid-template-columns: 4.6fr 1.4fr;">
                                    <div class="mx-4 px-3 py-2">
                                        <p class="font-bold">{{ __('Qtd. Pontos') }}</p>
                                    </div>
                                    <div class="mx-4 px-3 py-2">
                                        <p class = "text-gray-500 font-bold">
                                            {{ $totalPoints }}
                                        </p>
                                    </div>
                                </div>
                                <div class="grid" style="grid-template-columns: 4.6fr 1.4fr;">
                                    <div class="mx-4 px-3 py-2">
                                        <p class="font-bold">{{ __('Qtd. de grupos Param. Análise') }}</p>
                                    </div>
                                    <div class="mx-4 px-3 py-2">
                                        <p class = "text-gray-500 font-bold">
                                            {{ $totalGroups }}
                                        </p>
                                    </div>
                                </div>
                                <div class="grid" style="grid-template-columns: 4.6fr 1.4fr;">
                                    <div class="mx-4 px-3 py-2">
                                        <p class="font-bold">{{ __('Qtd. de Param. Análise') }}</p>
                                    </div>
                                    <div class="mx-4 px-3 py-2">
                                        <p class = "text-gray-500 font-bold">
                                            {{ $totalParamAnalysis }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex mx-4 px-3 py-2 md:flex-row flex-col">
                                <div class="w-full">
                                    <x-jet-label for="lab_id" value="{{ __('Laboratório') }}" required/>
                                    <x-custom-select :options="$labs" name="lab_id" id="lab_id" :value="old('lab_id')"/>
                                </div>
                            </div>
                            <div class="flex mx-4 px-3 py-2 md:flex-row flex-col">
                                <div class="w-full">
                                    <x-jet-label for="lab_id" value="{{ __('Observações') }}" />
                                    <textarea class="form-input w-full" name="obs" id="obs" cols="30" rows="10">{{ old('obs') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll(".delete-parameter-analysis-item").forEach(item => {
            item.addEventListener("click", function() {
                item.parentNode.parentNode.innerHTML = "";
            })
        });
    </script>
</x-app-layout>
