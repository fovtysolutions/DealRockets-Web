@extends('layouts.back-end.app-partial')

@section('title', translate('Membership Create Plan'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 m-4">
            <div class="card">
                <div class="card-header">
                    <h4>{{ translate('Create Membership Tier') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('membership-tiers.store') }}" method="POST">
                        @csrf

                        <!-- Membership ID -->
                        <div class="form-group mb-3">
                            <label for="membership_id">{{ translate('Membership ID') }}</label>
                            <input type="text" id="membership_id" name="membership_id" class="form-control" value="{{ $membershipId }}" readonly required>
                            @error('membership_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Membership Name -->
                        <div class="form-group mb-3">
                            <label for="membership_name">{{ translate('Membership Name / Tier (Ex. Free or Premium)') }}</label>
                            <input type="text" id="membership_name" name="membership_name" class="form-control" value="{{ old('membership_name') }}" required>
                            @error('membership_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Membership Benefits -->
                        {{-- <div class="form-group mb-3">
                            <label for="membership_benefits">{{ translate('Membership Benefits') }}</label>
                            <textarea id="membership_benefits" name="membership_benefits" class="form-control" rows="4" required>{{ old('membership_benefits') }}</textarea>
                            @error('membership_benefits')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div> --}}

                        <!-- Membership Type -->
                        <div class="form-group mb-3">
                            <label for="membership_type">{{ translate('Membership Type') }}</label>
                            <select id="membership_type" name="membership_type" class="form-control" required>
                                <option value="" disabled selected>{{ translate('Select Membership Type') }}</option>
                                <option value="customer">{{ translate('Customer') }}</option>
                                <option value="seller">{{ translate('Seller') }}</option>
                            </select>
                            @error('membership_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Membership Active -->
                        <div class="form-group mb-3">
                            <label for="membership_active">{{ translate('Membership Active') }}</label>
                            <select id="membership_active" name="membership_active" class="form-control" required>
                                <option value="1" {{ old('membership_active') == '1' ? 'selected' : '' }}>{{ translate('Active') }}</option>
                                <option value="0" {{ old('membership_active') == '0' ? 'selected' : '' }}>{{ translate('Inactive') }}</option>
                            </select>
                            @error('membership_active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Membership Order -->
                        <div class="form-group mb-3">
                            <label for="membership_order">{{ translate('Membership Order') }}</label>
                            <input type="number" id="membership_order" name="membership_order" class="form-control" value="{{ old('membership_order') }}" required>
                            @error('membership_order')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group mb-3 text-center">
                            <button type="submit" class="btn btn-primary">{{ translate('Create Membership Tier') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
