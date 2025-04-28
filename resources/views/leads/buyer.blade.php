@extends('layouts.front-end.app')
@section('title',translate('Buyers'. ' | ' . $web_config['name']->value))
@push('css_or_js')
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/ai/buyer.css') }}" />
@endpush
@section('content')
<section class="mainpagesection buy-offer" style="margin-top: 20px; background-color: unset;">
    <div class="flex">

        <div class="search-and-filters-container">
          <!-- Search Box -->
          <div class ="search-box" >
            <!-- Search Icon SVG -->
            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" fill="black" style="margin-right: 6px;" viewBox="0 0 24 24">
              <path d="M21 21L15.8 15.8M18 10.5A7.5 7.5 0 1 1 3 10.5a7.5 7.5 0 0 1 15 0Z" stroke="black" stroke-width="2" fill="none"></path>
            </svg>
            <input type="text" placeholder="Search by Name" style="border: none; outline: none;">
          </div>
        
          <!-- Filters Button -->
          <button class ="filters-button">
            Filters
            <!-- Filter Icon SVG -->
            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" fill="black" viewBox="0 0 24 24">
              <path d="M3 5h18M6 12h12M10 19h4" stroke="black" stroke-width="2" fill="none" stroke-linecap="round"></path>
            </svg>
          </button>
        </div>
        <!-- Left sidebar column -->
        <div class="sidebar">
          <aside>
            <div class="sidebar-inner">
              <div class="sidebar-content">
                <!-- Search by Name -->
                <div class="search-input-container">
                  <label class="search-label" for="search-search-by-name">Search by Name</label>
                  <div class="search-field">
                    <div class="search-wrapper">
                      <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/3a64a9fd31e748785a7a5dadd46ebd0f926050b9?placeholderIfAbsent=true" alt="Search icon" class="search-icon">
                      <input type="text" id="search-search-by-name" placeholder="Search..." class="search-input">
                    </div>
                  </div>
                </div>
                
                <!-- Filter By Country -->
                <div class="filter-group">
                  <h3 class="filter-title">Filter By Country</h3>
                  <div class="search-field">
                    <div class="search-wrapper">
                      <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/3a64a9fd31e748785a7a5dadd46ebd0f926050b9?placeholderIfAbsent=true" alt="Search icon" class="search-icon">
                      <input type="text" placeholder="Search countries..." class="search-input">
                    </div>
                  </div>
                  <div class="checkboxes-container">
                    <!-- <fieldset> -->
                      <label class="sr-only">Select countries</label>
                      <!-- United States -->
                      <div class="checkbox-item">
                        <div class="custom-checkbox selected" data-id="1">
                          <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/fa3fb47b92badc40c5a98d6513d0cc4689a59f45?placeholderIfAbsent=true" alt="Selected checkbox">
                        </div>
                        <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/310ff89f1dff8af2e8a965f3f1d0004b43241166?placeholderIfAbsent=true" alt="United States flag" class="flag-icon">
                        <div class="my-auto">United States</div>
                      </div>
                      <!-- United Kingdom -->
                      <div class="checkbox-item">
                        <div class="custom-checkbox" data-id="2"></div>
                        <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/ea9b135ec0849f3a59662b5bd96bfd4b0dbc5008?placeholderIfAbsent=true" alt="United Kingdom flag" class="flag-icon">
                        <div class="my-auto">United Kingdom</div>
                      </div>
                      <!-- China -->
                      <div class="checkbox-item">
                        <div class="custom-checkbox" data-id="3"></div>
                        <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/2cfe57c20dfb273b3473cef35f7ff35cfdc75ad5?placeholderIfAbsent=true" alt="China flag" class="flag-icon">
                        <div class="my-auto">China</div>
                      </div>
                      <!-- Russia -->
                      <div class="checkbox-item">
                        <div class="custom-checkbox" data-id="4"></div>
                        <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/fca9c4ace3664357f9afbdc2e4b909a471f7a1af?placeholderIfAbsent=true" alt="Russia flag" class="flag-icon">
                        <div class="my-auto">Russia</div>
                      </div>
                      <!-- Australia -->
                      <div class="checkbox-item">
                        <div class="custom-checkbox" data-id="5"></div>
                        <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/84d7c1d487ad1947937ba29db5084ff668eed82d?placeholderIfAbsent=true" alt="Australia flag" class="flag-icon">
                        <div class="my-auto">Australia</div>
                      </div>
                    <!-- </fieldset> -->
                  </div>
                </div>
                
                <!-- Search by Category -->
                <div class="filter-group">
                  <h3 class="filter-title">Search by Category</h3>
                  <div class="search-field">
                    <div class="search-wrapper">
                      <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/3a64a9fd31e748785a7a5dadd46ebd0f926050b9?placeholderIfAbsent=true" alt="Search icon" class="search-icon">
                      <input type="text" placeholder="Search categories..." class="search-input">
                    </div>
                  </div>
                  <div class="checkboxes-container">
                    <!-- <fieldset> -->
                      <label class="sr-only">Select categories </label>
                      <!-- Agriculture -->
                      <div class="checkbox-item">
                        <div class="custom-checkbox selected" data-id="1">
                          <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/fa3fb47b92badc40c5a98d6513d0cc4689a59f45?placeholderIfAbsent=true" alt="Selected checkbox">
                        </div>
                        <div>Agriculture</div>
                      </div>
                      <!-- Fashion Accessories -->
                      <div class="checkbox-item">
                        <div class="custom-checkbox" data-id="2"></div>
                        <div>Fashion Accessories</div>
                      </div>
                      <!-- Furniture -->
                      <div class="checkbox-item">
                        <div class="custom-checkbox" data-id="3"></div>
                        <div>Furniture</div>
                      </div>
                      <!-- Trade Services -->
                      <div class="checkbox-item">
                        <div class="custom-checkbox" data-id="4"></div>
                        <div>Trade Services</div>
                      </div>
                      <!-- Health & Medical -->
                      <div class="checkbox-item">
                        <div class="custom-checkbox" data-id="5"></div>
                        <div>Health & Medical</div>
                      </div>
                    <!-- </fieldset> -->
                  </div>
                </div>
              </div>
            </div>
            <div class="ad-banner">
              <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/7a9e912a4c8f6b77078cecb33ba617ba90c1939a?placeholderIfAbsent=true" alt="Advertisement">
            </div>
            <div class="ad-banner ad-banner-square">
              <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/7141cec73fbe84e43712828a78a9956ea1d034a3?placeholderIfAbsent=true" alt="Advertisement">
            </div>
          </aside>
        </div>
  
        <!-- Main content column -->
        <div class="main-content">
          <div>
            <div id="leads-container">
                <!-- Lead cards will be dynamically inserted here -->
                <article class="lead-card">
                    <div class="lead-card-inner">
                        <div class="lead-info">
                        <div class="lead-header">
                            <h2 class="lead-title">500 MT New Crop Basmati Rice Supplier</h2>
                            <div class="lead-location visibleonhigh">
                            <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/aea079960aaf6436704a53b19b29379031cce2ed?placeholderIfAbsent=true" alt="Location icon">
                            <span>Mumbai, India</span>
                            </div>
                        </div>
                        <p class="lead-description">We are looking for a trusted supplier for 500 MT of premium
                             Basmati Rice from the latest harvest. The rice should be long-grain, aromatic, 
                             well-milled, and meet international quality standards. We require competitive
                              pricing, proper packaging, and timely delivery. Interested suppliers, please
                               provide quotations, quality certifications, and delivery terms for further 
                               discussion
                        </p>
                        <div class="lead-location visibleonlow">
                            <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/aea079960aaf6436704a53b19b29379031cce2ed?placeholderIfAbsent=true" alt="Location icon">
                            <span>Mumbai, India</span>
                        </div>
                        <div class="lead-tags">
                            <span class="lead-tags-label">Tags:</span>
                            <span class="lead-tags-content">Buying Leads Supplier | Sourcing Agent Supplier | China Agent Supplier Buying Leads Supplier | Sourcing Agent Supplier | China Agent Supplier</span>
                        </div>
                        <div class="lead-details">
                            <div class="detail-group">
                            <div class="detail-row">
                                <span class="detail-label">Quantity Required:</span>
                                <span class="detail-value">500 MT</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Refundable:</span>
                                <span class="detail-value">Refundable</span>
                            </div>
                            </div>
                            <div class="detail-group">
                            <div class="detail-row">
                                <span class="detail-label">Term:</span>
                                <span class="detail-value">500 MT</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Available Stock:</span>
                                <span class="detail-value">98 kg</span>
                            </div>
                            </div>
                            <div class="detail-group">
                                <div class="detail-row">
                                    <span class="detail-label">Lead Time:</span>
                                    <span class="detail-value">10–18 days</span>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="divider"></div>
                        <div class="lead-actions">
                        <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/775ee05572e2f14d4118adf59e4ab6933d6d2125?placeholderIfAbsent=true" alt="Verified badge" class="verified-badge">
                        <button class="contact-btn ">Contact Buyer</button>
                        <div class="lead-posted">Posted: 10 days ago</div>
                        </div>
                    </div>
                </article>
                <article class="lead-card">
                    <div class="lead-card-inner">
                        <div class="lead-info">
                        <div class="lead-header">
                            <h2 class="lead-title">500 MT New Crop Basmati Rice Supplier</h2>
                            <div class="lead-location visibleonhigh">
                            <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/aea079960aaf6436704a53b19b29379031cce2ed?placeholderIfAbsent=true" alt="Location icon">
                            <span>Mumbai, India</span>
                            </div>
                        </div>
                        <p class="lead-description">We are looking for a trusted supplier for 500 MT of premium
                             Basmati Rice from the latest harvest. The rice should be long-grain, aromatic, 
                             well-milled, and meet international quality standards. We require competitive
                              pricing, proper packaging, and timely delivery. Interested suppliers, please
                               provide quotations, quality certifications, and delivery terms for further 
                               discussion
                        </p>
                        <div class="lead-location visibleonlow">
                            <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/aea079960aaf6436704a53b19b29379031cce2ed?placeholderIfAbsent=true" alt="Location icon">
                            <span>Mumbai, India</span>
                        </div>
                        <div class="lead-tags">
                            <span class="lead-tags-label">Tags:</span>
                            <span class="lead-tags-content">Buying Leads Supplier | Sourcing Agent Supplier | China Agent Supplier Buying Leads Supplier | Sourcing Agent Supplier | China Agent Supplier</span>
                        </div>
                        <div class="lead-details">
                            <div class="detail-group">
                            <div class="detail-row">
                                <span class="detail-label">Quantity Required:</span>
                                <span class="detail-value">500 MT</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Refundable:</span>
                                <span class="detail-value">Refundable</span>
                            </div>
                            </div>
                            <div class="detail-group">
                            <div class="detail-row">
                                <span class="detail-label">Term:</span>
                                <span class="detail-value">500 MT</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Available Stock:</span>
                                <span class="detail-value">98 kg</span>
                            </div>
                            </div>
                            <div class="detail-group">
                                <div class="detail-row">
                                    <span class="detail-label">Lead Time:</span>
                                    <span class="detail-value">10–18 days</span>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="divider"></div>
                        <div class="lead-actions">
                        <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/775ee05572e2f14d4118adf59e4ab6933d6d2125?placeholderIfAbsent=true" alt="Verified badge" class="verified-badge">
                        <button class="contact-btn ">Contact Buyer</button>
                        <div class="lead-posted">Posted: 10 days ago</div>
                        </div>
                    </div>
                </article>
                <article class="lead-card">
                    <div class="lead-card-inner">
                        <div class="lead-info">
                        <div class="lead-header">
                            <h2 class="lead-title">500 MT New Crop Basmati Rice Supplier</h2>
                            <div class="lead-location visibleonhigh">
                            <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/aea079960aaf6436704a53b19b29379031cce2ed?placeholderIfAbsent=true" alt="Location icon">
                            <span>Mumbai, India</span>
                            </div>
                        </div>
                        <p class="lead-description">We are looking for a trusted supplier for 500 MT of premium
                             Basmati Rice from the latest harvest. The rice should be long-grain, aromatic, 
                             well-milled, and meet international quality standards. We require competitive
                              pricing, proper packaging, and timely delivery. Interested suppliers, please
                               provide quotations, quality certifications, and delivery terms for further 
                               discussion
                        </p>
                        <div class="lead-location visibleonlow">
                            <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/aea079960aaf6436704a53b19b29379031cce2ed?placeholderIfAbsent=true" alt="Location icon">
                            <span>Mumbai, India</span>
                        </div>
                        <div class="lead-tags">
                            <span class="lead-tags-label">Tags:</span>
                            <span class="lead-tags-content">Buying Leads Supplier | Sourcing Agent Supplier | China Agent Supplier Buying Leads Supplier | Sourcing Agent Supplier | China Agent Supplier</span>
                        </div>
                        <div class="lead-details">
                            <div class="detail-group">
                            <div class="detail-row">
                                <span class="detail-label">Quantity Required:</span>
                                <span class="detail-value">500 MT</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Refundable:</span>
                                <span class="detail-value">Refundable</span>
                            </div>
                            </div>
                            <div class="detail-group">
                            <div class="detail-row">
                                <span class="detail-label">Term:</span>
                                <span class="detail-value">500 MT</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Available Stock:</span>
                                <span class="detail-value">98 kg</span>
                            </div>
                            </div>
                            <div class="detail-group">
                                <div class="detail-row">
                                    <span class="detail-label">Lead Time:</span>
                                    <span class="detail-value">10–18 days</span>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="divider"></div>
                        <div class="lead-actions">
                        <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/775ee05572e2f14d4118adf59e4ab6933d6d2125?placeholderIfAbsent=true" alt="Verified badge" class="verified-badge">
                        <button class="contact-btn ">Contact Buyer</button>
                        <div class="lead-posted">Posted: 10 days ago</div>
                        </div>
                    </div>
                </article>
                <article class="lead-card">
                    <div class="lead-card-inner">
                        <div class="lead-info">
                        <div class="lead-header">
                            <h2 class="lead-title">500 MT New Crop Basmati Rice Supplier</h2>
                            <div class="lead-location visibleonhigh">
                            <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/aea079960aaf6436704a53b19b29379031cce2ed?placeholderIfAbsent=true" alt="Location icon">
                            <span>Mumbai, India</span>
                            </div>
                        </div>
                        <p class="lead-description">We are looking for a trusted supplier for 500 MT of premium
                             Basmati Rice from the latest harvest. The rice should be long-grain, aromatic, 
                             well-milled, and meet international quality standards. We require competitive
                              pricing, proper packaging, and timely delivery. Interested suppliers, please
                               provide quotations, quality certifications, and delivery terms for further 
                               discussion
                        </p>
                        <div class="lead-location visibleonlow">
                            <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/aea079960aaf6436704a53b19b29379031cce2ed?placeholderIfAbsent=true" alt="Location icon">
                            <span>Mumbai, India</span>
                        </div>
                        <div class="lead-tags">
                            <span class="lead-tags-label">Tags:</span>
                            <span class="lead-tags-content">Buying Leads Supplier | Sourcing Agent Supplier | China Agent Supplier Buying Leads Supplier | Sourcing Agent Supplier | China Agent Supplier</span>
                        </div>
                        <div class="lead-details">
                            <div class="detail-group">
                            <div class="detail-row">
                                <span class="detail-label">Quantity Required:</span>
                                <span class="detail-value">500 MT</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Refundable:</span>
                                <span class="detail-value">Refundable</span>
                            </div>
                            </div>
                            <div class="detail-group">
                            <div class="detail-row">
                                <span class="detail-label">Term:</span>
                                <span class="detail-value">500 MT</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Available Stock:</span>
                                <span class="detail-value">98 kg</span>
                            </div>
                            </div>
                            <div class="detail-group">
                                <div class="detail-row">
                                    <span class="detail-label">Lead Time:</span>
                                    <span class="detail-value">10–18 days</span>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="divider"></div>
                        <div class="lead-actions">
                        <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/775ee05572e2f14d4118adf59e4ab6933d6d2125?placeholderIfAbsent=true" alt="Verified badge" class="verified-badge">
                        <button class="contact-btn ">Contact Buyer</button>
                        <div class="lead-posted">Posted: 10 days ago</div>
                        </div>
                    </div>
                </article>
                <article class="lead-card">
                    <div class="lead-card-inner">
                        <div class="lead-info">
                        <div class="lead-header">
                            <h2 class="lead-title">500 MT New Crop Basmati Rice Supplier</h2>
                            <div class="lead-location visibleonhigh">
                            <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/aea079960aaf6436704a53b19b29379031cce2ed?placeholderIfAbsent=true" alt="Location icon">
                            <span>Mumbai, India</span>
                            </div>
                        </div>
                        <p class="lead-description">We are looking for a trusted supplier for 500 MT of premium
                             Basmati Rice from the latest harvest. The rice should be long-grain, aromatic, 
                             well-milled, and meet international quality standards. We require competitive
                              pricing, proper packaging, and timely delivery. Interested suppliers, please
                               provide quotations, quality certifications, and delivery terms for further 
                               discussion
                        </p>
                        <div class="lead-location visibleonlow">
                            <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/aea079960aaf6436704a53b19b29379031cce2ed?placeholderIfAbsent=true" alt="Location icon">
                            <span>Mumbai, India</span>
                        </div>
                        <div class="lead-tags">
                            <span class="lead-tags-label">Tags:</span>
                            <span class="lead-tags-content">Buying Leads Supplier | Sourcing Agent Supplier | China Agent Supplier Buying Leads Supplier | Sourcing Agent Supplier | China Agent Supplier</span>
                        </div>
                        <div class="lead-details">
                            <div class="detail-group">
                            <div class="detail-row">
                                <span class="detail-label">Quantity Required:</span>
                                <span class="detail-value">500 MT</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Refundable:</span>
                                <span class="detail-value">Refundable</span>
                            </div>
                            </div>
                            <div class="detail-group">
                            <div class="detail-row">
                                <span class="detail-label">Term:</span>
                                <span class="detail-value">500 MT</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Available Stock:</span>
                                <span class="detail-value">98 kg</span>
                            </div>
                            </div>
                            <div class="detail-group">
                                <div class="detail-row">
                                    <span class="detail-label">Lead Time:</span>
                                    <span class="detail-value">10–18 days</span>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="divider"></div>
                        <div class="lead-actions">
                        <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/775ee05572e2f14d4118adf59e4ab6933d6d2125?placeholderIfAbsent=true" alt="Verified badge" class="verified-badge">
                        <button class="contact-btn ">Contact Buyer</button>
                        <div class="lead-posted">Posted: 10 days ago</div>
                        </div>
                    </div>
                </article>
            </div>
  
            <!-- Pagination -->
            <nav aria-label="Pagination" class="pagination">
              <div class="pagination-inner">
                <div class="pagination-controls">
                  <div class="items-per-page">Items Per Page: 12</div>
                  <div class="page-buttons">
                    <button class="page-btn disabled" id="prev-page" aria-label="Previous page" disabled>
                      <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/5eb6b06b3bcadcc55fe58b6d826dbed3f4da9dcd?placeholderIfAbsent=true" alt="Previous page">
                    </button>
                    <button class="page-btn active" aria-label="Page 1" aria-current="page" data-page="1">1</button>
                    <button class="page-btn" aria-label="Page 2" data-page="2">2</button>
                    <button class="page-btn" aria-label="Page 3" data-page="3">3</button>
                    <button class="page-btn" aria-label="Page 4" data-page="4">4</button>
                    <button class="page-btn" aria-label="Page 5" data-page="5">5</button>
                  </div>
                  <div class="pagination-total">
                    <div class="total-items">276</div>
                    <button class="page-btn" id="next-page" aria-label="Next page">
                      <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/f33b71f7df6b8ca473e5ea478fe4d57efb81ddaf?placeholderIfAbsent=true" alt="Next page">
                    </button>
                  </div>
                </div>
              </div>
            </nav>
          </div>
        </div>
      </div>
  
      <!-- Bottom banner -->
      <div class="bottom-banner">
        <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/666290679db229039ce0c8d24be8ae4e66bd94f6?placeholderIfAbsent=true" alt="Advertisement banner">
      </div>
</section>
@endsection
@push('script')
<script src="{{ theme_asset('public/js/buyer.js')}}"></script>
@endpush