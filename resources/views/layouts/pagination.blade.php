@if (isset($pageName))
    {!! $models->fragment($pageName)->appends([
        'order_by' => $order_by,
        'ascending' => $ascending,
        'paginate_per_page' => $ascending,
    ])->links() !!}
@else
    {!! $models->appends([
        'order_by' => $order_by,
        'ascending' => $ascending,
        'paginate_per_page' => $paginate_per_page,
    ])->links() !!}
@endif
