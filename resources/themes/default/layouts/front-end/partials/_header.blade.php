@php($announcement = getWebConfig(name: 'announcement'))
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/ai/header.css') }}" />
{{-- Start Content --}}
@if (isset($announcement) && $announcement['status'] == 1)
    <div class="text-center position-relative px-4 py-1" id="announcement"
        style="background-color: {{ $announcement['color'] }}; color: {{ $announcement['text_color'] }};">
        <span>{{ $announcement['announcement'] }} </span>
        <span class="__close-announcement web-announcement-slideUp">X</span>
    </div>
@endif
<?php
$unread = App\Utils\ChatManager::unread_messages();
$userId = Auth::guard('customer')->user() ? Auth::guard('customer')->id() : 0;
$role = App\Models\User::where('id', $userId)->first();
$is_jobadder = $role['typerole'] === 'findtalent' ? true : false;
?>
<p style="height: 124px; visiblity: none;">
    Hidden height From Top
</p>
<div class="element-mobile header-wrapper navbar-sticky navbar-floating navbar-dark">
    <div class="navbar-wrapper">
        <div class="navbar-2">
            <div class="group-14">
                <div class="overlap-group-3">
                    <div class="contentgroup deltwelve">
                        <div class="group-15">
                            <div class="group-2">
                                <a class="text-wrapper" href="{{ route('categories') }}">All Categories</a>
                                <img class="options-lines" src="/img/options-lines-1.png" />
                            </div>
                        </div>
                        <div class="navbar-3">
                            <a class="nav-tile deleight" href="{{ route('home') }}" data-menu="/" data-home="true">
                                <img class="badge img-default" src="/img/home.svg" />
                                <img class="badge img-hover" src="/img/home-hover.svg" />
                                <span class="nav-label">Home</span>
                            </a>
                            <a class="nav-tile delseven" href="{{ route('stocksale') }}" data-menu="/stock-sale">
                                <img class="badge img-default" src="/img/stocksale.svg" />
                                <img class="badge img-hover" src="/img/stocksale-hover.svg" />
                                <span class="nav-label">Stock Sale</span>
                            </a>
                            <a class="nav-tile delsix" href="{{ route('buyer') }}" data-menu="/buy-leads">
                                <img class="badge img-default" src="/img/lead.svg" style="padding-left: 12px;" />
                                <img class="badge img-hover" src="/img/lead-hover.svg" style="padding-left: 12px;" />
                                <span class="nav-label">Buy Leads</span>
                            </a>
                            <a class="nav-tile deleight" href="/products?searchInput=" data-menu="/" data-home="true">
                                <img class="badge img-default" src="/img/shop.svg" />
                                <img class="badge img-hover" src="/img/shop.svg" />
                                <span class="nav-label">Marketplace</span>
                            </a>
                            <a class="nav-tile delfive" href="{{ route('seller') }}" data-menu="/sell-offer">
                                <img class="badge img-default" src="/img/saleoffer.svg" />
                                <img class="badge img-hover" src="/img/saleoffer-hover.svg" />
                                <span class="nav-label">Sell Offer</span>
                            </a>
                            <a class="nav-tile delfour" href="{{ route('dealassist') }}" data-menu="/deal-assist">
                                <img class="badge img-default" src="/img/dealassist.svg" />
                                <img class="badge img-hover" src="/img/dealassist-hover.svg" />
                                <span class="nav-label">Deal Assist</span>
                            </a>
                            <a class="nav-tile delone" href="{{ route('sendcv') }}" data-menu="/industry-jobs">
                                <img class="badge img-default" src="/img/industryjobs.svg" />
                                <img class="badge img-hover" src="/img/industryjobs-hover.svg" />
                                <span class="nav-label">Industry Jobs</span>
                            </a>
                            {{-- <div class="frame-2 deltwo">
                                <a class="nav-tile" href="{{ route('tradeshow') }}" data-menu="/tradeshow">
                                    <img class="badge img-default" src="/img/trade-shows.png" />
                                    <img class="badge img-hover" src="/img/trade-shows-hover.png" />
                                    <span class="nav-label">Trade Shows</span>
                                </a>
                            </div> --}}
                            {{-- <div class="frame-2 delthree">
                                <a class="nav-tile" href="{{ route('vendor.auth.registration.index') }}"
                                    data-menu="/vendorzone">
                                    <img class="badge img-default" src="/img/supplier-zone.png" />
                                    <img class="badge img-hover" src="/img/supplier-zone-hover.png" />
                                    <span class="nav-label">Supplier Zone</span>
                                </a>
                            </div> --}}
                        </div>
                        <div class="frame-6 delnine">
                            <a href="{{ route('webinfo') }}">
                                <div class="nav-tile">
                                    <img class="badge img-default" src="/img/badge-1.png" />
                                    <img class="badge img-hover" src="/img/badge (2).png" />
                                    <div class="text-wrapper-4">Features</div>
                                </div>
                            </a>
                            <div class="group-12">
                                <a href="{{ route('chat', ['type' => 'vendor']) }}" class="nav-tile">
                                    <img class="badge img-default" src="/img/chatting-1.png" />
                                    <img class="badge img-hover" src="/img/chatting (2).png" />
                                    <div class="text-wrapper-10">Message</div>
                                    @if (auth('customer')->check() && isset($unread))
                                        <span class="unread-badge">{{ $unread }}</span>
                                    @endif
                                </a>
                            </div>
                            <div class="group-3">
                                <a href="{{ route('helpTopic') }}" target="_blank" class="nav-tile">
                                    <div class="frame-4">
                                        <div class="text-wrapper-5">Help</div>
                                        {{-- <img class="img" src="/img/arrow-down-sign-to-navigate-4.png" /> --}}
                                    </div>
                                    <div class="icon-hover group-help">
                                        <img class="badge img-default" src="/img/question-1.png" />
                                        <img class="badge img-hover" src="/img/help-web-button.png" />
                                    </div>
                                </a>
                            </div>

                            <div class="group-4">
                                <div id="languageToggleBtn" class="nav-tile">
                                    <div class="frame-4" style="left:0;">
                                        <div class="text-wrapper-5">
                                            Translate
                                        </div>
                                        {{-- <img class="img" src="/img/arrow-down-sign-to-navigate-5.png" /> --}}
                                    </div>
                                    <div class="icon-hover group-language">
                                        <img class="badge img-default" src="/img/language-1.png" />
                                        <img class="badge img-hover" src="/img/language (2).png" />
                                    </div>
                                </div>
                                <ul id="languageDropdown-class" class="language-dropdown"
                                    style="font-size: 14px; color: black;">
                                    @foreach (json_decode($language['value'], true) as $key => $data)
                                        @if ($data['status'] == 1)
                                            <li class="change-language __inline-17"
                                                style="padding: 0px 4px 0px 3px;text-align: center;"
                                                data-action="{{ route('change-language') }}"
                                                data-language-code="{{ $data['code'] }}">
                                                <a class="dropdown-item custom-dealrock-text" href="javascript:">
                                                    <span class="text-capitalize">{{ $data['name'] }}</span>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            @if (!auth('customer')->check() && !auth('seller')->check() && !auth('admin')->check())
                                {{-- Guest User: Show Sign In/Join --}}
                                {{-- <a href="{{ route('customer.auth.login') }}">
                                    <div class="group-5 group-user">
                                        <div class="text-wrapper-6">Sign in / Join</div>
                                        <img class="user img-default" src="/img/user-1.png" />
                                        <img class="user img-hover" src="/img/user (2).png" />
                                    </div>
                                </a> --}}
                            @else
                                <div class="dropdown m-0">
                                    <a class="navbar-tool navbaricons m-0" type="button" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <div class="navbar-tool-icon-box bg-secondary">
                                            <img class="img-profile rounded-circle __inline-14" alt=""
                                                src="{{ getStorageImages(path: auth()->user()->image_full_url ?? '', type: 'avatar') }}">
                                        </div>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}"
                                        aria-labelledby="dropdownMenuButton" style="border-radius: 10px;">

                                        @if (auth('customer')->check())
                                            <a class="dropdown-item custom-dealrock-text"
                                                href="{{ route('account-oder') }}">{{ translate('my_Order') }}</a>
                                            <a class="dropdown-item custom-dealrock-text"
                                                href="{{ route('user-account') }}">{{ translate('my_Profile') }}</a>
                                            @if ($is_jobadder === true)
                                                <a class="dropdown-item custom-dealrock-text"
                                                    href="{{ route('job-panel') }}">{{ translate('job_Panel') }}</a>
                                            @endif
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item custom-dealrock-text"
                                                href="{{ route('customer.auth.logout') }}">{{ translate('logout') }}</a>
                                        @elseif (auth('seller')->check())
                                            <a class="dropdown-item custom-dealrock-text"
                                                href="{{ route('vendor.dashboard.index') }}">{{ translate('manage_Dashboard') }}</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item custom-dealrock-text"
                                                href="{{ route('vendor.auth.logout') }}">{{ translate('logout') }}</a>
                                        @elseif (auth('admin')->check())
                                            <a class="dropdown-item custom-dealrock-text"
                                                href="{{ route('admin.dashboard.index') }}">{{ translate('manage_Dashboard') }}</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item custom-dealrock-text"
                                                href="{{ route('admin.logout') }}">{{ translate('logout') }}</a>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="group-16">
                <div class="contentgroup">
                    <img class="rectangle-stroke-2" src="/img/rectangle-20-stroke-1.svg" />
                    <div class="group-17">
                        <a href="{{ url('/') }}">
                            <img class="logo-3" src="/img/logo-2.png" />
                        </a>
                        <div class="group-18">
                            <div class="group-19">
                                <div class="overlap-group-4">
                                    <div class="input-group-overlay search-form-mobile text-align-direction ml-1 mr-2"
                                        id="searchformclose">
                                        <div class="section">
                                            <div class="wrapper">
                                                @if (str_contains(url()->current(), '/job-seeker'))
                                                    <form action="{{ route('jobseeker') }}" type="submit"
                                                        class="wrapperform mb-0">
                                                    @elseif(str_contains(url()->current(), '/talent-finder'))
                                                        <form action="{{ route('talentfinder') }}" type="submit"
                                                            class="wrapperform mb-0">
                                                        @else
                                                            <form id="prosup" action="{{ route('products') }}"
                                                                type="submit" class="wrapperform mb-0">
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
                                                                <span class="d-flex align-items-center"
                                                                    style="width: 20px; height: 100%;">
                                                                    <?xml version="1.0" ?><svg height="48"
                                                                        viewBox="0 0 48 48" width="48"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M14.83 16.42l9.17 9.17 9.17-9.17 2.83 2.83-12 12-12-12z" />
                                                                        <path d="M0-.75h48v48h-48z" fill="none" />
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                            <ul id="dropdownOptions">
                                                                <li id="productssearch" data-value="products"
                                                                    data-route="{{ route('products') }}"
                                                                    data-suggest="products" data-type="products"
                                                                    data-placeholder="Search for products..."
                                                                    class="custom-dealrock-text">
                                                                    Products
                                                                </li>
                                                                <li id="leadsbuy" data-value="buyleads"
                                                                    data-route="{{ route('buyer') }}"
                                                                    data-suggest="buyer" data-type="buyer"
                                                                    data-placeholder="Search for buy leads..."
                                                                    class="custom-dealrock-text">
                                                                    Buy Leads
                                                                </li>
                                                                <li id="leadssell" data-value="sellleads"
                                                                    data-route="{{ route('seller') }}"
                                                                    data-suggest="seller" data-type="seller"
                                                                    data-placeholder="Search for sell leads..."
                                                                    class="custom-dealrock-text">
                                                                    Sell offer
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    @endif
                                                    <div class="search_field">
                                                        @if (str_contains(url()->current(), '/job-seeker'))
                                                            <input class="custom-dealrock-text" type="text"
                                                                id="searchInput" class="input" name="vacancy"
                                                                style="width: inherit;height: 100%;border: 0;outline: 0;"
                                                                value="{{ request('vacancy') }}"
                                                                placeholder="{{ translate('Search for job profiles') }}...">
                                                        @elseif(str_contains(url()->current(), '/talent-finder'))
                                                            <input class="custom-dealrock-text" type="text"
                                                                id="searchInput" class="input" name="talentfinder"
                                                                style="width: inherit;height: 100%;border: 0;outline: 0;"
                                                                value="{{ request('talentfinder') }}"
                                                                placeholder="{{ translate('Search for Candidates') }}...">
                                                        @else
                                                            <input class="custom-dealrock-text" type="text"
                                                                id="searchInput" name="searchInput" class="input"
                                                                data-suggest="products"
                                                                style="width: inherit;height: 100%;border: 0;outline: 0;"
                                                                data-type="products" value="{{ request('name') }}"
                                                                placeholder="{{ translate('Search for products') }}...">
                                                        @endif

                                                        <div class="d-flex position-absolute searchbutton justify-content-center"
                                                            onclick="document.getElementsByClassName('wrapperform')[0].submit()"
                                                            style="width: 177px;">
                                                            {{-- <span>Search</span> --}}
                                                            <img src="/images/magnify_icon.png" alt="magnify"
                                                                style="height: 16px; width: 16px;"><span
                                                                class="ml-1" style="font-size: 18px;">Search<span>
                                                        </div>
                                                        <ul id="suggestions" class="dropdown-menu suggestion-dropdown"
                                                            style="display: none;"></ul>
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
                            </div>
                            <div class="frame-11">
                                <a href="{{ route('quotationweb') }}" target="_blank">
                                    <div class="group-9">
                                        <img class="chat img-default" src="/img/chat-1.png" />
                                        <img class="chat img-hover" src="/img/chat (2).png" />
                                        <div class="text-wrapper-9">RFQ</div>
                                    </div>
                                </a>
                                <div class="group-10 position-relative">
                                    <a href="{{ route('vendor.auth.login') }}" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <img class="parcel img-default" src="/img/parcel-1.png" />
                                        <img class="parcel img-hover" src="/img/parcel (2).png" />
                                        <div class="text-wrapper-10">Supplier</div>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}"
                                        aria-labelledby="dropdownMenuButton"
                                        style="border-radius: 10px; min-width: 300px; padding: 20px;">

                                        <div class="detailsboxtop">
                                            <h5 class="custom-dealrock-head mb-3 text-center">Why Join as a Supplier
                                            </h5>
                                            <ul class="feature-list list-unstyled">
                                                <li class="d-flex mb-3">
                                                    <div class="leftclass pr-2">
                                                        <i class="fa fa-tachometer-alt fa-lg text-primary"></i>
                                                    </div>
                                                    <div class="rightclass">
                                                        <strong class="custom-dealrock-subhead">Manage
                                                            Dashboard</strong><br>
                                                        <span class="custom-dealrock-subtext">Access all tools to
                                                            control your products, leads, and offers.</span>
                                                    </div>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <div class="leftclass pr-2">
                                                        <i class="fa fa-crown fa-lg text-warning"></i>
                                                    </div>
                                                    <div class="rightclass">
                                                        <strong class="custom-dealrock-subhead">Flexible
                                                            Memberships</strong><br>
                                                        <span class="custom-dealrock-subtext">Choose a plan that fits
                                                            your scale and goals.</span>
                                                    </div>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <div class="leftclass pr-2">
                                                        <i class="fa fa-briefcase fa-lg text-success"></i>
                                                    </div>
                                                    <div class="rightclass">
                                                        <strong class="custom-dealrock-subhead">Verified Business
                                                            Leads</strong><br>
                                                        <span class="custom-dealrock-subtext">Engage with buyers
                                                            actively looking for suppliers like you.</span>
                                                    </div>
                                                </li>
                                            </ul>

                                            <div class="text-center mt-4">
                                                @if (auth('seller')->check())
                                                    <a href="{{ route('vendor.dashboard.index') }}"
                                                        class="btn btn-primary btn-sm mb-2 w-100">Dashboard</a>
                                                @else
                                                    <a href="{{ route('vendor.auth.login') }}"
                                                        class="btn btn-primary btn-sm mb-2 w-100">Sign In</a>
                                                    <a href="{{ route('vendor.auth.registration.index') }}"
                                                        class="btn btn-primary btn-sm w-100">Sign Up</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="group-11 position-relative">
                                    <a href="{{ route('customer.auth.login') }}" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <img class="customer img-default" src="/img/customer-1.png" />
                                        <img class="customer img-hover" src="/img/customer (2).png" />
                                        <div class="text-wrapper-10">Buyer</div>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}"
                                        aria-labelledby="dropdownMenuButton"
                                        style="border-radius: 10px; min-width: 300px; padding: 20px;">

                                        <div class="detailsboxtop">
                                            <h5 class="custom-dealrock-head mb-3 text-center">Register as a Buyer</h5>
                                            <ul class="feature-list list-unstyled">
                                                <li class="d-flex mb-3">
                                                    <div class="leftclass pr-2">
                                                        <i class="fa fa-search fa-lg text-primary"></i>
                                                    </div>
                                                    <div class="rightclass">
                                                        <strong class="custom-dealrock-subhead">Product
                                                            Discovery</strong><br>
                                                        <span class="custom-dealrock-subtext">Browse thousands of
                                                            products and categories.</span>
                                                    </div>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <div class="leftclass pr-2">
                                                        <i class="fa fa-heart fa-lg text-danger"></i>
                                                    </div>
                                                    <div class="rightclass">
                                                        <strong class="custom-dealrock-subhead">Wishlist &
                                                            Save</strong><br>
                                                        <span class="custom-dealrock-subtext">Shortlist your favorite
                                                            products for later.</span>
                                                    </div>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <div class="leftclass pr-2">
                                                        <i class="fa fa-paper-plane fa-lg text-success"></i>
                                                    </div>
                                                    <div class="rightclass">
                                                        <strong class="custom-dealrock-subhead">Send
                                                            Inquiries</strong><br>
                                                        <span class="custom-dealrock-subtext">Reach out to suppliers
                                                            directly with your needs.</span>
                                                    </div>
                                                </li>
                                            </ul>

                                            <div class="text-center mt-4">
                                                @if (auth('customer')->check())
                                                    <a href="{{ route('account-oder') }}"
                                                        class="btn btn-primary btn-sm mb-2 w-100">My Orders</a>
                                                    <a href="{{ route('user-account') }}"
                                                        class="btn btn-primary btn-sm w-100">My Profile</a>
                                                    <a href="{{ route('customer.auth.logout') }}"
                                                        class="btn btn-primary btn-sm w-100">Logout</a>
                                                @else
                                                    <a href="{{ route('customer.auth.login') }}"
                                                        class="btn btn-primary btn-sm mb-2 w-100">Sign In</a>
                                                    <a href="{{ route('customer.auth.sign-up') }}"
                                                        class="btn btn-primary btn-sm w-100">Sign Up</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="group-11 position-relative" style="width: 23px;height: 100%;">
                                    <a href="javascript:" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <img class="user img-default" src="/img/user-1.png" style="left: 2px;" />
                                        <img class="user img-hover" src="/img/user (2).png" style="left: 2px;" />
                                        <div class="text-wrapper-10">Hire</div>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}"
                                        aria-labelledby="dropdownMenuButton"
                                        style="border-radius: 10px; min-width: 300px; padding: 20px;">

                                        <div class="detailsboxtop">
                                            <h5 class="custom-dealrock-head mb-3 text-center">Hire Talented
                                                Professionals</h5>
                                            <ul class="feature-list list-unstyled">
                                                <li class="d-flex mb-3">
                                                    <div class="leftclass pr-2">
                                                        <i class="fa fa-users fa-lg text-info"></i>
                                                    </div>
                                                    <div class="rightclass">
                                                        <strong class="custom-dealrock-subhead">Browse
                                                            Talent</strong><br>
                                                        <span class="custom-dealrock-subtext">Discover skilled
                                                            freelancers and professionals.</span>
                                                    </div>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <div class="leftclass pr-2">
                                                        <i class="fa fa-briefcase fa-lg text-warning"></i>
                                                    </div>
                                                    <div class="rightclass">
                                                        <strong class="custom-dealrock-subhead">Post Jobs</strong><br>
                                                        <span class="custom-dealrock-subtext">List your hiring needs to
                                                            attract top candidates.</span>
                                                    </div>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <div class="leftclass pr-2">
                                                        <i class="fa fa-comments fa-lg text-success"></i>
                                                    </div>
                                                    <div class="rightclass">
                                                        <strong class="custom-dealrock-subhead">Connect &
                                                            Hire</strong><br>
                                                        <span class="custom-dealrock-subtext">Chat, evaluate, and make
                                                            hiring decisions easily.</span>
                                                    </div>
                                                </li>
                                            </ul>

                                            <div class="text-center mt-4">
                                                @if (auth('customer')->check())
                                                    <a href="{{ route('account-oder') }}"
                                                        class="btn btn-primary btn-sm mb-2 w-100">My Orders</a>
                                                    <a href="{{ route('user-account') }}"
                                                        class="btn btn-primary btn-sm w-100">My Profile</a>
                                                    <a href="{{ route('customer.auth.logout') }}"
                                                        class="btn btn-primary btn-sm w-100">Logout</a>
                                                @else
                                                    <a href="{{ route('customer.auth.hire-sign-in') }}"
                                                        class="btn btn-primary btn-sm mb-2 w-100">Sign In</a>
                                                    <a href="{{ route('customer.auth.hire-sign-up') }}"
                                                        class="btn btn-primary btn-sm w-100">Sign Up</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="group-13">
                                    <div id="google-translate-dropdown"
                                        style="display: none;position: absolute;top: -17px;right: 0;z-index: 10000000;background: white;border: 1px solid black;padding: 15px;">
                                    </div>
                                    <a href="{{ route('gotoshortlist') }}">
                                        <img class="heart img-default" src="/img/heart-1.png" />
                                        <img class="heart img-hover" src="/img/heart (2).png" />
                                        <div class="text-wrapper-11">Shortlist</div>
                                    </a>
                                </div>
                            </div>
                            <div class="hamburger" onclick="toggleDropdown()"><img src="/img/menu.png"
                                    alt="menu" style="height: 16px; width: 16px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="dropdown-nav" id="dropdownNav">
    <a class="flexboxlogocross" href="{{ url('/') }}">
        <img class="logo-3" src="/img/logo-2.png" />
        <button class="drawer-close" onclick="toggleDropdown()">✕</button>
    </a>
    <a href="{{ route('stocksale') }}">Stock Sale</a>
    <a href="{{ route('buyer') }}">Buy Leads</a>
    <a href="{{ route('seller') }}">Sell Offer</a>
    <a href="{{ route('dealassist') }}">Deal Assist</a>
    <a href="{{ route('sendcv') }}">Industry Jobs</a>
    <a href="{{ route('tradeshow') }}">Trade Shows</a>
    <a href="{{ route('vendor.auth.registration.index') }}">Supplier Zone</a>
</div>
@push('script')
    <script defer src="{{ theme_asset('public/js/header.js') }}"></script>
    <script defer>
        "use strict";
        $(".category-menu").find(".mega_menu").parents("li")
            .addClass("has-sub-item").find("> a")
            .append("<i class='czi-arrow-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}'></i>");

        function toggleDropdown() {
            document.getElementById("dropdownNav").classList.toggle("show");
        }
    </script>
@endpush
