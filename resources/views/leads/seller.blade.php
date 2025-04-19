@extends('layouts.front-end.app')
@section('title', translate('Sellers' . ' | ' . $web_config['name']->value))
@push('css_or_js')
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/ai/sale-offer.css') }}" />
@endpush
@section('content')
    <section class="mainpagesection sale-offer-page" style="background-color: unset;">
        <div class="sell-offer">
            <div id="sidebarFilters" class="sidebarf-for d-none">

            </div>
            <div class="main-content">
                <!-- Sidebar -->

                <div class="hidden">
                    <div class="search-box " style="width: 65%;">
                        <input type="text" placeholder="Search...">
                        <button class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                    <div class="search-box hidden">
                        <!-- <input type="text" placeholder="Search..."> -->
                        <button id="toggleSidebarBtn" class="filters-btn">
                            Filters <i class="fa-solid fa-sort-amount-down"></i>
                        </button>
                    </div>
                </div>
                <div class="sidebar desktop-sidebar" id="sidebar-mobile-content-saleoffer">
                    <!-- Search by Name -->
                    <div class="search-section hidebelow926">
                        <h3>Search by Name</h3>
                        <div class="search-box">
                            <input type="text" placeholder="Search...">
                            <button class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </div>


                    <!-- Filter By Country -->
                    <div class="search-section">
                        <h3>Filter By Country</h3>
                        <div class="search-box">
                            <input type="text" placeholder="Search...">
                            <button class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                        <div class="checkbox-list">
                            <label class="checkbox-item checked">
                                <input type="checkbox" checked>
                                <span class="checkbox-custom"></span>
                                United States
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox">
                                <span class="checkbox-custom"></span>
                                United Kingdom
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox">
                                <span class="checkbox-custom"></span>
                                China
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox">
                                <span class="checkbox-custom"></span>
                                Russia
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox">
                                <span class="checkbox-custom"></span>
                                Australia
                            </label>
                        </div>
                    </div>

                    <!-- Search by Category -->
                    <div class="search-section">
                        <h3>Search by Category</h3>
                        <div class="search-box">
                            <input type="text" placeholder="Search...">
                            <button class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                        <div class="checkbox-list">
                            <label class="checkbox-item checked">
                                <input type="checkbox" checked>
                                <span class="checkbox-custom"></span>
                                Agriculture
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox">
                                <span class="checkbox-custom"></span>
                                Fashion Accessories
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox">
                                <span class="checkbox-custom"></span>
                                Furniture
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox">
                                <span class="checkbox-custom"></span>
                                Trade Services
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox">
                                <span class="checkbox-custom"></span>
                                Health & Medical
                            </label>
                        </div>
                    </div>

                    <!-- Sidebar Banners -->
                    <div class="sidebar-banner">
                        <img src="/img/vendor-ad.png" alt="Samsung TV Sale">
                    </div>
                    <div class="sidebar-banner">
                        <img src="/img/small-ad.png" alt="Phone Promotion">
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="products-section">
                    <!-- Product Cards -->
                    <div id="product-list">
                        <div class="product-card">
                            <div class="product-image-col">
                                <h3 class="product-title">Offering TCL Television @ $100</h3>
                                <div>
                                    <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/247ec7c7bc1f6428f4d5acb3c10d89df21f5e0ba?placeholderIfAbsent=true"
                                        alt="${product.title}" class="product-image">
                                </div>
                                <div class="product-location">
                                    <div>Location:</div>
                                    <i class="fas fa-map-marker-alt location-icon"></i>
                                    <div>New York, US</div>
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
                                        <td class="detail-value">32' Inch</td>
                                    </tr>
                                    <tr>
                                        <td class="detail-label">Type</td>
                                        <td class="detail-value">Smart</td>
                                    </tr>
                                    <tr>
                                        <td class="detail-label">Terms</td>
                                        <td class="detail-value">Ex Stock</td>
                                    </tr>
                                    <tr>
                                        <td class="detail-label">Payment</td>
                                        <td class="detail-value">Ex Stock</td>
                                    </tr>
                                    <tr>
                                        <td class="detail-label">Brand</td>
                                        <td class="detail-value">TCL</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="hidebelow926 contact-seller-col">
                                <i class="far fa-heart favorite-icon"></i>

                                <button class="contact-btn">Contact Seller</button>
                                <div class="seller-name">John Doe</div>
                                <div class="company-name">Shenzhen Inzok Electron Co.,Ltd</div>
                            </div>
                        </div>
                        <div class="product-card">
                            <div class="product-image-col">
                                <h3 class="product-title">Offering TCL Television @ $100</h3>
                                <div>
                                    <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/247ec7c7bc1f6428f4d5acb3c10d89df21f5e0ba?placeholderIfAbsent=true"
                                        alt="${product.title}" class="product-image">
                                </div>
                                <div class="product-location">
                                    <div>Location:</div>
                                    <i class="fas fa-map-marker-alt location-icon"></i>
                                    <div>New York, US</div>
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
                                        <td class="detail-value">32' Inch</td>
                                    </tr>
                                    <tr>
                                        <td class="detail-label">Type</td>
                                        <td class="detail-value">Smart</td>
                                    </tr>
                                    <tr>
                                        <td class="detail-label">Terms</td>
                                        <td class="detail-value">Ex Stock</td>
                                    </tr>
                                    <tr>
                                        <td class="detail-label">Payment</td>
                                        <td class="detail-value">Ex Stock</td>
                                    </tr>
                                    <tr>
                                        <td class="detail-label">Brand</td>
                                        <td class="detail-value">TCL</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="hidebelow926 contact-seller-col">
                                <i class="far fa-heart favorite-icon"></i>

                                <button class="contact-btn">Contact Seller</button>
                                <div class="seller-name">John Doe</div>
                                <div class="company-name">Shenzhen Inzok Electron Co.,Ltd</div>
                            </div>
                        </div>
                        <div class="product-card">
                            <div class="product-image-col">
                                <h3 class="product-title">Offering TCL Television @ $100</h3>
                                <div>
                                    <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/247ec7c7bc1f6428f4d5acb3c10d89df21f5e0ba?placeholderIfAbsent=true"
                                        alt="${product.title}" class="product-image">
                                </div>
                                <div class="product-location">
                                    <div>Location:</div>
                                    <i class="fas fa-map-marker-alt location-icon"></i>
                                    <div>New York, US</div>
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
                                        <td class="detail-value">32' Inch</td>
                                    </tr>
                                    <tr>
                                        <td class="detail-label">Type</td>
                                        <td class="detail-value">Smart</td>
                                    </tr>
                                    <tr>
                                        <td class="detail-label">Terms</td>
                                        <td class="detail-value">Ex Stock</td>
                                    </tr>
                                    <tr>
                                        <td class="detail-label">Payment</td>
                                        <td class="detail-value">Ex Stock</td>
                                    </tr>
                                    <tr>
                                        <td class="detail-label">Brand</td>
                                        <td class="detail-value">TCL</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="hidebelow926 contact-seller-col">
                                <i class="far fa-heart favorite-icon"></i>

                                <button class="contact-btn">Contact Seller</button>
                                <div class="seller-name">John Doe</div>
                                <div class="company-name">Shenzhen Inzok Electron Co.,Ltd</div>
                            </div>
                        </div>
                        <div class="product-card">
                            <div class="product-image-col">
                                <h3 class="product-title">Offering TCL Television @ $100</h3>
                                <div>
                                    <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/247ec7c7bc1f6428f4d5acb3c10d89df21f5e0ba?placeholderIfAbsent=true"
                                        alt="${product.title}" class="product-image">
                                </div>
                                <div class="product-location">
                                    <div>Location:</div>
                                    <i class="fas fa-map-marker-alt location-icon"></i>
                                    <div>New York, US</div>
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
                                        <td class="detail-value">32' Inch</td>
                                    </tr>
                                    <tr>
                                        <td class="detail-label">Type</td>
                                        <td class="detail-value">Smart</td>
                                    </tr>
                                    <tr>
                                        <td class="detail-label">Terms</td>
                                        <td class="detail-value">Ex Stock</td>
                                    </tr>
                                    <tr>
                                        <td class="detail-label">Payment</td>
                                        <td class="detail-value">Ex Stock</td>
                                    </tr>
                                    <tr>
                                        <td class="detail-label">Brand</td>
                                        <td class="detail-value">TCL</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="hidebelow926 contact-seller-col">
                                <i class="far fa-heart favorite-icon"></i>

                                <button class="contact-btn">Contact Seller</button>
                                <div class="seller-name">John Doe</div>
                                <div class="company-name">Shenzhen Inzok Electron Co.,Ltd</div>
                            </div>
                        </div>
                        <div class="product-card">
                            <div class="product-image-col">
                                <h3 class="product-title">Offering TCL Television @ $100</h3>
                                <div>
                                    <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/247ec7c7bc1f6428f4d5acb3c10d89df21f5e0ba?placeholderIfAbsent=true"
                                        alt="${product.title}" class="product-image">
                                </div>
                                <div class="product-location">
                                    <div>Location:</div>
                                    <i class="fas fa-map-marker-alt location-icon"></i>
                                    <div>New York, US</div>
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
                                        <td class="detail-value">32' Inch</td>
                                    </tr>
                                    <tr>
                                        <td class="detail-label">Type</td>
                                        <td class="detail-value">Smart</td>
                                    </tr>
                                    <tr>
                                        <td class="detail-label">Terms</td>
                                        <td class="detail-value">Ex Stock</td>
                                    </tr>
                                    <tr>
                                        <td class="detail-label">Payment</td>
                                        <td class="detail-value">Ex Stock</td>
                                    </tr>
                                    <tr>
                                        <td class="detail-label">Brand</td>
                                        <td class="detail-value">TCL</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="hidebelow926 contact-seller-col">
                                <i class="far fa-heart favorite-icon"></i>

                                <button class="contact-btn">Contact Seller</button>
                                <div class="seller-name">John Doe</div>
                                <div class="company-name">Shenzhen Inzok Electron Co.,Ltd</div>
                            </div>
                        </div>
                        
                    </div>

                    <!-- Pagination -->
                    <div class="pagination">
                        <div class="items-per-page">Items Per Page: 12</div>
                        <div class="page-controls">
                            <button class="pagination-arrow" id="prev-page">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button class="pagination-number ">1</button>
                            <button class="pagination-number">2</button>
                            <button class="pagination-number hide-num">3</button>
                            <button class="pagination-number hide-num">4</button>
                            <button class="pagination-number hide-num">5</button>
                            <span class="pagination-ellipsis">...</span>
                            <div class="pagination-total">276</div>
                            <button class="pagination-arrow" id="next-page">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('leads.partials.selloffer-view')
    </section>
    @include('web-views.partials._quotation')
    {{-- Import Modals --}}
    {{-- End Import Modals --}}
@endsection
@push('script')
    <script src="{{ theme_asset('js/sale-offer.js') }}"></script>
@endpush
