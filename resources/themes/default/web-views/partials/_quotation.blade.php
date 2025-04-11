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
<section class="mainpagesection custom-dealrock-banner-large" style="background-color: var(--web-bg);">
    <div class="rfq-section">
      <div class="hiddenuntil768"> Request For Quotations (RFQ)</div>
        <div class="rfq-info">
          <h2>Request for Quotations (RFQ)</h2>
          <p class="rfq-description">Z********** from Pakistan is looking for Solar electric robot dog chil... and has received 0 quotation(s)</p>
          <button class="view-more">View More</button>
          <ul class="rfq-benefits">
            <li>Submit an RFQ in just one minute.</li>
            <li>Get multiple quotations from Verified Suppliers.</li>
            <li>Compare and choose the best quotation!</li>
          </ul>
        </div>
        <div class="rfq-form-container">
          <form class="rfq-form">
            <h3>Get Quotations Now</h3>
            <input type="text" placeholder="Please enter a specific product name" required>
            <div class="select-container">
              <select required>
                <option value="" disabled selected>Select Port</option>
                <option value="new-york">New York</option>
                <option value="los-angeles">Los Angeles</option>
                <option value="miami">Miami</option>
                <option value="seattle">Seattle</option>
              </select>
              <i class="fas fa-chevron-down"></i>
            </div>
            <input type="tel" placeholder="Enter your mobile number" required>
            <div class="quantity-row">
              <input type="number" placeholder="Quantity" required>
              <select>
                <option value="Bags">Bags</option>
                <option value="Pieces">Pieces</option>
                <option value="Boxes">Boxes</option>
                <option value="Tons">Tons</option>
              </select>
            </div>
            <button type="submit" class="submit-rfq">REQUEST FOR QUOTATIONS</button>
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