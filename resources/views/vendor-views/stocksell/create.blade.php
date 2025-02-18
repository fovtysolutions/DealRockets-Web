@extends('layouts.back-end.app-seller')

@section('title', translate('Stock_Create'))

@push('css_or_js')
<link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
<link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Create Stock for Sale</h2>
    <form action="{{ route('vendor.stock.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- First Row -->
        <div class="row mb-3">
            <div class="col">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter name" required>
            </div>
            <div class="col">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control" placeholder="Enter description"
                    rows="3" required></textarea>
            </div>
        </div>
        <!-- Second Row -->
        <div class="row mb-3">
            <div class="col">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Enter quantity"
                    required>
            </div>
            <div class="col">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-control" required>
                    <option selected disabled value="">Select an option</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
        </div>
        <!-- Third Row -->
        <div class="row mb-3">
            <div class="col">
                <label for="product" class="form-label">Product</label>
                <select id="product" name="product_id" class="form-control" required>
                    <option selected value="">Select a product</option>
                    <!-- Add dynamic product options here -->
                    @foreach ($items as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <!-- Country and Industry -->
        <div class="row mb-3">
            <div class="col">
                <label for="product" class="form-label">Country</label>
                <select name="country" id="country" class="form-control">
                    <option value="value" selected>Select a Country</option>
                    @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <label for="product" class="form-label">Industry</label>
                <select name="industry" id="industry" class="form-control">
                    <option value="value" selected>Select a Industry</option>
                    @foreach($categories as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <!-- Company Details -->
        <div class="row mb-3">
            <div class="col">
                <label for="company_name" class="form-label">Company Name</label>
                <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Enter Company Name"
                    required>
            </div>
            <div class="col">
                <label for="company_address" class="form-label">Company Address</label>
                <input type="text" name="company_address" id="company_address" class="form-control" placeholder="Enter Company Address"
                    required>
            </div>
            <div class="col">
                <label for="company_icon" class="form-label">Company Icon</label>
                <input type="file" name="company_icon" id="company_icon" class="form-control" placeholder="Enter Company Icon"
                    required>
            </div>
        </div>
        <!-- Add Images -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="imagePicker">Choose Images</label>
                <div class="multi-image-picker">
                    <input type="file" id="imagePicker" name="images[]" multiple />
                </div>
            </div>
        </div>
        <!-- Submit Button -->
        <div class="row">
            <div class="col text-end">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </div>
    </form>
</div>
@endsection