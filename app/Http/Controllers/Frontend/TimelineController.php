<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Timeline;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function singleTimeline($lead_id)
    {
        $timelines = Timeline::with(['caller','lead'])->where('lead_id', $lead_id)->orderBy('created_at', 'desc')->get();
        return view('timeline.single', compact('timelines'));
    }
}
