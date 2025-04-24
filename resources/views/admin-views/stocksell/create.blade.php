@extends('layouts.back-end.app')

@section('title', translate('Create_Stock'))

@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Create Stock for Sale</h2>
    <form action="{{ route('admin.stock.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- First Row -->
        <div class="row mb-3">
            <div class="col">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter name" required>
            </div>
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
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control" placeholder="Enter description" rows="5"></textarea>
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
        <div class="row mb-3">
            <div class="col">
                <label for="compliance_status" class="form-label">Compliance Status</label>
                <select name="compliance_status" id="compliance_status" class="form-control">
                    <option value="pending" selected>Pending</option>
                    <option value="approved">Approved</option>
                    <option value="flagged">Flagged</option>
                </select>
            </div>
            <div class="col">
                <label for="unit" class="form-label">Unit</label>
                <input type="text" name="unit" id="unit" class="form-control" placeholder="Enter Unit">
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col">
                <label for="upper_limit" class="form-label">Upper Limit</label>
                <input type="text" name="upper_limit" id="upper_limit" class="form-control" placeholder="Enter Upper Limit">
            </div>
            <div class="col">
                <label for="lower_limit" class="form-label">Lower Limit</label>
                <input type="text" name="lower_limit" id="lower_limit" class="form-control" placeholder="Enter Lower Limit">
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col">
                <label for="city" class="form-label">City</label>
                <input type="text" name="city" id="city" class="form-control" placeholder="Enter City">
            </div>
            <div class="col">
                <label for="stock_type" class="form-label">Stock Type</label>
                <input type="text" name="stock_type" id="stock_type" class="form-control" placeholder="Enter Stock Type">
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col">
                <label for="product_type" class="form-label">Product Type</label>
                <input type="text" name="product_type" id="product_type" class="form-control" placeholder="Enter Product Type">
            </div>
            <div class="col">
                <label for="origin" class="form-label">Origin</label>
                <input type="text" name="origin" id="origin" class="form-control" placeholder="Enter Origin">
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col">
                <label for="badge" class="form-label">Badge</label>
                <input type="text" name="badge" id="badge" class="form-control" placeholder="Enter Badge">
            </div>
            <div class="col">
                <label for="refundable" class="form-label">Refundable</label>
                <input type="text" name="refundable" id="refundable" class="form-control" placeholder="Is Refundable? (Yes/No)">
            </div>
        </div>
        
        <!-- Submit Button -->
        <div class="row mb-3">
            <div class="col text-end">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/tags-input.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .then(editor => {
                console.log('Editor initialized');
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        $(document).ready(function () {
            // Initialize the Spartan Multi Image Picker
            $('#imagePicker').spartanMultiImagePicker({
                fieldName: 'images[]',    // Use images[] to support multiple file uploads
                maxFileCount: 5,         // Max number of images
                rowHeight: '100px',      // Set row height for images
                groupClassName: 'col-6', // Set class for image group (optional)
                maxFileSize: 3,          // Max file size (optional)
                allowedExt: ['jpg', 'jpeg', 'png', 'gif'] // Allowed file types
            });
        });
    </script>
@endpush