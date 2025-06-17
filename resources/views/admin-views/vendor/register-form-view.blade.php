@extends('layouts.back-end.app-partial')

@section('title', translate('Vendor Register Forms'))

@section('content')
    <div class="content container-fluid text-start">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">{{ translate('Register Form Information') }}</h4>
            </div>
            <div class="card-body">
                <h4 class="mb-4">{{ translate('Shop Information') }}</h4>
                <div class="row g-4">
                    <x-preview-field label="Email">{{ $seller->email ?? 'N/A' }}</x-preview-field>
                    <x-preview-field label="Phone">{{ $seller->phone ?? 'N/A' }}</x-preview-field>
                    <x-preview-field label="Password">••••••••</x-preview-field>
                    <x-preview-field label="Years in Business">{{ $shop->years ?? 'N/A' }}</x-preview-field>
                    <x-preview-field label="First Name">{{ $seller->f_name ?? 'N/A' }}</x-preview-field>
                    <x-preview-field label="Last Name">{{ $seller->l_name ?? 'N/A' }}</x-preview-field>

                    <x-preview-field label="Shop Name">{{ $shop->name ?? 'N/A' }}</x-preview-field>
                    <x-preview-field label="Shop Address">{{ $shop->address ?? 'N/A' }}</x-preview-field>
                    <x-preview-field label="Membership">{{ $seller->membership ?? 'Free' }}</x-preview-field>

                    <x-preview-field label="Logo">
                        @if ($shop->image)
                            <img src="/storage/shop/{{ $shop->image }}" alt="Logo" style="max-height: 200px;">
                        @else
                            {{ translate('No file chosen') }}
                        @endif
                    </x-preview-field>

                    <x-preview-field label="Banner">
                        @if ($shop->banner)
                            <img src="/storage/shop/banner/{{ $shop->banner }}" alt="Banner" style="max-height: 200px;">
                        @else
                            {{ translate('No file chosen') }}
                        @endif
                    </x-preview-field>
                </div>
                <h4 class="mt-4 mb-4">{{ translate('Company Information') }}</h4>

                <div class="row g-4">

                    <x-preview-field label="Company Name">{{ $registerForm->company_name ?? 'N/A' }}</x-preview-field>
                    <x-preview-field
                        label="Registered Business Name">{{ $registerForm->registered_business_name ?? 'N/A' }}</x-preview-field>

                    <x-preview-field label="Type of Business">
                        {{ $registerForm->business_type ?? 'Manufacturer' }}
                    </x-preview-field>

                    <x-preview-field label="Main Products / Services">
                        {{ $registerForm->main_products_services ?? 'N/A' }}
                    </x-preview-field>

                    <x-preview-field
                        label="Year of Establishment">{{ $registerForm->year_of_establishment ?? 'N/A' }}</x-preview-field>
                    <x-preview-field
                        label="Business Registration Number">{{ $registerForm->registration_number ?? 'N/A' }}</x-preview-field>

                    <x-preview-field
                        label="Country of Registration">{{ $registerForm->country_of_registration ?? 'N/A' }}</x-preview-field>
                    <x-preview-field label="GST / VAT / TAX ID">{{ $registerForm->tax_id ?? 'N/A' }}</x-preview-field>

                    <x-preview-field label="Tax Expiry Date">
                        {{ $registerForm->tax_expiry ? date('m/d/Y', strtotime($registerForm->tax_expiry)) : 'N/A' }}
                    </x-preview-field>

                    <x-preview-field
                        label="Industry Category">{{ $registerForm->industry_category ?? 'N/A' }}</x-preview-field>

                </div>
                <h4 class="mt-4 mb-4">{{ translate('Office & Contact Details') }}</h4>

                <div class="row g-4">
                    <x-preview-field label="City">{{ $registerForm->city ?? 'N/A' }}</x-preview-field>
                    <x-preview-field label="State">{{ $registerForm->state ?? 'N/A' }}</x-preview-field>
                    <x-preview-field label="Country">{{ $registerForm->country ?? 'N/A' }}</x-preview-field>
                    <x-preview-field label="Postal / ZIP Code">{{ $registerForm->postal_code ?? 'N/A' }}</x-preview-field>
                    <x-preview-field label="Website URL">{{ $registerForm->website ?? 'N/A' }}</x-preview-field>
                    <x-preview-field
                        label="Company Phone Number">{{ $registerForm->company_phone ?? 'N/A' }}</x-preview-field>
                    <x-preview-field
                        label="Head Office Address">{{ $registerForm->head_office_address ?? 'N/A' }}</x-preview-field>
                    <x-preview-field
                        label="Company Email Address">{{ $registerForm->company_email ?? 'N/A' }}</x-preview-field>
                </div>
                <h4 class="mt-4 mb-4">{{ translate('Contact Person Details') }}</h4>

                <div class="row g-4">
                    <x-preview-field
                        label="Contact Person Name">{{ $registerForm->contact_person_name ?? 'N/A' }}</x-preview-field>
                    <x-preview-field label="Designation">{{ $registerForm->designation ?? 'N/A' }}</x-preview-field>
                    <x-preview-field
                        label="Mobile Number (WhatsApp preferred)">{{ $registerForm->mobile_number ?? 'N/A' }}</x-preview-field>
                    <x-preview-field label="Email ID">{{ $registerForm->contact_email ?? 'N/A' }}</x-preview-field>
                    <x-preview-field
                        label="Alternative Contact (Optional)">{{ $registerForm->alt_contact ?? 'N/A' }}</x-preview-field>
                </div>
                <h4 class="mt-4 mb-4">{{ translate('Banking Details') }}</h4>

                <div class="row g-4">
                    <x-preview-field label="Bank Name">{{ $registerForm->bank_name ?? 'N/A' }}</x-preview-field>
                    <x-preview-field label="Bank Account Name">{{ $registerForm->account_name ?? 'N/A' }}</x-preview-field>
                    <x-preview-field
                        label="Account Number / IBAN">{{ $registerForm->account_number ?? 'N/A' }}</x-preview-field>
                    <x-preview-field label="SWIFT / BIC Code">{{ $registerForm->swift_code ?? 'N/A' }}</x-preview-field>
                    <x-preview-field label="Bank Address">{{ $registerForm->bank_address ?? 'N/A' }}</x-preview-field>
                    <x-preview-field label="Currency Accepted">{{ $registerForm->currency ?? 'N/A' }}</x-preview-field>
                </div>
                <h4 class="mt-4 mb-4">{{ translate('Branches & Global Presence') }}</h4>

                <div class="row g-4">
                    <x-preview-field label="Local Branches">
                        {{ is_array(json_decode($registerForm->local_branches)) ? implode(', ', json_decode($registerForm->local_branches)) : 'N/A' }}
                    </x-preview-field>

                    <x-preview-field label="Overseas Offices / Branches">
                        {{ is_array(json_decode($registerForm->overseas_offices)) ? implode(', ', json_decode($registerForm->overseas_offices)) : 'N/A' }}
                    </x-preview-field>

                    <x-preview-field label="Export Countries">
                        {{ is_array(json_decode($registerForm->export_countries)) ? implode(', ', json_decode($registerForm->export_countries)) : 'N/A' }}
                    </x-preview-field>

                    <x-preview-field label="Warehousing Locations (if any)">
                        {{ $registerForm->warehousing_locations ?? 'N/A' }}
                    </x-preview-field>
                </div>
                <h4 class="mt-4 mb-4">{{ translate('Business Documentation') }}</h4>

                <div class="row g-4">
                    <x-preview-field label="Business License / Registration">
                        @if (!empty($registerForm->business_license_path))
                            <a href="/storage/{{ $registerForm->business_license_path }}" target="_blank">View Document</a>
                        @else
                            {{ translate('No file uploaded') }}
                        @endif
                    </x-preview-field>

                    <x-preview-field label="Tax Certificate">
                        @if (!empty($registerForm->tax_certificate_path))
                            <a href="/storage/{{ $registerForm->tax_certificate_path }}" target="_blank">View Document</a>
                        @else
                            {{ translate('No file uploaded') }}
                        @endif
                    </x-preview-field>

                    <x-preview-field label="Import/Export License (if any)">
                        @if (!empty($registerForm->import_export_license_path))
                            <a href="/storage/{{ $registerForm->import_export_license_path }}" target="_blank">View
                                Document</a>
                        @else
                            {{ translate('No file uploaded') }}
                        @endif
                    </x-preview-field>

                    <x-preview-field label="Bank Account Proof / Cancelled Cheque">
                        @if (!empty($registerForm->bank_proof_path))
                            <a href="/storage/{{ $registerForm->bank_proof_path }}" target="_blank">View Document</a>
                        @else
                            {{ translate('No file uploaded') }}
                        @endif
                    </x-preview-field>

                    <x-preview-field label="Top Authority ID (optional)">
                        @if (!empty($registerForm->authority_id_path))
                            <a href="/storage/{{ $registerForm->authority_id_path }}" target="_blank">View Document</a>
                        @else
                            {{ translate('No file uploaded') }}
                        @endif
                    </x-preview-field>

                    <x-preview-field
                        label="Name & Designation">{{ $registerForm->authority_name ?? 'N/A' }}</x-preview-field>
                    <x-preview-field label="Contact">{{ $registerForm->authority_contact ?? 'N/A' }}</x-preview-field>
                    <x-preview-field label="Email ID">{{ $registerForm->authority_email ?? 'N/A' }}</x-preview-field>

                    <x-preview-field label="Business Card (optional)">
                        @if (!empty($registerForm->business_card_path))
                            <a href="/storage/{{ $registerForm->business_card_path }}" target="_blank">View Business
                                Card</a>
                        @else
                            {{ translate('No file uploaded') }}
                        @endif
                    </x-preview-field>
                </div>

                <h4 class="mt-4 mb-4">{{ translate('Declarations') }}</h4>

                <div class="row g-4">
                    <x-preview-field label="Business Status">
                        {{ $registerForm->is_operational ? 'Business is operational and active' : 'Not declared' }}
                    </x-preview-field>

                    <x-preview-field label="Verified Information">
                        {{ $registerForm->is_info_verified ? 'The information provided is true and verified' : 'Not declared' }}
                    </x-preview-field>

                    <x-preview-field label="Authorization Confirmation">
                        {{ $registerForm->has_authorized_consent ? 'I am an authorized representative of the company' : 'Not declared' }}
                    </x-preview-field>

                    <x-preview-field label="Authorized Person Name">
                        {{ $registerForm->authorized_name ?? 'N/A' }}
                    </x-preview-field>

                    <x-preview-field label="Signature">
                        @if (!empty($registerForm->authorized_signature_path))
                            <a href="/storage/{{ $registerForm->authorized_signature_path }}" target="_blank">View
                                Signature</a>
                        @else
                            {{ translate('No file uploaded') }}
                        @endif
                    </x-preview-field>

                    <x-preview-field label="Company Profile Images">
                        @if (!empty($registerForm->company_images))
                            @foreach (json_decode($registerForm->company_images, true) as $image)
                                <a href="/storage/{{ $image }}" target="_blank">
                                    <img src="/storage/{{ $image }}" alt="Company Image" width="80"
                                        class="me-2 mb-2 rounded border">
                                </a>
                            @endforeach
                        @else
                            {{ translate('No files uploaded') }}
                        @endif
                    </x-preview-field>

                    <x-preview-field label="Factory / Warehouse Images">
                        @if (!empty($registerForm->factory_images))
                            @foreach (json_decode($registerForm->factory_images, true) as $image)
                                <a href="/storage/{{ $image }}" target="_blank">
                                    <img src="/storage/{{ $image }}" alt="Factory Image" width="80"
                                        class="me-2 mb-2 rounded border">
                                </a>
                            @endforeach
                        @else
                            {{ translate('No files uploaded') }}
                        @endif
                    </x-preview-field>
                </div>
            </div>
        </div>
    </div>
@endsection
