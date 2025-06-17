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
<link rel="stylesheet" href="{{ theme_asset('public/assets/custom-css/vendorpanel/sidebar.css') }}">
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
                            <li class="nav-item-button-sidebar {{ Request::is('vendor/dashboard*') ? 'active' : '' }}"  style="border-top: 2px solid rgb(195 195 195) !important;">
                                <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                    href="{{ route('vendor.dashboard.index') }}">
                                    <i class="fa-solid fa-border-all sidebar-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                        {{ translate('dashboard') }}
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/profile*') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'profile']) }}">
                                    <i class="fa-solid fa-user sidebar-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                        {{ translate('My Profile') }}
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/vendor-inbox*') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'vendor-inbox']) }}">
                                    <i class="fa-solid fa-inbox sidebar-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                        {{ translate('Inbox') }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item-button-sidebar">
                                <a href="javascript:void(0);"
                                    class="nav-link text-capitalize toggle-dropdown sidebar-link  {{ Request::is('vendor/subcard/product-upload') ? 'active' : '' }}"
                                    title="{{ translate('Product Upload') }}">
                                    <i class="fa-solid fa-box me-2 sidebar-icon"></i>
                                    <span class="sidebar-text">{{ translate('Product Upload') }}</span>
                                    <i class="tio-chevron-down float-end transition-icon"></i>
                                </a>

                                <ul class="nav-sub dropdown-content w-100 transition-dropdown"
                                    style="display: none; padding-left: 15px;">
                                    <li
                                        class="navbar-vertical-aside-has-menu">
                                        <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                            href="{{ route('vendor.subcard', ['slug' => 'product-upload']) }}"
                                            title="{{ translate('Add Product') }}">
                                            {{ translate('Add Product') }}
                                        </a>
                                    </li>
                                    <li
                                        class="navbar-vertical-aside-has-menu">
                                        <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                            href="{{ route('vendor.subcard', ['slug' => 'product-upload']) }}"
                                            title="{{ translate('Bulk Import') }}">
                                            {{ translate('Bulk Import') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item-button-sidebar">
                                <a href="javascript:void(0);"
                                    class="nav-link text-capitalize toggle-dropdown sidebar-link {{ Request::is('vendor/subcard/upload-banner') ? 'active' : '' }}"
                                    title="{{ translate('Upload Banner') }}">
                                    <i class="fa-solid fa-upload me-2 sidebar-icon"></i>
                                    <span class="sidebar-text">{{ translate('Upload Banner') }}</span>
                                    <i class="tio-chevron-down float-end transition-icon"></i>
                                </a>

                                <ul class="nav-sub dropdown-content w-100 transition-dropdown"
                                    style="display: none; padding-left: 15px;">
                                    <li
                                        class="navbar-vertical-aside-has-menu ">
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
                            <li class="nav-item-button-sidebar {{ Request::is('vendor/subcard/analytics') ? 'active' : '' }}" style="border-bottom: 2px solid rgb(195 195 195) !important;">
                                <a href="javascript:void(0);"
                                    class="nav-link text-capitalize toggle-dropdown sidebar-link"
                                    title="{{ translate('reports_&_analytics') }}">
                                    <i class="fa-solid fa-chart-line me-2 sidebar-icon"></i>
                                    <span
                                        class="sidebar-text">{{ translate('Reports') }}</span>
                                    <i class="tio-chevron-down float-end"></i>
                                </a>

                                <ul class="nav-sub dropdown-content w-100" style="display: none; padding-left: 15px;">
                                    <li
                                        class="navbar-vertical-aside-has-menu">
                                        <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                            href="{{ route('vendor.subcard', ['slug' => 'analytics']) }}"
                                            title="{{ translate('product_report') }}">
                                            {{ translate('product_report') }}
                                        </a>
                                    </li>
                                    <li
                                        class="navbar-vertical-aside-has-menu">
                                        <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize"
                                            href="{{ route('vendor.subcard', ['slug' => 'analytics']) }}"
                                            title="{{ translate('order_report') }}">
                                            {{ translate('order_report') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item-button-sidebar {{ Request::is('vendor/subcard/stock-sell') ? 'active' : '' }}">
                                <a href="javascript:void(0);"
                                    class="nav-link text-capitalize toggle-dropdown sidebar-link"
                                    title="{{ translate('Stock Sell') }}">
                                    <i class="fa-solid fa-cubes me-2 sidebar-icon"></i>
                                    <span
                                        class="sidebar-text sidebar-text">{{ translate('Stock Sell') }}</span>
                                    <i class="tio-chevron-down float-end transition-icon"></i>
                                </a>

                                <ul class="nav-sub dropdown-content w-100 transition-dropdown"
                                    style="display: none; padding-left: 15px;">
                                    <li
                                        class="navbar-vertical-aside-has-menu">
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
                                <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'buy-leads']) }}">
                                    <i class="fa-solid fa-pencil sidebar-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                        {{ translate('Buy Leads') }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item-button-sidebar {{ Request::is('vendor/subcard/sell-offer') ? 'active' : '' }}">
                                <a href="javascript:void(0);"
                                    class="nav-link text-capitalize toggle-dropdown sidebar-link"
                                    title="{{ translate('Sale Offer') }}">
                                    <i class="fa-solid fa-leaf me-2 sidebar-icon"></i>
                                    <span class="sidebar-text">{{ translate('Sale Offer') }}</span>
                                    <i class="tio-chevron-down float-end transition-icon"></i>
                                </a>

                                <ul class="nav-sub dropdown-content w-100 transition-dropdown"
                                    style="display: none; padding-left: 15px;">
                                    <li
                                        class="navbar-vertical-aside-has-menu">
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
                                <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'deal-assist']) }}">
                                    <i class="fa-solid fa-handshake sidebar-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                        {{ translate('Deal Assist') }}
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/trade-shows') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'trade-shows']) }}">
                                    <i class="fa-solid fa-trademark sidebar-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                        {{ translate('Trade Shows') }}
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/post-rfq') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'post-rfq']) }}">
                                    <i class="fa-solid fa-envelope-open-text sidebar-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                        {{ translate('RFQ') }}
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/hire-employee') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'hire-employee']) }}">
                                    <i class="fa-solid fa-shield-halved sidebar-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                        {{ translate('Hire Employee') }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item-button-sidebar {{ Request::is('vendor/subcard/post-job') ? 'active' : '' }}">
                                <a href="javascript:void(0);"
                                    class="nav-link text-capitalize toggle-dropdown sidebar-link"
                                    title="{{ translate('Post Job') }}">
                                    <i class="fa-solid fa-sitemap me-2 sidebar-icon"></i>
                                    <span class="sidebar-text">{{ translate('Post Job') }}</span>
                                    <i class="tio-chevron-down float-end transition-icon"></i>
                                </a>

                                <ul class="nav-sub dropdown-content w-100 transition-dropdown"
                                    style="display: none; padding-left: 15px;">
                                    <li
                                        class="navbar-vertical-aside-has-menu">
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
                            <li class="nav-item-button-sidebar {{ Request::is('vendor/subcard/marketplace') ? 'active' : '' }}" style="border-bottom: 2px solid rgb(195 195 195) !important;">
                                <a href="javascript:void(0);"
                                    class="nav-link text-capitalize toggle-dropdown sidebar-link"
                                    title="{{ translate('Marketplace') }}">
                                    <i class="fa-solid fa-store me-2 sidebar-icon"></i>
                                    <span class="sidebar-text">{{ translate('Marketplace') }}</span>
                                    <i class="tio-chevron-down float-end transition-icon"></i>
                                </a>

                                <ul class="nav-sub dropdown-content w-100 transition-dropdown"
                                    style="display: none; padding-left: 15px;">
                                    <li class="navbar-vertical-aside-has-menu">
                                        <a class="nav-link text-capitalize"
                                            href="{{ route('vendor.subcard', ['slug' => 'marketplace']) }}"
                                            title="{{ translate('Manage Products') }}">
                                            {{ translate('Manage Products') }}
                                        </a>
                                    </li>
                                    <li class="navbar-vertical-aside-has-menu">
                                        <a class="nav-link text-capitalize"
                                            href="{{ route('vendor.subcard', ['slug' => 'marketplace']) }}"
                                            title="{{ translate('Approved Products') }}">
                                            {{ translate('Approved Products') }}
                                        </a>
                                    </li>
                                    <li class="navbar-vertical-aside-has-menu">
                                        <a class="nav-link text-capitalize"
                                            href="{{ route('vendor.subcard', ['slug' => 'marketplace']) }}"
                                            title="{{ translate('Denied Products') }}">
                                            {{ translate('Denied Products') }}
                                        </a>
                                    </li>
                                    <li class="navbar-vertical-aside-has-menu">
                                        <a class="nav-link text-capitalize"
                                            href="{{ route('vendor.subcard', ['slug' => 'marketplace']) }}"
                                            title="{{ translate('New Product Request') }}">
                                            {{ translate('New Product Request') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/membership') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'membership']) }}">
                                    <i class="fa-solid fa-user-plus sidebar-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                        {{ translate('Membership') }}
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/faq') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'faq']) }}">
                                    <i class="fa-solid fa-question sidebar-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                        {{ translate('FAQ') }}
                                    </span>
                                </a>
                            </li>
                            <li style="border-bottom: 2px solid rgb(195 195 195) !important;"
                                class="nav-item-button-sidebar {{ Request::is('vendor/subcard/settings') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                    href="{{ route('vendor.subcard', ['slug' => 'settings']) }}">
                                    <i class="fa-solid fa-sliders sidebar-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                        {{ translate('Settings') }}
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
