@extends('layouts.back-end.app')

@section('title', translate('cv_List'))

@section('content')
<div class="content container-fluid">

    <div class="mb-3">
        <h2 class="h1 mb-0 text-capitalize d-flex gap-2">
            <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
            {{ translate('cv_List') }}
            <span class="badge badge-soft-dark radius-50 fz-14 ml-1">{{ $totalCvs }}</span>
        </h2>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ url()->current() }}" method="GET">
                <input type="hidden" value="{{ request('status') }}" name="status">
                <div class="row gx-2">
                    <div class="col-12">
                        <h4 class="mb-3">{{ translate('filter_cvs') }}</h4>
                    </div>

                    <!-- Filter by Name -->
                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="form-group">
                            <label class="title-color" for="name">{{ translate('name') }}</label>
                            <input type="text" name="name" class="form-control text-capitalize" placeholder="{{ translate('search_by_name') }}" value="{{ request('name') }}">
                        </div>
                    </div>

                    <!-- Filter by Details -->
                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="form-group">
                            <label class="title-color" for="details">{{ translate('details') }}</label>
                            <input type="text" name="details" class="form-control text-capitalize" placeholder="{{ translate('search_by_details') }}" value="{{ request('details') }}">
                        </div>
                    </div>

                    <!-- Filter by Email -->
                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="form-group">
                            <label class="title-color" for="email">{{ translate('email') }}</label>
                            <input type="text" name="email" class="form-control text-capitalize" placeholder="{{ translate('search_by_email') }}" value="{{ request('email') }}">
                        </div>
                    </div>

                    <!-- Filter by Phone Number -->
                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="form-group">
                            <label class="title-color" for="pnumber">{{ translate('phone_number') }}</label>
                            <input type="text" name="pnumber" class="form-control text-capitalize" placeholder="{{ translate('search_by_phone_number') }}" value="{{ request('pnumber') }}">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="d-flex gap-3 justify-content-end">
                            <a class="btn btn-secondary px-5" href="{{ url()->current() }}">
                                {{ translate('reset') }}
                            </a>
                            <button type="submit" class="btn btn--primary px-5">
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
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="datatable"
                        class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100 text-start">
                        <thead class="thead-light thead-50 text-capitalize">
                            <tr>
                                <th>{{ translate('SL') }}</th>
                                <th>{{ translate('Name') }}</th>
                                <th>{{ translate('email') }}</th>
                                <th>{{ translate('phone_number') }}</th>
                                <th>{{ translate('details') }}</th>
                                <th>{{ translate('action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cvs as $key => $cv)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>
                                        <a href="{{ route('admin.cv.view', ['id' => $cv['id']]) }}"
                                            class="media align-items-center gap-2">
                                            <span class="media-body title-color hover-c1">
                                                {{ Str::limit($cv['name'], 20) }}
                                            </span>
                                        </a>
                                    </td>
                                    <td>
                                        {{ $cv['email'] }}
                                    </td>
                                    <td>
                                        {{ $cv['pnumber'] }}
                                    </td>
                                    <td>
                                        {{ $cv['details'] }}
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a class="btn btn-outline-info btn-sm square-btn" title="View"
                                                href="{{ route('admin.cv.view', ['id' => $cv['id']]) }}">
                                                <i class="tio-invisible"></i>
                                            </a>
                                            <a class="btn btn-outline--primary btn-sm square-btn"
                                                title="{{ translate('edit') }}"
                                                href="{{ route('admin.cv.edit', ['id' => $cv['id']]) }}">
                                                <i class="tio-edit"></i>
                                            </a>
                                            <span class="btn btn-outline-danger btn-sm square-btn delete-data"
                                                title="{{ translate('delete') }}" data-id="cv-{{ $cv['id']}}">
                                                <i class="tio-delete"></i>
                                            </span>
                                        </div>
                                        <form action="{{ route('admin.cv.delete', [$cv['id']]) }}" method="post"
                                            id="cv-{{ $cv['id']}}">
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
                        {{ $totCvsPage }}
                    </div>
                </div>

                @if(count($cvs) == 0)
                    @include('layouts.back-end._empty-state', ['text' => 'no_supplier_found'], ['image' => 'default'])
                @endif
            </div>
        </div>
    </div>
</div>
<span id="message-select-word" data-text="{{ translate('select') }}"></span>
@endsection
