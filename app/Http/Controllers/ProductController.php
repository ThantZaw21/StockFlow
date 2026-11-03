<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Models\Category;

class ProductController extends Controller
{
    //
    public function __construct(
        private ProductService $productService
    ) {
    }

    public function getAllProducts()
    {
        //ask the service to retrieve all products
        $products = $this->productService->getAllProducts();

        //pass the product to the blade view
        return view('products.index', compact('products'));
    }

    //show product create form
    public function showCreateProductForm()
    {
        $categories = Category::where('is_active', true)->get();

        return view('products.create', compact('categories'));
    }

    //post product create
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'sku' => 'required|string|max:255|unique:products,sku',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0|gte:purchase_price',
            'quantity' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
        ]);

        $this->productService->createProduct($validatedData);
        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function showEditProductForm(int $productId)
    {
        $product = $this->productService->getProductById($productId);

        if (!$product) {
            abort(404);
        }

        // Retrieve active categories for the dropdown.
        $categories = Category::where('is_active', true)->get();

        // Pass both product and categories to the Blade view.
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, int $productId)
    {
        // Validate the submitted product information.
        $validatedData = $request->validate([
            'sku' => 'required|string|max:255|unique:products,sku,' . $productId,
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0|gte:purchase_price',
            'quantity' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
        ]);

        // Ask the Service to update the existing product.
        $this->productService->updateProduct($productId, $validatedData);

        // Return to the product list with a success message.
        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function delete(int $productId)
    {
        $this->productService->deleteProduct($productId);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully');
    }

    public function showProductDetails(int $productId)
    {
        $product = $this->productService->getProductById($productId);

        if (!$product) {
            abort(404);
        }

        return view('products.show', compact('product'));
    }
}
