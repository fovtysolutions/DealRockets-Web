<?php
// Variables for form content
$nameQuote = 'Post Your Sourcing Request Now';
$keyword = 'Product name or keywords';
$description = 'Product description';
$quantity = 'Product Quantity';
$inputType = 'text';

// Retrieve quotation data from the database
$quotationbanner = \App\Models\BusinessSetting::where('type', 'quotation')->first();
$quotationdata = $quotationbanner ? json_decode($quotationbanner->value, true) : [];

// Handle null or missing data
$quotationDescription = isset($quotationdata['description']) ? $quotationdata['description'] : '';
?>
<section class="mainpagesection custom-dealrock-banner-large" style="background-color: var(--web-bg);">
    <div class="rfq-section bg-shimmer"
        data-bg="linear-gradient(to right, rgb(0 0 0 / 68%), rgb(0 0 0 / 0%)), url(/img/rfq-image-1.png)" data-bgtype='withlinear'>
        <div class="hiddenuntil768"> Request For Quotations (RFQ)</div>
        <div class="rfq-info">
            <h2>Request for Quotations (RFQ)</h2>
            <p class="rfq-description" id="rfq-description">
                <?php echo $quotationDescription; ?> <!-- Display the quotation description or default message -->
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
                <input type="text" name="productName" placeholder="Please enter a specific product name" required>
                <input type="text" name="port" placeholder="Please enter a Port" required>
                <input type="tel" placeholder="Enter your mobile number" name="mobile" required>
                <div class="quantity-row">
                    <input type="number" name="quantity" placeholder="Quantity" required>
                    <select name="unit" required>
                        <option value="" disabled selected>Select Unit</option>
                        <!-- Weight Units -->
                        <option value="mg">Milligram(s) (mg)</option>
                        <option value="g">Gram(s) (g)</option>
                        <option value="kg">Kilogram(s) (kg)</option>
                        <option value="tonne">Tonne(s) (t)</option>

                        <!-- Volume Units -->
                        <option value="ml">Millilitre(s) (ml)</option>
                        <option value="l">Litre(s) (l)</option>
                        <option value="cbm">Cubic Meter(s) (m³)</option>
                    </select>
                </div>
                <button type="button" id="quotationButton" class="submit-rfq">REQUEST FOR QUOTATIONS</button>
            </form>
        </div>
    </div>
</section>

<script defer>
    $(document).ready(function() {
        function fetchQuotationData() {
            $.ajax({
                url: '{{ route('rotating-leads') }}',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.status === 'success' && data.data) {
                        const quotation = data.data;
                        console.log(quotation);
                        const companyName = quotation.company_name ? quotation.company_name :
                            'Unknown';
                        const description = `
                            ${companyName} Company is looking for 
                            ${quotation.details ? quotation.details.substring(0, 50) + '...' : 'N/A'} 
                            and has received ${quotation.quotes_recieved} quotation(s).
                        `;
                        $('#rfq-description').text(description);
                    } else {
                        console.error('No RFQ data available or failed to fetch.');
                        $('#rfq-description').text(
                            'No RFQ data available. Please check back later.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching quotation data:', error);
                    $('#rfq-description').text('Error fetching data. Please try again later.');
                }
            });
        }
        fetchQuotationData();
        setInterval(() => {
            fetchQuotationData(); // Fetch every 30 seconds
        }, 30000);
    });
</script>

<script defer>
    function NeedLogin() {
        console.log('worked login!');
        toastr.info('You Need to Be Logged In to Continue');
        setTimeout(function() {
            window.location.href = "{{ route('customer.auth.login') }}";
        }, 2000);
    };

    $('#quotationButton').on('click', function(event) {
        event.preventDefault();
        const form = $(this).closest('form');
        const formData = new FormData(form[0]);

        // Validate if required fields are filled
        if (!formData.get('productName') || !formData.get('port') || !formData.get('mobile') || !formData.get(
                'quantity') || !formData.get('unit')) {
            toastr.error('Please fill all required fields.');
            return;
        }

        // Store the Quotation Data
        sessionStorage.setItem('productName', formData.get('productName'));
        sessionStorage.setItem('port', formData.get('port'));
        sessionStorage.setItem('mobile', formData.get('mobile'));
        sessionStorage.setItem('quantity', formData.get('quantity'));
        sessionStorage.setItem('unit', formData.get('unit'));

        window.location.href = "{{ route('quotationweb') }}";
    });
</script>
