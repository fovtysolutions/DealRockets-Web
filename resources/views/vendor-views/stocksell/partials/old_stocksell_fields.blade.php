@php
    $isEdit = isset($stocksell);
@endphp
<div class="progress-form-main">
    <div class="progress-container">
        <div class="step active">
            <div class="step-circle">1</div>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">2</div>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">3</div>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">4</div>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">5</div>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">6</div>
        </div>
    </div>
    <div class="form-header">
        <h1>{{ $isEdit ? 'Edit Stock Sale' : 'Add Stock Sale' }}</h1>
        <p>Fill in the required details to {{ $isEdit ? 'Update' : 'Add' }} Stock Sale</p>
    </div>
    <div class="step-section" data-step="1">
        <div class="form-row">
            <div class="form-group">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $isEdit ? $stocksell->name : '') }}" placeholder="Enter name" required>
            </div>

            <div class="form-group">
                <label for="product_id" class="form-label">Product</label>
                <select id="product_id" name="product_id" class="form-control" required>
                    <option value="">Select a product</option>
                    @foreach ($items as $key => $value)
                        <option value="{{ $key }}"
                            {{ old('product_id', $isEdit ? $stocksell->product_id : '') == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control" placeholder="Enter description" rows="1">{{ old('description', $isEdit ? $stocksell->description : '') }}</textarea>
            </div>
            <div class="form-group">
                <label for="industry" class="form-label">Country</label>
                <select name="country" id="country" class="form-control">
                    <option value="" selected>Select a Country</option>
                    @foreach ($countries as $ind)
                        <option value="{{ $ind->id }}"
                            {{ old('country', $isEdit ? $stocksell->country : '') == $ind->id ? 'selected' : '' }}>
                            {{ $ind->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="origin" class="form-label">Origin</label>
                <input type="text" value="{{ old('origin', $isEdit ? $stocksell->origin : '') }}" name="origin"
                    id="origin" class="form-control" placeholder="Enter Origin">
            </div>
            <div class="form-group">
                <label for="city" class="form-label">City</label>
                <input type="text" name="city" id="city" class="form-control"
                    value="{{ old('city', $isEdit ? $stocksell->city : '') }}" placeholder="Enter City" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="industry" class="form-label">Category</label>
                <select name="industry" id="industry" class="form-control" required>
                    <option value="" selected>Select an Category</option>
                    @foreach ($industry as $ind)
                        <option value="{{ $ind->id }}"
                            {{ old('industry', $isEdit ? $stocksell->industry : '') == $ind->id ? 'selected' : '' }}>
                            {{ $ind->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="sub_category_id" class="title-color">{{ translate('sub_Category') }}</label>
                <select class="form-control action-get-request-onchange" name="sub_category_id" id="sub-category-select"
                    data-url-prefix="{{ route('vendor.products.get-categories') . '?parent_id=' }}"
                    data-element-id="sub-sub-category-select" data-element-type="select">
                    <option value="" disabled {{ !$isEdit ? 'selected' : '' }}>
                        {{ translate('select_Sub_Category') }}
                    </option>
                    @if ($isEdit)
                        <option value="{{ $stocksell->sub_category_id }}" selected>
                            {{ optional($stocksell->subcategory)->name }}
                        </option>
                    @endif
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="product_type" class="form-label">Product Type</label>
                <input type="text" name="product_type" id="product_type" class="form-control"
                    value="{{ old('product_type', $isEdit ? $stocksell->product_type : '') }}"
                    placeholder="Enter Product Type">
            </div>

            <div class="form-group">
                <label for="stock_type" class="form-label">Stock Type</label>
                <select name="stock_type" id="stock_type" class="form-control">
                    <option value="">Select a Category</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('stock_type', $isEdit ? $stocksell->stock_type : '') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="badge" class="form-label">Badge</label>
                <input type="text" name="badge" id="badge" class="form-control"
                    value="{{ old('badge', $isEdit ? $stocksell->badge : '') }}" placeholder="Enter Badge">
            </div>

            <div class="form-group">
                <label for="hs_code" class="form-label">HS Code</label>
                <input type="text" name="hs_code" id="hs_code" class="form-control"
                    value="{{ old('hs_code', $isEdit ? $stocksell->hs_code : '') }}" placeholder="Enter HS Code"
                    required>
            </div>
        </div>
        <button type="button" class="next-btn" data-next="2">Next</button>
    </div>
    <div class="step-section" data-step="2">
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
        <button type="button" class="prev-btn" data-prev="1">Prev</button>
        <button type="button" class="next-btn" data-next="3">Next</button>
    </div>
    <div class="step-section" data-step="3">
        @php
            $isEdit = isset($stocksell);
        @endphp

        <!-- Quantity & Unit -->
        <div class="form-row">
            <div class="form-group">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control"
                    value="{{ old('quantity', $isEdit ? $stocksell->quantity : '') }}" placeholder="Enter quantity"
                    required>
            </div>
            <div class="form-group">
                <label for="unit" class="form-label">Unit</label>
                <select name="unit" id="unit" class="form-control">
                    @php
                        $unitOptions = ['kg', 'ltr', 'cbm', 'pcs', 'gms', 'oz', 'lb', 'pair'];
                        $selectedUnit = old('unit', $isEdit ? $stocksell->unit : '');
                    @endphp
                    <option value="">Select Unit</option>
                    @foreach ($unitOptions as $unit)
                        <option value="{{ $unit }}" {{ $selectedUnit == $unit ? 'selected' : '' }}>
                            {{ $unit }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Upper & Lower Limit -->
        <div class="form-row">
            <div class="form-group">
                <label for="upper_limit" class="form-label">Upper Limit</label>
                <input type="text" name="upper_limit" id="upper_limit" class="form-control"
                    value="{{ old('upper_limit', $isEdit ? $stocksell->upper_limit : '') }}"
                    placeholder="Enter Upper Limit">
            </div>
            <div class="form-group">
                <label for="lower_limit" class="form-label">Lower Limit</label>
                <input type="text" name="lower_limit" id="lower_limit" class="form-control"
                    value="{{ old('lower_limit', $isEdit ? $stocksell->lower_limit : '') }}"
                    placeholder="Enter Lower Limit">
            </div>
        </div>

        <!-- Internal Packing -->
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Internal Packing') }}</label>
                <input type="text" class="form-control" name="dimensions_per_unit"
                    value="{{ old('dimensions_per_unit', $isEdit ? $stocksell->dimensions_per_unit : '') }}"
                    placeholder="e.g., 10x5x2 cm">
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Internal Packing Unit') }}</label>
                <select class="form-control" name="dimensions_per_unit_type">
                    @php
                        $dimensionUnits = ['cm', 'mm', 'm', 'in', 'ft'];
                        $selectedInternalUnit = old(
                            'dimensions_per_unit_type',
                            $isEdit ? $stocksell->dimensions_per_unit_type ?? '' : '',
                        );
                    @endphp
                    <option value="">Select Unit</option>
                    @foreach ($dimensionUnits as $unit)
                        <option value="{{ $unit }}" {{ $selectedInternalUnit == $unit ? 'selected' : '' }}>
                            {{ $unit }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Master Packing -->
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Master Packing') }}</label>
                <input type="text" class="form-control" name="master_packing"
                    value="{{ old('master_packing', $isEdit ? $stocksell->master_packing : '') }}"
                    placeholder="e.g., 100x50x40 cm">
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Master Packing Unit') }}</label>
                <select class="form-control" name="master_packing_unit">
                    @php
                        $selectedMasterUnit = old(
                            'master_packing_unit',
                            $isEdit ? $stocksell->master_packing_unit ?? '' : '',
                        );
                    @endphp
                    <option value="">Select Unit</option>
                    @foreach ($dimensionUnits as $unit)
                        <option value="{{ $unit }}" {{ $selectedMasterUnit == $unit ? 'selected' : '' }}>
                            {{ $unit }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="button" class="prev-btn" data-prev="2">Prev</button>
        <button type="button" class="next-btn" data-next="4">Next</button>
    </div>
    <div class="step-section" data-step="4">
        <!-- Packing Type -->
        <div class="form-row">
            @if ($isEdit)
                <div class="form-group">
                @else
                    <div class="form-single">
            @endif
            <label class="form-label">{{ translate('Packing Type') }}</label>
            <select class="form-control" name="packing_type">
                <option value="">Select Packing Type</option>
                @php
                    $packingTypes = [
                        'PP Bag',
                        'Carton',
                        'Plastic Drum',
                        'Steel Drum',
                        'Wooden Crate',
                        'Bulk',
                        'IBC Tank',
                        'Plastic Container',
                        'Custom Packaging',
                    ];
                    $selectedPackingType = old('packing_type', $isEdit ? $stocksell->packing_type : '');
                @endphp
                @foreach ($packingTypes as $type)
                    <option value="{{ $type }}" {{ $selectedPackingType == $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>
        </div>
        @if ($isEdit)
            <div class="form-group">
                <label for="imagePicker">Choose Images</label>
                <input type="file" name="images[]" id="new_images" class="form-select" accept="image/*"
                    multiple>
            </div>
        @endif
    </div>
    @if ($isEdit)
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
    @endif
    <!-- Weight Per Unit -->
    <div class="form-row">
        <div class="form-group">
            <label class="form-label">{{ translate('Weight Per Unit') }}</label>
            <input type="text" class="form-control" name="weight_per_unit" placeholder="e.g., 1.5"
                value="{{ old('weight_per_unit', $isEdit ? $stocksell->weight_per_unit : '') }}">
        </div>
        <div class="form-group">
            <label class="form-label">{{ translate('Weight Per Unit Type') }}</label>
            <select class="form-control" name="weight_per_unit_type">
                @php
                    $weightUnits = ['kg', 'g', 'lb', 'oz'];
                    $selectedWeightUnit = old(
                        'weight_per_unit_type',
                        $isEdit ? $stocksell->weight_per_unit_type ?? '' : '',
                    );
                @endphp
                <option value="">Select Unit</option>
                @foreach ($weightUnits as $unit)
                    <option value="{{ $unit }}" {{ $selectedWeightUnit == $unit ? 'selected' : '' }}>
                        {{ $unit }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Dimensions Per Unit -->
    <div class="form-row">
        <div class="form-group">
            <label class="form-label">{{ translate('Dimensions Per Unit') }}</label>
            <input type="text" class="form-control" name="dimension_per_unit" placeholder="e.g., 30x30x30"
                value="{{ old('dimension_per_unit', $isEdit ? $stocksell->dimension_per_unit : '') }}">
        </div>
        <div class="form-group">
            <label class="form-label">{{ translate('Dimension Per Unit Type') }}</label>
            <select class="form-control" name="dimension_per_unit_type">
                @php
                    $dimensionUnits = ['cm', 'inch', 'mm'];
                    $selectedDimUnit = old(
                        'dimension_per_unit_type',
                        $isEdit ? $stocksell->dimension_per_unit_type ?? '' : '',
                    );
                @endphp
                <option value="">Select Unit</option>
                @foreach ($dimensionUnits as $unit)
                    <option value="{{ $unit }}" {{ $selectedDimUnit == $unit ? 'selected' : '' }}>
                        {{ $unit }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <button type="button" class="prev-btn" data-prev="3">Prev</button>
    <button type="button" class="next-btn" data-next="5">Next</button>
</div>
<div class="step-section" data-step="5">
    <div class="form-row">
        <div class="form-group">
            <label for="rate" class="form-label">Rate ($)</label>
            <input type="number" name="rate" id="rate"
                value="{{ old('rate', $isEdit ? $stocksell->rate : '') }}" class="form-control"
                placeholder="Enter Rate" required>
        </div>
        <div class="form-group">
            <label for="rate_unit" class="form-label">Rate Unit</label>
            <select name="rate_unit" id="rate_unit" class="form-control">
                @php
                    $rateUnits = ['per kg', 'per ltr', 'per cbm', 'per pcs'];
                    $selectedRateUnit = old('rate_unit', $isEdit ? $stocksell->rate_unit : '');
                @endphp
                <option value="">Select Rate Unit</option>
                @foreach ($rateUnits as $unit)
                    <option value="{{ $unit }}" {{ $selectedRateUnit == $unit ? 'selected' : '' }}>
                        {{ $unit }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group">
            <label for="local_currency" class="form-label">Local Currency</label>
            <input type="text" name="local_currency" id="local_currency" class="form-control"
                placeholder="Enter Local Currency"
                value="{{ old('local_currency', $isEdit ? $stocksell->local_currency : '') }}">
        </div>
        <div class="form-group">
            <label class="title-color">{{ translate('Delivery Terms') }}</label>
            <select class="form-control" name="delivery_terms" id="delivery_terms">
                @php
                    $deliveryTerms = ['CFR', 'FOB', 'CIF', 'EXW', 'FCA', 'FAS', 'CPT', 'CIP', 'DAP', 'DPU', 'DDP'];
                @endphp
                @foreach ($deliveryTerms as $term)
                    <option value="{{ $term }}"
                        {{ $isEdit ? ($stocksell->delivery_terms == $term ? 'selected' : '') : '' }}>
                        {{ $term }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <button type="button" class="prev-btn" data-prev="4">Prev</button>
    <button type="button" class="next-btn" data-next="6">Next</button>
</div>
<div class="step-section" data-step="6">
    <div class="form-row">
        <div class="form-group">
            <label for="company_name" class="form-label">Company Name</label>
            <input type="text" name="company_name" id="company_name" class="form-control"
                placeholder="Enter Company Name" required
                value="{{ old('company_name', $isEdit ? $stocksell->company_name : '') }}">
        </div>
        <div class="form-group">
            <label for="company_icon" class="form-label">Company Icon</label>
            <input type="file" name="company_icon" id="company_icon" class="form-select"
                placeholder="Enter Company Icon" {{ $isEdit ? '' : 'required' }}>
        </div>
    </div>
    @if ($isEdit)
        <div class="form-row">
            <span>
                Current Image:
                <img src="/{{ $stocksell->company_icon }}" alt="Company Icon"
                    style="width: 100px; height: 100px; object-fit: cover;">
            </span>
        </div>
    @endif
    @php
        $selectedStatus = old('status', $isEdit ? $stocksell->status : '');
        $selectedCompliance = old('compliance_status', $isEdit ? $stocksell->compliance_status : 'pending');
    @endphp
    <div class="form-row">
        <!-- Status -->
        <div class="form-group">
            <label for="status" class="form-label">Status</label>
            <select id="status" name="status" class="form-control" required>
                <option disabled value="">Select an option</option>
                <option value="active" {{ $selectedStatus === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $selectedStatus === 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="rejected" {{ $selectedStatus === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        <div class="form-group">
            <label for="company_address" class="form-label">Company Address</label>
            <input type="text" name="company_address" id="company_address" class="form-control"
                placeholder="Enter Company Address" required
                value="{{ old('company_address', $isEdit ? $stocksell->company_address : '') }}">
        </div>
    </div>
    <div class="form-row">
        <!-- Compliance Status -->
        <div class="form-group">
            <label for="compliance_status" class="form-label">Compliance Status</label>
            <select name="compliance_status" id="compliance_status" class="form-control">
                <option value="pending" {{ $selectedCompliance === 'pending' ? 'selected' : '' }}>Pending</option>
                @if (auth('admin')->check())
                    <option value="approved" {{ $selectedCompliance === 'approved' ? 'selected' : '' }}>Approved
                    </option>
                    <option value="flagged" {{ $selectedCompliance === 'flagged' ? 'selected' : '' }}>Flagged
                    </option>
                @endif
            </select>
        </div>
        <div class="form-group">
            <label for="refundable" class="form-label">Refundable</label>
            <select name="refundable" id="refundable" class="form-control" placeholder="Is Refundable? (Yes/No)">
                <option value="" selected disabled>Select an option</option>
                <option value="yes"
                    {{ old('refundable', $isEdit ? $stocksell->refundable : '') == 'yes' ? 'selected' : '' }}>Yes
                </option>
                <option value="no"
                    {{ old('refundable', $isEdit ? $stocksell->refundable : '') == 'no' ? 'selected' : '' }}>No
                </option>
            </select>
        </div>
    </div>
    <button type="button" class="prev-btn" data-prev="5">Prev</button>
    <button type="submit" class="submit-btn">Submit</button>
</div>
</div>
<script>
    $(document).ready(function() {
        $('#product_id').select2({
            tags: true,
            placeholder: 'Search or add product name',
            minimumInputLength: 2,
            ajax: {
                url: '{{ route('products.search') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term // search term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.map(item => ({
                            id: item.id,
                            text: item.name
                        }))
                    };
                },
                cache: true
            },
            createTag: function(params) {
                return {
                    id: params.term,
                    text: params.term,
                    newOption: true
                };
            },
            templateResult: function(data) {
                return data.newOption ? `<em>Add "${data.text}"</em>` : data.text;
            }
        });
    });
</script>
