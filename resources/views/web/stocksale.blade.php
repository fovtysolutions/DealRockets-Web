@extends('layouts.front-end.app')
@push('css_or_js')
    <link rel="stylesheet" href="{{ theme_asset(path: 'assets/custom-css/ai/stocksale.css') }}" />
    <style>
        .leadpagedivision {
            background-color: var(--web-bg);
        }

        .gapbetweens {
            height: 22px;
            background-color: var(--web-bg);
        }

        .fade-in-on-scroll {
            width: 100%;
        }

        .__inline-9 {
            background-color: var(--web-bg);
        }

        .dropdown-item:hover {
            background-color: white;
            transform: scale(1) !important;
            cursor: pointer;
        }

        .ad-section {
            flex-direction: row !important;
        }

        .ad-section img {
            aspect-ratio: 6 / 1;
            max-width: 1440px;
            height: 300px;
            width: 100%;
        }
    </style>
@endpush
@section('title', translate('Stock Sale' . ' | ' . $web_config['name']->value))
@section('content')
    <?php
    $categories = \App\Utils\CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
    $unread = \App\Utils\ChatManager::unread_messages();
    if (Auth('customer')->check()) {
        $membership = \App\Utils\ChatManager::getMembershipStatusCustomer(Auth('customer')->user()->id);
        if (isset($membership['error'])) {
            $membership = ['status' => 'NotMade', 'message' => 'Membership Not Applied'];
        }
    }
    $userdata = \App\Utils\ChatManager::getRoleDetail();
    $user_id = $userdata['user_id'];
    $role = $userdata['role'];
    ?>

    <section class="mainpagesection stock-sale" style="background-color: unset; margin-top: 30px;">
        <div class="main-content">
            <!-- Left sidebar with filters -->
            <div class="sidebar">
                <div class="filter-sidebar">
                    <form method="GET" action="{{ route('stocksale') }}" id="filterFormStockSale">
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

                            <button id="filters-button" class="filter-button" onclick="toggleFilters(event)">
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

                            <div class="filter-options country-list" id="countriescheckbox">
                                @foreach ($countries as $country)
                                    @php
                                        $countryDetails = \App\Utils\ChatManager::getCountryDetails($country);
                                        $isSelected =
                                            is_array(request()->input('country', [])) &&
                                            in_array($country, request()->input('country', []));
                                    @endphp
                                    <div class="checkbox-item">
                                        <label class="filter-checkbox country-option filter-item">
                                            <input type="checkbox" name="country[]" value="{{ $country }}"
                                                {{ $isSelected ? 'checked' : '' }} />
                                            <img src="/flags/{{ strtolower($countryDetails['countryISO2']) }}.svg"
                                                class="flag-icon" alt="{{ $country }} flag" />
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

                            <div class="category-list filter-options" id="categorycheckbox">
                                @foreach ($categoriesn as $industry)
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
                        <div class="filter-section togglebelow768">
                            <div class="search-label">Search by Stock Type</div>
                            <div class="search-input-container">
                                <div class="search-input-field">
                                    <input type="text" name="stock_search" placeholder="Enter Category..."
                                        class="search-filter" data-target="#stockcheckbox"
                                        value="{{ request('stock_search') }}" />
                                    <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/1198a3d1d34d3e698d6d5a08e6c9133273758e48?placeholderIfAbsent=true"
                                        class="search-icon" alt="Search icon" />
                                </div>
                            </div>

                            <div class="category-list filter-options" id="stockcheckbox">
                                @foreach ($stocktype as $industry)
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
                </div>
            </div>

            <!-- Middle section with product listings -->
            <div class="product-list-section">
                <div class="product-list">
                    <div class="product-list-inner">
                        @include('web.dynamic-partials.dynamic-stocksell')
                        <!-- Pagination -->
                        <div id="paginationControls">
                            {{ $items->links('custom-paginator.custom') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right section with product details -->
            <div class="product-detail-section" id="productModal">
                <div class="product-detail">
                    <button type="button" class="close filter-button" data-dismiss="modal" onclick="toggleDetailBox()"
                        aria-label="Close" style="margin: auto !important;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="detail-tabs">
                        <div class="detail-tab active" id="tab-stock-photo">
                            <i class="fa-solid fa-circle-info detail-tab-icon"></i>
                            <div>Stock Photo</div>
                        </div>
                        <div class="detail-tab" id="tab-specification">
                            <i class="fa-solid fa-list detail-tab-icon"></i>
                            <div>Specification</div>
                        </div>
                        <div class="detail-tab" id="tab-deal">
                            <i class="fa-solid fa-envelope detail-tab-icon"></i>
                            <div>Deal</div>
                        </div>
                        <div class="detail-tab" id="tab-contact">
                            <i class="fa-regular fa-circle-question detail-tab-icon"></i>
                            <div>Contact</div>
                        </div>
                    </div>

                    <div class="d-flex flex-column justify-content-between h-100" id="StockSellView">
                        @include('web.dynamic-partials.dynamic-stocksellview')
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('web-views.partials._quotation')
    <div class="mainpagesection leadrightdivision" style="width: 96%;">
        <div class="ad-section">
            <div class="google-ad">
                <div class="ad-content">
                    <!-- Google Ad code goes here -->
                    <img src="{{ isset($adimages['ad2_image']) && $adimages['ad2_image'] ? asset('storage/' . $adimages['ad2_image']) : asset('/images/placeholderimage.webp') }}"
                        alt="Google Ad" class="ad-image">
                </div>
            </div>
        </div>
    </div>
    @include('web-views.partials._order-now')
    @include('web.partials.loginmodal')
@endsection
@push('script')
    <script src="{{ theme_asset(path: 'public/js/stocksale.js') }}"></script>
    <script>
        function loadFilteredData(filters, page = 1) {
            $('#dynamicLoader').css('display', 'block');

            filters.page = page;

            $.ajax({
                url: "{{ route('dynamic-stocksell') }}",
                method: 'GET',
                data: filters,
                success: function(response) {
                    $('#stocksaleOfferDynamic').html(response.html);
                    $('#paginationControls').html(response.pagination);
                    $('#dynamicLoader').css('display', 'none');
                    initializeIconCarousel();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    $('#dynamicLoader').css('display', 'none');
                }
            });
        };
    </script>
    <script>
        $('#inquiryForm').on('submit', function(e) {
            e.preventDefault();

            var formData = {
                sender_id: $('#sender_id').val(),
                sender_type: $('#sender_type').val(),
                receiver_id: $('#receiver_id').val(),
                receiver_type: $('#receiver_type').val(),
                type: $('#type').val(),
                stocksell_id: $('#stocksell_id').val(),
                email: $('#email').val(),
                message: $('#message').val(),
                _token: $('input[name="_token"]').val()
            };

            $.ajax({
                url: "{{ route('sendmessage.other') }}",
                type: 'POST',
                data: formData,
                success: function(response) {
                    toastr.success('Inquiry sent successfully!', 'Success');
                    $('#inquireButton').modal('hide');
                    $('#inquiryForm')[0].reset();
                },
                error: function(xhr) {
                    toastr.error('Failed to send inquiry.', 'Error');
                }
            });
        });
    </script>
    <script>
        function loadStockSellData(id) {
            $('#dynamicLoader').css('display', 'block');

            $.ajax({
                url: "{{ route('dynamic-stocksellview') }}",
                method: 'GET',
                data: {
                    'id': id,
                },
                success: function(response) {
                    $('#StockSellView').html(response.html);
                    initializeDetailCarousel();
                    $('#dynamicLoader').css('display', 'none');
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    $('#dynamicLoader').css('display', 'none');
                }
            });
        };
    </script>
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
@endpush
