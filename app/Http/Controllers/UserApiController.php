<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserApiController extends Controller
{
    function getUsers() {
        $users = User::select(
            'id',
            'name',
            'email',
            'password',
            'role'
            )->get();

        // add phone number
        foreach ($users as $user) {
            $user->phone = "".rand(10000000000, 99999999999);
        }


        return response()->json($users);
    }

    function getProducts() {

        $products = Product::select(
            'id',
            'name',
        )->get();

        return response()->json($products);
    }

    function getSuppliers() {

        $suppliers = Supplier::select(
            'id',
            'name',
            'email',
            'phone',
            'address',
            'api',
        )->get();

        return response()->json($suppliers);

    }

    function  getLeads () {

        $lead = DB::table('leads')
            ->join('customers', 'leads.customer_id', '=', 'customers.id')
            ->select(
                'leads.product_id as productId',
                'leads.supplier_id as supplierId',
                'leads.note',
                'leads.order_id as orderId',
                'leads.publisher_id as publisherId',
                DB::raw('(CASE
                        WHEN leads.status = "1" THEN "active"
                        ELSE "inactive"
                        END) AS status'),
                'leads.country_code as countryCode',
                DB::raw('(CAST(leads.duplicate_id AS CHAR)) AS duplicates'),
                'customers.name as customerName',
                'customers.email as email',
                'customers.phone as phone',
                'customers.address as address',
            )->skip(40000)->take(10000)->get();

        return response()->json($lead);

            }


}
