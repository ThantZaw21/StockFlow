<?php

namespace App\Repositories;

use App\Models\StockMovement;

class StockMovementRepository
{
    /**
     * Create a new class instance.
     */ 
        //create a stock movement record
        public function createStockMovement(array $movementData) : StockMovement{
            return StockMovement::create($movementData);
        }

        //get all  stocks movements with their related products
        public function getAllStockMovements(){
            return StockMovement::with('product')
            ->latest()
            ->get();
        }

}
