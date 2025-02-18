@extends('layouts.back-end.app-seller')

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
            <div class="px-4 pt-3 d-flex justify-content-between">
                <ul class="nav nav-tabs w-fit-content mb-4">
                    @foreach ($languages as $lang)
                        <li class="nav-item">
                            <span
                                class="nav-link text-capitalize form-system-language-tab {{ $lang == $defaultLanguage ? 'active' : '' }} cursor-pointer"
                                id="{{ $lang }}-link">{{ getLanguageName($lang) . '(' . strtoupper($lang) . ')' }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="card-body">
                @foreach ($languages as $lang)
                    <div class="{{ $lang != $defaultLanguage ? 'd-none' : '' }} form-system-language-form"
                        id="{{ $lang }}-form">

                        <!-- Buyer/Seller Dropdown -->
                        <div class="form-group">
                            <label for="buyer_seller" class="title-color">{{ translate('buyer_or_seller') }}
                                <span class="input-required-icon">*</span>
                            </label>
                            <select class="js-select2-custom form-control" name="type" required>
                                <option value="" disabled selected>{{ translate('select_buyer_or_seller') }}</option>
                                <option value="buyer">{{ translate('buyer') }}</option>
                                <option value="seller">{{ translate('seller') }}</option>
                            </select>
                        </div>

                        <!-- Lead Name -->
                        <div class="form-group">
                            <label class="title-color" for="{{ $lang }}_name">{{ translate('Lead_name') }}
                                ({{ strtoupper($lang) }})
                                @if($lang == $defaultLanguage)
                                    <span class="input-required-icon">*</span>
                                @endif
                            </label>
                            <input type="text" {{ $lang == $defaultLanguage ? 'required' : '' }} name="name"
                                id="{{ $lang }}_name"
                                class="form-control {{ $lang == $defaultLanguage ? 'product-title-default-language' : '' }}"
                                placeholder="{{ translate('new_lead') }}">
                        </div>

                        <!-- Country -->
                        <div class="form-group">
                            <label class="title-color" for="{{ $lang }}_country">{{ translate('country') }}
                                ({{ strtoupper($lang) }})
                                @if($lang == $defaultLanguage)
                                    <span class="input-required-icon">*</span>
                                @endif
                            </label>
                            <select class="form-control" placeholder="{{ translate('Enter Origin') }}"
                                name="country" data-role="country">
                                <option selected value="">Select a Country</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Company Name -->
                        <div class="form-group">
                            <label class="title-color" for="{{ $lang }}_company_name">{{ translate('company_name') }}
                                ({{ strtoupper($lang) }})
                                @if($lang == $defaultLanguage)
                                    <span class="input-required-icon">*</span>
                                @endif
                            </label>
                            <input type="text" {{ $lang == $defaultLanguage ? 'required' : '' }} name="company_name"
                                id="{{ $lang }}_company_name"
                                class="form-control {{ $lang == $defaultLanguage ? 'product-title-default-language' : '' }}"
                                placeholder="{{ translate('enter_company_name') }}">
                        </div>

                        <!-- Contact Number -->
                        <div class="form-group">
                            <label class="title-color" for="{{ $lang }}_contact_number">{{ translate('contact_number') }}
                                <span class="input-required-icon">*</span>
                            </label>
                            <input type="text" {{ $lang == $defaultLanguage ? 'required' : '' }} name="contact_number"
                                id="{{ $lang }}_contact_number" class="form-control"
                                placeholder="{{ translate('enter_contact_number') }}">
                        </div>

                        {{-- Leads Industry --}}
                        <div class="form-group">
                            <label class="title-color" for="{{ $lang }}_industry">{{ translate('industry') }}
                                ({{ strtoupper($lang) }})
                                @if($lang == $defaultLanguage)
                                    <span class="input-required-icon">*</span>
                                @endif
                            </label>
                            <select name="industry" id="industry" class="form-control">
                                <option value="" selected>Select a Industry</option>
                                @foreach($industries as $industry)
                                    <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="{{ $lang }}_product" class="form-label">Product</label>
                            <select id="{{ $lang }}_product" name="product_id" class="form-control">
                                <option selected value="">Select a product</option>
                                @foreach ($items as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Quantity Required -->
                        <div class="form-group">
                            <label class="title-color"
                                for="{{ $lang }}_quantity_required">{{ translate('quantity_required') }}
                                <span class="input-required-icon">*</span>
                            </label>
                            <input type="text" {{ $lang == $defaultLanguage ? 'required' : '' }} name="quantity_required"
                                id="{{ $lang }}_quantity_required" class="form-control"
                                placeholder="{{ translate('enter_quantity_required') }}">
                        </div>

                        <!-- Term -->
                        <div class="form-group">
                            <label class="title-color" for="{{ $lang }}_term">{{ translate('term') }}</label>
                            <input type="text" name="term" id="{{ $lang }}_term" class="form-control"
                                placeholder="{{ translate('enter_term') }}">
                        </div>

                        <!-- Unit -->
                        <div class="form-group">
                            <label class="title-color" for="{{ $lang }}_unit">{{ translate('unit') }}</label>
                            <input type="text" name="unit" id="{{ $lang }}_unit" class="form-control"
                                placeholder="{{ translate('enter_unit') }}">
                        </div>

                        <!-- Buying Frequency -->
                        <div class="form-group">
                            <label class="title-color"
                                for="{{ $lang }}_buying_frequency">{{ translate('buying_frequency') }}
                                <span class="input-required-icon">*</span>
                            </label>
                            <select class="js-select2-custom form-control" name="buying_frequency" required>
                                <option value="" disabled selected>{{ translate('select_buying_frequency') }}</option>
                                <option value="daily">{{ translate('daily') }}</option>
                                <option value="weekly">{{ translate('weekly') }}</option>
                                <option value="monthly">{{ translate('monthly')}}</option>
                                <option value="quarterly">{{ translate('quaterly')}}</option>
                                <option value="yearly">{{ translate('yearly') }}</option>
                            </select>
                        </div>

                        <!-- Additional Details -->
                        <div class="form-group">
                            <label class="title-color" for="{{ $lang }}_details">{{ translate('details') }}</label>
                            <textarea name="details" id="{{ $lang }}_details" class="form-control"
                                placeholder="{{ translate('enter_details') }}" rows="3"></textarea>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="row justify-content-end gap-3 mt-3 mx-1">
            <button type="reset" class="btn btn-secondary px-5">{{ translate('reset') }}</button>
            <button type="submit" class="btn btn--primary px-5">
                {{ translate('submit') }}
            </button>
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
        $(document).ready(function () {
            $('#leadsForm').on('submit', function (event) {
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
                    success: function (response) {
                        loading.classList.add('d-none');
                        loading.classList.remove('d-block');        

                        toastr()->success("Leads added successfully!");
                        $('#leadsForm')[0].reset();
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
        $(document).ready(function () {
            $('.js-select2-country').select2({
                placeholder: "{{ translate('select_country') }}",
                ajax: {
                    url: 'https://restcountries.com/v3.1/name/',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (country) {
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

            $('#{{ $lang }}_country_input').on('input', function () {
                var name = $(this).val();
                if (name.length >= 1) { // Trigger search when at least 1 character is entered
                    $('.js-select2-country').select2('open'); // Open the dropdown
                    $('.js-select2-country').select2('data', []); // Clear previous data
                    $('.js-select2-country').select2({
                        ajax: {
                            url: 'https://restcountries.com/v3.1/name/' + name,
                            dataType: 'json',
                            delay: 250,
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function (country) {
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
                } else {
                    $('.js-select2-country').select2('close'); // Close the dropdown if input is empty
                }
            });
            $('#{{ $lang }}_country').on('select2:open', function () {
                $('.select2-search__field').on('input', function () {
                    var name = $(this).val();
                    if (name.length < 1) {
                        $('.js-select2-country').select2('close'); // Close if input is empty
                    }
                });
            });
        });
    </script>
@endpush