<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function getUsers()
    {
        $query = User::all();

        return DataTables::of($query)
                ->addColumn('action', function (User $user) {
                    return "
                    <a href='" . route('users.edit', $user->id) . "' class='btn btn-primary'><i class='mdi mdi-pencil'></i></a>
                    <a href='" . route('users.destroy', $user->id) . "' class='btn btn-danger delete-user'><i class='mdi mdi-delete'></i></a>
                    ";
                })
                ->rawColumns(['action'])
                ->make(true);
    }
}
