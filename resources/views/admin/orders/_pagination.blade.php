@if ($orders->hasPages())
    <ul class="pagination justify-content-center">
        {{-- السابق --}}
        @if ($orders->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">السابق</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $orders->previousPageUrl() }}">السابق</a>
            </li>
        @endif

        {{-- روابط الصفحات --}}
        @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
            <li class="page-item {{ $orders->currentPage() == $page ? 'active' : '' }}">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
        @endforeach

        {{-- التالي --}}
        @if ($orders->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $orders->nextPageUrl() }}">التالي</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">التالي</span>
            </li>
        @endif
    </ul>
@endif
