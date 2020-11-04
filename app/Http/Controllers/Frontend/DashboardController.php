<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(int $product_id)
    {
        session(['product_id' => $product_id]);

        return view('dashboard.index');
    }
}
