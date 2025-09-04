<?php

use App\Models\Order;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Broadcasting\PresenceChannel;


Broadcast::channel('orders.{orderId}', function ($user, $orderId) {
    $order = Order::find($orderId);
    return $order && $order->user_id === $user->id;
});

Broadcast::channel('admin.presence', function ($user) {
    return ['id' => $user->id, 'name' => $user->name, 'role' => $user->role];
});
