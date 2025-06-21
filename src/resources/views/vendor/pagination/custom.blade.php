@if ($paginator->hasPages())
    <nav class="pagination" role="navigation">
        {{-- 前へボタン --}}
        @if ($paginator->onFirstPage())
            <span class="pagination__item pagination__arrow disabled">&lt;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="pagination__item pagination__arrow">&lt;</a>
        @endif

        {{-- 数字 --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="pagination__item disabled">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="pagination__item pagination__item--active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="pagination__item">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- 次へボタン --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="pagination__item pagination__arrow">&gt;</a>
        @else
            <span class="pagination__item pagination__arrow disabled">&gt;</span>
        @endif
    </nav>
@endif
