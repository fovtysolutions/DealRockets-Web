<div class="product-cards-container" id="stocksaleOfferDynamic">
    @foreach($items as $stocksell)
        <div class="product-card" data-id="{{ $stocksell->id }}" onclick="populateDetailedBox(this)">
            <div class="product-card-inner">
                <div class="product-card-content">
                    <div class="product-image-container">
                        <div class="owl-carousel icon-carousel">
                            <!-- Loop through the images (using PHP) -->
                            @foreach (json_decode($stocksell->image, true) as $image)
                                <div class="item">
                                    <img class="ico" src="/{{ $image }}" style="height: 106px; width: 100%;"/>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-header">
                            <div class="product-title">{{ $stocksell->name }}</div>
                            @php
                                $user = auth('customer')->user();
                                if($user){
                                    $isFavourite = \App\Utils\HelperUtil::checkIfFavourite($stocksell->id, $user->id, 'stocksell');
                                } else {
                                    $isFavourite = false;
                                }
                            @endphp
                            @if(auth('customer')->user())
                                <img class="heart favourite-img" onclick="makeFavourite(this)"  
                                    data-id="{{ $stocksell->id }}" 
                                    data-userid="{{ $user->id }}"
                                    data-type="stocksell" 
                                    data-role="{{ auth()->user()->role ?? 'customer' }}"
                                    src="{{ $isFavourite ? theme_asset('public/img/Heart (2).png') : theme_asset('public/img/Heart (1).png') }}"
                                    width="20" alt="Featured icon">
                            @else
                                <img class="heart favourite-img" onclick="sendtologin()"  
                                    src="{{ theme_asset('public/img/Heart (1).png') }}"
                                    width="20" alt="Featured icon">
                            @endif
                        </div>
                        <div class="product-rate">
                            <div class="product-rate-label">Offer Rate:</div>
                            <div class="product-rate-value">{{ $stocksell->lower_limit ?? 'N/A' }}-{{ $stocksell->upper_limit ?? 'N/A' }}/{{ $stocksell->unit ?? 'N/A' }}</div>
                        </div>
                        <div class="product-origin">
                            <div>Origin:</div>
                            <div class="product-origin-location">
                                @php
                                    $countryDetails = \App\Utils\ChatManager::getCountryDetails($stocksell->country);
                                    $countryISO2 = $countryDetails['countryISO2'] ?? null;
                                    $imagepath = $countryISO2 ? "/flags/" . strtolower($countryISO2) . ".svg" : null;
                                @endphp

                                @if($imagepath)
                                    <img src="{{ $imagepath }}" width="15" alt="Location icon">
                                @endif
                                <div>{{ $stocksell->city ?? 'N/A' }}, {{ \App\Models\Country::where('id',$stocksell->country)->first()->name }}</div>
                            </div>
                        </div>
                        <div class="product-description">
                            {!! $stocksell->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
