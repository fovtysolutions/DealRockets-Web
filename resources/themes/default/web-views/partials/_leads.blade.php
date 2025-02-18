<section class="mainpagesection fade-in-on-scroll">
    <div class="leads-container">
        <!-- Buy Leads Section -->
        <div class="buy-leads-container">
            <div class="header">
                <h2><span class="icon text-dark"><i class="fas fa-bars"></i></span>
                    <span class="leadstitle1 custom-dealrock-head"><?php echo LATEST; ?> </span>
                    <span class="leadstitle2 custom-dealrock-head"><?php echo BUY_LEADS_TITLE; ?></span>
                    <a href="{{ route('buyer') }}" class="viewall"><?php echo VIEW_ALL; ?></a>
                </h2>
            </div>
            <div style="height: 305px;overflow: hidden;width: 100%;">
                <ul class="leads-list">
                    @if (!empty($leads['buyer']) && count($leads['buyer']) > 0)
                        @foreach ($leads['buyer'] as $lead)
                            <a id="buyer" class="lead-item"
                                href="{{ route('buyerview', ['name' => $lead->name, 'id' => $lead->id]) }}">
                                @php
                                    $countryDetails = \App\Utils\ChatManager::getCountryDetails($lead['country']);
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
                                <span class="text-truncate leadName  custom-dealrock-text">{{ $lead['name'] }}</span>
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
                    @else
                        <li class="lead-item">
                            <span>No buyer leads available</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Sell Leads Section -->
        <div class="sell-leads-container">
            <div class="header">
                <h2><span class="icon text-dark"><i class="fas fa-bars"></i></span>
                    <span class="leadstitle1 custom-dealrock-head"><?php echo LATEST; ?></span>
                    <span class="leadstitle2 custom-dealrock-head"><?php echo SELL_LEADS_TITLE; ?></span>
                    <a href="{{ route('seller') }}" class="viewall"><?php echo VIEW_ALL; ?></a>
                </h2>
            </div>
            <div style="height: 305px;overflow: hidden;width: 100%;">
                <ul class="leads-list">
                    @if (!empty($leads['seller']) && count($leads['seller']) > 0)
                        @foreach ($leads['seller'] as $lead)
                            <a id="seller" class="lead-item"
                                href="{{ route('sellerview', ['name' => $lead['name'], 'id' => $lead['id']]) }}">
                                @php
                                    $countryDetails = \App\Utils\ChatManager::getCountryDetails($lead['country']);
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
                                <span class="text-truncate leadName custom-dealrock-text">{{ $lead['name'] }}</span>
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
                    @else
                        <li class="lead-item">
                            <span>No Seller leads available</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        const itemHeight = $(".lead-item").outerHeight(true); // Height of one item, including margins
        const scrollSpeed = 2000; // Scroll speed for one step
        const delayBetweenScrolls = 100; // Delay between scroll cycles
        let scrollInterval;

        $(".buy-leads-container, .sell-leads-container").css({
            height: "385px",
            overflow: "hidden",
        });

        function smoothScroll(containerSelector) {
            const $list = $(containerSelector + " .leads-list");

            function scrollStep() {
                $list.animate({
                        marginTop: `-=${itemHeight}px`
                    },
                    scrollSpeed,
                    "linear",
                    function() {
                        const currentMarginTop = parseInt($list.css("margin-top"), 10);

                        if (currentMarginTop <= -itemHeight) {
                            $list.find(".lead-item:first").appendTo($list);
                            $list.css("margin-top", 0); // Reset margin
                        }
                        scrollInterval = setTimeout(scrollStep, delayBetweenScrolls); // Continue scrolling
                    }
                );
            }

            scrollStep();

            // Pause scrolling on mouseenter
            $(containerSelector).on('mouseenter', function() {
                clearTimeout(scrollInterval);
            });

            // Resume scrolling on mouseleave
            $(containerSelector).on('mouseleave', function() {
                scrollStep(); // Restart scrolling when mouse leaves
            });

            // Do not stop on manual scroll
            $(".leads-list").on(
                "scroll mousedown DOMMouseScroll mousewheel keyup",
                function(e) {
                    e.stopImmediatePropagation(); // Prevent stopping the scroll when user manually interacts
                }
            );
        }

        smoothScroll(".buy-leads-container");
        smoothScroll(".sell-leads-container");
    });
</script>

