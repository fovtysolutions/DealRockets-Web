@extends('layouts.front-end.app')

@section('title', $web_config['name']->value . ' ' . translate('online_Shopping') . ' | ' . $web_config['name']->value . ' ' . translate('ecommerce'))
@push('css_or_js')
    <meta property="og:image" content="{{$imagegetsd['company_web_logo']}}" />
    <meta property="og:title" content="Welcome To {{$web_config['name']->value}} Home" />
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description"
        content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)), 0, 160) }}">

    <meta property="twitter:card" content="{{$imagegetsd['company_web_logo']}}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta property="twitter:title" content="Welcome To {{$web_config['name']->value}} Home" />
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description"
        content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)), 0, 160) }}">

    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/body.css')}}" />
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/popup.css')}}" />
    <link rel="stylesheet" href="{{theme_asset(path: 'public/assets/front-end/css/home.css')}}" />
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/front-end/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/front-end/css/owl.theme.default.min.css') }}">
@endpush

@section('content')
    @php($decimalPointSettings = !empty(getWebConfig(name: 'decimal_point_settings')) ? getWebConfig(name:'decimal_point_settings') : 0)

    @if($web_config['featured_deals'] && (count($web_config['featured_deals']) > 0))
        <section class="featured_deal">
            <div class="container">
                <div class="__featured-deal-wrap bg--light">
                    <div class="d-flex flex-wrap justify-content-between gap-8 mb-3">
                        <div class="w-0 flex-grow-1">
                            <span class="featured_deal_title font-bold text-dark">{{ translate('featured_deal')}}</span>
                            <br>
                            <span
                                class="text-left text-nowrap">{{ translate('see_the_latest_deals_and_exciting_new_offers')}}!</span>
                        </div>
                        <div>
                            <a class="text-capitalize view-all-text web-text-primary"
                                href="{{route('products', ['data_from' => 'featured_deal'])}}">
                                {{ translate('view_all')}}
                                <i
                                    class="czi-arrow-{{Session::get('direction') === 'rtl' ? 'left mr-1 ml-n1 mt-1' : 'right ml-1'}}"></i>
                            </a>
                        </div>
                    </div>
                    <div class="owl-carousel owl-theme new-arrivals-product">
                        @foreach($web_config['featured_deals'] as $key => $product)
                            @include('web-views.partials._product-card-1', ['product' => $product, 'decimal_point_settings' => $decimalPointSettings])
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if (isset($main_section_banner))
        <div class="container rtl pt-4 px-0 px-md-3">
            <a href="{{$main_section_banner->url}}" target="_blank" class="cursor-pointer d-block">
                <img class="d-block footer_banner_img __inline-63" alt=""
                    src="{{ getStorageImages(path: $main_section_banner->photo_full_url, type: 'wide-banner') }}">
            </a>
        </div>
    @endif

    @if(!empty($carouselimages))
        @include('web-views.partials._bannercarousel')
    @endif
    @include('web-views.partials._herobanner')
    {{-- @include('web-views.partials._trending-selection') --}}
    <div class="mainpagesection" style="background-color: var(--web-bg);">
        @include('web-views.partials._category-section-home')
    </div>
    @include('web-views.partials._genregroup')
    @include('web-views.partials._leads')
    @include('web-views.partials._registerforfree')
    @include('web-views.partials._quotation')
    {{-- @include('web-views.partials._multiboxes') --}}
    @include('web-views.partials._multistuff')
    {{-- @include('web-views.partials._suscribe') --}}
    @include('web-views.partials._top-sellers')
    @include('web-views.partials._order-now')
    {{-- @if ($bestSellProduct->count() > 0)
        @include('web-views.partials._best-selling')
    @endif --}}
    @php($businessMode = getWebConfig(name: 'business_mode'))

        <section class="new-arrival-section">

            <div class="mainpagesection shadow" style="max-width: 1600px; padding-left:0; padding-right:0; background-color: unset;">
                <div class="row g-3 mx-max-md-0">
                </div>
            </div>
        </section>

    @if(auth('customer')->check())
        {{-- Do Nothing --}}
    @else
        <div class="modal fade" id="thankYouModal" tabindex="-1" aria-labelledby="thankYouModalLabel" aria-hidden="true"
            data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    @include('web-views.pages.landingpage')
                </div>
            </div>
        </div>
    @endif
    <span id="direction-from-session" data-value="{{ session()->get('direction') }}"></span>
@endsection

@push('script')
    <script src="{{theme_asset(path: 'public/assets/front-end/js/owl.carousel.min.js')}}"></script>
    <script src="{{ theme_asset(path: 'public/assets/front-end/js/home.js') }}"></script>
    <script>
        $(document).ready(function () {
            const searchProductsBtn = $('#searchProducts');
            const searchSuppliersBtn = $('#searchSuppliers');
            const thankYouModalElement = $('#thankYouModal'); // Modal element
            const dropdown = $('#productDropdown'); // Dropdown element
            const defaultOption = dropdown.find('.default_option'); // Default option text
            const searchInput = $('#searchInput'); // Search input field

            // Function to handle search button clicks
            function handleSearchClick(event) {
                event.preventDefault();

                // Close the modal when clicking search buttons
                thankYouModalElement.modal('hide'); // Use jQuery to hide the modal

                // Determine which button was clicked and set the dropdown accordingly
                if ($(this).attr('id') === 'searchProducts') {
                    defaultOption.text("Products"); // Update the dropdown display text
                    searchInput.attr("placeholder", "Search for products..."); // Update the placeholder
                } else if ($(this).attr('id') === 'searchSuppliers') {
                    defaultOption.text("Suppliers"); // Update the dropdown display text
                    searchInput.attr("placeholder", "Search for suppliers..."); // Update the placeholder
                }

                // Optionally, focus on the search input field
                searchInput.focus();
            }

            function ScrollToPage() {
                thankYouModalElement.modal('hide');
                $('html,body').animate({
                    scrollTop:$('#sendcv').offset().top
                },500);
            }

            // Add event listeners for search buttons using jQuery
            searchProductsBtn.on('click', handleSearchClick);
            searchSuppliersBtn.on('click', handleSearchClick);
            // Event Listener for CV Post
            $('#cv_post').on('click',function(event){
                event.preventDefault();
                ScrollToPage();
            });
        });

        function loginmodel() {
            // Show the modal using jQuery
            $('#thankYouModal').modal({
                backdrop: true,
                keyboard: true
            }).modal('show'); // Show the modal
        }

        // Call the function to show the modal
        // loginmodel(); 
    </script>
@endpush