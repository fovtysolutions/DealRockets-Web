<div class="product-cards-container" id="stocksaleOfferDynamic">
    @if ($items->isEmpty())
        <p>There are no Products to display!</p>
    @else
        @foreach ($items as $stocksell)
            <div class="product-card" data-id="{{ $stocksell->id }}" onclick="populateDetailedBox(this)">
                <div class="product-card-inner">
                    <div class="product-card-content">
                        <div class="product-image-container">
                            <div class="owl-carousel icon-carousel">
                                @php
                                    $images = json_decode($stocksell->image, true) ?? [];
                                @endphp

                                @forelse ($images as $image)
                                    <div class="item">
                                        <img class="ico" src="/{{ $image }}"
                                             onerror="this.onerror=null;this.src='/images/placeholderimage.webp';"
                                             style="max-height: 135px; width: 100%; aspect-ratio: 1/1;" />
                                    </div>
                                @empty
                                    <div class="item">
                                        <img class="ico" src="/images/placeholderimage.webp"
                                             style="max-height: 135px; width: 100%; aspect-ratio: 1/1;" />
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="product-info">
                            <div class="product-header">
                                <div class="product-title">{{ $stocksell->product->name ?? ($stocksell->name ?? 'N/A') }}</div>

                                @php
                                    $user = auth('customer')->user();
                                    $isFavourite = $user
                                        ? \App\Utils\HelperUtil::checkIfFavourite($stocksell->id, $user->id, 'stocksell')
                                        : false;
                                @endphp

                                @if ($user)
                                    <img class="heart favourite-img" onclick="makeFavourite(this)"
                                         data-id="{{ $stocksell->id }}" data-userid="{{ $user->id }}"
                                         data-type="stocksell" data-role="{{ auth()->user()->role ?? 'customer' }}"
                                         src="{{ $isFavourite ? theme_asset('public/img/Heart (2).png') : theme_asset('public/img/Heart (1).png') }}"
                                         width="20" alt="Featured icon">
                                @else
                                    <img class="heart favourite-img" onclick="sendtologin()"
                                         src="{{ theme_asset('public/img/Heart (1).png') }}" width="20"
                                         alt="Featured icon">
                                @endif
                            </div>

                            <div class="product-rate">
                                <div class="product-rate-label">Offer Rate:</div>
                                <div class="product-rate-value">
                                    {{ $stocksell->lower_limit ?? 'N/A' }} - {{ $stocksell->upper_limit ?? 'N/A' }} / {{ $stocksell->unit ?? 'unit' }}
                                </div>
                            </div>

                            <div class="product-origin">
                                <div style="width: 75px;">Origin:</div>
                                <div class="product-origin-location">
                                    @php
                                        $country = \App\Models\Country::find($stocksell->country);
                                        $countryName = $country->name ?? 'N/A';
                                        $countryDetails = $stocksell->country ? \App\Utils\ChatManager::getCountryDetails($stocksell->country) : null;
                                        $countryISO2 = $countryDetails['countryISO2'] ?? null;
                                        $flag = $countryISO2 ? '/flags/' . strtolower($countryISO2) . '.svg' : null;
                                    @endphp
                               @if ($flag)
                                        <img src="{{ $flag }}" width="15" alt="Flag">
                                    @endif
                                    <div>{{ $stocksell->city ?? 'Unknown City' }}, {{ $countryName }}</div>
                                </div>
                            </div>

                            <div class="product-origin">
                                <div style="width: 75px;">Quantity:</div>
                                <div class="product-origin-location">
                                    {{ $stocksell->quantity }}  {{ $stocksell->unit }}
                                </div>
                            </div>

                            <div class="product-description">
                                {!! $stocksell->description ?? '<em>No description available</em>' !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
