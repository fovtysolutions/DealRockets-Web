@php
    use App\Models\SocialMedia;
    $companyPhone = getWebConfig(name: 'company_phone');
    $companyEmail = getWebConfig(name: 'company_email');
    $companyName = getWebConfig(name: 'company_name');
    $companyLogo = getWebConfig(name: 'company_web_logo');

    $quotationUrl = '/quotation';
    $faqUrl = '/helpTopic';
    $privacyPolicyUrl = '/privacy-policy';
    $unsubscribeUrl = '/unsuscribe';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $subject ?? 'Company Notification' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
        }

        .footer {
            font-size: 12px;
            color: #777;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div style="text-align: center;">
            <img src="{{ getStorageImages(path: $companyLogo, type: 'backend-logo') }}" height="60" alt="Logo">
        </div>

        <div class="content" style="margin-top: 20px;">
            {!! $body ?? 'No message body provided.' !!}
        </div>

        <div class="footer"
            style="background-color:#f7f7f7; padding: 30px; font-family: sans-serif; font-size: 14px; color: #555; text-align: center;">
            <p>{{ translate('best_regards') }},</p>
            <p><img class="mail-img-2" src="{{ getStorageImages(path: $companyLogo, type: 'backend-logo') }}"
                    id="logoViewer" alt="" style="width: 25%;"></p>
            <p><strong>{{ translate('phone') }}:</strong> {{ $companyPhone }}</p>
            <p><strong>{{ translate('Email') }}:</strong> {{ $companyEmail }}</p>

            <div style="margin: 20px 0;">
                <span class="social" style="text-align:center">
                    @php($social_media = SocialMedia::where('active_status', 1)->get())
                    @if ($social_media)
                        @foreach ($social_media as $social)
                            <a href="{{ $social->link }}" target=”_blank” style="margin: 0 5px;text-decoration:none;">
                                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/' . $social->name . '.png') }}"
                                    width="16" alt="">
                            </a>
                        @endforeach
                    @endif
                </span>
            </div>

            <!-- Links -->
            <p style="margin: 15px 0;">
                <a href="{{ $helpCenterUrl ?? '#' }}" style="color: #0066c0;">Marketplace</a> |
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
