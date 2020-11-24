<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::all();
        return view('products-home', compact('products'));
    }

    public function temp()
    {
        $leads = Lead::all();
        foreach ($leads as $lead) {
            // $phone_last     = substr($lead->phone, -7);
            // $duplicate      = null;
            $duplicate_lead = Lead::query()
                                  ->where('id', '!=', $lead->id)
                                  ->where('customer_id', '=', $lead->customer_id)
                                  ->where('product_id', '=', $lead->product_id)
                                  ->orderBy('created_at', 'ASC')
                                  ->first();

            if ($duplicate_lead) {
                $lead->duplicate_id       = $duplicate_lead->id;
                $lead->save();
            }
        }
    }
}
