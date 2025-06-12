<div class="progress-form-main">
    <div class="progress-container">
        <div class="step active">
            <div class="step-circle">1</div>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">2</div>
        </div>
    </div>
    <div class="form-header">
        <h1>Create Stock Sale</h1>
        <p>Fill in the required details to create Stock Sale</p>
    </div>
    <div class="step-section" data-step="1">
        <h4> Basic Information </h4>
        <div class="form-row">
            <div class="form-group">
                <label for="product" class="form-label">Category</label>
                <select name="industry" id="industry" class="form-control">
                    <option value="value" selected>Select a Industry</option>
                    @foreach ($industry as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
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
        <div class="form-row">
            <div class="form-group">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter name"
                    required>
            </div>
            <div class="form-group">
                <label for="hs_code" class="form-label">HS Code</label>
                <input type="text" name="hs_code" id="hs_code" class="form-control" placeholder="Enter HS Code"
                    required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="imagePicker">Choose Images</label>
                <input type="file" class="form-select" id="imagePicker" name="images[]" multiple />
            </div>
            <div class="form-group">
                <label for="product" class="form-label">Country</label>
                <select name="country" id="country" class="form-control">
                    <option value="value" selected>Select a Country</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="stock_type" class="form-label">Stock Type</label>
                <select name="stock_type" id="stock_type" class="form-control">
                    <option value="" selected>Select a Category</option>
                    @foreach ($categories as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="rate" class="form-label">Rate</label>
                <input type="number" name="rate" id="rate" class="form-control" placeholder="Enter Rate"
                    required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="local_currency" class="form-label">Local Currency</label>
                <input type="text" name="local_currency" id="local_currency" class="form-control"
                    placeholder="Enter Local Currency" required>
            </div>
            <div class="form-group">
                <label class="title-color">{{ translate('Delivery Terms') }}</label>
                <select class="form-control" name="delivery_terms">
                    <option value="CFR" {{ old('delivery_terms') == 'CFR' ? 'selected' : '' }}>CFR
                    </option>
                    <option value="FOB" {{ old('delivery_terms') == 'FOB' ? 'selected' : '' }}>FOB
                    </option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Place of Loading') }}</label>
                <input type="text" class="form-control" name="place_of_loading" placeholder="e.g., Shanghai, Ningbo">
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Port of Loading') }}</label>
                <select class="form-control" name="port_of_loading">
                    <option value="Factory" {{ old('port_of_loading') == 'Factory' ? 'selected' : '' }}>
                        Factory
                    </option>
                    <option value="Sea_Port" {{ old('port_of_loading') == 'Sea_Port' ? 'selected' : '' }}>
                        Sea
                        Port</option>
                    <option value="ICD" {{ old('port_of_loading') == 'ICD' ? 'selected' : '' }}>ICD
                    </option>
                    <option value="Air_Port" {{ old('port_of_loading') == 'Air_Port' ? 'selected' : '' }}>
                        Air
                        Port</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Packing Type') }}</label>
                <select class="form-control" name="packing_type">
                    <option value="">Select Packing Type</option>
                    <option value="PP Bag" {{ old('packing_type') == 'PP Bag' ? 'selected' : '' }}>PP
                        Bag
                    </option>
                    <option value="Carton" {{ old('packing_type') == 'Carton' ? 'selected' : '' }}>
                        Carton
                    </option>
                    <option value="Plastic Drum" {{ old('packing_type') == 'Plastic Drum' ? 'selected' : '' }}>
                        Plastic Drum</option>
                    <option value="Steel Drum" {{ old('packing_type') == 'Steel Drum' ? 'selected' : '' }}>
                        Steel
                        Drum</option>
                    <option value="Wooden Crate" {{ old('packing_type') == 'Wooden Crate' ? 'selected' : '' }}>
                        Wooden Crate</option>
                    <option value="Bulk" {{ old('packing_type') == 'Bulk' ? 'selected' : '' }}>Bulk
                    </option>
                    <option value="IBC Tank" {{ old('packing_type') == 'IBC Tank' ? 'selected' : '' }}>IBC
                        Tank
                    </option>
                    <option value="Plastic Container"
                        {{ old('packing_type') == 'Plastic Container' ? 'selected' : '' }}>Plastic
                        Container
                    </option>
                    <option value="Custom Packaging"
                        {{ old('packing_type') == 'Custom Packaging' ? 'selected' : '' }}>Custom
                        Packaging
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Size') }}</label>
                <input type="text" class="form-control" name="weight_per_unit" placeholder="e.g., 1.5kg">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Internal Packing') }}</label>
                <input type="text" class="form-control" name="dimensions_per_unit" placeholder="e.g., 10x5x2 cm">
            </div>
            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control" placeholder="Enter description" rows="1"></textarea>
            </div>
        </div>
        <div class="form-row">
            <div class="form-single">
                <label class="form-label">{{ translate('Standard Specification') }}</label>
                <div id="dynamic-data-box">
                    {{-- Title Groups Go Here --}}
                </div>
                <button type="button" class="btn btn-primary mt-2" id="add-title-group">Add
                    Title</button>
            </div>
        </div>
        <div class="form-row">
            <div class="form-single">
                <label class="form-label">{{ translate('Technical Specification') }}</label>
                <div id="dynamic-data-box-technical">
                    {{-- Title Groups Go Here --}}
                </div>
                <button type="button" class="btn btn-primary mt-2" id="add-title-group-technical">Add
                    Title</button>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Certificate</label>
                <input class="form-select" type="file" name="certificate" id="certificate">
            </div>
            <div class="form-group">
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
        <button type="button" class="next-btn" data-next="2">Next</button>
    </div>
    <div class="step-section d-none" data-step="2">
        <div class="form-row">
            <div class="form-group">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control"
                    placeholder="Enter quantity" required>
            </div>
            <div class="form-group">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-control" required>
                    <option selected disabled value="">Select an option</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="company_name" class="form-label">Company Name</label>
                <input type="text" name="company_name" id="company_name" class="form-control"
                    placeholder="Enter Company Name" required>
            </div>
            <div class="form-group">
                <label for="company_address" class="form-label">Company Address</label>
                <input type="text" name="company_address" id="company_address" class="form-control"
                    placeholder="Enter Company Address" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="company_icon" class="form-label">Company Icon</label>
                <input type="file" name="company_icon" id="company_icon" class="form-select"
                    placeholder="Enter Company Icon" required>
            </div>
            <div class="form-group">
                <label for="compliance_status" class="form-label">Compliance Status</label>
                <select name="compliance_status" id="compliance_status" class="form-control">
                    <option value="pending" selected>Pending</option>
                    <option value="approved">Approved</option>
                    <option value="flagged">Flagged</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="unit" class="form-label">Unit</label>
                <input type="text" name="unit" id="unit" class="form-control" placeholder="Enter Unit">
            </div>
            <div class="form-group">
                <label for="upper_limit" class="form-label">Upper Limit</label>
                <input type="text" name="upper_limit" id="upper_limit" class="form-control"
                    placeholder="Enter Upper Limit">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="lower_limit" class="form-label">Lower Limit</label>
                <input type="text" name="lower_limit" id="lower_limit" class="form-control"
                    placeholder="Enter Lower Limit">
            </div>
            <div class="form-group">
                <label for="city" class="form-label">City</label>
                <input type="text" name="city" id="city" class="form-control" placeholder="Enter City">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="product_type" class="form-label">Product Type</label>
                <input type="text" name="product_type" id="product_type" class="form-control"
                    placeholder="Enter Product Type">
            </div>
            <div class="form-group">
                <label for="origin" class="form-label">Origin</label>
                <input type="text" name="origin" id="origin" class="form-control"
                    placeholder="Enter Origin">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="badge" class="form-label">Badge</label>
                <input type="text" name="badge" id="badge" class="form-control" placeholder="Enter Badge">
            </div>
            <div class="form-group">
                <label for="refundable" class="form-label">Refundable</label>
                <input type="text" name="refundable" id="refundable" class="form-control"
                    placeholder="Is Refundable? (Yes/No)">
            </div>
        </div>

        <button type="button" class="prev-btn" data-prev="1">Prev</button>
    </div>
    <!-- Submit Button -->
    <div class="row mb-3">
        <div class="col text-end">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
        </div>
    </div>
</div>
