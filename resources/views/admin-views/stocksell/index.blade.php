@extends('layouts.back-end.app-partial')

@section('title', translate('Stock_List'))

@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex gap-2">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
                {{ translate('Stock_Sell_List') }}
                <span class="badge badge-soft-dark radius-50 fz-14 ml-1">{{ $items->total() }}</span>
            </h2>
        </div> -->

        <div class="container-fluid p-0">
            <div class="mb-3">
                <div class="card-body p-0">
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-2 col-sm-4 col-6">
                                <label class="form-label mb-1 small">{{ translate('status') }}</label>
                                <select name="status" class="form-control form-control-sm">
                                    <option value="">{{ translate('all_status') }}</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                                        {{ translate('active') }}
                                    </option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                        {{ translate('inactive') }}
                                    </option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                        {{ translate('rejected') }}
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-2 col-sm-4 col-6">
                                <label class="form-label mb-1 small">{{ translate('min_quantity') }}</label>
                                <input type="number" name="minqty" class="form-control form-control-sm" 
                                    placeholder="{{ translate('min_qty') }}" value="{{ request('minqty') }}" min="0">
                            </div>

                            <div class="col-md-2 col-sm-4 col-6">
                                <label class="form-label mb-1 small">{{ translate('max_quantity') }}</label>
                                <input type="number" name="maxqty" class="form-control form-control-sm" 
                                    placeholder="{{ translate('max_qty') }}" value="{{ request('maxqty') }}" min="0">
                            </div>

                            <div>
                                <a href="{{ route('admin.stock.index') }}"
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
                                        <input id="datatableSearch_" type="search" name="name" class="form-control"
                                            placeholder="{{ translate('search_by_Product_Name') }}"
                                            aria-label="Search products" value="{{ request('name') }}">
                                        <input type="hidden" value="{{ request('status') }}" name="status">
                                        <input type="hidden" value="{{ request('minqty') }}" name="minqty">
                                        <input type="hidden" value="{{ request('maxqty') }}" name="maxqty">
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
                                            <a class="dropdown-item" href="#">
                                                <img width="14" src="{{ dynamicAsset(path: 'public/assets/back-end/img/excel.png') }}" alt="">
                                                {{ translate('excel') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <a href="{{ route('admin.stock.create') }}" class="btn btn--primary">
                                    <i class="tio-add"></i>
                                    <span class="text">{{ translate('add_new_stock') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="box-view p-3">

                            <div class="table-responsive">
                                <table id="datatable"
                                    style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                    class="table table-hover table-borderless table-thead-bordered table-align-middle card-table w-100">
                                    <thead class="thead-light thead-50 text-capitalize table-nowrap">
                                        <tr>
                                            <th>#</th>
                                            <th>{{ translate('name') }}</th>
                                            <th>{{ translate('quantity') }}</th>
                                            <th>{{ translate('status') }}</th>
                                            <th>{{ translate('view_product') }}</th>
                                            <th class="text-center">{{ translate('actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $key => $value)
                                            <tr>
                                                <td>{{$key + 1}}</td>
                                                <td>{{ $value->name }}</td>
                                                {{-- <td>{!! $value->description !!}</td> --}}
                                                <td>{{ $value->quantity }}</td>
                                                <td>
                                                    @if($value->status == 'active')
                                                        <span class="badge bg-success">Active</span>
                                                    @elseif($value->status == 'inactive')
                                                        <span class="badge bg-secondary">Inactive</span>
                                                    @elseif($value->status == 'rejected')
                                                        <span class="badge bg-danger">Rejected</span>
                                                    @else
                                                        <span class="badge bg-warning">Invalid</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a
                                                        href="{{ route('admin.products.view', ['addedBy' => "$value->user_id", 'id' => "$value->product_id"]) }}">
                                                        <span>See Product</span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <div class="" role="group" style="display: flex;gap: 10px;align-items: center;">
                                                        <a href="{{ route('admin.stock.show', ['id' => $value->id]) }}"
                                                            class="btn btn-outline-info" title="View"><i class="tio-invisible"></i>View</a>
                                                        <a href="{{ route('admin.stock.edit', ['id' => $value->id]) }}"
                                                            class="btn btn-outline-primary" title="Edit"><i class="tio-edit"></i>Edit</a>
                                                        <form action="{{ route('admin.stock.destroy', ['id' => $value->id]) }}"
                                                            method="POST" onsubmit="return confirm('Are you sure?');" class="d-inline">
                                                            @csrf 
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger" title="Delete">Delete
                                                                <i class="tio-delete"></i>
                                                            </button>
                                                        </form>
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
                            {{ $items->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/tags-input.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.js') }}"></script>
@endpush