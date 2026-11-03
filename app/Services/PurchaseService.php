<?php

namespace App\Services;

use App\Models\Purchase;
use Illuminate\Support\Facades\DB;
use App\Repositories\PurchaseRepository;
use App\Services\StockMovementService;
use Illuminate\Validation\ValidationException;

class PurchaseService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private PurchaseRepository $purchaseRepository,
        private StockMovementService $stockMovementService
    ) {
    }

    public function calculatePurchaseItems(array $items)
    {
        $purchasedItems = [];

        foreach ($items as $item) {
            $subtotal = $item['quantity'] * $item['unit_price'];

            $purchasedItems[] = [
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'subtotal' => $subtotal,
            ];
        }

        return $purchasedItems;

    }

    public function createPurchase(array $purchaseData, array $items): Purchase
    {
        return DB::transaction(function () use ($purchaseData, $items) {
            //calculate subtotals for purchased items
            $purchaseItems = $this->calculatePurchaseItems($items);

            //calculate the overall purchase amount
            $totalAmount = array_sum(array_column($purchaseItems, 'subtotal'));

            //add the calculated total to purchase data 
            $purchaseData['total_amount'] = $totalAmount;

            //create the parent purchase record
            $purchase = $this->purchaseRepository->createPurchase($purchaseData);

            //attach the generated ID to every item
            foreach ($purchaseItems as &$purchaseItem) {
                $purchaseItem['purchase_id'] = $purchase->id;
            }

            unset($purchaseItem);

            // Save all purchase items
            $this->purchaseRepository->createPurchaseItems($purchaseItems);

            return $purchase;
        });
    }

    public function receivePurchase(int $purchaseId): Purchase
    {
        return DB::transaction(function () use ($purchaseId) {

            // Retrieve the purchase with its items
            $purchase = $this->purchaseRepository->getPurchaseById($purchaseId);

            if (!$purchase) {
                abort(404, 'Purchase not found.');
            }

            // Only pending purchases can be received
            if ($purchase->status !== 'pending') {
                throw ValidationException::withMessages([
                    'purchase' => 'This purchase has already been processed.',
                ]);
            }

            // Add the purchased quantities to product stock
            foreach ($purchase->items as $item) {
                $this->stockMovementService->addStock(
                    $item->product_id,
                    $item->quantity,
                    'purchase',
                    'Purchase #' . $purchase->id
                );
            }

            // Mark the purchase as received
            $purchase->update([
                'status' => 'received',
            ]);

            return $purchase;
        });
    }

    public function getAllPurchases()
    {
        return $this->purchaseRepository->getAllPurchases();
    }

    // Retrieve one purchase with all its related information
    public function getPurchaseById(int $purchaseId): ?Purchase
    {
        return $this->purchaseRepository->getPurchaseById($purchaseId);
    }

}
