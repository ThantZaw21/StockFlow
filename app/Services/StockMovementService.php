<?php

namespace App\Services;

use App\Models\StockMovement;
use App\Repositories\ProductRepository;
use App\Repositories\StockMovementRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class StockMovementService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private StockMovementRepository $stockMovementRepository,
        private ProductRepository $productRepository
    ) {
    }

    //add stock to a product and  record the movement
    public function addStock(
        int $productId,
        int $quantity,
        string $reason,
        ?string $notes = null
    ): StockMovement {
        //make sure the incoming quantity is greater than zero
        if ($quantity <= 0) {
            throw ValidationException::withMessages([
                'quantity' => 'Quantity must be greater than zero'
            ]);
        }

        //run both database operations inside one transaction
        return DB::transaction(function () use ($productId, $quantity, $reason, $notes) {
            //find the  product
            $product = $this->productRepository->getProductById($productId);

            //calculate the new stock balance
            $newBalance = $product->quantity + $quantity;

            //update the product current stock quantity in the database
            $this->productRepository->updateProduct($productId, [
                'quantity' => $newBalance
            ]);

            //updates the product's current quantity
            return $this->stockMovementRepository->createStockMovement([
                'product_id' => $productId,
                'type' => 'in',
                'quantity' => $quantity,
                'balance_after' => $newBalance,
                'reason' => $reason,
                'notes' => $notes,
            ]);
        });
    }

    public function removeStock(
        int $productId,
        int $quantity,
        string $reason,
        ?string $notes = null
    ): StockMovement {
        if ($quantity <= 0) {
            throw ValidationException::withMessages([
                'quantity' => 'Quantity must be greater than zero.'
            ]);
        }

        return DB::transaction(function () use ($productId, $quantity, $reason, $notes) {
            //find the product
            $product = $this->productRepository->getProductById($productId);

            if ($product->quantity < $quantity) {
                throw ValidationException::withMessages([
                    'quantity' => 'Insufficient stock.Available quantity is ' . $product->quantity,
                ]);
            }

            //calculate stock 
            $newBalance = $product->quantity - $quantity;

            //update the product's current stock quantity in the database
            $this->productRepository->updateProduct($productId, [
                'quantity' => $newBalance
            ]);

            return $this->stockMovementRepository->createStockMovement([
                'product_id' => $productId,
                'type' => 'out',
                'quantity' => $quantity,
                'balance_after' => $newBalance,
                'reason' => $reason,
                'notes' => $notes,
            ]);

        });
    }
}
