<div class="form-group">
    <label class="form-label font-semibold">
        {{ translate('email') }}
        <span class="input-required-icon">*</span>
    </label>
    <input class="form-control text-align-direction auth-email-input" type="text" name="user_identity" id="si-email"
           value="{{old('user_identity')}}" placeholder="{{ translate('Email') }}"
           required>
    <div class="invalid-feedback">{{ translate('Please Provice a valid email') }} .</div>
</div>
