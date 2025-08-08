@php
    $isEdit = isset($leads);
@endphp
<link rel="stylesheet" href="{{ theme_asset('public/assets/custom-css/progress-form.css') }}">
<script src="{{ theme_asset('public/js/progress-form.js') }}"></script>
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
    </div>
    <div class="form-header">
        <h1>{{ $isEdit ? 'Edit Lead' : 'Create Lead' }}</h1>
        <p>
            {{ $isEdit ? 'Update the details of your Lead' : 'Fill in the required details to create Lead' }}
        </p>
    </div>
    <div class="step-section" data-step="1">
        <div class="form-row {{ auth('seller')->check() ? 'd-none' : '' }}">
            <div class="form-group">
                <label for="buyer_seller" class="title-color">
                    {{ translate('buy_leads_or_sell_offer') }}
                    <span class="input-required-icon">*</span>
                </label>
                @php
                    $selectedType = old('type') ?? ($isEdit ? $leads->type : (auth('seller')->check() ? 'seller' : ''));
                @endphp

                <select class="form-control" name="type" required>
                    <option value="" disabled {{ $selectedType == '' ? 'selected' : '' }}>
                        {{ translate('select_buyer_or_seller') }}
                    </option>
                    @if (auth('admin')->check())
                        <option value="buyer" {{ $selectedType == 'buyer' ? 'selected' : '' }}>
                            {{ translate('buy_leads') }}
                        </option>
                    @endif
                    <option value="seller" {{ $selectedType == 'seller' ? 'selected' : '' }}>
                        {{ translate('sell_offer') }}
                    </option>
                </select>

            </div>
            <div class="form-group">
                <label for="compliance_status" class="form-label">Compliance Status</label>
                <select name="compliance_status" id="compliance_status" class="form-control">
                    @php
                        if (auth('admin')->check()) {
                            $statusList = ['pending', 'approved', 'flagged'];
                        } else {
                            $statusList = ['pending'];
                        }
                    @endphp
                    @foreach ($statusList as $status)
                        <option value="{{ $status }}"
                            {{ old('compliance_status', $isEdit ? $leads->compliance_status : 'pending') == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="industry" class="form-label">Industry</label>
                <select name="industry" id="industry" class="form-control" required>
                    <option value="" disabled
                        {{ old('industry', $isEdit ? $leads->industry : '') == '' ? 'selected' : '' }}>
                        Select an Industry
                    </option>
                    @foreach ($industry as $item)
                        <option value="{{ $item->id }}"
                            {{ old('industry', $isEdit ? $leads->industry : '') == $item->id ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="sub-category-select" class="form-label">{{ translate('sub_Category') }}</label>
                @if (auth('admin')->check())
                    <select name="sub_category_id" id="sub-category-select"
                        class="form-control action-get-request-onchange"
                        data-url-prefix="{{ route('admin.products.get-categories') . '?parent_id=' }}"
                        data-element-id="sub-sub-category-select" data-element-type="select" required>
                    @else
                        <select name="sub_category_id" id="sub-category-select"
                            class="form-control action-get-request-onchange"
                            data-url-prefix="{{ route('vendor.products.get-categories') . '?parent_id=' }}"
                            data-element-id="sub-sub-category-select" data-element-type="select">
                @endif
                <option value="" disabled
                    {{ old('sub_category_id', $isEdit ? $leads->sub_category_id : '') == '' ? 'selected' : '' }}>
                    {{ translate('select_Sub_Category') }}
                </option>

                @if ($isEdit && isset($subCategories))
                    @foreach ($subCategories as $sub)
                        <option value="{{ $sub->id }}"
                            {{ old('sub_category_id', $leads->sub_category_id) == $sub->id ? 'selected' : '' }}>
                            {{ $sub->name }}
                        </option>
                    @endforeach
                @endif
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="product_id" class="form-label">Product Name</label>
                <select name="product_id" id="product_id" class="form-select" {{ $isEdit ? '' : 'required' }}>
                    @if ($isEdit && $leads->product)
                        <option value="{{ $leads->product_id }}" selected>Select a Option if Updating</option>
                    @endif
                </select>
            </div>

            <div class="form-group">
                <label for="hs_code" class="form-label">HS Code</label>
                <div class="position-relative">
                    <input type="text" name="hs_code" id="hs_code" class="form-control" 
                           placeholder="Enter HS Code or Product Description" autocomplete="off"
                           required value="{{ old('hs_code', $isEdit ? $leads->hs_code : '') }}">
                    <div id="hs_code_suggestions" class="hs-suggestions-dropdown"></div>
                </div>
            </div>
        </div>
        <div class="form-row">
            @if ($isEdit)
                <div class="form-group">
                    <label for="images" class="form-label">{{ translate('product_images') }}</label>
                    <input type="file" name="new_images[]" id="images" class="form-select" multiple
                        accept="image/*">
                </div>
            @else
                <div class="form-group">
                    <label for="imagePicker">Choose Images</label>
                    <input type="file" name="images[]" id="images" class="form-select" multiple accept="image/*">
                </div>
            @endif
            <div class="form-group">
                <label for="country" class="form-label">Origin</label>
                <select name="country" id="country" class="form-control" required>
                    <option value="" disabled
                        {{ old('country', $isEdit ? $leads->country : '') == '' ? 'selected' : '' }}>
                        Select a Country
                    </option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}"
                            {{ old('country', $isEdit ? $leads->country : '') == $country->id ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        @if ($isEdit)
            <div class="form-row">
                <div class="form-single">
                    <label class="form-label d-block">Preview Images:</label>

                    {{-- Existing images with remove button --}}
                    @if (isset($leads->images))
                        @php
                            $images = json_decode($leads->images);
                        @endphp
                        <div id="existing-images" class="d-flex flex-wrap gap-2">
                            @foreach ($images as $key => $item)
                                <div class="position-relative image-wrapper" style="width: 140px;"
                                    data-image="{{ $item }}">
                                    <img src="/{{ $item }}" alt="image" class="img-thumbnail"
                                        style="width: 100px; height: auto;">
                                    <button type="button"
                                        class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-existing">
                                        &times;
                                    </button>
                                    {{-- This field is used to pass the list of kept images --}}
                                    <input type="hidden" name="keep_images[]" value="{{ $item }}">
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- New image previews --}}
                    <div id="preview-images" class="d-flex flex-wrap gap-2 mt-3"></div>
                </div>
            </div>
        @endif
        <button type="button" class="next-btn" data-next="2">Next</button>
    </div>
    <div class="step-section d-none" data-step="2">
        <div class="form-row">
            <div class="form-single">
                <label for="description" class="form-label">Description</label>
                <textarea required id="details" name="details" class="form-control" placeholder="Enter description"
                    rows="1">{{ old('details', $isEdit ? $leads->details : '') }}</textarea>
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
            <div class="form-group">
                <label for="tags">{{ translate('tags') }}</label>
                <input type="text" name="tags" id="tags" class="form-control"
                    placeholder="{{ translate('enter_tags') }}"
                    value="{{ old('tags', $isEdit ? $leads->tags : '') }}">
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Size') }}</label>
                <input type="text" class="form-control" name="size" placeholder="e.g., 1.5kg"
                    value="{{ old('size', $isEdit ? $leads->size : '') }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="brand" class="form-label">Brand</label>
                <input type="text" name="brand" id="brand" class="form-control" placeholder="e.g., 'Reebok'"
                   value="{{ old('brand', $isEdit ? $leads->brand : '') }}">
            </div>
            <div class="form-group">
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
                    @endphp
                    @foreach ($packingTypes as $type)
                        <option value="{{ $type }}"
                            {{ old('packing_type', $isEdit ? $leads->packing_type : '') == $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="button" class="prev-btn" data-prev="1">Prev</button>
        <button type="button" class="next-btn" data-next="3">Next</button>
    </div>
    <div class="step-section d-none" data-step="3">
        <div class="form-row">
            <div class="form-group">
                <label for="rate" class="form-label">Rate</label>
                <div class="input-group">
                    @php
                        $currencies = ['USD', 'EUR', 'INR', 'PKR', 'SAR', 'AED'];
                        // Split rate if it includes a space (e.g., "150 USD")
                        $rateValue = old('rate', $isEdit ? $leads->rate ?? '' : '');
                        $rateParts = explode(' ', $rateValue);
                        $rateAmount = $rateParts[0] ?? '';
                        $rateCurrency = $rateParts[1] ?? 'USD';
                    @endphp

                    <input type="number" id="rate" class="form-control" placeholder="Enter Rate" required
                        value="{{ $rateAmount }}">

                    <select id="rate_currency" class="form-select" style="max-width: 120px;border-top-left-radius: 0px;border-bottom-left-radius: 0px;" required>
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency }}" {{ $rateCurrency == $currency ? 'selected' : '' }}>
                                {{ $currency }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <input type="hidden" name="rate" id="rate_combined"
                    value="{{ trim($rateAmount . ' ' . $rateCurrency) }}">
            </div>

            <div class="form-group">
                <label class="title-color" for="quantity_required">{{ translate('quantity_required') }}</label>
                <div class="input-group">
                    @php
                        $units = ['kg', 'ton', 'litre', 'meter', 'pack', 'box', 'piece', 'bag'];
                        $qtyValue = old('quantity_required', $isEdit ? $leads->quantity_required : '');
                        $qtyParts = explode(' ', $qtyValue);
                        $qtyAmount = $qtyParts[0] ?? '';
                        $qtyUnit = $qtyParts[1] ?? 'kg';
                    @endphp

                    <input type="number" id="quantity_required" class="form-control"
                        placeholder="{{ translate('enter_quantity_required') }}" required
                        value="{{ $qtyAmount }}">

                    <select id="quantity_unit" class="form-select" style="max-width: 120px;border-top-left-radius: 0px;border-bottom-left-radius: 0px;" required>
                        @foreach ($units as $unit)
                            <option value="{{ $unit }}" {{ $qtyUnit == $unit ? 'selected' : '' }}>
                                {{ strtoupper($unit) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <input type="hidden" name="quantity_required" id="quantity_required_combined"
                    value="{{ trim($qtyAmount . ' ' . $qtyUnit) }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="avl_stock">{{ translate('available_stock') }}</label>
                <input type="text" name="avl_stock" id="avl_stock" class="form-control"
                    placeholder="{{ translate('enter_available_stock') }}"
                    value="{{ old('avl_stock', $isEdit ? $leads->avl_stock : '') }}">
            </div>
            <div class="form-group">
                <label for="avl_stock_unit">{{ translate('available_stock_unit') }}</label>

                @php
                    $unitOptions = ['kg', 'ton', 'litre', 'meter', 'pack', 'box', 'piece', 'bag'];
                    $selectedUnit = old('avl_stock_unit', $isEdit ? $leads->avl_stock_unit : '');
                @endphp

                <select name="avl_stock_unit" id="avl_stock_unit" class="form-select">
                    <option value="" disabled {{ $selectedUnit == '' ? 'selected' : '' }}>
                        {{ translate('select_unit') }}
                    </option>
                    @foreach ($unitOptions as $unit)
                        <option value="{{ $unit }}" {{ $selectedUnit == $unit ? 'selected' : '' }}>
                            {{ strtoupper($unit) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="lead_time">{{ translate('lead_time') }}</label>
                <input type="text" name="lead_time" id="lead_time" class="form-control"
                    placeholder="{{ translate('enter_lead_time') }}"
                    value="{{ old('lead_time', $isEdit ? $leads->lead_time : '') }}">
            </div>
            <div class="form-group">
                <label for="payment_option">{{ translate('payment_option') }}</label>

                @php
                    $paymentOptions = [
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
                    $selectedPayment = old('payment_option', $isEdit ? $leads->payment_option : '');
                @endphp

                <select name="payment_option" id="payment_option" class="form-select">
                    <option value="" disabled {{ $selectedPayment == '' ? 'selected' : '' }}>
                        {{ translate('select_payment_option') }}
                    </option>
                    @foreach ($paymentOptions as $option)
                        <option value="{{ $option }}" {{ $selectedPayment == $option ? 'selected' : '' }}>
                            {{ $option }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>
        <div class="form-row">
            <div class="form-single">
                <label for="refund">{{ translate('refund_policy') }}</label>
                <input type="text" name="refund" id="refund" class="form-control"
                    placeholder="{{ translate('enter_refund_policy') }}"
                    value="{{ old('refund', $isEdit ? $leads->refund : '') }}">
            </div>
        </div>
        <button type="button" class="prev-btn" data-prev="2">Prev</button>
        <button type="button" class="next-btn" data-next="4">Next</button>
    </div>
    <div class="step-section d-none" data-step="4">
        <div class="form-row">
            <div class="form-group">
                <label class="title-color">{{ translate('Delivery Terms') }}</label>
                @php
                    $deliveryTerms = ['CFR', 'FOB', 'CIF', 'EXW', 'DDP', 'DAP'];
                    $selectedTerm = old('delivery_terms', $isEdit ? $leads->delivery_terms : '');
                @endphp
                <select class="form-control" name="delivery_terms">
                    <option value="" disabled {{ $selectedTerm == '' ? 'selected' : '' }}>
                        {{ translate('select_delivery_terms') }}
                    </option>
                    @foreach ($deliveryTerms as $term)
                        <option value="{{ $term }}" {{ $selectedTerm == $term ? 'selected' : '' }}>
                            {{ $term }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="title-color">{{ translate('Delivery Mode') }}</label>
                @php
                    $deliveryModes = ['Air', 'Rail', 'Sea', 'Road', 'Courier'];
                    $selectedMode = old('delivery_mode', $isEdit ? $leads->delivery_mode : '');
                @endphp
                <select class="form-control" name="delivery_mode">
                    <option value="" disabled {{ $selectedMode == '' ? 'selected' : '' }}>
                        {{ translate('select_delivery_mode') }}
                    </option>
                    @foreach ($deliveryModes as $mode)
                        <option value="{{ $mode }}" {{ $selectedMode == $mode ? 'selected' : '' }}>
                            {{ $mode }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Place of Loading') }}</label>
                <input type="text" class="form-control" name="place_of_loading"
                    placeholder="e.g., Shanghai, Ningbo"
                    value="{{ old('place_of_loading', $isEdit ? $leads->place_of_loading : '') }}">
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Port of Loading') }}</label>
                <select class="form-control" name="port_of_loading">
                    @foreach (['Factory', 'Sea_Port', 'ICD', 'Air_Port'] as $port)
                        <option value="{{ $port }}"
                            {{ old('port_of_loading', $isEdit ? $leads->port_of_loading : '') == $port ? 'selected' : '' }}>
                            {{ str_replace('_', ' ', $port) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="country" class="form-label">Origin</label>
                <select name="country" id="country" class="form-control" required>
                    <option value="" disabled
                        {{ old('country', $isEdit ? $leads->country : '') == '' ? 'selected' : '' }}>
                        Select a Country
                    </option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}"
                            {{ old('country', $isEdit ? $leads->country : '') == $country->id ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="city">{{ translate('city') }}</label>
                <input type="text" name="city" id="city" class="form-control"
                    placeholder="{{ translate('enter_city') }}"
                    value="{{ old('city', $isEdit ? $leads->city : '') }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-single">
                <label for="offer_type">{{ translate('offer_type') }}</label>
                <input type="text" name="offer_type" id="offer_type" class="form-control"
                    placeholder="{{ translate('enter_offer_type') }}"
                    value="{{ old('offer_type', $isEdit ? $leads->offer_type : '') }}">
            </div>
        </div>
        <button type="button" class="prev-btn" data-prev="3">Prev</button>
        <button type="submit" class="submit-btn">Submit</button>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@if ($isEdit)
    <script>
        const existingDynamicData = {!! $dynamicData !!};
    </script>
@endif
<script>
    function renderExistingDynamicData(data, containerId, isTechnical = false) {
        console.log('populating started');
        if (!Array.isArray(data)) return;

        const container = document.getElementById(containerId);

        data.forEach((group, titleIndex) => {
            const html = isTechnical ?
                getTitleGroupHtmlTechnical(titleIndex) :
                getTitleGroupHtml(titleIndex);

            container.insertAdjacentHTML('beforeend', html);

            // Set title input, even if it's null
            const titleInput = container.querySelector(
                `input[name="${isTechnical ? 'dynamic_data_technical' : 'dynamic_data'}[${titleIndex}][title]"]`
            );
            if (titleInput) {
                titleInput.value = group.title || '';
            }

            const subHeadsContainer = container.querySelector(
                `.sub-heads[data-title-index="${titleIndex}"]`
            );

            if (subHeadsContainer) {
                subHeadsContainer.innerHTML = ''; // Clear default sub-head

                const subHeadsRaw = group.sub_heads || {};
                const subHeadsArray = Array.isArray(subHeadsRaw) ?
                    subHeadsRaw :
                    Object.values(subHeadsRaw);

                if (subHeadsArray.length > 0) {
                    subHeadsArray.forEach((sub, subIndex) => {
                        const subHtml = isTechnical ?
                            getSubHeadRowHtmlTechnical(titleIndex, subIndex) :
                            getSubHeadRowHtml(titleIndex, subIndex);

                        subHeadsContainer.insertAdjacentHTML('beforeend', subHtml);

                        const subHeadInput = subHeadsContainer.querySelector(
                            `input[name="${isTechnical ? 'dynamic_data_technical' : 'dynamic_data'}[${titleIndex}][sub_heads][${subIndex}][sub_head]"]`
                        );
                        const subHeadDataInput = subHeadsContainer.querySelector(
                            `input[name="${isTechnical ? 'dynamic_data_technical' : 'dynamic_data'}[${titleIndex}][sub_heads][${subIndex}][sub_head_data]"]`
                        );

                        if (subHeadInput) subHeadInput.value = sub.sub_head || '';
                        if (subHeadDataInput) subHeadDataInput.value = sub.sub_head_data || '';
                    });
                } else {
                    // Insert one empty row if no subheads found
                    const subHtml = isTechnical ?
                        getSubHeadRowHtmlTechnical(titleIndex, 0) :
                        getSubHeadRowHtml(titleIndex, 0);

                    subHeadsContainer.insertAdjacentHTML('beforeend', subHtml);
                }
            }

            // Increment counters
            if (isTechnical) {
                titleCountTechnical++;
            } else {
                titleCount++;
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        renderExistingDynamicData(existingDynamicData, 'dynamic-data-box', false);
    });
</script>
<script>
    let titleCount = 0;

    function getTitleGroupHtml(titleIndex) {
        return `
        <div class="title-group border p-3 mb-3">
            <div class="mb-2 d-flex justify-content-between align-items-center gap-3">
                <input type="text" name="dynamic_data[${titleIndex}][title]" class="form-control me-2" placeholder="Title">
                <button type="button" class="btn btn-danger remove-title-group">Remove</button>
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
        <div class="row mb-2 sub-head-row" style="width: 100%; display: flex; margin: 0 auto; gap: 13px;">
            <div style="width: 44%;">
                <input type="text" name="dynamic_data[${titleIndex}][sub_heads][${subIndex}][sub_head]" class="form-control" placeholder="Sub Head">
            </div>
            <div style="width: 45%;">
                <input type="text" name="dynamic_data[${titleIndex}][sub_heads][${subIndex}][sub_head_data]" class="form-control" placeholder="Sub Head Data">
            </div>
            <div style="width: 8%;">
                <button type="button" class="btn btn-danger remove-sub-head">Remove</button>
            </div>
        </div>`;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('dynamic-data-box');
        if (container && container.children.length === 0) {
            container.insertAdjacentHTML('beforeend', getTitleGroupHtml(titleCount));
            titleCount++;
        }
    });

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
                return data.newOption ? `Add "${data.text}"` : data.text;
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const qtyInput = document.getElementById('quantity_required');
        const unitSelect = document.getElementById('quantity_unit');
        const hiddenCombined = document.getElementById('quantity_required_combined');

        function updateQuantityField() {
            const qty = qtyInput.value.trim();
            const unit = unitSelect.value.trim();
            hiddenCombined.value = qty && unit ? `${qty} ${unit}` : '';
        }

        qtyInput.addEventListener('input', updateQuantityField);
        unitSelect.addEventListener('change', updateQuantityField);

        updateQuantityField(); // Init on load
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rateInput = document.getElementById('rate');
        const rateCurrency = document.getElementById('rate_currency');
        const rateCombined = document.getElementById('rate_combined');

        const qtyInput = document.getElementById('quantity_required');
        const qtyUnit = document.getElementById('quantity_unit');
        const qtyCombined = document.getElementById('quantity_required_combined');

        function updateCombinedRate() {
            const rate = rateInput.value.trim();
            const currency = rateCurrency.value.trim();
            rateCombined.value = rate && currency ? `${rate} ${currency}` : '';
        }

        function updateCombinedQty() {
            const qty = qtyInput.value.trim();
            const unit = qtyUnit.value.trim();
            qtyCombined.value = qty && unit ? `${qty} ${unit}` : '';
        }

        rateInput.addEventListener('input', updateCombinedRate);
        rateCurrency.addEventListener('change', updateCombinedRate);

        qtyInput.addEventListener('input', updateCombinedQty);
        qtyUnit.addEventListener('change', updateCombinedQty);

        // Initialize on load
        updateCombinedRate();
        updateCombinedQty();
    });
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
    const hsCodeInput = $('#hs_code');
    const suggestionDropdown = $('#hs_code_suggestions');
    
    // Get the correct route based on current context
    const searchRoute = @if(auth('admin')->check())
        '{{ route("admin.leads.search-hs-codes") }}'
    @else
        '{{ route("vendor.leads.search-hs-codes") }}'
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
        if (!$(e.target).closest('#hs_code, #hs_code_suggestions').length) {
            suggestionDropdown.hide().empty();
        }
    });

    // Hide suggestions on escape key
    hsCodeInput.on('keydown', function(e) {
        if (e.key === 'Escape') {
            suggestionDropdown.hide().empty();
        }
    });
});
</script>
