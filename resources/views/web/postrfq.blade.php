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
                            <div class="form-row form-row-for-phone">
                                <label class="label-width">Product Name</label>
                                <input class="contact-input counter-fields" name="product_name" type="text" placeholder="Enter product name" value="{{ old('product_name') }}" />
                            </div>


                            <div class="form-row form-row-for-phone">
                                <label class="label-width">Category</label>
                                <select class="contact-input counter-fields" name="category">
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <div class="d-flex w-100 maincontainer">
                                    <div class="leftcontainer">
                                        <div class="form-row">
                                            <div class="innerleftcontainer">
                                                <label class="label-width">Purchase Quantity</label>
                                            </div>
                                            <div class="innerrightcontainer">
                                                <input class="contact-input counter-fields" name="purchase_quantity" type="number" placeholder="0"
                                                    style="max-width: 150px;" />
                                                <select class="contact-input counter-fields" name="unit_unit" style="max-width: 150px;">
                                                    <option value="">Select a Unit</option>
                                                    <option value="Pc" {{ old('unit_unit') == "Pc" ? 'selected' : '' }}>Piece(s)</option>
                                                    <option value="Kg" {{ old('unit_unit') == "Kg" ? 'selected' : '' }}>Kg(s)</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-row">
                                            <div class="innerleftcontainer">
                                                <label class="label-width">Target Unit Price</label>
                                            </div>
                                            <div class="innerrightcontainer">
                                                <input class="contact-input counter-fields" name="target_unit_price" type="number" placeholder="0.00"
                                                    style="max-width: 150px;" />
                                                <select class="contact-input counter-fields" name="target_unit_price_currency" style="max-width: 150px;">
                                                    <option value="">Select a Currency</option>
                                                    <option value="usd" {{ old('target_unit_price_currency') == "usd" ? 'selected' : '' }}>USD</option>
                                                    <option value="eur" {{ old('target_unit_price_currency') == "eur" ? 'selected' : '' }}>EUR</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Trade Terms -->
                                        <div class="form-row width-form-phone float-phone">
                                            <div class="innerleftcontainer">
                                                <label class="label-width">Trade Terms</label>
                                            </div>
                                            <div class="innerrightcontainer">
                                                <select class="contact-input counter-fields" name="trade_terms" style="max-width: 300px;">
                                                    <option value="">Select Trading Terms</option>
                                                    <option value="fob" {{ old('trade_terms') == "eur" ? 'selected' : '' }}>FOB</option>
                                                    <option value="cif" {{ old('trade_terms') == "eur" ? 'selected' : '' }}>CIF</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-row width-form-phone">
                                            <div class="innerleftcontainer">
                                                <label class="label-width">Max Budget</label>
                                            </div>
                                            <div class="innerrightcontainer">
                                                <input class="contact-input counter-fields" name="max_budget" style="max-width: 150px;">
                                                <select class="contact-input counter-fields" name="max_budget_currency" style="max-width: 150px;">
                                                    <option value="">Select Currency</option>
                                                    <option value="usd" {{ old('max_budget_currency') == "eur" ? 'selected' : '' }}>USD</option>
                                                    <option value="eur" {{ old('max_budget_currency') == "eur" ? 'selected' : '' }}>EUR</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-end rightcontainer">
                                        <div class="form-row image-upload">
                                            <!-- Hidden file input -->
                                            <input type="file" id="imageInput" accept="image/*" name="image" style="display: none;" class=" counter-fields"/>

                                            <!-- Clickable upload box -->
                                            <div class="upload-box" id="uploadBox">
                                                <div class="text-center">
                                                    <i class="fa-solid fa-cloud-arrow-up fa-2x mb-2 text-secondary"></i><br>
                                                    Upload Image
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Purchase Quantity + Unit -->
                                    </div>
                                </div>

                                <!-- Details (Textarea) -->
                                <div class="form-row">
                                    <label class="label-width">Details</label>
                                    <textarea class="contact-input counter-fields" rows="1" name="details" placeholder="Describe product requirements..."></textarea>
                                </div>
                                <hr>
                                <div class="section-heading mt-3">Shipping and Payment</div>
                                <div class="form-row">
                                    <label class="label-width">Contact Number</label>
                                    <input class="contact-input counter-fields" type="text" placeholder="Contact Number" name="contact_number" style="max-width: 200px;">
                                </div>
                                <div class="form-row">
                                    <label class="label-width">Shipping Method</label>
                                    <select class="contact-input counter-fields" name="shipping_method" style="max-width: 200px;">
                                        <option value="">Select Shipping Method</option>
                                        <option value="sea_freight">Sea freight</option>
                                    </select>
                                </div>
                                <div class="form-row">
                                    <label class="label-width">Destination Port</label>
                                    <input class="contact-input counter-fields" type="text" name="destination_port" placeholder=""style="max-width: 200px;"/>
                                    <select class="contact-input counter-fields" name="destination_port_currency" style="max-width: 150px;">
                                        <option value="">Select Currency</option>
                                        <option value="usd">USD</option>
                                        <option value="eur">EUR</option>
                                    </select>

                                </div>
                                <div class="form-row width-form-phone float-phone">
                                    <label class="label-width">Lead time</label>
                                    <span style="margin-left: 5px; font-weight: bold;">Spin in</span>
                                    <input class="contact-input counter-fields" name="spin_time" type="text" placeholder="" style="max-width: 200px;" />

                                    <span style="margin-left: 5px; font-weight: bold; " class="hide-span">day(s) after
                                        supplier
                                        receives the initial payment.</span>
                                </div>
                                <div class="form-row width-form-phone">
                                    <label class="label-width padding-phone">Payment Terms</label>
                                    <select class="contact-input counter-fields" name="terms" style="max-width: 200px;">
                                        <option value="">Select Payment Terms</option>
                                        <option value="t/t">T/T</option>
                                        <option value="cif">CIF</option>
                                    </select>
                                </div>
                                <div class="form-row" style="justify-content: end;">
                                    <button type="submit" class="btn submit-rfq  px-4">Submit</button>
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
                unit_selector.find('option').each(function(){
                    var option = $(this);
                    if (option.val() === unit) {
                        option.prop('selected',true);
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
