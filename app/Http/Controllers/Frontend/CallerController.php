<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CallerController extends Controller
{
    public function index()
    {
        $callers = User::where('role', User::ROLE_CALLER)->get();
        return view('caller.index', compact('callers'));
    }
}
