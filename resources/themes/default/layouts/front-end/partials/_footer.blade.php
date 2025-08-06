<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/ai/footer.css') }}" />
@php
    $footerproducts = App\Utils\ChatManager::getProductsFooter();
    $industries = App\Utils\CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
@endphp
<div class="footer" style="background-color: #e5e3e3;">
    <div class="footer-wrapper">
        <footer class="group-wrapper">
            <div class="group" style="max-width: 1440px; margin: 0 auto;">
                <div class="responsive-1 deleleventeen">
                    <div class="group-11">
                        <div class="group-2">
                            <div class="row">
                                @foreach ($industries->take(20) as $key => $value)
                                    <div class="col-md-3 product-category"
                                        style="text-align: left; margin-bottom:16px; height: 60px; overflow:hidden;">
                                        <!-- Adjust column size to split into two columns -->
                                        <span class="fw-bold d-flex"
                                            style="text-transform: uppercase; font-weight: 500 !important; align-content: start; font-size: 10px; color:#0D0D0F;">
                                            <a style="font-weight: 500 !important;text-transform:uppercase;font-size: 10px; color:#0D0D0F;"
                                                href="{{ route('buyer', ['industry' => $value['id']]) }}">
                                                {{ $value['name'] }}
                                            </a>
                                            <a href="{{ route('products') }}" class="view-more custom-dealrock-subtext"
                                                style="text-transform: none; color: var(--web-text) !important;">
                                                - See More
                                            </a>
                                        </span>
                                        @if (isset($value->childes) && $value->childes->count() > 0)
                                            <div class="sub-category-list pl-0"
                                                style="height:32px; overflow:hidden; display: inline-block; line-height: 1rem;height: calc(1rem * 3); font-size: 7px; font-weight: 400;">
                                                @foreach ($value->childes->take(5) as $sub_category)
                                                    <a class="font-weight-normal custom-dealrock-subtext"
                                                        href="{{ route('buyer', ['industry' => $sub_category['id']]) }}">
                                                        {{ $sub_category['name'] }}@if (!$loop->last)
                                                            ,
                                                        @endif
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
                            <img class="img" src="/img/line-34-1.svg" />
                        </div>
                    </div>
                </div>
                <!-- New Client Requested Footer Sections -->
                <div class="d-flex" style="height: 175px;margin-bottom: 20px;">
                    <div class="frame-x">
                        <div class="group-17">
                            <div class="text-wrapper-5">Legal</div>
                            <div class="frame-7">
                                <div class="footer-text"><a href="{{ route('terms') }}" class="text-wrapper-7">Trade Mark</a></div>
                                <div class="footer-text"><a href="{{ route('contacts') }}" class="text-wrapper-7">Grievance</a></div>
                                <div class="footer-text"><a href="{{ route('helpTopic') }}" class="text-wrapper-7">Language</a></div>
                            </div>
                        </div>
                        <div class="group-18">
                            <div class="text-wrapper-5">Policies</div>
                            <div class="frame-7">
                                <div class="footer-text"><a href="{{ route('terms') }}" class="text-wrapper-7">User Agreement</a></div>
                                <div class="footer-text"><a href="{{ route('dealassist') }}" class="text-wrapper-7">Trade Solutions</a></div>
                                <div class="footer-text"><a href="{{ route('privacy-policy') }}" class="text-wrapper-7">Declaration</a></div>
                            </div>
                        </div>
                        <div class="group-17">
                            <div class="text-wrapper-5">Registration</div>
                            <div class="frame-7">
                                <div class="footer-text"><a href="/customer/auth/login" class="text-wrapper-7">Register as Buyer</a></div>
                                <div class="footer-text"><a href="{{ route('vendor.auth.login') }}" class="text-wrapper-7">Register as Supplier</a></div>
                                <div class="footer-text"><a href="/customer/auth/hire-sign-in" class="text-wrapper-7">Register as Consultant</a></div>
                                <div class="footer-text"><a href="/membership" class="text-wrapper-7">Membership</a></div>
                            </div>
                        </div>
                        <div class="group-19">
                            <div class="text-wrapper-5">Return Policy</div>
                            <div class="frame-7">
                                <div class="footer-text"><a href="{{ route('return-policy') }}" class="text-wrapper-7">Return Policy</a></div>
                                <div class="footer-text"><a href="{{ route('refund-policy') }}" class="text-wrapper-7">Refund Policy</a></div>
                                <div class="footer-text"><a href="{{ route('cancellation-policy') }}" class="text-wrapper-7">Cancellation Policy</a></div>
                                <div class="footer-text"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Buyers Benefits Section -->
                    <div class="frame-y">
                        <div class="group-17">
                            <div class="text-wrapper-5">For Buyers</div>
                            <div class="frame-7">
                                <div class="footer-text"><a href="/sale-offer" class="text-wrapper-7">Current Sale Offers</a></div>
                                <div class="footer-text"><a href="/products?searchInput=" class="text-wrapper-7">10,000+ Products</a></div>
                                <div class="footer-text"><a href="/deal-assist" class="text-wrapper-7">Deal Assist</a></div>
                                <div class="footer-text"><a href="/deal-assist" class="text-wrapper-7">Rocket Negotiation</a></div>
                            </div>
                        </div>
                        <div class="group-18">
                            <div class="text-wrapper-5">Buyer Benefits</div>
                            <div class="frame-7">
                                <div class="footer-text"><a href="{{ route('membership') }}" class="text-wrapper-7">All Benefits</a></div>
                                <div class="footer-text"><a href="{{ route('membership') }}" class="text-wrapper-7">Premium Access</a></div>
                                <div class="footer-text"><a href="{{ route('supplier') }}" class="text-wrapper-7">Verified Suppliers</a></div>
                                <div class="footer-text"><a href="{{ route('about-us') }}" class="text-wrapper-7">Quality Assurance</a></div>
                            </div>
                        </div>
                    </div>

                <!-- Suppliers Benefits Section -->
                    <div class="frame-y">
                        <div class="group-17">
                            <div class="text-wrapper-5">For Suppliers</div>
                            <div class="frame-7">
                                <div class="footer-text"><a href="/buy-leads" class="text-wrapper-7">Global Buy Leads</a></div>
                                <div class="footer-text"><a href="{{ route('products') }}" class="text-wrapper-7">Sell on Marketplace</a></div>
                                <div class="footer-text"><a href="{{ route('jobseeker') }}" class="text-wrapper-7">Jobs & Hire Talent</a></div>
                                <div class="footer-text"><a href="{{ route('tradeshow') }}" class="text-wrapper-7">Trade Shows</a></div>
                            </div>
                        </div>
                        <div class="group-18">
                            <div class="text-wrapper-5">Business Growth</div>
                            <div class="frame-7">
                                <div class="footer-text"><a href="/stock-sale" class="text-wrapper-7">Bulk Stock Sales</a></div>
                                <div class="footer-text"><a href="{{ route('dealassist') }}" class="text-wrapper-7">Startup Assistance</a></div>
                                <div class="footer-text"><a href="{{ route('dealassist') }}" class="text-wrapper-7">Rocket Growth</a></div>
                                <div class="footer-text"><a href="{{ route('contacts') }}" class="text-wrapper-7">Business Support</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of New Client Requested Footer Sections -->
                <div class="group-16 responsive-1">
                    <div class="frame-6">
                        <div class="group-17">
                            <div class="text-wrapper-5">Special</div>
                            <div class="frame-7">
                                <div class="footer-text"><a
                                        href="{{ route('products', ['data_from' => 'featured', 'page' => 1]) }}"
                                        class="text-wrapper-7">Featured Products</a></div>
                                <div class="footer-text"><a
                                        href="{{ route('products', ['data_from' => 'latest', 'page' => 1]) }}"
                                        class="text-wrapper-7">Latest Products</a></div>
                                <div class="footer-text"><a
                                        href="{{ route('products', ['data_from' => 'best-selling', 'page' => 1]) }}"
                                        class="text-wrapper-7">Best Selling Products</a></div>
                                <div class="footer-text"><a
                                        href="{{ route('products', ['data_from' => 'top-rated', 'page' => 1]) }}"
                                        class="text-wrapper-7">Top Rated Products</a></div>
                            </div>
                        </div>
                        <div class="group-18">
                            <div class="text-wrapper-5">Account info</div>
                            <div class="frame-7">
                                <div class="footer-text"><a class="text-wrapper-7"
                                        href="{{ route('user-account') }}">Profile Info</a>
                                </div>
                                <div class="footer-text"><a class="text-wrapper-7" href="{{ route('wishlists') }}">Wish
                                        list</a></div>
                                <div class="footer-text"><a class="text-wrapper-7"
                                        href="{{ route('track-order.index') }}">Track Order</a>
                                </div>
                            </div>
                        </div>
                        <div class="group-17">
                            <div class="text-wrapper-5">Quick Links</div>
                            <div class="frame-7">
                                <div class="footer-text"><a href="{{ route('products') }}"
                                        class="text-wrapper-7">All Products</a>
                                </div>
                                <div class="footer-text"><a href="{{ route('vendors') }}"
                                        class="text-wrapper-7">All Shops</a>
                                </div>
                                <div class="footer-text"><a href="{{ route('brands') }}"
                                        class="text-wrapper-7">All Brands</a></div>
                                <div class="footer-text"></div>
                            </div>
                        </div>
                        <div class="group-19">
                            <div class="text-wrapper-5">Help</div>
                            <div class="frame-7">
                                <div class="footer-text"><a href="{{ route('about-us') }}" class="text-wrapper-7">About
                                        us</a></div>
                                <div class="footer-text"><a href="{{ route('contacts') }}"
                                        class="text-wrapper-7">Contact Us</a></div>
                                <div class="footer-text"><a href="{{ route('helpTopic') }}"
                                        class="text-wrapper-7">FAQ</a></div>
                                <div class="footer-text"><a href="{{ route('account-tickets') }}"
                                        class="text-wrapper-7">Support
                                        ticket</a></div>
                            </div>
                        </div>
                    </div>
                    {{-- <img class="line-2" src="/img/line-34-2.svg" /> --}}
                    <div class="responsive-2">
                        <div class="group-20">
                            <div class="group-21">
                                <div class="text-wrapper-8">Mail Us</div>
                                <div class="group-22">
                                    <img class="img-2" src="/img/email.png" />
                                    <a href="mailto:{{ getWebConfig(name: 'company_email') }}"
                                        class="text-wrapper-9">{{ getWebConfig(name: 'company_email') }}</a>
                                </div>
                            </div>
                            <div class="group-23">
                                <div class="text-wrapper-8">Social</div>
                                <div class="frame-8">
                                    <a href="https://twitter.com" target="_blank" class="twitter"></a>
                                    <a href="https://linkedin.com" target="_blank" class="linkedin"></a>
                                    <a href="https://instagram.com" target="_blank" class="instagram"></a>
                                    <a href="https://facebook.com" target="_blank" class="facebook"></a>
                                </div>
                            </div>
                        </div>
                        <div class="group-24">
                            <div class="text-wrapper-8">Registered office address</div>
                            <div class="group-25">
                                <img class="img-2" src="/img/maps-and-flags.png" />
                                <div class="text-wrapper-9">India</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="group-26 responsive-1">
                    <div class="group-27">
                        <div class="group-10">
                            <div class="text-wrapper-5">Explore More</div>
                            <img class="line" src="/img/line-34-3.svg" />
                        </div>
                        <div class="frame-9">
                            <div class="frame-5">
                                <img class="img-3" src="/img/store.png" />
                                <a href="{{ route('vendor.auth.login') }}" class="text-wrapper-10">Become a
                                    Seller</a>
                            </div>
                            <div class="frame-5">
                                <img class="img-3" src="/img/accept.png" />
                                <a href="{{ route('terms') }}" class="text-wrapper-10">Terms &amp; Conditions</a>
                            </div>
                            <div class="frame-5" style="margin-right: 50px;">
                                <img class="img-3" src="/img/legal-document.png" />
                                <a href="{{ route('privacy-policy') }}" class="text-wrapper-10">Privacy policy</a>
                            </div>
                        </div>
                    </div>
                    <div class="group-28">
                        <div class="group-10">
                            <div class="text-wrapper-5">About Company</div>
                            <img class="line-3" src="/img/line-34-4.svg" />
                        </div>
                        <div class="frame-9">
                            <div class="frame-5">
                                <img class="img-3" src="/img/copyright.png" />
                                <div class="text-wrapper-10">{{ $web_config['copyright_text']->value }}</div>
                            </div>
                            <div class="frame-5">
                                <img class="img-3" src="/img/viber.png" />
                                <a href="tel:{{ getWebConfig(name: 'company_phone') }}"
                                    class="text-wrapper-10">{{ getWebConfig(name: 'company_phone') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script>
    document.querySelectorAll('img').forEach(img => {
        img.setAttribute('loading', 'lazy');
    });
</script>
