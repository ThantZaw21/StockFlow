<?php
namespace App\Repositories;
use App\Models\Product;
class ProductRepository{
    public function getAllProducts(){
        //retrieve all products from the database
        return Product::all();
    }

    public function getProductById(int $productId){
        return Product::find($productId);
    }

    public function createProduct(array $productData):Product{
        //create a new product using a validated product data
        return Product::create($productData);
    }

    public function updateProduct(int $productId, array  $productData):bool{
        $product = Product::findOrFail($productId);

        return $product->update($productData);
    }

    public function deleteProduct(int $productId):void{
        $product = Product::findOrFail($productId);

        $product->delete(); 
    }
}