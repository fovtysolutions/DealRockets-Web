@extends('layouts.back-end.app-partialseller')

@section('title', translate('Membership Tiers'))

@section('content')
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/membership.css') }}" />
<div class="container mt-5">
    <div class="row">
        <div class="col">
            {{-- Balancer --}}
        </div>
        <div class="col">
            <h2 class="text-center mb-4 h-100 align-content-center">Membership Tiers</h2>
        </div>
        <div class="col">
            {{-- Balancer --}}
        </div>
    </div>
    <div class="row sellertiers">
        <div class="container">
            <table>
                @for($i = 0; $i < ($seller_tiers->count()+1); $i++)
                    <colgroup></colgroup>
                @endfor
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        @foreach ($seller_tiers as $tier)
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
                        @for($i = 0; $i < ($seller_tiers->count()); $i++)
                            @if($seller_tiers[$i]->membership_name === 'Free')
                                <td>No action needed (Free Membership)</td>
                            @else
                                <td>
                                    @php
                                        $membershipCheck = App\Utils\ChatManager::membershipChecker();
                                    @endphp
                                    
                                    @if($membershipCheck['status'] === 'success' && $membershipCheck['membership'] == $seller_tiers[$i]->membership_name)
                                        <span>Already Applied</span>
                                    @else
                                    <a href="javascript:void(0)" 
                                        class="transactionMod" 
                                        style="background-color: #0073c7;" 
                                        data-tier-id="{{ $seller_tiers[$i]->id }}" 
                                        data-membership-name="{{ $seller_tiers[$i]->membership_name }}" 
                                        data-membership-price="{{ number_format(json_decode($seller_tiers[$i]->membership_benefits,true)['price'], 2) }}"
                                    >
                                        Apply for Membership
                                    </a>
                                    @endif
                                </td>
                            @endif
                        @endfor
                    </tr>
                </tfoot>            
                <tbody>
                    @foreach ($memdatar['type'] as $index => $type)
                        <tr>
                            <th>{{ $type }} <span>{{ $memdatar['desc'][$index] }}.</span></th>
                            @for ($i = 1; $i <= $memdatar['totalTiers']; $i++)
                                <td>{{ $memdatar['feature' . $i][$index] ?? 'N/A' }}</td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>                 
        </div>
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
                                        <form method="post" class="digital_payment" id="{{($payment_gateway->key_name)}}_form" action="{{ route('membership-payment-seller') }}" 
                                            onclick="if (confirm('Are you sure you want to proceed with payment?')) { event.preventDefault(); this.submit(); }">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ auth('seller')->check() ? auth('seller')->user()->id : session('guest_id') }}">
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
document.querySelectorAll('.transactionMod').forEach(button => {
    button.addEventListener('click', function () {
        // Retrieve data from data-* attributes
        const tierId = this.getAttribute('data-tier-id');
        const membershipName = this.getAttribute('data-membership-name');
        const membershipPrice = this.getAttribute('data-membership-price');

        console.log('Clicked:', { tierId, membershipName, membershipPrice });

        // Update modal content
        document.getElementById('modalMembershipName').innerText = 'Membership: ' + membershipName;
        document.getElementById('modalMembershipPrice').innerText = 'Price: $' + membershipPrice;
        document.getElementById('modalMembershipDescription').innerText = 'Details: ' + membershipName + ' membership plan';
        document.getElementById('paymentamount').value = membershipPrice;

        // Show the modal
        const modalElement = document.getElementById('transactionModal');
        const modal = new bootstrap.Modal(modalElement); // Bootstrap Modal instance
        modal.show();
    });
});
</script>
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
        console.log('toggleModal called with:', tierId, membershipName, membershipPrice);

        // Set membership details in modal
        document.getElementById('modalMembershipName').innerText = 'Membership: ' + membershipName;
        document.getElementById('modalMembershipPrice').innerText = 'Price: $' + membershipPrice;
        document.getElementById('modalMembershipDescription').innerText = 'Details: ' + membershipName + ' membership plan';
        document.getElementById('paymentamount').value = membershipPrice;

        // Show the modal using Bootstrap's JavaScript API
        const modalElement = document.getElementById('transactionModal');
        const modal = new bootstrap.Modal(modalElement); // Bootstrap Modal instance
        modal.show();
    }
</script>
@endsection
