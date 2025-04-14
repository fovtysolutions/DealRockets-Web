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
      <p class="rfq-description" id="rfq-description">
          tester
      </p>      
      <a href="{{ route('seller') }}" class="view-more" style="text-decoration: none;">View More</a>
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
  console.log('validjs');
  $(document).ready(function() {
    function fetchQuotationData(){
      $.ajax({
        url: '{{ route('rotating-leads') }}',
        type: 'GET',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Ensure this meta tag is present
        },
        success: function(data) {
          if (data.status === 'success') {
            const quotation = data.data;
            console.log(quotation); // Log the fetched quotation data
            // Update the RFQ description dynamically
            const companyName = quotation.company_name
              ? quotation.company_name[0] + '*'.repeat(quotation.company_name.length - 1)
              : 'Unknown';
            const description = `
              ${companyName} from ${quotation.country} is looking for 
              ${quotation.details ? quotation.details.substring(0, 50) + '...' : 'N/A'} 
              and has received ${quotation.quotes_recieved} quotation(s).
            `;
            $('#rfq-description').text(description); // Update the RFQ description in the DOM
          } else {
            console.error('Failed to fetch quotation data:', data.message);
            $('#rfq-description').text('No RFQ data available.');
          }
        },
        error: function(xhr, status, error) {
          console.error('Error fetching quotation data:', error);
        }
      });
    }
    fetchQuotationData(); // Initial fetch
    setInterval(() => {
      fetchQuotationData(); // Fetch every 30 seconds
    }, 30000);
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