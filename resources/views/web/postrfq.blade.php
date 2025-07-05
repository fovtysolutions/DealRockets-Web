@extends('layouts.front-end.app')
@section('title', translate('RFQ' . ' | ' . $web_config['name']->value))
@push('css_or_js')
    <link rel="stylesheet" href="{{ asset('assets/custom-css/ai/rfq-form.css') }}">
@endpush
@section('content')
    <section class="mainpagesection rfq-form" style="background-color: unset;">
        <div class="rfq-form-container " style="background-color: #f7f7f7;">
            <div style="margin-left: 15px;">
                <div class="section-heading mb-0">Essential Product Details</div>
                <div class="right-text">
                    Provide detailed requirements to receive quicker and more accurate responses.
                </div>
            </div>
            <div class=" form-con my-4 d-flex" style="justify-content: space-between;">
                <div class="left-div " style="width:72%;">
                    <div class="inner-form-wrapper">
                        <div class="section-heading">Essential Product Details</div>

                        <form id="rfq-form" method="POST" action="{{ route('quotation.submit') }}"
                            enctype="multipart/form-data">
                            @csrf

                            {{-- Product Name --}}
                            <div class="form-row form-row-for-phone">
                                <label class="label-width">Product Name</label>
                                <input class="contact-input counter-fields" name="product_name" type="text"
                                    placeholder="Enter product name" value="{{ old('product_name') }}" required />
                            </div>

                            {{-- Category --}}
                            <div class="form-row form-row-for-phone">
                                <label class="label-width">Category</label>
                                <select class="contact-input counter-fields" name="category" required>
                                    <option value="">Select a category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-flex w-100 maincontainer">
                                <div class="leftcontainer">

                                    {{-- Purchase Quantity --}}
                                    <div class="form-row">
                                        <div class="innerleftcontainer">
                                            <label class="label-width">Purchase Quantity</label>
                                        </div>
                                        <div class="innerrightcontainer">
                                            <input class="contact-input counter-fields" name="purchase_quantity"
                                                type="number" placeholder="0" value="{{ old('purchase_quantity') }}"
                                                style="max-width: 150px;" required />
                                            <select class="contact-input counter-fields" name="unit_unit"
                                                style="max-width: 150px;" required>
                                                <option value="">Select Unit</option>
                                                @foreach ([
            'pc' => 'Piece(s)',
            'kg' => 'Kilogram(s)',
            'g' => 'Gram(s)',
            'mg' => 'Milligram(s)',
            'ltr' => 'Liter(s)',
            'ml' => 'Milliliter(s)',
            'cbm' => 'Cubic Meter(s)',
            'cm' => 'Centimeter(s)',
            'm' => 'Meter(s)',
            'in' => 'Inch(es)',
            'ft' => 'Foot/Feet',
            'yd' => 'Yard(s)',
            'sqft' => 'Square Foot/Feet',
            'sqm' => 'Square Meter(s)',
            'dozen' => 'Dozen',
            'box' => 'Box(es)',
            'pack' => 'Pack(s)',
            'roll' => 'Roll(s)',
            'set' => 'Set(s)',
            'bottle' => 'Bottle(s)',
        ] as $unitValue => $unitLabel)
                                                    <option value="{{ $unitValue }}"
                                                        {{ old('unit_unit') == $unitValue ? 'selected' : '' }}>
                                                        {{ $unitLabel }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Target Unit Price --}}
                                    <div class="form-row">
                                        <div class="innerleftcontainer">
                                            <label class="label-width">Target Unit Price</label>
                                        </div>
                                        <div class="innerrightcontainer">
                                            <input class="contact-input counter-fields" name="target_unit_price"
                                                type="number" placeholder="0.00" value="{{ old('target_unit_price') }}"
                                                style="max-width: 150px;" required />
                                            <select class="contact-input counter-fields" name="target_unit_price_currency"
                                                style="max-width: 150px;" required>
                                                <option value="">Select Currency</option>
                                                @foreach (['usd' => 'USD', 'eur' => 'EUR', 'inr' => 'INR', 'gbp' => 'GBP'] as $curVal => $curLabel)
                                                    <option value="{{ $curVal }}"
                                                        {{ old('target_unit_price_currency') == $curVal ? 'selected' : '' }}>
                                                        {{ $curLabel }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Trade Terms --}}
                                    <div class="form-row width-form-phone float-phone">
                                        <div class="innerleftcontainer">
                                            <label class="label-width">Trade Terms</label>
                                        </div>
                                        <div class="innerrightcontainer">
                                            <select class="contact-input counter-fields" name="trade_terms"
                                                style="max-width: 300px;" required>
                                                <option value="">Select Trading Terms</option>
                                                @foreach ([
            'exw' => 'EXW - Ex Works',
            'fca' => 'FCA - Free Carrier',
            'cpt' => 'CPT - Carriage Paid To',
            'cip' => 'CIP - Carriage and Insurance Paid To',
            'dap' => 'DAP - Delivered at Place',
            'dpu' => 'DPU - Delivered at Place Unloaded',
            'ddp' => 'DDP - Delivered Duty Paid',
            'fob' => 'FOB - Free On Board',
            'fas' => 'FAS - Free Alongside Ship',
            'cfr' => 'CFR - Cost and Freight',
            'cif' => 'CIF - Cost, Insurance and Freight',
        ] as $termVal => $termLabel)
                                                    <option value="{{ $termVal }}"
                                                        {{ old('trade_terms') == $termVal ? 'selected' : '' }}>
                                                        {{ $termLabel }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Max Budget --}}
                                    {{-- <div class="form-row width-form-phone">
                                        <div class="innerleftcontainer">
                                            <label class="label-width">Max Budget</label>
                                        </div>
                                        <div class="innerrightcontainer">
                                            <input class="contact-input counter-fields" name="max_budget"
                                                value="{{ old('max_budget') }}" style="max-width: 150px;" />
                                            <select class="contact-input counter-fields" name="max_budget_currency"
                                                style="max-width: 150px;">
                                                <option value="">Select Currency</option>
                                                @foreach (['usd' => 'USD', 'eur' => 'EUR', 'inr' => 'INR'] as $curVal => $curLabel)
                                                    <option value="{{ $curVal }}"
                                                        {{ old('max_budget_currency') == $curVal ? 'selected' : '' }}>
                                                        {{ $curLabel }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}

                                </div>

                                {{-- Image Upload --}}
                                <div class="d-flex justify-end rightcontainer">
                                    <div class="form-row image-upload">
                                        <input type="file" id="imageInput" accept="image/*" name="image"
                                            style="display: none;" class="counter-fields" />
                                        <div class="upload-box" id="uploadBox">
                                            <div class="text-center">
                                                <i class="fa-solid fa-cloud-arrow-up fa-2x mb-2 text-secondary"></i><br>
                                                Upload Image
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Details --}}
                            <div class="form-row">
                                <label class="label-width">Details</label>
                                <textarea class="contact-input counter-fields" rows="1" name="details"
                                    placeholder="Describe product requirements..." required>{{ old('details') }}</textarea>
                            </div>

                            <hr>

                            <div class="section-heading mt-3">Shipping and Payment</div>

                            {{-- Contact Number --}}
                            <div class="form-row">
                                <label class="label-width">Contact Number</label>
                                <input class="contact-input counter-fields" type="text" placeholder="Contact Number"
                                    name="contact_number" value="{{ old('contact_number') }}" style="max-width: 200px;"
                                    required />
                            </div>

                            {{-- Shipping Method --}}
                            <div class="form-row">
                                <label class="label-width">Shipping Method</label>
                                <select class="contact-input counter-fields" name="shipping_method"
                                    style="max-width: 200px;" required>
                                    <option value="">Select Shipping Method</option>
                                    @foreach ([
            // Sea Freight
            'sea_fcl' => 'Sea Freight (FCL - Full Container Load)',
            'sea_lcl' => 'Sea Freight (LCL - Less than Container Load)',
            'sea_bulk' => 'Sea Freight (Bulk)',

            // Air Freight
            'air_freight' => 'Air Freight',
            'air_express' => 'Air Express',

            // Rail Transport
            'rail_freight' => 'Rail Freight',
            'rail_container' => 'Rail Container Transport',

            // Road Transport
            'road_freight' => 'Road Freight',
            'road_truck' => 'Road Transport (Truck)',
            'road_ltl' => 'Road Freight (LTL - Less than Truckload)',
            'road_ftl' => 'Road Freight (FTL - Full Truckload)',

            // Courier / Parcel
            'courier_express' => 'Courier (Express)',
            'courier_standard' => 'Courier (Standard)',

            // Multimodal / Others
            'multimodal' => 'Multimodal Transport',
            'pickup' => 'Local Pickup',
            'dropoff' => 'Local Dropoff',
        ] as $method => $label)
                                        <option value="{{ $method }}"
                                            {{ old('shipping_method') == $method ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Destination Port --}}
                            <div class="form-row">
                                <label class="label-width">Destination Port</label>
                                <input class="contact-input counter-fields" type="text" name="destination_port"
                                    value="{{ old('destination_port') }}" style="max-width: 200px;" required />
                                {{-- <select class="contact-input counter-fields" name="destination_port_currency"
                                    style="max-width: 150px;">
                                    <option value="">Select Currency</option>
                                    @foreach (['usd' => 'USD', 'eur' => 'EUR'] as $code => $label)
                                        <option value="{{ $code }}"
                                            {{ old('destination_port_currency') == $code ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select> --}}
                            </div>

                            {{-- Lead Time --}}
                            <div class="form-row width-form-phone float-phone">
                                <label class="label-width">Lead Time</label>
                                <span style="margin-left: 5px; font-weight: bold;">Delivery Required in</span>

                                <input class="contact-input counter-fields" name="spin_time_value" id="spin_time_value"
                                    type="number" value="{{ old('spin_time_value') }}" style="max-width: 100px;"
                                    min="1" />

                                <select name="spin_time_unit" id="spin_time_unit" class="contact-input"
                                    style="max-width: 100px; margin-left: 5px;">
                                    <option value="day" {{ old('spin_time_unit') == 'day' ? 'selected' : '' }}>Day(s)
                                    </option>
                                    <option value="month" {{ old('spin_time_unit') == 'month' ? 'selected' : '' }}>
                                        Month(s)</option>
                                </select>

                                <input type="hidden" name="spin_time" id="spin_time" value="{{ old('spin_time') }}"
                                    required>

                                <span style="margin-left: 5px; font-weight: bold;" class="hide-span">
                                    after supplier receives the initial payment.
                                </span>
                            </div>

                            {{-- Payment Terms --}}
                            <div class="form-row width-form-phone">
                                <label class="label-width padding-phone">Payment Terms</label>
                                <select class="contact-input counter-fields" name="terms" style="max-width: 200px;"
                                    required>
                                    <option value="">Select Payment Terms</option>
                                    @foreach ([
            't/t' => 'T/T (Telegraphic Transfer)',
            'l/c' => 'L/C (Letter of Credit)',
            'd/p' => 'D/P (Documents Against Payment)',
            'd/a' => 'D/A (Documents Against Acceptance)',
            'open_account' => 'Open Account',
            'advance_payment' => 'Advance Payment',
            'partial_payment' => 'Partial Payment',
            'cash_on_delivery' => 'Cash on Delivery (COD)',
            'cash_in_advance' => 'Cash in Advance',
            'net_30' => 'Net 30 Days',
            'net_60' => 'Net 60 Days',
            'paypal' => 'PayPal',
            'western_union' => 'Western Union',
            'moneygram' => 'MoneyGram',
            'credit_card' => 'Credit Card',
            'debit_card' => 'Debit Card',
            'bank_transfer' => 'Bank Transfer',
            'escrow' => 'Escrow',
            'bitcoin' => 'Bitcoin',
            'alipay' => 'Alipay',
            'wechat_pay' => 'WeChat Pay',
        ] as $term => $label)
                                        <option value="{{ $term }}"
                                            {{ old('terms') == $term ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Submit --}}
                            <div class="form-row" style="justify-content: end;">
                                <button type="submit" class="btn submit-rfq px-4">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="right-div" style="width: 25%;">
                    <div class="inner-form-wrapper  h-100">
                        <div>
                            <div class="section-heading">RFQ Score</div>
                            <div class="right-text">
                                Provide as many details as possible about your request to ensure a faster response from the
                                right
                                suppliers. The higher the score, the better responses you will get.
                            </div>
                        </div>
                        <div class="text-center my-4">
                            <svg width="150" height="80" viewBox="0 0 150 80">
                                <!-- Background arc -->
                                <path d="M10,70 A65,65 0 0,1 140,70" fill="none" stroke="#eee" stroke-width="10" />

                                <!-- Foreground (progress) arc -->
                                <path id="progress-arc" d="M10,70 A65,65 0 0,1 140,70" fill="none" stroke="#FE4E44"
                                    stroke-width="10" stroke-dasharray="205" stroke-dashoffset="205" />
                            </svg>
                            <div style="margin-top: -15px; font-size: 16px; font-weight: bold;" id="progress-text">0%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script src="{{ asset('js/rfq-form.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Fetch Session Values
            var productName = sessionStorage.getItem('productName');
            var port = sessionStorage.getItem('port');
            var mobile = sessionStorage.getItem('mobile');
            var quantity = sessionStorage.getItem('quantity');
            var unit = sessionStorage.getItem('unit');
            var details = sessionStorage.getItem('details');
            var payment_terms = sessionStorage.getItem('payment_terms');
            var shipping_method = sessionStorage.getItem('shipping_method');

            // Auto Fill Session Values
            if (productName) {
                $('input[name="product_name"]').val(productName);
                updateProgress();
            }
            if (port) {
                $('input[name="destination_port"]').val(port);
                updateProgress();
            }
            if (mobile) {
                $('input[name="contact_number"]').val(mobile);
                updateProgress();
            }
            if (quantity) {
                $('input[name="purchase_quantity"]').val(quantity);
                updateProgress();
            }
            if (unit) {
                var unit_selector = $('select[name="unit_unit"]');
                unit_selector.find('option').each(function() {
                    var option = $(this);
                    if (option.val() === unit) {
                        option.prop('selected', true);
                    }
                });
                updateProgress();
            }
            if (details) {
                $('textarea[name="details"]').val(details);
                updateProgress();
            }
            if (payment_terms) {
                var terms_selector = $('select[name="terms"]');
                terms_selector.find('option').each(function() {
                    var option = $(this);
                    if (option.val() === payment_terms) {
                        option.prop('selected', true);
                    }
                });
                updateProgress();
            }
            if (shipping_method) {
                var shipping_selector = $('select[name="shipping_method"]');
                shipping_selector.find('option').each(function() {
                    var option = $(this);
                    if (option.val() === shipping_method) {
                        option.prop('selected', true);
                    }
                });
                updateProgress();
            }

            // Remove Item
            sessionStorage.removeItem('productName');
            sessionStorage.removeItem('port');
            sessionStorage.removeItem('mobile');
            sessionStorage.removeItem('quantity');
            sessionStorage.removeItem('unit');
            sessionStorage.removeItem('details');
            sessionStorage.removeItem('payment_terms');
            sessionStorage.removeItem('shipping_method');
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("rfq-form");
            const valueInput = document.getElementById("spin_time_value");
            const unitSelect = document.getElementById("spin_time_unit");
            const hiddenInput = document.getElementById("spin_time");
            const imageInput = document.getElementById("imageInput");
            const uploadBox = document.getElementById("uploadBox");

            valueInput.addEventListener("input", function() {
                const value = valueInput.value.trim();
                const unit = unitSelect.value.trim();
                hiddenInput.value = value && unit ? `${value} ${unit}` : '';
            });

            unitSelect.addEventListener("change", function() {
                const value = valueInput.value.trim();
                const unit = unitSelect.value.trim();
                hiddenInput.value = value && unit ? `${value} ${unit}` : '';
            });

            form.addEventListener('submit', function(e) {
                const imageInput = document.getElementById("imageInput");
                const uploadBox = document.getElementById("uploadBox");

                if (!imageInput.files.length) {
                    e.preventDefault(); // Prevent form submission
                    toastr.warning("Please upload an image.");
                    uploadBox.classList.add("border", "border-danger");
                } else {
                    uploadBox.classList.remove("border", "border-danger");
                    // Form will submit naturally if image is present
                }
            });
        });
    </script>
@endpush
