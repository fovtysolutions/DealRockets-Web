@php($announcement = getWebConfig(name: 'announcement'))

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

<header class="rtl __inline-10">
    <!-- <div class="topbar">
         <div class="container">
            <div>
                <div class="topbar-text dropdown d-md-none ms-auto">
                    <a class="topbar-link direction-ltr" href="tel: {{ $web_config['phone']->value }}">
                        <i class="fa fa-phone"></i> {{ $web_config['phone']->value }}
                    </a>
                </div>
                <div class="d-none d-md-block mr-2 text-nowrap">
                    <a class="topbar-link d-none d-md-inline-block direction-ltr"
                        href="tel:{{ $web_config['phone']->value }}">
                        <i class="fa fa-phone"></i> {{ $web_config['phone']->value }}
                    </a>
                </div>
            </div>

            <div>
                @php($currency_model = getWebConfig(name: 'currency_model'))
                @if ($currency_model == 'multi_currency')
<div class="topbar-text dropdown disable-autohide mr-4">
                        <a class="topbar-link dropdown-toggle" href="#" data-toggle="dropdown">
                            <span>{{ session('currency_code') }} {{ session('currency_symbol') }}</span>
                        </a>
                        <ul
                            class="text-align-direction dropdown-menu dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'right' : 'left' }} min-width-160px">
                            @foreach (\App\Models\Currency::where('status', 1)->get() as $key => $currency)
<li class="dropdown-item cursor-pointer get-currency-change-function"
                                    data-code="{{ $currency['code'] }}">
                                    {{ $currency->name }}
                                </li>
@endforeach
                        </ul>
                    </div>
@endif
            </div>
        </div>
    </div> -->


    <div class="centernavbar navbar-sticky bg-white mobile-head">
        <div class="firstnavbar navbar navbar-expand-md navbar-light">
            <div class="container width addcontents" style="margin:0;">
                <a class="navbar-brand d-sm-none" href="{{ route('home') }}">
                    <img class="mobile-logo-img __inline-12" style="max-width:100%"
                        src="{{ getStorageImages(path: $web_config['mob_logo'], type: 'logo') }}"
                        alt="{{ $web_config['name']->value }}" />
                </a>
                <a class="navbar-brand d-none d-sm-block flex-shrink-0" href="{{ route('home') }}">
                    <img class="navbarbrandnew"
                        src="{{ getStorageImages(path: $web_config['web_logo'], type: 'logo') }}"
                        alt="{{ $web_config['name']->value }}">
                </a>
                <div
                    class="navbar-tool open-search-form-mobile d-lg-none {{ Session::get('direction') === 'rtl' ? 'mr-md-3' : '' }}">
                    <a class="navbar-tool-icon-box bg-secondary" href="javascript:">
                        <i class="tio-search"></i>
                    </a>
                </div>
                <button class="navbar-toggler ml-3" type="button" id="togglenavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>

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
                                        <div class="default_option">Products</div>
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

                                    <div style="top:5px; right:10px; color:var(--web-hover);"
                                        class="d-flex position-absolute"
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
                            <div class="closebutton" id="closebutton">
                                <strong> X</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <form action="{{ route('products') }}" type="submit" class="search_form">
                        <div class="d-flex align-items-center gap-2">
                            <input class="form-control appended-form-control search-bar-input headerinput" type="search"
                                autocomplete="off" data-given-value=""
                                placeholder="{{ translate('search_for_items') }}..." name="name"
                                value="{{ request('name') }}">

                            <button class="input-group-append-overlay search_button d-none d-md-block" type="submit">
                                <span class="input-group-text __text-20px">
                                    <i class="czi-search text-white"></i>
                                </span>
                            </button>

                            <span class="close-search-form-mobile fs-14 font-semibold text-muted d-md-none"
                                type="submit">
                                {{ translate('cancel') }}
                            </span>
                        </div>

                        <input name="data_from" value="search" hidden>
                        <input name="page" value="1" hidden>
                        <diV class="card search-card mobile-search-card">
                            <div class="card-body">
                                <div class="search-result-box __h-400px overflow-x-hidden overflow-y-auto"></div>
                            </div>
                        </diV>
                    </form> -->
            </div>

            <div class="navbar-toolbar d-flex flex-shrink-0 align-items-center">
                <!-- <a class="navbar-tool navbar-stuck-toggler" href="#">
                    <span class="navbar-tool-tooltip">{{ translate('expand_Menu') }}</span>
                    <div class="navbar-tool-icon-box">
                        <i class="navbar-tool-icon czi-menu open-icon"></i>
                        <i class="navbar-tool-icon czi-close close-icon"></i>
                    </div>
                </a> -->
                <div>
                    <a class="navbaricons" href="{{ route('quotationweb') }}">
                        <div class="navbariconscontainer" style="color: var(--web-hover)">
                            <svg class="headericon" fill="var(--web-hover)" version="1.1" id="Capa_1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                viewBox="0 0 512 512" xml:space="preserve">
                                <g>
                                    <path d="M426.737,168.939c-3.912,2.054-5.418,6.89-3.364,10.802C439.484,210.427,448,245.096,448,280
  c0,57.695-22.468,111.938-63.265,152.735C343.938,473.533,289.696,496,232,496s-111.938-22.468-152.735-63.265
  C38.468,391.939,16,337.696,16,280s22.468-111.938,63.265-152.735C120.062,86.468,174.304,64,232,64
  c34.916,0,69.595,8.521,100.288,24.642c3.911,2.057,8.748,0.55,10.802-3.362c2.054-3.911,0.549-8.748-3.363-10.802
  C306.749,57.156,269.498,48,232,48c-61.97,0-120.23,24.132-164.049,67.951S0,218.031,0,280S24.132,400.23,67.951,444.049
  S170.03,512,232,512s120.23-24.132,164.049-67.951S464,341.97,464,280c0-37.485-9.15-74.727-26.461-107.697
  C435.485,168.391,430.649,166.885,426.737,168.939z" />
                                    <path d="M334.708,136.837c2.413-3.701,1.37-8.658-2.332-11.071C302.513,106.293,267.804,96,232,96C130.542,96,48,178.542,48,280
  s82.542,184,184,184s184-82.542,184-184c0-35.79-10.286-70.488-29.745-100.344c-2.413-3.701-7.369-4.748-11.07-2.334
  c-3.702,2.412-4.747,7.369-2.334,11.07C390.612,215.644,400,247.321,400,280c0,92.636-75.364,168-168,168S64,372.636,64,280
  s75.364-168,168-168c32.692,0,64.38,9.395,91.637,27.168C327.337,141.581,332.294,140.537,334.708,136.837z" />
                                    <path d="M306.644,175.699c2.346-3.744,1.212-8.681-2.532-11.026C282.525,151.149,257.589,144,232,144c-74.991,0-136,61.01-136,136
  s61.009,136,136,136s136-61.01,136-136c0-25.589-7.147-50.523-20.67-72.108c-2.346-3.744-7.283-4.879-11.026-2.532
  c-3.744,2.346-4.878,7.282-2.532,11.026C345.696,235.422,352,257.419,352,280c0,66.168-53.832,120-120,120s-120-53.832-120-120
  s53.832-120,120-120c22.582,0,44.58,6.304,63.617,18.23C299.362,180.577,304.298,179.443,306.644,175.699z" />
                                    <path d="M274.128,211.508c1.932-3.974,0.277-8.761-3.697-10.692C258.4,194.966,245.47,192,232,192c-48.523,0-88,39.477-88,88
  s39.477,88,88,88s88-39.477,88-88c0-13.457-2.961-26.377-8.8-38.401c-1.931-3.975-6.717-5.634-10.691-3.701
  c-3.974,1.931-5.631,6.717-3.701,10.691C301.58,258.416,304,268.985,304,280c0,39.701-32.299,72-72,72s-72-32.299-72-72
  s32.299-72,72-72c11.026,0,21.603,2.424,31.435,7.204C267.407,217.136,272.195,215.481,274.128,211.508z" />
                                    <path d="M226.975,256.526c4.321-0.92,7.08-5.168,6.16-9.489c-0.919-4.32-5.165-7.077-9.489-6.161
  C205.309,244.776,192,261.231,192,280c0,22.056,17.944,40,40,40c18.919,0,35.4-13.436,39.188-31.947
  c0.886-4.328-1.905-8.556-6.233-9.441c-4.331-0.881-8.556,1.905-9.441,6.234C253.241,295.945,243.353,304,232,304
  c-13.233,0-24-10.767-24-24C208,268.737,215.98,258.865,226.975,256.526z" />
                                    <path d="M511.391,52.939C510.153,49.95,507.236,48,504,48h-40V8c0-3.235-1.949-6.152-4.938-7.391
  c-2.989-1.239-6.431-0.554-8.718,1.733l-100,100c-1.5,1.501-2.343,3.535-2.343,5.657v44.686L226.343,274.343
  c-3.125,3.125-3.125,8.189,0,11.314c1.562,1.562,3.609,2.343,5.657,2.343s4.095-0.781,5.657-2.343L359.314,164H404
  c2.122,0,4.157-0.843,5.657-2.343l100-100C511.945,59.369,512.629,55.928,511.391,52.939z M400.687,148h-25.373l62.343-62.343
  c3.125-3.125,3.125-8.189,0-11.314c-3.124-3.123-8.189-3.123-11.313,0L364,136.686v-25.373l84-84V56c0,4.418,3.582,8,8,8h28.687
  L400.687,148z" />
                                </g>
                            </svg>
                            <div class="inquiry-cart-label" style="color: var(--web-hover)">Post my RFQ</div>
                        </div>
                    </a>
                </div>
                <!-- <div
                    class="navbar-tool open-search-form-mobile d-lg-none {{ Session::get('direction') === 'rtl' ? 'mr-md-3' : 'ml-md-3' }}">
                    <a class="navbar-tool-icon-box bg-secondary" href="javascript:">
                        <i class="tio-search"></i>
                    </a>
                </div> -->
                <!-- <div class="navbar-tool dropdown d-none d-md-block {{ Session::get('direction') === 'rtl' ? 'mr-md-3' : 'ml-md-3' }}">
                        <a class="navbar-tool-icon-box bg-secondary dropdown-toggle" href="{{ route('wishlists') }}">
                            <span class="navbar-tool-label">
                                <span class="countWishlist">
                                    {{ session()->has('wish_list') ? count(session('wish_list')) : 0 }}
                                </span>
                           </span>
                            <i class="navbar-tool-icon czi-heart"></i>
                        </a>
                    </div> -->
                @if (auth('customer')->check())
                    <div class="dropdown">
                        <a class="navbar-tool ml-3" type="button" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <div class="navbar-tool-icon-box bg-secondary">
                                <div class="navbar-tool-icon-box bg-secondary">
                                    <img class="img-profile rounded-circle __inline-14" alt=""
                                        src="{{ getStorageImages(path: auth('customer')->user()->image_full_url, type: 'avatar') }}">
                                </div>
                            </div>
                            <div class="navbar-tool-text">
                                <small>{{ translate('hello') }}, {{ auth('customer')->user()->f_name }}</small>
                                {{ translate('dashboard') }}
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}"
                            aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('account-oder') }}"> {{ translate('my_Order') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('user-account') }}">
                                {{ translate('my_Profile') }}</a>
                            @if ($is_jobadder === true)
                                <a class="dropdown-item"
                                    href="{{ route('job-panel') }}">{{ translate('job_Panel') }}</a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item"
                                href="{{ route('customer.auth.logout') }}">{{ translate('logout') }}</a>
                        </div>
                    </div>
                @else
                    <div class="dropdown">
                        <a class="signinheader" type="button" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" href="#">
                            <div class="navbaricons">
                                <div class="navbariconscontainer">
                                    <svg class="headericon" fill="white" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="6" r="4" stroke="var(--web-hover)"
                                            stroke-width="1.5" />
                                        <path
                                            d="M20 17.5C20 19.9853 20 22 12 22C4 22 4 19.9853 4 17.5C4 15.0147 7.58172 13 12 13C16.4183 13 20 15.0147 20 17.5Z"
                                            stroke="var(--web-hover)" stroke-width="1.5" />
                                    </svg>
                                    <div class="inquiry-cart-label">Sign In</div>
                                </div>
                            </div>
                        </a>
                        <div class="pb-1 text-align-direction dropdown-menu __auth-dropdown dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}"
                            aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('customer.auth.login') }}">
                                <i class="fas fa-regular fa-user mr-2"></i> {{ translate('sign_in') }}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('customer.auth.sign-up') }}">
                                <i class="fas fa-user-circle mr-2"></i>{{ translate('sign_up') }}
                            </a>
                        </div>
                    </div>
                @endif
                <div>
                    @if (auth('customer')->check())
                        <a class="messageheader navbaricons" href="/chat/vendor">
                            <div class="navbariconscontainer">
                                <span class="chat-unread" style="z-index: 0;">{{ $unread }}</span>
                                <svg class="headericon" viewBox="0 0 48 48" id="Layer_2" data-name="Layer 2"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <defs>
                                        <style>
                                            .cls-1 {
                                                fill: none;
                                                stroke: var(--web-hover);
                                                stroke-linecap: round;
                                                stroke-linejoin: round;
                                                stroke-width: 3px;
                                            }
                                        </style>
                                    </defs>
                                    <path class="cls-1"
                                        d="M41.47,7.28H6.53a2,2,0,0,0-2,1.88V31.41a2,2,0,0,0,2,1.88H9.14v7.43l8.26-7.43H41.47a2,2,0,0,0,2-1.88V9.16A2,2,0,0,0,41.47,7.28ZM14.25,17A3.25,3.25,0,1,1,11,20.29,3.24,3.24,0,0,1,14.25,17ZM24,23.54a3.25,3.25,0,1,1,3.25-3.25A3.26,3.26,0,0,1,24,23.54Zm9.75,0A3.25,3.25,0,1,1,37,20.29,3.26,3.26,0,0,1,33.75,23.54Z" />
                                </svg>
                                <div class="inquiry-cart-label">Messages</div>
                            </div>
                        </a>
                    @else
                        <a class="messageheader navbaricons" href="{{ route('customer.auth.login') }}">
                            <div class="navbariconscontainer">
                                <svg class="headericon" viewBox="0 0 48 48" id="Layer_2" data-name="Layer 2"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <defs>
                                        <style>
                                            .cls-1 {
                                                fill: none;
                                                stroke: var(--web-hover);
                                                stroke-linecap: round;
                                                stroke-linejoin: round;
                                                stroke-width: 3px;
                                            }
                                        </style>
                                    </defs>
                                    <path class="cls-1"
                                        d="M41.47,7.28H6.53a2,2,0,0,0-2,1.88V31.41a2,2,0,0,0,2,1.88H9.14v7.43l8.26-7.43H41.47a2,2,0,0,0,2-1.88V9.16A2,2,0,0,0,41.47,7.28ZM14.25,17A3.25,3.25,0,1,1,11,20.29,3.24,3.24,0,0,1,14.25,17ZM24,23.54a3.25,3.25,0,1,1,3.25-3.25A3.26,3.26,0,0,1,24,23.54Zm9.75,0A3.25,3.25,0,1,1,37,20.29,3.26,3.26,0,0,1,33.75,23.54Z" />
                                </svg>
                                <div class="inquiry-cart-label">Messages</div>
                            </div>
                        </a>
                    @endif
                    <!-- <a class="navbaricons" href="#">
                        <div class="navbariconscontainer">
                            <i class="headericon bx bx-cart" aria-hidden="true"></i>
                            <div class="inquiry-cart-label">Inquiry Cart</div>
                        </div>
                    </a> -->
                </div>
                <div id="cart_items">
                    @include('layouts.front-end.partials._cart')
                </div>
            </div>
        </div>
    </div>
    <div class="centernavbar secondnavbar navbar navbar-expand-md navbar-stuck-menu">
        <div class="container px-10px">
            <div class="collapse navbar-collapse text-align-direction" id="navbarCollapse">
                <div class="w-100 d-md-none text-align-direction">
                    <button class="navbar-toggler p-0" type="button" data-toggle="collapse"
                        data-target="#navbarCollapse" id="navbarbutton">
                        <i class="tio-clear __text-26px"></i>
                    </button>
                </div>
                <div class="custom-dropdown">
                    <div class="dropdown-trigger">
                        <svg class="spanimage pr-1" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                            <rect x="5" y="6" width="20" height="2" fill="black" />
                            <rect x="5" y="13" width="20" height="2" fill="black" />
                            <rect x="5" y="20" width="20" height="2" fill="black" />
                        </svg>
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

                {{-- <div class="custom-dropdown">
                    <div class="dropdown-trigger">
                        <svg class="spanimage" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                            <rect x="5" y="6" width="20" height="2" fill="black" />
                            <rect x="5" y="13" width="20" height="2" fill="black" />
                            <rect x="5" y="20" width="20" height="2" fill="black" />
                        </svg>
                        {{ translate('All Categories') }}
                        <span class="arrow">&#9662;</span>
                    </div>
                    <div class="dropdown-menu">
                        @foreach ($categories->chunk(10) as $chunk)
                            <div class="column">
                                @foreach ($chunk as $category)
                                    <a class="dropdown-itemcat"
                                        href="{{ route('products', ['category_id' => $category['id'], 'data_from' => 'category', 'page' => 1]) }}">
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div> --}}
                <ul class="navbar-nav d-block d-md-none">
                    <li class="nav-item dropdown {{ request()->is('/') ? 'active' : '' }}">
                        <a class="nav-linknew" href="{{ route('home') }}">{{ translate('home') }}</a>
                    </li>
                </ul>

                @php($categories = \App\Utils\CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting(dataLimit: 11))

                <!-- <ul class="navbar-nav mega-nav pr-lg-2 pl-lg-2 mr-2 d-none d-md-block __mega-nav">
                        <li class="nav-item {{ !request()->is('/') ? 'dropdown' : '' }}">

                            <a class="nav-link dropdown-toggle category-menu-toggle-btn ps-0"
                               href="javascript:">
                                <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M9.875 12.9195C9.875 12.422 9.6775 11.9452 9.32563 11.5939C8.97438 11.242 8.4975 11.0445 8 11.0445C6.75875 11.0445 4.86625 11.0445 3.625 11.0445C3.1275 11.0445 2.65062 11.242 2.29937 11.5939C1.9475 11.9452 1.75 12.422 1.75 12.9195V17.2945C1.75 17.792 1.9475 18.2689 2.29937 18.6202C2.65062 18.972 3.1275 19.1695 3.625 19.1695H8C8.4975 19.1695 8.97438 18.972 9.32563 18.6202C9.6775 18.2689 9.875 17.792 9.875 17.2945V12.9195ZM19.25 12.9195C19.25 12.422 19.0525 11.9452 18.7006 11.5939C18.3494 11.242 17.8725 11.0445 17.375 11.0445C16.1337 11.0445 14.2413 11.0445 13 11.0445C12.5025 11.0445 12.0256 11.242 11.6744 11.5939C11.3225 11.9452 11.125 12.422 11.125 12.9195V17.2945C11.125 17.792 11.3225 18.2689 11.6744 18.6202C12.0256 18.972 12.5025 19.1695 13 19.1695H17.375C17.8725 19.1695 18.3494 18.972 18.7006 18.6202C19.0525 18.2689 19.25 17.792 19.25 17.2945V12.9195ZM16.5131 9.66516L19.1206 7.05766C19.8525 6.32578 19.8525 5.13828 19.1206 4.4064L16.5131 1.79891C15.7813 1.06703 14.5937 1.06703 13.8619 1.79891L11.2544 4.4064C10.5225 5.13828 10.5225 6.32578 11.2544 7.05766L13.8619 9.66516C14.5937 10.397 15.7813 10.397 16.5131 9.66516ZM9.875 3.54453C9.875 3.04703 9.6775 2.57015 9.32563 2.2189C8.97438 1.86703 8.4975 1.66953 8 1.66953C6.75875 1.66953 4.86625 1.66953 3.625 1.66953C3.1275 1.66953 2.65062 1.86703 2.29937 2.2189C1.9475 2.57015 1.75 3.04703 1.75 3.54453V7.91953C1.75 8.41703 1.9475 8.89391 2.29937 9.24516C2.65062 9.59703 3.1275 9.79453 3.625 9.79453H8C8.4975 9.79453 8.97438 9.59703 9.32563 9.24516C9.6775 8.89391 9.875 8.41703 9.875 7.91953V3.54453Z"
                                          fill="currentColor"/>
                                </svg>
                                <span class="category-menu-toggle-btn-text">
                                    {{ translate('categories') }}
                                </span>
                            </a>
                        </li>
                    </ul> -->

                <ul class="navbar-nav mega-nav1 pr-md-2 pl-md-2 d-block d-xl-none">
                    <!-- <li class="nav-item dropdown d-md-none">
                        <a class="nav-linknew dropdown-toggle ps-0" href="javascript:" data-toggle="dropdown">
                            <i class="czi-menu align-middle mt-n1 me-2"></i>
                            <span class="me-4">
                                {{ translate('categories') }}
                            </span>
                        </a>
                        <ul class="dropdown-menu __dropdown-menu-2 text-align-direction">
                            @php($categoryIndex = 0)
                            @foreach ($categories as $category)
@php($categoryIndex++)
                            @if ($categoryIndex < 10)
<li class="dropdown">

                                                    <a <?php if ($category->childes->count() > 0) {
                                                        echo '';
                                                    } ?>
                                                        href="{{ route('products', ['category_id' => $category['id'], 'data_from' => 'category', 'page' => 1]) }}">
                                                        <span>{{ $category['name'] }}</span>

                                                    </a>
                                                    @if ($category->childes->count() > 0)
<a data-toggle='dropdown' class='__ml-50px'>
                                                            <i
                                                                class="czi-arrow-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }} __inline-16"></i>
                                                        </a>
@endif

                                                    @if ($category->childes->count() > 0)
<ul class="dropdown-menu text-align-direction">
                                                            @foreach ($category['childes'] as $subCategory)
<li class="dropdown">
                                                                    <a
                                                                        href="{{ route('products', ['category_id' => $subCategory['id'], 'data_from' => 'category', 'page' => 1]) }}">
                                                                        <span>{{ $subCategory['name'] }}</span>
                                                                    </a>

                                                                    @if ($subCategory->childes->count() > 0)
<a class="header-subcategories-links" data-toggle='dropdown'>
                                                                            <i
                                                                                class="czi-arrow-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }} __inline-16"></i>
                                                                        </a>
                                                                        <ul class="dropdown-menu">
                                                                            @foreach ($subCategory['childes'] as $subSubCategory)
<li>
                                                                                    <a class="dropdown-item"
                                                                                        href="{{ route('products', ['category_id' => $subSubCategory['id'], 'data_from' => 'category', 'page' => 1]) }}">{{ $subSubCategory['name'] }}</a>
                                                                                </li>
@endforeach
                                                                        </ul>
@endif
                                                                </li>
@endforeach
                                                        </ul>
@endif
                                                </li>
@endif
@endforeach
                            <li class="__inline-17">
                                <div>
                                    <a class="dropdown-item web-text-primary" href="{{ route('categories') }}">
                                        {{ translate('view_more') }}
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li> -->
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item dropdown d-none d-md-block {{ request()->is('/') ? 'active' : '' }}">
                        <a class="nav-linknew" href="{{ route('home') }}">{{ translate('home') }}</a>
                    </li>

                    <!-- @if (getWebConfig(name: 'product_brand'))
<li class="nav-item dropdown">
                        <a class="nav-linknew dropdown-toggle" href="#"
                            data-toggle="dropdown">{{ translate('brand') }}</a>
                        <ul class="text-align-direction dropdown-menu __dropdown-menu-sizing dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'right' : 'left' }}"
                            style="font-size: 14px; color: black;">
                            @php($brandIndex = 0)
                            @foreach (\App\Utils\BrandManager::getActiveBrandWithCountingAndPriorityWiseSorting() as $brand)
@php($brandIndex++)
                            @if ($brandIndex < 10)
<li class="__inline-17">
                                    <div>
                                        <a class="dropdown-item"
                                            href="{{ route('products', ['brand_id' => $brand['id'], 'data_from' => 'brand', 'page' => 1]) }}">
                                            {{ $brand['name'] }}
                                        </a>
                                    </div>
                                    <div class="align-baseline">
                                        @if ($brand['brand_products_count'] > 0)
<span class="count-value px-2">( {{ $brand['brand_products_count'] }} )</span>
@endif
                                    </div>
                                </li>
@endif
@endforeach
                            <li class="__inline-17">
                                <div>
                                    <a class="dropdown-item web-text-primary" href="{{ route('brands') }}">
                                        {{ translate('view_more') }}
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
@endif -->
                    {{-- @php(
    $discount_product = App\Models\Product::with(['reviews'])->active()->where('discount', '!=', 0)->count(),
)
                    @if ($discount_product > 0)
<li class="nav-item dropdown {{ request()->is('/') ? 'active' : '' }}">
                            <a class="nav-link text-capitalize"
                                href="{{ route('products', ['data_from' => 'discounted', 'page' => 1]) }}">
                                {{ translate('discounted_products') }}
                            </a>
                        </li>
@endif --}}

                    @if ($web_config['digital_product_setting'] && count($web_config['publishing_houses']) == 1)
                        <li class="nav-item dropdown d-none d-md-block {{ request()->is('/') ? 'active' : '' }}">
                            <a class="nav-link"
                                href="{{ route('products', ['publishing_house_id' => 0, 'product_type' => 'digital', 'page' => 1]) }}">
                                {{ translate('Publication_House') }}
                            </a>
                        </li>
                    @elseif ($web_config['digital_product_setting'] && count($web_config['publishing_houses']) > 1)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                                {{ translate('Publication_House') }}
                            </a>
                            <ul
                                class="text-align-direction dropdown-menu __dropdown-menu-sizing dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'right' : 'left' }} scroll-bar">
                                @php($publishingHousesIndex = 0)
                                @foreach ($web_config['publishing_houses'] as $publishingHouseItem)
                                    @if ($publishingHousesIndex < 10 && $publishingHouseItem['name'] != 'Unknown')
                                        @php($publishingHousesIndex++)
                                        <li class="__inline-17">
                                            <div>
                                                <a class="dropdown-item"
                                                    href="{{ route('products', ['publishing_house_id' => $publishingHouseItem['id'], 'product_type' => 'digital', 'page' => 1]) }}">
                                                    {{ $publishingHouseItem['name'] }}
                                                </a>
                                            </div>
                                            <div class="align-baseline">
                                                @if ($publishingHouseItem['publishing_house_products_count'] > 0)
                                                    <span class="count-value px-2">(
                                                        {{ $publishingHouseItem['publishing_house_products_count'] }}
                                                        )</span>
                                                @endif
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                                <li class="__inline-17">
                                    <div>
                                        <a class="dropdown-item web-text-primary"
                                            href="{{ route('products', ['product_type' => 'digital', 'page' => 1]) }}">
                                            {{ translate('view_more') }}
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @php($businessMode = getWebConfig(name: 'business_mode'))
                    @if ($businessMode == 'multi')
                        <!-- <li class="nav-item dropdown {{ request()->is('/') ? 'active' : '' }}"> -->
                        <li class="nav-item">
                            <a class="nav-linknew"
                                href="{{ route('vendors') }}">{{ translate('all_vendors') }}</a>
                        </li>
                    @endif

                    @if (auth('customer')->check())
                        <li class="nav-item d-md-none">
                            <a href="{{ route('user-account') }}" class="nav-linknew text-capitalize">
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

                    @if ($businessMode == 'multi')
                        @if (getWebConfig(name: 'seller_registration'))
                            <li class="nav-item">
                                <div class="dropdown">
                                    <a class="nav-linknew dropdown-toggle" href="#" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        {{ translate('vendor_zone') }}
                                    </a>
                                    <div class="dropdown-menu __dropdown-menu-3 __min-w-165px text-align-direction"
                                        aria-labelledby="dropdownMenuButton"
                                        style="position: absolute; background-color: white; z-index: 1000; left: 0; top: 100%; 
                                                                                                                                            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); width: auto; min-width: 165px;">
                                        <a class="dropdown-item text-nowrap text-capitalize "
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
                </ul>
                <div class="hiddennavbar-container">
                    <button class="menu-toggle" id="menu-button">☰</button>
                    <ul class="hiddennavbar-nav" id="navbarhidden">
                        <li class="nav-itemnew">
                            <a href="{{ route('stocksale') }}" class="nav-linknew">
                                Stock Sale
                            </a>
                        </li>
                        <li class="nav-itemnew">
                            <a href="{{ route('agrotradex') }}" class="nav-linknew">
                                Agro Tradex
                            </a>
                        </li>
                        <li class="nav-itemnew">
                            <a href="{{ route('buyer') }}" class="nav-linknew">
                                Buy Leads
                            </a>
                        </li>
                        <!-- <li class="nav-itemnew">
                            <a href="{{ route('supplier') }}" class="nav-linknew">
                                Sale Offers
                            </a>
                        </li> -->
                        <li class="nav-itemnew">
                            <a href="{{ route('seller') }}" class="nav-linknew">
                                Sell Leads
                            </a>
                        </li>
                        <li class="nav-itemnew">
                            <a class="nav-linknew" href="{{ route('dealassist') }}">
                                Deal Assist
                            </a>
                        </li>
                        <li class="nav-itemnew">
                            <a href="{{ route('tradeshow') }}" class="nav-linknew">
                                Trade Shows
                            </a>
                        </li>
                        <li class="nav-itemnew">
                            <a href="{{ route('membership') }}" class="nav-linknew">
                                Membership
                            </a>
                        </li>
                        <!-- <li class="nav-itemnew dropdown">
                            <a class="nav-linknew dropdown-toggle" href="#"
                                data-toggle="dropdown">{{ translate('Supplier') }}</a>
                            <ul class="text-align-direction dropdown-menu __dropdown-menu-sizing dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'right' : 'left' }}"
                                style="font-size: 14px; color: black;">
                                <li class="navdropdown-new">
                                    <div><a class="dropdown-item">Join Premium Membership</a></div>
                                </li>
                                <li class="navdropdown-new">
                                    <div><a class="dropdown-item">Foreign Trade Service Market</a></div>
                                </li>
                                <li class="navdropdown-new">
                                    <div><a class="dropdown-item">Foreign Trade eHome</a></div>
                                </li>
                                <li class="navdropdown-new">
                                    <div><a class="dropdown-item">Smart Trading Services</a></div>
                                </li>
                                <li class="navdropdown-new">
                                    <div><a class="dropdown-item">Smart Expo</a></div>
                                </li>
                            </ul>
                        </li> -->

                        <li class="nav-itemnew dropdown">
                            <a class="nav-linknew dropdown-toggle" href="#"
                                data-toggle="dropdown">{{ translate('Buyer') }}</a>
                            <ul class="text-align-direction dropdown-menu __dropdown-menu-sizing dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'right' : 'left' }}"
                                style="font-size: 14px; color: black;">
                                <li class="navdropdown-new">
                                    <div><a class="dropdown-item">Market Insights</a></div>
                                </li>
                                <li class="navdropdown-new">
                                    <div><a class="dropdown-item">Product Sourcing</a></div>
                                </li>
                                <li class="navdropdown-new">
                                    <div><a class="dropdown-item">Supplier Ratings</a></div>
                                </li>
                                <li class="navdropdown-new">
                                    <div><a href="{{ route('products') }}" class="dropdown-item">Buy New
                                            Products</a>
                                    </div>
                                </li>
                                <li class="navdropdown-new">
                                    <div><a class="dropdown-item">Hot Products</a></div>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-itemnew dropdown">
                            <a class="nav-linknew dropdown-toggle" href="#"
                                data-toggle="dropdown">{{ translate('Help') }}</a>
                            <ul class="text-align-direction dropdown-menu __dropdown-menu-sizing dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'right' : 'left' }}"
                                style="font-size: 14px; color: black;">
                                <li class="navdropdown-new">
                                    <div><a class="dropdown-item">Q & A's</a></div>
                                </li>
                                <li class="navdropdown-new">
                                    <div><a class="dropdown-item">Customer Helpdesk</a></div>
                                </li>
                                <li class="navdropdown-new">
                                    <div><a class="dropdown-item">Vendor Helpdesk</a></div>
                                </li>
                                <li class="navdropdown-new">
                                    <div><a class="dropdown-item">Contact an Agent</a></div>
                                </li>
                                <li class="navdropdown-new">
                                    <div><a class="dropdown-item">Contact a Helper</a></div>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-itemnew dropdown">
                            <a class="nav-linknew dropdown-toggle text-capitalize" href="#"
                                data-toggle="dropdown">
                                @foreach (json_decode($language['value'], true) as $data)
                                    @if ($data['code'] == getDefaultLanguage())
                                        {{ $data['name'] }}
                                    @endif
                                @endforeach
                            </a>
                            <ul class="text-align-direction dropdown-menu __dropdown-menu-sizing dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'right' : 'left' }}"
                                style="font-size: 14px; color: black;">
                                @foreach (json_decode($language['value'], true) as $key => $data)
                                    @if ($data['status'] == 1)
                                        <li class="change-language __inline-17"
                                            data-action="{{ route('change-language') }}"
                                            data-language-code="{{ $data['code'] }}">
                                            <a class="dropdown-item" href="javascript:">
                                                <span class="text-capitalize"
                                                    style="color:var(--web-text);">{{ $data['name'] }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                        <!-- <div class="topbar-text dropdown disable-autohide  __language-bar text-capitalize">
                        <a class="topbar-link dropdown-toggle" href="#" data-toggle="dropdown">
                            @foreach (json_decode($language['value'], true) as $data)
@if ($data['code'] == getDefaultLanguage())
{{ $data['name'] }}
@endif
@endforeach
                        </a>
                        <ul
                            class="text-align-direction dropdown-menu dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'right' : 'left' }}">
                            @foreach (json_decode($language['value'], true) as $key => $data)
@if ($data['status'] == 1)
<li class="change-language" data-action="{{ route('change-language') }}"
                                        data-language-code="{{ $data['code'] }}">
                                        <a class="dropdown-item pb-1" href="javascript:">
                                            <span class="text-capitalize">{{ $data['name'] }}</span>
                                        </a>
                                    </li>
@endif
@endforeach
                        </ul>
                    </div> -->

                    </ul>
                </div>
                <ul class="navbar-navnew checkhidden" id="navbar">
                    <li class="nav-itemnew">
                        <a href="{{ route('stocksale') }}" class="nav-linknew">
                            Stock Sale
                        </a>
                    </li>
                    <li class="nav-itemnew">
                        <a href="{{ route('agrotradex') }}" class="nav-linknew">
                            Agro Tradex
                        </a>
                    </li>
                    <li class="nav-itemnew">
                        <a href="{{ route('buyer') }}" class="nav-linknew">
                            Buy Leads
                        </a>
                    </li>
                    <!-- <li class="nav-itemnew">
                        <a href="{{ route('supplier') }}" class="nav-linknew">
                            Sale Offers
                        </a>
                    </li> -->
                    <li class="nav-itemnew">
                        <a href="{{ route('seller') }}" class="nav-linknew">
                            Sell Leads
                        </a>
                    </li>
                    <li class="nav-itemnew">
                        <a class="nav-linknew" href="{{ route('dealassist') }}">
                            Deal Assist
                        </a>
                    </li>
                    <li class="nav-itemnew">
                        <a href="{{ route('tradeshow') }}" class="nav-linknew">
                            Trade Shows
                        </a>
                    </li>
                    <li class="nav-itemnew">
                        <a href="{{ route('membership') }}" class="nav-linknew">
                            Membership
                        </a>
                    </li>
                    <!-- <li class="nav-itemnew dropdown">
                        <a class="nav-linknew dropdown-toggle" href="#"
                            data-toggle="dropdown">{{ translate('Supplier') }}</a>
                        <ul class="text-align-direction dropdown-menu __dropdown-menu-sizing dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'right' : 'left' }}"
                            style="font-size: 14px; color: black;">
                            <li class="navdropdown-new">
                                <div><a class="dropdown-item">Join Premium Membership</a></div>
                            </li>
                            <li class="navdropdown-new">
                                <div><a class="dropdown-item">Foreign Trade Service Market</a></div>
                            </li>
                            <li class="navdropdown-new">
                                <div><a class="dropdown-item">Foreign Trade eHome</a></div>
                            </li>
                            <li class="navdropdown-new">
                                <div><a class="dropdown-item">Smart Trading Services</a></div>
                            </li>
                            <li class="navdropdown-new">
                                <div><a class="dropdown-item">Smart Expo</a></div>
                            </li>
                        </ul>
                    </li> -->

                    <li class="nav-itemnew dropdown">
                        <a class="nav-linknew dropdown-toggle" href="#"
                            data-toggle="dropdown">{{ translate('Buyer') }}</a>
                        <ul class="text-align-direction dropdown-menu __dropdown-menu-sizing dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'right' : 'left' }}"
                            style="font-size: 14px; color: black;">
                            <li class="navdropdown-new">
                                <div><a class="dropdown-item">Market Insights</a></div>
                            </li>
                            <li class="navdropdown-new">
                                <div><a class="dropdown-item">Product Sourcing</a></div>
                            </li>
                            <li class="navdropdown-new">
                                <div><a class="dropdown-item">Supplier Ratings</a></div>
                            </li>
                            <li class="navdropdown-new">
                                <div><a href="{{ route('products') }}" class="dropdown-item">Buy New Products</a>
                                </div>
                            </li>
                            <li class="navdropdown-new">
                                <div><a class="dropdown-item">Hot Products</a></div>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-itemnew dropdown">
                        <a class="nav-linknew dropdown-toggle" href="#"
                            data-toggle="dropdown">{{ translate('Help') }}</a>
                        <ul class="text-align-direction dropdown-menu __dropdown-menu-sizing dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'right' : 'left' }}"
                            style="font-size: 14px; color: black;">
                            <li class="navdropdown-new">
                                <div><a class="dropdown-item">Q & A's</a></div>
                            </li>
                            <li class="navdropdown-new">
                                <div><a class="dropdown-item">Customer Helpdesk</a></div>
                            </li>
                            <li class="navdropdown-new">
                                <div><a class="dropdown-item">Vendor Helpdesk</a></div>
                            </li>
                            <li class="navdropdown-new">
                                <div><a class="dropdown-item">Contact an Agent</a></div>
                            </li>
                            <li class="navdropdown-new">
                                <div><a class="dropdown-item">Contact a Helper</a></div>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-itemnew dropdown">
                        <a class="nav-linknew dropdown-toggle text-capitalize" href="#" data-toggle="dropdown">
                            @foreach (json_decode($language['value'], true) as $data)
                                @if ($data['code'] == getDefaultLanguage())
                                    {{ $data['name'] }}
                                @endif
                            @endforeach
                        </a>
                        <ul class="text-align-direction dropdown-menu __dropdown-menu-sizing dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'right' : 'left' }}"
                            style="font-size: 14px; color: black;">
                            @foreach (json_decode($language['value'], true) as $key => $data)
                                @if ($data['status'] == 1)
                                    <li class="change-language __inline-17"
                                        data-action="{{ route('change-language') }}"
                                        data-language-code="{{ $data['code'] }}">
                                        <a class="dropdown-item" href="javascript:">
                                            <span class="text-capitalize"
                                                style="color:var(--web-text);">{{ $data['name'] }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                    <!-- <div class="topbar-text dropdown disable-autohide  __language-bar text-capitalize">
                        <a class="topbar-link dropdown-toggle" href="#" data-toggle="dropdown">
                            @foreach (json_decode($language['value'], true) as $data)
@if ($data['code'] == getDefaultLanguage())
{{ $data['name'] }}
@endif
@endforeach
                        </a>
                        <ul
                            class="text-align-direction dropdown-menu dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'right' : 'left' }}">
                            @foreach (json_decode($language['value'], true) as $key => $data)
@if ($data['status'] == 1)
<li class="change-language" data-action="{{ route('change-language') }}"
                                        data-language-code="{{ $data['code'] }}">
                                        <a class="dropdown-item pb-1" href="javascript:">
                                            <span class="text-capitalize">{{ $data['name'] }}</span>
                                        </a>
                                    </li>
@endif
@endforeach
                        </ul>
                    </div> -->
                </ul>
                @if (auth('customer')->check())
                    <div class="logout-btn mt-auto d-md-none">
                        <hr>
                        <a href="{{ route('customer.auth.logout') }}" class="nav-linknew">
                            <strong class="text-base">{{ translate('logout') }}</strong>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>
</header>

<div class="rightfloatheaders">
    <div class="float-sm">
        <a href="{{ route('quotationweb') }}" target="_blank">
            <div class="fl-fl float-fb text-white">
                <i class="fa fa-home"></i>
                RFQ
            </div>
        </a>
        <div class="fl-fl float-tw text-white">
            <i class="fa fa-user"></i>
            <a href="" target="_blank">Help</a>
        </div>
        <div class="fl-fl float-gp text-white">
            <i class="fa fa-info-circle"></i>
            <a href="" target="_blank">Info</a>
        </div>
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
@endpush
