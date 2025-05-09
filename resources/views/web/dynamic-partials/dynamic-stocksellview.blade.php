<div class="detail-content">
    <div id="content-stock-photo" class="detail-tab-content active">
        <div class="detail-title">
            {{ $stocksell->name ?? 'N/A' }}
            <div class="text-muted">
                <img src="{{ asset('img/Ellipse 75.png') }}" alt="dot" style="height: 5px;">
                @php
                    $stock_type_data = \App\Models\StockCategory::where('id',$stocksell->stock_type)->first();
                    if($stock_type_data){
                        $stock_type = $stock_type_data->name;
                    } else {
                        $stock_type = 'N/A';
                    }
                @endphp
                <small>{{ $stock_type ?? 'N/A' }}</small>
            </div>
        </div>
        @php
            $images = json_decode($stocksell->image); // Adjust this if you're using JSON or a relation
        @endphp

        <div class="owl-carousel details-carousel owl-theme">
            @foreach($images as $image)
                <div class="item">
                    <img src="/{{ $image }}" class="detail-image" alt="StockSell Image">
                </div>
            @endforeach
        </div>

        <div class="detail-description">
            {!! $stocksell->description ?? 'N/A' !!}
        </div>
    </div>
    <div id="content-specification" class="detail-tab-content custom-info">
        <div class="detail-title">Stock Specifications</div>
        <div class="detail-description">
            {!! $stocksell->description ?? 'N/A' !!}
        </div>
        <div class="product-info">
            <table>
              <tbody>
                <tr class="row-even">
                  <td class="label">Name of Product</td>
                  <td class="value">
                    <div class="value-with-icon">
                      {{ $stocksell->product->name ?? 'N/A' }}
                    </div>
                  </td>
                </tr>
                <tr class="row-odd">
                  <td class="label">Type</td>
                  <td class="value">
                    <div class="value-with-icon">
                        {{ $stocksell->product->product_type ?? 'N/A' }}
                    </div>
                  </td>
                </tr>
                <tr class="row-even">
                  <td class="label">Origin</td>
                  <td class="value">
                    <div class="value-with-icon">
                        @php
                            $origin = $stocksell->product->origin ?? null;
                            if (isset($origin)){
                                $origin = $stocksell->product->origin;
                                if (is_numeric($origin)) {
                                    $country = \App\Models\Country::find($origin);
                                    $country_name = $country ? $country->name : 'N/A';
                                } else {
                                    $country_name = $origin ?: 'N/A';
                                }
                            } else {
                                $country_name = 'N/A';
                            }
                        @endphp
                        {{ $country_name }}
                    </div>
                  </td>
                </tr>
                <tr class="row-odd">
                  <td class="label">Badge</td>
                  <td class="value">
                    <div class="value-with-icon">
                        {{ $stocksell->product->badge ?? 'N/A' }}
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
        </div>
    </div>
    <div id="content-deal" class="detail-tab-content custom-info">
        <div class="detail-title">Deal Information</div>
        <div class="product-info">
            <table>
              <tbody>
                <tr class="row-even">
                  <td class="label">Name of Product</td>
                  <td class="value">
                    <div class="value-with-icon">
                        {{ $stocksell->product->name ?? 'N/A' }}
                    </div>
                  </td>
                </tr>
                <tr class="row-odd">
                  <td class="label">Type</td>
                  <td class="value">
                    <div class="value-with-icon">
                        {{ $stocksell->product->product_type ?? 'N/A' }}
                    </div>
                  </td>
                </tr>
                <tr class="row-even">
                    <td class="label">Refundable</td>
                    <td class="value">
                      <div class="value-with-icon">
                        {{ $stocksell->refundable ?? 'N/A' }}
                      </div>
                    </td>
                  </tr>
                  <tr class="row-odd">
                    <td class="label">Avaliable Stock</td>
                    <td class="value">
                      <div class="value-with-icon">
                            {{ $stocksell->product->current_stock ?? 'N/A' }} / {{ $stocksell->unit ?? 'N/A' }}
                      </div>
                    </td>
                  </tr>
                  <tr class="row-even">
                      <td class="label">Min. Order Quantity</td>
                      <td class="value">
                        <div class="value-with-icon">
                            {{ $stocksell->quantity ?? 'N/A' }}  {{ $stocksell->unit ?? 'N/A' }}
                        </div>
                      </td>
                    </tr>
                    <tr class="row-odd">
                      <td class="label">Shipping Cost</td>
                      <td class="value">
                        <div class="value-with-icon">
                          {{ $stocksell->product->shipping_cost ?? 'N/A' }}
                        </div>
                      </td>
                    </tr>
              </tbody>
            </table>
        </div>
    </div>
    @php
        if($stocksell->role == 'admin'){
            $vendorData = \App\Models\Admin::where('id',$stocksell->user_id)->first();
        }
        else if($stocksell->role == 'seller'){
            $vendorData = \App\Models\Seller::where('id',$stocksell->user_id)->first();
        } else {
            $vendorData = [];
        }
    @endphp
    <div id="content-contact" class="detail-tab-content custom-contact">
        <div class="detail-title">Contact Information</div>
        <div class="detail-description">For any inquiries, you can reach us at:</div>

        <div class="contact-grid">
            <div class="contact-item">
              <div class="icon-container">
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                  <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                </svg>
              </div>
              <div class="contact-info">
                <p>Email</p>
                <p><a href="mailto:{{ isset($vendorData->email) ? $vendorData->email : '' }}">{{ $vendorData->email ?? 'N/A' }}</a></p>
              </div>
            </div>
            
            <div class="contact-item">
              <div class="icon-container">
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                </svg>
              </div>
              <div class="contact-info">
                <p>Phone</p>
                <p>{{ $vendorData->phone ?? 'N/A' }}</p>
              </div>
            </div>
            
            <div class="contact-item">
              <div class="icon-container">
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                  <circle cx="12" cy="10" r="3"></circle>
                </svg>
              </div>
              <div class="contact-info">
                <p>Address</p>
                <p>{{ $vendorData->shop->address ?? 'N/A' }}</p>
              </div>
            </div>
            
            <div class="contact-item">
              <div class="icon-container">
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect width="20" height="14" x="2" y="3" rx="2"></rect>
                  <path d="M2 7h20"></path>
                  <path d="M16 21V7"></path>
                  <path d="M8 21V7"></path>
                </svg>
              </div>
                @php
                    $category_type_data = \App\Models\Category::where('id',$stocksell->industry)->first();
                    if($category_type_data){
                        $category_type = $category_type_data->name;
                    } else {
                        $category_type = 'N/A';
                    }
                @endphp
              <div class="contact-info">
                <p>Industry</p>
                <p>{{ $category_type }}</p>
              </div>
            </div>
          </div>

    </div>
</div>
<div class="detail-footer">
    <div class="company-info">
        <div class="company-rating">
            @php
                $overallRating = null;

                if ($stocksell->role === 'seller') {
                    $user = \App\Models\Seller::with('product.reviews')->find($stocksell->user_id);
                } elseif ($stocksell->role === 'admin') {
                    $user = \App\Models\Admin::with('product.reviews')->find($stocksell->user_id);
                }

                if (isset($user) && $user->product->isNotEmpty()) {
                    $allReviews = $user->product->flatMap(fn($product) => $product->reviews);
                    $total = $allReviews->sum('rating');
                    $count = $allReviews->count();
                    $overallRating = $count > 0 ? round($total / $count, 1) : 0;
                }
            @endphp
            <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/9dcf86845a5774a466c010f69a48d3bed069ce99?placeholderIfAbsent=true"
                width="25" alt="Company logo">
            <div class="rating-badge">
                <i class="fa fa-star" aria-hidden="true" style="color:rgba(255, 166, 0, 1);"></i>
                <div>{{ $overallRating }}/5</div>
            </div>
        </div>
        @php
            $flagImage = 0;
            if ($stocksell->role === 'seller') {
                $seller = \App\Models\Seller::find($stocksell->user_id);
                $shopName = $seller->shop->name;
                $shopAddress = $seller->shop->address;
                $countryDetails = \App\Utils\ChatManager::getCountryDetails($seller->country);
                if($countryDetails){
                    $flagImage = 1;
                }
            } elseif ($stocksell->role === 'admin') {
                $shopName = 'Admin Shop';
                $shopAddress = 'Admin Address';
            }
        @endphp
        <div class="company-name">{{ $shopName }}</div>
        <div class="company-exhibitions">Exhibited at 2 GS shows</div>
        <div class="company-location">
            @if($flagImage == 1 && isset($countryDetails['countryISO2']))
                <img src="/flags/{{ strtolower($countryDetails['countryISO2']) }}.svg"
                    width="15" alt="Location icon">
            @endif
            <div>{{ $shopAddress }}</div>
        </div>
    </div>

    <button class="inquire-button" data-toggle="modal" data-target="#inquireButton">Inquire Now</button>
</div>
<!-- Modal -->
<div class="modal fade" id="inquireButton" tabindex="-1" role="dialog" aria-labelledby="inquireButtonLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="inquiry-form">
        <div class="inquiry-header">
          Send a direct inquiry to this supplier
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin: auto !important;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="inquiry-body">
          <form id="inquiryForm">
            @csrf
            @php
              $userdata = \App\Utils\ChatManager::getRoleDetail();
              $userId = $userdata['user_id'] ?? null;
              $role = $userdata['role'] ?? null;
            @endphp
            <!-- Hidden fields -->
            <input type="hidden" id="sender_id" name="sender_id" value={{ $userId }}>
            <input type="hidden" id="sender_type" name="sender_type" value={{ $role }}>
            <input type="hidden" id="receiver_id" name="receiver_id" value={{ $stocksell->user_id }}>
            <input type="hidden" id="receiver_type" name="receiver_type" value={{ $stocksell->role }}>
            <input type="hidden" id="type" name="type" value="stocksell">
            <input type="hidden" id="stocksell_id" name="stocksell_id" value={{ $stocksell->id }}>

            <!-- Visible fields -->
            <div class="form-group">
              <label for="supplier">To</label>
              <div class="supplier-name-field">{{ $shopName }}</div>
            </div>
            <div class="form-group">
              <label for="email">E-mail Address</label>
              <input type="email" id="email" name="email" placeholder="Please enter your business e-mail address" required>
            </div>
            <div class="form-group">
              <label for="message">Message</label>
              <textarea id="message" name="message" placeholder="Enter product details such as color, size, materials and other specific requirements." rows="6" required></textarea>
            </div>
            @if (auth('customer')->check() && auth('customer')->user()->id)
              @if ($membership['status'] == 'active')
                <button type="submit" class="btn-inquire-now">Send Inquiry Now</button>
              @else
                <button href="{{ route('membership') }}" class="btn-inquire-now">Send Inquiry Now</button>
              @endif
            @else
              <button href="#" onclick="sendtologin()" class="btn-inquire-now">Send Inquiry Now</button>
            @endif
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
