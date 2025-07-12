@php
    $isEdit = isset($stocksell);
    $units = [
        'Piece (pc)',
        'Kilogram (kg)',
        'Gram (g)',
        'Tonne (t)',
        'Litre (l)',
        'Millilitre (ml)',
        'Meter (m)',
        'Centimeter (cm)',
        'Millimeter (mm)',
        'Square Meter (m²)',
        'Cubic Meter (m³)',
        'Dozen',
        'Pack',
        'Box',
        'Carton',
        'Roll',
        'Set',
        'Pair',
        'Bottle',
        'Bag',
    ];
    $paymentTerms = [
        'L/C at Sight',
        'L/C 30/60/90 Days',
        'D/A (Documents Against Acceptance)',
        'D/P (Documents Against Payment)',
        'CAD (Cash Against Documents)',
        'T/T (Telegraphic Transfer)',
        'Advance Payment',
        'Advance + Partial Payment',
        'Advance 30%, Balance Before Shipment',
        'Advance 30%, Balance Against BL Copy',
        'Advance 50%, Balance on Delivery',
        'Advance 100% before Production',
        'Advance + L/C',
        'Advance + T/T',
    ];
    $dimensionUnits = [
        // Metric Units
        'mm', // millimeter
        'cm', // centimeter
        'dm', // decimeter
        'm', // meter
        'km', // kilometer

        // Imperial Units
        'in', // inch
        'ft', // foot
        'yd', // yard

        // Volume (used in shipping container space)
        'ml', // milliliter
        'l', // liter
        'm³', // cubic meter
        'cm³', // cubic centimeter
        'ft³', // cubic foot
        'in³', // cubic inch
        'yd³', // cubic yard

        // Packaging-Specific Units
        'pcs', // pieces
        'bale',
        'box',
        'bag',
        'carton',
        'drum',
        'crate',
        'pallet',
        'container',
        'roll',
        'reel',
        'tube',
        'IBC', // Intermediate Bulk Container
        'tank',

        // Special Logistics Units
        'TEU', // Twenty-foot Equivalent Unit (container)
        'FEU', // Forty-foot Equivalent Unit
    ];

    // Internal Packing values
    $internalValue = old('dimensions_per_unit', $isEdit ? $stocksell->dimensions_per_unit : '');
    preg_match('/([0-9xX* ]+)\s*([a-zA-Z]+)?/', $internalValue, $intMatch);
    $internalDims = trim($intMatch[1] ?? '');
    $internalUnit = strtolower(trim($intMatch[2] ?? ''));

    // Master Packing values
    $masterValue = old('master_packing', $isEdit ? $stocksell->master_packing : '');
    preg_match('/([0-9xX* ]+)\s*([a-zA-Z]+)?/', $masterValue, $masMatch);
    $masterDims = trim($masMatch[1] ?? '');
    $masterUnit = strtolower(trim($masMatch[2] ?? ''));
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
    </div>
    <div class="form-header">
        <h1>{{ $isEdit ? 'Edit Stock Sale' : 'Add Stock Sale' }}</h1>
        <p>Fill in the required details to {{ $isEdit ? 'Update' : 'Add' }} Stock Sale</p>
    </div>
    <div class="step-section" data-step="1">
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
                <label for="product_id" class="form-label">Product Name</label>
                <select id="product_id" name="product_id" class="form-control" {{ $isEdit ? '' : 'required' }}>
                    <option value="">Select a product</option>
                    @foreach ($items as $key => $value)
                        <option value="{{ $key }}"
                            {{ old('product_id', $isEdit ? $stocksell->product_id : '') == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
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
            @if ($isEdit)
                <div class="form-group">
                    <label for="imagePicker">Choose Images</label>
                    <input type="file" name="images[]" id="new_images" class="form-select" accept="image/*" multiple>
                </div>
            @else
                <div class="form-group">
                    <label for="imagePicker">Choose Images</label>
                    <input type="file" class="form-select" id="imagePicker" name="images[]" multiple />
                </div>
            @endif
            <div class="form-group">
                <label for="origin" class="form-label">Origin</label>
                <select name="origin" id="origin" class="form-control">
                    <option value="">{{ __('Select a Country') }}</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}"
                            {{ old('origin', $isEdit ? $stocksell->origin : '') == $country->id ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>
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
        <div class="form-row">
            <div class="form-single">
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
                <label class="form-label">Certificate Name</label>
                <input class="form-control" type="text" name="certificate_name" id="certificate_name"
                    value={{ old('certificate_name', $isEdit ? $stocksell->certificate_name : '') }}>
            </div>
            <div class="form-group">
                <label class="form-label">Certificate</label>
                <input class="form-select" type="file" name="certificate" id="certificate">
            </div>
        </div>
        @if ($isEdit)
            Current Certificate:
            <div class="form-row">
                <img src="/{{ $stocksell->certificate }}" alt="Certificate"
                    style="width: 100px; height: 100px; object-fit: cover;">
            </div>
        @endif
        <div class="form-row">
            <div class="form-group">
                <label for="city" class="form-label">City</label>
                <input type="text" name="city" id="city" class="form-control" required
                    value="{{ old('city', $isEdit ? $stocksell->city : '') }}" placeholder="Enter City">
            </div>
            @php
                $quantityValue = old('quantity', $isEdit ? $stocksell->quantity : '');
                preg_match('/([\d.,]+)\s*([a-zA-Z]+)/', $quantityValue, $matches);
                $parsedQuantity = $matches[1] ?? '';
                $parsedUnit = strtoupper(trim($matches[2] ?? ''));
            @endphp

            <div class="form-group">
                <label for="quantity_value" class="form-label">Quantity</label>
                <div class="input-group">
                    <input type="number" min="0" step="any" id="quantity_value" class="form-control"
                        placeholder="Enter quantity" value="{{ $parsedQuantity }}" required>

                    <select id="quantity_unit" class="form-control" required>
                        <option value="">Select Unit</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit }}"
                                {{ strtoupper($unit) == $parsedUnit ? 'selected' : '' }}>
                                {{ $unit }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Hidden input for combined quantity + unit --}}
                <input type="hidden" name="quantity" id="quantity" value="{{ $quantityValue }}">
            </div>

        </div>
        <button type="button" class="prev-btn" data-prev="1">Prev</button>
        <button type="button" class="next-btn" data-next="3">Next</button>
    </div>
    <div class="step-section" data-step="3">
        <div class="form-row">
            <div class="form-group">
                <label for="upper_limit" class="form-label">Upper Limit ($)</label>
                <input type="text" name="upper_limit" id="upper_limit" class="form-control"
                    value="{{ old('upper_limit', $isEdit ? $stocksell->upper_limit : '') }}"
                    placeholder="Enter Upper Limit">
            </div>
            <div class="form-group">
                <label for="lower_limit" class="form-label">Lower Limit ($)</label>
                <input type="text" name="lower_limit" id="lower_limit" class="form-control"
                    value="{{ old('lower_limit', $isEdit ? $stocksell->lower_limit : '') }}"
                    placeholder="Enter Lower Limit">
            </div>
        </div>
        <div class="form-row">
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
            <div class="form-group">
                <label class="title-color">{{ translate('Delivery Mode') }}</label>
                <select class="form-control" name="delivery_mode" id="delivery_mode">
                    @php
                        $deliveryModes = ['Air', 'Sea', 'Rail', 'Road'];
                    @endphp
                    @foreach ($deliveryModes as $mode)
                        <option value="{{ $mode }}"
                            {{ $isEdit ? ($stocksell->delivery_mode == $mode ? 'selected' : '') : '' }}>
                            {{ $mode }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-single">
                <label class="title-color">{{ translate('Payment Terms') }}</label>
                <select class="form-control" name="payment_terms" id="payment_terms">
                    @foreach ($paymentTerms as $term)
                        <option value="{{ $term }}"
                            {{ $isEdit ? ($stocksell->payment_terms == $term ? 'selected' : '') : '' }}>
                            {{ $term }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="button" class="prev-btn" data-prev="2">Prev</button>
        <button type="button" class="next-btn" data-next="4">Next</button>
    </div>
    <div class="step-section" data-step="4">
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Internal Packing') }}</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="internal_dims" value="{{ $internalDims }}"
                        placeholder="e.g., 10x5x2">
                    <select class="form-control" id="internal_unit">
                        <option value="">Select Unit</option>
                        @foreach ($dimensionUnits as $unit)
                            <option value="{{ $unit }}"
                                {{ $internalUnit == strtolower($unit) ? 'selected' : '' }}>
                                {{ strtoupper($unit) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" name="dimensions_per_unit" id="dimensions_per_unit"
                    value="{{ $internalValue }}">
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Internal Packing Type') }}</label>
                <select class="form-control" name="dimensions_per_unit_type">
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
                        $selectedInternalUnit = old(
                            'dimensions_per_unit_type',
                            $isEdit ? $stocksell->dimensions_per_unit_type ?? '' : '',
                        );
                    @endphp
                    <option value="">Select Unit</option>
                    @foreach ($packingTypes as $unit)
                        <option value="{{ $unit }}" {{ $selectedInternalUnit == $unit ? 'selected' : '' }}>
                            {{ $unit }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Master Packing') }}</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="master_dims" value="{{ $masterDims }}"
                        placeholder="e.g., 100x50x40">
                    <select class="form-control" id="master_unit">
                        <option value="">Select Unit</option>
                        @foreach ($dimensionUnits as $unit)
                            <option value="{{ $unit }}"
                                {{ $masterUnit == strtolower($unit) ? 'selected' : '' }}>
                                {{ strtoupper($unit) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" name="master_packing" id="master_packing" value="{{ $masterValue }}">
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Master Packing Type') }}</label>
                <select class="form-control" name="master_packing_unit">
                    @php
                        $selectedMasterUnit = old(
                            'master_packing_unit',
                            $isEdit ? $stocksell->master_packing_unit ?? '' : '',
                        );
                    @endphp
                    <option value="">Select Unit</option>
                    @foreach ($packingTypes as $unit)
                        <option value="{{ $unit }}" {{ $selectedMasterUnit == $unit ? 'selected' : '' }}>
                            {{ $unit }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-single">
                <label for="pod_port" class="form-label">Port of Delivery (POD)</label>
                <input type="text" name="pod_port" id="pod_port" class="form-control"
                    value="{{ old('pod_port', $isEdit ? $stocksell->pod_port : '') }}" placeholder="Enter POD Port">
            </div>
        </div>
        <div class="form-row">
            <div class="form-single">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control" placeholder="Enter description" rows="1"
                    required>{{ old('description', $isEdit ? $stocksell->description : '') }}</textarea>
            </div>
        </div>
        <button type="button" class="prev-btn" data-prev="3">Prev</button>
        <button type="button" class="next-btn" data-next="5">Next</button>
    </div>
    <div class="step-section" data-step="5">
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
        <div class="form-row mb-3">
            <div class="from-single">
                <label for="status" class="form-label">Status</label>
                @php
                    $statusValue = old('status', $isEdit ? $stocksell->status : '');
                @endphp
                <select id="status" name="status" class="form-control" required>
                    <option disabled value="" {{ $statusValue == '' ? 'selected' : '' }}>Select an option
                    </option>
                    <option value="active" {{ $statusValue == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $statusValue == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    @if(auth('admin')->check())
                        <option value="rejected" {{ $statusValue == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    @endif
                </select>
            </div>
        </div>
        <button type="button" class="prev-btn" data-prev="4">Prev</button>
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
<script>
    function updateQuantityField() {
        const qty = document.getElementById('quantity_value').value;
        const unit = document.getElementById('quantity_unit').value;
        document.getElementById('quantity').value = qty && unit ? `${qty} ${unit}` : '';
    }

    document.getElementById('quantity_value').addEventListener('input', updateQuantityField);
    document.getElementById('quantity_unit').addEventListener('change', updateQuantityField);

    // Initialize on load if value exists
    document.addEventListener('DOMContentLoaded', updateQuantityField);
</script>
<script>
    function updatePackingValue(dimsId, unitId, targetId) {
        const dims = document.getElementById(dimsId).value.trim();
        const unit = document.getElementById(unitId).value.trim();
        document.getElementById(targetId).value = dims && unit ? `${dims} ${unit}` : dims;
    }

    document.getElementById('internal_dims').addEventListener('input', () => {
        updatePackingValue('internal_dims', 'internal_unit', 'dimensions_per_unit');
    });
    document.getElementById('internal_unit').addEventListener('change', () => {
        updatePackingValue('internal_dims', 'internal_unit', 'dimensions_per_unit');
    });

    document.getElementById('master_dims').addEventListener('input', () => {
        updatePackingValue('master_dims', 'master_unit', 'master_packing');
    });
    document.getElementById('master_unit').addEventListener('change', () => {
        updatePackingValue('master_dims', 'master_unit', 'master_packing');
    });
</script>
