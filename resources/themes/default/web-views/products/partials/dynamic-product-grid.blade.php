@foreach ($products as $item)
    <div class="product-card">
        <div class="heart-image">
            <div class="circle-container">
                @php
                    $user = auth('customer')->user();
                    if ($user) {
                        $isFavourite = \App\Utils\HelperUtil::checkIfFavourite($item->id, $user->id, 'product');
                    } else {
                        $isFavourite = false;
                    }
                @endphp
                @if (auth('customer')->user())
                    <img class="heart favourite-img" onclick="makeFavourite(this)" data-id="{{ $item->id }}"
                        data-userid="{{ $user->id }}" data-type="product"
                        data-role="{{ auth()->user()->role ?? 'customer' }}"
                        src="{{ $isFavourite ? theme_asset('public/img/Heart (2).png') : theme_asset('public/img/Heart (1).png') }}"
                        width="20" alt="Featured icon" style="margin-left: auto;">
                @else
                    <img class="heart favourite-img" onclick="sendtologin()"
                        src="{{ theme_asset('public/img/Heart (1).png') }}" width="20" alt="Featured icon"
                        style="margin-left: auto;">
                @endif
            </div>
        </div>
        <a href="{{ route('product', $item->slug) }}" style="width: 100%;">
            <img src="{{ isset($item->thumbnail) ? '/storage/product/thumbnail/' . $item->thumbnail : '/images/placeholderimage.webp' }}"
                alt="Sample Product" onerror="this.onerror=null; this.src='/images/placeholderimage.webp';"
                class="product-image">
            <div class="product-info">
                @if ($item->badge)
                    <div class="d-flex justify-content-between">
                        <p class="new">{{ $item->badge }}</p>
                    </div>
                @else
                    {{-- Nothing Yet --}}
                @endif
                <h3 class="product-title">{!! $item->short_details !!}</h3>
                <div class="product-price">${{ number_format($item->unit_price, 2) }} / {{ $item->unit }}</div>
                <div class="product-moq">{{ $item->minimum_order_qty }} {{ $item->unit }} (MOQ)</div>
                @php
                    $memberCheck = \App\Utils\ChatManager::checkifMember($item->added_by, $item->user_id);
                    if ($item->added_by == 'seller') {
                        $seller = \App\Models\Seller::find($item->user_id);
                        $shopName = $seller->shop->name ?? 'N/A';
                        $shopAddress = $seller->shop->address ?? 'N/A';
                    } elseif ($item->added_by == 'admin') {
                        $shopName = 'Admin Shop';
                        $shopAddress = 'Admin Address';
                    }
                @endphp
                <div class="product-seller" style="display: flex;justify-content: space-between; align-items:center;">
                    @if ($item->origin)
                        @php
                            $countryDetails = \App\Utils\ChatManager::getCountryDetails($item->origin);
                            if ($countryDetails) {
                                $countryName = $countryDetails['countryName'];
                                $countryISO = $countryDetails['countryISO2'];
                            }
                        @endphp
                        <div>
                            <img src="/flags/{{ strtolower($countryDetails['countryISO2']) }}.svg" class="flag-icon"
                                alt="{{ $countryName }} flag" />
                            {{ $countryName }}
                        </div>
                    @endif
                    @if ($memberCheck == 1)
                        <img src="/img/Diamond.png" alt="diamond" class="dimond-img" style="width: 25px;">
                    @endif
                </div>
                <div class="product-exhibition">{{ $shopName }}</div>
                <div>
                    <button class="start-order-btn">Explore</button>
                </div>
            </div>
        </a>
    </div>
@endforeach
