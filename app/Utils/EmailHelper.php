<?php

namespace App\Utils;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailHelper
{
    public static function send($to, $subject, $view, $data = [], $attachments = [])
    {
        $emailServices_smtp = getWebConfig(name: 'mail_config');
        if ($emailServices_smtp['status'] == 0) {
            $emailServices_smtp = getWebConfig(name: 'mail_config_sendgrid');
        }

        if ($emailServices_smtp['status'] != 1) {
            Log::warning('Email not sent: SMTP is not active', [
                'to' => $to,
                'subject' => $subject,
                'view' => $view,
            ]);

            return [
                'success' => false,
                'message' => 'SMTP is not active.',
            ];
        }

        try {
            Mail::send($view, $data, function ($message) use ($to, $subject, $attachments) {
                $message->to($to)
                ->bcc(['emails@dealrockets.com'])
                ->subject($subject);
                foreach ($attachments as $filePath) {
                    $message->attach($filePath);
                }
            });

            return ['success' => true];
        } catch (\Throwable $th) {
            Log::error('Mail send failed', [
                'to' => $to,
                'subject' => $subject,
                'view' => $view,
                'error' => $th->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => $th->getMessage(),
            ];
        }
    }

    public static function sendWelcomeMail($user)
    {
        $subject = 'Welcome to ' . (getWebConfig('company_name')['value'] ?? 'our platform');
        $body = view('emails.partials.welcome-message', ['user' => $user])->render();

        return self::send($user->email, $subject, 'emails.base-template', [
            'subject' => $subject,
            'body' => $body,
        ]);;
    }

    public static function sendProductCreatedMail($vendor, $product)
    {
        $subject = 'Your product has been submitted';
        $body = view('emails.partials.product-created', compact('vendor', 'product'))->render();

        return self::send($vendor->email, $subject, 'emails.base-template', compact('subject', 'body'));
    }

    public static function sendProductApprovedMail($vendor, $product)
    {
        $subject = 'Your product has been approved!';
        $body = view('emails.partials.product-approved', compact('vendor', 'product'))->render();

        return self::send($vendor->email, $subject, 'emails.base-template', compact('subject', 'body'));
    }

    public static function sendStockSellCreatedMail($vendor, $stock)
    {
        $subject = 'Your stock sell listing is created';
        $body = view('emails.partials.stock-created', compact('vendor', 'stock'))->render();

        return self::send($vendor->email, $subject, 'emails.base-template', compact('subject', 'body'));
    }

    public static function sendStockSellApprovedMail($vendor, $stock)
    {
        $subject = 'Your stock sell listing is approved!';
        $body = view('emails.partials.stock-approved', compact('vendor', 'stock'))->render();

        return self::send($vendor->email, $subject, 'emails.base-template', compact('subject', 'body'));
    }

    public static function sendBuyLeadCreatedMail($user, $lead)
    {
        $subject = 'Your buy lead has been created';
        $body = view('emails.partials.buy-lead-created', compact('user', 'lead'))->render();

        return self::send($user->email, $subject, 'emails.base-template', compact('subject', 'body'));
    }

    public static function sendBuyLeadApprovedMail($user, $lead)
    {
        $subject = 'Your buy lead has been approved!';
        $body = view('emails.partials.buy-lead-approved', compact('user', 'lead'))->render();

        return self::send($user->email, $subject, 'emails.base-template', compact('subject', 'body'));
    }

    public static function sendSaleOfferCreatedMail($user, $lead)
    {
        $subject = 'Your sale offer has been created';
        $body = view('emails.partials.sale-offer-created', compact('user', 'lead'))->render();

        return self::send($user->email, $subject, 'emails.base-template', compact('subject', 'body'));
    }

    public static function sendSaleOfferApprovedMail($user, $lead)
    {
        $subject = 'Your sale offer has been approved!';
        $body = view('emails.partials.sale-offer-approved', compact('user', 'lead'))->render();

        return self::send($user->email, $subject, 'emails.base-template', compact('subject', 'body'));
    }

    public static function sendRFQToBuyLeadMail($vendor, $rfq)
    {
        $subject = 'An RFQ has been converted to a Buy Lead';
        $body = view('emails.partials.rfq-conversion', compact('vendor', 'rfq'))->render();

        return self::send($vendor->email, $subject, 'emails.base-template', compact('subject', 'body'));
    }

    public static function sendInquiryMail($vendor, $inquiry)
    {
        $subject = 'You have a new inquiry';
        $body = view('emails.partials.inquiry', compact('vendor', 'inquiry'))->render();

        return self::send($vendor->email, $subject, 'emails.base-template', compact('subject', 'body'));
    }

    public static function sendSaleOfferInquiryMail($buyer, $offer)
    {
        $subject = 'A buyer inquired about your sale offer';
        $body = view('emails.partials.sale-offer-inquiry', compact('buyer', 'offer'))->render();

        return self::send($buyer->email, $subject, 'emails.base-template', compact('subject', 'body'));
    }

    public static function sendBuyLeadInquiryMail($buyer, $lead)
    {
        $subject = 'A Buyer Inquired About your Buy Lead';
        $body = view('emails.partials.buy-lead-inquiry', compact('buyer', 'lead'))->render();

        return self::send($buyer->email, $subject, 'emails.base-template', compact('subject', 'body'));
    }

    public static function sendStockSellInquiryMail($buyer,$lead)
    {
        $subject = 'A Buyer Inquired About your Stock Sale';
        $body = view('emails.partials.stock-inquiry', compact('buyer', 'lead'))->render();

        return self::send($buyer->email, $subject, 'emails.base-template', compact('subject', 'body'));
    }
}
