@php($announcement = getWebConfig(name: 'announcement'))
<?php
$colorSetting = App\Models\BusinessSetting::where('type', 'colorsu')->first();
$hovercolor = $colorSetting ? json_decode($colorSetting->value, true)['hovercolor'] : '#FFFFFF';
$textcolor = App\Utils\ChatManager::getTextColorBasedOnBackground($hovercolor);
?>
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/style.css') }}" />
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400&display=swap" rel="stylesheet">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/body.css') }}" />
<style>
    @media (max-width: 400px) {
        .navbaricons {
            margin: 12px !important;
        }

        .inquiry-cart-label {
            font-size: 12px;
        }
    }

    @media (max-width: 768px) {
        .navbaricons {
            margin: 20px;
        }
    }

    @media (max-width: 768px) {
        .navbaricons {
            margin: 20px;
        }
    }

    @media (min-width: 768px) {
        .navbar-expand-md {
            justify-content: space-between;
        }

        .width {
            max-width: 61% !important;
        }
    }

    @media (min-width: 1200px) {
        .navbariconscontainer {
            flex-direction: row;
            gap: 10px
        }

        .inquiry-cart-label {
            font-size: 16px;
        }
    }

    .navbar-expand-md {
        justify-content: center;
    }
</style>
@if (isset($announcement) && $announcement['status'] == 1)
    <div class="text-center position-relative px-4 py-1" id="announcement"
        style="background-color: {{ $announcement['color'] }}; color: {{ $announcement['text_color'] }};">
        <span>{{ $announcement['announcement'] }} </span>
        <span class="__close-announcement web-announcement-slideUp">X</span>
    </div>
@endif

<?php
$categories = App\Utils\CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
$unread = App\Utils\ChatManager::unread_messages();
$userId = Auth::guard('customer')->user() ? Auth::guard('customer')->id() : 0;
$role = App\Models\User::where('id', $userId)->first();
$is_jobadder = $role['typerole'] === 'findtalent' ? true : false;
?>

<div>
    <div class="header_free_details">
        <marquee behavior="" direction="">Free Shipping Sitewide on Every Order, Don’t Miss Out!!</marquee>
    </div>
    <div class="d-flex bg-dark align-items-center px-3 justify-content-between">
        <div class=" text-white">
            <p class="text-uppercase m-0 p-1 fw-semibold fs-5"><span class="" style="margin-right: 10px;"><i
                        class="fa-solid fa-location-dot"></i></span>Track
                Your Order</p>
        </div>
        @if (!auth('customer')->check())
            <div class="text-white">
                <div>
                    <p class="m-0 p-1" style="font-size: 12px;">
                        <a href="{{ route('customer.auth.login') }}" class="text-white">
                            <span>lOG IN</span>
                        </a> |
                        <a href="{{ route('customer.auth.sign-up') }}" class="text-white">
                            <span>SIGN UP</span>
                        </a>
                    </p>
                </div>
            </div>
        @else
            <div class="dropdown" id="profileDropdownContainer">
                <a class="text-white dropdown-toggle" href="#" id="profileDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                    <span>PROFILE</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'start' : 'end' }}"
                    aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item" href="{{ route('account-oder') }}">{{ translate('my_Order') }}</a></li>
                    <li><a class="dropdown-item" href="{{ route('user-account') }}">{{ translate('my_Profile') }}</a>
                    </li>
                    @if ($is_jobadder === true)
                        <li><a class="dropdown-item" href="{{ route('job-panel') }}">{{ translate('job_Panel') }}</a>
                        </li>
                    @endif
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item"
                            href="{{ route('customer.auth.logout') }}">{{ translate('logout') }}</a></li>
                </ul>
            </div>
        @endif
    </div>
    <div class="d-flex align-items-center justify-content-between px-3 py-2"
        style="background-color: var(--web-hover);">
        <div class="d-flex align-items-center">
            <a class="navbar-brand d-sm-none" href="{{ route('home') }}">
                <img class="mobile-logo-img __inline-12" style="max-width:100%"
                    src="{{ getStorageImages(path: $web_config['mob_logo'], type: 'logo') }}"
                    alt="{{ $web_config['name']->value }}" />
            </a>
            <a class="navbar-brand d-none d-sm-block flex-shrink-0" href="{{ route('home') }}">
                <img class="navbarbrandnew" src="{{ getStorageImages(path: $web_config['web_logo'], type: 'logo') }}"
                    alt="{{ $web_config['name']->value }}">
            </a>
        </div>
        <div class="All-Category">
            <ul class="d-flex m-0 gap-5 fs-6 fw-semibold" style="list-style: none;">
                <li class="Men">
                    <div class="custom-dropdown">
                        <div class="dropdown-trigger" style="color: {{ $textcolor }}">
                            All Categories
                            {{-- <span class="arrow">&#9662;</span> --}}
                        </div>
                        <div class="dropdown-menu">
                            @foreach ($categories->chunk(10) as $chunk)
                                <div class="column">
                                    @foreach ($chunk as $category)
                                        <a class="dropdown-item"
                                            href="{{ route('products', ['category_id' => $category['id'], 'data_from' => 'category', 'page' => 1]) }}">
                                            {{ $category->name }}
                                        </a>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </li>
                @php($businessMode = getWebConfig(name: 'business_mode'))
                <li class="Men" style="color: {{ $textcolor }} !important;">
                    @if (auth('customer')->check())
                <li class="nav-item d-md-none">
                    <a href="{{ route('user-account') }}" class="nav-linknew ">
                        {{ translate('user_profile') }}
                    </a>
                </li>
                <li class="nav-item d-md-none">
                    <a href="{{ route('wishlists') }}" class="nav-linknew">
                        {{ translate('Wishlist') }}
                    </a>
                </li>
            @else
                <li class="nav-item d-md-none">
                    <a class="dropdown-item pl-2" href="{{ route('customer.auth.login') }}">
                        <i class="fa fa-sign-in mr-2"></i> {{ translate('sign_in') }}
                    </a>
                    <div class="dropdown-divider"></div>
                </li>
                <li class="nav-item d-md-none">
                    <a class="dropdown-item pl-2" href="{{ route('customer.auth.sign-up') }}">
                        <i class="fa fa-user-circle mr-2"></i>{{ translate('sign_up') }}
                    </a>
                </li>
                @endif
                </li>
                <li>
                    @if ($businessMode == 'multi')
                        @if (getWebConfig(name: 'seller_registration'))
                <li class="Men">
                    <div class="dropdown">
                        <a class="nav-linknew dropdown-toggle" href="#" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            style="color: {{ $textcolor }} !important;">
                            {{ translate('vendor_zone') }}
                        </a>
                        <div class="dropdown-menu __dropdown-menu-3 __min-w-165px text-align-direction"
                            aria-labelledby="dropdownMenuButton"
                            style="position: absolute; background-color: white; z-index: 1000; left: 0; top: 100%; 
                                                                                                                                            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); width: auto; min-width: 165px;">
                            <a class="dropdown-item text-nowrap  " style="font-size: 14px; color: var(--web-text);"
                                href="{{ route('vendor.auth.registration.index') }}">
                                {{ translate('become_a_vendor') }}
                            </a>

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item text-nowrap" href="{{ route('vendor.auth.login') }}"
                                style="font-size: 14px; color: var(--web-text)">
                                {{ translate('vendor_login') }}
                            </a>
                        </div>
                    </div>
                </li>
                @endif
                @endif
                </li>
                <li class="Men">
                    <a style="color: {{ $textcolor }} !important;" href="{{ route('stocksale') }}"
                        class="nav-linknew">
                        Stock Sale
                    </a>
                </li>
                <li class="Men">
                    <a style="color: {{ $textcolor }} !important;" href="{{ route('buyer') }}"
                        class="nav-linknew">
                        Buy Leads
                    </a>
                </li>
                <li class="Men">
                    <a style="color: {{ $textcolor }} !important;" href="{{ route('seller') }}"
                        class="nav-linknew">
                        Sell Leads
                    </a>
                </li>
                <li class="Men">
                    <a style="color: {{ $textcolor }} !important;" class="nav-linknew"
                        href="{{ route('dealassist') }}">
                        Deal Assist
                    </a>
                </li>
                <li class="Men">
                    <a style="color: {{ $textcolor }} !important;" href="{{ route('tradeshow') }}"
                        class="nav-linknew">
                        Trade Shows
                    </a>
                </li>
                <li class="Men">
                    <a style="color: {{ $textcolor }} !important;" href="{{ route('sendcv') }}"
                        class="nav-linknew">
                        CV Submit
                    </a>
                </li>
                <li class="Men">
                    <a href="{{ route('membership') }}" style="color: {{ $textcolor }} !important;"
                        class="nav-linknew">
                        Membership
                    </a>
                </li>
                <li class="Men dropdown">
                    <a style="color: {{ $textcolor }} !important;"
                        class="nav-linknew text-capitalize dropdown-toggle " href="#" data-toggle="dropdown">
                        @foreach (json_decode($language['value'], true) as $data)
                            @if ($data['code'] == getDefaultLanguage())
                                {{ $data['name'] }}
                            @endif
                        @endforeach
                    </a>
                    <ul class="text-align-direction text-capitalize dropdown-menu __dropdown-menu-sizing dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'right' : 'left' }}"
                        style="font-size: 14px; color: black;">
                        @foreach (json_decode($language['value'], true) as $key => $data)
                            @if ($data['status'] == 1)
                                <li class="change-language __inline-17" data-action="{{ route('change-language') }}"
                                    data-language-code="{{ $data['code'] }}">
                                    <a class="dropdown-item" href="javascript:">
                                        <span class=""
                                            style="color:var(--web-text);">{{ $data['name'] }}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
                @if (auth('customer')->check())
                    <div class="logout-btn mt-auto d-md-none">
                        <hr>
                        <a href="{{ route('customer.auth.logout') }}" class="Men">
                            <strong class="text-base">{{ translate('logout') }}</strong>
                        </a>
                    </div>
                @endif
            </ul>
        </div>
        <div class="d-flex gap-2">
            <button style="color: {{ $textcolor }} !important;" class="search_glass border-0  bg-transparent fs-5"
                onclick="myFunction()"><i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <button class="border-0 bg-transparent fs-5" data-bs-toggle="modal" data-bs-target="#exampleModal"
                data-bs-toggle="tooltip" data-bs-placement="top" title="RFQ">
                <a href="{{ route('quotationweb') }}" style="color: {{ $textcolor }} !important;">
                    <i class="fa-solid fa-bullseye"></i>
                </a>
            </button>
            @if (auth('customer')->check())
                <button class="border-0 bg-transparent fs-5" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Message">
                    <a href="/chat/vendor" style="color: {{ $textcolor }} !important;">
                        <span class="chat-unread" style="z-index: 0;">{{ $unread }}</span>
                        <i class="fa-solid fa-message"></i>
                    </a>
                </button>
            @else
                <button class="border-0 bg-transparent fs-5" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Message">
                    <a href="{{ route('customer.auth.login') }}" style="color: {{ $textcolor }} !important;">
                        <i class="fa-solid fa-message"></i>
                    </a>
                </button>
            @endif
            @include('layouts.front-end.partials._cart')
            {{-- <button class="border-0 bg-transparent fs-5" data-bs-toggle="tooltip" data-bs-placement="top"
                title="Cart">
                <i class="fa-solid fa-cart-shopping"></i>
            </button> --}}
            <button id="showNavbar" class="humburger border-0  bg-transparent fs-5"><i
                    class="fa-solid fa-bars"></i></button>
            <div id="categoryDropdown" class="all-category-dropdown" style="display: none;">
                <ul class="m-0 gap-5 fs-6 fw-semibold" style="list-style: none;">
                    @php($businessMode = getWebConfig(name: 'business_mode'))
                    <li class="Men" style="color: {{ $textcolor }} !important;">
                        @if (auth('customer')->check())
                    <li class="nav-item d-md-none">
                        <a href="{{ route('user-account') }}" class="nav-linknew ">
                            {{ translate('user_profile') }}
                        </a>
                    </li>
                    <li class="nav-item d-md-none">
                        <a href="{{ route('wishlists') }}" class="nav-linknew">
                            {{ translate('Wishlist') }}
                        </a>
                    </li>
                @else
                    <li class="nav-item d-md-none">
                        <a class="dropdown-item pl-2" href="{{ route('customer.auth.login') }}">
                            <i class="fa fa-sign-in mr-2"></i> {{ translate('sign_in') }}
                        </a>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="dropdown-item pl-2" href="{{ route('customer.auth.sign-up') }}">
                            <i class="fa fa-user-circle mr-2"></i>{{ translate('sign_up') }}
                        </a>
                    </li>
                    @endif
                    </li>
                    <li>
                        @if ($businessMode == 'multi')
                            @if (getWebConfig(name: 'seller_registration'))
                    <li class="Men">
                        <div class="dropdown">
                            <a class="nav-linknew dropdown-toggle" href="#" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" style="color: {{ $textcolor }} !important;">
                                {{ translate('vendor_zone') }}
                            </a>
                            <div class="dropdown-menu __dropdown-menu-3 __min-w-165px text-align-direction"
                                aria-labelledby="dropdownMenuButton"
                                style="position: absolute; background-color: white; z-index: 1000; left: 0; top: 100%; 
                                                                                                                                                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); width: auto; min-width: 165px;">
                                <a class="dropdown-item text-nowrap  "
                                    style="font-size: 14px; color: var(--web-text);"
                                    href="{{ route('vendor.auth.registration.index') }}">
                                    {{ translate('become_a_vendor') }}
                                </a>

                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item text-nowrap" href="{{ route('vendor.auth.login') }}"
                                    style="font-size: 14px; color: var(--web-text)">
                                    {{ translate('vendor_login') }}
                                </a>
                            </div>
                        </div>
                    </li>
                    @endif
                    @endif
                    </li>
                    <li class="Men">
                        <a style="color: {{ $textcolor }} !important;" href="{{ route('stocksale') }}"
                            class="nav-linknew">
                            Stock Sale
                        </a>
                    </li>
                    <li class="Men">
                        <a style="color: {{ $textcolor }} !important;" href="{{ route('buyer') }}"
                            class="nav-linknew">
                            Buy Leads
                        </a>
                    </li>
                    <li class="Men">
                        <a style="color: {{ $textcolor }} !important;" href="{{ route('seller') }}"
                            class="nav-linknew">
                            Sell Leads
                        </a>
                    </li>
                    <li class="Men">
                        <a style="color: {{ $textcolor }} !important;" class="nav-linknew"
                            href="{{ route('dealassist') }}">
                            Deal Assist
                        </a>
                    </li>
                    <li class="Men">
                        <a style="color: {{ $textcolor }} !important;" href="{{ route('tradeshow') }}"
                            class="nav-linknew">
                            Trade Shows
                        </a>
                    </li>
                    <li class="Men">
                        <a style="color: {{ $textcolor }} !important;" href="{{ route('sendcv') }}"
                            class="nav-linknew">
                            CV Submit
                        </a>
                    </li>
                    <li class="Men">
                        <a href="{{ route('membership') }}" style="color: {{ $textcolor }} !important;"
                            class="nav-linknew">
                            Membership
                        </a>
                    </li>
                    <li class="Men dropdown">
                        <a style="color: {{ $textcolor }} !important;"
                            class="nav-linknew text-capitalize dropdown-toggle " href="#"
                            data-toggle="dropdown">
                            @foreach (json_decode($language['value'], true) as $data)
                                @if ($data['code'] == getDefaultLanguage())
                                    {{ $data['name'] }}
                                @endif
                            @endforeach
                        </a>
                        <ul class="text-align-direction text-capitalize dropdown-menu __dropdown-menu-sizing dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'right' : 'left' }}"
                            style="font-size: 14px; color: black;">
                            @foreach (json_decode($language['value'], true) as $key => $data)
                                @if ($data['status'] == 1)
                                    <li class="change-language __inline-17"
                                        data-action="{{ route('change-language') }}"
                                        data-language-code="{{ $data['code'] }}">
                                        <a class="dropdown-item" href="javascript:">
                                            <span class=""
                                                style="color:var(--web-text);">{{ $data['name'] }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                    @if (auth('customer')->check())
                        <div class="logout-btn mt-auto d-md-none">
                            <hr>
                            <a href="{{ route('customer.auth.logout') }}" class="Men">
                                <strong class="text-base">{{ translate('logout') }}</strong>
                            </a>
                        </div>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
<div id="myDIV">
    <div class="input-group-overlay mx-lg-4 search-form-mobile text-align-direction" id="searchformclose">
        <div class="section">
            <div class="wrapper">
                @if (str_contains(url()->current(), '/job-seeker'))
                    <form action="{{ route('jobseeker') }}" type="submit" class="wrapperform">
                    @elseif(str_contains(url()->current(), '/talent-finder'))
                        <form action="{{ route('talentfinder') }}" type="submit" class="wrapperform">
                        @else
                            <form id="prosup" action="{{ route('products') }}" type="submit"
                                class="wrapperform">
                @endif
                <div class="search_box">
                    @if (str_contains(url()->current(), '/job-seeker'))
                        <div class="w-30 mr-m-1 position-relative my-auto"
                            style="border-right: 2px solid #dde2f1;cursor: pointer;">
                            <span>Search Profile</span>
                        </div>
                    @elseif(str_contains(url()->current(), '/talent-finder'))
                        <div class="w-30 mr-m-1 position-relative my-auto"
                            style="border-right: 2px solid #dde2f1;cursor: pointer;">
                            <span>Search Candidates</span>
                        </div>
                    @else
                        <div class="dropdown" id="productDropdown">
                            <div class="default_option">{{ translate('Products') }}</div>
                            <ul id="dropdownOptions">
                                <li data-value="products" data-route="{{ route('products') }}"
                                    data-placeholder="Search for products...">
                                    Products
                                </li>
                                <li data-value="suppliers" data-route="{{ route('supplier') }}"
                                    data-placeholder="Search for suppliers...">
                                    Suppliers</li>
                            </ul>
                        </div>
                    @endif
                    <div class="search_field">
                        @if (str_contains(url()->current(), '/job-seeker'))
                            <input type="text" id="searchInput" class="input" name="vacancy"
                                value="{{ request('vacancy') }}"
                                placeholder="{{ translate('Search for job profiles') }}...">
                        @elseif(str_contains(url()->current(), '/talent-finder'))
                            <input type="text" id="searchInput" class="input" name="talentfinder"
                                value="{{ request('talentfinder') }}"
                                placeholder="{{ translate('Search for Candidates') }}...">
                        @else
                            <input type="text" id="searchInput" name="searchInput" class="input"
                                value="{{ request('name') }}"
                                placeholder="{{ translate('Search for products') }}...">
                        @endif

                        <div style="top:5px; right:10px; color:var(--web-hover);" class="d-flex position-absolute"
                            onclick="document.getElementsByClassName('wrapperform')[0].submit()">
                            <svg style="width:16px; height:16px;" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 512 512"
                                fill="var(--web-hover)"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path
                                    d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                            </svg>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->

<div class="rightfloatheaders">
    <div class="float-sm">
        <button class="fl-fl float-fb text-white" data-icon="fa-home" data-label="RFQ" onclick="window.open('{{ route('quotationweb') }}', '_blank')">
            <i class="fa fa-home"></i>
        </button>
        <button class="fl-fl float-tw text-white" data-icon="fa-user" data-label="Help" onclick="window.open('', '_blank')">
            <i class="fa fa-user"></i>
        </button>
        <button class="fl-fl float-gp text-white" data-icon="fa-info-circle" data-label="Info" onclick="window.open('', '_blank')">
            <i class="fa fa-info-circle"></i>
        </button>
    </div>
</div>

@push('script')
    <script>
        "use strict";
        $(".category-menu").find(".mega_menu").parents("li")
            .addClass("has-sub-item").find("> a")
            .append("<i class='czi-arrow-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}'></i>");
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.fl-fl');

            buttons.forEach(button => {
                const label = button.getAttribute('data-label'); // Retrieve label from `data-label`
                const icon = button.getAttribute('data-icon');

                button.addEventListener('mouseenter', () => {
                    button.textContent = ''; // Clear existing content
                    button.innerHTML =
                        `<i class="fa ${icon}"></i> ${label}`; // Add icon and label
                });

                button.addEventListener('mouseleave', () => {
                    button.textContent = ''; // Clear content
                    button.innerHTML =
                    `<i class="fa ${icon}"></i>`; // Add only icon
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const showNavbarButton = document.getElementById('showNavbar');
            const categoryDropdown = document.getElementById('categoryDropdown');

            // Show dropdown on mouse enter
            showNavbarButton.addEventListener('mouseenter', function() {
                categoryDropdown.style.display = 'block';
            });

            // Keep the dropdown visible while hovering over it
            categoryDropdown.addEventListener('mouseenter', function() {
                categoryDropdown.style.display = 'block';
            });

            // Hide dropdown when mouse leaves both button and dropdown
            categoryDropdown.addEventListener('mouseleave', function() {
                categoryDropdown.style.display = 'none';
            });

            showNavbarButton.addEventListener('mouseleave', function() {
                setTimeout(() => {
                    if (!categoryDropdown.matches(':hover')) {
                        categoryDropdown.style.display = 'none';
                    }
                }, 200); // Slight delay to ensure smooth transition
            });
        });
    </script>
    <script>
        document.getElementById('menu-button').addEventListener('click', function() {
            const navbar = document.getElementById('navbarhidden');
            if (navbar.style.display === 'block') {
                navbar.style.display = 'none';
            } else {
                navbar.style.display = 'block';
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dropdown = document.querySelector('.dropdown');
            const defaultOption = document.querySelector('.default_option');
            const dropdownList = document.querySelector('.dropdown ul');
            const prosup = document.getElementById('prosup');

            // Preselect the first option
            defaultOption.textContent = dropdownList.querySelector('li').textContent;

            dropdown.addEventListener('click', function() {
                dropdownList.classList.toggle('active'); // Toggle dropdown visibility
            });

            // Close the dropdown if an option is selected or clicked
            dropdownList.querySelectorAll('li').forEach(item => {
                item.addEventListener('click', function() {
                    defaultOption.textContent = this.textContent; // Update selected option
                    prosup.action = item.dataset.route;
                    dropdownList.classList.remove('active'); // Close dropdown
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!dropdown.contains(event.target)) {
                    dropdownList.classList.remove('active'); // Close dropdown if clicked outside
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdown = document.querySelector('.custom-dropdown');
            const trigger = dropdown.querySelector('.dropdown-trigger');

            trigger.addEventListener('click', function() {
                dropdown.classList.toggle('show');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!dropdown.contains(event.target)) {
                    dropdown.classList.remove('show');
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdown = document.getElementById('productDropdown');
            const defaultOption = dropdown.querySelector('.default_option');
            const searchInput = document.getElementById('searchInput');

            // Toggle dropdown visibility when the dropdown is clicked
            dropdown.addEventListener('click', function() {
                const ul = dropdown.querySelector('ul');
                ul.style.display = ul.style.display === 'block' ? 'none' : 'block';
            });

            // Add click event listener to each dropdown item
            dropdown.querySelectorAll('li').forEach(item => {
                item.addEventListener('click', function() {
                    // Update the default option text
                    defaultOption.textContent = this.textContent;

                    // Change the placeholder based on the selected option
                    const placeholder = this.getAttribute('data-placeholder');
                    searchInput.placeholder = placeholder;

                    // Close the dropdown after selection
                    dropdown.querySelector('ul').style.display = 'none';
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                // Check if the click is outside the dropdown
                if (!dropdown.contains(event.target)) {
                    dropdown.querySelector('ul').style.display = 'none'; // Hide dropdown
                }
            });
        });
    </script>
    <script>
        $('#togglenavbar').on('click', function(event) {
            $('#navbarCollapse').show();
        });
        $('#navbarbutton').on('click', function(event) {
            $('#navbarCollapse').hide();
        });
    </script>
    <script>
        $('#closebutton').on('click', function(event) {
            $('#searchformclose').removeClass('active');
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#dropdownbar').on('mouseenter', function() {
                $(this).css({
                    'box-shadow': '0px 4px 15px rgba(0, 0, 0, 0.5)',
                    'z-index': '1000'
                });

                $(this).find('.dropdownmenucat').css({
                    'display': 'flex',
                    'flex-wrap': 'wrap',
                    'pointer-events': 'auto',
                });
            });

            $('#dropdownbar').on('mouseleave', function() {
                $(this).css({
                    'background-color': '',
                    'box-shadow': ''
                });

                $(this).find('.dropdownmenucat').css({
                    'display': 'none',
                    'pointer-events': 'none',
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var signinheader = document.getElementsByClassName('signinheader');
            var message = document.getElementsByClassName('messageheader');
            var cartheader = document.getElementsByClassName('cartheader');
            var getheader = document.getElementsByClassName('addcontents');

            function checkNavbarScroll() {
                var navbar = document.querySelector('.centernavbar'); // Get the navbar element
                if (navbar && navbar.classList.contains('navbar-stuck')) {
                    for (var i = 0; i < signinheader.length; i++) {
                        signinheader[i].style.display = 'none';
                    }
                    for (var i = 0; i < message.length; i++) {
                        message[i].style.display = 'none';
                    }
                    for (var i = 0; i < cartheader.length; i++) {
                        cartheader[i].style.display = 'none';
                    }
                    getheader[0].style.display = 'contents';
                } else {
                    for (var i = 0; i < signinheader.length; i++) {
                        signinheader[i].style.display = 'inline-block'; // Adjust based on your layout
                    }
                    for (var i = 0; i < message.length; i++) {
                        message[i].style.display = 'inline-block'; // Adjust based on your layout
                    }
                    for (var i = 0; i < cartheader.length; i++) {
                        cartheader[i].style.display = 'inline-block'; // Adjust based on your layout
                    }
                    getheader[0].style.display = '';
                }
            }

            checkNavbarScroll();

            window.addEventListener('scroll', function() {
                checkNavbarScroll();
            });
        });
    </script>
    <script>
        function myFunction() {
            var x = document.getElementById("myDIV");
            if (x.style.display === "none") {
                x.style.display = "flex";
            } else {
                x.style.display = "none";
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdown = document.getElementById('profileDropdownContainer');
            const dropdownToggle = document.getElementById('profileDropdown');
            const dropdownMenu = dropdown.querySelector('.dropdown-menu');

            // Show dropdown on hover
            dropdown.addEventListener('mouseenter', function() {
                dropdownMenu.classList.add('show');
                dropdownToggle.setAttribute('aria-expanded', 'true');
            });

            // Hide dropdown when not hovering
            dropdown.addEventListener('mouseleave', function() {
                dropdownMenu.classList.remove('show');
                dropdownToggle.setAttribute('aria-expanded', 'false');
            });
        });
    </script>
@endpush
