<?php
namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;

class CategoryService{
    //inject the repository, so service can use its methods
    public function __construct(
        private CategoryRepository $categoryRepository
    ){}

    public function getAllCategories(){
        return $this->categoryRepository->getAllCategories();
    }

    public function createCategory(array $categoryData){
        return $this->categoryRepository->createCategory($categoryData);
    }

        public function getCategoryById(int $categoryId): ? Category{
            return $this->categoryRepository->getCategoryById($categoryId);
        }

        public function updateCategory(int $categoryId, array $categoryData){
            $this->categoryRepository->updateCategory($categoryId,$categoryData);
        }

        public function deleteCategory(int $categoryId){
            $this->categoryRepository->deleteCategory($categoryId);
        }
}