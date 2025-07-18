<?php

namespace Modules\Category\App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Category\Service\CategoryService;
use Modules\Category\App\resources\CategoryResource;

class CategoryController extends Controller
{
    protected $categoryService;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function index(Request $request)
    {
        $data = $request->all();
        $categories = $this->categoryService->active($data);
        return returnMessage(true, 'Categories Fetched Successfully', CategoryResource::collection($categories)->response()->getData(true));
    }
}