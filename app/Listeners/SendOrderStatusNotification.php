<?php

namespace App\Listeners;

use App\Events\OrderStatusUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\OrderStatusUpdatedNotification;

class SendOrderStatusNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    // public function handle(OrderStatusUpdated $event): void
    // {
    //     $event->order->user->notify(new OrderStatusUpdatedNotification($event->order));
    // }
}
