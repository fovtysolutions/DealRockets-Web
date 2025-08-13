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
    
    <style>
        /* Hierarchical Category Styling - Minimal spacing only */
        .hierarchical-category-list .filter-label {
            display: flex;
            align-items: center;
            width: 100%;
        }
        
        /* Simple indentation */
        .sub-category-item .filter-label {
            padding-left: 15px;
        }
        
        .sub-sub-category-item .filter-label {
            padding-left: 30px;
        }
    </style>
@endpush

@section('content')

    @php
        $decimal_point_settings = getWebConfig(name: 'decimal_point_settings');
    @endphp

    <section class="mainpagesection marketplace-list" style="background-color: unset; margin-top:20px;">
        <main class="market-sub">
            <!-- Breadcrumb -->
            <nav class="breadcrumb mb-2" aria-label="Breadcrumb">
                <div class="d-flex">
                    <span><a href="{{ route('home') }}">Home</a></span>
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
                          <div class="filter-section togglebelow768 mb-3 d-flex justify-content-between pb-0 align-items-center" >
                            <div class="search-label w-50 custom-dealrock-text-16">Filter</div>
                            <a href="{{ request()->url() }}" class=" w-50 reset-filter custom-dealrock-text-16" style="display: flex;  justify-content: right;">Reset Filters</a>
                        </div>
                        <div class="filter-section mt-0 showbelow768">
                            <div class="search-section">
                                <div class="search-label notshowbelow768 custom-dealrock-text-16">Search by Name</div>
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
                            <div class="search-label custom-dealrock-text-16">Search by Country</div>
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
                                            <div class="filter-labelb custom-dealrock-text-14">{{ $countryDetails['countryName'] }}</div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Hierarchical Category Filter Section -->
                        <div class="filter-section togglebelow768">
                            <div class="search-label custom-dealrock-text-16">Search by Category</div>
                            <div class="search-input-container">
                                <div class="search-input-field">
                                    <input type="text" name="category_search" placeholder="Search categories..."
                                        class="search-filter" data-target="#hierarchicalcategory"
                                        value="{{ request('category_search') }}" />
                                    <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/1198a3d1d34d3e698d6d5a08e6c9133273758e48?placeholderIfAbsent=true"
                                        class="search-icon" alt="Search icon" />
                                </div>
                            </div>

                            <div class="hierarchical-category-list filter-options checkbox-list" id="hierarchicalcategory">
                                @foreach ($categories as $mainCategory)
                                    <!-- Main Category -->
                                    <div class="checkbox-item main-category-item" data-category-id="{{ $mainCategory->id }}">
                                        <label class="filter-checkbox category-option filter-item">
                                            <input type="checkbox" name="industry[]" value="{{ $mainCategory->id }}"
                                                {{ in_array($mainCategory->id, request('industry', [])) ? 'checked' : '' }}
                                                onchange="toggleSubCategories({{ $mainCategory->id }})" />
                                            <div class="filter-label custom-dealrock-text-14">
                                                {{ $mainCategory->name }}
                                            </div>
                                        </label>
                                    </div>

                                    <!-- Sub Categories (initially hidden) -->
                                    @foreach ($mainCategory->childes as $subCategory)
                                        @php
                                            $parentChecked = in_array($mainCategory->id, request('industry', []));
                                            $displayStyle = $parentChecked ? 'display: flex !important;' : 'display: none !important;';
                                        @endphp
                                        <div class="checkbox-item sub-category-item" 
                                             data-parent-id="{{ $mainCategory->id }}" 
                                             data-sub-category-id="{{ $subCategory->id }}"
                                             style="{{ $displayStyle }}">
                                            <label class="filter-checkbox sub-category-option filter-item">
                                                <input type="checkbox" name="sub_category[]" value="{{ $subCategory->id }}"
                                                    {{ in_array($subCategory->id, request('sub_category', [])) ? 'checked' : '' }}
                                                    onchange="toggleSubSubCategories({{ $subCategory->id }})" />
                                                <div class="filter-label custom-dealrock-text-14">
                                                    {{ $subCategory->name }}
                                                </div>
                                            </label>
                                        </div>

                                        <!-- Sub Sub Categories (initially hidden) -->
                                        @foreach ($subCategory->childes as $subSubCategory)
                                            @php
                                                $subParentChecked = in_array($subCategory->id, request('sub_category', []));
                                                $mainParentChecked = in_array($mainCategory->id, request('industry', []));
                                                $subSubDisplayStyle = ($parentChecked && $subParentChecked) ? 'display: flex !important;' : 'display: none !important;';
                                            @endphp
                                            <div class="checkbox-item sub-sub-category-item" 
                                                 data-sub-parent-id="{{ $subCategory->id }}"
                                                 style="{{ $subSubDisplayStyle }}">
                                                <label class="filter-checkbox sub-sub-category-option filter-item">
                                                    <input type="checkbox" name="sub_sub_category[]" value="{{ $subSubCategory->id }}"
                                                        {{ in_array($subSubCategory->id, request('sub_sub_category', [])) ? 'checked' : '' }} />
                                                    <div class="filter-label custom-dealrock-text-14">{{ $subSubCategory->name }}</div>
                                                </label>
                                            </div>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </div>
                        </div>

                        <!-- Supplier Ranking -->
                        <div class="filter-section togglebelow768">
                            <div class="search-label custom-dealrock-text-16">Supplier Ranking</div>
                            @php
                                $supplierRanks = [
                                    'All Suppliers',
                                    'Gold Verified Supplier',
                                    'Premium Supplier',
                                    'Verified Supplier',
                                    'Non-Verified Supplier',
                                ];
                            @endphp

                            @foreach ($supplierRanks as $rank)
                                <div class="checkbox-item">
                                    <label class="filter-checkbox supplier-rank-option filter-item">
                                        <input type="checkbox" name="supplier_rank[]" value="{{ $rank }}"
                                            {{ request()->has('supplier_rank') && in_array($rank, request('supplier_rank')) ? 'checked' : '' }} />
                                        <div class="filter-label custom-dealrock-text-14">{{ $rank }}</div>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Business Type -->
                        <div class="filter-section togglebelow768">
                            <div class="search-label custom-dealrock-text-16">Business Type</div>
                            @php
                                $businessTypes = [
                                    'Manufacturer',
                                    'Wholesaler',
                                    'Trading Company',
                                    'Distributor',
                                    'Trader',
                                ];
                            @endphp

                            @foreach ($businessTypes as $type)
                                <div class="checkbox-item">
                                    <label class="filter-checkbox filter-item">
                                        <input type="checkbox" name="business_type[]" value="{{ $type }}"
                                            {{ request()->has('business_type') && in_array($type, request('business_type')) ? 'checked' : '' }} />
                                        <div class="filter-label custom-dealrock-text-14">{{ $type }}</div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <!-- <div class="filter-section togglebelow768">
                            <a href="{{ request()->url() }}" class="btn btn-sm reset-filter">Reset Filters</a>
                        </div> -->
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

                    <div id="paginationControls">
                        {{ $products->links('custom-paginator.custom') }}
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
                    
                    // Maintain category hierarchy after AJAX load
                    if (typeof maintainCategoryHierarchy === 'function') {
                        maintainCategoryHierarchy();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    $("#dynamicLoader").css("display", "none");
                },
            });
        }

        // Toggle sub-categories when main category is selected
        function toggleSubCategories(categoryId) {
            const subCategories = document.querySelectorAll(`[data-parent-id="${categoryId}"]`);
            const isChecked = document.querySelector(`input[name="industry[]"][value="${categoryId}"]`).checked;
            
            subCategories.forEach(function(subCategory) {
                if (isChecked) {
                    subCategory.style.setProperty('display', 'flex', 'important');
                } else {
                    subCategory.style.setProperty('display', 'none', 'important');
                    
                    // Also hide all sub-sub-categories and uncheck sub-categories
                    const subCategoryInput = subCategory.querySelector('input[type="checkbox"]');
                    if (subCategoryInput) {
                        subCategoryInput.checked = false;
                        const subCategoryId = subCategoryInput.value;
                        const subSubCategories = document.querySelectorAll(`[data-sub-parent-id="${subCategoryId}"]`);
                        subSubCategories.forEach(function(subSubCategory) {
                            subSubCategory.style.setProperty('display', 'none', 'important');
                            const subSubInput = subSubCategory.querySelector('input[type="checkbox"]');
                            if (subSubInput) {
                                subSubInput.checked = false;
                            }
                        });
                    }
                }
            });
        }

        // Toggle sub-sub-categories when sub-category is selected  
        function toggleSubSubCategories(subCategoryId) {
            const subSubCategories = document.querySelectorAll(`[data-sub-parent-id="${subCategoryId}"]`);
            const isChecked = document.querySelector(`input[name="sub_category[]"][value="${subCategoryId}"]`).checked;
            
            subSubCategories.forEach(function(subSubCategory) {
                if (isChecked) {
                    subSubCategory.style.setProperty('display', 'flex', 'important');
                } else {
                    subSubCategory.style.setProperty('display', 'none', 'important');
                    
                    // Uncheck sub-sub-categories when hiding
                    const subSubInput = subSubCategory.querySelector('input[type="checkbox"]');
                    if (subSubInput) {
                        subSubInput.checked = false;
                    }
                }
            });
        }

        // Initialize hierarchy on page load based on checked items
        document.addEventListener('DOMContentLoaded', function() {
            // Only show sub-categories if their parent main category is also checked
            document.querySelectorAll('input[name="industry[]"]:checked').forEach(function(input) {
                toggleSubCategories(input.value);
            });
            
            // Only show sub-sub-categories if their parent sub-category is also checked
            document.querySelectorAll('input[name="sub_category[]"]:checked').forEach(function(input) {
                // Check if the parent sub-category's main category is also checked
                const subCategoryId = input.value;
                const subCategoryElement = document.querySelector(`[data-sub-category-id="${subCategoryId}"]`);
                if (subCategoryElement) {
                    const parentId = subCategoryElement.getAttribute('data-parent-id');
                    const parentCheckbox = document.querySelector(`input[name="industry[]"][value="${parentId}"]`);
                    if (parentCheckbox && parentCheckbox.checked) {
                        toggleSubSubCategories(subCategoryId);
                    }
                }
            });
        });
    </script>
@endpush
