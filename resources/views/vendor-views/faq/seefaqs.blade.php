@extends('layouts.back-end.app-partialseller')

@section('title', translate('FAQ'))

@push('css_or_js')
    <link rel="stylesheet" href="{{ asset('assets/custom-css/css-partials/faq.css') }}">
@endpush

@section('content')
    <div class="content container-fluid faqs">
        <div class="faq-container">
            <div class="faq-header">
                <h1>Frequently Asked Questions</h1>
                <p>Find answers to common questions about our services</p>

                <!-- Search Bar -->
                <div class="search-container">
                    <div class="search-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" id="searchInput" placeholder="Search questions...">
                        <button class="clear-search" title="Clear search">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>
                </div>

                <!-- Category Filter -->
                <div class="category-filter">
                    <button class="category-btn active" data-category="all">All</button>
                    @foreach ($vendorCategories as $key => $value)
                        <button class="category-btn" data-category="{{ $key }}">{{ $value }}</button>
                    @endforeach
                </div>
            </div>

            <div class="faq-content">
                @if (empty($faqs))
                    <h5> No FAQ's Added by Admin For this Category. Please Check Later. </h5>
                @endif
                @foreach ($vendorCategories as $key => $value)
                    <div class="faq-category" data-category="{{ $key }}">
                        <h2>{{ $value }} Questions</h2>

                        @php
                            $filteredFaqs = $faqs->where('sub_type', $key);
                        @endphp

                        @if ($filteredFaqs->isEmpty())
                            <p class="text-muted">No questions available in this category.</p>
                        @else
                            @foreach ($filteredFaqs as $item)
                                <div class="faq-item">
                                    <div class="faq-question">
                                        <h3>{{ $item->question }}</h3>
                                        <span class="faq-icon"><i class="fa-solid fa-plus"></i></span>
                                    </div>
                                    <div class="faq-answer">
                                        <p>{{ $item->answer }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('js/faqs.js') }}"></script>
@endpush
