<?php
namespace App\Events;

class SendEmailEvent{
    public $to, $subject, $view, $data, $attachments;
    public function __construct($to, $subject, $view, $data = [], $attachments = [])
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->view = $view;
        $this->data = $data;
        $this->attachments = $attachments;
    }
}