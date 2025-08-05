@extends('layouts.back-end.app')
@section('title', translate('order_List'))

@section('content')
    <div class="content container-fluid">
        <!-- <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex gap-2">
                <img src="{{dynamicAsset(path: 'public/assets/back-end/img/all-orders.png')}}" alt="">
                <span class="page-header-title">
                    @if($status =='processing')
                        {{translate('packaging')}}
                    @elseif($status =='failed')
                        {{translate('failed_to_Deliver')}}
                    @elseif($status == 'all')
                        {{translate('all')}}
                    @else
                        {{translate(str_replace('_',' ',$status))}}
                    @endif
                </span>
                {{translate('orders')}}
                <span class="badge badge-soft-dark radius-50 fz-14 ml-1">{{$orders->total()}}</span>
            </h2>
        </div> -->

        <div class="container-fluid p-0">
            <div class="mb-3">
                <div class="card-body p-0">
                    <form action="{{route('admin.orders.list',['status'=>request('status')])}}" id="form-data" method="GET">
                        @if(request('delivery_man_id'))
                            <input type="hidden" name="delivery_man_id" value="{{ request('delivery_man_id') }}">
                        @endif
                        <div class="row g-2 align-items-end">
                            <div class="col-md-2 col-sm-4 col-6">
                                <label class="form-label mb-1 small">{{translate('order_type')}}</label>
                                <select name="filter" id="filter" class="form-control form-control-sm">
                                    <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>{{translate('all')}}</option>
                                    <option value="admin" {{ $filter == 'admin' ? 'selected' : '' }}>{{translate('in_House_Order')}}</option>
                                    <option value="seller" {{ $filter == 'seller' ? 'selected' : '' }}>{{translate('vendor_Order')}}</option>
                                    @if(($status == 'all' || $status == 'delivered') && !request()->has('delivery_man_id'))
                                    <option value="POS" {{ $filter == 'POS' ? 'selected' : '' }}>{{translate('POS_Order')}}</option>
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-2 col-sm-4 col-6" id="seller_id_area" style="{{ $filter && $filter == 'admin'?'display:none':'' }}">
                                <label class="form-label mb-1 small">{{translate('store')}}</label>
                                <select name="seller_id" id="seller_id" class="form-control form-control-sm">
                                    <option value="all">{{translate('all_shop')}}</option>
                                    <option value="0" id="seller_id_inhouse" {{request('seller_id') == 0 ? 'selected' :''}}>{{translate('inhouse')}}</option>
                                    @foreach ($sellers as $seller)
                                        @isset($seller->shop)
                                            <option value="{{$seller->id}}"{{request('seller_id') == $seller->id ? 'selected' :''}}>
                                                {{ $seller->shop->name }}
                                            </option>
                                        @endisset
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2 col-sm-4 col-6">
                                <label class="form-label mb-1 small">{{translate('date_type')}}</label>
                                <select class="form-control form-control-sm" name="date_type" id="date_type">
                                    <option value="">{{translate('select_Date_Type')}}</option>
                                    <option value="this_year" {{ $dateType == 'this_year'? 'selected' : '' }}>{{translate('this_Year')}}</option>
                                    <option value="this_month" {{ $dateType == 'this_month'? 'selected' : '' }}>{{translate('this_Month')}}</option>
                                    <option value="this_week" {{ $dateType == 'this_week'? 'selected' : '' }}>{{translate('this_Week')}}</option>
                                    <option value="custom_date" {{ $dateType == 'custom_date'? 'selected' : '' }}>{{translate('custom_Date')}}</option>
                                </select>
                            </div>

                            <div class="col-md-2 col-sm-4 col-6" id="from_div">
                                <label class="form-label mb-1 small">{{translate('start_date')}}</label>
                                <input type="date" name="from" value="{{$from}}" id="from_date" class="form-control form-control-sm">
                            </div>

                            <div class="col-md-2 col-sm-4 col-6" id="to_div">
                                <label class="form-label mb-1 small">{{translate('end_date')}}</label>
                                <input type="date" value="{{$to}}" name="to" id="to_date" class="form-control form-control-sm">
                            </div>

                            <div>
                                <a href="{{route('admin.orders.list',['status'=>request('status')])}}"
                                    class="btn btn--primary w-100" style="height:35px; padding:5px 10px 5px 10px;">
                                    {{translate('reset')}}
                                </a>
                            </div>
                            <div>
                                <button type="submit" class="btn btn--primary w-100" style="height:35px; padding:5px 10px 5px 10px;" id="formUrlChange" data-action="{{ url()->current() }}">
                                    {{translate('show_data')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row mt-20">
            <div class="col-md-12">
                <div class="card">
                    <div class="px-3 py-4">
                        <div class="row align-items-center">
                            <div class="col-lg-4">
                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="input-group input-group-custom input-group-merge">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="searchValue" class="form-control"
                                            placeholder="{{translate('search_by_Order_ID')}}" aria-label="Search orders" value="{{ $searchValue }}">
                                        <input type="hidden" value="{{ request('status') }}" name="status">
                                        <input type="hidden" value="{{ $filter }}" name="filter">
                                        <input type="hidden" value="{{ request('seller_id') }}" name="seller_id">
                                        <input type="hidden" value="{{ request('customer_id') }}" name="customer_id">
                                        <input type="hidden" value="{{ $dateType }}" name="date_type">
                                        <input type="hidden" value="{{ $from }}" name="from">
                                        <input type="hidden" value="{{ $to }}" name="to">
                                        <button type="submit" class="btn btn--primary">{{translate('search')}}</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-8 mt-3 mt-lg-0 d-flex flex-wrap gap-3 justify-content-lg-end">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-outline--primary" data-toggle="dropdown">
                                        <i class="tio-download-to"></i>
                                        {{translate('export')}}
                                        <i class="tio-chevron-down"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.orders.export-excel', ['delivery_man_id' => request('delivery_man_id'), 'status' => $status, 'from' => $from, 'to' => $to, 'filter' => $filter, 'searchValue' => $searchValue,'seller_id'=>$vendorId,'customer_id'=>$customerId, 'date_type'=>$dateType]) }}">
                                                <img width="14" src="{{dynamicAsset(path: 'public/assets/back-end/img/excel.png')}}" alt="">
                                                {{translate('excel')}}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-view p-3">
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100 text-start">
                                <thead class="thead-light thead-50 text-capitalize">
                                <tr>
                                    <th>{{translate('SL')}}</th>
                                    <th>{{translate('order_ID')}}</th>
                                    <th class="text-capitalize">{{translate('order_date')}}</th>
                                    <th class="text-capitalize">{{translate('customer_info')}}</th>
                                    <th>{{translate('store')}}</th>
                                    <th class="text-capitalize">{{translate('total_amount')}}</th>
                                    @if($status == 'all')
                                        <th class="text-center">{{translate('order_status')}} </th>
                                    @else
                                        <th class="text-capitalize">{{translate('payment_method')}} </th>
                                    @endif
                                    <th class="text-center">{{translate('action')}}</th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach($orders as $key=>$order)

                                <tr class="status-{{$order['order_status']}} class-all">
                                    <td class="">
                                        {{$orders->firstItem()+$key}}
                                    </td>
                                    <td >
                                        <a class="title-color" href="{{route('admin.orders.details',['id'=>$order['id']])}}">{{$order['id']}} {!! $order->order_type == 'POS' ? '<span class="text--primary">(POS)</span>' : '' !!}</a>
                                    </td>
                                    <td>
                                        <div>{{date('d M Y',strtotime($order['created_at']))}},</div>
                                        <div>{{ date("h:i A",strtotime($order['created_at'])) }}</div>
                                    </td>
                                    <td>
                                        @if($order->is_guest)
                                            <strong class="title-name">{{translate('guest_customer')}}</strong>
                                        @elseif($order->customer_id == 0)
                                            <strong class="title-name">{{translate('walking_customer')}}</strong>
                                        @else
                                            @if($order->customer)
                                                <a class="text-body text-capitalize" href="{{route('admin.orders.details',['id'=>$order['id']])}}">
                                                    <strong class="title-name">{{$order->customer['f_name'].' '.$order->customer['l_name']}}</strong>
                                                </a>
                                                @if($order->customer['phone'])
                                                    <a class="d-block title-color" href="tel:{{ $order->customer['phone'] }}">{{ $order->customer['phone'] }}</a>
                                                @else
                                                    <a class="d-block title-color" href="mailto:{{ $order->customer['email'] }}">{{ $order->customer['email'] }}</a>
                                                @endif
                                            @else
                                                <label class="badge badge-danger fz-12">
                                                    {{ translate('customer_not_found') }}
                                                </label>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($order->seller_id) && isset($order->seller_is))
                                            <a href="{{$order->seller_is == 'seller' && $order->seller?->shop ? route('admin.vendors.view', ['id'=>$order->seller->shop->id]) : 'javascript:' }}" class="store-name font-weight-medium">
                                                @if($order->seller_is == 'seller')
                                                    {{ isset($order->seller?->shop) ? $order->seller?->shop?->name : translate('Store_not_found') }}
                                                @elseif($order->seller_is == 'admin')
                                                    {{translate('in_House')}}
                                                @endif
                                            </a>
                                        @else
                                            {{ translate('Store_not_found') }}
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            @php($orderTotalPriceSummary = \App\Utils\OrderManager::getOrderTotalPriceSummary(order: $order))
                                            {{ setCurrencySymbol(amount: usdToDefaultCurrency(amount:  $orderTotalPriceSummary['totalAmount']), currencyCode: getCurrencyCode()) }}
                                        </div>

                                        @if($order->payment_status == 'paid')
                                            <span class="badge badge-soft-success">{{translate('paid')}}</span>
                                        @else
                                            <span class="badge badge-soft-danger">{{translate('unpaid')}}</span>
                                        @endif
                                    </td>
                                    @if($status == 'all')
                                        <td class="text-center text-capitalize">
                                            @if($order['order_status']=='pending')
                                                <span class="badge badge-soft-info fz-12">
                                                    {{translate($order['order_status'])}}
                                                </span>
                                            @elseif($order['order_status']=='processing' || $order['order_status']=='out_for_delivery')
                                                <span class="badge badge-soft-warning fz-12">
                                                    {{str_replace('_',' ',$order['order_status'] == 'processing' ? translate('packaging'):translate($order['order_status']))}}
                                                </span>
                                            @elseif($order['order_status']=='confirmed')
                                                <span class="badge badge-soft-success fz-12">
                                                    {{translate($order['order_status'])}}
                                                </span>
                                            @elseif($order['order_status']=='failed')
                                                <span class="badge badge-danger fz-12">
                                                    {{translate('failed_to_deliver')}}
                                                </span>
                                            @elseif($order['order_status']=='delivered')
                                                <span class="badge badge-soft-success fz-12">
                                                    {{translate($order['order_status'])}}
                                                </span>
                                            @else
                                                <span class="badge badge-soft-danger fz-12">
                                                    {{translate($order['order_status'])}}
                                                </span>
                                            @endif
                                        </td>
                                    @else
                                        <td class="text-capitalize">
                                            {{str_replace('_',' ',$order['payment_method'])}}
                                        </td>
                                    @endif
                                    <td class="text-center">
                                        <div class="" role="group" style="display: flex;gap: 10px;align-items: center;">
                                            <a href="{{route('admin.orders.details',['id'=>$order['id']])}}"
                                                class="btn btn-outline-info" title="View"><i class="tio-invisible"></i>View</a>
                                            <a href="{{route('admin.orders.generate-invoice',[$order['id']])}}" target="_blank"
                                                class="btn btn-outline-success" title="Invoice"><i class="tio-download-to"></i>Invoice</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive mt-4">
                        <div class="d-flex justify-content-lg-end">
                            {!! $orders->links() !!}
                        </div>
                    </div>
                    @if(count($orders) == 0)
                        @include('layouts.back-end._empty-state',['text'=>'no_order_found'],['image'=>'default'])
                    @endif
                </div>
            </div>
            <div class="js-nav-scroller hs-nav-scroller-horizontal d-none">
                <span class="hs-nav-scroller-arrow-prev d-none">
                    <a class="hs-nav-scroller-arrow-link" href="javascript:">
                        <i class="tio-chevron-left"></i>
                    </a>
                </span>

                <span class="hs-nav-scroller-arrow-next d-none">
                    <a class="hs-nav-scroller-arrow-link" href="javascript:">
                        <i class="tio-chevron-right"></i>
                    </a>
                </span>
                <ul class="nav nav-tabs page-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">{{translate('order_list')}}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <span id="message-date-range-text" data-text="{{ translate("invalid_date_range") }}"></span>
    <span id="js-data-example-ajax-url" data-url="{{ route('admin.orders.customers') }}"></span>
@endsection

@push('script_2')
    <script src="{{dynamicAsset(path: 'public/assets/back-end/js/admin/order.js')}}"></script>
@endpush
