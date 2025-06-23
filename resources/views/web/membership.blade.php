@extends('layouts.front-end.app')
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/membership.css') }}" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@section('title', translate('Membership' . ' | ' . $web_config['name']->value))
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
    ?>
    <div class="mainpagesection membershipplan" style="margin-top: 22px; background: unset;">
        <div class="nlic-pricing-table">

            <div class="nlic-column nlic-column-skus">
                <div>
                    <div class="nlic-column-head">
                        <div class="nlic-plan-name">

                        </div>
                        <div class="nlic-plan-description">

                        </div>
                        <div class="nlic-plan-price">

                        </div>
                    </div>
                    <ul class="nlic-sku-list">
                        @foreach ($memdata['type'] as $key => $value)
                            <li class="nlic-sku-item nlic-sku-COMMERCIAL-USE">{{ $value }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="nlic-column nlic-column-PLAN-OPENSOURCE">
                <div class="nlic-plan-column">
                    <div class="nlic-column-head">
                        <div class="nlic-plan-name">
                            Open Source
                        </div>
                        <div class="nlic-plan-description">
                            Open Source plan
                        </div>
                        <div class="nlic-plan-price">
                            Free
                        </div>
                    </div>
                    <ul class="nlic-sku-list">
                        <li class="nlic-sku-feature nlic-sku-COMMERCIAL-USE">
                            <div class="nlic-sku-description">
                                Commercial Use
                            </div>
                            <div class="nlic-sku-feature-item nlic-sku-feature-value-enabled"></div>
                        </li>
                        <li class="nlic-sku-feature nlic-sku-PLUGINS">
                            <div class="nlic-sku-description">
                                Extensions/Plugins
                            </div>
                            <div class="nlic-sku-feature-item nlic-sku-feature-value-enabled"></div>
                        </li>
                        <li class="nlic-sku-feature nlic-sku-NO-ATTRIBUTION">
                            <div class="nlic-sku-description">
                                Remove Attribution
                            </div>
                            <div class="nlic-sku-feature-item nlic-sku-feature-value-disabled"></div>
                        </li>
                        <li class="nlic-sku-feature nlic-sku-CUSTOMIZATION">
                            <div class="nlic-sku-description">
                                Customization
                            </div>
                            <div class="nlic-sku-feature-item nlic-sku-feature-value-disabled"></div>
                        </li>
                        <li class="nlic-sku-feature nlic-sku-SUPPORT">
                            <div class="nlic-sku-description">
                                Support
                            </div>
                            <div class="nlic-sku-feature-item nlic-sku-feature-value-disabled"></div>
                        </li>
                        <li class="nlic-sku-quota nlic-sku-DOMAINS">
                            <div class="nlic-sku-description">
                                Domains
                            </div>
                            <div class="nlic-sku-quota-item">
                                1
                            </div>
                        </li>
                    </ul>
                    <div class="nlic-action nlic-action-PLAN-OPENSOURCE">
                        <a href="https://go.netlicensing.io/shop/v2/?packagetoken=0448250a-ef3a-4cbd-a031-98deeaa65111"
                            class="nlic-action-url">Start Now Free</a>
                    </div>
                </div>
            </div>
            <div class="nlic-column nlic-column-PLAN-COMMERCIAL">
                <div class="nlic-plan-column">
                    <div class="nlic-column-head">
                        <div class="nlic-plan-name">
                            Commercial
                        </div>
                        <div class="nlic-plan-description">
                            Commercial plan
                        </div>
                        <div class="nlic-plan-price">
                            49 EUR / year
                        </div>
                    </div>
                    <ul class="nlic-sku-list">
                        <li class="nlic-sku-feature nlic-sku-COMMERCIAL-USE">
                            <div class="nlic-sku-description">
                                Commercial Use
                            </div>
                            <div class="nlic-sku-feature-item nlic-sku-feature-value-enabled"></div>
                        </li>
                        <li class="nlic-sku-feature nlic-sku-PLUGINS">
                            <div class="nlic-sku-description">
                                Extensions/Plugins
                            </div>
                            <div class="nlic-sku-feature-item nlic-sku-feature-value-enabled"></div>
                        </li>
                        <li class="nlic-sku-feature nlic-sku-NO-ATTRIBUTION">
                            <div class="nlic-sku-description">
                                Remove Attribution
                            </div>
                            <div class="nlic-sku-feature-item nlic-sku-feature-value-enabled"></div>
                        </li>
                        <li class="nlic-sku-feature nlic-sku-CUSTOMIZATION">
                            <div class="nlic-sku-description">
                                Customization
                            </div>
                            <div class="nlic-sku-feature-item nlic-sku-feature-value-disabled"></div>
                        </li>
                        <li class="nlic-sku-feature nlic-sku-SUPPORT">
                            <div class="nlic-sku-description">
                                Support
                            </div>
                            <div class="nlic-sku-feature-item nlic-sku-feature-value-disabled"></div>
                        </li>
                        <li class="nlic-sku-quota nlic-sku-DOMAINS">
                            <div class="nlic-sku-description">
                                Domains
                            </div>
                            <div class="nlic-sku-quota-item">
                                3
                            </div>
                        </li>
                    </ul>
                    <div class="nlic-action nlic-action-PLAN-COMMERCIAL">
                        <a href="https://go.netlicensing.io/shop/v2/?packagetoken=4505d572-5861-496c-bbc7-2823776d9e1e"
                            class="nlic-action-url">Get It Now</a>
                    </div>
                </div>
            </div>
            <div class="nlic-column nlic-column-PLAN-ENTERPRISE">
                <div class="nlic-plan-column">
                    <div class="nlic-column-head">
                        <div class="nlic-plan-name">
                            Enterprise
                        </div>
                        <div class="nlic-plan-description">
                            Enterprise plan
                        </div>
                        <div class="nlic-plan-price">
                            199 EUR / year
                        </div>
                    </div>
                    <ul class="nlic-sku-list">
                        <li class="nlic-sku-feature nlic-sku-COMMERCIAL-USE">
                            <div class="nlic-sku-description">
                                Commercial Use
                            </div>
                            <div class="nlic-sku-feature-item nlic-sku-feature-value-enabled"></div>
                        </li>
                        <li class="nlic-sku-feature nlic-sku-PLUGINS">
                            <div class="nlic-sku-description">
                                Extensions/Plugins
                            </div>
                            <div class="nlic-sku-feature-item nlic-sku-feature-value-enabled"></div>
                        </li>
                        <li class="nlic-sku-feature nlic-sku-NO-ATTRIBUTION">
                            <div class="nlic-sku-description">
                                Remove Attribution
                            </div>
                            <div class="nlic-sku-feature-item nlic-sku-feature-value-enabled"></div>
                        </li>
                        <li class="nlic-sku-feature nlic-sku-CUSTOMIZATION">
                            <div class="nlic-sku-description">
                                Customization
                            </div>
                            <div class="nlic-sku-feature-item nlic-sku-feature-value-enabled"></div>
                        </li>
                        <li class="nlic-sku-feature nlic-sku-SUPPORT">
                            <div class="nlic-sku-description">
                                Support
                            </div>
                            <div class="nlic-sku-feature-item nlic-sku-feature-value-enabled"></div>
                        </li>
                        <li class="nlic-sku-quota nlic-sku-DOMAINS">
                            <div class="nlic-sku-description">
                                Domains
                            </div>
                            <div class="nlic-sku-quota-item">
                                unlimited
                            </div>
                        </li>
                    </ul>
                    <div class="nlic-action nlic-action-PLAN-ENTERPRISE">
                        <a href="https://www.labs64.com/contact/" class="nlic-action-url">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Transaction Approval -->
    <div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transactionModalLabel">Process Your Transaction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="toggleModal()"></button>
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
                                    <h4 class="mb-2 text-nowrap">{{ translate('payment_method') }}</h4>
                                </div>
                                <p class="text-capitalize mt-2">{{ translate('select_a_payment_method_to_proceed') }}</p>
                            </div>
                            @if ($digital_payment['status'] == 1)
                                <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
                                    <h5 class="mb-0 text-capitalize">{{ translate('pay_via_online') }}</h5>
                                    <span
                                        class="fs-10 text-capitalize mt-1">({{ translate('faster_&_secure_way_to_pay') }})</span>
                                </div>

                                <div class="row gx-4 mb-4">
                                    @foreach ($payment_gateways_list as $payment_gateway)
                                        <div class="col-sm-6">
                                            <form method="post" class="digital_payment"
                                                id="{{ $payment_gateway->key_name }}_form"
                                                action="{{ route('membership-payment') }}"
                                                onclick="if (confirm('Are you sure you want to proceed with payment?')) { event.preventDefault(); this.submit(); }">
                                                @csrf
                                                <input type="hidden" name="user_id"
                                                    value="{{ auth('customer')->check() ? auth('customer')->user()->id : session('guest_id') }}">
                                                <input type="hidden" name="payment_method"
                                                    value="{{ $payment_gateway->key_name }}">
                                                <input type="hidden" name="payment_platform" value="web">
                                                <input type="hidden" id="paymentamount" name="payment_amount"
                                                    value="">
                                                <input type="hidden" name="callback" value="">
                                                <input type="hidden" name="external_redirect_link"
                                                    value="{{ route('web-payment-success') }}">

                                                <label
                                                    class="d-flex align-items-center gap-2 mb-0 form-check py-2 cursor-pointer">
                                                    <input type="radio" id="{{ $payment_gateway->key_name }}"
                                                        name="online_payment" class="form-check-input custom-radio"
                                                        value="{{ $payment_gateway->key_name }}">
                                                    <img width="30"
                                                        src="{{ dynamicStorage(path: 'storage/app/public/payment_modules/gateway_image') }}/{{ json_decode($payment_gateway->additional_data)->gateway_image }}"
                                                        alt="">
                                                    <span
                                                        class="text-capitalize form-check-label">{{ json_decode($payment_gateway->additional_data)->gateway_title ?? str_replace('_', ' ', $payment_gateway->key_name) }}</span>
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
            document.getElementById('modalMembershipDescription').innerText = 'Details: ' + membershipName +
                ' membership plan';
            document.getElementById('paymentamount').value = membershipPrice;

            // Show the modal
            var modal = new bootstrap.Modal(document.getElementById('transactionModal'));
            modal.show();
        }
    </script>
@endsection
