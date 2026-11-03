<?php
namespace App\Services;
use App\Models\Product;
use App\Repositories\ProductRepository;

class ProductService
{
    public function __construct(
        private ProductRepository $productRepository
    ) {
    }

    public function getAllProducts()
    {
        return $this->productRepository->getAllProducts();
    }

    public function createProduct($productData): Product
    {
        return $this->productRepository->createProduct($productData);
    }

    public function updateProduct(int $productId, array $productData): void
    {
        $this->productRepository->updateProduct($productId, $productData);
    }

    public function getProductById(int $productId): ?Product{
        return $this->productRepository->getProductById($productId);
    }

    public function deleteProduct(int $productId):void{
        $this->productRepository->deleteProduct($productId);
    }
}