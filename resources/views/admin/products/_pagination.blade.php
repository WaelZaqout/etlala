@if ($products->hasPages())
    <ul class="pagination justify-content-center">
        {{-- السابق --}}
        @if ($products->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">السابق</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $products->previousPageUrl() }}">السابق</a>
            </li>
        @endif

        {{-- روابط الصفحات --}}
        @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
            <li class="page-item {{ $products->currentPage() == $page ? 'active' : '' }}">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
        @endforeach

        {{-- التالي --}}
        @if ($products->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $products->nextPageUrl() }}">التالي</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">التالي</span>
            </li>
        @endif
    </ul>
@endif
