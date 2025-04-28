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
                                    <img class="ico" src="/{{ $image }}" style="height: 106px;"/>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-header">
                            <div class="product-title">{{ $stocksell->name }}</div>
                            <img class ="heart"
                                src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/69456c03811ace2c0c568374d486fb1c0b4f38c1?placeholderIfAbsent=true"
                                width="20" alt="Featured icon">
                        </div>
                        <div class="product-rate">
                            <div class="product-rate-label">Offer Rate:</div>
                            <div class="product-rate-value">{{ $stocksell->lower_limit ?? 'N/A' }}-{{ $stocksell->upper_limit ?? 'N/A' }}/{{ $stocksell->unit ?? 'N/A' }}</div>
                        </div>
                        <div class="product-origin">
                            <div>Origin:</div>
                            <div class="product-origin-location">
                                <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/5b1bea327edb9b7946bc239f6a800e8695ba92c6?placeholderIfAbsent=true"
                                    width="15" alt="Location icon">
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
