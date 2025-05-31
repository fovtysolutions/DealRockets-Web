@extends('layouts.back-end.app')

@section('title', translate('Edit_Stock'))

@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Edit Stock for Sale</h2>
        <form action="{{ route('admin.stock.update', ['id' => $stocksell->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <div class="col">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" value="{{ $stocksell->name }}" name="name" id="name" class="form-control"
                        placeholder="Enter name" required>
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
                    <input type="number" value="{{ $stocksell->quantity }}" name="quantity" id="quantity"
                        class="form-control" placeholder="Enter quantity" required>
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
                    <textarea id="description" name="description" class="form-control" placeholder="Enter description" rows="5">{{ $stocksell->description }}</textarea>
                </div>
            </div>
            <!-- Country and Industry -->
            <div class="row mb-3">
                <div class="col">
                    <label for="product" class="form-label">Country</label>
                    <select name="country" id="country" class="form-control">
                        <option value="{{ $stocksell->country }}" selected>
                            {{ \App\Utils\ChatManager::getCountryDetails($stocksell->country)['countryName'] ?? 'Select a Country' }}
                        </option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="product" class="form-label">Industry</label>
                    <select name="industry" id="industry" class="form-control">
                        <option value="{{ $stocksell->industry }}" selected>
                            {{ \App\Models\Category::where('id', $stocksell->industry)->first()->name }}
                        </option>
                        @foreach ($industry as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- Company Details -->
            <div class="row mb-3">
                <div class="col">
                    <label for="company_name" class="form-label">Company Name</label>
                    <input type="text" value="{{ $stocksell->company_name }}" name="company_name" id="company_name"
                        class="form-control" placeholder="Enter Company Name" required>
                </div>
                <div class="col">
                    <label for="company_address" class="form-label">Company Address</label>
                    <input type="text" value="{{ $stocksell->company_address }}" name="company_address"
                        id="company_address" class="form-control" placeholder="Enter Company Address" required>
                </div>
                <div class="col">
                    <label for="company_icon" class="form-label">Company Icon</label>
                    <input type="file" name="company_icon" id="company_icon" class="form-control"
                        placeholder="Enter Company Icon" required>
                    Current Image:
                    <img src="/{{ $stocksell->company_icon }}" alt="Company Icon"
                        style="width: 100px; height: 100px; object-fit: cover;">
                </div>
            </div>
            <!-- Add Images -->
            <div class="row mb-3">
                <div class="col">
                    <label for="images" class="form-label">Product Images</label>
                    <div class="existing-images">
                        @if ($stocksell->image) <!-- Check if images exist -->
                            @foreach (json_decode($stocksell->image) as $image)
                                <div class="image-preview">
                                    <img src="/{{ $image }}" alt="Product Image"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                    <input type="checkbox" name="remove_images[]" value="{{ $image }}"> Remove
                                </div>
                            @endforeach
                        @else
                            <p>No images uploaded yet.</p>
                        @endif
                    </div>
                </div>
            </div>
            <!-- File input for new images -->
            <div class="row mb-3">
                <div class="col">
                    <label for="new_images" class="form-label">Upload New Images</label>
                    <input type="file" name="images[]" id="new_images" class="form-control" accept="image/*"
                        multiple>
                    <small class="text-muted">You can upload multiple images. If there are existing images, you can also
                        remove them.</small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="compliance_status" class="form-label">Compliance Status</label>
                    <select name="compliance_status" id="compliance_status" class="form-control">
                        <option value="pending" @selected($stocksell->compliance_status == 'pending')>Pending</option>
                        <option value="approved" @selected($stocksell->compliance_status == 'approved')>Approved</option>
                        <option value="flagged" @selected($stocksell->compliance_status == 'flagged')>Flagged</option>
                    </select>
                </div>
                <div class="col">
                    <label for="unit" class="form-label">Unit</label>
                    <input type="text" value="{{ $stocksell->unit }}" name="unit" id="unit"
                        class="form-control" placeholder="Enter Unit">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="upper_limit" class="form-label">Upper Limit</label>
                    <input type="text" name="upper_limit" value="{{ $stocksell->upper_limit }}" id="upper_limit"
                        class="form-control" placeholder="Enter Upper Limit">
                </div>
                <div class="col">
                    <label for="lower_limit" class="form-label">Lower Limit</label>
                    <input type="text" name="lower_limit" value="{{ $stocksell->lower_limit }}" id="lower_limit"
                        class="form-control" placeholder="Enter Lower Limit">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="city" class="form-label">City</label>
                    <input type="text" name="city" id="city" class="form-control"
                        value="{{ $stocksell->city }}" placeholder="Enter City">
                </div>
                <div class="col">
                    <label for="stock_type" class="form-label">Stock Type</label>
                    <select name="stock_type" id="stock_type" class="form-control">
                        <option value="" disabled>Select a Category</option>
                        @php
                            $selectedCategory = \App\Models\StockCategory::find($stocksell->stock_type);
                        @endphp

                        @if ($selectedCategory)
                            <option value="{{ $selectedCategory->id }}" selected>{{ $selectedCategory->name }}</option>
                        @endif

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="product_type" class="form-label">Product Type</label>
                    <input type="text" value="{{ $stocksell->product_type }}" name="product_type" id="product_type"
                        class="form-control" placeholder="Enter Product Type">
                </div>
                <div class="col">
                    <label for="origin" class="form-label">Origin</label>
                    <input type="text" value="{{ $stocksell->origin }}" name="origin" id="origin"
                        class="form-control" placeholder="Enter Origin">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="badge" class="form-label">Badge</label>
                    <input type="text" value="{{ $stocksell->badge }}" name="badge" id="badge"
                        class="form-control" placeholder="Enter Badge">
                </div>
                <div class="col">
                    <label for="refundable" class="form-label">Refundable</label>
                    <input type="text" value="{{ $stocksell->refundable }}" name="refundable" id="refundable"
                        class="form-control" placeholder="Is Refundable? (Yes/No)">
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
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/tags-input.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.js') }}"></script>
@endpush
