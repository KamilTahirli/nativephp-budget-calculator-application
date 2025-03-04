<?php

namespace App\Services\Frontend\API;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryService
{
    /**
     * @param Request $request
     * @return string
     */
    public function getCategories(Request $request): string
    {
        $categories = Category::where('type', $request->type)->get();
        return view('frontend.partials.render.__categories', compact('categories'))->render();
    }
}
