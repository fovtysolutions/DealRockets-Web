@php
    $vendorCards = [
        ['Analytics', 'analytics', 'fas fa-chart-line'],
        ['Product Approvals', 'product-approval', 'fas fa-inbox'],
        ['Vendor Approvals', 'vendor-approval', 'fas fa-upload'],
        ['Leads', 'leads', 'fas fa-user'],
        ['Sell Offers', 'sell-offers', 'fas fa-bullhorn'],
        ['Buy Leads', 'buy-leads', 'fas fa-id-card'],
        ['Marketplace', 'marketplace', 'fas fa-question-circle'],
        ['Stock Sell', 'stock-sell', 'fas fa-cog'],
        ['Tradeshows', 'tradeshows', 'fas fa-box-open'],
        ['Vendor', 'vendor', 'fas fa-shopping-cart'],
        ['Buyer', 'buyer', 'fas fa-tags'],
        ['Guest', 'guest', 'fas fa-handshake'],
        ['Consultant', 'consultant', 'fas fa-globe'],
        ['Industry Jobs', 'industry-jobs', 'fas fa-paper-plane'],
        ['Graphics', 'graphics', 'fas fa-user-tie'],
        ['Deal Assist', 'deal-assist', 'fas fa-briefcase'],
        ['Inbox', 'inbox', 'fas fa-store'],
        ['Membership', 'membership', 'fas fa-truck-moving'],
        ['Home page', 'home-page', 'fas fa-truck-moving'],
        ['FAQ Settings', 'faq', 'fas fa-truck-moving'],
        ['Footer', 'footer', 'fas fa-truck-moving'],
        ['Finance & Account', 'finance-account', 'fas fa-truck-moving'],
        ['Dashboard Allotment', 'dashboard-allotment', 'fas fa-truck-moving'],
        ['Grievence/Complaint', 'grievence-complaint', 'fas fa-truck-moving'],
    ];
@endphp

@php
    $gradients = [
        'gradient-1',
        'gradient-2',
        'gradient-3',
        'gradient-4',
        'gradient-5',
        'gradient-6',
        'gradient-7',
        'gradient-8',
    ];
@endphp

@php
    $iconMap = [
        '/img/admin_icons/analysis.png',
        '/img/admin_icons/quality.png',
        '/img/admin_icons/check-mark.png',
        '/img/admin_icons/conversion-rate.png',
        '/img/admin_icons/value-proposition.png',
        '/img/admin_icons/b2b.png',
        '/img/admin_icons/marketplace.png',
        '/img/admin_icons/stock.png',
        '/img/admin_icons/time-is-money.png',
        '/img/admin_icons/vendor.png',
        '/img/admin_icons/investor.png',
        '/img/admin_icons/visitor-card.png',
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
            $icon = $iconMap[$index] ?? '/img/default.png';
        @endphp
        <div class="custom-col p-0">
            <a class="card {{ $gradientClass }} business-analytics p-3 d-flex flex-column justify-content-between position-relative h-100"
                href="{{ route('admin.subcard', ['slug' => $slug]) }}" style="min-height: 130px;">
                <div style="align-self: self-end;">
                    <img src="{{ asset($icon) }}" alt="{{ $title }}" class="mb-2" style="width: 58px; height: 58px;">
                </div>
                <div>
                    <p class="mb-0 text-start" style="color: white; font-size: 18px;">{{ translate($title) }}</p>
                </div>
            </a>
        </div>
    @endforeach
</div>