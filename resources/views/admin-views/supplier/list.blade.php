@extends('layouts.back-end.app')

@section('title', translate('supplier_List'))

@section('content')
<div class="content container-fluid">

    <div class="mb-3">
        <h2 class="h1 mb-0 text-capitalize d-flex gap-2">
            <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
            {{ translate('supplier_List') }}
            <span class="badge badge-soft-dark radius-50 fz-14 ml-1">{{ $totalsuppliers }}</span>
        </h2>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ url()->current() }}" method="GET">
                <input type="hidden" value="{{ request('status') }}" name="status">
                <div class="row gx-2">
                    <div class="col-12">
                        <h4 class="mb-3">{{ translate('filter_suppliers') }}</h4>
                    </div>

                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="form-group">
                            <label class="title-color" for="business_type">{{ translate('business_Type') }}</label>
                            <select name="business_type" class="js-select2-custom form-control text-capitalize">
                                <option value="" selected>{{ translate('all_business_type') }}</option>
                                @foreach ($business_type as $business)
                                    <option value="{{ $business }}" {{ request('business_type') == $business ? 'selected' : '' }}>
                                        {{ $business }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="form-group">
                            <label for="main_products" class="title-color">{{ translate('main_products') }}</label>
                            <select name="main_products" class="js-select2-custom form-control text-capitalize">
                                <option value="" selected>{{ translate('all_main_products') }}</option>
                                @foreach ($main_products as $product)
                                    <option value="{{ trim($product) }}" {{ request('main_products') == trim($product) ? 'selected' : '' }}>
                                        {{ trim($product) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="form-group">
                            <label for="management_certification"
                                class="title-color">{{ translate('management_certification') }}</label>
                            <select name="management_certification"
                                class="js-select2-custom form-control text-capitalize">
                                <option value="" selected>{{ translate('all_management_certification') }}</option>
                                @foreach ($management_certification as $certification)
                                    <option value="{{ trim($certification) }}" {{ request('management_certification') == trim($certification) ? 'selected' : '' }}>
                                        {{ trim($certification) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="form-group">
                            <label for="city_province" class="title-color">{{ translate('city_province') }}</label>
                            <select name="city_province" class="js-select2-custom form-control text-capitalize">
                                <option value="" selected>{{ translate('all_city_province') }}</option>
                                @foreach ($city_province as $city)
                                    <option value="{{ trim($city) }}" {{ request('city_province') == trim($city) ? 'selected' : '' }}>
                                        {{ trim($city) }}
                                    </option>
                                @endforeach
                            </select>
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
                                        placeholder="{{ translate('search_by_Supplier_Name') }}"
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
                            <a href="{{ route('admin.add-new-suppliers') }}" class="btn btn--primary">
                                <i class="tio-add"></i>
                                <span class="text">{{ translate('add_new_supplier') }}</span>
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
                                <th>{{ translate('Supplier Name') }}</th>
                                <th class="text-center">{{ translate('business Type') }}</th>
                                <th class="text-center">{{ translate('main_products') }}</th>
                                <th class="text-center">{{ translate('management_certification') }}</th>
                                <th class="text-center">{{ translate('city_province') }}</th>
                                <th class="text-center">{{ translate('action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($suppliers as $key => $supplier)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>
                                        <a href="{{ route('admin.products.view', ['addedBy' => ($supplier['added_by'] == 'seller' ? 'vendor' : 'in-house'), 'id' => $supplier['id']]) }}"
                                            class="media align-items-center gap-2">
                                            @if(isset($supplier->image1))
                                                <img src="/storage/{{ $supplier->image1 }}" class="avatar border" alt="">
                                            @else
                                                <img src="/images/placeholderimage.webp" class="avatar border" alt="">
                                            @endif
                                            <span class="media-body title-color hover-c1">
                                                {{ Str::limit($supplier['name'], 20) }}
                                            </span>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        {{ translate(str_replace('_', ' ', $supplier['business_type'])) }}
                                    </td>
                                    <td class="text-center">
                                        {{ $supplier['main_products'] }}
                                    </td>
                                    <td class="text-center">
                                        {{ $supplier['management_certification'] }}
                                    </td>
                                    <td class="text-center">
                                        {{ $supplier['city_province']}}
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a class="btn btn-outline-info btn-sm square-btn" title="View"
                                                href="{{ route('admin.suppliers.view', ['id' => $supplier['id']]) }}">
                                                <i class="tio-invisible"></i>
                                            </a>
                                            <a class="btn btn-outline--primary btn-sm square-btn"
                                                title="{{ translate('edit') }}"
                                                href="{{ route('admin.suppliers.edit', ['id' => $supplier['id']]) }}">
                                                <i class="tio-edit"></i>
                                            </a>
                                            <span class="btn btn-outline-danger btn-sm square-btn delete-data"
                                                title="{{ translate('delete') }}" data-id="product-{{ $supplier['id']}}">
                                                <i class="tio-delete"></i>
                                            </span>
                                        </div>
                                        <form action="{{ route('admin.suppliers.delete', [$supplier['id']]) }}" method="post"
                                            id="product-{{ $supplier['id']}}">
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
                        {{ $totsupplierspage }}
                    </div>
                </div>

                @if(count($suppliers) == 0)
                    @include('layouts.back-end._empty-state', ['text' => 'no_supplier_found'], ['image' => 'default'])
                @endif
            </div>
        </div>
    </div>
</div>
<span id="message-select-word" data-text="{{ translate('select') }}"></span>
@endsection