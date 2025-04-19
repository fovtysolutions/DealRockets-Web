@extends('layouts.front-end.app')

@section('title', translate('contact_us'))

@push('css_or_js')
    <link rel="stylesheet"
        href="{{ theme_asset(path: 'public/assets/front-end/plugin/intl-tel-input/css/intlTelInput.css') }}">
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/ai/contact-us.css') }}">
@endpush

@section('content')
    <section class="mainpagesection contact-page" style="background-color: unset;">
        <div class="container contact-form">

            <div class="main-content justify-center" style="justify-content: center;">

                <!-- RFQ Section -->
                <div class="get-in-touch d-flex justify-center">

                    <div class="contact-us-form">
                        <form class="rfq-form remove" style="text-align: center;">
                            <div>
                                <p class="contact-us">Contact us</p>
                                <h2 class="get-head">Get in touch</h2>
                                <p class="get-para">We’d love to hear from you. Please fill out this form.</p>
                            </div>


                            <div class="quantity-row">
                                <div class="d-flex contact-input-div">
                                    <label class="contact-label">First Name</label>
                                    <input class="contact-input form-control" type="text" placeholder="First Name"
                                        required>
                                </div>
                                <div class="d-flex contact-input-div">
                                    <label class="contact-label">Last Name</label>
                                    <input class="contact-input form-control" type="text" placeholder="Last Name"
                                        required>
                                </div>

                            </div>
                            <div class="">
                                <div class="d-flex contact-input-div">
                                    <label class="contact-label">Email</label>
                                    <input class="contact-input form-control" type="email" placeholder="Email" required>
                                </div>


                            </div>

                            <div class="">
                                <div class=" d-flex contact-input-div " style="position: relative; text-align: left;">
                                    <label for="phone" class="contact-input form-label fw-bold">Phone Number</label>
                                    <!-- NOTE: only one `type` attribute, and it’s "tel" -->
                                    <div class="d-flex align-items-center">
                                        <select id="countryCode" class="form-select me-2 p-0" style="max-width: 55px;height: 34px;">
                                            <option value="+1">USA</option>
                                            <option value="+44">UK</option>
                                            <option value="+91">Ind</option>
                                        </select>
                                        <input id="phone" type="tel" class="form-control contact-input" placeholder="Enter phone number" required />
                                    </div>
                                </div>
                                <!-- <div  class="d-flex contact-input-div">
                    <label class="contact-label">Phone Number</label>
                    <input id="phone" type="tel" class="contact-input" type="number" placeholder="Number" required>
                </div> -->
                            </div>
                            <div class="">
                                <div class="d-flex contact-input-div">
                                    <label class="contact-label">Message</label>
                                    <textarea class="contact-textarea form-control" type="text" placeholder="" required></textarea>
                                </div>
                            </div>

                            <div class=" quantity-row">
                                <input class="" type="checkbox" value="" id="flexCheckDefault"
                                    style="width: auto;">
                                <label class="contact-label m-0" for="flexCheckDefault">
                                    You agree to our friendly <a href="#" class="policy-link">privacy policy.

                                    </a>
                                </label>
                            </div>
                            <button type="submit" class="submit-rfq " style="background: #FE4E44 !important;">Send
                                Mesage</button>
                        </form>
                    </div>
                </div>
            </div>
    </section>
@endsection


@push('script')
    <script src="{{ theme_asset(path: 'public/js/contact-us.js') }}"></script>
    @if (isset($recaptcha) && $recaptcha['status'] == 1)
        <script type="text/javascript">
            "use strict";
            var onloadCallback = function() {
                grecaptcha.render('recaptcha_element', {
                    'sitekey': '{{ getWebConfig(name: 'recaptcha')['site_key'] }}'
                });
            };
        </script>
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
        <script>
            "use strict";
            $("#getResponse").on('submit', function(e) {
                var response = grecaptcha.getResponse();
                if (response.length === 0) {
                    e.preventDefault();
                    toastr.error($('#message-please-check-recaptcha').data('text'));
                }
            });
        </script>
    @endif

    <script src="{{ theme_asset(path: 'public/assets/front-end/plugin/intl-tel-input/js/intlTelInput.js') }}"></script>
    <script src="{{ theme_asset(path: 'public/assets/front-end/js/country-picker-init.js') }}"></script>
@endpush
