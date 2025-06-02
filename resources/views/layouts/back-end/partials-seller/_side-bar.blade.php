@php
    use App\Enums\ViewPaths\Vendor\Chatting;
    use App\Enums\ViewPaths\Vendor\Product;
    use App\Enums\ViewPaths\Vendor\Profile;
    use App\Enums\ViewPaths\Vendor\Refund;
    use App\Enums\ViewPaths\Vendor\Review;
    use App\Enums\ViewPaths\Vendor\DeliveryMan;
    use App\Enums\ViewPaths\Vendor\EmergencyContact;
    use App\Models\Order;
    use App\Models\RefundRequest;
    use App\Models\Shop;
    use App\Utils\ChatManager;
    use App\Enums\ViewPaths\Vendor\Order as OrderEnum;
    $shop = Shop::where(['seller_id' => auth('seller')->id()])->first();
    ChatManager::RedirectSupplierDetails();
@endphp
<style>
    .smallview {
        width: 75px;
        transition: all 0.3s ease;
    }

    .smallview:hover {
        width: 265px;
    }

    .navbar-vertical-aside-has-menu {
        display: none;
    }

    .smallview:hover .navbar-vertical-aside-has-menu {
        display: block;
    }

    .nav-tabs .nav-item.active {
        color: white;
        background-color: #E72528;
        padding-left: 5px;
    }

    .nav-tabs .nav-item {
        padding-left: 12px;
        margin-top: 0px !important;
    }

    .nav-item.active small {
        color: white;
    }

    .navbar-vertical-content::-webkit-scrollbar {
        width: 1px;
    }

    .navbar-vertical-content .nav-link:hover i {
        color: #FFFFFF;
    }

    .smallview:hover .nav-item {
        padding-left: 4px;
        flex-direction: column;
    }

    .smallview:hover .nav-item-button-sidebar {
        padding-left: 0px;
        margin-left: -3px;
        width: 98%;
        border-radius: 6px;
    }

    .smallview:hover .nav-item i {
        padding-right: 0;
    }

    .smallview:hover .nav-item a {
        padding-right: 0;
        position: relative;
        left: -7px;
        padding: 0;
    }

    .smallview .nav-item a {
        color: #4E5D52 !important;
        position: relative;
        width: 100%;
        padding: 0 !important;
    }

    .smallview .nav-link:hover .nav-subtitle {
        color: white;
    }

    .smallview .nav-item a:hover {
        color: white !important;
    }

    .nav-item-button-sidebar {
        padding-left: 11px;
    }

    .nav-item i {
        padding-right: 16px;
        padding-left: 7px;
        font-size: 20px;
    }

    .nav-item-button-sidebar a {
        padding-left: 3px !important;
    }

    .nav-item-button-sidebar i {
        padding-right: 16px !important;
        color: #4E5D52;
        padding-left: 5px;
        font-size: 20px;
    }

    .nav-item-button-sidebar span {
        text-transform: uppercase !important;
        font-size: 13px;
        font-weight: 700;
    }

    .nav-item-button-sidebar.active i {
        padding-left: 9px;
        padding-right: 12px !important;
    }

    .nav-item-button-sidebar.active {
        color: white;
        background-color: #E72528;
    }

    .navbar-vertical-content {
        background: var(--sidebar);
        padding-left: 7px;
        padding-right: 3px;
    }

    .smallview:hover .navbar-vertical-content {
        background: var(--sidebar);
        /* padding: 10px 15px; */
    }

    .nav-item-button-sidebar.active i {
        color: white;
    }

    .centermagnifymain {
        position: relative;
        flex-wrap: unset;
        display: inline-flex;
    }

    .centermagnifymain-icon {
        justify-content: left;
        align-content: center;
        font-size: 20px;
        padding-left: 20px;
        padding-right: 25px;
    }

    .smallview:hover .centermagnifymain-icon {
        justify-content: left;
        align-content: center;
        font-size: 20px;
        padding-left: 8px;
        padding-right: 11px;
    }

    .smallview .dropdown-content a {
        font-size: 16px !important;
    }

    .smallview .dropdown-content a {
        padding: 4px !important;
    }

    @media (min-width: 1200px) {
        .navbar-vertical-aside-show-xl .main {
            padding-left: 70px;
            transition: padding-left 0.3s ease;
        }

        .navbar-vertical-aside-show-xl:hover .smallview:hover~.main {
            padding-left: 265px;
        }

        .navbar-vertical-aside-show-xl .footer {
            margin-left: 3.25rem;
        }
    }
</style>
<div id="sidebarMain" class="d-none">
    <aside style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};"
        class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered smallview">
        <div class="navbar-vertical-container">
            <div class="navbar-vertical-footer-offset pb-0">
                <div class="navbar-brand-wrapper justify-content-between side-logo">
                    {{-- <a class="navbar-brand" href="{{ route('vendor.dashboard.index') }}" aria-label="Front">
                        @if (isset($shop))
                            <img class="navbar-brand-logo-mini for-seller-logo"
                                src="{{ getStorageImages(path: $shop->image_full_url, type: 'backend-logo') }}"
                                alt="{{ translate('logo') }}">
                        @else
                            <img class="navbar-brand-logo-mini for-seller-logo"
                                src="{{ dynamicAsset(path: 'public/assets/back-end/img/900x400/img1.jpg') }}"
                                alt="{{ translate('logo') }}">
                        @endif
                    </a> --}}
                    {{-- <button type="button"
                        class="d-none js-navbar-vertical-aside-toggle-invoker navbar-vertical-aside-toggle btn btn-icon btn-xs btn-ghost-dark">
                        <i class="tio-clear tio-lg"></i>
                    </button>

                    <button type="button" class="js-navbar-vertical-aside-toggle-invoker close mr-3">
                        <i class="tio-first-page navbar-vertical-aside-toggle-short-align"></i>
                        <i class="tio-last-page navbar-vertical-aside-toggle-full-align"
                            data-template="<div class=&quot;tooltip d-none d-sm-block&quot; role=&quot;tooltip&quot;><div class=&quot;arrow&quot;></div><div class=&quot;tooltip-inner&quot;></div></div>"></i>
                    </button> --}}
                </div>
                <div class="navbar-vertical-content">
                    <div class="sidebar--search-form pb-1 pt-1 centermagnifymain">
                        <i class="fa-solid fa-magnifying-glass centermagnifymain-icon"></i>
                        <div class="search--form-group">
                            <button type="button" class="btn"><i class="tio-search"></i></button>
                            <input type="text" class="js-form-search form-control form--control"
                                id="search-bar-input" placeholder="{{ translate('search_menu') . '...' }}">
                        </div>
                    </div>
                    @if (\App\Utils\ChatManager::checkifsupplier() == true)
                        <li class="nav-item {{ Request::is('vendor/supplier/*') ? 'active' : '' }}">
                            <small class="nav-subtitle" title="">{{ translate('Supplier_section') }}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>
                        <li
                            class="navbar-vertical-aside-has-menu {{ Request::is('vendor/supplier/status-update') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="{{ route('vendor.supplier.status.update') }}"
                                title="{{ translate('Supplier_Profile') }}">
                                <i class="tio-chart-bar-3 nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate text-capitalize">
                                    {{ translate('Supplier_Profile') }}
                                </span>
                            </a>
                        </li>
                    @endif
                    @if (\App\Utils\ChatManager::checkStatusSupplier() == 1)
                        <ul class="navbar-nav navbar-nav-lg nav-tabs">
                            <li class="nav-item-button-sidebar {{ Request::is('vendor/dashboard*') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{ route('vendor.dashboard.index') }}">
                                    <i class="fa-solid fa-border-all"></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('dashboard') }}
                                    </span>
                                </a>
                            </li>
                            @php($seller = auth('seller')->user())
                            @php($sellerId = $seller['id'])
                            @php($sellerPOS = getWebConfig('seller_pos'))
                            @if ($sellerPOS == 1 && $seller['pos_status'] == 1)
                                <li
                                    class="navbar-vertical-aside-has-menu {{ Request::is('vendor/pos*') ? 'active' : '' }}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link"
                                        href="{{ route('vendor.pos.index') }}">
                                        <i class="tio-shopping nav-icon"></i>
                                        <span
                                            class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{ translate('POS') }}</span>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item navbar-vertical-aside-has-menu">
                                <a href="javascript:void(0);" class="nav-link text-capitalize toggle-dropdown"
                                    title="{{ translate('reports_&_analytics') }}">
                                    <i class="fa-solid fa-chart-line me-2"></i>
                                    <span class="nav-subtitle">{{ translate('reports_&_analytics') }}</span>
                                    <i class="tio-chevron-down float-end"></i>
                                </a>

                                <ul class="nav-sub dropdown-content w-100" style="display: none; padding-left: 15px;">
                                    <li
                                        class="navbar-vertical-aside-has-menu {{ Request::is('vendor/report/all-product') || Request::is('vendor/report/stock-product-report') ? 'active' : '' }}">
                                        <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                            href="{{ route('vendor.subcard', ['slug' => 'analytics']) }}"
                                            title="{{ translate('product_report') }}">
                                            {{ translate('product_report') }}
                                        </a>
                                    </li>
                                    <li
                                        class="navbar-vertical-aside-has-menu {{ Request::is('vendor/report/order-report') ? 'active' : '' }}">
                                        <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                            href="{{ route('vendor.subcard', ['slug' => 'analytics']) }}"
                                            title="{{ translate('order_report') }}">
                                            {{ translate('order_report') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/vendor-inbox*') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'vendor-inbox']) }}">
                                    <i class="fa-solid fa-inbox"></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('Inbox') }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item navbar-vertical-aside-has-menu">
                                <a href="javascript:void(0);" class="nav-link text-capitalize toggle-dropdown"
                                    title="{{ translate('Product Upload') }}">
                                    <i class="fa-solid fa-box me-2"></i>
                                    <span class="nav-subtitle">{{ translate('Product Upload') }}</span>
                                    <i class="tio-chevron-down float-end transition-icon"></i>
                                </a>

                                <ul class="nav-sub dropdown-content w-100 transition-dropdown"
                                    style="display: none; padding-left: 15px;">
                                    <li
                                        class="navbar-vertical-aside-has-menu {{ Request::is('vendor/subcard/product-upload') ? 'active' : '' }}">
                                        <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                            href="{{ route('vendor.subcard', ['slug' => 'product-upload']) }}"
                                            title="{{ translate('Add Product') }}">
                                            {{ translate('Add Product') }}
                                        </a>
                                    </li>
                                    <li
                                        class="navbar-vertical-aside-has-menu {{ Request::is('vendor/subcard/product-upload') ? 'active' : '' }}">
                                        <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                            href="{{ route('vendor.subcard', ['slug' => 'product-upload']) }}"
                                            title="{{ translate('Bulk Import') }}">
                                            {{ translate('Bulk Import') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/profile*') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'profile']) }}">
                                    <i class="fa-solid fa-user"></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('Profile') }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item navbar-vertical-aside-has-menu">
                                <a href="javascript:void(0);" class="nav-link text-capitalize toggle-dropdown"
                                    title="{{ translate('Upload Banner') }}">
                                    <i class="fa-solid fa-upload me-2"></i>
                                    <span class="nav-subtitle">{{ translate('Upload Banner') }}</span>
                                    <i class="tio-chevron-down float-end transition-icon"></i>
                                </a>

                                <ul class="nav-sub dropdown-content w-100 transition-dropdown"
                                    style="display: none; padding-left: 15px;">
                                    <li
                                        class="navbar-vertical-aside-has-menu {{ Request::is('vendor/subcard/upload-banner') ? 'active' : '' }}">
                                        <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                            href="{{ route('vendor.subcard', ['slug' => 'upload-banner']) }}"
                                            title="{{ translate('Marketplace') }}">
                                            {{ translate('Marketplace') }}
                                        </a>
                                    </li>
                                    <li class="navbar-vertical-aside-has-menu">
                                        <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                            href="{{ route('vendor.subcard', ['slug' => 'upload-banner']) }}"
                                            title="{{ translate('Buy Leads') }}">
                                            {{ translate('Buy Leads') }}
                                        </a>
                                    </li>
                                    <li class="navbar-vertical-aside-has-menu">
                                        <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                            href="{{ route('vendor.subcard', ['slug' => 'upload-banner']) }}"
                                            title="{{ translate('Sell Offer') }}">
                                            {{ translate('Sell Offer') }}
                                        </a>
                                    </li>
                                    <li class="navbar-vertical-aside-has-menu">
                                        <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                            href="{{ route('vendor.subcard', ['slug' => 'upload-banner']) }}"
                                            title="{{ translate('Tradeshows') }}">
                                            {{ translate('Tradeshows') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/membership') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'membership']) }}">
                                    <i class="fa-solid fa-user-plus"></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('Membership') }}
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/faq') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'faq']) }}">
                                    <i class="fa-solid fa-question"></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('FAQ') }}
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/settings') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'settings']) }}">
                                    <i class="fa-solid fa-sliders"></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('Settings') }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item navbar-vertical-aside-has-menu">
                                <a href="javascript:void(0);" class="nav-link text-capitalize toggle-dropdown"
                                    title="{{ translate('Stock Sell') }}">
                                    <i class="fa-solid fa-cubes me-2"></i>
                                    <span class="nav-subtitle">{{ translate('Stock Sell') }}</span>
                                    <i class="tio-chevron-down float-end transition-icon"></i>
                                </a>

                                <ul class="nav-sub dropdown-content w-100 transition-dropdown"
                                    style="display: none; padding-left: 15px;">
                                    <li
                                        class="navbar-vertical-aside-has-menu {{ Request::is('vendor/subcard/stock-sell') ? 'active' : '' }}">
                                        <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                            href="{{ route('vendor.subcard', ['slug' => 'stock-sell']) }}"
                                            title="{{ translate('Manage Stock Sell') }}">
                                            {{ translate('Manage Stock Sell') }}
                                        </a>
                                    </li>
                                    <li class="navbar-vertical-aside-has-menu">
                                        <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                            href="{{ route('vendor.subcard', ['slug' => 'stock-sell']) }}"
                                            title="{{ translate('Add Stock Sell') }}">
                                            {{ translate('Add Stock Sell') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/buy-leads') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'buy-leads']) }}">
                                    <i class="fa-solid fa-pencil"></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('Buy Leads') }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item navbar-vertical-aside-has-menu">
                                <a href="javascript:void(0);" class="nav-link text-capitalize toggle-dropdown"
                                    title="{{ translate('Sale Offer') }}">
                                    <i class="fa-solid fa-leaf me-2"></i>
                                    <span class="nav-subtitle">{{ translate('Sale Offer') }}</span>
                                    <i class="tio-chevron-down float-end transition-icon"></i>
                                </a>

                                <ul class="nav-sub dropdown-content w-100 transition-dropdown"
                                    style="display: none; padding-left: 15px;">
                                    <li
                                        class="navbar-vertical-aside-has-menu {{ Request::is('vendor/subcard/sell-offer') ? 'active' : '' }}">
                                        <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                            href="{{ route('vendor.subcard', ['slug' => 'sell-offer']) }}"
                                            title="{{ translate('Manage Sale Offer') }}">
                                            {{ translate('Manage Sale Offer') }}
                                        </a>
                                    </li>
                                    <li class="navbar-vertical-aside-has-menu">
                                        <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                            href="{{ route('vendor.subcard', ['slug' => 'sell-offer']) }}"
                                            title="{{ translate('Add Sale Offer') }}">
                                            {{ translate('Add Sale Offer') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/deal-assist') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'deal-assist']) }}">
                                    <i class="fa-solid fa-handshake"></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('Deal Assist') }}
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/trade-shows') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'trade-shows']) }}">
                                    <i class="fa-solid fa-trademark"></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('Trade Shows') }}
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/post-rfq') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'post-rfq']) }}">
                                    <i class="fa-solid fa-envelope-open-text"></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('RFQ') }}
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/hire-employee') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'hire-employee']) }}">
                                    <i class="fa-solid fa-shield-halved"></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('Hire Employee') }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item navbar-vertical-aside-has-menu">
                                <a href="javascript:void(0);" class="nav-link text-capitalize toggle-dropdown"
                                    title="{{ translate('Post Job') }}">
                                    <i class="fa-solid fa-sitemap me-2"></i>
                                    <span class="nav-subtitle">{{ translate('Post Job') }}</span>
                                    <i class="tio-chevron-down float-end transition-icon"></i>
                                </a>

                                <ul class="nav-sub dropdown-content w-100 transition-dropdown"
                                    style="display: none; padding-left: 15px;">
                                    <li
                                        class="navbar-vertical-aside-has-menu {{ Request::is('vendor/subcard/post-job') ? 'active' : '' }}">
                                        <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                            href="{{ route('vendor.subcard', ['slug' => 'post-job']) }}"
                                            title="{{ translate('Manage Jobs') }}">
                                            {{ translate('Manage Jobs') }}
                                        </a>
                                    </li>
                                    <li class="navbar-vertical-aside-has-menu">
                                        <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                            href="{{ route('vendor.subcard', ['slug' => 'post-job']) }}"
                                            title="{{ translate('Add Jobs') }}">
                                            {{ translate('Add Jobs') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item navbar-vertical-aside-has-menu">
                                <a href="javascript:void(0);" class="nav-link text-capitalize toggle-dropdown"
                                    title="{{ translate('Marketplace') }}">
                                    <i class="fa-solid fa-store me-2"></i>
                                    <span class="nav-subtitle">{{ translate('Marketplace') }}</span>
                                    <i class="tio-chevron-down float-end transition-icon"></i>
                                </a>

                                <ul class="nav-sub dropdown-content w-100 transition-dropdown"
                                    style="display: none; padding-left: 15px;">
                                    <li class="{{ Request::is('vendor/subcard/marketplace') ? 'active' : '' }}">
                                        <a class="nav-link text-capitalize"
                                            href="{{ route('vendor.subcard', ['slug' => 'marketplace']) }}"
                                            title="{{ translate('Manage Products') }}">
                                            {{ translate('Manage Products') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link text-capitalize"
                                            href="{{ route('vendor.subcard', ['slug' => 'marketplace']) }}"
                                            title="{{ translate('Approved Products') }}">
                                            {{ translate('Approved Products') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link text-capitalize"
                                            href="{{ route('vendor.subcard', ['slug' => 'marketplace']) }}"
                                            title="{{ translate('Denied Products') }}">
                                            {{ translate('Denied Products') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link text-capitalize"
                                            href="{{ route('vendor.subcard', ['slug' => 'marketplace']) }}"
                                            title="{{ translate('New Product Request') }}">
                                            {{ translate('New Product Request') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </aside>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fetching Url's
        var CurrentUrl = window.location.href;

        // Activating corrosponding paths based on activation - Leads
        if (CurrentUrl.includes('/leads/list')) {
            document.getElementById('leadslist').classList.add('show', 'active');
        } else if (CurrentUrl.includes('/leads/add-new')) {
            document.getElementById('leadsaddnew').classList.add('show', 'active');
        } else if (CurrentUrl.includes('/leads/bulk')) {
            document.getElementById('leadsbulkimport').classList.add('show', 'active');
        } else if (CurrentUrl.includes('/leads/view')) {
            document.getElementById('leadslist').classList.add('show', 'active');
        } else if (CurrentUrl.includes('/leads/edit')) {
            document.getElementById('leadslist').classList.add('show', 'active');
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.toggle-dropdown').forEach(function(toggle) {
            toggle.addEventListener('click', function() {
                const dropdown = this.nextElementSibling;
                const icon = this.querySelector('.tio-chevron-down');

                if (dropdown.style.display === 'block') {
                    dropdown.style.display = 'none';
                    icon.classList.remove('rotate-180');
                } else {
                    dropdown.style.display = 'block';
                    icon.classList.add('rotate-180');
                }
            });
        });
    });
</script>

<style>
    .rotate-180 {
        transform: rotate(180deg);
        transition: transform 0.3s ease;
    }
</style>
<script>
    $('.js-navbar-vertical-aside-toggle-invoker').on('click', function() {
        setTimeout(function() {
            console.log('Sidebar toggled, checking width...');
            var allToHide = $('.specialhidden');
            var windowWidth = $(window).width();

            if (windowWidth < 200) {
                allToHide.each(function() {
                    $(this).css('display', 'none');
                });
            } else {
                allToHide.each(function() {
                    $(this).css('display', 'block');
                });
            }
        }, 800);
    });
</script>
