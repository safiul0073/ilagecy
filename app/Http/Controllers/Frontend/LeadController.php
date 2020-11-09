<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class LeadController extends Controller
{
    public function index()
    {
        return view('lead.index');
    }
}
