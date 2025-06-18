@extends('layouts.back-end.app-partialseller')

@section('title', translate('profile_Settings'))
@push('css_or_js')
    <link rel="stylesheet"
        href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/intl-tel-input/css/intlTelInput.css') }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <div class="card">
            <div class="card-body">
                <form id="company-profile" enctype="multipart/form-data">
                    @include('vendor-views.profile.partials.cp-formfields')
                    <input type="hidden" name="seller" id="seller" value={{ auth('seller')->user()->id }}>
                    {{-- <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn--primary">{{ translate('save_Changes') }}</button>
                            </div> --}}
                </form>
            </div>
        </div>
    </div>
@endsection
