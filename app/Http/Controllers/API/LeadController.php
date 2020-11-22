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
        if (request()->input('role') === 'admin') {
            $lead = Lead::find(request()->input('leadId'))->update([
                'status_admin' => request()->input('status')
            ]);
        }

        if (request()->input('role') === 'caller') {
            $lead = Lead::find(request()->input('leadId'))->update([
                'status_caller' => request()->input('status')
            ]);
        }
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
        switch ($request['data']['adminstatus']) {
            case 'confirmed':
                $status = 'confirm';
                break;

            case 'cancelled':
                $status = 'reject';
                break;

            case 'hold':
                $status = 'expect';
                break;

            default:
                $status = 'trash';
                break;
        }


        $supplier_request_token = "bf9c857cbb89f733796e4758fe817462";

        $content = json_encode([
            "user_id" => "18302",
            "data"    => [
                "id"      => $request['data']['orderid'],
                "status"  => $status,
                "comment" => $request['data']['note']
            ]
        ]);

        $url = "http://tl-api.com/api/lead/update?check_sum=" . sha1($content . $supplier_request_token);
        /**
         * Used Old Code
         */
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array( "Content-type: application/json" )
        );
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

        $json_response = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($status != 200 || $status != 201) {
            $json_response = "Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl);
        }

        curl_close($curl);

        $response = json_decode($json_response, true);


        // $response = Http::get('http://tl-api.com/api/lead/update?check_sum=' . sha1($content . $supplier_request_token));

        $lead = Lead::find($request['data']['leadid'])->update([
            'send_to_api' =>  $json_response
        ]);

        return $lead;
    }
}
