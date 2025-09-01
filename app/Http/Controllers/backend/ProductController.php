<?php

namespace App\Http\Controllers\backend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use Illuminate\Support\Optional;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('backend.products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('backend.products.show', compact('product'));
    }

    public function create()
    {
        return view('backend.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:60|string',
            'category' => 'required|string',
            'price' => 'required|numeric|regex:/^\d{1,7}(\.\d{1,2})?$/',
            'stock' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:1028',
            'description' => 'required|string|min:3|max:20000',
        ]);

        $product = new product();
        // dd($fileWithExtension);
        if ($request->hasFile('image')) {
            $fileWithExtension = $request->file('image');
            $filename = now()->format('dmy-his') . '-' . rand(1, 99) . '.' . $fileWithExtension->clientExtension();
            $destinationPath = storage_path('app/public/images/products/');
            $manager = ImageManager::gd();
            $img = $manager->read($fileWithExtension->getRealPath())->scale(600);
            $img->orient();
            $img->save($destinationPath . $filename, 85);
            $product->image = $filename;
        }
        $product->name = $request->name;
        $product->category = $request->category;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->description = $request->description;
        if ($product->save()) {
            return redirect()->route('backend.product.index')->with(['alert-type' => 'success', 'message' => 'Product Created Successfully']);
        }
        return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Something Went Wrong']);
    }

    public function edit($id)
    {
        $product = product::findOrFail($id);
        return view('backend.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3|max:60|string',
            'category' => 'required|string',
            'price' => 'required|numeric|regex:/^\d{1,7}(\.\d{1,2})?$/',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:1028',
            'description' => 'required|string|min:3|max:20000',
        ]);

        $product = Product::findOrFail($id);
        // dd($fileWithExtension);
        if ($request->hasFile('image')) {
            if (!Storage::exists('images/products/' . $product->image)) {
                Storage::disk('public')->delete('images/products/' . $product->image);
            }
            $fileWithExtension = $request->file('image');
            $filename = now()->format('dmy-his') . '-' . rand(1, 99) . '.' . $fileWithExtension->clientExtension();
            $destinationPath = storage_path('app/public/images/products/');
            $manager = ImageManager::gd();
            $img = $manager->read($fileWithExtension->getRealPath())->scale(600);
            $img->orient();
            $img->save($destinationPath . $filename, 85);
            $product->image = $filename;
        }
        $product->name = $request->name;
        $product->category = $request->category;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->description = $request->description;
        if ($product->save()) {
            return redirect()->route('backend.product.index')->with(['alert-type' => 'success', 'message' => 'Product Updated Successfully']);
        }
        return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Something Went Wrong']);
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        Optional(Storage::disk('public')->delete('images/products/' . $product->image));
        if ($product->delete()) {
            return redirect()->route('backend.product.index')->with(['alert-type' => 'success', 'message' => 'Product Deleted Successfully']);
        }
        return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Something Went Wrong']);
    }

    public function importShow()
    {
        return view('backend.products.importCsv');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,txt',
        ]);

        Excel::import(new ProductsImport, $request->file('file'));

        return back()->with('success', 'Products imported successfully!');
    }
}
