<thead>
    <tr class="thead-light">
        <x-table-sort-header :orderBy="null" :ascending="null" columnName="null" columnText="{{ __('Amostra') }}"/>
    </tr>
</thead>
<tbody>
    @foreach ($projectPointMatrices as $index => $point)
        <tr>
            <td>
                <table class="table table-responsive md:table w-full" x-data="{ open_{{ $point->pointIdentification->id }}: false }">
                    @if (($index > 0 && $projectPointMatrices[$index]->pointIdentification->identification !=
                            $projectPointMatrices[$index - 1]->pointIdentification->identification) || $index == 0)
                        <tr>
                            <td class="font-bold border-t-0" style="border-top-width: 0px;">
                                @if ($point->pointIdentification)
                                    <button @click="open_{{ $point->pointIdentification->id }} = !open_{{ $point->pointIdentification->id }}" type="button" class="point-open pl-4" data-id="{{ $point->pointIdentification->id }}">
                                        {{ $point->pointIdentification->area }} - {{ $point->pointIdentification->identification }}
                                        <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open_{{ $point->pointIdentification->id }}, 'rotate-0': !open_{{ $point->pointIdentification->id }}}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1 text-black">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endif

                    @if (($index > 0 && $projectPointMatrices[$index]->parameterAnalysis->parameter_analysis_group_id !=
                                        $projectPointMatrices[$index - 1]->parameterAnalysis->parameter_analysis_group_id) || $index == 0 ||
                                        ($projectPointMatrices[$index]->pointIdentification->identification !=
                                        $projectPointMatrices[$index - 1]->pointIdentification->identification))
                        <tr x-show="open_{{ $point->pointIdentification->id }}" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="point-items-{{ $point->pointIdentification->id }}">
                            <td class="font-bold text-black" style="background-color:#e1ede1">
                                {{ $point->parameterAnalysis->parameterAnalysisGroup->name }}
                            </td>
                        </tr>
                    @endif

                    <tr x-show="open_{{ $point->pointIdentification->id }}" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="point-items-{{ $point->pointIdentification->id }}">
                        <td>
                            @if ($point->parameterAnalysis)
                                <a class="text-green-600 underline text-item-table" href="{{ route('parameter-analysis.show', ['parameter_analysis' => $point->parameterAnalysis->id]) }}">
                                    {{ $point->parameterAnalysis->cas_rn }} -
                                    {{ $point->parameterAnalysis->analysis_parameter_name }} -
                                    {{ $point->parameterAnalysis->parameterAnalysisGroup ? $point->parameterAnalysis->parameterAnalysisGroup->name : '' }}
                                </a>
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>



    @endforeach
</tbody>

<script>
    document.querySelectorAll(".point-open").forEach(item => {
        item.addEventListener("click", function() {

            document.querySelectorAll(".point-items-" + this.dataset.id).forEach(item => {
                if(item.classList.contains("hidden")) {
                    //item.classList.remove("hidden");
                } else {
                    //item.classList.add("hidden");
                }
            });
        });
    });
</script>
