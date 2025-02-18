@extends('layouts.front-end.app')
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/tradeshow.css') }}" />
@section('title',translate('Trade Shows'. ' | ' . $web_config['name']->value))
@section('content')
<style>
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
<div class="mainpagesection">
    <div class="widebanner position-relative" style="margin-bottom: 22px;">
        <div class="owl-carousel owl-theme">
            @foreach($banners as $banner)
            <div class="item" style="border-radius: 10px;">
                <div class="widebannertext position-absolute mb-0 d-flex flex-column">
                    <h2 class="banner-name">{{$banner->name}}</h2>
                    <p class="banner-company">{{$banner->company_name}}</p>
                    <p class="banner-description">{{$banner->description}}</p>
                    <div class="banner-details">
                        <span class="banner-date">
                            <h4 class="text-white">Exhibition Time and Venue </h4>{{ \Carbon\Carbon::parse($banner->show_date)->format('l, F j, Y') }}
                        </span>
                        <span class="banner-location">
                            <h7>Near </h7>{{ \App\Models\Country::where('id',$banner->country)->first()->name }},
                            {{ \App\Models\City::where('id',$banner->city)->first()->name}}
                        </span>
                    </div>
                </div>
                <img src="/storage/{{ json_decode($banner->image,true)[0] }}" alt="Banner Image" class="img-fluid bannerimage">
            </div>
            @endforeach
        </div>
    </div>
    <div class="card border-0 rounded-0" style="background-color: var(--web-bg); margin-bottom: 22px;">
        <span> <a href="/"> Home </a> / <a href="{{ route('tradeshow') }}"> Tradeshow </a> </span>
    </div>
    <div class="completesection">
        <div class="filtersectionleft">
            <div class="card border-0 roundeded-0" style="background-color: white;">
                <div class="searchcontainertrdshw">
                    <span class="searchicontrdshw"><i class="fa fa-search"></i></span>
                    <input class="searchbartrdshw" name="keyword" placeholder="Keyword search" />
                </div>
                <select class="filterdropdown px-3 py-3" name="country" id="country">
                    <option value="" selected>Select a Country</option>
                    @foreach ($countries as $country)
                    @php
                        $countryDetails = \App\Utils\ChatManager::getCountryDetails($country)
                    @endphp
                    <option value="{{ $country }}">
                        {{ $countryDetails['countryName'] }} {{ $countryDetails['countryISO2'] }}
                    </option>
                    @endforeach
                </select>
                <select class="filterdropdown px-3 py-3" name="country" id="country">
                    <option value="" selected>Select a Industry</option>
                    @foreach ($industries as $industry)
                        <option value="{{ $industry->id }}">
                            {{ \App\Models\TradeCategory::where('id',$industry->id)->first()->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="filtersectiontrdshw">
        <!-- <form method="GET" action="{{ route('tradeshow') }}" class="my-1 d-flex flex-wrap" style="margin-left:3vw;">
                    <div class="my-2 d-flex flex-wrap overflow-x-scroll" style="max-width:100%; justify-self:center;">
                        <button class="lettersort" name="letter" value="all">All</button>
                        <button class="lettersort" name="letter" value="numbers">0-9</button>
                        @foreach ($alphabet as $a)
                        <button class="lettersort" name="letter" value="{{ $a }}">{{ $a }}</button>
                        @endforeach
                    </div>
                    <div class="searchcontainertrdshw">
                        <span class="searchicontrdshw"><i class="fa fa-search"></i></span>
                        <input class="searchbartrdshw" name="keyword" placeholder="Keyword search" />
                    </div>
                    <select class="filterdropdown px-3 py-3" name="country" id="country">
                        <option value="" selected>Select a Country</option>
                        @foreach ($countries as $country)
                        <option value="{{ $country }}">
                            {{ \App\Utils\ChatManager::getCountryDetails($country)['countryName'] }}
                        </option>
                        @endforeach
                    </select>
                </form> -->
                <div class="my-1">
                    <div class="table-responsive">
                        <table class="tradeshowtable w-100">
                            <thead>
                                <tr>
                                    <th>Logo</th>
                                    <th class="bg-secondary">Exhibitor Name</th>
                                    <th class="bg-secondary-subtle">Hall</th>
                                    <th class="bg-secondary">Stand</th>
                                    <!-- <th class="bg-secondary-subtle">Find the Stand</th> -->
                                    {{-- <th class="bg-secondary">Sectors</th> --}}
                                    <th class="bg-secondary-subtle">Country</th>
                                    <th class="bg-secondary">Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tradeshows as $tradeshow)
                                <tr id="tradeshowboxes" data-country="{{ $tradeshow->country }}">
                                    <td><img style="height: 50px; width: 50px;"
                                            src="https://static.vecteezy.com/system/resources/thumbnails/000/605/214/small/5057-01.jpg">
                                    </td>
                                    <td class="bg-secondary">{{ $tradeshow->company_name }}</td>
                                    <td class="bg-secondary-subtle">{{ $tradeshow->hall }}</td>
                                    <td class="bg-secondary">{{ $tradeshow->stand }}</td>
                                    <!-- <td class="bg-secondary-subtle">
                                                        <div class="referarrow">
                                                            <button class="referbutton py-2 px-3">Find the Stand</button>
                                                            <div class="refericon px-2 py-2"><i class="fas fa-arrow-right"></i></div>
                                                        </div>
                                                    </td> -->
                                    {{-- <td class="bg-secondary">Sample Sectors</td> --}}
                                    <td class="bg-secondary-subtle">
                                        {{ \App\Utils\ChatManager::getCountryDetails($tradeshow->country)['countryName'] }}
                                    </td>
                                    <td class="bg-secondary">
                                        <div class="referarrow">
                                            <button class="referbutton py-2 px-3 detailsButton"
                                                data-id="{{ $tradeshow->id }}" data-bs-toggle="modal"
                                                data-bs-target="#detailsModal">
                                                Details
                                            </button>
                                            <div class="refericon px-2 py-2"><i class="fas fa-arrow-right"></i></div>
                                        </div>
                                    </td>

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5">No tradeshows found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination my-3">
                        {{ $tradeshows->links() }}
                    </div>
                </div>
        </div>
    </div>
</div>
<!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">Tradeshow Details</h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body" id="modalContent">
                <!-- Modal content will be dynamically inserted here -->
                <div class="text-center">
                    <i class="fa fa-spinner fa-spin fa-3x text-primary"></i>
                    <p class="mt-3">Loading...</p>
                </div>
            </div>
            {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div> --}}
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const detailsButtons = document.querySelectorAll('.detailsButton');

        detailsButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tradeshowId = this.getAttribute('data-id');
                const modalContent = document.getElementById('modalContent');

                var myModal = new bootstrap.Modal(document.getElementById('detailsModal'));
                myModal.show();

                // Show loading message
                modalContent.innerHTML =
                    '<div class="text-center"><i class="fa fa-spinner fa-spin fa-3x text-primary"></i><p class="mt-3">Loading...</p></div>';

                // Fetch tradeshow details using AJAX
                fetch(`/tradeshow/details/${tradeshowId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Populate modal with fetched data
                        modalContent.innerHTML = `
                        <div class="container">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h6 class="text-uppercase">Company Name:</h6>
                                    <p class="lead text-muted">${data.company_name}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h6 class="text-uppercase">Country:</h6>
                                    <p>${data.country}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-uppercase">Description:</h6>
                                    <p>${data.description}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h6 class="text-uppercase">Hall:</h6>
                                    <p>${data.hall}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-uppercase">Stand:</h6>
                                    <p>${data.stand}</p>
                                </div>
                            </div>
                        </div>
                    `;
                    })
                    .catch(error => {
                        modalContent.innerHTML =
                            `<p class="text-danger text-center">Failed to load details. Please try again later.</p>`;
                    });
            });
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

    document.addEventListener('DOMContentLoaded', function() {
        // Add an event listener to the country dropdown
        document.getElementById('country').addEventListener('change', filterTrades);

        const lettersortlinks = document.querySelectorAll('.lettersort');
        lettersortlinks.forEach(link => {
            link.addEventListener('click', function() {
                lettersortlinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
                filterTrades();
            });
        });
    });
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
        $('.owl-carousel').owlCarousel({
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
@endsection