<!-- Banner -->
<div class="banner">
    @if (!empty($shopInfoArray['id']) && $shopInfoArray['id'] != 0 && !empty($shopInfoArray['banner_full_url']))
        <img src="{{ getStorageImages(path: $shopInfoArray['banner_full_url'], type: 'wide-banner') }}" alt="Banner" />
    @else
        @php $banner = getWebConfig(name: 'shop_banner'); @endphp
        <img src="{{ getStorageImages(path: $banner, type: 'wide-banner') }}" alt="Banner" />
    @endif
</div>

<!-- About & Certificates section -->
<section class="section top-section">
    <div class="contant-section">
        <div class="top-section-left">
            <div class="company-history">
                <h2>{{ $shopInfoArray['company_profiles']->title ?? '' }}</h2>
                <div class="subline">{{ $shopInfoArray['company_profiles']->subtitle ?? '' }}</div>
                <div class="response-time">
                    <span>Avg Response time:</span> <strong>48–72 h</strong>
                </div>
            </div>
            <div class="about">
                <h3>{{ $shopInfoArray['company_profiles']->description_head ?? '' }}</h3>
                <p>{{ $shopInfoArray['company_profiles']->description_text ?? '' }}</p>
            </div>
        </div>

        <div class="top-section-right">
            {{-- <button class="inquire-btn" data-bs-toggle="modal" data-bs-target="#inquireModel">
                <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/9881a67e7313be73b75bd5f735007e08ab4512c3?placeholderIfAbsent=true"
                    alt="Email icon" width="18" />
                Inquire Now
            </button> --}}

            <div class="certificates">
                @if (!empty($shopInfoArray['certificates']) && is_array($shopInfoArray['certificates']))
                    @foreach ($shopInfoArray['certificates'] as $item)
                        @if (!empty($item))
                            <img src="/storage/{{ $item }}" alt="Cert" onerror="this.onerror=null; this.src='/images/placeholderimage.webp';" />
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <div class="gallery">
        @if (!empty($shopInfoArray['images']) && is_array($shopInfoArray['images']))
            @foreach ($shopInfoArray['images'] as $item)
                @if (!empty($item))
                    <img src="/storage/{{ $item }}" class="side-image" onerror="this.onerror=null; this.src='/images/placeholderimage.webp';"/>
                @endif
            @endforeach
        @endif
    </div>
</section>

<!-- New Products Section -->

{{-- <div class="main-content">
    <h4 class="top-product-h">Top Products</h4>
    <div class="top-product-grid">
        @foreach ($products->take(5) as $item)
            <div class="top-product-card">
                <div class="heart-icon-div">
                    @php
                        $user = auth('customer')->user();
                        $isFavourite = $user ? \App\Utils\HelperUtil::checkIfFavourite($item->id, $user->id, 'product') : false;
                    @endphp

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

                <img src="/storage/product/thumbnail/{{ $item->thumbnail ?? 'default.png' }}" alt="{{ $item->name }}"
                    class="product-image">

                <div class="product-info">
                    <div class="d-flex justify-content-between">
                        <p class="new">{{ $item->badge ?? '' }}</p>

                        <div class="rating">
                            <span style="font-size: 12px;">
                                <i class="bi bi-star-fill start-rating text-warning"></i>
                                @php $overallRating = getOverallRating($item->reviews ?? []); @endphp
                                {{ $overallRating[0] ?? '0' }}/5
                            </span>
                        </div>
                    </div>

                    <h3 class="top-product-title">{{ $item->name }}</h3>
                    <div class="top-product-price">US$ {{ number_format($item->unit_price ?? 0, 2, '.', ',') }} / {{ $item->unit ?? 'unit' }}</div>
                    <div class="top-product-moq">{{ $item->minimum_order_qty ?? 1 }} {{ $item->unit ?? 'unit' }} (MOQ)</div>

                    @php
                        if ($item->added_by == 'seller') {
                            $seller = \App\Models\Seller::find($item->user_id);
                            $shopName = $seller->shop->name ?? 'N/A';
                        } elseif ($item->added_by == 'admin') {
                            $shopName = 'Admin Shop';
                        } else {
                            $shopName = 'Unknown';
                        }
                    @endphp
                    <div class="top-product-seller">{{ $shopName }}</div>

                    <div class="top-product-diamond">
                        <img src="/img/Diamond.png" alt="diamond" class="dimond-img" style="width: 25px;">
                    </div>

                    <div>
                        @if (!auth('customer')->check())
                            <a href="{{ route('customer.auth.login') }}">
                        @else
                            <a href="{{ route('product', $item->slug) }}">
                        @endif
                            <button class="top-start-order-btn">Start order</button>
                            </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div> --}}
