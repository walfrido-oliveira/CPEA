<tbody id="point_matrix_table_content">
    @forelse ($projectPointMatrices as $key => $projectPointMatrix)
        @include('project.saved-point-matrix', ['id' => $projectPointMatrix->id, 'key' => $key])
    @empty
    @endforelse
</tbody>
