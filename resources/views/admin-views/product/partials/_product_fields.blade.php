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
            <div class="step-circle">6</div>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">7</div>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">8</div>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">9</div>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">10</div>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">11</div>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">12</div>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">13</div>
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
                @if (auth('admin')->check())
                    <select class="js-select2-custom form-control action-get-request-onchange" name="category_id"
                        data-url-prefix="{{ route('admin.products.get-categories') . '?parent_id=' }}"
                        data-element-id="sub-category-select" data-element-type="select" required>
                    @else
                        <select class="js-select2-custom form-control action-get-request-onchange" name="category_id"
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
                        class="js-example-basic-multiple js-states js-example-responsive form-control action-get-request-onchange"
                        name="sub_category_id" id="sub-category-select"
                        data-id="{{ $isEdit ? $product['sub_category_id'] : '' }}"
                        data-url-prefix="{{ url('/admin/products/get-categories?parent_id=') }}"
                        data-element-id="sub-sub-category-select" data-element-type="select">
                    </select>
                @else
                    <select
                        class="js-example-basic-multiple js-states js-example-responsive form-control action-get-request-onchange"
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
                <label class="form-label">{{ translate('HT Code') }}</label>
                <input type="text" class="form-control" name="hts_code"
                    value="{{ $isEdit ? $product['hts_code'] : '' }}" placeholder="e.g., 8473301000">
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
                                                <span class="input-label-secondary cursor-pointer"
                                                    data-toggle="tooltip"
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
                                            .
                                        </p>

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
                                            {{ '2 MB' }}
                                        </p>
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
                                        {{ translate('colour_is_shown_in_the_image_section_top_right.') }}
                                    </p>

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
                                                    @php
                                                        $unique_id = rand(1111, 9999);
                                                    @endphp

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
                                                            @php
                                                                $unique_id = rand(1111, 9999);
                                                            @endphp
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
                                                                                {{ translate('Upload_Image') }}
                                                                            </h3>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @foreach ($product->images_full_url as $key => $photo)
                                                        @php
                                                            $unique_id = rand(1111, 9999);
                                                        @endphp
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
                                                                            {{ translate('Upload_Image') }}
                                                                        </h3>
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
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="title-color mb-0" for="minimum_order_qty">
                    {{ translate('minimum_order_qty') }}
                    <span class="input-required-icon">*</span>
                </label>

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
                        <option value="{{ $unit }}"
                            {{ $isEdit ? ($product['unit'] == $unit ? 'selected' : '') : '' }}>
                            {{ $unit }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">

                <label class="title-color mb-0" for="supply_capacity">
                    {{ translate('Supply Capacity') }}
                    <span class="input-required-icon">*</span>
                </label>

                <input type="number" min="1" value="1" step="1"
                    placeholder="{{ translate('supply_capacity') }}" name="supply_capacity" id="supply_capacity"
                    class="form-control" required value="{{ $isEdit ? $product['supply_capacity'] : '' }}">
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
                <label class="title-color mb-0">
                    {{ translate('unit_price') }}
                    ({{ getCurrencySymbol(currencyCode: getCurrencyCode()) }})
                    <span class="input-required-icon">*</span>
                </label>
                <input type="number" min="0" step="0.01" placeholder="{{ translate('unit_price') }}"
                    name="unit_price" value="{{ $isEdit ? $product['unit_price'] : 0 }}" class="form-control"
                    required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">

                <label class="title-color mb-0">
                    {{ translate('Local Currency') }}
                </label>
                <input type="text" placeholder="{{ translate('local_currency') }}" name="local_currency"
                    value="{{ $isEdit ? $product['local_currency'] : '' }}" class="form-control" required>
            </div>
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
        </div>
        <div class="form-row">
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
            <div class="form-group">
                <label class="form-label">{{ translate('Place of Loading') }}</label>
                <input type="text" class="form-control" name="place_of_loading"
                    value="{{ $isEdit ? $product['place_of_loading'] : '' }}" placeholder="e.g., Shanghai, Ningbo">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Port of Loading') }}</label>
                <select class="form-control" name="port_of_loading">
                    <option value="Factory"
                        {{ $isEdit ? ($product['port_of_loading'] == 'Factory' ? 'selected' : '') : '' }}>
                        Factory
                    </option>
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
            <div class="form-group">
                <label class="form-label">{{ translate('Production Lead Time') }}</label>
                <input type="text" class="form-control" name="lead_time"
                    value="{{ $isEdit ? $product['lead_time'] : '' }}" placeholder="e.g., 7-10 business days">
            </div>
        </div>
        <div class="form-row">
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
        </div>
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
                            {{ $isEdit && ($product['packing_type'] ?? null) === $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Size') }}</label>
                <input type="text" class="form-control" name="weight_per_unit"
                    value="{{ $isEdit ? $product['weight_per_unit'] ?? '' : '' }}" placeholder="e.g., 1.5kg">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Internal Packing') }}</label>
                <input type="text" class="form-control" name="dimensions_per_unit"
                    value="{{ $isEdit ? $product['dimensions_per_unit'] ?? '' : '' }}"
                    placeholder="e.g., 10x5x2 cm">
            </div>
            <div class="form-group">
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
                <label class="title-color">
                    {{ translate('brand') }}
                    <span class="input-required-icon">*</span>
                </label>
                <select class="js-select2-custom form-control" name="brand_id" required>
                    <option value="" selected disabled>{{ translate('select_Brand') }}</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand['id'] }}"
                            {{ $isEdit && $brand['id'] == ($product['brand_id'] ?? null) ? 'selected' : '' }}>
                            {{ $brand['defaultName'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="button" class="next-btn" data-next="2">Next</button>
    </div>
    <div class="step-section" data-step="2">
        <div class="form-row">
            <div class="form-group">
                <label class="title-color" for="description">{{ translate('Short Description') }}
                </label>
                <textarea name="short_details" class="summernote">{!! $isEdit ? $product['short_details'] ?? '' : '' !!}</textarea>
            </div>
            <div class="form-group">
                <label class="title-color" for="description">{{ translate('Description') }}
                </label>
                <textarea name="description" class="summernote">{!! $isEdit ? $product['details'] ?? '' : '' !!}</textarea>
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
        <button type="button" class="prev-btn" data-prev="1">Prev</button>
        <button type="button" class="next-btn" data-next="3">Next</button>
    </div>
    <div class="step-section" data-step="3">
        <div class="form-row">
            <div class="form-group">
                <label class="title-color">
                    {{ translate('product_type') }}
                    <span class="input-required-icon">*</span>
                </label>
                <select name="product_type" id="product_type" class="form-control" required>
                    <option value="physical"
                        {{ $isEdit && ($product['product_type'] ?? '') === 'physical' ? 'selected' : '' }}>
                        {{ translate('physical') }}
                    </option>

                    @if ($digitalProductSetting)
                        <option value="digital"
                            {{ $isEdit && ($product['product_type'] ?? '') === 'digital' ? 'selected' : '' }}>
                            {{ translate('digital') }}
                        </option>
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label class="title-color">
                    {{ translate('Author') }}/{{ translate('Creator') }}/{{ translate('Artist') }}
                </label>
                <select class="multiple-select2 form-control" name="authors[]" multiple="multiple" id="mySelect">
                    @foreach ($digitalProductAuthors as $authors)
                        <option value="{{ $authors['name'] }}"
                            {{ in_array($authors['id'], $productAuthorIds) ? 'selected' : '' }}>
                            {{ $authors['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="title-color">{{ translate('Publishing_House') }}</label>
                <select class="multiple-select2 form-control" name="publishing_house[]" multiple="multiple">
                    @foreach ($publishingHouseList as $publishingHouse)
                        <option value="{{ $publishingHouse['name'] }}"
                            {{ in_array($publishingHouse['id'], $productPublishingHouseIds) ? 'selected' : '' }}>
                            {{ $publishingHouse['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="digital_product_type" class="title-color">{{ translate('delivery_type') }}</label>
                <select name="digital_product_type" id="digital_product_type" class="form-control" required>
                    <option value=""
                        {{ !$isEdit || empty($product['digital_product_type']) ? 'selected' : '' }} disabled>
                        ---{{ translate('select') }}---
                    </option>
                    <option value="ready_after_sell"
                        {{ $isEdit && ($product['digital_product_type'] ?? '') === 'ready_after_sell' ? 'selected' : '' }}>
                        {{ translate('ready_After_Sell') }}
                    </option>
                    <option value="ready_product"
                        {{ $isEdit && ($product['digital_product_type'] ?? '') === 'ready_product' ? 'selected' : '' }}>
                        {{ translate('ready_Product') }}
                    </option>
                </select>
            </div>
        </div>
        <div class="form-row">
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
                    value="{{ request('product-gallery') ? '' : ($isEdit ? $product->code : '') }}"
                    placeholder="{{ translate('4FOITO') }}" required>
            </div>
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
                <input type="text" class="form-control" placeholder="{{ translate('Enter Badge') }}"
                    name="badge" data-role="badgeinput" value="{{ $isEdit ? $product->badge : '' }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-single">
                <label class="title-color d-flex align-items-center gap-2">
                    {{ translate('search_tags') }}
                    <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                        title="{{ translate('add_the_product_search_tag_for_this_product_that_customers_can_use_to_search_quickly') }}">
                        <img width="16"
                            src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                            alt="">
                    </span>
                </label><input type="text" class="form-control" name="tags"
                    value="{{ $isEdit ? collect($product['tags'])->pluck('tag')->implode(',') : '' }}"
                    data-role="tagsinput">
            </div>
        </div>
        <button type="button" class="prev-btn" data-prev="2">Prev</button>
        <button type="button" class="next-btn" data-next="4">Next</button>
    </div>
    <div class="step-section" data-step="4">
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Customization') }}</label>
                <input type="text" class="form-control" name="customization"
                    placeholder="e.g., Logo, Color, Packaging" value="{{ $product->customization ?? '' }}">
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Style') }}</label>
                <input type="text" class="form-control" name="style"
                    placeholder="e.g., Modern, Classic, Industrial" value="{{ $product->style ?? '' }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Usage') }}</label>
                <input type="text" class="form-control" name="usage" value="{{ $product->usage ?? '' }}"
                    placeholder="e.g., Indoor/Outdoor Use">
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Sample Price') }}</label>
                <input type="text" class="form-control" name="sample_price" placeholder="e.g., $20"
                    value="{{ $product->sample_price ?? '' }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Sample Amount') }}</label>
                <input type="text" class="form-control" name="sample_amount" placeholder="e.g., 2 units"
                    value="{{ $product->sample_amount ?? '' }}">
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Model Number') }}</label>
                <input type="text" class="form-control" name="model_number" placeholder="e.g., ABC123"
                    value="{{ $product->model_number ?? '' }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-single">
                <label class="form-label">{{ translate('Small Orders Accepted') }}</label>
                <select class="form-control" name="small_orders">
                    <option value="1" {{ $isEdit && $product->small_orders == 1 ? 'selected' : '' }}>
                        {{ translate('Yes') }}
                    </option>
                    <option value="0" {{ $isEdit && $product->small_orders == 0 ? 'selected' : '' }}>
                        {{ translate('No') }}
                    </option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-single">
                <label class="form-label">{{ translate('FAQ') }}</label>
                <textarea class="summernote" name="faq" rows="3" placeholder="Write common questions and answers..."> {{ $product->faq ?? '' }}</textarea>
            </div>
        </div>
        <div class="form-row">
            <div class="form-single">
                <label class="form-label">{{ translate('Why Choose Us?') }}</label>
                <textarea class="summernote" name="why_choose_us" rows="3"
                    placeholder="e.g., Trusted supplier, 10+ years experience">{{ $product->why_choose_us ?? '' }}</textarea>
            </div>
        </div>
        <button type="button" class="prev-btn" data-prev="3">Prev</button>
        <button type="button" class="next-btn" data-next="5">Next</button>
    </div>
    <div class="step-section" data-step="5">
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Export Carton Dimensions (L x W x H)') }}</label>
                <input type="text" class="form-control" name="export_carton_dimensions"
                    placeholder="e.g., 60x40x30 cm" value="{{ $product->export_carton_dimensions ?? '' }}">
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Logistics Attributes') }}</label>
                <input type="text" class="form-control" name="logistics_attributes"
                    placeholder="e.g., Stackable, Fragile" value="{{ $product->logistics_attributes ?? '' }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Units per Export Carton') }}</label>
                <input type="text" class="form-control" name="units_per_carton" placeholder="e.g., 50"
                    value="{{ $product->units_per_carton ?? '' }}">
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Export Carton Weight') }}</label>
                <input type="text" class="form-control" name="carton_weight" placeholder="e.g., 75kg"
                    value="{{ $product->carton_weight ?? '' }}">
            </div>
        </div>
        <button type="button" class="prev-btn" data-prev="4">Prev</button>
        <button type="button" class="next-btn" data-next="6">Next</button>
    </div>
    <div class="step-section" data-step="6">
        <div class="form-row">
            <div class="form-single">
                <label class="form-label">{{ translate('Regions') }}</label>
                <textarea type="text" class="summernote" name="export_markets"
                    placeholder="e.g., North America, Europe, Southeast Asia">{{ $product->export_markets ?? '' }}</textarea>
            </div>
        </div>
        <button type="button" class="prev-btn" data-prev="5">Prev</button>
        <button type="button" class="next-btn" data-next="7">Next</button>
    </div>
    <div class="step-section" data-step="7">
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Accepted Payment Methods') }}</label>
                <input type="text" class="form-control" name="payment_methods"
                    placeholder="e.g., Bank Transfer (T/T), PayPal, L/C, Western Union"
                    value="{{ $product->payment_methods ?? '' }}">
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Currency Accepted') }}</label>
                <input type="text" class="form-control" name="currency_accepted"
                    value="{{ $product->currency_accepted ?? '' }}" placeholder="e.g., USD, EUR, GBP">
            </div>
        </div>
        <div class="form-row">
            <div class="form-single">
                <label class="form-label">{{ translate('Invoicing Info') }}</label>
                <input type="text" class="form-control" name="invoicing"
                    value="{{ $product->invoicing ?? '' }}"
                    placeholder="e.g., Issued with shipment, PDF format via email">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Refund Policy') }}</label>
                <textarea class="summernote" name="refund_policy" rows="3" placeholder="State refund conditions, if any...">{{ $product->refund_policy ?? '' }}</textarea>
            </div>
        </div>
        <button type="button" class="prev-btn" data-prev="6">Prev</button>
        <button type="button" class="next-btn" data-next="8">Next</button>
    </div>
    <div class="step-section" data-step="8">
        <div class="form-row">
            <div class="form-group">
                <label class="title-color mb-0">{{ translate('purchase_price') }}
                    ({{ getCurrencySymbol(currencyCode: getCurrencyCode()) }})
                </label>
                <input type="number" min="0" step="0.01"
                    placeholder="{{ translate('purchase_price') }}" name="purchase_price" class="form-control"
                    value={{ usdToDefaultCurrency($product['purchase_price'] ?? 0) }} required>
            </div>
            <div class="form-group">
                <label class="title-color mb-0" for="current_stock">
                    {{ translate('current_stock_qty') }}
                    <span class="input-required-icon">*</span>
                </label>

                <input type="number" min="0" value={{ $product['current_stock'] ?? '' }} step="1"
                    placeholder="{{ translate('quantity') }}" name="current_stock" id="current_stock"
                    class="form-control" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="title-color mb-0" for="discount_type">{{ translate('discount_Type') }}</label>
                <select class="form-control" name="discount_type" id="discount_type">
                    <option value="flat" {{ $isEdit && $product->discount_type == 'flat' ? 'selected' : '' }}>
                        {{ translate('flat') }}
                    </option>
                    <option value="percent" {{ $isEdit && $product->discount_type == 'percent' ? 'selected' : '' }}>
                        {{ translate('percent') }}
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label class="title-color" for="discount">
                    {{ translate('discount_amount') }}
                    <span
                        class="discount_amount_symbol">({{ getCurrencySymbol(currencyCode: getCurrencyCode()) }})</span>
                </label>
                <input type="number" min="0"
                    value="{{ $isEdit ? ($product->discount_type == 'flat' ? usdToDefaultCurrency($product->discount) : $product->discount) : 0 }}"
                    step="0.01" placeholder="{{ translate('ex: 5') }}" name="discount" id="discount"
                    class="form-control" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="title-color" for="tax_model">
                    {{ translate('tax_calculation') }} <span class="input-required-icon">*</span>
                </label>
                <select name="tax_model" id="tax_model" class="form-control" required>
                    <option value="include" {{ $isEdit && $product->tax_model == 'include' ? 'selected' : '' }}>
                        {{ translate('include_with_product') }}
                    </option>
                    <option value="exclude" {{ $isEdit && $product->tax_model == 'exclude' ? 'selected' : '' }}>
                        {{ translate('exclude_with_product') }}
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label class="title-color" for="tax">
                    {{ translate('Tax') }} (%) <span class="input-required-icon">*</span>
                </label>
                <input type="number" min="0" step="0.01" placeholder="{{ translate('ex: 5') }}"
                    name="tax" id="tax" value="{{ $isEdit ? $product->tax : 0 }}" class="form-control">
                <input name="tax_type" value="percent" class="d-none">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="title-color">
                    {{ translate('shipping_cost') }}
                    ({{ getCurrencySymbol(currencyCode: getCurrencyCode()) }})
                    <span class="input-required-icon">*</span>
                </label>
                <input type="number" min="0" step="1"
                    value="{{ $isEdit ? usdToDefaultCurrency($product->shipping_cost) : 0 }}"
                    placeholder="{{ translate('shipping_cost') }}" name="shipping_cost" class="form-control"
                    required>
            </div>
            <div class="form-group">
                <label class="title-color text-capitalize"
                    for="shipping_cost">{{ translate('shipping_cost_multiply_with_quantity') }}</label>
                <div>
                    <label class="switcher">
                        <input class="switcher_input" type="checkbox" name="multiply_qty"
                            {{ $isEdit && $product->multiply_qty == 1 ? 'checked' : '' }}>
                        <span class="switcher_control"></span>
                    </label>
                </div>
            </div>
        </div>
        <button type="button" class="prev-btn" data-prev="7">Prev</button>
        <button type="button" class="next-btn" data-next="9">Next</button>
    </div>
    <div class="step-section" data-step="9">
        <div class="form-row">
            <div class="form-group">
                <div class="mb-3 d-flex align-items-center gap-2" style="flex-direction: column;/*! width: auto; */">
                    <label for="colors" class="title-color mb-0">
                        {{ translate('select_colors') }} :
                    </label>
                    <label class="switcher">
                        <input type="checkbox" class="switcher_input" id="product-color-switcher"
                            value="{{ old('colors_active') }}" name="colors_active">
                        <span class="switcher_control"></span>
                    </label>
                </div>
                <select class="js-example-basic-multiple js-states js-example-responsive form-control color-var-select"
                    name="colors[]" multiple="multiple" id="colors-selector" disabled>
                    @foreach ($colors as $key => $color)
                        <option value="{{ $color->code }}">
                            {{ $color['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
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
        </div>
        <div class="row customer_choice_options mt-2" id="customer_choice_options"></div>
        <div class="form-group sku_combination" id="sku_combination"></div>
        <button type="button" class="prev-btn" data-prev="8">Prev</button>
        <button type="button" class="next-btn" data-next="10">Next</button>
    </div>
    <div class="step-section" data-step="10">
        <div class="form-row">
            <div class="form-single">
                <div class="col-sm-6 col-md-4 col-xxl-12">
                    <div class="multi--select">
                        <label class="title-color">{{ translate('File_Type') }}</label>
                        <select class="js-example-basic-multiple js-select2-custom form-control" name="file-type"
                            multiple id="digital-product-type-select">
                            @foreach ($digitalProductFileTypes as $FileType)
                                @if (isset($product) && $product->digital_product_file_types)
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

                @if (isset($product) && $product->digital_product_file_types && count($product->digital_product_file_types) > 0)
                    @foreach ($product->digital_product_file_types as $digitalProductFileTypes)
                        <div class="col-sm-6 col-md-4 col-xxl-3 extension-choice-section">
                            <div class="form-group">
                                <input type="hidden" name="extensions_type[]"
                                    value="{{ $digitalProductFileTypes }}">
                                <label class="title-color">
                                    {{ $digitalProductFileTypes }}
                                </label>
                                <input type="text" name="extensions[]" value="{{ $digitalProductFileTypes }}"
                                    hidden>
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
        <button type="button" class="prev-btn" data-prev="9">Prev</button>
        <button type="button" class="next-btn" data-next="11">Next</button>
    </div>
    <div class="step-section" data-step="11">
        <div class="form-row">
            <div class="form-single">
                <label class="mb-0 title-color">
                    {{ translate('select_colors') }} :
                </label>
                <label class="switcher">
                    <input type="checkbox" class="switcher_input" id="product-color-switcher"
                        name="colors_active"
                        {{ isset($product['colors']) && count($product['colors']) > 0 ? 'checked' : '' }}>
                    <span class="switcher_control"></span>
                </label>

                <select
                    class="js-example-basic-multiple js-states js-example-responsive form-control color-var-select"
                    name="colors[]" multiple="multiple" id="colors-selector"
                    {{ isset($product['colors']) && count($product['colors']) > 0 ? '' : 'disabled' }}>
                    @foreach ($colors as $key => $color)
                        <option value="{{ $color->code }}"
                            {{ isset($product['colors']) && in_array($color->code, $product['colors']) ? 'selected' : '' }}>
                            {{ $color['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-single">
                <label for="choice_attributes" class="pb-1 title-color">
                    {{ translate('select_attributes') }} :
                </label>
                <select class="js-example-basic-multiple js-states js-example-responsive form-control"
                    name="choice_attributes[]" id="choice_attributes" multiple="multiple">
                    @foreach ($attributes as $key => $attribute)
                        @php
                            $selectedAttributes =
                                !empty($product['attributes']) && $product['attributes'] != 'null'
                                    ? json_decode($product['attributes'], true)
                                    : [];
                        @endphp
                        <option value="{{ $attribute['id'] }}"
                            {{ in_array($attribute->id, $selectedAttributes) ? 'selected' : '' }}>
                            {{ $attribute['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        @if ($isEdit)
            <div class="form-row">
                <div class="form-single">
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
        @endif
        <div class="form-row">
            <div class="form-single">
                <div class="mb-3" style="display: flex;flex-direction: column;/*! flex: unset; */">
                    <label class="title-color mb-0"
                        style="width:100%;">{{ translate('youtube_video_link') }}</label>
                    <span class="text-info"> (
                        {{ translate('optional_please_provide_embed_link_not_direct_link') }}.
                        )</span>
                </div>
                <input type="text" value="{{ $product['video_url'] ?? '' }}" name="video_url"
                    placeholder="{{ translate('ex') }} : https://www.youtube.com/embed/5R06LRdUCSE"
                    class="form-control" required>
            </div>
        </div>
        <button type="button" class="prev-btn" data-prev="10">Prev</button>
        <button type="button" class="next-btn" data-next="12">Next</button>
    </div>
    <div class="step-section" data-step="12">
        <div class="form-row">
            <div class="form-group">
                <label class="title-color">
                    {{ translate('meta_Title') }}
                    <span class="input-label-secondary cursor-pointer" data-toggle="tooltip" data-placement="top"
                        title="{{ translate('add_the_products_title_name_taglines_etc_here') . ' ' . translate('this_title_will_be_seen_on_Search_Engine_Results_Pages_and_while_sharing_the_products_link_on_social_platforms') . ' [ ' . translate('character_Limit') }} : 100 ]">
                        <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                            alt="">
                    </span>
                </label>
                <input type="text" name="meta_title"
                    value="{{ $product->seoInfo->title ?? ($product->meta_title ?? '') }}" placeholder=""
                    class="form-control">
            </div>
            <div class="form-group">
                <label class="title-color">
                    {{ translate('meta_Description') }}
                    <span class="input-label-secondary cursor-pointer" data-toggle="tooltip" data-placement="top"
                        title="{{ translate('write_a_short_description_of_this_shop_product') . ' ' . translate('this_description_will_be_seen_on_Search_Engine_Results_Pages_and_while_sharing_the_products_link_on_social_platforms') . ' [ ' . translate('character_Limit') }} : 100 ]">
                        <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}"
                            alt="">
                    </span>
                </label>
                <textarea rows="1" type="text" name="meta_description" class="form-control">{{ $product->seoInfo->description ?? ($product->meta_description ?? '') }}</textarea>
            </div>
        </div>

        <div class="form-row">
            <div class="form-single">
                <label class="title-color" for="meta_Image">
                    {{ translate('meta_Image') }}
                </label>

                <div>
                    <div class="custom_upload_input">
                        <input type="file" name="meta_image"
                            class="custom-upload-input-file meta-img action-upload-color-image"
                            data-imgpreview="pre_meta_image_viewer"
                            accept=".jpg, .webp, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">

                        @php
                            $metaImagePath =
                                $product->seoInfo->image_full_url['path'] ??
                                ($product->meta_image_full_url['path'] ?? null);
                        @endphp

                        <span
                            class="delete_file_input btn btn-outline-danger btn-sm square-btn d-{{ $metaImagePath ? 'flex' : 'none' }}">
                            <i class="tio-delete"></i>
                        </span>

                        <div class="img_area_with_preview position-absolute z-index-2 d-flex">
                            <img id="pre_meta_image_viewer" class="h-auto aspect-1 bg-white" alt=""
                                src="{{ $metaImagePath ? getStorageImages(path: $product->seoInfo->image_full_url ?? $product->meta_image_full_url, type: 'backend-banner') : '' }}">
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

                @if (auth('admin')->check())
                    @if ($isEdit)
                        @include('admin-views.product.partials._seo-update-section')
                    @else
                        @include('admin-views.product.partials._seo-section')
                    @endif
                @else
                    @if ($isEdit)
                        @include('vendor-views.product.partials._seo-update-section')
                    @else
                        @include('vendor-views.product.partials._seo-section')
                    @endif
                @endif
            </div>
        </div>
        @if ($isEdit)
            <div class="form-row">
                <div class="form-single">
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
                </div>
            </div>
        @endif
        <button type="button" class="prev-btn" data-prev="11">Prev</button>
        <button type="submit" class="next-btn">Submit</button>
    </div>
</div>
