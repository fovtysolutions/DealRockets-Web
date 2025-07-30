@php use Illuminate\Support\Str; @endphp
@extends('layouts.back-end.app-partial')

@section('title', translate('customer_List'))

@section('content')
    <div class="content container-fluid">
        {{-- <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex gap-2">
                <img width="20" src="{{dynamicAsset(path: 'public/assets/back-end/img/customer.png')}}" alt="">
                {{translate('customer_list')}}
                <span class="badge badge-soft-dark radius-50 fz-14 ml-1">{{$customers->total()}}</span>
            </h2>
        </div> --}}

        <div class="container-fluid p-0">
            <div class="mb-3">
                <div class="card-body p-0">
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-2 col-sm-4 col-6">
                                <label class="form-label mb-1 small">{{ translate('membership_tier') }}</label>
                                <select name="membership" class="form-control form-control-sm">
                                    <option value="">{{ translate('all_membership_tiers') }}</option>
                                    @foreach($membershipTiers as $tier)
                                        <option value="{{ $tier->membership_name }}" {{ request('membership') == $tier->membership_name ? 'selected' : '' }}>
                                            {{ $tier->membership_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <a href="{{ route('admin.customer.list') }}"
                                    class="btn btn--primary w-100" style="height:35px; padding:5px 10px 5px 10px;">
                                    {{ translate('reset') }}
                                </a>
                            </div>
                            <div>
                                <button type="submit" class="btn btn--primary w-100" style="height:35px; padding:5px 10px 5px 10px;">
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
                                            placeholder="{{translate('search_by_Name_or_Email_or_Phone')}}"
                                            aria-label="Search customers" value="{{ request('searchValue') }}">
                                        <input type="hidden" value="{{ request('membership') }}" name="membership">
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
                                            <a class="dropdown-item"
                                               href="{{route('admin.customer.export',['searchValue'=>request('searchValue')])}}">
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
            <div class="table-responsive datatable-custom">
                <table
                    style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                    class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                    <thead class="thead-light thead-50 text-capitalize">
                    <tr>
                        <th>{{translate('SL')}}</th>
                        <th>{{translate('customer_name')}}</th>
                        <th>{{translate('contact_info')}}</th>
                        <th>{{translate('Joined At')}}</th>
                        {{-- <th>{{translate('total_Order')}} </th> --}}
                        <th class="text-center">{{translate('block')}} / {{translate('unblock')}}</th>
                        <th class="text-center">{{translate('action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($customers as $key=>$customer)
                        <tr>
                            <td>
                                {{$customers->firstItem()+$key}}
                            </td>
                            <td>
                                <a href="{{route('admin.customer.view',[$customer['id']])}}"
                                   class="title-color hover-c1 d-flex align-items-center gap-10">
                                    <img src="{{getStorageImages(path:$customer->image_full_url,type:'backend-profile')}}"
                                         class="avatar rounded-circle " alt="" width="40">
                                    {{Str::limit($customer['f_name']." ".$customer['l_name'],20)}}
                                </a>
                            </td>
                            <td>
                                <div class="mb-1">
                                    <strong><a class="title-color hover-c1"
                                               href="mailto:{{$customer->email}}">{{$customer->email}}</a></strong>

                                </div>
                                <a class="title-color hover-c1" href="tel:{{$customer->phone}}">{{$customer->phone}}</a>

                            </td>
                            <td>
                                {{date('Y-m-d H:i:s',strtotime($customer->created_at))}}
                            </td>
                            {{-- <td>
                                <label class="btn text-info bg-soft-info font-weight-bold px-3 py-1 mb-0 fz-12">
                                    {{$customer->orders_count}}
                                </label>
                            </td> --}}
                            <td>
                                @if($customer['email'] == 'walking@customer.com')
                                    <div class="text-center">
                                        <div class="badge badge-soft-version">{{ translate('default') }}</div>
                                    </div>
                                @else
                                    <form action="{{route('admin.customer.status-update')}}" method="post"
                                          id="customer-status{{$customer['id']}}-form" class="customer-status-form">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$customer['id']}}">
                                        <label class="switcher mx-auto">
                                            <input type="checkbox" class="switcher_input toggle-switch-message"
                                                   id="customer-status{{$customer['id']}}" name="status" value="1"
                                                   {{ $customer['is_active'] == 1 ? 'checked':'' }}
                                                   data-modal-id = "toggle-status-modal"
                                                   data-toggle-id = "customer-status{{$customer['id']}}"
                                                   data-on-image = "customer-block-on.png"
                                                   data-off-image = "customer-block-off.png"
                                                   data-on-title = "{{translate('want_to_unblock').' '.$customer['f_name'].' '.$customer['l_name'].'?'}}"
                                                   data-off-title = "{{translate('want_to_block').' '.$customer['f_name'].' '.$customer['l_name'].'?'}}"
                                                   data-on-message = "<p>{{translate('if_enabled_this_customer_will_be_unblocked_and_can_log_in_to_this_system_again')}}</p>"
                                                   data-off-message = "<p>{{translate('if_disabled_this_customer_will_be_blocked_and_cannot_log_in_to_this_system')}}</p>">
                                            <span class="switcher_control"></span>
                                        </label>
                                    </form>
                                @endif
                            </td>

                            <td class="text-center">
                                <div class="" role="group" style="display: flex;gap: 10px;align-items: center;">
                                    @if(\App\Utils\RolesAccess::checkButtonAccess('user_management',$customer['country'],'read'))
                                        <a href="{{route('admin.customer.view',[$customer['id']])}}"
                                            class="btn btn-outline-info" title="View"><i class="tio-invisible"></i>View</a>
                                    @endif
                                    @if(\App\Utils\RolesAccess::checkButtonAccess('user_management',$customer['country'],'delete'))
                                        @if($customer['id'] != '0')
                                            <form action="{{route('admin.customer.delete',[$customer['id']])}}" method="POST"
                                                onsubmit="return confirm('Are you sure?');" class="d-inline">
                                                @csrf 
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Delete">Delete
                                                    <i class="tio-delete"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="table-responsive mt-4">
                <div class="px-4 d-flex justify-content-lg-end">
                    {!! $customers->links() !!}
                </div>
            </div>
            @if(count($customers)==0)
                @include('layouts.back-end._empty-state',['text'=>'no_customer_found'],['image'=>'default'])
            @endif
        </div>
    </div>
@endsection
