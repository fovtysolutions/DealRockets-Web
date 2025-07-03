@php
    $trending = App\Utils\ChatManager::GetTrendingProducts();
    $searches = App\Utils\HelperUtil::getsearchedproducts($trending);
@endphp
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/ai/ordernow.css') }}" />
<section class="mainpagesection order-now">
    <div class="order-now-box">
        <!-- Left Banner with Background Image -->
        <div class="title-show-768">
            <h5 class="m-0 text-capitalize" style="color: black;font-size: 20px;/* bottom: 1px; */top: 6px;left: 44%;">
                {{ translate('Ready_to_Order')}}
            </h5>
        </div>
        <div class="left-banner rounded">
            <div class="hide-768">
                <h5 class="fw-bold order-now-heading leadstitle2">READY TO ORDER</h5>
                {{-- <a href="{{ route('products') }}" class="btn btn-danger btn-sm">View More</a> --}}
            </div>    
        </div>
        <!-- Product Cards Grid -->
        <div class="product-grid showabove768">
            @foreach($trending->take(5) as $product)
            <!-- Product 1 -->
            <div class="product-card image-wrapper shimmer">
                <img data-src="{{ $product->thumbnail !== 'imageurl' ? '/storage/' . $product->thumbnail : '/images/placeholderimage.webp' }}" class="card-img-top lazyload" alt="Product 1"
                onerror="this.onerror=null; this.src='/images/placeholderimage.webp';">
                <div class="text-left">
                    <p class="small text-muted m-1">{{ $product->name }}</p>
                    <p class="fw-bold m-1">US$ {{ number_format($product->unit_price, 2) }} / {{ $product->unit }}</p>
                    <p class="small text-muted m-2">{{ $product->min_qty }} {{ $product->unit }} (MOQ)</p>
                    <a href="{{ route('product',['slug'=>$product->slug]) }}" class="btn btn-outline-dark btn-sm w-100">Start order</a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="product-grid showbelow768">
            @foreach($trending->take(2) as $product)
            <!-- Product 1 -->
            <div class="card product-card image-wrapper shimmer">
                <img data-src="{{ $product->thumbnail !== 'imageurl' ? '/storage/' . $product->thumbnail : '/images/placeholderimage.webp' }}" class="card-img-top lazyload" alt="Product 1" 
                    onerror="this.onerror=null; this.src='/images/placeholderimage.webp';">
                <div class="card-body text-left">
                    <p class="small text-muted mb-1">{{ $product->name }}</p>
                    <p class="fw-bold mb-1">US$ {{ number_format($product->unit_price, 2) }} / {{ $product->unit }}</p>
                    <p class="small text-muted mb-2">{{ $product->min_qty }} {{ $product->unit }} (MOQ)</p>
                    <a href="{{ route('product',['slug'=>$product->slug]) }}" class="btn btn-outline-dark btn-sm w-100">Start order</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>