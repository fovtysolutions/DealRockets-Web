@extends('layouts.front-end.app')

@push('css_or_js')
    <style>
        /* Container */
        .otp-container {
            background-color: #fff;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            padding: 2rem;
            width: 100%;
            max-width: 20rem;
            /* xs */
            margin: 30px auto;
        }

        @media (min-width: 768px) {
            .otp-container {
                max-width: 28rem;
                /* md */
            }
        }

        /* Heading */
        .otp-title {
            font-size: 1.25rem;
            font-weight: 700;
            text-align: center;
            color: #1f2937;
            /* gray-800 */
            margin-bottom: 1.5rem;
        }

        @media (min-width: 768px) {
            .otp-title {
                font-size: 1.5rem;
            }
        }

        /* Subtitle */
        .otp-subtitle {
            text-align: center;
            color: #4b5563;
            /* gray-600 */
            margin-bottom: 1rem;
        }

        /* Input fields container */
        .otp-inputs {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        /* OTP input field */
        .otp-input {
            width: 2.5rem;
            height: 2.5rem;
            border: 1px solid #d1d5db;
            /* gray-300 */
            border-radius: 0.5rem;
            text-align: center;
            font-size: 1.125rem;
            font-weight: 600;
            outline: none;
            transition: box-shadow 0.2s ease;
        }

        @media (min-width: 768px) {
            .otp-input {
                width: 3rem;
                height: 3rem;
            }
        }

        .otp-input:focus {
            box-shadow: 0 0 0 2px #d14f4f;
            /* purple-500 ring */
            border-color: #e76161;
        }

        /* Submit button */
        .otp-submit-btn {
            width: 100%;
            background-color: #e71f1f;
            /* purple-500 */
            color: white;
            padding: 0.5rem 0;
            border-radius: 0.5rem;
            border-color:white;
            font-weight: 600;
            transition: background-color 0.2s ease;
        }

        @media (min-width: 768px) {
            .otp-submit-btn {
                padding: 0.75rem 0;
            }
        }

        .otp-submit-btn:hover {
            background-color: #e71f1f;
            /* purple-600 */
        }

        /* Resend link */
        .otp-resend {
            text-align: center;
            color: #4b5563;
            margin-top: 1.5rem;
        }

        .otp-resend a {
            color: #e52222;
            text-decoration: none;
        }

        .otp-resend a:hover {
            color: #e52222;
            text-decoration: underline;
        }
    </style>
@endpush

@section('title', translate('vendor_Apply'))

@section('content')
    <div class="otp-container">
        <h2 class="otp-title">Verify Your OTP</h2>
        <p class="otp-subtitle">Enter the 5-digit OTP sent to your email.</p>
        <form id="otp-form" method="POST" action="{{ route('verify-otp-custom') }}">
            @csrf
            <input type="hidden" value="" name="otp" id="otp">
            <div class="otp-inputs">
                <input type="text" maxlength="1" class="otp-input" />
                <input type="text" maxlength="1" class="otp-input" />
                <input type="text" maxlength="1" class="otp-input" />
                <input type="text" maxlength="1" class="otp-input" />
                <input type="text" maxlength="1" class="otp-input" />
            </div>
            <button type="submit" class="otp-submit-btn">Verify OTP</button>
        </form>
        <p class="otp-resend">
            Didn’t receive the code? <a id="resend-otp" href="javascript:">Resend OTP</a>
        </p>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.otp-input');
            const hiddenOtpInput = document.getElementById('otp');

            function updateHiddenOtp() {
                let otp = '';
                inputs.forEach(input => otp += input.value);
                hiddenOtpInput.value = otp;
            }

            inputs.forEach((input, index) => {
                // 🟡 Handle Paste Event
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pasteData = (e.clipboardData || window.clipboardData).getData('text')
                        .replace(/\D/g, '');

                    if (pasteData.length !== 5) return;

                    pasteData.split('').forEach((char, idx) => {
                        if (inputs[idx]) {
                            inputs[idx].value = char;
                        }
                    });

                    inputs[4].focus(); // Focus last field
                    updateHiddenOtp();
                });

                // 🟢 Handle Manual Input
                input.addEventListener('input', function() {
                    if (input.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                    updateHiddenOtp();
                });

                // 🔙 Handle Backspace Navigation
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && input.value === '' && index > 0) {
                        inputs[index - 1].focus();
                    }
                });
            });

            // 🟠 Resend OTP
            $('#resend-otp').on('click', function(e) {
                e.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                $.ajax({
                    url: "{{ route('resend-otp-custom') }}",
                    method: "POST",
                    data: {
                        vendor_type: @json($vendor_type),
                        email: @json($email),
                        phone: @json($phone),
                        password: @json($password),
                        confirm_password: @json($confirm_password),
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success('OTP resent to your email.');
                        } else {
                            toastr.info(response.message || 'Failed to resend OTP');
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Server error: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
@endpush
