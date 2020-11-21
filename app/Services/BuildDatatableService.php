<?php

namespace App\Services;

use App\Models\Lead;
use App\Services\GlobalProductIdService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;

// 01716068965
// 10321496
class BuildDatatableService
{
    public static function make()
    {
        $query = Lead::query();

        $startDate = date('Y-m-d', strtotime(request()->get('from')));
        $endDate = date('Y-m-d', strtotime(request()->get('to')));
        if (request()->get('from') && request()->get('to')) {
            $query->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate);
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

        if (request()->get('role') === 'caller') {
            $query->where('status_caller', '!=', 'confirmed');
        }

        return DataTables::of($query)
                ->editColumn('product_id', function (Lead $lead) {
                    $html  = $lead->product ? $lead->product->name : '';

                    if (!$lead->note) {
                        $html .= '<span class="badge badge-pill badge-danger">new</span>';
                    }
                    if ($lead->duplicate_id) {
                        $html .= '<span class="badge badge-pill badge-danger duplicate_btn" data-customerid="' . $lead->customer_id . '" data-parent="' . $lead->duplicate_id . '" data-toggle="modal" data-target="#duplicateModal">duplicate</span>';
                    }
                    return $html;
                })
                ->editColumn('customer_id', function (Lead $lead) {
                    return $lead->customer ? $lead->customer->name : '';
                })
                ->addColumn('customer_phone', function (Lead $lead) {
                    return $lead->customer ? $lead->customer->phone : '';
                })
                ->addColumn('customer_address', function (Lead $lead) {
                    return $lead->customer ? $lead->customer->address : '';
                })
                ->editColumn('created_at', function (Lead $lead) {
                    return Carbon::parse($lead->created_at);
                })
                ->editColumn('action', function (Lead $lead) {
                    $html = '
                    <a href="javascript;" id="change-status" class="d-block text-center" data-status='. Lead::CONFIRMED .' data-leadId='. $lead->id .'><i class="mdi mdi-check mdi-24px"></i></a>

                    <a href="javascript;" id="change-status" class="d-block text-center" data-status='. Lead::CANCELLED .' data-leadId='. $lead->id .' ><i class="mdi mdi-close mdi-24px"></i></a>

                    <a href="javascript;" id="change-status" class="d-block text-center" data-status='. Lead::HOLD .' data-leadId='. $lead->id .'><i class="mdi mdi-pause mdi-24px"></i></a>

                    <a href="javascript;" id="change-status" class="d-block text-center" data-status='. Lead::TRASH .' data-leadId='. $lead->id .'><i class="mdi mdi-delete mdi-24px"></i></a>

                    <a href="javascript;" class="change-lead d-block text-center" data-toggle="modal" data-target="#modalLeadEdit"  data-leadId="'. $lead->id .'" data-name="'. ($lead->customer ? $lead->customer->name : '') .'" data-phone="'. ($lead->customer ? $lead->customer->phone : '') .'" data-email="'. ($lead->customer ? $lead->customer->email : '') .'" data-address="'. ($lead->customer ? $lead->customer->address : '') .'" data-callerstatus="'. $lead->status_caller .'"><i class="mdi mdi-pencil mdi-24px"></i></a>
                    ';
                    // $html .= '<a href="javascript;" class="btn btn-danger" id="deleteLead"  data-leadid='. $lead->id . '>Delete</a>';
                    return $html;
                })
                ->editColumn('note', function (Lead $lead) {
                    $html = $lead->note . '<br>
                    <a href="javascript;" class="noteButton" data-toggle="modal" data-target="#exampleModal" data-leadid="' . $lead->id  . '" data-note="' . $lead->note  . '"><i class="mdi mdi-plus mdi-24px"></i></a>
                    ';
                    return $html;
                })
                ->editColumn('status_admin', function (Lead $lead) {
                    $html = '<span class="status-color" style="background: '. Lead::COLORS[$lead->status_admin] .'"></span>';
                    return $html;
                })
                ->editColumn('status_caller', function (Lead $lead) {
                    $html = '<span class="status-color" style="background: '. Lead::COLORS[$lead->status_caller] .'"></span>';
                    return $html;
                })
                ->editColumn('postback', function (Lead $lead) {
                    $postback = $lead->send_to_api ?  'btn-success' : 'btn-primary';
                    $html = '
                    <a href="javascript;" class="btn '.  $postback .' postback-confirm" data-leadid="'. $lead->id .'" data-productid="'. $lead->product_id .'" data-supplierid="'. $lead->supplier_id .'" data-orderid="'. $lead->order_id .'">Confirm</a>
                    ';
                    return $html;
                })
                 ->rawColumns(['note','action','postback','status_admin','status_caller','product_id'])
                 ->order(function ($query) {
                     $query->orderBy('id', 'desc');
                 })
                ->make(true);
    }
}
