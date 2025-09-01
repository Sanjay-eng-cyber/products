<?php

namespace App\Http\Controllers\frontend;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::latest();
        $products = $this->filterResults($request, $products);
        $products = $products->paginate(10);
        $user = Auth::guard('customer')->user();
        $orderArray = $user->orders->pluck('product_id')->toArray();
        return view('frontend.index', compact('products', 'orderArray'));
    }

    protected function filterResults($request, $products)
    {
        if ($request !== null && $request->has('q') && $request['q'] !== '') {
            $search = $request['q'];
            $products = $products->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%');
            });
        }
        if ($request !== null && $request->has('min_price') && $request->min_price != '' && $request->has('max_price') && $request->max_price != '') {
            $products = $products->whereBetween('price', [$request->min_price, $request->max_price]);
        }
        if ($request !== null && $request->has('min_price') && $request->min_price != '') {
            $products = $products->where('price', '>=', $request->min_price);
        }
        if ($request !== null && $request->has('max_price') && $request->max_price != '') {
            $products = $products->where('price', '<=', $request->max_price);
        }
        return $products;
    }
}
