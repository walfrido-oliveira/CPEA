@if (isset($pageName))
    {!! $models->fragment($pageName)->links() !!}
@else
    {!! $models->links() !!}
@endif
