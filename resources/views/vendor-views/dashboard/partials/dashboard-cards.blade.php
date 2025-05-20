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

<div class="row">
@foreach ($vendorCards as [$title, $slug, $icon])
    <div class="col-sm-6 col-lg-3 mb-3">
        <a class="card business-analytics p-3 d-flex flex-column justify-content-between position-relative h-100" 
           href="{{ route('vendor.subcard', ['slug' => $slug]) }}" style="min-height: 130px;">
            <i class="{{ $icon }} fa-3x text-primary position-absolute" style="top: 15px; right: 15px;"></i>
            <div class="mt-auto">
                <h2 class="mb-0 text-start">{{ translate($title) }}</h2>
            </div>
        </a>
    </div>
@endforeach
</div>
