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

        <form class="product-form text-start" 
            action="{{ route('admin.store.leads') }}" 
            method="POST"
            enctype="multipart/form-data">
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
    
                            <div class="row mb-4">
                                <!-- Buyer/Seller Dropdown -->
                                <div class="col form-group">
                                    <label for="buyer_seller" class="title-color">{{ translate('buyer_or_seller') }}
                                        <span class="input-required-icon">*</span>
                                    </label>
                                    <select class="js-select2-custom form-control" name="type">
                                        <option value="" disabled selected>{{ translate('select_buyer_or_seller') }}
                                        </option>
                                        <option value="buyer">{{ translate('buyer') }}</option>
                                        <option value="seller">{{ translate('seller') }}</option>
                                    </select>
                                </div>
    
                                <!-- Lead Name -->
                                <div class="col form-group">
                                    <label class="title-color" for="{{ $lang }}_name">{{ translate('Lead_name') }}
                                        ({{ strtoupper($lang) }})
                                        @if ($lang == $defaultLanguage)
                                            <span class="input-required-icon">*</span>
                                        @endif
                                    </label>
                                    <input type="text" {{ $lang == $defaultLanguage ? 'required' : '' }} name="name"
                                        id="{{ $lang }}_name"
                                        class="form-control {{ $lang == $defaultLanguage ? 'product-title-default-language' : '' }}"
                                        placeholder="{{ translate('new_lead') }}">
                                </div>
                            </div>
    
                            <div class="row mb-4">
                                <!-- Country -->
                                <div class="col form-group">
                                    <label class="title-color"
                                        for="{{ $lang }}_country">{{ translate('country') }}
                                        ({{ strtoupper($lang) }})
                                        @if ($lang == $defaultLanguage)
                                            <span class="input-required-icon">*</span>
                                        @endif
                                    </label>
                                    <select name="country" id="country" class="form-control">
                                        <option value="value" selected>Select a Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
    
                                {{-- Leads Industry --}}
                                <div class="col form-group">
                                    <label class="title-color"
                                        for="{{ $lang }}_industry">{{ translate('industry') }}
                                        ({{ strtoupper($lang) }})
                                        @if ($lang == $defaultLanguage)
                                            <span class="input-required-icon">*</span>
                                        @endif
                                    </label>
                                    <select name="industry" id="industry" class="form-control">
                                        <option value="" selected>Select a Industry</option>
                                        @foreach ($industries as $industry)
                                            <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
    
                                <div class=" col form-group">
                                    <label for="{{ $lang }}_product" class="form-label">Product</label>
                                    <input type="text" {{ $lang == $defaultLanguage ? 'required' : '' }} name="product_id"
                                        id="{{ $lang }}_product"
                                        class="form-control {{ $lang == $defaultLanguage ? 'product-title-default-language' : '' }}"
                                        placeholder="{{ translate('product') }}">
                                </div>
    
                                <div class="col form-group">
                                    <label for="images" class="form-label">{{ translate('product_images') }}</label>
                                    <input type="file" 
                                           name="images[]" 
                                           id="images" 
                                           class="form-control" 
                                           multiple 
                                           accept="image/*">
                                    <small class="text-muted">{{ translate('you_can_select_multiple_images') }}</small>
                                </div>
                                <!-- Unit -->
                                {{-- <div class="col form-group">
                            <label class="title-color" for="{{ $lang }}_unit">{{ translate('unit') }}</label>
                            <input type="text" name="unit" id="{{ $lang }}_unit" class="form-control"
                                placeholder="{{ translate('enter_unit') }}"
                                value="{{ old('unit', $leads->unit ?? '') }}">
                        </div> --}}
                            </div>
    
                            <div class="row mb-4">
                                <!-- Company Name -->
                                <div class="col form-group">
                                    <label class="title-color"
                                        for="{{ $lang }}_company_name">{{ translate('company_name') }}
                                        ({{ strtoupper($lang) }})
                                        @if ($lang == $defaultLanguage)
                                            <span class="input-required-icon"></span>
                                        @endif
                                    </label>
                                    <input type="text" {{ $lang == $defaultLanguage ? 'required' : '' }}
                                        name="company_name" id="{{ $lang }}_company_name"
                                        class="form-control {{ $lang == $defaultLanguage ? 'product-title-default-language' : '' }}"
                                        placeholder="{{ translate('enter_company_name') }}">
                                </div>
    
                                <!-- Contact Number -->
                                <div class="col form-group">
                                    <label class="title-color"
                                        for="{{ $lang }}_contact_number">{{ translate('contact_number') }}
                                        <span class="input-required-icon">*</span>
                                    </label>
                                    <input type="text" {{ $lang == $defaultLanguage ? 'required' : '' }}
                                        name="contact_number" id="{{ $lang }}_contact_number" class="form-control"
                                        placeholder="{{ translate('enter_contact_number') }}">
                                </div>
                            </div>
    
                            <!-- Quantity Required -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <!-- Quantity Required -->
                                    <label class="title-color"
                                        for="{{ $lang }}_quantity_required">{{ translate('quantity_required') }}</label>
                                    <input type="number" name="quantity_required"
                                        id="{{ $lang }}_quantity_required" class="form-control"
                                        placeholder="{{ translate('enter_quantity_required') }}">
                                </div>
                                <div class="col-md-6">
                                    <!-- Unit -->
                                    <label class="title-color" for="{{ $lang }}_unit">{{ translate('Unit') }}
                                        <span class="input-required-icon">*</span>
                                    </label>
                                    <input type="text" {{ $lang == $defaultLanguage ? 'required' : '' }}
                                        name="unit" id="{{ $lang }}_unit" class="form-control"
                                        placeholder="{{ translate('Enter Unit') }}">
                                </div>
                            </div>
    
                            <div class="row mb-4">
    
                                <!-- Term -->
                                <div class="col form-group">
                                    <label class="title-color" for="{{ $lang }}_term">{{ translate('Term') }}
                                        <span class="input-required-icon">*</span>
                                    </label>
                                    <input type="string" {{ $lang == $defaultLanguage ? 'required' : '' }}
                                        name="term" id="{{ $lang }}_term" class="form-control"
                                        placeholder="{{ translate('Enter Term') }}">
                                </div>
    
                                <!-- Buying Frequency -->
                                <div class="col form-group">
                                    <label class="title-color"
                                        for="{{ $lang }}_buying_frequency">{{ translate('buying_frequency') }}
                                        <span class="input-required-icon">*</span>
                                    </label>
                                    <select class="js-select2-custom form-control" name="buying_frequency">
                                        <option value="" disabled selected>
                                            {{ translate('select_buying_frequency') }}</option>
                                        <option value="daily">{{ translate('daily') }}</option>
                                        <option value="weekly">{{ translate('weekly') }}</option>
                                        <option value="monthly">{{ translate('monthly') }}</option>
                                        <option value="quarterly">{{ translate('quaterly') }}</option>
                                        <option value="yearly">{{ translate('yearly') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
    
                                <!-- Compliance Status (Hidden Field) -->
                                <div class="col form-group">
                                    <label for="compliance_status" class="form-label">Compliance Status</label>
                                    <select name="compliance_status" id="compliance_status" class="form-control">
                                        <option value="pending" selected>Pending</option>
                                        <option value="approved">Approved</option>
                                        <option value="flagged">Flagged</option>
                                    </select>
                                </div>
    
                                <!-- City -->
                                <div class="col form-group">
                                    <label for="{{ $lang }}_city">{{ translate('city') }}</label>
                                    <input type="text" name="city" id="{{ $lang }}_city"
                                        class="form-control" placeholder="{{ translate('enter_city') }}"
                                        value="{{ old('city', $leads->city ?? '') }}">
                                </div>
                            </div>
                            <div class="row mb-4">
    
                                <!-- Tags -->
                                <div class="col form-group">
                                    <label for="{{ $lang }}_tags">{{ translate('tags') }}</label>
                                    <input type="text" name="tags" id="{{ $lang }}_tags"
                                        class="form-control" placeholder="{{ translate('enter_tags') }}"
                                        value="{{ old('tags', $leads->tags ?? '') }}">
                                </div>
    
                                <!-- Refund -->
                                <div class="col form-group">
                                    <label for="{{ $lang }}_refund">{{ translate('refund_policy') }}</label>
                                    <input type="text" name="refund" id="{{ $lang }}_refund"
                                        class="form-control" placeholder="{{ translate('enter_refund_policy') }}"
                                        value="{{ old('refund', $leads->refund ?? '') }}">
                                </div>
                            </div>
                            <div class="row mb-4">
    
                                <!-- Available Stock -->
                                <div class="col form-group">
                                    <label for="{{ $lang }}_avl_stock">{{ translate('available_stock') }}</label>
                                    <input type="text" name="avl_stock" id="{{ $lang }}_avl_stock"
                                        class="form-control" placeholder="{{ translate('enter_available_stock') }}"
                                        value="{{ old('avl_stock', $leads->avl_stock ?? '') }}">
                                </div>
    
                                <!-- Available Stock Unit -->
                                <div class="col form-group">
                                    <label
                                        for="{{ $lang }}_avl_stock_unit">{{ translate('available_stock_unit') }}</label>
                                    <input type="text" name="avl_stock_unit" id="{{ $lang }}_avl_stock_unit"
                                        class="form-control" placeholder="{{ translate('enter_available_stock_unit') }}"
                                        value="{{ old('avl_stock_unit', $leads->avl_stock_unit ?? '') }}">
                                </div>
    
                            </div>
                            <div class="row mb-4">
    
                                <!-- Lead Time -->
                                <div class="col form-group">
                                    <label for="{{ $lang }}_lead_time">{{ translate('lead_time') }}</label>
                                    <input type="text" name="lead_time" id="{{ $lang }}_lead_time"
                                        class="form-control" placeholder="{{ translate('enter_lead_time') }}"
                                        value="{{ old('lead_time', $leads->lead_time ?? '') }}">
                                </div>
    
                                <!-- Brand -->
                                <div class="col form-group">
                                    <label for="{{ $lang }}_brand">{{ translate('brand') }}</label>
                                    <input type="text" name="brand" id="{{ $lang }}_brand"
                                        class="form-control" placeholder="{{ translate('enter_brand') }}"
                                        value="{{ old('brand', $leads->brand ?? '') }}">
                                </div>
                            </div>
                            <div class="row mb-4">
    
                                <!-- Payment Option -->
                                <div class="col form-group">
                                    <label
                                        for="{{ $lang }}_payment_option">{{ translate('payment_option') }}</label>
                                    <input type="text" name="payment_option" id="{{ $lang }}_payment_option"
                                        class="form-control" placeholder="{{ translate('enter_payment_option') }}"
                                        value="{{ old('payment_option', $leads->payment_option ?? '') }}">
                                </div>
    
                                <!-- Offer Type -->
                                <div class="col form-group">
                                    <label for="{{ $lang }}_offer_type">{{ translate('offer_type') }}</label>
                                    <input type="text" name="offer_type" id="{{ $lang }}_offer_type"
                                        class="form-control" placeholder="{{ translate('enter_offer_type') }}"
                                        value="{{ old('offer_type', $leads->offer_type ?? '') }}">
                                </div>
                            </div>
                            <div class="row mb-4">
    
                                <!-- Size -->
                                <div class="col form-group">
                                    <label for="{{ $lang }}_size">{{ translate('size') }}</label>
                                    <input type="text" name="size" id="{{ $lang }}_size"
                                        class="form-control" placeholder="{{ translate('enter_size') }}"
                                        value="{{ old('size', $leads->size ?? '') }}">
                                </div>
    
                                <!-- Additional Details -->
                                <div class="col form-group">
                                    <label class="title-color"
                                        for="{{ $lang }}_details">{{ translate('details') }}</label>
                                    <textarea name="details" id="{{ $lang }}_details" class="form-control"
                                        placeholder="{{ translate('enter_details') }}" rows="3"></textarea>
                                </div>
                            </div>
    
                            <!-- Compliance Warning -->
                            <div id="compliance-warning" class="alert alert-warning d-none">
                                {{ translate('This lead may not comply with platform standards. Please review before submitting.') }}
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
@endsection

@push('script')

@endpush
