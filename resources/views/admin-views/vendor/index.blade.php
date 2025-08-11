@php use Illuminate\Support\Str; @endphp
@extends('layouts.back-end.app-partial')

@section('title', translate('vendor_List'))

@section('content')
    <div class="content container-fluid">
        <!-- <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex gap-2">
                <img src="{{dynamicAsset(path: 'public/assets/back-end/img/add-new-seller.png')}}" alt="">
                {{translate('vendor_List')}}
                <span class="badge badge-soft-dark radius-50 fz-14 ml-1">{{ $vendors->total() }}</span>
            </h2>
        </div> -->

        <div class="container-fluid p-0">
            <div class="mb-3">
                <div class="card-body p-0">
                    <form action="{{ url()->current() }}" method="GET">
                        <input type="hidden" name="searchValue" value="{{ request('searchValue') }}">
                        
                        <div class="row g-2 align-items-end">
                            <!-- Created Date Filter -->
                            <div class="col-md-2 col-sm-4 col-6">
                                <label class="form-label mb-1 small">{{ translate('created_date_from') }}</label>
                                <input type="date" name="created_from" class="form-control form-control-sm" 
                                       value="{{ request('created_from') }}">
                            </div>
                            
                            <div class="col-md-2 col-sm-4 col-6">
                                <label class="form-label mb-1 small">{{ translate('created_date_to') }}</label>
                                <input type="date" name="created_to" class="form-control form-control-sm" 
                                       value="{{ request('created_to') }}">
                            </div>

                            <!-- Sort Filter -->
                            <div class="col-md-2 col-sm-4 col-6">
                                <label class="form-label mb-1 small">{{ translate('sort_by') }}</label>
                                <select name="sort_by" class="form-control form-control-sm">
                                    <option value="">{{ translate('default') }}</option>
                                    <option value="name_asc" {{ request('sort_by') == 'name_asc' ? 'selected' : '' }}>{{ translate('name_ascending') }}</option>
                                    <option value="name_desc" {{ request('sort_by') == 'name_desc' ? 'selected' : '' }}>{{ translate('name_descending') }}</option>
                                    <option value="created_asc" {{ request('sort_by') == 'created_asc' ? 'selected' : '' }}>{{ translate('created_date_ascending') }}</option>
                                    <option value="created_desc" {{ request('sort_by') == 'created_desc' ? 'selected' : '' }}>{{ translate('created_date_descending') }}</option>
                                </select>
                            </div>

                            <!-- Status Filter -->
                            <div class="col-md-2 col-sm-4 col-6">
                                <label class="form-label mb-1 small">{{ translate('status') }}</label>
                                <select name="status" class="form-control form-control-sm">
                                    <option value="">{{ translate('all_status') }}</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>{{ translate('approved') }}</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ translate('pending') }}</option>
                                    <option value="denied" {{ request('status') == 'denied' ? 'selected' : '' }}>{{ translate('denied') }}</option>
                                </select>
                            </div>

                            <div>
                                <a href="{{ route('admin.vendors.vendor-list') }}"
                                    class="btn btn--primary w-100" style="height:35px; padding:5px 10px 5px 10px;">
                                    <i class="tio-refresh"></i>
                                    {{ translate('reset') }}
                                </a>
                            </div>
                            <div>
                                <button type="submit" class="btn btn--primary w-100" style="height:35px; padding:5px 10px 5px 10px;">
                                    <i class="tio-filter-list"></i>
                                    {{ translate('show_data') }}
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
                                            placeholder="{{translate('search_by_shop_name_or_vendor_name_or_phone_or_email')}}"
                                            aria-label="Search vendors" value="{{ request('searchValue') }}">
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
                                            <a class="dropdown-item" href="{{route('admin.vendors.export', array_merge(request()->all()))}}">
                                                <img width="14" src="{{dynamicAsset(path: 'public/assets/back-end/img/excel.png')}}" alt="">
                                                {{translate('excel')}}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{route('admin.vendors.export', array_merge(request()->all(), ['format' => 'pdf']))}}">
                                                <i class="tio-document-text text-danger"></i>
                                                {{translate('pdf')}}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{route('admin.vendors.export', array_merge(request()->all(), ['format' => 'csv']))}}">
                                                <i class="tio-table text-success"></i>
                                                {{translate('csv')}}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <a href="{{route('admin.vendors.add')}}" class="btn btn--primary">
                                    <i class="tio-add"></i>
                                    <span class="text">{{translate('add_New_Vendor')}}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="box-view p-3">
                    <div class="table-responsive">
                        <table
                            style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                            class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                            <thead class="thead-light thead-50 text-capitalize">
                            <tr>
                                <th>{{translate('SL')}}</th>
                                <th>{{translate('shop_name')}}</th>
                                <th>{{translate('vendor_name')}}</th>
                                <th>{{translate('contact_info')}}</th>
                                <th>{{translate('Date')}}</th>
                                <th>{{translate('status')}}</th>
                                <th class="text-center">{{translate('total_products')}}</th>
                                {{-- <th class="text-center">{{translate('total_orders')}}</th> --}}
                                <th class="text-center">{{translate('action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($vendors as $key=>$seller)
                                <tr>
                                    <td>{{$vendors->firstItem()+$key}}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-10 w-max-content">
                                            <img width="50"
                                            class="avatar rounded-circle object-fit-cover" src="{{ getStorageImages(path: $seller?->shop?->image_full_url, type: 'backend-basic') }}"
                                                alt="">
                                            <div>
                                                <a class="title-color" href="{{ route('admin.vendors.view', ['id' => $seller->id]) }}">{{ $seller->shop ? Str::limit($seller->shop->name, 20) : translate('shop_not_found')}}</a>
                                                <br>
                                                <span class="text-danger">
                                                    @if($seller->shop && $seller->shop->temporary_close)
                                                        {{ translate('temporary_closed') }}
                                                    @elseif($seller->shop && $seller->shop->vacation_status && $current_date >= date('Y-m-d', strtotime($seller->shop->vacation_start_date)) && $current_date <= date('Y-m-d', strtotime($seller->shop->vacation_end_date)))
                                                        {{ translate('on_vacation') }}
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a title="{{translate('view')}}"
                                           class="title-color"
                                           href="{{route('admin.vendors.view',$seller->id)}}">
                                            {{$seller->f_name}} {{$seller->l_name}}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="mb-1">
                                            <strong><a class="title-color hover-c1" href="mailto:{{$seller->email}}">{{$seller->email}}</a></strong>
                                        </div>
                                        <a class="title-color hover-c1" href="tel:{{$seller->phone}}">{{$seller->phone}}</a>
                                    </td>
                                    <td>    
                                        {{ date('d M Y',strtotime($seller->created_at)) }}
                                    </td>
                                    <td>
                                        {!! $seller->status=='approved'?'<label class="badge badge-success">'.translate('active').'</label>':'<label class="badge badge-danger">'.translate('inactive').'</label>' !!}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{route('admin.vendors.product-list',[$seller['id']])}}"
                                           class="btn text--primary bg-soft--primary font-weight-bold px-3 py-1 mb-0 fz-12">
                                            {{$seller->product->count()}}
                                        </a>
                                    </td>
                                    {{-- <td class="text-center">
                                        <a href="{{route('admin.vendors.order-list',[$seller['id']])}}"
                                            class="btn text-info bg-soft-info font-weight-bold px-3 py-1 fz-12 mb-0">
                                            {{$seller->orders->where('seller_is','seller')->where('order_type','default_type')->count()}}
                                        </a>
                                    </td> --}}
                                    <td class="text-center">
                                        <div class="" role="group" style="display: flex;gap: 10px;align-items: center;">
                                            <a href="{{route('admin.vendors.view',$seller->id)}}"
                                                class="btn btn-outline-info" title="View"><i class="tio-invisible"></i>View</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive mt-4">
                        <div class="px-4 d-flex justify-content-center justify-content-md-end">
                            {!! $vendors->links() !!}
                        </div>
                    </div>
                    @if(count($vendors)==0)
                        @include('layouts.back-end._empty-state',['text'=>'no_vendor_found'],['image'=>'default'])
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
