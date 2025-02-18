<?php
$allCategories = \App\Models\Category::inRandomOrder()->take(5)->get();
?>

@if(count($products) > 0)
@php($decimal_point_settings = getWebConfig(name: 'decimal_point_settings'))
    <div class="rightsideven">
        <div class="gridviewven">
            <h5 class="pagetitleven">All Products ({{ count($products) }} Products)</h5>
            <div class="boundaryven"></div>
            <div class="catandview">
                <div class="catsuggestbox">
                    <div class="categories">
                        @foreach($allCategories as $category)
                            <span class="catsuggestboxtext"><a href="{{ route('products', ['category_id' =>$category->id, 'data_from' => 'category', 'page' => 1]) }}">{{ $category->name }}</a></span>
                        @endforeach
                    </div>
                </div>
                <div class="view-controls">
                    <span class="icon" onclick="showListView()">
                        <i class="fa fa-bars"></i>
                    </span>
                    <span class="icon" onclick="showGridView()">
                        <i class="fa fa-th"></i>
                    </span>
                </div>
            </div>
            <div class="boundaryven"></div>

            <!-- Grid View -->
            <div class="carouselven" id="gridView" style="display: none;">
                <div class="carouselven-container">
                    @foreach($products as $item)
                        <div class="carouselven-body">
                            <p class="carouselven-badge">{{ $item->badge}}</p>
                            <img src="{{ $item->thumbnail !== 'imageurl' ? asset('storage/product/thumbnail/images/' . $item->thumbnail) : asset('images/placeholderimage.webp') }}"
                                alt="Item Image" class="carouselven-image" />
                            <a href="/product/{{ $item->slug }}">
                                <h4 class="carouselven-title">{{ $item->name }}</h4>
                            </a>
                            <p class="carouselven-price">US {{ $item->unit_price }}/{{$item->unit}}</p>
                            <p class="carouselven-order">Min. Order: {{ $item->min_qty ?? '1' }} per {{$item->unit}}</p>
                            <p class="carouselven-origin">Origin: {{ \App\Models\Country::where('id',$item->origin)->first()->country_name ?? 'Invalid Country Id' }}</p>
                            <p class="carouselven-description">{{ $item->details }}</p>
                            <p class="carouselven-rating">
                                {{ $item->views }} views
                            </p>
                            <div class="carouselven-buttons">
                                @if(auth('customer')->check())
                                    <a href="{{ route('product', $item->slug) }}" class="carouselven-button"
                                        style="color: white !important;">
                                        <img style="height: 20px; width: 20px; filter: brightness(0) invert(1);"
                                            src="{{ asset('/svgs/mail.png') }}" /> Contact Now or
                                        <img style="height: 20px; width: 20px; filter: brightness(0) invert(1);"
                                            src="{{ asset('/svgs/messenger.png') }}" /> Chat
                                    </a>
                                @else
                                    <a href="{{ route('customer.auth.login') }}" class="carouselven-button" style="color: white !important;">
                                        <img style="height: 20px; width: 20px; filter: brightness(0) invert(1);"
                                            src="{{ asset('/svgs/mail.png') }}" /> Contact Now or
                                        <img style="height: 20px; width: 20px; filter: brightness(0) invert(1);"
                                            src="{{ asset('/svgs/messenger.png') }}" /> Chat
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- List View -->
            <div class="listviewven" id="listView">
                @foreach($products as $item)
                    <div class="listview-item">
                        <div class="leftflexlistview">
                            <img src="{{ $item->thumbnail !== 'imageurl' ? asset('storage/product/thumbnail/images/' . $item->thumbnail) : '/images/placeholderimage.webp' }}"
                                alt="Item Image" class="listview-image" />
                        </div>
                        <div class="centerflexlistview">
                            <a class="d-flex" href="/product/{{ $item->slug }}">
                                <h6 class="listview-title">{{ $item->name }}</h6>
                            </a>
                            <p class="listview-price">US${{ $item->unit_price }} /{{ $item->unit}}</p>
                            <p class="listview-order">Min. Order: {{ $item->min_qty ?? '1' }}{{ $item->unit}}</p>
                            <p class="listview-description">Application: {{ $item->details }}</p>
                        </div>
                        <div class="rightmostflexlistview">
                            <p class="listview-badge">{{ $item->badge }}</p>
                            <p class="listview-origin">Origin: {{ \App\Models\Country::where('id',$item->origin)->first()->country_name ?? 'Invalid Country Id' }}</p>
                            <p class="listview-rating">
                                {{ $item->views }} views
                            </p>
                            <div class="listview-buttons">
                                @if(auth('customer')->check())
                                    <a href="{{ route('product', $item->slug) }}" class="carouselven-button"
                                        style="color: white !important;">
                                        <img style="height: 20px; width: 20px; filter: brightness(0) invert(1);"
                                            src="{{ asset('/svgs/mail.png') }}" /> Contact Now or
                                        <img style="height: 20px; width: 20px; filter: brightness(0) invert(1);"
                                            src="{{ asset('/svgs/messenger.png') }}" /> Chat
                                    </a>
                                @else
                                    <a href="{{ route('customer.auth.login') }}" class="carouselven-button" style="color: white !important;">
                                        <img style="height: 20px; width: 20px; filter: brightness(0) invert(1);"
                                            src="{{ asset('/svgs/mail.png') }}" /> Contact Now or
                                        <img style="height: 20px; width: 20px; filter: brightness(0) invert(1);"
                                            src="{{ asset('/svgs/messenger.png') }}" /> Chat
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Pagination -->
            <div class="pagination-container">
                {{ $products->links() }} <!-- Assuming you're using Laravel's pagination -->
            </div>
        </div>
    </div>
    <!-- @foreach($products as $product)
                <div
                    class="{{ Request::is('products*') ? 'col-lg-3 col-md-4 col-sm-4 col-6' : 'col-lg-2 col-md-3 col-sm-4 col-6' }} {{ Request::is('shopView*') ? 'col-lg-3 col-md-4 col-sm-4 col-6' : '' }} p-2">
                    @if(!empty($product))
                        <div class="product-item">
                            <img style="width: 300px; height: 300px;" src="storage/product/thumbnail/{{ $product->thumbnail }}" alt="{{ $product->name }}" />
                            <h6>{{ $product->name }}</h6>
                            <p>{{ $product->details }}</p>
                            <p><strong>{{ $product->unit_price }}</strong></p>
                        </div>
                    @endif
                </div>
                @endforeach

                <div class="col-12">
                <nav class="d-flex justify-content-between pt-2" aria-label="Page navigation" id="paginator-ajax">
                </nav>
                </div> -->
@else
<div class="d-flex justify-content-center align-items-center w-100 py-5">
    <div>
        <img src="{{ theme_asset(path: 'public/assets/front-end/img/media/product.svg') }}" class="img-fluid" alt="">
        <h6 class="text-muted">{{ translate('no_product_found') }}</h6>
    </div>
</div>
@endif

<script>
    function showGridView() {
        document.getElementById('gridView').style.display = 'block';
        document.getElementById('listView').style.display = 'none';
    }

    function showListView() {
        document.getElementById('gridView').style.display = 'none';
        document.getElementById('listView').style.display = 'block';
    }
</script>
<script>
    $(document).ready(function () {
        $(".owl-carousel").owlCarousel({
            items: 3,
            loop: true,
            autoplay: true,
            autoplayTimeout: 2000,
            responsive: {
                0: {
                    items: 1
                },
                464: {
                    items: 2
                },
                1024: {
                    items: 3
                }
            }
        });
    });
</script>