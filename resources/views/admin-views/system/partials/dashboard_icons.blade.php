@php
$vendorCards = [
    ['Analytics', 'analytics', 'fas fa-chart-line'],
    ['Product Approvals', 'product-approval', 'fas fa-check-square'],
    ['Vendor Approvals', 'vendor-approval', 'fas fa-user-check'],
    ['Leads', 'leads', 'fas fa-user-plus'],
    ['Sell Offers', 'sell-offer', 'fas fa-bullhorn'],
    // ['Buy Leads', 'buy-leads', 'fas fa-clipboard-list'],
    ['Marketplace', 'marketplace', 'fas fa-store'],
    ['Stock Sell', 'stock-sell', 'fas fa-warehouse'],
    ['Tradeshows', 'tradeshows', 'fas fa-calendar-alt'],
    ['Vendor', 'vendor', 'fas fa-users'],
    ['Buyer', 'buyer', 'fas fa-hand-holding-usd'],
    // ['Guest', 'guest', 'fas fa-user-secret'],
    ['Consultant', 'consultant', 'fas fa-user-tie'],
    ['Industry Jobs', 'industry-jobs', 'fas fa-briefcase'],
    ['Graphics', 'graphics', 'fas fa-palette'],
    ['Deal Assist', 'deal-assist', 'fas fa-handshake'],
    ['Inbox', 'inbox', 'fas fa-envelope'],
    ['Membership', 'membership', 'fas fa-id-badge'],
    ['Home page', 'home-page', 'fas fa-home'],
    ['FAQ Settings', 'faq', 'fas fa-question-circle'],
    ['Footer', 'footer', 'fas fa-shoe-prints'],
    ['Finance & Account', 'finance-account', 'fas fa-coins'],
    ['Dashboard Allotment', 'dashboard-allotment', 'fas fa-th-large'],
    ['Grievence/Complaint', 'grievence-complaint', 'fas fa-exclamation-circle'],
];
@endphp

@php
    $gradients = [
        'gradient-1',
        // 'gradient-2',
        // 'gradient-3',
        // 'gradient-4',
        // 'gradient-5',
        // 'gradient-6',
        // 'gradient-7',
        // 'gradient-8',
    ];
@endphp

@php
    $iconMap = [
        '/img/admin_icons/analysis.png',
        '/img/admin_icons/quality.png',
        '/img/admin_icons/check-mark.png',
        '/img/admin_icons/conversion-rate.png',
        '/img/admin_icons/value-proposition.png',
        // '/img/admin_icons/b2b.png',
        '/img/admin_icons/marketplace.png',
        '/img/admin_icons/stock.png',
        '/img/admin_icons/time-is-money.png',
        '/img/admin_icons/vendor.png',
        '/img/admin_icons/investor.png',
        // '/img/admin_icons/visitor-card.png',
        '/img/admin_icons/conversation.png',
        '/img/admin_icons/engineer.png',
        '/img/admin_icons/illustration.png',
        '/img/admin_icons/deal.png',
        '/img/admin_icons/inbox.png',
        '/img/admin_icons/vip-card.png',
        '/img/admin_icons/home.png',
        '/img/admin_icons/faq.png',
        '/img/admin_icons/footer.png',
        '/img/admin_icons/accounting.png',
        '/img/admin_icons/employee.png',
        '/img/admin_icons/assessment.png',
    ];
@endphp

<div class="row p-3 custom-box-container">
    @foreach ($vendorCards as $index => [$title, $slug, $icon])
        @php
            $gradientClass = $gradients[array_rand($gradients)];
        @endphp
        <div class="custom-col p-0">
            <a class="card {{ $gradientClass }} business-analytics p-3 d-flex flex-column justify-content-between position-relative h-100"
                href="{{ route('admin.subcard', ['slug' => $slug]) }}" style="min-height: 130px;">
                <div style="align-self: self-end;">
                    {{-- Show Font Awesome icon --}}
                    <i class="{{ $icon }} mb-2" style="font-size: 46px; color: white;"></i>
                </div>
                <div>
                    <p class="mb-0 text-start" style="color: white; font-size: 18px;">{{ translate($title) }}</p>
                </div>
            </a>
        </div>
    @endforeach
</div>