<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    //inject the service,so controller can use ites methods
    public function __construct(
        private CategoryService $categoryService
    ) {
    }

    public function getAllCategories()
    {
        //retrive categories througn service layer
        $categories = $this->categoryService->getAllCategories();

        //pass the categories to the blade views
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $categoryData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        //create category through the service layer
        $this->categoryService->createCategory($categoryData);

        //redirect to category list with the success message
        return redirect()
            ->route('categories.index')
            ->with('success', 'Category created successfully');
    }

    public function showCategoryCreateForm()
    {
        return view('categories.create');
    }

    //displlay edit category form
    public function showEditCategoryForm($categoryId)
    {
        $category = $this->categoryService->getCategoryById($categoryId);

        //return 404 if category doesnt exist
        if (!$category) {
            abort(404);
        }

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, int $categoryId)
    {
        $categoryData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $categoryId,
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        //update category through the service layer
        $this->categoryService->updateCategory($categoryId, $categoryData);

        return redirect()
        ->route('categories.index')
        ->with('success', 'Category updated successfully');
    }

    public function delete(int $categoryId){
        $this->categoryService->deleteCategory($categoryId);

        return redirect()
        ->route('categories.index')
        ->with('success','Category deleted successfully');
    }

}