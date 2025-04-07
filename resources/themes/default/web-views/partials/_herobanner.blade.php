@if (empty($carouselimages))
    <section class="mainpagesection fade-in" style="/* background-color: unset; */ margin-top: 22px;">
    @else
        <section class="mainpagesection fade-in" style="/* background-color: unset; */ margin-top: 320px;">
@endif
<div class="herobannermain overflow-hidden">
    <div class="herobannerleft" id="highlightbanner">
        <ul class="navbar-nav" style="height: 100%;">
            <li class="nav-item mb-0 {{ !request()->is('/') ? 'dropdown' : '' }}">
                <a class="spanatag" style="z-index: 0; margin-bottom: 0; margin-top: 0;">
                    <h6 class="spantitlenew font-weight-bold custom-dealrock-subhead">
                        <i class="fa fa-bars"></i>
                        {{ translate('Top categories') }}
                    </h6>
                </a>
            </li>
            <div class="megamenu" style="height: 88%;">
                <div class="megamenucontainer" style="height:100%;">
                    <div class="category-menu-wrapper" style="height:100%;">
                        <ul class="category-menu-items">
                            @foreach ($categories as $key => $category)
                                <li>
                                    <a class="custom-dealrock-text"
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
                    </div>
                </div>
            </div>
            <li class="border-0 hovertext" style="text-align: center;padding-top: 10px; z-index: 1;background-color: white;">
                <a href="{{ route('categories') }}"
                    class="text-primary justify-content-center text-center custom-dealrock-text" style="font-weight: bold !important;">
                    {{ translate('View_All') }}
                </a>
            </li>
        </ul>
        <ul class="navbar-nav mega-nav1 pr-md-2 pl-md-2 d-block d-xl-none">
            <li class="nav-item dropdown d-md-none">
                <a class="nav-linknew dropdown-toggle ps-0" href="javascript:" data-toggle="dropdown">
                    <i class="czi-menu align-middle mt-n1 me-2"></i>
                    <span class="me-4">
                        {{ translate('categories') }}
                    </span>
                </a>
                <ul class="dropdown-menu __dropdown-menu-2 text-align-direction">
                    @php($categoryIndex = 0)
                    @foreach ($categories as $category)
                        @php($categoryIndex++)
                        @if ($categoryIndex < 10)
                            <li class="dropdown">
                                <a <?php if ($category->childes->count() > 0) {
                                    echo '';
                                } ?>
                                    href="{{ route('products', ['category_id' => $category['id'], 'data_from' => 'category', 'page' => 1]) }}">
                                    <span>{{ $category['name'] }}</span>
                                </a>
                                @if ($category->childes->count() > 0)
                                    <a data-toggle='dropdown' class='__ml-50px'>
                                        <i
                                            class="czi-arrow-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }} __inline-16"></i>
                                    </a>
                                @endif

                                @if ($category->childes->count() > 0)
                                    <ul class="dropdown-menu text-align-direction">
                                        @foreach ($category['childes'] as $subCategory)
                                            <li class="dropdown">
                                                <a
                                                    href="{{ route('products', ['category_id' => $subCategory['id'], 'data_from' => 'category', 'page' => 1]) }}">
                                                    <span>{{ $subCategory['name'] }}</span>
                                                </a>

                                                @if ($subCategory->childes->count() > 0)
                                                    <a class="header-subcategories-links" data-toggle='dropdown'>
                                                        <i
                                                            class="czi-arrow-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }} __inline-16"></i>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        @foreach ($subCategory['childes'] as $subSubCategory)
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('products', ['category_id' => $subSubCategory['id'], 'data_from' => 'category', 'page' => 1]) }}">{{ $subSubCategory['name'] }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endif
                    @endforeach
                    <li class="__inline-17">
                        <div>
                            <a class="dropdown-item web-text-primary" href="{{ route('categories') }}">
                                {{ translate('view_more') }}
                            </a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="herosecondcontainer">
        <div class="herobannertop">
            <div class="herobannercenter">
                @if ($bannerCount > 0)
                    <div class="owl-carousel banner-carousel" data-banner-count="{{ $bannerCount }}">
                        @foreach ($banners as $banner)
                            <div class="banner-image">
                                <a href="{{ route('products') }}">
                                    <img class="d-block w-100" src="/storage/company/{{ $banner }}"
                                        alt="Banner Image" />
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Default Sample Image -->
                    <div class="banner-image">
                        <a href="{{ route('products') }}">
                            <img class="d-block w-100" src="/storage/company/sample-banner.jpg" alt="Default Banner" />
                        </a>
                    </div>
                @endif
            </div>
            <div class="herobannerright">
                <div class="owl-carousel owl-theme testerte" id="banner-carousel" style="height: 50%; display:flex;">
                    <!-- Loop through the bannercard array -->
                    @foreach($bannercard as $banner)
                        @if($banner['image'])
                            <div class="last-item">
                                <a class="d-flex w-100" href="{{ $banner['url'] ?? '#' }}">
                                    <div class="p-3 w-100 banner-container"
                                        style="background-image: url('storage/{{ $banner['image'] ?? '' }}');">
                                        <h5 class="custom-dealrock-subhead" style="color:{{ $banner['color'] }};">{{ $banner['title'] ?? '' }}</h5>
                                        <p class="custom-dealrock-text" style="color:{{ $banner['color'] }};">{{ $banner['content'] ?? '' }}</p>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="owl-carousel owl-theme testerte" id="banner-carousel1" style="height: 50%; display:flex;">
                    <!-- Loop through the bannercardtwo array -->
                    @foreach($bannercardtwo as $banner)
                        @if($banner['image'])
                            <div class="last-item" style="margin-top: 10px;">
                                <a class="d-flex w-100" href="{{ $banner['url'] ?? '#' }}">
                                    <div class="p-3 w-100 banner-container"
                                        style="background-image: url('storage/{{ $banner['image'] ?? '' }}');">
                                        <h5 class="custom-dealrock-subhead" style="color:{{ $banner['color'] }};">{{ $banner['title'] ?? '' }}</h5>
                                        <p class="custom-dealrock-text" style="color:{{ $banner['color'] }};">{{ $banner['content'] ?? '' }}</p>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>                

                <!-- No Desirable Products Section -->
                <!-- <span>No Desirable Products?</span> -->

                <!-- Post Request Button -->
                <!-- <div class="postrequest">
                        <button class="postrequest-button">
                            <i class="postrequesticon fa fa-bullseye" aria-hidden="true"></i>
                            <a href="{{ route('quotationweb') }}" class="postrequestptag">Post Your Request Now</a>
                        </button>
                    </div> -->
            </div>
        </div>
        <div class="herobannerbottom">
            <!-- Box Container for services -->
            <div class="row h-100 w-100" style="margin-left:0rem !important; flex-wrap: nowrap; gap: 10px;">
                <!-- First Box -->
                <div class="hover-box">
                    <a href="{{ $firstbox['url'] ?? '#' }}" class="hover-box-link">
                        <div class="content">
                            <div class="topcontent">
                                <img src="/storage/{{ $firstbox['image'] ?? 'default-image.jpg' }}" alt="Image" />
                            </div>
                            <div class="bottomcontent">
                                <h5 class="custom-dealrock-text">{{ $firstbox['title'] ?? 'Catalog' }}</h5>
                            </div>
                        </div>
                        {{-- <div class="hover-text">
                                <img src="/storage/{{ $firstbox['image'] ?? 'default-image.jpg' }}" alt="Image" />
                                <p>{{ $firstbox['content'] ?? 'Make your Smart Expo Decisions!' }}</p><br>
                                <div class="hoverarrow"></div>
                            </div> --}}
                    </a>
                </div>

                <!-- Second Box -->
                <div class="hover-box">
                    <a href="{{ $secondbox['url'] ?? '#' }}" class="hover-box-link">
                        <div class="content">
                            <div class="topcontent">
                                <img src="/storage/{{ $secondbox['image'] ?? 'default-image.jpg' }}"
                                    alt="Image" />
                            </div>
                            <div class="bottomcontent">
                                <h5 class="custom-dealrock-text">{{ $secondbox['title'] ?? 'Buy Leads' }}</h5>
                            </div>
                        </div>
                        {{-- <div class="hover-text">
                                <img src="/storage/{{ $secondbox['image'] ?? 'default-image.jpg' }}" alt="Image" />
                                <p>{{ $secondbox['content'] ?? 'Secured Trading Decisions!' }}</p><br>
                                <div class="hoverarrow"></div>
                            </div> --}}
                    </a>
                </div>

                <!-- Third Box -->
                <div class="hover-box">
                    <a href="{{ $thirdbox['url'] ?? '#' }}" class="hover-box-link">
                        <div class="content">
                            <div class="topcontent">
                                <img src="/storage/{{ $thirdbox['image'] ?? 'default-image.jpg' }}" alt="Image" />
                            </div>
                            <div class="bottomcontent">
                                <h5 class="custom-dealrock-text">{{ $thirdbox['title'] ?? 'Sell Leads' }}</h5>
                            </div>
                        </div>
                        {{-- <div class="hover-text">
                                <img src="/storage/{{ $thirdbox['image'] ?? 'default-image.jpg' }}" alt="Image" />
                                <p>{{ $thirdbox['content'] ?? 'Explore our best suppliers!' }}</p><br>
                                <div class="hoverarrow"></div>
                            </div> --}}
                    </a>
                </div>

                <!-- Fourth Box -->
                <div class="hover-box">
                    <a href="{{ $fourthbox['url'] ?? '#' }}" class="hover-box-link">
                        <div class="content">
                            <div class="topcontent">
                                <img src="/storage/{{ $fourthbox['image'] ?? 'default-image.jpg' }}"
                                    alt="Image" />
                            </div>
                            <div class="bottomcontent">
                                <h5 class="custom-dealrock-text">{{ $fourthbox['title'] ?? 'Star Supplier' }}</h5>
                            </div>
                        </div>
                        {{-- <div class="hover-text">
                                <img src="/storage/{{ $fourthbox['image'] ?? 'default-image.jpg' }}" alt="Image" />
                                <p>{{ $fourthbox['content'] ?? 'Explore our best trades!' }}</p><br>
                                <div class="hoverarrow"></div>
                            </div> --}}
                    </a>
                </div>

                <!-- Fifth Box -->
                <div class="hover-box">
                    <a href="{{ $fifthbox['url'] ?? '#' }}" class="hover-box-link">
                        <div class="content">
                            <div class="topcontent">
                                <img src="/storage/{{ $fifthbox['image'] ?? 'default-image.jpg' }}" alt="Image" />
                            </div>
                            <div class="bottomcontent">
                                <h5 class="custom-dealrock-text">{{ $fifthbox['title'] ?? 'Trade Shows' }}</h5>
                            </div>
                        </div>
                        {{-- <div class="hover-text">
                                <img src="/storage/{{ $fifthbox['image'] ?? 'default-image.jpg' }}" alt="Image" />
                                <p>{{ $fifthbox['content'] ?? 'Find Best Leads!' }}</p><br>
                                <div class="hoverarrow"></div>
                            </div> --}}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</section>
<script>
    const button = document.querySelector(".postrequest-button");
    const icon = document.querySelector(".postrequesticon");
    const text = document.querySelector(".postrequestptag");

    button.addEventListener("mouseover", () => {
        button.classList.add("hovered");
        icon.style.color = "white";
        text.style.color = "white";
    });

    button.addEventListener("mouseout", () => {
        button.classList.remove("hovered");
        icon.style.color = "var(--web-hover)";
        text.style.color = "var(--web-hover)";
    });
</script>
<!-- Owl Carousel Initialization -->
<script>
    $(document).ready(function() {
        let bannerCount = $('.banner-carousel').data('banner-count');
        $(".banner-carousel").owlCarousel({
            items: 1,
            loop: bannerCount > 1,
            nav: false,
            dots: bannerCount > 1,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true
        });
    });
</script>
{{-- <script>
document.addEventListener("DOMContentLoaded", function () {
    const categoryContainer = document.getElementById("highlightbanner"); 
    if (!categoryContainer) return; // Prevent errors if missing

    // Create the full-screen shadow overlay
    const fullScreenShadow = document.createElement("div");
    fullScreenShadow.classList.add("fullscreen-shadow");
    document.body.appendChild(fullScreenShadow);

    let hoverTimeout;

    function showShadow() {
        clearTimeout(hoverTimeout);
        fullScreenShadow.style.display = "block";
    }

    function hideShadow() {
        hoverTimeout = setTimeout(() => {
            fullScreenShadow.style.display = "none";
        }, 200); // Small delay prevents flickering when moving between elements
    }

    categoryContainer.addEventListener("mouseenter", showShadow);
    categoryContainer.addEventListener("mouseleave", hideShadow);

    // Ensure shadow remains active if cursor moves over it
    fullScreenShadow.addEventListener("mouseenter", showShadow);
    fullScreenShadow.addEventListener("mouseleave", hideShadow);
});
</script> --}}
<!-- Initialize Owl Carousel Script -->
<script>
    $(document).ready(function() {
        $('#banner-carousel').owlCarousel({
            autoplay: true,
            loop: true, // Loop the carousel
            margin: 10, // Space between items
            responsiveClass: true, // Makes the carousel responsive
            nav: false, // Disables navigation arrows
            dots: {{ count($bannercard) + count($bannercardtwo) > 1 ? 'true' : 'false' }}, // Shows dots only if more than one banner
            items: 1 // Only show one banner at a time
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#banner-carousel1').owlCarousel({
            autoplay: true,
            loop: true, // Loop the carousel
            margin: 10, // Space between items
            responsiveClass: true, // Makes the carousel responsive
            nav: false, // Disables navigation arrows
            dots: {{ count($bannercard) + count($bannercardtwo) > 1 ? 'true' : 'false' }}, // Shows dots only if more than one banner
            items: 1 // Only show one banner at a time
        });
    });
</script>