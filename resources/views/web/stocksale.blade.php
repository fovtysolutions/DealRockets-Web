@extends('layouts.front-end.app')
@push('css_or_js')
<link rel="stylesheet" href="{{ theme_asset(path: 'assets/custom-css/ai/stocksale.css') }}" />
<style>
    .leadpagedivision {
        background-color: var(--web-bg);
    }

    .gapbetweens {
        height: 22px;
        background-color: var(--web-bg);
    }

    .fade-in-on-scroll {
        width: 100%;
    }

    .__inline-9 {
        background-color: var(--web-bg);
    }

    .dropdown-item:hover {
        background-color: white;
        transform: scale(1) !important;
        cursor: pointer;
    }

    .ad-section{
        flex-direction: row !important;
    }

    .ad-section img{
        aspect-ratio: 6 / 1;
        max-width: 1440px;
        height: 300px;
    }
</style>
@endpush
@section('title', translate('Stock Sale' . ' | ' . $web_config['name']->value))
@section('content')
    <?php
    $categories = \App\Utils\CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
    $unread = \App\Utils\ChatManager::unread_messages();
    if (Auth('customer')->check()) {
        $membership = \App\Utils\ChatManager::getMembershipStatusCustomer(Auth('customer')->user()->id);
        if (isset($membership['error'])) {
            $membership = ['status' => 'NotMade', 'message' => 'Membership Not Applied'];
        }
    }
    $userdata = \App\Utils\ChatManager::getRoleDetail();
    $user_id = $userdata['user_id'];
    $role = $userdata['role'];
    ?>
    
    <section class="mainpagesection stock-sale" style="background-color: unset; margin-top: 30px;">
        <div class="main-content">
            <!-- Left sidebar with filters -->
              <!-- for mobile media  -->
              <div class="search-and-filters-container">
                <!-- Search Box -->
                <div id="search-box" style="background: #fff;  width: 196.66px; display: flex; align-items: center; border: 1px solid #ccc; border-radius: 8px; padding: 6px 10px;">
                  <!-- Search Icon SVG -->
                  <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" fill="black" style="margin-right: 6px;" viewBox="0 0 24 24">
                    <path d="M21 21L15.8 15.8M18 10.5A7.5 7.5 0 1 1 3 10.5a7.5 7.5 0 0 1 15 0Z" stroke="black" stroke-width="2" fill="none" />
                  </svg>
                  <input type="text" placeholder="Search by Name" style="border: none; outline: none;" />
                </div>
      
                <!-- Filters Button -->
                <button id="filters-button" style="display: flex;     margin-left: 50px;
                width: 101px;
                height: 30px;  align-items: center; gap: 6px; border: 1px solid #ccc; padding: 6px 12px; background-color: white; cursor: pointer;">
                  Filters
                  <!-- Filter Icon SVG -->
                  <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" fill="black" viewBox="0 0 24 24">
                    <path d="M3 5h18M6 12h12M10 19h4" stroke="black" stroke-width="2" fill="none" stroke-linecap="round" />
                  </svg>
                </button>
              </div>
      
      
            
            <div class="sidebar">
              <div class="filter-sidebar">
                <div class="search-input">
                  <div class="input-label">Search by Name</div>
                  <div class="input-container">
                    <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/793bda788c444c6fa750bc442f903d3640eb48a5?placeholderIfAbsent=true" alt="Search icon">
                  </div>
                </div>
      
                <div style="margin-top: 9px;">
                  <div class="input-label">Filter By Country</div>
                  <div class="input-container">
                    <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/f1c85c4a500d673e402c69eef99db5caaa078e9d?placeholderIfAbsent=true" alt="Filter icon">
                  </div>
                </div>
      
                <div class="country-list">
                  <div class="checkbox-item">
                    <div class="checkbox checkbox-checked"></div>
                    <div class="checkbox-label">United States</div>
                  </div>
                  <div class="checkbox-item">
                    <div class="checkbox"></div>
                    <div class="checkbox-label">United Kingdom</div>
                  </div>
                  <div class="checkbox-item">
                    <div class="checkbox"></div>
                    <div class="checkbox-label">China</div>
                  </div>
                  <div class="checkbox-item">
                    <div class="checkbox"></div>
                    <div class="checkbox-label">Russia</div>
                  </div>
                  <div class="checkbox-item">
                    <div class="checkbox"></div>
                    <div class="checkbox-label">Australia</div>
                  </div>
                </div>
      
                <div class="input-label" style="margin-top: 11px;">Search by Category</div>
                <div class="input-container">
                  <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/793bda788c444c6fa750bc442f903d3640eb48a5?placeholderIfAbsent=true" alt="Search icon">
                </div>
      
                <div class="category-list">
                  <div class="checkbox-item">
                    <div class="checkbox checkbox-checked"></div>
                    <div class="checkbox-label">Agriculture</div>
                  </div>
                  <div class="checkbox-item">
                    <div class="checkbox"></div>
                    <div class="checkbox-label">Apparel & Accessories</div>
                  </div>
                  <div class="checkbox-item">
                    <div class="checkbox"></div>
                    <div class="checkbox-label">Automobiles & Motorcycles</div>
                  </div>
                  <div class="checkbox-item">
                    <div class="checkbox"></div>
                    <div class="checkbox-label">Beauty</div>
                  </div>
                  <div class="checkbox-item">
                    <div class="checkbox"></div>
                    <div class="checkbox-label">Building & Construction</div>
                  </div>
                  <div class="checkbox-item">
                    <div class="checkbox"></div>
                    <div class="checkbox-label">Chemicals</div>
                  </div>
                  <div class="checkbox-item">
                    <div class="checkbox"></div>
                    <div class="checkbox-label">Consumer Electronics & Components</div>
                  </div>
                  <div class="checkbox-item">
                    <div class="checkbox"></div>
                    <div class="checkbox-label">Electrical Equipment</div>
                  </div>
                  <div class="checkbox-item">
                    <div class="checkbox"></div>
                    <div class="checkbox-label">Fashion Accessories</div>
                  </div>
                  <div class="checkbox-item">
                    <div class="checkbox"></div>
                    <div class="checkbox-label">Food & Beverage</div>
                  </div>
                  <div class="checkbox-item">
                    <div class="checkbox"></div>
                    <div class="checkbox-label">Furniture</div>
                  </div>
                </div>
              </div>
            </div>
      
            <!-- Middle section with product listings -->
            <div class="product-list-section">
              <div class="product-list">
                <div class="product-list-inner">
                  <div class="product-cards-container">
                    <!-- Product Card 1 (Featured) -->
                    <div class="product-card" data-id="productCard">
                      <div class="product-card-inner product-card-featured">
                        <div class="product-card-content">
                          <div class="product-image-container">
                            <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/4de8e965ad84b638b3a33b6125a0b45bb159b0f9?placeholderIfAbsent=true" class="product-image" alt="Fresh Apples">
                          </div>
                          <div class="product-info">
                            <div class="product-header">
                              <div class="product-title">Selling 300 Units of Fresh Apples</div>
                              <img  class ="heart" src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/69456c03811ace2c0c568374d486fb1c0b4f38c1?placeholderIfAbsent=true" width="20" alt="Featured icon">
                            </div>
                            <div class="product-rate">
                              <div class="product-rate-label">Offer Rate:</div>
                              <div class="product-rate-value">$500-600/MT</div>
                            </div>
                            <div class="product-origin">
                              <div>Origin:</div>
                              <div class="product-origin-location">
                                <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/5b1bea327edb9b7946bc239f6a800e8695ba92c6?placeholderIfAbsent=true" width="15" alt="Location icon">
                                <div>New York, US</div>
                              </div>
                            </div>
                            <div class="product-description">
                              Juicy and crisp apples from the local farm. Perfect for snacking or baking. Available in bulk for retail or wholesale buyers.
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
      
                    <!-- Product Card 2 -->
                    <div class="product-card" data-id="2">
                      <div class="product-card-inner">
                        <div class="product-card-content">
                          <div class="product-image-container">
                            <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/4de8e965ad84b638b3a33b6125a0b45bb159b0f9?placeholderIfAbsent=true" class="product-image" alt="Fresh Apples">
                          </div>
                          <div class="product-info">
                            <div class="product-header">
                              <div class="product-title">Selling 300 Units of Fresh Apples</div>
                              <img class ="heart" src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/4138db3e7bada86a66bf44bd7fe2dc3b0959e290?placeholderIfAbsent=true" width="20" alt="Product icon">
                            </div>
                            <div class="product-rate">
                              <div class="product-rate-label">Offer Rate:</div>
                              <div class="product-rate-value">$500-600/MT</div>
                            </div>
                            <div class="product-origin">
                              <div>Origin:</div>
                              <div class="product-origin-location">
                                <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/5b1bea327edb9b7946bc239f6a800e8695ba92c6?placeholderIfAbsent=true" width="15" alt="Location icon">
                                <div>New York, US</div>
                              </div>
                            </div>
                            <div class="product-description">
                              Juicy and crisp apples from the local farm. Perfect for snacking or baking. Available in bulk for retail or wholesale buyers.
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
      
                    <!-- Product Card 3 -->
                    <div class="product-card" data-id="3">
                      <div class="product-card-inner">
                        <div class="product-card-content">
                          <div class="product-image-container">
                            <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/4de8e965ad84b638b3a33b6125a0b45bb159b0f9?placeholderIfAbsent=true" class="product-image" alt="Fresh Apples">
                          </div>
                          <div class="product-info">
                            <div class="product-header">
                              <div class="product-title">Selling 300 Units of Fresh Apples</div>
                              <img  class ="heart" src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/4138db3e7bada86a66bf44bd7fe2dc3b0959e290?placeholderIfAbsent=true" width="20" alt="Product icon">
                            </div>
                            <div class="product-rate">
                              <div class="product-rate-label">Offer Rate:</div>
                              <div class="product-rate-value">$500-600/MT</div>
                            </div>
                            <div class="product-origin">
                              <div>Origin:</div>
                              <div class="product-origin-location">
                                <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/5b1bea327edb9b7946bc239f6a800e8695ba92c6?placeholderIfAbsent=true" width="15" alt="Location icon">
                                <div>New York, US</div>
                              </div>
                            </div>
                            <div class="product-description">
                              Juicy and crisp apples from the local farm. Perfect for snacking or baking. Available in bulk for retail or wholesale buyers.
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Product Card 4 -->
                    <div class="product-card" data-id="3">
                      <div class="product-card-inner">
                        <div class="product-card-content">
                          <div class="product-image-container">
                            <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/4de8e965ad84b638b3a33b6125a0b45bb159b0f9?placeholderIfAbsent=true" class="product-image" alt="Fresh Apples">
                          </div>
                          <div class="product-info">
                            <div class="product-header">
                              <div class="product-title">Selling 300 Units of Fresh Apples</div>
                              <img  class ="heart" src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/4138db3e7bada86a66bf44bd7fe2dc3b0959e290?placeholderIfAbsent=true" width="20" alt="Product icon">
                            </div>
                            <div class="product-rate">
                              <div class="product-rate-label">Offer Rate:</div>
                              <div class="product-rate-value">$500-600/MT</div>
                            </div>
                            <div class="product-origin">
                              <div>Origin:</div>
                              <div class="product-origin-location">
                                <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/5b1bea327edb9b7946bc239f6a800e8695ba92c6?placeholderIfAbsent=true" width="15" alt="Location icon">
                                <div>New York, US</div>
                              </div>
                            </div>
                            <div class="product-description">
                              Juicy and crisp apples from the local farm. Perfect for snacking or baking. Available in bulk for retail or wholesale buyers.
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Product Card 5 -->
                    <div class="product-card" data-id="3">
                      <div class="product-card-inner">
                        <div class="product-card-content">
                          <div class="product-image-container">
                            <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/4de8e965ad84b638b3a33b6125a0b45bb159b0f9?placeholderIfAbsent=true" class="product-image" alt="Fresh Apples">
                          </div>
                          <div class="product-info">
                            <div class="product-header">
                              <div class="product-title">Selling 300 Units of Fresh Apples</div>
                              <img class ="heart" src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/4138db3e7bada86a66bf44bd7fe2dc3b0959e290?placeholderIfAbsent=true" width="20" alt="Product icon">
                            </div>
                            <div class="product-rate">
                              <div class="product-rate-label">Offer Rate:</div>
                              <div class="product-rate-value">$500-600/MT</div>
                            </div>
                            <div class="product-origin">
                              <div>Origin:</div>
                              <div class="product-origin-location">
                                <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/5b1bea327edb9b7946bc239f6a800e8695ba92c6?placeholderIfAbsent=true" width="15" alt="Location icon">
                                <div>New York, US</div>
                              </div>
                            </div>
                            <div class="product-description">
                              Juicy and crisp apples from the local farm. Perfect for snacking or baking. Available in bulk for retail or wholesale buyers.
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                
                <!-- Pagination -->
                <div class="pagination">
                  <div class="pagination-info">
                    Items Per Page: 12
                  </div>
                  <div class="pagination-controls">
                    <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/4a5206e5d6ef2bdb743353eb6c64e547ad87c593?placeholderIfAbsent=true" class="pagination-arrow" alt="Previous page">
                    
                    <div class="pagination-pages">
                      <div class="page-item active">1</div>
                      <div class="page-item">2</div>
                      <div class="page-item">20</div>
                    </div>
                    
                    <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/4d6e7a69f970a12cc65c8adc1a439633aff3cbf6?placeholderIfAbsent=true" class="pagination-arrow" alt="Next page">
                  </div>
                </div>
              </div>
            </div>
      
            <!-- Right section with product details -->
            <div class="product-detail-section" id="productModal">
              <div class="product-detail">
                <div class="detail-tabs">
                  <div class="detail-tab active">
                    <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/7d0a2a11ff9449e7aff27e271699d3e6dd4ac825?placeholderIfAbsent=true" class="detail-tab-icon" alt="Stock photo icon">
                    <div>Stock Photo</div>
                  </div>
                  <div class="detail-tab">
                    <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/ef9458326d55dc88fc6f7bebc00ffbcfac31016d?placeholderIfAbsent=true" class="detail-tab-icon" alt="Specification icon">
                    <div>Specification</div>
                  </div>
                  <div class="detail-tab">
                    <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/2827236b066050a00f6b7815e8e9078274a5b298?placeholderIfAbsent=true" class="detail-tab-icon" alt="Deal icon">
                    <div>Deal</div>
                  </div>
                  <div class="detail-tab">
                    <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/39d5ea4a9e67d861c878f366e8723186b08a5b10?placeholderIfAbsent=true" class="detail-tab-icon" alt="Contact icon">
                    <div>Contact</div>
                  </div>
                </div>
      
                <div class="detail-content">
                  <div class="detail-title">Selling 300 Units of Fresh Apples</div>
                  <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/247ec7c7bc1f6428f4d5acb3c10d89df21f5e0ba?placeholderIfAbsent=true" class="detail-image" alt="Fresh Apples">
                  <div class="detail-description">
                    Juicy and crisp apples from the local farm. Perfect for snacking or baking. Available in bulk for retail or wholesale buyers.
                    <br><br>
                    Sourced from trusted local orchards committed to quality and sustainability, our apples are available in bulk for retail or wholesale buyers, ensuring farm-fresh goodness in every bite.
                  </div>
      
                  <div class="detail-footer">
                    <div class="company-info">
                      <div class="company-rating">
                        <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/9dcf86845a5774a466c010f69a48d3bed069ce99?placeholderIfAbsent=true" width="25" alt="Company logo">
                        <div class="rating-badge">
                          <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/3b8226d1f3a4db74d7c0ea4e4f0145078db18bbb?placeholderIfAbsent=true" width="15" alt="Rating icon">
                          <div>4.9/5</div>
                        </div>
                      </div>
                      <div class="company-name">Market Union Co.Ltd</div>
                      <div class="company-exhibitions">Exhibited at 2 GS shows</div>
                      <div class="company-location">
                        <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/3c2974afe389ac984c47d41dcc08c0e410f01010?placeholderIfAbsent=true" width="15" alt="Location icon">
                        <div>New York, US</div>
                      </div>
                    </div>
      
                    <button class="inquire-button">Inquire Now</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </section>
    @include('web-views.partials._quotation')
    <div class="mainpagesection leadrightdivision" style="width: 96%;">
        <div class="ad-section">
            <div class="google-ad">
                <div class="ad-content">
                    <!-- Google Ad code goes here -->
                    <img src="storage/{{ $adimages['ad2_image'] }}" alt="Google Ad" class="ad-image">
                </div>
            </div>
        </div>
    </div>
    @include('web-views.partials._order-now')
    @include('web.partials.loginmodal')
    @include('web.partials.stockdetailmodal')
@endsection
@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        const trendingsection = document.getElementById('trendingselection');

        // Remove the bottom shadow but keep the others
        trendingsection.style.boxShadow = 'rgba(0, 0, 0, 0.07) 0px 0rem 1rem'; // Keep existing shadow properties

        // Correct way to remove a class (if you're trying to remove a class named 'boxShadow')
        trendingsection.classList.remove('shadow');
    </script>
    <script>
        // Tab functionality
        const tabLinks = document.querySelectorAll('.tab-link');
        const tabContents = document.querySelectorAll('.tab-content');

        tabLinks.forEach(link => {
            link.addEventListener('click', () => {
                // Remove active class from all links
                tabLinks.forEach(link => link.classList.remove('active'));
                // Add active class to clicked link
                link.classList.add('active');

                // Hide all tab contents
                tabContents.forEach(content => content.classList.remove('active'));

                // Show current tab content
                const targetTab = document.getElementById(link.dataset.tab);
                if (targetTab) {
                    targetTab.classList.add('active');
                }
            });
        });

        // Add dynamic gradient to tab-links
        document.addEventListener('DOMContentLoaded', function() {
            const wideBannerTexts = document.querySelectorAll('.tab-link');

            wideBannerTexts.forEach(text => {
                // Generate two random, visually appealing colors
                const randomColor1 = `hsl(${Math.floor(Math.random() * 360)}, 70%, 40%)`; // Darker hue
                const randomColor2 =
                    `hsl(${Math.floor(Math.random() * 360)}, 70%, 50%)`; // Medium-light hue

                // Apply gradient as a background to the tab link
                text.style.background = `linear-gradient(45deg, ${randomColor1}, ${randomColor2})`;
            });
        });
    </script>
    <script>
        // Function to open the login modal
        function openLoginModal() {
            $('#exampleModalLong').modal('hide');
            $('#loginModal').modal('show');
        }
    </script>
    <script>
        // Handle form submission with AJAX
        $('#send-message-btn').on('click', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Collect form data
            var formData = {
                sender_id: $('#sender_id').val(),
                sender_type: $('#sender_type').val(),
                receiver_id: $('#receiver_id').val(),
                receiver_type: $('#receiver_type').val(),
                type: $('#typereq').val(),
                leads_id: $('#leads_id').val(),
                message: $('textarea[name="message"]').val(),
                _token: $('input[name="_token"]').val() // CSRF token
            };

            // Send AJAX POST request
            $.ajax({
                url: "{{ route('sendmessage.other') }}", // Backend route
                type: 'POST',
                data: formData,
                success: function(response) {
                    toastr.success('Message sent successfully!', 'Success');
                    $('#chatting_modalnew').modal('hide'); // Hide modal
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    toastr.error('An error occurred while sending the message.', 'Error');
                }
            });
        });
    </script>
    <script>
        function openChatModalnew(button) {
            // Extract data from button attributes
            const sellerId = button.getAttribute('data-seller-id');
            const shopName = button.getAttribute('data-shop-name');
            const role = button.getAttribute('data-role');
            const leadsId = button.getAttribute('data-leads-id');
            const typereq = button.getAttribute('data-typereq');

            // Update modal title
            document.getElementById('chatModalNewTitle').innerText = `Chat with ${shopName}`;

            // Populate form hidden inputs
            document.getElementById('typereq').value = typereq;
            document.getElementById('leads_id').value = leadsId;
            document.getElementById('receiver_id').value = sellerId;
            document.getElementById('receiver_type').value = role;
        }
    </script>
    <script>
        function getLocationName(type, id) {
            return new Promise(function(resolve, reject) {
                if (!id) {
                    resolve("Location not available");
                    return;
                }

                var url = `/${type}name/${id}`;

                $.ajax({
                    url: url,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        resolve(response || "Location not available");
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                        reject("Error loading location.");
                    }
                });
            });
        }
        // Function to update company location
        function updateCompanyLocation(job) {
            // Fetch country, state, and city asynchronously
            var countryPromise = getLocationName('country', job.country);

            // Use Promise.all to wait for all the responses
            Promise.all([countryPromise])
                .then(function([countryName]) {
                    // Update location element with the company location
                    $("#company-location").text(countryName);
                    $("#ncompany-location").text(countryName);
                })
                .catch(function(error) {
                    // Handle error case if any AJAX call fails
                    console.error("Error in loading location details:", error);
                    $("#company-location").text(countryName);
                    $("#ncompany-location").text(countryName);
                });
        }
    </script>
    <script>
        // Define the filterLeads function globally
        function filterLeads() {
            // Gather Filter Data
            let fromDateInput = document.querySelector('input[name="from"]');
            let toDateInput = document.querySelector('input[name="to"]');
            let selectedCountries = Array.from(document.querySelectorAll('input[name="countries[]"]:checked')).map(function(
                checkbox) {
                return checkbox.value;
            });

            let fromDate = new Date(fromDateInput.value);
            let toDate = new Date(toDateInput.value);

            // Filter Leads
            let leadBoxes = document.querySelectorAll('#leadList .leadsrelatedbox');
            leadBoxes.forEach(function(box) {
                let leadDate = new Date(box.getAttribute('data-posted-date'));
                let leadCountry = box.getAttribute('data-country');

                let dateMatch = true;
                if (!isNaN(fromDate) && leadDate < fromDate) {
                    dateMatch = false;
                }
                if (!isNaN(toDate) && leadDate > toDate) {
                    dateMatch = false;
                }

                let countryMatch = selectedCountries.length === 0 || selectedCountries.includes(leadCountry);

                // Show or hide lead based on filters
                if (dateMatch && countryMatch) {
                    box.style.display = 'flex';
                } else {
                    box.style.display = 'none';
                }
            });
        }

        // Attach the filter function to the button click
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('filterButton').addEventListener('click', function() {
                filterLeads();
            });
        });
    </script>
    <script>
        function SearchbyCountry() {
            var countryId = document.getElementById('countryselector').value;
            if (countryId) {
                window.location.href = '/stock-sale?country=' + countryId;
            } else {
                alert('Please Select a Country');
            }
        }
    </script>
    <script>
        document.getElementById("viewMoreBtn").addEventListener("click", function() {
            // Set the new HTML content for #dpcontainerbox
            const fullCategoryList = `
            @foreach ($categoriesn as $category)
                <li>
                    <a href="{{ route('stocksale', ['categoryid' => $category->id]) }}">{{ $category->name }}</a>
                </li>
            @endforeach
        `;
            // Replace the current content with the full category list
            document.getElementById("dpcontainerbox").innerHTML = fullCategoryList;
            document.getElementById("dpcontainertwo").style.overflowY = 'scroll';
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var urlParams = new URLSearchParams(window.location.search);
            var jobid = urlParams.get("jobid");
            var job_first_id = document.getElementById("jobid") ?
                document.getElementById("jobid").value :
                null;

            var jobDetailsVisible =
                $("#jobdetails").length && $("#jobdetails").css("display") === "block";

            if (jobid) {
                if (jobDetailsVisible) {
                    fetchJobData(jobid);
                } else {
                    $("#exampleModalLong").modal("show");
                    fetchJobData(jobid);
                }
            } else if (job_first_id) {
                fetchJobData(job_first_id);
            } else {
                console.error("No job ID found in URL or default input.");
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Show and hide dropdowns on click
            const dropdownContainers = document.querySelectorAll(".dropdown-container");

            dropdownContainers.forEach(container => {
                const button = container.querySelector(".dropdown-button");
                const list = container.querySelector(".dropdown-list");
                const arrow = container.querySelector(".dropdown-arrow");

                button.addEventListener("click", function(event) {
                    event.stopPropagation(); // Prevent bubbling

                    // Close other dropdowns
                    document.querySelectorAll(".dropdown-list").forEach(otherList => {
                        if (otherList !== list) {
                            otherList.style.display = "none";
                            const otherArrow = otherList.previousElementSibling
                                .querySelector(".dropdown-arrow");
                            if (otherArrow) otherArrow.classList.remove("rotate");
                        }
                    });

                    // Toggle current dropdown
                    const isVisible = list.style.display === "block";
                    list.style.display = isVisible ? "none" : "block";

                    // Rotate the arrow
                    if (arrow) {
                        if (isVisible) {
                            arrow.classList.remove("rotate");
                        } else {
                            arrow.classList.add("rotate");
                        }
                    }
                });
            });

            // Close dropdowns if clicked outside
            document.addEventListener("click", function() {
                dropdownContainers.forEach(container => {
                    const list = container.querySelector(".dropdown-list");
                    const arrow = container.querySelector(".dropdown-arrow");

                    if (list.style.display === "block") {
                        list.style.display = "none";
                        if (arrow) arrow.classList.remove("rotate");
                    }
                });
            });

            // Filter function for dropdown search
            function filterList(searchId, listId) {
                const searchInput = document.getElementById(searchId);
                const listItems = document.querySelectorAll(`#${listId} .dropdown-item`);

                searchInput.addEventListener('input', function() {
                    const query = searchInput.value.toLowerCase();
                    listItems.forEach(function(item) {
                        const text = item.textContent || item.innerText;
                        item.style.display = text.toLowerCase().includes(query) ? 'block' : 'none';
                    });
                });
            };

            // Initialize filtering for Location dropdown
            filterList('country-search', 'country-list');

            // Handle item selection in dropdown
            const dropdownItems = document.querySelectorAll(".dropdown-item");
            dropdownItems.forEach(item => {
                item.addEventListener("click", function() {
                    const dropdownLabel = this.closest(".dropdown-container").querySelector(
                        ".dropdown-label");
                    dropdownLabel.textContent = this
                        .textContent; // Update the label to selected item

                    // Close the dropdown after selection
                    const dropdownList = this.closest(".dropdown-list");
                    dropdownList.style.display = "none";

                    const arrow = dropdownList.previousElementSibling.querySelector(
                        ".dropdown-arrow");
                    if (arrow) arrow.classList.remove("rotate");

                    applyFilters(); // Apply selected filters
                });
            });

            // Apply filters when an option is selected
            function applyFilters() {
                const location = document.querySelector("input[name='country']:checked")?.value;
                const time = document.querySelector("input[name='time']:checked")?.value;

                console.log("Filters Applied:");
                console.log("Location:", location);
                console.log("Time:", time);
            };

            // Function to clear all filters
            function clearFilters() {
                document.querySelectorAll('input[type="radio"]').forEach(input => input.checked = false);
                document.querySelectorAll(".dropdown-label").forEach(label => {
                    label.textContent = label.getAttribute("data-default-label");
                });
                applyFilters();
            };

            // Clear Filters Button
            const clearFiltersBtn = document.querySelector("#clear-filters-btn");
            if (clearFiltersBtn) {
                clearFiltersBtn.addEventListener("click", function() {
                    clearFilters();
                });
            }
        });
    </script>
    <script>
        function insertcarousel(job) {
            // Assuming 'job.image' is a JSON string containing image URLs
            var images = JSON.parse(job.image);
            // var inserthere = document.getElementById('hereinsert'); // Get the carousel container
            var insertherealso = document.getElementById('hereinsertalso');

            // inserthere.innerHTML = '';
            insertherealso.innerHTML = '';

            // Loop through the images and create carousel items
            images.forEach(function(image) {
                var imgElement = document.createElement('img');
                imgElement.src = '/' + image; // Assuming image path is relative
                imgElement.classList.add('item'); // Owl Carousel expects items to have a class

                // Optional styling
                imgElement.style.maxWidth = '100%';
                // imgElement.style.maxHeight = '55vh';
                imgElement.style.objectFit = 'contain';
                imgElement.style.aspectRatio = '4/3';

                // Create a wrapper div for each image
                var itemDiv = document.createElement('div');
                itemDiv.appendChild(imgElement);

                // Append the item div to the carousel container
                // inserthere.appendChild(itemDiv);
                insertherealso.appendChild(itemDiv);
            });

            // Destroy Previous Owl Carousel
            $('.details-carousel').owlCarousel('destroy');
            // Initialize Owl Carousel
            $('.details-carousel').owlCarousel({
                loop: true,
                margin: 10,
                autoplay: true,
                nav: false, // Show navigation arrows
                dots: true, // Show dots for navigation
                responsive: {
                    0: {
                        items: 1
                    }, // 1 item on small screens
                    600: {
                        items: 1
                    }, // 3 items on medium screens
                    1000: {
                        items: 1
                    } // 5 items on large screens
                }
            });
        }
    </script>
    <script>
        function formatTimeAgo(dateString) {
            const now = new Date();
            const postedDate = new Date(dateString);
            const timeDiff = now - postedDate; // difference in milliseconds

            const daysAgo = Math.floor(timeDiff / (1000 * 3600 * 24)); // converting milliseconds to days

            if (daysAgo === 0) {
                return "Posted today";
            } else if (daysAgo === 1) {
                return "Posted 1 day ago";
            } else {
                return `Posted ${daysAgo} days ago`;
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            // Initialize Owl Carousel
            $(".icon-carousel").owlCarousel({
                items: 1, // Show 1 image at a time
                loop: true, // Enable looping
                autoplay: false, // Disable autoplay by default
                nav: false, // Disable next/prev buttons
                dots: false, // Disable pagination dots
            });

            // Play carousel on hover
            $(".icon-carousel").hover(
                function() {
                    $(this).trigger('play.owl.autoplay', [1500]); // Start autoplay on hover
                },
                function() {
                    $(this).trigger('stop.owl.autoplay'); // Stop autoplay when hover is removed
                }
            );
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".stocksale-carousel").owlCarousel({
                loop: true, // Enable looping
                margin: 10, // Space between items
                nav: false, // Show navigation arrows
                dots: false, // Show dots navigation
                autoplay: true, // Auto slide
                autoplayTimeout: 3000, // Auto slide delay (in ms)
                autoplayHoverPause: true, // Pause on hover
                responsive: {
                    0: {
                        items: 1
                    }, // 1 item for small screens
                    600: {
                        items: 1
                    }, // 2 items for medium screens
                    1000: {
                        items: 1
                    } // 1 item for large screens
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dropdownButton = document.querySelector(".dropdown-button");
            const dropdownList = document.querySelector(".dropdown-list");
            const dropdownArrow = document.querySelector(".dropdown-arrow");

            // Toggle dropdown and arrow rotation
            dropdownButton.addEventListener("click", function(event) {
                event.stopPropagation(); // Prevent closing the dropdown when clicking inside
                const isVisible = dropdownList.style.display === "block";
                dropdownList.style.display = isVisible ? "none" : "block";
                dropdownArrow.classList.toggle("rotate", !isVisible); // Toggle rotation
            });

            // Close dropdown when clicking outside
            document.addEventListener("click", function() {
                dropdownList.style.display = "none";
                dropdownArrow.classList.remove("rotate"); // Reset arrow rotation
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var dropdownbutton = document.getElementById('locationdropdown');
            var dropdownchild = document.getElementById('locationdropdownchild');

            document.getElementById('country-search').addEventListener('click', function(event) {
                event.stopPropagation();
            });

            dropdownbutton.addEventListener('click', function() {
                if (dropdownchild.style.display === 'none' || dropdownchild.style.display === '') {
                    dropdownchild.style.display = 'block';
                } else {
                    dropdownchild.style.display = 'none';
                }
            });
        });
    </script>
    <script>
        // Product selection functionality
        document.querySelectorAll('.product-card').forEach(card => {
          card.addEventListener('click', function() {
            // In a real implementation, this would update the product detail section
            console.log('Selected product ID:', this.dataset.id);
            
            // Update highlighted/featured status
            document.querySelectorAll('.product-card-inner').forEach(inner => {
              inner.classList.remove('product-card-featured');
            });
            this.querySelector('.product-card-inner').classList.add('product-card-featured');
            
            // Update product icon
            const icons = document.querySelectorAll('.product-card .product-header img');
            icons.forEach(icon => {
              icon.src = "https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/4138db3e7bada86a66bf44bd7fe2dc3b0959e290?placeholderIfAbsent=true";
            });
            this.querySelector('.product-header img').src = "https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/69456c03811ace2c0c568374d486fb1c0b4f38c1?placeholderIfAbsent=true";
          });
        });
        
        // Pagination functionality
        document.querySelectorAll('.page-item').forEach(page => {
          page.addEventListener('click', function() {
            document.querySelectorAll('.page-item').forEach(p => {
              p.classList.remove('active');
            });
            this.classList.add('active');
          });
        });
        
        // Tab switching functionality
        document.querySelectorAll('.detail-tab').forEach(tab => {
          tab.addEventListener('click', function() {
            document.querySelectorAll('.detail-tab').forEach(t => {
              t.classList.remove('active');
            });
            this.classList.add('active');
          });
        });
        
        // Checkbox toggle functionality
        document.querySelectorAll('.checkbox').forEach(checkbox => {
          checkbox.addEventListener('click', function() {
            this.classList.toggle('checkbox-checked');
          });
        });
        
        // Form submission
        const quotationForm = document.querySelector('.quotation-form');
        quotationForm.addEventListener('submit', function(e) {
          e.preventDefault();
          console.log('Form submitted');
          alert('Quotation request submitted successfully!');
        });
    </script>
@endpush
