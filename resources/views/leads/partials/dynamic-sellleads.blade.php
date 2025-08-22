<!-- Product Cards -->
<div id="dynamicSellLeads">
    @if (isset($items) && $items->isNotEmpty())
        @foreach ($items as $seller)
            @php
                $user = auth('customer')->user();
                if ($user) {
                    $isFavourite = \App\Utils\HelperUtil::checkIfFavourite($seller->id, $user->id, 'saleoffer');
                } else {
                    $isFavourite = false;
                }
            @endphp
            <div class="product-card"
                style="display: flex; border: 1px solid #ddd; border-radius: 8px; padding: 15px; align-items: flex-start; gap: 15px;">

                <!-- Left: Product Image -->
                <div class="product-image-col image-box" style="flex: 0 0 200px;">
                    <img  src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/247ec7c7bc1f6428f4d5acb3c10d89df21f5e0ba?placeholderIfAbsent=true"
                        alt="{{ $seller->product->name ?? 'Product' }}" style="width: 100%; border-radius: 6px; ">
                </div>

                <!-- Right: Product Details -->
                <div class="product-details-col"
                    style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">

                    <!-- Title + Location + Seller -->
                    <div>
                        <h3 class="product-title" class="custom-dealrock-text-18"
                            style="margin: 0; font-size: 1.1rem; font-weight: bold;">
                            {{ $seller->product->name ?? $seller->product_id }}
                        </h3>

                        <div class="custom-dealrock-text-14 my-2">
                            @php
                                $countryDetails = \App\Utils\ChatManager::getCountryDetails($seller->country);
                            @endphp
                            <img src="/flags/{{ strtolower($countryDetails['countryISO2']) }}.svg"
                                style="width: 16px; height: 12px; margin-right: 4px;" />
                            <span>{{ $seller->city }}, {{ $countryDetails['countryName'] }}</span>
                        </div>
                        <div class="hidebelow926 contact-seller-col my-3">
                            <div>
                                {{-- Supporting Div --}}
                            </div>
                            @php
                                $flagImage = 0;
                                if ($seller->role === 'seller') {
                                    $seller = \App\Models\Seller::find($seller->added_by);
                                    $sellerName = $seller->name ?? 'N/A';
                                    $shopName = $seller->shop->name ?? 'N/A';
                                    $shopAddress = $seller->shop->address ?? 'N/A';
                                    $countryDetails = \App\Utils\ChatManager::getCountryDetails($seller->country);
                                    if ($countryDetails) {
                                        $flagImage = 1;
                                    }
                                } elseif ($seller->role === 'admin') {
                                    $shopName = 'Admin Shop';
                                    $sellerName = 'Admin';
                                    $shopAddress = 'Admin Address';
                                }
                            @endphp
                            @php
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
                                    <!-- <div class="avatar-placeholder"></div> -->
                                </div>

                                <!-- <p><strong>Email:</strong>
                                                            @if (auth()->check())
                                                                <span class="contact-text">
                                                                    {{ $shopInfoArray['company_profiles']->email ?? 'N/A' }}
                                                                </span>
                                                            @else
                                                                <button class="sign-in-btn">Sign In for Email</button>
                                                            @endif
                                                        </p> -->

                            </div>
                            <div>
                                <p>
                                    <!-- <strong class="detail-label-fixed1">Rate</strong> -->
                                    <span class="contact-text ">
                                        <span class="custom-dealrock-text-18">
                                            {{ $seller->rate ?? 'N/A' }}
                                        </span>

                                        <span class="unit custom-dealrock-text-14" style="color: #515050;">/Piece</span>
                                    </span>
                                </p>
                            </div>

                        </div>
                        <div class="product-details-col hidebelow926">
                            <div class="details-flex-container">
                                <!-- Left Column -->
                                <div class="details-column">
                                    
                                        <p><strong class="detail-label-fixed">Type</strong>
                                            <span class="contact-text">{{ $seller->offer_type ?? 'N/A' }}</span>
                                        </p>
                                        <p><strong class="detail-label-fixed">Terms</strong>
                                            <span class="contact-text">{{ $seller->delivery_terms ?? 'N/A' }}</span>
                                        </p>
                                        <p><strong class="detail-label-fixed">Payment</strong>
                                            <span class="contact-text">{{ $seller->payment_option ?? 'N/A' }}</span>
                                        </p>
                                    
                                </div>

                                <!-- Right Column -->
                                <div class="details-column">
                                    
                                        <p><strong class="detail-label-fixed1">Brand</strong>
                                            <span class="contact-text">{{ $seller->brand ?? 'N/A' }}</span>
                                        </p>
                                        <p><strong class="detail-label-fixed1">Rate</strong>
                                            <span class="contact-text">
                                                {{ $seller->rate ?? 'N/A' }}
                                                <span class="unit">/Piece</span>
                                            </span>
                                        </p>
                                        <p><strong class="detail-label-fixed1">Size</strong>
                                            <span class="contact-text">{{ $seller->size ?? 'N/A' }}</span>
                                        </p>
                                 
                                </div>
                            </div>
                        </div>

                    </div>


                </div>

                <div class="product-details-col" style="gap:3rem;">
                    <img class="heart favourite-img mobile-hide" onclick="sendtologin()"
                        src="https://www.dealrockets.com/img/Heart (1).png" width="20" alt="Featured icon"
                        style="margin-left: auto;">
                    <button class="filled-btn" data-toggle="modal" data-target="#inquireButton{{ $seller->id }}">
                        Contact Seller
                    </button>
                    <div class="custom-dealrock-text-14" style="color: #515050;">
                        Posted: {{ $seller->created_at->diffForHumans() }}

                    </div>


                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="inquireButton{{ $seller->id }}" tabindex="-1" role="dialog"
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
                                    @php
                                        $flagImage = 0;
                                        if ($seller->role === 'seller') {
                                            $seller = \App\Models\Seller::find($seller->added_by);
                                            $shopName = $seller->shop->name ?? 'N/A';
                                            $shopAddress = $seller->shop->address ?? 'N/A';
                                            $countryDetails = \App\Utils\ChatManager::getCountryDetails(
                                                $seller->country,
                                            );
                                            if ($countryDetails) {
                                                $flagImage = 1;
                                            }
                                        } elseif ($seller->role === 'admin') {
                                            $shopName = 'Admin Shop';
                                            $shopAddress = 'Admin Address';
                                        }
                                    @endphp
                                    @php
                                        $userdata = \App\Utils\ChatManager::getRoleDetail();
                                        $userId = $userdata['user_id'] ?? null;
                                        $role = $userdata['role'] ?? null;
                                    @endphp
                                    <!-- Hidden fields -->
                                    <input type="hidden" id="sender_id" name="sender_id" value={{ $userId }}>
                                    <input type="hidden" id="sender_type" name="sender_type" value={{ $role }}>
                                    <input type="hidden" id="receiver_id" name="receiver_id" value={{ $seller->added_by }}>
                                    <input type="hidden" id="receiver_type" name="receiver_type" value={{ $seller->role }}>
                                    <input type="hidden" id="type" name="type" value="sellleads">
                                    <input type="hidden" id="leads_id" name="leads_id" value={{ $seller->id }}>

                                    <!-- Visible fields -->
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
                                            <a href="{{ route('membership') }}" class="btn-inquire-now">Send Inquiry
                                                Now</a>
                                        @endif
                                    @else
                                        <button type="button" onclick="sendtologin()" class="btn-inquire-now">Send
                                            Inquiry Now</button>
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