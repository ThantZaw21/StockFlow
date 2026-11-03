<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    //retrive all categories from the database
    public function getAllCategories()
    {
        return Category::all();
    }

    public function createCategory(array $categoryData)
    {
        return Category::create($categoryData);
    }

    public function getCategoryById(int $categoryId): ?Category
    {
        return Category::find($categoryId);
    }

    public function updateCategory(int $categoryId, array $categoryData): void
    {
        $category = Category::findOrFail($categoryId);

        $category->update($categoryData);
    }

    public function deleteCategory(int $categoryId){
        $category = Category::findOrFail($categoryId);

        $category->delete();
    }
}