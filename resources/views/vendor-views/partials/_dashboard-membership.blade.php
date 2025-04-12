<div class="col-sm-6 col-lg-3">
    <a class="order-stats order-stats_plan" href="javascript:void(0)">
        <div class="order-stats__content">
            <img width="20" src="{{ dynamicAsset(path: 'public/assets/back-end/img/membership-plan.png') }}" alt="">
            <h6 class="order-stats__subtitle">{{ translate('plan_type') }}</h6>
        </div>
        <span class="order-stats__title">{{ $membership['planType'] ?? translate('not_available') }}</span>
    </a>
</div>
<div class="col-sm-6 col-lg-3">
    <a class="order-stats order-stats_renewal" href="javascript:void(0)">
        <div class="order-stats__content">
            <img width="20" src="{{ dynamicAsset(path: 'public/assets/back-end/img/calendar.png') }}" alt="">
            <h6 class="order-stats__subtitle">{{ translate('renewal_date') }}</h6>
        </div>
        <span class="order-stats__title">{{ $membership['renewalDate'] ?? '--' }}</span>
    </a>
</div>
<div class="col-sm-6 col-lg-3">
    <a class="order-stats order-stats_upgrade" href="javascript:void(0)">
        <div class="order-stats__content">
            <img width="20" src="{{ dynamicAsset(path: 'public/assets/back-end/img/upgrade.png') }}" alt="">
            <h6 class="order-stats__subtitle">{{ translate('upgrade_option') }}</h6>
        </div>
        <span class="order-stats__title">{{ translate('available') }}</span>
    </a>
</div>
