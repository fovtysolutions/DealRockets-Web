<!-- Product Cards -->
<div id="dynamicSellLeads">
    @if (isset($items))
        @foreach ($items as $seller)
            <div class="product-card">
                <div class="product-image-col">
                    <h3 class="product-title">{{ $seller->name }}</h3>
                    <div>
                        <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/247ec7c7bc1f6428f4d5acb3c10d89df21f5e0ba?placeholderIfAbsent=true"
                            alt="${product.title}" class="product-image">
                    </div>
                    <div class="product-location">
                        @php
                            $countryDetails = \App\Utils\ChatManager::getCountryDetails($seller->country);
                        @endphp
                        <div>Location:</div>
                        <div>
                            <img src="/flags/{{ strtolower($countryDetails['countryISO2']) }}.svg" class="flag-icon"
                                alt="{{ $countryDetails['countryName'] }} flag" />
                            <span>{{ $seller->city }}, {{ $countryDetails['countryName'] }}</span>
                        </div>
                    </div>
                    <div class="view-detail-btn-hide">
                        <button class="view-detail-btn" data-index="${index}" data-target="#productDetailModal"
                            data-toggle="modal">View Details</button>
                    </div>
                </div>
                <div class="product-details-col hidebelow926">
                    <table class="detail-table">
                        <tr>
                            <td class="detail-label">Rate</td>
                            <td class="detail-value">$100 <span class="unit">/Piece</span></td>
                        </tr>
                        <tr>
                            <td class="detail-label">Size</td>
                            <td class="detail-value">{{ $seller->size ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="detail-label">Type</td>
                            <td class="detail-value">{{ $seller->offer_type ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="detail-label">Terms</td>
                            <td class="detail-value">{{ $seller->term ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="detail-label">Payment</td>
                            <td class="detail-value">{{ $seller->payment_option ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="detail-label">Brand</td>
                            <td class="detail-value">{{ $seller->brand ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="hidebelow926 contact-seller-col">
                    @php
                        $user = auth('customer')->user();
                        if ($user) {
                            $isFavourite = \App\Utils\HelperUtil::checkIfFavourite($seller->id, $user->id);
                        } else {
                            $isFavourite = false;
                        }
                    @endphp
                    @if (auth('customer')->user())
                        <img class="heart favourite-img" onclick="makeFavourite(this)" data-id="{{ $seller->id }}"
                            data-userid="{{ $user->id }}" data-type="saleoffer"
                            data-role="{{ auth()->user()->role ?? 'customer' }}"
                            src="{{ $isFavourite ? theme_asset('public/img/Heart (2).png') : theme_asset('public/img/Heart (1).png') }}"
                            width="20" alt="Featured icon" style="margin-left: auto;">
                    @else
                        <img class="heart favourite-img" onclick="sendtologin()"
                            src="{{ theme_asset('public/img/Heart (1).png') }}" width="20" alt="Featured icon"
                            style="margin-left: auto;">
                    @endif
                    @php
                        $flagImage = 0;
                        if ($seller->role === 'seller') {
                            $seller = \App\Models\Seller::find($seller->added_by);
                            $shopName = $seller->shop->name ?? 'N/A';
                            $shopAddress = $seller->shop->address ?? 'N/A';
                            $countryDetails = \App\Utils\ChatManager::getCountryDetails($seller->country);
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
                    <button class="contact-btn" data-toggle="modal"
                        data-target="#inquireButton{{ $seller->id }}">Contact Seller</button>
                    <div class="seller-name">{{ $shopName }}</div>
                    <div class="company-name">{{ $shopAddress }}</div>
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
                                <form id="inquiryForm">
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
                                    <input type="hidden" id="sender_type" name="sender_type"
                                        value={{ $role }}>
                                    <input type="hidden" id="receiver_id" name="receiver_id"
                                        value={{ $seller->added_by }}>
                                    <input type="hidden" id="receiver_type" name="receiver_type"
                                        value={{ $seller->role }}>
                                    <input type="hidden" id="type" name="type" value="sellleads">
                                    <input type="hidden" id="buyer_id" name="buyer_id" value={{ $seller->id }}>

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
                                            placeholder="Enter product details such as color, size, materials and other specific requirements." rows="6"
                                            required></textarea>
                                    </div>
                                    @if (auth('customer')->check())
                                        @if (strtolower(trim($membership['status'] ?? '')) == 'active')
                                            <button type="button" onclick="triggerChat()"class="btn-inquire-now">Send Inquiry Now</button>
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
        <p>No Data</p>
    @endif
</div>
