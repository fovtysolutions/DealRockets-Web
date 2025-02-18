<section class="mainpagesection fade-in-on-scroll" id="trendingselection">
    <div class="trd-product-sec">
        <h3 class="custom-dealrock-head"><?php echo PRODUCT_SECTION_TITLE; ?></h3>
        @php
            $trending = App\Utils\ChatManager::GetTrendingProducts();
            $searches = App\Utils\HelperUtil::getsearchedproducts($trending);
        @endphp
        <!-- Loop through the products in chunks of 6 -->
        @foreach (array_chunk($searches['array'], 10) as $chunk)
            <div class="container-fluid" style="padding: 0px 10px 0px 0px;">
                <div class="swiper-container trd-product-cnt" style="overflow:hidden; ">
                    <div class="swiper-wrapper">
                        @foreach ($chunk as $trendprods)
                            <div class="swiper-slide">
                                <div class="trd-product-item">
                                    <a href='/product/{{ $trendprods['slug'] }}'>
                                        <div class="image-container overflow-hidden mb-2" style="max-width: 100%; height: auto; position: relative;">
                                            <img 
                                                class="img-fluid" 
                                                src="{{ isset($trendprods['thumbnail']) ? '/storage/product/thumbnail/' . $trendprods['thumbnail'] : '/images/placeholderimage.webp' }}" 
                                                alt="{{ $trendprods['name'] }}" 
                                                style="object-fit: cover; width: 100%; height: 100%;"
                                            />
                                        </div>                                        
                                        <span class="custom-dealrock-text">{{ $trendprods['name'] }}</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize each swiper container
        const swipers = document.querySelectorAll('.swiper-container');
        swipers.forEach((swiperContainer) => {
            new Swiper(swiperContainer, {
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
    });
</script>
