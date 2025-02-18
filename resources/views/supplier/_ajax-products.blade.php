<?php
$allCategories = ['Electronics', 'Clothing', 'Home Appliances'];
?>

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
@if (count($products) > 0)
    @php($decimal_point_settings = getWebConfig(name: 'decimal_point_settings'))
    <div class="rightsideven">
        <div class="gridviewven">
            <h5 class="pagetitleven">All Suppliers</h5>
            <div class="boundaryven"></div>
            <div class="catandview">
                <div class="catsuggestbox">
                    <div class="categories">
                        <p>Total {{$totalsuppliers}} Suppliers Found on Same Category</p>
                    </div>
                </div>
            </div>
            <div class="boundaryven"></div>

            <div class="custom-list-container" id="listView">
                @foreach ($combinedSuppliers as $supplier)
                    <div class="custom-list-item">
                        <div class="custom-left-section">
                            <h6>{{ $supplier['suppliers']->name }}</h6>
                            <p>Business Type: {{ $supplier['suppliers']->business_type }}</p>
                            <p>Main Products: {{ $supplier['suppliers']->main_products }}</p>
                            <p>Certification: {{ $supplier['suppliers']->management_certification ?? 'Not Available' }}</p>
                            <p>Location: {{ $supplier['suppliers']->city_province }}</p>
                            <div class="custom-button-group">
                                @if (auth('customer')->check() && auth('customer')->user()->id)
                                    @if ($membership['status'] == 'active')
                                        <button class="custom-button" data-toggle="modal"
                                            data-target="#chatting_modalnew"
                                            data-seller-id="{{ $supplier['shop']['added_by'] }}"
                                            data-user-type="{{ $supplier['suppliers']->role }}"
                                            data-role="{{ $supplier['shop']['role'] }}"
                                            data-suppliers-id="{{ $supplier['suppliers']->id }}" data-typereq="supplier"
                                            data-shop-name="{{ $supplier['shop']['shop_name'] }}"
                                            onclick="openChatModalnew(this)">
                                            <img src="{{ asset('/svgs/mail.png') }}" /> Contact Now or
                                            <img src="{{ asset('/svgs/messenger.png') }}" /> Chat
                                        </button>
                                    @else
                                        <a href="{{ route('membership') }}">
                                            <button class="custom-button">
                                                <img src="{{ asset('/svgs/mail.png') }}" /> Contact Now or
                                                <img src="{{ asset('/svgs/messenger.png') }}" /> Chat
                                            </button>
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('customer.auth.login') }}">
                                        <button class="custom-button">
                                            <img src="{{ asset('/svgs/mail.png') }}" /> Contact Now or
                                            <img src="{{ asset('/svgs/messenger.png') }}" /> Chat
                                        </button>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="custom-right-section">
                            <img src="{{ asset('storage/' . $supplier['suppliers']->image1) ?? 'https://via.placeholder.com/100' }}"
                                alt="Supplier Image" class="custom-main-image" />
                            <div class="custom-thumbnail-group">
                                <img src="{{ asset('storage/' . $supplier['suppliers']->image2) ?? 'https://via.placeholder.com/50' }}"
                                    alt="Additional Image" class="custom-thumbnail" />
                                <img src="{{ asset('storage/' . $supplier['suppliers']->image3) ?? 'https://via.placeholder.com/50' }}"
                                    alt="Additional Image" class="custom-thumbnail" />
                            </div>
                            <p>0 views</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Pagination -->
            <div class="pagination-container">
                {{ $suppliers->links() }}
            </div>
        </div>
    </div>
@else
    <div class="d-flex justify-content-center align-items-center w-100 py-5">
        <div>
            <img src="{{ theme_asset(path: 'public/assets/front-end/img/media/product.svg') }}" class="img-fluid"
                alt="">
            <h6 class="text-muted">{{ translate('no_product_found') }}</h6>
        </div>
    </div>
@endif
    <!-- Modal -->
    <div class="modal fade" id="chatting_modalnew" tabindex="-1" role="dialog" aria-labelledby="chatModalNewLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-faded-info">
                    <h6 class="modal-title text-capitalize" id="chatModalNewTitle"></h6>
                    <button type="button" class="text-white close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="seller-chat-form">
                        @csrf
                        <input type="hidden" name="typereq" id="typereq" value="">
                        <input type="hidden" name="suppliers_id" id="suppliers_id" value="">
                        <input type="hidden" name="sender_id" id="sender_id" value="{{ $user_id }}">
                        <input type="hidden" name="sender_type" id="sender_type" value="{{ $role }}">
                        <input type="hidden" name="receiver_id" id="receiver_id"
                            value="">
                        <input type="hidden" name="receiver_type" id="receiver_type" value="">
                        <textarea name="message" class="form-control min-height-100px max-height-200px" required
                            placeholder="{{ translate('Write_here') }}..."></textarea>
                        <br>
                        <div class="justify-content-end gap-2 d-flex flex-wrap">
                            <button type="button" class="btn btn--primary text-white"
                                id="send-message-btn">{{ translate('send') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    // Handle form submission with AJAX
    $('#send-message-btn').on('click', function (e) {
        e.preventDefault();  // Prevent default form submission

        // Collect form data
        var formData = {
            sender_id: $('#sender_id').val(),
            sender_type: $('#sender_type').val(),
            receiver_id: $('#receiver_id').val(),
            receiver_type: $('#receiver_type').val(),
            type: $('#typereq').val(),
            suppliers_id: $('#suppliers_id').val(),
            message: $('textarea[name="message"]').val(),
            _token: $('input[name="_token"]').val()  // CSRF token
        };

        // Send AJAX POST request
        $.ajax({
            url: '{{ route("sendmessage.other") }}',  // Backend route
            type: 'POST',
            data: formData,
            success: function (response) {
                toastr.success('Message sent successfully!', 'Success');
                $('#chatting_modalnew').modal('hide');  // Hide modal
            },
            error: function (xhr, status, error) {
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
        const suppliersId = button.getAttribute('data-suppliers-id');
        const typereq = button.getAttribute('data-typereq');

        // Update modal title
        document.getElementById('chatModalNewTitle').innerText = `Chat with ${shopName}`;

        // Populate form hidden inputs
        document.getElementById('typereq').value = typereq;
        document.getElementById('suppliers_id').value = suppliersId;
        document.getElementById('receiver_id').value = sellerId;
        document.getElementById('receiver_type').value = role;
    }
</script>
<script>
    function showGridView() {
        document.getElementById('gridView').style.display = 'block';
        document.getElementById('listView').style.display = 'none';
    }

    function showListView() {
        document.getElementById('gridView').style.display = 'none';
        document.getElementById('listView').style.display = 'block';
    }
</script>
<script>
    $(document).ready(function() {
        $(".owl-carousel").owlCarousel({
            items: 3,
            loop: true,
            autoplay: true,
            autoplayTimeout: 2000,
            responsive: {
                0: {
                    items: 1
                },
                464: {
                    items: 2
                },
                1024: {
                    items: 3
                }
            }
        });
    });
</script>
