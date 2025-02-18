<section class="mainpagesection fade-in-on-scroll shadow">
    <div class="supplier-sec trd-product-sec">
        <div class="container-fluid">
            <h3>{{ PAGE_TITLE }}</h3>
            <div class="swiper-container trd-product-cnt" style="overflow:hidden; padding: 15px 0px 10px 10px;">
                <div class="swiper-wrapper">
                    @if (!empty($suppliers) && count($suppliers) > 0)
                        @foreach ($suppliers as $supplier)
                            <div class="swiper-slide">
                                <!-- Supplier Card -->
                                <div class="card text-center h-100 border-0">
                                    <img src="/storage/{{ $supplier['image1'] }}" alt="Supplier Image"
                                        class="img-fluid rounded scale-img" style="border-radius: 10px;" />
                                    <a href="#" class="supplier-link">
                                        <strong style="color: var(--web-hover)">{{ $supplier['name'] }}</strong>
                                    </a>
                                    <p class="text-muted">{{ $supplier['city_province'] }}</p>
                                    <p class="text-muted">{{ $supplier['business_type'] }}</p>
                                    <div class="supplier-rating">
                                        <?php for ($i = 0; $i < $supplier['rating']; $i++): ?>
                                        <i class="fa-solid fa-star text-warning"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="swiper-slide text-center">
                            <p>No suppliers available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper('.swiper-container', {
            slidesPerView: 2,
            spaceBetween: 20,
            loop: true,
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 5,
                },
                1200: {
                    slidesPerView: 6,
                },
            },
        });
    });
</script>

<style>
    /* Scale effect on image hover */
    .scale-img {
        transition: transform 0.3s ease;
    }

    .scale-img:hover {
        transform: scale(1.15);
    }
</style>
