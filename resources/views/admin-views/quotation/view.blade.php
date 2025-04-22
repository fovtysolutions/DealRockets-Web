@extends('layouts.back-end.app')

@section('title', translate('View_Quotation'))

@push('css_or_js')
    <link href="{{ dynamicAsset('public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset('public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset('public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
            <h2 class="h1 mb-0 d-flex gap-2">
                <img src="{{ dynamicAsset('public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
                {{ translate('View_Quotation') }}
            </h2>
        </div>

        <!-- Quotation Details Card -->
        <div class="card">
            <div class="card-body">
                <h4>{{ translate('Quotation_Details') }}</h4>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>{{ translate('Quotation Name') }}:</strong> {{ $quotations->name ?? translate('N/A') }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>{{ translate('Quantity Required') }}:</strong> {{ $quotations->quantity ?? translate('N/A') }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>{{ translate('Description') }}:</strong> {{ $quotations->description ?? translate('N/A') }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>{{ translate('Email') }}:</strong> {{ $quotations->email ?? translate('N/A') }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>{{ translate('Phone Number') }}:</strong> {{ $quotations->pnumber ?? translate('N/A') }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>{{ translate('Role') }}:</strong> {{ $quotations->role ?? translate('N/A') }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>{{ translate('Type') }}:</strong> {{ $quotations->type ?? translate('N/A') }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>{{ translate('Country') }}:</strong> {{ $quotations->country ?? translate('N/A') }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>{{ translate('Shipping Method') }}:</strong> {{ $quotations->shipping_method ?? translate('N/A') }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>{{ translate('Destination Port') }}:</strong> {{ $quotations->destination_port ?? translate('N/A') }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>{{ translate('Target Unit Price') }}:</strong> {{ $quotations->target_unit_price ?? translate('N/A') }} {{ $quotations->target_unit_price_currency ?? '' }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>{{ translate('Max Budget') }}:</strong> {{ $quotations->max_budget ?? translate('N/A') }} {{ $quotations->max_budget_currency ?? '' }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>{{ translate('Terms') }}:</strong> {{ $quotations->terms ?? translate('N/A') }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>{{ translate('Image') }}:</strong>
                        @if ($quotations->image)
                            <img src="{{ asset($quotations->image) }}" alt="Quotation Image" style="max-width: 200px;">
                        @else
                            {{ translate('No Image Available') }}
                        @endif
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>{{ translate('Created At') }}:</strong> {{ $quotations->created_at->format('d M Y, h:i A') ?? translate('N/A') }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>{{ translate('Updated At') }}:</strong> {{ $quotations->updated_at->format('d M Y, h:i A') ?? translate('N/A') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row justify-content-end gap-3 mt-3 mx-1">
            {{-- <a href="{{ route('admin.quotation.edit', $quotations->id) }}" class="btn btn--primary px-5">{{ translate('Edit') }}</a> --}}
            <a href="{{ route('admin.quotation.list') }}" class="btn btn-secondary px-5">{{ translate('Back to List') }}</a>
        </div>
    </div>
@endsection
