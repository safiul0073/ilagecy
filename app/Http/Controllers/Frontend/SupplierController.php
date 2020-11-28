<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSupplier;
use App\Http\Requests\UpdateSupplier;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        return view('supplier.index');
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier', $supplier));
    }

    public function store(CreateSupplier $request)
    {
        Supplier::create($request->validated());

        return redirect()->route('suppliers.index')->with('success', 'Supplier is created successfully!');
    }

    public function update(UpdateSupplier $request, Supplier $supplier)
    {
        $supplier->update($request->validated());
        return redirect()->route('suppliers.index')->with('success', 'Supplier is updated successfully!');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
    }
}
