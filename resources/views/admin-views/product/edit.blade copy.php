@extends('layouts.back-end.app-partial')

@section('title', translate(request('product-gallery') == 1 ? 'product_Add' : 'product_Edit'))

@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
                {{ translate(request('product-gallery') == 1 ? 'product_Add' : 'product_Edit') }}
            </h2>
        </div>

        <form class="product-form text-start"
            action="{{ request('product-gallery') == 1 ? route('admin.products.add') : route('admin.products.update', $product->id) }}"
            method="post" enctype="multipart/form-data" id="product_form">
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
                                        {{ $category->id == $product['category_id'] ? 'selected' : '' }}>
                                        {{ $category['defaultName'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="title-color">{{ translate('sub_Category') }}</label>
                            <select
                                class="js-example-basic-multiple js-states js-example-responsive form-control action-get-request-onchange"
                                name="sub_category_id" id="sub-category-select" data-id="{{ $product['sub_category_id'] }}"
                                data-url-prefix="{{ url('/admin/products/get-categories?parent_id=') }}"
                                data-element-id="sub-sub-category-select" data-element-type="select">
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="name" class="title-color">{{ translate('sub_Sub_Category') }}</label>
                            <select class="js-example-basic-multiple js-states js-example-responsive form-control"
                                data-id="{{ $product['sub_sub_category_id'] }}" name="sub_sub_category_id"
                                id="sub-sub-category-select">
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
                                        id="{{ $lang }}_name" value="{{ $product['name'] }}"
                                        class="form-control {{ $lang == $defaultLanguage ? 'product-title-default-language' : '' }}"
                                        placeholder="{{ translate('new_Product') }}">
                                </div>
                                <input type="hidden" name="lang[]" value="{{ $lang }}">
                            </div>
                        @endforeach
                    </div>
                    <div class="col-lg-4" style="padding-bottom: 15px;">
                        <label class="form-label">{{ translate('HT Code') }}</label>
                        <input type="text" class="form-control" name="hts_code" value="{{ $product['hts_code'] ?? '' }}"
                            placeholder="e.g., 8473301000">
                    </div>
                    <div class="col-lg-12">
                        <div class="product-image-wrapper">
                            <div class="item-1">
                                <div class="card h-100">
                                    <div class="card-body">
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
                                                    title="{{ translate('add_your_products_thumbnail_in') }} {{ 'JPG, PNG or JPEG' }} {{ translate('format_within') }} 2MB">
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

                                                @if ($product->thumbnail_full_url['path'])
                                                    <span
                                                        class="delete_file_input btn btn-outline-danger btn-sm square-btn d-flex">
                                                        <i class="tio-delete"></i>
                                                    </span>
                                                @else
                                                    <span
                                                        class="delete_file_input btn btn-outline-danger btn-sm square-btn d--none">
                                                        <i class="tio-delete"></i>
                                                    </span>
                                                @endif

                                                <div class="img_area_with_preview position-absolute z-index-2">
                                                    <img id="pre_img_viewer" class="h-auto aspect-1 bg-white  "
                                                        alt=""
                                                        src="{{ getStorageImages(path: $product->thumbnail_full_url, type: 'backend-product') }}">
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

                                            <p class="text-muted mt-2">{{ translate('image_format') }} :
                                                {{ 'Jpg, png, jpeg, webp' }} <br>
                                                {{ translate('image_size') }} : {{ translate('max') }}
                                                {{ '2 MB' }}</p>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="item-2 color_image_column d-none">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <label for="name"
                                                class="title-color text-capitalize font-weight-bold mb-0">{{ translate('colour_wise_product_image') }}</label>
                                            <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                                title="{{ translate('add_color_wise_product_images_here') }}.">
                                                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                                                    alt="">
                                            </span>
                                        </div>
                                        <p class="text-muted">{{ translate('must_upload_colour_wise_images_first') }}
                                            {{ translate('colour_is_shown_in_the_image_section_top_right.') }} </p>

                                        <div id="color-wise-image-area" class="row g-2 mb-4">
                                            <div class="col-12">
                                                <div class="row g-2" id="color_wise_existing_image"></div>
                                            </div>
                                            <div class="col-12">
                                                <div class="row g-2" id="color-wise-image-section"></div>
                                            </div>
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

                                        <div class="coba-area">

                                            <div class="row g-2" id="additional_Image_Section">

                                                @if (count($product->colors) == 0)
                                                    @foreach ($product->images_full_url as $key => $photo)
                                                        @php($unique_id = rand(1111, 9999))

                                                        <div class="col-sm-12 col-md-4"
                                                            id="addition-image-section-{{ $key }}">
                                                            <div
                                                                class="custom_upload_input custom-upload-input-file-area position-relative border-dashed-2 aspect-1">
                                                                @if (request('product-gallery'))
                                                                    <button
                                                                        class="delete_file_input_css btn btn-outline-danger btn-sm square-btn remove-addition-image-for-product-gallery"
                                                                        data-section-remove-id="addition-image-section-{{ $key }}">
                                                                        <i class="tio-delete"></i>
                                                                    </button>
                                                                @else
                                                                    <a class="delete_file_input_css btn btn-outline-danger btn-sm square-btn"
                                                                        href="{{ route('admin.products.delete-image', ['id' => $product['id'], 'name' => $photo['key']]) }}">
                                                                        <i class="tio-delete"></i>
                                                                    </a>
                                                                @endif

                                                                <div
                                                                    class="img_area_with_preview position-absolute z-index-2 border-0">
                                                                    <img id="additional_Image_{{ $unique_id }}"
                                                                        alt="" class="h-auto aspect-1 bg-white  "
                                                                        src="{{ getStorageImages(path: $photo, type: 'backend-product') }}">
                                                                    @if (request('product-gallery'))
                                                                        <input type="text" name="existing_images[]"
                                                                            value="{{ $photo['key'] }}" hidden>
                                                                    @endif
                                                                </div>
                                                                <div
                                                                    class="position-absolute h-100 top-0 w-100 d-flex align-content-center justify-content-center">
                                                                    <div
                                                                        class="d-flex flex-column justify-content-center align-items-center">
                                                                        <img alt=""
                                                                            src="{{ dynamicAsset(path: 'public/assets/back-end/img/icons/product-upload-icon.svg') }}"
                                                                            class="w-75">
                                                                        <h3 class="text-muted">
                                                                            {{ translate('Upload_Image') }}
                                                                        </h3>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    @if ($product->color_image)
                                                        @foreach ($product->color_images_full_url as $photo)
                                                            @if ($photo['color'] == null)
                                                                @php($unique_id = rand(1111, 9999))
                                                                <div class="col-sm-12 col-md-4"
                                                                    id="addition-image-section-{{ $key }}">
                                                                    <div
                                                                        class="custom_upload_input custom-upload-input-file-area position-relative border-dashed-2 aspect-1">
                                                                        @if (request('product-gallery'))
                                                                            <button
                                                                                class="delete_file_input_css btn btn-outline-danger btn-sm square-btn remove-addition-image-for-product-gallery"
                                                                                data-section-remove-id="addition-image-section-{{ $key }}">
                                                                                <i class="tio-delete"></i>
                                                                            </button>
                                                                        @else
                                                                            <a class="delete_file_input_css btn btn-outline-danger btn-sm square-btn"
                                                                                href="{{ route('admin.products.delete-image', ['id' => $product['id'], 'name' => $photo['image_name']['key'], 'color' => 'null']) }}">
                                                                                <i class="tio-delete"></i>
                                                                            </a>
                                                                        @endif

                                                                        <div
                                                                            class="img_area_with_preview position-absolute z-index-2 border-0">
                                                                            <img id="additional_Image_{{ $unique_id }}"
                                                                                alt=""
                                                                                class="h-auto aspect-1 bg-white  "
                                                                                src="{{ getStorageImages(path: $photo['image_name'], type: 'backend-product') }}">
                                                                            @if (request('product-gallery'))
                                                                                <input type="text"
                                                                                    name="existing_images[]"
                                                                                    value="{{ $photo['image_name']['key'] }}"
                                                                                    hidden>
                                                                            @endif
                                                                        </div>
                                                                        <div
                                                                            class="position-absolute h-100 top-0 w-100 d-flex align-content-center justify-content-center">
                                                                            <div
                                                                                class="d-flex flex-column justify-content-center align-items-center">
                                                                                <img alt=""
                                                                                    src="{{ dynamicAsset(path: 'public/assets/back-end/img/icons/product-upload-icon.svg') }}"
                                                                                    class="w-75">
                                                                                <h3 class="text-muted">
                                                                                    {{ translate('Upload_Image') }}</h3>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        @foreach ($product->images_full_url as $key => $photo)
                                                            @php($unique_id = rand(1111, 9999))
                                                            <div class="col-sm-12 col-md-4"
                                                                id="addition-image-section-{{ $key }}">
                                                                <div
                                                                    class="custom_upload_input custom-upload-input-file-area position-relative border-dashed-2 aspect-1">
                                                                    @if (request('product-gallery'))
                                                                        <button
                                                                            class="delete_file_input_css btn btn-outline-danger btn-sm square-btn remove-addition-image-for-product-gallery"
                                                                            data-section-remove-id="addition-image-section-{{ $key }}">
                                                                            <i class="tio-delete"></i>
                                                                        </button>
                                                                    @else
                                                                        <a class="delete_file_input_css btn btn-outline-danger btn-sm square-btn"
                                                                            href="{{ route('admin.products.delete-image', ['id' => $product['id'], 'name' => $photo['key']]) }}">
                                                                            <i class="tio-delete"></i>
                                                                        </a>
                                                                    @endif
                                                                    <div
                                                                        class="img_area_with_preview position-absolute z-index-2 border-0">
                                                                        <img id="additional_Image_{{ $unique_id }}"
                                                                            alt=""
                                                                            class="h-auto aspect-1 bg-white  "
                                                                            src="{{ getStorageImages(path: $photo, type: 'backend-product') }}">
                                                                        @if (request('product-gallery'))
                                                                            <input type="text" name="existing_images[]"
                                                                                value="{{ $photo['key'] }}" hidden>
                                                                        @endif
                                                                    </div>
                                                                    <div
                                                                        class="position-absolute h-100 top-0 w-100 d-flex align-content-center justify-content-center">
                                                                        <div
                                                                            class="d-flex flex-column justify-content-center align-items-center">
                                                                            <img alt="" class="w-75"
                                                                                src="{{ dynamicAsset(path: 'public/assets/back-end/img/icons/product-upload-icon.svg') }}">
                                                                            <h3 class="text-muted">
                                                                                {{ translate('Upload_Image') }}</h3>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                @endif
                                                <div class="col-sm-12 col-md-4">
                                                    <div
                                                        class="custom_upload_input position-relative border-dashed-2 aspect-1">
                                                        <input type="file" name="images[]"
                                                            class="custom-upload-input-file action-add-more-image"
                                                            data-index="1" data-imgpreview="additional_Image_1"
                                                            accept=".jpg, .webp, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*"
                                                            data-target-section="#additional_Image_Section">

                                                        <span
                                                            class="delete_file_input delete_file_input_section btn btn-outline-danger btn-sm square-btn d-none">
                                                            <i class="tio-delete"></i>
                                                        </span>

                                                        <div
                                                            class="img_area_with_preview position-absolute z-index-2 border-0">
                                                            <img id="additional_Image_1"
                                                                class="h-auto aspect-1 bg-white d-none" alt=""
                                                                src="">
                                                        </div>
                                                        <div
                                                            class="position-absolute h-100 top-0 w-100 d-flex align-content-center justify-content-center">
                                                            <div
                                                                class="d-flex flex-column justify-content-center align-items-center">
                                                                <img alt=""
                                                                    src="{{ dynamicAsset(path: 'public/assets/back-end/img/icons/product-upload-icon.svg') }}"
                                                                    class="w-75">
                                                                <h3 class="text-muted">{{ translate('Upload_Image') }}
                                                                </h3>
                                                            </div>
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
                                                <div class="image-uploader__title line--limit-2"
                                                    data-default="{{ translate('Upload_File') }}">
                                                    @if ($product->preview_file_full_url['path'])
                                                        {{ $product->preview_file }}
                                                    @elseif(request('product-gallery') && $product?->preview_file)
                                                        {{ translate('Upload_File') }}
                                                    @else
                                                        {{ translate('Upload_File') }}
                                                    @endif

                                                    @if (request('product-gallery'))
                                                        <input type="hidden" name="existing_preview_file"
                                                            value="{{ $product?->preview_file }}">
                                                        <input type="hidden" name="existing_preview_file_storage_type"
                                                            value="{{ $product?->preview_file_storage_type }}">
                                                    @endif
                                                </div>
                                            </div>

                                            @if ($product->preview_file_full_url['path'])
                                                <span
                                                    class="btn btn-outline-danger btn-sm square-btn collapse show zip-remove-btn delete_preview_file_input"
                                                    data-route="{{ route('admin.products.delete-preview-file') }}">
                                                    <i class="tio-delete"></i>
                                                </span>
                                            @else
                                                <span
                                                    class="btn btn-outline-danger btn-sm square-btn collapse zip-remove-btn">
                                                    <i class="tio-delete"></i>
                                                </span>
                                            @endif
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

                        <input type="hidden" id="color_image"
                            value="{{ json_encode($product->color_images_full_url) }}">
                        <input type="hidden" id="images" value="{{ json_encode($product->images_full_url) }}">
                        <input type="hidden" id="product_id" name="product_id" value="{{ $product['id'] }}">
                        <input type="hidden" id="remove_url" value="{{ route('admin.products.delete-image') }}">
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
                                <option value="{{ $country->id }}"
                                    {{ isset($product['origin']) && $product['origin'] == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}</option>
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
                                id="minimum_order_qty" class="form-control"
                                value="{{ $product['minimum_order_qty'] ?? 0 }}" required>
                        </div>
                    </div>
                    <div class="col-lg-4 physical_product_show">
                        <div class="form-group">
                            <label class="title-color">{{ translate('unit') }}</label>
                            <select class="js-example-basic-multiple form-control" name="unit">
                                @foreach (units() as $unit)
                                    <option value="{{ $unit }}"
                                        {{ $product['unit'] == $unit ? 'selected' : '' }}>
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
                                id="supply_capacity" class="form-control" required
                                value="{{ $product['supply_capacity'] }}">
                        </div>
                    </div>
                    <div class="col-lg-4 physical_product_show">
                        <div class="form-group">
                            <label class="title-color">{{ translate('Supply Unit') }}</label>
                            <select class="js-example-basic-multiple form-control" name="supply_unit">
                                @foreach (units() as $unit)
                                    <option value="{{ $unit }}"
                                        {{ isset($product['supply_unit']) && $unit == $product['supply_unit'] ? 'selected' : '' }}>
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
                                value="{{ $product['unit_price'] }}" value="{{ $product['unit_price'] ?? 0 }}"
                                class="form-control" required>
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
                            <input type="text"
                                placeholder="{{ translate('local_currency') }}" name="local_currency"
                                value="{{ $product['local_currency'] }}"
                                class="form-control" required>
                        </div>
                    </div>

                    <div class="col-lg-4 physical_product_show">
                        <div class="form-group">
                            <label class="title-color">{{ translate('Delivery Terms') }}</label>
                            <select class="form-control" name="delivery_terms">
                                <option value="CFR" {{ $product['delivery_terms'] == 'CFR' ? 'selected' : '' }}>CFR
                                </option>
                                <option value="FOB" {{ $product['delivery_terms'] == 'FOB' ? 'selected' : '' }}>FOB
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 physical_product_show">
                        <div class="form-group">
                            <label class="title-color">{{ translate('Delivery Mode') }}</label>
                            <select class="form-control" name="delivery_mode">
                                <option value="Air" {{ $product['delivery_mode'] == 'Air' ? 'selected' : '' }}>Air
                                </option>
                                <option value="Sea" {{ $product['delivery_mode'] == 'Sea' ? 'selected' : '' }}>Sea
                                </option>
                                <option value="Rail_Road"
                                    {{ $product['delivery_mode'] == 'Rail_Road' ? 'selected' : '' }}>
                                    Rail Road</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4" style="padding-bottom:15px;">
                        <label class="form-label">{{ translate('Place of Loading') }}</label>
                        <input type="text" class="form-control" name="place_of_loading"
                            value="{{ $product['place_of_loading'] }}" placeholder="e.g., Shanghai, Ningbo">
                    </div>
                    <div class="col-lg-4" style="padding-bottom:15px;">
                        <label class="form-label">{{ translate('Port of Loading') }}</label>
                        <select class="form-control" name="port_of_loading">
                            <option value="Factory" {{ $product['port_of_loading'] == 'Factory' ? 'selected' : '' }}>
                                Factory
                            </option>
                            <option value="Sea_Port" {{ $product['port_of_loading'] == 'Sea_Port' ? 'selected' : '' }}>
                                Sea
                                Port</option>
                            <option value="ICD" {{ $product['port_of_loading'] == 'ICD' ? 'selected' : '' }}>ICD
                            </option>
                            <option value="Air_Port" {{ $product['port_of_loading'] == 'Air_Port' ? 'selected' : '' }}>
                                Air
                                Port</option>
                        </select>
                    </div>
                    <div class="col-lg-4" style="padding-bottom:15px;">
                        <label class="form-label">{{ translate('Production Lead Time') }}</label>
                        <input type="text" class="form-control" name="lead_time"
                            value="{{ $product['lead_time'] }}" placeholder="e.g., 7-10 business days">
                    </div>
                    <div class="col-lg-4" style="padding-bottom:15px;">
                        <label class="form-label">{{ translate('Lead Time Unit') }}</label>
                        <select class="js-example-basic-multiple form-control" name="lead_time_unit">
                            <option value="days" {{ $product['lead_time_unit'] == 'days' ? 'selected' : '' }}>Days
                            </option>
                            <option value="months" {{ $product['lead_time_unit'] == 'month' ? 'selected' : '' }}>Month
                            </option>
                        </select>
                    </div>
                    <div class="col-lg-4" style="padding-bottom:15px;">
                        <label class="form-label">{{ translate('Payment Terms') }}</label>
                        <select class="form-control" name="payment_terms">
                            <option value="">Select Payment Term</option>
                            <option value="L/C at Sight"
                                {{ $product['payment_terms'] == 'L/C at Sight' ? 'selected' : '' }}>
                                L/C at Sight</option>
                            <option value="L/C 30/60/90 Days"
                                {{ $product['payment_terms'] == 'L/C 30/60/90 Days' ? 'selected' : '' }}>L/C 30/60/90 Days
                            </option>
                            <option value="D/A (Documents Against Acceptance)"
                                {{ $product['payment_terms'] == 'D/A (Documents Against Acceptance)' ? 'selected' : '' }}>
                                D/A
                                (Documents Against Acceptance)</option>
                            <option value="D/P (Documents Against Payment)"
                                {{ $product['payment_terms'] == 'D/P (Documents Against Payment)' ? 'selected' : '' }}>D/P
                                (Documents Against Payment)</option>
                            <option value="CAD (Cash Against Documents)"
                                {{ $product['payment_terms'] == 'CAD (Cash Against Documents)' ? 'selected' : '' }}>CAD
                                (Cash
                                Against Documents)</option>
                            <option value="T/T (Telegraphic Transfer)"
                                {{ $product['payment_terms'] == 'T/T (Telegraphic Transfer)' ? 'selected' : '' }}>T/T
                                (Telegraphic Transfer)</option>
                            <option value="Advance Payment"
                                {{ $product['payment_terms'] == 'Advance Payment' ? 'selected' : '' }}>Advance Payment
                            </option>
                            <option value="Net 30" {{ $product['payment_terms'] == 'Net 30' ? 'selected' : '' }}>Net 30
                            </option>
                            <option value="Net 60" {{ $product['payment_terms'] == 'Net 60' ? 'selected' : '' }}>Net 60
                            </option>
                        </select>
                    </div>

                    <div class="col-lg-4" style="padding-bottom:15px;">
                        <label class="form-label">{{ translate('Packing Type') }}</label>
                        <select class="form-control" name="packing_type">
                            <option value="">Select Packing Type</option>
                            <option value="PP Bag" {{ $product['packing_type'] == 'PP Bag' ? 'selected' : '' }}>PP Bag
                            </option>
                            <option value="Carton" {{ $product['packing_type'] == 'Carton' ? 'selected' : '' }}>Carton
                            </option>
                            <option value="Plastic Drum"
                                {{ $product['packing_type'] == 'Plastic Drum' ? 'selected' : '' }}>
                                Plastic Drum</option>
                            <option value="Steel Drum" {{ $product['packing_type'] == 'Steel Drum' ? 'selected' : '' }}>
                                Steel
                                Drum</option>
                            <option value="Wooden Crate"
                                {{ $product['packing_type'] == 'Wooden Crate' ? 'selected' : '' }}>
                                Wooden Crate</option>
                            <option value="Bulk" {{ $product['packing_type'] == 'Bulk' ? 'selected' : '' }}>Bulk
                            </option>
                            <option value="IBC Tank" {{ $product['packing_type'] == 'IBC Tank' ? 'selected' : '' }}>IBC
                                Tank
                            </option>
                            <option value="Plastic Container"
                                {{ $product['packing_type'] == 'Plastic Container' ? 'selected' : '' }}>Plastic Container
                            </option>
                            <option value="Custom Packaging"
                                {{ $product['packing_type'] == 'Custom Packaging' ? 'selected' : '' }}>Custom Packaging
                            </option>
                        </select>
                    </div>

                    <div class="col-lg-4" style="padding-bottom:15px;">
                        <label class="form-label">{{ translate('Size') }}</label>
                        <input type="text" class="form-control" name="weight_per_unit"
                            value="{{ $product['weight_per_unit'] }}" placeholder="e.g., 1.5kg">
                    </div>
                    <div class="col-lg-4" style="padding-bottom:15px;">
                        <label class="form-label">{{ translate('Internal Packing') }}</label>
                        <input type="text" class="form-control" name="dimensions_per_unit"
                            value="{{ $product['dimensions_per_unit'] }}" placeholder="e.g., 10x5x2 cm">
                    </div>
                    <div class="col-lg-4" style="padding-bottom:15px;">
                        <label class="form-label">{{ translate('Target Market') }}</label>
                        <select class="js-example-basic-multiple form-control" name="target_market[]" multiple>
                            @foreach ($countries as $country)
                                <option value="{{ $country['id'] }}"
                                    {{ in_array($country['id'], old('target_market', json_decode($product['target_market'],true) ?? [])) ? 'selected' : '' }}>
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
                                        <option value="{{ $brand['id'] }}"
                                            {{ $brand['id'] == $product['brand_id'] ? 'selected' : '' }}>
                                            {{ $brand['defaultName'] }}</option>
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
                            <textarea name="short_details[]" class="summernote">{!! $product['short_details'] !!}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group pt-4">
                            <label class="title-color" for="description">{{ translate('Description') }}
                            </label>
                            <textarea name="description[]" class="summernote">{!! $product['details'] !!}</textarea>
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
                        <input type="file" name="certificate" id="certificate"
                            accept=".jpg, .webp, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                        @if(!empty($product->certificate))
                            <div>
                                <img src="/{{$product->certificate}}" 
                                    alt="Current Certificate" 
                                    style="max-width: 100%; height: auto; border: 1px solid #ddd; margin-top: 8px;">
                            </div>
                        @endif
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
                                    <option value="physical"
                                        {{ $product['product_type'] == 'physical' ? 'selected' : '' }}>
                                        {{ translate('physical') }}</option>
                                    @if ($digitalProductSetting)
                                        <option value="digital"
                                            {{ $product['product_type'] == 'digital' ? 'selected' : '' }}>
                                            {{ translate('digital') }}</option>
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
                                    <option value="{{ $authors['name'] }}"
                                        {{ in_array($authors['id'], $productAuthorIds) ? 'selected' : '' }}>
                                        {{ $authors['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-4 digital-product-sections-show">
                            <label class="title-color">{{ translate('Publishing_House') }}</label>
                            <select class="multiple-select2 form-control" name="publishing_house[]" multiple="multiple">
                                @foreach ($publishingHouseList as $publishingHouse)
                                    <option value="{{ $publishingHouse['name'] }}"
                                        {{ in_array($publishingHouse['id'], $productPublishingHouseIds) ? 'selected' : '' }}>
                                        {{ $publishingHouse['name'] }}</option>
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
                                    <option value="{{ old('category_id') }}"
                                        {{ !$product['digital_product_type'] ? 'selected' : '' }} disabled>
                                        ---{{ translate('select') }}---
                                    </option>
                                    <option value="ready_after_sell"
                                        {{ $product['digital_product_type'] == 'ready_after_sell' ? 'selected' : '' }}>
                                        {{ translate('ready_After_Sell') }}</option>
                                    <option value="ready_product"
                                        {{ $product['digital_product_type'] == 'ready_product' ? 'selected' : '' }}>
                                        {{ translate('ready_Product') }}</option>
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
                                <input type="text" id="generate_number" name="code" class="form-control"
                                    value="{{ request('product-gallery') ? ' ' : $product->code }}"
                                    placeholder="{{ translate('4FOITO') }}" required>
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
                                            data-role="badgeinput" value="{{ $product->badge }}">
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
                                <input type="text" class="form-control" name="tags"
                                    value="@foreach ($product['tags'] as $tag) {{ $tag->tag . ',' }} @endforeach"
                                    data-role="tagsinput">
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
                                placeholder="e.g., Logo, Color, Packaging" value="{{ $product->customization }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ translate('Style') }}</label>
                            <input type="text" class="form-control" name="style"
                                placeholder="e.g., Modern, Classic, Industrial" value="{{ $product->style }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ translate('Usage') }}</label>
                            <input type="text" class="form-control" name="usage" value="{{ $product->usage }}"
                                placeholder="e.g., Indoor/Outdoor Use">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ translate('Sample Price') }}</label>
                            <input type="text" class="form-control" name="sample_price" placeholder="e.g., $20" value="{{ $product->sample_price }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ translate('Sample Amount') }}</label>
                            <input type="text" class="form-control" name="sample_amount" placeholder="e.g., 2 units" value="{{ $product->sample_amount }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ translate('Model Number') }}</label>
                            <input type="text" class="form-control" name="model_number" placeholder="e.g., ABC123" value="{{ $product->model_number }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ translate('Small Orders Accepted') }}</label>
                            <select class="form-control" name="small_orders">
                                <option value="1"
                                    {{ isset($product->small_orders) && $product->small_orders == 1 ? 'selected' : '' }}>
                                    {{ translate('Yes') }}</option>
                                <option value="0"
                                    {{ isset($product->small_orders) && $product->small_orders == 0 ? 'selected' : '' }}>
                                    {{ translate('No') }}</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">{{ translate('FAQ') }}</label>
                            <textarea class="summernote" name="faq" rows="3" placeholder="Write common questions and answers..."> {{ $product->faq }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">{{ translate('Why Choose Us?') }}</label>
                            <textarea class="summernote" name="why_choose_us" rows="3"
                                placeholder="e.g., Trusted supplier, 10+ years experience">{{ $product->why_choose_us }}</textarea>
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
                                placeholder="e.g., 60x40x30 cm" value="{{ $product->export_carton_dimensions }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ translate('Logistics Attributes') }}</label>
                            <input type="text" class="form-control" name="logistics_attributes"
                                placeholder="e.g., Stackable, Fragile" value="{{ $product->logistics_attributes }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ translate('Units per Export Carton') }}</label>
                            <input type="text" class="form-control" name="units_per_carton" placeholder="e.g., 50"
                                value="{{ $product->units_per_carton }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ translate('Export Carton Weight') }}</label>
                            <input type="text" class="form-control" name="carton_weight" placeholder="e.g., 75kg"
                                value="{{ $product->carton_weight }}">
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
                                placeholder="e.g., North America, Europe, Southeast Asia">{{ $product->export_markets }}</textarea>
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
                                placeholder="e.g., Bank Transfer (T/T), PayPal, L/C, Western Union"
                                value="{{ $product->payment_methods }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">{{ translate('Currency Accepted') }}</label>
                            <input type="text" class="form-control" name="currency_accepted"
                                value="{{ $product->currency_accepted }}" placeholder="e.g., USD, EUR, GBP">
                        </div>
                        <div class="col-12">
                            <label class="form-label">{{ translate('Invoicing Info') }}</label>
                            <input type="text" class="form-control" name="invoicing"
                                value="{{ $product->invoicing }}"
                                placeholder="e.g., Issued with shipment, PDF format via email">
                        </div>
                        <div class="col-12">
                            <label class="form-label">{{ translate('Refund Policy') }}</label>
                            <textarea class="summernote" name="refund_policy" rows="3" placeholder="State refund conditions, if any...">{{ $product->refund_policy }}</textarea>
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
                                    placeholder="{{ translate('purchase_price') }}" name="purchase_price"
                                    class="form-control" value={{ usdToDefaultCurrency($product['purchase_price']) }}
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

                                <input type="number" min="0" value={{ $product['current_stock'] }}
                                    step="1" placeholder="{{ translate('quantity') }}" name="current_stock"
                                    id="current_stock" class="form-control" required>
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
                                <select class="form-control" name="discount_type" id="discount_type">
                                    <option value="flat" {{ $product['discount_type'] == 'flat' ? 'selected' : '' }}>
                                        {{ translate('flat') }}</option>
                                    <option value="percent" {{ $product['discount_type'] == 'percent' ? 'selected' : '' }}>
                                        {{ translate('percent') }}</option>
                                </select>
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

                                <input type="number" min="0"
                                    value="{{ $product->discount_type == 'flat' ? usdToDefaultCurrency($product->discount) : $product->discount }}"
                                    step="0.01" placeholder="{{ translate('ex: 5') }}" name="discount"
                                    id="discount" class="form-control" required>
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
                                    <option value="include" {{ $product->tax_model == 'include' ? 'selected' : '' }}>
                                        {{ translate('include_with_product') }}</option>
                                    <option value="exclude" {{ $product->tax_model == 'exclude' ? 'selected' : '' }}>
                                        {{ translate('exclude_with_product') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <div class="d-flex gap-2">
                                    <label class="title-color" for="tax">
                                        {{ translate('Tax') }}
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
                                    value="{{ $product->tax ?? 0 }}" class="form-control">
                                <input name="tax_type" value="percent" class="d-none">
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

                                <input type="number" min="0"
                                    value="{{ usdToDefaultCurrency($product->shipping_cost) }}" step="1"
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
                                            <input class="switcher_input" type="checkbox" name="multiply_qty"
                                                id="" {{ $product['multiply_qty'] == 1 ? 'checked' : '' }}>
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
                                        @if ($product->digital_product_file_types)
                                            <option value="{{ $FileType }}"
                                                {{ in_array($FileType, $product->digital_product_file_types) ? 'selected' : '' }}>
                                                {{ translate($FileType) }}
                                            </option>
                                        @else
                                            <option value="{{ $FileType }}">{{ translate($FileType) }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @if ($product->digital_product_file_types && count($product->digital_product_file_types) > 0)
                            @foreach ($product->digital_product_file_types as $digitalProductFileTypes)
                                <div class="col-sm-6 col-md-4 col-xxl-3 extension-choice-section">
                                    <div class="form-group">
                                        <input type="hidden" name="extensions_type[]"
                                            value="{{ $digitalProductFileTypes }}">
                                        <label class="title-color">
                                            {{ $digitalProductFileTypes }}
                                        </label>
                                        <input type="text" name="extensions[]"
                                            value="{{ $digitalProductFileTypes }}" hidden>
                                        <div class="">
                                            @if ($product->digital_product_extensions && isset($product->digital_product_extensions[$digitalProductFileTypes]))
                                                <input type="text" class="form-control"
                                                    name="extensions_options_{{ $digitalProductFileTypes }}[]"
                                                    placeholder="{{ translate('enter_choice_values') }}"
                                                    data-role="tagsinput"
                                                    value="@foreach ($product->digital_product_extensions[$digitalProductFileTypes] as $extensions){{ $extensions . ',' }} @endforeach"
                                                    onchange="getUpdateDigitalVariationFunctionality()">
                                            @else
                                                <input type="text" class="form-control"
                                                    name="extensions_options_{{ $digitalProductFileTypes }}[]"
                                                    placeholder="{{ translate('enter_choice_values') }}"
                                                    data-role="tagsinput"
                                                    onchange="getUpdateDigitalVariationFunctionality()">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>

            <div class="card mt-3 rest-part" id="digital-product-variation-section"></div>

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
                            <div class="form-group">
                                <div class="mb-3 d-flex align-items-center gap-2">
                                    <label class="mb-0 title-color">
                                        {{ translate('select_colors') }} :
                                    </label>
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher_input" id="product-color-switcher"
                                            name="colors_active" {{ count($product['colors']) > 0 ? 'checked' : '' }}>
                                        <span class="switcher_control"></span>
                                    </label>
                                </div>

                                <select
                                    class="js-example-basic-multiple js-states js-example-responsive form-control color-var-select"
                                    name="colors[]" multiple="multiple" id="colors-selector"
                                    {{ count($product['colors']) > 0 ? '' : 'disabled' }}>
                                    @foreach ($colors as $key => $color)
                                        <option value={{ $color->code }}
                                            {{ in_array($color->code, $product['colors']) ? 'selected' : '' }}>
                                            {{ $color['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="choice_attributes" class="pb-1 title-color">
                                    {{ translate('select_attributes') }} :
                                </label>
                                <select class="js-example-basic-multiple js-states js-example-responsive form-control"
                                    name="choice_attributes[]" id="choice_attributes" multiple="multiple">
                                    @foreach ($attributes as $key => $attribute)
                                        @if ($product['attributes'] != 'null')
                                            <option value="{{ $attribute['id'] }}"
                                                {{ in_array($attribute->id, json_decode($product['attributes'], true)) ? 'selected' : '' }}>
                                                {{ $attribute['name'] }}
                                            </option>
                                        @else
                                            <option value="{{ $attribute['id'] }}">{{ $attribute['name'] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 mt-2 mb-2">
                            <div class="row customer_choice_options mt-2" id="customer_choice_options">
                                @include('admin-views.product.partials._choices', [
                                    'choice_no' => json_decode($product['attributes']),
                                    'choice_options' => json_decode($product['choice_options'], true),
                                ])
                            </div>

                            <div class="sku_combination table-responsive form-group mt-2" id="sku_combination">
                                @include('admin-views.product.partials._edit_sku_combinations', [
                                    'combinations' => json_decode($product['variation'], true),
                                ])
                            </div>
                        </div>
                    </div>
                </div>
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
                        <span class="text-info"> ( {{ translate('optional_please_provide_embed_link_not_direct_link') }}.
                            )</span>
                    </div>
                    <input type="text" value="{{ $product['video_url'] }}" name="video_url"
                        placeholder="{{ translate('ex') }} : https://www.youtube.com/embed/5R06LRdUCSE"
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
                                <input type="text" name="meta_title"
                                    value="{{ $product?->seoInfo?->title ?? $product->meta_title }}" placeholder=""
                                    class="form-control">
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
                                <textarea rows="4" type="text" name="meta_description" class="form-control">{{ $product?->seoInfo?->description ?? $product->meta_description }}</textarea>
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
                                                id="" data-imgpreview="pre_meta_image_viewer"
                                                accept=".jpg, .webp, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">

                                            @if ($product?->seoInfo?->image_full_url['path'] || $product->meta_image_full_url['path'])
                                                <span
                                                    class="delete_file_input btn btn-outline-danger btn-sm square-btn d-flex">
                                                    <i class="tio-delete"></i>
                                                </span>
                                            @else
                                                <span
                                                    class="delete_file_input btn btn-outline-danger btn-sm square-btn d--none">
                                                    <i class="tio-delete"></i>
                                                </span>
                                            @endif

                                            <div class="img_area_with_preview position-absolute z-index-2 d-flex">
                                                <img id="pre_meta_image_viewer" class="h-auto aspect-1 bg-white"
                                                    alt=""
                                                    src="{{ getStorageImages(path: $product?->seoInfo?->image_full_url['path'] ? $product?->seoInfo?->image_full_url : $product->meta_image_full_url, type: 'backend-banner') }}">
                                            </div>
                                            <div
                                                class="position-absolute h-100 top-0 w-100 d-flex align-content-center justify-content-center">
                                                <div class="d-flex flex-column justify-content-center align-items-center">
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

                    @include('admin-views.product.partials._seo-update-section')
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <button type="button" class="btn btn--primary px-5 product-add-requirements-check">
                    @if ($product->request_status == 2)
                        {{ translate('resubmit') }}
                    @else
                        {{ translate(request('product-gallery') ? 'submit' : 'update') }}
                    @endif
                </button>
            </div>
            @if (request('product-gallery'))
                <input hidden name="existing_thumbnail" value="{{ $product->thumbnail_full_url['key'] }}">
                <input hidden name="existing_meta_image"
                    value="{{ $product?->seoInfo?->image_full_url['key'] ?? $product->meta_image_full_url['key'] }}">
            @endif
        </form>
    </div>

    <span id="route-admin-products-sku-combination" data-url="{{ route('admin.products.sku-combination') }}"></span>
    <span id="route-admin-products-digital-variation-combination"
        data-url="{{ route('admin.products.digital-variation-combination') }}"></span>
    <span id="route-admin-products-digital-variation-file-delete"
        data-url="{{ route('admin.products.digital-variation-file-delete') }}"></span>
    <span id="image-path-of-product-upload-icon"
        data-path="{{ dynamicAsset(path: 'public/assets/back-end/img/icons/product-upload-icon.svg') }}"></span>
    <span id="image-path-of-product-upload-icon-two"
        data-path="{{ dynamicAsset(path: 'public/assets/back-end/img/400x400/img2.jpg') }}"></span>
    <span id="message-enter-choice-values" data-text="{{ translate('enter_choice_values') }}"></span>
    <span id="message-upload-image" data-text="{{ translate('upload_Image') }}"></span>
    <span id="message-are-you-sure" data-text="{{ translate('are_you_sure') }}"></span>
    <span id="message-yes-word" data-text="{{ translate('yes') }}"></span>
    <span id="message-no-word" data-text="{{ translate('no') }}"></span>
    <span id="message-want-to-add-or-update-this-product"
        data-text="{{ translate('want_to_update_this_product') }}"></span>
    <span id="message-please-only-input-png-or-jpg"
        data-text="{{ translate('please_only_input_png_or_jpg_type_file') }}"></span>
    <span id="message-product-added-successfully" data-text="{{ translate('product_added_successfully') }}"></span>
    <span id="message-discount-will-not-larger-then-variant-price"
        data-text="{{ translate('the_discount_price_will_not_larger_then_Variant_Price') }}"></span>
    <span id="system-currency-code" data-value="{{ getCurrencySymbol(currencyCode: getCurrencyCode()) }}"></span>
    <span id="system-session-direction" data-value="{{ Session::get('direction') }}"></span>
    <span id="message-file-size-too-big" data-text="{{ translate('file_size_too_big') }}"></span>
@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/tags-input.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/product-add-update.js') }}"></script>

    <script>
        "use strict";

        let colors = {{ count($product->colors) }};
        let imageCount = {{ 15 - count(json_decode($product->images)) }};
        let thumbnail =
            '{{ productImagePath('thumbnail') . '/' . $product->thumbnail ?? dynamicAsset(path: 'public/assets/back-end/img/400x400/img2.jpg') }}';
        $(function() {
            if (imageCount > 0) {
                $("#coba").spartanMultiImagePicker({
                    fieldName: 'images[]',
                    maxCount: colors === 0 ? 15 : imageCount,
                    rowHeight: 'auto',
                    groupClassName: 'col-6 col-md-4 col-xl-3 col-xxl-2',
                    maxFileSize: '',
                    placeholderImage: {
                        image: '{{ dynamicAsset(path: 'public/assets/back-end/img/400x400/img2.jpg') }}',
                        width: '100%',
                    },
                    dropFileLabel: "Drop Here",
                    onAddRow: function(index, file) {},
                    onRenderedPreview: function(index) {},
                    onRemoveRow: function(index) {},
                    onExtensionErr: function() {
                        toastr.error(messagePleaseOnlyInputPNGOrJPG, {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    },
                    onSizeErr: function() {
                        toastr.error(messageFileSizeTooBig, {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                });
            }

            $("#thumbnail").spartanMultiImagePicker({
                fieldName: 'image',
                maxCount: 1,
                rowHeight: 'auto',
                groupClassName: 'col-12',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{ productImagePath('thumbnail') . '/' . $product->thumbnail ?? dynamicAsset(path: 'public/assets/back-end/img/400x400/img2.jpg') }}',
                    width: '100%',
                },
                dropFileLabel: "Drop Here",
                onAddRow: function(index, file) {

                },
                onRenderedPreview: function(index) {

                },
                onRemoveRow: function(index) {

                },
                onExtensionErr: function() {
                    toastr.error(messagePleaseOnlyInputPNGOrJPG, {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function() {
                    toastr.error(messageFileSizeTooBig, {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });

        });

        setTimeout(function() {
            $('.call-update-sku').on('change', function() {
                getUpdateSKUFunctionality();
            });
        }, 2000)

        function colorWiseImageFunctionality(t) {
            let colors = t.val();
            let color_image = $('#color_image').val() ? $.parseJSON($('#color_image').val()) : [];

            let images = $.parseJSON($('#images').val());
            let product_id = $('#product_id').val();
            let remove_url = $('#remove_url').val();

            let color_image_value = $.map(color_image, function(item) {
                return item.color;
            });

            $('#color_wise_existing_image').html('')
            $('#color-wise-image-section').html('')

            $.each(colors, function(key, value) {
                let value_id = value.replace('#', '');
                let in_array_image = $.inArray(value_id, color_image_value);
                let input_image_name = "color_image_" + value_id;
                @if (request('product-gallery'))
                    $.each(color_image, function(color_key, color_value) {
                        if ((in_array_image !== -1) && (color_value['color'] === value_id)) {
                            let image_name = color_value['image_name'];
                            let exist_image_html = `
                                    <div class="col-6 col-md-4 col-xl-4 color-image-` + color_value['color'] +
                                `">
                                        <div class="position-relative p-2 border-dashed-2">
                                            <div class="upload--icon-btns d-flex gap-2 position-absolute z-index-2 p-2" >
                                                <button type="button" class="btn btn-square text-white btn-sm" style="background: #${color_value['color']}"><i class="tio-done"></i></button>
                                                <button class="btn btn-outline-danger btn-sm square-btn remove-color-image-for-product-gallery" data-color="` +
                                color_value['color'] + `"><i class="tio-delete"></i></button>
                                            </div>
                                            <img class="w-100" height="auto"
                                                onerror="this.src='{{ dynamicAsset(path: 'public/assets/front-end/img/image-place-holder.png') }}'"
                                                src="${image_name['path']}"
                                                alt="Product image">
                                                <input type="text" name="color_image_` + color_value['color'] +
                                `[]" value="` + image_name['key'] + `" hidden>
                                        </div>
                                    </div>`;
                            $('#color_wise_existing_image').append(exist_image_html)
                        }
                    });
                @else
                    $.each(color_image, function(color_key, color_value) {
                        if ((in_array_image !== -1) && (color_value['color'] === value_id)) {
                            let image_name = color_value['image_name'];
                            let exist_image_html = `
                                    <div class="col-6 col-md-4 col-xl-4">
                                        <div class="position-relative p-2 border-dashed-2">
                                            <div class="upload--icon-btns d-flex gap-2 position-absolute z-index-2 p-2" >
                                                <button type="button" class="btn btn-square text-white btn-sm" style="background: #${color_value['color']}"><i class="tio-done"></i></button>
                                                <a href="` + remove_url + `?id=` + product_id + `&name=` + image_name[
                                'key'] + `&color=` + color_value['color'] + `"
                                            class="btn btn-outline-danger btn-sm square-btn"><i class="tio-delete"></i></a>
                                            </div>
                                            <img class="w-100" height="auto"
                                                onerror="this.src='{{ dynamicAsset(path: 'public/assets/front-end/img/image-place-holder.png') }}'"
                                                src="${image_name['path']}"
                                                alt="Product image">
                                        </div>
                                    </div>`;
                            $('#color_wise_existing_image').append(exist_image_html)
                        }
                    });
                @endif
            });

            $.each(colors, function(key, value) {
                let value_id = value.replace('#', '');
                let in_array_image = $.inArray(value_id, color_image_value);
                let input_image_name = "color_image_" + value_id;

                if (in_array_image === -1) {
                    let html = `<div class='col-6 col-md-4 col-xl-4'>
                                        <div class="position-relative p-2 border-dashed-2">
                                            <label style='border-radius: 3px; cursor: pointer; text-align: center; overflow: hidden; position : relative; display: flex; align-items: center; margin: auto; justify-content: center; flex-direction: column;'>
                                            <span class="upload--icon" style="background: ${value}">
                                            <i class="tio-edit"></i>
                                                <input type="file" name="` + input_image_name + `" id="` + value_id + `" class="d-none" accept=".jpg, .webp, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required="">
                                            </span>

                                            <div class="h-100 top-0 aspect-1 w-100 d-flex align-content-center justify-content-center overflow-hidden">
                                                <div class="d-flex flex-column justify-content-center align-items-center">
                                                    <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/icons/product-upload-icon.svg') }}" class="w-75">
                                                    <h3 class="text-muted">{{ translate('Upload_Image') }}</h3>
                                                </div>
                                            </div>
                                        </label>
                                        </div>
                                        </div>`;
                    $('#color-wise-image-section').append(html)

                    $("#color-wise-image-section input[type='file']").each(function() {

                        let thisElement = $(this).closest('label');

                        function proPicURL(input) {
                            if (input.files && input.files[0]) {
                                let uploadedFile = new FileReader();
                                uploadedFile.onload = function(e) {
                                    thisElement.find('img').attr('src', e.target.result);
                                    thisElement.fadeIn(300);
                                    thisElement.find('h3').hide();
                                };
                                uploadedFile.readAsDataURL(input.files[0]);
                            }
                        }

                        $(this).on("change", function() {
                            proPicURL(this);
                        });
                    });
                }
            });
        }

        $(document).on('click', '.remove-color-image-for-product-gallery', function(event) {
            event.preventDefault();
            let value_id = $(this).data('color');
            let value = '#' + value_id;
            let color = "color_image_" + value_id;
            let html = `<div class="position-relative p-2 border-dashed-2">
                                <label style='border-radius: 3px; cursor: pointer; text-align: center; overflow: hidden; position : relative; display: flex; align-items: center; margin: auto; justify-content: center; flex-direction: column;'>
                                    <span class="upload--icon" style="background: ${value}">
                                    <i class="tio-edit"></i>
                                        <input type="file" name="` + color + `" id="` + value_id + `" class="d-none" accept=".jpg, .webp, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required="">
                                    </span>

                                    <div class="h-100 top-0 aspect-1 w-100 d-flex align-content-center justify-content-center overflow-hidden">
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/icons/product-upload-icon.svg') }}" class="w-75">
                                            <h3 class="text-muted">{{ translate('Upload_Image') }}</h3>
                                        </div>
                                    </div>
                                </label>
                            </div>`;
            $('.color-image-' + value_id).empty().append(html);
            $("#color-wise-image-area input[type='file']").each(function() {

                let thisElement = $(this).closest('label');

                function proPicURL(input) {
                    if (input.files && input.files[0]) {
                        let uploadedFile = new FileReader();
                        uploadedFile.onload = function(e) {
                            thisElement.find('img').attr('src', e.target.result);
                            thisElement.fadeIn(300);
                            thisElement.find('h3').hide();
                        };
                        uploadedFile.readAsDataURL(input.files[0]);
                    }
                }

                $(this).on("change", function() {
                    proPicURL(this);
                });
            });
        })
        $('.remove-addition-image-for-product-gallery').on('click', function() {
            $('#' + $(this).data('section-remove-id')).remove();
        })

        $(document).ready(function() {
            setTimeout(function() {
                let category = $("#category_id").val();
                let sub_category = $("#sub-category-select").attr("data-id");
                let sub_sub_category = $("#sub-sub-category-select").attr("data-id");
                getRequestFunctionality('{{ route('admin.products.get-categories') }}?parent_id=' +
                    category + '&sub_category=' + sub_category, 'sub-category-select', 'select');
                getRequestFunctionality('{{ route('admin.products.get-categories') }}?parent_id=' +
                    sub_category + '&sub_category=' + sub_sub_category, 'sub-sub-category-select',
                    'select');
            }, 100)
        });
        updateProductQuantity();
    </script>
    <script>
        const existingDynamicData = {!! $dynamicData !!};
        const existingDynamicDataTechnical = {!! $dynamicDataTechnical !!};
    </script>
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
            renderExistingDynamicData(existingDynamicDataTechnical, 'dynamic-data-box-technical', true);
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
@endpush
