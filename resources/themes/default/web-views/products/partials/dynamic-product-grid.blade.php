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
                    <img class="heart favourite-img" onclick="makeFavourite(this)"
                        data-id="{{ $item->id }}" data-userid="{{ $user->id }}" data-type="product"
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
        <img src="{{ isset($item->thumbnail) ? '/storage/product/thumbnail/' . $item->thumbnail : '/images/placeholderimage.webp' }}" alt="Sample Product" class="product-image">
        <div class="product-info">
            <div class="d-flex justify-content-between">
                <p class="new">{{ $item->badge }}</p>
                <div class="rating">
                    <span style="font-size: 12px;">
                        <i class="bi bi-star-fill start-rating text-warning"></i>
                        @php
                            $overallRating = getOverallRating($item->reviews);
                        @endphp
                        {{ $overallRating[0] }}/5
                    </span>
                </div>
            </div>
            <h3 class="product-title">{{ $item->name }}</h3>
            <div class="product-price">${{ number_format($item->unit_price,2,'.',',') }}</div>
            <div class="product-moq">MOQ: {{ $item->minimum_order_qty }} {{ $item->unit }}</div>
            @php
                if ($item->added_by == 'seller') {
                    $seller = \App\Models\Seller::find($item->user_id);
                    $shopName = $seller->shop->name ?? 'N/A';
                    $shopAddress = $seller->shop->address ?? 'N/A';
                } elseif ($item->added_by == 'admin') {
                    $shopName = 'Admin Shop';
                    $shopAddress = 'Admin Address';
                }
            @endphp
            <div class="product-seller">Seller: {{ $shopName }}</div>
            {{-- <div class="product-exhibition">Exhibition: {{ 'N/A' }}</div> --}}
            <div class="product-diamond">
                <img src="/img/Diamond.png" alt="diamond" class="dimond-img">
            </div>
            <div>
                @if(!auth('customer')->check())
                    <a href="{{ route('customer.auth.login') }}">
                @else
                    <a href="{{ route('product', $item->slug) }}">
                @endif
                    <button class="start-order-btn">Start order</button>
                </a>
            </div>
        </div>
    </div>
@endforeach
