@extends('layouts.back-end.app-partialseller')

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
        <div class="row mb-3">
                <div class="col">
                    <label for="product" class="form-label">Category</label>
                    <select name="industry" id="industry" class="form-control">
                        <option value="value" selected>Select a Industry</option>
                        @foreach ($industry as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="name" class="title-color">{{ translate('sub_Category') }}</label>
                        <select class="js-select2-custom form-control action-get-request-onchange" name="sub_category_id"
                            id="sub-category-select"
                            data-url-prefix="{{ route('vendor.products.get-categories') . '?parent_id=' }}"
                            data-element-id="sub-sub-category-select" data-element-type="select">
                            <option value="{{ null }}" selected disabled>
                                {{ translate('select_Sub_Category') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter name"
                        required>
                </div>
                <div class="col">
                    <label for="hs_code" class="form-label">HS Code</label>
                    <input type="text" name="hs_code" id="hs_code" class="form-control" placeholder="Enter HS Code"
                        required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="imagePicker">Choose Images</label>
                    <div class="multi-image-picker">
                        <input type="file" id="imagePicker" name="images[]" multiple />
                    </div>
                </div>
                <div class="col">
                    <label for="product" class="form-label">Country</label>
                    <select name="country" id="country" class="form-control">
                        <option value="value" selected>Select a Country</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="stock_type" class="form-label">Stock Type</label>
                    <select name="stock_type" id="stock_type" class="form-control">
                        <option value="" selected>Select a Category</option>
                        @foreach ($categories as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="rate" class="form-label">Rate</label>
                    <input type="number" name="rate" id="rate" class="form-control" placeholder="Enter Rate"
                        required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="local_currency" class="form-label">Local Currency</label>
                    <input type="text" name="local_currency" id="local_currency" class="form-control"
                        placeholder="Enter Local Currency" required>
                </div>
                <div class="col">
                    <label class="title-color">{{ translate('Delivery Terms') }}</label>
                    <select class="form-control" name="delivery_terms">
                        <option value="CFR" {{ old('delivery_terms') == 'CFR' ? 'selected' : '' }}>CFR</option>
                        <option value="FOB" {{ old('delivery_terms') == 'FOB' ? 'selected' : '' }}>FOB</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">{{ translate('Place of Loading') }}</label>
                    <input type="text" class="form-control" name="place_of_loading"
                        placeholder="e.g., Shanghai, Ningbo">
                </div>
                <div class="col">
                    <label class="form-label">{{ translate('Port of Loading') }}</label>
                    <select class="form-control" name="port_of_loading">
                        <option value="Factory" {{ old('port_of_loading') == 'Factory' ? 'selected' : '' }}>Factory
                        </option>
                        <option value="Sea_Port" {{ old('port_of_loading') == 'Sea_Port' ? 'selected' : '' }}>Sea
                            Port</option>
                        <option value="ICD" {{ old('port_of_loading') == 'ICD' ? 'selected' : '' }}>ICD</option>
                        <option value="Air_Port" {{ old('port_of_loading') == 'Air_Port' ? 'selected' : '' }}>Air
                            Port</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">{{ translate('Packing Type') }}</label>
                    <select class="form-control" name="packing_type">
                        <option value="">Select Packing Type</option>
                        <option value="PP Bag" {{ old('packing_type') == 'PP Bag' ? 'selected' : '' }}>PP Bag
                        </option>
                        <option value="Carton" {{ old('packing_type') == 'Carton' ? 'selected' : '' }}>Carton
                        </option>
                        <option value="Plastic Drum" {{ old('packing_type') == 'Plastic Drum' ? 'selected' : '' }}>
                            Plastic Drum</option>
                        <option value="Steel Drum" {{ old('packing_type') == 'Steel Drum' ? 'selected' : '' }}>Steel
                            Drum</option>
                        <option value="Wooden Crate" {{ old('packing_type') == 'Wooden Crate' ? 'selected' : '' }}>
                            Wooden Crate</option>
                        <option value="Bulk" {{ old('packing_type') == 'Bulk' ? 'selected' : '' }}>Bulk</option>
                        <option value="IBC Tank" {{ old('packing_type') == 'IBC Tank' ? 'selected' : '' }}>IBC Tank
                        </option>
                        <option value="Plastic Container"
                            {{ old('packing_type') == 'Plastic Container' ? 'selected' : '' }}>Plastic Container
                        </option>
                        <option value="Custom Packaging"
                            {{ old('packing_type') == 'Custom Packaging' ? 'selected' : '' }}>Custom Packaging
                        </option>
                    </select>
                </div>

                <div class="col">
                    <label class="form-label">{{ translate('Size') }}</label>
                    <input type="text" class="form-control" name="weight_per_unit" placeholder="e.g., 1.5kg">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-lg-4" style="padding-bottom:15px;">
                    <label class="form-label">{{ translate('Internal Packing') }}</label>
                    <input type="text" class="form-control" name="dimensions_per_unit" placeholder="e.g., 10x5x2 cm">
                </div>
                <div class="col">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-control" placeholder="Enter description" rows="5"></textarea>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12" style="padding-bottom: 15px;">
                    <label class="form-label">{{ translate('Standard Specification') }}</label>
                    <div id="dynamic-data-box">
                        {{-- Title Groups Go Here --}}
                    </div>
                    <button type="button" class="btn btn-primary mt-2" id="add-title-group">Add Title</button>
                </div>
                <div class="col-12" style="padding-bottom: 15px;">
                    <label class="form-label">{{ translate('Technical Specification') }}</label>
                    <div id="dynamic-data-box-technical">
                        {{-- Title Groups Go Here --}}
                    </div>
                    <button type="button" class="btn btn-primary mt-2" id="add-title-group-technical">Add
                        Title</button>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label class="form-lable">Certificate</label>
                    <input class="form-control" type="file" name="certificate" id="certificate">
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
                    <input type="number" name="quantity" id="quantity" class="form-control"
                        placeholder="Enter quantity" required>
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
            <!-- Company Details -->
            <div class="row mb-3">
                <div class="col">
                    <label for="company_name" class="form-label">Company Name</label>
                    <input type="text" name="company_name" id="company_name" class="form-control"
                        placeholder="Enter Company Name" required>
                </div>
                <div class="col">
                    <label for="company_address" class="form-label">Company Address</label>
                    <input type="text" name="company_address" id="company_address" class="form-control"
                        placeholder="Enter Company Address" required>
                </div>
                <div class="col">
                    <label for="company_icon" class="form-label">Company Icon</label>
                    <input type="file" name="company_icon" id="company_icon" class="form-control"
                        placeholder="Enter Company Icon" required>
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
                    <input type="text" name="upper_limit" id="upper_limit" class="form-control"
                        placeholder="Enter Upper Limit">
                </div>
                <div class="col">
                    <label for="lower_limit" class="form-label">Lower Limit</label>
                    <input type="text" name="lower_limit" id="lower_limit" class="form-control"
                        placeholder="Enter Lower Limit">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="city" class="form-label">City</label>
                    <input type="text" name="city" id="city" class="form-control" placeholder="Enter City">
                </div>
                <div class="col">
                    <label for="product_type" class="form-label">Product Type</label>
                    <input type="text" name="product_type" id="product_type" class="form-control"
                        placeholder="Enter Product Type">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="origin" class="form-label">Origin</label>
                    <input type="text" name="origin" id="origin" class="form-control"
                        placeholder="Enter Origin">
                </div>
                <div class="col">
                    <label for="badge" class="form-label">Badge</label>
                    <input type="text" name="badge" id="badge" class="form-control" placeholder="Enter Badge">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="refundable" class="form-label">Refundable</label>
                    <input type="text" name="refundable" id="refundable" class="form-control"
                        placeholder="Is Refundable? (Yes/No)">
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
        $(document).ready(function() {
            // Initialize the Spartan Multi Image Picker
            $('#imagePicker').spartanMultiImagePicker({
                fieldName: 'images[]', // Use images[] to support multiple file uploads
                maxFileCount: 5, // Max number of images
                rowHeight: '100px', // Set row height for images
                groupClassName: 'col-6', // Set class for image group (optional)
                maxFileSize: 3, // Max file size (optional)
                allowedExt: ['jpg', 'jpeg', 'png', 'gif'] // Allowed file types
            });
        });
    </script>
    <script>
        let titleCount = 0;

        function getTitleGroupHtml(titleIndex) {
            return `
        <div class="title-group border p-3 mb-3">
            <div class="mb-2 d-flex justify-content-between align-items-center gap-3">
                <input type="text" name="dynamic_data[${titleIndex}][title]" class="form-control me-2" placeholder="Title">
                <button type="button" class="btn btn-danger btn-sm remove-title-group">Remove</button>
            </div>
            <div class="sub-heads" data-title-index="${titleIndex}">
                ${getSubHeadRowHtml(titleIndex, 0)}
            </div>
            <button type="button" class="btn btn-secondary btn-sm mt-2 add-sub-head" data-title-index="${titleIndex}">Add Sub Head</button>
        </div>
        `;
        }

        function getSubHeadRowHtml(titleIndex, subIndex) {
            return `
        <div class="row mb-2 sub-head-row">
            <div class="col-md-5">
                <input type="text" name="dynamic_data[${titleIndex}][sub_heads][${subIndex}][sub_head]" class="form-control" placeholder="Sub Head">
            </div>
            <div class="col-md-5">
                <input type="text" name="dynamic_data[${titleIndex}][sub_heads][${subIndex}][sub_head_data]" class="form-control" placeholder="Sub Head Data">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm remove-sub-head">Remove</button>
            </div>
        </div>`;
        }

        document.getElementById('add-title-group').addEventListener('click', function() {
            const container = document.getElementById('dynamic-data-box');
            container.insertAdjacentHTML('beforeend', getTitleGroupHtml(titleCount));
            titleCount++;
        });

        document.addEventListener('click', function(e) {
            // Remove entire title group
            if (e.target.classList.contains('remove-title-group')) {
                e.target.closest('.title-group').remove();
            }

            // Add sub head
            if (e.target.classList.contains('add-sub-head')) {
                const titleIndex = e.target.getAttribute('data-title-index');
                const subHeadsContainer = e.target.previousElementSibling;
                const subIndex = subHeadsContainer.querySelectorAll('.sub-head-row').length;
                subHeadsContainer.insertAdjacentHTML('beforeend', getSubHeadRowHtml(titleIndex, subIndex));
            }

            // Remove individual sub head
            if (e.target.classList.contains('remove-sub-head')) {
                e.target.closest('.sub-head-row').remove();
            }
        });
    </script>
    <script>
        let titleCountTechnical = 0;

        function getTitleGroupHtmlTechnical(titleIndex) {
            return `
        <div class="title-group border p-3 mb-3">
            <div class="mb-2 d-flex justify-content-between align-items-center gap-3">
                <input type="text" name="dynamic_data_technical[${titleIndex}][title]" class="form-control me-2" placeholder="Title">
                <button type="button" class="btn btn-danger btn-sm remove-title-group">Remove</button>
            </div>
            <div class="sub-heads" data-title-index="${titleIndex}">
                ${getSubHeadRowHtmlTechnical(titleIndex, 0)}
            </div>
            <button type="button" class="btn btn-secondary btn-sm mt-2 add-sub-head" data-title-index="${titleIndex}">Add Sub Head</button>
        </div>
        `;
        }

        function getSubHeadRowHtmlTechnical(titleIndex, subIndex) {
            return `
        <div class="row mb-2 sub-head-row">
            <div class="col-md-5">
                <input type="text" name="dynamic_data_technical[${titleIndex}][sub_heads][${subIndex}][sub_head]" class="form-control" placeholder="Sub Head">
            </div>
            <div class="col-md-5">
                <input type="text" name="dynamic_data_technical[${titleIndex}][sub_heads][${subIndex}][sub_head_data]" class="form-control" placeholder="Sub Head Data">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm remove-sub-head">Remove</button>
            </div>
        </div>`;
        }

        document.getElementById('add-title-group-technical').addEventListener('click', function() {
            const container = document.getElementById('dynamic-data-box-technical');
            container.insertAdjacentHTML('beforeend', getTitleGroupHtmlTechnical(titleCountTechnical));
            titleCountTechnical++;
        });

        document.addEventListener('click', function(e) {
            // Remove entire title group
            if (e.target.classList.contains('remove-title-group')) {
                e.target.closest('.title-group').remove();
            }

            // Add sub head
            if (e.target.classList.contains('add-sub-head')) {
                const titleIndex = e.target.getAttribute('data-title-index');
                const subHeadsContainer = e.target.previousElementSibling;
                const subIndex = subHeadsContainer.querySelectorAll('.sub-head-row').length;
                subHeadsContainer.insertAdjacentHTML('beforeend', getSubHeadRowHtmlTechnical(titleIndex, subIndex));
            }

            // Remove individual sub head
            if (e.target.classList.contains('remove-sub-head')) {
                e.target.closest('.sub-head-row').remove();
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#industry').on('change', function() {
                var parentId = $(this).val();
                var urlPrefix = $('#sub-category-select').data('url-prefix');
                var targetSelect = $('#sub-category-select');

                if (parentId) {
                    $.ajax({
                        url: urlPrefix + parentId,
                        type: 'GET',
                        success: function(response) {
                            // Insert HTML directly into the <select>
                            if (response.select_tag) {
                                targetSelect.html(response.select_tag);
                            } else {
                                console.warn('Missing select_tag in response.');
                            }
                        },
                        error: function() {
                            alert('Failed to load sub categories.');
                        }
                    });
                } else {
                    targetSelect.html('<option value="" disabled selected>Select Sub Category</option>');
                }
            });
        });
    </script>
@endsection