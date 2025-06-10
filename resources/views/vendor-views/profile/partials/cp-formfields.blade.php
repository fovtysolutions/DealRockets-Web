<link rel="stylesheet" href="{{ theme_asset('public/assets/custom-css/progress-form.css') }}">
<script src="{{ theme_asset('public/js/progress-form.js') }}"></script>
<style>
    .step-section button{
        margin-top: 10px;
    }
</style>
<div class="progress-form-main">
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
        <h1>Company Details</h1>
        <p>Fill in the required details to get started</p>
    </div>
    <div class="step-section" data-step="1">
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Title') }}</label>
                <input type="text" class="form-control" name="title" value="{{ $cp->title ?? '' }}">
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Subtitle') }}</label>
                <input type="text" class="form-control" name="subtitle" value="{{ $cp->subtitle ?? '' }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ translate('Description Heading') }}</label>
                <input type="text" class="form-control" name="description_head"
                    value="{{ $cp->description_head ?? '' }}">
            </div>
            <div class="form-group">
                <label class="form-label">{{ translate('Description Text') }}</label>
                <textarea class="form-control" name="description_text" rows="3">{{ $cp->description_text ?? '' }}</textarea>
            </div>
        </div>
        <button type="button" class="next-btn" data-next="2">Next</button>
    </div>
    <div class="step-section d-none" data-step="2">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">{{ translate('Images') }}</label>
                <input type="file" class="form-control" name="images[]" multiple>
                @if (!empty($cp->images) && isset($cp))
                    @php $imagesArray = json_decode($cp->images, true); @endphp
                    <div class="mt-3 mb-2">
                        @foreach ($imagesArray as $item)
                            <img src="{{ theme_asset('storage/' . $item) }}" alt="image"
                                style="height: 150px; width: 150px;">
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ translate('Certificates') }}</label>
                <input type="file" class="form-control" name="certificates[]" multiple>
                @if (!empty($cp->certificates) && isset($cp))
                    @php $imagesArray = json_decode($cp->certificates, true); @endphp
                    <div class="mt-3 mb-2">
                        @foreach ($imagesArray as $item)
                            <img src="{{ theme_asset('storage/' . $item) }}" alt="image"
                                style="height: 150px; width: 150px;">
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <button type="button" class="prev-btn" data-prev="1">Back</button>
        <button type="button" class="next-btn" data-next="3">Next</button>
    </div>
    <div class="step-section d-none" data-step="3">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">{{ translate('Total Capitalization') }}</label>
                <input type="text" class="form-control" name="total_capitalization"
                    value="{{ $cp->total_capitalization ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">{{ translate('Year Established') }}</label>
                <input type="number" class="form-control" name="year_established"
                    value="{{ $cp->year_established ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">{{ translate('Total Employees') }}</label>
                <input type="text" class="form-control" name="total_employees"
                    value="{{ $cp->total_employees ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ translate('Company Certificates') }}</label>
                <input type="text" class="form-control" name="company_certificates"
                    value="{{ $cp->company_certificates ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ translate('Product Certificates') }}</label>
                <input type="text" class="form-control" name="product_certificates"
                    value="{{ $cp->product_certificates ?? '' }}">
            </div>
            <div class="col-12">
                <label class="form-label">{{ translate('Business Type') }}</label>
                <input type="text" class="form-control" name="business_type"
                    value="{{ $cp->business_type ?? '' }}">
            </div>
        </div>
        <button type="button" class="prev-btn" data-prev="2">Back</button>
        <button type="button" class="next-btn" data-next="4">Next</button>
    </div>
    <div class="step-section d-none" data-step="4">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">{{ translate('Total Annual Sales') }}</label>
                <input type="text" class="form-control" name="total_annual_sales"
                    value="{{ $cp->total_annual_sales ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ translate('Export Percentage') }}</label>
                <input type="number" class="form-control" name="export_percentage"
                    value="{{ $cp->export_percentage ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ translate('OEM Service') }}</label>
                <select class="form-control" name="oem_service">
                    <option value="1" {{ !empty($cp) && $cp->oem_service == 1 ? 'selected' : '' }}>
                        {{ translate('Yes') }}</option>
                    <option value="0" {{ !empty($cp) && $cp->oem_service == 0 ? 'selected' : '' }}>
                        {{ translate('No') }}</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ translate('Small Orders Accepted') }}</label>
                <select class="form-control" name="small_orders_accepted">
                    <option value="1" {{ !empty($cp) && $cp->small_orders_accepted == 1 ? 'selected' : '' }}>
                        {{ translate('Yes') }}</option>
                    <option value="0" {{ !empty($cp) && $cp->small_orders_accepted == 0 ? 'selected' : '' }}>
                        {{ translate('No') }}</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">{{ translate('Main Export Markets') }}</label>
                <input type="text" class="form-control" name="main_export_markets"
                    value="{{ $cp->main_export_markets ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ translate('Payment Terms') }}</label>
                <input type="text" class="form-control" name="payment_terms"
                    value="{{ $cp->payment_terms ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ translate('Delivery Terms') }}</label>
                <input type="text" class="form-control" name="delivery_terms"
                    value="{{ $cp->delivery_terms ?? '' }}">
            </div>
        </div>
        <button type="button" class="prev-btn" data-prev="3">Back</button>
        <button type="button" class="next-btn" data-next="5">Next</button>
    </div>
    <div class="step-section d-none" data-step="5">
        <div class="row g-3">
            {{-- Company Show --}}
            <div class="col-md-6">
                <label class="form-label">{{ translate('Hot Products') }}</label>
                <input type="text" class="form-control" name="hot_products"
                    value="{{ $cp->hot_products ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ translate('Product Categories') }}</label>
                <input type="text" class="form-control" name="product_categories"
                    value="{{ $cp->product_categories ?? '' }}">
            </div>

            {{-- Production Capacity --}}
            <div class="col-md-4">
                <label class="form-label">{{ translate('Factory Size') }}</label>
                <input type="text" class="form-control" name="factory_size"
                    value="{{ $cp->factory_size ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">{{ translate('Production Lines') }}</label>
                <input type="number" class="form-control" name="production_lines"
                    value="{{ $cp->production_lines ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">{{ translate('Monthly Output') }}</label>
                <input type="text" class="form-control" name="monthly_output"
                    value="{{ $cp->monthly_output ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ translate('Main Products') }}</label>
                <input type="text" class="form-control" name="main_products"
                    value="{{ $cp->main_products ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ translate('Lead Time') }}</label>
                <input type="text" class="form-control" name="lead_time" value="{{ $cp->lead_time ?? '' }}">
            </div>
        </div>
        <button type="button" class="prev-btn" data-prev="4">Back</button>
        <button type="button" class="next-btn" data-next="6">Next</button>
    </div>
    <div class="step-section d-none" data-step="6">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">{{ translate('QC Staff Count') }}</label>
                <input type="number" class="form-control" name="qc_staff_count"
                    value="{{ $cp->qc_staff_count ?? '' }}">
            </div>
            <div class="col-md-8">
                <label class="form-label">{{ translate('Inspection Process') }}</label>
                <input type="text" class="form-control" name="inspection_process"
                    value="{{ $cp->inspection_process ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ translate('Testing Equipment') }}</label>
                <input type="text" class="form-control" name="testing_equipment"
                    value="{{ $cp->testing_equipment ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ translate('QC Certifications') }}</label>
                <input type="text" class="form-control" name="qc_certifications"
                    value="{{ $cp->qc_certifications ?? '' }}">
            </div>
        </div>
        <button type="button" class="prev-btn" data-prev="5">Back</button>
        <button type="button" class="next-btn" data-next="7">Next</button>
    </div>
    <div class="step-section d-none" data-step="7">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">{{ translate('R&D Staff Count') }}</label>
                <input type="number" class="form-control" name="rd_staff_count"
                    value="{{ $cp->rd_staff_count ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">{{ translate('Patents') }}</label>
                <input type="number" class="form-control" name="patents" value="{{ $cp->patents ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">{{ translate('Annual R&D Spending') }}</label>
                <input type="text" class="form-control" name="annual_rd_spending"
                    value="{{ $cp->annual_rd_spending ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ translate('Customization Offered') }}</label>
                <select class="form-control" name="customization_offered">
                    <option value="1" {{ !empty($cp) && $cp->customization_offered == 1 ? 'selected' : '' }}>
                        {{ translate('Yes') }}</option>
                    <option value="0" {{ !empty($cp) && $cp->customization_offered == 0 ? 'selected' : '' }}>
                        {{ translate('No') }}</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ translate('Product Development Time') }}</label>
                <input type="text" class="form-control" name="product_dev_time"
                    value="{{ $cp->product_dev_time ?? '' }}">
            </div>
        </div>
        <button type="button" class="prev-btn" data-prev="6">Back</button>
        <button type="button" class="next-btn" data-next="8">Next</button>
    </div>
    <div class="step-section d-none" data-step="8">
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">{{ translate('Address') }}</label>
                <input type="text" class="form-control" name="address" value="{{ $cp->address ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">{{ translate('Local Time') }}</label>
                <input type="text" class="form-control" name="local_time" value="{{ $cp->local_time ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">{{ translate('Telephone') }}</label>
                <input type="text" class="form-control" name="telephone" value="{{ $cp->telephone ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">{{ translate('Mobile') }}</label>
                <input type="text" class="form-control" name="mobile" value="{{ $cp->mobile ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ translate('Fax') }}</label>
                <input type="text" class="form-control" name="fax" value="{{ $cp->fax ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ translate('Showroom') }}</label>
                <input type="text" class="form-control" name="showroom" value="{{ $cp->showroom ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ translate('Contact Name') }}</label>
                <input type="text" class="form-control" name="contact_name"
                    value="{{ $cp->contact_name ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ translate('Department') }}</label>
                <input type="text" class="form-control" name="contact_dept"
                    value="{{ $cp->contact_dept ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ translate('Email') }}</label>
                <input type="email" class="form-control" name="email" value="{{ $cp->email ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ translate('Website') }}</label>
                <input type="url" class="form-control" name="website" value="{{ $cp->website ?? '' }}">
            </div>
        </div>
        <button type="button" class="prev-btn" data-prev="7">Back</button>
        <button type="submit" class="submit-btn">{{ translate('Submit') }}</button>
    </div>
</div>
