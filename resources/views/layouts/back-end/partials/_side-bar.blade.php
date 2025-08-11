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
                        <!-- 1. Dashboard -->
                        <li class="nav-item-button-sidebar {{ Request::is('admin/dashboard*') ? 'active' : '' }}" style="border-top: 2px solid rgb(195 195 195) !important;">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.dashboard.index') }}">
                                <i class="fa-solid fa-border-all sidebar-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                    {{ translate('Dashboard') }}
                                </span>
                            </a>
                        </li>

                        <!-- 2. Inbox -->
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/inbox') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'inbox']) }}">
                                <i class="fa-solid fa-inbox sidebar-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                    {{ translate('Inbox') }}
                                </span>
                            </a>
                        </li>

                        <!-- 3. User Account Settings - Dropdown -->
                        <li class="nav-item-button-sidebar">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link toggle-dropdown"
                                href="javascript:void(0)">
                                <i class="fa-solid fa-user-cog sidebar-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                    {{ translate('User Accounts') }}
                                </span>
                                <i class="tio-chevron-down ms-auto"></i>
                            </a>
                            <ul class="dropdown-menu-sidebar" style="display: none;">
                                <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/buyer') ? 'active' : '' }}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                        href="{{ route('admin.subcard', ['slug' => 'buyer']) }}">
                                        <i class="fa-regular fa-credit-card sidebar-icon"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                            {{ translate('Buyer') }}
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/vendor') ? 'active' : '' }}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                        href="{{ route('admin.subcard', ['slug' => 'vendor']) }}">
                                        <i class="fa-solid fa-tarp sidebar-icon"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                            {{ translate('Supplier') }}
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/guest') ? 'active' : '' }}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                        href="{{ route('admin.subcard', ['slug' => 'industry-jobs']) }}">
                                        <i class="fa-regular fa-user sidebar-icon"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                            {{ translate('Job Seeker') }}
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/consultant') ? 'active' : '' }}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                        href="{{ route('admin.subcard', ['slug' => 'consultant']) }}">
                                        <i class="fa-solid fa-user-tie sidebar-icon"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                            {{ translate('Hire') }}
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- 4. Industry Jobs -->
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/industry-jobs') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'industry-jobs']) }}">
                                <i class="fa-solid fa-briefcase sidebar-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                    {{ translate('Industry Jobs') }}
                                </span>
                            </a>
                        </li>

                        <!-- 5. Graphics and Dashboard Allotment - Dropdown -->
                        <li class="nav-item-button-sidebar">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link toggle-dropdown"
                                href="javascript:void(0)">
                                <i class="fa-solid fa-chart-pie sidebar-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                    {{ translate('Graphics and Dashboard Allotment') }}
                                </span>
                                <i class="tio-chevron-down ms-auto"></i>
                            </a>
                            <ul class="dropdown-menu-sidebar" style="display: none;">
                                <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/graphics') ? 'active' : '' }}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                        href="{{ route('admin.subcard', ['slug' => 'graphics']) }}">
                                        <i class="fa-brands fa-artstation sidebar-icon"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                            {{ translate('Graphics') }}
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/dashboard-allotment') ? 'active' : '' }}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                        href="{{ route('admin.subcard', ['slug' => 'dashboard-allotment']) }}">
                                        <i class="fa-solid fa-table-columns sidebar-icon"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                            {{ translate('Dashboard Allotment') }}
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- 6. Supplier Onboarding -->
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/supplier-onboarding') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'supplier-onboarding']) }}">
                                <i class="fa-solid fa-user-check sidebar-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                    {{ translate('Supplier Onboarding') }}
                                </span>
                            </a>
                        </li>

                        <!-- 7. Finance & Accounting -->
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/finance-account') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'finance-account']) }}">
                                <i class="fa-solid fa-coins sidebar-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                    {{ translate('Finance & Accounting') }}
                                </span>
                            </a>
                        </li>

                        <!-- 8. Grievance & Complain -->
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/grievence-compliant') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'grievence-compliant']) }}">
                                <i class="fa-regular fa-face-angry sidebar-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                    {{ translate('Grievance & Complain') }}
                                </span>
                            </a>
                        </li>

                        <!-- 9. Marketing Dashboard Allotment -->
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/marketing-dashboard') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'marketing-dashboard']) }}">
                                <i class="fa-solid fa-chart-line sidebar-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                    {{ translate('Marketing Dashboard Allotment') }}
                                </span>
                            </a>
                        </li>

                        <!-- 10. Membership -->
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/membership') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'membership']) }}">
                                <i class="fa-solid fa-user-plus sidebar-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                    {{ translate('Membership') }}
                                </span>
                            </a>
                        </li>

                        <!-- 11. FAQ Setting -->
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/faq') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'faq']) }}">
                                <i class="fa-solid fa-question sidebar-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                    {{ translate('FAQ Setting') }}
                                </span>
                            </a>
                        </li>

                        <!-- 12. Footer -->
                        <li class="nav-item-button-sidebar {{ Request::is('admin/subcard/footer') ? 'active' : '' }}" style="border-bottom: 2px solid rgb(195 195 195) !important;">
                            <a class="js-navbar-vertical-aside-menu-link nav-link sidebar-link"
                                href="{{ route('admin.subcard', ['slug' => 'footer']) }}">
                                <i class="fa-solid fa-bars-progress sidebar-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate sidebar-text">
                                    {{ translate('Footer') }}
                                </span>
                            </a>
                        </li>

                        <!-- Items not included in your requested structure (commented out): -->
                        <!-- Analytics, Product Approvals, Vendor Approvals, Leads, Sell Offer, Marketplace, Stock Sell, Tradeshows, Deal Assist, Home Page -->
                    </ul>
                </div>
            </div>
        </div>
    </aside>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let isSmallviewHovered = false;
        let rememberedDropdowns = new Set(); // Remember which dropdowns were open
        
        // Handle dropdown toggle functionality
        document.querySelectorAll('.toggle-dropdown').forEach(function(toggle) {
            const dropdown = toggle.nextElementSibling;
            const icon = toggle.querySelector('.tio-chevron-down');
            const parentLi = toggle.closest('li');
            
            // Click handler for dropdown toggle
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (dropdown.classList.contains('show')) {
                    dropdown.classList.remove('show');
                    dropdown.style.display = 'none';
                    icon.classList.remove('rotate-180');
                    parentLi.classList.remove('dropdown-open');
                    rememberedDropdowns.delete(dropdown); // Remove from memory
                } else {
                    dropdown.classList.add('show');
                    dropdown.style.display = 'block';
                    icon.classList.add('rotate-180');
                    parentLi.classList.add('dropdown-open');
                    rememberedDropdowns.add(dropdown); // Add to memory
                }
            });
        });
        
        // Handle smallview sidebar hover state
        const smallviewSidebar = document.querySelector('.smallview');
        if (smallviewSidebar) {
            smallviewSidebar.addEventListener('mouseenter', function() {
                isSmallviewHovered = true;
                // Re-show remembered dropdowns when smallview is hovered
                rememberedDropdowns.forEach(function(dropdown) {
                    if (dropdown.classList.contains('show')) {
                        dropdown.style.display = 'block';
                    }
                });
            });
            
            smallviewSidebar.addEventListener('mouseleave', function() {
                isSmallviewHovered = false;
            });
        }
        
        // Simple condition: if dropdown is block and smallview is not hovered then display none
        setInterval(function() {
            document.querySelectorAll('.dropdown-menu-sidebar').forEach(function(dropdown) {
                if (dropdown.style.display === 'block' && !isSmallviewHovered) {
                    dropdown.style.display = 'none';
                }
            });
        }, 100);
    });
</script>

<style>
    .rotate-180 {
        transform: rotate(180deg);
        transition: transform 0.3s ease;
    }
</style>