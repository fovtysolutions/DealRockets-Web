@extends('layouts.front-end.app')
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/tradeshow.css') }}" />
@section('title', translate('Trade Shows' . ' | ' . $web_config['name']->value))
@section('content')
<style>
    .dropdown-item:hover label {
        color: white !important;
    }

    #detailsModal .modal-content {
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        background: #fff;
    }

    #detailsModal .modal-header {
        background: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        border-radius: 15px 15px 0 0;
    }

    #detailsModal .modal-title {
        font-weight: bold;
        color: #007bff;
    }

    #detailsModal .modal-body {
        padding: 2rem;
        color: #555;
    }

    #detailsModal .modal-body h6 {
        font-size: 1.1rem;
        color: #333;
    }

    #detailsModal .modal-body p {
        font-size: 1rem;
        color: #666;
    }

    #detailsModal .modal-body .lead {
        font-size: 1.2rem;
        color: #007bff;
    }

    #detailsModal .modal-footer {
        background: #f1f1f1;
        border-top: 1px solid #dee2e6;
    }

    #detailsModal .btn-close {
        background: #007bff;
        color: #fff;
        border-radius: 50%;
    }
</style>
<div class="mainpagesection" style="background-color: unset;">
    <div class="widebanner position-relative" style="margin-bottom: 10px;">
        <div class="owl-carousel owl-theme first-carousel">
            @foreach($banners as $banner)
            <div class="item" style="border-radius: 10px;">
                <div class="widebannertext position-absolute mb-0 d-flex flex-column">
                    <h5 class="banner-name">{{$banner->name}}</h5>
                    <p class="banner-company">{{$banner->company_name}}</p>
                    <p class="banner-description">{{$banner->description}}</p>
                    <div class="banner-details">
                        <span class="banner-date">
                            <h4 class="text-white">Exhibition Time and Venue </h4>
                            {{ \Carbon\Carbon::parse($banner->show_date)->format('l, F j, Y') }}
                        </span>
                        <span class="banner-location">
                            <h7>Near </h7>{{ \App\Models\Country::where('id', $banner->country)->first()->name }},
                            {{ \App\Models\City::where('id', $banner->city)->first()->name}}
                        </span>
                    </div>
                </div>
                <img src="/storage/{{ json_decode($banner->image, true)[0] }}" alt="Banner Image"
                    class="img-fluid bannerimage">
            </div>
            @endforeach
        </div>
    </div>
    <div class="card border-0 rounded-0" style="background-color: var(--web-bg); margin-bottom: 10px;">
        <span> <a href="/"> Home </a> / <a href="{{ route('tradeshow') }}"> Tradeshow </a>
            / <a href="{{ route('tradeshow.view',['name'=>$tradeshow->name,'id'=>$tradeshow->id]) }}">{{ $tradeshow->name }}</a>
        </span>
    </div>
    <div class="buttonsbox" style="margin-bottom: 22px;">
        <form id="filterForm" method="GET" style="display: flex; margin-top: 0; margin-bottom: 0;">
            <!-- Search Bar -->
            <div class="dropdown-container" style="flex-grow: 1; margin-right: 10px;">
                <input type="search" placeholder="Text Search" class="dropdown-search border-0 h-100 w-100"
                    id="text-search" name="text" style="outline: 0;" />
            </div>

            <!-- Location Dropdown -->
            <div id="locationdropdown" class="dropdown-container" style="flex-grow: 1; margin-right: 10px;">
                <div class="dropdown-button noselect">
                    <div class="dropdown-label" data-default-label="Country">Country</div>
                </div>
                <div id="locationdropdownchild" class="dropdown-list" style="display: none;">
                    <input type="search" placeholder="Search country" class="dropdown-search"
                        id="country-search" name="country" />
                    <ul id="country-list">
                        @foreach($locations as $location)
                        <li class="dropdown-item pr-2 pl-2">
                            <label>
                                <input type="radio" name="country" value="{{ $location->id }}" />
                                {{ $location->name }}
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Industry Dropdown -->
            <div class="dropdown-container pr-0" style="flex-grow: 1; border-right: 0;">
                <div id="industrymain" class="dropdown-button noselect">
                    <div class="dropdown-label" data-default-label="Industry">Industry</div>
                </div>
                <div id="industrychild" class="dropdown-list" style="display: none;">
                    <input type="search" placeholder="Search Industry" class="dropdown-search"
                        id="industry-search" name="industry" />
                    <ul id="industry-list">
                        @foreach($industries as $industry)
                        <li class="dropdown-item pr-2 pl-2">
                            <label>
                                <input type="radio" name="industry" value="{{ $industry->id }}" />
                                {{ $industry->name }}
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Submit Button (Magnifying Icon) -->
            <div class="clear-filters mr-2" style="margin-top: 10px;">
                <button type="submit" id="filters-btn">Filters</button>
            </div>
        </form>
        <!-- <select class="buttonsboxq" id="location_filter" name="location_filter">
            <option selected value="">Exact Location</option>
            <option value="city1">City 1</option>
            <option value="city2">City 2</option>
            <option value="city3">City 3</option>
            <option value="city4">City 4</option>
        </select> -->
    </div>
    <div class="detailssection">
        <div class="grhrbrr-banner-layout">
            <!-- Banner Section -->
            <div class="grhrbrr-banner">
                <div class="grhrbrr-banner-overlay">
                    <div class="grhrbrr-event-banner-info d-flex flex-row">
                        <div class="grhrbrr-event-logo-cont">
                            <div class="grhrbrr-event-logo-box">
                                <img src="/storage/{{ $tradeshow->company_icon }}" alt="{{ $tradeshow->name }} {{ \Carbon\Carbon::parse($tradeshow->show_date)->format('Y') }}">
                            </div>
                        </div>
                        <div class="grhrbrr-event-info-box">
                            <h1>{{ $tradeshow->name }} {{ \Carbon\Carbon::parse($tradeshow->show_date)->format('Y') }}</h1>
                            <p class="grhrbrr-event-date">
                                {{ \Carbon\Carbon::parse($tradeshow->show_date)->format('l, F j, Y') }}
                            </p>
                            <p class="grhrbrr-event-location">{{ \App\Models\City::where('id', $tradeshow->city)->first()->name }} ,
                                {{ \App\Models\Country::where('id', $tradeshow->country)->first()->name }}
                            </p>
                        </div>
                        <div class="grhrbrr-event_btn-wrapper">
                            <a class="grhrbrr-request-booth" href="javascript:displayPopoup('Join &amp; Get Access to Verified<span> Buyers &amp; Suppliers</span>','seller','tradeshow-request-booth');">
                                Request a Booth
                            </a>
                            @if (!auth('customer')->check())
                                <a class="grhrbrr-visitor-registration" href="{{ route('customer.auth.login') }}">
                                    Visitor Registration
                                </a>
                            @else
                                <a class="grhrbrr-visitor-registration" href="#">
                                    Visitor Registered
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


            <div>
                <div class="row">
                    <div class="col-md-9">
                        <!--event details start-->
                        <div class="hr-event-box">
                            <div class="hr-event-hl-box">
                                <div class="hr-event-hl-left">
                                    <ul>
                                        <li>
                                            <span>Date</span>
                                            {{ \Carbon\Carbon::parse($tradeshow->show_date)->format('l, F j, Y') }}
                                        </li>
                                        <li>
                                            <span>Website</span>
                                            {{ $tradeshow->website }}
                                        </li>
                                        <li>
                                            <span>Phone</span>
                                            +{{ \App\Models\Country::where('id', $tradeshow->country)->first()->phonecode }}-{{ $tradeshow->phone }}
                                        </li>
                                        <li>
                                            <span>Email</span>
                                            {{ $tradeshow->email }}
                                        </li>
                                        <li>
                                            <span>Industry</span>
                                            <div style="background: #767676;color:#fff; padding:5px 15px; margin-right:5px;margin-bottom:15px;;display:inline-block;">
                                                {{ \App\Models\TradeCategory::where('id', $tradeshow->industry)->first()->name ?? 'N/A'}}
                                            </div>
                                        </li>
                                        <li>
                                            <a href="javascript:tsContactUs();" class="hr-btn-theme hr-btn-contact-btn" title="Contact Now">Contact Now</a>
                                        </li>
                                    </ul>

                                </div>
                                <div class="hr-event-hl-right">
                                    <h2 style="font-weight: bold;margin-bottom: 10px;font-size: 24px;">Event Organizer</h2>
                                    <div class="hr-org-pic">
                                        <a href="/tradeshow/filter-by-country/all/all/all/{{ $tradeshow->company_name }}" title="{{ $tradeshow->company_name }}">
                                            <img src="/storage/{{ $tradeshow->company_icon }}" alt="{{ $tradeshow->company_name }}">
                                        </a>
                                    </div>
                                    <h6><a href="/tradeshow/filter-by-country/all/all/all/{{ $tradeshow->company_name }}" title="{{ $tradeshow->company_name }}">{{ $tradeshow->company_name }}</a></h6>
                                    <p>{{ $tradeshow->address }}</p>
                                    <p>Tel:+{{ \App\Models\Country::where('id', $tradeshow->country)->first()->phonecode }}-{{ $tradeshow->phone }} </p>
                                </div>
                                <div class="hr-main-box">
                                    <p></p>
                                    <p class="hr-MsoNormal" style="text-align: justify;">
                                        <span style="color: #212529; background: white;">
                                            {{ $tradeshow->description }}</span>
                                    </p>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                        <!--event details end-->

                        <!--organizer box starts-->
                        <div class="hr-event-box">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h2 style="font-weight: bold;margin-bottom: 10px;font-size: 24px;">Event Venue</h2>
                                    <div class="hr-event-add">
                                        {{ $tradeshow->address }} <br>
                                        {{ \App\Models\City::where('id', $tradeshow->city)->first()->name }} ,
                                        {{ \App\Models\Country::where('id', $tradeshow->country)->first()->name }} <br>
                                        +{{ \App\Models\Country::where('id', $tradeshow->country)->first()->phonecode }}-{{ $tradeshow->phone }}<br>
                                        {{ $tradeshow->website }}
                                        <br>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="hr-event-map">
                                        <iframe style="width: 100%;height: 250px;border: 3px solid #ddd;" src="https://www.google.com/maps?q={{ \App\Models\City::where('id', $tradeshow->city)->first()->name }} +{{ \App\Models\Country::where('id', $tradeshow->country)->first()->name }}&amp;output=embed"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--organizer box ends-->
                    </div>

                    <div class="col-md-3">
                        <!--related events start-->
                        <div class="hr-events-filetr-box">
                            <h2 style="font-weight: bold;margin-bottom: 10px;font-size: 24px;">Related Events</h2>
                            @if($related->isEmpty())
                               No Related Tradeshows !             
                            @else
                                @foreach($related as $tradeshow)
                                <div class="hr-re-item">
                                    <div class="hr-re-event-date">
                                        {{ \Carbon\Carbon::parse($tradeshow->show_date)->format('F,j') }} <span>{{ \Carbon\Carbon::parse($tradeshow->show_date)->format('Y') }}</span>
                                    </div>
                                    <div class="hr-re-caption">
                                        <h6><a href="{{ route('tradeshow.view',['name'=>$tradeshow->name,'id'=>$tradeshow->id]) }}"> {{ $tradeshow->name }}</a></h6>
                                        {{ \App\Models\City::where('id', $tradeshow->city)->first()->name }} ,
                                        {{ \App\Models\Country::where('id', $tradeshow->country)->first()->name }}
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        <!--related events end-->
                    </div>
                </div>
            </div>

            <!-- Details Section -->
            <!-- <div class="grhrbrr-details-container">
                <div class="grhrbrr-trade-details">
                    <div class="grhrbrr-first">
                        <h5>Event Venue Details</h5>
                        <div class="grhrbrr-detail-row">
                            <span>Hall:</span>
                            <span>{{ $tradeshow->hall }}</span>
                        </div>
                        <div class="grhrbrr-detail-row">
                            <span>Stand:</span>
                            <span>{{ $tradeshow->stand }}</span>
                        </div>
                        <div class="grhrbrr-detail-row">
                            <span>Show Date:</span>
                            <span>{{ \Carbon\Carbon::parse($tradeshow->show_date)->format('l, F j, Y') }}</span>
                        </div>
                        <div class="grhrbrr-detail-row">
                            <span>Popularity:</span>
                            <span>⭐ {{ $tradeshow->popularity }}</span>
                        </div>
                    </div>
                    <div class="grhrbrr-second">
                        <h5>Event Location</h5>
                        <div class="grhrbrr-detail-row">
                            <span>Address:</span>
                            <span>{{ $tradeshow->address }}</span>
                        </div>
                        <div class="grhrbrr-detail-row">
                            <span>City:</span>
                            <span>{{ \App\Models\City::where('id', $tradeshow->city)->first()->name }}</span>
                        </div>
                        <div class="grhrbrr-detail-row">
                            <span>Country:</span>
                            <span>{{ \App\Models\Country::where('id', $tradeshow->country)->first()->name }}</span>
                        </div>
                    </div>
                    <div class="grhrbrr-third">
                        <h5>Organizer Details</h5>
                        <div class="grhrbrr-company-info">
                            <img src="/storage/{{ $tradeshow->company_icon }}" alt="Company Logo" class="grhrbrr-company-logo">
                            <div class="grhrbrr-company-details">
                                <h1 class="grhrbrr-company-name">{{ $tradeshow->name }}</h1>
                                <p class="grhrbrr-industry">Industry: {{ \App\Models\TradeCategory::where('id', $tradeshow->industry)->first()->name ?? 'N/A'}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grhrbrr-description-box">
                    <h5>Description</h5>
                    <p class="grhrbrr-description">{{ $tradeshow->description }}</p>
                </div>

                <div class="grhrbrr-footer">
                    <a href="{{ $tradeshow->website }}" target="_blank" class="grhrbrr-website-link">Visit Website</a>
                </div>
            </div> -->
        </div>

    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Handle the Location Dropdown
        document.getElementById('locationdropdown').addEventListener('click', function() {
            const dropdownList = document.getElementById('locationdropdownchild');
            dropdownList.style.display = (dropdownList.style.display === 'none' || dropdownList.style.display === '') ? 'block' : 'none';
        });

        // Handle the Industry Dropdown
        document.querySelector('.dropdown-button').addEventListener('click', function() {
            const dropdownList = this.nextElementSibling;
            dropdownList.style.display = (dropdownList.style.display === 'none' || dropdownList.style.display === '') ? 'block' : 'none';
        });

        // Filter Location search
        document.getElementById('country-search').addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const items = document.querySelectorAll('#country-list li');
            items.forEach(item => {
                const text = item.textContent || item.innerText;
                item.style.display = text.toLowerCase().includes(filter) ? '' : 'none';
            });
        });

        // Filter Industry search
        document.getElementById('industry-search').addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const items = document.querySelectorAll('#industry-list li');
            items.forEach(item => {
                const text = item.textContent || item.innerText;
                item.style.display = text.toLowerCase().includes(filter) ? '' : 'none';
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown-container')) {
                document.querySelectorAll('.dropdown-list').forEach(function(dropdown) {
                    dropdown.style.display = 'none';
                });
            }
        });

        // Apply filters when an option is selected
        function applyFilters() {
            // Get values for country and industry filters
            const locationId = document.querySelector("input[name='country']:checked")?.value;
            const industryId = document.querySelector("input[name='industry']:checked")?.value;

            // Log applied filters for debugging
            console.log("Filters Applied:");
            console.log("Location ID:", locationId); // Get the selected location ID
            console.log("Industry ID:", industryId); // Get the selected industry ID
        }

        // Initialize filter functionality for dropdowns
        const dropdownItems = document.querySelectorAll(".dropdown-item");
        dropdownItems.forEach((item) => {
            item.addEventListener("click", function() {
                const dropdownLabel = this.closest(".dropdown-container").querySelector(".dropdown-label");
                dropdownLabel.textContent = this.textContent; // Update the label to selected item

                // Close the dropdown after selection
                const dropdownList = this.closest(".dropdown-list");
                dropdownList.style.display = "none";

                applyFilters(); // Apply selected filters
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('filterForm');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Get the values from the input fields
            let textSearch = document.getElementById("text-search").value;

            // Set default value for text-search to 'noselect' if it's empty
            if (!textSearch) {
                textSearch = 'all';
            }

            // Get the values from the input fields
            const locationId = document.querySelector("input[name='country']:checked")?.value;
            const industryId = document.querySelector("input[name='industry']:checked")?.value;

            // Construct the URL with the parameters
            let url = `/tradeshow/filter-by-country/${textSearch}`;

            if (locationId) {
                url += `/${locationId}`;
            } else {
                url += `/all`; // Optional: Use "all" or a default if no location is selected
            }

            if (industryId) {
                url += `/${industryId}`;
            } else {
                url += `/all`; // Optional: Use "all" or a default if no industry is selected
            }

            url += `/all`;

            // Redirect to the constructed URL
            window.location.replace(url);
        });
    });
</script>
<script>
    function filterTrades() {
        let country = document.getElementById('country').value;
        let selectedLetter = document.getElementById('.lettersort.active') ? document.querySelector('.lettersort')
            .getAttribute('name') : '';

        let databoxes = document.querySelectorAll('#tradeshowboxes');

        databoxes.forEach(function(box) {
            let dataCountry = box.getAttribute('data-country');
            let exhibitorNames = box.querySelector('td:nth-of-type(2)').textContent.trim();

            let countryMatch = (country === '' || dataCountry === country);
            let letterMatch = (selectedLetter === '' || exhibitorName.startsWith(selectedLetter));

            if (countryMatch && letterMatch) {
                box.style.display = 'table-row';
            } else {
                box.style.display = 'none';
            }
        });
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const wideBannerTexts = document.querySelectorAll('.widebannertext');

        wideBannerTexts.forEach(text => {
            // Generate two random, visually appealing colors
            const randomColor1 = `hsl(${Math.floor(Math.random() * 360)}, 70%, 40%)`; // Darker hue
            const randomColor2 = `hsl(${Math.floor(Math.random() * 360)}, 70%, 50%)`; // Medium-light hue

            // Set the linear gradient as the background
            text.style.background = `linear-gradient(45deg, ${randomColor1}, ${randomColor2})`;
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.first-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            dots: true,
            autoplay: false,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var dropdownbutton = document.getElementById('locationdropdown');
        var dropdownchild = document.getElementById('locationdropdownchild');

        dropdownbutton.addEventListener('click', function() {
            if (dropdownchild.style.display === 'none' || dropdownchild.style.display === '') {
                dropdownchild.style.display = 'block';
            } else {
                dropdownchild.style.display = 'none';
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var dropdownbutton = document.getElementById('industrymain');
        var dropdownchild = document.getElementById('industrychild');

        dropdownbutton.addEventListener('click', function() {
            if (dropdownchild.style.display === 'none' || dropdownchild.style.display === '') {
                dropdownchild.style.display = 'block';
            } else {
                dropdownchild.style.display = 'none';
            }
        });
    });
</script>
@endsection