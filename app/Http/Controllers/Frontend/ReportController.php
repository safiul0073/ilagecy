<?php

namespace App\Http\Controllers\Frontend;

use App\Exports\ReportsExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        return view('report.leadRevision');
    }

    public function export(Request $request)
    {
        dd($request);
        $current_timestamp = date('d_m_Y_H_i_s', $_SERVER['REQUEST_TIME']);
        ;
        return Excel::download(new ReportsExport($request), $current_timestamp.'_reports.xlsx');
    }

    public function todaysConfirm()
    {
        return view('report.todaysConfirm');
    }

    public function dailyReports()
    {
        return view('report.dailyReports');
    }
}
