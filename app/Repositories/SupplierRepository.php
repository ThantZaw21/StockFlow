<?php
namespace App\Repositories;
use App\Models\Supplier;
class SupplierRepository{
    public function getAllSuppliers(){
        return Supplier::all();
    }

    public function createSupplier(array $supplierData): ?Supplier{
        return Supplier::create($supplierData);
    }

    public function getSupplierById(int $supplierId): ?Supplier{
        return Supplier::find($supplierId);
    }

    public function updateSupplier(int $supplierId, array $supplierData): void{
        $supplier = Supplier::findOrFail($supplierId);

        $supplier->update($supplierData);
    }

    public function deleteSupplier(int $supplierId):void{
        $supplier = Supplier::findOrFail($supplierId);

        $supplier->delete();
    }
}