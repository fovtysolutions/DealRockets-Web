@extends('layouts.front-end.app')
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/stocksale.css')}}" />
@section('title',translate('Stock Sale'. ' | ' . $web_config['name']->value))
@section('content')
<?php 
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
<div class="mainpagesection">
    <div class="leadpagedivision">
        <div class="leadleftdivision">
            <div class="card">
                <form method="GET" action="{{ route('stocksale') }}" id="filterForm">
                    <ul class="list-group p-3">
                        <h6 class="m-3">Text Search</h6>
                        <div class="input-group mb-3">
                            <span class="input-group-text"> Text: </span>
                            <input type="text" name="textsearch" class="form-control" value="{{ request('textsearch') }}">
                        </div>
                        <h6 class="m-3">Deadline</h6>
                        <div class="input-group mb-3">
                            <span class="input-group-text"> From: </span>
                            <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"> To: </span>
                            <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                        </div>
                        <h6 class="m-3">Quantity</h6>
                        <div class="input-group mb-3">
                            <span class="input-group-text"> Min: </span>
                            <input type="number" name="minqty" class="form-control" value="{{ request('minqty') }}">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"> Max: </span>
                            <input type="number" name="maxqty" class="form-control" value="{{ request('maxqty') }}">
                        </div>
                        <button type="submit" class="newleadsbutton" id="filterButton">Filter</button>
                        <button type="reset" class="newleadsbutton" id="filterButton">Reset</button>
                    </ul>
                </form>
            </div>
        </div>
        <div class="leadrightdivision">
            <div class="card border-0" style="background-color:var(--web-bg);">
                <span> <a href="/"> Home </a> / <a href="/stock-sale"> Stock Sale </a> </span>
            </div>
            <div class="card border-0" style="background-color:var(--web-bg);">
                @if(count($items) === 0)
                    <div class="leadsrelatedbox">
                        <p>No Stock Sale Found.</p>
                    </div>
                @else
                    @foreach($items as $item)
                        <div class="leadsrelatedbox">
                            <div class="leadsrelatedboxcontent border-end border-secondary">
                                <a>{{ $item->name }}</a>
                                <div class="d-flex">
                                    <p class="bylinerelated mr-3">Min Quantity: {{ $item->quantity }}</p>
                                </div>
                                <p>{{ $item->description }}</p>
                                <p class="bylinerelated my-3 text-start">
                                    {{ ($item->added_by) }}
                                </p>
                                <p class="bylinerelated my-3 text-start">Date Posted: {{ $item->created_at }}</p>
                            </div>
                            <div class="leadsrelatedboxbutton">
                                @if(auth('customer')->check() && auth('customer')->user()->id)
                                    @if($membership['status'] == 'active')
                                    <button data-toggle="modal" data-target="#chatting_modalnew"
                                        data-seller-id="{{ $item->user_id }}"
                                        data-role="{{ $item->role }}"
                                        data-stock-id="{{ $item->id }}" data-typereq="stocksale"
                                        onclick="openChatModalnew(this)">
                                        Contact Seller
                                    </button>
                                    @else
                                        <a href="{{ route('membership') }}">
                                            <button>
                                                Contact Seller
                                            </button>
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('customer.auth.login') }}">
                                        <button>
                                            Contact Seller
                                        </button>
                                    </a>
                                @endif
                                <p class="bylinerelated m-1">{{ $item->quote_recieved }} quote Received</p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            {{ $items->links() }}
        </div>
    </div>
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
                        <input type="hidden" name="stockid" id="stockid" value="">
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
            stocksell_id : $('#stockid').val(),
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
        const role = button.getAttribute('data-role');
        const stockId = button.getAttribute('data-stock-id');
        const typereq = button.getAttribute('data-typereq');

        // Update modal title
        document.getElementById('chatModalNewTitle').innerText = `Send Message to StockSell`;

        // Populate form hidden inputs
        document.getElementById('typereq').value = typereq;
        document.getElementById('stockid').value = stockId;
        document.getElementById('receiver_id').value = sellerId;
        document.getElementById('receiver_type').value = role;
    }
</script>
@endsection