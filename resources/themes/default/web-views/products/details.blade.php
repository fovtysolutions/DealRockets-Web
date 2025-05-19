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
                <div class="product-view">

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
                                {{-- <div class="quantity-input">
                                    <span>Enter Qty</span>
                                    <div class="divider"></div>
                                    <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/2fb86a15b06a52a02d4ed45c08ac901377aa5b4e"
                                        alt="Dropdown" class="dropdown-icon">
                                </div>
                                <button class="btn-cart">Add to Cart</button> --}}
                                <button type="button" class="btn custom-inquiry-btn" data-bs-toggle="modal"
                                    data-bs-target="#inquiryModal">
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
                                if ($product->added_by = 'admin') {
                                    $isAdmin = true;
                                } else {
                                    $isAdmin = false;
                                }
                            @endphp
                            <div>
                                <div class="supplier-name">{{ $isAdmin ? 'Admin Shop' : $product->seller->shop->name }}
                                </div>
                                <div class="supplier-meta">
                                    <span
                                        class="years">{{ $isAdmin ? 'Admin' : $product->seller->years . 'years' }}</span>
                                    <span class="country">{{ $isAdmin ? 'DealRocket' : $product->seller->country }}</span>
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

                <!-- New Products Section -->
                <div class="related-products" style="margin: 2rem 2rem !important;">
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
                </div>

                <!-- Product Description Section -->
                <div class="product-description">
                    <div class="product-div">
                        <div class="description-tabs">
                            <div class="tab active">Product Description</div>
                            <div class="tab">Company Info.</div>
                        </div>

                        <div class="description-subtabs">
                            <div class="subtab active">Product Information</div>
                            <div class="subtab">Shipping Information</div>
                            <div class="subtab">Main Export Markets</div>
                            <div class="subtab">Payment Details</div>
                        </div>

                        <div class="product-info">
                            <div class="info-table">
                                <div class="info-row">
                                    <div class="info-label">Model Number</div>
                                    <div class="info-value">{{ $product->model_number }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Brand Name</div>
                                    <div class="info-value">{{ $product->brand }}</div>
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
                                @foreach ($productArray as $key => $value)
                                    <img src="{{ '/storage/product/' . $value['image_name'] }}" alt="Thumbnail 2"
                                        class="display-image">
                                @endforeach
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
                                                    <th rowspan="{{ $countofsubheads }}">{{ $item['title'] }}</th>
                                                @endif
                                                <td class="spec-name">{{ $subhead['sub_head'] }}</td>
                                                <td class="spec-detail">{{ $subhead['sub_head_data'] }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                @endforeach
                            </div>
                            <button class="see-more-btn" onclick="showHiddenTables()">See more details</button>
                            <script>
                                function showHiddenTables() {
                                    // Show all hidden tables
                                    const hiddenTables = document.querySelectorAll('.specs-table.hide');
                                    hiddenTables.forEach(table => {
                                        table.classList.remove('hide');
                                    });

                                    // Hide the button after click
                                    const btn = document.querySelector('.see-more-btn');
                                    if (btn) {
                                        btn.style.display = 'none';
                                    }
                                }
                            </script>

                        </div>

                        <div class="contact-us-section">
                            <h2 class="contact-us-title">Contact Us</h2>
                            <div class="contact-text">
                                {{ $isAdmin ? 'Admin Shop' : $product->seller->shop->name }} <br>
                                {{ $isAdmin ? 'Admin Address' : $product->seller->shop->address }}
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
                                    <th class="company-value">Wenzhou Intop electron co.,ltd</th>
                                </tr>
                                <tr>
                                    <td class="company-label">Contact</td>
                                    <td class="company-value">Benson T</td>
                                </tr>
                                <tr>
                                    <td class="company-label">tel/we-chat/what's-app</td>
                                    <td class="company-value">+86-15669282250</td>
                                </tr>
                                <tr>
                                    <td class="company-label">E-mail</td>
                                    <td class="company-value">benson@wimet.com</td>
                                </tr>
                            </table>
                        </div>
                        <h2 class="section-title-large">Shipping Information</h2>
                        <table class="shipping-table">
                            <tr>
                                <td class="shipping-label">FOB Port</td>
                                <td class="shipping-value">FOB Port</td>
                            </tr>
                            <tr>
                                <td class="shipping-label">Weight per Unit</td>
                                <td class="shipping-value">141.0 Grams</td>
                            </tr>
                            <tr>
                                <td class="shipping-label">HTS Code</td>
                                <td class="shipping-value">8421.31.00 00</td>
                            </tr>
                            <tr>
                                <td class="shipping-label">Export Carton<br>Dimensions L/W/H</td>
                                <td class="shipping-value">20.0 x 20.0 x 20.0 Centimeters</td>
                            </tr>
                            <tr>
                                <td class="shipping-label">Logistics attributes</td>
                                <td class="shipping-value">Common</td>
                            </tr>
                        </table>
                        <table class="shipping-table">
                            <tr>
                                <td class="shipping-label">Lead Time</td>
                                <td class="shipping-value">5–15 days</td>
                            </tr>
                            <tr>
                                <td class="shipping-label">Dimensions per Unit</td>
                                <td class="shipping-value">10.0 x 10.0 x 10.0 Centimeters</td>
                            </tr>
                            <tr>
                                <td class="shipping-label">Units per Export Carton</td>
                                <td class="shipping-value">50.0</td>
                            </tr>
                            <tr>
                                <td class="shipping-label">Units per Export Carton</td>
                                <td class="shipping-value">50.0</td>
                            </tr>
                            <tr>
                                <td class="shipping-label">Export Carton Weight</td>
                                <td class="shipping-value">0.5 Kilograms</td>
                            </tr>
                        </table>
                    </div>
                    <div class="supplier-info card-2">
                        <div class="supplier-name">Wenzhou Ivspeed Co.,Ltd</div>
                        <div class="supplier-meta">
                            <span class="years">14 years</span>
                            <span class="country">China</span>
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
                <div class="inquiry-box m-sm-5 m-3">
                    <h5 class="">Send a direct inquiry to this supplier</h5>
                    <form style="padding: 30px;">
                        <div class="mb-3">
                            <label for="company" class="form-label">To</label>
                            <input type="text" class="form-control" id="company" value="Wenzhou Ivspeed Co.,Ltd"
                                readonly>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail Address</label>
                            <input type="email" class="form-control" id="email"
                                placeholder="Please enter your business e-mail address">
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" rows="5"
                                placeholder="Enter product details such as color, size, materials and other specific requirements."></textarea>
                        </div>
                        <div style="text-align: end;">
                            <button type="submit" class="btn btn-red">Send Inquiry Now</button>
                        </div>

                    </form>
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
                                    <div class="mb-3">
                                        <label for="email" class="form-label">E-mail Address</label>
                                        <input type="email" class="form-control" id="email"
                                            placeholder="Please enter your business e-mail address" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="message" class="form-label">Message</label>
                                        <textarea class="form-control" id="message" rows="4" placeholder="Enter product details..." required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success">Send Inquiry Now</button>
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
    <script src="{{ theme_asset(path: 'public/assets/front-end/js/product-details.js') }}"></script>
    <script type="text/javascript" async="async"
        src="https://platform-api.sharethis.com/js/sharethis.js#property=5f55f75bde227f0012147049&product=sticky-share-buttons">
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle thumbnail clicks
            const mainImage = document.getElementById('mainImage');
            const thumbnails = document.querySelectorAll('.thumbnail');

            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener('click', function() {
                    mainImage.src = this.src;
                });
            });

            // Handle tab switching
            const tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs
                    tabs.forEach(t => t.classList.remove('active'));
                    // Add active class to clicked tab
                    this.classList.add('active');
                });
            });

            // Handle subtab switching
            const subtabs = document.querySelectorAll('.subtab');
            subtabs.forEach(subtab => {
                subtab.addEventListener('click', function() {
                    // Remove active class from all subtabs
                    subtabs.forEach(t => t.classList.remove('active'));
                    // Add active class to clicked subtab
                    this.classList.add('active');
                });
            });

            // Handle quantity input
            const quantityInput = document.querySelector('.quantity-input');
            if (quantityInput) {
                quantityInput.addEventListener('click', function() {
                    // Add quantity selection logic here
                    console.log('Quantity input clicked');
                });
            }

            // Handle Add to Cart
            const addToCartBtn = document.querySelector('.btn-cart');
            if (addToCartBtn) {
                addToCartBtn.addEventListener('click', function() {
                    // Add to cart logic here
                    console.log('Add to cart clicked');
                    alert('Product added to cart!');
                });
            }

            // Handle Inquire Now
            const inquireBtn = document.querySelector('.btn-inquire');
            if (inquireBtn) {
                inquireBtn.addEventListener('click', function() {
                    // Scroll to inquiry form
                    const inquiryForm = document.querySelector('.inquiry-form');
                    inquiryForm.scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            }

            // Handle inquiry form submission
            const inquiryForm = document.getElementById('inquiryForm');
            if (inquiryForm) {
                inquiryForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const email = document.getElementById('email').value;
                    const message = document.getElementById('message').value;

                    console.log('Inquiry submitted:', {
                        email,
                        message
                    });

                    // Reset form
                    inquiryForm.reset();

                    // Show success message
                    alert('Your inquiry has been sent successfully!');
                });
            }

            // Handle start order buttons
            const startOrderBtns = document.querySelectorAll('.start-order-btn');
            startOrderBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    console.log('Start order clicked');
                    alert('Order process initiated!');
                });
            });

            // Handle "Buy Sample" link click
            const buySampleLink = document.querySelector('.buy-sample');
            if (buySampleLink) {
                buySampleLink.addEventListener('click', function() {
                    console.log('Buy sample clicked');
                    alert('Sample purchase process initiated!');
                });
            }
        });
    </script>
@endpush
