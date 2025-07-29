@extends('layouts.back-end.app-partial')

@section('title', translate('Vendor Register Forms'))

@section('content')
    <form action="{{ url()->current() }}" method="GET" class="p-3">
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label">{{ translate('Email') }}</label>
                <input type="text" name="email" value="{{ request('email') }}" class="form-control form-control-sm"
                    placeholder="Enter email">
            </div>
            <div class="col-md-3">
                <label class="form-label">{{ translate('Phone') }}</label>
                <input type="text" name="phone" value="{{ request('phone') }}" class="form-control form-control-sm"
                    placeholder="Enter phone">
            </div>
            <div class="col-md-3">
                <label class="form-label">{{ translate('Status') }}</label>
                <select name="status" class="form-control form-control-sm">
                    <option value="">{{ translate('All') }}</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>{{ translate('Active') }}</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>{{ translate('Inactive') }}</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn--primary px-3">{{ translate('Filter') }}</button>
                <a href="{{ url()->current() }}" class="btn btn--primary px-3">{{ translate('Reset') }}</a>
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