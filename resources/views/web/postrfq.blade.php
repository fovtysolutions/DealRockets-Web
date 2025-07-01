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

                        <form method="POST" action="{{ route('quotation.submit') }}" enctype="multipart/form-data">
                            @csrf

                            {{-- Product Name --}}
                            <div class="form-row form-row-for-phone">
                                <label class="label-width">Product Name</label>
                                <input class="contact-input counter-fields" name="product_name" type="text"
                                    placeholder="Enter product name" value="{{ old('product_name') }}" />
                            </div>

                            {{-- Category --}}
                            <div class="form-row form-row-for-phone">
                                <label class="label-width">Category</label>
                                <select class="contact-input counter-fields" name="category">
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
                                                style="max-width: 150px;" />
                                            <select class="contact-input counter-fields" name="unit_unit"
                                                style="max-width: 150px;">
                                                <option value="">Select Unit</option>
                                                @foreach (['pc' => 'Piece(s)', 'kg' => 'Kg(s)', 'g' => 'Gram(s)', 'ltr' => 'Liter(s)', 'cbm' => 'Cubic Meter(s)'] as $unitValue => $unitLabel)
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
                                                style="max-width: 150px;" />
                                            <select class="contact-input counter-fields" name="target_unit_price_currency"
                                                style="max-width: 150px;">
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
                                                style="max-width: 300px;">
                                                <option value="">Select Trading Terms</option>
                                                @foreach (['fob' => 'FOB', 'cif' => 'CIF', 'exw' => 'EXW', 'dap' => 'DAP'] as $termVal => $termLabel)
                                                    <option value="{{ $termVal }}"
                                                        {{ old('trade_terms') == $termVal ? 'selected' : '' }}>
                                                        {{ $termLabel }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Max Budget --}}
                                    <div class="form-row width-form-phone">
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
                                    </div>

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
                                    placeholder="Describe product requirements...">{{ old('details') }}</textarea>
                            </div>

                            <hr>

                            <div class="section-heading mt-3">Shipping and Payment</div>

                            {{-- Contact Number --}}
                            <div class="form-row">
                                <label class="label-width">Contact Number</label>
                                <input class="contact-input counter-fields" type="text" placeholder="Contact Number"
                                    name="contact_number" value="{{ old('contact_number') }}"
                                    style="max-width: 200px;" />
                            </div>

                            {{-- Shipping Method --}}
                            <div class="form-row">
                                <label class="label-width">Shipping Method</label>
                                <select class="contact-input counter-fields" name="shipping_method"
                                    style="max-width: 200px;">
                                    <option value="">Select Shipping Method</option>
                                    @foreach (['sea_freight' => 'Sea Freight', 'air_freight' => 'Air Freight', 'courier' => 'Courier'] as $method => $label)
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
                                    value="{{ old('destination_port') }}" style="max-width: 200px;" />
                                <select class="contact-input counter-fields" name="destination_port_currency"
                                    style="max-width: 150px;">
                                    <option value="">Select Currency</option>
                                    @foreach (['usd' => 'USD', 'eur' => 'EUR'] as $code => $label)
                                        <option value="{{ $code }}"
                                            {{ old('destination_port_currency') == $code ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Lead Time --}}
                            <div class="form-row width-form-phone float-phone">
                                <label class="label-width">Lead Time</label>
                                <span style="margin-left: 5px; font-weight: bold;">Spin in</span>
                                <input class="contact-input counter-fields" name="spin_time" type="text"
                                    value="{{ old('spin_time') }}" style="max-width: 200px;" />
                                <span style="margin-left: 5px; font-weight: bold;" class="hide-span">day(s) after supplier
                                    receives the initial payment.</span>
                            </div>

                            {{-- Payment Terms --}}
                            <div class="form-row width-form-phone">
                                <label class="label-width padding-phone">Payment Terms</label>
                                <select class="contact-input counter-fields" name="terms" style="max-width: 200px;">
                                    <option value="">Select Payment Terms</option>
                                    @foreach (['t/t' => 'T/T', 'l/c' => 'L/C', 'paypal' => 'PayPal', 'cif' => 'CIF'] as $term => $label)
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
                        <div style="margin-top: -15px; font-size: 16px; font-weight: bold;" id="progress-text">0%</div>
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

            // Remove Item
            sessionStorage.removeItem('productName');
            sessionStorage.removeItem('port');
            sessionStorage.removeItem('mobile');
            sessionStorage.removeItem('quantity');
            sessionStorage.removeItem('unit');
        });
    </script>
@endpush
