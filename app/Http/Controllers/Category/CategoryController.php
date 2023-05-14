<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Services\Category\CategoryService;

/**
 * @group Category
 */
class CategoryController extends Controller
{
    public function __construct(protected CategoryService $service)
    {
    }

    /**
     * Category-list (userni postlarini olish)
     * @ResponseFile 401 storage/response/auth/401.json
     * @ResponseFile 401 storage/response/category/200.json
     */
    public function categoryList()
    {
        $list = $this->service->categoryList();
        return success($list);
    }
}
