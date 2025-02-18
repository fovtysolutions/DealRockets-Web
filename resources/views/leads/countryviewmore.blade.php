@extends('layouts.front-end.app')
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/leads.css') }}" />
@section('title', translate('Search By Country' . ' | ' . $web_config['name']->value))
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
    $settingsp = \App\Models\BusinessSetting::where('type', 'buyer')->first();
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
        .fade-in-on-scroll {
            width: 100%;
        }

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
    </style>
    <div class="mainpagesection">
        @if (!request()->has('country') && $type == 'buyer')
            <div class="d-flex w-100" style="margin-top: 22px;">
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
                        @foreach ($countrykeyvaluebuyer as $key => $value)
                            @php
                                $countryDetails = \App\Utils\ChatManager::getCountryDetails($value['countryid']);
                            @endphp
                            <a class="country-button" href="{{ route('buyer', ['country' => $value['countryid']]) }}"
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

        @if (!request()->has('country') && $type == 'seller')
            <div class="d-flex w-100" style="margin-top: 22px;">
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
                        @foreach ($countrykeyvalueseller as $key => $value)
                            @php
                                $countryDetails = \App\Utils\ChatManager::getCountryDetails($value['countryid']);
                            @endphp
                            <a class="country-button" href="{{ route('buyer', ['country' => $value['countryid']]) }}"
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
                window.location.href = '/buyers?country=' + countryId;
            } else {
                alert('Please Select a Country');
            }
        }
    </script>
    <script>
        function SearchbyIndustry() {
            var countryId = document.getElementById('industryselector').value;
            if (countryId) {
                window.location.href = '/buyers?industry=' + countryId;
            } else {
                alert('Please Select a Industry');
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            // Initialize carousel with auto-slide if needed
            $('#carousel').carousel({
                interval: 5000, // Slide every 3 seconds (optional)
                ride: 'carousel' // Start carousel on page load
            });
        });
    </script>
@endsection
