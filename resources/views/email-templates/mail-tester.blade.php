<?php
$companyPhone = getWebConfig(name: 'company_phone');
$companyEmail = getWebConfig(name: 'company_email');
$companyName = getWebConfig(name: 'company_name');
$companyLogo = getWebConfig(name: 'company_web_logo');

// $helpCenterUrl = route('helpTopic');
// $quotationUrl = route('quotationweb');
// $faqUrl = route('user.account');
// $privacyPolicyUrl = route('privacy.policy');
// $unsubscribeUrl = route('email.unsubscribe');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ translate('test_Mail') }} - {{ translate('mail_configuration_check') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            /* border: 2px solid #007bff; */
            padding: 10px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .content {
            margin: 20px 0;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="text-center">
                <img height="60" class="mb-4" id="view-mail-icon"
                    src="{{ getStorageImages(path: $companyLogo, type: 'backend-logo') }}" alt="">
            </div>
            {{-- <h1>{{ translate('test_Mail') }} - {{ translate('Mail_Configuration_Check') }}</h1> --}}
        </div>
        <div class="content">
            <p>{{ translate('Dear') }} {{ translate('Sir') }}/{{ translate('Mam') }},</p>
            <p>{{ translate('this_is_a_test_email_to_confirm_that_mail_configuration_is_working_correctly.') }}
                {{ translate('if_you_received_this_message,_it_means_everything_is_set_up_properly.') }}</p>
            <p>{{ translate('thank_you') }}</p>
        </div>
        <div class="footer"
            style="background-color:#f7f7f7; padding: 30px; font-family: sans-serif; font-size: 14px; color: #555; text-align: center;">
            <p>{{ translate('best_regards') }},</p>
            <p><strong>{{ $companyName }}</strong></p>
            <p><strong>{{ translate('phone') }}:</strong> {{ $companyPhone }}</p>
            <p><strong>{{ translate('Email') }}:</strong> {{ $companyEmail }}</p>

            <div style="margin: 20px 0;">
                <!-- Social Icons -->
                <a href="https://facebook.com/yourpage" style="margin: 0 8px;"><img
                        src="https://cdn-icons-png.flaticon.com/24/733/733547.png" alt="Facebook"></a>
                <a href="https://twitter.com/yourhandle" style="margin: 0 8px;"><img
                        src="https://cdn-icons-png.flaticon.com/24/733/733579.png" alt="Twitter"></a>
                <a href="https://youtube.com/yourchannel" style="margin: 0 8px;"><img
                        src="https://cdn-icons-png.flaticon.com/24/733/733646.png" alt="YouTube"></a>
                <a href="https://instagram.com/yourhandle" style="margin: 0 8px;"><img
                        src="https://cdn-icons-png.flaticon.com/24/733/733558.png" alt="Instagram"></a>
                <a href="https://linkedin.com/company/yourcompany" style="margin: 0 8px;"><img
                        src="https://cdn-icons-png.flaticon.com/24/733/733561.png" alt="LinkedIn"></a>
            </div>

            <!-- Links -->
            <p style="margin: 15px 0;">
                <a href="{{ $helpCenterUrl ?? '#' }}" style="color: #0066c0;">Help Center</a> |
                <a href="{{ $quotationUrl ?? '#' }}" style="color: #0066c0;">Request for Quotation</a> |
                <a href="{{ $faqUrl ?? '#' }}" style="color: #0066c0;">FAQ</a>
            </p>

            <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">

            <p>
                We’re committed to protecting your privacy. Read our
                <a href="{{ $privacyPolicyUrl ?? '#' }}" style="color: #0066c0;">Privacy Policy</a>
                to learn how we handle your data.
            </p>

            <p style="margin-top: 10px;">
                If you no longer wish to receive these emails, you can
                <a href="{{ $unsubscribeUrl ?? '#' }}" style="color: #0066c0; font-weight: bold;">unsubscribe</a>
                at any time.
            </p>

            <p style="font-size: 12px; color: #888; margin-top: 20px;">
                {{ $companyName }} {{ $companyAddress ?? '' }}<br>
                This email was sent from a no-reply address. Please do not reply to this message.
            </p>
        </div>
    </div>
</body>

</html>
