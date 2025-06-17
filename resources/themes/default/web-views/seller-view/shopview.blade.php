@extends('layouts.front-end.app')
<link rel="stylesheet" href="{{ theme_asset('public/assets/custom-css/vendor.css') }}" />
@section('title', translate('shop_Page'))

@push('css_or_js')
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/ai/vendor-web.css') }}" />
    @if ($shopInfoArray['id'] != 0)
        <meta property="og:image" content="{{ $shopInfoArray['image_full_url']['path'] }}" />
        <meta property="og:title" content="{{ $shopInfoArray['name'] }} " />
        <meta property="og:url" content="{{ route('shopView', [$shopInfoArray['id']]) }}">
    @else
        <meta property="og:image" content="{{ $web_config['fav_icon']['path'] }}" />
        <meta property="og:title" content="{{ $shopInfoArray['name'] }} " />
        <meta property="og:url" content="{{ route('shopView', [$shopInfoArray['id']]) }}">
    @endif

    @if ($shopInfoArray['id'] != 0)
        <meta property="twitter:card" content="{{ $shopInfoArray['image_full_url']['path'] }}" />
        <meta property="twitter:title" content="{{ route('shopView', [$shopInfoArray['id']]) }}" />
        <meta property="twitter:url" content="{{ route('shopView', [$shopInfoArray['id']]) }}">
    @else
        <meta property="twitter:card" content="{{ $web_config['fav_icon']['path'] }}" />
        <meta property="twitter:title" content="{{ route('shopView', [$shopInfoArray['id']]) }}" />
        <meta property="twitter:url" content="{{ route('shopView', [$shopInfoArray['id']]) }}">
    @endif

    <meta property="og:description"
        content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)), 0, 160) }}">
    <meta property="twitter:description"
        content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)), 0, 160) }}">
@endpush

@section('content')

    @php
        $decimalPointSettings = getWebConfig(name: 'decimal_point_settings');
    @endphp

    <div class="main-container vender-company" style="margin-bottom: 20px;">
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                @if ($shopInfoArray['id'] != 0)
                    <img src="{{ getStorageImages(path: $shopInfoArray['image_full_url'], type: 'shop') }}" class="logo"
                        alt="Logo" />
                @else
                    @php
                        $banner = getWebConfig(name: 'shop_banner');
                    @endphp
                    <img src="{{ getStorageImages(path: $shopInfoArray['image_full_url'], type: 'shop') }}" class="logo"
                        alt="Logo" />
                @endif
                <div class="company-info">
                    <span class="company-title">
                        @if ($shopInfoArray['id'] != 0)
                            {{ $shopInfoArray['name'] }}
                        @else
                            {{ $web_config['name']->value }}
                        @endif
                    </span>
                    <p class="member"><img src="/img/Diamond.png" class="diamond">
                        @if ($shopInfoArray['id'] == 0)
                            Staff
                        @else
                            {{ $shopInfoArray['seller_details']->membership }}
                        @endif Member <span class="member2024" style="margin-top: 1px;"> Since
                            {{ $shopInfoArray['seller_details']->created_at->diffForHumans() }}</span>
                    </p>
                </div>
            </div>
            <div class="header-right">
                <input class="search-input" placeholder="Search for products..." />
                <button class="search-btn">Search</button>
                <!-- <button class="search-icon"><i class="fas fa-search"></i></button> -->

            </div>
            <div class="search-box">
                <button class="btn-search" onclick="toggleSearch()"><i class="fas fa-search"></i></button>
                <input type="text" class="input-search" placeholder="Type to Search...">
            </div>
            <div class="search-overlay" onclick="toggleSearch()"></div>

        </header>
        <script>
            function toggleSearch() {
                const searchBox = document.querySelector('.search-box');
                searchBox.classList.toggle('active');
            }
        </script>
        <!-- Navigation -->
        <div style="overflow: scroll;">
            <nav class="navbar">
                <a href="#" class="nav-item nav-active">Home</a>
                <div class="nav-item dropdown">
                    Products
                    <span class="chevron">&#9660;</span>
                </div>
                <a href="#" class="nav-item">Company Profile</a>
                <a href="#" class="nav-item">Contact Us</a>
            </nav>
        </div>
        <div class="section-1">
            @include('web-views.seller-view.partials._shop_section_1')
        </div>
        <div class="section-2 d-none">
            @include('web-views.seller-view.partials._shop_section_2')
        </div>
        <div class="section-3 d-none">
            @include('web-views.seller-view.partials._shop_section_3')
        </div>
        <div class="section-4 d-none">
            @include('web-views.seller-view.partials._shop_section_4')
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade vender-company" id="inquireModel" tabindex="-1" aria-labelledby="inquireModelLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: #EBEBEB;">
                    <h5 class="modal-title" id="inquireModelLabel">Send a direct inquiry to this supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form style="padding: 10px;">
                        <div class="mb-3">
                            <label for="company" class="form-label">To</label>
                            <input type="text" class="form-control" id="company" value="Wenzhou Ivspeed Co.,Ltd"
                                readonly>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail Address</label>
                            <input type="email" class="form-control" id="email"
                                placeholder="Please enter your business e-mail address">
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" rows="5"
                                placeholder="Enter product details such as color, size, materials and other specific requirements."></textarea>
                        </div>

                        <div style="display: flex; justify-content: end;">
                            <button type="submit" class="btn btn-red inquire-btn">Send Inquiry Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <span id="products-search-data-backup"
        data-url="{{ route('shopView', ['id' => $shopInfoArray['id'] != 0 ? $shopInfoArray['id'] : 0]) }}"
        data-brand="{{ $data['brand_id'] ?? '' }}" data-category="{{ $data['category_id'] ?? '' }}"
        data-name="{{ request('search') ?? request('name') }}" data-from="{{ request('data_from') }}"
        data-sort="{{ request('sort_by') }}" data-product-type="{{ request('product_type') ?? 'all' }}"
        data-message="{{ translate('items_found') }}" data-publishing-house-id="{{ request('publishing_house_id') }}"
        data-author-id="{{ request('author_id') }}"></span>
@endsection

@push('script')
    <script src="{{ theme_asset(path: 'public/assets/front-end/js/product-view.js') }}"></script>
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
        function sendtologin() {
            window.location.href = '/customer/auth/login';
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navItems = document.querySelectorAll('.navbar .nav-item');
            const sections = document.querySelectorAll('[class^="section-"]');

            navItems.forEach((item, index) => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Remove active class from all nav items
                    navItems.forEach(nav => nav.classList.remove('nav-active'));

                    // Add active class to clicked item
                    this.classList.add('nav-active');

                    // Hide all sections
                    sections.forEach(section => section.classList.add('d-none'));

                    // Show corresponding section (section-1, section-2, etc.)
                    const targetSection = document.querySelector(`.section-${index + 1}`);
                    if (targetSection) {
                        targetSection.classList.remove('d-none');
                    }
                });
            });
        });
    </script>
@endpush
