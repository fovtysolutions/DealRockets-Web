@extends('layouts.front-end.app')

@section('title', translate('vendor_Apply'))

@push('css_or_js')
    <link href="{{ theme_asset(path: 'public/assets/back-end/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ theme_asset(path: 'public/assets/back-end/css/croppie.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet"
        href="{{ theme_asset(path: 'public/assets/front-end/plugin/intl-tel-input/css/intlTelInput.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('public/assets/custom-css/ai/vendor.css') }}" />
@endpush


@section('content')
    <form id="seller-registration" action="{{ route('vendor.auth.registration.index') }}" method="POST"
        enctype="multipart/form-data" class="vendor-box" style="max-width: 1440px; margin: 0 auto;">

        @csrf
        <div style="margin-top: 20px;">
            <div class="first-el vendor-box">
                <section>
                    <div class="d-flex flex-row" style="max-width: 1440px; margin: 0 auto;">
                        <div class="left-image"></div>
                        <div class="form-section">
                            <div class="form-container">
                                <div class="toggle-buttons">
                                    <button type="button" class="btn btn-active" id="vendor"
                                        value="vendor">Vendor</button>
                                    <button type="button" class="btn " id="supplier" value="supplier">Supplier</button>
                                </div>

                                <h4 class="mb-1">Create an Account</h4>
                                <p class="text-muted mb-2">You can reach us anytime via <a
                                        href="mailto:info@dealrocket.com">info@dealrocket.com</a></p>

                                <input name="vendor_type" id="vendor_type" value="vendor" type="hidden" />
                                <div class="mb-2">
                                    <label class="form-label">Email</label>
                                    <div class="icon-input">
                                        <!-- <i class="bi bi-envelope"></i> -->
                                        <input type="email" id="email" name="email" class="form-control"
                                            placeholder="Your Email">
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Phone number</label>
                                    <div class="icon-input">
                                        <!-- <i class="bi bi-telephone"></i> -->
                                        <input type="tel" name="phone" class="form-control"
                                            placeholder="US +1 (555) 000-0000">
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Password</label>
                                    <div class="icon-input">
                                        <!-- <i class="bi bi-lock"></i> -->
                                        <input name="password" type="password" id="password" class="form-control"
                                            placeholder="Minimum 8 Character Long">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <div class="icon-input">
                                        <!-- <i class="bi bi-lock-fill"></i> -->
                                        <input name="confirm_password" type="password" id="confirm_password"
                                            class="form-control" placeholder="Confirm Password">
                                    </div>
                                </div>

                                <button class="btn btn-submit mb-2 proceed-to-next-btn text-capitalize" type="button">Get
                                    started</button>

                                <p class=" text-muted">Create your own store. Already have store? <a
                                        href="{{ route('vendor.auth.login') }}">Sign
                                        In</a></p>
                            </div>
                        </div>
                    </div>
                </section>
                @include('web-views.seller-view.auth.partial.why-with-us')
                @include('web-views.seller-view.auth.partial.business-process')
                @include('web-views.seller-view.auth.partial.faq')
            </div>
        </div>
        @include('web-views.seller-view.auth.partial.vendor-information-form')
    </form>


    <div class="modal fade registration-success-modal" tabindex="-1" aria-labelledby="toggle-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header border-0 pb-0 d-flex justify-content-end">
                    <button type="button" class="btn-close border-0" data-dismiss="modal" aria-label="Close"><i
                            class="tio-clear"></i></button>
                </div>
                <div class="modal-body px-4 px-sm-5 pt-0">
                    <div class="d-flex flex-column align-items-center text-center gap-2 mb-2">
                        <img src="{{ theme_asset(path: 'public/assets/front-end/img/congratulations.png') }}" width="70"
                            class="mb-3 mb-20" alt="">
                        <h5 class="modal-title">{{ translate('congratulations') }}</h5>
                        <div class="text-center">
                            {{ translate('your_registration_is_successful') . ', ' . translate('please-wait_for_admin_approval') . '.' . translate(' you’ll_get_a_mail_soon') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <span id="get-confirm-and-cancel-button-text" data-sure ="{{ translate('are_you_sure') . '?' }}"
        data-message="{{ translate('want_to_apply_as_a_vendor') . '?' }}" data-confirm="{{ translate('yes') }}"
        data-cancel="{{ translate('no') }}"></span>
    <span id="proceed-to-next-validation-message" data-mail-error="{{ translate('please_enter_your_email') . '.' }}"
        data-phone-error="{{ translate('please_enter_your_phone_number') . '.' }}"
        data-valid-mail="{{ translate('please_enter_a_valid_email_address') . '.' }}"
        data-enter-password="{{ translate('please_enter_your_password') . '.' }}"
        data-enter-confirm-password="{{ translate('please_enter_your_confirm_password') . '.' }}"
        data-password-not-match="{{ translate('passwords_do_not_match') . '.' }}">
    </span>
@endsection

@push('script')

    @if ($web_config['recaptcha']['status'] == '1')
        <script type="text/javascript">
            "use strict";
            var onloadCallback = function() {
                let reg_id = grecaptcha.render('recaptcha-element-vendor-register', {
                    'sitekey': '{{ $web_config['recaptcha']['site_key'] }}'
                });
                $('#recaptcha-element-vendor-register').attr('data-reg-id', reg_id);
            };
        </script>
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const vendorTypeInput = document.getElementById('vendor_type');
            const vendorButton = document.getElementById('vendor');
            const supplierButton = document.getElementById('supplier');

            function toggleActive(button, type) {
                vendorTypeInput.value = type;

                // Toggle classes
                vendorButton.classList.remove('btn-active');
                supplierButton.classList.remove('btn-active');

                button.classList.add('btn-active');
            }

            vendorButton.addEventListener('click', function() {
                toggleActive(this, 'vendor');
            });

            supplierButton.addEventListener('click', function() {
                toggleActive(this, 'supplier');
            });
        });

        function togglePasswordVisibility(inputId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIndicator = passwordInput.nextElementSibling.querySelector('.password-toggle-indicator');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIndicator.classList.remove('tio-hidden');
                toggleIndicator.classList.add('tio-visible'); // Replace with the "eye-open" icon class
            } else {
                passwordInput.type = 'password';
                toggleIndicator.classList.remove('tio-visible');
                toggleIndicator.classList.add('tio-hidden'); // Replace with the "eye-closed" icon class
            }
        }
    </script>
    <script>
        $('#vendor-apply-submit').on('click', function() {
            @if ($web_config['recaptcha']['status'] == '1')
                var response = grecaptcha.getResponse($('#recaptcha-element-vendor-register').attr('data-reg-id'));
                if (response.length === 0) {
                    toastr.error("{{ translate('please_check_the_recaptcha') }}");
                } else {
                    submitRegistration();
                }
            @else
                submitRegistration();
            @endif
        });
    </script>
    <script src="{{ theme_asset(path: 'public/assets/front-end/plugin/intl-tel-input/js/intlTelInput.js') }}"></script>
    <script src="{{ theme_asset(path: 'public/assets/front-end/js/country-picker-init.js') }}"></script>
    <script src="{{ theme_asset(path: 'public/assets/front-end/js/vendor-registration.js') }}"></script>
@endpush
