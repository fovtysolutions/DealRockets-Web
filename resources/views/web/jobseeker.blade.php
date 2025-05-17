@extends('layouts.front-end.app')
@push('css_or_js')
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/ai/candidatejobs.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush
@section('title', translate('Job Seeker' . ' | ' . $web_config['name']->value))
@section('content')
    <section class="mainpagesection candidate-jobs" style="background-color: unset;">
        <div class="jobs">
            <div class="container jobs">
                <form method="GET" action="{{ url()->current() }}" id="candidateJobsForm" class="leftdiv">
                    <div class="container  hide-header">
                        <div class=" p-2 py-3 px-3 rounded  shadow1 d-flex align-items-center justify-content-between">
                            <!-- Full version -->
                            <div class="search-full  flex-grow-1 align-items-center">
                                <div class="input-group rounded-pill border-gold overflow-hidden"
                                    style="max-width: 600px; height: 44px;">
                                    <input type="text" name="search_filter" class="form-control border-0 ps-3"
                                        placeholder="Search for jobs..." />
                                    <button type="button" class="btn btn-gold px-4">Search</button>
                                </div>
                            </div>
                            <!-- Compact version -->
                            <div class="search-compact align-items-center" style="width: 50%;">
                                <div class="d-flex align-items-center w-100 bg-white border px-3" style="height: 44px;">
                                    <img src="/img/Magnifiying Glass.png" alt="Search Icon" class="me-2"
                                        style="width: 20px;" />
                                    <input type="text" class="form-control border-0" style="height: 100%;"
                                        placeholder="Search by Name" style="box-shadow: none;" />
                                </div>
                            </div>
                            <!-- Filters Button -->
                            <button type="button"
                                class="btn btn-outline-light bg-white border ms-3 d-flex align-items-center "
                                style="color: var(--text-medium);" id="filtertoggle">
                                Filters&nbsp;<i class="bi bi-filter align-items-center h-75"
                                    style="font-size:22px; position: relative; top: 4px;"></i>
                            </button>

                        </div>
                    </div>
                    <div class="sidebar" id="sidebartoggle">

                        <!-- Salary Range -->
                        <div class="filter-section">
                            <h3>Salary Range</h3>
                            <div class="salary-slider">
                                <div class="salary-values">
                                    <label for="min_salary">Min Salary</label>
                                    <input id="min_salary" type="number" class="form-control" name="min_salary"
                                        value="{{ request('min_salary', 0) }}" min="0">

                                    <label for="max_salary">Max Salary</label>
                                    <input id="max_salary" class="form-control" type="number" name="max_salary"
                                        value="{{ request('max_salary', 100000000) }}" min="0">
                                </div>
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
                                        <input type="checkbox" id="currency_{{ $currency }}" name="currencies[]"
                                            value="{{ $currency }}"
                                            {{ in_array($currency, request()->get('currencies', [])) ? 'checked' : '' }}>
                                        <label for="currency_{{ $currency }}">{{ $currency }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Specialization Filter -->
                        <div class="filter-section">
                            <h3>Specialization</h3>
                            <div class="filter-options">
                                @foreach ($categories as $category)
                                    <div class="filter-option">
                                        <input type="checkbox" id="specialization_{{ $category->id }}"
                                            name="specializations[]" value="{{ $category->id }}"
                                            {{ in_array($category->id, request()->get('specializations', [])) ? 'checked' : '' }}>
                                        <label for="specialization_{{ $category->id }}">{{ $category->name }}
                                            {{-- <span class="count">(937)</span> --}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Job Type -->
                        <div class="filter-section">
                            <h3>Job Type</h3>
                            <div class="filter-options">
                                @foreach (['Permanent', 'Temporary', 'Contract', 'Full-Time', 'Part-Time', 'Work From Home'] as $type)
                                    <div class="filter-option">
                                        <input type="checkbox" id="job_type_{{ \Str::slug($type) }}" name="job_types[]"
                                            value="{{ $type }}"
                                            {{ in_array($type, request()->get('job_types', [])) ? 'checked' : '' }}>
                                        <label for="job_type_{{ \Str::slug($type) }}">{{ $type }}
                                            {{-- <span class="count">(500)</span> --}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Posted By -->
                        <div class="filter-section">
                            <h3>Posted By</h3>
                            <div class="filter-options">
                                @foreach (['Agency', 'Employer', 'Deal Rocket'] as $poster)
                                    <div class="filter-option">
                                        <input type="checkbox" id="posted_by_{{ \Str::slug($poster) }}" name="posted_by[]"
                                            value="{{ $poster }}"
                                            {{ in_array($poster, request()->get('posted_by', [])) ? 'checked' : '' }}>
                                        <label for="posted_by_{{ \Str::slug($poster) }}">{{ $poster }}
                                            {{-- <span class="count">(500)</span> --}}
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
                                <input id="min_experience" type="number" name="min_experience" class="form-control"
                                    min="0" placeholder="Min Experience"
                                    value="{{ request('min_experience', '') }}">

                                <label for="max_experience">Max Experience</label>
                                <input id="max_experience" type="number" name="max_experience" class="form-control"
                                    min="0" placeholder="Max Experience"
                                    value="{{ request('max_experience', '') }}">
                            </div>
                        </div>
                    </div>
                </form>

                <div class="d-flex rightdiv">
                    <div class="job-listings">
                        <div id="dynamic-jobvacancies" style="gap: 15px; display: flex; flex-direction: column;">
                            @include('web.dynamic-partials.dynamic-vacancies')
                        </div>
                    </div>
                    <div class="job-details-panel" id="dynamicvacanciesviews">
                        @include('web.dynamic-partials.dynamic-vacanciesview')
                    </div>
                </div>

            </div>
            <div id="paginationControls">
                {{ $jobseeker->links('custom-paginator.custom') }}
            </div>
        </div>
        @include('web.partials.applymodal')
    </section>
@endsection
@push('script')
    <script src="{{ asset('js/candidatejobs.js') }}"></script>
    <script>
        function loadFilteredData(filters, page = 1) {
            $("#dynamicLoader").css("display", "block");

            filters.page = page;

            $.ajax({
                url: "{{ route('dynamic-jobs') }}",
                method: "GET",
                data: filters,
                success: function(response) {
                    $("#dynamic-jobvacancies").html(response.html);
                    $("#paginationControls").html(response.pagination);
                    $("#dynamicLoader").css("display", "none");
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    $("#dynamicLoader").css("display", "none");
                },
            });
        }

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
                        btn.value = 'Saved'; // or change icon class
                    } else {
                        btn.value = 'Save';
                    }
                },
                error: function() {
                    toastr.Error('Something Went Wrong');
                }
            });
        }

        function sendtologin() {
            window.location.href = "/customer/auth/login";
        }
    </script>
@endpush
