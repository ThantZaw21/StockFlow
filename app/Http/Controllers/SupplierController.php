<?php
namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Services\SupplierService;
use Illuminate\Http\Request;

class SupplierController
{
    public function __construct(
        private SupplierService $supplierService
    ) {
    }

    public function getAllSuppliers()
    {
        $suppliers = $this->supplierService->getAllSuppliers();

        return view('suppliers.index', compact('suppliers'));
    }

    public function showCreateSupplierForm()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $supplierData = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $this->supplierService->createSupplier($supplierData);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier created successfully');
    }

    public function showEditSupplierForm(int $supplierId){
        $supplier = $this->supplierService->getSupplierById($supplierId);

        if(!$supplier){
            abort(404);
        }

        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, int $supplierId)
    {
        $supplierData = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $this->supplierService->updateSupplier($supplierId, $supplierData);

        return redirect()
        ->route('suppliers.index')
        ->with('success', 'Supplier updated successfully');
    }

    public function delete(int $supplierId){
        $this->supplierService->deleteSupplier($supplierId);

        return redirect()
        ->route('suppliers.index')
        ->with('success', 'Supplier deleted successfully');
    }
}