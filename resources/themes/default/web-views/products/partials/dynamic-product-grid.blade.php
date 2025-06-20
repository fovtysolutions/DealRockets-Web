<style>
    .carousel-wrapper {
        position: relative;
        overflow: hidden;
        text-align: center;
    }

    .carousel-prev,
    .carousel-next {
        position: absolute;
        top: 45%;
        background-color: rgba(0, 0, 0, 0.4);
        color: white;
        border: none;
        padding: 4px 8px;
        cursor: pointer;
        z-index: 2;
    }

    .carousel-prev {
        left: 10px;
    }

    .carousel-next {
        right: 10px;
    }

    .carousel-counter {
        position: absolute;
        top: 8px;
        right: 10px;
        background: rgba(0, 0, 0, 0.5);
        color: white;
        padding: 2px 6px;
        font-size: 12px;
        border-radius: 4px;
    }
</style>

@foreach ($products as $item)
    @php
        $user = auth('customer')->user();
        $isFavourite = $user ? \App\Utils\HelperUtil::checkIfFavourite($item->id, $user->id, 'product') : false;
        $images = collect(json_decode($item->extra_images ?? '[]'))->filter(); // remove empty/null
        $images->prepend($item->thumbnail); // put thumbnail first

        $countryDetails = \App\Utils\ChatManager::getCountryDetails($item->origin);
    @endphp

    <div class="product-card position-relative">
        {{-- Image Carousel --}}
        <div class="carousel-wrapper">
            {{-- Favourite Icon --}}
            <div class="heart-image">
                <div class="circle-container">
                    @if ($user)
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
            <img src="/storage/{{ $images[0] ?? 'images/placeholderimage.webp' }}" class="product-image active-image"
                id="product-img-{{ $item->id }}" data-index="0"
                onerror="this.onerror=null; this.src='/images/placeholderimage.webp';">

            @if ($images->count() > 1)
                <button class="carousel-prev" onclick="prevImage({{ $item->id }})">&#10094;</button>
                <button class="carousel-next"
                    onclick="nextImage({{ $item->id }}, {{ $images->count() }})">&#10095;</button>
            @endif

            <div class="carousel-counter" id="carousel-counter-{{ $item->id }}">
                1 / {{ $images->count() }}
            </div>
        </div>

        {{-- Product Info --}}
        <div class="product-info">
            <div class="d-flex justify-content-between">
                <h3 class="product-title">{{ $item->name }}</h3>
                <div class="rating">
                    <span class="d-flex" style="font-size: 12px; gap: 4px;">
                        <i class="bi bi-star-fill start-rating text-warning"></i>
                        @php $overallRating = getOverallRating($item->reviews); @endphp
                        <span
                            style="text-wrap-mode: nowrap;align-content: center;font-size: 15px;">{{ $overallRating[0] }}/5</span>
                    </span>
                </div>
            </div>

            <div class="product-price">${{ number_format($item->unit_price, 2, '.', ',') }} / {{ $item->unit }}
            </div>

            <div class="d-flex justify-content-between">
                <div class="product-moq">MOQ: {{ $item->minimum_order_qty }} {{ $item->unit }}</div>
                <img src="/flags/{{ strtolower($countryDetails['countryISO2']) }}.svg" class="flag-icon"
                    onerror="this.onerror=null; this.src='/flags/default.svg';"
                    alt="{{ $countryDetails['countryName'] }} flag">
            </div>

            @php
                if ($item->added_by == 'seller') {
                    $seller = \App\Models\Seller::find($item->user_id);
                    $shopName = $seller->shop->name ?? 'N/A';
                    $membership = $seller->membership ?? 'Standard';
                } else {
                    $shopName = 'Admin Shop';
                    $membership = 'Admin';
                }
            @endphp

            <div class="d-flex justify-content-between">
                <div class="product-seller">{{ $shopName }}</div>
                <div class="product-seller d-flex align-items-center">
                    <img src="/img/Diamond.png" alt="diamond" class="product-diamond dimond-img">
                    <span style="color: #FE4E56; font-weight: 600;">{{ $membership }}</span>
                </div>
            </div>

            <div style="justify-self: center;">
                <a
                    href="{{ auth('customer')->check() ? route('product', $item->slug) : route('customer.auth.login') }}">
                    <button class="start-order-btn">Start order</button>
                </a>
            </div>
        </div>
    </div>
@endforeach

{{-- JavaScript Carousel Controller --}}
<script>
    const productImages = @json(
        $products->mapWithKeys(function ($item) {
            $images = collect(json_decode($item->extra_images ?? '[]'))->filter()->values();
            $images->prepend($item->thumbnail);
            return [$item->id => $images];
        }));

    function updateCarousel(productId, index, total) {
        const img = document.getElementById(`product-img-${productId}`);
        img.src = '/storage/' + productImages[productId][index];
        img.dataset.index = index;
        document.getElementById(`carousel-counter-${productId}`).innerText = `${index + 1} / ${total}`;
    }

    function nextImage(productId, total) {
        const img = document.getElementById(`product-img-${productId}`);
        let index = parseInt(img.dataset.index);
        updateCarousel(productId, (index + 1) % total, total);
    }

    function prevImage(productId) {
        const img = document.getElementById(`product-img-${productId}`);
        let index = parseInt(img.dataset.index);
        const total = productImages[productId].length;
        updateCarousel(productId, (index - 1 + total) % total, total);
    }
</script>
