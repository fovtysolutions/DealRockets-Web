@php
    if(auth('seller')->check()){
        $seller = \App\Models\Seller::where('id',auth('seller')->user()->id)->first();
        $shop = \App\Models\Shop::where('seller_id',$seller->id)->first();
    } else {
        $seller = null;
        $shop = null;
    }
@endphp
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
                placeholder="{{ translate('ex') . ':' . translate('2') }}" value="{{ old('shop_years',$seller->years ?? '') }}" required>
            <input type="hidden" name="vendor_type" value="{{ $vendor_type }}" readonly>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="f_name" required value="{{ $seller->f_name ?? '' }}">
        </div>
        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="l_name" required value="{{ $seller->l_name ?? '' }}">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" accept="image/*"  {{ isset($shop->image) ? '' : 'required'}}>
        </div>
        <div class="form-group">
            <label for="store_name" class="text-capitalize">{{ translate('shop_Name') }} <span
                    class="text-danger">*</span></label>
            <input class="form-control" type="text" id="shop_name" name="shop_name" value="{{ $shop->name ?? '' }}"
                placeholder="{{ translate('Ex: XYZ store') }}" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group">
            <label for="store_address" class="text-capitalize">{{ translate('shop_address') }} <span
                    class="text-danger">*</span></label>
            <textarea class="form-control" name="shop_address" id="shop_address" rows="1"
                placeholder="{{ translate('shop_address') }}" required>{{ $shop->address ?? '' }}</textarea>
        </div>
        <div class="form-group">
            <label for="shop_membership"
                class="title-color d-flex gap-1 align-items-center">{{ translate('Membership') }}</label>
            <select class="form-control form-control-user" id="shop_membership" name="shop_membership" required>
                <option value="Free" selected>{{ translate('Free') }}</option>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group border p-3 p-xl-4 rounded">
            <div class="d-flex flex-column gap-3 align-items-center">
                <div class="upload-file">
                    <input type="file" name="logo" accept="image/*" {{ isset($shop->bottom_banner) ? '' : 'required'}}>
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
                    <input type="file" name="banner" accept="image/*" {{ isset($shop->banner) ? '' : 'required'}}>
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
    <button type="button" class="save-btn">Save</button>
</div>
<!-- Step 1: Company Information -->
<div class="step-section d-none" data-step="2">
    <h4>Company Information</h4>

    <div class="form-row">
        <div class="form-group">
            <label>Company Name</label>
            <input type="text" name="company_name" required
                value="{{ $vendorProfileData->company_name ?? null }}">
        </div>
        <div class="form-group">
            <label>Registered Business Name</label>
            <input type="text" name="registered_name" required
                value="{{ $vendorProfileData->registered_business_name ?? null }}">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Type of Business</label>
            <select name="business_type" required>
                <option value="">Select</option>
                <option value="manufacturer"
                    {{ isset($vendorProfileData->business_type) ? ($vendorProfileData->business_type == 'manufacturer' ? 'selected' : '') : '' }}>
                    Manufacturer</option>
                <option value="trader"
                    {{ isset($vendorProfileData->business_type) ? ($vendorProfileData->business_type == 'trader' ? 'selected' : '') : '' }}>
                    Trader</option>
                <option value="exporter"
                    {{ isset($vendorProfileData->business_type) ? ($vendorProfileData->business_type == 'exporter' ? 'selected' : '') : '' }}>
                    Exporter</option>
                <option value="service"
                    {{ isset($vendorProfileData->business_type) ? ($vendorProfileData->business_type == 'service' ? 'selected' : '') : '' }}>
                    Service</option>
            </select>
        </div>
        <div class="form-group">
            <label>Main Products / Services</label>
            <textarea name="main_products" placeholder="List comma-separated or use bullet points" rows="1" required>{{ $vendorProfileData->main_products_services ?? null }}</textarea>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Year of Establishment</label>
            <input type="text" name="establishment_year" required pattern="\d{4}" maxlength="4"
                value="{{ $vendorProfileData->year_of_establishment ?? null }}">
        </div>
        <div class="form-group">
            <label>Business Registration Number</label>
            <input type="text" name="registration_number" required
                value="{{ $vendorProfileData->registration_number ?? null }}">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Country of Registration</label>
            <input type="text" name="registration_country" required
                value="{{ $vendorProfileData->country_of_registration ?? null }}">
        </div>
        <div class="form-group">
            <label>GST / VAT / TAX ID</label>
            <input type="text" name="tax_id" required value="{{ $vendorProfileData->tax_id ?? null }}">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Tax Expiry Date</label>
            <input type="date" name="tax_expiry" required value="{{ $vendorProfileData->tax_expiry ?? null }}">
        </div>
        <div class="form-group">
            <label>Industry Category</label>
            <select name="industry" required>
                <option value="">Select Industry</option>
                <option
                    value="agri"{{ isset($vendorProfileData->industry_category) ? ($vendorProfileData->industry_category == 'agri' ? 'selected' : '') : '' }}>
                    Agriculture</option>
                <option
                    value="food"{{ isset($vendorProfileData->industry_category) ? ($vendorProfileData->industry_category == 'food' ? 'selected' : '') : '' }}>
                    Food</option>
                <option
                    value="fmcg"{{ isset($vendorProfileData->industry_category) ? ($vendorProfileData->industry_category == 'fmcg' ? 'selected' : '') : '' }}>
                    FMCG</option>
                <!-- Add more as needed -->
            </select>
        </div>
    </div>

    <button type="button" class="prev-btn" data-prev="1">Previous</button>
    <button type="button" class="next-btn" data-next="3">Next</button>
    <button type="button" class="save-btn">Save</button>
</div>

<!-- Step 2: Office & Contact Details -->
<div class="step-section d-none" data-step="3">
    <h4>Office & Contact Details</h4>

    <div class="form-row">
        <div class="form-group">
            <label>City</label>
            <input type="text" name="city" required value="{{ $vendorProfileData->city ?? null }}">
        </div>
        <div class="form-group">
            <label>State</label>
            <input type="text" name="state" required value="{{ $vendorProfileData->state ?? null }}">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Country</label>
            <input type="text" name="country" required value="{{ $vendorProfileData->country ?? null }}">
        </div>
        <div class="form-group">
            <label>Postal / ZIP Code</label>
            <input type="text" name="zip_code" required value="{{ $vendorProfileData->postal_code ?? null }}">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Website URL</label>
            <input type="url" name="website_url" required value="{{ $vendorProfileData->website ?? null }}">
        </div>
        <div class="form-group">
            <label>Company Phone Number</label>
            <input type="tel" name="company_phone" required
                value="{{ $vendorProfileData->company_phone ?? null }}">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Head Office Address</label>
            <textarea name="office_address" required rows="1">{{ $vendorProfileData->head_office_address ?? null }}</textarea>
        </div>
        <div class="form-group">
            <label>Company Email Address</label>
            <input type="email" name="company_email" required
                value="{{ $vendorProfileData->company_email ?? null }}">
        </div>
    </div>

    <button type="button" class="prev-btn" data-prev="2">Back</button>
    <button type="button" class="next-btn" data-next="4">Next</button>
    <button type="button" class="save-btn">Save</button>
</div>

<!-- Step 3: Contact Person -->
<div class="step-section d-none" data-step="4">
    <h4>Contact Person</h4>

    <div class="form-row">
        <div class="form-group">
            <label>Contact Person Name</label>
            <input type="text" name="contact_name" required
                value="{{ $vendorProfileData->contact_person_name ?? null }}">
        </div>
        <div class="form-group">
            <label>Designation</label>
            <input type="text" name="designation" required value="{{ $vendorProfileData->designation ?? null }}">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Mobile Number (WhatsApp preferred)</label>
            <input type="tel" name="mobile_number" required
                value="{{ $vendorProfileData->mobile_number ?? null }}">
        </div>
        <div class="form-group">
            <label>Email ID</label>
            <input type="email" name="contact_email" required
                value="{{ $vendorProfileData->contact_email ?? null }}">
        </div>
    </div>

    <div class="form-row">
        <div class="form-single">
            <label>Alternative Contact (Optional)</label>
            <input type="text" name="alt_contact" required value="{{ $vendorProfileData->alt_contact ?? null }}">
        </div>
    </div>

    <button type="button" class="prev-btn" data-prev="3">Back</button>
    <button type="button" class="next-btn" data-next="5">Next</button>
    <button type="button" class="save-btn">Save</button>
</div>

<!-- Step 4: Banking Details -->
<div class="step-section d-none" data-step="5">
    <h4>Banking Details</h4>

    <div class="form-row">
        <div class="form-group">
            <label>Bank Name</label>
            <input type="text" name="bank_name" required value="{{ $vendorProfileData->bank_name ?? null }}">
        </div>

        <div class="form-group">
            <label>Bank Account Name</label>
            <input type="text" name="bank_account_name" required
                value="{{ $vendorProfileData->account_name ?? null }}">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Account Number / IBAN</label>
            <input type="text" name="iban" required value="{{ $vendorProfileData->account_number ?? null }}">
        </div>
        <div class="form-group">
            <label>SWIFT / BIC Code</label>
            <input type="text" name="swift_code" value="{{ $vendorProfileData->swift_code ?? null }}">
        </div>
    </div>


    <div class="form-row">
        <div class="form-group">
            <label>Bank Address</label>
            <input type="text" name="bank_address" required
                value="{{ $vendorProfileData->bank_address ?? null }}">
        </div>
        <div class="form-group">
            <label>Currency Accepted</label>
            <input type="text" name="currency_accepted" placeholder="USD, AED, EUR" required
                value="{{ $vendorProfileData->currency ?? null }}">
        </div>
    </div>

    <button type="button" class="prev-btn" data-prev="4">Back</button>
    <button type="button" class="next-btn" data-next="6">Next</button>
    <button type="button" class="save-btn">Save</button>
</div>


<!-- Step 5: Branches & Global Presence -->
<div class="step-section d-none" data-step="6">
    <h4>Branches & Global Presence</h4>

    <div class="form-row">
        <div class="form-group">
            <label>Local Branches</label>
            <textarea name="local_branches" placeholder="List with city, address, and contact" rows="1">{{ $vendorProfileData->local_branches ?? null }}</textarea>
        </div>

        <div class="form-group">
            <label>Overseas Offices / Branches</label>
            <textarea name="overseas_offices" placeholder="Country and contact person details" rows="1">{{ $vendorProfileData->overseas_offices ?? null }}</textarea>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Export Countries</label>
            <input type="text" name="export_countries" placeholder="e.g., UAE, India, Germany"
                value="{{ $vendorProfileData->export_countries ?? null }}">
        </div>

        <div class="form-group">
            <label>Warehousing Locations (if any)</label>
            <input type="text" name="warehousing_locations" placeholder="Country and City"
                value="{{ $vendorProfileData->warehousing_locations ?? null }}">
        </div>
    </div>

    <button type="button" class="prev-btn" data-prev="5">Back</button>
    <button type="button" class="next-btn" data-next="7">Next</button>
    <button type="button" class="save-btn">Save</button>
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
            <input type="text" name="person_name_designation" required
                value="{{ $vendorProfileData->authority_name ?? null }}">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Contact</label>
            <input type="text" name="person_contact" required
                value="{{ $vendorProfileData->authority_contact ?? null }}">
        </div>
        <div class="form-group">
            <label>Email ID</label>
            <input type="email" name="person_email" required
                value="{{ $vendorProfileData->authority_email ?? null }}">
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
    <button type="button" class="save-btn">Save</button>
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
                value="{{ $vendorProfileData->authorized_name ?? null }}" required>
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
    <button type="button" class="save-btn">Save</button>
    <button type="button" onclick="submitRegistrationVendor()" class="submit-btn">Submit</button>
</div>
