@extends('layouts.back-end.app-partial')

@section('title', translate('Vendor Register Forms'))

@section('content')
    <form action="{{ url()->current() }}" method="GET" class="p-3">
        <input type="hidden" name="searchValue" value="{{ request('searchValue') }}">
        <div class="row g-2 align-items-end">
            <!-- Search Filter (Email/Phone) -->
            <div class="col-md-2 col-sm-6 col-12">
                <label class="form-label mb-1 small">{{ translate('Search_by_email_or_phone') }}</label>
                <input type="text" name="searchValue" value="{{ request('searchValue') }}" class="form-control form-control-sm"
                    placeholder="{{ translate('Enter_email_or_phone') }}">
            </div>
            
            <!-- Created Date Filter -->
            <div class="col-md-2 col-sm-4 col-6">
                <label class="form-label mb-1 small">{{ translate('date_from') }}</label>
                <input type="date" name="created_from" class="form-control form-control-sm"
                       value="{{ request('created_from') }}">
            </div>
            
            <div class="col-md-2 col-sm-4 col-6">
                <label class="form-label mb-1 small">{{ translate('date_to') }}</label>
                <input type="date" name="created_to" class="form-control form-control-sm"
                       value="{{ request('created_to') }}">
            </div>
            
            <!-- Sort Filter -->
            <div class="col-md-2 col-sm-4 col-6">
                <label class="form-label mb-1 small">{{ translate('sort_by') }}</label>
                <select name="sort_by" class="form-control form-control-sm">
                    <option value="">{{ translate('default') }}</option>
                    <option value="email_asc" {{ request('sort_by') == 'email_asc' ? 'selected' : '' }}>{{ translate('email_ascending') }}</option>
                    <option value="email_desc" {{ request('sort_by') == 'email_desc' ? 'selected' : '' }}>{{ translate('email_descending') }}</option>
                    <option value="created_asc" {{ request('sort_by') == 'created_asc' ? 'selected' : '' }}>{{ translate('created_date_ascending') }}</option>
                    <option value="created_desc" {{ request('sort_by') == 'created_desc' ? 'selected' : '' }}>{{ translate('created_date_descending') }}</option>
                </select>
            </div>
            
            <!-- Status Filter -->
            <div class="col-md-1 col-sm-2 col-6">
                <label class="form-label mb-1 small">{{ translate('Status') }}</label>
                <select name="status" class="form-control form-control-sm">
                    <option value="">{{ translate('All') }}</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>{{ translate('Active') }}</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>{{ translate('Inactive') }}</option>
                </select>
            </div>
            
            <div class="col-md-1 col-sm-2 col-6">
                <a href="{{ url()->current() }}"
                    class="btn btn--primary w-100" style="height:35px; padding:5px 10px 5px 10px;">
                    <i class="tio-refresh"></i>
                    {{ translate('Reset') }}
                </a>
            </div>
            <div class="col-md-1 col-sm-2 col-6">
                <button type="submit" class="btn btn--primary w-100" style="height:35px; padding:5px 10px 5px 10px;">
                    <i class="tio-filter-list"></i>
                    {{ translate('Filter') }}
                </button>
            </div>
        </div>
    </form>
    <div class="card m-3">
        <div class="card-body">
            <div class="table-responsive">
                <table style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};"
                    class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                    <thead class="thead-light thead-50 text-capitalize">
                        <tr>
                            <th>{{ translate('SL') }}</th>
                            <th>{{ translate('Email') }}</th>
                            <th>{{ translate('Phone') }}</th>
                            <th>{{ translate('Status') }}</th>
                            <th class="text-center">{{ translate('action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($registerForms as $key => $value)
                                        @php
                                            $vendorSeller = \App\Models\VendorUsers::where('id', $value->seller_users)->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $registerForms->firstItem() + $key }}</td>
                                            <td>
                                                <div class="mb-1">
                                                    <strong><a class="title-color hover-c1"
                                                            href="mailto:{{ $vendorSeller->email }}">{{ $vendorSeller->email }}</a></strong>
                                                </div>
                                            </td>
                                            <td>
                                                <a class="title-color hover-c1"
                                                    href="tel:{{ $vendorSeller->phone }}">{{ $vendorSeller->phone }}</a>
                                            </td>
                                            <td>
                                                {!! $vendorSeller->is_complete == 1
                            ? '<label class="badge badge-success">' . translate('active') . '</label>'
                            : '<label class="badge badge-danger">' . translate('inactive') . '</label>' !!}
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a title="{{ translate('view') }}" class="btn btn-outline-info"
                                                        href="{{ route('admin.vendors.get-vendor-register-details', $value->id) }}">
                                                        <i class="tio-invisible"></i> View
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="table-responsive mt-4">
            <div class="px-4 d-flex justify-content-center justify-content-md-end">
                {!! $registerForms->links() !!}
            </div>
        </div>
    </div>
@endsection