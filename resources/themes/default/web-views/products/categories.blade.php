@extends('layouts.front-end.app')
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/leads.css') }}" />
@section('title', translate('all_Categories'))

@push('css_or_js')
    <meta property="og:image" content="{{ $web_config['web_logo']['path'] }}" />
    <meta property="og:title" content="Categories of {{ $web_config['name']->value }} " />
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:description"
        content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)), 0, 160) }}">
    <meta property="twitter:card" content="{{ $web_config['web_logo']['path'] }}" />
    <meta property="twitter:title" content="Categories of {{ $web_config['name']->value }}" />
    <meta property="twitter:url" content="{{ env('APP_URL') }}">
    <meta property="twitter:description"
        content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)), 0, 160) }}">
    <style>
        .filter-header {
            background: linear-gradient(90deg, #FE4E44 0%, #9F0900 100%);
            -webkit-background-clip: text;
            width: max-content;
            -webkit-text-fill-color: transparent;
        }

        .filter-description {
            font-size: 16px;
            color: black;
            margin-bottom: 30px;
        }

        .main-category .country-button {
            color: #303030;
            font-size: 16px;
            /* border-bottom: 1px solid lightgrey; */
            padding-bottom: 14px;
            width: 90%;
        }

        .main-category a:hover {
            color: #fb2419;
        }

        .sub-category-button {
            font-size: 14px !important;
            padding: 5px 10px 0px 0px;
            color: rgba(81, 80, 80, 1) !important;
        }

        .sub-category-button:hover {
            color: #fb2419 !important;
            transform: scale(1) !important;
        }

        .sub-category-list {
            padding-left: 5px;
        }
    </style>
@endpush

@section('content')
    <div class="mainpagesection">

        {{-- <div class="bg-primary-light rounded-10 my-4 p-3 p-sm-4"
            data-bg-img="{{ theme_asset(path: 'public/assets/front-end/img/media/bg.png') }}">
            <div class="d-flex flex-column gap-1 text-primary">
                <h4 class="mb-0 text-start fw-bold text-primary text-uppercase">
                    {{ translate('category') }}
                </h4>
                <p class="fs-14 fw-semibold mb-0">
                    {{ translate('Find_your_favourite_categories_and_products') }}
                </p>
            </div>
        </div> --}}

        <div class="d-flex w-100" style="border-radius: 10px; margin-top:22px;">
            <div class="filter-container" style="box-shadow: unset;border: 1px solid lightgrey;">
                <h5 class="filter-header">
                    All Industries
                </h5>
                <div class="filter-description">
                    {{ translate('Find_your_favourite_categories_and_products') }}
                </div>
                <!-- Country Buttons -->
                <div class="country-buttons">
                    @foreach ($categories as $key => $value)
                        <div class="main-category">
                            <a class="country-button font-weight-bold" href="/marketplace-categories/{{ $value['id'] }}">
                                {{ $value['name'] }}
                            </a>
                            @if ($value->childes->count() > 0)
                                <div class="sub-category-list">
                                    @foreach ($value->childes as $sub_category)
                                        <a class="sub-category-button font-weight-normal"
                                            href="{{ route('products', ['category_id' => $sub_category['id'], 'data_from' => 'category', 'page' => 1]) }}"><i class='fas fa-angle-right'></i>
                                            {{ $sub_category['name'] }}
                                        </a>
                                        {{-- @if ($sub_category->childes->count() > 0)
                                            <div class="sub-sub-category-list">
                                                @foreach ($sub_category->childes as $sub_sub_category)
                                                    <a class="sub-sub-category-button font-weight-light"
                                                        href="{{ route('products', ['industry' => $sub_sub_category['id']]) }}">
                                                        {{ $sub_sub_category['name'] }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif --}}
                                    @endforeach
                                </div>
                            @endif
                            @if ($value->childes->count() == 0)
                                <div class="sub-category-list">
                                    <span class="sub-category-button font-weight-normal">No Sub Categories Added</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                <!-- Display selected tags -->
                <div class="selected-tags" id="selectedTags"></div>
            </div>
        </div>
        {{-- <div class="brand_div-wrap mb-4"> 
            @foreach ($categories as $categoryKey => $category)
            <a href="{{route('products',['category_id'=> $category['id'],'data_from'=>'category','page'=>1])}}" class="brand_div">
                <img src="{{ getStorageImages(path: $category->icon_full_url, type: 'category') }}" alt="{{ $category['name'] }}">
                <div>{{ $category['name'] }}</div>
            </a>
            @endforeach 
            </div> --}}
    </div>
@endsection

@push('script')
    <script src="{{ asset('public/assets/front-end/js/categories.js') }}"></script>
@endpush
