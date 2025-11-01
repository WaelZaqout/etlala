@if ($categories->hasPages())
    <ul class="pagination justify-content-center">
        {{-- السابق --}}
        @if ($categories->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">السابق</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $categories->previousPageUrl() }}">السابق</a>
            </li>
        @endif

        {{-- روابط الصفحات --}}
        @foreach ($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
            <li class="page-item {{ $categories->currentPage() == $page ? 'active' : '' }}">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
        @endforeach

        {{-- التالي --}}
        @if ($categories->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $categories->nextPageUrl() }}">التالي</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">التالي</span>
            </li>
        @endif
    </ul>
@endif
