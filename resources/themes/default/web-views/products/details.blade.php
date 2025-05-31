@extends('layouts.front-end.app')

@section('title', $product['name'])

@push('css_or_js')
    @include(VIEW_FILE_NAMES['product_seo_meta_content_partials'], [
        'metaContentData' => $product?->seoInfo,
        'product' => $product,
    ])
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/ai/marketplace-view.css') }}" />
@endpush

@section('content')
    <?php
    if (Auth('customer')->check()) {
        $membership = \App\Utils\ChatManager::getMembershipStatusCustomer(Auth('customer')->user()->id);
        if (isset($membership)) {
            if ($membership['status'] == 'error') {
                $membership = ['status' => 'NotMade', 'message' => 'Membership Not Applied'];
            }
        }
    } else {
        $membership = ['status' => 'notLogged', 'message' => 'Not Logged In'];
    }
    $userdata = \App\Utils\ChatManager::getRoleDetail();
    if ($userdata) {
        $role = $userdata['role'];
        if ($role == 'seller' || $role == 'admin' || $role == 'customer') {
            $user_id = $userdata['user_id'];
            $cookie_name = $role . $user_id . 'product' . $product->id;
            $cookie_value = $user_id;
            if (isset($_COOKIE[$cookie_name])) {
                // Do Nothing
            } else {
                setcookie($cookie_name, $cookie_value, time() + 86400 * 30, '/');
                \App\Utils\ChatManager::IncreaseProductView($product->id);
            }
        } else {
            // Do Nothing
        }
    }
    ?>
    <div class="__inline-23">
        <div class="container mt-4 rtl text-align-direction">
            <div class="product-view-section" style="    background: #f7f7f7;">
                <!-- Product View Section -->
                <div class="product-view" style="margin-bottom: 40px;">

                    <!-- Product Images Section -->
                    <div class="product-images">

                        <img id="mainImage"
                            src="{{ isset($product->thumbnail) ? '/storage/product/thumbnail/' . $product->thumbnail : '/images/placeholderimage.webp' }}"
                            alt="Main product view" class="main-image">
                        <div class="thumbnail-container">
                            @php
                                $productArray = json_decode($product->images, true);
                            @endphp
                            @foreach ($productArray as $key => $value)
                                <img src="{{ '/storage/product/' . $value['image_name'] }}" alt="Thumbnail 2"
                                    class="thumbnail">
                            @endforeach
                        </div>
                    </div>
                    <!-- </div> -->
                    <div class=" dots-container">
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>

                    </div>
                    <!-- <div class="product-view" > -->
                    <!-- Product Details Section -->
                    <div class="product-details">
                        <div class="price-details-box">
                            <h1 class="product-title">{{ $product->name }}</h1>

                            <div class="price-box">
                                <div class="price-info">
                                    <div class="price">
                                        <span class="amount">US$ {{ $product->unit_price }}</span>
                                        <span class="unit">/1 {{ $product->unit }}</span>
                                    </div>
                                    <div class="min-order">
                                        <span class="quantity">{{ $product->minimum_order_qty }} {{ $product->unit }}</span>
                                        <span class="label">Minimum order</span>
                                    </div>
                                </div>
                                <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/ebe375fda3be1065358baf7296c9b484e546d2f7"
                                    alt="Rating" class="rating-image">
                            </div>

                            <div class="product-specs">
                                <div class="spec-row">
                                    <span class="spec-label">Customization:</span>
                                    <span class="spec-value">{{ $product->customization }}</span>
                                </div>
                                <div class="spec-row">
                                    <span class="spec-label">Style:</span>
                                    <span class="spec-value">{{ $product->style }}</span>
                                </div>
                                <div class="spec-row">
                                    <span class="spec-label">Usage:</span>
                                    <span class="spec-value margin">{{ $product->usage }}</span>
                                </div>
                            </div>


                            <div class="action-buttons" data-toggle="modal" data-target="#exampleModal">
                                <input type="number" min="0" placeholder="Enter Qty" id="productQty"
                                    class="quantity-input form-control"></input>
                                <button type="button" class="btn custom-inquiry-btn" data-toggle="modal"
                                    data-target="#inquiryModal">
                                    <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/0882f754e189daab8d1153c2e9654e9a14108c4f"
                                        alt="Inquire" class="inquire-icon">
                                    Inquire Now
                                </button>
                            </div>

                            <div class="product-costs">
                                <div class="cost-item">
                                    <div class="cost-label">Total Product Cost</div>
                                    <div class="cost-value">US$ {{ $product->unit_price }} / {{ $product->unit }}</div>
                                </div>
                                <div class="cost-item">
                                    <div class="cost-label">Shipping Cost</div>
                                    <div class="cost-value">{{ $product->shipping_cost }}</div>
                                </div>
                                <div class="cost-item">
                                    <div class="cost-label">Total</div>
                                    <div class="cost-value">{{ $product->unit_price + $product->shipping_cost }} /
                                        {{ $product->unit }}</div>
                                </div>
                            </div>

                            <div class="samples-info">
                                Samples: {{ $product->sample_price }}/{{ $product->unit }} |
                                {{ $product->sample_amount }} {{ $product->unit }} | <span class="buy-sample">Buy
                                    Sample</span>
                            </div>
                        </div>
                        <div class="supplier-info">
                            @php
                                if ($product->added_by == 'admin') {
                                    $isAdmin = 1;
                                } else {
                                    $isAdmin = 0;
                                }
                            @endphp
                            <div>
                                <div class="supplier-name">{{ $isAdmin == 1 ? 'Admin Shop' : $product->seller->shop->name }}
                                </div>
                                <div class="supplier-meta">
                                    <span
                                        class="years">{{ $isAdmin == 1 ? 'Admin' : $product->seller->years . ' years' }}</span>
                                    <span class="country">{{ $isAdmin == 1 ? 'DealRocket' : $product->seller->country }}</span>
                                </div>
                                <div class="response-data">
                                    <div class="response-rate"><span class="label">Response Rate:</span> <span
                                            class="value">High</span></div>
                                    <div class="response-time"><span class="label">Avg Response Time:</span> <span
                                            class="value">≤24 h</span></div>

                                </div>
                            </div>
                            <div class="subplier-btn"
                                style="    display: flex
                    ;
                        flex-direction: column-reverse;
                        justify-content: start; gap: 1rem;">
                                <div class="business-type"><span class="label">Business Type:</span> <span
                                        class="value">Manufacturer, Exporter, Trading Company</span></div>
                                <div class="supplier-actions">
                                    <button class="btn-outline">Follow</button>
                                    <button class="btn-outline">Chat</button>
                                </div>
                            </div>

                        </div>


                    </div>

                </div>


                @include('web-views.partials._order-now')
                <!-- New Products Section -->
                {{-- <div class="related-products" style="margin: 2rem 2rem !important;">
                    <div class="new-products-container">
                        <div class="new-products-banner">
                            <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/03db452520cbb4fc62a10fc86e2e2c09fb43fa2f"
                                alt="New products background" class="banner-bg">
                            <div class="banner-content">
                                <div class="banner-title">New Products</div>
                                <div class="view-more-container">
                                    <div class="view-more">View More</div>
                                </div>
                            </div>
                        </div>

                        <div class="product-grid">
                            <div class="product-card">
                                <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/cb7b1be753ae81f132745df01ab5fb7ec2cdf023"
                                    alt="Wax Beads" class="product-img">
                                <div class="product-title">Wholesale Hard Wax Beads 400g Painess Bikini leg Hair Removal
                                    Bulk Depilatory Wax Beans</div>
                                <div class="product-price">US$ 2.30 / Piece</div>
                                <div class="product-moq">400 Piece (MOQ)</div>
                                <button class="start-order-btn">Start order</button>
                            </div>
                            <div class="product-card">
                                <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/cb7b1be753ae81f132745df01ab5fb7ec2cdf023"
                                    alt="Wax Beads" class="product-img">
                                <div class="product-title">Wholesale Hard Wax Beads 400g Painess Bikini leg Hair Removal
                                    Bulk Depilatory Wax Beans</div>
                                <div class="product-price">US$ 2.30 / Piece</div>
                                <div class="product-moq">400 Piece (MOQ)</div>
                                <button class="start-order-btn">Start order</button>
                            </div>
                            <div class="product-card">
                                <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/cb7b1be753ae81f132745df01ab5fb7ec2cdf023"
                                    alt="Wax Beads" class="product-img">
                                <div class="product-title">Wholesale Hard Wax Beads 400g Painess Bikini leg Hair Removal
                                    Bulk Depilatory Wax Beans</div>
                                <div class="product-price">US$ 2.30 / Piece</div>
                                <div class="product-moq">400 Piece (MOQ)</div>
                                <button class="start-order-btn">Start order</button>
                            </div>
                            <div class="product-card">
                                <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/cb7b1be753ae81f132745df01ab5fb7ec2cdf023"
                                    alt="Wax Beads" class="product-img">
                                <div class="product-title">Wholesale Hard Wax Beads 400g Painess Bikini leg Hair Removal
                                    Bulk Depilatory Wax Beans</div>
                                <div class="product-price">US$ 2.30 / Piece</div>
                                <div class="product-moq">400 Piece (MOQ)</div>
                                <button class="start-order-btn">Start order</button>
                            </div>

                        </div>
                    </div>
                </div> --}}

                <!-- Product Description Section -->
                <div class="product-description">
                    <div class="product-div">
                        <div class="description-tabs">
                            <div class="tab active" data-toggleid="productDescription">Product Description</div>
                            <div class="tab" data-toggleid="companyInfo">Company Info.</div>
                        </div>
                        <div class="tabdata" id="productDescription">
                            <div class="description-subtabs">
                                <div class="subtab active" data-toggleid="productInfo">Product Information</div>
                                <div class="subtab" data-toggleid="shippingInfo">Shipping Information</div>
                                <div class="subtab" data-toggleid="mainExportMarket">Main Export Markets</div>
                                <div class="subtab" data-toggleid="paymentDetails">Payment Details</div>
                            </div>

                            <div class="subtabdata" id="productInfo">
                                <div class="product-info">
                                    <div class="info-table">
                                        <div class="info-row">
                                            <div class="info-label">Model Number</div>
                                            <div class="info-value">{{ $product->model_number }}</div>
                                        </div>
                                        <div class="info-row">
                                            <div class="info-label">Brand Name</div>
                                            <div class="info-value">{{ $product->brand->name }}</div>
                                        </div>
                                        <div class="info-row">
                                            <div class="info-label">Origin</div>
                                            <div class="info-value">{{ $product->origin }}</div>
                                        </div>
                                        <div class="info-row">
                                            <div class="info-label">Small Orders</div>
                                            <div class="info-value">
                                                {{ $product->small_orders == 1 ? 'Accepted' : 'Not Accepted' }}</div>
                                        </div>
                                    </div>

                                    <h3 class="section-title">Key Specifications/ Special Features:</h3>
                                    <h2 class="display-title">Product Display</h2>

                                    <div class="product-display-images">
                                        <div class="swiper">
                                            <div class="swiper-wrapper">
                                                @foreach ($productArray as $value)
                                                    <div class="swiper-slide">
                                                        <img src="{{ asset('storage/product/' . $value['image_name']) }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="specs-tables">
                                        @php
                                            $additionalDetailsArray = json_decode($product->additional_details, true);
                                        @endphp
                                        @foreach ($additionalDetailsArray as $item)
                                            <table class="specs-table">
                                                @php
                                                    $subheads = $item['sub_heads'];
                                                    $countofsubheads = count($subheads);
                                                @endphp
                                                @foreach ($subheads as $index => $subhead)
                                                    <tr>
                                                        @if ($index == 0)
                                                            <th rowspan="{{ $countofsubheads }}">{{ $item['title'] }}
                                                            </th>
                                                        @endif
                                                        <td class="spec-name">{{ $subhead['sub_head'] }}</td>
                                                        <td class="spec-detail">{{ $subhead['sub_head_data'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        @endforeach
                                    </div>
                                    <button class="see-more-btn" onclick="showHiddenTables()">See more details</button>
                                </div>

                                <div class="contact-us-section">
                                    <h2 class="contact-us-title">Contact Us</h2>
                                    <div class="contact-text">
                                        {{ $isAdmin == 1 ? 'Admin Shop' : $product->seller->shop->name }} <br>
                                        {{ $isAdmin == 1 ? 'Admin Address' : $product->seller->shop->address }}
                                    </div>
                                </div>

                                <div class="faq-section">
                                    <h2 class="faq-title">Faq</h2>
                                    <div class="faq-list">
                                        {!! $product->faq !!}
                                    </div>
                                </div>

                                <div class="why-choose-us-section">
                                    <h2 class="why-choose-us-title">Why Choose Us?</h2>
                                    <div class="why-choose-us-content">
                                        {!! $product->why_choose_us !!}
                                    </div>

                                    <table class="company-table">
                                        <tr>
                                            <th class="company-label">Company</th>
                                            <th class="company-value">
                                                {{ $isAdmin == 1 ? 'Admin Shop' : $product->seller->shop->name }}</th>
                                        </tr>
                                        <tr>
                                            <td class="company-label">Contact</td>
                                            <td class="company-value">
                                                {{ $isAdmin == 1 ? getWebConfig(name: 'company_name') : $product->seller->f_name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="company-label">tel/we-chat/what's-app</td>
                                            <td class="company-value">
                                                {{ $isAdmin == 1 ? getWebConfig(name: 'company_phone') : $product->seller->shop->contact }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="company-label">E-mail</td>
                                            <td class="company-value">
                                                {{ $isAdmin == 1 ? getWebConfig(name: 'company_email') : $product->seller->email }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="subtabdata" id="shippingInfo" style="display: none;">
                                <h2 class="section-title-large">Shipping Information</h2>
                                <table class="shipping-table">
                                    <tr>
                                        <td class="shipping-label">FOB Port</td>
                                        <td class="shipping-value">{{ $product->fob_port }}</td>
                                    </tr>
                                    <tr>
                                        <td class="shipping-label">Weight per Unit</td>
                                        <td class="shipping-value">{{ $product->weight_per_unit }}</td>
                                    </tr>
                                    <tr>
                                        <td class="shipping-label">HTS Code</td>
                                        <td class="shipping-value">{{ $product->hts_code }}</td>
                                    </tr>
                                    <tr>
                                        <td class="shipping-label">Export Carton<br>Dimensions L/W/H</td>
                                        <td class="shipping-value">{{ $product->export_carton_dimensions }}</td>
                                    </tr>
                                    <tr>
                                        <td class="shipping-label">Logistics attributes</td>
                                        <td class="shipping-value">{{ $product->logistics_attributes }}</td>
                                    </tr>
                                </table>
                                <table class="shipping-table">
                                    <tr>
                                        <td class="shipping-label">Lead Time</td>
                                        <td class="shipping-value">{{ $product->lead_time }}</td>
                                    </tr>
                                    <tr>
                                        <td class="shipping-label">Dimensions per Unit</td>
                                        <td class="shipping-value">{{ $product->dimensions_per_unit }}</td>
                                    </tr>
                                    <tr>
                                        <td class="shipping-label">Units per Export Carton</td>
                                        <td class="shipping-value">{{ $product->units_per_carton }}</td>
                                    </tr>
                                    <tr>
                                        <td class="shipping-label">Export Carton Weight</td>
                                        <td class="shipping-value">{{ $product->carton_weight }}</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="subtabdata" id="mainExportMarket" style="display: none;">
                                <h2 class="section-title-large">Main Export Market</h2>
                                {!! $product->export_markets !!}
                            </div>

                            <div class="subtabdata" id="paymentDetails" style="display: none;">
                                <h2 class="section-title-large">Shipping Information</h2>
                                <table class="shipping-table">
                                    <tr>
                                        <td class="shipping-label">Payment Methods</td>
                                        <td class="shipping-value">{{ $product->payment_methods }}</td>
                                    </tr>
                                    <tr>
                                        <td class="shipping-label">Currency Accepted</td>
                                        <td class="shipping-value">{{ $product->currency_accepted }}</td>
                                    </tr>
                                    <tr>
                                        <td class="shipping-label">Payment Terms</td>
                                        <td class="shipping-value">{{ $product->payment_terms }}</td>
                                    </tr>
                                    <tr>
                                        <td class="shipping-label">Invoicing</td>
                                        <td class="shipping-value">{{ $product->invoicing }}</td>
                                    </tr>
                                    <tr>
                                        <td class="shipping-label">Refund Policy</td>
                                        <td class="shipping-value">{!! $product->refund_policy !!}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="product-description tabdata" id="companyInfo" style="display: none;">
                            <div class="product-div">
                                <div class="product-info">
                                    <div class="supplier-name">
                                        {{ $isAdmin == 1 ? 'Admin Shop' : $product->seller->shop->name }}</div>
                                    <div class="supplier-meta">
                                        <span
                                            class="years">{{ $isAdmin == 1 ? 'Admin' : $product->seller->years . 'years' }}</span>
                                        <span
                                            class="country">{{ $isAdmin == 1 ? 'DealRocket' : $product->seller->country }}</span>
                                    </div>
                                    <div class="response-data">
                                        <div class="response-rate"><span class="label">Response Rate:</span> <span
                                                class="value">High</span></div>
                                        <div class="response-time"><span class="label">Avg Response Time:</span> <span
                                                class="value">≤24 h</span></div>
                                        <div class="business-type"><span class="label">Business Type:</span> <span
                                                class="value">Manufacturer, Exporter, Trading Company</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="supplier-info card-2">
                        <div class="supplier-name">{{ $isAdmin == 1 ? 'Admin Shop' : $product->seller->shop->name }}</div>
                        <div class="supplier-meta">
                            <span class="years">{{ $isAdmin == 1 ? 'Admin' : $product->seller->years . ' years' }}</span>
                            <span class="country">{{ $isAdmin == 1 ? 'DealRocket' : $product->seller->country }}</span>
                        </div>
                        <div class="response-data">
                            <div class="response-rate"><span class="label">Response Rate:</span> <span
                                    class="value">High</span></div>
                            <div class="response-time"><span class="label">Avg Response Time:</span> <span
                                    class="value">≤24 h</span></div>
                            <div class="business-type"><span class="label">Business Type:</span> <span
                                    class="value">Manufacturer, Exporter, Trading Company</span></div>
                        </div>
                        <div class="supplier-actions">
                            <button class="btn-outline">Follow</button>
                            <button class="btn-outline">Chat</button>
                        </div>
                    </div>
                </div>
                <!-- Inquiry Form Section -->

                <div class="modal fade" id="inquiryModal" tabindex="-1" aria-labelledby="inquiryModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h5 class="modal-title" id="inquiryModalLabel">Send a direct inquiry to this supplier</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <!-- Modal Body -->
                            <div class="modal-body">
                                <form id="inquiryForm">
                                    <div class="mb-3">
                                        <label for="supplier" class="form-label">To</label>
                                        <div class="form-control-plaintext">Wenzhou Ivspeed Co.,Ltd</div>
                                    </div>
                                    @php
                                        $userdata = \App\Utils\ChatManager::getRoleDetail();
                                        $userId = $userdata['user_id'] ?? null;
                                        $role = $userdata['role'] ?? null;
                                    @endphp
                                    <!-- Hidden fields -->
                                    <input type="hidden" id="sender_id" name="sender_id" value={{ $userId }}>
                                    <input type="hidden" id="sender_type" name="sender_type" value={{ $role }}>
                                    <input type="hidden" id="receiver_id" name="receiver_id"
                                        value={{ $product->user_id }}>
                                    <input type="hidden" id="receiver_type" name="receiver_type"
                                        value={{ $product->added_by }}>
                                    <input type="hidden" id="product_id" name="product_id" value={{ $product->id }}>
                                    <input type="hidden" id="type" name="type" value="products">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">E-mail Address</label>
                                        <input type="email" class="form-control" id="email"
                                            placeholder="Please enter your business e-mail address" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="message" class="form-label">Message</label>
                                        <textarea class="form-control" id="message" rows="4" placeholder="Enter product details..." required></textarea>
                                    </div>
                                    @if (auth('customer')->check())
                                        @if (strtolower(trim($membership['status'] ?? '')) == 'active')
                                            <button type="button" onclick="triggerChat()"
                                                class="btn-inquire-now btn btn-success">Send Inquiry Now</button>
                                        @else
                                            <a href="{{ route('membership') }}"
                                                class="btn-inquire-now btn btn-success">Send Inquiry
                                                Now</a>
                                        @endif
                                    @else
                                        <button type="button" onclick="sendtologin()"
                                            class="btn-inquire-now btn btn-success">Send
                                            Inquiry Now</button>
                                    @endif
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="modal fade rtl text-align-direction" id="show-modal-view" tabindex="-1" role="dialog"
            aria-labelledby="show-modal-image" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body flex justify-content-center">
                        <button class="btn btn-default __inline-33 dir-end-minus-7px" data-dismiss="modal">
                            <i class="fa fa-close"></i>
                        </button>
                        <img class="element-center" id="attachment-view" src="" alt="">
                    </div>
                </div>
            </div>
        </div>

    </div>

    @if ($product?->preview_file_full_url['path'])
        @include('web-views.partials._product-preview-modal', ['previewFileInfo' => $previewFileInfo])
    @endif

    @include('layouts.front-end.partials.modal._chatting', [
        'seller' => $product->seller,
        'user_type' => $product->added_by,
    ])

    <span id="route-review-list-product" data-url="{{ route('review-list-product') }}"></span>
    <span id="products-details-page-data" data-id="{{ $product['id'] }}"></span>
@endsection

@push('script')
    {{-- <script src="{{ theme_asset(path: 'public/assets/front-end/js/product-details.js') }}"></script> --}}
    <script src="{{ theme_asset(path: 'public/js/product-detail.js') }}"></script>
    <script type="text/javascript" async="async"
        src="https://platform-api.sharethis.com/js/sharethis.js#property=5f55f75bde227f0012147049&product=sticky-share-buttons">
    </script>
    <script>
        function triggerChat() {
            var _token = $('input[name="_token"]').val()

            var formData = {
                sender_id: $('#sender_id').val(),
                sender_type: $('#sender_type').val(),
                receiver_id: $('#receiver_id').val(),
                receiver_type: $('#receiver_type').val(),
                product_id: $('#product_id').val(),
                product_qty: $('#productQty').val(),
                type: $('#type').val(),
                email: $('#email').val(),
                message: $('#message').val()
            };

            $.ajax({
                url: "{{ route('sendmessage.other') }}",
                type: 'POST',
                data: JSON.stringify(formData),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': _token,
                },
                success: function(response) {
                    toastr.success('Inquiry sent successfully!', 'Success');
                    window.location.reload();
                },
                error: function(xhr) {
                    toastr.error('Failed to send inquiry.', 'Error');
                }
            });
        }
    </script>
@endpush
