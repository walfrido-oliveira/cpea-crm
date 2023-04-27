<th scope="col"
    @if($columnName) data-name="{{ $columnName }}" @endif
    @if($orderBy) data-ascending="@if ($orderBy == $columnName) {{ $ascending == 'asc' ? 'desc' : 'asc' }} @else desc @endif" @endif

    class="custom-th">
     {!! $columnText !!}

    <span class="@if ($orderBy == $columnName && $ascending == 'asc') inline @else hidden @endif asc">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
        </svg>
    </span>
    <span class="@if ($orderBy == $columnName && $ascending == 'desc') inline @else hidden @endif desc">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
        </svg>
    </span>
    @if ($searchable)
        <input type="text" name="{{ $columnName }}_search" id="{{ $columnName }}_search" class="form-control no-border m-0 w-full p-0 search-form" style="background-color:hsl(0deg 0% 96%);">
    @endif
</th>
