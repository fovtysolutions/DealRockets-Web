<?php
use App\Utils\ChatManager;
use App\Models\Category;

// Set a default background color if the image or color extraction fails
$defaultColor = '#ffffff'; // white
$defaultTextColor = '#000000'; // black

// Try to get the color at a pixel location
$colorat = ChatManager::getimagecolorat('storage/' . ($homepagesetting[2]['background_image'] ?? ''), 15, 15) ?? $defaultColor;

// Determine text color based on background or fall back to default
$text_color = ChatManager::getTextColorBasedOnBackground($colorat) ?? $defaultTextColor;

// Get category ID safely with fallback
$getcategoryid = optional(Category::where('name', $homepagesetting[2]['category_title'] ?? '')->first())->id ?? 0; // default ID 1
?>

<section>
    <div class="sourcenow-sec">
        <div class="sourcemaindiv d-flex">
            <!-- Left Banner Section -->
            <div class="sourcefirstdiv bg-shimmer" data-bg='{{ isset($homepagesetting[2]['background_image']) ? asset('storage/' . $homepagesetting[2]['background_image']) : asset('/images/placeholderimage.webp') }}'>
                <div class="cnt-1">
                    <div class="text-overlay">
                        <h4 class="title fourthshow custom-dealrock-text-18" style="color:white !important; ">
                            {{ $homepagesetting[2]['category_title'] ?? 'Default Category' }}
                        </h4>
                        <h4 class="othertitle custom-dealrock-text-18" style="color:white !important; ">
                            {{ $homepagesetting[2]['category_title'] ?? 'Default Category' }}
                        </h4>
                        <a class="btn source-btn btn-sm custom-dealrock-text-14"  style="background-color: white !important; color:#FE4E44 !important;"
                            href="{{ route('products', ['category_id' => $getcategoryid, 'data_from' => 'category', 'page' => 1]) }}">
                            {{$homepagesetting[2]['button_text'] ?? 'Browse Products'}}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Product Grid Section -->
            <div class="sourceseconddiv">
                @if (!empty($homepagesetting[2]['products']))
                    <div class="prd-grid firstshow">
                        <?php
                        // Loop through the products array and display each product
                        for ($i = 0; $i < 8; $i++) {
                            $product = $homepagesetting[2]['products'][$i] ?? null;
                            if ($product) {
                        ?>
                                <div class="prd-item">
                                    <a style="all: unset; cursor: pointer;" href="{{ route('products', ['searchInput' => $product['name']]) }}" class="text-decoration-none">
                                        <div class="source-product-item image-wrapper shimmer">
                                            <div class="product-name text-left d-flex flex-column justify-content-center">
                                                <p class="custom-dealrock-text">{{ $product['name'] }}</p>
                                            </div>
                                            <img data-src="{{ isset($product['image']) ? asset('storage/' . $product['image']) : asset('/images/placeholderimage.webp') }}" alt="product" class="source-product-img lazyload align-self-end" />
                                        </div>
                                    </a>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>

                    <div class="prd-grid secondshow">
                        <?php
                        // Loop through the products array and display each product
                        for ($i = 0; $i < 6; $i++) {
                            $product = $homepagesetting[2]['products'][$i] ?? null;
                            if ($product) {
                        ?>
                                <div class="prd-item">
                                    <a style="all: unset; cursor: pointer;" href="{{ route('products', ['searchInput' => $product['name']]) }}" class="text-decoration-none">
                                        <div class="source-product-item image-wrapper shimmer">
                                            <div class="product-name text-left d-flex flex-column justify-content-center">
                                                <p class="custom-dealrock-text">{{ $product['name'] }}</p>
                                            </div>
                                            <img data-src="{{ isset($product['image']) ? asset('storage/' . $product['image']) : asset('/images/placeholderimage.webp') }}" alt="product" class="source-product-img lazyload align-self-end" />
                                        </div>
                                    </a>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>

                    <div class="prd-grid thirdshow">
                        <?php
                        // Loop through the products array and display each product
                        for ($i = 0; $i < 2; $i++) {
                            $product = $homepagesetting[2]['products'][$i] ?? null;
                            if ($product) {
                        ?>
                                <div class="prd-item">
                                    <a style="all: unset; cursor: pointer;" href="{{ route('products', ['searchInput' => $product['name']]) }}" class="text-decoration-none">
                                        <div class="source-product-item image-wrapper shimmer">
                                            <div class="product-name text-left d-flex flex-column justify-content-center">
                                                <p class="custom-dealrock-text">{{ $product['name'] }}</p>
                                            </div>
                                            <img data-src="{{ isset($product['image']) ? asset('storage/' . $product['image']) : asset('/images/placeholderimage.webp') }}" alt="product" class="source-product-img lazyload align-self-end" />
                                        </div>
                                    </a>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                @else
                    <div class="no-products">
                        <p>No products available at the moment. Please check back later!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
