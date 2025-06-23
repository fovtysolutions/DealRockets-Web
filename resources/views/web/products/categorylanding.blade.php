@extends('layouts.front-end.app')
@push('css_or_js')
    <link rel="stylesheet" href="{{ asset('assets/custom-css/ai/marketplace-sub.css') }}">
@endpush
@section('title')
    Category Landing Page | {{ $web_config['name']->value }}
@endsection
@section('content')
    <section class="mainpagesection marketplace-sub" style="background: unset; margin-top:20px;">
        <div class="market-price-container" style="background-color: #f7f7f7;">
            <!-- <div class="container bg-white form-con my-4 d-flex" > -->
            <div class="category-section bg-white">
                <div class="category-sidebar">
                    <h3 class="protection-head"><strong><a href="{{ route('products', ['category_id' => $categories->id, 'data_from' => 'category', 'page' => 1]) }}">{{ $categories->name }}</a></strong> </h3>
                    @if(empty($categories->childes))
                        <ul class="ul-desktop">
                            @foreach($categories->childes as $subcategory)
                                <li>
                                    <h6><span>{{ $subcategory->name }}</span><i class="bi bi-chevron-right"></i></h6>
                                    <div class="d-flex">
                                        @foreach($subcategory->childes as $subsubcategory)
                                            <a href="{{ route('products', ['category_id' => $subsubcategory->id, 'data_from' => 'category', 'page' => 1]) }}">
                                                <p>{{ $subsubcategory->name }}&nbsp;/&nbsp;</p>
                                            </a>
                                        @endforeach
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="mt-3" style="font-size: unset;">No Sub Categories Avaliable!</p>
                    @endif
                </div>

                <div class="category-grid">
                    @if(empty($randomSubsubcategories))
                        @foreach($randomSubsubcategories as $product) 
                            <a class="category-card" href="{{ route('products', ['category_id' => $product->id, 'data_from' => 'category', 'page' => 1]) }}">
                                <p>{{ $product->name }}</p>
                                <img src="{{ $product->category_image ? asset('storage/'.$product->category_image) : '/images/placeholderimage.webp' }}" alt="{{ $product->name }}" />
                            </a>
                        @endforeach
                    @else
                        <p style="font-size: unset; color: #555;">No Sub Sub Categories Avaliable!</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
    @include('web-views.partials._order-now')
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $(".hoveronshow").hover(function() {
                // Hide all dropdowns first
                $(".subcategory-dropdown").hide();

                // Show only the hovered subcategory's dropdown
                $(this).find(".subcategory-dropdown").show();
            }, function() {
                // Hide dropdown when not hovering
                $(this).find(".subcategory-dropdown").hide();
            });
        });
    </script>
@endpush
