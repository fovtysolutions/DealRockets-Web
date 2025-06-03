@php use App\Utils\Helpers; @endphp
@extends('layouts.back-end.app')
@section('title', translate('dashboard'))
@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    @if(auth('admin')->user()->admin_role_id==1 || Helpers::module_permission_check('dashboard_management'))
        <div class="content container-fluid">
            <div class="page-header pb-0 mb-0 border-0">
                <div class="flex-between align-items-center">
                    <div>
                        <h1 class="page-header-title">{{translate('welcome').' '.auth('admin')->user()->name}}</h1>
                        <p>{{ translate('monitor_your_business_analytics_and_statistics').'.'}}</p>
                    </div>
                </div>
            </div>
            <div class="mb-4 border-0" style="background: unset; box-shadow: unset;">
                <div class="row">
                    @include('admin-views.system.partials.dashboard_icons')
                </div>
            </div>
    @else
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-12 mb-2 mb-sm-0">
                        <h3 class="text-center">{{translate('hi')}} {{auth('admin')->user()->name}}
                            {{' , '.translate('welcome_to_dashboard')}}.</h3>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <span id="earning-statistics-url" data-url="{{ route('admin.dashboard.earning-statistics') }}"></span>
    <span id="order-status-url" data-url="{{ route('admin.dashboard.order-status') }}"></span>
    <span id="seller-text" data-text="{{ translate('vendor')}}"></span>
    <span id="message-commission-text" data-text="{{ translate('commission')}}"></span>
    <span id="in-house-text" data-text="{{ translate('In-house')}}"></span>
    <span id="customer-text" data-text="{{ translate('customer')}}"></span>
    <span id="store-text" data-text="{{ translate('store')}}"></span>
    <span id="product-text" data-text="{{ translate('product')}}"></span>
    <span id="order-text" data-text="{{ translate('order')}}"></span>
    <span id="brand-text" data-text="{{ translate('brand')}}"></span>
    <span id="business-text" data-text="{{ translate('business')}}"></span>
    <span id="orders-text" data-text="{{ $data['order'] }}"></span>
    <span id="user-overview-data"
          data-customer="{{$data['getTotalCustomerCount']}}"
          data-customer-title="{{ translate('customer') }}"
          data-vendor="{{$data['getTotalVendorCount']}}"
          data-vendor-title="{{ translate('vendor') }}"
          data-delivery-man="{{$data['getTotalDeliveryManCount']}}"
          data-delivery-man-title="{{ translate('delivery_man') }}"
    ></span>
@endsection

@push('script')
    <script src="{{dynamicAsset(path: 'public/assets/back-end/js/apexcharts.js')}}"></script>
    <script src="{{dynamicAsset(path: 'public/assets/back-end/js/admin/dashboard.js')}}"></script>
@endpush
