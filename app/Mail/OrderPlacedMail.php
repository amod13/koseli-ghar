<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlacedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order,$userDetail;

    public function __construct($order,$userDetail)
    {
         $this->order = $order->load('orderItems.product');
        $this->userDetail = $userDetail;
    }

    public function build()
    {
        return $this->subject('Your Order Confirmation')
                    ->view('site.page.emails.order-placed');
    }
}

