<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Services\BuildDatatableService;
use App\Services\Lead\UpdateLeadService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;

class LeadController extends Controller
{
    public function getLeads()
    {
        return BuildDatatableService::make();
    }

    public function changeStatus()
    {
        $lead = Lead::find(request()->input('leadId'))->update([
            'status_admin' => request()->input('status')
        ]);
        return $lead;
    }

    public function changeNote(Request $request)
    {
        $lead = Lead::find($request->leadId)->update([
            'note' => $request->currentNote
        ]);
        return $lead;
    }

    public function update(Request $request)
    {
        $lead = UpdateLeadService::run($request);
        return $lead;
    }

    public function destroy(Request $request)
    {
        $lead = Lead::find($request->leadId)->delete();
        return $lead;
    }

    public function getLeadDuplicate()
    {
        $query = Lead::where('duplicate_id', request()->get('duplicateLeadId'))
                        ->where('customer_id', request()->get('customerId'));


        return DataTables::of($query)
                ->editColumn('product_id', function (Lead $lead) {
                    return $lead->product ? $lead->product->name : '';
                })
                ->addColumn('phone', function (Lead $lead) {
                    return $lead->customer ? $lead->customer->phone : '';
                })
                ->editColumn('status_admin', function (Lead $lead) {
                    $html = '<span class="status-color" style="background: '. Lead::COLORS[$lead->status_admin] .'"></span>';
                    return $html;
                })
                ->editColumn('created_at', function (Lead $lead) {
                    return Carbon::parse($lead->created_at);
                })
                ->editColumn('status_caller', function (Lead $lead) {
                    $html = '<span class="status-color" style="background: '. Lead::COLORS[$lead->status_caller] .'"></span>';
                    return $html;
                })
                ->rawColumns(['status_admin','status_caller'])
                ->order(function ($query) {
                    $query->orderBy('id', 'desc');
                })
                ->make(true);
    }


    public function postbackEndpoint(Request $request)
    {
        // $response = Http::get('http://127.0.0.1:8000/leads/sudo-postback', [
        // 'product_id' => $request['data']['productid'],
        // 'supplier_id' => $request['data']['supplierid'],
        // 'order_id' => $request['data']['orderid']
        // ]);

        $response = Http::get('https://api.github.com/users/princerafid01');

        $lead = Lead::find($request['data']['leadid'])->update([
            'send_to_api' =>  $response->json()['node_id']
        ]);

        return $lead;
    }
}
