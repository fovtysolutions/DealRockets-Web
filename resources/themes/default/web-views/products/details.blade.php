@extends('layouts.front-end.app')

@section('title', $product['name'])

@push('css_or_js')
    @include(VIEW_FILE_NAMES['product_seo_meta_content_partials'], [
        'metaContentData' => $product?->seoInfo,
        'product' => $product,
    ])
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/ai/marketplace-view.css') }}" />
    <style>
        #sticky-supplier-info.stuck {
            position: fixed;
            top: 136px;
            width: 211px !important;
            z-index: 999;
            height: 245px !important;
            /* right will be set dynamically */
        }

        @media (max-width: 999px) {
            #sticky-supplier-info.stuck {
                top: 0px;
            }
        }
    </style>
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
    
    if ($product->added_by == 'admin') {
        $isAdmin = 1;
    } else {
        $isAdmin = 0;
    }
    ?>
    <div class="__inline-23 mainpagesection" style="background-color: unset; margin-top: 22px;">
        <div>
            <div class="product-view-section" style="background: #f7f7f7;">
                <!-- Product View Section -->
                <div class="product-view" style="margin-bottom: 20px;">
                    <!-- Product Images Section -->
                    <div class="product-images">

                        <div class="heart-image">
                            <div class="circle-container">
                                @php
                                    $user = auth('customer')->user();
                                    $isFavourite = $user
                                        ? \App\Utils\HelperUtil::checkIfFavourite($item->id, $user->id, 'product')
                                        : false;
                                @endphp

                                @if ($user)
                                    <img class="heart favourite-img" onclick="makeFavourite(this)"
                                        data-id="{{ $item->id }}" data-userid="{{ $user->id }}" data-type="product"
                                        data-role="{{ $user->role ?? 'customer' }}"
                                        src="{{ $isFavourite ? theme_asset('public/img/Heart (2).png') : theme_asset('public/img/Heart (1).png') }}"
                                        width="20" alt="Featured icon" style="margin-left: auto;">
                                @else
                                    <img class="heart favourite-img" onclick="sendtologin()"
                                        src="{{ theme_asset('public/img/Heart (1).png') }}" width="20"
                                        alt="Featured icon" style="margin-left: auto;">
                                @endif
                            </div>
                        </div>
                        <img id="mainImage"
                            src="{{ isset($product->thumbnail) ? '/storage/' . $product->thumbnail : '/images/placeholderimage.webp' }}"
                            alt="Main product view" class="main-image">
                        <div class="thumbnail-container">
                            @php
                                $productArray = json_decode($product->extra_images, true) ?? [];
                                $totalImages = count($productArray);
                            @endphp

                            @foreach ($productArray as $key => $value)
                                @if ($key < 3)
                                    <img src="{{ '/storage/' . $value }}" alt="Thumbnail {{ $key + 1 }}"
                                        class="thumbnail" onclick="openGallery({{ $key }})">
                                @elseif ($key === 3)
                                    <div class="more-thumbnail" onclick="openGallery({{ $key }})">
                                        <img src="{{ '/storage/' . $value }}" alt="Thumbnail {{ $key + 1 }}"
                                            class="thumbnail" onclick="openGallery({{ $key }})"
                                            style="opacity: 0.2;">
                                        <span style="position: absolute; font-size: 22px;"> +{{ $totalImages - 3 }} </span>
                                    </div>
                                    @break
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <!-- <div class="product-view" > -->
                    <!-- Product Details Section -->
                    <div class="product-details">
                        <div class="price-details-box">
                            <!-- Product Title -->
                            <section class="product-heading">
                                <h1 class="product-title">{{ $product->name ?? '' }}</h1>
                                <p class="product-subtitle">{!! $product->short_details ?? '' !!}</p>
                            </section>

                            <!-- Specification Section -->
                            <section class="specification-section">
                                <div class="product-specs">
                                    <div class="spec-row"><span class="spec-label">Rate</span><span class="spec-value">US$
                                            {{ number_format($product->unit_price, 2) ?? '' }}/
                                            {{ $product->unit ?? '' }}</span>
                                    </div>
                                    @php
                                        $countryDetails = \App\Utils\ChatManager::getCountryDetails($product->origin);
                                    @endphp
                                    <div class="spec-row">
                                        <span class="spec-label">Product Origin</span>
                                        <span class="spec-value">
                                            <img src="/flags/{{ strtolower($countryDetails['countryISO2']) }}.svg"
                                                class="flag-icon mr-2" alt="{{ $countryDetails['countryName'] }} flag"
                                                style="width: 25px;" />
                                            {{ $countryDetails['countryName'] ?? 'Invalid Country Name' }}
                                        </span>
                                    </div>
                                    <div class="spec-row"><span class="spec-label">Port of Loading</span><span
                                            class="spec-value">{{ $product->port_of_loading ?? '' }}</span></div>
                                    <div class="spec-row"><span class="spec-label">MOQ</span><span
                                            class="spec-value">{{ $product->minimum_order_qty ?? '' }}
                                            {{ $product->unit ?? '' }}</span></div>
                                    <div class="spec-row"><span class="spec-label">Delivery Mode</span><span
                                            class="spec-value">{{ $product->delivery_mode ?? '' }}</span></div>
                                </div>
                            </section>

                            <section class="specification-section">
                                <div class="product-specs">
                                    <div class="spec-row"><span class="spec-label">Payment Term</span>
                                        <span class="spec-value">{{ $product->payment_terms ?? '' }}
                                        </span>
                                    </div>
                                    <div class="spec-row"><span class="spec-label">Lead Time</span>
                                        <span class="spec-value">{{ $product->lead_time ?? '' }}
                                            {{ $product->lead_time_unit ?? '' }}
                                        </span>
                                    </div>
                                </div>
                            </section>
                            <div class="d-flex">
                                <div style="flex-grow: 1;">
                                    <section class="specification-section">
                                        <div class="product-specs">
                                            <div class="spec-row">
                                                <span class="spec-label">Supply Capacity</span>
                                                <span class="spec-value">{{ $product->supply_capacity ?? '-' }}
                                                    {{ $product->supply_unit ?? '' }}</span>
                                            </div>
                                            <div class="spec-row">
                                                <span class="spec-label">Weight per Unit</span>
                                                <span class="spec-value">{{ $product->weight_per_unit ?? '-' }}</span>
                                            </div>
                                            <div class="spec-row">
                                                <span class="spec-label">Master Packing</span>
                                                <span class="spec-value">{{ $product->master_packing ?? '-' }} per
                                                    {{ $product->dimension_unit ?? '' }}</span>
                                            </div>
                                            <div class="spec-row">
                                                <span class="spec-label">Container</span>
                                                <span class="spec-value">{{ $product->container ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </section>

                                    <!-- Packing Info -->
                                    <section class="specification-section">
                                        {{-- <h4 class="section-title">Packing Information</h4> --}}
                                        <div class="product-specs">
                                            <div class="spec-row"><span class="spec-label">Packing Material:</span><span
                                                    class="spec-value">{{ $product->container ?? '' }}</span></div>
                                            <div class="spec-row"><span class="spec-label">Packing Type:</span><span
                                                    class="spec-value">{{ $product->packing_type ?? '' }}</span></div>
                                            {{-- <div class="spec-row"><span class="spec-label">Master Packing:</span><span
                                                    class="spec-value">{{ $product->master_packing ?? ''}} per {{ $product->dimension_unit ?? ''}}</span></div> --}}
                                        </div>
                                    </section>
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
                                </div>
                                <div class="supplier-info" id="sticky-supplier-info">
                                    @php
                                        $isAdmin = $product->added_by === 'admin';
                                        $vendorExtra = \App\Models\VendorExtraDetail::where(
                                            'seller_id',
                                            $product->user_id,
                                        )->first();
                                    @endphp

                                    <div class="supplier-header">
                                        <div class="supplier-name">
                                            {{ $isAdmin ? 'Admin Shop' : $product->seller->shop->name ?? 'N/A' }}
                                        </div>
                                        <div class="contact-person">
                                            {{ $vendorExtra->contact_person_name ?? 'N/A' }}
                                        </div>
                                    </div>

                                    <div class="supplier-meta">
                                        <span class="years">
                                            Since {{ $isAdmin ? 'Admin' : $product->seller->years . ' years' }}
                                            in {{ $vendorExtra->city ?? 'N/A' }},
                                            {{ $isAdmin ? 'DealRockets' : $vendorExtra->country_of_registration ?? 'N/A' }}
                                        </span>
                                    </div>

                                    <div class="response-data">
                                        <div class="response-rate">
                                            <span class="label">Response Rate:</span>
                                            <span class="value">High</span>
                                        </div>
                                        <div class="response-time">
                                            <span class="label">Avg Response Time:</span>
                                            <span class="value">≤24 h</span>
                                        </div>
                                    </div>

                                    <div class="subplier-btn"
                                        style="display: flex; flex-direction: column; justify-content: start;">
                                        <div class="business-type">
                                            <span class="label">Business Type:</span>
                                            <span class="value">{{ $vendorExtra->business_type ?? 'N/A' }}</span>
                                        </div>

                                        <div class="supplier-actions">
                                            @if (!$isAdmin && isset($product->seller->shop->id))
                                                <a href="{{ route('shopView', ['id' => $product->seller->shop->id]) }}"
                                                    class="btn-outline">Shop</a>
                                            @endif
                                            {{-- <button class="btn-outline">Chat</button> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Description Section -->
                <div class="product-description" style="flex-direction: column;">
                    <div class="d-flex w-100 gap-3 spec-section">
                        {{-- Left Section: Technical Details --}}
                        <div class="spec-left">
                            <h4 class="section-title">Specification</h4>
                            <div class="specs-tables">
                                @php
                                    $additionalDetailsArray = json_decode($product->dynamic_data, true) ?? [];
                                @endphp

                                @if (!empty($additionalDetailsArray) && is_array($additionalDetailsArray))
                                    @foreach ($additionalDetailsArray as $item)
                                        <table class="specs-table">
                                            @php
                                                $subheads = $item['sub_heads'] ?? [];
                                                $countofsubheads = count($subheads);
                                            @endphp
                                            @foreach ($subheads as $index => $subhead)
                                                <tr>
                                                    @if ($index == 0 && isset($item['title']))
                                                        <th rowspan="{{ $countofsubheads }}">
                                                            {{ $item['title'] }}
                                                        </th>
                                                    @endif
                                                    <td class="spec-name">
                                                        {{ $subhead['sub_head'] ?? '-' }}</td>
                                                    <td class="spec-detail">
                                                        {{ $subhead['sub_head_data'] ?? '-' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    @endforeach
                                @else
                                    <p class="text-muted">No technical details available.</p>
                                @endif
                            </div>
                        </div>

                        {{-- Right Section: Additional Details --}}
                        <div class="spec-right">
                            <h4 class="section-title">Technical Specification</h4>
                            <div class="specs-tables">
                                @php
                                    $additionalDetailsArray1 =
                                        json_decode($product->dynamic_data_technical, true) ?? [];
                                @endphp

                                @if (!empty($additionalDetailsArray1) && is_array($additionalDetailsArray1))
                                    @foreach ($additionalDetailsArray1 as $item)
                                        <table class="specs-table">
                                            @php
                                                $subheads1 = $item['sub_heads'] ?? [];
                                                $countofsubheads1 = count($subheads1);
                                            @endphp
                                            @foreach ($subheads1 as $index => $subhead)
                                                <tr>
                                                    @if ($index == 0 && isset($item['title']))
                                                        <th rowspan="{{ $countofsubheads1 }}">
                                                            {{ $item['title'] }}
                                                        </th>
                                                    @endif
                                                    <td class="spec-name">
                                                        {{ $subhead['sub_head'] ?? '-' }}</td>
                                                    <td class="spec-detail">
                                                        {{ $subhead['sub_head_data'] ?? '-' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    @endforeach
                                @else
                                    <p class="text-muted">No additional details available.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="product-div">
                        <div class="description-tabs">
                            {{-- <div class="tab" data-toggleid="productDescription">Product Description</div> --}}
                            <div class="tab active" data-toggleid="companyInfo">Company Profile</div>
                            <div class="tab" data-toggleid="productGallery">Product Gallery</div>
                        </div>
                        <div class="tabdata" id="productDescription" style="display: none;">
                            <div class="description-content p-4 space-y-4">
                                <div class="description-section" style="padding-bottom: 20px;">

                                </div>

                                @if (!empty($product->short_details))
                                    <div class="description-section">
                                        <h5 class="section-subtitle">Quick Overview</h5>
                                        <p class="text-muted">{!! $product->short_details !!}</p>
                                    </div>
                                @endif

                                @if (!empty($product->details))
                                    <div class="description-section">
                                        <h5 class="section-subtitle">Product Description</h5>
                                        <p>{!! $product->details !!}</p>
                                    </div>
                                @endif

                                @php
                                    $images = json_decode($product->certificates, true); // or $product->certificates
                                @endphp

                                @if (!empty($images) && is_array($images))
                                    <div class="product-image-gallery space-y-4">
                                        <h4 class="section-subtitle">Certificates</h4>
                                        <div class="image-gallery-preview">
                                            <img id="mainPreview" src="{{ asset('storage/' . $images[0]) }}"
                                                alt="Main Preview">
                                        </div>

                                        <div class="thumbnail-row flex flex-wrap gap-2 justify-start d-flex">
                                            @foreach ($images as $image)
                                                <div class="thumb border rounded cursor-pointer overflow-hidden">
                                                    <img src="{{ asset('storage/' . $image) }}" alt="Thumbnail"
                                                        style="height: 100px;"
                                                        class="w-20 h-20 object-cover hover:opacity-75 transition"
                                                        onclick="document.getElementById('mainPreview').src = this.src;">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <div class="description-section mt-3">
                                    <h5 class="section-subtitle">Business Information</h5>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="spec-row">
                                            <div class="spec-label">Place of Loading</div>
                                            <div class="spec-value">{{ $product->place_of_loading ?? '-' }}</div>
                                        </div>
                                        <div class="spec-row">
                                            <div class="spec-label">Delivery Terms</div>
                                            <div class="spec-value">{{ $product->delivery_terms ?? '-' }}</div>
                                        </div>
                                        <div class="spec-row">
                                            <div class="spec-label">Packing Type</div>
                                            <div class="spec-value">{{ $product->packing_type ?? '-' }}</div>
                                        </div>
                                        <div class="spec-row">
                                            <div class="spec-label">Local Currency</div>
                                            <div class="spec-value">{{ $product->local_currency ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tabdata" id="companyInfo">
                            <div class="product-div">
                                <div class="vender-contact">
                                    <div class="contact-section">
                                        <div class="contact-left">
                                            <h3>Contact Details</h3>
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <p><strong>Address</strong>
                                                        <span class="contact-text">
                                                            {{ $shopInfoArray['company_profiles']->address ?? 'N/A' }}
                                                        </span>
                                                    </p>

                                                    <p><strong>Local Time</strong>
                                                        <span class="contact-text">
                                                            {{ $shopInfoArray['company_profiles']->local_time ?? 'N/A' }}
                                                        </span>
                                                    </p>

                                                    <p><strong>Showroom</strong>
                                                        <span class="contact-text">
                                                            {{ $shopInfoArray['company_profiles']->showroom ?? 'N/A' }}
                                                        </span>
                                                    </p>

                                                    <p><strong>Website</strong>
                                                        <span class="contact-text">
                                                            @if (!empty($shopInfoArray['company_profiles']->website))
                                                                <a href="{{ $shopInfoArray['company_profiles']->website }}"
                                                                    target="_blank">
                                                                    {{ $shopInfoArray['company_profiles']->website }}
                                                                </a>
                                                            @else
                                                                N/A
                                                            @endif
                                                        </span>
                                                    </p>

                                                    @if (auth()->check())
                                                        <div class="private-info-box">
                                                            <p><strong>Telephone</strong>
                                                                <span class="contact-text margin-l">
                                                                    {{ $shopInfoArray['company_profiles']->telephone ?? 'N/A' }}
                                                                </span>
                                                            </p>

                                                            <p><strong>Mobile Phone</strong>
                                                                <span class="contact-text margin-l">
                                                                    {{ $shopInfoArray['company_profiles']->mobile ?? 'N/A' }}
                                                                </span>
                                                            </p>

                                                            <p><strong>Fax</strong>
                                                                <span class="contact-text margin-l">
                                                                    {{ $shopInfoArray['company_profiles']->fax ?? 'N/A' }}
                                                                </span>
                                                            </p>

                                                            <p><strong>Alternate Contact</strong>
                                                                <span class="contact-text margin-l">
                                                                    {{ $shopInfoArray['company_profiles']->alternate_contact ?? 'N/A' }}
                                                                </span>
                                                            </p>
                                                        </div>
                                                    @else
                                                        <p><button class="sign-in-btn">Sign In to View Phone &
                                                                Email</button>
                                                        </p>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p><strong>Factory Size</strong>
                                                        <span class="contact-text margin-l">
                                                            {{ $shopInfoArray['company_profiles']->factory_size ?? 'N/A' }}
                                                        </span>
                                                    </p>
                                                    <p><strong>Year Established</strong>
                                                        <span class="contact-text margin-l">
                                                            {{ $shopInfoArray['company_profiles']->year_established ?? 'N/A' }}
                                                        </span>
                                                    </p>
                                                    <p><strong>Total Employees</strong>
                                                        <span class="contact-text margin-l">
                                                            {{ $shopInfoArray['company_profiles']->total_employees ?? 'N/A' }}
                                                        </span>
                                                    </p>
                                                    <p><strong>Production Lines</strong>
                                                        <span class="contact-text margin-l">
                                                            {{ $shopInfoArray['company_profiles']->production_lines ?? 'N/A' }}
                                                        </span>
                                                    </p>
                                                    <p><strong>Monthly Output</strong>
                                                        <span class="contact-text margin-l">
                                                            {{ $shopInfoArray['company_profiles']->monthly_output ?? 'N/A' }}
                                                        </span>
                                                    </p>
                                                    <p><strong>Total Annual Sales</strong>
                                                        <span class="contact-text margin-l">
                                                            {{ $shopInfoArray['company_profiles']->total_annual_sales ?? 'N/A' }}
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="contact-right">
                                            <h3>Contact Person</h3>
                                            <div class="contact-person">
                                                <div class="text-end">
                                                    <p class="name">
                                                        {{ $shopInfoArray['company_profiles']->contact_name ?? 'N/A' }}
                                                    </p>
                                                    <p class="position">
                                                        {{ $shopInfoArray['company_profiles']->contact_dept ?? 'N/A' }}
                                                    </p>
                                                </div>
                                                <div class="avatar-placeholder"></div>
                                            </div>

                                            <p><strong>Email:</strong>
                                                @if (auth()->check())
                                                    <span class="contact-text">
                                                        {{ $shopInfoArray['company_profiles']->email ?? 'N/A' }}
                                                    </span>
                                                @else
                                                    <button class="sign-in-btn">Sign In for Email</button>
                                                @endif
                                            </p>

                                            <button class="contact-now-btn" data-toggle="modal"
                                                data-target="#inquiryModal">
                                                Contact Now
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tabdata" id="productGallery" style="display: none;">
                            @php
                                $images = json_decode($product->extra_images, true); // or $product->certificates
                            @endphp

                            @if (!empty($images) && is_array($images))
                                <div class="product-image-gallery space-y-4">
                                    {{-- Main Preview Image --}}
                                    <div class="image-gallery-preview">
                                        <img id="mainPreview" src="{{ asset('storage/' . $images[0]) }}"
                                            alt="Main Preview">
                                    </div>

                                    {{-- Thumbnails --}}
                                    <div class="thumbnail-row flex flex-wrap gap-2 justify-start d-flex">
                                        @foreach ($images as $image)
                                            <div class="thumb border rounded cursor-pointer overflow-hidden">
                                                <img src="{{ asset('storage/' . $image) }}" alt="Thumbnail"
                                                    style="height: 100px;"
                                                    class="w-20 h-20 object-cover hover:opacity-75 transition"
                                                    onclick="document.getElementById('mainPreview').src = this.src;">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
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
            </div>
        </div>
    </div>
    @include('web-views.partials._order-now')
    <div style="max-width: 1440px; margin: 0 auto; padding-bottom: 60px;">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header" style="background-color:rgba(235, 235, 235, 1);">
                <h5 class="modal-title" id="inquiryModalLabel">Send a direct inquiry to this
                    supplier</h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="supplier" class="form-label">To</label>
                        <div class="form-control">{{ $isAdmin == 1 ? 'Admin Shop' : $product->seller->shop->name }}
                        </div>
                    </div>
                    @php
                        $userdata = \App\Utils\ChatManager::getRoleDetail();
                        $userId = $userdata['user_id'] ?? null;
                        $role = $userdata['role'] ?? null;
                    @endphp
                    <!-- Hidden fields -->
                    <input type="hidden" id="sender_id" name="sender_id" value={{ $userId }}>
                    <input type="hidden" id="sender_type" name="sender_type" value={{ $role }}>
                    <input type="hidden" id="receiver_id" name="receiver_id" value={{ $product->user_id }}>
                    <input type="hidden" id="receiver_type" name="receiver_type" value={{ $product->added_by }}>
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
                            <button type="button" onclick="triggerChat()" class="btn-inquire-now btn">Send Inquiry
                                Now</button>
                        @else
                            <a href="{{ route('membership') }}" class="btn-inquire-now btn">Send Inquiry
                                Now</a>
                        @endif
                    @else
                        <button type="button" onclick="sendtologin()" class="btn-inquire-now btn">Send
                            Inquiry Now</button>
                    @endif
                </form>
            </div>

        </div>
    </div>
    <div id="imageGalleryModal" class="gallery-modal" style="display: none;">
        <div class="gallery-overlay" onclick="closeGallery()"></div>
        <div class="gallery-content">
            <span class="close-btn" onclick="closeGallery()">×</span>

            <!-- Main Large Image -->
            <div class="main-image-container">
                <img id="mainGalleryImage" src="" alt="Main View">
            </div>

            <!-- Thumbnails -->
            <div class="gallery-thumbnails" id="galleryImages"></div>
        </div>
    </div>
    <div class="modal fade" id="inquiryModal" tabindex="-1" aria-labelledby="inquiryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header" style="background-color:rgba(235, 235, 235, 1);">
                    <h5 class="modal-title" id="inquiryModalLabel">Send a direct inquiry to this
                        supplier</h5>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="inquiryForm">
                        <div class="mb-3">
                            <label for="supplier" class="form-label">To</label>
                            <div class="form-control">{{ $isAdmin == 1 ? 'Admin Shop' : $product->seller->shop->name }}
                            </div>
                        </div>
                        @php
                            $userdata = \App\Utils\ChatManager::getRoleDetail();
                            $userId = $userdata['user_id'] ?? null;
                            $role = $userdata['role'] ?? null;
                        @endphp
                        <!-- Hidden fields -->
                        <input type="hidden" id="sender_id" name="sender_id" value={{ $userId }}>
                        <input type="hidden" id="sender_type" name="sender_type" value={{ $role }}>
                        <input type="hidden" id="receiver_id" name="receiver_id" value={{ $product->user_id }}>
                        <input type="hidden" id="receiver_type" name="receiver_type" value={{ $product->added_by }}>
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
                                <button type="button" onclick="triggerChat()" class="btn-inquire-now btn">Send Inquiry
                                    Now</button>
                            @else
                                <a href="{{ route('membership') }}" class="btn-inquire-now btn">Send Inquiry
                                    Now</a>
                            @endif
                        @else
                            <button type="button" onclick="sendtologin()" class="btn-inquire-now btn">Send
                                Inquiry Now</button>
                        @endif
                    </form>
                </div>

            </div>
        </div>
    </div>

    @if ($product?->preview_file_full_url['path'])
        @include('web-views.partials._product-preview-modal', [
            'previewFileInfo' => $previewFileInfo,
        ])
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
    <script>
        const allImages = {!! json_encode($productArray) !!};

        function openGallery(startIndex = 0) {
            const gallery = document.getElementById('galleryImages');
            const mainImage = document.getElementById('mainGalleryImage');

            // Set the main image initially
            mainImage.src = `/storage/${allImages[startIndex]}`;
            mainImage.alt = `Image ${startIndex + 1}`;

            // Clear and rebuild thumbnails
            gallery.innerHTML = '';

            allImages.forEach((src, i) => {
                const thumb = document.createElement('img');
                thumb.src = `/storage/${src}`;
                thumb.alt = `Thumbnail ${i + 1}`;
                thumb.onclick = () => {
                    mainImage.src = `/storage/${src}`;
                    mainImage.alt = `Image ${i + 1}`;
                };
                gallery.appendChild(thumb);
            });

            document.getElementById('imageGalleryModal').style.display = 'flex';
        }

        function closeGallery() {
            document.getElementById('imageGalleryModal').style.display = 'none';
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            try {
                const supplierInfo = document.getElementById("sticky-supplier-info");

                if (!supplierInfo) {
                    console.error("Element with ID 'sticky-supplier-info' not found.");
                    return;
                }

                const stickyOffset = supplierInfo.offsetTop;

                const updateStuckPosition = () => {
                    const container = document.querySelector('.mainpagesection');
                    if (!container) {
                        console.warn("'.container' element not found.");
                        return;
                    }

                    const containerRect = container.getBoundingClientRect();
                    const rightOffset = window.innerWidth - containerRect.right + 15;

                    if (supplierInfo.classList.contains('stuck')) {
                        supplierInfo.style.right = `${rightOffset}px`;
                        console.log("Updated supplierInfo right offset to", rightOffset);
                    } else {
                        supplierInfo.style.right = '';
                        console.log("Removed supplierInfo right offset");
                    }
                };

                window.addEventListener("scroll", function() {
                    if (window.innerWidth > 1024) {
                        if (window.pageYOffset > stickyOffset) {
                            if (!supplierInfo.classList.contains("stuck")) {
                                console.log("Applying stuck class to supplierInfo");
                            }
                            supplierInfo.classList.add("stuck");
                            updateStuckPosition();
                        } else {
                            if (supplierInfo.classList.contains("stuck")) {
                                console.log("Removing stuck class from supplierInfo");
                            }
                            supplierInfo.classList.remove("stuck");
                            supplierInfo.style.right = '';
                        }
                    } else {
                        supplierInfo.classList.remove("stuck");
                        supplierInfo.style.right = '';
                        console.log("Window width <= 1024, removing 'stuck' class");
                    }
                });

                window.addEventListener("resize", function() {
                    if (window.innerWidth <= 1024) {
                        supplierInfo.classList.remove("stuck");
                        supplierInfo.style.right = '';
                        console.log("Window resized below 1024, removing 'stuck'");
                    } else {
                        console.log("Window resized above 1024, updating position");
                        updateStuckPosition();
                    }
                });
            } catch (error) {
                console.error("Sticky Supplier Info Script Error:", error);
            }
        });
    </script>
@endpush
