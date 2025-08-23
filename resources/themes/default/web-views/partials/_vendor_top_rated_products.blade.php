<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/ai/ordernow.css') }}" />
<section class="mainpagesection order-now" style="margin-bottom: 20px;">
    <div class="order-now-box">
        <!-- Left Banner with Background Image -->
        <div class="title-show-768">
            <h5 class="m-0 text-capitalize" style="color: black;font-size: 20px;/* bottom: 1px; */top: 6px;left: 44%;">
                {{ translate('Top Vendor Products')}}
            </h5>
        </div>
        <div class="left-banner rounded">
            <div class="hide-768">
                <h5 class="fw-bold order-now-heading leadstitle2">Top Rated Products</h5>
                {{-- <a href="{{ route('products') }}" class="btn btn-danger btn-sm">View More</a> --}}
            </div>    
        </div>
        <!-- Product Cards Grid -->
        <div class="product-grid showabove768" style="width: 100%;">
            @if($topRatedProducts->isEmpty())
                <div class="no-products text-center w-100 p-4">
                    {{-- <img src="/images/no-products.svg" alt="No products available" style="max-width: 150px; margin-bottom: 15px;"> --}}
                    <p class="text-muted mb-2">No top-rated products available at the moment.</p>
                    <a href="{{ route('products') }}" class="btn btn-sm btn-primary">Browse All Products</a>
                </div>
            @else
                @foreach($topRatedProducts->take(5) as $product)
                    <!-- Product 1 -->
                    <div class="product-card image-wrapper shimmer">
                        <img data-src="{{ $product->thumbnail !== 'imageurl' ? '/storage/product/thumbnail/' . $product->thumbnail : '/images/placeholderimage.webp' }}" class="card-img-top lazyload" alt="Product 1"
                        onerror="this.onerror=null; this.src='/images/placeholderimage.webp';">
                        <div class="text-left">
                            <p class="small text-muted m-1 custom-dealrock-text-14 " style="font-weight: 500 !important; color: black;">{{ $product->name }}</p>
                            <p class="fw-bold m-1 custom-dealrock-text-18">US$ {{ number_format($product->unit_price, 2) }} / {{ $product->unit }}</p>
                            <p class="small text-muted m-2 custom-dealrock-text-14">{{ $product->min_qty }} {{ $product->unit }} (MOQ)</p>
                            <a href="{{ route('product',['slug'=>$product->slug]) }}" class="btn btn-outline-dark btn-sm w-100">Start order</a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="product-grid showbelow768" style="width: 100%;">
            @if($topRatedProducts->isEmpty())
                <div class="no-products text-center w-100 p-4">
                    {{-- <img src="/images/no-products.svg" alt="No products available" style="max-width: 150px; margin-bottom: 15px;"> --}}
                    <p class="text-muted mb-2">No top-rated products available at the moment.</p>
                    <a href="{{ route('products') }}" class="btn btn-sm btn-primary">Browse All Products</a>
                </div>
            @else
                @foreach($topRatedProducts->take(2) as $product)
                    <!-- Product 1 -->
                    <div class="card product-card image-wrapper shimmer">
                        <img data-src="{{ $product->thumbnail !== 'imageurl' ? '/storage/product/thumbnail/' . $product->thumbnail : '/images/placeholderimage.webp' }}" class="card-img-top lazyload" alt="Product 1" 
                            onerror="this.onerror=null; this.src='/images/placeholderimage.webp';">
                        <div class="card-body text-left">
                            <p class="small text-muted mb-1 custom-dealrock-text-14 " style="font-weight: 500 !important; color: black;">{{ $product->name }}</p>
                            <p class="fw-bold mb-1">US$ {{ number_format($product->unit_price, 2) }} / {{ $product->unit }}</p>
                            <p class="small text-muted mb-2">{{ $product->min_qty }} {{ $product->unit }} (MOQ)</p>
                            <a href="{{ route('product',['slug'=>$product->slug]) }}" class="btn btn-outline-dark btn-sm w-100">Start order</a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>