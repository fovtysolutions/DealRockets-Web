<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/ai/footer.css')}}" />
@php
$footerproducts = App\Utils\ChatManager::getProductsFooter();
$industries =  App\Utils\CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
@endphp
<div class="footer">
    <div class="footer-wrapper">
      <footer class="group-wrapper">
        <div class="group">
          <div class="responsive-1 deleleventeen">
            <div class="div">
              <div class="group-2" style="margin-right:40px;">
                <div class="row">
                  @foreach($footerproducts as $c)
                    <div class="col-md-6 product-category" style="text-align: left; margin-bottom:16px;"> <!-- Adjust column size to split into two columns -->
                        <span class="fw-bold d-flex" style="text-transform: uppercase; font-weight: 500 !important; align-content: start; font-size: 10px; color:#0D0D0F;">{{ $c['name'] }} 
                            <a href="{{ route('products', ['category_id' => $c['id'], 'data_from' => 'category', 'page' => 1]) }}" 
                                class="view-more custom-dealrock-subtext" 
                                onclick="toggleViewMore(this)" style="color: var(--web-text) !important; text-transform:none;">
                                - See More
                            </a>
                        </span>
                        <span class="product-list" style="height:44px; overflow:hidden; display: inline-block; line-height: 1rem;height: calc(1rem * 3);">
                                @foreach($c['products'] as $d)
                                    <a href="{{ route('product', ['slug' => $d['slug']]) }}" class="product-link custom-dealrock-subtext" style="font-size: 7px; color: var(--web-text) !important;">
                                        {{ $d['name'] }}@if (!$loop->last),@endif
                                    </a>
                                @endforeach
                        </span>
                    </div>
                  @endforeach
                </div>
              </div>
              <div class="group-10 group-new">
                <div class="text-wrapper-5">Our Products</div>
                <img class="line" src="img/line-34.svg" />
              </div>
            </div>
            <div class="group-11">
              <div class="group-2">
                <div class="row">
                  @foreach($industries->take(10) as $key => $value)
                    <div class="col-md-6 product-category" style="text-align: left; margin-bottom:16px;"> <!-- Adjust column size to split into two columns -->
                          <span class="fw-bold d-flex" style="text-transform: uppercase; font-weight: 500 !important; align-content: start; font-size: 10px; color:#0D0D0F;">                        
                        <a style="font-weight: 500 !important;text-transform:uppercase;font-size: 10px; color:#0D0D0F;" href="{{ route('buyer', ['industry' => $value['id']]) }}">
                            {{ $value['name'] }}
                        </a>
                        <a href="{{ route('products') }}" class="view-more custom-dealrock-subtext" style="text-transform: none; color: var(--web-text) !important;">
                            - See More
                        </a>
                        </span>
                        @if(isset($value->childes) && $value->childes->count() > 0)
                            <div class="sub-category-list pl-0" style="height:32px; overflow:hidden; display: inline-block; line-height: 1rem;height: calc(1rem * 3); font-size: 7px; font-weight: 400;">
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
              <div class="group-10 group-new">
                <div class="text-wrapper-5">Our Industries</div>
                <img class="img" src="img/line-34-1.svg" />
              </div>
            </div>
          </div>
          <div class="group-16 responsive-1">
            <div class="frame-6">
              <div class="group-17">
                <div class="text-wrapper-5">Special</div>
                <div class="frame-7">
                  <div class="footer-text"><div class="text-wrapper-7">Featured Products</div></div>
                  <div class="footer-text"><div class="text-wrapper-7">Latest Products</div></div>
                  <div class="footer-text"><div class="text-wrapper-7">Best Selling Products</div></div>
                  <div class="footer-text"><div class="text-wrapper-7">Top Rated Products</div></div>
                </div>
              </div>
              <div class="group-18">
                <div class="text-wrapper-5">Account info</div>
                <div class="frame-7">
                  <div class="footer-text"><div class="text-wrapper-7">Profile Info</div></div>
                  <div class="footer-text"><div class="text-wrapper-7">Wish list</div></div>
                  <div class="footer-text"><div class="text-wrapper-7">Track Order</div></div>
                </div>
              </div>
              <div class="group-17">
                <div class="text-wrapper-5">Shipping info</div>
                <div class="frame-7">
                  <div class="footer-text"><div class="text-wrapper-7">Refund policy</div></div>
                  <div class="footer-text"><div class="text-wrapper-7">Return policy</div></div>
                  <div class="footer-text"><div class="text-wrapper-7">Cancellation policy</div></div>
                  <div class="footer-text"></div>
                </div>
              </div>
              <div class="group-19">
                <div class="text-wrapper-5">Help</div>
                <div class="frame-7">
                  <div class="footer-text"><div class="text-wrapper-7">About us</div></div>
                  <div class="footer-text"><div class="text-wrapper-7">Contact Us</div></div>
                  <div class="footer-text"><div class="text-wrapper-7">HelpTopic</div></div>
                  <div class="footer-text"><div class="text-wrapper-7">Support ticket</div></div>
                </div>
              </div>
            </div>
            {{-- <img class="line-2" src="img/line-34-2.svg" /> --}}
            <div class="responsive-2">
              <div class="group-20">
                <div class="group-21">
                  <div class="text-wrapper-8">Mail Us</div>
                  <div class="group-22">
                    <img class="img-2" src="img/email.png" />
                    <div class="text-wrapper-9">contact@fovtysolutions.com</div>
                  </div>
                </div>
                <div class="group-23">
                  <div class="text-wrapper-8">Social</div>
                  <div class="frame-8">
                    <div class="twitter"></div>
                    <div class="linkedin"></div>
                    <div class="instagram"></div>
                    <div class="facebook"></div>
                  </div>
                </div>
              </div>              
              <div class="group-24">
                <div class="text-wrapper-8">Registered office address</div>
                <div class="group-25">
                  <img class="img-2" src="img/maps-and-flags.png" />
                  <div class="text-wrapper-9">India</div>
                </div>
              </div>
            </div>
          </div>
          <div class="group-26 responsive-1">
            <div class="group-27">
              <div class="group-10">
                <div class="text-wrapper-5">Explore More</div>
                <img class="line" src="img/line-34-3.svg" />
              </div>
              <div class="frame-9">
                <div class="frame-5">
                  <img class="img-3" src="img/store.png" />
                  <div class="text-wrapper-10">Become a Seller</div>
                </div>
                <div class="frame-5">
                  <img class="img-3" src="img/accept.png" />
                  <div class="text-wrapper-10">Terms &amp; Conditions</div>
                </div>
                <div class="frame-5">
                  <img class="img-3" src="img/legal-document.png" />
                  <div class="text-wrapper-10">Privacy policy</div>
                </div>
              </div>
            </div>
            <div class="group-28">
              <div class="group-10">
                <div class="text-wrapper-5">About Company</div>
                <img class="line-3" src="img/line-34-4.svg" />
              </div>
              <div class="frame-9">
                <div class="frame-5">
                  <img class="img-3" src="img/copyright.png" />
                  <div class="text-wrapper-10">CopyRight DealRabbit@2024</div>
                </div>
                <div class="frame-5">
                  <img class="img-3" src="img/viber.png" />
                  <div class="text-wrapper-10">+971551582756</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>