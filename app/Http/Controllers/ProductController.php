<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        $title = 'Dashboard Product';
        return view('products.index', compact('products', 'title'));
    }

    public function create()
    {
        $title = 'Create Product';
        return view('products.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        Product::create([
            'image' => $imageName,
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->route('products.index')->with('success', 'Product Berhasil Disimpan.');
    }

    // destroy
    public function destroy(Product $product)
    {
        $product->delete();
        if (file_exists(public_path('images/' . $product->image))) {
            unlink(public_path('images/' . $product->image));
        }
        return redirect()->route('products.index')->with('success', 'Product Berhasil Dihapus.');
    }
    // edit
    public function edit(Product $product)
    {
        $title = 'Edit Product';
        return view('products.edit', compact('product', 'title'));
    }
    // update
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            // Store old image name to delete after uploading new one
            $oldImage = $product->image;

            // Upload new image
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $product->image = $imageName;

            // Delete old image if it exists
            if (!empty($oldImage) && file_exists(public_path('images/' . $oldImage))) {
                unlink(public_path('images/' . $oldImage));
            }
        }

        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product Berhasil Diupdate.');
    }

    // show product details
    public function show(Product $product)
    {
        return response()->json($product);
    }
}
