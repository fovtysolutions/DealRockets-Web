@extends('layouts.front-end.app')
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/stocksalenew.css') }}" />
@section('title')
Stock Sale - {{ $leadrequest->name }} | {{ $web_config['name']->value }}
@endsection
@section('content')
<?php
$categories = \App\Utils\CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
$unread = \App\Utils\ChatManager::unread_messages();
if (Auth('customer')->check()) {
    $membership = \App\Utils\ChatManager::getMembershipStatusCustomer(Auth('customer')->user()->id);
    if (isset($membership['error'])) {
        $membership = ['status' => 'NotMade', 'message' => 'Membership Not Applied'];
    }
}
$userdata = \App\Utils\ChatManager::getRoleDetail();
$user_id = $userdata['user_id'];
$role = $userdata['role'];
?>
<style>
    .leadpagedivision {
        background-color: var(--web-bg);
    }

    .gapbetweens {
        height: 22px;
        background-color: var(--web-bg);
    }

    .fade-in-on-scroll {
        width: 100%;
    }

    .__inline-9 {
        background-color: var(--web-bg);
    }
</style>
<div class="mainpagesection">
<div style="border-radius:10px;">
        {{-- Banner --}}
        <img class="w-100 topclassbanner" src="{{ asset('storage/' . $stocksalebanner['banner_image']) }}" alt="Banner">
    </div>
    <div class="gapbetweens border-0 rounded-0">
        <!-- Empty Gap -->
    </div>
    <div class="card border-0 rounded-0" style="background-color: var(--web-bg);">
        <span> <a href="/"> Home </a> / <a href="/stock-sale"> Stock Sale </a>  /
        {{ $leadrequest->name }}</span></span>
    </div>
    <div class="gapbetweens border-0 rounded-0">
        <!-- Empty Gap -->
    </div>
    <div class="card border-0 rounded-0" style="background-color: var(--web-bg);">
        <h4><strong>Find Best Stocks in Sale!</strong></h4>
    </div>
    <div class="gapbetweens border-0 rounded-0">
        <!-- Empty Gap -->
    </div>
    <div class="card border-0 rounded-0 hrhhr">
        <!-- Buyers label on the left -->
        <div class="rrrh">
            <div class="btnbuyer" style="color: white;">
                Stock Sale
            </div>
        </div>

        <!-- Container for the Search bar and Counter (right side) -->
        <div class="egrrgr">
            <!-- Search bar in the center -->
            <div class="hrrgr">
                <div class="main-search" style="width: 100%;">
                    <form action="{{ route('stocksale') }}" method="GET" id="header_search_bar">
                        <div class="search-field-cont" style="position: relative; display: flex; align-items: center;">
                            <!-- Input field for search -->
                            <input type="text" name="search_query" id="search_query" class="form-control dbbe"
                                placeholder="Search..." required="">
                            <!-- Magnifying glass icon -->
                            <button type="submit" class="text-white pl-2 pr-2 h-100 rrwbrwbr">
                                <i class="fa fa-search" style="font-size: 18px;"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Counter on the right -->
            <div class="rfbrbrrbr">
                <div class="counter" style="text-align: right;">
                    Sale's Total Count
                    <span class="counteractual">{{ $counttotal }}</span> <!-- Replace with actual counter logic -->
                </div>
            </div>

        </div>
    </div>
    <div class="gapbetweens">
        <!-- Empty Gap -->
    </div>
    <div class="leadpagedivision">
        <!-- Center Section with Fixed Layout -->
        <div class="leadcenterdivision w-100" style="margin-top:20px;">
            <div class="carddetails">
                <div class="detailleft">
                    <h5 class="text-truncate">{{ $leadrequest->name }}</h5>
                    <div class="attr-content">
                        <div class="attr-left">
                            <ul class="nleftattr">
                                @php
                                    $sellerName = \App\Utils\ChatManager::getsellername($leadrequest->added_by);
                                    $firstLetter = strtoupper(substr($sellerName, 0, 1));
                                @endphp
                                <li><span>Purchaser</span>
                                    <div>
                                        <span class="rounded-box">{{ $firstLetter }}</span> {{ $sellerName }}
                                    </div>
                                </li>
                                @php
                                    $countryDetails = \App\Utils\ChatManager::getCountryDetails($leadrequest->country);
                                @endphp
                                @if ($countryDetails['status'] == 200)
                                    <li>
                                        <span>Country/Region</span>
                                        <div style="display: inline-block;margin-left: -5px;">
                                            {{ $countryDetails['countryName'] }} <img class="leadsflags"
                                                src="/images/flags/{{ strtolower($countryDetails['countryISO2']) }}.png"
                                                alt="Flag of {{ $countryDetails['countryName'] }}" />
                                        </div>
                                    </li>
                                @else
                                    <span>Flag</span>
                                @endif
                                @php
                                    // Convert the posted_date to a Carbon instance
                                    $postedDate = \Carbon\Carbon::parse($leadrequest->posted_date);

                                    // Calculate the difference in days from the current date
                                    $daysAgo = $postedDate->diffInDays(\Carbon\Carbon::now());
                                @endphp
                                <li><span>Posted</span>{{ $daysAgo }} days ago ({{ $postedDate->format('F j, Y') }}) </li>
                                <div class="newattr-right">
                                <li>Quantity Required <span>{{ $leadrequest->quantity }}</span> </li>
                                <li>Buying Frequency <span class="text-capitalize">One Time
                                    </span> </li>
                                </div>
                                
                            </ul>

                            <h6 class="rel-wrapper">
                                Stock Sale Details
                            </h6>
                            <p class="b-desc">{{ $leadrequest->description }}</p>
                                @if (auth('customer')->check() && auth('customer')->user()->id)
                                    @if ($membership['status'] == 'active')
                                        <a style="margin-top: 20px !important;" href="#" class="view-buyers-btn text-white"
                                            title="Contact Buyer" data-toggle="modal" data-target="#chatting_modalnew"
                                            data-seller-id="{{ $leadrequest->added_by }}"
                                            data-user-type="{{ $leadrequest->role }}" data-role="{{ $role }}"
                                            data-leads-id="{{ $leadrequest->id }}" data-typereq="stocksale"
                                            data-shop-name="{{ $shopName }}" onclick="openChatModalnew(this)">
                                            Contact Seller
                                        </a>
                                    @else
                                        <a style="margin-top: 20px !important;" href="{{ route('membership') }}" class="view-buyers-btn text-white"
                                            title="Contact Buyer">
                                            Contact Seller
                                        </a>
                                    @endif
                                @else
                                    <a style="margin-top: 20px !important;" href="{{ route('customer.auth.login') }}" class="view-buyers-btn text-white"
                                        title="Contact Buyer">
                                        Contact Seller
                                    </a>
                                @endif
                            <!-- <a style="margin-top: 5px;" class="btn-red btn-contact btn-contact-wrapper"
                                title="Submit a Similar Request ">Submit
                                a Similar Request </a> -->
                        </div>
                        <div class="attr-right">
                            <ul class="nleftattr">
                                <li>Quantity Required <span>{{ $leadrequest->quantity }}</span> </li>
                                <li>Buying Frequency <span class="text-capitalize">One Time
                                    </span> </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="detailright">
                    <a class="view-buyers-btn text-white" title="View All buyers from Netherlands"
                        style="border-bottom:0px;margin:auto; pointer-events:all;" href="#" onclick="SearchbyCountry({{ $leadrequest->country }})">
                        View All Stock Sale's from {{ $countryDetails['countryName'] }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="chatting_modalnew" tabindex="-1" role="dialog" aria-labelledby="chatModalNewLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-faded-info">
                        <h6 class="modal-title text-capitalize" id="chatModalNewTitle"></h6>
                        <button type="button" class="text-white close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="seller-chat-form">
                            @csrf
                            <input type="hidden" name="typereq" id="typereq" value="">
                            <input type="hidden" name="leads_id" id="leads_id" value="">
                            <input type="hidden" name="sender_id" id="sender_id" value="{{ $user_id }}">
                            <input type="hidden" name="sender_type" id="sender_type" value="{{ $role }}">
                            <input type="hidden" name="receiver_id" id="receiver_id" value="">
                            <input type="hidden" name="receiver_type" id="receiver_type" value="">
                            <textarea name="message" class="form-control min-height-100px max-height-200px" required
                                placeholder="{{ translate('Write_here') }}..."></textarea>
                            <br>
                            <div class="justify-content-end gap-2 d-flex flex-wrap">
                                <button type="button" class="btn btn--primary text-white"
                                    id="send-message-btn">{{ translate('send') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Right Section with Ads -->
    <div class="leadrightdivision">
        <div class="ad-section">
            <div class="vendor-ad">
                <div class="ad-content">
                    <!-- Replace with actual vendor ad content -->
                    <img src="/storage/{{ $adimages['ad1_image'] }}" alt="Vendor Ad" class="ad-image">
                </div>
            </div>
            <div class="google-ad">
                <div class="ad-content">
                    <!-- Google Ad code goes here -->
                    <img src="/storage/{{ $adimages['ad2_image'] }}" alt="Google Ad" class="ad-image">
                </div>
            </div>
        </div>
    </div>
</div>
@include('web.partials.loginmodal')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    // Handle form submission with AJAX
    $('#send-message-btn').on('click', function (e) {
        e.preventDefault(); // Prevent default form submission

        // Collect form data
        var formData = {
            sender_id: $('#sender_id').val(),
            sender_type: $('#sender_type').val(),
            receiver_id: $('#receiver_id').val(),
            receiver_type: $('#receiver_type').val(),
            type: $('#typereq').val(),
            leads_id: $('#leads_id').val(),
            message: $('textarea[name="message"]').val(),
            _token: $('input[name="_token"]').val() // CSRF token
        };

        // Send AJAX POST request
        $.ajax({
            url: '{{ route('sendmessage.other') }}', // Backend route
            type: 'POST',
            data: formData,
            success: function (response) {
                toastr.success('Message sent successfully!', 'Success');
                $('#chatting_modalnew').modal('hide'); // Hide modal
            },
            error: function (xhr, status, error) {
                // Handle errors
                toastr.error('An error occurred while sending the message.', 'Error');
            }
        });
    });
</script>
<script>
    function openChatModalnew(button) {
        // Extract data from button attributes
        const sellerId = button.getAttribute('data-seller-id');
        const shopName = button.getAttribute('data-shop-name');
        const role = button.getAttribute('data-role');
        const leadsId = button.getAttribute('data-leads-id');
        const typereq = button.getAttribute('data-typereq');

        // Update modal title
        document.getElementById('chatModalNewTitle').innerText = `Chat with ${shopName}`;

        // Populate form hidden inputs
        document.getElementById('typereq').value = typereq;
        document.getElementById('leads_id').value = leadsId;
        document.getElementById('receiver_id').value = sellerId;
        document.getElementById('receiver_type').value = role;
    }
</script>
<script>
    // Define the filterLeads function globally
    function filterLeads() {
        // Gather Filter Data
        let fromDateInput = document.querySelector('input[name="from"]');
        let toDateInput = document.querySelector('input[name="to"]');
        let selectedCountries = Array.from(document.querySelectorAll('input[name="countries[]"]:checked')).map(function (
            checkbox) {
            return checkbox.value;
        });

        let fromDate = new Date(fromDateInput.value);
        let toDate = new Date(toDateInput.value);

        // Filter Leads
        let leadBoxes = document.querySelectorAll('#leadList .leadsrelatedbox');
        leadBoxes.forEach(function (box) {
            let leadDate = new Date(box.getAttribute('data-posted-date'));
            let leadCountry = box.getAttribute('data-country');

            let dateMatch = true;
            if (!isNaN(fromDate) && leadDate < fromDate) {
                dateMatch = false;
            }
            if (!isNaN(toDate) && leadDate > toDate) {
                dateMatch = false;
            }

            let countryMatch = selectedCountries.length === 0 || selectedCountries.includes(leadCountry);

            // Show or hide lead based on filters
            if (dateMatch && countryMatch) {
                box.style.display = 'flex';
            } else {
                box.style.display = 'none';
            }
        });
    }

    // Attach the filter function to the button click
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('filterButton').addEventListener('click', function () {
            filterLeads();
        });
    });
</script>
<script>
    function SearchbyCountry(id) {
        if (id) {
            window.location.href = '/stock-sale?country=' + id;
        } else {
            alert('Please Select a Country');
        }
    }
</script>
<script>
    // Function to open the login modal
    function openLoginModal() {
        $('#loginModal').modal('show');
    }
</script>
@endsection