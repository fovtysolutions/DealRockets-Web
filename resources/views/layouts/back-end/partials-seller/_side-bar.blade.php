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
