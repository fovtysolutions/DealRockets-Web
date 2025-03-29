@php($announcement = getWebConfig(name: 'announcement'))
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/ai/header.css')}}" />
{{-- Start Content --}}
    <?php
    $colorSetting = App\Models\BusinessSetting::where('type', 'colorsu')->first();
    $hovercolor = $colorSetting ? json_decode($colorSetting->value, true)['hovercolor'] : '#FFFFFF';
    $textcolor = App\Utils\ChatManager::getTextColorBasedOnBackground($hovercolor);
    $checkerFunction = App\Utils\ChatManager::membershipChecker();
    // If we want notification in future
    ?>
    @if (isset($announcement) && $announcement['status'] == 1)
        <div class="text-center position-relative px-4 py-1" id="announcement"
            style="background-color: {{ $announcement['color'] }}; color: {{ $announcement['text_color'] }};">
            <span>{{ $announcement['announcement'] }} </span>
            <span class="__close-announcement web-announcement-slideUp">X</span>
        </div>
    @endif
    <?php
    $categories = App\Utils\CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
    $unread = App\Utils\ChatManager::unread_messages();
    $userId = Auth::guard('customer')->user() ? Auth::guard('customer')->id() : 0;
    $role = App\Models\User::where('id', $userId)->first();
    $is_jobadder = $role['typerole'] === 'findtalent' ? true : false;
    ?>
    <div class="header-footer">
        <div class="navbar-wrapper">
          <div class="navbar">
            <div class="group">
              <div class="overlap-group">
                <div class="group-wrapper">
                  <div class="div">
                    <div class="text-wrapper">All Categories</div>
                    <img class="options-lines" src="img/options-lines.png" />
                  </div>
                </div>
                <div class="navbar-2">
                  <div class="text-wrapper-2">Home</div>
                  <div class="text-wrapper-3">Stock Sale</div>
                  <div class="text-wrapper-3">Buy Leads</div>
                  <div class="text-wrapper-3">Sell Offer</div>
                  <div class="text-wrapper-3">Deal Assist</div>
                  <div class="text-wrapper-3">Industry Jobs</div>
                  <div class="frame">
                    <div class="text-wrapper-3">Trade Shows</div>
                  </div>
                  <div class="frame">
                    <div class="text-wrapper-3">Vendor Zone</div>
                    <img class="arrow-down-sign-to" src="img/arrow-down-sign-to-navigate.png" />
                  </div>
                </div>
                <div class="frame-2">
                  <div class="our-features">
                    <img class="badge" src="img/badge.png" />
                    <div class="text-wrapper-4">Our Features</div>
                  </div>
                  <div class="group-2">
                    <div class="frame-3">
                      <div class="text-wrapper-5">Help</div>
                      <img class="img" src="img/arrow-down-sign-to-navigate-1.png" />
                    </div>
                    <img class="question" src="img/question.png" />
                  </div>
                  <div class="group-3">
                    <div class="frame-3">
                      <div class="text-wrapper-5">English</div>
                      <img class="img" src="img/arrow-down-sign-to-navigate-2.png" />
                    </div>
                    <img class="language" src="img/language.png" />
                  </div>
                  <div class="group-4">
                    <div class="text-wrapper-6">Sign in/ Join</div>
                    <img class="user" src="img/user.png" />
                  </div>
                </div>
              </div>
            </div>
            <div class="group-5">
              <img class="rectangle-stroke" src="img/rectangle-20-stroke.svg" />
              <div class="group-6">
                <img class="logo" src="{{ getStorageImages(path: $web_config['web_logo'], type: 'logo') }}" />
                <div class="group-7">
                  <div class="overlap-group-wrapper">
                    <div class="overlap-group-2">
                      <div class="div-wrapper">
                        <div class="group-8">
                          <img class="magnifier" src="img/magnifier.png" />
                          <img class="search" src="img/search.png" />
                        </div>
                      </div>
                      <div class="group-9">
                        <div class="group-10">
                          <div class="frame-wrapper">
                            <div class="frame-4">
                              <div class="text-wrapper-7">Products</div>
                              <img class="arrow-down-sign-to-2" src="img/arrow-down-sign-to-navigate-3.png" />
                              <div class="group-11">
                                <div class="frame-5">
                                  <div class="frame-6">
                                    <div class="frame-7">
                                      <div class="text-wrapper-8">Products</div>
                                      <div class="text-wrapper-9">Buy Leads</div>
                                      <div class="text-wrapper-9">Sell Offer</div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <img class="search-for-products" src="img/search-for-products.png" />
                        <img class="line-stroke" src="img/line-29-stroke.svg" />
                      </div>
                    </div>
                  </div>
                  <div class="frame-8">
                    <div class="group-12">
                      <img class="chat" src="img/chat.png" />
                      <div class="text-wrapper-10">RFQ</div>
                    </div>
                    <div class="group-13">
                      <img class="parcel" src="img/parcel.png" />
                      <div class="text-wrapper-11">Supplier</div>
                    </div>
                    <div class="group-14">
                      <img class="customer" src="img/customer.png" />
                      <div class="text-wrapper-11">Buyer</div>
                    </div>
                    <div class="group-15">
                      <img class="chatting" src="img/chatting.png" />
                      <div class="text-wrapper-11">Message</div>
                    </div>
                    <div class="group-16">
                      <img class="heart" src="img/heart.png" />
                      <div class="text-wrapper-12">Shortlist</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

@push('script')
    <script>
        "use strict";
        $(".category-menu").find(".mega_menu").parents("li")
            .addClass("has-sub-item").find("> a")
            .append("<i class='czi-arrow-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}'></i>");
    </script>
    <script>
        document.getElementById('menu-button').addEventListener('click', function() {
            const navbar = document.getElementById('navbarhidden');
            if (navbar.style.display === 'block') {
                navbar.style.display = 'none';
            } else {
                navbar.style.display = 'block';
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dropdown = document.querySelector('.dropdown');
            const defaultOption = document.querySelector('.default_option');
            const dropdownList = document.querySelector('.dropdown ul');
            const prosup = document.getElementById('prosup');

            // Preselect the first option
            defaultOption.textContent = dropdownList.querySelector('li').textContent;

            dropdown.addEventListener('click', function() {
                dropdownList.classList.toggle('active'); // Toggle dropdown visibility
            });

            // Close the dropdown if an option is selected or clicked
            dropdownList.querySelectorAll('li').forEach(item => {
                item.addEventListener('click', function() {
                    defaultOption.textContent = this.textContent; // Update selected option
                    prosup.action = item.dataset.route;
                    dropdownList.classList.remove('active'); // Close dropdown
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!dropdown.contains(event.target)) {
                    dropdownList.classList.remove('active'); // Close dropdown if clicked outside
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdown = document.querySelector('.custom-dropdown');
            const trigger = dropdown.querySelector('.dropdown-trigger');

            trigger.addEventListener('click', function() {
                dropdown.classList.toggle('show');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!dropdown.contains(event.target)) {
                    dropdown.classList.remove('show');
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdown = document.getElementById('productDropdown');
            const defaultOption = dropdown.querySelector('.default_option');
            const searchInput = document.getElementById('searchInput');

            // Toggle dropdown visibility when the dropdown is clicked
            dropdown.addEventListener('click', function() {
                const ul = dropdown.querySelector('ul');
                ul.style.display = ul.style.display === 'block' ? 'none' : 'block';
            });

            // Add click event listener to each dropdown item
            dropdown.querySelectorAll('li').forEach(item => {
                item.addEventListener('click', function() {
                    // Update the default option text
                    defaultOption.textContent = this.textContent;

                    // Change the placeholder based on the selected option
                    const placeholder = this.getAttribute('data-placeholder');
                    searchInput.placeholder = placeholder;

                    // Close the dropdown after selection
                    dropdown.querySelector('ul').style.display = 'none';
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                // Check if the click is outside the dropdown
                if (!dropdown.contains(event.target)) {
                    dropdown.querySelector('ul').style.display = 'none'; // Hide dropdown
                }
            });
        });
    </script>
    <script>
        $('#togglenavbar').on('click', function(event) {
            $('#navbarCollapse').show();
        });
        $('#navbarbutton').on('click', function(event) {
            $('#navbarCollapse').hide();
        });
    </script>
    <script>
        $('#closebutton').on('click', function(event) {
            $('#searchformclose').removeClass('active');
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#dropdownbar').on('mouseenter', function() {
                $(this).css({
                    'box-shadow': '0px 4px 15px rgba(0, 0, 0, 0.5)',
                    'z-index': '1000'
                });

                $(this).find('.dropdownmenucat').css({
                    'display': 'flex',
                    'flex-wrap': 'wrap',
                    'pointer-events': 'auto',
                });
            });

            $('#dropdownbar').on('mouseleave', function() {
                $(this).css({
                    'background-color': '',
                    'box-shadow': ''
                });

                $(this).find('.dropdownmenucat').css({
                    'display': 'none',
                    'pointer-events': 'none',
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var signinheader = document.getElementsByClassName('signinheader');
            var message = document.getElementsByClassName('messageheader');
            var cartheader = document.getElementsByClassName('cartheader');
            var getheader = document.getElementsByClassName('addcontents');

            function checkNavbarScroll() {
                var navbar = document.querySelector('.centernavbar'); // Get the navbar element
                if (navbar && navbar.classList.contains('navbar-stuck')) {
                    for (var i = 0; i < signinheader.length; i++) {
                        signinheader[i].style.display = 'none';
                    }
                    for (var i = 0; i < message.length; i++) {
                        message[i].style.display = 'none';
                    }
                    for (var i = 0; i < cartheader.length; i++) {
                        cartheader[i].style.display = 'none';
                    }
                    getheader[0].style.display = 'contents';
                } else {
                    for (var i = 0; i < signinheader.length; i++) {
                        signinheader[i].style.display = 'inline-block'; // Adjust based on your layout
                    }
                    for (var i = 0; i < message.length; i++) {
                        message[i].style.display = 'inline-block'; // Adjust based on your layout
                    }
                    for (var i = 0; i < cartheader.length; i++) {
                        cartheader[i].style.display = 'inline-block'; // Adjust based on your layout
                    }
                    getheader[0].style.display = '';
                }
            }

            checkNavbarScroll();

            window.addEventListener('scroll', function() {
                checkNavbarScroll();
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the dropdown toggle button and the dropdown menu
            const dropdownToggle = document.getElementById('profileDropdown');
            const dropdownMenu = document.querySelector('#profileDropdownContainer .dropdown-menu');

            // Listen for click event on the dropdown toggle
            dropdownToggle.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default behavior (jumping to the top of the page)

                // Toggle the 'show' class to show or hide the dropdown menu
                dropdownMenu.classList.toggle('show');
            });

            // Close the dropdown if clicked outside
            document.addEventListener('click', function(event) {
                if (!dropdownToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.remove('show');
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var dropdownbutton = document.getElementById('productssearch');
            var dropdownbuttonu = document.getElementById('leadsbuy');
            var dropdownbuttonm = document.getElementById('leadssell');
            var changehere = document.getElementById('searchInput');

            if (dropdownbutton && changehere) {
                dropdownbutton.addEventListener('click', function() {
                    changehere.name = 'searchInput';
                });
            }

            if (dropdownbuttonu && changehere) {
                dropdownbuttonu.addEventListener('click', function() {
                    changehere.name = 'search_query';
                });
            }

            if (dropdownbuttonm && changehere) {
                dropdownbuttonm.addEventListener('click', function() {
                    changehere.name = 'search_query';
                });
            }
        });
    </script>
@endpush
