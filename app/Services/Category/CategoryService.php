<?php

namespace App\Services\Category;

use App\Models\Category;

class CategoryService
{
    public function categoryList()
    {
        return Category::select(['name','id'])->get();
    }
}
