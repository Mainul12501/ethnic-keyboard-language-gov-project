
@if ($paginator->hasPages())
    {{--<div class="text-end mb-3 justify-content-end">
        @if ($paginator->onFirstPage())
            <button  class="btn btn-success  text-white disabled" >Previous</button>
        @else
            <button  class="btn btn-success  text-white" ><a href="{{ $paginator->previousPageUrl() }}" aria-label="Previous"><span aria-hidden="true">Previous</span></a></button>
        @endif
            @if ($paginator->hasMorePages())
                <button type="submit" class="btn btn-success  text-white disabled" >
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" id="next_page" aria-label="Next"><span aria-hidden="true" >Next</span></a>
                </button>
            @else
                <button class="btn btn-success  text-white disabled" >Next</button>
            @endif
    </div>--}}
    <nav aria-label="Page navigation example">
        <ul class="pagination pagination-sm justify-content-end">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link">Previous</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous"><span aria-hidden="true">Previous</span></a></li>
            @endif

            @if ($paginator->hasMorePages())
                <li class="page-item" ><a class="page-link" href="{{ $paginator->nextPageUrl() }}" id="next_page" aria-label="Next"><span aria-hidden="true" >Next</span></a></li>
            @else
                <li class="page-item disabled"><span class="page-link">Next</span></li>
            @endif
        </ul>
    </nav>
@endif
