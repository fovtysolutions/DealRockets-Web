@extends('layouts.back-end.app')

@section('title', translate('View Tradeshow'))

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
                {{ translate('View Tradeshow') }}
            </h2>
        </div>

        <div class="card">
            <div class="card-body">
                <h4>{{ translate('Tradeshow Details') }}</h4>
                <div class="mb-3">
                    <strong>{{ translate('Tradeshow Name') }}:</strong> {{ $tradeshow->name }}
                </div>

                <div class="mb-3">
                    <strong>{{ translate('Country') }}:</strong> {{ \App\Utils\ChatManager::getCountryDetails($tradeshow->country)['countryName'] ?? 'N/A' }}
                </div>

                <div class="mb-3">
                    <strong>{{ translate('Company Name') }}:</strong> {{ $tradeshow->company_name }}
                </div>

                <div class="mb-3">
                    <strong>{{ translate('Description') }}:</strong> {{ $tradeshow->description }}
                </div>
                
                <div class="mb-3">
                    <strong>{{ translate('Industry') }}:</strong> {{ \App\Models\TradeCategory::where('id',$tradeshow->industry)->first()->name }}
                </div>

                <div class="mb-3">
                    <strong>{{ translate('Start Date') }}:</strong> {{ $tradeshow->start_date }}
                </div>

                <div class="mb-3">
                    <strong>{{ translate('End Date') }}:</strong> {{ $tradeshow->end_date }}
                </div>
            </div>
        </div>

        <div class="row justify-content-end gap-3 mt-3 mx-1 my-3">
            <a href="{{ route('admin.tradeshow.edit', $tradeshow->id) }}" class="btn btn--primary px-5">{{ translate('Edit') }}</a>
            <a href="{{ route('admin.tradeshow.list') }}" class="btn btn-secondary px-5">{{ translate('Back to List') }}</a>
        </div>
    </div>
@endsection
