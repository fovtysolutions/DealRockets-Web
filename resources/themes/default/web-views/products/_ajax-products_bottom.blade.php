<div class="bottomsideven">
    <div class="carouselven-bottom">
        <h3 style="text-align:left;">You May Also Like</h3>
        <div class="owl-carousel">
            @foreach($products as $item)
                <div class="carouselven-body">
                    <div class="carouselven-container">
                        @foreach($products as $item)
                            <div class="carouselven-bottom">
                                <p class="carouselven-badge">{{ $item->badge}}</p>
                                <img src="{{ $item->thumbnail !== 'imageurl' ? asset('storage/product/thumbnail/' . $item->thumbnail) : 'https://media.istockphoto.com/id/1409329028/vector/no-picture-available-placeholder-thumbnail-icon-illustration-design.jpg?s=612x612&w=0&k=20&c=_zOuJu755g2eEUioiOUdz_mHKJQJn-tDgIAhQzyeKUQ=' }}"
                                    alt="Item Image" class="carouselven-image" />
                                <h4 class="carouselven-title">{{ $item->name }}</h4>
                                <p class="carouselven-price">US {{ $item->unit_price }}/{{$item->unit}}</p>
                                <p class="carouselven-order">Min. Order: {{ $item->min_qty ?? '1' }} per {{$item->unit}}</p>
                                <p class="carouselven-origin">Origin: {{ $item->origin ?? 'Unknown' }}</p>
                                <p class="carouselven-description">{{ $item->meta_description }}</p>
                                <p class="carouselven-rating">
                                    <?php        $rating = 5?>
                                    @if($rating > 3.2)
                                        <span>⭐⭐⭐</span>
                                    @elseif($rating > 1.6)
                                        <span>⭐⭐</span>
                                    @else
                                        <span>⭐</span>
                                    @endif
                                </p>
                                <div class="carouselven-buttons">
                                    <button class="carouselven-button">
                                        <img style="height: 20px; width: 20px; filter: brightness(0) invert(1);"
                                            src="{{ asset('/svgs/mail.png') }}" /> Contact Now
                                    </button>
                                    <button class="carouselven-button">
                                        <img style="height: 20px; width: 20px; filter: brightness(0) invert(1);"
                                            src="{{ asset('/svgs/messenger.png') }}" /> Chat
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(".bottomsideven .owl-carousel").owlCarousel({
            items: 3,
            loop: true,
            autoplay: true,
            autoplayTimeout: 2000,
            responsive: {
                0: {
                    items: 1
                },
                464: {
                    items: 2
                },
                1024: {
                    items: 3
                }
            }
        });
    });
</script>