@extends('layouts.front-end.app')

@section('title', translate('sign_in'))

@push('css_or_js')
    <link rel="stylesheet"
        href="{{ theme_asset(path: 'public/assets/front-end/plugin/intl-tel-input/css/intlTelInput.css') }}">
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/ai/customerlogin.css') }}">
    <style>
        .btn-group-toggle {
            display: flex;
            gap: 10px;
            margin-top: 5px;
        }

        .role-btn {
            padding: 10px 20px;
            border: 1px solid #ccc;
            background-color: #f4f4f4;
            cursor: pointer;
            flex: 1;
            border-radius: 4px;
            transition: background-color 0.2s, border-color 0.2s;
        }

        .role-btn.active {
            background-color: #fa3030;
            color: white;
            border-color: #fa3030;
        }
    </style>
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

                    <form action="{{ route('customer.auth.login') }}" method="post" id="customer-login-form">
                        @csrf

                        <input type="hidden" name="login_type" class="auth-login-type-input" value="manual-login">

                        <!-- Sign in as dropdown -->
                        <div class="form-group">
                            <label for="signInAs">Sign in as</label>
                            <div class="btn-group-toggle" id="signInAsToggle" role="group" aria-label="Sign in as">
                                <button type="button" class="role-btn" data-value="buyer">Buyer</button>
                                <button type="button" class="role-btn" data-value="supplier">Supplier</button>
                                <button type="button" class="role-btn" data-value="consultant">Consultant</button>
                            </div>
                            <input type="hidden" name="signInAs" id="signInAs" />
                        </div>


                        @include('web-views.customer-views.auth.partials._email')
                        @include('web-views.customer-views.auth.partials._password')

                        <!-- Remember me and Forgot password -->
                        @include('web-views.customer-views.auth.partials._remember-me', [
                            'forgotPassword' => true,
                        ])

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
        var form = $('#customer-login-form');
        $('#signInAs').on('change', function() {
            if (this.value == 'buyer') {
                form.attr('action', "{{ route('customer.auth.login') }}");
            } else if (this.value == 'supplier') {
                form.attr('action', "{{ route('vendor.auth.login') }}");
            } else if (this.value == 'consultant') {
                form.attr('action', "{{ route('customer.auth.login') }}");
            } else {
                form.attr('action', '#');
            }
        });
    </script>
    <script>
        document.querySelectorAll('.role-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all
                document.querySelectorAll('.role-btn').forEach(btn => btn.classList.remove('active'));

                // Add to the clicked one
                this.classList.add('active');

                // Update hidden input value
                document.getElementById('signInAs').value = this.getAttribute('data-value');
            });
        });
    </script>
@endpush
