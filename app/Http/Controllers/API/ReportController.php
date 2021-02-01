<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Services\GlobalProductIdService;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function getReports()
    {
        $query = Lead::query();

        $startDate = date('Y-m-d', strtotime(request()->get('from')));
        $endDate = date('Y-m-d', strtotime(request()->get('to')));
        if (request()->get('from') && request()->get('to')) {
            $query->whereDate('updated_at', '>=', $startDate)
                    ->whereDate('updated_at', '<=', $endDate);
        }

        $status = request()->get('status');
        if (request()->get('status')) {
            $query->where('status_caller', $status);
        }

        if (request()->get('phone')) {
            $query->whereHas('customer', function ($customer) {
                $customer->where('phone', 'like', '%' . request()->get('phone') . '%');
            });
        }

        if (request()->get('orderId')) {
            $query->where('order_id', 'like', '%' . request()->get('orderId') . '%');
        }

        if (GlobalProductIdService::get()) {
            $query->where('product_id', GlobalProductIdService::get());
        }

        if (request()->get('confirm')) {
            $query->where('status_caller', Lead::CONFIRMED);
        }

        $query->where('caller_id', '!=', 0);


        return DataTables::of($query)
        // ->addColumn('customer_phone', function (Lead $lead) {
            // return $lead->customer ? $lead->customer->phone : '';
        // })
        ->editColumn('customer_id', function (Lead $lead) {
            return $lead->customer ? $lead->customer->name : '';
        })
        ->editColumn('product_id', function (Lead $lead) {
            return $lead->product ? $lead->product->name : '';
        })
        ->editColumn('caller_id', function (Lead $lead) {
            return $lead->caller ? $lead->caller->name : '';
        })
        ->editColumn('updated_at', function (Lead $lead) {
            return Carbon::parse($lead->updated_at);
        })
        ->addColumn('action', function (Lead $lead) {
            $html = '
            <a href="'. route('single.timeline.view', $lead->id) .'"  class="btn btn-primary text-center"> Lead\'s History</a>
            ';
            return $html;
        })
        ->rawColumns(['action'])
        ->make(true);
    }


    public function getReportsCustom()
    {
        $query = Lead::query();

        $startDate = date('Y-m-d', strtotime(request()->get('from')));
        $endDate = date('Y-m-d', strtotime(request()->get('to')));
        if (request()->get('from') && request()->get('to')) {
            $query->whereDate('updated_at', '>=', $startDate)
                    ->whereDate('updated_at', '<=', $endDate);
        }

        $status = request()->get('status');
        if (request()->get('status')) {
            $query->where('status_caller', $status);
        }

        if (request()->get('phone')) {
            $query->whereHas('customer', function ($customer) {
                $customer->where('phone', 'like', '%' . request()->get('phone') . '%');
            });
        }

        if (request()->get('orderId')) {
            $query->where('order_id', 'like', '%' . request()->get('orderId') . '%');
        }

        if (GlobalProductIdService::get()) {
            $query->where('product_id', GlobalProductIdService::get());
        }



        $query->where('caller_id', '!=', 0);

        return DataTables::of($query)
        // ->addColumn('customer_phone', function (Lead $lead) {
            // return $lead->customer ? $lead->customer->phone : '';
        // })
        ->editColumn('customer_id', function (Lead $lead) {
            return $lead->customer ? $lead->customer->name : '';
        })
        ->editColumn('product_id', function (Lead $lead) {
            return $lead->product ? $lead->product->name : '';
        })
        ->editColumn('caller_id', function (Lead $lead) {
            return $lead->caller ? $lead->caller->name : '';
        })
        ->editColumn('updated_at', function (Lead $lead) {
            return Carbon::parse($lead->updated_at);
        })
        ->editColumn('status_caller', function (Lead $lead) {
            $html = '<span class="status-color" style="background: '. Lead::COLORS[$lead->status_caller] .'"></span>';
            return $html;
        })
        ->rawColumns(['status_caller'])
        ->make(true);
    }
}
