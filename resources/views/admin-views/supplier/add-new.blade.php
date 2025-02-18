@extends('layouts.back-end.app')

@section('title', translate('Add_Supplier'))

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
                {{ translate('add_New_Supplier') }}
            </h2>
        </div>

        <form class="product-form text-start" action="{{ route('admin.suppliers.store') }}" method="POST"
              enctype="multipart/form-data" id="supplierForm">
            @csrf            
            <div class="card">
                <div class="px-4 pt-3 d-flex justify-content-between">
                    <ul class="nav nav-tabs w-fit-content mb-4">
                        @foreach ($languages as $lang)
                            <li class="nav-item">
                                <span class="nav-link text-capitalize form-system-language-tab {{ $lang == $defaultLanguage ? 'active' : '' }} cursor-pointer" id="{{ $lang }}-link">{{ getLanguageName($lang) . '(' . strtoupper($lang) . ')' }}</span>
                            </li>
                        @endforeach
                    </ul>
                    {{-- <a class="btn btn--primary btn-sm text-capitalize h-100" href="{{route('admin.products.product-gallery') }}">
                        {{translate('add_info_from_gallery')}}
                    </a> --}}
                </div>

                <div class="card-body">
                    @foreach ($languages as $lang)
                        <div class="{{ $lang != $defaultLanguage ? 'd-none' : '' }} form-system-language-form" id="{{ $lang }}-form">
                            <!-- Supplier Name -->
                            <div class="form-group">
                                <label class="title-color" for="{{ $lang }}_name">{{ translate('supplier_name') }} ({{ strtoupper($lang) }})
                                    @if($lang == $defaultLanguage)
                                        <span class="input-required-icon">*</span>
                                    @endif
                                </label>
                                <input type="text" {{ $lang == $defaultLanguage ? 'required' : '' }} name="name" id="{{ $lang }}_name"
                                    class="form-control {{ $lang == $defaultLanguage ? 'product-title-default-language' : '' }}"
                                    placeholder="{{ translate('new_Supplier') }}">
                            </div>
                            <input type="hidden" name="lang[]" value="{{ $lang }}">

                            <!-- Business Type -->
                            <div class="form-group">
                                <label for="business_type" class="title-color">{{ translate('business_type') }}
                                    <span class="input-required-icon">*</span>
                                </label>
                                <select class="js-select2-custom form-control action-get-request-onchange" name="business_type"
                                        data-url-prefix="{{ url('/admin/products/get-categories?parent_id=') }}"
                                        data-element-id="sub-category-select" data-element-type="select" required>
                                    <option value="{{ old('business_type') }}" selected disabled>{{ translate('select_category') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category['id'] }}" {{ old('business_type') == $category['id'] ? 'selected' : '' }}>
                                            {{ $category['defaultName'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Main Products -->
                            <div class="form-group">
                                <label class="title-color" for="{{ $lang }}_main_products">{{ translate('main_products') }}</label>
                                <input type="text" name="main_products" id="{{ $lang }}_main_products" class="form-control"
                                    placeholder="{{ translate('enter_main_products') }}">
                            </div>

                            <!-- Management Certification -->
                            <div class="form-group">
                                <label class="title-color" for="{{ $lang }}_management_certification">{{ translate('management_certification') }}</label>
                                <input type="text" name="management_certification" id="{{ $lang }}_management_certification" class="form-control"
                                    placeholder="{{ translate('enter_management_certification') }}">
                            </div>

                            <!-- City/Province -->
                            <div class="form-group">
                                <label class="title-color" for="{{ $lang }}_city_province">{{ translate('city_province') }}
                                    <span class="input-required-icon">*</span>
                                </label>
                                <input type="text" {{ $lang == $defaultLanguage ? 'required' : '' }} name="city_province"
                                    id="{{ $lang }}_city_province" class="form-control" placeholder="{{ translate('enter_city_province') }}">
                            </div>

                            <!-- Image Uploads -->
                            <div class="form-group">
                                <label class="title-color" for="{{ $lang }}_image1">{{ translate('image_1') }}</label>
                                <input type="file" name="image1" id="{{ $lang }}_image1" class="form-control" accept="image/*">
                            </div>
                            <div class="form-group">
                                <label class="title-color" for="{{ $lang }}_image2">{{ translate('image_2') }}</label>
                                <input type="file" name="image2" id="{{ $lang }}_image2" class="form-control" accept="image/*">
                            </div>
                            <div class="form-group">
                                <label class="title-color" for="{{ $lang }}_image3">{{ translate('image_3') }}</label>
                                <input type="file" name="image3" id="{{ $lang }}_image3" class="form-control" accept="image/*">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="row justify-content-end gap-3 mt-3 mx-1">
                <button type="reset" class="btn btn-secondary px-5">{{ translate('reset') }}</button>
                <button type="submit" class="btn btn--primary px-5" form="supplierForm">
                    {{ translate('submit') }}
                </button>
            </div>
        </form>
    </div>

    <span id="route-admin-products-sku-combination" data-url="{{ route('admin.products.sku-combination') }}"></span>
    <span id="route-admin-products-digital-variation-combination" data-url="{{ route('admin.products.digital-variation-combination') }}"></span>
    <span id="image-path-of-product-upload-icon" data-path="{{ dynamicAsset(path: 'public/assets/back-end/img/icons/product-upload-icon.svg') }}"></span>
    <span id="image-path-of-product-upload-icon-two" data-path="{{ dynamicAsset(path: 'public/assets/back-end/img/400x400/img2.jpg') }}"></span>
    <span id="message-enter-choice-values" data-text="{{ translate('enter_choice_values') }}"></span>
    <span id="message-upload-image" data-text="{{ translate('upload_Image') }}"></span>
    <span id="message-file-size-too-big" data-text="{{ translate('file_size_too_big') }}"></span>
    <span id="message-are-you-sure" data-text="{{ translate('are_you_sure') }}"></span>
    <span id="message-yes-word" data-text="{{ translate('yes') }}"></span>
    <span id="message-no-word" data-text="{{ translate('no') }}"></span>
    <span id="message-want-to-add-or-update-this-product" data-text="{{ translate('want_to_add_this_product') }}"></span>
    <span id="message-please-only-input-png-or-jpg" data-text="{{ translate('please_only_input_png_or_jpg_type_file') }}"></span>
    <span id="message-product-added-successfully" data-text="{{ translate('product_added_successfully') }}"></span>
    <span id="message-discount-will-not-larger-then-variant-price" data-text="{{ translate('the_discount_price_will_not_larger_then_Variant_Price') }}"></span>
    <span id="system-currency-code" data-value="{{ getCurrencySymbol(currencyCode: getCurrencyCode()) }}"></span>
    <span id="system-session-direction" data-value="{{ Session::get('direction') }}"></span>
@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/tags-input.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/product-add-update.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/product-add-colors-img.js') }}"></script>
@endpush
