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

$units = ['pc' => 'Piece(s)', 'kg' => 'Kilogram(s)', 'g' => 'Gram(s)', 'mg' => 'Milligram(s)', 'ltr' => 'Liter(s)', 'ml' => 'Milliliter(s)', 'cbm' => 'Cubic Meter(s)', 'cm' => 'Centimeter(s)', 'm' => 'Meter(s)', 'in' => 'Inch(es)', 'ft' => 'Foot/Feet', 'yd' => 'Yard(s)', 'sqft' => 'Square Foot/Feet', 'sqm' => 'Square Meter(s)', 'dozen' => 'Dozen', 'box' => 'Box(es)', 'pack' => 'Pack(s)', 'roll' => 'Roll(s)', 'set' => 'Set(s)', 'bottle' => 'Bottle(s)'];
$payment_terms = [
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
];
$shipping_method = [
    'sea_fcl' => 'Sea Freight (FCL - Full Container Load)',
    'sea_lcl' => 'Sea Freight (LCL - Less than Container Load)',
    'sea_bulk' => 'Sea Freight (Bulk)',
    'air_freight' => 'Air Freight',
    'air_express' => 'Air Express',
    'rail_freight' => 'Rail Freight',
    'rail_container' => 'Rail Container Transport',
    'road_freight' => 'Road Freight',
    'road_truck' => 'Road Transport (Truck)',
    'road_ltl' => 'Road Freight (LTL - Less than Truckload)',
    'road_ftl' => 'Road Freight (FTL - Full Truckload)',
    'courier_express' => 'Courier (Express)',
    'courier_standard' => 'Courier (Standard)',
    'multimodal' => 'Multimodal Transport',
    'pickup' => 'Local Pickup',
    'dropoff' => 'Local Dropoff',
];
?>
<section class="mainpagesection custom-dealrock-banner-large" style="background-color: var(--web-bg);">
    <div class="rfq-section bg-shimmer"
        data-bg="linear-gradient(to right, rgb(0 0 0 / 68%), rgb(0 0 0 / 0%)), url(/img/rfq-image-1.png)"
        data-bgtype='withlinear'>
        <div class="hiddenuntil768"> Request For Quotations (RFQ)</div>
        <div class="rfq-info ">
            <h2 class="custom-dealrock-text-30">Request for Quotations (RFQ)</h2>
            <p class="rfq-description" id="rfq-description">
                <?php echo $quotationDescription; ?> <!-- Display the quotation description or default message -->
            </p>
            <a href="{{ route('seller') }}" class="view-more custom-dealrock-text-18" style="text-decoration: none;">View More</a>
            <ul class="rfq-benefits custom-dealrock-text-18">
                <li>Submit an RFQ in just one minute.</li>
                <li>Get multiple quotations from Verified Suppliers.</li>
                <li>Compare and choose the best quotation!</li>
            </ul>
        </div>
        <div class="rfq-form-container">
            <form class="rfq-form container">
                <h3 class="mb-1 text-left custom-dealrock-text-18">Get Quotations Now from Verified Global Suppliers</h3>

                <div class="row">
                    <div class="col-md-4 mb-1">
                        <label for="productName" class="form-label custom-dealrock-text-14">Product Name</label>
                        <input type="text" class="form-control custom-dealrock-text-14" id="productName" name="productName"
                            placeholder="Enter specific product name" required>
                    </div>
                    <div class="col-md-4 mb-1">
                        <label for="port" class="form-label custom-dealrock-text-14">Port</label>
                        <input type="text" class="form-control custom-dealrock-text-14" id="port" name="port"
                            placeholder="Enter destination port" required>
                    </div>
                    <div class="col-md-4 mb-1">
                        <label for="mobile" class="form-label custom-dealrock-text-14">Mobile Number</label>
                        <input type="tel" class="form-control custom-dealrock-text-14" id="mobile" name="mobile"
                            placeholder="Enter your mobile number" required>
                    </div>
                </div>

                <div class="row mb-1">
                    <div class="col-md-6">
                        <label for="quantity" class="form-label custom-dealrock-text-14">Quantity</label>
                        <input type="number" class="form-control custom-dealrock-text-14" id="quantity" name="quantity" placeholder="Quantity"
                            required>
                    </div>
                    <div class="col-md-6">
                        <label for="unit" class="form-labelcustom-dealrock-text-14">Unit</label>
                        <select class="form-control custom-dealrock-text-14" id="unit" name="unit" required>
                            <option value="" disabled selected>Select Unit</option>
                            @foreach ($units as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-1">
                        <label for="shipping_method" class="form-label custom-dealrock-text-14">Shipping Method</label>
                        <select class="form-control custom-dealrock-text-14" id="shipping_method" name="shipping_method" required>
                            <option value="">Select Shipping Method</option>
                            @foreach ($shipping_method as $method => $label)
                                <option value="{{ $method }}"
                                    {{ old('shipping_method') == $method ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label for="terms" class="form-label custom-dealrock-text-14">Payment Terms</label>
                        <select class="form-control custom-dealrock-text-14" id="terms" name="terms" required>
                            <option value="">Select Payment Terms</option>
                            @foreach ($payment_terms as $term => $label)
                                <option value="{{ $term }}" {{ old('terms') == $term ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="label-width custom-dealrock-text-14">Details</label>
                        <textarea class="form-control custom-dealrock-text-14" rows="1" name="details"
                            placeholder="Describe product requirements..." required>{{ old('details') }}</textarea>
                    </div>
                </div>

                <div class="text-center">
                    <button type="button" id="quotationButton" class="filled-btn">
                        Request for Quotations
                    </button>
                </div>
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
        sessionStorage.setItem('details', formData.get('details'));
        sessionStorage.setItem('payment_terms', formData.get('terms'));
        sessionStorage.setItem('shipping_method', formData.get('shipping_method'));

        window.location.href = "{{ route('quotationweb') }}";
    });
</script>
