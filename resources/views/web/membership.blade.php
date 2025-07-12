@extends('layouts.front-end.app')
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/membership.css') }}" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@section('title',translate('Membership'. ' | ' . $web_config['name']->value))
@section('content')
<?php
$categories = \App\Utils\CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
$unread = \App\Utils\ChatManager::unread_messages();
if(Auth('customer')->check()){
    $membership = \App\Utils\ChatManager::getMembershipStatusCustomer(Auth('customer')->user()->id);
    if (isset($membership['error'])){
        $membership = ['status' => 'NotMade', 'message' => 'Membership Not Applied'];
    }
}
?>
<div class="mainpagesecton py-5">
    <div class="container">
        <table>
            @for($i = 0; $i < ($customer_tiers->count()+1); $i++)
                <colgroup></colgroup>
            @endfor
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    @foreach ($customer_tiers as $tier)
                        <th>
                            <h2>{{ $tier->membership_name }}</h2>
                            <p>$ {{ number_format(json_decode($tier->membership_benefits,true)['price'] ?? 0, 2) }}</p> <!-- Fetch price from benefits -->
                            @if ($tier->membership_name == 'Plus') <!-- Example promo based on name -->
                                <p class="promo">Our most valuable package!</p>
                            @endif
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>&nbsp;</th>
                    @for($i = 0; $i < ($customer_tiers->count()); $i++)
                        @if($customer_tiers[$i]->membership_name === 'Free')
                            <td>No action needed (Free Membership)</td>
                        @else
                            <td>
                                @php
                                    $membershipCheck = App\Utils\ChatManager::membershipChecker();
                                @endphp
                                
                                @if($membershipCheck['status'] === 'success' && $membershipCheck['membership'] == $customer_tiers[$i]->membership_name)
                                    <span>Already Applied</span>
                                @else
                                    <a href="#" 
                                       onclick="toggleModal({{ $customer_tiers[$i]->id }}, '{{ $customer_tiers[$i]->membership_name }}', '{{ number_format(json_decode($customer_tiers[$i]->membership_benefits,true)['price'], 2) }}')">
                                       Apply for Membership
                                    </a>
                                @endif
                            </td>
                        @endif
                    @endfor
                </tr>
            </tfoot>            
            <tbody>
                @foreach ($memdata['type'] as $index => $type)
                    <tr>
                        <th>{{ $type }} <span>{{ $memdata['desc'][$index] }}.</span></th>
                        @for ($i = 1; $i <= $memdata['totalTiers']; $i++)
                            <td>{{ $memdata['feature' . $i][$index] ?? 'N/A' }}</td>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>                 
    </div>
</div>
<!-- Modal for Transaction Approval -->
<div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transactionModalLabel">Process Your Transaction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="toggleModal()"></button>
            </div>
            <div class="modal-body text-center">
                <div class="card mt-3">
                    <div class="card-body">
                        <h4 class="text-capitalize">Membership Details</h4>
                        <p id="modalMembershipName"></p>
                        <p id="modalMembershipPrice"></p>
                        <p id="modalMembershipDescription"></p>

                        <div class="gap-2 mb-4">
                            <div class="d-flex justify-content-between">
                                <h4 class="mb-2 text-nowrap">{{ translate('payment_method')}}</h4>
                            </div>
                            <p class="text-capitalize mt-2">{{ translate('select_a_payment_method_to_proceed')}}</p>
                        </div>
                        @if ($digital_payment['status'] == 1)
                            <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
                                <h5 class="mb-0 text-capitalize">{{ translate('pay_via_online') }}</h5>
                                <span class="fs-10 text-capitalize mt-1">({{ translate('faster_&_secure_way_to_pay') }})</span>
                            </div>

                            <div class="row gx-4 mb-4">
                                @foreach ($payment_gateways_list as $payment_gateway)
                                    <div class="col-sm-6">
                                        <form method="post" class="digital_payment" id="{{($payment_gateway->key_name)}}_form" action="{{ route('membership-payment') }}" 
                                            onclick="if (confirm('Are you sure you want to proceed with payment?')) { event.preventDefault(); this.submit(); }">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ auth('customer')->check() ? auth('customer')->user()->id : session('guest_id') }}">
                                            <input type="hidden" name="payment_method" value="{{ $payment_gateway->key_name }}">
                                            <input type="hidden" name="payment_platform" value="web">
                                            <input type="hidden" id="paymentamount" name="payment_amount" value="">
                                            <input type="hidden" name="callback" value="">
                                            <input type="hidden" name="external_redirect_link" value="{{ route('web-payment-success') }}">
                                            
                                            <label class="d-flex align-items-center gap-2 mb-0 form-check py-2 cursor-pointer">
                                                <input type="radio" id="{{($payment_gateway->key_name)}}" name="online_payment" class="form-check-input custom-radio" value="{{($payment_gateway->key_name)}}">
                                                <img width="30" src="{{ dynamicStorage(path: 'storage/app/public/payment_modules/gateway_image') }}/{{ json_decode($payment_gateway->additional_data)->gateway_image }}" alt="">
                                                <span class="text-capitalize form-check-label">{{ json_decode($payment_gateway->additional_data)->gateway_title ?? str_replace('_', ' ', $payment_gateway->key_name) }}</span>
                                            </label>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function toggleModal() {
        const modal = document.getElementById('transactionModal');

        if (modal.classList.contains('show')) {
            // Hide the modal
            modal.classList.remove('show');
            modal.style.display = 'none';
            document.body.classList.remove('modal-open'); // Remove body modal class
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove(); // Remove the backdrop
        } else {
            // Show the modal
            modal.classList.add('show');
            modal.style.display = 'block';
            document.body.classList.add('modal-open'); // Add body modal class

            // Add a backdrop
            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show';
            document.body.appendChild(backdrop);
        }
    }
</script>
<script>
    function toggleModal(tierId, membershipName, membershipPrice) {
        // Set membership details in modal
        document.getElementById('modalMembershipName').innerText = 'Membership: ' + membershipName;
        document.getElementById('modalMembershipPrice').innerText = 'Price: $' + membershipPrice;
        document.getElementById('modalMembershipDescription').innerText = 'Details: ' + membershipName + ' membership plan';
        document.getElementById('paymentamount').value = membershipPrice;

        // Show the modal
        var modal = new bootstrap.Modal(document.getElementById('transactionModal'));
        modal.show();
    }
</script>
@endsection