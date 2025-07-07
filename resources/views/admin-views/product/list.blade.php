@extends('layouts.back-end.app-partial')

@section('title', translate('product_List'))

@section('content')
    <div class="content container-fluid">

        {{-- <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex gap-2">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
                @if ($type == 'in_house')
                    {{ translate('in_House_Product_List') }}
                @elseif($type == 'seller')
                    {{ translate('vendor_Product_List') }}
                @endif
                <span class="badge badge-soft-dark radius-50 fz-14 ml-1">{{ $products->total() }}</span>
            </h2>
        </div> --}}

        <div class="container-fluid p-0">
            <div class="mb-3">
                <div class="card-body p-0">
                    <form action="{{ url()->current() }}" method="GET">
                        <input type="hidden" name="status" value="{{ request('status') }}">

                        <div class="row g-2 align-items-end">
                            @if (request('type') == 'seller')
                                <div class="col-md-2 col-sm-4 col-6">
                                    <label class="form-label mb-1 small">{{ translate('store') }}</label>
                                    <select name="seller_id" class="form-control form-control-sm">
                                        <option value="">{{ translate('all_store') }}</option>
                                        @foreach ($sellers as $seller)
                                            <option value="{{ $seller->id }}" {{ request('seller_id') == $seller->id ? 'selected' : '' }}>
                                                {{ $seller->shop->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="col-md-2 col-sm-4 col-6">
                                <label class="form-label mb-1 small">{{ translate('brand') }}</label>
                                <select name="brand_id" class="form-control form-control-sm">
                                    <option value="">{{ translate('all_brand') }}</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->default_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2 col-sm-4 col-6">
                                <label class="form-label mb-1 small">{{ translate('category') }}</label>
                                <select name="category_id" class="form-control form-control-sm action-get-request-onchange"
                                    data-url-prefix="{{ url('/admin/products/get-categories?parent_id=') }}"
                                    data-element-id="sub-category-select"
                                    data-element-type="select">
                                    <option disabled selected>{{ translate('select_category') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category['id'] }}" {{ request('category_id') == $category['id'] ? 'selected' : '' }}>
                                            {{ $category['defaultName'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2 col-sm-4 col-6">
                                <label class="form-label mb-1 small">{{ translate('sub_Category') }}</label>
                                <select name="sub_category_id" id="sub-category-select" class="form-control form-control-sm action-get-request-onchange"
                                    data-url-prefix="{{ url('/admin/products/get-categories?parent_id=') }}"
                                    data-element-id="sub-sub-category-select"
                                    data-element-type="select">
                                    <option value="{{ request('sub_category_id') ?? '' }}" selected {{ request('sub_category_id') ? '' : 'disabled' }}>
                                        {{ request('sub_category_id') ? $subCategory['defaultName'] : translate('select_Sub_Category') }}
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-2 col-sm-4 col-6">
                                <label class="form-label mb-1 small">{{ translate('sub_Sub_Category') }}</label>
                                <select name="sub_sub_category_id" id="sub-sub-category-select" class="form-control form-control-sm">
                                    <option value="{{ request('sub_sub_category_id') ?? '' }}" selected {{ request('sub_sub_category_id') ? '' : 'disabled' }}>
                                        {{ request('sub_sub_category_id') ? $subSubCategory['defaultName'] : translate('select_Sub_Sub_Category') }}
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-2 col-sm-4 col-6 d-flex gap-2">
                                <a href="{{ route('admin.products.list', ['type' => request('type')]) }}" class="btn btn--primary w-100">
                                    {{ translate('reset') }}
                                </a>
                                <button type="submit" class="btn btn--primary w-100">
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
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Thumbnail</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Unit Price</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Published</th>
                                        <th scope="col" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $index => $product)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <img src="{{ getStorageImages(path: $product->thumbnail_full_url, type: 'backend-product') }}"
                                                    alt="Thumbnail" style="width: 60px; height: 60px; object-fit: cover;"
                                                    class="rounded">
                                            </td>
                                            <td>{{ Str::limit($product->name, 30) }}</td>
                                            <td>{{ \App\Models\Category::find($product->category_id)->name ?? '-' }}</td>
                                            <td>
                                                {{ setCurrencySymbol(amount: usdToDefaultCurrency($product->unit_price), currencyCode: getCurrencyCode()) }}
                                            </td>
                                            <td>
                                                @if ($product->status == 0)
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif($product->status == 1)
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($product->status == 2)
                                                    <span class="badge bg-danger">Denied</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('products_new.publish_update', ['id' => $product['id']]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $product['id'] }}">
                                                    <label class="switcher m-0">
                                                        <input type="checkbox"
                                                            class="switcher_input toggle-switch-message" name="status"
                                                            value="1" onchange="togglestatus(this)"
                                                            {{ $product['published'] == 1 ? 'checked' : '' }}>
                                                        <span class="switcher_control"></span>
                                                    </label>
                                                </form>
                                            </td>
                                            <td class="text-center">
                                                <div class="" role="group"
                                                    style="display: flex;gap: 10px;align-items: anchor-center;">
                                                    <a href="{{ route('products_new.view-admin', ['id' => $product['id']]) }}"
                                                        class="btn btn-outline-info" title="View"><i
                                                            class="tio-invisible"></i>View</a>
                                                    <a href="{{ route('admin.products.update', [$product['id']]) }}"
                                                        class="btn btn-outline-primary" title="Edit"><i
                                                            class="tio-edit"></i>Edit</a>
                                                    <form action="{{ route('products_new.delete', [$product['id']]) }}"
                                                        method="POST" onsubmit="return confirm('Are you sure?');"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="id"
                                                            value="{{ $product['id'] }}">
                                                        <button type="submit" class="btn btn-outline-danger"
                                                            title="Delete">Delete
                                                            <i class="tio-delete"></i>
                                                        </button>
                                                    </form>
                                                    @if (auth('admin')->check())
                                                        <form
                                                            action="{{ route('products_new.deny_status', ['id' => $product['id']]) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="id"
                                                                value="{{ $product['id'] }}">
                                                            <button type="button"
                                                                class="btn {{ $product['status'] == 1 ? 'btn-outline-danger' : 'btn-outline-success' }}"
                                                                title="{{ $product['status'] == 1 ? 'Revoke Approval' : 'Approve Product' }}"
                                                                onclick="togglestatus(this)">
                                                                <i
                                                                    class="{{ $product['status'] == 1 ? 'tio-close-circle-outlined' : 'tio-checkmark-circle-outlined' }}"></i>
                                                                {{ $product['status'] == 1 ? 'Revoke' : 'Approve' }}
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

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
