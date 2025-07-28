@extends('layouts.front-end.app')
@section('title', translate('Buyers' . ' | ' . $web_config['name']->value))
@push('css_or_js')
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/ai/buyer.css') }}" />
@endpush
@section('content')
    <section class="mainpagesection buy-offer" style="margin-top: 30px; background-color: unset;">
        <div class="flex">
            <div class="sidebar">
                <div class="filter-sidebar">
                    <form method="GET" action="{{ route('buyer') }}" id="filterFormBuyer">
                         <div class="filter-section togglebelow768 d-flex justify-content-between pb-0 align-items-center" >
                            <div class="search-label w-50">Filter</div>
                            <a href="{{ request()->url() }}" class=" w-50 reset-filter" style="display: flex;  justify-content: right;">Reset Filters</a>
                        </div>
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
                       
                    </form>
                </div>
            </div>

            <!-- Main content column -->
            <div class="main-content">
                <div>
                    <div id="leads-container">
                        <!-- Lead cards will be dynamically inserted here -->
                        @include('leads.partials.dynamic-buyers')
                        <div id="paginationControls">
                            {{ $items->links('custom-paginator.custom') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom banner -->
        <div class="bottom-banner">
            <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/666290679db229039ce0c8d24be8ae4e66bd94f6?placeholderIfAbsent=true"
                alt="Advertisement banner">
        </div>
    </section>
@endsection
@push('script')
    <script src="{{ theme_asset('public/js/buyer.js') }}"></script>
    <script>
        function loadFilteredData(filters, page = 1) {
            $("#dynamicLoader").css("display", "block");

            filters.page = page;

            $.ajax({
                url: "{{ route('dynamic-leads') }}",
                method: "GET",
                data: filters,
                success: function(response) {
                    $("#dynamicBuyLeads").html(response.html);
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
