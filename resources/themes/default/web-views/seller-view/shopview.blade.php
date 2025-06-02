@extends('layouts.front-end.app')
<link rel="stylesheet" href="{{ theme_asset('public/assets/custom-css/vendor.css') }}" />
@section('title', translate('shop_Page'))

@push('css_or_js')
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/ai/vendor-web.css') }}" />
    @if ($shopInfoArray['id'] != 0)
        <meta property="og:image" content="{{ $shopInfoArray['image_full_url']['path'] }}" />
        <meta property="og:title" content="{{ $shopInfoArray['name'] }} " />
        <meta property="og:url" content="{{ route('shopView', [$shopInfoArray['id']]) }}">
    @else
        <meta property="og:image" content="{{ $web_config['fav_icon']['path'] }}" />
        <meta property="og:title" content="{{ $shopInfoArray['name'] }} " />
        <meta property="og:url" content="{{ route('shopView', [$shopInfoArray['id']]) }}">
    @endif

    @if ($shopInfoArray['id'] != 0)
        <meta property="twitter:card" content="{{ $shopInfoArray['image_full_url']['path'] }}" />
        <meta property="twitter:title" content="{{ route('shopView', [$shopInfoArray['id']]) }}" />
        <meta property="twitter:url" content="{{ route('shopView', [$shopInfoArray['id']]) }}">
    @else
        <meta property="twitter:card" content="{{ $web_config['fav_icon']['path'] }}" />
        <meta property="twitter:title" content="{{ route('shopView', [$shopInfoArray['id']]) }}" />
        <meta property="twitter:url" content="{{ route('shopView', [$shopInfoArray['id']]) }}">
    @endif

    <meta property="og:description"
        content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)), 0, 160) }}">
    <meta property="twitter:description"
        content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)), 0, 160) }}">
@endpush

@section('content')

    @php($decimalPointSettings = getWebConfig(name: 'decimal_point_settings'))

    <div class="main-container vender-company">
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                @if ($shopInfoArray['id'] != 0)
                    <img src="{{ getStorageImages(path: $shopInfoArray['image_full_url'], type: 'shop') }}" class="logo"
                        alt="Logo" />
                @else
                    @php($banner = getWebConfig(name: 'shop_banner'))
                    <img src="{{ getStorageImages(path: $shopInfoArray['image_full_url'], type: 'shop') }}" class="logo"
                        alt="Logo" />
                @endif
                <div class="company-info">
                    <span class="company-title">
                        @if ($shopInfoArray['id'] != 0)
                            {{ $shopInfoArray['name'] }}
                        @else
                            {{ $web_config['name']->value }}
                        @endif
                    </span>
                    <p class="member"><img src="/img/Diamond.png" class="diamond">
                        @if ($shopInfoArray['id'] == 0)
                            Staff
                        @else
                            {{ $shopInfoArray['seller_details']->membership }}
                        @endif Member <span class="member2024" style="margin-top: 1px;"> Since
                            {{ $shopInfoArray['seller_details']->created_at->diffForHumans() }}</span>
                    </p>
                </div>
            </div>
            <div class="header-right">
                <input class="search-input" placeholder="Search for products..." />
                <button class="search-btn">Search</button>
                <!-- <button class="search-icon"><i class="fas fa-search"></i></button> -->

            </div>
            <div class="search-box">
                <button class="btn-search" onclick="toggleSearch()"><i class="fas fa-search"></i></button>
                <input type="text" class="input-search" placeholder="Type to Search...">
            </div>
            <div class="search-overlay" onclick="toggleSearch()"></div>

        </header>
        <script>
            function toggleSearch() {
                const searchBox = document.querySelector('.search-box');
                searchBox.classList.toggle('active');
            }
        </script>
        <!-- Navigation -->
        <div style="overflow: scroll;">
            <nav class="navbar">
                <a href="#" class="nav-item nav-active">Home</a>
                <div class="nav-item dropdown">
                    Products
                    <span class="chevron">&#9660;</span>
                </div>
                <a href="#" class="nav-item">Company Profile</a>
                <a href="#" class="nav-item">Contact Us</a>
            </nav>
        </div>

        <!-- Banner -->
        <div class="banner">
            @if ($shopInfoArray['id'] != 0)
                <img src="{{ getStorageImages(path: $shopInfoArray['banner_full_url'], type: 'wide-banner') }}"
                    alt="Banner" />
            @else
                @php($banner = getWebConfig(name: 'shop_banner'))
                <img src="{{ getStorageImages(path: $banner, type: 'wide-banner') }}" alt="Banner" />
            @endif
        </div>
        <!-- About & Certificates section -->
        <section class="section top-section">
            <div class="contant-section">
                <div class="top-section-left">
                    <div class="company-history">
                        <h2>{{ $shopInfoArray['company_profiles']->title }}</h2>
                        <div class="subline">{{ $shopInfoArray['company_profiles']->subtitle }}
                        </div>
                        <div class="response-time">
                            <span>Avg Response time:</span> <strong>48–72 h</strong>
                        </div>
                    </div>
                    <div class="about">
                        <h3>{{ $shopInfoArray['company_profiles']->description_head }}</h3>
                        <p>
                            {{ $shopInfoArray['company_profiles']->description_text }}
                        </p>
                    </div>



                </div>
                <div class="top-section-right">

                    <button class="inquire-btn" data-bs-toggle="modal" data-bs-target="#inquireModel">
                        <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/9881a67e7313be73b75bd5f735007e08ab4512c3?placeholderIfAbsent=true"
                            alt="Email icon" width="18" />
                        Inquire Now
                    </button>
                    <div class="certificates">
                        @foreach ($shopInfoArray['company_certificates'] as $item)
                            <img src="/storage/{{ $item }}"
                                alt="Cert" />
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="gallery">
                                        @foreach ($shopInfoArray['company_certificates'] as $item)

                                        @endforeach
                <div><img src="<?php echo asset('assets\front-end\img\image 220.png'); ?>" class="side-image" /></div>
                <div class="small-images images-for-mobile-1">

                    <img src="<?php echo asset('assets\front-end\img\image 219.png'); ?>" class="small-image" />
                    <img src="<?php echo asset('assets\front-end\img\image 216.png'); ?>" class="small-image" />

                </div>
                <div class="small-images images-for-mobile-2">
                    <img src="<?php echo asset('assets\front-end\img\image 218.png'); ?>" class="small-image" />
                    <img src="<?php echo asset('assets\front-end\img\image 219.png'); ?>"class="small-image" />
                </div>
            </div>
        </section>

        <!-- New Products Section -->
        <div class="related-products">
            <h4 class="letest-pro-h">Letest Product</h4>
            <div class="new-products-container">
                <div class="new-products-banner">
                    <img src="<?php echo asset('assets\front-end\img\image 72.png'); ?>" alt="New products background" class="banner-bg">
                    <div class="banner-content">
                        <div class="banner-title">Ready to order</div>
                        <div class="view-more-container">
                            <div class="view-more">View More</div>
                        </div>
                    </div>
                </div>

                <div class="product-grid">
                    <div class="product-card">
                        <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/cb7b1be753ae81f132745df01ab5fb7ec2cdf023"
                            alt="Wax Beads" class="product-img">
                        <div class="product-title">Wholesale Hard Wax Beads 400g Painess Bikini leg Hair Removal Bulk
                            Depilatory Wax Beans</div>
                        <div class="product-price">US$ 2.30 / Piece</div>
                        <div class="product-moq">400 Piece (MOQ)</div>
                        <button class="start-order-btn">Start order</button>
                    </div>
                    <div class="product-card">
                        <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/cb7b1be753ae81f132745df01ab5fb7ec2cdf023"
                            alt="Wax Beads" class="product-img">
                        <div class="product-title">Wholesale Hard Wax Beads 400g Painess Bikini leg Hair Removal Bulk
                            Depilatory Wax Beans</div>
                        <div class="product-price">US$ 2.30 / Piece</div>
                        <div class="product-moq">400 Piece (MOQ)</div>
                        <button class="start-order-btn">Start order</button>
                    </div>
                    <div class="product-card">
                        <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/cb7b1be753ae81f132745df01ab5fb7ec2cdf023"
                            alt="Wax Beads" class="product-img">
                        <div class="product-title">Wholesale Hard Wax Beads 400g Painess Bikini leg Hair Removal Bulk
                            Depilatory Wax Beans</div>
                        <div class="product-price">US$ 2.30 / Piece</div>
                        <div class="product-moq">400 Piece (MOQ)</div>
                        <button class="start-order-btn">Start order</button>
                    </div>
                    <div class="product-card">
                        <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/cb7b1be753ae81f132745df01ab5fb7ec2cdf023"
                            alt="Wax Beads" class="product-img">
                        <div class="product-title">Wholesale Hard Wax Beads 400g Painess Bikini leg Hair Removal Bulk
                            Depilatory Wax Beans</div>
                        <div class="product-price">US$ 2.30 / Piece</div>
                        <div class="product-moq">400 Piece (MOQ)</div>
                        <button class="start-order-btn">Start order</button>
                    </div>

                </div>
            </div>
        </div>
        <div class="main-content ">
            <h4 class="top-product-h">Top Products</h4>
            <div class="top-product-grid" id="productGrid">
                <div class="top-product-card">
                    <div class="heart-icon-div">

                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                            stroke="#4d4c4c" stroke-width="2" viewBox="0 0 24 24">
                            <path
                                d="M12 21C12 21 4 13.9 4 8.5C4 5.4 6.4 3 9.5 3C11.1 3 12.6 3.9 13.3 5.2C14 3.9 15.5 3 17.1 3C20.2 3 22.6 5.4 22.6 8.5C22.6 13.9 15 21 15 21H12Z" />
                        </svg>
                    </div>
                    <img src="<?php echo asset('assets\front-end\img\image 99.png'); ?>" alt="${product.title}" class="product-image">
                    <div class="product-info">
                        <div class="d-flex justify-content-between">
                            <p class="new">New</p>

                            <div class="rating">
                                <span style="font-size: 12px;"><i class="bi bi-star-fill start-rating text-warning"></i>
                                    </i> 4.5/9</span>
                            </div>

                            </span>
                        </div>
                        <h3 class="top-product-title">Wholesale Auto tracking CCT V cameras Full Hd Video Life 3mp Baby
                            Monitor Recorder Smart Home Security Camera</h3>
                        <div class="top-product-price">US$ 2.30 / Piece</div>
                        <div class="top-product-moq">400 Piece (MOQ)</div>
                        <div class="top-product-seller">Market Union Co.Ltd</div>
                        <div class="top-product-exhibition">Exhibited at 2 GS shows</div>
                        <div class="top-product-diamond">
                            <img scr="<?php echo asset('assets\front-end\img\Diamond.png'); ?>" alt="dimaond" class="dimond-img">
                        </div>
                        <div>

                            <button class="top-start-order-btn">Start order</button>
                        </div>

                    </div>
                </div>

                <div class="top-product-card">
                    <div class="heart-icon-div">

                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                            stroke="#4d4c4c" stroke-width="2" viewBox="0 0 24 24">
                            <path
                                d="M12 21C12 21 4 13.9 4 8.5C4 5.4 6.4 3 9.5 3C11.1 3 12.6 3.9 13.3 5.2C14 3.9 15.5 3 17.1 3C20.2 3 22.6 5.4 22.6 8.5C22.6 13.9 15 21 15 21H12Z" />
                        </svg>
                    </div>
                    <img src="<?php echo asset('assets\front-end\img\image 99.png'); ?>" alt="${product.title}" class="product-image">
                    <div class="product-info">
                        <div class="d-flex justify-content-between">
                            <p class="new">New</p>

                            <div class="rating">
                                <span style="font-size: 12px;"><i class="bi bi-star-fill start-rating text-warning"></i>
                                    </i> 4.5/9</span>
                            </div>

                            </span>
                        </div>
                        <h3 class="top-product-title">Wholesale Auto tracking CCT V cameras Full Hd Video Life 3mp Baby
                            Monitor Recorder Smart Home Security Camera</h3>
                        <div class="top-product-price">US$ 2.30 / Piece</div>
                        <div class="top-product-moq">400 Piece (MOQ)</div>
                        <div class="top-product-seller">Market Union Co.Ltd</div>
                        <div class="top-product-exhibition">Exhibited at 2 GS shows</div>
                        <div class="top-product-diamond">
                            <img scr="<?php echo asset('assets\front-end\img\Diamond.png'); ?>" alt="dimaond" class="dimond-img">
                        </div>
                        <div>

                            <button class="top-start-order-btn">Start order</button>
                        </div>

                    </div>
                </div>
                <div class="top-product-card">
                    <div class="heart-icon-div">

                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                            stroke="#4d4c4c" stroke-width="2" viewBox="0 0 24 24">
                            <path
                                d="M12 21C12 21 4 13.9 4 8.5C4 5.4 6.4 3 9.5 3C11.1 3 12.6 3.9 13.3 5.2C14 3.9 15.5 3 17.1 3C20.2 3 22.6 5.4 22.6 8.5C22.6 13.9 15 21 15 21H12Z" />
                        </svg>
                    </div>
                    <img src="<?php echo asset('assets\front-end\img\image 99.png'); ?>" alt="${product.title}" class="product-image">
                    <div class="product-info">
                        <div class="d-flex justify-content-between">
                            <p class="new">New</p>

                            <div class="rating">
                                <span style="font-size: 12px;"><i class="bi bi-star-fill start-rating text-warning"></i>
                                    </i> 4.5/9</span>
                            </div>

                            </span>
                        </div>
                        <h3 class="top-product-title">Wholesale Auto tracking CCT V cameras Full Hd Video Life 3mp Baby
                            Monitor Recorder Smart Home Security Camera</h3>
                        <div class="top-product-price">US$ 2.30 / Piece</div>
                        <div class="top-product-moq">400 Piece (MOQ)</div>
                        <div class="top-product-seller">Market Union Co.Ltd</div>
                        <div class="top-product-exhibition">Exhibited at 2 GS shows</div>
                        <div class="top-product-diamond">
                            <img scr="<?php echo asset('assets\front-end\img\Diamond.png'); ?>" alt="dimaond" class="dimond-img">
                        </div>
                        <div>

                            <button class="top-start-order-btn">Start order</button>
                        </div>

                    </div>
                </div>
                <div class="top-product-card">
                    <div class="heart-icon-div">

                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                            stroke="#4d4c4c" stroke-width="2" viewBox="0 0 24 24">
                            <path
                                d="M12 21C12 21 4 13.9 4 8.5C4 5.4 6.4 3 9.5 3C11.1 3 12.6 3.9 13.3 5.2C14 3.9 15.5 3 17.1 3C20.2 3 22.6 5.4 22.6 8.5C22.6 13.9 15 21 15 21H12Z" />
                        </svg>
                    </div>
                    <img src="<?php echo asset('assets\front-end\img\image 99.png'); ?>" alt="${product.title}" class="product-image">
                    <div class="product-info">
                        <div class="d-flex justify-content-between">
                            <p class="new">New</p>

                            <div class="rating">
                                <span style="font-size: 12px;"><i class="bi bi-star-fill start-rating text-warning"></i>
                                    </i> 4.5/9</span>
                            </div>

                            </span>
                        </div>
                        <h3 class="top-product-title">Wholesale Auto tracking CCT V cameras Full Hd Video Life 3mp Baby
                            Monitor Recorder Smart Home Security Camera</h3>
                        <div class="top-product-price">US$ 2.30 / Piece</div>
                        <div class="top-product-moq">400 Piece (MOQ)</div>
                        <div class="top-product-seller">Market Union Co.Ltd</div>
                        <div class="top-product-exhibition">Exhibited at 2 GS shows</div>
                        <div class="top-product-diamond">
                            <img scr="<?php echo asset('assets\front-end\img\Diamond.png'); ?>" alt="dimaond" class="dimond-img">
                        </div>
                        <div>

                            <button class="top-start-order-btn">Start order</button>
                        </div>

                    </div>
                </div>
                <div class="top-product-card">
                    <div class="heart-icon-div">

                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                            stroke="#4d4c4c" stroke-width="2" viewBox="0 0 24 24">
                            <path
                                d="M12 21C12 21 4 13.9 4 8.5C4 5.4 6.4 3 9.5 3C11.1 3 12.6 3.9 13.3 5.2C14 3.9 15.5 3 17.1 3C20.2 3 22.6 5.4 22.6 8.5C22.6 13.9 15 21 15 21H12Z" />
                        </svg>
                    </div>
                    <img src="<?php echo asset('assets\front-end\img\image 99.png'); ?>" alt="${product.title}" class="product-image">
                    <div class="product-info">
                        <div class="d-flex justify-content-between">
                            <p class="new">New</p>

                            <div class="rating">
                                <span style="font-size: 12px;"><i class="bi bi-star-fill start-rating text-warning"></i>
                                    </i> 4.5/9</span>
                            </div>

                            </span>
                        </div>
                        <h3 class="top-product-title">Wholesale Auto tracking CCT V cameras Full Hd Video Life 3mp Baby
                            Monitor Recorder Smart Home Security Camera</h3>
                        <div class="top-product-price">US$ 2.30 / Piece</div>
                        <div class="top-product-moq">400 Piece (MOQ)</div>
                        <div class="top-product-seller">Market Union Co.Ltd</div>
                        <div class="top-product-exhibition">Exhibited at 2 GS shows</div>
                        <div class="top-product-diamond">
                            <img scr="<?php echo asset('assets\front-end\img\Diamond.png'); ?>" alt="dimaond" class="dimond-img">
                        </div>
                        <div>

                            <button class="top-start-order-btn">Start order</button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade vender-company" id="inquireModel" tabindex="-1" aria-labelledby="inquireModelLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: #EBEBEB;">
                    <h5 class="modal-title" id="inquireModelLabel">Send a direct inquiry to this supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form style="padding: 10px;">
                        <div class="mb-3">
                            <label for="company" class="form-label">To</label>
                            <input type="text" class="form-control" id="company" value="Wenzhou Ivspeed Co.,Ltd"
                                readonly>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail Address</label>
                            <input type="email" class="form-control" id="email"
                                placeholder="Please enter your business e-mail address">
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" rows="5"
                                placeholder="Enter product details such as color, size, materials and other specific requirements."></textarea>
                        </div>

                        <div style="display: flex; justify-content: end;">
                            <button type="submit" class="btn btn-red inquire-btn" st>Send Inquiry Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <span id="products-search-data-backup"
        data-url="{{ route('shopView', ['id' => $shopInfoArray['id'] != 0 ? $shopInfoArray['id'] : 0]) }}"
        data-brand="{{ $data['brand_id'] ?? '' }}" data-category="{{ $data['category_id'] ?? '' }}"
        data-name="{{ request('search') ?? request('name') }}" data-from="{{ request('data_from') }}"
        data-sort="{{ request('sort_by') }}" data-product-type="{{ request('product_type') ?? 'all' }}"
        data-message="{{ translate('items_found') }}" data-publishing-house-id="{{ request('publishing_house_id') }}"
        data-author-id="{{ request('author_id') }}"></span>
@endsection

@push('script')
    <script src="{{ theme_asset(path: 'public/assets/front-end/js/product-view.js') }}"></script>
@endpush
