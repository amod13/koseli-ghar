<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderPlacedNotification extends Notification
{
    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // You can add 'slack', 'sms', etc.
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Order Placed')
            ->greeting('Hello ' . $notifiable->name)
            ->line('A new order has been placed.')
            ->line('Order ID: ' . $this->order->id)
            ->line('Total: NPR ' . number_format($this->order->total_price, 2))
            ->action('View Order', url('/admin/orders/' . $this->order->id))
            ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'amount'   => $this->order->total_price,
            'message'  => 'A new order has been placed.',
        ];
    }
}

