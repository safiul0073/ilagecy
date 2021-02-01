<?php

namespace App\Services\Lead;

use App\Models\Lead;
use App\Services\GlobalProductIdService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LeadStatService
{
    public static function get(Request $request, $date_column)
    {
        $leads = Lead::select('status_caller', DB::raw('count(*) as total'))
                 ->groupBy('status_caller');

        $startDate = date('Y-m-d', strtotime($request['startDate']));
        $endDate = date('Y-m-d', strtotime($request['endDate']));

        if (!$request['productFilter'] && GlobalProductIdService::get()) {
            $leads->where('product_id', GlobalProductIdService::get());
        }

        if ($request['startDate'] && $request['endDate']) {
            $leads->whereDate($date_column, '>=', $startDate)
                    ->whereDate($date_column, '<=', $endDate);
        }

        if ($request['productFilter']) {
            $leads->where('product_id', $request['productFilter']);
        }

        if ($request['supplierFilter']) {
            $leads->where('supplier_id', $request['supplierFilter']);
        }

        if ($request['callerFilter']) {
            $leads->where('caller_id', $request['callerFilter']);
        }

        return $leads->get();
    }
}
