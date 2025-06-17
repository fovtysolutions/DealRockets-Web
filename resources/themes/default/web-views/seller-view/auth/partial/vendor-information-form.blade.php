@extends('layouts.front-end.app')

@section('title', translate('Info Page'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ theme_asset('public/assets/custom-css/progress-form.css') }}">
    <style>
        .save-btn {
            background: #ef4444;
            color: white;
            border: none;
            padding: 12px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
            min-width: 120px;
        }
    </style>
@endpush

@section('content')
    <div class="second-el progress-form-main">
        <div class="container">
            <!-- Progress Steps -->
            <div class="progress-container">
                <div class="step active">
                    <div class="step-circle">1</div>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-circle">2</div>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-circle">3</div>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-circle">4</div>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-circle">5</div>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-circle">6</div>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-circle">7</div>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-circle">8</div>
                </div>
            </div>

            <!-- Form Header -->
            <div class="form-header">
                <h1>Vendor Registration</h1>
                <p>Fill in the required details to get started</p>
            </div>

            <form id="quotation-form" class="quotation-form" action="{{ route('vendor.auth.registration.index') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @include('web-views.seller-view.auth.partial._vendor_information_fields')
            </form>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).on('click', '.save-btn', function(e) {
            e.preventDefault();

            let form = $('#quotation-form')[0];
            let formData = new FormData(form);

            $.ajax({
                url: "{{ route('save-vendor-details',['sellerusers' => $sellerUsersId]) }}",
                method: "POST",
                data: formData,
                processData: false, // Important for file upload
                contentType: false, // Important for file upload
                success: function(response) {
                    toastr.success('Details saved successfully.');
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON?.errors;
                    if (errors) {
                        Object.values(errors).forEach(function(errorMessages) {
                            toastr.error(errorMessages[0]); // Show first error per field
                        });
                    } else {
                        toastr.error('Server error occurred.');
                    }
                }
            });
        });
    </script>
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
            submitRegistration();
        });
    </script>
    <script src="{{ theme_asset(path: 'public/assets/front-end/plugin/intl-tel-input/js/intlTelInput.js') }}"></script>
    <script src="{{ theme_asset(path: 'public/assets/front-end/js/country-picker-init.js') }}"></script>
    <script src="{{ theme_asset(path: 'public/assets/front-end/js/vendor-registration.js') }}"></script>
    <script src="{{ theme_asset('public/js/progress-form.js') }}"></script>
@endpush
