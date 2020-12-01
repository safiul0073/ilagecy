<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProduct;
use App\Http\Requests\UpdateProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('product.index');
    }

    public function create()
    {
        return view('product.create');
    }

    public function edit(Product $product)
    {
        return view('product.edit', compact('product', $product));
    }

    public function store(CreateProduct $request)
    {
        Product::create($request->validated());

        return redirect()->route('products.index')->with('success', 'Product is created successfully!');
    }

    public function update(UpdateProduct $request, Product $product)
    {
        $product->update($request->validated());
        return redirect()->route('products.index')->with('success', 'Product is updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
    }
}
