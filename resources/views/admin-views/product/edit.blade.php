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
            action="{{ request('product-gallery') == 1 ? route('products_new.store') : route('products.update', $product->id) }}"
            method="post" enctype="multipart/form-data" id="product_form">
            @csrf
            <div class="card">
                <div class="card-body">
                    @include('admin-views.product.partials._product_fields')
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
