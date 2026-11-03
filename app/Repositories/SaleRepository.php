<?php

namespace App\Repositories;

use App\Models\Sale;
use App\Models\SaleItem;

class SaleRepository
{
    public function createSale(array $saleData): Sale{
        return Sale::create($saleData);
    }

    public function getAllSales(){
        return Sale::latest()->get();
    }

    public function createSaleItems(array $saleItems):void{
        foreach($saleItems as $item){
            SaleItem::create($item);
        }
    }
}