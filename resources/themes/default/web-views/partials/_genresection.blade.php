<?php
$colorat = App\Utils\ChatManager::getimagecolorat('storage/'.$homepagesetting[0]['background_image'], 15, 15);
$text_color = App\Utils\ChatManager::getTextColorBasedOnBackground($colorat);
$getcategoryid = App\Models\Category::where('name',$homepagesetting[0]['category_title'])->first()->id;
?>
<section>
    <div class="sourcenow-sec">
        <div class="sourcemaindiv d-flex">
            <!-- Left Banner Section -->
            <div class="sourcefirstdiv bg-shimmer" data-bg='{{ 'storage/' . $homepagesetting[0]['background_image'] }}'>
                <div class="cnt-1">
                    <div class="text-overlay">
                        <h4 class="title fourthshow" style="color:white !important; font-size: 20px;">
                            {{$homepagesetting[0]['category_title']}}
                        </h4>
                        <h4 class="othertitle" style="color:black !important; font-size: 20px;">
                            {{$homepagesetting[0]['category_title']}}
                        </h4>
                        <a class="btn source-btn  btn-sm" style="background-color: white !important; color:#FE4E44 !important;"
                            href="{{ route('products', ['category_id' => $getcategoryid, 'data_from' => 'category', 'page' => 1]) }}">
                            {{$homepagesetting[0]['button_text']}}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Product Grid Section -->
            <div class="sourceseconddiv">
                <div class="prd-grid firstshow">
                    <?php
                    // Loop through the products array and display each product
                    for ($i = 0; $i < 8; $i++) {
                    ?>
                        <div class="prd-item">
                            <a style="all: unset; cursor: pointer;" href="{{ route('products', ['searchInput' => $homepagesetting[0]['products'][$i]['name'] ]) }}" class="text-decoration-none">
                                <div class="source-product-item image-wrapper shimmer">
                                    <div class="product-name text-left d-flex flex-column justify-content-center">
                                        <p class="custom-dealrock-text">{{ $homepagesetting[0]['products'][$i]['name'] }}</p>
                                    </div>
                                    {{-- <div class="redtriangle"> --}}
                                    <img data-src="storage/{{ $homepagesetting[0]['products'][$i]['image'] }}" alt="product" class="source-product-img lazyload align-self-end" />
                                </div>
                            </a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="prd-grid secondshow">
                    <?php
                    // Loop through the products array and display each product
                    for ($i = 0; $i < 6; $i++) {
                    ?>
                        <div class="prd-item">
                            <a style="all: unset; cursor: pointer;" href="{{ route('products', ['searchInput' => $homepagesetting[0]['products'][$i]['name'] ]) }}" class="text-decoration-none">
                                <div class="source-product-item image-wrapper shimmer">
                                    <div class="product-name text-left d-flex flex-column justify-content-center">
                                        <p class="custom-dealrock-text">{{ $homepagesetting[0]['products'][$i]['name'] }}</p>
                                    </div>
                                    {{-- <div class="redtriangle"> --}}
                                    <img data-src="storage/{{ $homepagesetting[0]['products'][$i]['image'] }}" alt="product" class="source-product-img lazyload align-self-end" />
                                </div>
                            </a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="prd-grid thirdshow">
                    <?php
                    // Loop through the products array and display each product
                    for ($i = 0; $i < 2; $i++) {
                    ?>
                        <div class="prd-item">
                            <a style="all: unset; cursor: pointer;" href="{{ route('products', ['searchInput' => $homepagesetting[0]['products'][$i]['name'] ]) }}" class="text-decoration-none">
                                <div class="source-product-item image-wrapper shimmer">
                                    <div class="product-name text-left d-flex flex-column justify-content-center">
                                        <p class="custom-dealrock-text">{{ $homepagesetting[0]['products'][$i]['name'] }}</p>
                                    </div>
                                    {{-- <div class="redtriangle"> --}}
                                    <img data-src="storage/{{ $homepagesetting[0]['products'][$i]['image'] }}" alt="product" class="source-product-img lazyload align-self-end" />
                                </div>
                            </a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>