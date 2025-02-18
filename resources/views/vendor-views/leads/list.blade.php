@extends('layouts.back-end.app-seller')

@section('title', translate('leads_List'))

@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<style>
    .rhreherh-switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 20px;
    }

    .rhreherh-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .rhreherh-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 20px;
    }

    .rhreherh-slider:before {
        position: absolute;
        content: "";
        height: 14px;
        width: 14px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
    }

    input:checked + .rhreherh-slider {
        background-color: #4caf50;
    }

    input:checked + .rhreherh-slider:before {
        transform: translateX(20px);
    }                                           
</style>
<div class="content container-fluid">

    <div class="mb-3">
        <h2 class="h1 mb-0 text-capitalize d-flex gap-2">
            <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
            {{ translate('leads_List') }}
            <span class="badge badge-soft-dark radius-50 fz-14 ml-1">{{ count($leads) }}</span>
        </h2>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ url()->current() }}" method="GET">
                <input type="hidden" value="{{ request('status') }}" name="status">
                <div class="row gx-2">
                    <div class="col-12">
                        <h4 class="mb-3">{{ translate('filter_leads') }}</h4>
                    </div>

                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="form-group">
                            <label class="title-color" for="type">{{ translate('type') }}</label>
                            <select name="type" class="js-select2-custom form-control text-capitalize">
                                <option value="" selected>{{ translate('all_types') }}</option>
                                @foreach ($type as $t)
                                    <option value="{{ $t }}" {{ request('type') == $t ? 'selected' : '' }}>
                                        {{ $t }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="form-group">
                            <label for="name" class="title-color">{{ translate('name') }}</label>
                            <select name="name" class="js-select2-custom form-control text-capitalize">
                                <option value="" selected>{{ translate('all_names') }}</option>
                                @foreach ($name as $product)
                                    <option value="{{ trim($product) }}" {{ request('name') == trim($product) ? 'selected' : '' }}>
                                        {{ trim($product) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="form-group">
                            <label for="country" class="title-color">{{ translate('country') }}</label>
                            <select name="country" class="js-select2-custom form-control text-capitalize">
                                <option value="" selected>{{ translate('all_countries') }}</option>
                                @foreach ($country as $c)
                                    <option value="{{ trim($c) }}" {{ request('country') == trim($c) ? 'selected' : '' }}>
                                        {{ trim($c) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="form-group">
                            <label for="company_name" class="title-color">{{ translate('company_name') }}</label>
                            <input type="text" name="company_name" class="form-control" placeholder="{{ translate('enter_company_name') }}" value="{{ request('company_name') }}">
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="form-group">
                            <label for="contact_number" class="title-color">{{ translate('contact_number') }}</label>
                            <input type="text" name="contact_number" class="form-control" placeholder="{{ translate('enter_contact_number') }}" value="{{ request('contact_number') }}">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="d-flex gap-3 justify-content-end">
                            <a class="btn btn-secondary px-5" href="{{ url()->current() }}">
                                {{ translate('reset') }}
                            </a>
                            <button type="submit" class="btn btn--primary px-5 action-get-element-type">
                                {{ translate('show_data') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
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
                                        placeholder="{{ translate('search_by_leads_Name') }}"
                                        aria-label="Search orders" value="{{ request('searchValue') }}">
                                    <input type="hidden" value="{{ request('status') }}" name="status">
                                    <button type="submit" class="btn btn--primary">{{ translate('search') }}</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-8 mt-3 mt-lg-0 d-flex flex-wrap gap-3 justify-content-lg-end">
                            <div class="dropdown">
                                <button type="button" class="btn btn-outline--primary" data-toggle="dropdown">
                                    <i class="tio-download-to"></i>
                                    {{ translate('export') }}
                                    <i class="tio-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a class="dropdown-item">
                                            <img width="14"
                                                src="{{ dynamicAsset(path: 'public/assets/back-end/img/excel.png') }}"
                                                alt="">
                                            {{ translate('excel') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <a href="{{ route('vendor.add-new-leads') }}" class="btn btn--primary">
                                <i class="tio-add"></i>
                                <span class="text">{{ translate('add_new_leads') }}</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="datatable"
                        class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100 text-start">
                        <thead class="thead-light thead-50 text-capitalize">
                            <tr>
                                <th>{{ translate('SL') }}</th>
                                <th>{{ translate('leads Name') }}</th>
                                <th class="text-center">{{ translate('type') }}</th>
                                <th class="text-center">{{ translate('country') }}</th>
                                <th class="text-center">{{ translate('company_name') }}</th>
                                <th class="text-center">{{ translate('contact_number') }}</th>
                                <th class="text-center">{{ translate('posted_date') }}</th>
                                <th class="text-center">{{ translate('active')}}</th>
                                <th class="text-center">{{ translate('action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leads as $key => $lead)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>
                                        <a href="{{ route('vendor.products.view', ['addedBy' => ($lead['added_by'] == 'seller' ? 'vendor' : 'in-house'), 'id' => $lead['id']]) }}"
                                            class="media align-items-center gap-2">
                                            <span class="media-body title-color hover-c1">
                                                {{ Str::limit($lead['name'], 20) }}
                                            </span>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        {{ translate(str_replace('_', ' ', $lead['type'])) }}
                                    </td>
                                    <td class="text-center">
                                        {{ \App\Models\Country::where('id',$lead['country'])->first()->name ?? 'Invalid Country ID' }}
                                    </td>
                                    <td class="text-center">
                                        {{ $lead['company_name'] }}
                                    </td>
                                    <td class="text-center">
                                        {{ $lead['contact_number'] }}
                                    </td>
                                    <td class="text-center">
                                        {{ $lead['posted_date'] }}
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('vendor.leads.toggle', $lead['id']) }}" method="POST" id="toggle-form-{{ $lead['id'] }}">
                                            @csrf
                                            @method('PATCH')
                                            <label class="rhreherh-switch">
                                                <input type="checkbox" 
                                                       {{ $lead['active'] == 1 ? 'checked' : '' }} 
                                                       onchange="document.getElementById('toggle-form-{{ $lead['id'] }}').submit()" 
                                                >
                                                <span class="rhreherh-slider"></span>
                                            </label>
                                        </form>
                                    </td>                                                                                                          
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a class="btn btn-outline-info btn-sm square-btn" title="View"
                                                href="{{ route('vendor.leads.view', ['id' => $lead['id']]) }}">
                                                <i class="tio-invisible"></i>
                                            </a>
                                            <a class="btn btn-outline--primary btn-sm square-btn"
                                                title="{{ translate('edit') }}"
                                                href="{{ route('vendor.leads.edit', ['id' => $lead['id']]) }}">
                                                <i class="tio-edit"></i>
                                            </a>
                                            <span class="btn btn-outline-danger btn-sm square-btn delete-data"
                                                title="{{ translate('delete') }}" data-id="lead-{{ $lead['id']}}">
                                                <i class="tio-delete"></i>
                                            </span>
                                        </div>
                                        <form action="{{ route('admin.leads.delete', [$lead['id']]) }}" method="post"
                                            id="lead-{{ $lead['id']}}">
                                            @csrf @method('delete')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="table-responsive mt-4">
                    <div class="px-4 d-flex justify-content-lg-end">
                        {{ $leads->links() }}
                    </div>
                </div>

                @if(count($leads) == 0)
                    @include('layouts.back-end._empty-state', ['text' => 'no_leads_found', 'image' => 'default'])
                @endif
            </div>
        </div>
    </div>
</div>
<span id="message-select-word" data-text="{{ translate('select') }}"></span>
@endsection
