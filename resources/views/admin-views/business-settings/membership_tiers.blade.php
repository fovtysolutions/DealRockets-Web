@extends('layouts.back-end.app-partial')

@section('title', translate('Membership Tiers'))

@section('content')
<style>
    .customertiers span{
        font-size: smaller;
    }

    .sellertiers span{
        font-size: smaller;
    }

    .randomclass span{
        font-size: medium;
        margin-left: 10px;
    }

    .randomclass input[type=checkbox]{
	height: 0;
	width: 0;
	visibility: hidden;
    }

    .randomclass label {
        cursor: pointer;
        text-indent: -9999px;
        width: 50px;
        height: 25px;
        background: grey;
        display: block;
        border-radius: 100px;
        position: relative;
    }

    .randomclass label:after {
        content: '';
        position: absolute;
        top: 3px;
        left: 5px;
        width: 19px;
        height: 19px;
        background: #fff;
        border-radius: 90px;
        transition: 0.3s;
    }

    .randomclass input:checked + label {
        background: #bada55;
    }

    .randomclass input:checked + label:after {
        left: calc(100% - 5px);
        transform: translateX(-100%);
    }

    .randomclass label:active:after {
        width: 19px;
    }

    .randomclass1 .mainDiv{
        width: 100%;
        height: 15vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .randomclass1 .mainSwitch{
        height: 50px;
        width: 200px;
        position: relative;
        display: flex;
        align-items:center;
        justify-content: space-around;
        background-color: lightgray;
        border-radius: 50px;
    }

    .randomclass1 .mainSwitch button{
        background-color: transparent;
        border: none;
        z-index: 10;
    }

    .randomclass1 .backgroundPill{
        position: absolute;
        background-color: white;
        width: 100px;
        height: 40px;
        border-radius: 50px;
        left: 5px;
        transition: 0.5s;
        box-shadow: 0 8px 8px 0 rgba(0,0,0,0.1)
    }
</style>
<div class="container mt-5">
    <div class="row">
        <div class="col">
            {{-- Balancer --}}
        </div>
        <div class="col">
            <h2 class="text-center mb-4 h-100 align-content-center">Membership Tiers</h2>
        </div>
        <div class="col d-flex justify-content-end">
            <a href="{{ route('admin.membershipplancrete') }}" class="btn btn-primary" style="height: 42px;">Create a Plan</a>
        </div>
    </div>
    <div class="row randomclass1">
        {{-- Toggle Memberships --}}
        <div class="mainDiv">
            <div class="mainSwitch">
                <div class="backgroundPill"></div>
                <button onclick="movePill(this)" value="customer">Customer</button>
                <button onclick="movePill(this)" value="seller">Seller</button>
            </div>
        </div>
    </div>
    <div class="row customertiers">
        @if(isset($customer_tiers))
            @foreach($customer_tiers as $tier)
                <!-- Free Tier -->
                <div class="col-md-3 mb-3">
                    <div class="card shadow">
                        <div class="card-header text-center bg-primary text-white">
                            <h4 class="text-white text-center w-100">{{ $tier->membership_name }}</h4>
                        </div>
                        <div class="card-body">
                            <!-- Toggle Switch -->
                            <form method="POST" action="{{ route('membership-tiers.update', ['membership_tier' => $tier->id]) }}" class="mb-0 randomclass d-flex justify-content-center">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" value="{{ $tier->membership_active == 1 ? 0 : 1 }}" name="membership_active">
                                <input type="checkbox" id="toggle-plan-{{ $tier->id }}" value="1" {{ $tier->membership_active == 1 ? 'checked' : '' }} 
                                onchange="this.form.submit()" /><label for="toggle-plan-{{ $tier->id }}">Toggle</label>
                            </form>
                            <form method="POST" action="{{ route('membership-tiers.update',['membership_tier' => $tier->id])}}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="membership_id" value="{{ $tier->membership_id }}">
                                <input type="hidden" name="membership_name" value="{{ $tier->membership_name }}">
                                @php
                                    $data = json_decode($tier->membership_benefits,true);
                                @endphp

                                <!-- Description -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea id="description" name="description" class="form-control" placeholder="Enter Description">{{ $data['description'] ?? '' }}</textarea>
                                    <span>Description</span>
                                </div>
                                
                                <!-- Price -->
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" step="0.01" id="price" name="price" class="form-control" placeholder="Enter limit" value="{{ $data['price'] ?? ''}}">
                                    <span>Price</span>
                                </div>

                                <!-- Order -->
                                <div class="mb-3">
                                    <label for="membership_order" class="form-label">Membership Order</label>
                                    <input type="integer" id="membership_order" name="membership_order" class="form-control" placeholder="Enter limit" value="{{ $tier->membership_order ?? ''}}">
                                    <span>Order to Show the Membership</span>
                                </div>

                                <!-- Buy Leads -->
                                <div class="mb-3">
                                    <label for="buy_leads_free" class="form-label">Buy Leads</label>
                                    <input type="integer" id="buy_leads_free" name="buy_leads" class="form-control" placeholder="Enter limit" value="{{ $data['buy_leads'] ?? ''}}">
                                    <span>Set Limit of Leads -1 for infinite</span>
                                </div>

                                <div class="mb-3">
                                    <label for="no_of_cv" class="form-label">Limit CV</label>
                                    <input type="integer" id="no_of_cv" name="no_of_cv" class="form-control" placeholder="Enter limit" value="{{ $data['no_of_cv'] ?? ''}}">
                                    <span>Set Limit of CV -1 for infinite</span>
                                </div>

                                <div class="mb-3">
                                    <label for="charge_cv" class="form-label">CV Charge</label>
                                    <input type="integer" id="charge_cv" name="charge_cv" class="form-control" placeholder="Enter price" value="{{ $data['charge_cv'] ?? ''}}">
                                    <span>Set Limit of Charge -1 for No Charge</span>
                                </div>

                                <!-- Sell Leads -->
                                <div class="mb-3">
                                    <label for="sell_leads_free" class="form-label">Sell Leads</label>
                                    <input type="integer" id="sell_leads_free" name="sell_leads" class="form-control" placeholder="Enter limit" value="{{ $data['sell_leads'] ?? ''}}">
                                    <span>Set Limit of Leads -1 for infinite</span>
                                </div>

                                <!-- Industry Jobs -->
                                <div class="mb-3">
                                    <label for="industry_jobs_free" class="form-label">Industry Jobs</label>
                                    <select id="industry_jobs_free" name="industry_jobs" class="form-control">
                                        <option value="" disabled>Select a Option</option>
                                        <option value="yes" {{ isset($data['industry_jobs']) && $data['industry_jobs'] === 'yes' ? 'selected' : ''}}>Yes</option>
                                        <option value="no" {{ isset($data['industry_jobs']) && $data['industry_jobs'] === 'no' ? 'selected' : ''}}>No</option>
                                    </select>
                                    <span>Select For Access to Jobs</span>
                                </div>

                                {{-- Update --}}
                                <div class="mb-3">
                                    <button type="submit" name="update" id="update-free" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <div class="row sellertiers" style="display: none;">
        @if(isset($seller_tiers))
            @foreach($seller_tiers as $tier)
                <div class="col-md-4 mb-3">
                    <div class="card shadow">
                        <div class="card-header text-center bg-primary text-white">
                            <h4 class="text-white text-center w-100">{{ $tier->membership_name }}</h4>
                        </div>
                        @php
                            $data = json_decode($tier->membership_benefits,true);
                        @endphp
                        <div class="card-body">
                            <!-- Toggle Switch -->
                            <form method="POST" action="{{ route('membership-tiers.update', ['membership_tier' => $tier->id]) }}" class="mb-0 randomclass d-flex justify-content-center">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" value="{{ $tier->membership_active == 1 ? 0 : 1 }}" name="membership_active">
                                <input type="checkbox" id="toggle-plan-{{ $tier->id }}" value="1" {{ $tier->membership_active == 1 ? 'checked' : '' }} 
                                onchange="this.form.submit()" /><label for="toggle-plan-{{ $tier->id }}">Toggle</label>
                            </form>
                            <form method="POST" action="{{ route('membership-tiers.update',['membership_tier' => $tier->id])}}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="membership_id" value="{{ $tier->membership_id }}">
                                <input type="hidden" name="membership_name" value="{{ $tier->membership_name }}">
                                @php
                                    $data = json_decode($tier->membership_benefits,true);
                                @endphp

                                <!-- Description -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea id="description" name="description" class="form-control" placeholder="Enter Description">{{ $data['description'] ?? '' }}</textarea>
                                    <span>Description</span>
                                </div>

                                <!-- Price -->
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" step="0.01" id="price" name="price" class="form-control" placeholder="Enter limit" value="{{ $data['price'] ?? ''}}">
                                    <span>Price</span>
                                </div>

                                <!-- Order -->
                                <div class="mb-3">
                                    <label for="membership_order" class="form-label">Membership Order</label>
                                    <input type="integer" id="membership_order" name="membership_order" class="form-control" placeholder="Enter limit" value="{{ $tier->membership_order ?? ''}}">
                                    <span>Order to Show the Membership</span>
                                </div>
                                
                                <!-- Buy Leads -->
                                <div class="mb-3">
                                    <label for="buy_leads_free" class="form-label">Buy Leads</label>
                                    <input type="integer" id="buy_leads_free" name="buy_leads" class="form-control" placeholder="Enter limit" value="{{ $data['buy_leads'] ?? ''}}">
                                    <span>Set Limit of Leads -1 for infinite</span>
                                </div>

                                <!-- Sell Leads -->
                                <div class="mb-3">
                                    <label for="sell_leads_free" class="form-label">Sell Leads</label>
                                    <input type="integer" id="sell_leads_free" name="sell_leads" class="form-control" placeholder="Enter limit" value="{{ $data['sell_leads'] ?? ''}}">
                                    <span>Set Limit of Leads -1 for infinite</span>
                                </div>

                                <div class="mb-3">
                                    <label for="no_of_cv" class="form-label">Limit CV</label>
                                    <input type="integer" id="no_of_cv" name="no_of_cv" class="form-control" placeholder="Enter limit" value="{{ $data['no_of_cv'] ?? ''}}">
                                    <span>Set Limit of CV -1 for infinite</span>
                                </div>

                                <div class="mb-3">
                                    <label for="charge_cv" class="form-label">CV Charge</label>
                                    <input type="integer" id="charge_cv" name="charge_cv" class="form-control" placeholder="Enter price" value="{{ $data['charge_cv'] ?? ''}}">
                                    <span>Set Limit of Charge -1 for No Charge</span>
                                </div>

                                <!-- Sell Leads -->
                                <div class="mb-3">
                                    <label for="sell_offer_free" class="form-label">Sell Offer Post</label>
                                    <input type="integer" id="sell_offer_free" name="sell_offer" class="form-control" placeholder="Enter limit" value="{{ $data['sell_offer'] ?? ''}}">
                                    <span>Set Limit of Leads -1 for infinite</span>
                                </div>

                                <!-- Industry Jobs -->
                                <div class="mb-3">
                                    <label for="industry_jobs_free" class="form-label">Industry Jobs</label>
                                    <select id="industry_jobs_free" name="industry_jobs" class="form-control">
                                        <option value="" disabled>Select a Option</option>
                                        <option value="yes" {{ isset($data['industry_jobs']) && $data['industry_jobs'] === 'yes' ? 'selected' : ''}}>Yes</option>
                                        <option value="no" {{ isset($data['industry_jobs']) && $data['industry_jobs'] === 'no' ? 'selected' : ''}}>No</option>
                                    </select>
                                    <span>Select For Access to Jobs</span>
                                </div>

                                {{-- Update --}}
                                <div class="mb-3">
                                    <button type="submit" name="update" id="update-free" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                        <div class="row ml-2 randomclass">
                            <!-- Access Leads -->
                            <div class="col-md-6 d-flex justify-content-left">
                                <form method="POST" action="{{ route('membership-tiers.update', ['membership_tier' => $tier->id]) }}" class="mb-0 randomclass d-flex justify-content-center">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="access_leads" value="{{ isset($data['access_leads']) && $data['access_leads'] == 1 ? 0 : 1 }}">
                                    <input type="checkbox" id="access-leads-{{ $tier->id }}" name="access_leads" value="1" 
                                        {{ isset($data['access_leads']) && $data['access_leads'] == 1 ? 'checked' : '' }} 
                                        onchange="this.form.submit()" />
                                    <label for="access-leads-{{ $tier->id }}">Leads</label>
                                    <span>Leads</span>
                                </form>
                            </div>
                            <!-- Access Suppliers -->
                            <div class="col-md-6 d-flex justify-content-right">
                                <form method="POST" action="{{ route('membership-tiers.update', ['membership_tier' => $tier->id]) }}" class="mb-0 randomclass d-flex justify-content-center">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="access_suppliers" value="{{ isset($data['access_suppliers']) && $data['access_suppliers'] == 1 ? 0 : 1 }}">
                                    <input type="checkbox" id="access-suppliers-{{ $tier->id }}" name="access_suppliers" value="1" 
                                        {{ isset($data['access_suppliers']) && $data['access_suppliers'] == 1 ? 'checked' : '' }} 
                                        onchange="this.form.submit()" />
                                    <label for="access-suppliers-{{ $tier->id }}">Suppliers</label>
                                    <span>Suppliers</span>
                                </form>
                            </div>
                            <!-- Access Jobs -->
                            <div class="col-md-6 d-flex justify-content-left">
                                <form method="POST" action="{{ route('membership-tiers.update', ['membership_tier' => $tier->id]) }}" class="mb-0 randomclass d-flex justify-content-center">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="access_jobs" value="{{ isset($data['access_jobs']) && $data['access_jobs'] == 1 ? 0 : 1 }}">
                                    <input type="checkbox" id="access-jobs-{{ $tier->id }}" name="access_jobs" value="1" 
                                        {{ isset($data['access_jobs']) && $data['access_jobs'] == 1 ? 'checked' : '' }} 
                                        onchange="this.form.submit()" />
                                    <label for="access-jobs-{{ $tier->id }}">Jobs</label>
                                    <span>Jobs</span>
                                </form>
                            </div>
                            <!-- Access Jobs -->
                            <div class="col-md-6 d-flex justify-content-left">
                                <form method="POST" action="{{ route('membership-tiers.update', ['membership_tier' => $tier->id]) }}" class="mb-0 randomclass d-flex justify-content-center">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="access_stock" value="{{ isset($data['access_stock']) && $data['access_stock'] == 1 ? 0 : 1 }}">
                                    <input type="checkbox" id="access-stock-{{ $tier->id }}" name="access_stock" value="1" 
                                        {{ isset($data['access_stock']) && $data['access_stock'] == 1 ? 'checked' : '' }} 
                                        onchange="this.form.submit()" />
                                    <label for="access-stock-{{ $tier->id }}">Stock</label>
                                    <span>Stock</span>
                                </form>
                            </div>
                        </div>                        
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
<script>
    function movePill(a) {
        let pill = document.querySelector(".backgroundPill"); // The moving pill
        let sellertiers = document.querySelector(".sellertiers"); // Seller tiers section
        let customertiers = document.querySelector(".customertiers"); // Customer tiers section

        if (a.value === "customer") {
            // Move the pill to the left
            pill.style.left = "5px";

            // Show customer tiers and hide seller tiers
            customertiers.style.display = "flex";
            sellertiers.style.display = "none";
        } else if (a.value === "seller") {
            // Move the pill to the right
            pill.style.left = "47%";

            // Show seller tiers and hide customer tiers
            sellertiers.style.display = "flex";
            customertiers.style.display = "none";
        }
    }
</script>
@endsection
