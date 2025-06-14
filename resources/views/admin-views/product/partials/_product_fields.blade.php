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
    </div>
    <div class="form-header">
        <h1>{{ $isEdit ? 'Edit Product' : 'Create Product' }}</h1>
        <p>{{ $isEdit ? 'Update the details of your Product' : 'Fill in the required details to create Product' }}
        </p>
    </div>
    <div class="step-section" data-step="1">
        <h4> Basic Information </h4>
        <div class="form-row">
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
        <div class="form-row">
            <div class="form-group">
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
            <div class="form-group">
                <label class="form-label">{{ translate('HT Code') }}</label>
                <input type="text" class="form-control" name="hts_code" value="{{ $product['hts_code'] ?? '' }}"
                    placeholder="e.g., 8473301000">
            </div>
        </div>
        <div class="form-row">
            <div class="form-single">
                @if (!$isEdit)
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
                @else
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
                @endif
            </div>
        </div>
        <div class="form-row">
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
                            {{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
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
                    id="minimum_order_qty" class="form-control" value="{{ $product['minimum_order_qty'] ?? 0 }}"
                    required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="title-color">{{ translate('unit') }}</label>
                <select class="js-example-basic-multiple form-control" name="unit">
                    @foreach (units() as $unit)
                        <option value="{{ $unit }}" {{ $product['unit'] == $unit ? 'selected' : '' }}>
                            {{ $unit }}</option>
                    @endforeach
                </select>
            </div>
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
                    placeholder="{{ translate('supply_capacity') }}" name="supply_capacity" id="supply_capacity"
                    class="form-control" required value="{{ $product['supply_capacity'] }}">
            </div>
        </div>
        <div class="form-row">
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
                <input type="number" min="0" step="0.01" placeholder="{{ translate('unit_price') }}"
                    name="unit_price" value="{{ $product['unit_price'] }}"
                    value="{{ $product['unit_price'] ?? 0 }}" class="form-control" required>
            </div>
        </div>
        <div class="form-row">
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
                <input type="text" placeholder="{{ translate('local_currency') }}" name="local_currency"
                    value="{{ $product['local_currency'] }}" class="form-control" required>
            </div>
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
        <div class="form-row">
            <div class="form-group">
                <label class="title-color">{{ translate('Delivery Mode') }}</label>
                <select class="form-control" name="delivery_mode">
                    <option value="Air" {{ $product['delivery_mode'] == 'Air' ? 'selected' : '' }}>Air
                    </option>
                    <option value="Sea" {{ $product['delivery_mode'] == 'Sea' ? 'selected' : '' }}>Sea
                    </option>
                    <option value="Rail_Road" {{ $product['delivery_mode'] == 'Rail_Road' ? 'selected' : '' }}>
                        Rail Road</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Place of Loading') }}</label>
                <input type="text" class="form-control" name="place_of_loading"
                    value="{{ $product['place_of_loading'] }}" placeholder="e.g., Shanghai, Ningbo">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
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
            <div class="form-group">
                <label class="form-label">{{ translate('Production Lead Time') }}</label>
                <input type="text" class="form-control" name="lead_time" value="{{ $product['lead_time'] }}"
                    placeholder="e.g., 7-10 business days">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Lead Time Unit') }}</label>
                <select class="js-example-basic-multiple form-control" name="lead_time_unit">
                    <option value="days" {{ $product['lead_time_unit'] == 'days' ? 'selected' : '' }}>Days
                    </option>
                    <option value="months" {{ $product['lead_time_unit'] == 'month' ? 'selected' : '' }}>Month
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Payment Terms') }}</label>
                <select class="form-control" name="payment_terms">
                    <option value="">Select Payment Term</option>
                    <option value="L/C at Sight" {{ $product['payment_terms'] == 'L/C at Sight' ? 'selected' : '' }}>
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
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Packing Type') }}</label>
                <select class="form-control" name="packing_type">
                    <option value="">Select Packing Type</option>
                    <option value="PP Bag" {{ $product['packing_type'] == 'PP Bag' ? 'selected' : '' }}>PP Bag
                    </option>
                    <option value="Carton" {{ $product['packing_type'] == 'Carton' ? 'selected' : '' }}>Carton
                    </option>
                    <option value="Plastic Drum" {{ $product['packing_type'] == 'Plastic Drum' ? 'selected' : '' }}>
                        Plastic Drum</option>
                    <option value="Steel Drum" {{ $product['packing_type'] == 'Steel Drum' ? 'selected' : '' }}>
                        Steel
                        Drum</option>
                    <option value="Wooden Crate" {{ $product['packing_type'] == 'Wooden Crate' ? 'selected' : '' }}>
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
            <div class="form-group">
                <label class="form-label">{{ translate('Size') }}</label>
                <input type="text" class="form-control" name="weight_per_unit"
                    value="{{ $product['weight_per_unit'] }}" placeholder="e.g., 1.5kg">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Internal Packing') }}</label>
                <input type="text" class="form-control" name="dimensions_per_unit"
                    value="{{ $product['dimensions_per_unit'] }}" placeholder="e.g., 10x5x2 cm">
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Target Market') }}</label>
                <select class="js-example-basic-multiple form-control" name="target_market[]" multiple>
                    @foreach ($countries as $country)
                        <option value="{{ $country['id'] }}"
                            {{ in_array($country['id'], old('target_market', json_decode($product['target_market'], true) ?? [])) ? 'selected' : '' }}>
                            {{ $country['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-single">
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
        <button type="button" class="next-btn" data-next="2">Next</button>
    </div>
    <div class="step-section" date-step="2">
        <div class="form-row">
            <div class="form-group">
                <label class="title-color" for="description">{{ translate('Short Description') }}
                </label>
                <textarea name="short_details[]" class="summernote">{!! $product['short_details'] !!}</textarea>
            </div>
            <div class="form-group">
                <label class="title-color" for="description">{{ translate('Description') }}
                </label>
                <textarea name="description[]" class="summernote">{!! $product['details'] !!}</textarea>
            </div>
        </div>
        <div class="form-row">
            <div class="form-single">
                <label class="form-label">{{ translate('Standard Specification') }}</label>
                <div id="dynamic-data-box">
                    {{-- Title Groups Go Here --}}
                </div>
                <button type="button" class="btn btn-primary mt-2" id="add-title-group">Add Title</button>
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
            <div class="form-single">
                <label class="form-lable">Certificate</label>
                <input type="file" name="certificate" id="certificate"
                    accept=".jpg, .webp, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                @if (!empty($product->certificate))
                    <div>
                        <img src="/{{ $product->certificate }}" alt="Current Certificate"
                            style="max-width: 100%; height: auto; border: 1px solid #ddd; margin-top: 8px;">
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
