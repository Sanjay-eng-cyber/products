<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\WebPush\WebPushMessage;
use Illuminate\Notifications\Messages\MailMessage;

class OrderStatusUpdatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    // private $order;

    // public function __construct($order)
    // {
    //     $this->order = $order;
    // }

    // public function via($notifiable)
    // {
    //     return ['webpush'];
    // }

    // public function toWebPush($notifiable, $notification)
    // {
    //     return (new WebPushMessage)
    //         ->title('Order Status Updated')
    //         ->icon('/images/order.png')
    //         ->body("Your order (#{$this->order->id}) is now: {$this->order->status}")
    //         ->action('View Order', 'view_order')
    //         ->data(['order_id' => $this->order->id]);
    // }
}
