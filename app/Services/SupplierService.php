<?php
namespace App\Services;

use App\Models\Supplier;
use App\Repositories\SupplierRepository;

class SupplierService{
    public function __construct(
        private SupplierRepository $supplierRepository
    ){}

    public function getAllSuppliers(){
        return $this->supplierRepository->getAllSuppliers();
    }

    public function createSupplier(array $supplierData){
        return $this->supplierRepository->createSupplier($supplierData);
    }

    public function getSupplierById(int $supplierId):?Supplier{
        return $this->supplierRepository->getSupplierById($supplierId);
    }

    public function updateSupplier(int $supplierId, array $supplierData): void{
        $this->supplierRepository->updateSupplier($supplierId, $supplierData);
    }

    public function deleteSupplier(int $supplierId){
        $this->supplierRepository->deleteSupplier($supplierId);
    }
}
