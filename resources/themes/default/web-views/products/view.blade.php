@extends('layouts.front-end.app')
@section('title', translate($data['data_from']) . ' ' . translate('products'))

@push('css_or_js')
    <meta property="og:image" content="{{ $web_config['web_logo']['path'] }}" />
    <meta property="og:title" content="Products of {{ $web_config['name'] }} " />
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:description"
        content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)), 0, 160) }}">
    <meta property="twitter:card" content="{{ $web_config['web_logo']['path'] }}" />
    <meta property="twitter:title" content="Products of {{ $web_config['name'] }}" />
    <meta property="twitter:url" content="{{ env('APP_URL') }}">
    <meta property="twitter:description"
        content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)), 0, 160) }}">
    <link rel="stylesheet" href="{{ asset('assets/custom-css/ai/marketplace-list.css') }}" />
@endpush

@section('content')

    @php
        $decimal_point_settings = getWebConfig(name: 'decimal_point_settings');
    @endphp

    <section class="mainpagesection marketplace-list" style="background-color: unset; margin-top:20px;">
        <main class="market-sub">
            <!-- Breadcrumb -->
            <nav class="breadcrumb mb-4" aria-label="Breadcrumb">
                <div class="d-flex">
                    <span>Home</span>
                    @if (!empty($data['cate_name']))
                        <span>/ {{ $data['cate_name'] }}</span>
                    @endif

                    @if (!empty($data['brand_name']))
                        <span class="active">/ {{ $data['brand_name'] }}</span>
                    @endif
                </div>

                <div>
                    <button class="btn icon-top" id="prod-list">
                        <i class="bi bi-list-ul"></i>
                    </button>
                    <button class="btn icon-top" id="prod-grid">
                        <i class="bi bi-grid-3x3-gap-fill"></i>
                    </button>
                </div>
            </nav>
            <div class="content-wrapper">


                <div class=" hide-header">
                    <div class="  py-3 rounded  shadow1 d-flex align-items-center justify-content-between">

                        <!-- Compact version -->
                        <div class="search-compact  align-items-center w-100">
                            <div class="d-flex align-items-center w-100 bg-white border px-3" style="height: 44px;">
                                <i class="bi bi-search me-2 fs-5"></i>
                                <input type="text" class="form-control border-0" placeholder="Search by Name"
                                    style="box-shadow: none;" />
                            </div>
                        </div>
                        <!-- Filters Button -->
                        <button class="btn btn-outline-light bg-white border ms-3 d-flex align-items-center "
                            style="color: var(--text-medium);">
                            Filters&nbsp;<i class="bi bi-filter"></i>
                        </button>

                    </div>
                </div>
                <!-- Left Sidebar -->
                <aside class="sidebar desktop-sidebar">
                    <form method="GET" action="{{ route('products') }}" id="filterFormProducts">
                        <div class="filter-section showbelow768">
                            <div class="search-section">
                                <div class="search-label notshowbelow768">Search by Name</div>
                                <div class="search-input-container">
                                    <div class="search-input-field">
                                        <input type="text" name="search_query" id="nameFilter"
                                            placeholder="Enter name..." value="{{ request('name') }}" />
                                        <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/1198a3d1d34d3e698d6d5a08e6c9133273758e48?placeholderIfAbsent=true"
                                            class="search-icon" alt="Search icon" />
                                    </div>
                                </div>
                            </div>

                            <button type="button" id="filters-button" class="filter-button" onclick="toggleFilters(event)">
                                Filters
                                <!-- Filter Icon SVG -->
                                <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" fill="black"
                                    viewBox="0 0 24 24">
                                    <path d="M3 5h18M6 12h12M10 19h4" stroke="black" stroke-width="2" fill="none"
                                        stroke-linecap="round" />
                                </svg>
                            </button>
                        </div>

                        <div class="filter-section togglebelow768">
                            <div class="search-label">Search by Country</div>
                            <div class="search-input-container">
                                <div class="search-input-field">
                                    <input type="text" name="country_search" placeholder="Enter Country..."
                                        class="search-filter" data-target="#countriescheckbox"
                                        value="{{ request('country_search') }}" />
                                    <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/1198a3d1d34d3e698d6d5a08e6c9133273758e48?placeholderIfAbsent=true"
                                        class="search-icon" alt="Search icon" />
                                </div>
                            </div>

                            <div class="filter-options country-list checkbox-list" id="countriescheckbox">
                                @foreach ($countries as $country)
                                    @php
                                        $countryDetails = \App\Utils\ChatManager::getCountryDetails($country->id);
                                        $isSelected =
                                            is_array(request()->input('country', [])) &&
                                            in_array($country->id, request()->input('country', []));
                                    @endphp
                                    <div class="checkbox-item">
                                        <label class="filter-checkbox country-option filter-item">
                                            <input type="checkbox" name="country[]" value="{{ $country->id }}"
                                                {{ $isSelected ? 'checked' : '' }} />
                                            <img src="/flags/{{ strtolower($countryDetails['countryISO2']) }}.svg"
                                                class="flag-icon" alt="{{ $country->name }} flag" />
                                            <div class="filter-label">{{ $countryDetails['countryName'] }}</div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Filter By Category Section -->
                        <div class="filter-section togglebelow768">
                            <div class="search-label">Search by Category</div>
                            <div class="search-input-container">
                                <div class="search-input-field">
                                    <input type="text" name="industry_search" placeholder="Enter Category..."
                                        class="search-filter" data-target="#categorycheckbox"
                                        value="{{ request('industry_search') }}" />
                                    <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/1198a3d1d34d3e698d6d5a08e6c9133273758e48?placeholderIfAbsent=true"
                                        class="search-icon" alt="Search icon" />
                                </div>
                            </div>

                            <div class="category-list filter-options checkbox-list" id="categorycheckbox">
                                @foreach ($categories as $industry)
                                    <div class="checkbox-item">
                                        <label class="filter-checkbox category-option filter-item">
                                            <input type="checkbox" name="industry[]" value="{{ $industry->id }}"
                                                {{ in_array($industry->id, request('industry', [])) ? 'checked' : '' }} />
                                            <div class="filter-label">{{ $industry->name }}</div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </aside>

                <!-- Main Content -->
                <div class="main-content">
                    <!-- Product Grid View -->
                    <div class="product-grid" id="productGrid">
                        @include('web-views.products.partials.dynamic-product-grid')
                    </div>

                    <!-- Product List View -->
                    <div class="product-list" id="productList" style="display: none;">
                        @include('web-views.products.partials.dynamic-product-list')
                    </div>
                </div>
            </div>
        </main>
        <div id="filterModal" class="filter-modal d-none">
            <aside class="sidebar mobile-sidebar">
                <!-- <div class="search-section">
                                            <h3>Search by Name</h3>
                                            <div class="search-input">
                                                <input type="text" placeholder="Search">
                                                <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/12f01963377e36ee54832fed9f9fa99ecc307862?placeholderIfAbsent=true" alt="Search">
                                            </div>
                                        </div> -->

                <div class="filter-section">
                    <h3>Filter By Country</h3>
                    <div class="search-input">
                        <input type="text" placeholder="Filter">
                        <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/12f01963377e36ee54832fed9f9fa99ecc307862?placeholderIfAbsent=true"
                            alt="Filter">
                    </div>
                    <div class="checkbox-list">
                        <label><input type="checkbox"> United States</label>
                    </div>
                </div>

                <div class="filter-section">
                    <h3>Search by Category</h3>
                    <div class="search-input">
                        <input type="text" placeholder="Category">
                        <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/12f01963377e36ee54832fed9f9fa99ecc307862?placeholderIfAbsent=true"
                            alt="Category">
                    </div>
                    <div class="checkbox-list">
                        <label><input type="checkbox"> Agriculture</label>
                    </div>
                </div>
            </aside>
        </div>
    </section>
    <span id="products-search-data-backup" data-url="{{ route('products') }}"
        data-brand="{{ $data['brand_id'] ?? '' }}" data-category="{{ $data['category_id'] ?? '' }}"
        data-name="{{ $data['name'] }}" data-from="{{ $data['data_from'] ?? $data['product_type'] }}"
        data-sort="{{ $data['sort_by'] }}" data-product-type="{{ $data['product_type'] }}"
        data-min-price="{{ $data['min_price'] }}" data-max-price="{{ $data['max_price'] }}"
        data-message="{{ translate('items_found') }}" data-publishing-house-id="{{ request('publishing_house_id') }}"
        data-author-id="{{ request('author_id') }}"></span>

@endsection

@push('script')
    <script src="{{ theme_asset(path: 'public/assets/front-end/js/product-view.js') }}"></script>
    <script src="{{ theme_asset(path: 'public/js/product-list.js') }}"></script>

    <script>
        function makeFavourite(element) {
            const listingId = element.getAttribute('data-id');
            const user_id = element.getAttribute('data-userid');
            const type = element.getAttribute('data-type');
            const role = element.getAttribute('data-role');
            const btn = element;

            var data = {
                listing_id: listingId,
                user_id: user_id,
                type: type,
                role: role,
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                url: '{{ route('toggle-favourite') }}',
                method: 'POST',
                data: data,
                success: function(response) {
                    if (response.status === 'added') {
                        toastr.success('Added Favourite');
                        btn.src = '/img/Heart (2).png'; // or change icon class
                    } else {
                        btn.src = '/img/Heart (1).png';
                    }
                },
                error: function() {
                    toastr.Error('Something Went Wrong');
                }
            });
        }
    </script>

    <script>
        function loadFilteredData(filters, page = 1) {
            $("#dynamicLoader").css("display", "block");

            filters.page = page;

            $.ajax({
                url: "{{ route('product-dynamic') }}",
                method: "GET",
                data: filters,
                success: function(response) {
                    $("#productGrid").html(response.html);
                    $("#productList").html(response.html2);
                    $("#paginationControls").html(response.pagination);
                    $("#dynamicLoader").css("display", "none");
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    $("#dynamicLoader").css("display", "none");
                },
            });
        }
    </script>
@endpush
