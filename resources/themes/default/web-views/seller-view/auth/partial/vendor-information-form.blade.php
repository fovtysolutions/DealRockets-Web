@extends('layouts.front-end.app')

@section('title', translate('Info Page'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ theme_asset('public/assets/custom-css/progress-form.css') }}">
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
                <div class="step-section" data-step="1">
                    <h4>Shop Information</h4>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" value="{{ $email }}">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" value="{{ $phone }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="text" name="password" value="{{ $password }}" readonly>
                            <input type="hidden" name="confirm_password" value="{{ $confirm_password }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="shop_years"
                                class="title-color d-flex gap-1 align-items-center">{{ translate('Years in Business') }}</label>
                            <input type="number" class="form-control form-control-user" id="shop_years" name="shop_years"
                                placeholder="{{ translate('ex') . ':' . translate('2') }}" value="{{ old('shop_years') }}"
                                required>
                            <input type="hidden" name="vendor_type" value="{{ $vendor_type }}" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="f_name" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="l_name" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image" accept="image/*" required>
                        </div>
                        <div class="form-group">
                            <label for="store_name" class="text-capitalize">{{ translate('shop_Name') }} <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="shop_name" name="shop_name"
                                placeholder="{{ translate('Ex: XYZ store') }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="store_address" class="text-capitalize">{{ translate('shop_address') }} <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" name="shop_address" id="shop_address" rows="1"
                                placeholder="{{ translate('shop_address') }}" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="shop_membership"
                                class="title-color d-flex gap-1 align-items-center">{{ translate('Membership') }}</label>
                            <select class="form-control form-control-user" id="shop_membership" name="shop_membership"
                                required>
                                <option value="Free" selected>{{ translate('Free') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group border p-3 p-xl-4 rounded">
                            <div class="d-flex flex-column gap-3 align-items-center">
                                <div class="upload-file">
                                    <input type="file" name="logo" accept="image/*" required>
                                </div>

                                <div class="d-flex flex-column gap-1 upload-img-content text-center">
                                    <h6 class="text-uppercase mb-1 fs-14">{{ translate('upload_logo') }}</h6>
                                    <div class="text-muted text-capitalize fs-12">
                                        {{ translate('image_ratio') . ' ' . '1:1' }}</div>
                                    <div class="text-muted text-capitalize fs-12">
                                        {{ translate('Image Size : Max 2 MB') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group border p-3 p-xl-4 rounded">
                            <div class="d-flex flex-column gap-3 align-items-center">
                                <div class="upload-file">
                                    <input type="file" name="banner" accept="image/*" required>
                                </div>

                                <div class="d-flex flex-column gap-1 upload-img-content text-center">
                                    <h6 class="text-uppercase mb-1 fs-14">{{ translate('upload_banner') }}</h6>
                                    <div class="text-muted text-capitalize fs-12">
                                        {{ translate('image_ratio') . ' ' . '2:1' }}</div>
                                    <div class="text-muted text-capitalize fs-12">
                                        {{ translate('Image Size : Max 2 MB') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="next-btn" data-next="2">Next</button>
                </div>
                <!-- Step 1: Company Information -->
                <div class="step-section d-none" data-step="2">
                    <h4>Company Information</h4>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Company Name</label>
                            <input type="text" name="company_name" required>
                        </div>
                        <div class="form-group">
                            <label>Registered Business Name</label>
                            <input type="text" name="registered_name">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Type of Business</label>
                            <select name="business_type" required>
                                <option value="">Select</option>
                                <option value="manufacturer">Manufacturer</option>
                                <option value="trader">Trader</option>
                                <option value="exporter">Exporter</option>
                                <option value="service">Service</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Main Products / Services</label>
                            <textarea name="main_products" placeholder="List comma-separated or use bullet points" rows="1" required></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Year of Establishment</label>
                            <input type="text" name="establishment_year" pattern="\d{4}" maxlength="4" required>
                        </div>
                        <div class="form-group">
                            <label>Business Registration Number</label>
                            <input type="text" name="registration_number" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Country of Registration</label>
                            <input type="text" name="registration_country" required>
                        </div>
                        <div class="form-group">
                            <label>GST / VAT / TAX ID</label>
                            <input type="text" name="tax_id" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Tax Expiry Date</label>
                            <input type="date" name="tax_expiry">
                        </div>
                        <div class="form-group">
                            <label>Industry Category</label>
                            <select name="industry" required>
                                <option value="">Select Industry</option>
                                <option value="agri">Agriculture</option>
                                <option value="food">Food</option>
                                <option value="fmcg">FMCG</option>
                                <!-- Add more as needed -->
                            </select>
                        </div>
                    </div>

                    <button type="button" class="prev-btn" data-prev="1">Previous</button>
                    <button type="button" class="next-btn" data-next="3">Next</button>
                </div>

                <!-- Step 2: Office & Contact Details -->
                <div class="step-section d-none" data-step="3">
                    <h4>Office & Contact Details</h4>

                    <div class="form-row">
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="city" required>
                        </div>
                        <div class="form-group">
                            <label>State</label>
                            <input type="text" name="state" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Country</label>
                            <input type="text" name="country" required>
                        </div>
                        <div class="form-group">
                            <label>Postal / ZIP Code</label>
                            <input type="text" name="zip_code" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Website URL</label>
                            <input type="url" name="website_url">
                        </div>
                        <div class="form-group">
                            <label>Company Phone Number</label>
                            <input type="tel" name="company_phone" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Head Office Address</label>
                            <textarea name="office_address" required rows="1"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Company Email Address</label>
                            <input type="email" name="company_email" required>
                        </div>
                    </div>

                    <button type="button" class="prev-btn" data-prev="2">Back</button>
                    <button type="button" class="next-btn" data-next="4">Next</button>
                </div>

                <!-- Step 3: Contact Person -->
                <div class="step-section d-none" data-step="4">
                    <h4>Contact Person</h4>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Contact Person Name</label>
                            <input type="text" name="contact_name" required>
                        </div>
                        <div class="form-group">
                            <label>Designation</label>
                            <input type="text" name="designation" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Mobile Number (WhatsApp preferred)</label>
                            <input type="tel" name="mobile_number" required>
                        </div>
                        <div class="form-group">
                            <label>Email ID</label>
                            <input type="email" name="contact_email" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-single">
                            <label>Alternative Contact (Optional)</label>
                            <input type="text" name="alt_contact">
                        </div>
                    </div>

                    <button type="button" class="prev-btn" data-prev="3">Back</button>
                    <button type="button" class="next-btn" data-next="5">Next</button>
                </div>

                <!-- Step 4: Banking Details -->
                <div class="step-section d-none" data-step="5">
                    <h4>Banking Details</h4>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Bank Name</label>
                            <input type="text" name="bank_name" required>
                        </div>

                        <div class="form-group">
                            <label>Bank Account Name</label>
                            <input type="text" name="bank_account_name" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Account Number / IBAN</label>
                            <input type="text" name="iban" required>
                        </div>
                        <div class="form-group">
                            <label>SWIFT / BIC Code</label>
                            <input type="text" name="swift_code">
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="form-group">
                            <label>Bank Address</label>
                            <input type="text" name="bank_address" required>
                        </div>
                        <div class="form-group">
                            <label>Currency Accepted</label>
                            <input type="text" name="currency_accepted" placeholder="USD, AED, EUR" required>
                        </div>
                    </div>

                    <button type="button" class="prev-btn" data-prev="4">Back</button>
                    <button type="button" class="next-btn" data-next="6">Next</button>
                </div>


                <!-- Step 5: Branches & Global Presence -->
                <div class="step-section d-none" data-step="6">
                    <h4>Branches & Global Presence</h4>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Local Branches</label>
                            <textarea name="local_branches" placeholder="List with city, address, and contact" rows="1"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Overseas Offices / Branches</label>
                            <textarea name="overseas_offices" placeholder="Country and contact person details" rows="1"></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Export Countries</label>
                            <input type="text" name="export_countries" placeholder="e.g., UAE, India, Germany">
                        </div>

                        <div class="form-group">
                            <label>Warehousing Locations (if any)</label>
                            <input type="text" name="warehousing_locations" placeholder="Country and City">
                        </div>
                    </div>

                    <button type="button" class="prev-btn" data-prev="5">Back</button>
                    <button type="button" class="next-btn" data-next="7">Next</button>
                </div>
                <!-- Step 6: Business Documentation -->
                <div class="step-section d-none" data-step="7">
                    <h4>Business Documentation</h4>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Business License / Registration (PDF, JPG)</label>
                            <input type="file" name="business_license" accept=".pdf,.jpg,.jpeg,.png" required>
                        </div>

                        <div class="form-group">
                            <label>Tax Certificate (PDF)</label>
                            <input type="file" name="tax_certificate" accept=".pdf" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Import/Export License (if any) (PDF)</label>
                            <input type="file" name="import_export_license" accept=".pdf">
                        </div>

                        <div class="form-group">
                            <label>Bank Account Proof / Cancelled Cheque</label>
                            <input type="file" name="bank_proof" accept=".pdf,.jpg,.jpeg,.png" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Top Authority ID (National ID / Passport - optional)</label>
                            <input type="file" name="authority_id" accept=".pdf">
                        </div>

                        <div class="form-group">
                            <label>Name of the Person & Designation</label>
                            <input type="text" name="person_name_designation" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Contact</label>
                            <input type="text" name="person_contact" required>
                        </div>
                        <div class="form-group">
                            <label>Email ID</label>
                            <input type="email" name="person_email" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-single">
                            <label>Upload Business Card (optional)</label>
                            <input type="file" name="business_card" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                    </div>

                    <button type="button" class="prev-btn" data-prev="6">Back</button>
                    <button type="button" class="next-btn" data-next="8">Next</button>
                </div>
                <!-- Step 7: Declarations -->
                <div class="step-section d-none" data-step="8">
                    <h4>Declarations</h4>

                    <div class="form-row">
                        <div class="checkbox-group">
                            <input type="checkbox" name="is_operational" required>
                            <label>Business is operational and
                                active</label>
                        </div>

                        <div class="checkbox-group">
                            <input type="checkbox" name="info_verified" required>
                            <label> The information provided is true
                                and
                                verified</label>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <div class="checkbox-group">
                                <input type="checkbox" name="authorized_consent" required><label> I am an authorized
                                    representative of the company</label>
                            </div>
                            <input type="text" name="authorized_name" placeholder="Name of Authorized Person"
                                required>
                        </div>

                        <div class="form-group">
                            <label>Upload Signature (Optional)</label>
                            <input type="file" name="signature" accept=".jpg,.jpeg,.png,.pdf">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Company Profile Images (3 images only)</label>
                            <input type="file" name="company_images[]" accept=".jpg,.jpeg,.png" multiple required>
                        </div>

                        <div class="form-group">
                            <label>Factory/Warehouse Images (3 images only)</label>
                            <input type="file" name="factory_images[]" accept=".jpg,.jpeg,.png" multiple>
                        </div>
                    </div>
                    <button type="button" class="prev-btn" data-prev="7">Back</button>
                    <button type="button" onclick="submitRegistrationVendor()" class="submit-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
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
    <script src="{{ theme_asset('public/js/progress-form.js') }}"></script>
@endpush
