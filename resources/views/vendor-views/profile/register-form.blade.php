@extends('layouts.back-end.app-partialseller')

@section('title', translate('profile_Settings'))
@push('css_or_js')
    <link rel="stylesheet"
        href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/intl-tel-input/css/intlTelInput.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('public/assets/custom-css/progress-form.css') }}">
    <style>
        .save-btn {
            background:rgb(29, 143, 250);
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
    <div class="content container-fluid">
        <div class="card">
            <div class="card-body progress-form-main">

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
                    method="POST" enctype="multipart/form-data" style="padding: unset;">
                    @csrf
                    @include('web-views.seller-view.auth.partial._vendor_information_fields')
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).on('submit', '#quotation-form', function(e) {
            e.preventDefault();

            let form = $('#quotation-form')[0];
            let formData = new FormData(form);

            $.ajax({
                url: "{{ route('save-vendor-details', ['sellerusers' => $sellerUsersId]) }}",
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
        $(document).on('click', '.save-btn', function(e) {
            e.preventDefault();

            let form = $('#quotation-form')[0];
            let formData = new FormData(form);

            $.ajax({
                url: "{{ route('save-vendor-details', ['sellerusers' => $sellerUsersId]) }}",
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
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/plugins/intl-tel-input/js/intlTelInput.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/country-picker-init.js') }}"></script>
    <script src="{{ theme_asset('public/js/progress-form.js') }}"></script>
@endpush
