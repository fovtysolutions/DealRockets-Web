@extends('layouts.front-end.app')
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/stocksalenew.css') }}" />
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/jobseekernew.css') }}">
{{-- <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/customdropdown.css') }}"> --}}
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/multitabstock.css') }}" />
@section('title', translate('Stock Sale' . ' | ' . $web_config['name']->value))
@section('content')
    <?php
    $categories = \App\Utils\CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
    $unread = \App\Utils\ChatManager::unread_messages();
    if (Auth('customer')->check()) {
        $membership = \App\Utils\ChatManager::getMembershipStatusCustomer(Auth('customer')->user()->id);
        if (isset($membership['error'])) {
            $membership = ['status' => 'NotMade', 'message' => 'Membership Not Applied'];
        }
    }
    $userdata = \App\Utils\ChatManager::getRoleDetail();
    $user_id = $userdata['user_id'];
    $role = $userdata['role'];
    ?>
    <style>
        .leadpagedivision {
            background-color: var(--web-bg);
        }

        .gapbetweens {
            height: 22px;
            background-color: var(--web-bg);
        }

        .fade-in-on-scroll {
            width: 100%;
        }

        .__inline-9 {
            background-color: var(--web-bg);
        }

        .dropdown-item:hover {
            background-color: white;
            transform: scale(1) !important;
            cursor: pointer;
        }

        /* .mainpagesection {
            margin-top: 0px;
        } */

        .ad-section{
            flex-direction: row !important;
        }

        .ad-section img{
            aspect-ratio: 7/1 !important;
            max-width: 1600px !important;
        }
    </style>
    <section class="mainpagesection" style="margin-top: 10px;">
        {{-- <div style="border-radius:10px;">
            <div class="owl-carousel stocksale-carousel">
                <!-- Banner Images -->
                <img class="w-100 topclassbanner" src="{{ asset('storage/' . $stocksalebanner['banner_image1']) }}" alt="Banner">
                <img class="w-100 topclassbanner" src="{{ asset('storage/' . $stocksalebanner['banner_image2']) }}" alt="Banner">
            </div>
        </div> --}}
        {{-- <div class="gapbetweens border-0 rounded-0" style="height: 10px;">
            <!-- Empty Gap -->
        </div>
        <div class="card border-0 rounded-0" style="background-color: var(--web-bg);">
            <span> <a href="/"> Home </a> / <a href="/stock-sale"> Stock Sale </a> </span>
        </div> --}}
        {{-- <div class="gapbetweens border-0 rounded-0" style="height: 10px;">
            <!-- Empty Gap -->
        </div>
        <div class="card border-0 rounded-0" style="background-color: var(--web-bg);">
            <h4><strong>Find Best Stocks in Sale!</strong></h4>
        </div> --}}
        {{-- <div class="gapbetweens border-0 rounded-0" style="height: 10px;">
            <!-- Empty Gap -->
        </div>
        <div class="card border-0 rounded-0 hrhhr">
            <!-- Buyers label on the left -->
            <div class="rrrh">
                <div class="btnbuyer" style="color: white;">
                    Stock Sale
                </div>
            </div>

            <!-- Container for the Search bar and Counter (right side) -->
            <div class="egrrgr">
                <!-- Search bar in the center -->
                <div class="hrrgr">
                    <div class="main-search" style="width: 100%;">
                        <form action="{{ route('stocksale') }}" method="GET" id="header_search_bar">
                            <div class="search-field-cont" style="position: relative; display: flex; align-items: center;">
                                <!-- Input field for search -->
                                <input type="text" name="search_query" id="search_query" class="form-control dbbe"
                                    placeholder="Search..." required="">
                                <!-- Magnifying glass icon -->
                                <button type="submit" class="text-white pl-2 pr-2 h-100 rrwbrwbr">
                                    <i class="fa fa-search" style="font-size: 18px;"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Counter on the right -->
                <div class="rfbrbrrbr">
                    <div class="counter" style="text-align: right;">
                        Sale's Total Count
                        <span class="counteractual">{{ $counttotal }}</span> <!-- Replace with actual counter logic -->
                    </div>
                </div>

            </div>
        </div> --}}
        {{-- <div class="gapbetweens">
            <!-- Empty Gap -->
        </div> --}}
        <!-- Added Stuff -->
        <div class="jobbannermain overflow-hidden">
            <div class="jobbannerrightbox">
                <div class="jobbannerrighttop d-flex flex-row">
                    <div class="rrrh" style="background-color: unset !important;">
                        <div class="btnbuyer" style="color: white;">
                            <h5 class="text-white custom-dealrock-subhead">Stock Sale</h5>
                        </div>
                    </div>
                    <div class="buttonsbox">
                        <form method="GET" action="{{ route('stocksale') }}"
                            style="flex-direction: row; margin-top: 0; display: flex; margin-bottom: 0;">
                            <div class="dropdown-container" style="margin-left: 10px;">
                                <div class="d-flex flex-row align-baseline justify-content-between">
                                    <div class="d-flex flex-column">
                                        {{-- <div class="dropdown-title">Location</div> --}}
                                        <div id="locationdropdown" class="dropdown-button noselect">
                                            <div class="dropdown-label custom-dealrock-text align-items-center d-flex"
                                                data-default-label="Country">Select a Location

                                                <div class="d-flex align-self-center custom-dealrock-text">
                                                    <svg fill="#b5b5b5" version="1.1" id="Capa_1"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="20"
                                                        height="20" viewBox="0 0 395.71 395.71" xml:space="preserve">
                                                        <g>
                                                            <path
                                                                d="M197.849,0C122.131,0,60.531,61.609,60.531,137.329c0,72.887,124.591,243.177,129.896,250.388l4.951,6.738
                                                            c0.579,0.792,1.501,1.255,2.471,1.255c0.985,0,1.901-0.463,2.486-1.255l4.948-6.738c5.308-7.211,129.896-177.501,129.896-250.388
                                                            C335.179,61.609,273.569,0,197.849,0z M197.849,88.138c27.13,0,49.191,22.062,49.191,49.191c0,27.115-22.062,49.191-49.191,49.191
                                                            c-27.114,0-49.191-22.076-49.191-49.191C148.658,110.2,170.734,88.138,197.849,88.138z" />
                                                        </g>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="locationdropdownchild" class="dropdown-list custom-dealrock-text" style="display: none;">
                                            <input type="search" placeholder="Search country" class="dropdown-search"
                                                id="country-search" name="country" />
                                            <ul id="country-list">
                                                @foreach ($locations as $location)
                                                    <li class="dropdown-item pr-2 pl-2">
                                                        <label>
                                                            <input type="radio" name="country"
                                                                value="{{ $location }}" />
                                                            {{ \App\Utils\ChatManager::getCountryDetails($location)['countryName'] }}
                                                        </label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Time Filter Dropdown -->
                            <div class="dropdown-container" style="border-right: 0;">
                                <div class="d-flex flex-row align-baseline justify-content-between">
                                    <div class="d-flex flex-column">
                                        {{-- <div class="dropdown-title">Time</div> --}}
                                        <div class="dropdown-button noselect">
                                            <div class="dropdown-label align-items-center d-flex custom-dealrock-text" data-default-label="Time">
                                                Select A Time Range</i>
                                                <div class="d-flex align-self-center">
                                                    <svg class="dropdown-arrow" width="20" height="20"
                                                        viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7 10l5 5 5-5" stroke="currentColor" stroke-width="1.5"
                                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dropdown-list custom-dealrock-text" style="display: none;">
                                            <ul id="time-list">
                                                <li class="dropdown-item pr-2 pl-2">
                                                    <label>
                                                        <input type="radio" name="time" value="7" /> Last 7 Days
                                                    </label>
                                                </li>
                                                <li class="dropdown-item pr-2 pl-2">
                                                    <label>
                                                        <input type="radio" name="time" value="30" /> Last 30
                                                        Days
                                                    </label>
                                                </li>
                                                <li class="dropdown-item pr-2 pl-2">
                                                    <label>
                                                        <input type="radio" name="time" value="90" /> Last 3
                                                        Months
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Filter Buttons -->
                            <div class="clear-filters mr-2  d-flex align-items-center">
                                <button class="clear-filters-button custom-dealrock-text" type="submit" id="filters-btn">Filters</button>
                            </div>
                            <div class="clear-filters d-flex align-items-center">
                                <button class="clear-filters-button custom-dealrock-text" id="clear-filters-btn">Clear Filters</button>
                            </div>
                        </form>
                        <!-- <select class="buttonsboxq" id="location_filter" name="location_filter">
                                <option selected value="">Exact Location</option>
                                <option value="city1">City 1</option>
                                <option value="city2">City 2</option>
                                <option value="city3">City 3</option>
                                <option value="city4">City 4</option>
                            </select> -->
                    </div>
                </div>
                <div class="jobbannerrightbottom">
                    <div class="jobbannerleft" id="bannerleft">
                        <div class="nav-item {{ !request()->is('/') ? 'dropdown' : '' }}">
                            <a class="spanatag" href="javascript:" style="z-index: 0;">
                                <svg class="spanimage" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="5" y="6" width="20" height="2" fill="black" />
                                    <rect x="5" y="13" width="20" height="2" fill="black" />
                                    <rect x="5" y="20" width="20" height="2" fill="black" />
                                </svg>
                                <span class="spantitlenew custom-dealrock-subhead">
                                    {{ translate('categories') }}
                                </span>
                            </a>
                        </div>
                        <ul class="navbar-nav" style="overflow-y:hidden; overflow-x:hidden; height: 87%;"
                            id="dpcontainertwo">
                            <div class="megamenu">
                                <div class="megamenucontainer">
                                    <div class="category-menu-wrapper">
                                        <ul class="category-menu-items" id="dpcontainerbox">
                                            @foreach ($categoriesn->take(17) as $key => $category)
                                                <li>
                                                    <a class="text-truncate custom-dealrock-text"
                                                        href="{{ route('stocksale', ['categoryid' => $category->id]) }}">{{ $category->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </ul>
                        <div class="text-center" id="viewMoreBtn">
                            <a href="#bannerleft" class="text-primary font-weight-bold justify-content-center">
                                {{ translate('View_More') }}
                            </a>
                        </div>
                    </div>
                    <div class="jobbannercenter">
                        <ul class="navbar-nav hiddenonscreens">
                            <li class="nav-item dropdown custom-dealrock-subhead">
                                <a class="nav-link dropdown-toggle" href="javascript:" id="dropdownMenuCat"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false"
                                    onclick="toggleDropdown('dropdownMenuCat', 'dropdownmenu-cat')"
                                    style="position: absolute;">
                                    <svg class="spanimage" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="5" y="6" width="20" height="2" fill="black" />
                                        <rect x="5" y="13" width="20" height="2" fill="black" />
                                        <rect x="5" y="20" width="20" height="2" fill="black" />
                                    </svg>
                                </a>
                                <ul class="dropdown-menu" id="dropdownmenu-cat" aria-labelledby="dropdownMenuButton"
                                    style="padding-top:50px;">
                                    @foreach ($categories as $category)
                                        <li>
                                            <a class="custom-dealrock-text"
                                                href="{{ route('stocksale', ['categoryid' => $category->id]) }}">{{ $category->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                        <div class="tilebox">
                            @if ($items->isEmpty())
                                <p>No Stocks Found!</p>
                            @else
                                @foreach ($items as $data)
                                    <input style="display: none;" value={{ $data->id }} id="jobid" />
                                    <div class="tile">
                                        <div class="tile-content" onclick="fetchJobData({{ $data->id }})">
                                            <!-- Company Logo -->
                                            <div class="icon">
                                                <div class="owl-carousel icon-carousel">
                                                    <!-- Loop through the images (using PHP) -->
                                                    @foreach (json_decode($data->image, true) as $image)
                                                        <div class="item">
                                                            <img class="ico" src="/{{ $image }}" />
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <!-- Job Details Section -->
                                            <div class="details">
                                                <div class="title custom-dealrock-subhead">{{ $data->name }}</div>
                                                <div class="company-name custom-dealrock-text" style="color: var(--web-hover); font-weight: bold !important;">MOQ: {{ $data->quantity }}</div>
                                                <div class="location custom-dealrock-text">{{ $data->description }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            @if ($items->isEmpty())
                                <!-- No Show -->
                            @else
                                {{ $items->links() }}
                            @endif
                        </div>
                    </div>
                    <div class="jobbannerright" id="jobdetails">
                        <div class="tabs-container">
                            <div class="tabs">
                                <div class="tab-links">
                                    <button class="custom-dealrock-text tab-link active" data-tab="tab-1"><i class="fas fa-info-circle"></i>
                                        Stock Photo</button>
                                    <button class="custom-dealrock-text tab-link" data-tab="tab-2"><i class="fas fa-list"></i>
                                        Specification</button>
                                    <button class="custom-dealrock-text tab-link" data-tab="tab-3"><i class="fas fa-envelope"></i>
                                        Deal</button>
                                    <button class="custom-dealrock-text tab-link" data-tab="tab-4"><i class="fas fa-question-circle"></i>
                                        Contact</button>
                                </div>

                                <div class="tab-content active" id="tab-1" style="height: 90%;">
                                    <h5 class="custom-dealrock-subhead">Stock Photo</h5>
                                    <div id="hereinsertalso" class="owl-carousel details-carousel">
                                        <!-- Carousel Inserted Here -->
                                    </div>
                                </div>

                                <div class="tab-content" id="tab-2">
                                    <h5 class="mb-2 custom-dealrock-subhead">Stock Specifications</h5>

                                    <p id="job-descriptionstock" class="mb-2 custom-dealrock-text">
                                        {{-- Stock Description Here --}}
                                    </p>
                                    <ul class="feature-list"
                                        style="list-style: none; margin-bottom: 10px;background-color: #efefef;padding: 5px;border-radius: 10px;">
                                        <div class="row custom-dealrock-text">
                                            <div class="col">
                                                <li>
                                                    <div class="leftclass">
                                                        <i class="fa fa-id-badge text-primary"
                                                            style="font-size: 20px;"></i> <!-- Icon for "Name" -->
                                                    </div>
                                                    <div class="rightclass">
                                                        <strong>Name</strong><br>
                                                        <span id="stockname">
                                                            {{-- Content Here --}}
                                                        </span>
                                                    </div>
                                                </li>
                                            </div>
                                            <div class="col">
                                                <li>
                                                    <div class="leftclass">
                                                        <i class="fa fa-list-alt text-info" style="font-size: 20px;"></i>
                                                        <!-- Icon for "Type" -->
                                                    </div>
                                                    <div class="rightclass">
                                                        <strong>Type</strong><br>
                                                        <span class="text-capitalize" id="stocktype">
                                                            {{-- Content Here --}}
                                                        </span>
                                                    </div>
                                                </li>
                                            </div>
                                        </div>
                                        <div class="row custom-dealrock-text">
                                            <div class="col">
                                                <li>
                                                    <div class="leftclass">
                                                        <i class="fa fa-globe text-success" style="font-size: 20px;"></i>
                                                        <!-- Icon for "Origin" -->
                                                    </div>
                                                    <div class="rightclass">
                                                        <strong>Origin</strong><br>
                                                        <span id="stockorigin">
                                                            {{-- Content Here --}}
                                                        </span>
                                                    </div>
                                                </li>
                                            </div>
                                            <div class="col">
                                                <li>
                                                    <div class="leftclass">
                                                        <i class="fa fa-certificate text-warning"
                                                            style="font-size: 20px;"></i> <!-- Icon for "Badge" -->
                                                    </div>
                                                    <div class="rightclass">
                                                        <strong>Badge</strong><br>
                                                        <span id="stockbadge">
                                                            {{-- Content Here --}}
                                                        </span>
                                                    </div>
                                                </li>
                                            </div>
                                        </div>
                                    </ul>
                                    <p class="custom-dealrock-text"><strong>Verified By:</strong> Admin</p>
                                </div>

                                <div class="tab-content rounded" id="tab-3">
                                    <h5 class="mb-3 custom-dealrock-subhead"><i class="fas fa-tag text-primary"></i> Deal Information</h5>
                                    {{-- <p class="mb-3">
                                    <strong><i class="fas fa-gift text-success"></i> Special Offer:</strong> Get a <span class="text-success">10% discount</span> on your first purchase. 
                                    Offer valid until <strong>January 31, 2025</strong>.
                                </p> --}}
                                    <div
                                        style="margin-bottom: 10px;background-color: #efefef;padding: 20px 5px 5px 20px;border-radius: 10px;">
                                        <div class="row mb-1">
                                            <div class="col-md-6 mb-1">
                                                <p class="d-flex flex-column">
                                                    <span class="custom-dealrock-text">
                                                        <strong>Product Name</strong>
                                                    </span>
                                                    <span class="custom-dealrock-text" id="stockdealname">
                                                        {{-- Product Name --}}
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="col-md-6 mb-1">
                                                <p class="d-flex flex-column">
                                                    <span class="custom-dealrock-text">
                                                        <strong>Available Stock</strong>
                                                    </span>
                                                    <span class="custom-dealrock-text" id="stockdealavaliable">
                                                        {{-- Available Stock --}}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-6 mb-1">
                                                <p class="d-flex flex-column">
                                                    <span class="custom-dealrock-text">
                                                        <strong>Product Type</strong>
                                                    </span>
                                                    <span class="text-capitalize custom-dealrock-text" id="stockdealproducttype">
                                                        {{-- Product Name --}}
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="col-md-6 mb-1">
                                                <p class="d-flex flex-column">
                                                    <span class="custom-dealrock-text">
                                                        <strong>Min. Order Quantity</strong>
                                                    </span>
                                                    <span class="fs-5 custom-dealrock-text" id="stockdealminorder">
                                                        {{-- Min Order --}}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-6 mb-1">
                                                <p class="d-flex flex-column">
                                                    <span class="custom-dealrock-text">
                                                        <strong>Refundable</strong>
                                                    </span>
                                                    <span class="fs-5 custom-dealrock-text" id="stockdealrefundable">
                                                        {{-- Refundable --}}
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="col-md-6 mb-1">
                                                <p class="d-flex flex-column">
                                                    <span class="custom-dealrock-text">
                                                        <strong>Shipping Cost</strong>
                                                    </span>
                                                    <span class="fs-5 custom-dealrock-text" id="stockdealshipping">
                                                        {{-- Shipping Cost --}}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-content rounded" id="tab-4">
                                    <h5 class="mb-3 custom-dealrock-subhead">Contact Information</h5>
                                    <p class="mb-3 custom-dealrock-text">For any inquiries, you can reach us at:</p>
                                    <ul
                                        style="list-style: none; background-color: #efefef;padding: 10px 10px 10px 20px;border-radius: 10px;">
                                        <li class="mb-2 custom-dealrock-text"><i class="fas fa-envelope text-danger"></i>
                                            <strong>Email:</strong>
                                            <a class="text-decoration-none">
                                                <span id="company-email">
                                                    {{-- Email --}}
                                                </span>
                                            </a>
                                        </li>
                                        <li class="mb-2 custom-dealrock-text"><i class="fas fa-phone text-success"></i>
                                            <strong>Phone:</strong>
                                            <span id="company-phone">
                                                {{-- Phone --}}
                                            </span>
                                        </li>
                                        <li class="mb-2 custom-dealrock-text"><i class="fas fa-map-marker-alt text-primary"></i>
                                            <strong>Address:</strong>
                                            <span id="company-address">
                                                {{-- Company Address --}}
                                            </span>
                                        </li>
                                        <li class="custom-dealrock-text"><i class="fas fa-industry text-warning"></i> <strong>Industry:</strong>
                                            <span id="industry">
                                                {{-- Industry --}}
                                            </span>
                                        </li>
                                    </ul>
                                    <p class="mt-3 custom-dealrock-text"><strong>Company Name:</strong><span id="company-name">
                                            {{-- Company Name --}}
                                        </span>
                                    </p>
                                    <div class="hereisbutton custom-dealrock-text" style="display: flex; justify-content: space-around; margin-top: 22px;">
                                        @if (auth('customer')->check() && auth('customer')->user()->id)
                                            @if ($membership['status'] == 'active')
                                            <button class="border-0" style="border-radius: 25px; padding: 10px 35px; background-color: var(--web-hover); color: white;" data-toggle="modal" data-target="#chatting_modalnew"
                                                data-seller-id="{{ $item->user_id }}" data-role="{{ $item->role }}"
                                                data-stock-id="{{ $item->id }}" data-typereq="stocksale" onclick="openChatModalnew(this)">
                                                Contact Seller
                                            </button>
                                            @else
                                            <a href="{{ route('membership') }}">
                                                <button class="border-0" style="border-radius: 25px; padding: 10px 35px; background-color: var(--web-hover); color: white;">
                                                    Contact Seller
                                                </button>
                                            </a>
                                            @endif
                                        @else
                                        <a href="#" onclick="openLoginModal()">
                                            <button class="border-0" style="border-radius: 25px; padding: 10px 35px; background-color: var(--web-hover); color: white;">
                                                Contact Seller
                                            </button>
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="jobbox">
                            {{-- <div class="card shadow-sm border-0">
                            <div class="job-card">
                                <div class="job-card-header">
                                    <img src="default-logo.png" alt="Company Logo" class="company-logo" id="company-logo">
                                    <div class="job-details">
                                        <h5 id="job-title">Software Engineer</h5>
                                        <div class="company-name-location">
                                            <span class="company-name" id="company-name">Tech Innovators</span>
                                            <span class="location" id="company-location">San Francisco, CA</span>
                                        </div>
                                        <div class="time-applicants">
                                            <span class="posted-time" id="posted-time">Posted 3 hours ago</span>
                                            <span class="applicants" id="applicants">15 Applicants</span>
                                        </div>
                                    </div>
                                </div>
                
                                <div class="job-description-box">
                                    <h5>Stock Description</h5>
                                    <p id="job-description">
                                        As a Software Engineer, you'll be responsible for building and maintaining
                                        software systems. You will work alongside a team of engineers to design, test,
                                        and deploy scalable solutions. The ideal candidate will have a passion for
                                        technology and a desire to continuously learn and grow.
                                    </p>
                                </div>
                
                                <div id="hereinsert" class="owl-carousel details-carousel">
                                    <!-- Carousel Inserted Here -->
                                </div>
                
                                <div class="hereisbutton" style="display: flex; justify-content: space-around; margin-top: 22px;">
                                    @if (auth('customer')->check() && auth('customer')->user()->id)
                                        @if ($membership['status'] == 'active')
                                        <button class="border-0" style="border-radius: 25px; padding: 10px 35px;" data-toggle="modal" data-target="#chatting_modalnew"
                                            data-seller-id="{{ $item->user_id }}" data-role="{{ $item->role }}"
                                            data-stock-id="{{ $item->id }}" data-typereq="stocksale" onclick="openChatModalnew(this)">
                                            Contact Seller
                                        </button>
                                        @else
                                        <a href="{{ route('membership') }}">
                                            <button class="border-0" style="border-radius: 25px; padding: 10px 35px;">
                                                Contact Seller
                                            </button>
                                        </a>
                                        @endif
                                    @else
                                    <a href="#" onclick="openLoginModal()">
                                        <button class="border-0" style="border-radius: 25px; padding: 10px 35px;">
                                            Contact Seller
                                        </button>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div id="galleryOverlay" class="gallery-overlay" style="display:none;">
                <div class="overlay-content">
                    <button id="closeGallery" class="close-gallery-btn">Close Gallery</button>
                    <div id="galleryGrid" class="gallery-grid"></div>
                </div>
            </div> -->
        @include('web.partials.loginmodal')
        @include('web.partials.stockdetailmodal')
        <!-- End Stuff -->
    </section>
    @include('web-views.partials._quotation')
    <div class="mainpagesection leadrightdivision" style="width: 96%;">
        <div class="ad-section">
            {{-- <div class="vendor-ad">
                <div class="ad-content ">
                    <!-- Replace with actual vendor ad content -->
                    <img src="storage/{{ $adimages['ad1_image'] }}" alt="Vendor Ad" class="ad-image">
                </div>
            </div> --}}
            <div class="google-ad">
                <div class="ad-content">
                    <!-- Google Ad code goes here -->
                    <img src="storage/{{ $adimages['ad2_image'] }}" alt="Google Ad" class="ad-image">
                </div>
            </div>
        </div>
    </div>
    <div class="mainpagesection" style="margin-top: 22px;">
        @include('web-views.partials._trending-selection')
    </div>
    {{-- <div style="margin-top: 22px;">
        @include('web-views.partials._searchby_industry')
    </div> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        const trendingsection = document.getElementById('trendingselection');

        // Remove the bottom shadow but keep the others
        trendingsection.style.boxShadow = 'rgba(0, 0, 0, 0.07) 0px 0rem 1rem'; // Keep existing shadow properties

        // Correct way to remove a class (if you're trying to remove a class named 'boxShadow')
        trendingsection.classList.remove('shadow');
    </script>
    <script>
        // Tab functionality
        const tabLinks = document.querySelectorAll('.tab-link');
        const tabContents = document.querySelectorAll('.tab-content');

        tabLinks.forEach(link => {
            link.addEventListener('click', () => {
                // Remove active class from all links
                tabLinks.forEach(link => link.classList.remove('active'));
                // Add active class to clicked link
                link.classList.add('active');

                // Hide all tab contents
                tabContents.forEach(content => content.classList.remove('active'));

                // Show current tab content
                const targetTab = document.getElementById(link.dataset.tab);
                if (targetTab) {
                    targetTab.classList.add('active');
                }
            });
        });

        // Add dynamic gradient to tab-links
        document.addEventListener('DOMContentLoaded', function() {
            const wideBannerTexts = document.querySelectorAll('.tab-link');

            wideBannerTexts.forEach(text => {
                // Generate two random, visually appealing colors
                const randomColor1 = `hsl(${Math.floor(Math.random() * 360)}, 70%, 40%)`; // Darker hue
                const randomColor2 =
                    `hsl(${Math.floor(Math.random() * 360)}, 70%, 50%)`; // Medium-light hue

                // Apply gradient as a background to the tab link
                text.style.background = `linear-gradient(45deg, ${randomColor1}, ${randomColor2})`;
            });
        });
    </script>
    <script>
        // Function to open the login modal
        function openLoginModal() {
            $('#exampleModalLong').modal('hide');
            $('#loginModal').modal('show');
        }
    </script>
    <script>
        function fetchJobData(jobId) {
            if ($("#jobdetails").css("display") === "block") {
                var baseUrl = window.location.origin;
                var dataUrl = baseUrl + "/get-data-from-stock/" + jobId;

                $.ajax({
                    url: dataUrl,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        if (response.job_data) {
                            var job = response.job_data;
                            var stock = response.stock_data;
                            var user = response.user_data;

                            // Populate job details
                            $("#job-title").text(job.name || "Title not provided");
                            $("#job-location").text(job.country || "Location not provided");
                            var postedTimeFormatted = formatTimeAgo(job.created_at);
                            $("#posted-time").text(postedTimeFormatted || "Posted time not available");
                            $("#applicants").text(job.quote_recieved + " Quotes Recieved" ||
                                "Applicants not available");

                            // Description
                            $("#job-descriptionstock").text(job.description ||
                            "Stock description not provided");
                            updateCompanyLocation(job);
                            insertcarousel(job);

                            // Stock Details
                            $("#stockname").text(stock.name || "Product Not Found");
                            $("#stocktype").text(stock.product_type || "Product Not Found");
                            $("#stockorigin").text(stock.origin || "Product Not Found");
                            $("#stockbadge").text(stock.badge || "Product Not Found");

                            // Deal Details
                            $("#stockdealname").text(stock.name || "Product Not Found");
                            $("#stockdealavaliable").text(stock.current_stock + " " + stock.unit ||
                                "Product Not Found");
                            $("#stockdealproducttype").text(stock.product_type || "Product Not Found");
                            $("#stockdealminorder").text(job.quantity + " Units" || "Product Not Found");
                            // Refundable logic with FA icons
                            if (stock.refundable === 1) {
                                $("#stockdealrefundable").html(
                                    '<i class="fas fa-check text-success"></i> Refundable');
                            } else if (stock.refundable === 0) {
                                $("#stockdealrefundable").html(
                                    '<i class="fas fa-times text-danger"></i> Non-Refundable');
                            } else {
                                $("#stockdealrefundable").text("Product Not Found");
                            }

                            // Shipping Cost logic
                            if (stock.shipping_cost && stock.shipping_cost > 0) {
                                $("#stockdealshipping").text("$" + stock.shipping_cost.toFixed(2));
                            } else {
                                $("#stockdealshipping").text("Shipping Not Available");
                            }

                            // Company Logo
                            $("#company-logo").attr("src", job.company_icon ? "/" + job.company_icon :
                                "default-logo.png");
                            $("#company-name").text(job.company_name || "No Company Name Avaliable");
                            $("#industry").text(" " + job.industry || "No Industry Added");
                            $('#company-address').text(job.company_address || "No Company Address Added");
                            $('#company-phone').text(user.phone || "No Phone Provided");
                            $('#company-email').text(user.email || "No Email Provided");
                        } else {
                            console.error("No Stock data found.");
                            alert("Stock data not found.");
                        }
                    },

                    error: function(xhr, status, error) {
                        console.error("Error fetching Stock data: ", error.message);
                        alert("Error fetching Stock data. Please try again.");
                    },
                });
            } else {
                $("#exampleModalLong").modal("show");
                var baseUrl = window.location.origin;
                var dataUrl = baseUrl + "/get-data-from-stock/" + jobId;

                $.ajax({
                    url: dataUrl,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        if (response.job_data) {
                            var job = response.job_data;
                            var stock = response.stock_data;
                            var user = response.user_data;

                            // Populate job details
                            $("#njob-title").text(job.name || "Title not provided");
                            $("#njob-location").text(job.country || "Location not provided");
                            var postedTimeFormatted = formatTimeAgo(job.created_at);
                            $("#nposted-time").text(postedTimeFormatted || "Posted time not available");
                            $("#napplicants").text(job.quote_recieved + " Quotes Recieved" ||
                                "Applicants not available");

                            // Description
                            $("#njob-descriptionstock").text(job.description ||
                            "Stock description not provided");
                            updateCompanyLocation(job);
                            ninsertcarousel(job);

                            // Stock Details
                            $("#nstockname").text(stock.name || "Product Not Found");
                            $("#nstocktype").text(stock.product_type || "Product Not Found");
                            $("#nstockorigin").text(stock.origin || "Product Not Found");
                            $("#nstockbadge").text(stock.badge || "Product Not Found");

                            // Deal Details
                            $("#nstockdealname").text(stock.name || "Product Not Found");
                            $("#nstockdealavaliable").text(stock.current_stock + " " + stock.unit ||
                                "Product Not Found");
                            $("#nstockdealproducttype").text(stock.product_type || "Product Not Found");
                            $("#nstockdealminorder").text(job.quantity + " Units" || "Product Not Found");
                            // Refundable logic with FA icons
                            if (stock.refundable === 1) {
                                $("#nstockdealrefundable").html(
                                    '<i class="fas fa-check text-success"></i> Refundable');
                            } else if (stock.refundable === 0) {
                                $("#nstockdealrefundable").html(
                                    '<i class="fas fa-times text-danger"></i> Non-Refundable');
                            } else {
                                $("#nstockdealrefundable").text("Product Not Found");
                            }

                            // Shipping Cost logic
                            if (stock.shipping_cost && stock.shipping_cost > 0) {
                                $("#nstockdealshipping").text("$" + stock.shipping_cost.toFixed(2));
                            } else {
                                $("#nstockdealshipping").text("Shipping Not Available");
                            }

                            // Company Logo
                            $("#ncompany-logo").attr("src", job.company_icon ? "/" + job.company_icon :
                                "default-logo.png");
                            $("#ncompany-name").text(job.company_name || "No Company Name Avaliable");
                            $("#nindustry").text(" " + job.industry || "No Industry Added");
                            $('#ncompany-address').text(job.company_address || "No Company Address Added");
                            $('#ncompany-phone').text(user.phone || "No Phone Provided");
                            $('#ncompany-email').text(user.email || "No Email Provided");
                        } else {
                            console.error("No Stock data found.");
                            alert("Stock data not found.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching Stock data: ", error);
                        alert("Error fetching Stock data. Please try again.");
                    },
                });
                $("#exampleModalLong").modal("show");
            }
        }
    </script>
    <script>
        // Handle form submission with AJAX
        $('#send-message-btn').on('click', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Collect form data
            var formData = {
                sender_id: $('#sender_id').val(),
                sender_type: $('#sender_type').val(),
                receiver_id: $('#receiver_id').val(),
                receiver_type: $('#receiver_type').val(),
                type: $('#typereq').val(),
                leads_id: $('#leads_id').val(),
                message: $('textarea[name="message"]').val(),
                _token: $('input[name="_token"]').val() // CSRF token
            };

            // Send AJAX POST request
            $.ajax({
                url: "{{ route('sendmessage.other') }}", // Backend route
                type: 'POST',
                data: formData,
                success: function(response) {
                    toastr.success('Message sent successfully!', 'Success');
                    $('#chatting_modalnew').modal('hide'); // Hide modal
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    toastr.error('An error occurred while sending the message.', 'Error');
                }
            });
        });
    </script>
    <script>
        function openChatModalnew(button) {
            // Extract data from button attributes
            const sellerId = button.getAttribute('data-seller-id');
            const shopName = button.getAttribute('data-shop-name');
            const role = button.getAttribute('data-role');
            const leadsId = button.getAttribute('data-leads-id');
            const typereq = button.getAttribute('data-typereq');

            // Update modal title
            document.getElementById('chatModalNewTitle').innerText = `Chat with ${shopName}`;

            // Populate form hidden inputs
            document.getElementById('typereq').value = typereq;
            document.getElementById('leads_id').value = leadsId;
            document.getElementById('receiver_id').value = sellerId;
            document.getElementById('receiver_type').value = role;
        }
    </script>
    <script>
        function getLocationName(type, id) {
            return new Promise(function(resolve, reject) {
                if (!id) {
                    resolve("Location not available");
                    return;
                }

                var url = `/${type}name/${id}`;

                $.ajax({
                    url: url,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        resolve(response || "Location not available");
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                        reject("Error loading location.");
                    }
                });
            });
        }
        // Function to update company location
        function updateCompanyLocation(job) {
            // Fetch country, state, and city asynchronously
            var countryPromise = getLocationName('country', job.country);

            // Use Promise.all to wait for all the responses
            Promise.all([countryPromise])
                .then(function([countryName]) {
                    // Update location element with the company location
                    $("#company-location").text(countryName);
                    $("#ncompany-location").text(countryName);
                })
                .catch(function(error) {
                    // Handle error case if any AJAX call fails
                    console.error("Error in loading location details:", error);
                    $("#company-location").text(countryName);
                    $("#ncompany-location").text(countryName);
                });
        }
    </script>
    <script>
        // Define the filterLeads function globally
        function filterLeads() {
            // Gather Filter Data
            let fromDateInput = document.querySelector('input[name="from"]');
            let toDateInput = document.querySelector('input[name="to"]');
            let selectedCountries = Array.from(document.querySelectorAll('input[name="countries[]"]:checked')).map(function(
                checkbox) {
                return checkbox.value;
            });

            let fromDate = new Date(fromDateInput.value);
            let toDate = new Date(toDateInput.value);

            // Filter Leads
            let leadBoxes = document.querySelectorAll('#leadList .leadsrelatedbox');
            leadBoxes.forEach(function(box) {
                let leadDate = new Date(box.getAttribute('data-posted-date'));
                let leadCountry = box.getAttribute('data-country');

                let dateMatch = true;
                if (!isNaN(fromDate) && leadDate < fromDate) {
                    dateMatch = false;
                }
                if (!isNaN(toDate) && leadDate > toDate) {
                    dateMatch = false;
                }

                let countryMatch = selectedCountries.length === 0 || selectedCountries.includes(leadCountry);

                // Show or hide lead based on filters
                if (dateMatch && countryMatch) {
                    box.style.display = 'flex';
                } else {
                    box.style.display = 'none';
                }
            });
        }

        // Attach the filter function to the button click
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('filterButton').addEventListener('click', function() {
                filterLeads();
            });
        });
    </script>
    <script>
        function SearchbyCountry() {
            var countryId = document.getElementById('countryselector').value;
            if (countryId) {
                window.location.href = '/stock-sale?country=' + countryId;
            } else {
                alert('Please Select a Country');
            }
        }
    </script>
    <script>
        document.getElementById("viewMoreBtn").addEventListener("click", function() {
            // Set the new HTML content for #dpcontainerbox
            const fullCategoryList = `
            @foreach ($categoriesn as $category)
                <li>
                    <a href="{{ route('stocksale', ['categoryid' => $category->id]) }}">{{ $category->name }}</a>
                </li>
            @endforeach
        `;
            // Replace the current content with the full category list
            document.getElementById("dpcontainerbox").innerHTML = fullCategoryList;
            document.getElementById("dpcontainertwo").style.overflowY = 'scroll';
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var urlParams = new URLSearchParams(window.location.search);
            var jobid = urlParams.get("jobid");
            var job_first_id = document.getElementById("jobid") ?
                document.getElementById("jobid").value :
                null;

            var jobDetailsVisible =
                $("#jobdetails").length && $("#jobdetails").css("display") === "block";

            if (jobid) {
                if (jobDetailsVisible) {
                    fetchJobData(jobid);
                } else {
                    $("#exampleModalLong").modal("show");
                    fetchJobData(jobid);
                }
            } else if (job_first_id) {
                fetchJobData(job_first_id);
            } else {
                console.error("No job ID found in URL or default input.");
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Show and hide dropdowns on click
            const dropdownContainers = document.querySelectorAll(".dropdown-container");

            dropdownContainers.forEach(container => {
                const button = container.querySelector(".dropdown-button");
                const list = container.querySelector(".dropdown-list");
                const arrow = container.querySelector(".dropdown-arrow");

                button.addEventListener("click", function(event) {
                    event.stopPropagation(); // Prevent bubbling

                    // Close other dropdowns
                    document.querySelectorAll(".dropdown-list").forEach(otherList => {
                        if (otherList !== list) {
                            otherList.style.display = "none";
                            const otherArrow = otherList.previousElementSibling
                                .querySelector(".dropdown-arrow");
                            if (otherArrow) otherArrow.classList.remove("rotate");
                        }
                    });

                    // Toggle current dropdown
                    const isVisible = list.style.display === "block";
                    list.style.display = isVisible ? "none" : "block";

                    // Rotate the arrow
                    if (arrow) {
                        if (isVisible) {
                            arrow.classList.remove("rotate");
                        } else {
                            arrow.classList.add("rotate");
                        }
                    }
                });
            });

            // Close dropdowns if clicked outside
            document.addEventListener("click", function() {
                dropdownContainers.forEach(container => {
                    const list = container.querySelector(".dropdown-list");
                    const arrow = container.querySelector(".dropdown-arrow");

                    if (list.style.display === "block") {
                        list.style.display = "none";
                        if (arrow) arrow.classList.remove("rotate");
                    }
                });
            });

            // Filter function for dropdown search
            function filterList(searchId, listId) {
                const searchInput = document.getElementById(searchId);
                const listItems = document.querySelectorAll(`#${listId} .dropdown-item`);

                searchInput.addEventListener('input', function() {
                    const query = searchInput.value.toLowerCase();
                    listItems.forEach(function(item) {
                        const text = item.textContent || item.innerText;
                        item.style.display = text.toLowerCase().includes(query) ? 'block' : 'none';
                    });
                });
            };

            // Initialize filtering for Location dropdown
            filterList('country-search', 'country-list');

            // Handle item selection in dropdown
            const dropdownItems = document.querySelectorAll(".dropdown-item");
            dropdownItems.forEach(item => {
                item.addEventListener("click", function() {
                    const dropdownLabel = this.closest(".dropdown-container").querySelector(
                        ".dropdown-label");
                    dropdownLabel.textContent = this
                        .textContent; // Update the label to selected item

                    // Close the dropdown after selection
                    const dropdownList = this.closest(".dropdown-list");
                    dropdownList.style.display = "none";

                    const arrow = dropdownList.previousElementSibling.querySelector(
                        ".dropdown-arrow");
                    if (arrow) arrow.classList.remove("rotate");

                    applyFilters(); // Apply selected filters
                });
            });

            // Apply filters when an option is selected
            function applyFilters() {
                const location = document.querySelector("input[name='country']:checked")?.value;
                const time = document.querySelector("input[name='time']:checked")?.value;

                console.log("Filters Applied:");
                console.log("Location:", location);
                console.log("Time:", time);
            };

            // Function to clear all filters
            function clearFilters() {
                document.querySelectorAll('input[type="radio"]').forEach(input => input.checked = false);
                document.querySelectorAll(".dropdown-label").forEach(label => {
                    label.textContent = label.getAttribute("data-default-label");
                });
                applyFilters();
            };

            // Clear Filters Button
            const clearFiltersBtn = document.querySelector("#clear-filters-btn");
            if (clearFiltersBtn) {
                clearFiltersBtn.addEventListener("click", function() {
                    clearFilters();
                });
            }
        });
    </script>
    <script>
        function insertcarousel(job) {
            // Assuming 'job.image' is a JSON string containing image URLs
            var images = JSON.parse(job.image);
            // var inserthere = document.getElementById('hereinsert'); // Get the carousel container
            var insertherealso = document.getElementById('hereinsertalso');

            // inserthere.innerHTML = '';
            insertherealso.innerHTML = '';

            // Loop through the images and create carousel items
            images.forEach(function(image) {
                var imgElement = document.createElement('img');
                imgElement.src = '/' + image; // Assuming image path is relative
                imgElement.classList.add('item'); // Owl Carousel expects items to have a class

                // Optional styling
                imgElement.style.maxWidth = '100%';
                // imgElement.style.maxHeight = '55vh';
                imgElement.style.objectFit = 'contain';
                imgElement.style.aspectRatio = '4/3';

                // Create a wrapper div for each image
                var itemDiv = document.createElement('div');
                itemDiv.appendChild(imgElement);

                // Append the item div to the carousel container
                // inserthere.appendChild(itemDiv);
                insertherealso.appendChild(itemDiv);
            });

            // Destroy Previous Owl Carousel
            $('.details-carousel').owlCarousel('destroy');
            // Initialize Owl Carousel
            $('.details-carousel').owlCarousel({
                loop: true,
                margin: 10,
                autoplay: true,
                nav: false, // Show navigation arrows
                dots: true, // Show dots for navigation
                responsive: {
                    0: {
                        items: 1
                    }, // 1 item on small screens
                    600: {
                        items: 1
                    }, // 3 items on medium screens
                    1000: {
                        items: 1
                    } // 5 items on large screens
                }
            });
        }
    </script>
    <script>
        function formatTimeAgo(dateString) {
            const now = new Date();
            const postedDate = new Date(dateString);
            const timeDiff = now - postedDate; // difference in milliseconds

            const daysAgo = Math.floor(timeDiff / (1000 * 3600 * 24)); // converting milliseconds to days

            if (daysAgo === 0) {
                return "Posted today";
            } else if (daysAgo === 1) {
                return "Posted 1 day ago";
            } else {
                return `Posted ${daysAgo} days ago`;
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            // Initialize Owl Carousel
            $(".icon-carousel").owlCarousel({
                items: 1, // Show 1 image at a time
                loop: true, // Enable looping
                autoplay: false, // Disable autoplay by default
                nav: false, // Disable next/prev buttons
                dots: false, // Disable pagination dots
            });

            // Play carousel on hover
            $(".icon-carousel").hover(
                function() {
                    $(this).trigger('play.owl.autoplay', [1500]); // Start autoplay on hover
                },
                function() {
                    $(this).trigger('stop.owl.autoplay'); // Stop autoplay when hover is removed
                }
            );
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".stocksale-carousel").owlCarousel({
                loop: true, // Enable looping
                margin: 10, // Space between items
                nav: false, // Show navigation arrows
                dots: false, // Show dots navigation
                autoplay: true, // Auto slide
                autoplayTimeout: 3000, // Auto slide delay (in ms)
                autoplayHoverPause: true, // Pause on hover
                responsive: {
                    0: {
                        items: 1
                    }, // 1 item for small screens
                    600: {
                        items: 1
                    }, // 2 items for medium screens
                    1000: {
                        items: 1
                    } // 1 item for large screens
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dropdownButton = document.querySelector(".dropdown-button");
            const dropdownList = document.querySelector(".dropdown-list");
            const dropdownArrow = document.querySelector(".dropdown-arrow");

            // Toggle dropdown and arrow rotation
            dropdownButton.addEventListener("click", function(event) {
                event.stopPropagation(); // Prevent closing the dropdown when clicking inside
                const isVisible = dropdownList.style.display === "block";
                dropdownList.style.display = isVisible ? "none" : "block";
                dropdownArrow.classList.toggle("rotate", !isVisible); // Toggle rotation
            });

            // Close dropdown when clicking outside
            document.addEventListener("click", function() {
                dropdownList.style.display = "none";
                dropdownArrow.classList.remove("rotate"); // Reset arrow rotation
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var dropdownbutton = document.getElementById('locationdropdown');
            var dropdownchild = document.getElementById('locationdropdownchild');

            document.getElementById('country-search').addEventListener('click', function(event) {
                event.stopPropagation();
            });

            dropdownbutton.addEventListener('click', function() {
                if (dropdownchild.style.display === 'none' || dropdownchild.style.display === '') {
                    dropdownchild.style.display = 'block';
                } else {
                    dropdownchild.style.display = 'none';
                }
            });
        });
    </script>
@endsection
