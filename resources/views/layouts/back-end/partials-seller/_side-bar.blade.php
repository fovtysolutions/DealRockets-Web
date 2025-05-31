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
        width: 44px;
        transition: all 0.3s ease;
    }

    .smallview:hover {
        width: 265px;
    }

    .navbar-vertical-aside-has-menu {
        display: none;
    }

    .sidebar--search-form {
        display: none;
    }

    .smallview:hover .sidebar--search-form {
        display: block;
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
        padding-left: 3px;
        margin-top: 0px !important;
    }

    .nav-item.active small {
        color: white;
    }

    .navbar-vertical-content .nav-link:hover i {
        color: #FFFFFF;
    }

    .smallview:hover .nav-item {
        padding-left: 3px;
    }

    .nav-item-button-sidebar a {
        padding-left: 0 !important;
    }

    .nav-item-button-sidebar i {
        padding-right: 10px !important;
        color: #4E5D52;
    }

    .nav-item-button-sidebar span {
        text-transform: uppercase !important;
        font-size: 13px;
        font-weight: 700;
    }

    .nav-item-button-sidebar.active i {
        padding-left: 5px;
        padding-right: 0px !important;
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
        padding: 10px 15px;
    }

    .nav-item-button-sidebar.active i{
        color: white;
    }

    @media (min-width: 1200px) {
        .navbar-vertical-aside-show-xl .main {
            padding-left: 50px;
            transition: padding-left 0.3s ease;
        }

        .navbar-vertical-aside-show-xl:hover .smallview:hover~.main {
            padding-left: 265px;
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
                    <div class="sidebar--search-form pb-3 pt-4">
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
                            <li
                                class="navbar-vertical-aside-has-menu {{ Request::is('vendor/dashboard*') ? 'show' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{ route('vendor.dashboard.index') }}">
                                    <i class='bx  bxs-dashboard'></i>
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
                            <li
                                class="nav-item specialhidden  {{ Request::is('vendor/subcard/analytics') ? 'active' : '' }}">
                                <i class='bx  bx-report'></i>
                                <small class="nav-subtitle">{{ translate('reports_&_analytics') }}</small>
                                <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                            </li>
                            <li
                                class="navbar-vertical-aside-has-menu {{ Request::is('vendor/report/all-product') || Request::is('vendor/report/stock-product-report') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                    href="{{ route('vendor.subcard', ['slug' => 'analytics']) }}"
                                    title="{{ translate('product_report') }}">
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        <span class="position-relative text-capitalize">
                                            {{ translate('product_report') }}
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li
                                class="navbar-vertical-aside-has-menu {{ Request::is('vendor/report/order-report') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                    href="{{ route('vendor.subcard', ['slug' => 'analytics']) }}"
                                    title="{{ translate('order_report') }}">
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('order_Report') }}
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/vendor-inbox*') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'vendor-inbox']) }}">
                                    <i class='bx  bx-inbox'></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('Inbox') }}
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item specialhidden  {{ Request::is('vendor/subcard/product-upload') ? 'active' : '' }}">
                                <i class='bx  bx-turkey-meat'></i>
                                <small class="nav-subtitle">{{ translate('Product Upload') }}</small>
                                <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                            </li>
                            <li class="navbar-vertical-aside-has-menu">
                                <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                    href="{{ route('vendor.subcard', ['slug' => 'product-upload']) }}"
                                    title="{{ translate('Add Product') }}">
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        <span class="position-relative text-capitalize">
                                            {{ translate('Add Product') }}
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="navbar-vertical-aside-has-menu">
                                <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                    href="{{ route('vendor.subcard', ['slug' => 'product-upload']) }}"
                                    title="{{ translate('Bulk Import') }}">
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('Bulk Import') }}
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/profile*') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'profile']) }}">
                                    <i class='bx  bx-user-square'></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('Profile') }}
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item specialhidden  {{ Request::is('vendor/subcard/upload-banner') ? 'active' : '' }}">
                                <i class='bx  bx-square-dashed-half'></i>
                                <small class="nav-subtitle">{{ translate('Upload Banner') }}</small>
                                <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                            </li>
                            <li class="navbar-vertical-aside-has-menu">
                                <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                    href="{{ route('vendor.subcard', ['slug' => 'upload-banner']) }}"
                                    title="{{ translate('Marketplace') }}">
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        <span class="position-relative text-capitalize">
                                            {{ translate('Marketplace') }}
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="navbar-vertical-aside-has-menu">
                                <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                    href="{{ route('vendor.subcard', ['slug' => 'upload-banner']) }}"
                                    title="{{ translate('Buy Leads') }}">
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('Buy Leads') }}
                                    </span>
                                </a>
                            </li>
                            <li class="navbar-vertical-aside-has-menu">
                                <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                    href="{{ route('vendor.subcard', ['slug' => 'upload-banner']) }}"
                                    title="{{ translate('Sell Offer') }}">
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('Sell Offer') }}
                                    </span>
                                </a>
                            </li>
                            <li class="navbar-vertical-aside-has-menu">
                                <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                    href="{{ route('vendor.subcard', ['slug' => 'upload-banner']) }}"
                                    title="{{ translate('Tradeshows') }}">
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('Tradeshows') }}
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/membership') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'membership']) }}">
                                    <i class='bx  bx-user-square'></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('Membership') }}
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/faq') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'faq']) }}">
                                    <i class='bx  bx-message-bubble-question-mark'></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('FAQ') }}
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/settings') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'settings']) }}">
                                    <i class='bx  bx-cog'></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('Settings') }}
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item specialhidden  {{ Request::is('vendor/subcard/stock-sell') ? 'active' : '' }}">
                                <i class='bx  bx-barn'></i>
                                <small class="nav-subtitle">{{ translate('Stock Sell') }}</small>
                                <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                            </li>
                            <li class="navbar-vertical-aside-has-menu">
                                <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                    href="{{ route('vendor.subcard', ['slug' => 'stock-sell']) }}"
                                    title="{{ translate('Manage Stock Sell') }}">
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        <span class="position-relative text-capitalize">
                                            {{ translate('Manage Stock Sell') }}
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="navbar-vertical-aside-has-menu">
                                <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                    href="{{ route('vendor.subcard', ['slug' => 'stock-sell']) }}"
                                    title="{{ translate('Add Stock Sell') }}">
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('Add Stock Sell') }}
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/buy-leads') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'buy-leads']) }}">
                                    <i class='bx  bx-arrow-s-right'></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('Buy Leads') }}
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item specialhidden  {{ Request::is('vendor/subcard/sell-offer') ? 'active' : '' }}">
                                <i class='bx  bx-arrow-s-left'></i>
                                <small class="nav-subtitle">{{ translate('Sale Offer') }}</small>
                                <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                            </li>
                            <li class="navbar-vertical-aside-has-menu">
                                <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                    href="{{ route('vendor.subcard', ['slug' => 'sell-offer']) }}"
                                    title="{{ translate('Manage Sale Offer') }}">
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        <span class="position-relative text-capitalize">
                                            {{ translate('Manage Sale Offer') }}
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="navbar-vertical-aside-has-menu">
                                <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                    href="{{ route('vendor.subcard', ['slug' => 'sell-offer']) }}"
                                    title="{{ translate('Add Sale Offer') }}">
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('Add Sale Offer') }}
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/deal-assist') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'deal-assist']) }}">
                                    <i class='bx  bx-people-handshake'></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('Deal Assist') }}
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/trade-shows') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'trade-shows']) }}">
                                    <i class='bx  bx-tent'></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('Trade Shows') }}
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/post-rfq') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'post-rfq']) }}">
                                    <i class='bx  bx-mail-open'></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('RFQ') }}
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/hire-employee') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'hire-employee']) }}">
                                    <i class='bx  bx-community'  ></i> 
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('Hire Employee') }}
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item specialhidden  {{ Request::is('vendor/subcard/post-job') ? 'active' : '' }}">
                                <i class='bx  bx-group'  ></i> 
                                <small class="nav-subtitle">{{ translate('Post Job') }}</small>
                                <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                            </li>
                            <li class="navbar-vertical-aside-has-menu">
                                <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                    href="{{ route('vendor.subcard', ['slug' => 'post-job']) }}"
                                    title="{{ translate('Manage Jobs') }}">
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        <span class="position-relative text-capitalize">
                                            {{ translate('Manage Jobs') }}
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="navbar-vertical-aside-has-menu">
                                <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                    href="{{ route('vendor.subcard', ['slug' => 'post-job']) }}"
                                    title="{{ translate('Add Jobs') }}">
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('Add Jobs') }}
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item specialhidden  {{ Request::is('vendor/subcard/marketplace') ? 'active' : '' }}">
                                <i class='bx  bx-pencil-edit-circle'  ></i> 
                                <small class="nav-subtitle">{{ translate('Marketplace') }}</small>
                                <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                            </li>
                            <li class="navbar-vertical-aside-has-menu">
                                <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                    href="{{ route('vendor.subcard', ['slug' => 'marketplace']) }}"
                                    title="{{ translate('Manage Products') }}">
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        <span class="position-relative text-capitalize">
                                            {{ translate('Manage Products') }}
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="navbar-vertical-aside-has-menu">
                                <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                    href="{{ route('vendor.subcard', ['slug' => 'marketplace']) }}"
                                    title="{{ translate('Approved Products') }}">
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('Approved Products') }}
                                    </span>
                                </a>
                            </li>
                            <li class="navbar-vertical-aside-has-menu">
                                <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                    href="{{ route('vendor.subcard', ['slug' => 'marketplace']) }}"
                                    title="{{ translate('Denied Products') }}">
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('Approved Products') }}
                                    </span>
                                </a>
                            </li>
                            <li class="navbar-vertical-aside-has-menu">
                                <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                    href="{{ route('vendor.subcard', ['slug' => 'marketplace']) }}"
                                    title="{{ translate('New Product Request') }}">
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ translate('New Product Request') }}
                                    </span>
                                </a>
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
