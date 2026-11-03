<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Repositories\PurchaseRepository;
use Illuminate\Http\Request;
use App\Services\PurchaseService;

class PurchaseController extends Controller
{
    //
    public function __construct(
        private PurchaseService $purchaseService
    ) {
    }

    public function showCreatePurchaseForm()
    {
        //retrieve active supplier for the supplier dropdown
        $suppliers = Supplier::where('is_active', true)->get();

        //retrieve active product for the dropdown
        $products = Product::where('is_active', true)->get();

        //display the create purchase page
        return view('purchases.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        // Validate the submitted purchase data
        $validatedData = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',

            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        // Separate purchase information from purchase items
        $purchaseData = [
            'supplier_id' => $validatedData['supplier_id'],
            'purchase_date' => $validatedData['purchase_date'],
            'status' => 'pending',
        ];

        // Create the purchase through the Service
        $purchase = $this->purchaseService->createPurchase(
            $purchaseData,
            $validatedData['items']
        );

        // Redirect after successful creation
        return redirect()
            ->route('purchases.index')
            ->with('success', 'Purchase created successfully.');
    }

    public function getAllPurchases()
    {
        $purchases = $this->purchaseService->getAllPurchases();

        return view('purchases.index', compact('purchases'));
    }

    // Display the details of a specific purchase
    public function showPurchaseDetails(int $purchaseId)
    {
        // Retrieve the purchase and its related information
        $purchase = $this->purchaseService->getPurchaseById($purchaseId);

        // Check whether the purchase exists
        if (!$purchase) {
            abort(404, 'Purchase not found.');
        }

        // Display the purchase details page
        return view('purchases.show', compact('purchase'));
    }

    public function receivePurchase(int $purchaseId)
    {
        $this->purchaseService->receivePurchase($purchaseId);

        return redirect()
            ->route('purchases.show', $purchaseId)
            ->with('success', 'Purchase received successfully. Stock has been updated.');
    }
}
