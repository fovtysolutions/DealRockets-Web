@extends('layouts.back-end.app')

@section('title', translate('Countries_Settings'))

@section('content')
<div class="content container-fluid">
    <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
        <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
            <img width="20" src="{{ dynamicAsset(path: '/public/assets/back-end/img/business-setup.png') }}" alt="">
            {{ translate('business_setup') }}
        </h2>
    </div>

    @include('admin-views.business-settings.business-setup-inline-menu')

    <div class="card">
        <div class="border-bottom px-4 py-3">
            <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2 text-capitalize">
                <img src="{{ dynamicAsset(path: '/public/assets/back-end/img/header-logo.png') }}" alt="">
                {{ translate('country_Setup_Settings') }}
            </h5>
        </div>
        <div class="card-body">
            <!-- Search and Filter Form -->
            <form action="{{ route('admin.countrySetup.index') }}" method="GET" class="mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search by name or code" value="{{ $search ?? '' }}">
                            <button type="submit" class="btn btn-primary">{{ translate('Search') }}</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select name="blacklist" class="form-control" onchange="this.form.submit()">
                                <option value="">{{ translate('All') }}</option>
                                <option value="yes" {{ $blacklistFilter === 'yes' ? 'selected' : '' }}>{{ translate('Blacklisted') }}</option>
                                <option value="no" {{ $blacklistFilter === 'no' ? 'selected' : '' }}>{{ translate('Not Blacklisted') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select name="region" class="form-control" onchange="this.form.submit()">
                                <option value="">{{ translate('All Regions') }}</option>
                                @foreach ($regions as $region)
                                    <option value="{{ $region }}" {{ $regionFilter === $region ? 'selected' : '' }}>{{ $region }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Country Table -->
            <div class="table-responsive">
                <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-capitalize text-center">{{ translate('country') }}</th>
                            <th class="text-capitalize text-center">{{ translate('country_code') }}</th>
                            <th class="text-capitalize text-center">{{ translate('continent') }}</th>
                            <th class="text-capitalize text-center">{{ translate('blacklist') }}</th>
                            <th class="text-capitalize text-center">{{ translate('action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($countries as $country)
                        <tr>
                            <td class="text-capitalize text-center">{{ $country->name }}</td>
                            <td class="text-capitalize text-center">{{ $country->phonecode }}</td>
                            <td class="text-capitalize text-center">{{ $country->region }}</td>
                            <td class="text-capitalize text-center">{{ $country->blacklist }}</td>
                            <td class="text-capitalize text-center">
                                <a href="{{ route('admin.countrySetup.edit', $country->id) }}" class="btn btn-warning">{{ translate('edit') }}</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">{{ translate('no_countries_found') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection