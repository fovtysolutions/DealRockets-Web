@extends('layouts.back-end.app-partialseller')

@section('title', translate('Leads_Add'))

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
                {{ translate('add_New_Leads') }}
            </h2>
        </div>

        <form class="product-form text-start" action="{{ route('vendor.store.leads') }}" method="POST"
            enctype="multipart/form-data" id="leadsForm">
            @csrf
            <div class="card">
                <div class="card-body">
                    @include('admin-views.leads.partials._leads_fields')
                </div>
            </div>
        </form>
    </div>

    <!-- Additional scripts and data -->
    <span id="route-admin-products-sku-combination" data-url="{{ route('admin.products.sku-combination') }}"></span>
    <span id="route-admin-products-digital-variation-combination"
        data-url="{{ route('admin.products.digital-variation-combination') }}"></span>
    <span id="message-enter-choice-values" data-text="{{ translate('enter_choice_values') }}"></span>
    <!-- Additional messages and configurations -->

@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/tags-input.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/product-add-update.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/product-add-colors-img.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#leadsForm').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                var CurrentDate = new Date();
                var formattedDate = CurrentDate.toISOString().split('T')[0];
                // Create a FormData object from the form
                var loading = document.getElementById('loading');
                loading.classList.remove('d-none');
                loading.classList.add('d-block');

                var formData = new FormData(this);

                formData.append('posted_date', formattedDate);

                $.ajax({
                    url: $(this).attr('action'), // Get the action URL from the form
                    method: $(this).attr('method'), // Use the method specified in the form
                    data: formData, // Send the form data
                    processData: false, // Important! Don't process the data
                    contentType: false, // Important! Set content type to false
                    success: function(response) {
                        loading.classList.add('d-none');
                        loading.classList.remove('d-block');

                        toastr() - > success("Leads added successfully!");
                        $('#leadsForm')[0].reset();
                    },
                    error: function(xhr) {
                        // Handle errors (for example, show validation messages)
                        var errors = xhr.responseJSON.errors;
                        var errorMessages = '';
                        for (var key in errors) {
                            errorMessages += errors[key].join(', ') +
                            '\n'; // Create a string of error messages
                        }
                        alert(errorMessages); // Show error messages
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.js-select2-country').select2({
                placeholder: "{{ translate('select_country') }}",
                ajax: {
                    url: 'https://restcountries.com/v3.1/name/',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(country) {
                                return {
                                    id: country.cca2,
                                    text: country.name.common
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        });
    </script>
@endpush
