<div class="col-sm-6 col-lg-3">
    <a class="order-stats order-stats_inquiries" href="javascript:void(0)">
        <div class="order-stats__content">
            <img width="20" src="{{ dynamicAsset(path: 'public/assets/back-end/img/inquiry.png') }}" alt="">
            <h6 class="order-stats__subtitle">{{ translate('buyer_inquiries') }}</h6>
        </div>
        <span class="order-stats__title">{{ $notifications['buyerInquiries'] ?? 0 }}</span>
    </a>
</div>
<div class="col-sm-6 col-lg-3">
    <a class="order-stats order-stats_applications" href="javascript:void(0)">
        <div class="order-stats__content">
            <img width="20" src="{{ dynamicAsset(path: 'public/assets/back-end/img/job-application.png') }}" alt="">
            <h6 class="order-stats__subtitle">{{ translate('job_applications') }}</h6>
        </div>
        <span class="order-stats__title">{{ $notifications['jobApplications'] ?? 0 }}</span>
    </a>
</div>
<div class="col-sm-6 col-lg-3">
    <a class="order-stats order-stats_admin-msg" href="javascript:void(0)">
        <div class="order-stats__content">
            <img width="20" src="{{ dynamicAsset(path: 'public/assets/back-end/img/admin-message.png') }}" alt="">
            <h6 class="order-stats__subtitle">{{ translate('admin_messages') }}</h6>
        </div>
        <span class="order-stats__title">{{ $notifications['adminMessages'] ?? 0 }}</span>
    </a>
</div>
