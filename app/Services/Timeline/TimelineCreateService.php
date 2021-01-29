<?php

namespace App\Services\Timeline;

use App\Models\Lead;
use App\Models\Timeline;

class TimelineCreateService
{
    public static function create($leadId, $action)
    {
        Timeline::create([
            'lead_id' =>  $leadId,
            'caller_id' =>  auth()->user()->id,
            'task' =>  auth()->user()->name . ' ' .Timeline::TIMELINE_ACTION[$action],
        ]);

        Lead::find($leadId)->update(['caller_id' => auth()->user()->id]);
    }
}
