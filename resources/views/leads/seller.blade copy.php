@extends('layouts.front-end.app')
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/leads.css') }}" />
@section('title', translate('Sellers' . ' | ' . $web_config['name']->value))
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
    <?php
    $settingsp = \App\Models\BusinessSetting::where('type', 'seller')->first();
    $datap = $settingsp
        ? json_decode($settingsp['value'], true)
        : [
            'color' => '#000000',
        ];
    ?>
    <style>
        .leadpagedivision {
            background-color: var(--web-bg);
        }

        .gapbetweens {
            height: 22px;
            background-color: var(--web-bg);
        }

        /* body {
                background-color: <?= htmlspecialchars($datap['color']) ?>
        ;
        }

        */
        /* .fade-in-on-scroll {
            width: 100%;
        } */

        .__inline-9 {
            background-color: var(--web-bg);
        }

        .carousel-control-next,
        .carousel-control-prev {
            width: 5%;
        }

        .mainpagesection {
            background-color: unset;
        }

        .deal-assist-banner {
            margin-top: 22px;
        }

        .bylinerelated {
            margin-bottom: 2px;
        }
    </style>
    <div class="mainpagesection">
        <div style="border-radius:10px;">
            @if (empty($bannerimages))
                {{-- No Carousel Images --}}
            @else
                <div>
                    <div id="carousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($bannerimages as $key => $value)
                                <div class="carousel-item  {{ $key == 0 ? 'active' : '' }}">
                                    {{-- Banner --}}
                                    <img class="w-100 topclassbanner" src="{{ asset('storage/' . $value['img_path']) }}"
                                        alt="Banner">
                                </div>
                            @endforeach
                        </div>
                        @if (count($bannerimages) != 1)
                            <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                                <span style="font-size: 32px; color: black;"><i class="fa fa-arrow-circle-left"
                                        aria-hidden="true"></i></span>
                            </a>
                            <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                                <span style="font-size: 32px; color: black;"><i class="fa fa-arrow-circle-right"
                                        aria-hidden="true"></i></span>
                            </a>
                        @else
                            {{-- Show Nothing --}}
                        @endif
                    </div>
                </div>
            @endif
        </div>
        <div class="gapbetweens border-0 rounded-0">
            <!-- Empty Gap -->
        </div>
        <div class="card border-0 rounded-0" style="background-color: var(--web-bg);">
            <span> <a class="custom-dealrock-text" href="/"> Home </a> / <a class="custom-dealrock-text" href="/sellers"> Seller </a> </span>
        </div>
        {{-- <div class="gapbetweens border-0 rounded-0">
        <!-- Empty Gap -->
    </div>
    <div class="card border-0 rounded-0" style="background-color: var(--web-bg);">
        <h4><strong>List of Global B2B Sellers, Importers, and Purchase Managers</strong></h4>
    </div> --}}
        <div class="gapbetweens border-0 rounded-0">
            <!-- Empty Gap -->
        </div>
        <div class="card border-0 rounded-0 hrhhr">
            <!-- Buyers label on the left -->
            <div class="rrrh">
                <div class="btnbuyer custom-dealrock-subhead" style="color: white;">
                    Sellers
                </div>
            </div>

            <!-- Container for the Search bar and Counter (right side) -->
            <div class="egrrgr">
                <!-- Search bar in the center -->
                <div class="hrrgr">
                    <div class="main-search" style="width: 100%;">
                        <form action="{{ route('seller') }}" method="GET" id="header_search_bar"
                            style="padding-bottom: 0;margin-bottom: 0;">
                            <div class="search-field-cont" style="position: relative; display: flex; align-items: center; height: 100%;">
                                <!-- Input field for search -->
                                <input type="text" name="search_query" id="search_query" class="form-control dbbe"
                                    placeholder="Search..." required="">
                                <!-- Magnifying glass icon -->
                                <button type="submit" class="pl-2 pr-2 h-100 rrwbrwbr">
                                    <svg style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 512 512"
                                        fill="var(--web-hover)"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path
                                            d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Counter on the right -->
                <div class="rfbrbrrbr custom-dealrock-text">
                    <div class="counter" style="text-align: right;">
                        RFQ's Total Count
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
                <div class="shadow-sm p-3" style="background-color: white;display: flex;flex-direction: column;">
                    <form method="GET" action="{{ route('seller') }}" id="filterForm">
                        <h5 class="text-center custom-dealrock-subhead">Filter By Country</h5>
                        <div>
                            {{-- <h6 class="mb-3 text-secondary">Country</h6> --}}
                            <div class="list-group">
                                @foreach ($countrykeyvalue as $key => $value)
                                    @php
                                        $countryDetails = \App\Utils\ChatManager::getCountryDetails(
                                            $value['countryid'],
                                        );
                                    @endphp
                                    <div class="list-group-item d-flex justify-content-between align-items-center border-left-0 border-right-0"
                                        style="text-wrap-mode: nowrap;border-radius: unset;padding: 5px 10px 5px 10px;">
                                        <a class="country-button mb-0 text-truncate flex-row d-flex"
                                            href="{{ route('buyer', ['country' => $value['countryid']]) }}"
                                            data-code="{{ $countryDetails['countryISO2'] }}">
                                            <img src="/images/flags/{{ strtolower($countryDetails['countryISO2']) }}.png"
                                                alt="{{ $countryDetails['countryName'] }} flag">
                                            <h6 title="{{ $countryDetails['countryName'] }}" class="text-truncate p-0 m-0  custom-dealrock-text">
                                                {{ $countryDetails['countryName'] }}</h6>
                                        </a>
                                        <span
                                            style="color: black; padding: 5px 8px 5px 9px; border: 1px solid lightgrey;">{{ $value['totquotes'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="grrgrbr">
                            <a class="custom-dealrock-subhead" href="{{ route('leadcountry', ['type' => 'seller']) }}">
                                Show More
                            </a>
                        </div>
                        {{-- <div class="text-center mt-2">
                        <button type="button" class="btn btn-primary btn-lg w-75" id="filterButton">Apply
                            Filters</button>
                    </div> --}}
                    </form>
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
            </div>

            <!-- Center Section with Fixed Layout -->
            <div class=" leadcenterdivision">
                <div class="card border-0" id="leadList" style="background-color: var(--web-bg);">
                    @if (count($combinedLeadsPaginator) === 0)
                        <div class="leadsrelatedbox">
                            <p>No Leads Found.</p>
                        </div>
                    @else
                        @foreach ($combinedLeadsPaginator as $lead)
                            <div class="leadsrelatedbox" data-country="{{ $lead['leads']->country }}"
                                data-posted-date="{{ $lead['leads']->posted_date }}" style="margin-bottom:22px;">
                                <div class="leadsrelatedboxcontent border-end border-secondary">
                                    <a
                                        href="{{ route('sellerview', ['name' => $lead['leads']->name, 'id' => $lead['leads']->id]) }}">
                                        <h6 class="mb-2 mt-2 custom-dealrock-head">{{ $lead['leads']->name }}</h6>
                                    </a>
                                    <div class="d-flex">
                                        @php
                                            $productUnitPrice = null;
                                            $productUnit = null;

                                            if (!empty($lead['leads']->product_id)) {
                                                $product = App\Models\Product::find($lead['leads']->product_id); // Fetch product only once
                                                if ($product) {
                                                    $productUnitPrice = $product->unit_price;
                                                    $productUnit = $product->unit;
                                                }
                                            }

                                            // Fallback to stock unit if product unit is not available
                                            $stockUnit = $lead['leads']->unit ?? 'pc';
                                        @endphp

                                        <p class="bylinerelated mr-3 custom-dealrock-text">
                                            Rate: {{ $productUnitPrice ?? 'N/A' }} per {{ $productUnit ?? $stockUnit }}
                                        </p>

                                        @php
                                            $countryDetails = \App\Utils\ChatManager::getCountryDetails(
                                                $lead['leads']->country,
                                            );
                                        @endphp
                                        </p>
                                    </div>
                                    <div class="d-flex custom-dealrock-text">
                                        <p class="bylinerelated mr-1">Term:
                                            {{ $lead['leads']->term ?? 'No Term Specified' }}
                                        </p>
                                    </div>
                                    <div class="d-flex custom-dealrock-text">
                                        <p class="bylinerelated mr-1">MOQ:
                                            {{ $lead['leads']->quantity_required }}
                                        </p>
                                    </div>
                                    <div class="d-flex custom-dealrock-text">
                                        <p class="bylinerelated mr-1">Packing: Wrapped
                                        </p>
                                    </div>
                                    <p>{{ $lead['leads']->details }}</p>
                                    @php
                                        $sellerName = \App\Utils\ChatManager::getsellername($lead['leads']->added_by);
                                        $firstLetter = strtoupper(substr($sellerName, 0, 1));
                                    @endphp

                                    <div class="d-flex" style="justify-content: space-between;">
                                        <p class="bylinerelated text-start text-capitalize custom-dealrock-text m-0">
                                            <span class="rounded-box" style="color: white;">{{ $firstLetter }}</span> {{ $sellerName }} - {{$lead['leads']->company_name ?? 'No Company Added'}}
                                        </p>
                                        @if ($countryDetails['status'] == 200)
                                        <p class="bylinerelated text-start text-capitalize custom-dealrock-text m-0 align-content-center">Origin: {{ $countryDetails['countryName'] }}
                                            <img class="leadsflags"
                                                src="/images/flags/{{ strtolower($countryDetails['countryISO2']) }}.png"
                                                alt="Flag of {{ $countryDetails['countryName'] }}" />
                                        @else
                                            <span>Flag</span>
                                        @endif
                                        <p>
                                            {{-- Empty Tag --}}
                                        </p>
                                    </div>

                                    @php
                                        // Convert the posted_date to a Carbon instance
                                        $postedDate = \Carbon\Carbon::parse($lead['leads']->posted_date);

                                        // Calculate the difference in days from the current date
                                        $daysAgo = $postedDate->diffInDays(\Carbon\Carbon::now());
                                    @endphp

                                    <p class="bylinerelated my-3 text-start custom-dealrock-text">
                                        Date Posted: {{ $daysAgo }} days ago ({{ $postedDate->format('F j, Y') }})
                                    </p>
                                </div>
                                <div class="leadsrelatedboxbutton">
                                    @if (auth('customer')->check() && auth('customer')->user()->id)
                                        @if ($membership['status'] == 'active')
                                            <button data-toggle="modal" data-target="#chatting_modalnew"
                                                data-seller-id="{{ $lead['shop']['added_by'] }}"
                                                data-user-type="{{ $lead['leads']->role }}"
                                                data-role="{{ $lead['shop']['role'] }}"
                                                data-leads-id="{{ $lead['leads']->id }}" data-typereq="leads"
                                                data-shop-name="{{ $lead['shop']['shop_name'] }}"
                                                onclick="openChatModalnew(this)">
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
                                        <a href="javascript:void(0)" onclick="openLoginModal()">
                                            <button>
                                                Contact Seller
                                            </button>
                                        </a>
                                    @endif
                                    <p class="bylinerelated m-1 custom-dealrock-text">{{ $lead['leads']->quotes_recieved }} quote Received
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                {{ $combinedLeadsPaginator->links() }}
            </div>

            <!-- Modal -->
            <div class="modal fade" id="chatting_modalnew" tabindex="-1" role="dialog"
                aria-labelledby="chatModalNewLabel" aria-hidden="true">
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
    </div>
    @include('web.partials.loginmodal')
    <script>
        // Function to open the login modal
        function openLoginModal() {
            $('#exampleModalLong').modal('hide');
            $('#loginModal').modal('show');
        }
    </script>
    @include('web-views.partials._quotation')
    @include('web-views.partials._dealassist')
    @include('web-views.partials._trending-selection')
    @if (!request()->has('country'))
        <div class="d-flex mainpagesection" style="margin-top:22px;">
            <div class="filter-container">
                <h5 class="filter-header custom-dealrock-head">
                    Filter by Country
                </h5>
                <div class="filter-description custom-dealrock-subhead">
                    Choose a country to filter by. You can select multiple countries, and they will appear as tags
                    below.
                </div>
                <!-- Country Buttons -->
                <div class="country-buttons">
                    @foreach ($countries as $key => $value)
                        @php
                            $countryDetails = \App\Utils\ChatManager::getCountryDetails($value);
                        @endphp
                        <a class="country-button custom-dealrock-text" href="{{ route('seller', ['country' => $value]) }}"
                            data-code="{{ $countryDetails['countryISO2'] }}">
                            <img src="/images/flags/{{ strtolower($countryDetails['countryISO2']) }}.png"
                                alt="{{ $countryDetails['countryName'] }} flag">
                            Buyers From {{ $countryDetails['countryName'] }}
                        </a>
                    @endforeach
                </div>
                <!-- Display selected tags -->
                <div class="selected-tags" id="selectedTags"></div>
            </div>
        </div>
    @endif
    @if (!request()->has('industry'))
        <div class="d-flex mainpagesection" style="margin-top:22px;">
            <div class="filter-container">
                <h5 class="filter-header custom-dealrock-head">
                    Filter by Industry
                </h5>
                <div class="filter-description custom-dealrock-subhead">
                    Choose a Industry to filter by. You can select multiple Industry, and they will appear as tags
                    below.
                </div>
                <!-- Country Buttons -->
                <div class="country-buttons">
                    @foreach ($industries as $key => $value)
                        <div class="main-category">
                            <a class="country-button font-weight-bold  custom-dealrock-text"
                                href="{{ route('seller', ['industry' => $value]) }}">
                                {{ $value['name'] }}
                            </a>
                            {{-- @if ($value->childes->count() > 0)
                                    <div class="sub-category-list">
                                        @foreach ($value->childes as $sub_category)
                                        <a class="sub-category-button font-weight-normal" href="{{ route('seller', ['industry' => $sub_category['id']]) }}">
                                            {{ $sub_category['name'] }}
                                        </a>
                                        @if ($sub_category->childes->count() > 0)
                                        <div class="sub-sub-category-list">
                                            @foreach ($sub_category->childes as $sub_sub_category)
                                            <a class="sub-sub-category-button font-weight-light"
                                                href="{{ route('seller', ['industry' => $sub_sub_category['id']]) }}">
                                                {{ $sub_sub_category['name'] }}
                                            </a>
                                            @endforeach
                                        </div>

                                        @endif
                                        @endforeach
                                    </div>
                                    @endif --}}
                        </div>
                    @endforeach
                </div>
                <!-- Display selected tags -->
                <div class="selected-tags" id="selectedTags"></div>
            </div>
        </div>
    @endif
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // Handle form submission with AJAX
        $('#send-message-btn').on('click', function(e) {
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
                success: function(response) {
                    toastr.success('Message sent successfully!', 'Success');
                    $('#chatting_modalnew').modal('hide'); // Hide modal
                },
                error: function(xhr, status, error) {
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
            let selectedCountries = Array.from(document.querySelectorAll('input[name="countries[]"]:checked')).map(function(
                checkbox) {
                return checkbox.value;
            });

            let fromDate = new Date(fromDateInput.value);
            let toDate = new Date(toDateInput.value);

            // Filter Leads
            let leadBoxes = document.querySelectorAll('#leadList .leadsrelatedbox');
            leadBoxes.forEach(function(box) {
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
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('filterButton').addEventListener('click', function() {
                filterLeads();
            });
        });
    </script>
    <script>
        function SearchbyCountry() {
            var countryId = document.getElementById('countryselector').value;
            if (countryId) {
                window.location.href = '/sellers?country=' + countryId;
            } else {
                alert('Please Select a Country');
            }
        }
    </script>
    <script>
        function SearchbyIndustry() {
            var countryId = document.getElementById('industryselector').value;
            if (countryId) {
                window.location.href = '/sellers?industry=' + countryId;
            } else {
                alert('Please Select a Industry');
            }
        }
    </script>
@endsection
