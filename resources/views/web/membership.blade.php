@extends('layouts.front-end.app')
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/membership.css') }}" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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

<div class="membership-page">
    <div class="container">
        <!-- Header Section -->
        <div class="membership-header">
            <h1>{{ translate('Choose Your Membership Plan') }}</h1>
            <p>{{ translate('Unlock premium features and exclusive benefits with our membership plans') }}</p>
            
            <!-- Billing Toggle -->
            <div class="billing-toggle">
                <div class="toggle-container">
                    <button class="toggle-option active" onclick="toggleBilling('monthly')">
                        {{ translate('Monthly') }}
                    </button>
                    <button class="toggle-option" onclick="toggleBilling('yearly')">
                        {{ translate('Yearly') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Membership Cards -->
        <div class="membership-cards">
            @foreach ($customer_tiers as $index => $tier)
                @php
                    $benefits = json_decode($tier->membership_benefits, true);
                    $price = $benefits['price'] ?? 0;
                    $membershipCheck = App\Utils\ChatManager::membershipChecker();
                    $isCurrentPlan = $membershipCheck['status'] === 'success' && $membershipCheck['membership'] == $tier->membership_name;
                    
                    // Make the center plan recommended (simple approach)
                    $totalPlans = $customer_tiers->count();
                    
                    // Simple center calculation - always make index 1 recommended for now
                    $isPopular = ($index === 1) || ($totalPlans === 3 && $index === 1) || ($totalPlans === 2 && $index === 1);
                    
                    // Debug: show values
                    echo "<!-- Index: $index, Total: $totalPlans, Popular: " . ($isPopular ? 'true' : 'false') . " -->";
                    
                    $isFree = strtolower($tier->membership_name) === 'free';
                    
                    // Define icons for different membership types
                    $iconMap = [
                        'free' => 'fa-user',
                        'basic' => 'fa-star',
                        'plus' => 'fa-crown',
                        'premium' => 'fa-gem',
                        'pro' => 'fa-rocket'
                    ];
                    $icon = $iconMap[strtolower($tier->membership_name)] ?? 'fa-medal';
                @endphp
                
                <div class="membership-card {{ $isPopular ? 'popular' : '' }}" data-index="{{ $index }}" data-popular="{{ $isPopular ? 'true' : 'false' }}">
                    @if($isPopular)
                        <div class="recommended-badge">{{ translate('Recommended') }}</div>
                    @endif
                    
                    <!-- Debug: Force show badge on second card for testing -->
                    <!-- @if($index === 1)
                        <div class="recommended-badge" style="background: red !important; top: -15px; right: 20px; position: absolute; z-index: 999; color: white; padding: 10px;">TEST BADGE</div>
                    @endif -->
                    
                    <div class="card-header">
                        <h3>{{ $tier->membership_name }}</h3>
                        <div class="billing-period">{{ translate('Monthly') }}</div>
                        <div class="price">
                            <span class="currency">$</span>{{ number_format($price, 0) }}
                            @if(!$isFree)
                                <div class="price-period">{{ translate('/month') }}</div>
                            @else
                                <div class="price-period">{{ translate('forever') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="features-title">{{ translate('Premium Features:') }}</div>
                        <ul class="features-list">
                            @foreach ($memdata['type'] as $featureIndex => $featureType)
                                @php
                                    $featureValue = $memdata['feature' . ($index + 1)][$featureIndex] ?? 'N/A';
                                    $isAvailable = $featureValue !== 'N/A' && $featureValue !== '0' && $featureValue !== 'No';
                                @endphp
                                <li class="{{ !$isAvailable ? 'unavailable' : '' }}">
                                    <i class="fas {{ $isAvailable ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                    <span>
                                        <strong>{{ $featureType }}</strong> - {{ $featureValue }}
                                        @if(isset($memdata['desc'][$featureIndex]) && $memdata['desc'][$featureIndex])
                                            <br><small>{{ $memdata['desc'][$featureIndex] }}</small>
                                        @endif
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="card-footer">
                        @if($isFree)
                            <button class="btn-membership current" disabled>
                                <i class="fas fa-check"></i>{{ translate('Current Plan') }}
                            </button>
                        @elseif($isCurrentPlan)
                            <button class="btn-membership current" disabled>
                                <i class="fas fa-check"></i>{{ translate('Current Plan') }}
                            </button>
                        @else
                            <button class="btn-membership" 
                                    onclick="toggleModal({{ $tier->id }}, '{{ $tier->membership_name }}', '{{ number_format($price, 2) }}', '{{ $tier->membership_name }} membership with premium features')">
                                {{ translate('Join This Plan') }}
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Enhanced Modal for Transaction Approval -->
<div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transactionModalLabel">
                    <i class="fas fa-credit-card me-2"></i>{{ translate('Complete Your Purchase') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Membership Details Card -->
                <div class="membership-details-card">
                    <div class="text-center">
                        <div class="plan-icon mx-auto mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-crown"></i>
                        </div>
                        <h4 class="fw-bold mb-3">{{ translate('Membership Details') }}</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <h6 class="text-muted">{{ translate('Plan Name') }}</h6>
                                <p id="modalMembershipName" class="fw-bold fs-5"></p>
                            </div>
                            <div class="col-md-4">
                                <h6 class="text-muted">{{ translate('Price') }}</h6>
                                <p id="modalMembershipPrice" class="fw-bold fs-5 text-success"></p>
                            </div>
                            <div class="col-md-4">
                                <h6 class="text-muted">{{ translate('Billing') }}</h6>
                                <p class="fw-bold fs-6">{{ translate('Monthly') }}</p>
                            </div>
                        </div>
                        <p id="modalMembershipDescription" class="text-muted mt-3"></p>
                    </div>
                </div>

                <!-- Payment Methods Section -->
                <div class="mt-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="mb-0">
                            <i class="fas fa-wallet me-2"></i>{{ translate('Payment Method') }}
                        </h5>
                        <span class="badge bg-success">
                            <i class="fas fa-shield-alt me-1"></i>{{ translate('Secure') }}
                        </span>
                    </div>
                    <p class="text-muted mb-4">{{ translate('Choose your preferred payment method to complete the purchase') }}</p>
                    
                    @if ($digital_payment['status'] == 1)
                        <div class="payment-methods">
                            @foreach ($payment_gateways_list as $payment_gateway)
                                <form method="post" class="digital_payment payment-method" 
                                      id="{{($payment_gateway->key_name)}}_form" 
                                      action="{{ route('membership-payment') }}">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ auth('customer')->check() ? auth('customer')->user()->id : session('guest_id') }}">
                                    <input type="hidden" name="payment_method" value="{{ $payment_gateway->key_name }}">
                                    <input type="hidden" name="payment_platform" value="web">
                                    <input type="hidden" class="paymentamount" name="payment_amount" value="">
                                    <input type="hidden" name="callback" value="">
                                    <input type="hidden" name="external_redirect_link" value="{{ route('web-payment-success') }}">
                                    
                                    <label class="w-100">
                                        <input type="radio" name="online_payment" class="custom-radio" value="{{$payment_gateway->key_name}}">
                                        <img width="40" height="40" 
                                             src="{{ dynamicStorage(path: 'storage/app/public/payment_modules/gateway_image') }}/{{ json_decode($payment_gateway->additional_data)->gateway_image }}" 
                                             alt="{{ json_decode($payment_gateway->additional_data)->gateway_title ?? str_replace('_', ' ', $payment_gateway->key_name) }}">
                                        <span class="fw-semibold">
                                            {{ json_decode($payment_gateway->additional_data)->gateway_title ?? str_replace('_', ' ', $payment_gateway->key_name) }}
                                        </span>
                                    </label>
                                </form>
                            @endforeach
                        </div>
                        
                        <!-- Proceed Button -->
                        <div class="text-center mt-4">
                            <button type="button" class="btn-membership" style="width: 240px;" onclick="processPayment()">
                                <i class="fas fa-lock"></i>
                                {{ translate('Complete Purchase') }}
                            </button>
                            <p class="text-muted mt-3 small">
                                <i class="fas fa-shield-alt me-1"></i>
                                {{ translate('Secure payment processing with 256-bit SSL encryption') }}
                            </p>
                        </div>
                    @else
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ translate('Online payments are currently disabled. Please contact support.') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Billing Toggle Functionality
    function toggleBilling(period) {
        const toggleOptions = document.querySelectorAll('.toggle-option');
        const billingPeriods = document.querySelectorAll('.billing-period');
        const pricePeriods = document.querySelectorAll('.price-period');
        
        // Update toggle buttons
        toggleOptions.forEach(option => {
            option.classList.remove('active');
        });
        
        if (period === 'monthly') {
            toggleOptions[0].classList.add('active');
            billingPeriods.forEach(el => el.textContent = '{{ translate("Monthly") }}');
            pricePeriods.forEach(el => {
                if (!el.textContent.includes('forever')) {
                    el.textContent = '{{ translate("/month") }}';
                }
            });
        } else {
            toggleOptions[1].classList.add('active');
            billingPeriods.forEach(el => el.textContent = '{{ translate("Yearly") }}');
            pricePeriods.forEach(el => {
                if (!el.textContent.includes('forever')) {
                    el.textContent = '{{ translate("/year") }}';
                }
            });
            
            // You can add yearly pricing logic here
            // For example, multiply prices by 10 for yearly discount
        }
    }

    let currentTierId = null;
    let currentPrice = null;

    function toggleModal(tierId, membershipName, membershipPrice, membershipDescription = '') {
        currentTierId = tierId;
        currentPrice = membershipPrice;
        
        // Set membership details in modal
        document.getElementById('modalMembershipName').innerText = membershipName;
        document.getElementById('modalMembershipPrice').innerText = '$' + membershipPrice;
        document.getElementById('modalMembershipDescription').innerText = membershipDescription || membershipName + ' membership plan with premium features';
        
        // Set payment amounts for all forms
        const paymentAmountInputs = document.querySelectorAll('.paymentamount');
        paymentAmountInputs.forEach(input => {
            input.value = membershipPrice;
        });

        // Show the modal
        var modal = new bootstrap.Modal(document.getElementById('transactionModal'));
        modal.show();
    }

    function processPayment() {
        const selectedPayment = document.querySelector('input[name="online_payment"]:checked');
        
        if (!selectedPayment) {
            alert('{{ translate("Please select a payment method") }}');
            return;
        }

        const form = selectedPayment.closest('form');
        
        if (confirm('{{ translate("Are you sure you want to proceed with payment?") }}')) {
            form.submit();
        }
    }

    // Add click event to payment methods for better UX
    document.addEventListener('DOMContentLoaded', function() {
        const paymentMethods = document.querySelectorAll('.payment-method');
        
        paymentMethods.forEach(method => {
            method.addEventListener('click', function() {
                // Remove selected class from all methods
                paymentMethods.forEach(m => m.classList.remove('selected'));
                
                // Add selected class to clicked method
                this.classList.add('selected');
                
                // Check the radio button
                const radio = this.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                }
            });
        });
    });

    // Add smooth scroll and animation effects
    window.addEventListener('scroll', function() {
        const cards = document.querySelectorAll('.membership-card');
        
        cards.forEach(card => {
            const rect = card.getBoundingClientRect();
            const isVisible = rect.top < window.innerHeight && rect.bottom > 0;
            
            if (isVisible) {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }
        });
    });
</script>
@endsection