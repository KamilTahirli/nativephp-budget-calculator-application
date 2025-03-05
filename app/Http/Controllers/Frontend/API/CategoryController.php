<?php

namespace App\Http\Controllers\Frontend\API;

use App\Http\Controllers\Controller;
use App\Services\Frontend\API\CategoryService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{

    /**
     * @param CategoryService $categoryService
     */
    public function __construct(private readonly CategoryService $categoryService)
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getCategories(Request $request): JsonResponse
    {
        try {
            $categories = $this->categoryService->getCategories($request);
            return $this->successResponse(data: $categories);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('site.response.an_error_occurred'));
        }
    }
}
