@extends('layouts.back-end.app')

@section('title', translate('Edit_Quotation'))

@push('css_or_js')
    <link href="{{ dynamicAsset('public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset('public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset('public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="content container-fluid">
    <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
        <h2 class="h1 mb-0 d-flex gap-2">
            <img src="{{ dynamicAsset('public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
            {{ translate('Update_quotation') }}
        </h2>
    </div>

    <form class="product-form text-start" action="{{ route('admin.quotation.update', $quotation->id) }}" method="POST"
        enctype="multipart/form-data" id="quotationForm">
        @csrf

        <div class="card">
            <div class="px-4 pt-3 d-flex justify-content-between">
                <ul class="nav nav-tabs w-fit-content mb-4">
                    @foreach ($languages as $lang)
                        <li class="nav-item">
                            <span
                                class="nav-link text-capitalize form-system-language-tab {{ $lang == $defaultLanguage ? 'active' : '' }} cursor-pointer"
                                id="{{ $lang }}-link">
                                {{ getLanguageName($lang) . '(' . strtoupper($lang) . ')' }}
                            </span>
                        </li>
                    @endforeach
                </ul>
                <!-- <a class="btn btn--primary btn-sm text-capitalize h-100"
                    href="{{ route('admin.products.product-gallery') }}">
                    {{ translate('add_info_from_gallery') }}
                </a> -->
            </div>

            <div class="card-body">
                @foreach ($languages as $lang)
                    <div class="{{ $lang != $defaultLanguage ? 'd-none' : '' }} form-system-language-form"
                        id="{{ $lang }}-form">
                        <!-- quotation Name -->
                        <div class="form-group">
                            <label class="title-color" for="{{ $lang }}_name">{{ translate('quotation_name') }}
                                ({{ strtoupper($lang) }})
                                @if($lang == $defaultLanguage)
                                    <span class="input-required-icon">*</span>
                                @endif
                            </label>
                            <input type="text" {{ $lang == $defaultLanguage ? 'required' : '' }} name="name"
                                id="{{ $lang }}_name"
                                class="form-control {{ $lang == $defaultLanguage ? 'product-title-default-language' : '' }}"
                                placeholder="{{ translate('new_quotation') }}" value="{{ old('name', $quotation->name) }}">
                        </div>
                        <input type="hidden" name="lang[]" value="{{ $lang }}">

                        <!-- Main Products -->
                        <div class="form-group">
                            <label class="title-color" for="{{ $lang }}_quantity">{{ translate('quantity') }}</label>
                            <input type="text" name="quantity" id="{{ $lang }}_quantity" class="form-control"
                                placeholder="{{ translate('enter_quantity') }}"
                                value="{{ old('quantity', $quotation->quantity) }}">
                        </div>

                        <!-- Management Certification -->
                        <div class="form-group">
                            <label class="title-color" for="{{ $lang }}_description">{{ translate('description') }}</label>
                            <input type="text" name="description" id="{{ $lang }}_description" class="form-control"
                                placeholder="{{ translate('enter_description') }}"
                                value="{{ old('description', $quotation->description) }}">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="row justify-content-end gap-3 mt-3 mx-1">
            <button type="reset" class="btn btn-secondary px-5">{{ translate('reset') }}</button>
            <button type="submit" class="btn btn--primary px-5">
                {{ translate('update') }}
            </button>
        </div>
    </form>
</div>

<!-- Other data spans -->
<span id="route-admin-products-sku-combination" data-url="{{ route('admin.products.sku-combination') }}"></span>
<span id="route-admin-products-digital-variation-combination"
    data-url="{{ route('admin.products.digital-variation-combination') }}"></span>
<span id="image-path-of-product-upload-icon"
    data-path="{{ dynamicAsset('public/assets/back-end/img/icons/product-upload-icon.svg') }}"></span>
<span id="image-path-of-product-upload-icon-two"
    data-path="{{ dynamicAsset('public/assets/back-end/img/400x400/img2.jpg') }}"></span>
<span id="message-enter-choice-values" data-text="{{ translate('enter_choice_values') }}"></span>
<span id="message-upload-image" data-text="{{ translate('upload_Image') }}"></span>
<span id="message-file-size-too-big" data-text="{{ translate('file_size_too_big') }}"></span>
<span id="message-are-you-sure" data-text="{{ translate('are_you_sure') }}"></span>
<span id="message-yes-word" data-text="{{ translate('yes') }}"></span>
<span id="message-no-word" data-text="{{ translate('no') }}"></span>
<span id="message-want-to-add-or-update-this-product" data-text="{{ translate('want_to_add_this_product') }}"></span>
<span id="message-please-only-input-png-or-jpg"
    data-text="{{ translate('please_only_input_png_or_jpg_type_file') }}"></span>
<span id="message-product-added-successfully" data-text="{{ translate('product_added_successfully') }}"></span>
<span id="message-discount-will-not-larger-then-variant-price"
    data-text="{{ translate('the_discount_price_will_not_larger_then_Variant_Price') }}"></span>
<span id="system-currency-code" data-value="{{ getCurrencySymbol(getCurrencyCode()) }}"></span>
<span id="system-session-direction" data-value="{{ Session::get('direction') }}"></span>
@endsection

@push('script')
    <script src="{{ dynamicAsset('public/assets/back-end/js/tags-input.min.js') }}"></script>
    <script src="{{ dynamicAsset('public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{ dynamicAsset('public/assets/back-end/plugins/summernote/summernote.min.js') }}"></script>
    <script src="{{ dynamicAsset('public/assets/back-end/js/admin/product-add-update.js') }}"></script>
    <script src="{{ dynamicAsset('public/assets/back-end/js/admin/product-add-colors-img.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#quotationForm').on('submit', function (event) {
                event.preventDefault(); // Prevent the default form submission

                // Create a FormData object from the form
                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'), // Get the action URL from the form
                    method: 'POST', // Use the method specified in the form
                    data: formData, // Send the form data
                    processData: false, // Important! Don't process the data
                    contentType: false, // Important! Set content type to false
                    success: function (response) {
                        alert("quotation updated successfully!"); // Show a simple alert
                        $('#quotationForm')[0].reset();
                    },
                    error: function (xhr) {
                        // Handle errors (for example, show validation messages)
                        var errors = xhr.responseJSON.errors;
                        var errorMessages = '';
                        for (var key in errors) {
                            errorMessages += errors[key].join(', ') + '\n'; // Create a string of error messages
                        }
                        alert(errorMessages); // Show error messages
                    }
                });
            });
        });
    </script>
    <script>
        function previewImage(event, previewId) {
            const input = event.target;
            const preview = document.getElementById(previewId);

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block'; // Show the image preview
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush