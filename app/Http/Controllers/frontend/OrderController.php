<?php

namespace App\Http\Controllers\frontend;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::guard('customer')->user();
        $orders = $user->orders;
        return view('frontend.orders.index', compact('orders'));
    }
    public function store(Request $req)
    {
        $products = Product::pluck('id')->toArray();
        $req->validate([
            'product_id' => ['required', Rule::in($products)]
        ]);

        $order = new Order();
        $order->user_id = Auth::guard('customer')->user()->id;
        $order->product_id = $req->product_id;
        // $order->status = 'Pending';
        if ($order->save()) {
            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Order Placed Successfully']);
        }
        return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Something Went Wrong']);
    }
}
