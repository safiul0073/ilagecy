<?php

namespace App\Http\Controllers\Frontend;

use App\Exports\LeadsExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LeadController extends Controller
{
    public function index()
    {
        return view('lead.index');
    }

    public function export(Request $request)
    {
        return Excel::download(new LeadsExport($request), 'leads.xlsx');
    }
}
