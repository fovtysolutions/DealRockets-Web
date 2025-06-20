@extends('layouts.back-end.app-partial')

@section('title', translate(request('product-gallery') == 1 ? 'product_Add' : 'product_Edit'))

@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ theme_asset('public/assets/custom-css/progress-form.css') }}">
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
            action="{{ request('product-gallery') == 1 ? route('products_new.store') : route('products_new.update', $product->id) }}"
            method="post" enctype="multipart/form-data" id="product_form">
            @csrf
            @if(request('product-gallery') != 1)
                @method('PUT')
            @endif
            <div class="card">
                <div class="card-body">
                    @include('admin-views.product.partials._product_fields_new')
                </div>
            </div>
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
    <script src="{{ theme_asset('public/js/progress-form.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/tags-input.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/product-add-update.js') }}"></script>

    <script>
        "use strict";

        setTimeout(function() {
            $('.call-update-sku').on('change', function() {
                getUpdateSKUFunctionality();
            });
        }, 2000)

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
                <button type="button" class="btn btn-danger remove-title-group">Remove</button>
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
                <div class="row mb-2 sub-head-row" style="width: 100%; display: flex; margin: 0 auto; gap: 13px;">
                    <div style="width: 44%;">
                        <input type="text" name="dynamic_data_technical[${titleIndex}][sub_heads][${subIndex}][sub_head]" class="form-control" placeholder="Sub Head">
                    </div>
                    <div style="width: 45%;">
                        <input type="text" name="dynamic_data_technical[${titleIndex}][sub_heads][${subIndex}][sub_head_data]" class="form-control" placeholder="Sub Head Data">
                    </div>
                    <div style="width: 8%;">
                        <button type="button" class="btn btn-danger remove-sub-head">Remove</button>
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
