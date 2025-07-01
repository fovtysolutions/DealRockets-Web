@php($rememberId = rand(111, 999))
<div class="form-group d-flex flex-wrap justify-content-between mb-1" style="flex-direction: row;">
    <div class="rtl">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="remember"
                   id="remember{{ $rememberId }}" {{ old('remember') ? 'checked' : '' }}>
            <label class="custom-control-label" for="remember{{ $rememberId }}" style="color: rgba(81, 80, 80, 1); font-weight: 400; padding-top:4px;">{{ translate('remember_me') }}</label>
        </div>
    </div>
    @if(isset($forgotPassword) && $forgotPassword)
        <a class="font-size-sm text-underline" style="color: rgba(37, 99, 235, 1); padding-top: 4px;" href="{{route('customer.auth.recover-password')}}">
            {{ translate('forgot_password') }}?
        </a>
    @endif
</div>
