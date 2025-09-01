<?php

namespace App\Http\Controllers\backend;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Events\OrderStatusUpdated;
use App\Http\Controllers\Controller;
use App\Notifications\OrderStatusUpdatedNotification;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->paginate(10);
        return view('backend.orders.index', compact('orders'));
    }

    public function orderStatusUpdate(Request $req)
    {
        $orders = Order::pluck('id')->toArray();
        $req->validate([
            'order_id' => ['required', Rule::in($orders)]
        ]);

        $order = Order::findOrFail($req->order_id);
        $order->status = $req->status;
        if ($order->save()) {
            // $order->user->notify(new OrderStatusUpdatedNotification($order));
            broadcast(new OrderStatusUpdated($order))->toOthers();
            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Order Status Updated Successfully']);
        }
        return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Something Went Wrong']);
    }
}
