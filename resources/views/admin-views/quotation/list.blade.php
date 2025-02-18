@extends('layouts.back-end.app')

@section('title', translate('quotations_List'))

@section('content')
<div class="content container-fluid">

    <div class="mb-3">
        <h2 class="h1 mb-0 text-capitalize d-flex gap-2">
            <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
            {{ translate('quotations_List') }}
            <span class="badge badge-soft-dark radius-50 fz-14 ml-1">{{ $totalquotations }}</span>
        </h2>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ url()->current() }}" method="GET">
                <input type="hidden" value="{{ request('status') }}" name="status">
                <div class="row gx-2">
                    <div class="col-12">
                        <h4 class="mb-3">{{ translate('filter_quotations') }}</h4>
                    </div>

                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="form-group">
                            <label class="title-color" for="name">{{ translate('name') }}</label>
                            <input type="text" name="name" class="form-control text-capitalize" value="{{ request('name') }}" placeholder="{{ translate('search_by_name') }}">
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="form-group">
                            <label class="title-color" for="quantity">{{ translate('quantity') }}</label>
                            <input type="text" name="quantity" class="form-control" value="{{ request('quantity') }}" placeholder="{{ translate('search_by_quantity') }}">
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="form-group">
                            <label class="title-color" for="description">{{ translate('description') }}</label>
                            <input type="text" name="description" class="form-control" value="{{ request('description') }}" placeholder="{{ translate('search_by_description') }}">
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
                                        placeholder="{{ translate('search_by_name') }}"
                                        aria-label="Search quotations" value="{{ request('searchValue') }}">
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
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="datatable"
                        class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100 text-start">
                        <thead class="thead-light thead-50 text-capitalize">
                            <tr>
                                <th>{{ translate('SL') }}</th>
                                <th>{{ translate('name') }}</th>
                                <th class="text-center">{{ translate('quantity') }}</th>
                                <th class="text-center">{{ translate('description') }}</th>
                                <th class="text-center">{{ translate('action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quotations as $key => $quotation)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>
                                        <a href="{{ route('admin.quotation.view', ['id' => $quotation->id]) }}"
                                            class="media align-items-center gap-2">
                                            <span class="media-body title-color hover-c1">
                                                {{ Str::limit($quotation->name, 20) }}
                                            </span>
                                        </a>
                                    </td>
                                    <td class="text-center">{{ $quotation->quantity }}</td>
                                    <td class="text-center">{{ Str::limit($quotation->description, 50) }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a class="btn btn-outline-info btn-sm square-btn" title="View"
                                                href="{{ route('admin.quotation.view', ['id' => $quotation->id]) }}">
                                                <i class="tio-invisible"></i>
                                            </a>
                                            <a class="btn btn-outline--primary btn-sm square-btn"
                                                title="{{ translate('edit') }}"
                                                href="{{ route('admin.quotation.edit', ['id' => $quotation->id]) }}">
                                                <i class="tio-edit"></i>
                                            </a>
                                            <span class="btn btn-outline-danger btn-sm square-btn delete-data"
                                                title="{{ translate('delete') }}" data-id="quotation-{{ $quotation->id}}">
                                                <i class="tio-delete"></i>
                                            </span>
                                        </div>
                                        <form action="{{ route('admin.quotation.delete', [$quotation->id]) }}" method="post"
                                            id="quotation-{{ $quotation->id}}">
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
                        {{ $totquotationspage->links() }}
                    </div>
                </div>

                @if(count($quotations) == 0)
                    @include('layouts.back-end._empty-state', ['text' => 'no_quotations_found'], ['image' => 'default'])
                @endif
            </div>
        </div>
    </div>
</div>
<span id="message-select-word" data-text="{{ translate('select') }}"></span>
@endsection
