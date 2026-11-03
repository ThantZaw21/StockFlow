<?php

namespace App\Repositories;

use App\Models\Purchase;
use App\Models\PurchaseItem;

class PurchaseRepository
{
    /**
     * Create a new class instance.
     */
    public function createPurchase(array $purchaseItems): Purchase{
        return Purchase::create($purchaseItems);
    }
    
    public function createPurchaseItems(array $purchasedItems):void{
        foreach($purchasedItems as $item){
            PurchaseItem::create($item);
        }
    }

    public function getAllPurchases(){
        return Purchase::with('supplier')
        ->latest()
        ->get();
    }

    public function getPurchaseById(int $purchaseId): ?Purchase{
        return Purchase::with(['supplier', 'items.product'])
        ->find($purchaseId);
    }
}
