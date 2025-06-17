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
        <h1>Update Stock Sale</h1>
        <p>Fill in the required details to Update Stock Sale</p>
    </div>
    <div class="step-section" data-step="1">
        <h4> Basic Information </h4>
        <div class="form-row">
            <div class="form-group">
                <label for="product" class="form-label">Category</label>
                <select name="industry" id="industry" class="form-control">
                    <option value="value" selected>Select a Industry</option>
                    @foreach ($industry as $country)
                        <option value="{{ $country->id }}"
                            {{ isset($stocksell->industry) && $stocksell->industry == $country->id ? 'selected' : '' }}>
                            {{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="name" class="title-color">{{ translate('sub_Category') }}</label>
                <select class="js-select2-custom form-control action-get-request-onchange" name="sub_category_id"
                    id="sub-category-select"
                    data-url-prefix="{{ route('vendor.products.get-categories') . '?parent_id=' }}"
                    data-element-id="sub-sub-category-select" data-element-type="select">
                    <option value="{{ isset($stocksell->sub_category_id) ? $stocksell->sub_category_id : null }}"
                        selected disabled>
                        {{ translate('select_Sub_Category') }}</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="name" class="form-label">Name</label>
                <input type="text" value="{{ $stocksell->name }}" name="name" id="name" class="form-control"
                    placeholder="Enter name" required>
            </div>
            <div class="form-group">
                <label for="hs_code" class="form-label">HS Code</label>
                <input type="text" value="{{ $stocksell->hs_code }}" name="hs_code" id="hs_code"
                    class="form-control" placeholder="Enter HS Code" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="imagePicker">Choose Images</label>
                <input type="file" name="images[]" id="new_images" class="form-select" accept="image/*" multiple>
            </div>
            <div class="form-group">
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
        </div>
        <div class="form-row">
            <div class="existing-images d-flex gap-3">
                @if ($stocksell->image)
                    <!-- Check if images exist -->
                    @foreach (json_decode($stocksell->image) as $image)
                        <div class="image-preview d-flex flex-column">
                            <img src="/{{ $image }}" alt="Product Image"
                                style="width: 100px; height: 100px; object-fit: cover;">
                            <span>
                                <input type="checkbox" name="remove_images[]" value="{{ $image }}">
                                Remove
                            </span>
                        </div>
                    @endforeach
                @else
                    <p>No images uploaded yet.</p>
                @endif
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="stock_type" class="form-label">Stock Type</label>
                <select name="stock_type" id="stock_type" class="form-control">
                    <option value="" disabled>Select a Category</option>
                    @php
                        $selectedCategory = \App\Models\StockCategory::find($stocksell->stock_type);
                    @endphp

                    @if ($selectedCategory)
                        <option value="{{ $selectedCategory->id }}" selected>
                            {{ $selectedCategory->name }}</option>
                    @endif

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="rate" class="form-label">Rate</label>
                <input type="number" value="{{ $stocksell->rate }}" name="rate" id="rate" class="form-control"
                    placeholder="Enter Rate" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="local_currency" class="form-label">Local Currency</label>
                <input type="text" value="{{ $stocksell->local_currency }}" name="local_currency"
                    id="local_currency" class="form-control" placeholder="Enter Local Currency" required>
            </div>
            <div class="form-group">
                <label class="title-color">{{ translate('Delivery Terms') }}</label>
                <select class="form-control" name="delivery_terms">
                    <option value="CFR" {{ $stocksell->delivery_terms == 'CFR' ? 'selected' : '' }}>CFR</option>
                    <option value="FOB" {{ $stocksell->delivery_terms == 'FOB' ? 'selected' : '' }}>FOB</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Place of Loading') }}</label>
                <input type="text" value="{{ $stocksell->place_of_loading }}" class="form-control"
                    name="place_of_loading" placeholder="e.g., Shanghai, Ningbo">
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Port of Loading') }}</label>
                <select class="form-control" name="port_of_loading">
                    <option value="Factory" {{ $stocksell->port_of_loading == 'Factory' ? 'selected' : '' }}>Factory
                    </option>
                    <option value="Sea_Port" {{ $stocksell->port_of_loading == 'Sea_Port' ? 'selected' : '' }}>Sea
                        Port</option>
                    <option value="ICD" {{ $stocksell->port_of_loading == 'ICD' ? 'selected' : '' }}>ICD</option>
                    <option value="Air_Port" {{ $stocksell->port_of_loading == 'Air_Port' ? 'selected' : '' }}>Air
                        Port</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Packing Type') }}</label>
                <select class="form-control" name="packing_type">
                    <option value="">Select Packing Type</option>
                    <option value="PP Bag" {{ $stocksell->packing_type == 'PP Bag' ? 'selected' : '' }}>PP Bag
                    </option>
                    <option value="Carton" {{ $stocksell->packing_type == 'Carton' ? 'selected' : '' }}>Carton
                    </option>
                    <option value="Plastic Drum" {{ $stocksell->packing_type == 'Plastic Drum' ? 'selected' : '' }}>
                        Plastic Drum</option>
                    <option value="Steel Drum" {{ $stocksell->packing_type == 'Steel Drum' ? 'selected' : '' }}>Steel
                        Drum</option>
                    <option value="Wooden Crate" {{ $stocksell->packing_type == 'Wooden Crate' ? 'selected' : '' }}>
                        Wooden Crate</option>
                    <option value="Bulk" {{ $stocksell->packing_type == 'Bulk' ? 'selected' : '' }}>
                        Bulk</option>
                    <option value="IBC Tank" {{ $stocksell->packing_type == 'IBC Tank' ? 'selected' : '' }}>IBC Tank
                    </option>
                    <option value="Plastic Container"
                        {{ $stocksell->packing_type == 'Plastic Container' ? 'selected' : '' }}>Plastic
                        Container
                    </option>
                    <option value="Custom Packaging"
                        {{ $stocksell->packing_type == 'Custom Packaging' ? 'selected' : '' }}>Custom
                        Packaging
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Size') }}</label>
                <input type="text" value="{{ $stocksell->weight_per_unit }}" class="form-control"
                    name="weight_per_unit" placeholder="e.g., 1.5kg">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Internal Packing') }}</label>
                <input type="text" value="{{ $stocksell->dimensions_per_unit }}" class="form-control"
                    name="dimensions_per_unit" placeholder="e.g., 10x5x2 cm">
            </div>
            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control" placeholder="Enter description" rows="1">{{ $stocksell->description }}</textarea>
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
                Current Image:
            </div>
            <div class="form-group">
                <label for="product" class="form-label">Product</label>
                <select id="product" name="product_id" class="form-control" required>
                    <option selected value="">Select a product</option>
                    <!-- Add dynamic product options here -->
                    @foreach ($items as $key => $value)
                        <option value="{{ $key }}"
                            {{ isset($stocksell->product) && $stocksell->product->id == $key ? 'selected' : '' }}>
                            {{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <img src="/{{ $stocksell->certificate }}" alt="Company Icon"
                style="width: 100px; height: 100px; object-fit: cover;">
        </div>
        <button type="button" class="next-btn" data-next="2">Next</button>
    </div>
    <div class="step-section d-none" data-step="2">
        <div class="form-row">
            <div class="form-group">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" value="{{ $stocksell->quantity }}" name="quantity" id="quantity"
                    class="form-control" placeholder="Enter quantity" required>
            </div>
            <div class="form-group">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-control" required>
                    <option selected disabled value="">Select an option</option>
                    <option value="active" @selected($stocksell->status == 'active')>Active</option>
                    <option value="inactive" @selected($stocksell->status == 'inactive')>Inactive</option>
                    <option value="rejected" @selected($stocksell->status == 'rejected')>Rejected</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="company_name" class="form-label">Company Name</label>
                <input type="text" value="{{ $stocksell->company_name }}" name="company_name" id="company_name"
                    class="form-control" placeholder="Enter Company Name" required>
            </div>
            <div class="form-group">
                <label for="company_address" class="form-label">Company Address</label>
                <input type="text" value="{{ $stocksell->company_address }}" name="company_address"
                    id="company_address" class="form-control" placeholder="Enter Company Address" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="company_icon" class="form-label">Company Icon</label>
                <input type="file" name="company_icon" id="company_icon" class="form-select"
                    placeholder="Enter Company Icon">
            </div>
            <div class="form-group">
                <label for="compliance_status" class="form-label">Compliance Status</label>
                <select name="compliance_status" id="compliance_status" class="form-control">
                    <option value="pending" @selected($stocksell->compliance_status == 'pending')>Pending</option>
                    <option value="approved" @selected($stocksell->compliance_status == 'approved')>Approved</option>
                    <option value="flagged" @selected($stocksell->compliance_status == 'flagged')>Flagged</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <span>
                Current Image:
                <img src="/{{ $stocksell->company_icon }}" alt="Company Icon"
                    style="width: 100px; height: 100px; object-fit: cover;">
            </span>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="unit" class="form-label">Unit</label>
                <input type="text" value="{{ $stocksell->unit }}" name="unit" id="unit"
                    class="form-control" placeholder="Enter Unit">
            </div>
            <div class="form-group">
                <label for="upper_limit" class="form-label">Upper Limit</label>
                <input type="text" name="upper_limit" value="{{ $stocksell->upper_limit }}" id="upper_limit"
                    class="form-control" placeholder="Enter Upper Limit">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="lower_limit" class="form-label">Lower Limit</label>
                <input type="text" name="lower_limit" value="{{ $stocksell->lower_limit }}" id="lower_limit"
                    class="form-control" placeholder="Enter Lower Limit">
            </div>
            <div class="form-group">
                <label for="city" class="form-label">City</label>
                <input type="text" name="city" id="city" class="form-control"
                    value="{{ $stocksell->city }}" placeholder="Enter City">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="product_type" class="form-label">Product Type</label>
                <input type="text" value="{{ $stocksell->product_type }}" name="product_type" id="product_type"
                    class="form-control" placeholder="Enter Product Type">
            </div>
            <div class="form-group">
                <label for="origin" class="form-label">Origin</label>
                <input type="text" value="{{ $stocksell->origin }}" name="origin" id="origin"
                    class="form-control" placeholder="Enter Origin">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="badge" class="form-label">Badge</label><input type="text"
                    value="{{ $stocksell->badge }}" name="badge" id="badge" class="form-control"
                    placeholder="Enter Badge">
            </div>
            <div class="form-group">
                <label for="refundable" class="form-label">Refundable</label>
                <input type="text" value="{{ $stocksell->refundable }}" name="refundable" id="refundable"
                    class="form-control" placeholder="Is Refundable? (Yes/No)">
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
