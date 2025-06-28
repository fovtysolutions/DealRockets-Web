@extends('layouts.back-end.app-partialseller')

@section('title', translate('Stock_Create'))

@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ theme_asset('public/assets/custom-css/progress-form.css') }}">
@endpush

@section('content')
    <div class="container mt-5">
        <form action="{{ route('vendor.stock.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    @include('vendor-views.stocksell.partials.stocksell_fields')
                </div>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize the Spartan Multi Image Picker
            $('#imagePicker').spartanMultiImagePicker({
                fieldName: 'images[]', // Use images[] to support multiple file uploads
                maxFileCount: 5, // Max number of images
                rowHeight: '100px', // Set row height for images
                groupClassName: 'col-6', // Set class for image group (optional)
                maxFileSize: 3, // Max file size (optional)
                allowedExt: ['jpg', 'jpeg', 'png', 'gif'] // Allowed file types
            });
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

        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('dynamic-data-box');
            if (container && container.children.length === 0) {
                container.insertAdjacentHTML('beforeend', getTitleGroupHtml(titleCount));
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
            $('#industry').on('change', function() {
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
    <script src="{{ theme_asset('public/js/progress-form.js') }}"></script>
@endpush
