@extends('layouts.back-end.app-seller')

@section('title', translate('Edit_Leads'))

@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="content container-fluid">
    <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
        <h2 class="h1 mb-0 d-flex gap-2">
            <img src="{{ dynamicAsset('public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
            {{ translate('Update_Leads') }}
        </h2>
    </div>

    <form class="product-form text-start" action="{{ route('vendor.leads.update', $leads->id) }}" method="POST"
        enctype="multipart/form-data" id="leadsForm">
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
            </div>

            <div class="card-body">
                @foreach ($languages as $lang)
                    <div class="{{ $lang != $defaultLanguage ? 'd-none' : '' }} form-system-language-form"
                        id="{{ $lang }}-form">

                        <!-- Type -->
                        <div class="form-group">
                            <label class="title-color" for="{{ $lang }}_type">{{ translate('type') }}
                                <span class="input-required-icon">*</span>
                            </label>
                            <select name="type" id="{{ $lang }}_type" class="js-select2-custom form-control" required>
                                <option value="">{{ translate('select_type') }}</option>
                                <option value="buyer" {{ old('type', $leads->type) == 'buyer' ? 'selected' : '' }}>
                                    {{ translate('buyer') }}
                                </option>
                                <option value="seller" {{ old('type', $leads->type) == 'seller' ? 'selected' : '' }}>
                                    {{ translate('seller') }}
                                </option>
                            </select>
                        </div>

                        <!-- Leads Name -->
                        <div class="form-group">
                            <label class="title-color" for="{{ $lang }}_name">{{ translate('leads_name') }}
                                ({{ strtoupper($lang) }})
                                @if($lang == $defaultLanguage)
                                    <span class="input-required-icon">*</span>
                                @endif
                            </label>
                            <input type="text" {{ $lang == $defaultLanguage ? 'required' : '' }} name="name"
                                id="{{ $lang }}_name"
                                class="form-control {{ $lang == $defaultLanguage ? 'product-title-default-language' : '' }}"
                                placeholder="{{ translate('new_leads') }}" value="{{ old('name', $leads->name) }}">
                        </div>

                        <!-- Country -->
                        <div class="form-group">
                            <label class="title-color" for="{{ $lang }}_country">{{ translate('country') }}
                                ({{ strtoupper($lang) }})
                                @if($lang == $defaultLanguage)
                                    <span class="input-required-icon">*</span>
                                @endif
                            </label>
                            <select class="form-control" placeholder="{{ translate('Enter Country') }}" name="country"
                                data-role="countryinput">
                                <option selected value="{{ $leads->country }}">
                                    {{ \App\Models\Country::where('id', $leads->country)->first()->name ?? 'Select a Country' }}
                                </option>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Company Name -->
                        <div class="form-group">
                            <label class="title-color"
                                for="{{ $lang }}_company_name">{{ translate('company_name') }}</label>
                            <input type="text" name="company_name" id="{{ $lang }}_company_name" class="form-control"
                                placeholder="{{ translate('enter_company_name') }}"
                                value="{{ old('company_name', $leads->company_name) }}">
                        </div>

                        <!-- Contact Number -->
                        <div class="form-group">
                            <label class="title-color"
                                for="{{ $lang }}_contact_number">{{ translate('contact_number') }}</label>
                            <input type="text" name="contact_number" id="{{ $lang }}_contact_number" class="form-control"
                                placeholder="{{ translate('enter_contact_number') }}"
                                value="{{ old('contact_number', $leads->contact_number) }}">
                        </div>

                        <!-- Posted Date -->
                        <div class="form-group">
                            <label class="title-color" for="{{ $lang }}_posted_date">{{ translate('posted_date') }}</label>
                            <input type="date" name="posted_date" id="{{ $lang }}_posted_date" class="form-control"
                                value="{{ old('posted_date', $leads->posted_date) }}">
                        </div>
                        
                        <div class="form-group">
                            <label for="{{ $lang }}_product" class="form-label">Product</label>
                            <select id="{{ $lang }}_product" name="product_id" class="form-control">
                                <option selected value="{{$leads->product_id}}">{{$name}}</option>
                                @foreach ($items as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Leads Industry --}}
                        <div class="form-group">
                            <label class="title-color" for="{{ $lang }}_industry">{{ translate('industry') }}
                                ({{ strtoupper($lang) }})
                                @if ($lang == $defaultLanguage)
                                    <span class="input-required-icon">*</span>
                                @endif
                            </label>
                            <select name="industry" id="industry" class="form-control">
                                <option value="{{ $leads->industry }}" selected>{{ \App\Utils\ChatManager::getCategoryName($leads->industry) ?? 'Select a Industry' }}</option>
                                @foreach ($industries as $industry)
                                    <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                                @endforeach
                            </select>
                        </div>                        

                        <!-- Quantity Required -->
                        <div class="form-group">
                            <label class="title-color"
                                for="{{ $lang }}_quantity_required">{{ translate('quantity_required') }}</label>
                            <input type="number" name="quantity_required" id="{{ $lang }}_quantity_required"
                                class="form-control" placeholder="{{ translate('enter_quantity_required') }}"
                                value="{{ old('quantity_required', $leads->quantity_required) }}">
                        </div>

                        <!-- Term -->
                        <div class="form-group">
                            <label class="title-color" for="{{ $lang }}_term">{{ translate('term') }}</label>
                            <input type="text" name="term" id="{{ $lang }}_term" class="form-control"
                                placeholder="{{ translate('enter_term') }}"
                                value="{{ old('term', $leads->term ?? '') }}">
                        </div>

                        <!-- Unit -->
                        <div class="form-group">
                            <label class="title-color" for="{{ $lang }}_unit">{{ translate('unit') }}</label>
                            <input type="text" name="unit" id="{{ $lang }}_unit" class="form-control"
                                placeholder="{{ translate('enter_unit') }}"
                                value="{{ old('unit', $leads->unit ?? '') }}">
                        </div>

                        <!-- Buying Frequency -->
                        <div class="form-group">
                            <label class="title-color"
                                for="{{ $lang }}_buying_frequency">{{ translate('buying_frequency') }}</label>
                            <input type="text" name="buying_frequency" id="{{ $lang }}_buying_frequency"
                                class="form-control" placeholder="{{ translate('enter_buying_frequency') }}"
                                value="{{ old('buying_frequency', $leads->buying_frequency) }}">
                        </div>

                        <!-- Details -->
                        <div class="form-group">
                            <label class="title-color" for="{{ $lang }}_details">{{ translate('details') }}</label>
                            <textarea name="details" id="{{ $lang }}_details" class="form-control" rows="4"
                                placeholder="{{ translate('enter_details') }}">{{ old('details', $leads->details) }}</textarea>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row justify-content-end gap-3 mt-3 mx-1 my-3">
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
            $('#leadsForm').on('submit', function (event) {
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
                        alert("leads updated successfully!"); // Show a simple alert
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
    <script>
        $(document).ready(function () {
            // Initialize select2 with AJAX for fetching countries
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

            // Pre-select the country if there is a previous selection
            var preSelectedCountry = "{{ old('country', $leads->country) }}";
            if (preSelectedCountry) {
                $('.js-select2-country').val(preSelectedCountry).trigger('change');
            }

            // Handle input for country search
            $('#{{ $lang }}_country_input').on('input', function () {
                var name = $(this).val();
                if (name.length >= 1) {
                    $('.js-select2-country').select2('open');
                    $('.js-select2-country').val(null).trigger('change'); // Clear previous selections
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
                    $('.js-select2-country').select2('close');
                }
            });

            $('#{{ $lang }}_country').on('select2:open', function () {
                $('.select2-search__field').on('input', function () {
                    var name = $(this).val();
                    if (name.length < 1) {
                        $('.js-select2-country').select2('close');
                    }
                });
            });
        });
    </script>
@endpush