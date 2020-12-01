<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function getProducts()
    {
        $query = Product::all();

        return DataTables::of($query)
                ->addColumn('action', function (Product $product) {
                    return "
                    <a href='" . route('products.edit', $product->id) . "' class='btn btn-primary'><i class='mdi mdi-pencil'></i></a>
                    <a href='" . route('products.destroy', $product->id) . "' class='btn btn-danger delete-product'><i class='mdi mdi-delete'></i></a>
                    ";
                })
                ->rawColumns(['action'])
                ->make(true);
    }
}
