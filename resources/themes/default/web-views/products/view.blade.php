@extends('layouts.front-end.app')
<link rel="stylesheet" href="{{ asset('assets/custom-css/vendor.css') }}" />
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

    @php($decimal_point_settings = getWebConfig(name: 'decimal_point_settings'))

    <section class="mainpagesection marketplace-list" style="background-color: unset">
        <main class="market-sub">
            <!-- Breadcrumb -->
            <nav class="breadcrumb mb-4" aria-label="Breadcrumb">
                <div><span>Home</span>
                    <span>/</span>
                    <span>{{ isset($data['cate_name']) ? $data['cate_name'] : '' }}</span>
                    <span>/</span>
                    <span class="active">{{ isset($data['brand_name']) ? $data['brand_name'] : '' }}</span>
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
                <aside class="sidebar col-3  desktop-sidebar">
                    <div class="search-section">
                        <h3>Search by Name</h3>
                        <div class="search-input">
                            <input type="text" placeholder="Search">
                            <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/12f01963377e36ee54832fed9f9fa99ecc307862?placeholderIfAbsent=true"
                                alt="Search">
                        </div>
                    </div>

                    <div class="filter-section">
                        <h3>Filter By Country</h3>
                        <div class="search-input">
                            <input type="text" placeholder="Filter">
                            <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/12f01963377e36ee54832fed9f9fa99ecc307862?placeholderIfAbsent=true"
                                alt="Filter">
                        </div>
                        <div class="checkbox-list">
                            <label><input type="checkbox" checked> United States</label>
                            <label><input type="checkbox"> United Kingdom</label>
                            <label><input type="checkbox"> China</label>
                            <label><input type="checkbox"> Russia</label>
                            <label><input type="checkbox"> Australia</label>
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
                            <label><input type="checkbox" checked> Agriculture</label>
                            <label><input type="checkbox"> Fashion Accessories</label>
                            <label><input type="checkbox"> Furniture</label>
                            <label><input type="checkbox"> Trade Services</label>
                            <label><input type="checkbox"> Health & Medical</label>
                        </div>
                    </div>
                </aside>

                <!-- Main Content -->
                <div class="main-content col-9">
                    <div class="product-grid" id="productGrid">
                        <!-- Products will be inserted here by JavaScript -->
                    </div>

                    <div class="product-list" id="productList" style="display: none;">
                        <!-- Products will be inserted here by JavaScript -->
                    </div>
                </div>
                <!-- <div class="main-content">
                    <div class="product-grid" id="productlist">
                        Products will be inserted here by JavaScript -->
                <!-- </div>

                     -->
                <!-- </div> -->
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
                        <label><input type="checkbox" checked> United States</label>
                        <label><input type="checkbox"> United Kingdom</label>
                        <label><input type="checkbox"> China</label>
                        <label><input type="checkbox"> Russia</label>
                        <label><input type="checkbox"> Australia</label>
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
                        <label><input type="checkbox" checked> Agriculture</label>
                        <label><input type="checkbox"> Fashion Accessories</label>
                        <label><input type="checkbox"> Furniture</label>
                        <label><input type="checkbox"> Trade Services</label>
                        <label><input type="checkbox"> Health & Medical</label>
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
@endpush
