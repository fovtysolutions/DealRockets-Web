@if (empty($carouselimages))
    <section class="mainpagesection fade-in"
        style="/* background-color: unset; */ margin-top: 22px; box-shadow: 0px 0px 1px 0px;">
    @else
        <section class="mainpagesection fade-in"
            style="/* background-color: unset; */ margin-top: 320px; box-shadow: 0px 0px 1px 0px;">
@endif
<div class="globle-deals">
    <div class="box flex p-0">
        <!-- Toggle Button for Small Screens -->
        <div class="btn menu-toggle d-flex justify-content-between d-md-none w-100 h-100">
            {{-- <i class="fa-solid fa-bars pr-2 align-items-center"></i> --}}
            <h5 class="fw-bold" style="color: black;">
                <span style="color:rgb(236, 51, 51);">☰</span> TOP CATEGORIES
            </h5>
        </div>

        <!-- Sidebar -->
        <div class="sidebar d-md-block border-0 h-100" id="sidebarMenu">
            <h5 class="fw-bold hidebelow728" style="color: black;">
                <span style="color:rgb(236, 51, 51);">☰</span> TOP CATEGORIES
            </h5>
            <ul id="categoryList" class="category-list">
                @foreach ($categories as $key => $category)
                    <li class="text-left">
                        <a
                            href="{{ route('marketplace-categories', ['id' => $category['id']]) }}">{{ $category->name }}</a>
                        @if ($category->childes->count() > 0)
                            <div class="mega_menu_new">
                                @foreach ($category->childes as $sub_category)
                                    <div class="mega_menu_inner_new">
                                        <h6>
                                            <a
                                                href="{{ route('products', ['category_id' => $sub_category['id'], 'data_from' => 'category', 'page' => 1]) }}">{{ $sub_category->name }}</a>
                                        </h6>
                                        @if ($sub_category->childes->count() > 0)
                                            @foreach ($sub_category->childes as $sub_sub_category)
                                                <div>
                                                    <a
                                                        href="{{ route('products', ['category_id' => $sub_sub_category['id'], 'data_from' => 'category', 'page' => 1]) }}">{{ $sub_sub_category->name }}</a>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
            <div>
                <a class="arrow-move-hover" href="{{ route('categories') }}" style="text-decoration: none;">
                    View All
                    <span class="arrow-icon">
                        <img src="/img/Right arrow.png" alt="arrow-right" style="height:16px; width: 16px;">
                    </span>
                    <span class="arrow-icon-colored">
                        <img src="/img/Right arrow (1).png" alt="arrow-right" style="height:16px; width: 16px;">
                    </span>
                </a>
            </div>
        </div>
    </div>

    <div class="insidebox" id="insideBox">
        <div class="d-flex flex-row insideinsidebox">
            <!-- Carousel Section -->
            <div class="mainbannerbox">
                <div id="carouselExample" class="carousel slide owl-carousel owl-theme">
                    <div class="item">
                        <div class="image-wrapper shimmer">
                            <img data-src="img/main.png" class="d-block w-100 h-100 lazyload" alt="Slide 1">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Section -->
            <div class="flex-column mt-md-0 mt-sm-2 sidebannerbox">
                <div id="carouselExample1" class="carousel slide owl-carousel owl-theme">
                    <div class="item">
                        <div class="card image-wrapper shimmer">
                            <img class="lazyload" data-src="img/side1.png" alt="Card Image">
                        </div>
                    </div>
                </div>
                <div id="carouselExample2" class="carousel slide owl-carousel owl-theme">
                    <div class="item">
                        <div class="card image-wrapper shimmer">
                            <img class="lazyload" data-src="img/side1.png" alt="Card Image">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Section -->
        <div class="scroll-wrapper position-relative">
            <div class="scroll-arrow-right" onclick="scrollRight()">
                &#10095;
            </div>
            <div class="card-group scroll-container" style="gap:10px; justify-content:space-around;">
                <div class="cardbottom">
                    <a href="{{ $firstbox['url'] ?? '#' }}" style="text-decoration: none;"
                        class="image-wrapper shimmer">
                        <img data-src="{{ isset($firstbox['image']) ?  '/storage/' . $firstbox['image'] : '/images/placeholderimage.webp' }}" class="lazyload"
                            alt="...">
                        <div class="card-bodybottom py-0" style="background-color: #E2E8F0;">
                            <h5 class="card-titlebottom">{{ $firstbox['title'] ?? 'Trade Shows' }}</h5>
                        </div>
                    </a>
                </div>
                <div class="cardbottom">
                    <a href="{{ $secondbox['url'] ?? '#' }}" style="text-decoration: none;"
                        class="image-wrapper shimmer">
                        <img data-src="{{ isset($secondbox['image']) ?  '/storage/' . $secondbox['image'] : '/images/placeholderimage.webp' }} class="lazyload"
                            alt="...">
                        <div class="card-bodybottom py-0" style="background-color: #E2E8F0;">
                            <h5 class="card-titlebottom">{{ $secondbox['title'] ?? 'Trade Shows' }}</h5>
                        </div>
                    </a>
                </div>
                <div class="cardbottom">
                    <a href="{{ $thirdbox['url'] ?? '#' }}" style="text-decoration: none;"
                        class="image-wrapper shimmer">
                        <img data-src="{{ isset($thirdbox['image']) ?  '/storage/' . $thirdbox['image'] : '/images/placeholderimage.webp' }} class="lazyload"
                            alt="...">
                        <div class="card-bodybottom py-0" style="background-color: #E2E8F0;">
                            <h5 class="card-titlebottom">{{ $thirdbox['title'] ?? 'Trade Shows' }}</h5>
                        </div>
                    </a>
                </div>
                <div class="cardbottom">
                    <a href="{{ $fourthbox['url'] ?? '#' }}" style="text-decoration: none;"
                        class="image-wrapper shimmer">
                        <img data-src="{{ isset($fourthbox['image']) ?  '/storage/' . $fourthbox['image'] : '/images/placeholderimage.webp' }}" class="lazyload"
                            alt="...">
                        <div class="card-bodybottom py-0" style="background-color: #E2E8F0;">
                            <h5 class="card-titlebottom">{{ $fourthbox['title'] ?? 'Trade Shows' }}</h5>
                        </div>
                    </a>
                </div>
                <div class="cardbottom">
                    <a href="{{ $fifthbox['url'] ?? '#' }}" style="text-decoration: none;"
                        class="image-wrapper shimmer">
                        <img data-src="{{ isset($fifthbox['image']) ?  '/storage/' . $fifthbox['image'] : '/images/placeholderimage.webp' }}" class="lazyload"
                            alt="...">
                        <div class="card-bodybottom" style="background-color: #E2E8F0;">
                            <h5 class="card-titlebottom py-0">{{ $fifthbox['title'] ?? 'Trade Shows' }}</h5>
                            <!-- <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> -->
                        </div>
                    </a>
                </div>
            </div>
            <div class="fade-right"></div>
        </div>
    </div>
</div>
</section>
<script defer>
    function initiateCarousel() {
        $('#carouselExample').owlCarousel({
            items: 1,
            loop: true,
            nav: false,
            dots: true,
            margin: 30,
            autoplay: true,
            autoplayTimeout: 5000,
            // lazyLoad: true,
            smartSpeed: 800,
            autoHeight: false,
        });
    }

    function initiateCarousel1() {
        $('#carouselExample1').owlCarousel({
            items: 1,
            loop: true,
            nav: false,
            dots: true,
            margin: 30,
            autoplay: true,
            autoplayTimeout: 5000,
            // lazyLoad: true,
            smartSpeed: 800,
            autoHeight: false,
        });
    }

    function initiateCarousel2() {
        $('#carouselExample2').owlCarousel({
            items: 1,
            loop: true,
            nav: false,
            dots: true,
            margin: 30,
            autoplay: true,
            autoplayTimeout: 5000,
            // lazyLoad: true,
            smartSpeed: 800,
            autoHeight: false,
        });
    }
</script>
<script defer>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.querySelector('.menu-toggle');
        const sidebar = document.getElementById('sidebarMenu');

        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('d-block');
        });
    });
</script>
<script defer>
    document.addEventListener("DOMContentLoaded", function() {
        if (window.innerWidth > 768) {
            const wrapper = document.getElementById('categoryList');
            const referenceBox = document.querySelector('.insideinsidebox');
            const scrollBoxHeight = document.querySelector('.scroll-wrapper');

            if (!wrapper || !referenceBox || !scrollBoxHeight) return;

            const setMaxHeight = () => {
                if (wrapper.classList.contains('expanded')) return;

                wrapper.style.maxHeight = 'none'; // reset to measure full
                const fullHeight = wrapper.scrollHeight;
                const refHeight = referenceBox.offsetHeight + scrollBoxHeight.offsetHeight - 60;

                const maxHeight = Math.min(fullHeight, refHeight);
                wrapper.style.maxHeight = `${maxHeight}px`;
            };

            initiateCarousel();
            initiateCarousel1();
            initiateCarousel2();

            // Debounce to prevent excessive calls
            let resizeTimeout;
            const debouncedSetMaxHeight = () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(setMaxHeight, 100);
            };

            // Initial
            setMaxHeight();

            // On window resize
            window.addEventListener('resize', () => {
                debouncedSetMaxHeight();
            });

            // ResizeObserver for dynamic layout/element size changes
            const resizeObserver = new ResizeObserver(() => {
                debouncedSetMaxHeight();
            });
            resizeObserver.observe(referenceBox);
            resizeObserver.observe(scrollBoxHeight);
            resizeObserver.observe(wrapper);

            // MutationObserver for DOM content changes
            const mutationObserver = new MutationObserver(() => {
                debouncedSetMaxHeight();
            });
            mutationObserver.observe(wrapper, {
                childList: true,
                subtree: true
            });

            // Final layout fallback on load (e.g., images, fonts)
            window.addEventListener('load', () => setTimeout(() => {
                setMaxHeight();
            }, 300));
        } else {
            return;
        }
    });

    function scrollRight() {
        const container = document.querySelector('.scroll-container');
        if (!container) return;

        const scrollAmount = container.offsetWidth * 0.8; // Scroll by 80% of visible width
        container.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
    }
</script>
