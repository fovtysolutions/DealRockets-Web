@extends('layouts.front-end.app')

@section('title', translate('register'))

@push('css_or_js')
    <link rel="stylesheet"
        href="{{ theme_asset(path: 'public/assets/front-end/plugin/intl-tel-input/css/intlTelInput.css') }}">
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/ai/customerregister.css') }}">
@endpush

@section('content')
    <div class="customerregister mainpagesection" style="margin-top: 22px; background-color: unset;">
        <div class="d-flex flex-row">
            <!-- Left Section - Red Background with Content -->
            <div class="left-section" style="background: linear-gradient(180deg, #BF9E66 0%, #71572C 100%);">
                <!-- Decorative elements -->
                <div class="decorative-circle"></div>
                <div class="decorative-line"></div>

                <div class="content">
                    <div class="hero-content">
                        <h1 style="font-size: 44px; color: white;">Launch Your Career Journey!</h1>
                        <p>Discover amazing job opportunities and connect with top employers. Join our platform today and take the next step in your professional career!</p>
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
                            "This platform helped me land my dream job in just 3 weeks! The job matching system is incredible. Highly recommend for any job seeker!"
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
                                <div class="author-name">Sarah M.</div>
                                <div class="author-title">Software Engineer</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Section - Sign Up Form -->
            <div class="right-section">
                <div class="form-container">
                    <div class="form-header">
                        <h2>Welcome to Job Seeker's Sign Up!</h2>
                        <p>Create your account to access thousands of job opportunities, connect with employers, and advance your career!</p>
                    </div>

                    <form class="form" id="register-form" action="{{ route('customer.auth.sign-up') }}"
                        method="post">
                        @csrf
                        <!-- Role Switch -->
                        <div class="form-group">
                            {{-- <label>Sign up as</label>
                            <div class="role-buttons">
                                <button type="button" class="role-button" data-role="buyer" data-url="{{ route('customer.auth.sign-up') }}">Buyer</button>
                                <button type="button" class="role-button" data-role="supplier" data-url="{{ route('vendor.auth.registration.rest-details-seller') }}">Supplier</button>
                                <button type="button" class="role-button" data-role="consultant" data-url="{{ route('customer.auth.sign-up') }}">Consultant</button>
                            </div> --}}
                            <input type="hidden" name="signInAs" id="signInAs">
                            <input type="hidden" name="vendor_type" id="vendor_type" value="vendor">
                        </div>

                        <!-- Name -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="f_name">First Name</label>
                                <input type="text" id="f_name" name="f_name" placeholder="Enter first name">
                            </div>
                            <div class="form-group">
                                <label for="l_name">Last Name</label>
                                <input type="text" id="l_name" name="l_name" placeholder="Enter last name">
                            </div>
                        </div>

                        <!-- Email & Phone -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" placeholder="Enter your email">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" id="phone" name="phone" placeholder="Enter your phone number">
                            </div>
                        </div>

                        <!-- Password & Confirm -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" placeholder="Enter password">
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" id="confirm_password" name="con_password"
                                    placeholder="Confirm password">
                            </div>
                        </div>

                        <!-- Country -->
                        <div class="form-row">
                            <div class="form-group">
                                @php
                                    $countries = \App\Models\Country::where('blacklist', 'no')->get();
                                @endphp
                                <label for="country">Country</label>
                                <select class="form-control text-align-direction" name="country" id="country" required>
                                    <option value="" selected>Select a Option</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                {{-- <label for="preference">Preference</label> --}}
                                <select class="form-control text-align-direction d-none" name="role" id="selectedItem"
                                    required>
                                    <option value="">Select a Option</option>
                                    <option value="jobseeker" selected>Job Seeker</option>
                                </select>
                            </div>
                        </div>

                        <!-- Remember Me / Forgot -->
                        <div class="form-row" style="justify-content: space-between;">
                            <div class="checkbox-group">
                                <input type="checkbox" id="rememberMe" name="rememberMe">
                                <label for="rememberMe">Remember me</label>
                            </div>
                            <button type="button" class="forgot-password">Forgot password?</button>
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="submit-btn" style="background: rgba(191, 158, 102, 1);">Sign Up</button>

                        <!-- Already have account -->
                        <div class="signup-link">
                            Already have an account?
                            <a type="button" href="{{ route('customer.auth.jobseeker-sign-in') }}" class="link-btn" style="color: rgba(191, 158, 102, 1);">Sign In</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
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
    @endif
    <script>
        function assignrole(role) {
            var roleassigner = document.getElementById('selectedItem');
            roleassigner.value = role;
        }
        $(document).ready(function() {
            assignrole('jobseeker');
            // When either button is clicked
            $('#jobseeker, #findtalent').on('click', function() {

                // Reset both buttons' styles to the default
                $('#jobseeker').css({
                    'background-color': '#e5e7eb',
                    'color': 'black'
                });
                $('#findtalent').css({
                    'background-color': '#e5e7eb',
                    'color': 'black'
                });

                // Highlight the clicked button
                $(this).css({
                    'background-color': '#3b82f6',
                    'color': 'white'
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Toggle CV Field
            $('#jobseeker').on('click', function() {
                $('#cvfield').css('display', 'block');
            });
            $('#findtalent').on('click', function() {
                $('#cvfield').css('display', 'none');
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#show_passworduno').on('click', function() {
                var password_field = $('#si-passworduno');
                var password_type = password_field.attr('type');

                if (password_type == 'password') {
                    $('#si-passworduno').attr('type', 'text');
                } else {
                    $('#si-passworduno').attr('type', 'password');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#show_passworddos').on('click', function() {
                var password_field = $('#si-passworddos');
                var password_type = password_field.attr('type');

                if (password_type == 'password') {
                    $('#si-passworddos').attr('type', 'text');
                } else {
                    $('#si-passworddos').attr('type', 'password');
                }
            });
        });
    </script>
    <script src="{{ theme_asset(path: 'public/assets/front-end/plugin/intl-tel-input/js/intlTelInput.js') }}"></script>
    <script src="{{ theme_asset(path: 'public/assets/front-end/js/country-picker-init.js') }}"></script>
    <script>
        const roleButtons = document.querySelectorAll('.role-button');
        const roleInput = document.getElementById('signInAs');
        const formAction = document.getElementById('register-form');

        roleButtons.forEach(button => {
            button.addEventListener('click', () => {
                roleButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                roleInput.value = button.getAttribute('data-role');
                formAction.action = button.getAttribute('data-url');
                formAction.id = button.getAttribute('data-id');
            });
        });
    </script>
    <script>
        sellerForm = document.getElementById('register-form');

        var formData = new FormData(sellerForm);

        sellerForm.addEventListener('submit', function(event) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: sellerForm.action,
                data: formData,
                beforeSend: function() {
                    $("#loading").addClass("d-grid");
                },
                success: function(response) {
                    if (response.errors) {
                        for (let index = 0; index < response.errors.length; index++) {
                            toastr.error(response.errors[index].message);
                        }
                    } else if (response.error) {
                        toastr.error(response.error);
                    } else if (response.status === 1) {
                        toastr.success(response.message);
                        window.location.href = response.redirect_url;
                    } else if (response.redirect_url !== "") {
                        window.location.href = response.redirect_url;
                    }
                },
                error: function() {},
                complete: function() {
                    $("#loading").removeClass("d-grid");
                }
            });
        });
    </script>
@endpush
