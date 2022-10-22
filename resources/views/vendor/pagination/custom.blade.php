
@if ($paginator->hasPages())
<nav aria-label="Page navigation example">
    <ul class="pagination pagination-sm justify-content-end">

        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link">Previous</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous"><span aria-hidden="true">Previous</span></a></li>
        @endif

        @foreach ($elements as $element)

            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li class="page-item" ><a class="page-link" href="{{ $paginator->nextPageUrl() }}" id="next_page" aria-label="Next"><span aria-hidden="true" >Next</span></a></li>
        @else
            <li class="page-item disabled"><span class="page-link">Next</span></li>
        @endif
    </ul>
</nav>
@endif
