@extends('layouts.back-end.app-partialseller')

@section('title', translate('View_Lead'))

@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
            <h2 class="h1 mb-0 d-flex gap-2">
                <img src="{{ dynamicAsset('public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
                {{ translate('View_Lead') }}
            </h2>
        </div>

        <div class="card">
            <div class="card-body">
                <h4>{{ translate('Lead_Details') }}</h4>
                <div class="mb-3">
                    <strong>{{ translate('Lead Type') }}:</strong> {{ $leads->type }}
                </div>
                <div class="mb-3">
                    <strong>{{ translate('Lead Name') }}:</strong> {{ $leads->name }}
                </div>

                <div class="mb-3">
                    <strong>{{ translate('Country') }}:</strong> {{ \App\Models\Country::where('id',$leads->country)->first()->name ?? 'Invalid Country ID' }}
                </div>

                <div class="mb-3">
                    <strong>{{ translate('Company Name') }}:</strong> {{ $leads->company_name }}
                </div>

                <div class="mb-3">
                    <strong>{{ translate('Contact Number') }}:</strong> {{ $leads->contact_number }}
                </div>

                <div class="mb-3">
                    <strong>{{ translate('Posted Date') }}:</strong> {{ $leads->posted_date }}
                </div>

                <div class="mb-3">
                    <strong>{{ translate('Quantity') }}:</strong> {{ $leads->quantity_required }}
                </div>

                <div class="mb-3">
                    <strong>{{ translate('Buying Freqency') }}:</strong> {{ $leads->buying_frequency }}
                </div>

                <div class="mb-3">
                    <strong>{{ translate('Details') }}:</strong> {{ $leads->details }}
                </div>
            </div>
        </div>

        <div class="row justify-content-end gap-3 mt-3 mx-1 my-3">
            <a href="{{ route('vendor.leads.edit', $leads->id) }}" class="btn btn--primary px-5">{{ translate('Edit') }}</a>
            <a href="{{ route('vendor.leads.list') }}" class="btn btn-secondary px-5">{{ translate('Back to List') }}</a>
        </div>
    </div>
@endsection
