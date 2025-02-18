@php($announcement = getWebConfig(name: 'announcement'))
<?php
$colorSetting = App\Models\BusinessSetting::where('type', 'colorsu')->first();
$hovercolor = $colorSetting ? json_decode($colorSetting->value, true)['hovercolor'] : '#FFFFFF';
$textcolor = App\Utils\ChatManager::getTextColorBasedOnBackground($hovercolor);
$checkerFunction = App\Utils\ChatManager::membershipChecker();
// If we want notification in future
?>
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/style.css') }}" />
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400&display=swap" rel="stylesheet">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/body.css') }}" />
<style>
    @media (min-width: 768px) {
        .navbar-expand-md {
            justify-content: space-between;
        }

        .width {
            max-width: 61% !important;
        }
    }

    @media screen and (max-width: 767px) {
        #navbarCollapse .nav-item {
            text-align: center;
        }
    }

    .navbar-expand-md {
        justify-content: center;
    }

    .nav-linknew:hover {
        color: var(--web-hover) !important;
        opacity: 1 !important;
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
    {{-- <div class="header_free_details">
        <div class="text-center text-white pt-1 pb-1 d-flex align-items-center justify-content-center gggrt">
            <p class="mb-0 me-2">Sign Up Today and be part of the largest B2B platform</p>
            <a href="{{ route('customer.auth.sign-up') }}" class="btn btn-sm text-white signupbutton"
    style="background-color: blue !important; border-radius: 40px !important; margin-top: 0;">
    Sign Up
    </a>
    </div>

    <!-- Dropdowns (aligned to the right) -->
    <div class="dropdowns-container ms-auto">
        <!-- Sign In/Sign Up Links (Aligned to the right) -->
        @if (!auth('customer')->check())
        <div class="d-flex justify-content-end text-white">
            <div>
                <a href="{{ route('customer.auth.login') }}" class="text-white btn-sm">
                    <span>Log In</span>
                </a> |
                <a href="{{ route('customer.auth.sign-up') }}" class="text-white btn-sm">
                    <span>Sign Up</span>
                </a> |
            </div>
        </div>
        @else
        <div class="dropdown" id="profileDropdownContainer">
            <a class="text-white dropdown-toggle btn-sm" href="#" id="profileDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                <span>Profile</span>
            </a>
            <ul class="dropdown-content p-0" aria-labelledby="profileDropdown">
                <a href="{{ route('account-oder') }}">{{ translate('my_Order') }}</a>
                <a href="{{ route('user-account') }}">{{ translate('my_Profile') }}
                    @if ($is_jobadder === true)
                    <a href="{{ route('job-panel') }}">{{ translate('job_Panel') }}</a>
                    @endif
                    <a href="{{ route('customer.auth.logout') }}">{{ translate('logout') }}</a>
            </ul>
        </div>
        @endif
        <!-- Buyer Dropdown -->
        <div class="dropdown">
            <button class="dropbtn btn-sm border-0">For Buyer</button>
            <div class="dropdown-content">
                <a href="{{ route('buyer') }}">My Orders</a>
                <a href="{{ route('buyer') }}">Order History</a>
                <a href="{{ route('buyer') }}">Payment Methods</a>
            </div>
        </div>
        <span class="text-white">|</span>
        <!-- Seller Dropdown -->
        <div class="dropdown">
            <button class="dropbtn btn-sm border-0">For Seller</button>
            <div class="dropdown-content">
                <a href="{{ route('seller') }}">Manage Listings</a>
                <a href="{{ route('seller') }}">Sales Report</a>
                <a href="{{ route('seller') }}">Payment Details</a>
            </div>
        </div>
    </div>
    </div> --}}

    <div class="centernavbar navbar-sticky bg-white mobile-head">
        <div class="firstnavbar navbar navbar-expand-md navbar-light" style="background-color:var(--web-firsthead);">
            <div class="addcontents d-flex flex-row align-items-center w-100" style="margin:0;">
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

                <div class="input-group-overlay search-form-mobile text-align-direction ml-1 mr-2" id="searchformclose">
                    <div class="section">
                        <div class="wrapper">
                            @if (str_contains(url()->current(), '/job-seeker'))
                                <form action="{{ route('jobseeker') }}" type="submit" class="wrapperform mb-0">
                                @elseif(str_contains(url()->current(), '/talent-finder'))
                                    <form action="{{ route('talentfinder') }}" type="submit" class="wrapperform mb-0">
                                    @else
                                        <form id="prosup" action="{{ route('products') }}" type="submit"
                                            class="wrapperform mb-0">
                            @endif
                            <div class="search_box">
                                @if (str_contains(url()->current(), '/job-seeker'))
                                    <div class="w-30 mr-m-1 position-relative my-auto"
                                        style="cursor: pointer;width: 105px;padding-left: 15px;">
                                        <span class="custom-dealrock-text">Search Profile</span>
                                    </div>
                                @elseif(str_contains(url()->current(), '/talent-finder'))
                                    <div class="w-30 mr-m-1 position-relative my-auto"
                                        style="cursor: pointer;width: 140px;padding-left: 15px;">
                                        <span class="custom-dealrock-text">Search Candidates</span>
                                    </div>
                                @else
                                    <div class="dropdown" id="productDropdown">
                                        <div class="d-flex h-100 flex-row align-items-center">
                                            <span class="default_option">Products</span>
                                            <span class="d-flex align-items-center" style="width: 20px; height: 100%;">
                                                <?xml version="1.0" ?><svg height="48" viewBox="0 0 48 48"
                                                    width="48" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M14.83 16.42l9.17 9.17 9.17-9.17 2.83 2.83-12 12-12-12z" />
                                                    <path d="M0-.75h48v48h-48z" fill="none" />
                                                </svg>
                                            </span>
                                        </div>
                                        <ul id="dropdownOptions">
                                            <li id="productssearch" data-value="products"
                                                data-route="{{ route('products') }}"
                                                data-placeholder="Search for products..."
                                                class="custom-dealrock-text">
                                                Products
                                            </li>
                                            <li id="leadsbuy" data-value="buyleads" data-route="{{ route('buyer') }}"
                                                data-placeholder="Search for buy leads..." class="custom-dealrock-text">
                                                Buy Leads
                                            </li>
                                            <li id="leadssell" data-value="sellleads"
                                                data-route="{{ route('seller') }}"
                                                data-placeholder="Search for sell leads..."
                                                class="custom-dealrock-text">
                                                Sell offer
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                                <div class="search_field">
                                    @if (str_contains(url()->current(), '/job-seeker'))
                                        <input class="custom-dealrock-text" type="text" id="searchInput" class="input" name="vacancy"
                                            style="width: inherit;height: 100%;border: 0;outline: 0;"    
                                            value="{{ request('vacancy') }}"
                                            placeholder="{{ translate('Search for job profiles') }}...">
                                    @elseif(str_contains(url()->current(), '/talent-finder'))
                                        <input class="custom-dealrock-text" type="text" id="searchInput" class="input" name="talentfinder"
                                            style="width: inherit;height: 100%;border: 0;outline: 0;"
                                            value="{{ request('talentfinder') }}"
                                            placeholder="{{ translate('Search for Candidates') }}...">
                                    @else
                                        <input class="custom-dealrock-text" type="text" id="searchInput" name="searchInput" class="input"
                                            style="width: inherit;height: 100%;border: 0;outline: 0;"
                                            value="{{ request('name') }}"
                                            placeholder="{{ translate('Search for products') }}...">
                                    @endif

                                    <div class="d-flex position-absolute searchbutton"
                                        onclick="document.getElementsByClassName('wrapperform')[0].submit()">
                                        {{-- <span>Search</span> --}}
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
            </div>

            <div class="navbar-toolbar d-flex flex-shrink-0 align-items-center">
                {{-- <a class="d-flex navbaricons hidewhensmall">
                    <div class="userscontainer">
                        <div class="user">
                            Registered Users
                        </div>
                        <div class="count">
                            13245
                        </div>
                    </div>
                </a> --}}
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
                                    <path
                                        d="M334.708,136.837c2.413-3.701,1.37-8.658-2.332-11.071C302.513,106.293,267.804,96,232,96C130.542,96,48,178.542,48,280
                                        s82.542,184,184,184s184-82.542,184-184c0-35.79-10.286-70.488-29.745-100.344c-2.413-3.701-7.369-4.748-11.07-2.334
                                        c-3.702,2.412-4.747,7.369-2.334,11.07C390.612,215.644,400,247.321,400,280c0,92.636-75.364,168-168,168S64,372.636,64,280
                                        s75.364-168,168-168c32.692,0,64.38,9.395,91.637,27.168C327.337,141.581,332.294,140.537,334.708,136.837z" />
                                    <path
                                        d="M306.644,175.699c2.346-3.744,1.212-8.681-2.532-11.026C282.525,151.149,257.589,144,232,144c-74.991,0-136,61.01-136,136
                                        s61.009,136,136,136s136-61.01,136-136c0-25.589-7.147-50.523-20.67-72.108c-2.346-3.744-7.283-4.879-11.026-2.532
                                        c-3.744,2.346-4.878,7.282-2.532,11.026C345.696,235.422,352,257.419,352,280c0,66.168-53.832,120-120,120s-120-53.832-120-120
                                        s53.832-120,120-120c22.582,0,44.58,6.304,63.617,18.23C299.362,180.577,304.298,179.443,306.644,175.699z" />
                                    <path
                                        d="M274.128,211.508c1.932-3.974,0.277-8.761-3.697-10.692C258.4,194.966,245.47,192,232,192c-48.523,0-88,39.477-88,88
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
                            <div class="inquiry-cart-label">
                                <span class="rfq custom-dealrock-text">
                                    {{-- <span class="circler">R</span>FQ --}}
                                    RFQ
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
                <div>
                    <div class="dropdown m-0">
                        <a class="navbaricons navbar-tool navbaricons m-0" href="{{ route('vendor.auth.login') }}"
                            type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="navbariconscontainer" style="color: var(--web-hover)">
                                <?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                                <svg fill="var(--web-hover)" class="headericon" viewBox="0 0 30 30"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M15.48 12c-.13.004-.255.058-.347.152l-2.638 2.63-1.625-1.62c-.455-.474-1.19.258-.715.712l1.983 1.978c.197.197.517.197.715 0l2.995-2.987c.33-.32.087-.865-.367-.865zM.5 16h3c.277 0 .5.223.5.5s-.223.5-.5.5h-3c-.277 0-.5-.223-.5-.5s.223-.5.5-.5zm0-4h3c.277 0 .5.223.5.5s-.223.5-.5.5h-3c-.277 0-.5-.223-.5-.5s.223-.5.5-.5zm0-4h3c.277 0 .5.223.5.5s-.223.5-.5.5h-3C.223 9 0 8.777 0 8.5S.223 8 .5 8zm24 11c-1.375 0-2.5 1.125-2.5 2.5s1.125 2.5 2.5 2.5 2.5-1.125 2.5-2.5-1.125-2.5-2.5-2.5zm0 1c.834 0 1.5.666 1.5 1.5s-.666 1.5-1.5 1.5-1.5-.666-1.5-1.5.666-1.5 1.5-1.5zm-13-1C10.125 19 9 20.125 9 21.5s1.125 2.5 2.5 2.5 2.5-1.125 2.5-2.5-1.125-2.5-2.5-2.5zm0 1c.834 0 1.5.666 1.5 1.5s-.666 1.5-1.5 1.5-1.5-.666-1.5-1.5.666-1.5 1.5-1.5zm-5-14C5.678 6 5 6.678 5 7.5v11c0 .822.678 1.5 1.5 1.5h2c.676.01.676-1.01 0-1h-2c-.286 0-.5-.214-.5-.5v-11c0-.286.214-.5.5-.5h13c.286 0 .5.214.5.5V19h-5.5c-.66 0-.648 1.01 0 1h7c.66 0 .654-1 0-1H21v-9h4.227L29 15.896V18.5c0 .286-.214.5-.5.5h-1c-.654 0-.654 1 0 1h1c.822 0 1.5-.678 1.5-1.5v-2.75c0-.095-.027-.19-.078-.27l-4-6.25c-.092-.143-.25-.23-.422-.23H21V7.5c0-.822-.678-1.5-1.5-1.5z" />
                                </svg>
                                <div class="inquiry-cart-label">
                                    <span class="rfq custom-dealrock-text">
                                        {{-- <span class="circler">S</span>upplier --}}
                                        Supplier
                                    </span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}"
                            aria-labelledby="dropdownMenuButton" style="border-radius: 10px;">
                            <div class="detailsboxtop">
                                <h5 class="custom-dealrock-head">What you get!</h5>
                                <ul class="feature-list">
                                    <li>
                                        <div class="leftclass custom-dealrock-head">
                                            <i class="fa fa-box"></i>
                                        </div>
                                        <div class="rightclass">
                                            <strong class="custom-dealrock-subhead">Product Management</strong><br>
                                            <span class="custom-dealrock-subtext">Add, update, and remove products with ease.</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="leftclass custom-dealrock-head">
                                            <i class="fa fa-chart-bar"></i>
                                        </div>
                                        <div class="rightclass">
                                            <strong class="custom-dealrock-subhead">Analytics & Insights</strong><br>
                                            <span class="custom-dealrock-subtext">Track sales, inventory, and product performance.</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="leftclass custom-dealrock-head">
                                            <i class="fa fa-credit-card"></i>
                                        </div>
                                        <div class="rightclass">
                                            <strong class="custom-dealrock-subhead">Secure Payments</strong><br>
                                            <span class="custom-dealrock-subtext">Manage payments and invoices securely.</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="dropdown m-0">
                        <a class="navbaricons navbar-tool navbaricons m-0" href="{{ route('vendor.auth.login') }}"
                            type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="navbariconscontainer" style="color: var(--web-hover)">
                                <?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                                <svg fill="var(--web-hover)" class="headericon" viewBox="0 0 960 960"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M475.448 702.412C406.938 702.412 338.418 703.092 269.923 702.076C205.224 702.528 118.821 694.142 117.31 611.319C112.909 527.954 96.3122 443.624 111.185 360.523C121.543 295.895 184.177 278.786 241.534 281.049C346.158 280.958 450.662 277.947 555.135 272.347C638.446 276.542 803.163 233.744 838.578 334.493C851.77 378.589 849.595 425.196 853.469 470.642C854.912 551.558 854.938 677.444 754.205 695.674C661.995 711.931 568.458 701.093 475.444 704.164C475.447 703.58 475.447 702.996 475.448 702.412ZM424.622 653.074C424.621 653.061 424.621 653.047 424.62 653.034C519.763 653.034 614.906 653.103 710.049 652.999C776.124 655.617 807.69 585.914 804.711 528.595C808.575 461.92 801.304 395.328 782.441 331.14C768.717 312.967 717.164 311.381 695.094 311.293C537.13 317.207 379.137 323.333 221.076 326.218C201.511 328.984 175.282 328.691 165.347 349.288C154.86 369.239 153.29 391.06 153.743 412.561C154.682 457.068 157.185 501.557 159.824 546.007C161.193 569.077 163.997 592.074 166.576 615.056C168.537 632.529 179.098 643.339 195.797 646.741C271.107 659.787 348.492 650.533 424.622 653.074Z"
                                        fill="var(--web-hover)" />
                                    <path
                                        d="M477.551 131.476C477.551 109.336 477.321 87.1927 477.629 65.0577C478.279 31.4447 525.841 32.6197 525.416 66.9797C525.588 109.755 525.624 152.555 524.038 195.309C524.342 228.391 478.256 230.876 477.717 197.893C477.463 175.757 477.651 153.615 477.651 131.476C477.617 131.476 477.584 131.476 477.551 131.476Z"
                                        fill="var(--web-hover)" />
                                    <path
                                        d="M506.142 840.64C505.863 859.791 506.756 879.035 505.714 898.146C502.457 927.761 460.741 926.06 459.773 896.353C458.062 860.542 457.865 824.677 457.012 788.839C456.646 772.785 464.647 761.025 477.398 759.15C519.249 756.101 503.067 814.414 505.94 840.64C506.007 840.64 506.075 840.64 506.142 840.64Z"
                                        fill="var(--web-hover)" />
                                    <path
                                        d="M363.714 255.667C351.164 252.159 341.517 244.565 332.533 235.415C318.342 222.562 304.325 209.515 290.014 196.798C261.892 176.103 291.903 134.481 320.23 158.968C341.25 179.104 364.659 197.877 382.331 221.08C391.369 236.024 381.279 254.241 363.714 255.667Z"
                                        fill="var(--web-hover)" />
                                    <path
                                        d="M586.134 731.82C612.423 741.785 631.461 764.062 653.596 780.724C677.253 799.103 651.146 832.567 627.418 814.943C608.954 801.911 590.834 788.362 572.97 774.513C554.591 760.479 563.727 733.745 586.134 731.82Z"
                                        fill="var(--web-hover)" />
                                    <path
                                        d="M604.674 246.415C581.352 244.941 575.988 216.978 593.687 204.619C609.585 191.484 625.805 178.734 641.996 165.955C649.021 160.41 656.941 157.972 665.729 161.025C682.581 166.88 685.922 187.821 671.5 200.173C649.968 216.364 630.145 236.656 604.674 246.415Z"
                                        fill="var(--web-hover)" />
                                    <path
                                        d="M351.843 738.77C411.404 753.772 344.094 807.091 315.128 815.999C305.271 820.098 294.752 814.353 289.6 805.468C284.525 796.714 284.947 784.815 293.07 777.95C308.038 765.301 323.986 753.782 339.88 742.282C343.054 739.986 347.815 739.884 351.843 738.77Z"
                                        fill="var(--web-hover)" />
                                    <path
                                        d="M424.623 653.077C348.489 650.54 271.113 659.786 195.797 646.749C179.099 643.343 168.538 632.533 166.577 615.06C163.998 592.078 161.195 569.081 159.825 546.011C157.186 501.561 154.683 457.072 153.744 412.565C153.29 391.063 154.86 369.242 165.348 349.293C175.217 328.67 201.578 329.015 221.076 326.222C379.138 323.337 537.132 317.21 695.094 311.297C717.752 311.397 768.342 312.951 782.446 331.141C801.292 395.335 808.587 461.921 804.711 528.6C807.657 585.896 776.163 655.649 710.048 653C614.907 653.105 519.764 653.037 424.622 653.037C424.622 653.051 424.622 653.064 424.623 653.077ZM368.82 469.328C439.009 377.24 246.578 302.471 241.47 416.55C244.678 463.207 244.995 509.977 245.965 556.716C249.255 593.656 293.969 585.89 320.42 587.38C378.188 587.352 414.98 517.669 368.82 469.328ZM395.989 472.889C396.939 488.33 397.129 500.549 398.547 512.624C399.841 571.073 474.145 626.171 519.168 572.358C559.797 523.729 550.58 456.286 548.107 397.482C547.844 367.977 507.368 367.875 508.864 398.04C510.387 446.775 522.001 503.822 491.077 545.863C481.027 556.913 471.495 557.814 459.549 548.856C423.144 522.765 441.346 431.359 439.96 389.689C442.001 365.239 410.587 359.752 405.285 384.257C398.04 412.719 398.924 446.295 395.989 472.889ZM635.924 445.95C619.304 419.91 605.823 397.084 589.652 372.233C572.704 347.414 543.327 370.115 558.444 394.233C574.813 420.677 590.549 447.552 607.988 473.272C613.386 481.233 615.111 488.329 614.745 497.263C613.653 523.868 612.813 550.489 612.337 577.113C612.138 588.257 619.96 596.29 629.883 596.53C640.143 596.778 647.729 589.619 648.209 578.107C649.392 549.76 650.385 521.401 650.926 493.036C651.057 486.19 651.896 480.881 657.883 476.405C680.354 452.527 693.688 420.701 712.138 393.599C723.858 375.599 701.459 354.103 685.052 369.495C666.777 394.404 654.855 420.572 635.924 445.95Z"
                                        fill="white" />
                                    <path
                                        d="M368.82 469.325C414.982 517.664 378.186 587.351 320.42 587.378C293.995 585.918 249.225 593.644 245.965 556.713C244.995 509.975 244.678 463.204 241.473 416.547C246.569 302.49 439.017 377.212 368.82 469.325ZM279.024 494.857C282.425 549.219 262.479 545.358 322.199 546.758C351.242 547.668 362.807 500.496 331.33 495.226C314.736 493.607 297.86 494.857 279.024 494.857ZM280.399 455.035C296.481 453.096 311.678 451.561 326.756 449.243C373.611 433.678 318.565 386.534 289.565 401.13C285.939 402.511 281.014 406.654 280.812 409.79C279.877 424.283 280.399 438.869 280.399 455.035Z"
                                        fill="var(--web-hover)" />
                                    <path
                                        d="M395.988 472.887C398.921 446.293 398.04 412.717 405.282 384.254C410.612 359.793 441.976 365.196 439.961 389.688C441.316 431.199 423.198 522.953 459.545 548.855C471.494 557.812 481.026 556.911 491.073 545.861C522.003 503.807 510.379 446.789 508.865 398.039C507.331 367.934 547.871 367.928 548.106 397.482C550.585 456.266 559.795 523.748 519.165 572.36C474.139 626.137 399.841 571.098 398.55 512.62C397.128 500.547 396.938 488.327 395.988 472.887Z"
                                        fill="var(--web-hover)" />
                                    <path
                                        d="M635.922 445.95C654.849 420.58 666.782 394.393 685.047 369.493C701.387 354.159 723.908 375.532 712.13 393.598C693.687 420.7 680.348 452.529 657.882 476.407C651.892 480.881 651.053 486.19 650.923 493.036C650.382 521.401 649.389 549.76 648.206 578.107C647.726 589.618 640.14 596.778 629.88 596.53C619.958 596.29 612.135 588.258 612.334 577.113C612.81 550.49 613.651 523.869 614.742 497.263C615.109 488.329 613.383 481.232 607.985 473.272C590.546 447.551 574.81 420.676 558.44 394.232C543.368 370.17 572.644 347.362 589.65 372.234C605.824 397.089 619.299 419.907 635.922 445.95Z"
                                        fill="var(--web-hover)" />
                                    <path
                                        d="M279.023 494.859C297.859 494.859 314.735 493.609 331.331 495.229C362.794 500.503 351.254 547.669 322.198 546.76C262.457 545.379 282.43 549.156 279.023 494.859Z"
                                        fill="white" />
                                    <path
                                        d="M280.399 455.035C280.399 438.87 279.877 424.283 280.812 409.79C281.014 406.655 285.939 402.511 289.565 401.128C318.575 386.54 373.609 433.677 326.756 449.245C311.678 451.561 296.48 453.095 280.399 455.035Z"
                                        fill="white" />
                                </svg>
                                <div class="inquiry-cart-label">
                                    <span class="rfq custom-dealrock-text">
                                        {{-- <span class="circler">B</span>uyer --}}
                                        Buyer
                                    </span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}"
                            aria-labelledby="dropdownMenuButton" style="border-radius: 10px;">
                            <div class="detailsboxtop">
                                <h5>Register Today!</h5>
                                <ul class="feature-list">
                                    <li>
                                        <div class="leftclass custom-dealrock-head">
                                            <i class="fa fa-search"></i>
                                        </div>
                                        <div class="rightclass">
                                            <strong class="custom-dealrock-subhead">Easy Browsing</strong><br>
                                            <span class="custom-dealrock-subtext">Find products quickly across various categories.</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="leftclass custom-dealrock-head">
                                            <i class="fa fa-heart"></i>
                                        </div>
                                        <div class="rightclass">
                                            <strong class="custom-dealrock-subhead">Wishlist</strong><br>
                                            <span class="custom-dealrock-subtext">Save your favorite items for future purchases.</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="leftclass custom-dealrock-head">
                                            <i class="fa fa-shield-alt"></i>
                                        </div>
                                        <div class="rightclass">
                                            <strong class="custom-dealrock-subhead">Secure Checkout</strong><br>
                                            <span class="custom-dealrock-subtext">Enjoy multiple payment options for a smooth experience.</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <a class="navbaricons" href="{{ route('membership') }}">
                        <div class="navbariconscontainer" style="color: var(--web-hover)">
                            <?xml version="1.0" encoding="iso-8859-1"?>
                            <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                            <svg class="headericon" fill="var(--web-hover)"  version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                                viewBox="0 0 512 512" xml:space="preserve">
                            <g>
                                <g>
                                    <path d="M256,49.021c-114.129,0-206.979,92.85-206.979,206.979S141.871,462.979,256,462.979S462.979,370.129,462.979,256
                                        S370.129,49.021,256,49.021z M256,446.638c-105.118,0-190.638-85.52-190.638-190.638S150.882,65.362,256,65.362
                                        S446.638,150.882,446.638,256S361.118,446.638,256,446.638z"/>
                                </g>
                            </g>
                            <g>
                                <g>
                                    <path d="M384,247.83h-24.511v-16.34h2.723c4.513,0,8.17-3.658,8.17-8.17s-3.657-8.17-8.17-8.17h-2.723v-13.617
                                        c0-22.526-18.325-40.851-40.851-40.851h-14.44C300.403,142.057,283.899,128,264.17,128h-16.34
                                        c-19.728,0-36.233,14.057-40.029,32.681h-14.44c-22.526,0-40.851,18.325-40.851,40.851v13.617h-2.723
                                        c-4.513,0-8.17,3.658-8.17,8.17s3.657,8.17,8.17,8.17h193.362v89.872c0,13.516-10.996,24.511-24.511,24.511H193.362
                                        c-13.515,0-24.511-10.995-24.511-24.511V256c0-4.512-3.657-8.17-8.17-8.17H128c-4.513,0-8.17,3.658-8.17,8.17
                                        c0,4.512,3.657,8.17,8.17,8.17h24.511v57.191c0,22.526,18.325,40.851,40.851,40.851h125.277c22.526,0,40.851-18.325,40.851-40.851
                                        V264.17H384c4.513,0,8.17-3.658,8.17-8.17C392.17,251.488,388.513,247.83,384,247.83z M247.83,144.34h16.34
                                        c10.651,0,19.733,6.831,23.105,16.34h-62.551C228.097,151.172,237.179,144.34,247.83,144.34z M343.149,215.149H168.851v-13.617
                                        c0-13.516,10.996-24.511,24.511-24.511h125.277c13.515,0,24.511,10.995,24.511,24.511V215.149z"/>
                                </g>
                            </g>
                            <g>
                                <g>
                                    <path d="M512,256c0-17.532-6.139-34.196-17.384-47.464c5.314-16.56,4.607-34.305-2.104-50.503
                                        c-6.708-16.198-18.757-29.244-34.223-37.197c-1.43-17.334-8.873-33.456-21.27-45.854c-12.397-12.398-28.521-19.841-45.854-21.27
                                        c-7.953-15.468-21-27.515-37.197-34.224c-8.983-3.721-18.432-5.607-28.085-5.607c-7.642,0-15.161,1.178-22.418,3.504
                                        C290.197,6.137,273.533,0,256,0s-34.197,6.137-47.464,17.384c-7.257-2.328-14.776-3.504-22.418-3.504
                                        c-9.653,0-19.102,1.887-28.085,5.607c-16.198,6.709-29.245,18.757-37.197,34.224c-17.335,1.429-33.459,8.873-45.857,21.27
                                        c-12.397,12.397-19.839,28.521-21.269,45.854c-15.467,7.953-27.515,21.001-34.223,37.197c-6.709,16.198-7.416,33.942-2.104,50.503
                                        C6.139,221.804,0,238.468,0,256s6.139,34.196,17.384,47.464c-5.313,16.562-4.607,34.306,2.104,50.503
                                        c6.708,16.198,18.757,29.244,34.223,37.197c1.43,17.334,8.873,33.456,21.27,45.854c12.397,12.398,28.521,19.841,45.854,21.27
                                        c7.953,15.468,21,27.515,37.197,34.224c8.983,3.721,18.432,5.607,28.084,5.607c7.643,0,15.162-1.178,22.419-3.505
                                        C221.803,505.863,238.467,512,256,512s34.197-6.137,47.464-17.384c7.257,2.328,14.776,3.504,22.419,3.504
                                        c9.652,0,19.101-1.887,28.084-5.607c16.198-6.709,29.245-18.757,37.197-34.224c17.334-1.429,33.458-8.873,45.856-21.27
                                        c12.397-12.397,19.839-28.521,21.269-45.854c15.467-7.953,27.515-21.001,34.223-37.197c6.709-16.199,7.417-33.943,2.104-50.503
                                        C505.861,290.196,512,273.532,512,256z M477.682,304.635c5.563,13.935,5.47,29.234-0.265,43.08
                                        c-5.735,13.845-16.486,24.73-30.274,30.65c-2.966,1.273-4.904,4.174-4.946,7.402c-0.194,15.004-6.135,29.102-16.732,39.699
                                        c-10.597,10.596-24.695,16.539-39.698,16.732c-3.228,0.041-6.129,1.979-7.402,4.947c-5.921,13.788-16.806,24.539-30.65,30.274
                                        c-6.99,2.896-14.336,4.364-21.831,4.364c-7.288,0-14.438-1.379-21.25-4.098c-3-1.199-6.422-0.517-8.731,1.736
                                        C285.157,489.892,270.985,495.66,256,495.66c-14.985,0-29.157-5.767-39.902-16.24c-1.555-1.515-3.611-2.319-5.704-2.319
                                        c-1.019,0-2.046,0.191-3.026,0.583c-6.813,2.719-13.961,4.098-21.25,4.098c-7.496,0-14.84-1.468-21.831-4.364
                                        c-13.845-5.734-24.73-16.486-30.65-30.274c-1.273-2.966-4.174-4.904-7.402-4.947c-15.004-0.193-29.102-6.135-39.698-16.732
                                        c-10.597-10.597-16.539-24.695-16.732-39.699c-0.041-3.228-1.979-6.128-4.946-7.402c-13.788-5.921-24.539-16.806-30.274-30.65
                                        c-5.734-13.844-5.829-29.144-0.265-43.08c1.197-2.998,0.516-6.42-1.738-8.731C22.109,285.156,16.34,270.985,16.34,256
                                        c0-14.985,5.768-29.156,16.24-39.902c2.253-2.312,2.934-5.733,1.738-8.731c-5.563-13.936-5.47-29.236,0.265-43.08
                                        c5.735-13.845,16.486-24.73,30.274-30.65c2.966-1.273,4.904-4.174,4.946-7.402c0.194-15.004,6.135-29.102,16.732-39.698
                                        c10.597-10.596,24.695-16.539,39.699-16.732c3.228-0.041,6.129-1.979,7.402-4.947c5.921-13.788,16.806-24.539,30.65-30.274
                                        c6.99-2.896,14.336-4.364,21.832-4.364c7.288,0,14.437,1.379,21.249,4.098c2.996,1.196,6.421,0.516,8.731-1.736
                                        C226.843,22.108,241.014,16.34,256,16.34c14.986,0,29.157,5.767,39.902,16.24c2.311,2.252,5.733,2.935,8.731,1.736
                                        c6.812-2.719,13.96-4.098,21.249-4.098c7.496,0,14.841,1.468,21.832,4.364c13.845,5.734,24.73,16.486,30.65,30.274
                                        c1.273,2.966,4.174,4.904,7.402,4.947c15.004,0.193,29.102,6.135,39.699,16.732c10.597,10.597,16.539,24.695,16.732,39.699
                                        c0.041,3.228,1.979,6.128,4.946,7.402c13.788,5.921,24.539,16.806,30.274,30.65c5.734,13.845,5.829,29.145,0.265,43.08
                                        c-1.197,2.998-0.516,6.42,1.738,8.731c10.472,10.747,16.24,24.917,16.24,39.902c0,14.985-5.768,29.156-16.24,39.902
                                        C477.165,298.214,476.485,301.637,477.682,304.635z"/>
                                </g>
                            </g>
                            <g>
                                <g>
                                    <path d="M256,81.702c-96.109,0-174.298,78.19-174.298,174.298c0,40.171,14.057,79.407,39.583,110.48
                                        c2.865,3.488,8.013,3.99,11.499,1.128c3.486-2.864,3.991-8.012,1.126-11.499C110.78,327.95,98.043,292.399,98.043,256
                                        c0-87.098,70.86-157.957,157.957-157.957S413.957,168.902,413.957,256S343.098,413.957,256,413.957
                                        c-36.399,0-71.951-12.738-100.107-35.868c-3.484-2.864-8.633-2.361-11.499,1.126c-2.865,3.486-2.361,8.635,1.126,11.499
                                        c31.071,25.526,70.307,39.583,110.48,39.583c96.109,0,174.298-78.19,174.298-174.298S352.109,81.702,256,81.702z"/>
                                </g>
                            </g>
                            </svg>
                            <div class="inquiry-cart-label">
                                <span class="rfq custom-dealrock-text">
                                    {{-- <span class="circler">R</span>FQ --}}
                                    Membership
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
                @if (auth('customer')->check())
                    <div class="dropdown m-0">
                        <a class="navbar-tool navbaricons m-0" type="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <div class="navbar-tool-icon-box bg-secondary">
                                <div class="navbar-tool-icon-box bg-secondary">
                                    <img class="img-profile rounded-circle __inline-14" alt=""
                                        src="{{ getStorageImages(path: auth('customer')->user()->image_full_url, type: 'avatar') }}">
                                </div>
                            </div>
                            {{-- <div class="navbar-tool-text">
                                <small>{{ translate('hello')}}, {{auth('customer')->user()->f_name}}</small>
                                {{ translate('dashboard')}}
                            </div> --}}
                        </a>
                        <div class="dropdown-menu dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}"
                            aria-labelledby="dropdownMenuButton" style="border-radius: 10px;">
                            <a class="dropdown-item custom-dealrock-text" href="{{ route('account-oder') }}"> {{ translate('my_Order') }}
                            </a>
                            <a class="dropdown-item custom-dealrock-text" href="{{ route('user-account') }}">
                                {{ translate('my_Profile') }}</a>
                            @if ($is_jobadder === true)
                                <a class="dropdown-item custom-dealrock-text"
                                    href="{{ route('job-panel') }}">{{ translate('job_Panel') }}</a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item custom-dealrock-text"
                                href="{{ route('customer.auth.logout') }}">{{ translate('logout') }}</a>
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
                                <div class="inquiry-cart-label custom-dealrock-text">Messages</div>
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
                                <div class="inquiry-cart-label custom-dealrock-text">Messages</div>
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
    <div class="centernavbar secondnavbar navbar navbar-expand-md navbar-stuck-menu" style="background-color:var(--web-secondhead);">
        <div class="collapse navbar-collapse text-align-direction justify-content-center" id="navbarCollapse">
            <div class="w-100 d-md-none text-align-direction">
                <button class="navbar-toggler p-0" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" id="navbarbutton">
                    <i class="tio-clear __text-26px"></i>
                </button>
            </div>
            <div class="custom-dropdown">
                <div class="dropdown-trigger custom-dealrock-text" style="font-weight: bold;">
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
                                <a class="dropdown-item custom-dealrock-text"
                                    href="{{ route('products', ['category_id' => $category['id'], 'data_from' => 'category', 'page' => 1]) }}">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
            <span style="color:var(--web-secondhead); border-right: 1px solid var(--web-secondhead); height: 24px; filter: brightness(90%);">
                {{-- | --}}
            </span>
            <ul class="navbar-nav d-block d-md-none">
                <li class="nav-item dropdown {{ request()->is('/') ? 'active' : '' }}">
                    <a class="nav-linknew custom-dealrock-text" href="{{ route('home') }}">{{ translate('home') }}</a>
                </li>
            </ul>

            @php($categories = \App\Utils\CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting(dataLimit: 11))

            <ul class="navbar-nav mega-nav1 pr-md-2 pl-md-2 d-block d-xl-none">
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item dropdown d-none d-md-block {{ request()->is('/') ? 'active' : '' }}">
                    <a class="nav-linknew custom-dealrock-text" href="{{ route('home') }}">{{ translate('home') }}</a>
                </li>


                @if ($web_config['digital_product_setting'] && count($web_config['publishing_houses']) == 1)
                    <li class="nav-item dropdown d-none d-md-block {{ request()->is('/') ? 'active' : '' }}">
                        <a class="nav-link custom-dealrock-text"
                            href="{{ route('products', ['publishing_house_id' => 0, 'product_type' => 'digital', 'page' => 1]) }}">
                            {{ translate('Publication_House') }}
                        </a>
                    </li>
                @elseif ($web_config['digital_product_setting'] && count($web_config['publishing_houses']) > 1)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle custom-dealrock-text" href="#" data-toggle="dropdown">
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
                                            <a class="dropdown-item custom-dealrock-text"
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
                                    <a class="dropdown-item web-text-primary custom-dealrock-text"
                                        href="{{ route('products', ['product_type' => 'digital', 'page' => 1]) }}">
                                        {{ translate('view_more') }}
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                @endif

                @php($businessMode = getWebConfig(name: 'business_mode'))
                @if (auth('customer')->check())
                    <li class="nav-item d-md-none">
                        <a href="{{ route('user-account') }}" class="nav-linknew text-capitalize custom-dealrock-text">
                            {{ translate('user_profile') }}
                        </a>
                    </li>
                    <li class="nav-item d-md-none">
                        <a href="{{ route('wishlists') }}" class="nav-linknew custom-dealrock-text">
                            {{ translate('Wishlist') }}
                        </a>
                    </li>
                @else
                    <li class="nav-item d-md-none">
                        <a class="dropdown-item pl-2 custom-dealrock-text" href="{{ route('customer.auth.login') }}">
                            <i class="fa fa-sign-in mr-2"></i> {{ translate('sign_in') }}
                        </a>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="dropdown-item pl-2 custom-dealrock-text" href="{{ route('customer.auth.sign-up') }}">
                            <i class="fa fa-user-circle mr-2"></i>{{ translate('sign_up') }}
                        </a>
                    </li>
                @endif

                @if ($businessMode == 'multi')
                    @if (getWebConfig(name: 'seller_registration'))
                        <li class="nav-item">
                            <div class="dropdown">
                                <a class="nav-linknew dropdown-toggle custom-dealrock-text" href="#" type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    {{ translate('vendor_zone') }}
                                </a>
                                <div class="dropdown-content" aria-labelledby="dropdownMenuButton"
                                    style="position: absolute; background-color: white; 
                                                z-index: 1000; left: 0; top: 100%; 
                                                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
                                                width: auto; min-width: 165px;">
                                    <a class="dropdown-item text-nowrap text-capitalize custom-dealrock-text"
                                        href="{{ route('vendor.auth.registration.index') }}">
                                        {{ translate('become_a_vendor') }}
                                    </a>
                                    <a class="dropdown-item text-nowrap custom-dealrock-text" 
                                        href="{{ route('vendor.auth.login') }}">
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
                        <a href="{{ route('stocksale') }}" class="nav-linknew custom-dealrock-text">
                            Stock Sale
                        </a>
                    </li>
                    <li class="nav-itemnew">
                        <a href="{{ route('buyer') }}" class="nav-linknew custom-dealrock-text">
                            Buy Leads
                        </a>
                    </li>
                    <li class="nav-itemnew">
                        <a href="{{ route('sendcv') }}" class="nav-linknew custom-dealrock-text">
                            Industry Jobs
                        </a>
                    </li>
                    <li class="nav-itemnew">
                        <a href="{{ route('seller') }}" class="nav-linknew custom-dealrock-text">
                            Sell Offer
                        </a>
                    </li>
                    <li class="nav-itemnew">
                        <a class="nav-linknew custom-dealrock-text" href="{{ route('dealassist') }}">
                            Deal Assist
                        </a>
                    </li>
                    <li class="nav-itemnew">
                        <a href="{{ route('tradeshow') }}" class="nav-linknew custom-dealrock-text">
                            Trade Shows
                        </a>
                    </li>
                    <li class="nav-itemnew dropdown">
                        <a class="nav-linknew custom-dealrock-text dropdown-toggle" href="#"
                            data-toggle="dropdown">{{ translate('Help') }}</a>
                        <ul class="dropdown-content p-0" style="font-size: 14px; color: black;">
                            <a class="dropdown-item custom-dealrock-text">Q & A's</a>
                            <a class="dropdown-item custom-dealrock-text">Customer Helpdesk</a>
                            <a class="dropdown-item custom-dealrock-text">Vendor Helpdesk</a>
                            <a class="dropdown-item custom-dealrock-text">Contact an Agent</a>
                            <a class="dropdown-item custom-dealrock-text">Contact a Helper</a>
                        </ul>
                    </li>

                    <li class="nav-itemnew dropdown">
                        <a class="nav-linknew custom-dealrock-text dropdown-toggle text-capitalize" href="#" data-toggle="dropdown">
                            @foreach (json_decode($language['value'], true) as $data)
                                @if ($data['code'] == getDefaultLanguage())
                                    {{ $data['name'] }}
                                @endif
                            @endforeach
                        </a>
                        <ul class="dropdown-content p-0" style="font-size: 14px; color: black;">
                            @foreach (json_decode($language['value'], true) as $key => $data)
                                @if ($data['status'] == 1)
                                    <li class="change-language __inline-17"
                                        data-action="{{ route('change-language') }}"
                                        data-language-code="{{ $data['code'] }}">
                                        <a class="dropdown-item custom-dealrock-text" href="javascript:">
                                            <span class="text-capitalize">{{ $data['name'] }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>

                    <div class="dropdowns-container ms-auto">
                        @if (!auth('customer')->check())
                            <div class="d-flex justify-content-end text-white">
                                <div class="brrgergr">
                                    <div class="nav-itemnew">
                                        <a href="{{ route('customer.auth.login') }}" class="nav-linknew custom-dealrock-text">
                                            <span>Log In</span>
                                        </a>
                                    </div>
                                    <div class="nav-itemnew">
                                        <a href="{{ route('customer.auth.sign-up') }}" class="nav-linknew custom-dealrock-text">
                                            <span>Sign Up</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- <div class="dropdown nav-itemnew" id="profileDropdownContainer">
                                <a class="dropdown-toggle btn-sm nav-linknew custom-dealrock-text" href="#" id="profileDropdown"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false"
                                    style="cursor: pointer;">
                                    <span>Profile</span>
                                </a>
                                <ul class="dropdown-content p-0" aria-labelledby="profileDropdown">
                                    <a href="{{ route('account-oder') }}">{{ translate('my_Order') }}</a>
                                    <a href="{{ route('user-account') }}">{{ translate('my_Profile') }}
                                        @if ($is_jobadder === true)
                                            <a href="{{ route('job-panel') }}">{{ translate('job_Panel') }}</a>
                                        @endif
                                        <a href="{{ route('customer.auth.logout') }}">{{ translate('logout') }}</a>
                                </ul>
                            </div> --}}
                        @endif
                    </div>
                    {{-- <a class="d-flex align-content-center" href="{{ route('webinfo') }}">
                        <li class="d-flex align-content-center mr-2 ml-2 dropdown m-0 randomshit"
                            style="list-style: none;">
                            <div class="align-content-center dropdown-toggle" type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <span>Info</span>
                            </div>
                            <div class="dropdown-menu dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}"
                                aria-labelledby="dropdownMenuButton" style="border-radius: 10px;">
                                <div class="detailsboxtop">
                                    <h5>Register Today!</h5>
                                    <ul class="feature-list">
                                        <li>
                                            <div class="leftclass">
                                                <i class="fa fa-search"></i>
                                            </div>
                                            <div class="rightclass">
                                                <strong>Easy Browsing</strong><br>
                                                <span>Find products quickly across various categories.</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="leftclass">
                                                <i class="fa fa-heart"></i>
                                            </div>
                                            <div class="rightclass">
                                                <strong>Wishlist</strong><br>
                                                <span>Save your favorite items for future purchases.</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="leftclass">
                                                <i class="fa fa-shield-alt"></i>
                                            </div>
                                            <div class="rightclass">
                                                <strong>Secure Checkout</strong><br>
                                                <span>Enjoy multiple payment options for a smooth experience.</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </a> --}}
                </ul>
            </div>
            <ul class="navbar-navnew checkhidden" id="navbar">
                <li class="nav-itemnew">
                    <a href="{{ route('stocksale') }}" class="nav-linknew custom-dealrock-text">
                        Stock Sale
                    </a>
                </li>
                <li class="nav-itemnew">
                    <a href="{{ route('buyer') }}" class="nav-linknew custom-dealrock-text">
                        Buy Leads
                    </a>
                </li>
                <li class="nav-itemnew">
                    <a href="{{ route('sendcv') }}" class="nav-linknew custom-dealrock-text">
                        Industry Jobs
                    </a>
                </li>
                <li class="nav-itemnew">
                    <a href="{{ route('seller') }}" class="nav-linknew custom-dealrock-text">
                        Sell Offer
                    </a>
                </li>
                <li class="nav-itemnew">
                    <a class="nav-linknew custom-dealrock-text" href="{{ route('dealassist') }}">
                        Deal Assist
                    </a>
                </li>
                <li class="nav-itemnew">
                    <a href="{{ route('tradeshow') }}" class="nav-linknew custom-dealrock-text">
                        Trade Shows
                    </a>
                </li>
                <li class="nav-itemnew dropdown">
                    <a class="nav-linknew custom-dealrock-text dropdown-toggle" href="#"
                        data-toggle="dropdown">{{ translate('Help') }}</a>
                    <ul class="dropdown-content  p-0" style="font-size: 14px; color: black;">
                        <a class="dropdown-item custom-dealrock-text">Q & A's</a>
                        <a class="dropdown-item custom-dealrock-text">Customer Helpdesk</a>
                        <a class="dropdown-item custom-dealrock-text">Vendor Helpdesk</a>
                        <a class="dropdown-item custom-dealrock-text">Contact an Agent</a>
                        <a class="dropdown-item custom-dealrock-text">Contact a Helper</a>
                    </ul>
                </li>

                <li class="nav-itemnew dropdown">
                    <a class="nav-linknew custom-dealrock-text dropdown-toggle text-capitalize" href="#" data-toggle="dropdown">
                        @foreach (json_decode($language['value'], true) as $data)
                            @if ($data['code'] == getDefaultLanguage())
                                {{ $data['name'] }}
                            @endif
                        @endforeach
                    </a>
                    <ul class="dropdown-content  p-0" style="font-size: 14px; color: black;">
                        @foreach (json_decode($language['value'], true) as $key => $data)
                            @if ($data['status'] == 1)
                                <li class="change-language __inline-17" data-action="{{ route('change-language') }}"
                                    data-language-code="{{ $data['code'] }}">
                                    <a class="dropdown-item custom-dealrock-text" href="javascript:">
                                        <span class="text-capitalize">{{ $data['name'] }}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
                <div class="dropdowns-container ms-auto">
                    @if (!auth('customer')->check())
                        <div class="d-flex justify-content-end text-white">
                            <div class="nav-itemnew">
                                <a href="{{ route('customer.auth.login') }}" class="nav-linknew custom-dealrock-text">
                                    <span>Log In</span>
                                </a>
                            </div>
                            <div class="nav-itemnew">
                                <a href="{{ route('customer.auth.sign-up') }}" class="nav-linknew custom-dealrock-text">
                                    <span>Sign Up</span>
                                </a>
                            </div>
                        </div>
                    @else
                        {{-- <div class="dropdown" id="profileDropdownContainer">
                            <a class="dropdown-toggle btn-sm" href="#" id="profileDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                                <span>Profile</span>
                            </a>
                            <ul class="dropdown-content p-0" aria-labelledby="profileDropdown">
                                <a href="{{ route('account-oder') }}">{{ translate('my_Order') }}</a>
                                <a href="{{ route('user-account') }}">{{ translate('my_Profile') }}
                                    @if ($is_jobadder === true)
                                        <a href="{{ route('job-panel') }}">{{ translate('job_Panel') }}</a>
                                    @endif
                                    <a href="{{ route('customer.auth.logout') }}">{{ translate('logout') }}</a>
                            </ul>
                        </div> --}}
                    @endif
                </div>
                <a class="d-flex align-content-center" href="{{ route('webinfo') }}">
                    <li class="d-flex align-content-center mr-2 ml-2 dropdown m-0 randomshit"
                        style="list-style: none;">
                        <div class="align-content-center dropdown-toggle" type="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                            <svg width="20px" height="20px" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M7 1H1V7H7V1ZM7 9H1V15H7V9ZM9 1H15V7H9V1ZM15 9H9V15H15V9Z" fill="#c2c4c3" />
                            </svg>
                        </div>
                        <div class="dropdown-menu dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}"
                            aria-labelledby="dropdownMenuButton" style="border-radius: 10px;">
                            <div class="detailsboxtop">
                                <h5>Our Features!</h5>
                                <ul class="feature-list">
                                    <li>
                                        <div class="leftclass">
                                            <i class="fa fa-tags"></i> <!-- Better for stock sales -->
                                        </div>
                                        <div class="rightclass">
                                            <strong>Stock Sale</strong><br>
                                            <span>Find discounted stock available for resale at great prices.</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="leftclass">
                                            <i class="fa fa-user-plus"></i> <!-- Represents acquiring leads -->
                                        </div>
                                        <div class="rightclass">
                                            <strong>Buy Leads</strong><br>
                                            <span>Purchase high-quality leads to grow your customer base.</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="leftclass">
                                            <i class="fa fa-bullhorn"></i> <!-- Represents promotions & offers -->
                                        </div>
                                        <div class="rightclass">
                                            <strong>Sale Offer</strong><br>
                                            <span>Explore limited-time sale offers and special deals.</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="leftclass">
                                            <i class="fa fa-briefcase"></i> <!-- Represents job opportunities -->
                                        </div>
                                        <div class="rightclass">
                                            <strong>Industry Jobs</strong><br>
                                            <span>Find job opportunities in various industries.</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="leftclass">
                                            <i class="fa fa-handshake"></i> <!-- Represents business deals -->
                                        </div>
                                        <div class="rightclass">
                                            <strong>Deal Assist</strong><br>
                                            <span>Get expert assistance to close deals successfully.</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="leftclass">
                                            <i class="fa fa-calendar-alt"></i> <!-- Represents events & tradeshows -->
                                        </div>
                                        <div class="rightclass">
                                            <strong>Tradeshows</strong><br>
                                            <span>Attend tradeshows to discover new opportunities.</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="leftclass">
                                            <i class="fa fa-male"></i>
                                        </div>
                                        <div class="rightclass">
                                            <strong>Membership</strong><br>
                                            <span>Become a Paid member to Enhance Experience.</span>
                                        </div>
                                    </li>
                                </ul>                                
                            </div>
                        </div>
                    </li>
                </a>

            </ul>
            @if (auth('customer')->check())
                <div class="logout-btn mt-auto d-md-none">
                    <hr>
                    <a href="{{ route('customer.auth.logout') }}" class="nav-linknew custom-dealrock-text">
                        <strong class="text-base">{{ translate('logout') }}</strong>
                    </a>
                </div>
            @endif
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
        <a href="{{route('helpTopic')}}" target="_blank">
            <div class="fl-fl float-tw text-white">
                <i class="fa fa-user"></i>
                Help
            </div>
        </a>
        <a href="{{ route('webinfo') }}" target="_blank">
            <div class="fl-fl float-gp text-white">
                <i class="fa fa-info-circle"></i>
                Info
            </div>
        </a>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the dropdown toggle button and the dropdown menu
            const dropdownToggle = document.getElementById('profileDropdown');
            const dropdownMenu = document.querySelector('#profileDropdownContainer .dropdown-menu');

            // Listen for click event on the dropdown toggle
            dropdownToggle.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default behavior (jumping to the top of the page)

                // Toggle the 'show' class to show or hide the dropdown menu
                dropdownMenu.classList.toggle('show');
            });

            // Close the dropdown if clicked outside
            document.addEventListener('click', function(event) {
                if (!dropdownToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.remove('show');
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var dropdownbutton = document.getElementById('productssearch');
            var dropdownbuttonu = document.getElementById('leadsbuy');
            var dropdownbuttonm = document.getElementById('leadssell');
            var changehere = document.getElementById('searchInput');

            if (dropdownbutton && changehere) {
                dropdownbutton.addEventListener('click', function() {
                    changehere.name = 'searchInput';
                });
            }

            if (dropdownbuttonu && changehere) {
                dropdownbuttonu.addEventListener('click', function() {
                    changehere.name = 'search_query';
                });
            }

            if (dropdownbuttonm && changehere) {
                dropdownbuttonm.addEventListener('click', function() {
                    changehere.name = 'search_query';
                });
            }
        });
    </script>
@endpush
