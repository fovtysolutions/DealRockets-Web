@extends('layouts.front-end.app')
@section('title', translate('Trade Shows' . ' | ' . $web_config['name']->value))
@push('css_or_js')
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/tradeshow.css') }}" />
@endpush
@section('content')
<main class="main-container tradeshow">
    <div class="banner-container">
      <div class="owl-carousel owl-theme first-carousel">
        @foreach($banners as $key => $value)
            @if (!empty($value))
                <img
                    src="{{ asset('storage/' . $value) }}"
                    class="banner-image"
                    alt="Trade Shows Banner"
                />
            @endif
        @endforeach
      </div>
    </div>

    <section class="content-section">
      <div class="content-layout">
        <div class="content-grid">
          <!-- Left sidebar with filters -->
          <aside class="sidebar">
            <div class="filter-container">
              <div>
                <form method="GET" action="{{ route('tradeshow') }}" id="filterFormTradeshow">
                  <div class="search-container">
                    <div class="search-sub-division">
                      <div class="search-section">
                        <div class="search-label">Search by Name</div>
                        <div class="search-input-container">
                          <div class="search-input-field">
                            <input type="text" name="name" placeholder="Enter name..." value="{{ request('name') }}" />
                            <img
                              src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/1198a3d1d34d3e698d6d5a08e6c9133273758e48?placeholderIfAbsent=true"
                              class="search-icon"
                              alt="Search icon"
                            />
                          </div>
                        </div>
                      </div>
                
                      <div class="filter-button delthree" onclick="toggleFilterSection()">
                        Filter
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
                          <rect x="3" y="6" width="18" height="2" rx="1" />
                          <rect x="6" y="11" width="12" height="2" rx="1" />
                          <rect x="9" y="16" width="6" height="2" rx="1" />
                        </svg>
                      </div>
                    </div>
                
                    <!-- Filter By Country Section -->
                    <div class="filter-section delone">
                      <div class="search-label">Filter By Country</div>
                      <div class="search-input-container">
                        <div class="search-input-field">
                          <input type="text" name="country_search" placeholder="Enter Country..." class="search-filter" data-target="#countriescheckbox" value="{{ request('country_search') }}" />
                          <img
                            src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/1198a3d1d34d3e698d6d5a08e6c9133273758e48?placeholderIfAbsent=true"
                            class="search-icon"
                            alt="Search icon"
                          />                        
                        </div>
                      </div>
                
                      <div class="filter-options" id="countriescheckbox">
                        @foreach ($countries as $country)
                          @php
                            $countryDetails = \App\Utils\ChatManager::getCountryDetails($country);
                            $isSelected = is_array(request()->input('country', [])) && in_array($country, request()->input('country', []));
                          @endphp
                
                          <label class="filter-checkbox country-option filter-item">
                            <input type="checkbox" name="country[]" value="{{ $country }}" {{ $isSelected ? 'checked' : '' }} />
                            <img src="/flags/{{ strtolower($countryDetails['countryISO2']) }}.svg" class="flag-icon" alt="{{ $country }} flag" />
                            <div class="filter-label">{{ $countryDetails['countryName'] }}</div>
                          </label>
                        @endforeach
                      </div>
                    </div>
                
                    <!-- Filter By Category Section -->
                    <div class="filter-section deltwo">
                      <div class="search-label">Search by Category</div>
                      <div class="search-input-container">
                        <div class="search-input-field">
                          <input type="text" name="industry_search" placeholder="Enter Category..." class="search-filter" data-target="#categorycheckbox" value="{{ request('industry_search') }}" />
                          <img
                            src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/1198a3d1d34d3e698d6d5a08e6c9133273758e48?placeholderIfAbsent=true"
                            class="search-icon"
                            alt="Search icon"
                          />
                        </div>
                      </div>
                
                      <div class="filter-options" id="categorycheckbox">
                        @foreach ($industries as $industry)
                          <label class="filter-checkbox category-option filter-item">
                            <input type="checkbox" name="industry[]" value="{{ $industry->id }}" {{ in_array($industry->id, request('industry', [])) ? 'checked' : '' }} />
                            <div class="filter-label">{{ $industry->name }}</div>
                          </label>
                        @endforeach
                      </div>
                    </div>
                  </div>
                </form>                
              </div>
            </div>
            <img
              src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/a52ef1d87fa5ef0c6b4750bcca3185851f37a518?placeholderIfAbsent=true"
              class="sidebar-advertisement"
              alt="Advertisement"
            />
          </aside>

          <!-- Main content area with trade show cards -->
          <div class="main-content">
            <div class="trade-shows-grid">
              @foreach($tradeshows as $tradeshow)
                <div class="trade-show-card">
                  <div class="card-container">
                    @php
                      $imageData = json_decode($tradeshow->image, true);
                      $image = !empty($imageData[0]) ? $imageData[0] : null;
                    @endphp
                    @if(isset($image))
                      <img
                        src="{{ asset('storage/' . $image) }}"
                        class="card-image"
                        alt="Trade Show"
                      />
                    @else
                      <img
                        src="{{ asset('images/placeholderimage.webp') }}"
                        class="card-image"
                        alt="Trade Show"
                      />
                    @endif
                    <div class="card-content">
                      <div class="card-title">{{ $tradeshow->name ?? '' }}</div>
                      <div class="card-description">{{ $tradeshow->description ?? ''}}</div>
                      <div class="card-details">
                        <div class="detail-label">Duration:</div>
                        <div class="detail-value">{{ \Carbon\Carbon::parse($tradeshow->start_date)->format('j') }} - 
                          {{ \Carbon\Carbon::parse($tradeshow->end_date)->format('j F Y') }}
                        </div>
                      </div>
                      <div class="card-location">
                        <div class="location-label">Location: </div>
                        <div class="location-value">
                          @php
                            $countryDetails = \App\Utils\ChatManager::getCountryDetails($tradeshow->country);
                          @endphp
                          <img
                            src="/flags/{{ strtolower($countryDetails['countryISO2']) }}.svg"
                            class="location-icon"
                            alt="China flag"
                          />
                          <div class="location-text">{{ $tradeshow->address ?? ''}}</div>
                        </div>
                      </div>
                      <a href="{{ route('tradeshow.view',['name'=>$tradeshow->name,'id'=>$tradeshow->id]) }}" class="card-button">View Details</a>
                    </div>
                  </div>
                </div>
              @endforeach          
            </div>
          </div>
        </div>
      </div>

      <!-- Pagination controls -->
      {{ $tradeshows->links('custom-paginator.custom')}}
    </section>
  </main>
@endsection
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Handle the Location Dropdown
        document.getElementById('locationdropdown').addEventListener('click', function() {
            const dropdownList = document.getElementById('locationdropdownchild');
            dropdownList.style.display = (dropdownList.style.display === 'none' || dropdownList.style.display === '') ? 'block' : 'none';
        });

        // Handle the Industry Dropdown
        document.querySelector('.dropdown-button').addEventListener('click', function() {
            const dropdownList = this.nextElementSibling;
            dropdownList.style.display = (dropdownList.style.display === 'none' || dropdownList.style.display === '') ? 'block' : 'none';
        });

        // Filter Location search
        document.getElementById('country-search').addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const items = document.querySelectorAll('#country-list li');
            items.forEach(item => {
                const text = item.textContent || item.innerText;
                item.style.display = text.toLowerCase().includes(filter) ? '' : 'none';
            });
        });

        // Filter Industry search
        document.getElementById('industry-search').addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const items = document.querySelectorAll('#industry-list li');
            items.forEach(item => {
                const text = item.textContent || item.innerText;
                item.style.display = text.toLowerCase().includes(filter) ? '' : 'none';
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown-container')) {
                document.querySelectorAll('.dropdown-list').forEach(function(dropdown) {
                    dropdown.style.display = 'none';
                });
            }
        });

        // Apply filters when an option is selected
        function applyFilters() {
            // Get values for country and industry filters
            const locationId = document.querySelector("input[name='country']:checked")?.value;
            const industryId = document.querySelector("input[name='industry']:checked")?.value;

            // Log applied filters for debugging
            console.log("Filters Applied:");
            console.log("Location ID:", locationId); // Get the selected location ID
            console.log("Industry ID:", industryId); // Get the selected industry ID
        }

        // Initialize filter functionality for dropdowns
        const dropdownItems = document.querySelectorAll(".dropdown-item");
        dropdownItems.forEach((item) => {
            item.addEventListener("click", function() {
                const dropdownLabel = this.closest(".dropdown-container").querySelector(".dropdown-label");
                dropdownLabel.textContent = this.textContent; // Update the label to selected item

                // Close the dropdown after selection
                const dropdownList = this.closest(".dropdown-list");
                dropdownList.style.display = "none";

                applyFilters(); // Apply selected filters
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('filterForm');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Get the values from the input fields
            let textSearch = document.getElementById("text-search").value;

            // Set default value for text-search to 'noselect' if it's empty
            if (!textSearch) {
                textSearch = 'all';
            }

            // Get the values from the input fields
            const locationId = document.querySelector("input[name='country']:checked")?.value;
            const industryId = document.querySelector("input[name='industry']:checked")?.value;

            // Construct the URL with the parameters
            let url = `/tradeshow/filter-by-country/${textSearch}`;

            if (locationId) {
                url += `/${locationId}`;
            } else {
                url += `/all`; // Optional: Use "all" or a default if no location is selected
            }

            if (industryId) {
                url += `/${industryId}`;
            } else {
                url += `/all`; // Optional: Use "all" or a default if no industry is selected
            }

            url += `/all`;

            // Redirect to the constructed URL
            window.location.replace(url);
        });
    });
</script>
<script>
    function filterTrades() {
        let country = document.getElementById('country').value;
        let selectedLetter = document.getElementById('.lettersort.active') ? document.querySelector('.lettersort')
            .getAttribute('name') : '';

        let databoxes = document.querySelectorAll('#tradeshowboxes');

        databoxes.forEach(function(box) {
            let dataCountry = box.getAttribute('data-country');
            let exhibitorNames = box.querySelector('td:nth-of-type(2)').textContent.trim();

            let countryMatch = (country === '' || dataCountry === country);
            let letterMatch = (selectedLetter === '' || exhibitorName.startsWith(selectedLetter));

            if (countryMatch && letterMatch) {
                box.style.display = 'table-row';
            } else {
                box.style.display = 'none';
            }
        });
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const wideBannerTexts = document.querySelectorAll('.widebannertext');

        wideBannerTexts.forEach(text => {
            // Generate two random, visually appealing colors
            const randomColor1 = `hsl(${Math.floor(Math.random() * 360)}, 70%, 40%)`; // Darker hue
            const randomColor2 = `hsl(${Math.floor(Math.random() * 360)}, 70%, 50%)`; // Medium-light hue

            // Set the linear gradient as the background
            text.style.background = `linear-gradient(45deg, ${randomColor1}, ${randomColor2})`;
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.first-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            dots: true,
            autoplay: false,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.second-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            dots: true,
            autoplay: false,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.third-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            dots: false,
            autoplay: false,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 4
                },
                1200: {
                    items: 6
                }
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var dropdownbutton = document.getElementById('locationdropdown');
        var dropdownchild = document.getElementById('locationdropdownchild');

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
    document.addEventListener('DOMContentLoaded', function() {
        var dropdownbutton = document.getElementById('industrymain');
        var dropdownchild = document.getElementById('industrychild');

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
    document.addEventListener('DOMContentLoaded', function() {
        // Checkbox functionality
        const checkboxes = document.querySelectorAll('.checkbox-unchecked');
        checkboxes.forEach(checkbox => {
        checkbox.addEventListener('click', function() {
            // Get parent element
            const parent = this.parentElement;
            
            // Get current state
            const isChecked = this.getAttribute('aria-checked') === 'true';
            
            // Toggle state
            this.setAttribute('aria-checked', !isChecked);
            
            // Replace with checked image if checked
            if (!isChecked) {
            const img = document.createElement('img');
            img.src = 'https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/fa3fb47b92badc40c5a98d6513d0cc4689a59f45?placeholderIfAbsent=true';
            img.className = 'checkbox-checked';
            img.alt = 'Checked checkbox';
            parent.replaceChild(img, this);
            
            // Add click event to the new image to toggle back
            img.addEventListener('click', function() {
                const unchecked = document.createElement('div');
                unchecked.className = 'checkbox-unchecked';
                unchecked.setAttribute('role', 'checkbox');
                unchecked.setAttribute('aria-checked', 'false');
                unchecked.setAttribute('tabindex', '0');
                parent.replaceChild(unchecked, this);
                
                // Add event listener to the new unchecked checkbox
                unchecked.addEventListener('click', arguments.callee.caller);
            });
            }
        });
        
        // Make checkbox accessible with keyboard
        checkbox.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            this.click();
            }
        });
        });
    });
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Show only first 6 items initially
    document.querySelectorAll('.filter-options').forEach(container => {
      const items = container.querySelectorAll('.filter-item');
      items.forEach((item, index) => {
        item.style.display = index < 6 ? 'flex' : 'none';
      });
    });

    // Attach filter logic to all search-filter inputs
    document.querySelectorAll('.search-filter').forEach(input => {
      input.addEventListener('input', function () {
        const targetSelector = this.getAttribute('data-target');
        const container = document.querySelector(targetSelector);
        const searchTerm = this.value.toLowerCase();
        const items = container.querySelectorAll('.filter-item');

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
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('filterFormTradeshow');

    if (form) {
      // Debounced submit for text inputs
      form.querySelectorAll('input[type="text"]').forEach(function (input) {
        let timeout;

        input.addEventListener('input', function () {
          clearTimeout(timeout);
          timeout = setTimeout(() => {
            if (input.value.trim() !== '') {
              form.requestSubmit ? form.requestSubmit() : form.submit();
            }
          }, 500);
        });

        // Handle Enter key for form submission
        input.addEventListener('keydown', function (e) {
          if (e.key === 'Enter') {
            e.preventDefault();
            if (input.value.trim() !== '') {
              form.requestSubmit ? form.requestSubmit() : form.submit();
            }
          }
        });
      });

      // Submit on checkbox change
      form.querySelectorAll('input[type="checkbox"]').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
          form.requestSubmit ? form.requestSubmit() : form.submit();
        });
      });

      // Allow search icon click to submit
      form.querySelectorAll('.search-icon').forEach(function (icon) {
        icon.addEventListener('click', function () {
          const parentForm = icon.closest('form');
          if (parentForm) {
            parentForm.requestSubmit ? parentForm.requestSubmit() : parentForm.submit();
          }
        });
      });
    }
  });
</script>
<script>
  window.toggleFilterSection = function () {
    const delOne = document.querySelector('.tradeshow .delone');
    const delTwo = document.querySelector('.tradeshow .deltwo');

    if (!delOne || !delTwo) return;

    const isDelOneHidden = getComputedStyle(delOne).display === 'none';

    // Forcefully set the styles regardless of current state
    delOne.style.display = isDelOneHidden ? 'block' : 'none';
    delTwo.style.display = isDelOneHidden ? 'block' : 'none';
  };
</script>
@endpush
