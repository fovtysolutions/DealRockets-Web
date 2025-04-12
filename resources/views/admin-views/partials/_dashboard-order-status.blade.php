<div class="col-sm-6 col-lg-3">
    <a class="business-analytics card" href="{{route('admin.orders.list',['all'])}}">
        <h5 class="business-analytics__subtitle">{{translate('total_order')}}</h5>
        <h2 class="business-analytics__title">{{ $data['order'] }}</h2>
        <img src="{{dynamicAsset(path: 'public/assets/back-end/img/all-orders.png')}}" width="30" height="30" class="business-analytics__img" alt="">
    </a>
</div>
<div class="col-sm-6 col-lg-3">
    <a class="business-analytics get-view-by-onclick card" href="{{route('admin.vendors.vendor-list')}}">
        <h5 class="business-analytics__subtitle">{{translate('total_Stores')}}</h5>
        <h2 class="business-analytics__title">{{ $data['store'] }}</h2>
        <img src="{{dynamicAsset(path: 'public/assets/back-end/img/total-stores.png')}}" class="business-analytics__img" alt="">
    </a>
</div>
<div class="col-sm-6 col-lg-3">
    <a class="business-analytics card">
        <h5 class="business-analytics__subtitle">{{translate('total_Products')}}</h5>
        <h2 class="business-analytics__title">{{ $data['product'] }}</h2>
        <img src="{{dynamicAsset(path: 'public/assets/back-end/img/total-product.png')}}" class="business-analytics__img" alt="">
    </a>
</div>
<div class="col-sm-6 col-lg-3">
    <a class="business-analytics card" href="{{route('admin.customer.list')}}">
        <h5 class="business-analytics__subtitle">{{translate('total_Customers')}}</h5>
        <h2 class="business-analytics__title">{{ $data['customer'] }}</h2>
        <img src="{{dynamicAsset(path: 'public/assets/back-end/img/total-customer.png')}}" class="business-analytics__img" alt="">
    </a>
</div>

<div class="col-sm-6 col-lg-3">
    <a class="business-analytics card" href="javascript:void(0)">
        <h5 class="business-analytics__subtitle">{{ translate('job_seekers') }}</h5>
        <h2 class="business-analytics__title">{{ $data['jobSeekerCount'] ?? 0 }}</h2>
        <i class="fa-solid fa-user-tie business-analytics__img fa-2x"></i>
    </a>
</div>

<div class="col-sm-6 col-lg-3">
    <a class="business-analytics card" href="javascript:void(0)">
        <h5 class="business-analytics__subtitle">{{ translate('job_postings') }}</h5>
        <h2 class="business-analytics__title">{{ $data['jobPostingsCount'] ?? 0 }}</h2>
        <i class="fa-solid fa-briefcase business-analytics__img fa-2x" style="color:#6f42c1;"></i>
    </a>
</div>

<div class="col-sm-6 col-lg-3">
    <a class="business-analytics card" href="javascript:void(0)">
        <h5 class="business-analytics__subtitle">{{ translate('job_applications') }}</h5>
        <h2 class="business-analytics__title">{{ $data['jobApplicationsCount'] ?? 0 }}</h2>
        <i class="fa-solid fa-file-lines business-analytics__img fa-2x" style="color:#fd7e14;"></i>
    </a>
</div>

<div class="col-sm-6 col-lg-3">
    <a class="business-analytics card" href="javascript:void(0)">
        <h5 class="business-analytics__subtitle">{{ translate('trade_show_registrations') }}</h5>
        <h2 class="business-analytics__title">{{ $data['tradeShowRegistrations'] ?? 0 }}</h2>
        <i class="fa-solid fa-calendar-check business-analytics__img fa-2x" style="color:#20c997;"></i>
    </a>
</div>

<div class="col-sm-6 col-lg-3">
    <a class="business-analytics card" href="javascript:void(0)">
        <h5 class="business-analytics__subtitle">{{ translate('deal_assist_requests') }}</h5>
        <h2 class="business-analytics__title">{{ $data['dealAssistRequests'] ?? 0 }}</h2>
        <i class="fa-solid fa-handshake business-analytics__img fa-2x" style="color:#17a2b8;"></i>
    </a>
</div>

<div class="col-sm-6 col-lg-3">
    <a class="business-analytics card" href="javascript:void(0)">
        <h5 class="business-analytics__subtitle">{{ translate('admin_alerts') }}</h5>
        <h2 class="business-analytics__title">{{ $data['adminNotificationCount'] ?? 0 }}</h2>
        <i class="fa-solid fa-bell business-analytics__img fa-2x" style="color:#ffc107;"></i>
    </a>
</div>

<div class="col-sm-6 col-lg-3">
    <a class="business-analytics card" href="javascript:void(0)">
        <h5 class="business-analytics__subtitle">{{ translate('total_memberships') }}</h5>
        <h2 class="business-analytics__title">{{ $data['membershipCount'] ?? 0 }}</h2>
        <i class="fa-solid fa-id-card business-analytics__img fa-2x" style="color:#28a745;"></i>
    </a>
</div>

<div class="col-sm-6 col-lg-3">
    <a class="business-analytics card" href="javascript:void(0)">
        <h5 class="business-analytics__subtitle">{{ translate('reported_issues') }}</h5>
        <h2 class="business-analytics__title">{{ $data['reportedIssues'] ?? 0 }}</h2>
        <i class="fa-solid fa-bug business-analytics__img fa-2x" style="color:#dc3545;"></i>
    </a>
</div>

<div class="col-sm-6 col-lg-3">
    <a class="business-analytics card" href="javascript:void(0)">
        <h5 class="business-analytics__subtitle">{{ translate('open_tickets') }}</h5>
        <h2 class="business-analytics__title">{{ $data['openTickets'] ?? 0 }}</h2>
        <i class="fa-solid fa-ticket business-analytics__img fa-2x" style="color:#6610f2;"></i>
    </a>
</div>

<div class="col-sm-6 col-lg-3">
    <a class="business-analytics card" href="javascript:void(0)">
        <h5 class="business-analytics__subtitle">{{ translate('active_subscribers') }}</h5>
        <h2 class="business-analytics__title">{{ $data['activeSubscribers'] ?? 0 }}</h2>
        <i class="fa-solid fa-user-check business-analytics__img fa-2x" style="color:#198754;"></i>
    </a>
</div>

<div class="col-sm-6 col-lg-3">
    <a class="business-analytics card" href="javascript:void(0)">
        <h5 class="business-analytics__subtitle">{{ translate('total_reviews') }}</h5>
        <h2 class="business-analytics__title">{{ $data['totalReviews'] ?? 0 }}</h2>
        <i class="fa-solid fa-star business-analytics__img fa-2x" style="color:#ffc107;"></i>
    </a>
</div>

<div class="col-sm-6 col-lg-3">
    <a class="business-analytics card" href="javascript:void(0)">
        <h5 class="business-analytics__subtitle">{{ translate('support_agents') }}</h5>
        <h2 class="business-analytics__title">{{ $data['supportAgents'] ?? 0 }}</h2>
        <i class="fa-solid fa-headset business-analytics__img fa-2x" style="color:#0d6efd;"></i>
    </a>
</div>

<div class="col-sm-6 col-lg-3">
    <a class="order-stats order-stats_pending" href="{{route('admin.orders.list',['pending'])}}">
        <div class="order-stats__content">
            <img width="20" src="{{dynamicAsset(path: '/public/assets/back-end/img/pending.png')}}" alt="">
            <h6 class="order-stats__subtitle">{{translate('pending')}}</h6>
        </div>
        <span class="order-stats__title">
            {{$data['pending']}}
        </span>
    </a>
</div>

<div class="col-sm-6 col-lg-3">
    <a class="order-stats order-stats_confirmed" href="{{route('admin.orders.list',['confirmed'])}}">
        <div class="order-stats__content">
            <img width="20" src="{{dynamicAsset(path: 'public/assets/back-end/img/confirmed.png')}}" alt="">
            <h6 class="order-stats__subtitle">{{translate('confirmed')}}</h6>
        </div>
        <span class="order-stats__title">
            {{$data['confirmed']}}
        </span>
    </a>
</div>

<div class="col-sm-6 col-lg-3">
    <a class="order-stats order-stats_packaging" href="{{route('admin.orders.list',['processing'])}}">
        <div class="order-stats__content">
            <img width="20" src="{{dynamicAsset(path: 'public/assets/back-end/img/packaging.png')}}" alt="">
            <h6 class="order-stats__subtitle">{{translate('packaging')}}</h6>
        </div>
        <span class="order-stats__title">
            {{$data['processing']}}
        </span>
    </a>
</div>

<div class="col-sm-6 col-lg-3">
    <a class="order-stats order-stats_out-for-delivery" href="{{route('admin.orders.list',['out_for_delivery'])}}">
        <div class="order-stats__content">
            <img width="20" src="{{dynamicAsset(path: 'public/assets/back-end/img/out-of-delivery.png')}}" alt="">
            <h6 class="order-stats__subtitle">{{translate('out_for_delivery')}}</h6>
        </div>
        <span class="order-stats__title">
            {{$data['out_for_delivery']}}
        </span>
    </a>
</div>



<div class="col-sm-6 col-lg-3">
    <div class="order-stats order-stats_delivered cursor-pointer get-view-by-onclick" data-link="{{route('admin.orders.list',['delivered'])}}">
        <div class="order-stats__content">
            <img width="20" src="{{dynamicAsset(path: 'public/assets/back-end/img/delivered.png')}}" alt="">
            <h6 class="order-stats__subtitle">{{translate('delivered')}}</h6>
        </div>
        <span class="order-stats__title">{{$data['delivered']}}</span>
    </div>
</div>

<div class="col-sm-6 col-lg-3">
    <div class="order-stats order-stats_canceled cursor-pointer get-view-by-onclick" data-link="{{route('admin.orders.list',['canceled'])}}">
        <div class="order-stats__content">
            <img width="20" src="{{dynamicAsset(path: 'public/assets/back-end/img/canceled.png')}}" alt="">
            <h6 class="order-stats__subtitle">{{translate('canceled')}}</h6>
        </div>
        <span class="order-stats__title h3">{{$data['canceled']}}</span>
    </div>
</div>

<div class="col-sm-6 col-lg-3">
    <div class="order-stats order-stats_returned cursor-pointer get-view-by-onclick" data-link="{{route('admin.orders.list',['returned'])}}">
        <div class="order-stats__content">
            <img width="20" src="{{dynamicAsset(path: 'public/assets/back-end/img/returned.png')}}" alt="">
            <h6 class="order-stats__subtitle">{{translate('returned')}}</h6>
        </div>
        <span class="order-stats__title h3">{{$data['returned']}}</span>
    </div>
</div>

<div class="col-sm-6 col-lg-3">
    <div class="order-stats order-stats_failed cursor-pointer get-view-by-onclick" data-link="{{route('admin.orders.list',['failed'])}}">
        <div class="order-stats__content">
            <img width="20" src="{{dynamicAsset(path: 'public/assets/back-end/img/failed-to-deliver.png')}}" alt="">
            <h6 class="order-stats__subtitle">{{translate('failed_to_delivery')}}</h6>
        </div>
        <span class="order-stats__title h3">{{$data['failed']}}</span>
    </div>
</div>
