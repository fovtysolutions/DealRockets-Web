@extends('layouts.back-end.app')

@section('title', translate('Tradeshow List'))

@section('content')
<div class="content container-fluid">

    <div class="mb-3">
        <h2 class="h1 mb-0 text-capitalize d-flex gap-2">
            <img src="{{ dynamicAsset('public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
            {{ translate('Tradeshow List') }}
            <span class="badge badge-soft-dark radius-50 fz-14 ml-1">{{ $totalTradeshows }}</span>
        </h2>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ url()->current() }}" method="GET">
                <input type="hidden" value="{{ request('status') }}" name="status">
                <div class="row gx-2">
                    <div class="col-12">
                        <h4 class="mb-3">{{ translate('Filter Tradeshows') }}</h4>
                    </div>

                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="form-group">
                            <label for="name" class="title-color">{{ translate('Name') }}</label>
                            <select name="name" class="js-select2-custom form-control text-capitalize">
                                <option value="" selected>{{ translate('All Companys') }}</option>
                                @foreach ($company_name as $name)
                                    <option value="{{ trim($name) }}" {{ request('name') == trim($name) ? 'selected' : '' }}>
                                        {{ trim($name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="form-group">
                            <label for="country" class="title-color">{{ translate('Country') }}</label>
                            <select name="country" class="js-select2-custom form-control text-capitalize">
                                <option value="" selected>{{ translate('All Countries') }}</option>
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
                            <label for="contact_number" class="title-color">{{ translate('Contact Number') }}</label>
                            <input type="text" name="contact_number" class="form-control" placeholder="{{ translate('Enter Contact Number') }}" value="{{ request('contact_number') }}">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="d-flex gap-3 justify-content-end">
                            <a class="btn btn-secondary px-5" href="{{ url()->current() }}">
                                {{ translate('Reset') }}
                            </a>
                            <button type="submit" class="btn btn--primary px-5 action-get-element-type">
                                {{ translate('Show Data') }}
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
                                        placeholder="{{ translate('Search by Tradeshow Name') }}"
                                        aria-label="Search tradeshows" value="{{ request('searchValue') }}">
                                    <input type="hidden" value="{{ request('status') }}" name="status">
                                    <button type="submit" class="btn btn--primary">{{ translate('Search') }}</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-8 mt-3 mt-lg-0 d-flex flex-wrap gap-3 justify-content-lg-end">
                            <div class="dropdown">
                                <button type="button" class="btn btn-outline--primary" data-toggle="dropdown">
                                    <i class="tio-download-to"></i>
                                    {{ translate('Export') }}
                                    <i class="tio-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a class="dropdown-item">
                                            <img width="14" src="{{ dynamicAsset('public/assets/back-end/img/excel.png') }}" alt="">
                                            {{ translate('Excel') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <a href="{{ route('admin.add-new-tradeshow') }}" class="btn btn--primary">
                                <i class="tio-add"></i>
                                <span class="text">{{ translate('Add New Tradeshow') }}</span>
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
                                <th>{{ translate('Tradeshow Name') }}</th>
                                <th class="text-center">{{ translate('Country') }}</th>
                                <th class="text-center">{{ translate('Company Name') }}</th>
                                <th class="text-center">{{ translate('Website') }}</th>
                                <th class="text-center">{{ translate('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tradeshows as $key => $tradeshow)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>
                                        <a href="{{ route('admin.tradeshow.view', ['id' => $tradeshow['id']]) }}"
                                            class="media align-items-center gap-2">
                                            <span class="media-body title-color hover-c1">
                                                {{ Str::limit($tradeshow['name'], 20) }}
                                            </span>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        {{ \App\Utils\ChatManager::getCountryDetails($tradeshow['country'])['countryName'] ?? 'N/A' }}
                                    </td>
                                    <td class="text-center">
                                        {{ $tradeshow['company_name'] }}
                                    </td>
                                    <td class="text-center">
                                        {{ $tradeshow['website'] }}
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a class="btn btn-outline-info btn-sm square-btn" title="View"
                                                href="{{ route('admin.tradeshow.view', ['id' => $tradeshow['id']]) }}">
                                                <i class="tio-invisible"></i>
                                            </a>
                                            <a class="btn btn-outline--primary btn-sm square-btn"
                                                title="{{ translate('Edit') }}"
                                                href="{{ route('admin.tradeshow.edit', ['id' => $tradeshow['id']]) }}">
                                                <i class="tio-edit"></i>
                                            </a>
                                            <span class="btn btn-outline-danger btn-sm square-btn delete-data"
                                                title="{{ translate('Delete') }}" data-id="tradeshow-{{ $tradeshow['id'] }}">
                                                <i class="tio-delete"></i>
                                            </span>
                                        </div>
                                        <form action="{{ route('admin.tradeshow.delete', [$tradeshow['id']]) }}" method="post"
                                            id="tradeshow-{{ $tradeshow['id'] }}">
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
                        {{ $totaltradeshowpage }}
                    </div>
                </div>

                @if(count($tradeshows) == 0)
                    @include('layouts.back-end._empty-state', ['text' => 'No tradeshows found', 'image' => 'default'])
                @endif
            </div>
        </div>
    </div>
</div>
<span id="message-select-word" data-text="{{ translate('select') }}"></span>
@endsection
