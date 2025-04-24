@extends('layouts.back-end.app')

@section('title', translate('Show_Stock'))

@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Show Stock for Sale</h2>
        <!-- Basic Info -->
<div class="card mb-4">
    <div class="card-header">Basic Information</div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <strong>Name:</strong>
                <p class="mb-0">{{ $stocksell->name }}</p>
            </div>
            <div class="col-md-4">
                <strong>Quantity:</strong>
                <p class="mb-0">{{ $stocksell->quantity }}</p>
            </div>
            <div class="col-md-4">
                <strong>Unit:</strong>
                <p class="mb-0">{{ $stocksell->unit ?? 'N/A' }}</p>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <strong>Status:</strong>
                <p class="mb-0">{{ $stocksell->status }}</p>
            </div>
            <div class="col-md-4">
                <strong>Stock Type:</strong>
                <p class="mb-0">{{ $stocksell->stock_type ?? 'N/A' }}</p>
            </div>
            <div class="col-md-4">
                <strong>Product:</strong>
                <p class="mb-0">{{ $name }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Classification -->
<div class="card mb-4">
    <div class="card-header">Classification</div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <strong>Industry:</strong>
                <p class="mb-0">{{ \App\Models\StockCategory::find($stocksell->industry)?->name ?? 'N/A' }}</p>
            </div>
            <div class="col-md-4">
                <strong>Product Type:</strong>
                <p class="mb-0">{{ $stocksell->product_type ?? 'N/A' }}</p>
            </div>
            <div class="col-md-4">
                <strong>Origin:</strong>
                <p class="mb-0">{{ $stocksell->origin ?? 'N/A' }}</p>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <strong>Badge:</strong>
                <p class="mb-0">{{ $stocksell->badge ?? 'N/A' }}</p>
            </div>
            <div class="col-md-4">
                <strong>Refundable:</strong>
                <p class="mb-0">{{ $stocksell->refundable ?? 'N/A' }}</p>
            </div>
            <div class="col-md-4">
                <strong>Compliance Status:</strong>
                <p class="mb-0">{{ ucfirst($stocksell->compliance_status) ?? 'Pending' }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Location -->
<div class="card mb-4">
    <div class="card-header">Location</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <strong>City:</strong>
                <p class="mb-0">{{ $stocksell->city ?? 'N/A' }}</p>
            </div>
            <div class="col-md-6">
                <strong>Country:</strong>
                <p class="mb-0">{{ \App\Models\Country::find($stocksell->country)?->name ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Company Info -->
<div class="card mb-4">
    <div class="card-header">Company Information</div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <strong>Company Name:</strong>
                <p class="mb-0">{{ $stocksell->company_name }}</p>
            </div>
            <div class="col-md-4">
                <strong>Company Address:</strong>
                <p class="mb-0">{{ $stocksell->company_address }}</p>
            </div>
            <div class="col-md-4">
                <strong>Company Icon:</strong><br>
                <img src="/{{ $stocksell->company_icon }}" alt="Company Icon" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
            </div>
        </div>
    </div>
</div>

<!-- Description -->
<div class="card mb-4">
    <div class="card-header">Description</div>
    <div class="card-body">
        <div class="border p-3 bg-light rounded">
            {!! $stocksell->description !!}
        </div>
    </div>
</div>

<!-- Product Images -->
<div class="card mb-4">
    <div class="card-header">Product Images</div>
    <div class="card-body">
        @if ($stocksell->image)
            <div class="d-flex flex-wrap gap-2">
                @foreach (json_decode($stocksell->image) as $image)
                    <img src="/{{ $image }}" alt="Image" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                @endforeach
            </div>
        @else
            <p>No images uploaded.</p>
        @endif
    </div>
</div>
        <!-- Submit Button -->
        <div class="row">
            <div class="col text-end">
                <a href="{{ route('admin.stock.index')}}" class="btn btn-primary">Back to List</a>
            </div>
        </div>
</div>
@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/tags-input.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.js') }}"></script>
@endpush
