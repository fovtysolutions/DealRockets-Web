@extends('layouts.back-end.app-partial')

@section('title', translate('Edit_Leads'))

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
                {{ translate('Update_Leads') }}
            </h2>
        </div>

        <form class="product-form text-start" action="{{ route('admin.leads.update', $leads->id) }}" method="POST"
            enctype="multipart/form-data" id="leadsForm">
            @csrf
            @include('admin-views.leads.partials._leads_fields')
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
    <span id="message-want-to-add-or-update-this-product"
        data-text="{{ translate('want_to_add_this_product') }}"></span>
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
        // Remove existing image and exclude it from submission
        document.querySelectorAll('.remove-existing').forEach(btn => {
            btn.addEventListener('click', function () {
                const wrapper = this.closest('.image-wrapper');
                wrapper.remove(); // Removes the image and its hidden input
            });
        });
    
        // Preview and allow removing new images
        document.getElementById('images').addEventListener('change', function () {
            const previewContainer = document.getElementById('preview-images');
            previewContainer.innerHTML = ''; // Clear previews
    
            Array.from(this.files).forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const preview = document.createElement('div');
                        preview.classList.add('position-relative');
                        preview.style.width = '100px';
                        preview.innerHTML = `
                            <img src="${e.target.result}" class="img-thumbnail" style="width: 100px; height: auto;">
                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-new">&times;</button>
                        `;
                        previewContainer.appendChild(preview);
    
                        preview.querySelector('.remove-new').addEventListener('click', function () {
                            preview.remove(); // Only removes preview, file still in input (limitation)
                            // To truly remove file from input, JS FileList manipulation or plugin needed
                        });
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>    
@endpush
