@extends('layouts.back-end.app')

@section('title', translate('View_Quotation'))

@push('css_or_js')
    <link href="{{ dynamicAsset('public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset('public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset('public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
            <h2 class="h1 mb-0 d-flex gap-2">
                <img src="{{ dynamicAsset('public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
                {{ translate('View_Quotation') }}
            </h2>
        </div>

        <div class="card">
            <div class="card-body">
                <h4>{{ translate('Quotation_Details') }}</h4>

                <div class="mb-3">
                    <strong>{{ translate('Quotation Name') }}:</strong> {{ $quotations->name }}
                </div>

                <div class="mb-3">
                    <strong>{{ translate('Quantity Required') }}:</strong> 
                    {{ $quotations->quantity ?? 'N/A' }}
                </div>

                <div class="mb-3">
                    <strong>{{ translate('Description') }}:</strong> {{ $quotations->description }}
                </div>

                <div class="mb-3">
                    <strong>{{ translate('Email') }}:</strong> {{ $quotations->email }}
                </div>

                <div class="mb-3">
                    <strong>{{ translate('Phone Number') }}:</strong> {{ $quotations->pnumber }}
                </div>
            </div>
        </div>

        <div class="row justify-content-end gap-3 mt-3 mx-1">
            <a href="{{ route('admin.quotation.edit', $quotations->id) }}" class="btn btn--primary px-5">{{ translate('Edit') }}</a>
            <a href="{{ route('admin.quotation.list') }}" class="btn btn-secondary px-5">{{ translate('Back to List') }}</a>
        </div>
    </div>
@endsection
