<div class="col-sm-6 col-lg-3">
    <a class="order-stats order-stats_listings" href="javascript:void(0)">
        <div class="order-stats__content">
            <img width="20" src="{{ dynamicAsset(path: 'public/assets/back-end/img/listings.png') }}" alt="">
            <h6 class="order-stats__subtitle">{{ translate('active_listings') }}</h6>
        </div>
        <span class="order-stats__title">{{ $vendorStats['activeListings'] ?? 0 }}</span>
    </a>
</div>
<div class="col-sm-6 col-lg-3">
    <a class="order-stats order-stats_buyleads" href="javascript:void(0)">
        <div class="order-stats__content">
            <img width="20" src="{{ dynamicAsset(path: 'public/assets/back-end/img/buy-leads.png') }}" alt="">
            <h6 class="order-stats__subtitle">{{ translate('buy_leads_responded') }}</h6>
        </div>
        <span class="order-stats__title">{{ $vendorStats['buyLeads'] ?? 0 }}</span>
    </a>
</div>
<div class="col-sm-6 col-lg-3">
    <a class="order-stats order-stats_jobs" href="javascript:void(0)">
        <div class="order-stats__content">
            <img width="20" src="{{ dynamicAsset(path: 'public/assets/back-end/img/jobs.png') }}" alt="">
            <h6 class="order-stats__subtitle">{{ translate('job_postings') }}</h6>
        </div>
        <span class="order-stats__title">{{ $vendorStats['jobPosts'] ?? 0 }}</span>
    </a>
</div>
<div class="col-sm-6 col-lg-3">
    <a class="order-stats order-stats_deals" href="javascript:void(0)">
        <div class="order-stats__content">
            <img width="20" src="{{ dynamicAsset(path: 'public/assets/back-end/img/deal-request.png') }}" alt="">
            <h6 class="order-stats__subtitle">{{ translate('deal_assist_requests') }}</h6>
        </div>
        <span class="order-stats__title">{{ $vendorStats['dealRequests'] ?? 0 }}</span>
    </a>
</div>
