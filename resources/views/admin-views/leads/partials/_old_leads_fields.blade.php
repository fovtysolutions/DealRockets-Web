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
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">5</div>
        </div>
    </div>
    <div class="form-header">
        <h1>{{ $isEdit ? 'Edit Lead' : 'Create Lead' }}</h1>
        <p>
            {{ $isEdit ? 'Update the details of your Lead' : 'Fill in the required details to create Lead' }}
        </p>
    </div>
    <div class="step-section" data-step="1">
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
                <select name="product_id" id="product_id" class="form-select" required>
                    @if ($isEdit && $leads->product)
                        <option value="{{ $leads->product->id }}" selected>{{ $leads->product->name }}</option>
                    @endif
                </select>
            </div>

            <div class="form-group">
                <label for="hs_code" class="form-label">HS Code</label>
                <input type="text" name="hs_code" id="hs_code" class="form-control" placeholder="Enter HS Code"
                    required value="{{ old('hs_code', $isEdit ? $leads->hs_code : '') }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-single">
                <label for="description" class="form-label">Description</label>
                <textarea required id="details" name="details" class="form-control" placeholder="Enter description" rows="1">{{ old('details', $isEdit ? $leads->details : '') }}</textarea>
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
        <button type="button" class="next-btn" data-next="2">Next</button>
    </div>
    <div class="step-section d-none" data-step="2">
        <div class="form-row">
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
            <div class="form-group">
                <label class="form-label">{{ translate('Size') }}</label>
                <input type="text" class="form-control" name="size" placeholder="e.g., 1.5kg"
                    value="{{ old('size', $isEdit ? $leads->size : '') }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="brand" class="form-label">Brand</label>
                <select name="brand" id="brand" class="form-control">
                    <option value="" disabled
                        {{ old('brand', $isEdit ? $leads->brand : '') == '' ? 'selected' : '' }}>
                        Select a Brand
                    </option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}"
                            {{ old('brand', $isEdit ? $leads->brand : '') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="tags">{{ translate('tags') }}</label>
                <input type="text" name="tags" id="tags" class="form-control"
                    placeholder="{{ translate('enter_tags') }}"
                    value="{{ old('tags', $isEdit ? $leads->tags : '') }}">
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
                <input type="text" name="avl_stock_unit" id="avl_stock_unit" class="form-control"
                    placeholder="{{ translate('enter_available_stock_unit') }}"
                    value="{{ old('avl_stock_unit', $isEdit ? $leads->avl_stock_unit : '') }}">
            </div>
        </div>
        <div class="form-row">
            @if ($isEdit)
                <div class="form-single">
                    <label for="images" class="form-label">{{ translate('product_images') }}</label>
                    <input type="file" name="new_images[]" id="images" class="form-select" multiple
                        accept="image/*">
                </div>
            @else
                <div class="form-single">
                    <label for="imagePicker">Choose Images</label>
                    <input type="file" name="images[]" id="images" class="form-select" multiple
                        accept="image/*">
                </div>
            @endif
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
        <button type="button" class="prev-btn" data-prev="1">Prev</button>
        <button type="button" class="next-btn" data-next="3">Next</button>
    </div>
    <div class="step-section d-none" data-step="3">
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
                <label for="rate" class="form-label">Rate</label>
                <input type="number" name="rate" id="rate" class="form-control" placeholder="Enter Rate"
                    required value="{{ old('rate', $isEdit ? $leads->rate : '') }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="title-color">{{ translate('Delivery Terms') }}</label>
                <select class="form-control" name="delivery_terms">
                    @foreach (['CFR', 'FOB'] as $term)
                        <option value="{{ $term }}"
                            {{ old('delivery_terms', $isEdit ? $leads->delivery_terms : '') == $term ? 'selected' : '' }}>
                            {{ $term }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="title-color">{{ translate('Delivery Mode') }}</label>
                <select class="form-control" name="delivery_mode">
                    @foreach (['Air', 'Rail', 'Sea'] as $mode)
                        <option value="{{ $mode }}"
                            {{ old('delivery_mode', $isEdit ? $leads->delivery_mode : '') == $mode ? 'selected' : '' }}>
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
        <button type="button" class="prev-btn" data-prev="2">Prev</button>
        <button type="button" class="next-btn" data-next="4">Next</button>
    </div>
    <div class="step-section d-none" data-step="4">
        <div class="form-row">
            <div class="form-group">
                <label for="buyer_seller" class="title-color">
                    {{ translate('buyer_or_seller') }}
                    <span class="input-required-icon">*</span>
                </label>
                <select class="form-control" name="type" required>
                    <option value="" disabled
                        {{ old('type', $isEdit ? $leads->type : '') == '' ? 'selected' : '' }}>
                        {{ translate('select_buyer_or_seller') }}
                    </option>
                    @if (auth('admin')->check())
                        <option value="buyer"
                            {{ old('type', $isEdit ? $leads->type : '') == 'buyer' ? 'selected' : '' }}>
                            {{ translate('buyer') }}
                        </option>
                    @endif
                    <option value="seller"
                        {{ old('type', $isEdit ? $leads->type : '') == 'seller' ? 'selected' : '' }}>
                        {{ translate('seller') }}
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label class="title-color" for="name">{{ translate('Lead_name') }}</label>
                <input type="text" name="name" id="name" class="form-control"
                    placeholder="{{ translate('new_lead') }}"
                    value="{{ old('name', $isEdit ? $leads->name : '') }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="title-color" for="company_name">{{ translate('company_name') }}</label>
                <input type="text" name="company_name" id="company_name" class="form-control"
                    placeholder="{{ translate('enter_company_name') }}"
                    value="{{ old('company_name', $isEdit ? $leads->company_name : '') }}">
            </div>

            <div class="form-group">
                <label class="title-color" for="contact_number">
                    {{ translate('contact_number') }} <span class="input-required-icon">*</span>
                </label>
                <input type="text" name="contact_number" id="contact_number" class="form-control"
                    placeholder="{{ translate('enter_contact_number') }}"
                    value="{{ old('contact_number', $isEdit ? $leads->contact_number : '') }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="city">{{ translate('city') }}</label>
                <input type="text" name="city" id="city" class="form-control"
                    placeholder="{{ translate('enter_city') }}"
                    value="{{ old('city', $isEdit ? $leads->city : '') }}">
            </div>
            <div class="form-group">
                <label for="refund">{{ translate('refund_policy') }}</label>
                <input type="text" name="refund" id="refund" class="form-control"
                    placeholder="{{ translate('enter_refund_policy') }}"
                    value="{{ old('refund', $isEdit ? $leads->refund : '') }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-single">
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
        <button type="button" class="prev-btn" data-prev="3">Prev</button>
        <button type="button" class="next-btn" data-next="5">Next</button>
    </div>
    <div class="step-section d-none" data-step="5">
        <div class="form-row">
            <div class="form-group">
                <label class="title-color" for="quantity_required">{{ translate('quantity_required') }}</label>
                <input type="number" name="quantity_required" id="quantity_required" class="form-control"
                    placeholder="{{ translate('enter_quantity_required') }}" required
                    value="{{ old('quantity_required', $isEdit ? $leads->quantity_required : '') }}">
            </div>

            <div class="form-group">
                <label class="title-color" for="unit">
                    {{ translate('Unit') }} <span class="input-required-icon">*</span>
                </label>
                <input type="text" name="unit" id="unit" class="form-control"
                    placeholder="{{ translate('Enter Unit') }}" required
                    value="{{ old('unit', $isEdit ? $leads->unit : '') }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="title-color" for="term">{{ translate('Term') }}
                    <span class="input-required-icon">*</span>
                </label>
                <input type="text" name="term" id="term" class="form-control"
                    placeholder="{{ translate('Enter Term') }}" required
                    value="{{ old('term', $isEdit ? $leads->term : '') }}">
            </div>

            <div class="form-group">
                <label class="title-color" for="buying_frequency">{{ translate('buying_frequency') }}
                    <span class="input-required-icon">*</span>
                </label>
                <select class="js-select2-custom form-control" name="buying_frequency" required>
                    <option value="" disabled
                        {{ old('buying_frequency', $isEdit ? $leads->buying_frequency : '') == '' ? 'selected' : '' }}>
                        {{ translate('select_buying_frequency') }}
                    </option>
                    @foreach (['daily', 'weekly', 'monthly', 'quarterly', 'yearly'] as $freq)
                        <option value="{{ $freq }}"
                            {{ old('buying_frequency', $isEdit ? $leads->buying_frequency : '') == $freq ? 'selected' : '' }}>
                            {{ translate($freq) }}
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
                <input type="text" name="payment_option" id="payment_option" class="form-control"
                    placeholder="{{ translate('enter_payment_option') }}"
                    value="{{ old('payment_option', $isEdit ? $leads->payment_option : '') }}">
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
        <button type="button" class="prev-btn" data-prev="4">Prev</button>
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

            const titleInput = container.querySelector(
                `input[name="${isTechnical ? 'dynamic_data_technical' : 'dynamic_data'}[${titleIndex}][title]"]`
            );
            if (titleInput) {
                titleInput.value = group.title || '';
            }

            const subHeadsContainer = container.querySelector(`.sub-heads[data-title-index="${titleIndex}"]`);
            subHeadsContainer.innerHTML = ''; // Clear default first sub-head

            if (group.sub_heads && Array.isArray(group.sub_heads)) {
                group.sub_heads.forEach((sub, subIndex) => {
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
            }

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
                return data.newOption ? `<em>Add "${data.text}"</em>` : data.text;
            }
        });
    });
</script>
