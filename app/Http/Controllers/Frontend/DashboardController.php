<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Product;
use App\Models\Supplier;
use App\Services\GlobalProductIdService;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    private $product_id;
    public function __construct(GlobalProductIdService $product_id)
    {
        $this->product_id = $product_id;
    }

    public function index()
    {
        if (request()->input('pid') === "0") {
            Storage::put('id.txt', 0);
        } elseif (request()->input('pid') === null) {
            Storage::put('id.txt', $this->product_id->get());
        } else {
            Storage::put('id.txt', intval(request()->input('pid')));
        }

        $products = Product::all();
        $suppliers = Supplier::all();

        return view('dashboard.index', compact('products', 'suppliers'));
    }
}
