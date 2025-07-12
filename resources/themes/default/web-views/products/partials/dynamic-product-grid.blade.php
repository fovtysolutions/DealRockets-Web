@foreach ($products as $index => $item)
    <div class="product-card">
        <a href="{{ route('product', $item->slug) }}" style="width: 100%;">
            <div class="heart-image">
                <div class="circle-container">
                    @php
                        $user = auth('customer')->user();
                        $isFavourite = $user
                            ? \App\Utils\HelperUtil::checkIfFavourite($item->id, $user->id, 'product')
                            : false;
                        $vendorExtra = \App\Models\VendorExtraDetail::where('seller_id', $item->user_id)->first();
                    @endphp

                    @if ($user)
                        <img class="heart favourite-img" onclick="makeFavourite(this)" data-id="{{ $item->id }}"
                            data-userid="{{ $user->id }}" data-type="product"
                            data-role="{{ $user->role ?? 'customer' }}"
                            src="{{ $isFavourite ? theme_asset('public/img/Heart (2).png') : theme_asset('public/img/Heart (1).png') }}"
                            width="20" alt="Featured icon" style="margin-left: auto;">
                    @else
                        <img class="heart favourite-img" onclick="sendtologin()"
                            src="{{ theme_asset('public/img/Heart (1).png') }}" width="20" alt="Featured icon"
                            style="margin-left: auto;">
                    @endif
                </div>
            </div>
            <img src="{{ isset($item->thumbnail) ? '/storage/' . $item->thumbnail : '/images/placeholderimage.webp' }}"
                alt="Sample Product" onerror="this.onerror=null;this.src='/images/placeholderimage.webp';"
                class="product-image">

            <div class="product-info">
                @if (Carbon\Carbon::parse($item->created_at)->gt(Carbon\Carbon::now()->subDays(30)))
                    <div class="d-flex justify-content-between" style="align-items: center; padding-bottom: 11px;">
                        <p class="new">New</p>
                        <div class="rating">
                            <span style="font-size: 16px;">
                                <i class="bi bi-star-fill start-rating"
                                    style="color: #ffbb00;font-size: 18px !important;"></i>
                                @php
                                    $overallRating = getOverallRating($item->reviews);
                                @endphp
                                {{ $overallRating[0] }}/5
                            </span>
                        </div>
                    </div>
                @endif

                <h3 class="product-title">{{ $item->short_details }}</h3>
                <div class="product-price">${{ number_format($item->unit_price, 2) }} / {{ $item->unit }}</div>
                <div class="product-moq">{{ $item->minimum_order_qty }} {{ $item->unit }} (MOQ)</div>

                @php
                    $memberCheck = \App\Utils\ChatManager::checkifMember($item->added_by, $item->user_id);
                    if ($item->added_by == 'seller') {
                        $seller = \App\Models\Seller::find($item->user_id);
                        $shopName = $seller->shop->name ?? '';
                        $shopAddress = $seller->shop->address ?? '';
                    } else {
                        $shopName = 'Admin Shop';
                        $shopAddress = 'Admin Address';
                    }
                @endphp

                <div class="product-seller" style="display: flex; justify-content: space-between; align-items:center;">
                    @if ($item->origin)
                        @php
                            $countryDetails = \App\Utils\ChatManager::getCountryDetails($item->origin);
                        @endphp
                        @if ($countryDetails)
                            <div>
                                <img src="/flags/{{ strtolower($countryDetails['countryISO2']) }}.svg"
                                    class="flag-icon" alt="{{ $countryDetails['countryName'] }} flag" />
                                {{ $countryDetails['countryName'] }}
                            </div>
                        @endif
                    @endif

                    @if ($memberCheck == 1)
                        <img src="/img/Diamond.png" alt="diamond" class="dimond-img" style="width: 25px;">
                    @endif
                </div>

                <div class="product-exhibition" style="display: flex; justify-content: space-between">
                    <span style="font-size: 13px;">{{ $shopName }}</span>
                    <span style="text-transform: capitalize; font-size: 13px;">{{ $vendorExtra->business_type ?? 'Manufacturer' }}</span>
                </div>
                <div>
                    <button class="start-order-btn">Inquire Now</button>
                </div>
            </div>
        </a>
    </div>

    {{-- ✅ Vendor Ad after every 6 products --}}
    @if (($index + 1) % 6 === 0)
        <div class="vendor-ad" style="grid-column: span 2;">
            <a href="javascript:0" style="height: 100%;">
                <img src="/images/vendor-ad-placeholder.jpg" style="height: 100%; object-fit:fill;" alt="Vendor Ad"
                    onerror="this.onerror=null;this.src='/images/placeholderimage.webp';" class="img-fluid">
            </a>
        </div>
    @endif
@endforeach
