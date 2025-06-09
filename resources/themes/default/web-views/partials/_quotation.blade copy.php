<?php
// Variables for form content
$nameQuote = 'Post Your Sourcing Request Now';
$keyword = 'Product name or keywords';
$description = 'Product description';
$quantity = 'Product Quantity';
$inputType = 'text';
$quotationbanner =  \App\Models\BusinessSetting::where('type','quotation')->first()->value;
$quotationdata = json_decode($quotationbanner,true) ?? [];
?>
<style>
    .backbannersec{
        background-image: url('/images/rfq-banner.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        /* background-position: left; */
    }
    .custombg-rhgr{
        background-image: url('https://static.vecteezy.com/system/resources/thumbnails/022/978/121/small/abstract-white-and-grey-gradient-color-with-modern-geometric-background-for-graphic-design-element-vector.jpg');
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>
<section class="mainpagesection custom-dealrock-banner-small">
    <div class="quotation-sec backbannersec" style="background-image: url('{{ asset('storage/'. $quotationdata['banner'])}}')">
    {{-- <div class="quotation-sec backbannersec"> --}}
        <div class="quotation-txt">
            <h2 class="custom-dealrock-head" style="color:{{ $quotationdata['header_color'] }}">{{ $quotationdata['header'] ?? '' }}</h2>
            <div class="mb-4 custom-dealrock-subhead" style="color:{{ $quotationdata['subtext_color'] }}">{!! $quotationdata['subtext'] ?? '' !!}</div>
            {{-- <div class="h-100 align-content-end">
                <a href="{{ route('quotationweb') }}">Submit Your Request <span>&#8250;</span></a>
            </div> --}}
        </div>
        <div class="quotation-form custombg-rhgr p-3 mr-4 rounded shadow" style="max-width: 400px; margin: 0 auto; width: 100%;">
            <form id="quotationForm" action="{{ route('quotation.submit') }}" method="POST">
                <h3 class="title-form-qut text-center mb-3" style="font-size: 1.25rem;">Quotation Form</h3>
        
                <!-- Step Indicators -->
                {{-- <div class="step-progress position-relative mb-4">
                    <div class="step-line position-absolute top-50 start-0 w-100 translate-middle-y bg-secondary" style="height: 2px;"></div>
                    <div class="d-flex justify-content-between position-relative">
                        <span class="step-indicator rounded-circle bg-secondary" data-step="1"></span>
                        <span class="step-indicator rounded-circle bg-secondary" data-step="2"></span>
                        <span class="step-indicator rounded-circle bg-secondary" data-step="3"></span>
                    </div>
                </div> --}}
        
                <!-- Step 1 -->
                <div class="form-step" data-step="1">
                    <div class="mb-2">
                        <label for="productName" class="form-label fw-bold">Name:</label>
                        <input type="text" class="form-control form-control-sm" id="productName" name="name" value="{{ old('name') }}" required placeholder="Enter Name">
                    </div>
                    <div class="mb-2">
                        <label for="productDescription" class="form-label fw-bold">Description:</label>
                        <textarea class="form-control form-control-sm" id="productDescription" name="description" rows="2" required placeholder="Enter Description">{{ old('description') }}</textarea>
                    </div>
                </div>
        
                <!-- Step 2 -->
                <div class="form-step" data-step="2" style="display: none;">
                    <div class="mb-2">
                        <label for="purchaseQuantity" class="form-label fw-bold">Quantity:</label>
                        <input type="number" class="form-control form-control-sm" id="purchaseQuantity" name="quantity" value="{{ old('quantity') }}" min="1" required placeholder="Enter Quantity">
                    </div>
                    <div class="mb-2">
                        <label for="type" class="form-label fw-bold">Type:</label>
                        <input type="text" class="form-control form-control-sm" id="type" name="type" value="{{ old('type') }}" required placeholder="Enter Type">
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="form-step" data-step="3" style="display: none;">
                    <div class="mb-2">
                        <label for="country" class="form-label fw-bold">Country:</label>
                        <input type="text" class="form-control form-control-sm" id="country" name="country" value="{{ old('country') }}" required placeholder="Enter Country">
                    </div>
                    <div class="mb-2">
                        <label for="industry" class="form-label fw-bold">Industry:</label>
                        <input type="text" class="form-control form-control-sm" id="industry" name="industry" value="{{ old('industry') }}" required placeholder="Enter Industry">
                    </div>
                </div>
        
                <!-- Step 4 -->
                <div class="form-step" data-step="4" style="display: none;">
                    <div class="mb-2">
                        <label for="term" class="form-label fw-bold">Term:</label>
                        <input type="text" class="form-control form-control-sm" id="term" name="term" value="{{ old('term') }}" required placeholder="Enter Term">
                    </div>
                    <div class="mb-2">
                        <label for="unit" class="form-label fw-bold">Unit:</label>
                        <input type="text" class="form-control form-control-sm" id="unit" name="unit" value="{{ old('unit') }}" required placeholder="Enter Unit">
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="form-step" data-step="5" style="display: none;">
                    <div class="mb-2">
                        <label for="buyingFrequency" class="form-label fw-bold">Buying Frequency:</label>
                        <input type="text" class="form-control form-control-sm" id="buyingFrequency" name="buying_frequency" value="{{ old('buying_frequency') }}" required placeholder="Enter Buying Frequency">
                    </div>
                </div>
        
                <!-- Navigation Buttons -->
                <div class="d-flex justify-content-between mt-3">
                    @if(auth('customer')->check())
                        <button type="button" class="btn btn-secondary btn-sm px-4 mr-3" id="prevStep" style="display: none;">Previous</button>
                        <button type="button" class="btn btn-primary btn-sm px-4" id="nextStep">Next</button>
                        <button type="submit" class="btn btn-primary btn-sm px-4 ml-3" id="submitForm" style="display: none;">Submit</button>
                    @else
                        <button type="button" class="btn btn-secondary btn-sm px-4 mr-3" id="prevStep" onclick="$('#loginModal').modal('show')" style="display: none;">Previous</button>
                        <button type="button" class="btn btn-primary btn-sm px-4" id="nextStep" onclick="$('#loginModal').modal('show')">Next</button>
                        <button type="submit" class="btn btn-primary btn-sm px-4 ml-3" onclick="$('#loginModal').modal('show')" style="display: none;">Submit</button>
                    @endif
                </div>
            </form>
        </div>                               
    </div>
</section>
@include('web.partials.loginmodal')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const steps = document.querySelectorAll('.form-step');
        const indicators = document.querySelectorAll('.step-indicator');
        const prevButton = document.getElementById('prevStep');
        const nextButton = document.getElementById('nextStep');
        const submitButton = document.getElementById('submitForm');
        let currentStep = 1;

        function showStep(step) {
            steps.forEach(s => s.style.display = s.dataset.step == step ? 'block' : 'none');
            indicators.forEach((i, index) => {
                i.classList.toggle('bg-primary', index < step);
                i.classList.toggle('bg-secondary', index >= step);
            });
            prevButton.style.display = step > 1 ? '' : 'none';
            nextButton.style.display = step < steps.length ? '' : 'none';
            submitButton.style.display = step === steps.length ? '' : 'none';
        }

        nextButton.addEventListener('click', () => {
            if (currentStep < steps.length) {
                currentStep++;
                showStep(currentStep);
            }
        });

        prevButton.addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        });

        showStep(currentStep);
    });
</script>
<script>
    $(document).ready(function() {
        $('#quotationForm').on('submit', function(event) {
            event.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: '/quotation',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // Ensure this meta tag is present
                },
                success: function(response) {
                    toastr.success('Quotation submitted successfully!');
                    $('#quotationForm')[0].reset();
                },
                error: function(xhr, status, error) {
                    toastr.error('Error submitting quotation');
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
