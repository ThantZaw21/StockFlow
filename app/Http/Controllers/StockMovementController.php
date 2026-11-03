<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use App\Repositories\StockMovementRepository;
use App\Services\StockMovementService;

use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    //
    public function __construct(
        private StockMovementService $stockMovementService,
        private StockMovementRepository $stockMovementRepository,
        private ProductRepository $productRepository
    ) {
    }

    public function getAllStockMovements()
    {
        $stockMovements = $this->stockMovementRepository->getAllStockMovements();

        $products = $this->productRepository->getAllProducts();

        return view('stock-movements.index', compact('stockMovements', 'products'));
    }

    public function storeStockIn(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $this->stockMovementService->addStock(
            $validatedData['product_id'],
            $validatedData['quantity'],
            $validatedData['reason'],
            $validatedData['notes'] ?? null
        );

        return redirect()
            ->route('stock-movements.index')
            ->with('success', 'Stock added successfully.');
    }

    public function storeStockOut(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $this->stockMovementService->removeStock(
            $validatedData['product_id'],
            $validatedData['quantity'],
            $validatedData['reason'],
            $validatedData['notes'] ?? null
        );

        return redirect()
        ->route('stock-movements.index')
        ->with('success', 'Stock removed successfully.');
    }
}
