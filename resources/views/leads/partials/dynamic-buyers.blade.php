<div id="dynamicBuyLeads">
    @if (isset($items))
        @foreach ($items as $buyer)
            <article class="lead-card">
                <div class="lead-card-inner">
                    <div class="lead-info">
                        <div class="lead-header">
                            <h2 class="lead-title">{{ $buyer->name }}</h2>
                            @php
                                $countryDetails = \App\Utils\ChatManager::getCountryDetails($buyer->country);
                            @endphp
                            <div class="lead-location visibleonhigh">
                                <img src="/flags/{{ strtolower($countryDetails['countryISO2']) }}.svg" class="flag-icon"
                                    alt="{{ $countryDetails['countryName'] }} flag" />
                                <span>{{ $buyer->city }}, {{ $countryDetails['countryName'] }}</span>
                            </div>
                        </div>
                        <p class="lead-description">
                            {!! $buyer->details !!}
                        </p>
                        <div class="lead-location visibleonlow">
                            <img src="/flags/{{ strtolower($countryDetails['countryISO2']) }}.svg" class="flag-icon"
                                alt="{{ $countryDetails['countryName'] }} flag" />
                            <span>{{ $buyer->city }}, {{ $countryDetails['countryName'] }}</span>
                        </div>
                        <div class="lead-tags">
                            <span class="lead-tags-label">Tags:</span>
                            <span class="lead-tags-content">{{ $buyer->tags ?? 'N/A' }}</span>
                        </div>
                        <div class="lead-details">
                            <div class="detail-group">
                                <div class="detail-row">
                                    <span class="detail-label">Quantity Required:</span>
                                    <span class="detail-value">{{ $buyer->quantity_required ?? 'N/A' }}
                                        {{ $buyer->unit ?? 'N/A' }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">Refundable:</span>
                                    <span class="detail-value">{{ $buyer->refund ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="detail-group">
                                <div class="detail-row">
                                    <span class="detail-label">Term:</span>
                                    <span class="detail-value">{{ $buyer->term ?? 'N/A' }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">Available Stock:</span>
                                    <span class="detail-value">{{ $buyer->avl_stock ?? 'N/A' }}
                                        {{ $buyer->avl_stock_unit ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="detail-group">
                                <div class="detail-row">
                                    <span class="detail-label">Lead Time:</span>
                                    <span class="detail-value">{{ $buyer->lead_time ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="lead-actions">
                        @php
                            $user = auth('customer')->user();
                            if ($user) {
                                $isFavourite = \App\Utils\HelperUtil::checkIfFavourite($buyer->id, $user->id);
                            } else {
                                $isFavourite = false;
                            }
                        @endphp
                        @if (auth('customer')->user())
                            <img class="heart favourite-img" onclick="makeFavourite(this)"
                                data-id="{{ $buyer->id }}" data-userid="{{ $user->id }}" data-type="buyleads"
                                data-role="{{ auth()->user()->role ?? 'customer' }}"
                                src="{{ $isFavourite ? theme_asset('public/img/Heart (2).png') : theme_asset('public/img/Heart (1).png') }}"
                                width="20" alt="Featured icon" style="margin-left: auto;">
                        @else
                            <img class="heart favourite-img" onclick="sendtologin()"
                                src="{{ theme_asset('public/img/Heart (1).png') }}" width="20" alt="Featured icon"
                                style="margin-left: auto;">
                        @endif
                        <button class="contact-btn" data-toggle="modal" data-target="#inquireButton{{ $buyer->id }}">Contact Buyer</button>
                        <div class="lead-posted">Posted: {{ $buyer->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            </article>
            <!-- Modal -->
            <div class="modal fade" id="inquireButton{{ $buyer->id }}" tabindex="-1" role="dialog"
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
                                        if ($buyer->role === 'seller') {
                                            $seller = \App\Models\Seller::find($buyer->added_by);
                                            $shopName = $buyer->shop->name ?? 'N/A';
                                            $shopAddress = $buyer->shop->address ?? 'N/A';
                                            $countryDetails = \App\Utils\ChatManager::getCountryDetails($buyer->country);
                                            if($countryDetails){
                                                $flagImage = 1;
                                            }
                                        } elseif ($buyer->role === 'admin') {
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
                                        value={{ $buyer->added_by }}>
                                    <input type="hidden" id="receiver_type" name="receiver_type"
                                        value={{ $buyer->role }}>
                                    <input type="hidden" id="type" name="type" value="buyleads">
                                    <input type="hidden" id="buyer_id" name="buyer_id"
                                        value={{ $buyer->id }}>

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
                                            <button type="button" onclick="triggerChat()" class="btn-inquire-now">Send Inquiry Now</button>
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
