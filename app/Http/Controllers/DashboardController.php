<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();

        $inventoryValue = Product::selectRaw(
            'SUM(purchase_price * quantity) as total'
        )->value('total') ?? 0;

        $totalSales = Sale::count();

        $lowStockItems = Product::whereColumn(
            'quantity',
            '<=',
            'reorder_level'
        )->count();

        return view('dashboard', compact(
            'totalProducts',
            'inventoryValue',
            'totalSales',
            'lowStockItems'
        ));
    }
}