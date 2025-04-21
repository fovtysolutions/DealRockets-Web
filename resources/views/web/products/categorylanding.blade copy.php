@extends('layouts.front-end.app')
@push('css_or_js')
<link rel="stylesheet" href="{{ asset('public/assets/custom-css/ai/marketplace-sub.css') }}">
@endpush
@section('title')
Category Landing Page | {{ $web_config['name']->value }}
@endsection
@section('content')
<section class="mainpagesection marketplace-sub">
    <div class="d-flex">
        <div class="left-section" style="width: 30%; padding: 20px; border-right: 1px solid lightgrey;">
            <h4 class="custom-dealrock-subhead" style="border-bottom: 1px solid lightgrey; padding-bottom: 10px;">
                {{ $categories->name }}
            </h4>
            
            @foreach($categories->childes as $subcategory)
                <div class="subcategory pt-2 pb-1 hoveronshow position-relative" 
                    style="border-bottom: 1px solid lightgrey;">
                    
                    <h5 class="custom-dealrock-text">{{ $subcategory->name }}</h5>
                    <div class="d-flex">
                        @foreach($subcategory->childes as $subsubcategory)
                            <a href="{{ route('products', ['category_id' => $subsubcategory->id, 'data_from' => 'category', 'page' => 1]) }}">
                                <p>{{ $subsubcategory->name }}&nbsp;/&nbsp;</p>
                            </a>
                        @endforeach
                    </div>

                    <!-- Individual Dropdown for Each Subcategory -->
                    <div class="subcategory-dropdown position-absolute d-none"
                        style="top: 0; left: 100%; width: 200px; background: white; border: 1px solid lightgrey; padding: 10px; 
                                z-index: 10; height: 200px; overflow-y: scroll;">
                        {{-- <h5 class="custom-dealrock-subhead">{{ $subcategory->name }}</h5> --}}
                        <div class="d-block">
                            @foreach($subcategory->childes as $subsubcategory)
                                <a class="makethisred" href="{{ route('products', ['category_id' => $subsubcategory->id, 'data_from' => 'category', 'page' => 1]) }}">
                                    <p class="mb-2 mt-2 custom-dealrock-text">{{ $subsubcategory->name }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Right Section: Product Grid (80% Width) -->
        <div class="right-section" style="width: 70%; padding: 20px;">
            <div class="prd-grid">
                @foreach($randomSubsubcategories as $product) <!-- Get only 8 products -->
                    <div class="prd-item">
                        <a style="all: unset; cursor: pointer;" href="{{ route('products', ['category_id' => $product->id, 'data_from' => 'category', 'page' => 1]) }}" class="text-decoration-none">
                            <div class="source-product-item">
                                <div class="product-name text-left d-flex flex-column justify-content-center">
                                    <p class="custom-dealrock-text">{{ $product->name }}</p>
                                </div>
                                <img src="{{ $product->category_image ? asset('storage/'.$product->category_image) : '/images/placeholderimage.webp' }}" alt="product" class="source-product-img align-self-end" />
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
<script>
    $(document).ready(function () {
        $(".hoveronshow").hover(function () {
            // Hide all dropdowns first
            $(".subcategory-dropdown").hide();
            
            // Show only the hovered subcategory's dropdown
            $(this).find(".subcategory-dropdown").show();
        }, function () {
            // Hide dropdown when not hovering
            $(this).find(".subcategory-dropdown").hide();
        });
    });
</script>
@endpush