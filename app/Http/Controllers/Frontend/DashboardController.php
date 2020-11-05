<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index(int $product_id)
    {
        Storage::put('id.txt', $product_id);
        $products = Product::all();
        $suppliers = Supplier::all();

        return view('dashboard.index', compact('products', 'suppliers'));
    }
}
