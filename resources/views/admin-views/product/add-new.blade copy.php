@extends('layouts.back-end.app-partial')

@section('title', translate('product_Add'))

@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
            <h2 class="h1 mb-0 d-flex gap-2">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
                {{ translate('add_New_Product') }}
            </h2>
        </div>

        <form class="product-form text-start" action="{{ route('admin.products.store') }}" method="POST"
            enctype="multipart/form-data" id="product_form">
            @csrf
            <div class="card mb-5">
                <div class="card-header">
                    <div class="d-flex gap-2">
                        <i class="tio-user-big"></i>
                        <h4 class="mb-0">{{ translate('Basic Product Information') }}</h4>
                    </div>
                </div>
                <div class="card-body row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="name" class="title-color">
                                {{ translate('category') }}
                                <span class="input-required-icon">*</span>
                            </label>
                            <select class="js-select2-custom form-control action-get-request-onchange" name="category_id"
                                data-url-prefix="{{ route('admin.products.get-categories') . '?parent_id=' }}"
                                data-element-id="sub-category-select" data-element-type="select" required>
                                <option value="{{ old('category_id') }}" selected disabled>
                                    {{ translate('select_category') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category['id'] }}"
                                        {{ old('name') == $category['id'] ? 'selected' : '' }}>
                                        {{ $category['defaultName'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="name" class="title-color">{{ translate('sub_Category') }}</label>
                            <select class="js-select2-custom form-control action-get-request-onchange"
                                name="sub_category_id" id="sub-category-select"
                                data-url-prefix="{{ route('admin.products.get-categories') . '?parent_id=' }}"
                                data-element-id="sub-sub-category-select" data-element-type="select">
                                <option value="{{ null }}" selected disabled>
                                    {{ translate('select_Sub_Category') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="name" class="title-color">{{ translate('sub_Sub_Category') }}</label>
                            <select class="js-select2-custom form-control" name="sub_sub_category_id"
                                id="sub-sub-category-select">
                                <option value="{{ null }}" selected disabled>
                                    {{ translate('select_Sub_Sub_Category') }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        @foreach ($languages as $lang)
                            <div class="{{ $lang != $defaultLanguage ? 'd-none' : '' }} form-system-language-form"
                                id="{{ $lang }}-form">
                                <div class="form-group">
                                    <label class="title-color" for="{{ $lang }}_name">{{ translate('product_name') }}
                                        ({{ strtoupper($lang) }})
                                        @if ($lang == $defaultLanguage)
                                            <span class="input-required-icon">*</span>
                                        @endif
                                    </label>
                                    <input type="text" {{ $lang == $defaultLanguage ? 'required' : '' }} name="name[]"
                                        id="{{ $lang }}_name"
                                        class="form-control {{ $lang == $defaultLanguage ? 'product-title-default-language' : '' }}"
                                        placeholder="{{ translate('new_Product') }}">
                                </div>
                                <input type="hidden" name="lang[]" value="{{ $lang }}">
                            </div>
                        @endforeach
                    </div>
                    <div class="col-lg-4" style="padding-bottom: 15px;">
                        <label class="form-label">{{ translate('HT Code') }}</label>
                        <input type="text" class="form-control" name="hts_code" placeholder="e.g., 8473301000">
                    </div>
                    <div class="col-lg-12">
                        <div class="product-image-wrapper">
                            <div class="item-1">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
                                                <div>
                                                    <label for="name"
                                                        class="title-color text-capitalize font-weight-bold mb-0">
                                                        {{ translate('product_thumbnail') }}
                                                        <span class="input-required-icon">*</span>
                                                    </label>
                                                    <span
                                                        class="badge badge-soft-info">{{ THEME_RATIO[theme_root_path()]['Product Image'] }}</span>
                                                    <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                                        title="{{ translate('add_your_product’s_thumbnail_in') }} JPG, PNG or JPEG {{ translate('format_within') }} 2MB">
                                                        <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                                                            alt="">
                                                    </span>
                                                </div>
                                            </div>

                                            <div>
                                                <div class="custom_upload_input">
                                                    <input type="file" name="image"
                                                        class="custom-upload-input-file action-upload-color-image"
                                                        id="" data-imgpreview="pre_img_viewer"
                                                        accept=".jpg, .webp, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">

                                                    <span
                                                        class="delete_file_input btn btn-outline-danger btn-sm square-btn d--none">
                                                        <i class="tio-delete"></i>
                                                    </span>

                                                    <div class="img_area_with_preview position-absolute z-index-2">
                                                        <img id="pre_img_viewer" class="h-auto aspect-1 bg-white d-none"
                                                            src="" alt="">
                                                    </div>
                                                    <div
                                                        class="position-absolute h-100 top-0 w-100 d-flex align-content-center justify-content-center">
                                                        <div
                                                            class="d-flex flex-column justify-content-center align-items-center">
                                                            <img alt="" class="w-75"
                                                                src="{{ dynamicAsset(path: 'public/assets/back-end/img/icons/product-upload-icon.svg') }}">
                                                            <h3 class="text-muted">{{ translate('Upload_Image') }}</h3>
                                                        </div>
                                                    </div>
                                                </div>

                                                <p class="text-muted mt-2">
                                                    {{ translate('image_format') }} : {{ 'Jpg, png, jpeg, webp,' }}
                                                    <br>
                                                    {{ translate('image_size') }} : {{ translate('max') }}
                                                    {{ '2 MB' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="color_image_column item-2 d-none">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                                                <div>
                                                    <label for="name"
                                                        class="title-color text-capitalize font-weight-bold mb-0">{{ translate('colour_wise_product_image') }}</label>
                                                    <span
                                                        class="badge badge-soft-info">{{ THEME_RATIO[theme_root_path()]['Product Image'] }}</span>
                                                    <span class="input-label-secondary cursor-pointer"
                                                        data-toggle="tooltip"
                                                        title="{{ translate('add_color-wise_product_images_here') }}.">
                                                        <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                                                            alt="">
                                                    </span>
                                                </div>

                                            </div>
                                            <p class="text-muted">
                                                {{ translate('must_upload_colour_wise_images_first._Colour_is_shown_in_the_image_section_top_right') }}
                                                . </p>

                                            <div id="color-wise-image-section" class="row g-2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="additional_image_column item-2">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                                            <div>
                                                <label for="name"
                                                    class="title-color text-capitalize font-weight-bold mb-0">{{ translate('upload_additional_image') }}</label>
                                                <span
                                                    class="badge badge-soft-info">{{ THEME_RATIO[theme_root_path()]['Product Image'] }}</span>
                                                <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                                    title="{{ translate('upload_any_additional_images_for_this_product_from_here') }}.">
                                                    <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                                                        alt="">
                                                </span>
                                            </div>

                                        </div>
                                        <p class="text-muted">{{ translate('upload_additional_product_images') }}</p>

                                        <div class="row g-2" id="additional_Image_Section">
                                            <div class="col-sm-12 col-md-4">
                                                <div
                                                    class="custom_upload_input position-relative border-dashed-2 aspect-1">
                                                    <input type="file" name="images[]"
                                                        class="custom-upload-input-file action-add-more-image"
                                                        data-index="1" data-imgpreview="additional_Image_1"
                                                        accept=".jpg, .png, .webp, .jpeg, .gif, .bmp, .tif, .tiff|image/*"
                                                        data-target-section="#additional_Image_Section">

                                                    <span
                                                        class="delete_file_input delete_file_input_section btn btn-outline-danger btn-sm square-btn d-none">
                                                        <i class="tio-delete"></i>
                                                    </span>

                                                    <div
                                                        class="img_area_with_preview position-absolute z-index-2 border-0">
                                                        <img id="additional_Image_1"
                                                            class="h-auto aspect-1 bg-white d-none "
                                                            src="{{ dynamicAsset(path: 'public/assets/back-end/img/icons/product-upload-icon.svg-dummy') }}"
                                                            alt="">
                                                    </div>
                                                    <div
                                                        class="position-absolute h-100 top-0 w-100 d-flex align-content-center justify-content-center">
                                                        <div
                                                            class="d-flex flex-column justify-content-center align-items-center">
                                                            <img alt=""
                                                                src="{{ dynamicAsset(path: 'public/assets/back-end/img/icons/product-upload-icon.svg') }}"
                                                                class="w-75">
                                                            <h3 class="text-muted">{{ translate('Upload_Image') }}</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="item-1 digital-product-sections-show">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="d-flex align-items-center justify-content-between gap-2 mb-1">
                                                <div>
                                                    <label for="name"
                                                        class="title-color text-capitalize font-weight-bold mb-0">{{ translate('Product_Preview_File') }}</label>
                                                    <span class="input-label-secondary cursor-pointer"
                                                        data-toggle="tooltip"
                                                        title="{{ translate('upload_a_suitable_file_for_a_short_product_preview.') }} {{ translate('this_preview_will_be_common_for_all_variations.') }}">
                                                        <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                                                            alt="">
                                                    </span>
                                                </div>
                                            </div>
                                            <p class="text-muted">{{ translate('Upload_a_short_preview') }}.</p>
                                        </div>
                                        <div class="image-uploader">
                                            <input type="file" name="preview_file" class="image-uploader__zip"
                                                id="input-file">
                                            <div class="image-uploader__zip-preview">
                                                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/icons/product-upload-icon.svg') }}"
                                                    class="mx-auto" width="50" alt="">
                                                <div class="image-uploader__title line--limit-2">
                                                    {{ translate('Upload_File') }}
                                                </div>
                                            </div>
                                            <span class="btn btn-outline-danger btn-sm square-btn collapse zip-remove-btn">
                                                <i class="tio-delete"></i>
                                            </span>
                                        </div>
                                        <p class="text-muted mt-2 fz-12">
                                            {{ translate('Format') }} : {{ ' pdf, mp4, mp3' }}
                                            <br>
                                            {{ translate('image_size') }} : {{ translate('max') }} {{ '10 MB' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
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
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4" id="minimum_order_qty">
                        <div class="form-group">
                            <div class="d-flex gap-2 mb-2">
                                <label class="title-color mb-0" for="minimum_order_qty">
                                    {{ translate('minimum_order_qty') }}
                                    <span class="input-required-icon">*</span>
                                </label>

                                <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                    title="{{ translate('set_the_minimum_order_quantity_that_customers_must_choose._Otherwise,_the_checkout_process_won’t_start') }}.">
                                    <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                                        alt="">
                                </span>
                            </div>

                            <input type="number" min="1" value="1" step="1"
                                placeholder="{{ translate('minimum_order_quantity') }}" name="minimum_order_qty"
                                id="minimum_order_qty" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-4 physical_product_show">
                        <div class="form-group">
                            <label class="title-color">{{ translate('unit') }}</label>
                            <select class="js-example-basic-multiple form-control" name="unit">
                                @foreach (units() as $unit)
                                    <option value="{{ $unit }}" {{ old('unit') == $unit ? 'selected' : '' }}>
                                        {{ $unit }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4" id="supply_capacity">
                        <div class="form-group">
                            <div class="d-flex gap-2 mb-2">
                                <label class="title-color mb-0" for="supply_capacity">
                                    {{ translate('Supply Capacity') }}
                                    <span class="input-required-icon">*</span>
                                </label>

                                <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                    title="{{ translate('Set the Supply Capacity') }}.">
                                    <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                                        alt="">
                                </span>
                            </div>

                            <input type="number" min="1" value="1" step="1"
                                placeholder="{{ translate('supply_capacity') }}" name="supply_capacity"
                                id="supply_capacity" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-4 physical_product_show">
                        <div class="form-group">
                            <label class="title-color">{{ translate('Supply Unit') }}</label>
                            <select class="js-example-basic-multiple form-control" name="supply_unit">
                                @foreach (units() as $unit)
                                    <option value="{{ $unit }}"
                                        {{ old('supply_unit') == $unit ? 'selected' : '' }}>
                                        {{ $unit }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <div class="d-flex gap-2 mb-2">
                                <label class="title-color mb-0">
                                    {{ translate('unit_price') }}
                                    ({{ getCurrencySymbol(currencyCode: getCurrencyCode()) }})
                                    <span class="input-required-icon">*</span>
                                </label>

                                <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                    title="{{ translate('set_the_selling_price_for_each_unit_of_this_product._This_Unit_Price_section_won’t_be_applied_if_you_set_a_variation_wise_price') }}.">
                                    <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                                        alt="">
                                </span>
                            </div>
                            <input type="number" min="0" step="0.01"
                                placeholder="{{ translate('unit_price') }}" name="unit_price"
                                value="{{ old('unit_price') }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <div class="d-flex gap-2 mb-2">
                                <label class="title-color mb-0">
                                    {{ translate('Local Currency') }}
                                </label>

                                <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                    title="{{ translate('Set the Local Currency') }}.">
                                    <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                                        alt="">
                                </span>
                            </div>
                            <input type="texr" placeholder="{{ translate('local_currency') }}" name="local_currency"
                                value="{{ old('local_currency') }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-lg-4 physical_product_show">
                        <div class="form-group">
                            <label class="title-color">{{ translate('Delivery Terms') }}</label>
                            <select class="form-control" name="delivery_terms">
                                <option value="CFR" {{ old('delivery_terms') == 'CFR' ? 'selected' : '' }}>CFR</option>
                                <option value="FOB" {{ old('delivery_terms') == 'FOB' ? 'selected' : '' }}>FOB</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 physical_product_show">
                        <div class="form-group">
                            <label class="title-color">{{ translate('Delivery Mode') }}</label>
                            <select class="form-control" name="delivery_mode">
                                <option value="Air" {{ old('delivery_mode') == 'Air' ? 'selected' : '' }}>Air</option>
                                <option value="Sea" {{ old('delivery_mode') == 'Sea' ? 'selected' : '' }}>Sea</option>
                                <option value="Rail_Road" {{ old('delivery_mode') == 'Rail_Road' ? 'selected' : '' }}>
                                    Rail Road</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4" style="padding-bottom:15px;">
                        <label class="form-label">{{ translate('Place of Loading') }}</label>
                        <input type="text" class="form-control" name="place_of_loading"
                            placeholder="e.g., Shanghai, Ningbo">
                    </div>
                    <div class="col-lg-4" style="padding-bottom:15px;">
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
                    <div class="col-lg-4" style="padding-bottom:15px;">
                        <label class="form-label">{{ translate('Production Lead Time') }}</label>
                        <input type="text" class="form-control" name="lead_time"
                            placeholder="e.g., 7-10 business days">
                    </div>
                    <div class="col-lg-4" style="padding-bottom:15px;">
                        <label class="form-label">{{ translate('Lead Time Unit') }}</label>
                        <select class="js-example-basic-multiple form-control" name="lead_time_unit">
                            <option value="days" {{ old('lead_time_unit') == 'days' ? 'selected' : '' }}>Days</option>
                            <option value="months" {{ old('lead_time_unit') == 'month' ? 'selected' : '' }}>Month
                            </option>
                        </select>
                    </div>
                    <div class="col-lg-4" style="padding-bottom:15px;">
                        <label class="form-label">{{ translate('Payment Terms') }}</label>
                        <select class="form-control" name="payment_terms">
                            <option value="">Select Payment Term</option>
                            <option value="L/C at Sight" {{ old('payment_terms') == 'L/C at Sight' ? 'selected' : '' }}>
                                L/C at Sight</option>
                            <option value="L/C 30/60/90 Days"
                                {{ old('payment_terms') == 'L/C 30/60/90 Days' ? 'selected' : '' }}>L/C 30/60/90 Days
                            </option>
                            <option value="D/A (Documents Against Acceptance)"
                                {{ old('payment_terms') == 'D/A (Documents Against Acceptance)' ? 'selected' : '' }}>D/A
                                (Documents Against Acceptance)</option>
                            <option value="D/P (Documents Against Payment)"
                                {{ old('payment_terms') == 'D/P (Documents Against Payment)' ? 'selected' : '' }}>D/P
                                (Documents Against Payment)</option>
                            <option value="CAD (Cash Against Documents)"
                                {{ old('payment_terms') == 'CAD (Cash Against Documents)' ? 'selected' : '' }}>CAD (Cash
                                Against Documents)</option>
                            <option value="T/T (Telegraphic Transfer)"
                                {{ old('payment_terms') == 'T/T (Telegraphic Transfer)' ? 'selected' : '' }}>T/T
                                (Telegraphic Transfer)</option>
                            <option value="Advance Payment"
                                {{ old('payment_terms') == 'Advance Payment' ? 'selected' : '' }}>Advance Payment</option>
                            <option value="Net 30" {{ old('payment_terms') == 'Net 30' ? 'selected' : '' }}>Net 30
                            </option>
                            <option value="Net 60" {{ old('payment_terms') == 'Net 60' ? 'selected' : '' }}>Net 60
                            </option>
                        </select>
                    </div>

                    <div class="col-lg-4" style="padding-bottom:15px;">
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

                    <div class="col-lg-4" style="padding-bottom:15px;">
                        <label class="form-label">{{ translate('Size') }}</label>
                        <input type="text" class="form-control" name="weight_per_unit" placeholder="e.g., 1.5kg">
                    </div>
                    <div class="col-lg-4" style="padding-bottom:15px;">
                        <label class="form-label">{{ translate('Internal Packing') }}</label>
                        <input type="text" class="form-control" name="dimensions_per_unit"
                            placeholder="e.g., 10x5x2 cm">
                    </div>
                    <div class="col-lg-4" style="padding-bottom:15px;">
                        <label class="form-label">{{ translate('Target Market') }}</label>
                        <select class="js-example-basic-multiple form-control" name="target_market[]" multiple>
                            @foreach ($countries as $country)
                                <option value="{{ $country['id'] }}"
                                    {{ collect(old('target_market'))->contains($country) ? 'selected' : '' }}>
                                    {{ $country['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if ($brandSetting)
                        <div class="col-lg-4 physical_product_show">
                            <div class="form-group">
                                <label class="title-color">
                                    {{ translate('brand') }}
                                    <span class="input-required-icon">*</span>
                                </label>
                                <select class="js-select2-custom form-control" name="brand_id" required>
                                    <option value="{{ null }}" selected disabled>
                                        {{ translate('select_Brand') }}</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand['id'] }}">{{ $brand['defaultName'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                <h2 class="h1 mb-0 d-flex gap-2">
                    <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}"
                        alt="">
                    {{ translate('Product Description & Specification') }}
                </h2>
            </div>

            <div class="card mb-5">
                <div class="card-header">
                    <div class="d-flex gap-2">
                        <i class="tio-user-big"></i>
                        <h4 class="mb-0">{{ translate('Product Description & Specification') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="form-group pt-4">
                            <label class="title-color" for="description">{{ translate('Short Description') }}
                            </label>
                            <textarea name="short_details[]" class="summernote">{{ old('short_details') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group pt-4">
                            <label class="title-color" for="description">{{ translate('Description') }}
                            </label>
                            <textarea name="details[]" class="summernote">{{ old('details') }}</textarea>
                        </div>
                    </div>
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
                    <div class="col-md-4">
                        <label class="form-lable">Certificate</label>
                        <input type="file" name="certificate" id="certificate">
                    </div>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                <h2 class="h1 mb-0 d-flex gap-2">
                    <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}"
                        alt="">
                    {{ translate('Other Details') }}
                </h2>
            </div>

            <div class="card mt-3 rest-part">
                <div class="card-header">
                    <div class="d-flex gap-2">
                        <i class="tio-user-big"></i>
                        <h4 class="mb-0">{{ translate('general_setup') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="title-color">
                                    {{ translate('product_type') }}
                                    <span class="input-required-icon">*</span>
                                </label>
                                <select name="product_type" id="product_type" class="form-control" required>
                                    <option value="physical" selected>{{ translate('physical') }}</option>
                                    @if ($digitalProductSetting)
                                        <option value="digital">{{ translate('digital') }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 digital-product-sections-show">
                            <label class="title-color">
                                {{ translate('Author') }}/{{ translate('Creator') }}/{{ translate('Artist') }}
                            </label>
                            <select class="multiple-select2 form-control" name="authors[]" multiple="multiple"
                                id="mySelect">
                                @foreach ($digitalProductAuthors as $authors)
                                    <option value="{{ $authors['name'] }}">{{ $authors['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-4 digital-product-sections-show">
                            <label class="title-color">{{ translate('Publishing_House') }}</label>
                            <select class="multiple-select2 form-control" name="publishing_house[]" multiple="multiple">
                                @foreach ($publishingHouseList as $publishingHouse)
                                    <option value="{{ $publishingHouse['name'] }}">{{ $publishingHouse['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-4" id="digital_product_type_show">
                            <div class="form-group">
                                <label for="digital_product_type"
                                    class="title-color">{{ translate('delivery_type') }}</label>
                                <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                    title="{{ translate('for_Ready_Produc”_deliveries,_customers_can_pay_&_instantly_download_pre-uploaded_digital_products._For_Ready_After_Sale_deliveries,_customers_pay_first_then_vendor_uploads_the_digital_products_that_become_available_to_customers_for_download') }}">
                                    <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                                        alt="">
                                </span>
                                <select name="digital_product_type" id="digital_product_type" class="form-control"
                                    required>
                                    <option value="{{ old('category_id') }}" selected disabled>
                                        ---{{ translate('select') }}---
                                    </option>
                                    <option value="ready_after_sell">{{ translate('ready_After_Sell') }}</option>
                                    <option value="ready_product">{{ translate('ready_Product') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="title-color d-flex justify-content-between gap-2">
                                    <span class="d-flex align-items-center gap-2">
                                        {{ translate('product_SKU') }}
                                        <span class="input-required-icon">*</span>
                                        <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                            title="{{ translate('create_a_unique_product_code_by_clicking_on_the_Generate_Code_button') }}">
                                            <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                                                alt="">
                                        </span>
                                    </span>
                                    <span
                                        class="style-one-pro cursor-pointer user-select-none text--primary action-onclick-generate-number"
                                        data-input="#generate_number">
                                        {{ translate('generate_code') }}
                                    </span>
                                </label>
                                <input type="text" minlength="6" id="generate_number" name="code"
                                    class="form-control" value="{{ old('code') }}"
                                    placeholder="{{ translate('123412') }}" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="title-color d-flex align-items-center gap-2">
                                            {{ translate('Badge') }}
                                            <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                                title="{{ translate('add_the_product_search_tag_for_this_product_that_customers_can_use_to_search_quickly') }}">
                                                <img width="16"
                                                    src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                                                    alt="">
                                            </span>
                                        </label>
                                        <input type="text" class="form-control"
                                            placeholder="{{ translate('Enter Badge') }}" name="badge"
                                            data-role="badgeinput">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="title-color d-flex align-items-center gap-2">
                                    {{ translate('search_tags') }}
                                    <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                        title="{{ translate('add_the_product_search_tag_for_this_product_that_customers_can_use_to_search_quickly') }}">
                                        <img width="16"
                                            src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                                            alt="">
                                    </span>
                                </label>
                                <input type="text" class="form-control" placeholder="{{ translate('enter_tag') }}"
                                    name="tags" data-role="tagsinput">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- PRODUCT INFORMATION --}}
            <div class="card mt-3 rest-part">
                <div class="card-header">
                    <div class="d-flex gap-2">
                        <i class="tio-info"></i>
                        <h4 class="mb-0">{{ translate('Product Information') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">{{ translate('Customization') }}</label>
                            <input type="text" class="form-control" name="customization"
                                placeholder="e.g., Logo, Color, Packaging">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ translate('Style') }}</label>
                            <input type="text" class="form-control" name="style"
                                placeholder="e.g., Modern, Classic, Industrial">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ translate('Usage') }}</label>
                            <input type="text" class="form-control" name="usage"
                                placeholder="e.g., Indoor/Outdoor Use">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ translate('Sample Price') }}</label>
                            <input type="text" class="form-control" name="sample_price" placeholder="e.g., $20">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ translate('Sample Amount') }}</label>
                            <input type="text" class="form-control" name="sample_amount" placeholder="e.g., 2 units">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ translate('Model Number') }}</label>
                            <input type="text" class="form-control" name="model_number" placeholder="e.g., ABC123">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ translate('Small Orders Accepted') }}</label>
                            <select class="form-control" name="small_orders">
                                <option value="1">{{ translate('Yes') }}</option>
                                <option value="0">{{ translate('No') }}</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">{{ translate('FAQ') }}</label>
                            <textarea class="summernote" name="faq" rows="3" placeholder="Write common questions and answers..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">{{ translate('Why Choose Us?') }}</label>
                            <textarea class="summernote" name="why_choose_us" rows="3"
                                placeholder="e.g., Trusted supplier, 10+ years experience"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SHIPPING INFORMATION --}}
            <div class="card mt-3 rest-part">
                <div class="card-header">
                    <div class="d-flex gap-2">
                        <i class="tio-truck"></i>
                        <h4 class="mb-0">{{ translate('Shipping Information') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">{{ translate('Export Carton Dimensions (L x W x H)') }}</label>
                            <input type="text" class="form-control" name="export_carton_dimensions"
                                placeholder="e.g., 60x40x30 cm">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ translate('Logistics Attributes') }}</label>
                            <input type="text" class="form-control" name="logistics_attributes"
                                placeholder="e.g., Stackable, Fragile">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ translate('Units per Export Carton') }}</label>
                            <input type="text" class="form-control" name="units_per_carton" placeholder="e.g., 50">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ translate('Export Carton Weight') }}</label>
                            <input type="text" class="form-control" name="carton_weight" placeholder="e.g., 75kg">
                        </div>
                    </div>
                </div>
            </div>

            {{-- MAIN EXPORT MARKETS --}}
            <div class="card mt-3 rest-part">
                <div class="card-header">
                    <div class="d-flex gap-2">
                        <i class="tio-globe"></i>
                        <h4 class="mb-0">{{ translate('Main Export Markets') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">{{ translate('Regions') }}</label>
                            <textarea type="text" class="summernote" name="export_markets"
                                placeholder="e.g., North America, Europe, Southeast Asia"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- PAYMENT DETAILS --}}
            <div class="card mt-3 rest-part">
                <div class="card-header">
                    <div class="d-flex gap-2">
                        <i class="tio-wallet"></i>
                        <h4 class="mb-0">{{ translate('Payment Details') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">{{ translate('Accepted Payment Methods') }}</label>
                            <input type="text" class="form-control" name="payment_methods"
                                placeholder="e.g., Bank Transfer (T/T), PayPal, L/C, Western Union">
                        </div>
                        <div class="col-12">
                            <label class="form-label">{{ translate('Currency Accepted') }}</label>
                            <input type="text" class="form-control" name="currency_accepted"
                                placeholder="e.g., USD, EUR, GBP">
                        </div>
                        <div class="col-12">
                            <label class="form-label">{{ translate('Invoicing Info') }}</label>
                            <input type="text" class="form-control" name="invoicing"
                                placeholder="e.g., Issued with shipment, PDF format via email">
                        </div>
                        <div class="col-12">
                            <label class="form-label">{{ translate('Refund Policy') }}</label>
                            <textarea class="form-control" name="refund_policy" rows="3" placeholder="State refund conditions, if any..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3 rest-part">
                <div class="card-header">
                    <div class="d-flex gap-2">
                        <i class="tio-user-big"></i>
                        <h4 class="mb-0">{{ translate('pricing_&_others') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-md-6 col-lg-4 col-xl-3 d-none">
                            <div class="form-group">
                                <div class="d-flex gap-2 mb-2">
                                    <label class="title-color mb-0">{{ translate('purchase_price') }}
                                        ({{ getCurrencySymbol(currencyCode: getCurrencyCode()) }})
                                    </label>
                                    <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                        title="{{ translate('add_the_purchase_price_for_this_product') }}.">
                                        <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                                            alt="">
                                    </span>
                                </div>
                                <input type="number" min="0" step="0.01"
                                    placeholder="{{ translate('purchase_price') }}"
                                    value="{{ old('purchase_price') }}" name="purchase_price" class="form-control"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 col-xl-3 physical_product_show" id="quantity">
                            <div class="form-group">
                                <div class="d-flex gap-2 mb-2">
                                    <label class="title-color mb-0" for="current_stock">
                                        {{ translate('current_stock_qty') }}
                                        <span class="input-required-icon">*</span>
                                    </label>

                                    <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                        title="{{ translate('add_the_Stock_Quantity_of_this_product_that_will_be_visible_to_customers') }}.">
                                        <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                                            alt="">
                                    </span>
                                </div>

                                <input type="number" min="0" value="0" step="1"
                                    placeholder="{{ translate('quantity') }}" name="current_stock" id="current_stock"
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <div class="d-flex gap-2 mb-2">
                                    <label class="title-color mb-0"
                                        for="discount_Type">{{ translate('discount_Type') }}</label>
                                    <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                        title="{{ translate('if_Flat,_discount_amount_will_be_set_as_fixed_amount._If_Percentage,_discount_amount_will_be_set_as_percentage.') }}">
                                        <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                                            alt="">
                                    </span>
                                </div>

                                <select class="form-control" name="discount_type" id="discount_type">
                                    <option value="flat">{{ translate('flat') }}</option>
                                    <option value="percent">{{ translate('percent') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <div class="d-flex gap-2">
                                    <label class="title-color" for="discount">{{ translate('discount_amount') }} <span
                                            class="discount_amount_symbol">({{ getCurrencySymbol(currencyCode: getCurrencyCode()) }})</span></label>

                                    <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                        title="{{ translate('add_the_discount_amount_in_percentage_or_a_fixed_value_here') }}.">
                                        <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                                            alt="">
                                    </span>
                                </div>
                                <input type="number" min="0" value="0" step="0.01"
                                    placeholder="{{ translate('ex: 5') }}" name="discount" id="discount"
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <div class="d-flex gap-2">
                                    <label class="title-color" for="tax">
                                        {{ translate('tax_amount') }}(%)
                                        <span class="input-required-icon">*</span>
                                    </label>

                                    <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                        title="{{ translate('set_the_Tax_Amount_in_percentage_here') }}">
                                        <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                                            alt="">
                                    </span>
                                </div>

                                <input type="number" min="0" step="0.01"
                                    placeholder="{{ translate('ex: 5') }}" name="tax" id="tax"
                                    value="{{ old('tax') ?? 0 }}" class="form-control">
                                <input name="tax_type" value="percent" class="d-none">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <div class="d-flex gap-2">
                                    <label class="title-color" for="tax_model">
                                        {{ translate('tax_calculation') }}
                                        <span class="input-required-icon">*</span>
                                    </label>

                                    <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                        title="{{ translate('set_the_tax_calculation_method_from_here.') . ' ' . translate('select_Include_with_product_to_combine_product_price_and_tax_on_the_checkout.') . ' ' . translate('pick_Exclude_from_product_to_display_product_price_and_tax_amount_separately.') }}">
                                        <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                                            alt="">
                                    </span>
                                </div>
                                <select name="tax_model" id="tax_model" class="form-control" required>
                                    <option value="include">{{ translate('include_with_product') }}</option>
                                    <option value="exclude">{{ translate('exclude_with_product') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 col-xl-3 physical_product_show" id="shipping_cost">
                            <div class="form-group">
                                <div class="d-flex gap-2">
                                    <label class="title-color">
                                        {{ translate('shipping_cost') }}
                                        ({{ getCurrencySymbol(currencyCode: getCurrencyCode()) }})
                                        <span class="input-required-icon">*</span>
                                    </label>

                                    <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                        title="{{ translate('set_the_shipping_cost_for_this_product_here._Shipping_cost_will_only_be_applicable_if_product-wise_shipping_is_enabled.') }}">
                                        <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                                            alt="">
                                    </span>
                                </div>

                                <input type="number" min="0" value="0" step="1"
                                    placeholder="{{ translate('shipping_cost') }}" name="shipping_cost"
                                    class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6 physical_product_show" id="shipping_cost_multy">
                            <div class="form-group">
                                <div
                                    class="form-control h-auto min-form-control-height d-flex align-items-center flex-wrap justify-content-between gap-2">
                                    <div class="d-flex gap-2">
                                        <label class="title-color text-capitalize"
                                            for="shipping_cost">{{ translate('shipping_cost_multiply_with_quantity') }}</label>

                                        <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                            title="{{ translate('if_enabled,_the_shipping_charge_will_increase_with_the_product_quantity') }}">
                                            <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                                                alt="">
                                        </span>
                                    </div>

                                    <div>
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher_input" name="multiply_qty">
                                            <span class="switcher_control"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3 rest-part physical_product_show">
                <div class="card-header">
                    <div class="d-flex gap-2">
                        <i class="tio-user-big"></i>
                        <h4 class="mb-0">{{ translate('product_variation_setup') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-md-6">
                            <div class="mb-3 d-flex align-items-center gap-2">
                                <label for="colors" class="title-color mb-0">
                                    {{ translate('select_colors') }} :
                                </label>
                                <label class="switcher">
                                    <input type="checkbox" class="switcher_input" id="product-color-switcher"
                                        value="{{ old('colors_active') }}" name="colors_active">
                                    <span class="switcher_control"></span>
                                </label>
                            </div>
                            <select
                                class="js-example-basic-multiple js-states js-example-responsive form-control color-var-select"
                                name="colors[]" multiple="multiple" id="colors-selector" disabled>
                                @foreach ($colors as $key => $color)
                                    <option value="{{ $color->code }}">
                                        {{ $color['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="choice_attributes" class="title-color">
                                {{ translate('select_attributes') }} :
                            </label>
                            <select class="js-example-basic-multiple js-states js-example-responsive form-control"
                                name="choice_attributes[]" id="choice_attributes" multiple="multiple">
                                @foreach ($attributes as $key => $a)
                                    <option value="{{ $a['id'] }}">
                                        {{ $a['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 mt-2 mb-2">
                            <div class="row customer_choice_options mt-2" id="customer_choice_options"></div>
                            <div class="form-group sku_combination" id="sku_combination"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3 rest-part digitalProductVariationSetupSection">
                <div class="card-header">
                    <div class="d-flex gap-2">
                        <i class="tio-user-big"></i>
                        <h4 class="mb-0">{{ translate('product_variation_setup') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-2" id="digital-product-type-choice-section">
                        <div class="col-sm-6 col-md-4 col-xxl-3">
                            <div class="multi--select">
                                <label class="title-color">{{ translate('File_Type') }}</label>
                                <select class="js-example-basic-multiple js-select2-custom form-control" name="file-type"
                                    multiple id="digital-product-type-select">
                                    @foreach ($digitalProductFileTypes as $FileType)
                                        <option value="{{ $FileType }}">{{ translate($FileType) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3 rest-part" id="digital-product-variation-section"></div>

            <div class="mt-3 rest-part">

            </div>

            <div class="card mt-3 rest-part">
                <div class="card-header">
                    <div class="d-flex gap-2">
                        <i class="tio-user-big"></i>
                        <h4 class="mb-0">{{ translate('product_video') }}</h4>
                        <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                            title="{{ translate('add_the_YouTube_video_link_here._Only_the_YouTube-embedded_link_is_supported') }}.">
                            <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                                alt="">
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="title-color mb-0">{{ translate('youtube_video_link') }}</label>
                        <span class="text-info">
                            ({{ translate('optional_please_provide_embed_link_not_direct_link') }}.)</span>
                    </div>
                    <input type="text" name="video_url"
                        placeholder="{{ translate('ex') }} : {{ 'https://www.youtube.com/embed/5R06LRdUCSE' }}"
                        class="form-control" required>
                </div>
            </div>

            <div class="card mt-3 rest-part">
                <div class="card-header">
                    <div class="d-flex gap-2">
                        <i class="tio-user-big"></i>
                        <h4 class="mb-0">
                            {{ translate('seo_section') }}
                            <span class="input-label-secondary cursor-pointer" data-toggle="tooltip" data-placement="top"
                                title="{{ translate('add_meta_titles_descriptions_and_images_for_products') . ', ' . translate('this_will_help_more_people_to_find_them_on_search_engines_and_see_the_right_details_while_sharing_on_other_social_platforms') }}">
                                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                                    alt="">
                            </span>
                        </h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="title-color">
                                    {{ translate('meta_Title') }}
                                    <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                        data-placement="top"
                                        title="{{ translate('add_the_products_title_name_taglines_etc_here') . ' ' . translate('this_title_will_be_seen_on_Search_Engine_Results_Pages_and_while_sharing_the_products_link_on_social_platforms') . ' [ ' . translate('character_Limit') }} : 100 ]">
                                        <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                                            alt="">
                                    </span>
                                </label>
                                <input type="text" name="meta_title" placeholder="{{ translate('meta_Title') }}"
                                    class="form-control" id="meta_title">
                            </div>
                            <div class="form-group">
                                <label class="title-color">
                                    {{ translate('meta_Description') }}
                                    <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                        data-placement="top"
                                        title="{{ translate('write_a_short_description_of_this_shop_product') . ' ' . translate('this_description_will_be_seen_on_Search_Engine_Results_Pages_and_while_sharing_the_products_link_on_social_platforms') . ' [ ' . translate('character_Limit') }} : 100 ]">
                                        <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                                            alt="">
                                    </span>
                                </label>
                                <textarea rows="4" type="text" name="meta_description" id="meta_description" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="d-flex justify-content-center">
                                <div class="form-group w-100">
                                    <div class="d-flex align-items-center justify-content-between gap-2">
                                        <div>
                                            <label class="title-color" for="meta_Image">
                                                {{ translate('meta_Image') }}
                                            </label>
                                            <span
                                                class="badge badge-soft-info">{{ THEME_RATIO[theme_root_path()]['Meta Thumbnail'] }}</span>
                                            <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                                title="{{ translate('add_Meta_Image_in') }} JPG, PNG or JPEG {{ translate('format_within') }} 2MB, {{ translate('which_will_be_shown_in_search_engine_results') }}.">
                                                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                                                    alt="">
                                            </span>
                                        </div>

                                    </div>

                                    <div>
                                        <div class="custom_upload_input">
                                            <input type="file" name="meta_image"
                                                class="custom-upload-input-file meta-img action-upload-color-image"
                                                data-imgpreview="pre_meta_image_viewer" id="meta_image_input"
                                                accept=".jpg, .webp, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">

                                            <span
                                                class="delete_file_input btn btn-outline-danger btn-sm square-btn d--none">
                                                <i class="tio-delete"></i>
                                            </span>

                                            <div
                                                class="img_area_with_preview position-absolute z-index-2 d-flex align-items-center justify-content-center">
                                                <img id="pre_meta_image_viewer"
                                                    class="h-auto bg-white onerror-add-class-d-none pre-meta-image-viewer"
                                                    alt=""
                                                    src="{{ dynamicAsset(path: 'public/assets/back-end/img/icons/product-upload-icon.svg-dummy') }}">
                                            </div>
                                            <div
                                                class="position-absolute h-100 top-0 w-100 d-flex align-content-center justify-content-center overflow-hidden">
                                                <div class="d-flex flex-column justify-content-center align-items-center">
                                                    <img alt="" class="w-75"
                                                        src="{{ dynamicAsset(path: 'public/assets/back-end/img/icons/product-upload-icon.svg') }}">
                                                    <h3 class="text-muted">{{ translate('Upload_Image') }}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    @include('admin-views.product.partials._seo-section')
                </div>
            </div>

            <div class="row justify-content-end gap-3 mt-3 mx-1">
                <button type="reset" class="btn btn-secondary px-5">{{ translate('reset') }}</button>
                <button type="button"
                    class="btn btn--primary px-5 product-add-requirements-check">{{ translate('submit') }}</button>
            </div>
        </form>
    </div>

    <span id="route-admin-products-sku-combination" data-url="{{ route('admin.products.sku-combination') }}"></span>
    <span id="route-admin-products-digital-variation-combination"
        data-url="{{ route('admin.products.digital-variation-combination') }}"></span>
    <span id="image-path-of-product-upload-icon"
        data-path="{{ dynamicAsset(path: 'public/assets/back-end/img/icons/product-upload-icon.svg') }}"></span>
    <span id="image-path-of-product-upload-icon-two"
        data-path="{{ dynamicAsset(path: 'public/assets/back-end/img/400x400/img2.jpg') }}"></span>
    <span id="message-enter-choice-values" data-text="{{ translate('enter_choice_values') }}"></span>
    <span id="message-upload-image" data-text="{{ translate('upload_Image') }}"></span>
    <span id="message-file-size-too-big" data-text="{{ translate('file_size_too_big') }}"></span>
    <span id="message-are-you-sure" data-text="{{ translate('are_you_sure') }}"></span>
    <span id="message-yes-word" data-text="{{ translate('yes') }}"></span>
    <span id="message-no-word" data-text="{{ translate('no') }}"></span>
    <span id="message-want-to-add-or-update-this-product"
        data-text="{{ translate('want_to_add_this_product') }}"></span>
    <span id="message-please-only-input-png-or-jpg"
        data-text="{{ translate('please_only_input_png_or_jpg_type_file') }}"></span>
    <span id="message-product-added-successfully" data-text="{{ translate('product_added_successfully') }}"></span>
    <span id="message-discount-will-not-larger-then-variant-price"
        data-text="{{ translate('the_discount_price_will_not_larger_then_Variant_Price') }}"></span>
    <span id="system-currency-code" data-value="{{ getCurrencySymbol(currencyCode: getCurrencyCode()) }}"></span>
    <span id="system-session-direction" data-value="{{ Session::get('direction') }}"></span>
@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/tags-input.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/product-add-update.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/product-add-colors-img.js') }}"></script>

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
            $('#category_id').on('change', function() {
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
            $('.action-get-request-onchange').on('change', function() {
                const parentId = $(this).val();
                const urlPrefix = $(this).data('url-prefix');
                const targetId = $(this).data('element-id');
                const $target = $('#' + targetId);

                if (parentId && urlPrefix && targetId) {
                    $.ajax({
                        url: urlPrefix + parentId,
                        type: 'GET',
                        success: function(response) {
                            if (typeof response === 'object' && response.select_tag) {
                                $target.html(response.select_tag);
                            } else {
                                console.warn('Unexpected response format:', response);
                            }

                            // Optional: clear next-level select
                            const nextTargetId = $target.data('element-id');
                            if (nextTargetId) {
                                $('#' + nextTargetId).html(
                                    '<option value="0" disabled selected>---Select---</option>'
                                    );
                            }
                        },
                        error: function() {
                            alert('Failed to load sub-categories.');
                        }
                    });
                }
            });
        });
    </script>
@endpush
