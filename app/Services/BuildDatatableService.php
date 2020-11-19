<?php

namespace App\Services;

use App\Models\Lead;
use App\Services\GlobalProductIdService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;

// 01716068965
// 10321496
class BuildDatatableService
{
    private static $product_id;
    public function __construct(GlobalProductIdService $product_id)
    {
        self::$product_id = $product_id->get();
    }

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
            $query->where('status_admin', $status);
        }

        if (request()->get('phone')) {
            $query->whereHas('customer', function ($customer) {
                $customer->where('phone', 'like', '%' . request()->get('phone') . '%');
            });
        }

        if (request()->get('orderId')) {
            $query->where('order_id', request()->get('orderId'));
        }

        if (self::$product_id) {
            $query->where('product_id', self::$product_id);
        }
        return DataTables::of($query)
                ->editColumn('product_id', function (Lead $lead) {
                    return $lead->product ? $lead->product->name : '';
                })
                ->editColumn('supplier_id', function (Lead $lead) {
                    return $lead->supplier ? $lead->supplier->name : '';
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
                 ->rawColumns(['note','action','postback','status_admin','status_caller'])
                ->make(true);
    }
}
