@foreach ($products as $index => $item)
    <div class="product-card1 d-flex" onclick="window.location='{{ route('product', $item->slug) }}';">
         <!-- <a href="{{ route('product', $item->slug) }}" style="width: 100%;"></a> -->
            <div class="imagebox ">
                <div class="heart-image">
                    <div class="circle-container">
                        @php
                            $user = auth('customer')->user();
                            if ($user) {
                                $isFavourite = \App\Utils\HelperUtil::checkIfFavourite($item->id, $user->id, 'product');
                            } else {
                                $isFavourite = false;
                            }
                            $vendorExtra = \App\Models\VendorExtraDetail::where('seller_id', $item->user_id)->first();
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
                        @if (auth('customer')->user())
                            <img class="heart favourite-img" onclick="makeFavourite(this)" data-id="{{ $item->id }}"onerror="this.onerror=null;this.src='/images/placeholderimage.webp';" 
                                data-userid="{{ $user->id }}" data-type="product"
                                data-role="{{ auth()->user()->role ?? 'customer' }}"
                                src="{{ $isFavourite ? theme_asset('public/img/Heart (2).png') : theme_asset('public/img/Heart (1).png') }}"
                                width="20" alt="Featured icon" style="margin-left: auto;">
                        @else
                            <img class="heart favourite-img" onclick="sendtologin()" onerror="this.onerror=null;this.src='/images/placeholderimage.webp';"  
                                src="{{ theme_asset('public/img/Heart (1).png') }}" width="20" alt="Featured icon"
                                style="margin-left: auto;">
                        @endif
                    </div>
                </div>
                <img src="{{ isset($item->thumbnail) ? '/storage/' . $item->thumbnail : '/images/placeholderimage.webp' }}" onerror="this.onerror=null;this.src='/images/placeholderimage.webp';"
                    alt="Sample Product" class="product-image1">
            </div>
            <div class="product-info1">
                @if (Carbon\Carbon::parse($item->created_at)->gt(Carbon\Carbon::now()->subDays(30)))
                    <div class="d-flex justify-content-between" style="align-items: center; padding-bottom: 11px;">
                        <p class="new">New</p>
                        <div class="rating">
                            <span style="font-size: 12px;">
                                <i class="bi bi-star-fill start-rating" style="color: #ffbb00;font-size: 14px !important;"></i>
                                @php
                                    $overallRating = getOverallRating($item->reviews);
                                @endphp
                                {{ $overallRating[0] }}/5
                            </span>
                        </div>
                    </div>
                @else
                    <div class="d-flex justify-content-between" style="align-items: center; padding-bottom: 11px;">
                        @if ($item->badge)
                            <p class="new">{{ $item->badge }}</p>
                        @else
                            <div></div>
                        @endif
                        <div class="rating">
                            <span style="font-size: 12px;">
                                <i class="bi bi-star-fill start-rating" style="color: #ffbb00;font-size: 14px !important;"></i>
                                @php
                                    $overallRating = getOverallRating($item->reviews);
                                @endphp
                                {{ $overallRating[0] }}/5
                            </span>
                        </div>
                    </div>
                @endif
                <h3 class="product-title product-title1 text-truncate" style="height: 1rem; margin-bottom: 5px; font-size: 16px; display:flex; justify-content:space-between;">
                    {{ $item->name }}
                    @if ($item->origin)
                        @php
                            $countryDetails = \App\Utils\ChatManager::getCountryDetails($item->origin);
                        @endphp
                        @if ($countryDetails)
                            <div style="display: flex; align-items: center; gap: 5px;">
                                <img src="/flags/{{ strtolower($countryDetails['countryISO2']) }}.svg"
                                    class="flag-icon" alt="{{ $countryDetails['countryName'] }} flag" 
                                    style="width: 17px;" />
                                <span>{{ $countryDetails['countryName'] }}</span>
                            </div>
                        @endif
                    @endif
                </h3>
                <div class="product-price product-price1" style="font-size: 18px;">
                    ${{ number_format($item->unit_price, 2, '.', ',') }} <span
                        style="color: #515050; font-size: 14px; font-weight: 400;"> / {{ $item->unit }}</span></div>
                <div class="product-moq product-moq1">{{ $item->minimum_order_qty }} {{ $item->unit }} <span
                        style="color: #515050; font-size: 16px;">(MOQ)</span></div>
                <div class="product-subtitle" style="margin-bottom: 10px;color: #555 !important; font-size: 14px !important;">
                    {{ $item->short_details }}
                </div>
                
                {{-- Business type information like grid view --}}
                {{-- <div class="lead-details-table">
                    <table class="detail-table">
                        <tr>
                            <td class="detail-label">Origin</td>
                            <td class="detail-value text-truncate">{{ $item->origin ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="detail-label">Terms</td>
                            <td class="detail-value text-truncate">{{ $item->delivery_terms ?? 'N/A' }}</td>
                        </tr>
                    </table>
                    <table class="detail-table">
                        <tr>
                            <td class="detail-label">Supply</td>
                            <td class="detail-value text-truncate">{{ $item->supply_capacity ?? 'N/A' }} <span>
                                    {{ $item->supply_unit ?? 'N/A' }} </span></td>
                        </tr>
                        <tr>
                            <td class="detail-label">Mode</td>
                            <td class="detail-value text-truncate">{{ $item->delivery_mode ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </div> --}}
                {{-- <div class="product-exhibition product-exhibition1">Exhibition: Tech Expo 2025</div> --}}
            </div>
            <div
                style="width: 25%;padding: 10px;height: -webkit-fill-available;display: flex;flex-direction: column;justify-content: space-between;">
                <div class="product-seller product-seller1" style="text-decoration: underline;">{{ $shopName ?? '' }}</div>
                <div>
                    @if ($memberCheck == 1)
                        <img src="/img/Diamond.png" alt="diamond" class="dimond-img" style="width: 25px;">
                        <span style="font-size: 14px;color: #555;">Verified</span>
                    @endif
                    <div class="product-seller product-seller1"
                        style="color: rgba(81, 80, 80, 1);font-size: 14px;font-weight: 400;">
                        {{ $vendorExtra->city ?? 'City' }},{{ $vendorExtra->country ?? 'Country' }}
                    </div>
                    <div class="product-seller product-seller1"
                        style="color: rgba(81, 80, 80, 1);font-size: 14px;font-weight: 400;">
                        {{ $vendorExtra->postal_code ?? '110122' }}
                    </div>
                </div>
                {{-- <div class="product-diamond">
                    <img src="/img/Diamond.png" alt="diamond" class="dimond-img">
                </div> --}}
                <div class="d-flex gap-3" style="flex-wrap: wrap;">
                    <a href="{{ route('product', $item->slug) }}">
                        <button class="start-order-btn1">Inquire</button>
                    </a>
                    <a href="{{ route('shopView', ['id' => $item->seller->shop->id]) }}">
                        <button class="start-order-btn1">Explore</button>
                    </a>
                </div>
            </div>
        <!-- </a> -->
    </div>

    {{-- ✅ Vendor Ad after every 6 products --}}
    @if (($index + 1) % 6 === 0)
        <div class="vendor-ad-list" style="width: 100%; margin: 20px 0; border-radius: 8px; overflow: hidden;">
            <a href="javascript:0" style="display: block; width: 100%; height: 200px;">
                <img src="/images/vendor-ad-placeholder.jpg" 
                     style="width: 100%; height: 100%; object-fit: cover;" 
                     alt="Vendor Ad"
                     onerror="this.onerror=null;this.src='/images/placeholderimage.webp';" 
                     class="img-fluid">
            </a>
        </div>
    @endif
@endforeach
