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

                        <img id="mainImage" src="<?php echo asset('assets\front-end\img\image 99.png'); ?>" alt="Main product view" class="main-image">
                        <div class="thumbnail-container">
                            <!-- <img src="lovable-uploads/a8162771-3113-49ef-9581-7dd4e19220ca.png" alt="Thumbnail 1" class="thumbnail"> -->
                            <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/f3c0381041ef8f92243b60873062c2b77239c367"
                                alt="Thumbnail 2" class="thumbnail">
                            <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/a3e7c9c266f3d808cac5cb97662da382d479482b"
                                alt="Thumbnail 3" class="thumbnail">
                            <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/bb98adedc0858f92f23ec8d7ac4b78c5120aa076"
                                alt="Thumbnail 4" class="thumbnail">
                            <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/0323c9df36474d00d3016191da5f45c19dc3ae5a"
                                alt="Thumbnail 5" class="thumbnail">
                            <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/0c97a9b52935fdb41fa8b3586f6558996b0953fd"
                                alt="Thumbnail 6" class="thumbnail">
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
                            <h1 class="product-title">Wholesale High quality Mini camera 4G Low Power 1080P HD Wireless
                                cameras Micro 2600mAh Battery Support Full Netcom 4G mini camera</h1>

                            <div class="price-box">
                                <div class="price-info">
                                    <div class="price">
                                        <span class="amount">US$ 25 - 29</span>
                                        <span class="unit">/1 Piece</span>
                                    </div>
                                    <div class="min-order">
                                        <span class="quantity">5 Pieces</span>
                                        <span class="label">Minimum order</span>
                                    </div>
                                </div>
                                <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/ebe375fda3be1065358baf7296c9b484e546d2f7"
                                    alt="Rating" class="rating-image">
                            </div>

                            <div class="product-specs">
                                <div class="spec-row">
                                    <span class="spec-label">Customization:</span>
                                    <span class="spec-value">Available</span>
                                </div>
                                <div class="spec-row">
                                    <span class="spec-label">Style:</span>
                                    <span class="spec-value">In-ear</span>
                                </div>
                                <div class="spec-row">
                                    <span class="spec-label">Usage:</span>
                                    <span class="spec-value margin">Mobile Phone, Call Center, MP3 & MP4, Computer, Game
                                        Player</span>
                                </div>
                            </div>


                            <div class="action-buttons" data-toggle="modal" data-target="#exampleModal">
                                <div class="quantity-input">
                                    <span>Enter Qty</span>
                                    <div class="divider"></div>
                                    <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/2fb86a15b06a52a02d4ed45c08ac901377aa5b4e"
                                        alt="Dropdown" class="dropdown-icon">
                                </div>
                                <button class="btn-cart">Add to Cart</button>
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
                                    <div class="cost-value">US$ 29.00</div>
                                </div>
                                <div class="cost-item">
                                    <div class="cost-label">Shipping Cost</div>
                                    <div class="cost-value">To be provided by supplier</div>
                                </div>
                                <div class="cost-item">
                                    <div class="cost-label">Total</div>
                                    <div class="cost-value">Pending supplier's quote</div>
                                </div>
                            </div>

                            <div class="samples-info">
                                Samples: $50.00/Piece | 1–4 Pieces | <span class="buy-sample">Buy Sample</span>
                            </div>
                        </div>
                        <div class="supplier-info">
                            <div>
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
                                    <div class="info-value">IV-4GIPC001-01</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Brand Name</div>
                                    <div class="info-value">IVSPEED</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Origin</div>
                                    <div class="info-value">China</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Small Orders</div>
                                    <div class="info-value">Accepted</div>
                                </div>
                            </div>

                            <h3 class="section-title">Key Specifications/ Special Features:</h3>
                            <h2 class="display-title">Product Display</h2>

                            <div class="product-display-images">
                                <img src="<?php echo asset('assets/front-end/img/image 99.png'); ?>" alt="Product Display 1" class="display-image">
                                <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/75f87a23563ea2c57ac1a8a3ffac61ad1427e3dd"
                                    alt="Product Display 2" class="display-image">
                            </div>

                            <div class="specs-tables">
                                <table class="specs-table">
                                    <tr>
                                        <th rowspan="5">Image Capture</th>
                                        <td class="spec-name">Image sensor</td>
                                        <td class="spec-detail">GC2053,1/2.9 inch 1080p progressive scan CMOS sensor
                                            (100W/200W/300W optional)</td>
                                    </tr>
                                    <tr>
                                        <td class="spec-name">Minimum Illumination</td>
                                        <td class="spec-detail">0.3-0.5Lux(color mode), 0 Lux(B&W mode)</td>
                                    </tr>
                                    <tr>
                                        <td class="spec-name">Lens</td>
                                        <td class="spec-detail">GC2053 integrated module</td>
                                    </tr>
                                    <tr>
                                        <td class="spec-name">View Angle</td>
                                        <td class="spec-detail">140 (Diagonal)</td>
                                    </tr>
                                    <tr>
                                        <td class="spec-name">Night vision</td>
                                        <td class="spec-detail">Photosensitive filter with auto-switching,8pcs 940nm SMD IR
                                            LED, IR irradiation distance: 3~5 m</td>
                                    </tr>
                                </table>

                                <table class="specs-table hide">
                                    <tr>
                                        <th rowspan="2">Video</th>
                                        <td class="spec-name">Input</td>
                                        <td class="spec-detail">Built-in 38db microphone</td>
                                    </tr>
                                    <tr>
                                        <td class="spec-name">Output</td>
                                        <td class="spec-detail">Built-in 8 & 1 w speakers</td>
                                    </tr>
                                </table>

                                <table class="specs-table hide audio-table">
                                    <tr>
                                        <th rowspan="5">Audio</th>
                                        <td class="spec-name">Input</td>
                                        <td class="spec-detail">Built-in 38db microphone</td>
                                    </tr>
                                    <tr>
                                        <td class="spec-name">Output</td>
                                        <td class="spec-detail">Built-in 8 & 1 w speakers</td>
                                    </tr>
                                    <tr>
                                        <td class="spec-name">Sampling frequency / Bit width</td>
                                        <td class="spec-detail">8KHz/16bit</td>
                                    </tr>
                                    <tr>
                                        <td class="spec-name">Input</td>
                                        <td class="spec-detail">Input</td>
                                    </tr>
                                    <tr>
                                        <td class="spec-name">Compression standard / code rate</td>
                                        <td class="spec-detail">ADPCM/32kbps</td>
                                    </tr>
                                </table>

                                <table class="specs-table hide">
                                    <tr>
                                        <th rowspan="2">Network frequency</th>
                                        <td class="spec-name">Input</td>
                                        <td class="spec-detail">FDD:B1/B3/B5/B8 TDD:B34/B38/B39/B40/B41 WCDMA:B1/B5/B8</td>
                                    </tr>
                                    <tr>
                                        <td class="spec-name">EU/Southeast Asia</td>
                                        <td class="spec-detail">WCDMA:B1/B5/B8 FDD:B1/B3/B5/B7/B8/B20 TDD:B38/B40/B41</td>
                                    </tr>
                                </table>

                                <table class="specs-table hide">
                                    <tr>
                                        <th>MemorySocket</th>
                                        <td class="spec-name">Socket</td>
                                        <td class="spec-detail">TF Push-push socket,Maximum support 256GB; Cloud Storage
                                        </td>
                                    </tr>
                                </table>

                                <table class="specs-table hide">
                                    <tr>
                                        <th>Alarm</th>
                                        <td class="spec-name">Alarm Trigger</td>
                                        <td class="spec-detail">Support PIR detection</td>
                                    </tr>
                                </table>

                                <table class="specs-table hide">
                                    <tr>
                                        <th rowspan="6">Physical Environmental</th>
                                        <td class="spec-name">Rated voltage</td>
                                        <td class="spec-detail">DC5V±5%</td>
                                    </tr>
                                    <tr>
                                        <td class="spec-name">Power supply</td>
                                        <td class="spec-detail">Built-in 2600mAh batteries/USB DC5V</td>
                                    </tr>
                                    <tr>
                                        <td class="spec-name">Power consumption</td>
                                        <td class="spec-detail">Sleep mode: 5mA working mode: 500mA</td>
                                    </tr>
                                    <tr>
                                        <td class="spec-name">Operating condition</td>
                                        <td class="spec-detail">Temperature:-10~50℃,humidity:<90%< /td>
                                    </tr>
                                    <tr>
                                        <td class="spec-name">Weight</td>
                                        <td class="spec-detail">Net: 90g Gross:240g (Note: in kind prevail)</td>
                                    </tr>
                                    <tr>
                                        <td class="spec-name">Package size</td>
                                        <td class="spec-detail">130x90x45 mm (L×W×H)</td>
                                    </tr>
                                </table>
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
                            <div class="contact-us-banner">
                                <div>
                                    <img class=" contact-img" src="<?php echo asset('assets/front-end/img/image (1).png'); ?>" alt="Product Display 1"
                                        class="display-image">
                                </div>
                                <!-- <div class="contact-text">CONTACT US</div> -->
                            </div>
                        </div>

                        <div class="faq-section">
                            <h2 class="faq-title">Faq</h2>
                            <div class="faq-list">
                                <div class="faq-item">
                                    <div class="faq-question">Q1. What is your terms of packing?</div>
                                    <div class="faq-answer">A: Generally the Neutral packing, our colored packing or
                                        according to customer's requirement are all acceptable.</div>
                                </div>
                                <div class="faq-item">
                                    <div class="faq-question">Q2. What's your minimum order quantity?</div>
                                    <div class="faq-answer">A: In general,MOQ is 50pcs, but different items with different
                                        MOQ.</div>
                                </div>
                                <div class="faq-item">
                                    <div class="faq-question">Q3. How about your delivery time?</div>
                                    <div class="faq-answer">A: Generally, if we have goods in stock, 1-3 days are
                                        needed.<br><br>Otherwise, it will take 15 to 40 days after receiving your advance
                                        payment. The specific delivery time depends on the items and the quantity of your
                                        order.</div>
                                </div>
                                <div class="faq-item">
                                    <div class="faq-question">Q4. What is your terms of payment?</div>
                                    <div class="faq-answer">A: T/T 30% as deposit, and 70% before delivery. We'll show you
                                        the photos of the products and packages before you pay the balance.</div>
                                </div>
                                <div class="faq-item">
                                    <div class="faq-question">Q5. What is your terms of delivery?</div>
                                    <div class="faq-answer">A: FOB, EXW, CFR, CIF, DDU, DDP, DAP.</div>
                                </div>
                                <div class="faq-item">
                                    <div class="faq-question">Q6. What is your sample policy?</div>
                                    <div class="faq-answer">A: We can supply the sample if we have ready parts in stock,
                                        but customers have to pay the sample cost and the courier cost.</div>
                                </div>
                                <div class="faq-item">
                                    <div class="faq-question">Q7: How is your quality control?</div>
                                    <div class="faq-answer">A: Original OEM quality</div>
                                </div>
                            </div>
                        </div>

                        <div class="why-choose-us-section">
                            <h2 class="why-choose-us-title">Why Choose Us?</h2>
                            <div class="why-choose-us-content">
                                1. A wide range for options.<br>
                                2. Quality assurance: Advanced equipment, 100% finished product check, safe fixed, stable,
                                durable.<br>
                                3. Fast delivery, Prompt response, Professional staffs<br>
                                4.The customized components also can be manufactured<br>
                                5.Neutral packing, export standard carton, all of the products are inspected carefully by QC
                                before delivery.<br>
                                6.Completive price: Order a HQ container, price will be more favorable.
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
