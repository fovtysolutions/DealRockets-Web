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
    <link rel="stylesheet" href="{{theme_asset(path: 'public/assets/front-end/css/chatbot.css')}}" />
    <link rel="stylesheet" href="{{theme_asset(path: 'public/assets/front-end/css/chatbot-widget.css')}}" />
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/front-end/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/front-end/css/owl.theme.default.min.css') }}">
@endpush

@section('content')
    @php($decimalPointSettings = !empty(getWebConfig(name: 'decimal_point_settings')) ? getWebConfig(name:'decimal_point_settings') : 0)

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
    <div class="mainpagesection" style="background-color: var(--web-bg);">
        @include('web-views.partials._category-section-home')
    </div>
    @include('web-views.partials._genregroup')
    @include('web-views.partials._leads')
    @include('web-views.partials._registerforfree')
    @include('web-views.partials._quotation')
    @include('web-views.partials._multistuff1')
    @include('web-views.partials._multistuff')
    @include('web-views.partials._top-sellers')
    @include('web-views.partials._order-now')
    
    {{-- Chatbot Widget --}}
    @include('web-views.chatbot.widget')
    
    {{-- @if(!auth('customer')->check())
        <div class="modal fade" id="thankYouModal" tabindex="-1" aria-labelledby="thankYouModalLabel" aria-hidden="true"
            data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    @include('web-views.pages.landingpage')
                </div>
            </div>
        </div>
    @endif --}}
    <span id="direction-from-session" data-value="{{ session()->get('direction') }}"></span>
@endsection

@push('script')
    <script defer src="{{theme_asset(path: 'public/assets/front-end/js/owl.carousel.min.js')}}"></script>
    <script defer src="{{ theme_asset(path: 'public/assets/front-end/js/home.js') }}"></script>
    <script defer src="{{ theme_asset(path: 'public/assets/front-end/js/chatbot.js') }}"></script>
    <script defer>
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