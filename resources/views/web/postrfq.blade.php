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

                        <form>

                            <div class="form-row form-row-for-phone">
                                <label class="label-width">Product Name</label>
                                <input class="contact-input" type="text" placeholder="Enter product name" />
                            </div>


                            <div class="form-row form-row-for-phone">
                                <label class="label-width">Category</label>
                                <select class="contact-input">
                                    <option>Select a category</option>
                                    <option>Health & Medicine</option>
                                    <option>Technology</option>
                                    <option>Education</option>
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
                                                <input class="contact-input" type="number" placeholder="0"
                                                    style="max-width: 150px;" />
                                                <select class="contact-input" style="max-width: 120px;">
                                                    <option>Piece(s)</option>
                                                    <option>Kg(s)</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-row">
                                            <div class="innerleftcontainer">
                                                <label class="label-width">Target Unit Price</label>
                                            </div>
                                            <div class="innerrightcontainer">
                                                <input class="contact-input" type="number" placeholder="0.00"
                                                    style="max-width: 150px;" />
                                                <select class="contact-input" style="max-width: 100px;">
                                                    <option>USD</option>
                                                    <option>EUR</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Trade Terms -->
                                        <div class="form-row width-form-phone float-phone">
                                            <div class="innerleftcontainer">
                                                <label class="label-width">Trade Terms</label>
                                            </div>
                                            <div class="innerrightcontainer">
                                                <select class="contact-input" style="max-width: 200px;">
                                                    <option>FOB</option>
                                                    <option>CIF</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-row width-form-phone">
                                            <div class="innerleftcontainer">
                                                <label class="label-width">Max Budget</label>
                                            </div>
                                            <div class="innerrightcontainer">
                                                <select class="contact-input" style="max-width: 200px;">
                                                    <option>Please select</option>
                                                    <option>500 USD</option>
                                                    <option>1000 USD</option>
                                                </select>
                                                <span style="margin-left: 5px;">USD</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-end rightcontainer">
                                        <div class="form-row image-upload">
                                            <!-- Hidden file input -->
                                            <input type="file" id="imageInput" accept="image/*" style="display: none;" />

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
                                    <textarea class="contact-input" rows="4" placeholder="Describe product requirements..."></textarea>
                                </div>
                                <hr>
                                <div class="section-heading">Shipping and Payment</div>
                                <div class="form-row">
                                    <label class="label-width">Shipping Method</label>
                                    <select class="contact-input" style="max-width: 147px;">
                                        <option>Sea freight</option>
                                        <option></option>
                                        <option></option>
                                    </select>

                                </div>
                                <div class="form-row">
                                    <label class="label-width">Destination Port</label>
                                    <input class="contact-input" type="text" placeholder="" style="max-width: 200px;" />
                                    <select class="contact-input" style="max-width: 100px;">
                                        <option>USD</option>
                                        <option>EUR</option>
                                    </select>

                                </div>
                                <div class="form-row width-form-phone float-phone">
                                    <label class="label-width">Lead time</label>
                                    <span style="margin-left: 5px; font-weight: bold;">Spin in</span>
                                    <input class="contact-input" type="text" placeholder="" style="max-width: 100px;" />

                                    <span style="margin-left: 5px; font-weight: bold; " class="hide-span">day(s) after
                                        supplier
                                        receives the initial payment.</span>
                                </div>
                                <div class="form-row width-form-phone">
                                    <label class="label-width padding-phone">Payment Terms</label>
                                    <select class="contact-input" style="max-width: 96px;">
                                        <option>T/T</option>
                                        <option>CIF</option>
                                    </select>
                                </div>
                                <div class="form-row" style="margin-left: 25%;">
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
@endpush
