@php
    use App\Enums\DemoConstant;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="_token" content="{{ csrf_token() }}">
    <title>{{ translate('vendor_Login') }}</title>
    <link rel="shortcut icon" href="{{ getStorageImages(path: getWebConfig(name: 'company_fav_icon')) }}">
    <link rel="stylesheet" href="{{ dynamicAsset(path: 'public/assets/back-end/css/google-fonts.css') }}">
    <link rel="stylesheet" href="{{ dynamicAsset(path: 'public/assets/back-end/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ dynamicAsset(path: 'public/assets/back-end/css/vendor.min.css') }}">
    <link rel="stylesheet" href="{{ dynamicAsset(path: 'public/assets/back-end/vendor/icon-set/style.css') }}">
    <link rel="stylesheet" href="{{ dynamicAsset(path: 'public/assets/back-end/css/toastr.css') }}">
    <link rel="stylesheet" href="{{ dynamicAsset(path: 'public/assets/back-end/css/theme.minc619.css?v=1.0') }}">
    <link rel="stylesheet" href="{{ dynamicAsset(path: 'public/assets/back-end/css/style.css') }}">
    <link rel="stylesheet" href="{{ dynamicAsset(path: 'public/assets/back-end/css/custom.css') }}">
</head>
<style>
    /* Default styles for all banners */
    .banner {
        position: relative;
        height: 300px;
        border-radius: 10px;
        overflow: hidden;
        /* Prevents any overflow during animation */
    }

    /* Styling for the images, ensuring aspect ratio is maintained */
    .banner img {
        object-fit: cover;
        aspect-ratio: 4/3;
        width: 100%;
        height: 100%;
    }

    .banner ul {
        list-style-type: none;
    }

    .banner h3 {
        color: white;
    }

    /* Overlay styling */
    .overlayclipped {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        /* Transparent black background */
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        animation: fadeIn 1s forwards;
        clip-path: path("M -2 -132 Q -27 173 689 609 L 0 635 Z");
        background: rgba(174, 174, 174, 0.7);
        /* Semi-transparent background */
        background: linear-gradient(45deg, #ff9b9b, #3a3aff);
    }

    /* Banner text styling */
    .banner-text {
        color: white;
        max-width: 80%;
        animation-duration: 1s;
        position: absolute;
        left: 20px;
        bottom: 117px;
    }

    /* Slide from left animation */
    @keyframes slideFromLeft {
        0% {
            transform: translateX(-100%);
            /* Start from the left */
        }

        100% {
            transform: translateX(0);
            /* End at its original position */
        }
    }

    /* Slide from right animation */
    @keyframes slideFromRight {
        0% {
            transform: translateX(100%);
            /* Start from the right */
        }

        100% {
            transform: translateX(0);
            /* End at its original position */
        }
    }

    /* Apply the slide-in animation */
    .slide-left {
        animation-name: slideFromLeft;
    }

    .slide-right {
        animation-name: slideFromRight;
    }

    /* Fade-in effect for the overlay */
    @keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    /* Make sure the banners have visibility control */
    .d-none {
        display: none !important;
    }
</style>

<body>
    <main id="content" role="main" class="main">
        <div class="row">
            <div class="col-12 position-fixed z-9999 mt-10rem">
                <div id="loading" class="d--none">
                    <div id="loader"></div>
                </div>
            </div>
        </div>
        <div class="position-fixed top-0 right-0 left-0 bg-img-hero __h-32rem">
            <figure class="position-absolute right-0 bottom-0 left-0">
                <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                    viewBox="0 0 1921 273">
                    <polygon fill="#fff" points="0,273 1921,273 1921,0 " />
                </svg>
            </figure>
        </div>
        <div class="container py-5 py-sm-7">
            @php($companyWebLogo = getWebConfig(name: 'company_web_logo'))
            <a class="d-flex justify-content-center mb-5" href="{{ route('home') }}">
                <img class="z-index-2" height="40"
                    src="{{ getStorageImages(path: $companyWebLogo, type: 'backend-logo') }}"
                    alt="{{ translate('logo') }}">
            </a>
            <div class="row justify-content-center">
                <div class="vendor-suspend suspended-message d-none">
                    <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/warning.png') }}" alt="">
                    <div class="cont">
                        <h6>{{ translate('warning') }}</h6>
                        <div>
                            {{ translate('your_account_has_been_suspended') . ', ' . translate('please_contact_with') }}
                            <a href="{{ route('contacts') }}">{{ translate('help_and_support') }}</a>
                        </div>
                    </div>
                    <button class="p-2 m-0 border-0 outlie-0 shadow-none bg-transparent clear-alter-message">
                        <i class="tio-clear"></i>
                    </button>
                </div>
                <div class="vendor-suspend pending-message d-none">
                    <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/warning.png') }}" alt="">
                    <div class="cont">
                        <h6>{{ translate('warning') }}</h6>
                        <div>
                            {{ translate('your_account_is_not_approved_yet') . ', ' . translate('please_wait_or_contact_with') }}
                            <a href="{{ route('contacts') }}">{{ translate('help_and_support') }}</a>
                        </div>
                    </div>
                    <button class="p-2 m-0 border-0 outlie-0 shadow-none bg-transparent clear-alter-message">
                        <i class="tio-clear"></i>
                    </button>
                </div>
                <div class="w-90 flex-row d-flex">
                    <div id="buyerBanner" class="d-none banner buyer-banner mr-4 h-100" style="width:60%;">
                        <div class="overlayclipped">
                            <div class="banner-text slide-left">
                                <h3>{{ translate('For Buyers') }}</h3>
                                <ul class="pl-0">
                                    <li>{{ translate('Sign up and get access to 1000+ suppliers') }}</li>
                                    <li>{{ translate('Trade leads') }}</li>
                                    <li>{{ translate('Bulk stock and trade shows') }}</li>
                                </ul>
                            </div>
                        </div>
                        <img src="/storage/{{ $vendorsetting['ad1_image'] ?? '' }}"
                            onerror="this.onerror=null; this.src='/images/placeholderimage.webp';" alt="For Buyers">
                    </div>

                    <div id="supplierBanner" class="d-none banner supplier-banner mr-4 h-100" style="width:60%;">
                        <div class="overlayclipped">
                            <div class="banner-text slide-right">
                                <h3>{{ translate('For Suppliers') }}</h3>
                                <ul class="pl-0">
                                    <li>{{ translate('Sign up and get access to 1000+ buy leads') }}</li>
                                    <li>{{ translate('Sell your hot products') }}</li>
                                    <li>{{ translate('Sell your bulk stock quickly') }}</li>
                                </ul>
                            </div>
                        </div>
                        <img src="/storage/{{ $vendorsetting['ad2_image'] ?? '' }}"
                            onerror="this.onerror=null; this.src='/images/placeholderimage.webp';" alt="For Suppliers">
                    </div>
                    <div class="card card-lg" style="width:38%;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-4">
                                <button type="button" class="btn btn-primary"
                                    id="buyerBtn">{{ translate('Buyer') }}</button>
                                <button type="button" class="btn btn-secondary"
                                    id="supplierBtn">{{ translate('Supplier') }}</button>
                                <a href="{{ route('customer.auth.sign-up') }}" class="btn btn-info"
                                    id="consultantBtn">{{ translate('Consultant') }}</a>
                            </div>
                            <form action="{{ route('vendor.auth.login') }}" method="post" id="vendor-login-form">
                                @csrf
                                <div class="text-center">
                                    <div class="mb-5">
                                        <h1 class="display-4">{{ translate('sign_in') }}</h1>
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">
                                                {{ translate('welcome_back_to_vendor_login') }}
                                            </h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="js-form-message form-group">
                                    <label class="input-label"
                                        for="signingVendorEmail">{{ translate('your_email') }}</label>
                                    <input type="email" class="form-control form-control-lg" name="email"
                                        id="signingVendorEmail" tabindex="1" placeholder="email@address.com"
                                        aria-label="email@address.com" required
                                        data-msg="Please enter a valid email address.">
                                </div>
                                <div class="js-form-message form-group">
                                    <label class="input-label" for="signingVendorPassword" tabindex="0">
                                        <span class="d-flex justify-content-between align-items-center">
                                            {{ translate('password') }}
                                            <a href="{{ route('vendor.auth.forgot-password.index') }}">
                                                {{ translate('forgot_password') }}
                                            </a>
                                        </span>
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="js-toggle-password form-control form-control-lg"
                                            name="password" id="signingVendorPassword"
                                            placeholder="8+ characters required" aria-label="8+ characters required"
                                            required data-msg="Your password is invalid. Please try again."
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
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="termsCheckbox"
                                            name="remember">
                                        <label class="custom-control-label text-muted user-select-none"
                                            for="termsCheckbox">
                                            {{ translate('remember_me') }}
                                        </label>
                                    </div>
                                </div>
                                @if (isset($recaptcha) && $recaptcha['status'] == 0)
                                    {{-- Do Nothing --}}
                                @elseif(isset($recaptcha) && $recaptcha['status'] == 1)
                                    <div id="recaptcha_element" class="w-100" data-type="image"></div>
                                    <br />
                                @else
                                    <div class="row py-2">
                                        <div class="col-6 pr-0">
                                            <input type="text" class="form-control form-control-lg form-control-focus-none"
                                                name="vendorRecaptchaKey" value="" id="vendor-login-recaptcha-input"
                                                placeholder="{{ translate('enter_captcha_value') }}" autocomplete="off">
                                        </div>
                                        <div class="col-6 input-icons bg-white rounded">
                                            <a class="get-login-recaptcha-verify cursor-pointer get-session-recaptcha-auto-fill"
                                                data-link="{{ URL('/vendor/auth/recaptcha') }}"
                                                data-session="{{ 'vendorRecaptchaSessionKey' }}"
                                                data-input="#vendor-login-recaptcha-input">
                                                <img src="{{ URL('/vendor/auth/recaptcha/1?captcha_session_id=vendorRecaptchaSessionKey') }}"
                                                    alt="" class="input-field w-90 h-75 p-0 rounded"
                                                    id="default_recaptcha_id">
                                                <i class="tio-refresh icon"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                <button type="button"
                                    class="btn btn-lg btn-block btn--primary submit-login-form">{{ translate('login') }}</button>
                            </form>
                        </div>
                        @if (env('APP_MODE') == 'demo')
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-10">
                                        <span id="vendor-email"
                                            data-email="{{ DemoConstant::VENDOR['email'] }}">{{ translate('email') }}
                                            : {{ DemoConstant::VENDOR['email'] }}</span><br>
                                        <span id="vendor-password"
                                            data-password="{{ DemoConstant::VENDOR['password'] }}">{{ translate('password') }}
                                            : {{ DemoConstant::VENDOR['password'] }}</span>
                                    </div>
                                    <div class="col-2">
                                        <button class="btn btn--primary" id="copyLoginInfo"><i class="tio-copy"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
    <span id="message-please-check-recaptcha" data-text="{{ translate('please_check_the_recaptcha') }}"></span>
    <span id="message-copied_success" data-text="{{ translate('copied_successfully') }}"></span>

    <span id="route-get-session-recaptcha-code" data-route="{{ route('get-session-recaptcha-code') }}"
        data-mode="{{ env('APP_MODE') }}"></span>
    <script>
        // Script to toggle banners based on button clicks
        document.getElementById('buyerBtn').addEventListener('click', function () {
            showBanner('buyerBanner');
        });
        document.getElementById('supplierBtn').addEventListener('click', function () {
            showBanner('supplierBanner');
        });

        function showBanner(bannerId) {
            // Hide all banners
            document.querySelectorAll('.banner').forEach(function (banner) {
                banner.classList.add('d-none');
            });

            // Show the selected banner
            document.getElementById(bannerId).classList.remove('d-none');
        }
        showBanner('buyerBanner');
    </script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/vendor.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/theme.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/toastr.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/vendor/login.js') }}"></script>
    {!! Toastr::message() !!}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const wideBannerTexts = document.querySelectorAll('.overlayclipped');

            wideBannerTexts.forEach(element => {
                // Generate two random, visually appealing colors
                const randomColor1 = `hsl(${Math.floor(Math.random() * 360)}, 70%, 40%)`; // Darker hue
                const randomColor2 =
                    `hsl(${Math.floor(Math.random() * 360)}, 70%, 50%)`; // Medium-light hue

                // Set the linear gradient as the background
                element.style.background = `linear-gradient(45deg, ${randomColor1}, ${randomColor2})`;
            });
        });
    </script>
    @if (isset($recaptcha) && $recaptcha['status'] == 1)
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
        <script type="text/javascript">
            "use strict";
            var onloadCallback = function () {
                grecaptcha.render('recaptcha_element', {
                    'sitekey': '{{ getWebConfig(name: 'recaptcha', )['site_key'] }}'
                });
            };
        </script>
    @endif
</body>

</html>