@extends('layouts.front-end.app')

@section('title', translate('Membership Topup'. ' | ' . $web_config['name']->value))

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-plus-circle"></i> {{ translate('Membership Topups') }}</h4>
                    <p class="mb-0">{{ translate('Purchase additional credits for your membership features') }}</p>
                </div>
                
                <div class="card-body">
                    @if($membership)
                        <div class="current-membership mb-4">
                            <h5>{{ translate('Current Membership') }}: {{ $membership->membershipTier->membership_name ?? 'Unknown' }}</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>{{ translate('Status') }}:</strong> 
                                        <span class="badge badge-{{ $membership->isActive() ? 'success' : 'warning' }}">
                                            {{ ucfirst($membership->membership_status) }}
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    @if($membership->expires_at)
                                        <p><strong>{{ translate('Expires') }}:</strong> {{ $membership->expires_at->format('M d, Y') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Topup Features -->
                        @foreach($topupFeatures as $category => $features)
                            <div class="feature-category mb-4">
                                <h5 class="text-primary">{{ ucwords(str_replace('_', ' ', $category)) }}</h5>
                                <div class="row">
                                    @foreach($features as $feature)
                                        <div class="col-md-6 mb-3">
                                            <div class="card border">
                                                <div class="card-body">
                                                    <h6 class="card-title">{{ $feature->name }}</h6>
                                                    <p class="card-text small">{{ $feature->description }}</p>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="text-success font-weight-bold">
                                                            ${{ number_format($feature->topup_price_per_unit, 2) }}{{ $feature->unit }}
                                                        </span>
                                                        <button class="btn btn-sm btn-primary" onclick="openTopupModal({{ $feature->id }})">
                                                            <i class="fas fa-plus"></i> {{ translate('Add') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ translate('No active membership found. Please purchase a membership plan first.') }}
                            <a href="{{ route('web.membership') }}" class="btn btn-primary btn-sm ml-2">
                                {{ translate('View Plans') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar with Topup History -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-history"></i> {{ translate('Topup History') }}</h5>
                </div>
                <div class="card-body">
                    @if($topupHistory->count() > 0)
                        @foreach($topupHistory as $topup)
                            <div class="topup-item border-bottom pb-2 mb-2">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $topup->membershipFeature->name }}</strong>
                                    <span class="badge badge-{{ $topup->status === 'completed' ? 'success' : 'warning' }}">
                                        {{ ucfirst($topup->status) }}
                                    </span>
                                </div>
                                <div class="text-muted small">
                                    <div>{{ translate('Quantity') }}: {{ $topup->quantity }}</div>
                                    <div>{{ translate('Used') }}: {{ $topup->used_quantity }}</div>
                                    <div>{{ translate('Remaining') }}: {{ $topup->remaining_quantity }}</div>
                                    <div>{{ translate('Amount') }}: ${{ number_format($topup->total_amount, 2) }}</div>
                                    <div>{{ $topup->created_at->format('M d, Y') }}</div>
                                </div>
                            </div>
                        @endforeach
                        
                        {{ $topupHistory->links() }}
                    @else
                        <p class="text-muted">{{ translate('No topup history found.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Topup Modal -->
<div class="modal fade" id="topupModal" tabindex="-1" aria-labelledby="topupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="topupModalLabel">{{ translate('Purchase Topup') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="topupForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="featureId" name="feature_id">
                    
                    <div class="feature-details mb-3">
                        <h6 id="featureName"></h6>
                        <p id="featureDescription" class="text-muted"></p>
                    </div>

                    <div class="form-group mb-3">
                        <label for="quantity">{{ translate('Quantity') }}</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="1000" value="1" required>
                        <small class="text-muted">{{ translate('How many units would you like to purchase?') }}</small>
                    </div>

                    <div class="pricing-info mb-3">
                        <div class="d-flex justify-content-between">
                            <span>{{ translate('Unit Price') }}:</span>
                            <span id="unitPrice">$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <strong>{{ translate('Total') }}:</strong>
                            <strong id="totalPrice">$0.00</strong>
                        </div>
                    </div>

                    @if($digital_payment['status'] == 1)
                        <div class="form-group">
                            <label>{{ translate('Payment Method') }}</label>
                            @foreach($payment_gateways_list as $gateway)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" 
                                           id="payment_{{ $gateway->key_name }}" value="{{ $gateway->key_name }}" required>
                                    <label class="form-check-label" for="payment_{{ $gateway->key_name }}">
                                        {{ json_decode($gateway->additional_data)->gateway_title ?? str_replace('_', ' ', $gateway->key_name) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ translate('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-credit-card"></i> {{ translate('Purchase') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentFeature = null;

function openTopupModal(featureId) {
    fetch(`/membership-topup/feature/${featureId}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }

            currentFeature = data.feature;
            document.getElementById('featureId').value = featureId;
            document.getElementById('featureName').textContent = currentFeature.name;
            document.getElementById('featureDescription').textContent = currentFeature.description;
            document.getElementById('unitPrice').textContent = `$${data.formatted_price}`;
            
            updateTotalPrice();
            $('#topupModal').modal('show');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load feature details');
        });
}

function updateTotalPrice() {
    if (!currentFeature) return;
    
    const quantity = parseInt(document.getElementById('quantity').value) || 1;
    const total = quantity * parseFloat(currentFeature.topup_price_per_unit);
    document.getElementById('totalPrice').textContent = `$${total.toFixed(2)}`;
}

document.getElementById('quantity').addEventListener('input', updateTotalPrice);

document.getElementById('topupForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('{{ route("web.membership.topup.store") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.error || 'Purchase failed');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Purchase failed');
    });
});
</script>
@endsection