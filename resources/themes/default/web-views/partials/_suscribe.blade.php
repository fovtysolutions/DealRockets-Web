<div class="mainpagesection custom-dealrock-banner-small">
    <h6 class="custom-dealrock-head">Get More Access to the Features – Choose Your Membership!</h6>

    <!-- Toggle Switch -->
    <input type="radio" id="customer-toggle" name="membership" checked>
    <input type="radio" id="seller-toggle" name="membership">

    <div class="membership-toggle custom-dealrock-text">
        <label for="customer-toggle">For Buyer</label>
        <label for="seller-toggle">For Seller</label>
    </div>

    <!-- Seller Plans -->
    <div class="membership-plans seller">
        @foreach($seller_tiers as $seller)
            @php
                $benefits = json_decode($seller->membership_benefits, true);
            @endphp
            <a class="plan-card" href="{{ route('membership') }}">
                <div class="d-flex flex-column h-100">
                    <div>
                        <h4 class="plan-title font-weight-bold">{{ $seller->membership_name }}</h4>
                        <p class="plan-description custom-dealrock-text">{!! $benefits['description'] !!}</p>
                    </div>
                    <div>
                        <p class="plan-price custom-dealrock-text" style="font-weight: bold !important;">See More</p>
                        {{-- <p class="plan-price">$ {{ $benefits['price'] }}</p> --}}
                        {{-- <p class="small-text text-align-start" style="text-align: start;">per month</p>     --}}
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    <!-- Customer Plans -->
    <div class="membership-plans customer">
        @foreach($customer_tiers as $customer)
            @php
                $benefits = json_decode($customer->membership_benefits, true);
            @endphp
            <a class="plan-card" href="{{ route('membership') }}">
                <div class="d-flex flex-column h-100">
                    <div>
                        <h4 class="plan-title font-weight-bold">{{ $customer->membership_name }}</h4>
                        <p class="plan-description custom-dealrock-text">{!! $benefits['description'] !!}</p>
                    </div>
                    <div>
                        <p class="plan-price custom-dealrock-text" style="font-weight: bold !important;">See More</p>
                        {{-- <p class="plan-price">$ {{ $benefits['price'] }}</p>
                        <p class="small-text text-align-start text-black" style="text-align: start;">per month</p> --}}
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
