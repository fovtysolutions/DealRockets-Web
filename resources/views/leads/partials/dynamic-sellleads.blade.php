<!-- Product Cards -->
<div id="dynamicSellLeads">
    @if (isset($items) && $items->isNotEmpty())
        @foreach ($items as $sellunit)
            @php
                $user = auth('customer')->user();
                $isFavourite = $user ? \App\Utils\HelperUtil::checkIfFavourite($sellunit->id, $user->id, 'saleoffer') : false;

                // Decode images (in case it's JSON in DB)
                $images = is_array($sellunit->images) ? $sellunit->images : json_decode($sellunit->images, true);
            @endphp

            <div class="product-card"
                style="display: flex; border: 1px solid #ddd; border-radius: 8px; padding: 15px; align-items: flex-start; gap: 15px;">

                <!-- Left: Product Images Carousel -->
                <div class="product-image-col image-box" style="flex: 0 0 200px;">
                    <div class="owl-carousel owl-theme">
                        @foreach ($images as $img)
                            <div class="item">
                                <img src="{{ asset($img) }}"
                                     alt="{{ $sellunit->product->name ?? 'Product' }}"
                                     onerror="this.onerror=null;this.src='/images/placeholderimage.webp';"
                                     style="width: 100%; border-radius: 6px;">
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Right: Product Details -->
                <div class="product-details-col"
                    style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">

                    <!-- Title + Location + Seller -->
                    <div>
                        <h3 class="product-title custom-dealrock-text-18"
                            style="margin: 0; font-size: 1.1rem; font-weight: bold;">
                            {{ $sellunit->product->name ?? $sellunit->product_id }}
                        </h3>

                        <div class="custom-dealrock-text-14 my-2">
                            @php
                                $countryDetails = \App\Utils\ChatManager::getCountryDetails($sellunit->country);
                            @endphp
                            <img src="/flags/{{ strtolower($countryDetails['countryISO2']) }}.svg"
                                style="width: 16px; height: 12px; margin-right: 4px;" />
                            <span>{{ $sellunit->city }}, {{ $countryDetails['countryName'] }}</span>
                        </div>

                        <!-- Seller Info -->
                        <div class="hidebelow926 contact-seller-col my-3">
                            @php
                                $flagImage = 0;
                                $sellerName = 'N/A';
                                $shopName = 'N/A';
                                $shopAddress = 'N/A';

                                if ($sellunit->role === 'seller') {
                                    $sellerModel = \App\Models\Seller::find($sellunit->added_by);
                                    $sellerName = $sellerModel->f_name ?? 'N/A';
                                    $shopName = $sellerModel->shop->name ?? 'N/A';
                                    $shopAddress = $sellerModel->shop->address ?? 'N/A';
                                    $countryDetails = \App\Utils\ChatManager::getCountryDetails($sellerModel->country);
                                    if ($countryDetails) {
                                        $flagImage = 1;
                                    }
                                } elseif ($sellunit->role === 'admin') {
                                    $shopName = 'Admin Shop';
                                    $sellerName = 'Admin';
                                    $shopAddress = 'Admin Address';
                                }

                                $userdata = \App\Utils\ChatManager::getRoleDetail();
                                $userId = $userdata['user_id'] ?? null;
                                $role = $userdata['role'] ?? null;
                            @endphp

                            <div class="contact-right">
                                <div class="contact-person">
                                    <div class="text-end">
                                        <div class="d-flex">
                                            <i class="fa-regular fa-user"></i>
                                            <p class="company-name m-0 custom-dealrock-text-14" style="color: #515050;">
                                                {{ $sellerName }}
                                            </p>
                                        </div>

                                        <p class="seller-name custom-dealrock-text-14" style="color: #515050;">
                                            {{ $shopName }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <p>
                                    <span class="contact-text ">
                                        <span class="custom-dealrock-text-18">
                                            {{ $sellunit->rate ?? 'N/A' }}
                                        </span>
                                        <span class="unit custom-dealrock-text-14" style="color: #515050;">/Piece</span>
                                    </span>
                                </p>
                            </div>
                        </div>

                        <!-- Extra Product Details -->
                        <div class="product-details-col hidebelow926">
                            <div class="details-flex-container">
                                <div class="details-column">
                                    <p><strong class="detail-label-fixed">Type</strong>
                                        <span class="contact-text">{{ $sellunit->offer_type ?? 'N/A' }}</span>
                                    </p>
                                    <p><strong class="detail-label-fixed">Terms</strong>
                                        <span class="contact-text">{{ $sellunit->delivery_terms ?? 'N/A' }}</span>
                                    </p>
                                    <p><strong class="detail-label-fixed">Payment</strong>
                                        <span class="contact-text">{{ $sellunit->payment_option ?? 'N/A' }}</span>
                                    </p>
                                </div>
                                <div class="details-column">
                                    <p><strong class="detail-label-fixed1">Brand</strong>
                                        <span class="contact-text">{{ $sellunit->brand ?? 'N/A' }}</span>
                                    </p>
                                    <p><strong class="detail-label-fixed1">Rate</strong>
                                        <span class="contact-text">
                                            {{ $sellunit->rate ?? 'N/A' }}
                                            <span class="unit">/Piece</span>
                                        </span>
                                    </p>
                                    <p><strong class="detail-label-fixed1">Size</strong>
                                        <span class="contact-text">{{ $sellunit->size ?? 'N/A' }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side Actions -->
                <div class="product-details-col" style="gap:3rem;">
                    <img class="heart favourite-img mobile-hide" onclick="sendtologin()"
                        src="https://www.dealrockets.com/img/Heart (1).png" width="20" alt="Featured icon"
                        style="margin-left: auto;">
                    <button class="filled-btn" data-toggle="modal" data-target="#inquireButton{{ $sellunit->id }}">
                        Contact Seller
                    </button>
                    <div class="custom-dealrock-text-14" style="color: #515050;">
                        Posted: {{ $sellunit->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="inquireButton{{ $sellunit->id }}" tabindex="-1" role="dialog"
                aria-labelledby="inquireButtonLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="inquiry-form">
                            <div class="inquiry-header">
                                Send a direct inquiry to this supplier
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                    style="margin: auto !important;">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="inquiry-body">
                                <form id="inquiryForm" method="POST" action="{{ route('sendmessage.other') }}"
                                    enctype="application/x-www-form-urlencoded">
                                    @csrf
                                    <input type="hidden" id="sender_id" name="sender_id" value={{ $userId }}>
                                    <input type="hidden" id="sender_type" name="sender_type" value={{ $role }}>
                                    <input type="hidden" id="receiver_id" name="receiver_id" value={{ $sellunit->added_by }}>
                                    <input type="hidden" id="receiver_type" name="receiver_type" value={{ $sellunit->role }}>
                                    <input type="hidden" id="type" name="type" value="sellleads">
                                    <input type="hidden" id="leads_id" name="leads_id" value={{ $sellunit->id }}>

                                    <div class="form-group">
                                        <label for="supplier">To</label>
                                        <div class="supplier-name-field">{{ $shopName }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">E-mail Address</label>
                                        <input type="email" id="email" name="email"
                                            placeholder="Please enter your business e-mail address" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="message">Message</label>
                                        <textarea id="message" name="message"
                                            placeholder="Enter product details such as color, size, materials and other specific requirements."
                                            rows="6" required></textarea>
                                    </div>
                                    @if (auth('customer')->check())
                                        @if (strtolower(trim($membership['status'] ?? '')) == 'active')
                                            <button type="submit" class="btn-inquire-now">Send Inquiry Now</button>
                                        @else
                                            <a href="{{ route('membership') }}" class="btn-inquire-now">Send Inquiry Now</a>
                                        @endif
                                    @else
                                        <button type="button" onclick="sendtologin()" class="btn-inquire-now">Send Inquiry Now</button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="no-data-container" style="text-align: center; padding: 40px 20px;">
            <h3>No Sellers Found</h3>
            <p>Try adjusting your search filters or check back later for new listings.</p>
        </div>
    @endif
</div>

<!-- Owl Carousel CSS/JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
$(document).ready(function(){
    $('.owl-carousel').owlCarousel({
        items:1,
        loop:true,
        margin:10,
        nav:true,
        dots:true,
        autoplay:true,
        autoplayTimeout:3000,
        autoplayHoverPause:true
    });
});
</script>
