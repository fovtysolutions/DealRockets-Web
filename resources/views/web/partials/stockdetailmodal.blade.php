<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 96vw;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Stock Description</h5>
                <button type="button" class="close opacity-100 text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="tabs-container">
                <div class="tabs">
                    <div class="tab-links">
                        <button class="tab-link tabbuttons active" data-tab="tab-5"><i class="fas fa-info-circle"></i>
                            Stock Photo</button>
                        <button class="tab-link tabbuttons" data-tab="tab-6"><i class="fas fa-list"></i>
                            Specification</button>
                        <button class="tab-link tabbuttons" data-tab="tab-7"><i class="fas fa-envelope"></i>
                            Deal</button>
                        <button class="tab-link tabbuttons" data-tab="tab-8"><i class="fas fa-question-circle"></i>
                            Contact</button>
                    </div>

                    <div class="tab-content tabtabs active" id="tab-5">
                        <h5>Stock Photo</h5>
                        <div id="nhereinsertalso" class="owl-carousel details-carousel">
                            <!-- Carousel Inserted Here -->
                        </div>
                    </div>

                    <div class="tab-content tabtabs" id="tab-6">
                        <h5 class="mb-2">Stock Specifications</h5>

                        <p id="njob-descriptionstock" class="mb-2">
                            {{-- Stock Description Here --}}
                        </p>
                        <ul class="feature-list"
                            style="list-style: none; margin-bottom: 10px;background-color: #efefef;padding: 5px;border-radius: 10px;">
                            <div class="row">
                                <div class="col">
                                    <li>
                                        <div class="leftclass">
                                            <i class="fa fa-id-badge text-primary"
                                                style="font-size: 20px;"></i> <!-- Icon for "Name" -->
                                        </div>
                                        <div class="rightclass">
                                            <strong>Name</strong><br>
                                            <span id="nstockname">
                                                {{-- Content Here --}}
                                            </span>
                                        </div>
                                    </li>
                                </div>
                                <div class="col">
                                    <li>
                                        <div class="leftclass">
                                            <i class="fa fa-list-alt text-info" style="font-size: 20px;"></i>
                                            <!-- Icon for "Type" -->
                                        </div>
                                        <div class="rightclass">
                                            <strong>Type</strong><br>
                                            <span class="text-capitalize" id="nstocktype">
                                                {{-- Content Here --}}
                                            </span>
                                        </div>
                                    </li>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <li>
                                        <div class="leftclass">
                                            <i class="fa fa-globe text-success" style="font-size: 20px;"></i>
                                            <!-- Icon for "Origin" -->
                                        </div>
                                        <div class="rightclass">
                                            <strong>Origin</strong><br>
                                            <span id="nstockorigin">
                                                {{-- Content Here --}}
                                            </span>
                                        </div>
                                    </li>
                                </div>
                                <div class="col">
                                    <li>
                                        <div class="leftclass">
                                            <i class="fa fa-certificate text-warning"
                                                style="font-size: 20px;"></i> <!-- Icon for "Badge" -->
                                        </div>
                                        <div class="rightclass">
                                            <strong>Badge</strong><br>
                                            <span id="nstockbadge">
                                                {{-- Content Here --}}
                                            </span>
                                        </div>
                                    </li>
                                </div>
                            </div>
                        </ul>
                        <p><strong>Verified By:</strong> Admin</p>
                    </div>

                    <div class="tab-content tabtabs rounded" id="tab-7">
                        <h5 class="mb-3"><i class="fas fa-tag text-primary"></i> Deal Information</h5>
                        {{-- <p class="mb-3">
                        <strong><i class="fas fa-gift text-success"></i> Special Offer:</strong> Get a <span class="text-success">10% discount</span> on your first purchase. 
                        Offer valid until <strong>January 31, 2025</strong>.
                    </p> --}}
                        <div
                            style="margin-bottom: 10px;background-color: #efefef;padding: 20px 5px 5px 20px;border-radius: 10px;">
                            <div class="row mb-1">
                                <div class="col-md-6 mb-1">
                                    <p class="d-flex flex-column">
                                        <span>
                                            <strong>Product Name</strong>
                                        </span>
                                        <span class="" id="nstockdealname">
                                            {{-- Product Name --}}
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <p class="d-flex flex-column">
                                        <span>
                                            <strong>Available Stock</strong>
                                        </span>
                                        <span class="" id="nstockdealavaliable">
                                            {{-- Available Stock --}}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-6 mb-1">
                                    <p class="d-flex flex-column">
                                        <span>
                                            <strong>Product Type</strong>
                                        </span>
                                        <span class="text-capitalize" id="nstockdealproducttype">
                                            {{-- Product Name --}}
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <p class="d-flex flex-column">
                                        <span>
                                            <strong>Min. Order Quantity</strong>
                                        </span>
                                        <span class="fs-5" id="nstockdealminorder">
                                            {{-- Min Order --}}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-6 mb-1">
                                    <p class="d-flex flex-column">
                                        <span>
                                            <strong>Refundable</strong>
                                        </span>
                                        <span class="fs-5" id="nstockdealrefundable">
                                            {{-- Refundable --}}
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <p class="d-flex flex-column">
                                        <span>
                                            <strong>Shipping Cost</strong>
                                        </span>
                                        <span class="fs-5" id="nstockdealshipping">
                                            {{-- Shipping Cost --}}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-content tabtabs rounded" id="tab-8">
                        <h5 class="mb-3">Contact Information</h5>
                        <p class="mb-3">For any inquiries, you can reach us at:</p>
                        <ul
                            style="list-style: none; background-color: #efefef;padding: 10px 10px 10px 20px;border-radius: 10px;">
                            <li class="mb-2"><i class="fas fa-envelope text-danger"></i>
                                <strong>Email:</strong>
                                <a class="text-decoration-none">
                                    <span id="ncompany-email">
                                        {{-- Email --}}
                                    </span>
                                </a>
                            </li>
                            <li class="mb-2"><i class="fas fa-phone text-success"></i>
                                <strong>Phone:</strong>
                                <span id="ncompany-phone">
                                    {{-- Phone --}}
                                </span>
                            </li>
                            <li class="mb-2"><i class="fas fa-map-marker-alt text-primary"></i>
                                <strong>Address:</strong>
                                <span id="ncompany-address">
                                    {{-- Company Address --}}
                                </span>
                            </li>
                            <li><i class="fas fa-industry text-warning"></i> <strong>Industry:</strong>
                                <span id="nindustry">
                                    {{-- Industry --}}
                                </span>
                            </li>
                        </ul>
                        <p class="mt-3"><strong>Company Name:</strong><span id="ncompany-name">
                                {{-- Company Name --}}
                            </span>
                        </p>
                        <div class="hereisbutton" style="display: flex; justify-content: space-around; margin-top: 22px;">
                            @if (auth('customer')->check() && auth('customer')->user()->id)
                                @if ($membership['status'] == 'active')
                                <button class="border-0" style="border-radius: 25px; padding: 10px 35px;" data-toggle="modal" data-target="#chatting_modalnew"
                                    data-seller-id="{{ $item->user_id }}" data-role="{{ $item->role }}"
                                    data-stock-id="{{ $item->id }}" data-typereq="stocksale" onclick="openChatModalnew(this)">
                                    Contact Seller
                                </button>
                                @else
                                <a href="{{ route('membership') }}">
                                    <button class="border-0" style="border-radius: 25px; padding: 10px 35px;">
                                        Contact Seller
                                    </button>
                                </a>
                                @endif
                            @else
                            <a href="#" onclick="openLoginModal()">
                                <button class="border-0" style="border-radius: 25px; padding: 10px 35px;">
                                    Contact Seller
                                </button>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<script>
    function ninsertcarousel(job) {
        // Assuming 'job.image' is a JSON string containing image URLs
        var images = JSON.parse(job.image);
        // var inserthere = document.getElementById('hereinsert'); // Get the carousel container
        var insertherealso = document.getElementById('nhereinsertalso');

        // inserthere.innerHTML = '';
        insertherealso.innerHTML = '';

        // Loop through the images and create carousel items
        images.forEach(function(image) {
            var imgElement = document.createElement('img');
            imgElement.src = '/' + image; // Assuming image path is relative
            imgElement.classList.add('item'); // Owl Carousel expects items to have a class

            // Optional styling
            imgElement.style.maxWidth = '100%';
            imgElement.style.maxHeight = '55vh';
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
    // Tab functionality
    document.addEventListener('DOMContentLoaded', () => {
        const tabLinks = document.querySelectorAll('.tabbuttons');
        const tabContents = document.querySelectorAll('.tabtabs');

        tabLinks.forEach(link => {
            link.addEventListener('click', () => {
                // Remove active class from all links
                tabLinks.forEach(link => link.classList.remove('active'));
                // Add active class to clicked link
                link.classList.add('active');
                console.log(link);
                // Hide all tab contents
                tabContents.forEach(content => content.classList.remove('active'));

                // Show the corresponding tab content
                const targetTab = document.getElementById(link.dataset.tab);
                if (targetTab) {
                    targetTab.classList.add('active');
                }
            });
        });
    });
</script>