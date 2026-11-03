<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\SupplierController;
use App\Models\StockMovement;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

//-------Products---------
//display dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

//display all products
Route::get('/products', [
    ProductController::class,
    'getAllProducts'
])->name('products.index');

//display product create form
Route::get('/products/create', [
    ProductController::class,
    'showCreateProductForm'
])->name('products.create');

//handle the submitted product create form 
Route::post('products', [
    ProductController::class,
    'store'
])->name('products.store');

//display edit form for a specific product
Route::get('/products/{productid}/edit', [
    ProductController::class,
    'showEditProductForm'
])->name('products.edit');

//store modified product data
Route::put('/products/{productId}', [
    ProductController::class,
    'update'
])->name('products.update');

//delete product
Route::delete('/products/{productId}', [
    ProductController::class,
    'delete'
])->name('products.destroy');

//show products  details
Route::get('/products/{productId}', [
    ProductController::class,
    'showProductDetails'
])->name('products.show');

//------category---------
Route::get('/categories', [
    CategoryController::class,
    'getAllCategories'
])->name('categories.index');

//display category creation form
Route::get('/categories/create', [
    CategoryController::class,
    'showCategoryCreateForm'
])->name('categories.create');

//store a new category
Route::post('categories', [
    CategoryController::class,
    'store'
])->name('categories.store');

//display category edit form
Route::get('categories/{categoryId}/edit', [
    CategoryController::class,
    'showEditCategoryForm'
])->name('categories.edit');

//update exisiting category
Route::put('categories/{categoryId}', [
    CategoryController::class,
    'update'
])->name('categories.update');

//delete category
Route::delete('/categories/{categoryId}', [
    CategoryController::class,
    'delete'
])->name('categories.destroy');

//----------Suppliers------------
Route::get('/suppliers', [
    SupplierController::class,
    'getAllSuppliers'
])->name('suppliers.index');

//show supplier create form
Route::get('/suppliers/create', [
    SupplierController::class,
    'showCreateSupplierForm'
])->name('suppliers.create');

//store supplier data
Route::post('/suppliers', [
    SupplierController::class,
    'store'
])->name('suppliers.store');

//display supplier update form
Route::get('/suppliers/{id}/edit', [
    SupplierController::class,
    'showEditSupplierForm'
])->name('suppliers.edit');

//store supplier data
Route::put('/suppliers/{supplierId}', [
    SupplierController::class,
    'update'
])->name('suppliers.update');

//delete supplier
Route::delete('/suppliers/{supplierId}', [
    SupplierController::class,
    'delete'
])->name('suppliers.destroy');

//-----stock-movement-----------

//show all stock movements
Route::get('/stock-movements', [
    StockMovementController::class,
    'getAllStockMovements'
])->name('stock-movements.index');

//handle stock in form submission
Route::post('/stock-movements/in', [
    StockMovementController::class,
    'storeStockIn'
])->name('stock-movements.stock-in');

//handle stock out form submission
Route::post('stock-movements/out', [
    StockMovementController::class,
    'storeStockOut'
])->name('stock-movements.stock-out');

//------- Purchase Management-------
Route::get('/purchases/create', [
    PurchaseController::class,
    'showCreatePurchaseForm'
])->name('purchases.create');

Route::post('/purchases', [
    PurchaseController::class,
    'store'
])->name('purchases.store');

Route::get('/purchases', [
    PurchaseController::class,
    'getAllPurchases'
])->name('purchases.index');

Route::get('/purchases/{purchaseId}', [
    PurchaseController::class,
    'showPurchaseDetails'
])->name('purchases.show');

Route::post('/purchases/{purchaseId}/receive', [
    PurchaseController::class,
    'receivePurchase'
])->name('purchases.receive');

//-------create sale-------------
Route::post('/sales', [
    SaleController::class,
    'createSale'
])->name('sales.store');

Route::get('/sales/create', [
    SaleController::class,
    'showCreateSaleForm'
])->name('sales.create');

// Display all sales
Route::get('/sales', [
    SaleController::class,
    'getAllSales'
])->name('sales.index');