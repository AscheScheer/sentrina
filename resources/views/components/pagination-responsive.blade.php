@props(['paginator'])

@if ($paginator && method_exists($paginator, 'lastPage') && $paginator->lastPage() > 1)
    <div class="w-100">
        <!-- Mobile: compact pagination -->
        <div class="d-sm-none d-flex align-items-center justify-content-between gap-2 px-3">
            @if ($paginator->onFirstPage())
                <span class="btn btn-light disabled px-3 py-1">Sebelumnya</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-outline-primary px-3 py-1">Sebelumnya</a>
            @endif

            <small class="text-muted">Halaman {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}</small>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-outline-primary px-3 py-1">Berikutnya</a>
            @else
                <span class="btn btn-light disabled px-3 py-1">Berikutnya</span>
            @endif
        </div>

        <!-- Desktop/Tablet: full pagination -->
        <div class="d-none d-sm-block">
            {{ $paginator->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endif
