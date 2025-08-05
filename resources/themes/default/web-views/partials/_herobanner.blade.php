<style>
    .category-list {
        list-style: none;
        margin: 0;
        padding: 0;
        position: relative;
    }

    .category-item {
        position: relative;
    }

    .mega_menu_new {
        position: absolute;
        top: 0;
        left: 100%;
        /* Open to the right */
        display: none;
        background: white;
        z-index: 1000;
        width: 50vw;
        padding: 30px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-left: 1px solid #eee;
        overflow: hidden;
    }

    .mega_menu_new .sub-sub-category {
        font-size: 12px;
        color: rgba(81, 80, 80, 1) !important;
    }

    .mega_menu_new .view-all-sub-sub-category {
        font-size: 12px;
        color: rgba(254, 78, 68, 1) !important;
    }

    /* .globle-deals .category-list {
        overflow: hidden;
    } */

    .category-item:hover>.mega_menu_new {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        flex-wrap: wrap;
        gap: 10px;
    }

    .globle-deals .mega_menu_new a:hover {
        color: #FE4E44 !important;
        background-color: unset !important;
    }

    .globle-deals .mega_menu_new a:hover::after {
        content: unset !important;
    }

    .category-item:hover > a{
        color: #FE4E44 !important;
        background-color: #F6F6F6;
    }

    .mega_menu_inner_new {
        min-height: 216px;
    }
</style>
@if (empty($carouselimages))
    <section class="mainpagesection fade-in" style="/* background-color: unset; */ margin-top: 22px;">
    @else
        <section class="mainpagesection fade-in" style="/* background-color: unset; */ margin-top: 320px;">
@endif
<div class="globle-deals">
    <div class="box flex p-0">
        <!-- Toggle Button for Small Screens -->
        <div class="btn menu-toggle d-flex justify-content-between d-md-none w-100 h-100">
            {{-- <i class="fa-solid fa-bars pr-2 align-items-center"></i> --}}
            <h5 class="fw-bold dealrocket-text-18" style="color: black;">
                <span style="color:rgb(236, 51, 51);">☰</span> TOP CATEGORIES
            </h5>
        </div>

        <!-- Sidebar -->
        <div class="sidebar d-md-block border-0 h-100" id="sidebarMenu">
            <h5 class="fw-bold hidebelow728 dealrocket-text-18" style="color: black;">
                <span style="color:rgb(236, 51, 51);">☰</span> TOP CATEGORIES
            </h5>
            <ul id="categoryList" class="category-list">
                @foreach ($categories as $key => $category)
                    <li class="text-left category-item"> <!-- Added class here -->
                        <a class="dealrocket-text-14" href="{{ route('marketplace-categories', ['id' => $category['id']]) }}">
                            {{ $category->name }}
                        </a>

                        @if ($category->childes->count() > 0)
                            <div class="mega_menu_new">
                                @foreach ($category->childes->take(6) as $sub_category)
                                    <div class="mega_menu_inner_new">
                                        <h6>
                                            <a class="dealrocket-text-14"
                                                href="{{ route('products', ['category_id' => $sub_category['id'], 'data_from' => 'category', 'page' => 1]) }}">
                                                {{ $sub_category->name }}
                                            </a>
                                        </h6>
                                        @if ($sub_category->childes->count() > 0)
                                            @foreach ($sub_category->childes->take(5) as $sub_sub_category)
                                                <div>
                                                    <a class="sub-sub-category dealrocket-text-14"
                                                        href="{{ route('products', ['category_id' => $sub_sub_category['id'], 'data_from' => 'category', 'page' => 1]) }}">
                                                        {{ $sub_sub_category->name }}
                                                    </a>
                                                </div>
                                            @endforeach
                                            @if ($sub_category->childes->count() > 5)
                                                <div>
                                                    <a class="view-all-sub-sub-category"
                                                        href="{{ route('products', ['category_id' => $sub_category['id'], 'data_from' => 'category', 'page' => 1]) }}">
                                                        View All
                                                    </a>
                                                </div>
                                            @endif
                                        @else
                                            <div style="padding-top: 6px;">
                                                <span class="sub-sub-category mt-4"
                                                    style="color: rgba(81, 80, 80, 1);">No Data Avaliable</span>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                                <div>
                                    <a class="view-all-sub-sub-category"
                                        href="{{ route('categories') }}">
                                        More Categories
                                    </a>
                                </div>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
            <div style="padding-top: 5px;">
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
                <div id="carouselExample" class="owl-theme owl-carousel">
                    @if (!empty($banners))
                        @foreach ($banners as $banner)
                            <div class="item">
                                <a href="javascript:void(0)">
                                    <div class="card image-wrapper shimmer">
                                        <img class="lazyload" data-src="/storage/company/{{ $banner }}"
                                            alt="Card Image">
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="item">
                            <div class="image-wrapper shimmer">
                                <img data-src="img/main.png" class="d-block w-100 h-100 lazyload" alt="Slide 1">
                            </div>
                        </div>
                        <div class="item">
                            <div class="image-wrapper shimmer">
                                <img data-src="img/main.png" class="d-block w-100 h-100 lazyload" alt="Slide 1">
                            </div>
                        </div>
                        <div class="item">
                            <div class="image-wrapper shimmer">
                                <img data-src="img/main.png" class="d-block w-100 h-100 lazyload" alt="Slide 1">
                            </div>
                        </div>
                        <div class="item">
                            <div class="image-wrapper shimmer">
                                <img data-src="img/main.png" class="d-block w-100 h-100 lazyload" alt="Slide 1">
                            </div>
                        </div>
                        <div class="item">
                            <div class="image-wrapper shimmer">
                                <img data-src="img/main.png" class="d-block w-100 h-100 lazyload" alt="Slide 1">
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar Section -->
            <div class="flex-column mt-md-0 mt-sm-2 sidebannerbox">
                <div id="carouselExample1" class="owl-theme owl-carousel">
                    @if (!$solutions->isEmpty())
                        @foreach ($solutions as $solution)
                            <div class="item">
                                <a href="{{ route('solutions.web', ['id' => $solution->id]) }}">
                                    <div class="card image-wrapper shimmer">
                                        <img class="lazyload" data-src="/storage/{{ $solution->image }}"
                                            alt="Card Image">
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="item">
                            <div class="card image-wrapper shimmer">
                                <img class="lazyload" data-src="img/side1.png" alt="Card Image">
                            </div>
                        </div>
                        <div class="item">
                            <div class="card image-wrapper shimmer">
                                <img class="lazyload" data-src="img/side1.png" alt="Card Image">
                            </div>
                        </div>
                        <div class="item">
                            <div class="card image-wrapper shimmer">
                                <img class="lazyload" data-src="img/side1.png" alt="Card Image">
                            </div>
                        </div>
                        <div class="item">
                            <div class="card image-wrapper shimmer">
                                <img class="lazyload" data-src="img/side1.png" alt="Card Image">
                            </div>
                        </div>
                    @endif
                </div>
                <div id="carouselExample2" class="owl-theme owl-carousel">
                    @if (!$solutions->isEmpty())
                        @foreach ($solutions->reverse() as $solution)
                            <div class="item">
                                <a href="{{ route('solutions.web', ['id' => $solution->id]) }}">
                                    <div class="card image-wrapper shimmer">
                                        <img class="lazyload" data-src="/storage/{{ $solution->image }}"
                                            alt="Card Image">
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="item">
                            <div class="card image-wrapper shimmer">
                                <img class="lazyload" data-src="img/side1.png" alt="Card Image">
                            </div>
                        </div>
                        <div class="item">
                            <div class="card image-wrapper shimmer">
                                <img class="lazyload" data-src="img/side1.png" alt="Card Image">
                            </div>
                        </div>
                        <div class="item">
                            <div class="card image-wrapper shimmer">
                                <img class="lazyload" data-src="img/side1.png" alt="Card Image">
                            </div>
                        </div>
                        <div class="item">
                            <div class="card image-wrapper shimmer">
                                <img class="lazyload" data-src="img/side1.png" alt="Card Image">
                            </div>
                        </div>
                    @endif
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
                        <img data-src="{{ isset($firstbox['image']) ? '/storage/' . $firstbox['image'] : '/images/placeholderimage.webp' }}"
                            class="lazyload" alt="...">
                        <div class="card-bodybottom py-0" style="background-color: #E2E8F0;">
                            <h5 class="card-titlebottom">{{ $firstbox['title'] ?? 'Trade Shows' }}</h5>
                        </div>
                    </a>
                </div>
                <div class="cardbottom">
                    <a href="{{ $secondbox['url'] ?? '#' }}" style="text-decoration: none;"
                        class="image-wrapper shimmer">
                        <img data-src="{{ isset($secondbox['image']) ? '/storage/' . $secondbox['image'] : '/images/placeholderimage.webp' }}"
                            class="lazyload" alt="...">
                        <div class="card-bodybottom py-0" style="background-color: #E2E8F0;">
                            <h5 class="card-titlebottom">{{ $secondbox['title'] ?? 'Trade Shows' }}</h5>
                        </div>
                    </a>
                </div>
                <div class="cardbottom">
                    <a href="{{ $thirdbox['url'] ?? '#' }}" style="text-decoration: none;"
                        class="image-wrapper shimmer">
                        <img data-src="{{ isset($thirdbox['image']) ? '/storage/' . $thirdbox['image'] : '/images/placeholderimage.webp' }}"
                            class="lazyload" alt="...">
                        <div class="card-bodybottom py-0" style="background-color: #E2E8F0;">
                            <h5 class="card-titlebottom">{{ $thirdbox['title'] ?? 'Trade Shows' }}</h5>
                        </div>
                    </a>
                </div>
                <div class="cardbottom">
                    <a href="{{ $fourthbox['url'] ?? '#' }}" style="text-decoration: none;"
                        class="image-wrapper shimmer">
                        <img data-src="{{ isset($fourthbox['image']) ? '/storage/' . $fourthbox['image'] : '/images/placeholderimage.webp' }}"
                            class="lazyload" alt="...">
                        <div class="card-bodybottom py-0" style="background-color: #E2E8F0;">
                            <h5 class="card-titlebottom">{{ $fourthbox['title'] ?? 'Trade Shows' }}</h5>
                        </div>
                    </a>
                </div>
                <div class="cardbottom">
                    <a href="{{ $fifthbox['url'] ?? '#' }}" style="text-decoration: none;"
                        class="image-wrapper shimmer">
                        <img data-src="{{ isset($fifthbox['image']) ? '/storage/' . $fifthbox['image'] : '/images/placeholderimage.webp' }}"
                            class="lazyload" alt="...">
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
<script>
    $(document).ready(function() {
        $('#carouselExample').owlCarousel({
            items: 1,
            loop: true,
            nav: false,
            dots: true,
            margin: 30,
            autoplay: true,
            autoplayTimeout: 15000,
            lazyLoad: false,
            smartSpeed: 800,
            autoHeight: false,
        });

        $('#carouselExample1').owlCarousel({
            items: 1,
            loop: true,
            nav: false,
            dots: true,
            margin: 30,
            autoplay: true,
            autoplayTimeout: 30000,
            lazyLoad: false,
            smartSpeed: 800,
            autoHeight: false,
        });

        $('#carouselExample2').owlCarousel({
            items: 1,
            loop: true,
            nav: false,
            dots: true,
            margin: 30,
            autoplay: true,
            autoplayTimeout: 60000,
            lazyLoad: false,
            smartSpeed: 800,
            autoHeight: false,
        });
    });
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
<script>
    window.addEventListener('load', () => {
        setTimeout(() => {
            initCategoryLayout();
        }, 100);
    });

    function initCategoryLayout() {
        const wrapper = document.getElementById('categoryList');
        const referenceBox = document.querySelector('.insideinsidebox');
        const scrollBoxHeight = document.querySelector('.scroll-wrapper');
        const categoryItems = document.querySelectorAll('.category-item');

        if (!wrapper || !referenceBox || !scrollBoxHeight || categoryItems.length === 0) return;

        const ITEM_HEIGHT = 32.96;

        function updateLayoutAndVisibility() {
            if (wrapper.classList.contains('expanded')) return;

            // Measure heights
            const insideBoxHeight = referenceBox.offsetHeight;
            const scrollBoxWrapperHeight = scrollBoxHeight.offsetHeight;

            console.log("InsideBox height:", insideBoxHeight);
            console.log("Scroll Wrapper height:", scrollBoxWrapperHeight);

            const availableHeight = insideBoxHeight + scrollBoxWrapperHeight - 30;

            // Calculate how many items fit
            const maxVisible = Math.floor(availableHeight / ITEM_HEIGHT);

            // Apply max-height to wrapper
            wrapper.style.maxHeight = `${availableHeight}px`;

            // Show/hide items
            categoryItems.forEach((item, index) => {
                if (index < maxVisible) {
                    item.classList.remove('d-none');
                } else {
                    item.classList.add('d-none');
                }
            });
        }

        // Initial render
        updateLayoutAndVisibility();

        // On window resize
        window.addEventListener('resize', debounce(updateLayoutAndVisibility, 100));

        // Re-run every 5 seconds
        setInterval(() => {
            updateLayoutAndVisibility();
        }, 5000);
    }

    function debounce(func, delay) {
        let timeout;
        return () => {
            clearTimeout(timeout);
            timeout = setTimeout(func, delay);
        };
    }

    function scrollRight() {
        const container = document.querySelector('.scroll-container');
        if (!container) return;

        const scrollAmount = container.offsetWidth * 0.8;
        container.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
    }
</script>
