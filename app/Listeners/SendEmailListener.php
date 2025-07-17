<?php
namespace App\Listeners;

use App\Events\SendEmailEvent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendEmailListener
{
    public function handle(SendEmailEvent $event)
    {
        try {
            Mail::send($event->view, $event->data, function ($message) use ($event) {
                $message->to($event->to)
                    ->bcc(['emails@dealrockets.com'])
                    ->subject($event->subject);
                foreach ($event->attachments as $filePath) {
                    $message->attach($filePath);
                }
            });
            // Optionally log success
        } catch (\Throwable $th) {
            Log::error('Mail send failed', [
                'to' => $event->to,
                'subject' => $event->subject,
                'view' => $event->view,
                'error' => $th->getMessage(),
            ]);
        }
    }
}