@extends('layouts.back-end.app')

@section('title', translate('View_Supplier'))

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
                {{ translate('View_Supplier') }}
            </h2>
        </div>

        <div class="card">
            <div class="card-body">
                <h4>{{ translate('Supplier_Details') }}</h4>

                <div class="mb-3">
                    <strong>{{ translate('Supplier Name') }}:</strong> {{ $supplier->name }}
                </div>

                <div class="mb-3">
                    <strong>{{ translate('Business Type') }}:</strong> 
                    {{ $supplier->business_type ?? 'N/A' }}
                </div>

                <div class="mb-3">
                    <strong>{{ translate('Main Products') }}:</strong> {{ $supplier->main_products }}
                </div>

                <div class="mb-3">
                    <strong>{{ translate('Management Certification') }}:</strong> {{ $supplier->management_certification }}
                </div>

                <div class="mb-3">
                    <strong>{{ translate('City/Province') }}:</strong> {{ $supplier->city_province }}
                </div>

                <div class="mb-3">
                    <strong>{{ translate('Images') }}:</strong>
                    <div class="d-flex flex-wrap">
                        @for ($i = 1; $i <= 3; $i++)
                            @if ($supplier->{'image' . $i})
                                <div class="me-3 mb-3">
                                    <img style="width: 150px; height: 150px;" src="{{ asset('/storage/' . $supplier->{'image' . $i}) }}" class="img-thumbnail" alt="Image {{ $i }}">
                                </div>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-end gap-3 mt-3 mx-1">
            <a href="{{ route('admin.suppliers.edit', $supplier->id) }}" class="btn btn--primary px-5">{{ translate('Edit') }}</a>
            <a href="{{ route('admin.suppliers.list') }}" class="btn btn-secondary px-5">{{ translate('Back to List') }}</a>
        </div>
    </div>
@endsection
