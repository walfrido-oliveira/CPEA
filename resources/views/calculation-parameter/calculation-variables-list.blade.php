@foreach ($calculationVariables as $calculationVariable)
    <small class="tag inlie text-sm text-gray-500 cursor-pointer">{{ $calculationVariable->name }}</small>
@endforeach
