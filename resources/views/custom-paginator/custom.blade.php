@if ($paginator->hasPages())
  <link rel="stylesheet" href="{{ theme_asset('public/assets/custom-css/ai/custom-pagination.css') }}">
  <div class="pagination">
    <div class="pagination-pages">
      {{-- Previous Page Link --}}
      @if ($paginator->onFirstPage())
        <button class="pagination-prev" disabled>
            <img
              src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/a709056010543323f81b868dae7add3f426c9f74?placeholderIfAbsent=true"
              alt="Previous"
            />
        </button>
      @else
        <a href="{{ $paginator->previousPageUrl() }}" class="pagination-prev" data-page="{{ $paginator->currentPage() - 1 }}">
            <img
              src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/a709056010543323f81b868dae7add3f426c9f74?placeholderIfAbsent=true"
              alt="Previous"
            />
        </a>
      @endif

      {{-- Pagination Elements --}}
      @foreach ($elements as $element)
        @if (is_string($element))
          <span class="pagination-page disabled">{{ $element }}</span>
        @endif

        @if (is_array($element))
          @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
              <button class="pagination-page pagination-active" aria-current="page">{{ $page }}</button>
            @else
              <a href="{{ $url }}" class="pagination-page" style="text-decoration: none;" data-page="{{ $page }}">{{ $page }}</a>
            @endif
          @endforeach
        @endif
      @endforeach
    </div>

    <div class="pagination-info">
      {{-- <div class="pagination-total">{{ $paginator->total() }}</div> --}}
      {{-- Next Page Link --}}
      @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="pagination-next" data-page="{{ $paginator->currentPage() + 1 }}">
            <img
              src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/2acf36908afa50c91c57d10e3f0023c880bdaf97?placeholderIfAbsent=true"
              alt="Next"
            />
        </a>
      @else
        <button class="pagination-next" disabled>
            <img
              src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/2acf36908afa50c91c57d10e3f0023c880bdaf97?placeholderIfAbsent=true"
              alt="Next"
            />
        </button>
      @endif
    </div>
  </div>
@endif
