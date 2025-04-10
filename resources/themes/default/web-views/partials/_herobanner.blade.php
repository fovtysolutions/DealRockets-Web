@if (empty($carouselimages))
    <section class="mainpagesection fade-in"
        style="/* background-color: unset; */ margin-top: 22px; box-shadow: 0px 0px 1px 0px;">
    @else
        <section class="mainpagesection fade-in"
            style="/* background-color: unset; */ margin-top: 320px; box-shadow: 0px 0px 1px 0px;">
@endif
<div class="globle-deals">
    <div class="box flex p-0" style="max-width: 221px; height:auto;">
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
                        <a href="{{ route('marketplace-categories', ['id' => $category['id']]) }}">{{ $category->name }}</a>
                        @if ($category->childes->count() > 0)
                            <div class="mega_menu_new">
                                @foreach ($category->childes as $sub_category)
                                    <div class="mega_menu_inner_new">
                                        <h6>
                                            <a href="{{ route('products', ['category_id' => $sub_category['id'], 'data_from' => 'category', 'page' => 1]) }}">{{ $sub_category->name }}</a>
                                        </h6>
                                        @if ($sub_category->childes->count() > 0)
                                            @foreach ($sub_category->childes as $sub_sub_category)
                                                <div>
                                                    <a href="{{ route('products', ['category_id' => $sub_sub_category['id'], 'data_from' => 'category', 'page' => 1]) }}">{{ $sub_sub_category->name }}</a>
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
                <a href="{{ route('categories') }}" style="text-decoration: none;">View All <img style="height:16px; width: 16px;" src="/img/Right arrow.png" alt="arrow-right"></a>
            </div>            
        </div>
    </div>

    <div class="insidebox" id="insideBox">
        <div class="d-flex flex-row insideinsidebox">
            <!-- Carousel Section -->
            <div class="mainbannerbox">
                <div id="carouselExample" class="carousel slide h-100">
                    <div class="carousel-inner h-100">
                        <div class="carousel-item active h-100">
                            <img src="img/main.png" class="d-block w-100 h-100" alt="Slide 1">
                        </div>
                        <div class="carousel-item">
                            <img src="img/main.png" class="d-block w-100" alt="Slide 2">
                        </div>
                        <div class="carousel-item">
                            <img src="img/main.png" class="d-block w-100" alt="Slide 3">
                        </div>
                    </div>
                    <!-- <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button> -->
                    <!-- <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button> -->
                </div>
            </div>

            <!-- Sidebar Section -->
            <div class="flex-column gap-3 mt-md-0 mt-sm-2 sidebannerbox" style="gap:13px">
                <div class="card">
                    <img class="" src="img/side1.png" alt="Card Image">
                </div>
                <div class="card">
                    <img class="" src="img/side1.png" alt="Card Image">
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
                    <a href="{{ $firstbox['url'] ?? '#' }}" style="text-decoration: none;">
                    <img src="/storage/{{ $firstbox['image'] ?? 'default-image.jpg' }}" class="" alt="...">
                    <div class="card-bodybottom py-0" style="background-color: #E2E8F0;">
                        <h5 class="card-titlebottom">{{ $firstbox['title'] ?? 'Trade Shows' }}</h5>
                    </div>
                </a>
                </div>
                <div class="cardbottom">
                    <a href="{{ $secondbox['url'] ?? '#' }}" style="text-decoration: none;">
                    <img src="/storage/{{ $secondbox['image'] ?? 'default-image.jpg' }}" class="" alt="...">
                    <div class="card-bodybottom py-0" style="background-color: #E2E8F0;">
                        <h5 class="card-titlebottom">{{ $secondbox['title'] ?? 'Trade Shows' }}</h5>
                    </div>
                </a>
                </div>
                <div class="cardbottom">
                    <a href="{{ $thirdbox['url'] ?? '#' }}" style="text-decoration: none;">
                    <img src="/storage/{{ $thirdbox['image'] ?? 'default-image.jpg' }}" class="" alt="...">
                    <div class="card-bodybottom py-0" style="background-color: #E2E8F0;">
                        <h5 class="card-titlebottom">{{ $thirdbox['title'] ?? 'Trade Shows' }}</h5>
                    </div>
                </a>
                </div>
                <div class="cardbottom">
                    <a href="{{ $fourthbox['url'] ?? '#' }}" style="text-decoration: none;">
                        <img src="/storage/{{ $fourthbox['image'] ?? 'default-image.jpg' }}" class="" alt="...">
                        <div class="card-bodybottom py-0" style="background-color: #E2E8F0;">
                            <h5 class="card-titlebottom">{{ $fourthbox['title'] ?? 'Trade Shows' }}</h5>
                        </div>
                    </a>
                </div>
                <div class="cardbottom">
                    <a href="{{ $fifthbox['url'] ?? '#' }}" style="text-decoration: none;">
                        <img src="/storage/{{ $fifthbox['image'] ?? 'default-image.jpg' }}" class="" alt="...">
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.querySelector('.menu-toggle');
        const sidebar = document.getElementById('sidebarMenu');

        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('d-block');
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (window.innerWidth > 768) {
            const wrapper = document.getElementById('categoryList');
            const referenceBox = document.querySelector('.insideinsidebox');
            const scrollBoxHeight = document.querySelector('.scroll-wrapper');
        
            if (!wrapper || !referenceBox || !scrollBoxHeight) return;
        
            const setMaxHeight = () => {
                wrapper.style.maxHeight = 'none'; // reset to measure full
                const fullHeight = wrapper.scrollHeight;
                const refHeight = referenceBox.offsetHeight + scrollBoxHeight.offsetHeight - 60;
                console.log("fullHeight:", fullHeight, "| refHeight:", refHeight);
                if (fullHeight > refHeight) {
                    wrapper.style.maxHeight = `${refHeight}px`;
                } else {
                    wrapper.style.maxHeight = `${fullHeight}px`;
                }
            };
        
            // Wait a little for layout/rendering to settle
            setTimeout(setMaxHeight, 100);
        
            window.addEventListener('resize', () => {
                if (!wrapper.classList.contains('expanded')) {
                    setMaxHeight();
                }
            });
        } else {
            return;
        }
    });
</script>
    
