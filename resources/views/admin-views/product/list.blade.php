@extends('layouts.back-end.app-partial')

@section('title', translate('product_List'))

@section('content')
    <div class="content container-fluid">

        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex gap-2">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
                @if ($type == 'in_house')
                    {{ translate('in_House_Product_List') }}
                @elseif($type == 'seller')
                    {{ translate('vendor_Product_List') }}
                @endif
                <span class="badge badge-soft-dark radius-50 fz-14 ml-1">{{ $products->total() }}</span>
            </h2>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ url()->current() }}" method="GET">
                    <input type="hidden" value="{{ request('status') }}" name="status">
                    <div class="row gx-2">
                        <div class="col-12">
                            <h4 class="mb-3">{{ translate('filter_Products') }}</h4>
                        </div>
                        @if (request('type') == 'seller')
                            <div class="col-sm-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label class="title-color" for="store">{{ translate('store') }}</label>
                                    <select name="seller_id" class="form-control text-capitalize">
                                        <option value="" selected>{{ translate('all_store') }}</option>
                                        @foreach ($sellers as $seller)
                                            <option
                                                value="{{ $seller->id }}"{{ request('seller_id') == $seller->id ? 'selected' : '' }}>
                                                {{ $seller->shop->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label class="title-color" for="store">{{ translate('brand') }}</label>
                                <select name="brand_id" class="js-select2-custom form-control text-capitalize">
                                    <option value="" selected>{{ translate('all_brand') }}</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->default_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label for="name" class="title-color">{{ translate('category') }}</label>
                                <select class="js-select2-custom form-control action-get-request-onchange"
                                    name="category_id"
                                    data-url-prefix="{{ url('/admin/products/get-categories?parent_id=') }}"
                                    data-element-id="sub-category-select" data-element-type="select">
                                    <option value="{{ old('category_id') }}" selected disabled>
                                        {{ translate('select_category') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category['id'] }}"
                                            {{ request('category_id') == $category['id'] ? 'selected' : '' }}>
                                            {{ $category['defaultName'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label for="name" class="title-color">{{ translate('sub_Category') }}</label>
                                <select class="js-select2-custom form-control action-get-request-onchange"
                                    name="sub_category_id" id="sub-category-select"
                                    data-url-prefix="{{ url('/admin/products/get-categories?parent_id=') }}"
                                    data-element-id="sub-sub-category-select" data-element-type="select">
                                    <option
                                        value="{{ request('sub_category_id') != null ? request('sub_category_id') : null }}"
                                        selected {{ request('sub_category_id') != null ? '' : 'disabled' }}>
                                        {{ request('sub_category_id') != null ? $subCategory['defaultName'] : translate('select_Sub_Category') }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label for="name" class="title-color">{{ translate('sub_Sub_Category') }}</label>
                                <select class="js-select2-custom form-control" name="sub_sub_category_id"
                                    id="sub-sub-category-select">
                                    <option
                                        value="{{ request('sub_sub_category_id') != null ? request('sub_sub_category_id') : null }}"
                                        selected {{ request('sub_sub_category_id') != null ? '' : 'disabled' }}>
                                        {{ request('sub_sub_category_id') != null ? $subSubCategory['defaultName'] : translate('select_Sub_Sub_Category') }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex gap-3 justify-content-end">
                                <a href="{{ route('admin.products.list', ['type' => request('type')]) }}"
                                    class="btn btn-secondary px-5">
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
                                            placeholder="{{ translate('search_by_Product_Name') }}"
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
                                            <a class="dropdown-item"
                                                href="{{ route('vendor.products.export-excel', ['type' => $type, 'brand_id' => request('brand_id'), 'category_id' => request('category_id'), 'sub_category_id' => request('sub_category_id'), 'sub_sub_category_id' => request('sub_sub_category_id'), 'searchValue' => request('searchValue')]) }}">
                                                <img width="14"
                                                    src="{{ dynamicAsset(path: 'public/assets/back-end/img/excel.png') }}"
                                                    alt="">
                                                {{ translate('excel') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                @if ($type != 'new-request')
                                    <a href="{{ route('vendor.products.stock-limit-list') }}" class="btn btn-info">
                                        <i class="tio-add-circle"></i>
                                        <span class="text">{{ translate('limited_Stocks') }}</span>
                                    </a>
                                    <a href="{{ route('vendor.products.add') }}" class="btn btn--primary">
                                        <i class="tio-add"></i>
                                        <span class="text">{{ translate('add_new_product') }}</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="box-view p-3">
                        <div class="row g-3">
                            @foreach ($products as $key => $product)
                                <div class="col-6">
                                    <div class="card shadow-sm p-3 h-100">
                                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                                            {{-- Left Side: Product Details --}}
                                            <div class="d-flex gap-3 align-items-center flex-grow-1">
                                                <img src="{{ getStorageImages(path: $product->thumbnail_full_url, type: 'backend-product') }}"
                                                    class="rounded" alt=""
                                                    style="width: 80px; height: 80px; object-fit: cover;">

                                                <div class="text-start">
                                                    <h5 class="mb-1">{{ Str::limit($product['name'], 30) }}</h5>
                                                    <p class="mb-1 small">
                                                        <strong>{{ translate('Category') }}:</strong>
                                                        {{ \App\Models\Category::find($product['category_id'])->name ?? '-' }}
                                                    </p>
                                                    <p class="mb-1 small">
                                                        <strong>{{ translate('Unit Price') }}:</strong>
                                                        {{ setCurrencySymbol(amount: usdToDefaultCurrency($product['unit_price']), currencyCode: getCurrencyCode()) }}
                                                    </p>
                                                    <p class="mb-0 small">
                                                        <strong>{{ translate('Status') }}:</strong>
                                                        @if ($product->request_status == 0)
                                                            <span
                                                                class="badge bg-warning text-dark">{{ translate('pending') }}</span>
                                                        @elseif($product->request_status == 1)
                                                            <span
                                                                class="badge bg-success">{{ translate('approved') }}</span>
                                                        @elseif($product->request_status == 2)
                                                            <span class="badge bg-danger">{{ translate('denied') }}</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>

                                            {{-- Right Side: Actions --}}
                                            <div class="d-flex flex-column gap-2 align-items-end">
                                                <div class="d-grid gap-2"
                                                    style="grid-template-columns: repeat(2, 1fr); display: grid;">
                                                    <a href="{{ route('products_new.view-admin', ['id' => $product['id']]) }}"
                                                        class="btn btn-outline-info btn-sm d-flex flex-column align-items-center gap-1">
                                                        <i class="tio-invisible"></i>
                                                        <span>{{ translate('View') }}</span>
                                                    </a>
                                                    <a href="{{ route('admin.products.update', [$product['id']]) }}"
                                                        class="btn btn-outline-primary btn-sm d-flex flex-column align-items-center gap-1">
                                                        <i class="tio-edit"></i>
                                                        <span>{{ translate('Edit') }}</span>
                                                    </a>
                                                    <form action="{{ route('products_new.delete', [$product['id']]) }}"
                                                        method="post"
                                                        class="m-0 d-flex flex-column align-items-center gap-1">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="id"
                                                            value="{{ $product['id'] }}">
                                                        <button type="submit"
                                                            class="btn btn-outline-danger btn-sm d-flex flex-column align-items-center gap-1 delete-data">
                                                            <i class="tio-delete"></i>
                                                            <span>{{ translate('Delete') }}</span>
                                                        </button>
                                                    </form>
                                                    <form
                                                        action="{{ route('products_new.status-update', ['id' => $product['id']]) }}"
                                                        method="post"
                                                        class="m-0 d-flex flex-column align-items-center gap-1">
                                                        @csrf
                                                        <input type="hidden" name="id"
                                                            value="{{ $product['id'] }}">
                                                        <label class="switcher">
                                                            <input type="checkbox"
                                                                class="switcher_input toggle-switch-message"
                                                                name="status" value="1" onchange="togglestatus(this)"
                                                                {{ $product['status'] == 1 ? 'checked' : '' }}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                        <span>{{ translate('Toggle') }}</span>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="table-responsive mt-4">
                        <div class="px-4 d-flex justify-content-lg-end">
                            {{ $products->links() }}
                        </div>
                    </div>

                    @if (count($products) == 0)
                        @include(
                            'layouts.back-end._empty-state',
                            ['text' => 'no_product_found'],
                            ['image' => 'default']
                        )
                    @endif
                </div>
            </div>
        </div>
    </div>
    <span id="message-select-word" data-text="{{ translate('select') }}"></span>
    <script>
        function togglestatus(el) {
            console.log('switched');
            const $checkbox = $(el);
            const $form = $checkbox.closest('form');
            const formData = $form.serialize();
            const actionUrl = $form.attr('action');

            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Show success toast
                        toastr.success(response.message || 'Status updated successfully');
                    } else {
                        toastr.error(response.message || 'Something went wrong');
                    }
                },
                error: function(xhr) {
                    toastr.error('Server error: ' + xhr.status);
                }
            });
        }
    </script>
@endsection
