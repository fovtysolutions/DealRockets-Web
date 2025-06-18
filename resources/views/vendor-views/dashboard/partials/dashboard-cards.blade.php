@php
    $vendorCards = [
        ['Dashboard', 'analytics', 'fas fa-chart-line'],
        ['Inbox', 'vendor-inbox', 'fas fa-inbox'],
        ['Go To Marketplace', 'marketplace', 'fas fa-store'],
        ['Profile', 'profile', 'fas fa-user'],
        ['Upload Banner', 'upload-banner', 'fas fa-bullhorn'],
        ['Membership', 'membership', 'fas fa-id-card'],
        ['FAQ', 'faq', 'fas fa-question-circle'],
        ['Account Settings', 'settings', 'fas fa-cog'],
        ['Stock Sell', 'stock-sell', 'fas fa-box-open'],
        ['Go To Buy Leads', 'buy-leads', 'fas fa-shopping-cart'],
        ['Sell Offer', 'sell-offer', 'fas fa-tags'],
        ['Deal Assist', 'deal-assist', 'fas fa-handshake'],
        ['Explore Trade Shows', 'trade-shows', 'fas fa-globe'],
        ['Post RFQ', 'post-rfq', 'fas fa-paper-plane'],
        ['Hire an Employee', 'hire-employee', 'fas fa-user-tie'],
        ['Post a Job', 'post-job', 'fas fa-briefcase'],
        ['Clearing & Forwarding Services', 'clearing-forwarding', 'fas fa-truck-moving'],
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
        '/img/vendor_icons/dashboard.png',
        '/img/vendor_icons/inbox.png',
        '/img/vendor_icons/marketplace.png',
        '/img/vendor_icons/profile.png',
        '/img/vendor_icons/ads.png',
        '/img/vendor_icons/privilege.png',
        '/img/vendor_icons/faq.png',
        '/img/vendor_icons/fund.png',
        '/img/vendor_icons/stocksell.png',
        '/img/vendor_icons/buy.png',
        '/img/vendor_icons/sell.png',
        '/img/vendor_icons/deal.png',
        '/img/vendor_icons/tradeshow.png',
        '/img/vendor_icons/rfq.png',
        '/img/vendor_icons/candidate.png',
        '/img/vendor_icons/posting.png',
        '/img/vendor_icons/customer-service.png',
    ];
@endphp

<div class="row p-3 custom-box-container">
    @foreach ($vendorCards as $index => [$title, $slug, $icon])
        @php
            $gradientClass = $gradients[array_rand($gradients)];
            // $icon = $iconMap[$index] ?? '/img/default.png';
        @endphp
        <div class="custom-col p-0">
            <a class="card {{ $gradientClass }} business-analytics p-3 d-flex flex-column justify-content-between position-relative h-100"
                href="{{ route('vendor.subcard', ['slug' => $slug]) }}" style="min-height: 130px;">
                {{-- <div style="align-self: self-end;">
                    <img src="{{ asset($icon) }}" alt="{{ $title }}" class="mb-2" style="width: 58px; height: 58px;">
                </div> --}}
                <div style="align-self: self-end;">
                    <i class="{{ $icon }} mb-2" style="font-size: 32px; color: white;"></i>
                </div>
                <div>
                    <p class="mb-0 text-start" style="color: white; font-size: 18px;">{{ translate($title) }}</p>
                </div>
            </a>
        </div>
    @endforeach
</div>
