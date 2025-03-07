<?php

namespace App\Services\Frontend\API;

use App\Interfaces\CategoryInterface;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryService
{

    public function __construct(private readonly CategoryInterface $categoryRepository)
    {
    }

    public function getCategories(Request $request)
    {
        return $this->categoryRepository->getCategoriesByType($request->input('type'));
    }
}
