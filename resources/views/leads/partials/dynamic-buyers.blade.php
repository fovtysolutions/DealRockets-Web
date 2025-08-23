<div id="dynamicBuyLeads">
    @if (isset($items) && $items->isNotEmpty())
        @foreach ($items as $buyer)
            <article class="lead-card">
                <div class="lead-card-inner">
                    <div class="d-flex lead-card-inner-div" >
                        <div class="lead-info">
                            <div class="lead-header">
                                <h2 class="lead-title custom-dealrock-text-18">{{ $buyer->product->name ?? $buyer->product_id }}</h2>
                                  @php
                            $user = auth('customer')->user();
                            if ($user) {
                                $isFavourite = \App\Utils\HelperUtil::checkIfFavourite(
                                    $buyer->id,
                                    $user->id,
                                    'buyleads',
                                );
                            } else {
                                $isFavourite = false;
                            }
                        @endphp
                        @if (auth('customer')->user())
                            <img class="heart mobile-heart favourite-img" onclick="makeFavourite(this)"
                                data-id="{{ $buyer->id }}" data-userid="{{ $user->id }}" data-type="buyleads"
                                data-role="{{ auth()->user()->role ?? 'customer' }}"
                                src="{{ $isFavourite ? theme_asset('public/img/Heart (2).png') : theme_asset('public/img/Heart (1).png') }}"
                                width="20" alt="Featured icon" style="margin-left: auto;">
                        @else
                            <img class="heart mobile-heart favourite-img" onclick="sendtologin()"
                                src="{{ theme_asset('public/img/Heart (1).png') }}" width="20" alt="Featured icon"
                                style="margin-left: auto;">
                        @endif
                                @php
                                    $countryDetails = \App\Utils\ChatManager::getCountryDetails($buyer->country);
                                @endphp
                                <div class="lead-location visibleonhigh">
                                    <img src="/flags/{{ strtolower($countryDetails['countryISO2']) }}.svg"
                                        class="flag-icon" alt="{{ $countryDetails['countryName'] }} flag" />
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
                                <span class="lead-tags-label custom-dealrock-text-14">Tags:</span>
                                <span class="lead-tags-content custom-dealrock-text-14">{{ $buyer->tags ?? 'N/A' }}</span>
                            </div>
                        </div>
                     
                        
                        <div class="overflow-div">
                           <div class="lead-details-table-wrapper">
    <div class="lead-details-table">
        <table class="detail-table">
            <tr>
                <td class="detail-label custom-dealrock-text-14">Quantity</td>
                <td class="detail-value text-truncate custom-dealrock-text-14">{{ $buyer->quantity_required ?? 'N/A' }} {{ $buyer->unit ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="detail-label custom-dealrock-text-14">Term</td>
                <td class="detail-value text-truncate custom-dealrock-text-14">{{ $buyer->term ?? 'N/A' }}</td>
            </tr>
        </table>
        <table class="detail-table">
            <tr>
                <td class="detail-label custom-dealrock-text-14">Payment Term</td>
                <td class="detail-value text-truncate custom-dealrock-text-14">{{ $buyer->payment_option ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="detail-label custom-dealrock-text-14">Lead Time</td>
                <td class="detail-value text-truncate custom-dealrock-text-14">{{ $buyer->lead_time ?? 'N/A' }}</td>
            </tr>
        </table>
        <table class="detail-table">
            <tr>
                <td class="detail-label custom-dealrock-text-14">POD</td>
                <td class="detail-value text-truncate-2 custom-dealrock-text-14">{{ $buyer->port_of_loading ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="detail-label custom-dealrock-text-14">Packing</td>
                <td class="detail-value text-truncate-2 custom-dealrock-text-14">{{ $buyer->packing_type ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>
</div>

                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="lead-actions">
                        @php
                            $user = auth('customer')->user();
                            if ($user) {
                                $isFavourite = \App\Utils\HelperUtil::checkIfFavourite(
                                    $buyer->id,
                                    $user->id,
                                    'buyleads',
                                );
                            } else {
                                $isFavourite = false;
                            }
                        @endphp
                        @if (auth('customer')->user())
                            <img class="heart favourite-img mobile-hide" onclick="makeFavourite(this)"
                                data-id="{{ $buyer->id }}" data-userid="{{ $user->id }}" data-type="buyleads"
                                data-role="{{ auth()->user()->role ?? 'customer' }}"
                                src="{{ $isFavourite ? theme_asset('public/img/Heart (2).png') : theme_asset('public/img/Heart (1).png') }}"
                                width="20" alt="Featured icon" style="margin-left: auto;">
                        @else
                            <img class="heart favourite-img mobile-hide" onclick="sendtologin()"
                                src="{{ theme_asset('public/img/Heart (1).png') }}" width="20" alt="Featured icon"
                                style="margin-left: auto;">
                        @endif
                        <button class="filled-btn mt-0" style=" align-self: center; !important"  data-toggle="modal"
                            data-target="#inquireButton{{ $buyer->id }}">Contact Buyer</button>
                        <div class="lead-posted custom-dealrock-text-14">Posted: {{ $buyer->created_at->diffForHumans() }}</div>
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
                                <form id="inquiryForm" method="POST" action="{{ route('sendmessage.other') }}"
                                    enctype="application/x-www-form-urlencoded">
                                    @csrf
                                    @php
                                        $flagImage = 0;
                                        if ($buyer->role === 'seller') {
                                            $seller = \App\Models\Seller::find($buyer->added_by);
                                            $shopName = $buyer->shop->name ?? 'N/A';
                                            $shopAddress = $buyer->shop->address ?? 'N/A';
                                            $countryDetails = \App\Utils\ChatManager::getCountryDetails(
                                                $buyer->country,
                                            );
                                            if ($countryDetails) {
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
                                    <input type="hidden" id="leads_id" name="leads_id" value={{ $buyer->id }}>

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
                                            <button type="submit" class="filled-btn">Send Inquiry Now</button>
                                        @else
                                            <a href="{{ route('membership') }}" class="filled-btn">Send Inquiry
                                                Now</a>
                                        @endif
                                    @else
                                        <button type="button" onclick="sendtologin()" class="filled-btn">Send
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
            <h3>No Buyers Found</h3>
            <p>Try adjusting your search filters or check back later for new listings.</p>
        </div>
    @endif
</div>
