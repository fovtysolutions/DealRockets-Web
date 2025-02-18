@extends('layouts.front-end.app')
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/stocksalenew.css') }}" />
@section('title', translate('Stock Sale' . ' | ' . $web_config['name']->value))
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
        <span> <a href="/"> Home </a> / <a href="/stock-sale"> Stock Sale </a> </span>
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
        <div class="leadleftdivision">
            <div class="card shadow-sm rounded-3 p-4" style="background-color: #f8f9fa;">
                <h5 class="mb-2 text-center">Filter By Deadline</h5>
                <form method="GET" action="{{ route('stocksale') }}" id="filterForm">
                    <ul class="list-group p-3" style="background-color:white;border: 1px solid #e1dddd;">
                        <h6 class="m-3">Deadline</h6>
                        <div class="input-group mb-3">
                            <span class="input-group-text"> From: </span>
                            <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"> To: </span>
                            <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                        </div>
                        <h6 class="m-3">Quantity</h6>
                        <div class="input-group mb-3">
                            <span class="input-group-text"> Min: </span>
                            <input type="number" name="minqty" class="form-control" value="{{ request('minqty') }}">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"> Max: </span>
                            <input type="number" name="maxqty" class="form-control" value="{{ request('maxqty') }}">
                        </div>
                        <button type="submit" class="newleadsbutton" id="filterButton">Filter</button>
                        <button type="reset" class="newleadsbutton" id="filterButton">Reset</button>
                    </ul>
                </form>
            </div>
            <div class="gapbetweens">
                <!-- Empty Gap -->
            </div>
            <div class="card shadow-sm rounded-3 p-4" style="background-color: #f8f9fa;">
                <form method="GET" action="{{ route('stocksale') }}" id="filterForm">
                    <h5 class="mb-2 text-center">Filter By Country</h5>
                    <div>
                        {{-- <h6 class="mb-3 text-secondary">Country</h6> --}}
                        <div class="list-group">
                            @foreach ($countrykeyvalue as $key => $value)
                                                        @php
                                                            $countryDetails = \App\Utils\ChatManager::getCountryDetails(
                                                                $value['countryid'],
                                                            );
                                                        @endphp
                                                        <div class="list-group-item d-flex justify-content-between align-items-center"
                                                            style="text-wrap-mode: nowrap;">
                                                            <a class="country-button  mb-0"
                                                                href="{{ route('buyer', ['country' => $value['countryid']]) }}"
                                                                data-code="{{ $countryDetails['countryISO2'] }}">
                                                                <img src="/images/flags/{{ strtolower($countryDetails['countryISO2']) }}.png"
                                                                    alt="{{ $countryDetails['countryName'] }} flag">
                                                                {{ $countryDetails['countryName'] }}
                                                            </a>
                                                            {{ $value['totquotes'] }}
                                                        </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- <div class="text-center mt-2">
                        <button type="button" class="btn btn-primary btn-lg w-75" id="filterButton">Apply
                            Filters</button>
                    </div> --}}
                </form>
            </div>
        </div>

        <!-- Center Section with Fixed Layout -->
        <div class="leadcenterdivision">
            <div class="card border-0" id="leadList" style="background-color: var(--web-bg); gap:22px;">
                @if(count($items) === 0)
                    <div class="leadsrelatedbox">
                        <p>No Stock Sale Found.</p>
                    </div>
                @else
                            @foreach($items as $item)
                                        <div class="leadsrelatedbox">
                                            <div class="leadsrelatedboxcontent border-end border-secondary"
                                                style="border-right: 1px solid lightgrey;">
                                                <div class="d-flex">
                                                    <?php        $images = json_decode($item->image); ?>
                                                    <!-- Left Side: Array of 5 Images -->
                                                    <div class="flex-shrink-0 me-3" style="width: 215px;">
                                                        <!-- Loop to Display 5 Images -->
                                                        <div class="d-flex flex-row justify-content-between"
                                                            style="height: 100%; width: 100%; gap: 10px; position: relative;">

                                                            <!-- Static Image (first image) -->
                                                            <div class="image-container" id="imagestatic"
                                                                style="width: 100%; height: 100%; background-color: lightgrey; display: flex; justify-content: center; align-items: center; transition: opacity 0.3s ease;">
                                                                <img src="/<?= $images[0] ?>" alt="Image 1"
                                                                    style="max-width: 100%; max-height: 100%; object-fit: cover; aspect-ratio: 4/3;">
                                                            </div>

                                                            <!-- Hover Carousel -->
                                                            <div class="carousel-container" id="carouselstatic"
                                                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; opacity: 0; transition: opacity 0.3s ease;">
                                                                <div id="carouselExampleControls" class="carousel slide"
                                                                    data-bs-ride="carousel">
                                                                    <div class="carousel-inner">
                                                                        <?php        foreach ($images as $index => $image): ?>
                                                                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>"
                                                                            style="flex-shrink: 0; width: 100%; height: 100%; background-color: lightgrey; display: flex; justify-content: center; align-items: center;">
                                                                            <img src="/<?= $image ?>" alt="Image <?= $index + 1 ?>"
                                                                                style="max-width: 100%; max-height: 100%; object-fit: cover;">
                                                                        </div>
                                                                        <?php        endforeach; ?>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>


                                                    <!-- Right Side: Text Content -->
                                                    <div>
                                                        <a href="{{ route('stocksaleview', ['name' => $item->name, 'id' => $item->id]) }}">
                                                            <h6 class="mb-2 mt-2">{{ $item->name }}</h6>
                                                        </a>
                                                        <div class="d-flex">
                                                            <p class="bylinerelated mr-3">Min Quantity: {{ $item->quantity }}</p>
                                                            @php
                                                                $countryDetails = \App\Utils\ChatManager::getCountryDetails(
                                                                    $item->country,
                                                                );
                                                            @endphp

                                                            @if ($countryDetails['status'] == 200)
                                                                <p class="bylinerelated">Posted In: {{ $countryDetails['countryName'] }}
                                                                    <img class="leadsflags"
                                                                        src="/images/flags/{{ strtolower($countryDetails['countryISO2']) }}.png"
                                                                        alt="Flag of {{ $countryDetails['countryName'] }}" />
                                                            @else
                                                                <span>Flag</span>
                                                            @endif
                                                        </div>
                                                        <p>{{ $item->description }}</p>
                                                        @php
                                                            $sellerName = \App\Utils\ChatManager::getstockname($item->added_by);
                                                            $firstLetter = strtoupper(substr($sellerName, 0, 1));
                                                        @endphp

                                                        <p class="bylinerelated my-3 text-start text-capitalize">
                                                            <span class="rounded-box">{{ $firstLetter }}</span> {{ $sellerName }}
                                                        </p>

                                                        @php
                                                            // Convert the posted_date to a Carbon instance
                                                            $postedDate = \Carbon\Carbon::parse($item->created_at);

                                                            // Calculate the difference in days from the current date
                                                            $daysAgo = $postedDate->diffInDays(\Carbon\Carbon::now());
                                                        @endphp

                                                        <p class="bylinerelated my-3 text-start">
                                                            Date Posted: {{ $daysAgo }} days ago ({{ $postedDate->format('F j, Y') }})
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="leadsrelatedboxbutton">
                                                @if(auth('customer')->check() && auth('customer')->user()->id)
                                                    @if($membership['status'] == 'active')
                                                        <button data-toggle="modal" data-target="#chatting_modalnew"
                                                            data-seller-id="{{ $item->user_id }}" data-role="{{ $item->role }}"
                                                            data-stock-id="{{ $item->id }}" data-typereq="stocksale" onclick="openChatModalnew(this)">
                                                            Contact Seller
                                                        </button>
                                                    @else
                                                        <a href="{{ route('membership') }}">
                                                            <button>
                                                                Contact Seller
                                                            </button>
                                                        </a>
                                                    @endif
                                                @else
                                                    <a href="{{ route('customer.auth.login') }}">
                                                        <button>
                                                            Contact Seller
                                                        </button>
                                                    </a>
                                                @endif
                                                <p class="bylinerelated m-1">{{ $item->quote_recieved }} quote Received</p>
                                            </div>
                                        </div>
                            @endforeach
                @endif
            </div>
            {{ $items->links() }}
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
                    <img src="storage/{{ $adimages['ad1_image'] }}" alt="Vendor Ad" class="ad-image">
                </div>
            </div>
            <div class="google-ad">
                <div class="ad-content">
                    <!-- Google Ad code goes here -->
                    <img src="storage/{{ $adimages['ad2_image'] }}" alt="Google Ad" class="ad-image">
                </div>
            </div>
        </div>
    </div>
    @if (!request()->has('country'))
        <div class="d-flex w-100" style="border-radius: 10px;">
            <div class="filter-container">
                <h5 class="filter-header">
                    Filter by Country
                </h5>
                <div class="filter-description">
                    Choose a country to filter by. You can select multiple countries, and they will appear as tags
                    below.
                </div>
                <!-- Country Buttons -->
                <div class="country-buttons">
                    @foreach ($countries as $key => $value)
                                @php
                                    $countryDetails = \App\Utils\ChatManager::getCountryDetails($value);
                                @endphp
                                <a class="country-button" href="{{ route('stocksale', ['country' => $value]) }}"
                                    data-code="{{ $countryDetails['countryISO2'] }}">
                                    <img src="/images/flags/{{ strtolower($countryDetails['countryISO2']) }}.png"
                                        alt="{{ $countryDetails['countryName'] }} flag">
                                    Sellers From {{ $countryDetails['countryName'] }}
                                </a>
                    @endforeach
                </div>
                <!-- Display selected tags -->
                <div class="selected-tags" id="selectedTags"></div>
            </div>
        </div>
    @endif
</div>
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
    function SearchbyCountry() {
        var countryId = document.getElementById('countryselector').value;
        if (countryId) {
            window.location.href = '/stock-sale?country=' + countryId;
        } else {
            alert('Please Select a Country');
        }
    }
</script>
<script>
    $(document).ready(function () {
        const $imageContainer = $('#imagestatic');
        const $carouselContainer = $('#carouselstatic');

        if ($imageContainer.length && $carouselContainer.length) {
            $imageContainer.on('mouseenter', function () {
                console.log('mouse entered');
                $imageContainer.css('opacity', 0); // Hide the static image
                $carouselContainer.css('opacity', 1); // Show the carousel
            });

            $imageContainer.on('mouseleave', function () {
                console.log('mouse left');
                $imageContainer.css('opacity', 1); // Show the static image
                $carouselContainer.css('opacity', 0); // Hide the carousel
            });
        }
    });
</script>
@endsection