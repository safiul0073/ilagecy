<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Services\BuildDatatableService;
use App\Services\Lead\UpdateLeadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
