<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Services\GlobalProductIdService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
                ->editColumn('action', function (Lead $lead) {
                    $html = '
                    <a href="javascript;" id="change-status" data-status='. Lead::CONFIRMED .' data-leadId='. $lead->id .'><i class="mdi mdi-check mdi-36px"></i></a>

                    <a href="javascript;" id="change-status" data-status='. Lead::CANCELLED .' data-leadId='. $lead->id .' ><i class="mdi mdi-close mdi-36px"></i></a>

                    <a href="javascript;" id="change-status" data-status='. Lead::HOLD .' data-leadId='. $lead->id .'><i class="mdi mdi-pause mdi-36px"></i></a>

                    <a href="javascript;" id="change-status" data-status='. Lead::TRASH .' data-leadId='. $lead->id .'><i class="mdi mdi-delete mdi-36px"></i></a>

                    <a href="javascript;" class="change-lead" data-toggle="modal" data-target="#modalLeadEdit"  data-leadId="'. $lead->id .'" data-name="'. $lead->customer->name .'" data-phone="'. $lead->customer->phone .'" data-email="'. $lead->customer->email .'" data-address="'. $lead->customer->address .'" data-callerstatus="'. $lead->status_caller .'"><i class="mdi mdi-pencil mdi-36px"></i></a>

                    <a href="javascript;" class="btn btn-danger" id="deleteLead"  data-leadid='. $lead->id . '>Delete</a>
                    ';
                    return $html;
                })
                ->editColumn('note', function (Lead $lead) {
                    $html = $lead->note . '<br>
                    <a href="javascript;" class="btn btn-primary noteButton" data-toggle="modal" data-target="#exampleModal" data-leadid="' . $lead->id  . '" data-note="' . $lead->note  . '"><i class="mdi mdi-plus"></i></a>

                    ';
                    return $html;
                })
                ->editColumn('postback', function (Lead $lead) {
                    $postback = $lead->send_to_api ?  'btn-success' : 'btn-primary';
                    $html = '
                    <a href="javascript;" class="btn '.  $postback .' postback-confirm" data-leadid="'. $lead->id .'" data-productid="'. $lead->product_id .'" data-supplierid="'. $lead->supplier_id .'" data-orderid="'. $lead->order_id .'">Confirm</a>
                    ';
                    return $html;
                })
                 ->rawColumns(['note','action','postback'])
                ->make(true);
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
        $lead = Lead::find($request['data']['lead_id'])->customer->update([
            'name' => $request['data']['name'],
            'phone' => $request['data']['phone'],
            'email' => $request['data']['email'],
            'address' => $request['data']['address'],
        ]);

        Lead::find($request['data']['lead_id'])->update(['status_caller' => $request['data']['callerstatus']]);
        return $lead;
    }

    public function destroy(Request $request)
    {
        $lead = Lead::find($request->leadId)->delete();
        return $lead;
    }


    public function postbackEndpoint(Request $request)
    {
        // $response = Http::get('http://127.0.0.1:8000/leads/sudo-postback', [
        //     'product_id' => $request['data']['productid'],
        //     'supplier_id' => $request['data']['supplierid'],
        //     'order_id' => $request['data']['orderid']
        // ]);

        $response = Http::get('https://api.github.com/users/princerafid01');

        $lead = Lead::find($request['data']['leadid'])->update([
            'send_to_api' =>  $response->json()['node_id']
        ]);

        return $lead;
    }
}
