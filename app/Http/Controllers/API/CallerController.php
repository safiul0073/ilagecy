<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Services\GlobalProductIdService;
use App\Services\Lead\LeadStatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CallerController extends Controller
{
    public function filterSearch(Request $request)
    {
        return LeadStatService::get($request, 'update_caller');
    }

    public function countStatus()
    {
        if (GlobalProductIdService::get()) {
            $leads = Lead::select('status_admin', DB::raw('count(*) as total'))
                 ->groupBy('status_admin')
                 ->where('product_id', GlobalProductIdService::get())
                 ->get();
        } else {
            $leads = Lead::select('status_admin', DB::raw('count(*) as total'))
                 ->groupBy('status_admin')
                 ->get();
        }
        return $leads;
    }
}
