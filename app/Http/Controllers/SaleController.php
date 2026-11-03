<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\SaleService;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    //
    public function __construct(
        private SaleService $saleService
    ) {
    }

    public function showCreateSaleForm()
    {
        $products = Product::where('is_active', true)
            ->where('quantity', '>', 0)
            ->orderBy('name')
            ->get();

        $productsForJs = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'price' => (float) $product->selling_price,
                'quantity' => $product->quantity,
            ];
        })->values();

        return view('sales.create', compact('products', 'productsForJs'));
    }

    public function createSale(Request $request)
    {
        $validatedData = $request->validate([
            'customer_name' => ['nullable', 'string', 'max:255'],
            'sale_date' => ['required', 'date'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        $saleData = [
            'customer_name' => $validatedData['customer_name'] ?? null,
            'sale_date' => $validatedData['sale_date'],
        ];

        $this->saleService->processSale(
            $saleData,
            $validatedData['items']
        );

        return redirect()
            ->route('sales.index')
            ->with('success', 'Sale created successfully.');
    }


    public function getAllSales()
    {
        $sales = $this->saleService->getAllSales();

        return view('sales.index', compact('sales'));
    }
}
