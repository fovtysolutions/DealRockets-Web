@php
    use App\Enums\ViewPaths\Admin\Brand;
    use App\Enums\ViewPaths\Admin\BusinessSettings;
    use App\Enums\ViewPaths\Admin\Category;
    use App\Enums\ViewPaths\Admin\Chatting;
    use App\Enums\ViewPaths\Admin\Currency;
    use App\Enums\ViewPaths\Admin\Customer;
    use App\Enums\ViewPaths\Admin\CustomerWallet;
    use App\Enums\ViewPaths\Admin\Dashboard;
    use App\Enums\ViewPaths\Admin\DatabaseSetting;
    use App\Enums\ViewPaths\Admin\DealOfTheDay;
    use App\Enums\ViewPaths\Admin\DeliveryMan;
    use App\Enums\ViewPaths\Admin\DeliverymanWithdraw;
    use App\Enums\ViewPaths\Admin\DeliveryRestriction;
    use App\Enums\ViewPaths\Admin\Employee;
    use App\Enums\ViewPaths\Admin\EnvironmentSettings;
    use App\Enums\ViewPaths\Admin\FeatureDeal;
    use App\Enums\ViewPaths\Admin\FeaturesSection;
    use App\Enums\ViewPaths\Admin\FlashDeal;
    use App\Enums\ViewPaths\Admin\GoogleMapAPI;
    use App\Enums\ViewPaths\Admin\HelpTopic;
    use App\Enums\ViewPaths\Admin\InhouseProductSale;
    use App\Enums\ViewPaths\Admin\Mail;
    use App\Enums\ViewPaths\Admin\OfflinePaymentMethod;
    use App\Enums\ViewPaths\Admin\Order;
    use App\Enums\ViewPaths\Admin\Pages;
    use App\Enums\ViewPaths\Admin\Product;
    use App\Enums\ViewPaths\Admin\PushNotification;
    use App\Enums\ViewPaths\Admin\Recaptcha;
    use App\Enums\ViewPaths\Admin\RefundRequest;
    use App\Enums\ViewPaths\Admin\SiteMap;
    use App\Enums\ViewPaths\Admin\SMSModule;
    use App\Enums\ViewPaths\Admin\SocialLoginSettings;
    use App\Enums\ViewPaths\Admin\SocialMedia;
    use App\Enums\ViewPaths\Admin\SoftwareUpdate;
    use App\Enums\ViewPaths\Admin\SubCategory;
    use App\Enums\ViewPaths\Admin\SubSubCategory;
    use App\Enums\ViewPaths\Admin\ThemeSetup;
    use App\Enums\ViewPaths\Admin\FirebaseOTPVerification;
    use App\Enums\ViewPaths\Admin\Vendor;
    use App\Enums\ViewPaths\Admin\InhouseShop;
    use App\Enums\ViewPaths\Admin\SocialMediaChat;
    use App\Enums\ViewPaths\Admin\ShippingMethod;
    use App\Enums\ViewPaths\Admin\PaymentMethod;
    use App\Enums\ViewPaths\Admin\InvoiceSettings;
    use App\Enums\ViewPaths\Admin\SEOSettings;
    use App\Enums\ViewPaths\Admin\ErrorLogs;
    use App\Enums\ViewPaths\Admin\StorageConnectionSettings;
    use App\Enums\ViewPaths\Admin\SystemSetup;
    use App\Enums\ViewPaths\Admin\Supplier;
    use App\Enums\ViewPaths\Admin\Leads;
    use App\Utils\Helpers;
    use App\Enums\EmailTemplateKey;

    $responseuniq_check = 0; // Default value
    $responseuniq = App\Utils\HelperUtil::getLeadNotif();
    
    if (isset($responseuniq['status']) && $responseuniq['status'] === 'success' && isset($responseuniq['notif'])) {
        $responseuniq_check = $responseuniq['notif'];
    }
@endphp
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@if(isset($responseuniq_check) && $responseuniq_check == 1)
    <div id="notif-box" class="alert alert-success" style="position: absolute;z-index: 100;width: 100%;">
        🎉 New Leads are Updated!
        <button id="close-notif" class="close">&times;</button>
    </div>

    <script>
        $(document).ready(function() {
            $("#close-notif").click(function() {
                $.ajax({
                    url: "{{ route('mark-lead-notif') }}",
                    type: "POST",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function() {
                        $("#notif-box").fadeOut();
                    }
                });
            });
        });
    </script>
@endif
<link rel="stylesheet" href="{{ theme_asset('public/assets/custom-css/vendorpanel/sidebar.css') }}">
<div id="sidebarMain" class="d-none">
    <aside
        class="bg-white js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered text-start smallview">
        <div class="navbar-vertical-container">
            <div class="navbar-vertical-footer-offset pb-0">
                <div class="navbar-brand-wrapper justify-content-between side-logo">
                    {{-- <a class="navbar-brand" href="{{ route('admin.dashboard.index') }}" aria-label="Front">
                        <img class="navbar-brand-logo-mini for-web-logo max-h-30"
                            src="{{ $web_config['web_logo']['path'] }}" alt="{{ translate('logo') }}">
                    </a> --}}
                    {{-- <button type="button"
                        class="d-none js-navbar-vertical-aside-toggle-invoker navbar-vertical-aside-toggle btn btn-icon btn-xs btn-ghost-dark">
                        <i class="tio-clear tio-lg"></i>
                    </button>

                    <button type="button" class="js-navbar-vertical-aside-toggle-invoker close">
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
                    <ul class="navbar-nav navbar-nav-lg nav-tabs">
                        <li class="nav-item-button-sidebar {{ Request::is('admin/dashboard*') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.dashboard.index') }}">
                                <i class="fa-solid fa-border-all sidebar-icon"></i>
                                <span
                                    class="text-truncate sidebar-text">
                                    {{ translate('dashboard') }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/analytics') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'analytics']) }}">
                                <i class="fa-solid fa-chart-line me-2 sidebar-icon"></i>
                                <span
                                    class="text-truncate sidebar-text">
                                    {{ translate('Analytics') }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/product-approval') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'product-approval']) }}">
                                <i class="fa-regular fa-thumbs-up me-2 sidebar-icon"></i>
                                <span
                                    class="text-truncate sidebar-text">
                                    {{ translate('Product Approvals') }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/vendor-approval') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'vendor-approval']) }}">
                                <i class="fa-solid fa-person-circle-check me-2 sidebar-icon"></i>
                                <span
                                    class="text-truncate sidebar-text">
                                    {{ translate('Vendor Approvals') }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/leads') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'leads']) }}">
                                <i class="fa-solid fa-pencil me-2 sidebar-icon"></i>
                                <span
                                    class="text-truncate sidebar-text">
                                    {{ translate('Leads') }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/sell-offer') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'sell-offer']) }}">
                                <i class="fa-solid fa-wand-magic me-2 sidebar-icon"></i>
                                <span
                                    class="text-truncate sidebar-text">
                                    {{ translate('Sell Offer') }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/buy-leads') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'buy-leads']) }}">
                                <i class="fa-brands fa-buy-n-large me-2 sidebar-icon"></i>
                                <span
                                    class="text-truncate sidebar-text">
                                    {{ translate('Buy Leads') }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/marketplace') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'marketplace']) }}">
                                <i class="fa-solid fa-store me-2 sidebar-icon"></i>
                                <span
                                    class="text-truncate sidebar-text">
                                    {{ translate('Marketplace') }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/stock-sell') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'stock-sell']) }}">
                                <i class="fa-solid fa-arrow-trend-up me-2 sidebar-icon"></i>
                                <span
                                    class="text-truncate sidebar-text">
                                    {{ translate('Stock Sell') }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/tradeshow') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'tradeshow']) }}">
                                <i class="fa-brands fa-trade-federation me-2 sidebar-icon"></i>
                                <span
                                    class="text-truncate sidebar-text">
                                    {{ translate('Tradeshows') }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/vendor') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'vendor']) }}">
                                <i class="fa-solid fa-tarp me-2 sidebar-icon"></i>
                                <span
                                    class="text-truncate sidebar-text">
                                    {{ translate('Vendor') }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/buyer') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'buyer']) }}">
                                <i class="fa-regular fa-credit-card me-2 sidebar-icon"></i>
                                <span
                                    class="text-truncate sidebar-text">
                                    {{ translate('Buyer') }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/guest') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'guest']) }}">
                                <i class="i fa-regular fa-user me-2 sidebar-icon"></i>
                                <span
                                    class="text-truncate sidebar-text">
                                    {{ translate('Guest') }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/consultant') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'consultant']) }}">
                                <i class="fa-solid fa-user-tie me-2 sidebar-icon"></i>
                                <span
                                    class="text-truncate sidebar-text">
                                    {{ translate('Consultant') }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/industry-jobs') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'industry-jobs']) }}">
                                <i class="fa-solid fa-briefcase me-2 sidebar-icon"></i>
                                <span
                                    class="text-truncate sidebar-text">
                                    {{ translate('Industry Jobs') }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/graphics') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'graphics']) }}">
                                <i class="fa-brands fa-artstation me-2 sidebar-icon"></i>
                                <span
                                    class="text-truncate sidebar-text">
                                    {{ translate('Graphics') }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/deal-assist') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'deal-assist']) }}">
                                <i class="fa-regular fa-handshake me-2 sidebar-icon"></i>
                                <span
                                    class="text-truncate sidebar-text">
                                    {{ translate('Deal Assist') }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/inbox') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'inbox']) }}">
                                <i class="fa-solid fa-inbox me-2 sidebar-icon"></i>
                                <span
                                    class="text-truncate sidebar-text">
                                    {{ translate('Inbox') }}
                                </span>
                            </a>
                        </li>
                        
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/membership') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'membership']) }}">
                                <i class="fa-solid fa-user-plus me-2 sidebar-icon"></i>
                                <span
                                    class="text-truncate sidebar-text">
                                    {{ translate('Membership') }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/home-page') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'home-page']) }}">
                                <i class="fa-solid fa-house-user me-2 sidebar-icon"></i>
                                <span
                                    class="text-truncate sidebar-text">
                                    {{ translate('Home Page') }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/faq') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'faq']) }}">
                                <i class="fa-regular fa-circle-question me-2 sidebar-icon"></i>
                                <span
                                    class="text-truncate sidebar-text">
                                    {{ translate('FAQ Settings') }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/footer') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'footer']) }}">
                                <i class="fa-solid fa-bars-progress me-2 sidebar-icon"></i>
                                <span
                                    class="text-truncate sidebar-text">
                                    {{ translate('Footer') }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/finance-account') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'finance-account']) }}">
                                <i class="fa-solid fa-coins me-2 sidebar-icon"></i>
                                <span
                                    class="text-truncate sidebar-text">
                                    {{ translate('Finance & Account') }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/dashboard-allotment') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'dashboard-allotment']) }}">
                                <i class="fa-solid fa-table-columns me-2 sidebar-icon"></i>
                                <span
                                    class="text-truncate sidebar-text">
                                    {{ translate('Dashboard Allotment') }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/grievence-compliant') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'grievence-compliant']) }}">
                                <i class="fa-regular fa-face-angry me-2 sidebar-icon"></i>
                                <span
                                    class="text-truncate sidebar-text">
                                    {{ translate('Grievence / Compliant') }}
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </aside>
</div>
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
