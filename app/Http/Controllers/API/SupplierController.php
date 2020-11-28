<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    public function getSuppliers()
    {
        $query = Supplier::all();

        return DataTables::of($query)
                ->addColumn('action', function (Supplier $supplier) {
                    return "
                    <a href='" . route('suppliers.edit', $supplier->id) . "' class='btn btn-primary'><i class='mdi mdi-pencil'></i></a>
                    <a href='" . route('suppliers.destroy', $supplier->id) . "' class='btn btn-danger delete-supplier'><i class='mdi mdi-delete'></i></a>
                    ";
                })
                ->rawColumns(['action'])
                ->make(true);
    }
}
