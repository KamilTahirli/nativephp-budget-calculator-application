<?php

namespace App\Repositories\Category;

use App\Interfaces\CategoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryInterface
{
    /**
     * @param string $type
     * @return mixed
     */
    public function getCategoriesByType(string $type): mixed
    {
        return Category::where('type', $type)->get();
    }
}
