<?php

namespace App\Notifications;

use Log;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class OrderStatusUpdatedNotification extends Notification
{

    /**
     * Create a new notification instance.
     */
    private $order;

    public function __construct($order)
    {
        $this->order = $order;
        // dd($this->order);
    }
    public function via($notifiable)
    {
        return ['broadcast', WebPushChannel::class];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'order_id' => $this->order->id,
            'status'   => $this->order->status,
            'message'  => "from notifiaction Your order of (#{$this->order->product->name}) is now: {$this->order->status}",
        ]);
    }

    public function broadcastType()
    {
        return 'OrderStatusUpdated';
    }

    public function toWebPush($notifiable, $notification)
    {

        return (new WebPushMessage)
            ->title('Order Status Updated 🚚')
            ->icon('/images/order.png')
            ->body("Your order of ({$this->order->product->name}) is now: {$this->order->status}")
            ->action('View Order', 'view_order')
            ->data([
                'order_id' => $this->order->id,
                'status'   => $this->order->status,
            ]);
    }
}
