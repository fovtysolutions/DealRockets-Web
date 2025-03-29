{{-- Start CSS --}}
<style>
    .footer-header{
        font-size: 14px;
        color: var(--web-text) !important;
    }
    .page-footer{
        color: var(--web-text) !important;
    }
    .__inline-9 .widget-list-link {
        font-size: 14px;
        color: var(--web-text) !important;
    }
    .page-footer hr {
        background: rgba(0, 0, 0, 0.43) !important;
        border: none !important;
        height: 1px;
        width: 100% !important;
    }
    .social-media a{
        background-color: rgb(157, 156, 156) !important;
    }

    @media(max-width: 768px){
        .footerbottom{
            flex-direction: column !important;
        }
        .footer-padding-bottom{
            width: 100% !important;
        }
    }
</style>
{{-- End CSS --}}
{{-- Start Content --}}
    @php
        $footerproducts = App\Utils\ChatManager::getProductsFooter();
        $industries =  App\Utils\CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
    @endphp
    <div class="__inline-9 rtl" style="margin-top: 22px;">
        <footer class="page-footer font-small mdb-color rtl custom-footer" style="padding-left:30px;">
            <div class="pt-1 custom-light-primary-color-20">
                <div class="container text-center __pb-13px">
                    <div class="row mt-3 pb-3 ">
                        <div class="row mb-4">
                            <!-- Footer Products Section -->
                            <div class="col-md-6">
                                <div
                                        class="d-flex align-items-center mobile-view-center-align text-start justify-content-between">
                                        <div class="me-3">
                                            <span class="mb-4 font-weight-bold footer-header custom-dealrock-subhead text-capitalize">{{ translate('Our_Products')}}</span>
                                        </div>
                                        <div
                                            class="flex-grow-1 d-none d-md-block {{Session::get('direction') === "rtl" ? 'mr-4 mx-sm-4' : 'mx-sm-4'}}">
                                            <hr>
                                        </div>
                                    </div>
                                <div class="row">
                                    @foreach($footerproducts as $c)
                                        <div class="col-md-6 product-category" style="text-align: left;"> <!-- Adjust column size to split into two columns -->
                                            <span class="fw-bold custom-dealrock-subtext d-flex" style="font-weight: bold !important; align-content: start;">{{ $c['name'] }} 
                                                <a href="{{ route('products', ['category_id' => $c['id'], 'data_from' => 'category', 'page' => 1]) }}" 
                                                    class="view-more custom-dealrock-subtext" 
                                                    onclick="toggleViewMore(this)" style="color: var(--web-text) !important;">
                                                    - more
                                                </a>
                                            </span>
                                            <span class="product-list" style="height:44px; overflow:hidden; display: inline-block;">
                                                    @foreach($c['products'] as $d)
                                                        <a href="{{ route('product', ['slug' => $d['slug']]) }}" class="product-link custom-dealrock-subtext" style="font-size: 13px; color: var(--web-text) !important;">
                                                            {{ $d['name'] }}@if (!$loop->last),@endif
                                                        </a>
                                                    @endforeach
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        
                            <!-- Industries Section -->
                            <div class="col-md-6">
                                <div
                                    class="d-flex align-items-center mobile-view-center-align text-start justify-content-between">
                                    <div class="me-3">
                                        <span class="mb-4 font-weight-bold footer-header custom-dealrock-subhead text-capitalize">{{ translate('Our_Industries')}}</span>
                                    </div>
                                    <div
                                        class="flex-grow-1 d-none d-md-block {{Session::get('direction') === "rtl" ? 'mr-4 mx-sm-4' : 'mx-sm-4'}}">
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    @foreach($industries->take(10) as $key => $value)
                                        <div class="col-md-6 main-category" style="text-align: left;"> <!-- Adjust column size to split into two columns -->
                                            <a class="font-weight-bold custom-dealrock-subtext" style="font-weight: bold !important;" href="{{ route('buyer', ['industry' => $value['id']]) }}">
                                                {{ $value['name'] }}
                                            </a>
                                            <a href="{{ route('products') }}" class="view-more custom-dealrock-subtext" style="color: var(--web-text) !important;">
                                                - more
                                            </a>
                                            @if(isset($value->childes) && $value->childes->count() > 0)
                                                <div class="sub-category-list pl-0" style="height:32px; overflow:hidden; display: inline-block;">
                                                    @foreach($value->childes->take(5) as $sub_category)
                                                        <a class="font-weight-normal custom-dealrock-subtext" 
                                                        href="{{ route('buyer', ['industry' => $sub_category['id']]) }}">
                                                            {{ $sub_category['name'] }}@if (!$loop->last),@endif
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div> 
                        <div class="col-md-12">
                            <div class="row">
                                <div class="d-flex flex-row footerbottom" style="width: 55%;">
                                    <div class="col footer-padding-bottom text-start" style="width: 25%;">
                                        <h6 class="text-uppercase mobile-fs-12 font-semi-bold footer-header custom-dealrock-subhead">{{ translate('special')}}</h6>
                                        <ul class="widget-list __pb-10px">
                                            @php($flash_deals=\App\Models\FlashDeal::where(['status'=>1,'deal_type'=>'flash_deal'])->whereDate('start_date','<=',date('Y-m-d'))->whereDate('end_date','>=',date('Y-m-d'))->first())
                                            @if(isset($flash_deals))
                                                <li class="widget-list-item">
                                                    <a class="widget-list-link custom-dealrock-text"
                                                    href="{{route('flash-deals',[$flash_deals['id']])}}">
                                                        {{ translate('flash_deal')}}
                                                    </a>
                                                </li>
                                            @endif
                                            <li class="widget-list-item">
                                                <a class="widget-list-link custom-dealrock-text"
                                                href="{{route('products',['data_from'=>'featured','page'=>1])}}">
                                                    {{ translate('featured_products')}}
                                                </a>
                                            </li>
                                            <li class="widget-list-item">
                                                <a class="widget-list-link custom-dealrock-text"
                                                href="{{route('products',['data_from'=>'latest','page'=>1])}}">
                                                    {{ translate('latest_products')}}
                                                </a>
                                            </li>
                                            <li class="widget-list-item">
                                                <a class="widget-list-link custom-dealrock-text"
                                                href="{{route('products',['data_from'=>'best-selling','page'=>1])}}">
                                                    {{ translate('best_selling_product')}}
                                                </a>
                                            </li>
                                            <li class="widget-list-item">
                                                <a class="widget-list-link custom-dealrock-text"
                                                href="{{route('products',['data_from'=>'top-rated','page'=>1])}}">
                                                    {{ translate('top_rated_product')}}
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                    <div class="col footer-padding-bottom text-start" style="width: 25%;">
                                        <h6 class="text-uppercase mobile-fs-12 font-semi-bold footer-header custom-dealrock-subhead">{{ translate('account_info')}}</h6>
                                        @php($refund_policy = getWebConfig(name: 'refund-policy'))
                                        @php($return_policy = getWebConfig(name: 'return-policy'))
                                        @php($cancellation_policy = getWebConfig(name: 'cancellation-policy'))
                                        @php($shippingPolicy = getWebConfig(name: 'shipping-policy'))
                                        @if(auth('customer')->check())
                                            <ul class="widget-list __pb-10px">
                                                <li class="widget-list-item">
                                                    <a class="widget-list-link custom-dealrock-text" href="{{route('user-account')}}">
                                                        {{ translate('profile_info')}}
                                                    </a>
                                                </li>

                                                <li class="widget-list-item">
                                                    <a class="widget-list-link custom-dealrock-text" href="{{route('track-order.index')}}">
                                                        {{ translate('track_order')}}
                                                    </a>
                                                </li>
                                            </ul>
                                        @else
                                            <ul class="widget-list __pb-10px">
                                                <li class="widget-list-item">
                                                    <a class="widget-list-link custom-dealrock-text"
                                                    href="{{route('customer.auth.login')}}">{{ translate('profile_info')}}</a>
                                                </li>
                                                <li class="widget-list-item">
                                                    <a class="widget-list-link custom-dealrock-text"
                                                    href="{{route('customer.auth.login')}}">{{ translate('wish_list')}}</a>
                                                </li>

                                                <li class="widget-list-item">
                                                    <a class="widget-list-link custom-dealrock-text"
                                                    href="{{route('track-order.index')}}">{{ translate('track_order')}}</a>
                                                </li>
                                            </ul>
                                        @endif
                                    </div>
                                    <div class="col footer-padding-bottom text-start" style="width: 25%;">
                                        <h6 class="text-uppercase mobile-fs-12 font-semi-bold footer-header custom-dealrock-subhead">{{ translate('shipping_info')}}</h6>
                                        @if(auth('customer')->check())
                                            <ul class="widget-list __pb-10px">
                                                @if(isset($refund_policy['status']) && $refund_policy['status'] == 1)
                                                    <li class="widget-list-item">
                                                        <a class="widget-list-link custom-dealrock-text" href="{{route('refund-policy')}}">
                                                            {{ translate('refund_policy')}}
                                                        </a>
                                                    </li>
                                                @endif

                                                @if(isset($return_policy['status']) && $return_policy['status'] == 1)
                                                    <li class="widget-list-item">
                                                        <a class="widget-list-link custom-dealrock-text" href="{{route('return-policy')}}">
                                                            {{ translate('return_policy')}}
                                                        </a>
                                                    </li>
                                                @endif

                                                @if(isset($cancellation_policy['status']) && $cancellation_policy['status'] == 1)
                                                    <li class="widget-list-item">
                                                        <a class="widget-list-link custom-dealrock-text" href="{{route('cancellation-policy')}}">
                                                            {{ translate('cancellation_policy')}}
                                                        </a>
                                                    </li>
                                                @endif

                                                @if(isset($shippingPolicy['status']) && $shippingPolicy['status'] == 1)
                                                    <li class="widget-list-item">
                                                        <a class="widget-list-link custom-dealrock-text" href="{{route('shipping-policy')}}">
                                                            {{ translate('Shipping_Policy')}}
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        @else
                                            <ul class="widget-list __pb-10px">
                                                @if(isset($refund_policy['status']) && $refund_policy['status'] == 1)
                                                    <li class="widget-list-item">
                                                        <a class="widget-list-link custom-dealrock-text"
                                                        href="{{route('refund-policy')}}">{{ translate('refund_policy')}}</a>
                                                    </li>
                                                @endif

                                                @if(isset($return_policy['status']) && $return_policy['status'] == 1)
                                                    <li class="widget-list-item">
                                                        <a class="widget-list-link custom-dealrock-text"
                                                        href="{{route('return-policy')}}">{{ translate('return_policy')}}</a>
                                                    </li>
                                                @endif

                                                @if(isset($cancellation_policy['status']) && $cancellation_policy['status'] == 1)
                                                    <li class="widget-list-item">
                                                        <a class="widget-list-link custom-dealrock-text"
                                                        href="{{route('cancellation-policy')}}">{{ translate('cancellation_policy')}}</a>
                                                    </li>
                                                @endif

                                                @if(isset($shippingPolicy['status']) && $shippingPolicy['status'] == 1)
                                                    <li class="widget-list-item">
                                                        <a class="widget-list-link custom-dealrock-text" href="{{route('shipping-policy')}}">
                                                            {{ translate('shipping_Policy')}}
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        @endif
                                    </div>
                                    <div class="col footer-padding-bottom text-start" style="border-right: 1px solid rgba(0, 0, 0, 0.43);width: 25%;">
                                        <h6 class="text-uppercase mobile-fs-12 font-semi-bold footer-header custom-dealrock-subhead">{{ translate('help')}}</h6>
                                            <ul class="widget-list __pb-10px">
                                                <li class="widget-list-item">
                                                    <a class="widget-list-link custom-dealrock-text" href="{{route('about-us')}}">
                                                        {{ translate('about_us')}}
                                                    </a>
                                                </li>
                                                <li class="widget-list-item">
                                                    <a class="widget-list-link custom-dealrock-text" href="{{route('contacts')}}">
                                                        {{ translate('contacts')}}
                                                    </a>
                                                </li>
                                                <li class="widget-list-item">
                                                    <a class="widget-list-link custom-dealrock-text" href="{{route('helpTopic')}}">
                                                        {{ translate('helpTopic')}}
                                                    </a>
                                                </li>
                                                @if(auth('customer')->check())
                                                    <a class="widget-list-link custom-dealrock-text" href="{{route('account-tickets')}}">
                                                        <span>{{ translate('support_ticket')}} </span>
                                                    </a>
                                                    <br class="d-none d-md-block" />
                                                @else
                                                    <a class="widget-list-link custom-dealrock-text" href="{{route('customer.auth.login')}}">
                                                        <span>{{ translate('support_ticket')}} </span>
                                                    </a>
                                                    <br class="d-none d-md-block" />
                                                @endif
                                            </ul>
                                    </div>
                                </div>
                                <div class="d-flex flex-row footerbottom" style="width: 45%;">
                                    <div class="col footer-padding-bottom text-start" style="width: 50%;">
                                        <h6 class="text-uppercase mobile-fs-12 font-semi-bold footer-header custom-dealrock-subhead">{{ translate('mail_us')}}</h6>
                                            <ul class="widget-list __pb-10px">
                                                <a class="widget-list-link custom-dealrock-text"
                                                    href="{{ 'mailto:'.getWebConfig(name: 'company_email') }}">
                                                    <span><i class="fa fa-envelope  me-2 mt-2 mb-2"></i> {{getWebConfig(name: 'company_email')}} </span>
                                                </a>
                                            </ul>
                                        <h6 class="text-uppercase mobile-fs-12 font-semi-bold footer-header custom-dealrock-subhead">{{ translate('social')}}</h6>
                                            <div
                                            class="max-sm-100 d-flex flex-wrap mt-md-3 mt-0 mb-md-3">
                                            @if($web_config['social_media'])
                                                @foreach ($web_config['social_media'] as $item)
                                                    <span class="social-media ">
                                                        @if ($item->name == "twitter")
                                                            <a class="social-btn text-white sb-light sb-{{$item->name}} me-2 mb-2 d-flex justify-content-center align-items-center"
                                                            target="_blank" href="{{$item->link}}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="16"
                                                                    height="16" viewBox="0 0 24 24">
                                                                    <g opacity=".3">
                                                                        <polygon fill="#fff" fill-rule="evenodd"
                                                                        points="16.002,19 6.208,5 8.255,5 18.035,19"
                                                                                clip-rule="evenodd">
                                                                        </polygon>
                                                                        <polygon points="8.776,4 4.288,4 15.481,20 19.953,20 8.776,4">
                                                                        </polygon>
                                                                    </g>
                                                                    <polygon fill-rule="evenodd"
                                                                            points="10.13,12.36 11.32,14.04 5.38,21 2.74,21"
                                                                        clip-rule="evenodd">
                                                                    </polygon>
                                                                    <polygon fill-rule="evenodd"
                                                                            points="20.74,3 13.78,11.16 12.6,9.47 18.14,3"
                                                                            clip-rule="evenodd">
                                                                    </polygon>
                                                                    <path
                                                                        d="M8.255,5l9.779,14h-2.032L6.208,5H8.255 M9.298,3h-6.93l12.593,18h6.91L9.298,3L9.298,3z"
                                                                        fill="currentColor">
                                                                    </path>
                                                                </svg>
                                                            </a>
                                                        @else
                                                            <a class="social-btn text-white sb-light sb-{{$item->name}} me-2 mb-2"
                                                            target="_blank" href="{{$item->link}}">
                                                                <i class="{{$item->icon}}" aria-hidden="true"></i>
                                                            </a>
                                                        @endif
                                                    </span>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col footer-padding-bottom text-start" style="width: 50%;">
                                        <h6 class="text-uppercase mobile-fs-12 font-semi-bold footer-header custom-dealrock-subhead">{{ translate('registered_office_address')}}</h6>
                                            <ul class="widget-list __pb-10px">
                                                <span
                                                    class="__text-14px d-flex align-items-center">
                                                    <i class="fa fa-map-marker me-2 mt-2 mb-2"></i>
                                                    <span>{{ getWebConfig(name: 'shop_address')}}</span>
                                                </span>
                                            </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4 {{Session::get('direction') === "rtl" ? ' flex-row-reverse' : ''}}">
                                <div class="col-md-7">
                                    <div
                                        class="d-flex align-items-center mobile-view-center-align text-start justify-content-between">
                                        <div class="me-3">
                                            <span class="mb-4 font-weight-bold footer-header custom-dealrock-subhead text-capitalize">{{ translate('explore_more')}}</span>
                                        </div>
                                        <div
                                            class="flex-grow-1 d-none d-md-block {{Session::get('direction') === "rtl" ? 'mr-4 mx-sm-4' : 'mx-sm-4'}}">
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row text-start">
                                        <div class="col-11 start_address ">
                                            <div class="">
                                                <a class="widget-list-link custom-dealrock-text" href="{{ route('vendor.auth.login') }}">
                                                    <span class="">
                                                        <i class="fa-solid fa-shop me-2 mt-2 mb-2"></i>
                                                        <span class="direction-ltr">
                                                            Become a Seller
                                                        </span>
                                                    </span>
                                                </a>

                                            </div>
                                            <div class="align-content-center">
                                                <!-- Terms & Conditions -->
                                                <a class="widget-list-link custom-dealrock-text" href="{{ route('terms') }}">
                                                    <span class="">
                                                        <i class="fa-solid fa-file-contract me-2"></i>
                                                        <span class="direction-ltr">
                                                            {{ translate('terms_&_conditions') }}
                                                        </span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="align-content-center">
                                                <!-- Privacy Policy -->
                                                <a class="widget-list-link custom-dealrock-text" href="{{ route('privacy-policy') }}">
                                                    <span class="">
                                                        <i class="fa-solid fa-user-shield me-2"></i>
                                                        <span class="direction-ltr">
                                                            {{ translate('privacy_policy') }}
                                                        </span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 text-start">
                                    <div
                                        class="row d-flex align-items-center mobile-view-center-align justify-content-center justify-content-md-start pb-0">
                                        <div class="d-none d-md-block">
                                            <span class="mb-4 font-weight-bold footer-header custom-dealrock-subhead">{{ translate('About Company')}}</span>
                                        </div>
                                        <div
                                            class="flex-grow-1 d-none d-md-block {{Session::get('direction') === "rtl" ? 'mr-3 ' : 'ml-3'}}">
                                            <hr class="address_under_line"/>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <span
                                                class="__text-14px d-flex align-items-center">
                                                    <i class="fa-regular fa-copyright me-2 mt-2 mb-2"></i>
                                                    <span class="direction-ltr">
                                                        {{ $web_config['copyright_text']->value }}
                                                    </span>
                                            </span>
                                        </div>
                                        <div>
                                            <span
                                                class="__text-14px d-flex align-items-center">
                                                    <i class="fa fa-phone  me-2 mt-2 mb-2"></i>
                                                    <span class="direction-ltr">
                                                        {{getWebConfig(name: 'company_phone')}}
                                                    </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>                                                                    
                        </div>
                    </div>
                </div>
            </div>
            @php($cookie = $web_config['cookie_setting'] ? json_decode($web_config['cookie_setting']['value'], true):null)
            @if($cookie && $cookie['status'] == 1)
                <section id="cookie-section"></section>
            @endif
        </footer>
    </div>
{{-- End Content --}}