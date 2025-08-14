@extends('layouts.back-end.app')

@section('title', translate('Membership Tiers Management'))

@section('content')
<div class="content container-fluid">
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-10 mb-3">
        <div>
            <h1 class="page-header-title text-break">
                <i class="tio-premium-outlined"></i>
                {{ translate('Membership Tiers') }}
            </h1>
            <p class="mb-0">{{ translate('Manage your membership plans and features') }}</p>
        </div>
        
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary" onclick="toggleFeatureManagement()">
                <i class="tio-settings"></i> {{ translate('Manage Features') }}
            </button>
            <a href="{{ route('admin.membershipplancrete') }}" class="btn btn-primary">
                <i class="tio-add"></i> {{ translate('Create Plan') }}
            </a>
        </div>
    </div>

    <!-- Feature Management Panel (Initially Hidden) -->
    <div id="featureManagementPanel" class="card mb-4" style="display: none;">
        <div class="card-header">
            <h4><i class="tio-settings-outlined"></i> {{ translate('Feature Management') }}</h4>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($availableFeatures as $category => $features)
                    <div class="col-md-4 mb-3">
                        <h5 class="text-primary">{{ ucwords(str_replace('_', ' ', $category)) }}</h5>
                        @foreach($features as $feature)
                            <div class="card border mb-2">
                                <div class="card-body p-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="font-weight-bold">{{ $feature->name }}</small>
                                            @if($feature->is_topup_enabled)
                                                <span class="badge badge-success badge-soft">Topup: ${{ $feature->topup_price_per_unit }}</span>
                                            @endif
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" 
                                                   {{ $feature->is_active ? 'checked' : '' }}
                                                   onchange="toggleFeature({{ $feature->id }}, this.checked)">
                                        </div>
                                    </div>
                                    <small class="text-muted">{{ $feature->description }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Membership Type Toggle -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-center">
                <div class="btn-group" role="group">
                    <input type="radio" class="btn-check" name="membershipType" id="customerType" value="customer" checked>
                    <label class="btn btn-outline-primary" for="customerType">
                        <i class="tio-user"></i> {{ translate('Customer Plans') }}
                    </label>
                    
                    <input type="radio" class="btn-check" name="membershipType" id="sellerType" value="seller">
                    <label class="btn btn-outline-primary" for="sellerType">
                        <i class="tio-shop"></i> {{ translate('Seller Plans') }}
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Tiers -->
    <div id="customerTiers" class="tier-container">
        <div class="row">
            @foreach($customer_tiers as $tier)
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card h-100 {{ $tier->is_featured ? 'border-primary' : '' }}">
                        @if($tier->is_featured)
                            <div class="ribbon ribbon-primary">{{ translate('Featured') }}</div>
                        @endif
                        
                        <div class="card-header text-center">
                            <h4 class="card-title">{{ $tier->membership_name }}</h4>
                            <div class="h2 text-primary">${{ $tier->formatted_price }}</div>
                            <small class="text-muted">{{ $tier->billing_cycle }}</small>
                        </div>
                        
                        <div class="card-body">
                            <!-- Status Toggle -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span>{{ translate('Status') }}</span>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" 
                                           {{ $tier->membership_active ? 'checked' : '' }}
                                           onchange="toggleTierStatus({{ $tier->id }}, this.checked)">
                                </div>
                            </div>

                            <!-- Quick Edit Form -->
                            <form id="tierForm{{ $tier->id }}" onsubmit="updateTier(event, {{ $tier->id }})">
                                @csrf
                                @method('PATCH')
                                
                                <div class="form-group">
                                    <label>{{ translate('Price') }} ($)</label>
                                    <input type="number" step="0.01" class="form-control form-control-sm" 
                                           name="price" value="{{ $tier->price }}">
                                </div>
                                
                                <div class="form-group">
                                    <label>{{ translate('Order') }}</label>
                                    <input type="number" class="form-control form-control-sm" 
                                           name="membership_order" value="{{ $tier->membership_order }}">
                                </div>

                                <!-- Features -->
                                <div class="features-section">
                                    <h6>{{ translate('Features') }}</h6>
                                    @php
                                        $legacyBenefits = $tier->getLegacyBenefits();
                                    @endphp
                                    
                                    @if($tier->features->count() > 0)
                                        @foreach($tier->features as $feature)
                                            <div class="feature-item mb-2">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="font-weight-bold">{{ $feature->name }}</small>
                                                    @if($feature->pivot->is_unlimited)
                                                        <span class="badge badge-success">Unlimited</span>
                                                    @else
                                                        <input type="text" class="form-control form-control-sm w-25" 
                                                               name="features[{{ $feature->id }}][value]" 
                                                               value="{{ $feature->pivot->value }}">
                                                    @endif
                                                </div>
                                                <div class="form-check form-check-sm">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="features[{{ $feature->id }}][unlimited]"
                                                           {{ $feature->pivot->is_unlimited ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unlimited</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <!-- Legacy Benefits Display -->
                                        <div class="legacy-benefits">
                                            @if(isset($legacyBenefits['buy_leads']))
                                                <div class="d-flex justify-content-between">
                                                    <small>Buy Leads:</small>
                                                    <input type="number" class="form-control form-control-sm w-25" 
                                                           name="buy_leads" value="{{ $legacyBenefits['buy_leads'] ?? 0 }}">
                                                </div>
                                            @endif
                                            
                                            @if(isset($legacyBenefits['sell_leads']))
                                                <div class="d-flex justify-content-between mt-2">
                                                    <small>Sell Leads:</small>
                                                    <input type="number" class="form-control form-control-sm w-25" 
                                                           name="sell_leads" value="{{ $legacyBenefits['sell_leads'] ?? 0 }}">
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-soft-primary btn-sm w-100 mt-3">
                                    <i class="tio-save"></i> {{ translate('Update') }}
                                </button>
                            </form>
                        </div>
                        
                        <div class="card-footer">
                            <div class="d-flex gap-2">
                                <button class="btn btn-soft-info btn-sm flex-grow-1" 
                                        onclick="editTierModal({{ $tier->id }})">
                                    <i class="tio-edit"></i> {{ translate('Edit') }}
                                </button>
                                <button class="btn btn-soft-danger btn-sm" 
                                        onclick="deleteTier({{ $tier->id }})">
                                    <i class="tio-delete"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Seller Tiers -->
    <div id="sellerTiers" class="tier-container" style="display: none;">
        <div class="row">
            @foreach($seller_tiers as $tier)
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card h-100 {{ $tier->is_featured ? 'border-primary' : '' }}">
                        @if($tier->is_featured)
                            <div class="ribbon ribbon-primary">{{ translate('Featured') }}</div>
                        @endif
                        
                        <div class="card-header text-center">
                            <h4 class="card-title">{{ $tier->membership_name }}</h4>
                            <div class="h2 text-primary">${{ $tier->formatted_price }}</div>
                            <small class="text-muted">{{ $tier->billing_cycle }}</small>
                        </div>
                        
                        <div class="card-body">
                            <!-- Status Toggle -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span>{{ translate('Status') }}</span>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" 
                                           {{ $tier->membership_active ? 'checked' : '' }}
                                           onchange="toggleTierStatus({{ $tier->id }}, this.checked)">
                                </div>
                            </div>

                            <!-- Quick Edit Form -->
                            <form id="tierForm{{ $tier->id }}" onsubmit="updateTier(event, {{ $tier->id }})">
                                @csrf
                                @method('PATCH')
                                
                                <div class="form-group">
                                    <label>{{ translate('Price') }} ($)</label>
                                    <input type="number" step="0.01" class="form-control form-control-sm" 
                                           name="price" value="{{ $tier->price }}">
                                </div>
                                
                                <div class="form-group">
                                    <label>{{ translate('Order') }}</label>
                                    <input type="number" class="form-control form-control-sm" 
                                           name="membership_order" value="{{ $tier->membership_order }}">
                                </div>

                                <button type="submit" class="btn btn-soft-primary btn-sm w-100 mt-3">
                                    <i class="tio-save"></i> {{ translate('Update') }}
                                </button>
                            </form>
                        </div>
                        
                        <div class="card-footer">
                            <div class="d-flex gap-2">
                                <button class="btn btn-soft-info btn-sm flex-grow-1" 
                                        onclick="editTierModal({{ $tier->id }})">
                                    <i class="tio-edit"></i> {{ translate('Edit') }}
                                </button>
                                <button class="btn btn-soft-danger btn-sm" 
                                        onclick="deleteTier({{ $tier->id }})">
                                    <i class="tio-delete"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
.ribbon {
    position: absolute;
    top: 10px;
    right: -5px;
    z-index: 1;
    color: white;
    font-size: 0.75rem;
    padding: 0.25rem 0.75rem;
    border-radius: 0.25rem 0 0 0.25rem;
}

.ribbon-primary {
    background: linear-gradient(45deg, #007bff, #0056b3);
}

.feature-item {
    padding: 0.25rem;
    border: 1px solid #e9ecef;
    border-radius: 0.25rem;
    background: #f8f9fa;
}

.legacy-benefits {
    max-height: 200px;
    overflow-y: auto;
}

.tier-container {
    transition: all 0.3s ease;
}

.form-check-sm .form-check-input {
    transform: scale(0.8);
}

.form-check-sm .form-check-label {
    font-size: 0.8rem;
}
</style>

<script>
// Toggle between customer and seller tiers
document.querySelectorAll('input[name="membershipType"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const customerTiers = document.getElementById('customerTiers');
        const sellerTiers = document.getElementById('sellerTiers');
        
        if (this.value === 'customer') {
            customerTiers.style.display = 'block';
            sellerTiers.style.display = 'none';
        } else {
            customerTiers.style.display = 'none';
            sellerTiers.style.display = 'block';
        }
    });
});

// Toggle feature management panel
function toggleFeatureManagement() {
    const panel = document.getElementById('featureManagementPanel');
    panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
}

// Update tier via AJAX
async function updateTier(event, tierId) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    
    try {
        const response = await fetch(`{{ route('membership-tiers.update', '') }}/${tierId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: formData
        });
        
        if (response.ok) {
            toastr.success('{{ translate("Tier updated successfully!") }}');
        } else {
            toastr.error('{{ translate("Failed to update tier") }}');
        }
    } catch (error) {
        console.error('Error:', error);
        toastr.error('{{ translate("An error occurred") }}');
    }
}

// Toggle tier status
async function toggleTierStatus(tierId, isActive) {
    const formData = new FormData();
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    formData.append('_method', 'PATCH');
    formData.append('membership_active', isActive ? '1' : '0');
    
    try {
        const response = await fetch(`{{ route('membership-tiers.update', '') }}/${tierId}`, {
            method: 'POST',
            body: formData
        });
        
        if (response.ok) {
            toastr.success(isActive ? '{{ translate("Tier activated") }}' : '{{ translate("Tier deactivated") }}');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

// Toggle feature status
async function toggleFeature(featureId, isActive) {
    // Implementation for feature toggle
    console.log('Toggle feature', featureId, isActive);
}

// Delete tier
function deleteTier(tierId) {
    if (confirm('{{ translate("Are you sure you want to delete this tier?") }}')) {
        // Implementation for deletion
        console.log('Delete tier', tierId);
    }
}

// Edit tier modal
function editTierModal(tierId) {
    // Implementation for detailed edit modal
    console.log('Edit tier modal', tierId);
}
</script>
@endsection