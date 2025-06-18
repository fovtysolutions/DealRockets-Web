@php
    $isEdit = isset($product);
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
                    <select
                        class="form-control action-get-request-onchange"
                        name="sub_category_id" id="sub-category-select"
                        data-id="{{ $isEdit ? $product['sub_category_id'] : '' }}"
                        data-url-prefix="{{ url('/admin/products/get-categories?parent_id=') }}"
                        data-element-id="sub-sub-category-select" data-element-type="select">
                    </select>
                @else
                    <select
                        class="form-control action-get-request-onchange"
                        name="sub_category_id" id="sub-category-select"
                        data-id="{{ $isEdit ? $product['sub_category_id'] : '' }}"
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
                    class="form-control" placeholder="{{ translate('new_Product') }}">
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('HS Code') }}</label>
                <input type="text" class="form-control" name="hts_code"
                    value="{{ $isEdit ? $product['hts_code'] : '' }}" placeholder="e.g., 8473301000">
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
                    data-role="origininput">
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
                <textarea name="short_details" class="summernote">{!! $isEdit ? $product['short_details'] ?? '' : '' !!}</textarea>
            </div>
        </div>

        <button type="button" class="next-btn" data-next="2">Next</button>
    </div>
    <div class="step-section" data-step="2">
        <div class="form-row">
            <div class="form-group">
                <label for="thumbnail">Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail"
                    accept=".jpg, .webp, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
            </div>
            <div class="form-group">
                <label for="extra_images">Additional Images</label>
                <input type="file" name="extra_images[]" id="extra_images"
                    accept=".jpg, .webp, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" multiple>
            </div>
        </div>
        <div class="form-row">
            @if ($isEdit && !empty($product->thumbnail))
                <div class="d-flex gap-2 mt-2">
                    <h4>Thumbnail</h4>
                    <img src="/storage/{{ $product->thumbnail }}" alt="Thumbnail"
                        style="max-height: 200px;max-width: 200px;aspect-ratio: 4/3;border:1px solid #ccc;border-radius:6px;">
                </div>
            @endif
        </div>
        <div class="form-row">
            @if ($isEdit && !empty($product->extra_images))
                <div class="d-flex flex-wrap gap-2 mt-2">
                    <h4>Additional Images</h4>
                    @foreach (json_decode($product->extra_images, true) as $image)
                        <img src="/storage/{{ $image }}" alt="Extra Image"
                            style="max-height: 200px;max-width: 200px;aspect-ratio: 4/3;border:1px solid #ccc;border-radius:6px;">
                    @endforeach
                </div>
            @endif
        </div>
        <div class="form-row">
            <div class="form-single">
                <label class="form-lable">Certificate</label>
                <input type="file" name="certificates[]" id="certificates"
                    accept=".jpg, .webp, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" multiple>
            </div>
        </div>
        <div class="form-row" style="margin-bottom: 10px;">
            @if ($isEdit && !empty($product->certificates))
                <div class="d-flex flex-wrap gap-2 mt-2">
                    <h4>Certificates</h4>
                    @foreach (json_decode($product->certificates, true) as $cert)
                        <img src="/storage/{{ $cert }}" alt="Certificate"
                            style="max-height: 200px;max-width: 200px;aspect-ratio: 4/3;border:1px solid #ccc;border-radius:6px;">
                    @endforeach
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
                    @foreach (units() as $unit)
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
                <label class="title-color " for="supply_capacity">
                    {{ translate('Supply Capacity') }}
                    <span class="input-required-icon">*</span>
                </label>
                <input type="number" min="1" value="1" step="1"
                    placeholder="{{ translate('supply_capacity') }}" name="supply_capacity" id="supply_capacity"
                    class="form-control" required value="{{ $isEdit ? $product['supply_capacity'] : '' }}">
            </div>
        </div>
        <button type="button" class="prev-btn" data-prev="2">Prev</button>
        <button type="button" class="next-btn" data-next="4">Next</button>
    </div>
    <div class="step-section" data-step="4">
        <div class="form-row">
            <div class="form-group">
                <label class="title-color">{{ translate('Delivery Terms') }}</label>
                <select class="form-control" name="delivery_terms">
                    <option value="CFR"
                        {{ $isEdit ? ($product['delivery_terms'] == 'CFR' ? 'selected' : '') : '' }}>CFR
                    </option>
                    <option value="FOB"
                        {{ $isEdit ? ($product['delivery_terms'] == 'FOB' ? 'selected' : '') : '' }}>FOB
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label class="title-color">{{ translate('Delivery Mode') }}</label>
                <select class="form-control" name="delivery_mode">
                    <option value="Air"
                        {{ $isEdit ? ($product['delivery_mode'] == 'Air' ? 'selected' : '') : '' }}>Air
                    </option>
                    <option value="Sea"
                        {{ $isEdit ? ($product['delivery_mode'] == 'Sea' ? 'selected' : '') : '' }}>Sea
                    </option>
                    <option value="Rail_Road"
                        {{ $isEdit ? ($product['delivery_mode'] == 'Rail_Road' ? 'selected' : '') : '' }}>
                        Rail Road</option>
                </select>
            </div>
        </div>
        <div class="form-row">
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
            <div class="form-group">
                <label class="form-label">{{ translate('Payment Terms') }}</label>
                <select class="form-control" name="payment_terms">
                    <option value="">Select Payment Term</option>
                    @php
                        $paymentTerms = [
                            'L/C at Sight',
                            'L/C 30/60/90 Days',
                            'D/A (Documents Against Acceptance)',
                            'D/P (Documents Against Payment)',
                            'CAD (Cash Against Documents)',
                            'T/T (Telegraphic Transfer)',
                            'Advance Payment',
                            'Net 30',
                            'Net 60',
                        ];
                    @endphp

                    @foreach ($paymentTerms as $term)
                        <option value="{{ $term }}"
                            {{ $isEdit && ($product['payment_terms'] ?? null) === $term ? 'selected' : '' }}>
                            {{ $term }}
                        </option>
                    @endforeach
                </select>
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
                            {{ $isEdit && ($product['packing_type'] ?? null) === $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Size') }}</label>
                <input type="text" class="form-control" name="weight_per_unit"
                    value="{{ $isEdit ? $product['weight_per_unit'] ?? '' : '' }}" placeholder="e.g., 1.5kg">
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Internal Packing') }}</label>
                <input type="text" class="form-control" name="dimensions_per_unit"
                    value="{{ $isEdit ? $product['dimensions_per_unit'] ?? '' : '' }}" placeholder="e.g., 10x5x2 cm">
            </div>
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
                <select class="js-example-basic-multiple form-control" name="target_market[]" multiple>
                    @foreach ($countries as $country)
                        <option value="{{ $country['id'] }}"
                            {{ in_array($country['id'], old('target_market', $selectedMarkets)) ? 'selected' : '' }}>
                            {{ $country['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-single">
                <label class="title-color" for="description">{{ translate('Description') }}
                </label>
                <textarea name="details" class="summernote">{!! $isEdit ? $product['details'] ?? '' : '' !!}</textarea>
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
        <div class="form-row">
            <div class="form-group">
                <label class="title-color">{{ translate('Supply Unit') }}</label>
                <select class="js-example-basic-multiple form-control" name="supply_unit">
                    @foreach (units() as $unit)
                        <option value="{{ $unit }}"
                            {{ isset($product['supply_unit']) && $unit == $product['supply_unit'] ? 'selected' : '' }}>
                            {{ $unit }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="title-color ">
                    {{ translate('Local Currency') }}
                </label>
                <input type="text" placeholder="{{ translate('local_currency') }}" name="local_currency"
                    value="{{ $isEdit ? $product['local_currency'] : '' }}" class="form-control" required>
            </div>
        </div>
        <button type="button" class="prev-btn" data-prev="5">Prev</button>
        <button type="submit" class="submit-btn">Submit</button>
    </div>
</div>
