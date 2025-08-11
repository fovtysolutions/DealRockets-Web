@extends('layouts.back-end.app-partial')

@section('title', translate('cv_List'))

@section('content')
<div class="content container-fluid">

    <!-- <div class="mb-3">
        <h2 class="h1 mb-0 text-capitalize d-flex gap-2">
            <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
            {{ translate('cv_List') }}
            <span class="badge badge-soft-dark radius-50 fz-14 ml-1">{{ $totalCvs }}</span>
        </h2>
    </div> -->

    <div class="container-fluid p-0">
        <div class="mb-3">
            <div class="card-body p-0">
                <form action="{{ url()->current() }}" method="GET">
                    <input type="hidden" name="searchValue" value="{{ request('searchValue') }}">
                    
                    <div class="row g-2 align-items-end">
                        <!-- Date From Filter -->
                        <div class="col-md-2">
                            <label class="form-label mb-1 small">{{ translate('date_from') }}</label>
                            <input type="date" name="from" class="form-control form-control-sm" 
                                   value="{{ request('from') }}">
                        </div>
                        
                        <!-- Date To Filter -->
                        <div class="col-md-2">
                            <label class="form-label mb-1 small">{{ translate('date_to') }}</label>
                            <input type="date" name="to" class="form-control form-control-sm" 
                                   value="{{ request('to') }}">
                        </div>

                        <!-- Sort Filter -->
                        <div class="col-md-2">
                            <label class="form-label mb-1 small">{{ translate('sort_by') }}</label>
                            <select name="sort_by" class="form-control form-control-sm">
                                <option value="">{{ translate('default') }}</option>
                                <option value="name_asc" {{ request('sort_by') == 'name_asc' ? 'selected' : '' }}>{{ translate('name_asc') }}</option>
                                <option value="name_desc" {{ request('sort_by') == 'name_desc' ? 'selected' : '' }}>{{ translate('name_desc') }}</option>
                                <option value="created_asc" {{ request('sort_by') == 'created_asc' ? 'selected' : '' }}>{{ translate('date_asc') }}</option>
                                <option value="created_desc" {{ request('sort_by') == 'created_desc' ? 'selected' : '' }}>{{ translate('date_desc') }}</option>
                            </select>
                        </div>

                        <!-- Experience Level Filter -->
                        <div class="col-md-2">
                            <label class="form-label mb-1 small">{{ translate('experience') }}</label>
                            <select name="experience" class="form-control form-control-sm">
                                <option value="">{{ translate('all') }}</option>
                                <option value="fresher" {{ request('experience') == 'fresher' ? 'selected' : '' }}>{{ translate('fresher') }}</option>
                                <option value="1-3" {{ request('experience') == '1-3' ? 'selected' : '' }}>{{ translate('1-3_years') }}</option>
                                <option value="3-5" {{ request('experience') == '3-5' ? 'selected' : '' }}>{{ translate('3-5_years') }}</option>
                                <option value="5+" {{ request('experience') == '5+' ? 'selected' : '' }}>{{ translate('5+_years') }}</option>
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div class="col-md-2">
                            <label class="form-label mb-1 small">{{ translate('status') }}</label>
                            <select name="status" class="form-control form-control-sm">
                                <option value="">{{ translate('all') }}</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ translate('active') }}</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ translate('pending') }}</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>{{ translate('approved') }}</option>
                            </select>
                        </div>

                        <!-- Reset Button -->
                        <div class="col-md-1">
                            <a href="{{ route('admin.cv.list') }}" class="btn btn--primary w-100" style="height:35px;">
                                <i class="tio-refresh"></i>
                            </a>
                        </div>
                        
                        <!-- Show Data Button -->
                        <div class="col-md-1">
                            <button type="submit" class="btn btn--primary w-100" style="height:35px;">
                                <i class="tio-filter-list"></i>
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
                                    <td class="text-center">
                                        <div class="" role="group" style="display: flex;gap: 10px;align-items: center;">
                                            <a href="{{ route('admin.cv.view', ['id' => $cv['id']]) }}"
                                                class="btn btn-outline-info" title="View">
                                                <i class="tio-invisible"></i>View
                                            </a>
                                            <a href="{{ route('admin.cv.edit', ['id' => $cv['id']]) }}"
                                                class="btn btn-outline-primary" title="Edit">
                                                <i class="tio-edit"></i>Edit
                                            </a>
                                            <form action="{{ route('admin.cv.delete', [$cv['id']]) }}" method="POST"
                                                onsubmit="return confirm('Are you sure?');" class="d-inline">
                                                @csrf 
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                    Delete<i class="tio-delete"></i>
                                                </button>
                                            </form>
                                        </div>
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
