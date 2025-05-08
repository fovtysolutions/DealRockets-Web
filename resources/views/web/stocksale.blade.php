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

        .ad-section {
            flex-direction: row !important;
        }

        .ad-section img {
            aspect-ratio: 6 / 1;
            max-width: 1440px;
            height: 300px;
            width: 100%;
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
                <div id="search-box"
                    style="background: #fff;  width: 196.66px; display: flex; align-items: center; border: 1px solid #ccc; border-radius: 8px; padding: 6px 10px;">
                    <!-- Search Icon SVG -->
                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" fill="black"
                        style="margin-right: 6px;" viewBox="0 0 24 24">
                        <path d="M21 21L15.8 15.8M18 10.5A7.5 7.5 0 1 1 3 10.5a7.5 7.5 0 0 1 15 0Z" stroke="black"
                            stroke-width="2" fill="none" />
                    </svg>
                    <input type="text" placeholder="Search by Name" style="border: none; outline: none;" />
                </div>

                <!-- Filters Button -->
                <button id="filters-button"
                    style="display: flex;     margin-left: 50px;
                width: 101px;
                height: 30px;  align-items: center; gap: 6px; border: 1px solid #ccc; padding: 6px 12px; background-color: white; cursor: pointer;">
                    Filters
                    <!-- Filter Icon SVG -->
                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" fill="black"
                        viewBox="0 0 24 24">
                        <path d="M3 5h18M6 12h12M10 19h4" stroke="black" stroke-width="2" fill="none"
                            stroke-linecap="round" />
                    </svg>
                </button>
            </div>



            <div class="sidebar">
                <div class="filter-sidebar">
                    <form method="GET" action="{{ route('stocksale') }}" id="filterFormStockSale">
                        <div class="filter-section">
                            <div class="search-section">
                                <div class="search-label">Search by Name</div>
                                <div class="search-input-container">
                                    <div class="search-input-field">
                                        <input type="text" name="search_query" id="nameFilter"
                                            placeholder="Enter name..." value="{{ request('name') }}" />
                                        <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/1198a3d1d34d3e698d6d5a08e6c9133273758e48?placeholderIfAbsent=true"
                                            class="search-icon" alt="Search icon" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="filter-section">
                            <div class="search-label">Filter By Country</div>
                            <div class="search-input-container">
                                <div class="search-input-field">
                                    <input type="text" name="country_search" placeholder="Enter Country..."
                                        class="search-filter" data-target="#countriescheckbox"
                                        value="{{ request('country_search') }}" />
                                    <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/1198a3d1d34d3e698d6d5a08e6c9133273758e48?placeholderIfAbsent=true"
                                        class="search-icon" alt="Search icon" />
                                </div>
                            </div>

                            <div class="filter-options country-list" id="countriescheckbox">
                                @foreach ($countries as $country)
                                    @php
                                        $countryDetails = \App\Utils\ChatManager::getCountryDetails($country);
                                        $isSelected =
                                            is_array(request()->input('country', [])) &&
                                            in_array($country, request()->input('country', []));
                                    @endphp
                                    <div class="checkbox-item">
                                        <label class="filter-checkbox country-option filter-item">
                                            <input type="checkbox" name="country[]" value="{{ $country }}"
                                                {{ $isSelected ? 'checked' : '' }} />
                                            <img src="/flags/{{ strtolower($countryDetails['countryISO2']) }}.svg"
                                                class="flag-icon" alt="{{ $country }} flag" />
                                            <div class="filter-label">{{ $countryDetails['countryName'] }}</div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Filter By Category Section -->
                        <div class="filter-section deltwo">
                            <div class="search-label">Search by Category</div>
                            <div class="search-input-container">
                                <div class="search-input-field">
                                    <input type="text" name="industry_search" placeholder="Enter Category..."
                                        class="search-filter" data-target="#categorycheckbox"
                                        value="{{ request('industry_search') }}" />
                                    <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/1198a3d1d34d3e698d6d5a08e6c9133273758e48?placeholderIfAbsent=true"
                                        class="search-icon" alt="Search icon" />
                                </div>
                            </div>

                            <div class="category-list filter-options" id="categorycheckbox">
                                @foreach ($categoriesn as $industry)
                                    <div class="checkbox-item">
                                        <label class="filter-checkbox category-option filter-item">
                                            <input type="checkbox" name="industry[]" value="{{ $industry->id }}"
                                                {{ in_array($industry->id, request('industry', [])) ? 'checked' : '' }} />
                                            <div class="filter-label">{{ $industry->name }}</div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="filter-section deltwo">
                            <div class="search-label">Search by Stock Type</div>
                            <div class="search-input-container">
                                <div class="search-input-field">
                                    <input type="text" name="stock_search" placeholder="Enter Category..."
                                        class="search-filter" data-target="#stockcheckbox"
                                        value="{{ request('stock_search') }}" />
                                    <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/1198a3d1d34d3e698d6d5a08e6c9133273758e48?placeholderIfAbsent=true"
                                        class="search-icon" alt="Search icon" />
                                </div>
                            </div>

                            <div class="category-list filter-options" id="stockcheckbox">
                                @foreach ($stocktype as $industry)
                                    <div class="checkbox-item">
                                        <label class="filter-checkbox category-option filter-item">
                                            <input type="checkbox" name="industry[]" value="{{ $industry->id }}"
                                                {{ in_array($industry->id, request('industry', [])) ? 'checked' : '' }} />
                                            <div class="filter-label">{{ $industry->name }}</div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Middle section with product listings -->
            <div class="product-list-section">
                <div class="product-list">
                    <div class="product-list-inner">
                        @include('web.dynamic-partials.dynamic-stocksell')
                        <!-- Pagination -->
                        <div id="paginationControls">
                            {{ $items->links('custom-paginator.custom') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right section with product details -->
            <div class="product-detail-section" id="productModal">
                <div class="product-detail">
                    <div class="detail-tabs">
                        <div class="detail-tab active" id="tab-stock-photo">
                            <i class="fa-solid fa-circle-info detail-tab-icon"></i>
                            <div>Stock Photo</div>
                        </div>
                        <div class="detail-tab" id="tab-specification">
                            <i class="fa-solid fa-list detail-tab-icon"></i>
                            <div>Specification</div>
                        </div>
                        <div class="detail-tab" id="tab-deal">
                            <i class="fa-solid fa-envelope detail-tab-icon"></i>
                            <div>Deal</div>
                        </div>
                        <div class="detail-tab" id="tab-contact">
                            <i class="fa-regular fa-circle-question detail-tab-icon"></i>
                            <div>Contact</div>
                        </div>
                    </div>

                    <div class="d-flex flex-column justify-content-between h-100" id="StockSellView">
                        @include('web.dynamic-partials.dynamic-stocksellview')
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
@endsection
@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('filterFormStockSale');

            if (form) {
                // Debounced input for text fields
                form.querySelectorAll('input[type="text"]').forEach(function(input) {
                    let timeout;

                    input.addEventListener('input', function() {
                        clearTimeout(timeout);
                        timeout = setTimeout(function() {
                            if (input.value.trim() !== '') {
                                applyFilters();
                            }
                        }, 500); // Wait 500ms before triggering the filter
                    });
                });

                // Submit when checkboxes are changed
                form.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
                    checkbox.addEventListener('change', function() {
                        applyFilters();
                    });
                });

                // Handle search icon click
                form.querySelectorAll('.search-icon').forEach(function(icon) {
                    icon.addEventListener('click', function() {
                        applyFilters();
                    });
                });
            }

            // Function to gather filter values and make the AJAX request
            function applyFilters(page = 1) {
                let filters = {
                    search_query: document.getElementById('nameFilter').value, // Adjust to your input field ID
                    country: Array.from(document.querySelectorAll('input[name="country[]"]:checked')).map(
                        checkbox => checkbox.value), // For multiple checkboxes
                    industry: Array.from(document.querySelectorAll('input[name="industry[]"]:checked')).map(
                        checkbox => checkbox.value) // For multiple checkboxes
                };

                loadFilteredData(filters);
            }

            function loadFilteredData(filters, page = 1) {
                $('#dynamicLoader').css('display', 'block');

                filters.page = page;

                $.ajax({
                    url: "{{ route('dynamic-stocksell') }}",
                    method: 'GET',
                    data: filters,
                    success: function(response) {
                        $('#stocksaleOfferDynamic').html(response.html);
                        $('#paginationControls').html(response.pagination);
                        $('#dynamicLoader').css('display', 'none');
                        initializeIconCarousel();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        $('#dynamicLoader').css('display', 'none');
                    }
                });
            };

            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();

                let filters = {
                    search_query: document.getElementById('nameFilter')
                        .value, // Adjust to your input field ID
                    country: Array.from(document.querySelectorAll('input[name="country[]"]:checked'))
                        .map(checkbox => checkbox.value), // For multiple checkboxes
                    industry: Array.from(document.querySelectorAll('input[name="industry[]"]:checked'))
                        .map(checkbox => checkbox.value) // For multiple checkboxes
                };

                var page = $(this).data('page');
                loadFilteredData(filters, page);
            });

            applyFilters();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show only first 6 items initially
            document.querySelectorAll('.filter-options').forEach(container => {
                const items = container.querySelectorAll('.checkbox-item');
                items.forEach((item, index) => {
                    item.style.display = index < 6 ? 'flex' : 'none';
                });
            });

            // Attach filter logic to all search-filter inputs
            document.querySelectorAll('.search-filter').forEach(input => {
                input.addEventListener('input', function() {
                    const targetSelector = this.getAttribute('data-target');
                    const container = document.querySelector(targetSelector);
                    const searchTerm = this.value.toLowerCase();
                    const items = container.querySelectorAll('.checkbox-item');

                    let visibleCount = 0;

                    items.forEach(item => {
                        const label = item.textContent.toLowerCase();
                        const matches = label.includes(searchTerm);

                        if (matches && visibleCount < 6) {
                            item.style.display = 'flex';
                            visibleCount++;
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        });
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
        function initializeDetailCarousel() {
            // Initialize Owl Carousel
            $('.details-carousel').owlCarousel({
                loop: true,
                margin: 30,
                autoplay: false,
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
        };
        initializeDetailCarousel();
    </script>
    <script>
        function initializeIconCarousel() {
            // Initialize Owl Carousel
            $(".icon-carousel").owlCarousel({
                items: 1, // Show 1 image at a time
                margin: 30,
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
        };
        initializeIconCarousel();
    </script>
    <script>
        function initializeStockSellCarousel() {
            $(".stocksale-carousel").owlCarousel({
                loop: true, // Enable looping
                margin: 30, // Space between items
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
        };
        initializeStockSellCarousel();
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
        function populateDetailedBox(card) {
            var id = $(card).data('id');
            console.log('box populated', id);
            document.querySelectorAll('.product-card-inner').forEach(inner => {
                inner.classList.remove('product-card-featured');
            });
            card.querySelector('.product-card-inner').classList.add('product-card-featured');
            loadStockSellData(id);
        };

        function loadStockSellData(id) {
            $('#dynamicLoader').css('display', 'block');

            $.ajax({
                url: "{{ route('dynamic-stocksellview') }}",
                method: 'GET',
                data: {
                    'id': id,
                },
                success: function(response) {
                    $('#StockSellView').html(response.html);
                    initializeDetailCarousel();
                    $('#dynamicLoader').css('display', 'none');
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    $('#dynamicLoader').css('display', 'none');
                }
            });
        };
    </script>
    <script>
        // Tab switching functionality
        document.querySelectorAll('.detail-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.detail-tab').forEach(t => {
                    t.classList.remove('active');
                });
                document.querySelectorAll('.detail-tab-content').forEach(content => {
                    content.classList.remove('active');
                });

                this.classList.add('active');

                const targetId = this.id.replace('tab-', 'content-');
                const targetContent = document.getElementById(targetId);

                targetContent.classList.add('active');
            });
        });

        // Checkbox toggle functionality
        document.querySelectorAll('.checkbox').forEach(checkbox => {
            checkbox.addEventListener('click', function() {
                this.classList.toggle('checkbox-checked');
            });
        });
    </script>
    <script>
        function sendtologin(){
            window.location.href = '/customer/auth/login';
        }

        function makeFavourite(element) {
            const listingId = element.getAttribute('data-id');
            const user_id = element.getAttribute('data-userid');
            const type = element.getAttribute('data-type');
            const role = element.getAttribute('data-role');
            const btn = element;

            var data = {
                listing_id: listingId,
                user_id: user_id,
                type: type,
                role: role,
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                url: '{{ route('toggle-favourite') }}',
                method: 'POST',
                data: data,
                success: function(response) {
                    if (response.status === 'added') {
                        toastr.success('Added Favourite');
                        btn.src = '/img/Heart (2).png'; // or change icon class
                    } else {
                        btn.src = '/img/Heart (1).png';
                    }
                },
                error: function() {
                    toastr.Error('Something Went Wrong');
                }
            });
        }
    </script>
@endpush
