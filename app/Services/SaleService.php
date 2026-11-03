<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Sale;
use App\Repositories\SaleRepository;
use Illuminate\Validation\ValidationException;
use App\Services\StockMovementService;
use Illuminate\Support\Facades\DB;

class SaleService
{
    public function __construct(
        private SaleRepository $saleRepository,
        private StockMovementService $stockMovementService
    ) {
    }

    public function createSale(array $saleData): Sale
    {
        return $this->saleRepository->createSale($saleData);
    }

    public function getAllSales()
    {
        return $this->saleRepository->getAllSales();
    }

    public function calculateSaleItems(array $items): array
    {
        $saleItems = [];

        foreach ($items as $item) {
            $product = Product::findOrFail($item['product_id']);

            if ($item['quantity'] > $product->quantity) {
                throw ValidationException::withMessages([
                    'items' => "Insufficient stock for product: {$product->name}. Available quantity: {$product->quantity}.",
                ]);
            }

            $unitPrice = $product->selling_price;
            $subtotal = $item['quantity'] * $unitPrice;

            $saleItems[] = [
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'unit_price' => $unitPrice,
                'subtotal' => $subtotal,
            ];
        }
        return $saleItems;
    }

    public function calculateTotalAmount(array $saleItems): float
    {
        return array_sum(
            array_column($saleItems, 'subtotal')
        );
    }

    public function processSale(array $saleData, array $items): Sale
    {
        return DB::transaction(function () use ($saleData, $items) {

            // Prepare sale items and calculate their subtotals.
            $saleItems = $this->calculateSaleItems($items);

            // Calculate the complete sale amount.
            $totalAmount = $this->calculateSaleTotal($saleItems);

            // Create the main sale record.
            $sale = $this->saleRepository->createSale([
                ...$saleData,
                'total_amount' => $totalAmount,
                'status' => 'completed',
            ]);

            // Attach the sale ID to every sale item.
            foreach ($saleItems as &$item) {
                $item['sale_id'] = $sale->id;
            }
            unset($item);

            // Save all sale items.
            $this->saleRepository->createSaleItems($saleItems);

            // Reduce stock and record stock-out movements.
            foreach ($saleItems as $item) {
                $this->stockMovementService->removeStock(
                    $item['product_id'],
                    $item['quantity'],
                    'sale',
                    'Sale #' . $sale->id
                );
            }

            return $sale;
        });
    }

    public function calculateSaleTotal(array $saleItems): float
    {
        return array_sum(
            array_column($saleItems, 'subtotal')
        );
    }
}