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
        <span> <a href="/"> Home </a> / <a href="{{ route('tradeshow') }}"> Tradeshow </a> </span>
    </div>
    <div class="buttonsbox" style="margin-bottom: 22px;">
        <form id="filterForm" method="GET" style="display: flex; margin-top: 0; margin-bottom: 0;">
            <!-- Search Bar -->
            <div class="dropdown-container" style="flex-grow: 1; margin-right: 10px;">
                <input type="search" placeholder="Text Search" class="dropdown-search border-0 h-100 w-100"
                    id="text-search" name="text" style="outline: 0;"/>
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
    <h4 class="text-black font-weight-bold" style="margin-bottom: 22px;">
        Featured Events
    </h4>
    <div class="d-flex flexboxrt" style="margin-bottom: 22px;">
        <div class="box2">
            <div class="gridcontainer">
                @foreach($featuredTradeshows as $tradeshow)
                <a href="{{ route('tradeshow.view',['name'=>$tradeshow->name,'id'=>$tradeshow->id]) }}" title="{{ $tradeshow->name }}">
                    <div class="wrapper-events-main wrapper-events-fea">
                        <div class="bookmark">
                            <img src="/images/bookmar.png">
                        </div>
                        <div class="img-events">
                            <img class="events-img img-responsive"
                                src="/storage/{{ $tradeshow->company_icon ? $tradeshow->company_icon : '' }}">
                        </div>
                        <div class="img-content">
                            <span>
                                {{ \Carbon\Carbon::parse($tradeshow->show_date)->format('F, j, Y') }}
                            </span>
                            <h5 class="text-truncate mt-3 mb-0 text-dark">{{ $tradeshow->name }}</h5>
                            <span style="color: var(--web-text);" class="text-truncate">
                                {{ \App\Models\City::where('id', $tradeshow->city)->first()->name}},
                                {{ \App\Models\Country::where('id', $tradeshow->country)->first()->name }}
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        <div class="carouselcontainern">
            <div class="owl-carousel owl-theme second-carousel">
                @if($rotatingbox)
                    @foreach(range(1, 4) as $index)
                        @php
                        $carouselKey = 'carousel' . $index;
                        @endphp

                        @if(!empty($rotatingbox[$carouselKey]))
                            <div class="item">
                                <img src="/storage/{{ $rotatingbox[$carouselKey] }}" alt="Banner Image {{ $index }}"
                                    class="img-fluid vertimage">
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <h4 class="text-black font-weight-bold" style="margin-bottom: 22px;">
        Browse Events By Country
    </h4>
    <div class="d-flex" style="margin-bottom: 22px; text-align-last: center;">
        <div class="owl-carousel owl-theme third-carousel">
            @foreach ($topCountries as $countries)
            <a href="{{ route('tradeshow.filter',['search'=>'all','country'=>$countries->country,'industry'=>'all','company'=>'all']) }}" class="countryatag">
                @php
                $countryDetails = \App\Utils\ChatManager::getCountryDetails($countries->country);
                @endphp
                <div class="countries-img">
                    <h4>{{ $countryDetails['countryName'] ?? 'N/A' }}</h4>
                    <img src="/images/flags/{{ strtolower($countryDetails['countryISO2']) }}.png"
                        alt="{{ $countryDetails['countryName'] }} flag">
                    <h5>{{ $countries->count }} Events</h5>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    <h4 class="text-black font-weight-bold" style="margin-bottom: 22px;">
        Top 100 Events
    </h4>
    <div class="d-flex" style="margin-bottom: 22px;">
        <div class="gridcontainertwo">
            @foreach($tophundred as $tradeshow)
            <a href="{{ route('tradeshow.view',['name'=>$tradeshow->name,'id'=>$tradeshow->id]) }}" title="{{ $tradeshow->name }}">
                <div class="wrapper-events-main wrapper-events-fea">
                    <div class="img-events">
                        <img class="events-img img-responsive"
                            src="/storage/{{ $tradeshow->company_icon ? $tradeshow->company_icon : '' }}">
                    </div>
                    <div class="img-content">
                        <span>
                            {{ \Carbon\Carbon::parse($tradeshow->show_date)->format('F, j, Y') }}
                        </span>
                        <h5 class="mt-3 mb-0 text-truncate text-dark">{{ $tradeshow->name }}</h5>
                        <span style="color: var(--web-text);" class="text-truncate">
                            {{ \App\Models\City::where('id', $tradeshow->city)->first()->name}},
                            {{ \App\Models\Country::where('id', $tradeshow->country)->first()->name }}
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    <!-- <h4 class="text-black font-weight-bold" style="margin-bottom: 22px;">
        Featured Organizers
    </h4>
    <div class="d-flex" style="margin-bottom: 22px; text-align-last: center;">
        <div class="owl-carousel owl-theme fourth-carousel">
            @foreach ($featuredOrganizers as $organizers)
            <a href="#" class="countryatag">
                <div class="countries-img">
                    <img style="max-width:200px;" src="/storage/{{$organizers->company_icon}}" alt="company">
                </div>
            </a>
            @endforeach
        </div>
    </div> -->
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
    $(document).ready(function() {
        $('.second-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
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
    $(document).ready(function() {
        $('.third-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            dots: false,
            autoplay: false,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 4
                },
                1200: {
                    items: 6
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