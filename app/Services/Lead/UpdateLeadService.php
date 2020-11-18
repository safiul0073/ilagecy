<?php

namespace App\Services\Lead;

use App\Models\Lead;
use Illuminate\Http\Request;

class UpdateLeadService
{
    public static function run(Request $request)
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
}
