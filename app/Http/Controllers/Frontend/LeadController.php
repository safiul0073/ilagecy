<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;
use App\Services\GlobalProductIdService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LeadController extends Controller
{
    private $product_id;
    public function __construct(GlobalProductIdService $product_id)
    {
        $this->product_id = $product_id;
    }

    public function getLeads()
    {
        $query = Lead::query();
        if ($this->product_id->get()) {
            $query->where('product_id', $this->product_id->get());
        }
        return DataTables::of($query)
                ->editColumn('product_id', function (Lead $lead) {
                    return $lead->product->name;
                })
                ->editColumn('supplier_id', function (Lead $lead) {
                    return $lead->supplier->name;
                })
                ->editColumn('customer_id', function (Lead $lead) {
                    return $lead->customer->name;
                })
                ->addColumn('customer_phone', function (Lead $lead) {
                    return $lead->customer->phone;
                })
                ->addColumn('customer_address', function (Lead $lead) {
                    return $lead->customer->address;
                })
                ->editColumn('created_at', function (Lead $lead) {
                    return Carbon::parse($lead->created_at);
                })
                ->make(true);
    }
    public function index()
    {
        return view('lead.index');
    }
}
