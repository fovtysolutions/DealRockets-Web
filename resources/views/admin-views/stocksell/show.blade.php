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
        <!-- First Row -->
        <div class="row mb-3">
            <div class="col">
                <label for="name" class="form-label">Name</label>
                <input type="text" value="{{$stocksell->name}}" name="name" id="name" class="form-control" placeholder="No Data" required readonly>
            </div>
            <div class="col">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control" placeholder="No Data" rows="3" readonly required>{{$stocksell->description}}</textarea>
            </div>
        </div>
        <!-- Second Row -->
        <div class="row mb-3">
            <div class="col">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" value="{{$stocksell->quantity}}" name="quantity" id="quantity" class="form-control" placeholder="No Data" readonly required>
            </div>
            <div class="col">
                <label for="status" class="form-label">Status</label>
                <input type="text" value="{{$stocksell->status}}" name="status" id="status" class="form-control" placeholder="No Data" readonly required>
            </div>
            <div class="col">
                <label for="industry" class="form-label">Industry</label>
                <input type="text" value="{{ \App\Models\StockCategory::where('id',$stocksell->industry)->first()->name }}" name="industry" id="industry" class="form-control" placeholder="No Data" readonly required>
            </div>
        </div>
        <!-- Third Row -->
        <div class="row mb-3">
            <div class="col">
                <label for="product" class="form-label">Product</label>
                <input type="text" value="{{ $name }}" name="product_id" id="product_id" class="form-control" placeholder="No Data" readonly required>
            </div>
        </div>
        <!-- Fourth Row -->
        <div class="row mb-3">
            <div class="col">
                <label for="company_name" class="form-label">Company Name</label>
                <input type="text" name="company_name" id="company_name" class="form-control" value="{{ $stocksell->company_name}}" placeholder="Enter Company Name"  readonly required
                    required>
            </div>
            <div class="col">
                <label for="company_address" class="form-label">Company Address</label>
                <input type="text" name="company_address" id="company_address" class="form-control" value="{{ $stocksell->company_address}}" placeholder="Enter Company Address"  readonly required
                    required>
            </div>
            <div class="col">
                <label for="company_icon" class="form-label">Company Icon</label>
                <img src="/{{$stocksell->company_icon}}" alt="Company Icon" style="width: 100px; height: 100px; object-fit: cover;">
            </div>
        </div>
        <!-- Display Existing Images -->
        <div class="row mb-3">
            <div class="col">
                <label for="images" class="form-label">Product Images</label>
                <div class="existing-images">
                    @if ($stocksell->image) <!-- Check if images exist -->
                        @foreach (json_decode($stocksell->image) as $image)
                            <div class="image-preview">
                                <img src="/{{$image}}" alt="Product Image"
                                    style="width: 100px; height: 100px; object-fit: cover;">
                            </div>
                        @endforeach
                    @else
                        <p>No images uploaded yet.</p>
                    @endif
                </div>
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
