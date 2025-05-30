@php
    $vendorCards = [
        ['Inbox', 'vendor-inbox', 'fas fa-inbox'],
        ['Profile', 'profile', 'fas fa-user'],
        ['Dashboard', 'analytics', 'fas fa-chart-line'],
        ['Product Upload', 'product-upload', 'fas fa-upload'],
        ['Stock Sell', 'stock-sell', 'fas fa-box-open'],
        ['Sell Offer', 'sell-offer', 'fas fa-tags'],
        ['Deal Assist', 'deal-assist', 'fas fa-handshake'],
        ['Post a Job', 'post-job', 'fas fa-briefcase'],
        ['Hire an Employee', 'hire-employee', 'fas fa-user-tie'],
        ['Upload Banner / Advertise', 'upload-banner', 'fas fa-bullhorn'],
        ['Explore Trade Shows', 'trade-shows', 'fas fa-globe'],
        ['Go To Buy Leads', 'buy-leads', 'fas fa-shopping-cart'],
        ['Go To Marketplace', 'marketplace', 'fas fa-store'],
        ['Post RFQ', 'post-rfq', 'fas fa-paper-plane'],
        ['Clearing & Forwarding Services', 'clearing-forwarding', 'fas fa-truck-moving'],
        ['Account Settings', 'settings', 'fas fa-cog'],
        ['Membership', 'membership', 'fas fa-id-card'],
        ['FAQ', 'faq', 'fas fa-question-circle'],
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
        '/img/vendor_icons/inbox.png',
        '/img/vendor_icons/profile.png',
        '/img/vendor_icons/dashboard.png',
        '/img/vendor_icons/new-product.png',
        '/img/vendor_icons/stocksell.png',
        '/img/vendor_icons/sell.png',
        '/img/vendor_icons/deal.png',
        '/img/vendor_icons/posting.png',
        '/img/vendor_icons/candidate.png',
        '/img/vendor_icons/ads.png',
        '/img/vendor_icons/tradeshow.png',
        '/img/vendor_icons/buy.png',
        '/img/vendor_icons/marketplace.png',
        '/img/vendor_icons/rfq.png',
        '/img/vendor_icons/customer-service.png',
        '/img/vendor_icons/fund.png',
        '/img/vendor_icons/privilege.png',
        '/img/vendor_icons/faq.png',
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
                href="{{ route('vendor.subcard', ['slug' => $slug]) }}" style="min-height: 130px;">
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
