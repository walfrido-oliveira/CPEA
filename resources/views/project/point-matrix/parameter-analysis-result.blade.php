<thead>
    <tr class="thead-light">
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="analysis_parameter_id" columnText="{{ __('Amostra') }}"/>
    </tr>
</thead>
<tbody>
    @foreach ($parameterAnalyses as $key => $parameterAnalysis)
        <tr>
            <td class="text-center">
                <a class="text-green-600 underline text-item-table" href="{{ route('parameter-analysis.show', ['parameter_analysis' => $parameterAnalysis->id]) }}">
                    {{ $parameterAnalysis->cas_rn }} - {{ $parameterAnalysis->analysis_parameter_name }} - {{ $parameterAnalysis->parameterAnalysisGroup ? $parameterAnalysis->parameterAnalysisGroup->name : '' }}</td>
                </a>
            </td>
        </tr>
    @endforeach
</tbody>
