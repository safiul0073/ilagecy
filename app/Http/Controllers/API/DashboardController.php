<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function countStatus()
    {
        $product_id = session('product_id');
        if ($product_id) {
            $leads = Lead::select('status_admin', DB::raw('count(*) as total'))
                 ->groupBy('status_admin')
                 ->where('product_id', $product_id)
                 ->get();
        } else {
            $leads = Lead::select('status_admin', DB::raw('count(*) as total'))
                 ->groupBy('status_admin')
                 ->get();
        }
        return $leads;
    }

    public function dateSearch(Request $request)
    {
        $product_id = session('product_id');
        $startDate = date('Y-m-d', strtotime($request['startDate']));
        $endDate = date('Y-m-d', strtotime($request['endDate']));

        if ($product_id) {
            $leads = Lead::select('status_admin', DB::raw('count(*) as total'))
                        ->groupBy('status_admin')
                        ->whereDate('created_at', '>=', $startDate)
                        ->whereDate('created_at', '<=', $endDate)
                        ->where('product_id', $product_id)
                        ->get();
        } else {
            $leads = Lead::select('status_admin', DB::raw('count(*) as total'))
                        ->groupBy('status_admin')
                        ->whereDate('created_at', '>=', $startDate)
                        ->whereDate('created_at', '<=', $endDate)
                        ->get();
        }

        return $leads;
    }
}
