@extends('layouts.back-end.app-partialseller')

@section('title', translate('product_Add'))

@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ theme_asset('public/assets/custom-css/progress-form.css') }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
            <h2 class="h1 mb-0 d-flex gap-2">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
                {{ translate('add_New_Product') }}
            </h2>
        </div>

        <form class="product-form text-start" action="{{ route('products_new.store') }}" method="POST"
            enctype="multipart/form-data" id="product_form_new">
            @csrf
            
            <div class="card">
                <div class="card-body">
                    @include('admin-views.product.partials._product_fields_new')
                </div>
            </div>
        </form>
    </div>

    <span id="route-vendor-products-sku-combination" data-url="{{ route('vendor.products.sku-combination') }}"></span>
    <span id="route-vendor-products-digital-variation-combination"
        data-url="{{ route('vendor.products.digital-variation-combination') }}"></span>
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
    <script src="{{ theme_asset('public/js/progress-form.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/tags-input.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/vendor/product-add-update.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/vendor/product-add-colors-img.js') }}"></script>
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

        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('dynamic-data-box');
            if (container && container.children.length === 0) {
                container.insertAdjacentHTML('beforeend', getTitleGroupHtmlTechnical(titleCountTechnical));
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

        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('dynamic-data-box-technical');
            if (container && container.children.length === 0) {
                container.insertAdjacentHTML('beforeend', getTitleGroupHtmlTechnical(titleCountTechnical));
                titleCountTechnical++;
            }
        });

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
