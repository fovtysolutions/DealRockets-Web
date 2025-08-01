@extends('layouts.front-end.app')
@push('css_or_js')
    <link rel="stylesheet" href="{{ asset('assets/custom-css/ai/talentfinder.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/custom-css/ai/candidatejobs.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        /* Additional styles for better UX */
        .search-results-header {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
        

        
        .job-cards .job-card {
            display: flex;
            flex-direction: row;
            margin-bottom: 15px;
        }
        
        .job-cards .job-card .job-header {
            flex: 0 0 200px;
        }
        
        .job-cards .job-card .job-details {
            flex: 1;
            display: flex;
            flex-direction: row;
            align-items: center;
        }
        
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
        
        .no-data-message, .no-data-message-mobile {
            background: #f8f9fa;
            border-radius: 10px;
            margin: 20px 0;
        }
        
        .skill-tag {
            display: inline-block;
            background: #e9ecef;
            color: #495057;
            padding: 4px 8px;
            margin: 2px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .alert {
            border-radius: 8px;
        }
        
        .filter-section {
            margin-bottom: 20px;
        }
        
        .filter-section h3 {
            color: #333;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .search-box {
            position: relative;
            margin-bottom: 10px;
        }
        
        .search-box input {
            width: 100%;
            padding: 8px 35px 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .search-box i {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }
        
        @media (max-width: 768px) {
            .desktop-view {
                display: none !important;
            }
            
            .mobile-view {
                display: block !important;
            }
            
            .search-results-header .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
            }
        }
        
        @media (min-width: 769px) {
            .mobile-view {
                display: none !important;
            }
            
            .desktop-view {
                display: block !important;
            }
        }
    </style>
@endpush
@section('title')
    Talent Finder | {{ $web_config['name']->value }}
@endsection
@section('content')
    <section class="mainpagesection talent-finder candidate-jobs" style="background-color: unset;">
        <div class="jobs">
            <div class="container jobs">
            <form method="GET" action="{{ route('talentfinder') }}" class="formleft" id="filterFormIndustryJobs">
                <!-- Hidden search filter input for AJAX -->
                <input type="hidden" name="search_filter" id="search_filter" value="{{ request('search_filter', '') }}">
                
                <!-- button for screen less than 1024 -->
                <div class="search-bar-wrapper-tab">
                    <div class="search-bar-tab">
                        <input type="text" class="search-input-tab" name="search_filter_tab" placeholder="Search by names..." value="{{ request('search_filter', '') }}">
                        <button type="button" class="search-btn-tab" onclick="performSearch()">Search</button>
                    </div>
                    <button type="button" class="filter-btn" onclick="filterdrop()">Filters &#x2630;</button>
                </div>
                <!-- Left Sidebar -->
                <div class="sidebar" id="sidebarhidden">
                    <div class="d-flex justify-content-between pb-0 filter-section">
                        <h3>Filter</h3>
                        <div class="filter-section togglebelow768 p-0 ">
                            <a href="{{ request()->url() }}" class=" reset-filter background-none"
                                style=" color:#BF9E66">Reset Filters</a>
                        </div>
                    </div>

                    <!-- Salary Range Filter -->
                    <div class="salary-slider-wrapper filter-section" style="padding-top: 0px;">
                        <h3 class="mb-0">Salary Range</h3>
                        <!-- Hidden inputs for salary range -->
                        <input type="hidden" name="min_salary" id="min_salary" value="{{ request('min_salary', 0) }}">
                        <input type="hidden" name="max_salary" id="max_salary" value="{{ request('max_salary', 100000) }}">
                        
                        <div class="salary-slider-range">
                            <div class="salary-slider-track"></div>
                            <input type="range" min="0" max="100000" value="{{ request('min_salary', 0) }}" id="slider-1"
                                oninput="slideOne()" />
                            <input type="range" min="0" max="100000" value="{{ request('max_salary', 100000) }}" id="slider-2"
                                oninput="slideTwo()" />
                        </div>
                        <div class="salary-values-display d-flex justify-content-between align-items-center">
                            <span id="range1" class="W-100 col-5">{{ request('min_salary', 0) }}</span>
                            <span class="col-1"> &dash; </span>
                            <span class="col-5" id="range2" class="W-100">{{ request('max_salary', 100000) }}</span>
                        </div>
                    </div>

                    <!-- Currency Filter -->
                    <div class="filter-section">
                        <h3>Filter Currency</h3>
                        <div class="search-box">
                            <input type="text" placeholder="Search currency">
                            <i class="fas fa-search"></i>
                        </div>
                        <div class="currency-options">
                            @foreach ($currencies as $currency)
                                <div class="currency-option">
                                    <label class="filter-item">
                                        <input type="checkbox" id="currency_{{ $currency }}" name="currencies[]"
                                            value="{{ $currency }}"
                                            {{ in_array($currency, request()->get('currencies', [])) ? 'checked' : '' }}>
                                        <label for="currency_{{ $currency }}">{{ $currency }}</label>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Keywords Filter -->
                    <div class="filter-section">
                        <h3>Skills/Keywords</h3>
                        <div class="search-box">
                            <input type="text" placeholder="Search skills">
                            <i class="fas fa-search"></i>
                        </div>
                        <div class="filter-options">
                            @foreach ($keywords as $keyword)
                                <div class="filter-option">
                                    <label class="filter-item">
                                        <input type="checkbox" id="keyword_{{ $keyword['slug'] }}" name="keywords[]"
                                            value="{{ $keyword['label'] }}"
                                            {{ in_array($keyword['label'], request()->get('keywords', [])) ? 'checked' : '' }}>
                                        <label for="keyword_{{ $keyword['slug'] }}">{{ $keyword['label'] }}</label>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Job Type Filter -->
                    <div class="filter-section">
                        <h3>Job Type</h3>
                        <div class="search-box">
                            <input type="text" placeholder="Search job type">
                            <i class="fas fa-search"></i>
                        </div>
                        <div class="filter-options">
                            @foreach (['Full-Time', 'Part-Time', 'Contract', 'Freelancing', 'Hourly', 'Weekly'] as $type)
                                <div class="filter-option">
                                    <label class="filter-item">
                                        <input type="checkbox" id="job_type_{{ \Str::slug($type) }}" name="job_types[]"
                                            value="{{ $type }}"
                                            {{ in_array($type, request()->get('job_types', [])) ? 'checked' : '' }}>
                                        <label for="job_type_{{ \Str::slug($type) }}">{{ $type }}</label>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Location Filter -->
                    <div class="filter-section">
                        <h3>Location</h3>
                        <div class="search-box">
                            <input type="text" placeholder="Search location">
                            <i class="fas fa-search"></i>
                        </div>
                        <div class="filter-options">
                            @foreach ($countries as $country)
                                @php
                                    $countryDetails = \App\Utils\ChatManager::getCountryDetails($country);
                                    $isSelected =
                                        is_array(request()->input('country', [])) &&
                                        in_array($country, request()->input('country', []));
                                @endphp
                                <div class="filter-option">
                                    <label class="filter-item">
                                        <input type="checkbox" name="country[]" value="{{ $country['id'] }}"
                                                {{ $isSelected ? 'checked' : '' }} />
                                        <img src="/flags/{{ strtolower($country['iso2']) }}.svg"
                                                class="flag-icon" alt="flag" style="width: 25px;"/>    
                                        <label for="country_{{ $country['name'] }}">{{ $country['name'] }}</label>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Job Title Filter -->
                    <div class="filter-section">
                        <h3>Job Title</h3>
                        <div class="search-box">
                            <input type="text" placeholder="Search job title">
                            <i class="fas fa-search"></i>
                        </div>
                        <div class="filter-options">
                            @foreach ($jobtitle as $title)
                                <div class="filter-option">
                                    <label class="filter-item">
                                        <input type="checkbox" id="jobtitle_{{ \Str::slug($title) }}" name="jobtitles[]"
                                            value="{{ $title }}"
                                            {{ in_array($title, request()->get('jobtitles', [])) ? 'checked' : '' }}>
                                        <label for="jobtitle_{{ \Str::slug($title) }}">{{ $title }}</label>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Experience Level (min and max) -->
                    <div class="filter-section">
                        <h3>Experience Level (Years)</h3>
                        <div class="experience-range">
                            <label for="min_experience">Min Experience</label>
                            <input id="min_experience" type="number" name="min_experience"
                                class="form-control mb-2" min="0" placeholder="Min Experience"
                                value="{{ request('min_experience', '') }}">

                            <label for="max_experience">Max Experience</label>
                            <input id="max_experience" type="number" name="max_experience"
                                class="form-control mb-1" min="0" placeholder="Max Experience"
                                value="{{ request('max_experience', '') }}">
                        </div>
                    </div>
                </div>
            </form>
            <!-- Main Content -->
            <div class="main-content">
                <!-- Loading Indicator -->
                <div id="dynamicLoader" style="display: none; text-align: center; padding: 50px;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-3">Loading talent profiles...</p>
                </div>
                
                <!-- Search Results Header -->
                <!-- <div class="search-results-header" style="margin-bottom: 20px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4>Talent Profiles</h4>
                            <p class="text-muted mb-0" id="resultsCount">
                                @if($items->total() > 0)
                                    Showing {{ $items->firstItem() }} - {{ $items->lastItem() }} of {{ $items->total() }} profiles
                                @else
                                    No profiles found
                                @endif
                            </p>
                        </div>

                    </div>
                </div> -->

                <!-- Job Cards -->
                <div class="job-cards list-view">
                    <div id="dynamicprofilescards" class="desktop-view">
                        @include('web.dynamic-partials.dynamic-talentfinder')
                    </div>
                    <div id="dynamicprofilemobcards" class="mobile-view d-block d-md-none">
                        @include('web.dynamic-partials.dynamic-mobtalentfinder')
                    </div>
                    <!-- Pagination -->
                    <div id="paginationControls">
                        @if($items->hasPages())
                            {{ $items->links('custom-paginator.custom') }}
                        @endif
                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script src="{{ asset('js/talentfinder.js') }}"></script>
    <script>
        function triggerChat() {
            var _token = $('input[name="_token"]').val()

            var formData = {
                sender_id: $('#sender_id').val(),
                sender_type: $('#sender_type').val(),
                receiver_id: $('#receiver_id').val(),
                receiver_type: $('#receiver_type').val(),
                type: $('#type').val(),
                message: $('#message').val()
            };

            $.ajax({
                url: "{{ route('sendmessage.other') }}",
                type: 'POST',
                data: JSON.stringify(formData),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': _token,
                },
                success: function(response) {
                    toastr.success('Inquiry sent successfully!', 'Success');
                    window.location.reload();
                },
                error: function(xhr) {
                    toastr.error('Failed to send inquiry.', 'Error');
                }
            });
        }
    </script>
    <script>
        function loadFilteredData(filters, page = 1) {
            $("#dynamicLoader").css("display", "block");
            
            // Hide content while loading
            $("#dynamicprofilescards").css("opacity", "0.5");
            $("#dynamicprofilemobcards").css("opacity", "0.5");

            filters.page = page;

            $.ajax({
                url: "{{ route('dynamic-jobprofile') }}",
                method: "GET",
                data: filters,
                timeout: 30000, // 30 second timeout
                success: function(response) {
                    if (response.html && response.mobhtml) {
                        $("#dynamicprofilescards").html(response.html);
                        $("#dynamicprofilemobcards").html(response.mobhtml);
                        $("#paginationControls").html(response.pagination);
                        
                        // Update results count
                        if (response.total !== undefined) {
                            const start = ((response.current_page - 1) * 6) + 1;
                            const end = Math.min(response.current_page * 6, response.total);
                            
                            if (response.total > 0) {
                                $("#resultsCount").text(`Showing ${start} - ${end} of ${response.total} profiles`);
                            } else {
                                $("#resultsCount").text("No profiles found");
                            }
                        }
                        
                        // Restore opacity
                        $("#dynamicprofilescards").css("opacity", "1");
                        $("#dynamicprofilemobcards").css("opacity", "1");
                        
                        // Show success message for filters applied
                        if (Object.keys(filters).some(key => filters[key] && filters[key].length > 0 && key !== 'page')) {
                            toastr.success('Filters applied successfully!', 'Success');
                        }
                    } else {
                        throw new Error('Invalid response format');
                    }
                    
                    $("#dynamicLoader").css("display", "none");
                },
                error: function(xhr, status, error) {
                    console.error("Error loading data:", error);
                    $("#dynamicLoader").css("display", "none");
                    
                    // Restore opacity
                    $("#dynamicprofilescards").css("opacity", "1");
                    $("#dynamicprofilemobcards").css("opacity", "1");
                    
                    // Show error message
                    let errorMessage = "Failed to load talent profiles. Please try again.";
                    
                    if (status === 'timeout') {
                        errorMessage = "Request timed out. Please check your connection and try again.";
                    } else if (xhr.status === 500) {
                        errorMessage = "Server error occurred. Please try again later.";
                    } else if (xhr.status === 404) {
                        errorMessage = "Service not found. Please contact support.";
                    }
                    
                    // Show error in the content area
                    const errorHtml = `
                        <div class="alert alert-danger text-center" style="margin: 50px 20px;">
                            <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                            <h4>Oops! Something went wrong</h4>
                            <p>${errorMessage}</p>
                            <button class="btn btn-primary" onclick="location.reload()">Refresh Page</button>
                        </div>
                    `;
                    
                    $("#dynamicprofilescards").html(errorHtml);
                    $("#dynamicprofilemobcards").html(errorHtml);
                    
                    if (typeof toastr !== 'undefined') {
                        toastr.error(errorMessage, 'Error');
                    }
                },
            });
        }
        function sendtologin() {
            window.location.href = '/customer/auth/login';
        }

        // Additional functionality for better UX
        $(document).ready(function() {
            // Initialize tooltips if Bootstrap is available
            if (typeof $().tooltip === 'function') {
                $('[data-toggle="tooltip"]').tooltip();
            }



            // Handle search input on Enter key
            $('.search-input-tab').on('keypress', function(e) {
                if (e.which === 13) { // Enter key
                    e.preventDefault();
                    performSearch();
                }
            });

            // Auto-save search term as user types (debounced)
            let searchTimeout;
            $('.search-input-tab').on('input', function() {
                clearTimeout(searchTimeout);
                const searchValue = $(this).val();
                
                searchTimeout = setTimeout(function() {
                    $('#search_filter').val(searchValue);
                    if (searchValue.length >= 3 || searchValue.length === 0) {
                        applyFilters(1);
                    }
                }, 1000); // Wait 1 second after user stops typing
            });

            // Handle filter reset
            $('.reset-filter').on('click', function(e) {
                e.preventDefault();
                
                // Reset all form inputs
                $('#filterFormIndustryJobs')[0].reset();
                
                // Reset sliders
                $('#slider-1').val(0);
                $('#slider-2').val(100000);
                $('#min_salary').val(0);
                $('#max_salary').val(100000);
                $('#range1').text('0');
                $('#range2').text('100000');
                
                // Reset search
                $('.search-input-tab').val('');
                $('#search_filter').val('');
                
                // Apply filters (which will be empty, showing all results)
                applyFilters(1);
                
                if (typeof toastr !== 'undefined') {
                    toastr.info('All filters have been reset', 'Filters Reset');
                }
            });

            // Handle pagination clicks with smooth scrolling
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                
                const page = $(this).attr('href').split('page=')[1];
                if (page) {
                    // Scroll to top of results
                    $('html, body').animate({
                        scrollTop: $('.main-content').offset().top - 100
                    }, 500);
                    
                    // Get current filters and apply with new page
                    const form = document.getElementById("filterFormIndustryJobs");
                    let filters = {
                        search_filter: form.querySelector("input[name='search_filter']")?.value || "",
                        min_salary: form.querySelector("#min_salary")?.value || 0,
                        max_salary: form.querySelector("#max_salary")?.value || 100000,
                        currencies: Array.from(form.querySelectorAll('input[name="currencies[]"]:checked')).map(cb => cb.value),
                        keywords: Array.from(form.querySelectorAll('input[name="keywords[]"]:checked')).map(cb => cb.value),
                        job_types: Array.from(form.querySelectorAll('input[name="job_types[]"]:checked')).map(cb => cb.value),
                        countries: Array.from(form.querySelectorAll('input[name="countries[]"]:checked')).map(cb => cb.value),
                        jobtitles: Array.from(form.querySelectorAll('input[name="jobtitles[]"]:checked')).map(cb => cb.value),
                        min_experience: form.querySelector("input[name='min_experience']")?.value || "",
                        max_experience: form.querySelector("input[name='max_experience']")?.value || "",
                    };
                    
                    loadFilteredData(filters, page);
                }
            });

            // Initialize with current filters on page load
            if (window.location.search) {
                // If there are URL parameters, apply them as filters
                setTimeout(function() {
                    applyFilters(1);
                }, 500);
            }
        });
    </script>
    <script>
        window.onload = function() {
            slideOne();
            slideTwo();
        };

        let sliderOne = document.getElementById("slider-1");
        let sliderTwo = document.getElementById("slider-2");
        let displayValOne = document.getElementById("range1");
        let displayValTwo = document.getElementById("range2");
        let sliderTrack = document.querySelector(".salary-slider-track");
        let sliderMaxValue = sliderOne.max;
        let minGap = 0;

        function slideOne() {
            if (parseInt(sliderTwo.value) - parseInt(sliderOne.value) <= minGap) {
                sliderOne.value = parseInt(sliderTwo.value) - minGap;
            }
            displayValOne.textContent = sliderOne.value;
            
            // Update hidden input
            document.getElementById('min_salary').value = sliderOne.value;
            
            fillColor();
            
            // Trigger filtering when slider changes
            if (typeof applyFilters === 'function') {
                applyFilters();
            }
        }

        function slideTwo() {
            if (parseInt(sliderTwo.value) - parseInt(sliderOne.value) <= minGap) {
                sliderTwo.value = parseInt(sliderOne.value) + minGap;
            }
            displayValTwo.textContent = sliderTwo.value;
            
            // Update hidden input
            document.getElementById('max_salary').value = sliderTwo.value;
            fillColor();
            
            // Trigger filtering when slider changes
            if (typeof applyFilters === 'function') {
                applyFilters();
            }
        }

        function fillColor() {
            let percent1 = (sliderOne.value / sliderMaxValue) * 100;
            let percent2 = (sliderTwo.value / sliderMaxValue) * 100;
            sliderTrack.style.background =
                `linear-gradient(to right, #dadae5 ${percent1}% , #BF9E66 ${percent1}% , #BF9E66 ${percent2}%, #dadae5 ${percent2}%)`;
        }
    </script>
@endpush
