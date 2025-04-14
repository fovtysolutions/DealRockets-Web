@extends('layouts.back-end.app')

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
                                <select name="type" id="{{ $lang }}_type" class="js-select2-custom form-control">
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
                                    @if ($lang == $defaultLanguage)
                                        <span class="input-required-icon">*</span>
                                    @endif
                                </label>
                                <input type="text" {{ $lang == $defaultLanguage ? 'required' : '' }} name="name"
                                    id="{{ $lang }}_name"
                                    class="form-control {{ $lang == $defaultLanguage ? 'product-title-default-language' : '' }}"
                                    placeholder="{{ translate('new_leads') }}" value="{{ old('name', $leads->name) }}">
                            </div>
                            <input type="hidden" name="lang[]" value="{{ $lang }}">

                            <!-- Country -->
                            <div class="form-group">
                                <label class="title-color" for="{{ $lang }}_country">{{ translate('country') }}
                                    ({{ strtoupper($lang) }})
                                    @if ($lang == $defaultLanguage)
                                        <span class="input-required-icon">*</span>
                                    @endif
                                </label>
                                <select name="country" id="country" class="form-control">
                                    <option value="{{ $leads->country }}" selected>
                                        {{ \App\Utils\ChatManager::getCountryDetails($leads->country)['countryName'] ?? 'Select a Country' }}
                                    </option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
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

                            <!-- Company Name -->
                            <div class="form-group">
                                <label class="title-color"
                                    for="{{ $lang }}_company_name">{{ translate('company_name') }}</label>
                                <input type="text" name="company_name" id="{{ $lang }}_company_name"
                                    class="form-control" placeholder="{{ translate('enter_company_name') }}"
                                    value="{{ old('company_name', $leads->company_name) }}">
                            </div>

                            <!-- Contact Number -->
                            <div class="form-group">
                                <label class="title-color"
                                    for="{{ $lang }}_contact_number">{{ translate('contact_number') }}</label>
                                <input type="text" name="contact_number" id="{{ $lang }}_contact_number"
                                    class="form-control" placeholder="{{ translate('enter_contact_number') }}"
                                    value="{{ old('contact_number', $leads->contact_number) }}">
                            </div>

                            <!-- Posted Date -->
                            <div class="form-group">
                                <label class="title-color"
                                    for="{{ $lang }}_posted_date">{{ translate('posted_date') }}</label>
                                <input type="date" name="posted_date" id="{{ $lang }}_posted_date"
                                    class="form-control" value="{{ old('posted_date', $leads->posted_date) }}">
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
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <!-- Quantity Required -->
                                    <label class="title-color" for="{{ $lang }}_quantity_required">{{ translate('quantity_required') }}</label>
                                    <input type="number" name="quantity_required" id="{{ $lang }}_quantity_required"
                                        class="form-control" placeholder="{{ translate('enter_quantity_required') }}"
                                        value="{{ old('quantity_required', $leads->quantity_required) }}">
                                </div>
                                <div class="col-md-6">
                                    <!-- Unit -->
                                    <label class="title-color" for="{{ $lang }}_unit">{{ translate('Unit') }}
                                        <span class="input-required-icon">*</span>
                                    </label>
                                    <input type="text" {{ $lang == $defaultLanguage ? 'required' : '' }} name="unit"
                                        id="{{ $lang }}_unit" class="form-control" placeholder="{{ translate('Enter Unit') }}"
                                        value="{{ old('unit', $leads->unit) }}">
                                </div>
                            </div>

                            <!-- Term -->
                            <div class="form-group">
                                <label class="title-color"
                                    for="{{ $lang }}_term">{{ translate('Term') }}
                                    <span class="input-required-icon">*</span>
                                </label>
                                <input type="string" {{ $lang == $defaultLanguage ? 'required' : '' }} name="term"
                                    id="{{ $lang }}_term" class="form-control"
                                    placeholder="{{ translate('Enter Term') }}" value="{{ old('term', $leads->term) }}">
                            </div>

                            <!-- Compliance Status (Hidden Field) -->
                            <input type="hidden" name="compliance_status" id="compliance_status" value="{{ $leads->compliance_status }}">

                            <!-- Compliance Warning -->
                            @if ($leads->compliance_status == 'flagged')
                                <div id="compliance-warning" class="alert alert-warning">
                                    {{ translate('This lead has been flagged for compliance issues. Please review before updating.') }}
                                </div>
                            @endif

                            <!-- Buying Frequency -->
                            <div class="form-group">
                                <label class="title-color"
                                    for="{{ $lang }}_buying_frequency">{{ translate('buying_frequency') }}
                                    <span class="input-required-icon">*</span>
                                </label>
                                <select class="js-select2-custom form-control" name="buying_frequency">
                                    <option value="" disabled>{{ translate('select_buying_frequency') }}</option>
                                    <option value="daily" {{ $leads->buying_frequency == 'daily' ? 'selected' : '' }}>
                                        {{ translate('daily') }}</option>
                                    <option value="weekly" {{ $leads->buying_frequency == 'weekly' ? 'selected' : '' }}>
                                        {{ translate('weekly') }}</option>
                                    <option value="monthly" {{ $leads->buying_frequency == 'monthly' ? 'selected' : '' }}>
                                        {{ translate('monthly') }}</option>
                                    <option value="quarterly"
                                        {{ $leads->buying_frequency == 'quarterly' ? 'selected' : '' }}>
                                        {{ translate('quaterly') }}</option>
                                    <option value="yearly" {{ $leads->buying_frequency == 'yearly' ? 'selected' : '' }}>
                                        {{ translate('yearly') }}</option>
                                </select>
                            </div>

                            <!-- Details -->
                            <div class="form-group">
                                <label class="title-color"
                                    for="{{ $lang }}_details">{{ translate('details') }}</label>
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
            // Example compliance check logic
            $('#leadsForm').on('submit', function (e) {
                const details = $('#{{ $lang }}_details').val();
                const prohibitedKeywords = ['fraud', 'scam', 'illegal'];

                let isFlagged = false;
                prohibitedKeywords.forEach(keyword => {
                    if (details.includes(keyword)) {
                        isFlagged = true;
                    }
                });

                if (isFlagged) {
                    e.preventDefault();
                    $('#compliance-warning').removeClass('d-none');
                    $('#compliance_status').val('flagged');
                } else {
                    $('#compliance_status').val('approved');
                }
            });
        });
    </script>
@endpush
