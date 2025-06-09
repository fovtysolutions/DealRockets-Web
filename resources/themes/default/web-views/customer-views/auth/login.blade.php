@extends('layouts.front-end.app')

@section('title', translate('sign_in'))

@push('css_or_js')
    <link rel="stylesheet"
        href="{{ theme_asset(path: 'public/assets/front-end/plugin/intl-tel-input/css/intlTelInput.css') }}">
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/ai/customerlogin.css') }}">
@endpush

@section('content')

    <?php
    $customerManualLogin = $web_config['customer_login_options']['manual_login'] ?? 0;
    $customerOTPLogin = $web_config['customer_login_options']['otp_login'] ?? 0;
    $customerSocialLogin = $web_config['customer_login_options']['social_login'] ?? 0;
    
    if (!$customerOTPLogin && $customerManualLogin && $customerSocialLogin) {
        $multiColumn = 1;
    } elseif ($customerOTPLogin && !$customerManualLogin && $customerSocialLogin) {
        $multiColumn = 1;
    } elseif ($customerOTPLogin && $customerManualLogin && !$customerSocialLogin) {
        $multiColumn = 1;
    } elseif ($customerOTPLogin && $customerManualLogin && $customerSocialLogin) {
        $multiColumn = 1;
    } else {
        $multiColumn = 0;
    }
    ?>
    <div class="customerlogin mainpagesection" style="background-color: unset; margin-top: 22px;">
        <div class="container">
            <!-- Left Section - Red Background with Content -->
            <div class="left-section">
                <!-- Decorative elements -->
                <div class="decorative-circle"></div>
                <div class="decorative-line"></div>

                <div class="content">
                    <div class="hero-content">
                        <h1 style="font-size: 44px; color: white;">Join the Deal Rocket Community!</h1>
                        <p>Experience smarter shopping with exclusive deals and top-rated discounts. Sign up today and start
                            saving instantly!</p>
                    </div>

                    <!-- Testimonial Section -->
                    <div class="testimonial">
                        <!-- Star Rating -->
                        <div class="star-rating">
                            <svg class="star" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                            <svg class="star" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                            <svg class="star" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                            <svg class="star" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                            <svg class="star" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                        </div>

                        <!-- Testimonial Text -->
                        <blockquote>
                            "Deal Rocket makes shopping so much easier! I found the best discounts in seconds. Highly
                            recommend!"
                        </blockquote>

                        <!-- Author -->
                        <div class="author">
                            <div class="author-avatar">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                            </div>
                            <div class="author-info">
                                <div class="author-name">David B.</div>
                                <div class="author-title">Digital Marketer</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Section - Sign Up Form -->
            <div class="right-section">
                <div class="form-container">
                    <div class="form-header">
                        <h2>Welcome to Deal Rocket!</h2>
                        <p>Sign in to unlock exclusive deals, shop smarter, and save big on your favorite products!</p>
                    </div>

                    <form action="{{ route('customer.auth.login') }}"
                            method="post" id="customer-login-form">
                        @csrf

                        <input type="hidden" name="login_type" class="auth-login-type-input" value="manual-login">

                        <!-- Sign in as dropdown -->
                        <div class="form-group">
                            <label for="signInAs">Sign in as</label>
                            <div class="select-container">
                                <select id="signInAs" name="signInAs">
                                    <option value="">Select a Option</option>
                                    <option value="buyer">Buyer</option>
                                    <option value="supplier">Supplier</option>
                                    <option value="consultant">Consultant</option>
                                </select>
                                <svg class="select-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <polyline points="6,9 12,15 18,9"></polyline>
                                </svg>
                            </div>
                        </div>

                        @include("web-views.customer-views.auth.partials._email")
                        @include("web-views.customer-views.auth.partials._password")

                        <!-- Remember me and Forgot password -->
                        @include("web-views.customer-views.auth.partials._remember-me", ['forgotPassword' => true])

                        <div class="manual-login-items" style="padding-bottom: 25px;">
                            <!-- Sign Up button -->
                            <button type="submit" class="submit-btn">Sign Up</button>
                        </div>

                        <!-- Sign up link -->
                        <div class="signup-link">
                            Don't have an account?
                            <a href="{{ route('customer.auth.sign-up') }}" type="button" class="link-btn">Sign Up</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    @php($recaptcha = getWebConfig(name: 'recaptcha'))
    @if ($web_config['firebase_otp_verification'] && $web_config['firebase_otp_verification']['status'])
        <script type="text/javascript">
            "use strict";
            // console.info('Firebase Auth Rendering...');
        </script>
    @elseif(isset($recaptcha) && $recaptcha['status'] == 1)
        <script type="text/javascript">
            "use strict";
            var onloadCallback = function() {
                grecaptcha.render('recaptcha_element', {
                    'sitekey': '{{ getWebConfig(name: 'recaptcha')['site_key'] }}'
                });
            };
        </script>
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
    @endif

    @if ($web_config['firebase_otp_verification_status'])
        <script>
            $('.or-sign-in-with').css('width', $('.or-sign-in-with-row').height())
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $('#show_password').on('click', function() {
                var password_field = $('#si-password');
                var password_type = password_field.attr('type');

                if (password_type == 'password') {
                    $('#si-password').attr('type', 'text');
                } else {
                    $('#si-password').attr('type', 'password');
                }
            });
        });
    </script>
    <script src="{{ theme_asset(path: 'public/assets/front-end/plugin/intl-tel-input/js/intlTelInput.js') }}"></script>
    <script src="{{ theme_asset(path: 'public/assets/front-end/js/country-picker-init.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('signUpForm');
            const signInAsSelect = document.getElementById('signInAs');
            const fullNameInput = document.getElementById('fullName');
            const passwordInput = document.getElementById('password');
            const rememberMeCheckbox = document.getElementById('rememberMe');

            // Form data object to store current values
            const formData = {
                signInAs: '',
                fullName: '',
                password: '',
                rememberMe: false
            };

            // Handle form input changes
            function handleInputChange(field, value) {
                formData[field] = value;
                console.log('Form data updated:', formData);
            }

            // Add event listeners
            signInAsSelect.addEventListener('change', function() {
                handleInputChange('signInAs', this.value);
            });

            fullNameInput.addEventListener('input', function() {
                handleInputChange('fullName', this.value);
            });

            passwordInput.addEventListener('input', function() {
                handleInputChange('password', this.value);
            });

            rememberMeCheckbox.addEventListener('change', function() {
                handleInputChange('rememberMe', this.checked);
            });

            // Handle form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                console.log('Form submitted:', formData);

                // You can add your form submission logic here
                alert('Form submitted! Check the console for form data.');
            });

            // Handle forgot password click
            const forgotPasswordBtn = document.querySelector('.forgot-password');
            forgotPasswordBtn.addEventListener('click', function() {
                alert('Forgot password functionality would be implemented here.');
            });

            // Handle sign up link click
            const signUpLinkBtn = document.querySelector('.link-btn');
            signUpLinkBtn.addEventListener('click', function() {
                alert('Sign up page would be opened here.');
            });
        });
    </script>
@endpush
