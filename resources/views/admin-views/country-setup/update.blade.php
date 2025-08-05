@extends('layouts.back-end.app')

@section('title', translate('Update_Country_Blacklist_Status'))

@section('content')
<div class="content container-fluid">
    <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
        <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
            <img width="20" src="{{ dynamicAsset(path: '/public/assets/back-end/img/business-setup.png') }}" alt="">
            {{ translate('business_setup') }}
        </h2>
    </div>

    {{-- @include('admin-views.business-settings.business-setup-inline-menu') --}}

    <div class="card">
        <div class="border-bottom px-4 py-3">
            <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2 text-capitalize">
                <img src="{{ dynamicAsset(path: '/public/assets/back-end/img/header-logo.png') }}" alt="">
                {{ translate('update_blacklist_status') }}
            </h5>
        </div>
        <div class="card-body">
            <!-- Update Blacklist Form -->
            <form action="{{ route('admin.countrySetup.update', $country->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="blacklist" class="text-capitalize">{{ translate('blacklist_status') }}</label>
                    <select name="blacklist" id="blacklist" class="form-control">
                        <option value="no" {{ $country->blacklist === 'no' ? 'selected' : '' }}>{{ translate('no') }}</option>
                        <option value="yes" {{ $country->blacklist === 'yes' ? 'selected' : '' }}>{{ translate('yes') }}</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">{{ translate('update') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection