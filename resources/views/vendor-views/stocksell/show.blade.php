@extends('layouts.back-end.app-partialseller')

@section('title', translate('Stock_Show'))

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
        </div>
        <!-- Third Row -->
        <div class="row mb-3">
            <div class="col">
                <label for="product" class="form-label">Product</label>
                <input type="text" value="{{ $name }}" name="product_id" id="product_id" class="form-control" placeholder="No Data" readonly required>
            </div>
        </div>
        <!-- Submit Button -->
        <div class="row">
            <div class="col text-end">
                <a href="{{ route('vendor.stock.index')}}" class="btn btn-primary">Back to List</a>
            </div>
        </div>
</div>
@endsection
