@extends('layouts.front-end.app')
@push('css_or_js')
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/ai/talentfinder.css') }}" />
@endpush
@section('title')
    Talent Finder | {{ $web_config['name']->value }}
@endsection
@section('content')
    <section class="mainpagesection talent-finder" style="background-color: unset;">
        <div class="container">
            <form method="GET" action="{{ route('talentfinder') }}" class="formleft" id="filterFormIndustryJobs">
                <!-- button for screen less than 1024 -->
                <div class="search-bar-wrapper-tab">
                    <div class="search-bar-tab">
                        <input type="text" class="search-input-tab" placeholder="Search by names...">
                        <button type="button" class="search-btn-tab">Search</button>
                    </div>
                    <button type="button" class="filter-btn" onclick="filterdrop()">Filters &#x2630;</button>
                </div>
                <!-- Left Sidebar -->
                <div class="sidebar" id="sidebarhidden">

                    <!-- Salary Range Filter -->
                    <div class="filter-section">
                        <h3>Salary Range</h3>
                        <div class="range-slider">
                            <div class="slider-track">
                                <div class="slider-fill"></div>
                                <div class="slider-thumb left"></div>
                                <div class="slider-thumb right"></div>
                            </div>
                            <div class="range-inputs">
                                <div class="range-input">
                                    <input type="text" value="0" id="min-salary">
                                    <span>USD</span>
                                </div>
                                <div class="range-input">
                                    <input type="text" value="20000000" id="max-salary">
                                    <span>USD</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <!-- Currency Filter -->
                    <div class="filter-section">
                        <h3>Filter Currency</h3>
                        <div class="search-box">
                            <input type="text" placeholder="Search Currency...">
                            <button><img src="/img/Magnifiying Glass.png" alt="Search"></button>
                        </div>
                        <div class="checkbox-list">
                            @foreach ($currencies as $currency)
                                <div class="checkbox-item">
                                    <input type="checkbox" id="currency-{{ $currency }}" name="currency[]"
                                        value="{{ $currency }}">
                                    <label for="currency-{{ $currency }}">{{ $currency }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="divider"></div>

                    <!-- Keywords Filter -->
                    <div class="filter-section">
                        <h3>Keywords</h3>
                        <div class="search-box">
                            <input type="text" placeholder="Search keywords...">
                            <button><img src="/img/Magnifiying Glass.png" alt="Search"></button>
                        </div>
                        <div class="checkbox-list">
                            @foreach ($keywords as $keyword)
                                <div class="checkbox-item">
                                    <input type="checkbox" id="keyword-{{ $keyword['slug'] }}" name="keywords[]"
                                        value="{{ $keyword['label'] }}">
                                    <label for="keyword-{{ $keyword['slug'] }}">{{ $keyword['label'] }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="divider"></div>

                    <!-- Job Type Filter -->
                    <div class="filter-section">
                        <h3>Job Type</h3>
                        <div class="checkbox-list">
                            <div class="checkbox-item">
                                <input type="checkbox" name="full-time">
                                <label for="full-time">Full-Time</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" name="part-time">
                                <label for="part-time">Part-Time</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" name="weekly">
                                <label for="weekly">Weekly</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" name="hourly">
                                <label for="hourly">Hourly</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" name="contract">
                                <label for="contract">Contract</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" name="freelancing">
                                <label for="freelancing">Freelancing</label>
                            </div>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <!-- Location Filter -->
                    <div class="filter-section">
                        <h3>Location</h3>
                        <div class="search-box">
                            <input type="text" placeholder="Search location...">
                            <button><img src="/img/Magnifiying Glass.png" alt="Search"></button>
                        </div>
                        <div class="checkbox-list">
                            @foreach ($countries as $country)
                                <div class="checkbox-item">
                                    <input type="checkbox" id="country-{{ Str::slug($country->name) }}" name="country[]"
                                        value="{{ $country->id }}">
                                    <label for="country-{{ Str::slug($country->name) }}">{{ $country->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="divider"></div>

                    <!-- Job Title Filter -->
                    <div class="filter-section">
                        <h3>Job Title</h3>
                        <div class="search-box">
                            <input type="text" placeholder="Search job title...">
                            <button><img src="/img/Magnifiying Glass.png" alt="Search"></button>
                        </div>
                        <div class="checkbox-list">
                            @foreach ($jobtitle as $title)
                                <div class="checkbox-item">
                                    <input type="checkbox" id="jobtitle-{{ Str::slug($title) }}" name="jobtitle[]"
                                        value="{{ $title }}">
                                    <label for="jobtitle-{{ Str::slug($title) }}">{{ $title }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="filter-section togglebelow768">
                        <a href="{{ request()->url() }}" class="btn btn-sm reset-filter">Reset Filters</a>
                    </div>
                </div>
            </form>
            <!-- Main Content -->
            <div class="main-content">
                <!-- Job Cards -->
                <div class="job-cards">
                    <div id="dynamicprofilescards">
                        @include('web.dynamic-partials.dynamic-talentfinder')
                    </div>
                    <div id="dynamicprofilemobcards">
                        @include('web.dynamic-partials.dynamic-mobtalentfinder')
                    </div>
                    <!-- Pagination -->
                    <div id="paginationControls">
                        {{ $items->links('custom-paginator.custom') }}
                    </div>
                </div>
            </div>
    </section>
@endsection
@push('script')
    <script src="{{ theme_asset(path: 'public/js/talentfinder.js') }}"></script>
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

            filters.page = page;

            $.ajax({
                url: "{{ route('dynamic-jobprofile') }}",
                method: "GET",
                data: filters,
                success: function(response) {
                    $("#dynamicprofilescards").html(response.html);
                    $("#dynamicprofilemobcards").html(response.mobhtml);
                    $("#paginationControls").html(response.pagination);
                    $("#dynamicLoader").css("display", "none");
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    $("#dynamicLoader").css("display", "none");
                },
            });
        }
        function sendtologin() {
            window.location.href = '/customer/auth/login';
        }
    </script>
@endpush
