@extends('layouts.back-end.app-partialseller')

@section('title', translate('profile_Settings'))
@push('css_or_js')
    <link rel="stylesheet"
        href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/intl-tel-input/css/intlTelInput.css') }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <div class="card mb-5">
            <div class="card-body">
                <form action="{{ route('vendor.profile.update', [$vendor->id]) }}" method="post" enctype="multipart/form-data"
                    id="update-profile-form">
                    @csrf
                        <div class="profile-cover">
                            @php($banner = dynamicAsset(path: 'public/assets/back-end/img/media/admin-profile-bg.png'))
                            <div class="profile-cover-img-wrapper profile-bg"
                                style="background-image: url({{ $banner }})"></div>
                        </div>
                        <div class="avatar avatar-xxl avatar-circle avatar-border-lg avatar-uploader profile-cover-avatar">
                            <img id="viewer" class="avatar-img"
                                src="{{ getStorageImages(path: $vendor->image_full_url, type: 'backend-profile') }}"
                                alt="{{ translate('image') }}">
                            <label class="change-profile-image-icon" for="custom-file-upload">
                                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/add-photo.png') }}"
                                    alt="">
                            </label>
                        </div>

                        <div class="card-header">
                            <div class="d-flex align-items-center gap-3">
                                <div><img src="{{ dynamicAsset(path: 'public/assets/back-end/img/icons/user-1.svg') }}"
                                        alt="">
                                </div>
                                <h4 class="card-title m-0 fs-16">{{ translate('Login Information') }}</h4>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <label for="firstNameLabel" class="input-label mb-0">
                                            {{ translate('first_Name') }}
                                            <span class="text-danger px-1">*</span>
                                        </label>
                                        <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                            data-placement="right" title=""
                                            data-original-title="{{ translate('this_will_be_displayed_as_your_profile_name') }}">
                                            <img alt="" width="16"
                                                src={{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}
                                                alt="">
                                        </span>
                                    </div>

                                    <div class="mb-3">
                                        <div class="input-group input-group-sm-down-break">
                                            <input type="text" class="form-control" name="f_name" id="firstNameLabel"
                                                placeholder="{{ translate('ex') }}: {{ translate('ABC') }}"
                                                aria-label=" {{ translate('ABC') }}" value="{{ $vendor->f_name }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <label for="lastNameLabel" class="input-label mb-0">
                                            {{ translate('last_Name') }}
                                            <span class="text-danger px-1">*</span>
                                        </label>
                                    </div>

                                    <div class="mb-3">
                                        <div class="input-group input-group-sm-down-break">
                                            <input type="text" class="form-control" name="l_name" id="lastNameLabel"
                                                placeholder="{{ translate('ex') }}: {{ translate('ABC') }}"
                                                aria-label=" {{ translate('ABC') }}" value="{{ $vendor->l_name }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <label for="phoneLabel" class="input-label mb-0">
                                            {{ translate('phone_Number') }}
                                            <span class="input-label-secondary">
                                                ({{ translate('optional') }})
                                            </span>
                                        </label>
                                    </div>

                                    <div class="mb-3">
                                        <input class="form-control form-control-user phone-input-with-country-picker"
                                            type="tel" id="phoneLabel" value="{{ $vendor->phone ?? old('phone') }}"
                                            placeholder="{{ translate('ex') }}: {{ translate('123456789') }}" required>
                                        <input type="hidden" class="country-picker-phone-number w-50"
                                            value="{{ $vendor->phone }}" name="phone" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <label for="newEmailLabel" class="input-label mb-0">
                                            {{ translate('email') }}
                                            <span class="text-danger px-1">*</span>
                                        </label>

                                        <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                            data-placement="right" title=""
                                            data-original-title="{{ translate('you_can_login_to_your_panel_by_using_this_email') }}">
                                            <img alt="" width="16"
                                                src={{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}
                                                alt="">
                                        </span>
                                    </div>
                                    <div class="mb-3">
                                        <input type="email" class="form-control" name="email" id="newEmailLabel"
                                            value="{{ $vendor->email }}" readonly
                                            placeholder="{{ translate('ex') }}: {{ 'admin@admin.com' }}">
                                    </div>
                                </div>

                            </div>

                            <div class="d-none" id="select-img">
                                <input type="file" name="image" id="custom-file-upload"
                                    class="custom-file-input image-input" data-image-id="viewer"
                                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" data-form-id="update-profile-form"
                                    data-message="{{ translate('want_to_update_vendor_info') . '?' }}"
                                    class="btn btn--primary {{ env('APP_MODE') != 'demo' ? 'form-submit' : 'call-demo' }}">{{ translate('save_Changes') }}</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form id="update-password-form" action="{{ route('vendor.profile.update', [auth('seller')->id()]) }}"
                    method="POST" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-2">
                                <label for="newPassword" class="input-label mb-0">
                                    {{ translate('new_password') }}
                                    <span class="text-danger px-1">*</span>
                                </label>
                                <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                    data-placement="right" title=""
                                    data-original-title="{{ translate('The_password_must_be_at_least_8_characters_long_and_contain_at_least_one_uppercase_letter') . ',' . translate('_one_lowercase_letter') . ',' . translate('_one_digit_') . ',' . translate('_one_special_character') . ',' . translate('_and_no_spaces') . '.' }}">
                                    <img alt="" width="16"
                                        src={{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}
                                        alt="" class="m-1">
                                </span>
                            </div>
                            <div class="">
                                <div class="input-group input-group-merge">
                                    <input type="password" class="js-toggle-password form-control password-check"
                                        id="newPassword" autocomplete="off" name="password" required minlength="8"
                                        placeholder="{{ translate('enter_new_password') }}"
                                        data-hs-toggle-password-options='{
                                                         "target": "#changePassTarget",
                                                        "defaultClass": "tio-hidden-outlined",
                                                        "showClass": "tio-visible-outlined",
                                                        "classChangeTarget": "#changePassIcon"
                                                }'>
                                    <div id="changePassTarget" class="input-group-append">
                                        <a class="input-group-text" href="javascript:">
                                            <i id="changePassIcon" class="tio-visible-outlined"></i>
                                        </a>
                                    </div>
                                </div>
                                <span class="text-danger pt-1 min-h-20 d-block password-error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-2">
                                <label for="confirmNewPasswordLabel" class="input-label mb-1">
                                    {{ translate('confirm_password') }}
                                    <span class="text-danger px-1">*</span>
                                </label>
                            </div>
                            <div class="">
                                <div class="mb-3">
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="js-toggle-password form-control"
                                            name="confirm_password" required id="confirmNewPasswordLabel"
                                            placeholder="{{ translate('enter_confirm_password') }}" autocomplete="off"
                                            data-hs-toggle-password-options='{
                                                         "target": "#changeConfirmPassTarget",
                                                        "defaultClass": "tio-hidden-outlined",
                                                        "showClass": "tio-visible-outlined",
                                                        "classChangeTarget": "#changeConfirmPassIcon"
                                                }'>
                                        <div id="changeConfirmPassTarget" class="input-group-append">
                                            <a class="input-group-text" href="javascript:">
                                                <i id="changeConfirmPassIcon" class="tio-visible-outlined"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" data-form-id="update-password-form"
                            data-message="{{ translate('want_to_update_vendor_password') . '?' }}"
                            class="btn btn--primary {{ env('APP_MODE') != 'demo' ? 'form-submit' : 'call-demo' }}">{{ translate('save_Changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
