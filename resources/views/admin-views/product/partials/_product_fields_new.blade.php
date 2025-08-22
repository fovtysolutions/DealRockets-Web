@php
    $isEdit = isset($product);
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
        <h1>{{ $isEdit ? 'Edit Product' : 'Create Product' }}</h1>
        <p>{{ $isEdit ? 'Update the details of your Product' : 'Fill in the required details to create Product' }}
        </p>
    </div>
    <div class="step-section" data-step="1">
        <div class="form-row">
            <div class="form-group">
                <label for="name" class="title-color">
                    {{ translate('category') }}
                    <span class="input-required-icon">*</span>
                </label>
                @if (auth('admin')->check())
                    <select class="form-control action-get-request-onchange" name="category_id"
                        data-url-prefix="{{ route('admin.products.get-categories') . '?parent_id=' }}"
                        data-element-id="sub-category-select" data-element-type="select" required>
                    @else
                        <select class="form-control action-get-request-onchange" name="category_id"
                            data-url-prefix="{{ route('vendor.products.get-categories') . '?parent_id=' }}"
                            data-element-id="sub-category-select" data-element-type="select" required>
                @endif
                <option value="{{ old('category_id') }}" selected disabled>
                    {{ translate('select_category') }}
                </option>
                @foreach ($categories as $category)
                    <option value="{{ $category['id'] }}"
                        {{ $isEdit && $category['id'] == ($product['category_id'] ?? null) ? 'selected' : '' }}>
                        {{ $category['name'] }}
                    </option>
                @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="title-color">{{ translate('sub_Category') }}</label>
                @if (auth('admin')->check())
                    <select class="form-control action-get-request-onchange" name="sub_category_id"
                        id="sub-category-select" data-id="{{ $isEdit ? $product['sub_category_id'] : '' }}"
                        data-url-prefix="{{ url('/admin/products/get-categories?parent_id=') }}"
                        data-element-id="sub-sub-category-select" data-element-type="select">
                    </select>
                @else
                    <select class="form-control action-get-request-onchange" name="sub_category_id"
                        id="sub-category-select" data-id="{{ $isEdit ? $product['sub_category_id'] : '' }}"
                        data-url-prefix="{{ url('/vendor/products/get-categories?parent_id=') }}"
                        data-element-id="sub-sub-category-select" data-element-type="select">
                    </select>
                @endif
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="title-color" for="name">{{ translate('product_name') }}
                </label>
                <input type="text" name="name" id="name" value="{{ $isEdit ? $product['name'] : '' }}"
                    class="form-control" placeholder="{{ translate('new_Product') }}" required>
                <small class="text-muted d-block mt-1" id="name-word-counter">20 words left</small>
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('HS Code') }}</label>
                <div class="position-relative">
                    <input type="text" class="form-control" name="hts_code" id="hts_code"
                        value="{{ $isEdit ? $product['hts_code'] : '' }}" 
                        placeholder="Enter HS Code or Product Description" autocomplete="off">
                    <div id="hts_code_suggestions" class="hs-suggestions-dropdown"></div>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="title-color">
                    {{ translate('brand') }}
                    <span class="input-required-icon">*</span>
                </label>
                <input type="text" class="form-control" name="brand"
                    value="{{ $isEdit ? $product['brand'] : '' }}" placeholder="e.g., ASOS">
            </div>
            <div class="form-group">
                <label class="title-color d-flex align-items-center gap-2">
                    {{ translate('Origin') }}
                    <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                        title="{{ translate('add_the_product_search_tag_for_this_product_that_customers_can_use_to_search_quickly') }}">
                        <img width="16"
                            src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                            alt="">
                    </span>
                </label>
                <select class="form-control" placeholder="{{ translate('Enter Origin') }}" name="origin"
                    data-role="origininput" required>
                    <option selected value="">Select a Country</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}"
                            {{ isset($product['origin']) && $product['origin'] == $country->id ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-single">
                <label class="title-color" for="description">{{ translate('Short Description') }}
                </label>
                <textarea name="short_details" class="summernote" data-word-limit="50">{!! $isEdit ? $product['short_details'] ?? '' : '' !!}</textarea>
                <small class="text-muted d-block mt-1" id="short-details-counter">50 words left</small>
            </div>
        </div>

        <button type="button" class="next-btn" data-next="2">Next</button>
    </div>
    <div class="step-section" data-step="2">
        <div class="form-row">
            <div class="form-group">
                <label for="thumbnail">Thumbnail</label>
                <div class="upload-box" data-for="thumbnail">
                    <input type="file" accept="image/png,image/jpeg,image/webp" name="thumbnail" id="thumbnail" {{ $isEdit ? '' : 'required' }}>
                    <div class="upload-instructions">
                        <strong>Square image required (1:1)</strong> — Recommended 800×800. JPG/PNG/WebP only. Upload will be rejected if not 1:1.
                    </div>
                    <div id="thumbnail-error" class="upload-error text-danger mt-1" style="display:none;"></div>
                    <div id="thumbnail-preview" class="upload-preview-grid"></div>
                </div>
            </div>
            <div class="form-group">
                <label for="extra_images">Additional Images</label>
                <div class="upload-box" data-for="extra_images">
                    <input type="file" accept="image/png,image/jpeg,image/webp" name="extra_images[]" id="extra_images" {{ $isEdit ? '' : 'required' }} multiple data-max-count="5" data-existing-count="{{ $isEdit ? (is_array(json_decode($product->extra_images ?? '[]', true)) ? count(json_decode($product->extra_images ?? '[]', true)) : 0) : 0 }}">
                    <div class="upload-instructions">
                        <strong>Square images required (1:1)</strong> — Recommended 800×800. JPG/PNG/WebP only. Uploads will be rejected if not 1:1. Max 5 files total.
                    </div>
                    <div id="extra_images-error" class="upload-error text-danger mt-1" style="display:none;"></div>
                    <div id="extra_images-preview" class="upload-preview-grid"></div>
                </div>
            </div>
        </div>
        @if ($isEdit && !empty($product->thumbnail))
            <div class="form-row mb-3">
                <h4>Thumbnail</h4>
                <div class="upload-preview-grid mt-2">
                    <div class="upload-preview-box hover-delete">
                        <img src="/storage/{{ $product->thumbnail }}" alt="Thumbnail"/>
                        <button type="button" class="delete-image-btn" data-type="thumbnail" data-src="{{ $product->thumbnail }}" title="Remove"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
            </div>
        @else
            <div class="form-row mb-3">
                <h4>Thumbnail</h4>
                <p class="text-muted">No thumbnail uploaded.</p>
            </div>
        @endif
        @php
            if ($isEdit) {
                $extraImages = json_decode($product->extra_images, true) ?? [];
            } else {
                $extraImages = [];
            }
        @endphp

        <div class="form-row mb-3">
            <h4>Additional Images</h4>
            @if ($isEdit && is_array($extraImages) && count($extraImages))
                <div class="upload-preview-grid mt-2">
                    @foreach ($extraImages as $image)
                        <div class="upload-preview-box hover-delete">
                            <img src="/storage/{{ $image }}" alt="Extra Image"/>
                            <button type="button" class="delete-image-btn" data-type="extra" data-src="{{ $image }}" title="Remove"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">No additional images uploaded.</p>
            @endif
        </div>
        <div class="form-row">
            <div class="form-single">
                <label class="form-lable">Certificate</label>
                <div class="upload-box" data-for="certificates">
                    <input type="file" accept="image/png,image/jpeg,image/webp,application/pdf" name="certificates[]" id="certificates" {{ $isEdit ? '' : 'required' }} multiple data-max-count="5" data-existing-count="{{ $isEdit ? (is_array(json_decode($product->certificates ?? '[]', true)) ? count(json_decode($product->certificates ?? '[]', true)) : 0) : 0 }}">
                    <div class="upload-instructions">
                        <strong>Square images required (1:1) or PDF</strong> — Recommended 800×800 for images. JPG/PNG/WebP/PDF. Max 5 files total.
                    </div>
                    <div id="certificates-error" class="upload-error text-danger mt-1" style="display:none;"></div>
                    <div id="certificates-preview" class="upload-preview-grid"></div>
                </div>
            </div>
        </div>
        <div class="form-row" style="margin-bottom: 10px;">
            @if ($isEdit && !empty($product->certificates))
                <div class="d-flex flex-wrap gap-2 mt-2">
                    <h4>Certificates</h4>
                    @php
                        $certificates = json_decode($product->certificates, true) ?? [];
                    @endphp

                    @if (!empty($certificates) && is_array($certificates))
                        @foreach ($certificates as $cert)
                            <img src="/storage/{{ $cert }}" alt="Certificate"
                                style="max-height: 200px; max-width: 200px; aspect-ratio: 1/1; object-fit: cover; border:1px solid #ccc; border-radius:6px;"
                                class="me-2 mb-2">
                        @endforeach
                    @else
                        <p class="text-muted">No certificates available.</p>
                    @endif
                </div>
            @endif
        </div>
        <button type="button" class="prev-btn" data-prev="1">Prev</button>
        <button type="button" class="next-btn" data-next="3">Next</button>
    </div>
    <div class="step-section" data-step=3>
        <div class="form-row">
            <div class="form-group">
                <label class="title-color " for="minimum_order_qty">
                    {{ translate('minimum_order_qty') }}
                    <span class="input-required-icon">*</span>
                </label>

                <input type="number" min="1" value="1" step="1"
                    placeholder="{{ translate('minimum_order_quantity') }}" name="minimum_order_qty"
                    id="minimum_order_qty" class="form-control" value="{{ $product['minimum_order_qty'] ?? 0 }}"
                    required>
            </div>
            <div class="form-group">
                <label class="title-color">{{ translate('unit') }}</label>
                <select class="js-example-basic-multiple form-control" name="unit">
                    @foreach ($units as $unit)
                        <option value="{{ $unit }}"
                            {{ $isEdit ? ($product['unit'] == $unit ? 'selected' : '') : '' }}>
                            {{ $unit }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="title-color ">
                    {{ translate('unit_price') }}
                    ({{ getCurrencySymbol(currencyCode: getCurrencyCode()) }})
                    <span class="input-required-icon">*</span>
                </label>
                <input type="number" min="0" step="0.01" placeholder="{{ translate('unit_price') }}"
                    name="unit_price" value="{{ $isEdit ? $product['unit_price'] : 0 }}" class="form-control"
                    required>
            </div>
            <div class="form-group">
                <label class="title-color ">
                    {{ translate('Local Currency') }}
                </label>
                <input type="text" placeholder="{{ translate('Local Currency if Not US Dollar') }}"
                    name="local_currency" value="{{ $isEdit ? $product['local_currency'] : '' }}"
                    class="form-control">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="title-color " for="supply_capacity">
                    {{ translate('Supply Capacity') }}
                    <span class="input-required-icon">*</span>
                </label>
                <input type="number" min="1" value="1" step="1"
                    placeholder="{{ translate('supply_capacity') }}" name="supply_capacity" id="supply_capacity"
                    class="form-control" required value="{{ $isEdit ? $product['supply_capacity'] : '' }}">
            </div>
            <div class="form-group">
                <label class="title-color">{{ translate('Supply Unit') }}</label>
                <select class="js-example-basic-multiple form-control" name="supply_unit">
                    @foreach ($units as $unit)
                        <option value="{{ $unit }}"
                            {{ isset($product['supply_unit']) && $unit == $product['supply_unit'] ? 'selected' : '' }}>
                            {{ $unit }}
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
                <label class="title-color">{{ translate('Delivery Terms') }}</label>
                <select class="form-control" name="delivery_terms" id="delivery_terms">
                    @php
                        $deliveryTerms = ['CFR', 'FOB', 'CIF', 'EXW', 'FCA', 'FAS', 'CPT', 'CIP', 'DAP', 'DPU', 'DDP'];
                    @endphp
                    @foreach ($deliveryTerms as $term)
                        <option value="{{ $term }}"
                            {{ $isEdit ? ($product['delivery_terms'] == $term ? 'selected' : '') : '' }}>
                            {{ $term }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="title-color">{{ translate('Delivery Mode') }}</label>
                <select class="form-control" name="delivery_mode">
                    @php
                        $deliveryModes = ['Air', 'Sea', 'Rail', 'Road', 'Courier', 'Multimodal', 'Pipeline', 'Drone'];
                    @endphp
                    @foreach ($deliveryModes as $mode)
                        <option value="{{ $mode }}"
                            {{ $isEdit ? ($product['delivery_mode'] == $mode ? 'selected' : '') : '' }}>
                            {{ $mode }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row" id="hideforexw">
            <div class="form-group">
                <label class="form-label">{{ translate('Place of Loading') }}</label>
                <input type="text" class="form-control" name="place_of_loading"
                    value="{{ $isEdit ? $product['place_of_loading'] : '' }}" placeholder="e.g., Shanghai, Ningbo">
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Port of Loading') }}</label>
                <select class="form-control" name="port_of_loading">
                    <option value="Sea_Port"
                        {{ $isEdit ? ($product['port_of_loading'] == 'Sea_Port' ? 'selected' : '') : '' }}>
                        Sea
                        Port</option>
                    <option value="ICD"
                        {{ $isEdit ? ($product['port_of_loading'] == 'ICD' ? 'selected' : '') : '' }}>ICD
                    </option>
                    <option value="Air_Port"
                        {{ $isEdit ? ($product['port_of_loading'] == 'Air_Port' ? 'selected' : '') : '' }}>
                        Air
                        Port</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Production Lead Time') }}</label>
                <input type="text" class="form-control" name="lead_time"
                    value="{{ $isEdit ? $product['lead_time'] : '' }}" placeholder="e.g., 7-10 business days">
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Lead Time Unit') }}</label>
                <select class="js-example-basic-multiple form-control" name="lead_time_unit">
                    <option value="days"
                        {{ $isEdit ? ($product['lead_time_unit'] == 'days' ? 'selected' : '') : '' }}>
                        Days
                    </option>
                    <option value="months"
                        {{ $isEdit ? ($product['lead_time_unit'] == 'month' ? 'selected' : '') : '' }}>
                        Month
                    </option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-single">
                <label class="form-label">{{ translate('Payment Terms') }}</label>
                <select class="form-control" name="payment_terms">
                    <option value="">Select Payment Term</option>
                    @foreach ($paymentTerms as $term)
                        <option value="{{ $term }}"
                            {{ $isEdit && ($product['payment_terms'] ?? null) === $term ? 'selected' : '' }}>
                            {{ $term }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Internal Packing') }}</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="dimensionsInput" placeholder="e.g., 10x5x2"
                        value="{{ $isEdit ? ($product['dimensions_per_unit'] ? explode(' ', $product['dimensions_per_unit'])[0] : '') : '' }}">

                    <select class="form-select form-select-sm" id="unitSelect" style="max-width: 115px;border-radius: 0px 8px 8px 0px;">
                        @php
                            $selectedUnit =
                                $isEdit && isset($product['dimensions_per_unit'])
                                    ? explode(' ', $product['dimensions_per_unit'])[1] ?? 'cm'
                                    : 'cm';
                        @endphp
                        @foreach ($units as $unit)
                            <option value="{{ $unit }}" {{ $selectedUnit == $unit ? 'selected' : '' }}>
                                {{ $unit }}</option>
                        @endforeach
                    </select>
                </div>

                <input type="hidden" name="dimensions_per_unit" id="originalDimensions"
                    value="{{ $isEdit ? $product['dimensions_per_unit'] ?? '' : '' }}">
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Internal Packing Type') }}</label>
                <select class="form-control" name="packing_type" required>
                    <option value="">Select Packing Type</option>

                    <optgroup label="Bags">
                        <option value="PP Bag"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'PP Bag' ? 'selected' : '' }}>PP Bag
                        </option>
                        <option value="HDPE Bag"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'HDPE Bag' ? 'selected' : '' }}>HDPE
                            Bag</option>
                        <option value="Jumbo Bag"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Jumbo Bag' ? 'selected' : '' }}>Jumbo
                            Bag</option>
                        <option value="Woven Sack"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Woven Sack' ? 'selected' : '' }}>
                            Woven Sack</option>
                    </optgroup>

                    <optgroup label="Boxes & Cartons">
                        <option value="Carton"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Carton' ? 'selected' : '' }}>Carton
                        </option>
                        <option value="Corrugated Box"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Corrugated Box' ? 'selected' : '' }}>
                            Corrugated Box</option>
                        <option value="Paper Box"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Paper Box' ? 'selected' : '' }}>Paper
                            Box</option>
                    </optgroup>

                    <optgroup label="Drums & Containers">
                        <option value="Plastic Drum"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Plastic Drum' ? 'selected' : '' }}>
                            Plastic Drum</option>
                        <option value="Steel Drum"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Steel Drum' ? 'selected' : '' }}>
                            Steel Drum</option>
                        <option value="IBC Tank"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'IBC Tank' ? 'selected' : '' }}>IBC
                            Tank</option>
                        <option value="Plastic Container"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Plastic Container' ? 'selected' : '' }}>
                            Plastic Container</option>
                    </optgroup>

                    <optgroup label="Crates & Pallets">
                        <option value="Wooden Crate"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Wooden Crate' ? 'selected' : '' }}>
                            Wooden Crate</option>
                        <option value="Plastic Crate"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Plastic Crate' ? 'selected' : '' }}>
                            Plastic Crate</option>
                        <option value="Palletized"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Palletized' ? 'selected' : '' }}>
                            Palletized</option>
                    </optgroup>

                    <optgroup label="Others">
                        <option value="Bulk"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Bulk' ? 'selected' : '' }}>Bulk
                        </option>
                        <option value="Vacuum Pack"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Vacuum Pack' ? 'selected' : '' }}>
                            Vacuum Pack</option>
                        <option value="Shrink Wrap"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Shrink Wrap' ? 'selected' : '' }}>
                            Shrink Wrap</option>
                        <option value="Custom Packaging"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Custom Packaging' ? 'selected' : '' }}>
                            Custom Packaging</option>
                    </optgroup>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Master Packing') }}</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="masterPackingInput" placeholder="e.g., 5x1, 10x1"
                        value="{{ $isEdit ? ($product['master_packing'] ? explode(' ', $product['master_packing'])[0] : '') : '' }}"
                        required>

                    <select class="form-select form-select-sm" id="masterUnitSelect" style="max-width: 115px;border-radius: 0px 8px 8px 0px;">
                        @php
                            $selectedMasterUnit =
                                $isEdit && isset($product['master_packing'])
                                    ? explode(' ', $product['master_packing'])[1] ?? 'pcs'
                                    : 'pcs';
                        @endphp
                        @foreach ($units as $unit)
                            <option value="{{ $unit }}"
                                {{ $selectedMasterUnit == $unit ? 'selected' : '' }}>{{ $unit }}</option>
                        @endforeach
                    </select>
                </div>

                <input type="hidden" name="master_packing" id="masterPackingHidden"
                    value="{{ $isEdit ? $product['master_packing'] ?? '' : '' }}">
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Master Packing Type') }}</label>
                <select class="form-control" name="master_packing_type">
                    <option value="">Select Packing Type</option>

                    <optgroup label="Bags">
                        <option value="PP Bag"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'PP Bag' ? 'selected' : '' }}>PP Bag
                        </option>
                        <option value="HDPE Bag"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'HDPE Bag' ? 'selected' : '' }}>HDPE
                            Bag</option>
                        <option value="Jumbo Bag"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Jumbo Bag' ? 'selected' : '' }}>
                            Jumbo
                            Bag</option>
                        <option value="Woven Sack"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Woven Sack' ? 'selected' : '' }}>
                            Woven Sack</option>
                    </optgroup>

                    <optgroup label="Boxes & Cartons">
                        <option value="Carton"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Carton' ? 'selected' : '' }}>Carton
                        </option>
                        <option value="Corrugated Box"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Corrugated Box' ? 'selected' : '' }}>
                            Corrugated Box</option>
                        <option value="Paper Box"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Paper Box' ? 'selected' : '' }}>
                            Paper
                            Box</option>
                    </optgroup>

                    <optgroup label="Drums & Containers">
                        <option value="Plastic Drum"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Plastic Drum' ? 'selected' : '' }}>
                            Plastic Drum</option>
                        <option value="Steel Drum"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Steel Drum' ? 'selected' : '' }}>
                            Steel Drum</option>
                        <option value="IBC Tank"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'IBC Tank' ? 'selected' : '' }}>IBC
                            Tank</option>
                        <option value="Plastic Container"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Plastic Container' ? 'selected' : '' }}>
                            Plastic Container</option>
                    </optgroup>

                    <optgroup label="Crates & Pallets">
                        <option value="Wooden Crate"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Wooden Crate' ? 'selected' : '' }}>
                            Wooden Crate</option>
                        <option value="Plastic Crate"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Plastic Crate' ? 'selected' : '' }}>
                            Plastic Crate</option>
                        <option value="Palletized"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Palletized' ? 'selected' : '' }}>
                            Palletized</option>
                    </optgroup>

                    <optgroup label="Others">
                        <option value="Bulk"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Bulk' ? 'selected' : '' }}>Bulk
                        </option>
                        <option value="Vacuum Pack"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Vacuum Pack' ? 'selected' : '' }}>
                            Vacuum Pack</option>
                        <option value="Shrink Wrap"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Shrink Wrap' ? 'selected' : '' }}>
                            Shrink Wrap</option>
                        <option value="Custom Packaging"
                            {{ $isEdit && ($product['packing_type'] ?? null) === 'Custom Packaging' ? 'selected' : '' }}>
                            Custom Packaging</option>
                    </optgroup>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Load Capacity per Lot') }}</label>
                <input type="text" class="form-control" name="load_capacity_per_lot"
                    value="{{ $isEdit ? $product['load_capacity_per_lot'] ?? '' : '' }}"
                    placeholder="e.g., 1000 kg, 5000 pcs">
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Dimension Unit') }}</label><select class="form-control"
                    name="dimension_unit" required>
                    <option value="">Select Unit</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit }}"
                            {{ $isEdit && ($product['dimension_unit'] ?? null) === $unit ? 'selected' : '' }}>
                            {{ $unit }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-single">
                <label class="form-label">{{ translate('Container Type') }}</label>
                <select class="form-control" name="container" required>
                    <option value="">Select Container Type</option>
                    <optgroup label="Standard Containers">
                        <option value="20 ft Standard Container"
                            {{ $isEdit && ($product['container'] ?? null) === '20 ft Standard Container' ? 'selected' : '' }}>
                            20 ft Standard Container
                        </option>
                        <option value="40 ft Standard Container"
                            {{ $isEdit && ($product['container'] ?? null) === '40 ft Standard Container' ? 'selected' : '' }}>
                            40 ft Standard Container
                        </option>
                        <option value="40 ft High Cube Container"
                            {{ $isEdit && ($product['container'] ?? null) === '40 ft High Cube Container' ? 'selected' : '' }}>
                            40 ft High Cube Container
                        </option>
                    </optgroup>

                    <optgroup label="Special Containers">
                        <option value="Open Top Container"
                            {{ $isEdit && ($product['container'] ?? null) === 'Open Top Container' ? 'selected' : '' }}>
                            Open Top Container
                        </option>
                        <option value="Flat Rack Container"
                            {{ $isEdit && ($product['container'] ?? null) === 'Flat Rack Container' ? 'selected' : '' }}>
                            Flat Rack Container
                        </option>
                        <option value="Tank Container"
                            {{ $isEdit && ($product['container'] ?? null) === 'Tank Container' ? 'selected' : '' }}>
                            Tank Container
                        </option>
                        <option value="Refrigerated Container"
                            {{ $isEdit && ($product['container'] ?? null) === 'Refrigerated Container' ? 'selected' : '' }}>
                            Refrigerated Container
                        </option>
                    </optgroup>

                    <optgroup label="Other Shipping Modes">
                        <option value="Bulk Cargo"
                            {{ $isEdit && ($product['container'] ?? null) === 'Bulk Cargo' ? 'selected' : '' }}>
                            Bulk Cargo
                        </option>
                        <option value="LCL (Less than Container Load)"
                            {{ $isEdit && ($product['container'] ?? null) === 'LCL (Less than Container Load)' ? 'selected' : '' }}>
                            LCL (Less than Container Load)
                        </option>
                    </optgroup>
                </select>
            </div>
            {{-- <div class="form-group">
                <label class="form-label">{{ translate('Size') }}</label>
                <input type="text" class="form-control" name="weight_per_unit"
                    value="{{ $isEdit ? $product['weight_per_unit'] ?? '' : '' }}" placeholder="e.g., 1.5kg">
            </div> --}}
        </div>
        <button type="button" class="prev-btn" data-prev="3">Prev</button>
        <button type="button" class="next-btn" data-next="5">Next</button>
    </div>
    <div class="step-section" data-step="5">
        <div class="form-row">
            <div class="form-single">
                <label class="form-label">{{ translate('Target Market') }}</label>

                @php
                    $selectedMarkets = $isEdit ? json_decode($product['target_market'] ?? '[]', true) ?? [] : [];
                @endphp

                <select id="target-market-select" class="js-example-basic-multiple form-control"
                    name="target_market[]" multiple>
                    @foreach ($countries as $country)
                        <option value="{{ $country['id'] }}"
                            {{ in_array($country['id'], old('target_market', $selectedMarkets)) ? 'selected' : '' }}>
                            {{ $country['name'] }}
                        </option>
                    @endforeach
                </select>

                <div id="selected-markets-preview" class="mt-2">
                    {{-- Blade fallback rendering (in case JS fails) --}}
                    @foreach ($countries as $country)
                        @if (in_array($country['id'], $selectedMarkets))
                            <span class="badge badge-primary mr-1 mb-2">{{ $country['name'] }}</span>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-single">
                <label class="title-color" for="description">{{ translate('Description of Product') }}
                </label>
                <textarea name="details" class="summernote" data-word-limit="1000">{!! $isEdit ? $product['details'] ?? '' : '' !!}</textarea>
                <small class="text-muted d-block mt-1" id="details-counter">1000 words left</small>
            </div>
        </div>
        <button type="button" class="prev-btn" data-prev="4">Prev</button>
        <button type="button" class="next-btn" data-next="6">Next</button>
    </div>
    <div class="step-section" data-step="6">
        <div class="form-row">
            <div class="form-single">
                <label class="form-label">{{ translate('Standard Specification') }}</label>
                <div class="d-flex" style="flex-direction: column; width: 100%;">
                    <div id="dynamic-data-box">
                        {{-- Title Groups Go Here --}}
                    </div>
                    <button type="button" class="btn btn-primary mt-2" id="add-title-group">Add Title</button>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-single">
                <label class="form-label">{{ translate('Technical Specification') }}</label>
                <div class="d-flex" style="flex-direction: column; width: 100%;">
                    <div id="dynamic-data-box-technical">
                        {{-- Title Groups Go Here --}}
                    </div>
                    <button type="button" class="btn btn-primary mt-2" id="add-title-group-technical">Add
                        Title</button>
                </div>
            </div>
        </div>
        <button type="button" class="prev-btn" data-prev="5">Prev</button>
        <button type="submit" class="submit-btn">Submit</button>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('target-market-select');
        const preview = document.getElementById('selected-markets-preview');

        function updatePreview() {
            const selectedOptions = Array.from(select.selectedOptions);
            preview.innerHTML = selectedOptions.map(opt =>
                `<span class="badge badge-danger mr-1 p-2">${opt.text}</span>`
            ).join('');
        }

        // Initial render
        updatePreview();

        // On change
        select.addEventListener('change', updatePreview);
    });
</script>
<script>
    $(document).ready(function() {
        // Initialize select2
        $('#target-market-select').select2({
            placeholder: "Select Target Markets",
            allowClear: true,
            width: '100%'
        });

        // Word counter helpers
        const NAME_LIMIT = 20;
        function countWordsPlain(text){ const t=(text||'').trim(); return t ? t.split(/\s+/).length : 0; }
        function trimToWordLimit(text, limit){ const t=(text||'').trim(); if(!t) return ''; const words=t.split(/\s+/); return words.length<=limit ? text : words.slice(0,limit).join(' '); }
        function countWordsFromHtml(html){ const text = $('<div>').html(html || '').text().trim(); return text ? text.split(/\s+/).length : 0; }

        // Name input: 20-word limit with live counter
        const $nameInput = $('#name');
        const $nameCounter = $('#name-word-counter');
        function updateNameCounter(){
            let val = $nameInput.val();
            const words = countWordsPlain(val);
            if(words > NAME_LIMIT){
                val = trimToWordLimit(val, NAME_LIMIT);
                $nameInput.val(val);
            }
            const remaining = Math.max(0, NAME_LIMIT - countWordsPlain($nameInput.val()));
            if($nameCounter.length){ $nameCounter.text(remaining + ' words left'); }
        }
        $nameInput.on('input', updateNameCounter);
        updateNameCounter();

        // Initialize Summernote with word-limit enforcement per editor
        const lastValidContent = {}; // keep last valid HTML for each editor by name
        function updateCounterByName(name, remaining){
            if(name === 'short_details'){
                $('#short-details-counter').text(remaining + ' words left');
            } else if(name === 'details'){
                $('#details-counter').text(remaining + ' words left');
            }
        }

        $('.summernote').each(function(){
            const $el = $(this);
            const name = $el.attr('name');
            const limit = parseInt($el.data('word-limit')) || Number.MAX_SAFE_INTEGER;
            lastValidContent[name] = $el.val() || '';

            $el.summernote({
                height: 200,
                toolbar: [ ['font', ['bold','italic','underline']] ],
                callbacks: {
                    onInit: function(){
                        const html = $el.summernote('code');
                        lastValidContent[name] = html;
                        const words = countWordsFromHtml(html);
                        updateCounterByName(name, Math.max(0, limit - words));
                    },
                    onChange: function(contents){
                        const words = countWordsFromHtml(contents);
                        if(words > limit){
                            // revert to last valid content
                            $el.summernote('code', lastValidContent[name]);
                            updateCounterByName(name, 0);
                            return;
                        }
                        lastValidContent[name] = contents;
                        updateCounterByName(name, Math.max(0, limit - words));
                    }
                }
            });
        });
    });
</script>
<script>
    $('#delivery_terms').on('change', function() {
        const hidethiselement = $('#hideforexw');
        const selectedValue = $(this).val();
        if (selectedValue === 'EXW') {
            $(this).val('EXW');
            hidethiselement.hide();
        } else {
            hidethiselement.show();
        }
    });
</script>
<script>
    const dimensionsInput = document.getElementById('dimensionsInput');
    const unitSelect = document.getElementById('unitSelect');
    const originalInput = document.getElementById('originalDimensions');

    function updateOriginalValue() {
        const dims = dimensionsInput.value.trim();
        const unit = unitSelect.value;
        originalInput.value = dims ? `${dims} ${unit}` : '';
    }

    dimensionsInput.addEventListener('input', updateOriginalValue);
    unitSelect.addEventListener('change', updateOriginalValue);

    // Optional: call it initially to sync values
    updateOriginalValue();
</script>
<script>
    const masterPackingInput = document.getElementById('masterPackingInput');
    const masterUnitSelect = document.getElementById('masterUnitSelect');
    const masterPackingHidden = document.getElementById('masterPackingHidden');

    function updateMasterPackingValue() {
        const value = masterPackingInput.value.trim();
        const unit = masterUnitSelect.value;
        masterPackingHidden.value = value ? `${value} ${unit}` : '';
    }

    masterPackingInput.addEventListener('input', updateMasterPackingValue);
    masterUnitSelect.addEventListener('change', updateMasterPackingValue);

    // Initialize on load
    updateMasterPackingValue();
</script>

{{-- HS Code Autocomplete Styles --}}
<style>
.hs-suggestions-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #ddd;
    border-top: none;
    max-height: 200px;
    overflow-y: auto;
    z-index: 1000;
    display: none;
}

.hs-suggestion-item {
    padding: 10px;
    cursor: pointer;
    border-bottom: 1px solid #eee;
    font-size: 14px;
}

.hs-suggestion-item:hover {
    background-color: #f5f5f5;
}

.hs-suggestion-item:last-child {
    border-bottom: none;
}

.hs-suggestion-code {
    font-weight: bold;
    color: #007bff;
}

.hs-suggestion-desc {
    color: #666;
    margin-top: 2px;
    font-size: 12px;
}

.hs-loading {
    padding: 10px;
    text-align: center;
    color: #666;
    font-style: italic;
}
</style>

{{-- HS Code Autocomplete Script --}}
<script>
$(document).ready(function() {
    let hsCodeTimeout;
    const hsCodeInput = $('#hts_code');
    const suggestionDropdown = $('#hts_code_suggestions');
    
    // Get the correct route based on current context
    const searchRoute = @if(auth('admin')->check())
        '{{ route("admin.products.search-hs-codes") }}'
    @else
        '{{ route("vendor.products.search-hs-codes") }}'
    @endif;

    hsCodeInput.on('input', function() {
        const query = $(this).val().trim();
        
        // Clear previous timeout
        clearTimeout(hsCodeTimeout);
        
        if (query.length < 2) {
            suggestionDropdown.hide().empty();
            return;
        }

        // Show loading
        suggestionDropdown.show().html('<div class="hs-loading">Searching...</div>');

        // Debounce the search
        hsCodeTimeout = setTimeout(function() {
            $.ajax({
                url: searchRoute,
                method: 'GET',
                data: { query: query },
                success: function(data) {
                    suggestionDropdown.empty();
                    
                    if (data.length === 0) {
                        suggestionDropdown.html('<div class="hs-loading">No results found</div>');
                        return;
                    }

                    data.forEach(function(item) {
                        const suggestionItem = $(`
                            <div class="hs-suggestion-item" data-hs-code="${item.hs_code}">
                                <div class="hs-suggestion-code">${item.hs_code}</div>
                                <div class="hs-suggestion-desc">${item.description}</div>
                            </div>
                        `);
                        
                        suggestionItem.on('click', function() {
                            hsCodeInput.val($(this).data('hs-code'));
                            suggestionDropdown.hide().empty();
                        });
                        
                        suggestionDropdown.append(suggestionItem);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('HS Code search error:', error);
                    suggestionDropdown.html('<div class="hs-loading">Error loading results</div>');
                }
            });
        }, 300); // 300ms delay
    });

    // Hide suggestions when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#hts_code, #hts_code_suggestions').length) {
            suggestionDropdown.hide().empty();
        }
    });

    // Hide suggestions on escape key
    hsCodeInput.on('keydown', function(e) {
        if (e.key === 'Escape') {
            suggestionDropdown.hide().empty();
        }
    });

    // Image validation helpers
    function isSquare(width, height) { return width === height; }
    function formatBytes(bytes){ if(bytes===0) return '0 B'; const k=1024; const sizes=['B','KB','MB','GB']; const i=Math.floor(Math.log(bytes)/Math.log(k)); return parseFloat((bytes/Math.pow(k,i)).toFixed(2))+' '+sizes[i]; }

    // Validate file input with 1:1 aspect ratio requirement (images) and preview in a grid boxes
    function setupImageInput(opts){
        const input = document.getElementById(opts.inputId);
        const errorBox = document.getElementById(opts.errorId);
        const preview = document.getElementById(opts.previewId);
        if(!input) return;

        input.addEventListener('change', function(){
            errorBox && (errorBox.style.display='none', errorBox.textContent='');
            if(preview) preview.innerHTML='';

            const files = Array.from(input.files || []);
            if(!files.length) return;

            let hasError = false;
            const validFiles = [];

            const pending = files.map(file => new Promise(resolve => {
                const type = file.type || '';
                // Allow PDFs only for certificates; images for others
                if(opts.allowPdf && type === 'application/pdf'){
                    validFiles.push({file, isPdf: true});
                    return resolve();
                }
                if(!type.startsWith('image/')){
                    hasError = true; return resolve();
                }
                const img = new Image();
                img.onload = function(){
                    if(!isSquare(img.width, img.height)){
                        hasError = true; // reject non-square
                    } else {
                        validFiles.push({file, isPdf:false, width: img.width, height: img.height});
                    }
                    URL.revokeObjectURL(img.src);
                    resolve();
                };
                img.onerror = function(){ hasError = true; resolve(); };
                img.src = URL.createObjectURL(file);
            }));

            Promise.all(pending).then(() => {
                // If any invalid files detected, show error and clear input to block submission
                if(hasError){
                    if(errorBox){
                        errorBox.textContent = 'Only square images (1:1) are allowed. Please upload images with equal width and height.';
                        errorBox.style.display='block';
                    }
                    input.value = '';
                    if(preview) preview.innerHTML='';
                    return;
                }

                // Render previews as square boxes
                if(preview){
                    validFiles.forEach(item => {
                        const box = document.createElement('div');
                        box.className = 'upload-preview-box';
                        if(item.isPdf){
                            box.innerHTML = `<div class="pdf-chip">PDF: ${item.file.name}</div>`;
                        } else {
                            const url = URL.createObjectURL(item.file);
                            box.innerHTML = `<img src="${url}" alt="preview"/>`;
                        }
                        preview.appendChild(box);
                    });
                }
            });
        });
    }

    setupImageInput({ inputId: 'thumbnail', errorId: 'thumbnail-error', previewId: 'thumbnail-preview' });
    setupImageInput({ inputId: 'extra_images', errorId: 'extra_images-error', previewId: 'extra_images-preview' });

    // Handle delete click for existing images (requires backend endpoint)
    $(document).on('click', '.delete-image-btn', function() {
        const btn = $(this);
        const type = btn.data('type'); // 'thumbnail' | 'extra'
        const src = btn.data('src');
        if(!confirm('Remove this image?')) return;

        const url = type === 'thumbnail'
            ? (@if(auth('admin')->check()) '{{ route("admin.products.delete-image", ["type" => "thumbnail", "product" => $product->id ?? 0]) }}' @else '{{ route("vendor.products.delete-image", ["type" => "thumbnail", "product" => $product->id ?? 0]) }}' @endif)
            : (@if(auth('admin')->check()) '{{ route("admin.products.delete-image", ["type" => "extra", "product" => $product->id ?? 0]) }}' @else '{{ route("vendor.products.delete-image", ["type" => "extra", "product" => $product->id ?? 0]) }}' @endif);

        $.ajax({
            url: url,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                src: src
            },
            success: function() {
                btn.closest('.upload-preview-box').remove();
            },
            error: function() {
                alert('Failed to delete image.');
            }
        });
    });
    setupImageInput({ inputId: 'certificates', errorId: 'certificates-error', previewId: 'certificates-preview', allowPdf: true });
});
</script>

<style>
/* Upload UI (box format) */
.upload-box { border: 1px dashed #cbd5e1; padding: 14px; border-radius: 10px; background:#fbfbfb; }
.upload-instructions { font-size: 12px; color:#475569; margin-top:6px; }
.upload-error { font-size: 12px; }
/* Larger, cleaner cards */
.upload-preview-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 12px; margin-top: 10px; }
.upload-preview-box { width: 100%; aspect-ratio: 1/1; position: relative; border:1px solid #e2e8f0; border-radius: 10px; overflow: hidden; background: linear-gradient(180deg,#fff,#fafafa); box-shadow: 0 2px 6px rgba(0,0,0,0.05); transition: box-shadow .2s ease, transform .2s ease; }
.upload-preview-box:hover { box-shadow: 0 6px 16px rgba(0,0,0,0.10); transform: translateY(-2px); }
.upload-preview-box img { width: 100%; height: 100%; object-fit: cover; display:block; }
/* Subtle overlay on hover */
.upload-preview-box::after { content:""; position:absolute; inset:0; background: radial-gradient(transparent, rgba(0,0,0,0.15)); opacity:0; transition: opacity .2s ease; }
.upload-preview-box:hover::after { opacity:1; }
.pdf-chip { font-size: 12px; padding: 8px 10px; background:#eef2ff; color:#3730a3; border-radius: 8px; border:1px solid #c7d2fe; text-align:center; box-shadow: inset 0 1px 0 rgba(255,255,255,0.6); }
</style>
   <style>
   /* Hover delete button */
   .hover-delete { position: relative; }
   .delete-image-btn { position:absolute; top:8px; right:8px; background:#ef4444; color:#fff; border:none; border-radius:6px; padding:8px 10px; font-size:14px; cursor:pointer; display:none; box-shadow: 0 2px 6px rgba(0,0,0,0.15); }
   .hover-delete:hover .delete-image-btn { display:block; }
   </style>
