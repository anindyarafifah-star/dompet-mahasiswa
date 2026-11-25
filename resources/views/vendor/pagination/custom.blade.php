@if ($paginator->hasPages())
<nav class="pager">
    <span class="muted">Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }} transaksi</span>
    <div class="pages">
        @if ($paginator->onFirstPage())
            <span class="disabled">« Sebelumnya</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}">« Sebelumnya</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="disabled">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="current">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}">Berikutnya »</a>
        @else
            <span class="disabled">Berikutnya »</span>
        @endif
    </div>
</nav>
@endif