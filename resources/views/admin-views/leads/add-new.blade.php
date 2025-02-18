@extends('layouts.back-end.app')

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

    <form class="product-form text-start" action="{{ route('admin.store.leads') }}" method="POST"
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
                            <select class="js-select2-custom form-control" name="type">
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
                                <select name="country" id="country" class="form-control">
                                <option value="value" selected>Select a Country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                                </select>
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

                        <!-- Unit -->
                        <div class="form-group">
                            <label class="title-color" for="{{ $lang }}_unit">{{ translate('unit') }}</label>
                            <input type="text" name="unit" id="{{ $lang }}_unit" class="form-control"
                                placeholder="{{ translate('enter_unit') }}"
                                value="{{ old('unit', $leads->unit ?? '') }}">
                        </div>

                        <!-- Company Name -->
                        <div class="form-group">
                            <label class="title-color" for="{{ $lang }}_company_name">{{ translate('company_name') }}
                                ({{ strtoupper($lang) }})
                                @if($lang == $defaultLanguage)
                                    <span class="input-required-icon"></span>
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

                        <!-- Quantity Required -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <!-- Quantity Required -->
                                <label class="title-color" for="{{ $lang }}_quantity_required">{{ translate('quantity_required') }}</label>
                                <input type="number" name="quantity_required" id="{{ $lang }}_quantity_required"
                                    class="form-control" placeholder="{{ translate('enter_quantity_required') }}">
                            </div>
                            <div class="col-md-6">
                                <!-- Unit -->
                                <label class="title-color" for="{{ $lang }}_unit">{{ translate('Unit') }}
                                    <span class="input-required-icon">*</span>
                                </label>
                                <input type="text" {{ $lang == $defaultLanguage ? 'required' : '' }} name="unit"
                                    id="{{ $lang }}_unit" class="form-control" placeholder="{{ translate('Enter Unit') }}">
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
                                placeholder="{{ translate('Enter Term') }}">
                        </div>

                        <!-- Buying Frequency -->
                        <div class="form-group">
                            <label class="title-color"
                                for="{{ $lang }}_buying_frequency">{{ translate('buying_frequency') }}
                                <span class="input-required-icon">*</span>
                            </label>
                            <select class="js-select2-custom form-control" name="buying_frequency">
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
            <button type="submit" class="btn btn--primary px-5" form="leadsForm">
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
@endpush