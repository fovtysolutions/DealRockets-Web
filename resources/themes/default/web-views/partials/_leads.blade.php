<style>
    @keyframes scroll-vertical {
        0% {
            transform: translateY(0);
        }

        100% {
            transform: translateY(calc(-50%));
        }
    }

    .leads-container .slider {
        background: white;
        height: 700px;
        margin: auto;
        overflow: hidden;
        position: relative;
    }

    .leads-container .slider::before,
    .leads-container .slider::after {
        content: "";
        width: 250px;
        height: 100px;
        position: absolute;
        z-index: 2;
        left: 0;
    }

    .leads-container .slider::before {
        top: 0;
    }

    .leads-container .slider::after {
        bottom: 0;
        transform: rotateX(180deg);
    }

    .leads-container .slider .slide-track {
        animation: scroll-vertical 40s linear infinite;
        display: flex;
        flex-direction: column;
        height: calc(32px * 30);
    }

    .leads-container .slider .slide {
        height: 100px;
    }

    .leads-container .slider:hover .slide-track {
        animation-play-state: paused;
    }
</style>
<section class="mainpagesection fade-in-on-scroll">
    <div class="leads-container">
        <!-- Buy Leads Section -->
        <div class="buy-leads-container">
            <div class="header">
                <div class="d-flex w-100" style="justify-content: space-between;">
                    <span class="leadstitle2">LATEST BUY LEADS</span>
                    <a href="{{ route('buyer') }}" class="top-movers-viewall" style="text-decoration: none;">View All <i
                            style="color:#ED4553;"
                            class="czi-arrow-{{ Session::get('direction') === 'rtl' ? 'left mr-1 ml-n1 mt-1 float-left' : 'right ml-1 mr-n1' }}"></i></a>
                </div>
            </div>
            <div style="height: 305px;overflow: hidden;width: 100%;">
                <ul class="leads-list">
                    @if (!empty($leads['buyer']) && count($leads['buyer']) > 0)
                        <div class="slider">
                            <div class="slide-track">
                                <div class="slide">
                                    @foreach ($leads['buyer'] as $lead)
                                        <a id="buyer" class="lead-item"
                                            href="/buy-leads?specific_id={{ $lead['id'] }}">
                                            @php
                                                $countryDetails = \App\Utils\ChatManager::getCountryDetails(
                                                    $lead['country'],
                                                );
                                            @endphp

                                            @if ($countryDetails['status'] == 200)
                                                <span class="countryName text-truncate custom-dealrock-text">
                                                    <img src="/images/flags/{{ strtolower($countryDetails['countryISO2']) }}.png"
                                                        alt="Flag of {{ $countryDetails['countryName'] }}" />
                                                    {{ $countryDetails['countryName'] }}
                                                </span>
                                            @else
                                                <span>Flag</span>
                                            @endif
                                            <span
                                                class="text-truncate leadName  custom-dealrock-text">{{ $lead['name'] }}</span>
                                            <span class="time leadTime custom-dealrock-text">
                                                <?php
                                                if (!empty($lead['posted_date'])) {
                                                    $date = Carbon\Carbon::createFromFormat('Y-m-d', $lead['posted_date']);
                                                    $daysAgo = $date->diffInDays(Carbon\Carbon::now());
                                                    echo $daysAgo . ' Days Ago';
                                                } else {
                                                    echo 'Date not available';
                                                }
                                                ?>
                                            </span>
                                        </a>
                                    @endforeach
                                    @foreach ($leads['buyer'] as $lead)
                                        <a id="buyer" class="lead-item"
                                            href="/buy-leads?specific_id={{ $lead['id'] }}">
                                            @php
                                                $countryDetails = \App\Utils\ChatManager::getCountryDetails(
                                                    $lead['country'],
                                                );
                                            @endphp

                                            @if ($countryDetails['status'] == 200)
                                                <span class="countryName text-truncate custom-dealrock-text">
                                                    <img src="/images/flags/{{ strtolower($countryDetails['countryISO2']) }}.png"
                                                        alt="Flag of {{ $countryDetails['countryName'] }}" />
                                                    {{ $countryDetails['countryName'] }}
                                                </span>
                                            @else
                                                <span>Flag</span>
                                            @endif
                                            <span
                                                class="text-truncate leadName  custom-dealrock-text">{{ $lead['name'] }}</span>
                                            <span class="time leadTime custom-dealrock-text">
                                                <?php
                                                if (!empty($lead['posted_date'])) {
                                                    $date = Carbon\Carbon::createFromFormat('Y-m-d', $lead['posted_date']);
                                                    $daysAgo = $date->diffInDays(Carbon\Carbon::now());
                                                    echo $daysAgo . ' Days Ago';
                                                } else {
                                                    echo 'Date not available';
                                                }
                                                ?>
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <span>No buyer leads available</span>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Sell Leads Section -->
        <div class="sell-leads-container">
            <div class="header">
                <div class="d-flex w-100" style="justify-content: space-between;">
                    <span class="leadstitle2">LATEST SELL LEADS</span>
                    <a href="{{ route('seller') }}" class="top-movers-viewall" style="text-decoration: none;">View All
                        <i style="color:#ED4553;"
                            class="czi-arrow-{{ Session::get('direction') === 'rtl' ? 'left mr-1 ml-n1 mt-1 float-left' : 'right ml-1 mr-n1' }}"></i></a>
                </div>
            </div>
            <div style="height: 305px;overflow: hidden;width: 100%;">
                <ul class="leads-list">
                    @if (!empty($leads['seller']) && count($leads['seller']) > 0)
                        <div class="slider">
                            <div class="slide-track">
                                <div class="slide">
                                    @foreach ($leads['seller'] as $lead)
                                        <a id="seller" class="lead-item"
                                            href="/sell-offer?specific_id={{ $lead['id'] }}">
                                            @php
                                                $countryDetails = \App\Utils\ChatManager::getCountryDetails(
                                                    $lead['country'],
                                                );
                                            @endphp

                                            @if ($countryDetails['status'] == 200)
                                                <span class="countryName text-truncate custom-dealrock-text">
                                                    <img src="/images/flags/{{ strtolower($countryDetails['countryISO2']) }}.png"
                                                        alt="Flag of {{ $countryDetails['countryName'] }}" />
                                                    {{ $countryDetails['countryName'] }}
                                                </span>
                                            @else
                                                <span>Flag</span>
                                            @endif
                                            <span
                                                class="text-truncate leadName custom-dealrock-text">{{ $lead['name'] }}</span>
                                            <span class="time leadTime custom-dealrock-text">
                                                <?php
                                                if (!empty($lead['posted_date'])) {
                                                    $date = Carbon\Carbon::createFromFormat('Y-m-d', $lead['posted_date']);
                                                    $daysAgo = $date->diffInDays(Carbon\Carbon::now());
                                                    echo $daysAgo . ' Days Ago';
                                                } else {
                                                    echo 'Date not available';
                                                }
                                                ?>
                                            </span>
                                        </a>
                                    @endforeach
                                    @foreach ($leads['seller'] as $lead)
                                        <a id="seller" class="lead-item"
                                            href="/sell-offer?specific_id={{ $lead['id'] }}">
                                            @php
                                                $countryDetails = \App\Utils\ChatManager::getCountryDetails(
                                                    $lead['country'],
                                                );
                                            @endphp

                                            @if ($countryDetails['status'] == 200)
                                                <span class="countryName text-truncate custom-dealrock-text">
                                                    <img src="/images/flags/{{ strtolower($countryDetails['countryISO2']) }}.png"
                                                        alt="Flag of {{ $countryDetails['countryName'] }}" />
                                                    {{ $countryDetails['countryName'] }}
                                                </span>
                                            @else
                                                <span>Flag</span>
                                            @endif
                                            <span
                                                class="text-truncate leadName custom-dealrock-text">{{ $lead['name'] }}</span>
                                            <span class="time leadTime custom-dealrock-text">
                                                <?php
                                                if (!empty($lead['posted_date'])) {
                                                    $date = Carbon\Carbon::createFromFormat('Y-m-d', $lead['posted_date']);
                                                    $daysAgo = $date->diffInDays(Carbon\Carbon::now());
                                                    echo $daysAgo . ' Days Ago';
                                                } else {
                                                    echo 'Date not available';
                                                }
                                                ?>
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <span>No Seller leads available</span>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</section>
