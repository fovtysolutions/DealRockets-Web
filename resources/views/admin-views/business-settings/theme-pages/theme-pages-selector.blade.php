<div class="inline-page-menu my-4">
    <ul class="list-unstyled">
        <li class="{{ Request::is('admin/webtheme/index') ? 'active' : ''}}">
            <a href="{{ route('admin.webtheme.index')}}">{{translate('Membership_Settings')}}</a>
        </li>
        <li class="{{ Request::is('admin/webtheme/homepagesetting') ? 'active' : ''}}">
            <a href="{{ route('admin.webtheme.homepagesetting') }}">{{translate('Genre Settings')}}</a>
        </li>
        <li class="{{ Request::is('admin/webtheme/homepagesecsetting') ? 'active' : ''}}">
            <a href="{{ route('admin.webtheme.homepagesecsetting') }}">{{translate('Quotation Settings')}}</a>
        </li>
        <!-- <li class="{{ Request::is('admin/webtheme/vendorsetting') ? 'active' : ''}}">
            <a href="{{ route('admin.webtheme.vendorsetting')}}">{{translate('Vendor_Settings')}}</a>
        </li> -->
        <!-- <li class="{{ Request::is('admin/webtheme/backsettings') ? 'active' : ''}}">
            <a href="{{ route('admin.webtheme.backsettings')}}">{{translate('Background_Settings')}}</a>
        </li> -->
        <!-- <li class="{{ Request::is('admin/webtheme/bannersetting') ? 'active' : ''}}">
            <a href="{{ route('admin.webtheme.bannersetting')}}">{{translate('Tradeshow_Banner_Settings')}}</a>
        </li> -->
        <li class="{{ Request::is('admin/webtheme/trendingproducts') ? 'active' : ''}}">
            <a href="{{ route('admin.webtheme.trendingproducts')}}">{{translate('Register_Setting') }}</a>
        </li>
        <li class="{{ Request::is('admin/webtheme/topsupplier') ? 'active' : ''}}">
            <a href="{{ route('admin.webtheme.topsupplier')}}">{{ translate('Top_Suppliers')}}</a>
        </li>
        <li class="{{ Request::is('admin/webtheme/buyer') ? 'active' : ''}}">
            <a href="{{ route('admin.webtheme.buyer')}}">{{ translate('Buyer')}}</a>
        </li>
        <li class="{{ Request::is('admin/webtheme/seller') ? 'active' : ''}}">
            <a href="{{ route('admin.webtheme.seller')}}">{{ translate('Seller')}}</a>
        </li>
        <li class="{{ Request::is('admin/webtheme/tradeshow') ? 'active' : ''}}">
            <a href="{{ route('admin.webtheme.tradeshow')}}">{{ translate('Tradeshow')}}</a>
        </li>
        <!-- <li class="{{ Request::is('admin/webtheme/stocksale') ? 'active' : '' }}">
            <a href="{{ route('admin.webtheme.stocksale')}}">{{ translate('Stock Sale')}}</a>
        </li>  -->
        <li class="{{ Request::is('admin/webtheme/solutions') ? 'active' : '' }}">
            <a href="{{ route('admin.webtheme.solutions')}}">{{ translate('Solutions')}}</a>
        </li>
        <li class="{{ Request::is('admin/webtheme/adsmanager') ? 'active' : '' }}">
            <a href="{{ route('admin.webtheme.adsmanager')}}">{{ translate('Ads Manager') }}</a>   
        </li>
    </ul>
</div>
