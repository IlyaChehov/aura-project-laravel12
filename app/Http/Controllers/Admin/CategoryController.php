<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\IndexCategoryRequest;
use App\Http\Requests\Admin\Category\StoreCategoryRequest;
use App\Http\Resources\Admin\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CategoryController extends Controller
{
    public function index(IndexCategoryRequest $request): Response|ResponseFactory|AnonymousResourceCollection
    {
        $data = $request->validated();
        $data['filter'] = $data['filter'] ?? [];
        $categories = CategoryResource::collection(Category::filter($data['filter'])
            ->latest()
            ->paginate($data['pagination']['per_page'], '*', 'page', $data['pagination']['page']));

        if(Request::wantsJson()) {
            return $categories;
        }

        return inertia('Admin/Category/Index', compact('categories'));
    }

    public function create()
    {
        return inertia('Admin/Category/Create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        return CategoryResource::make(Category::find(1));
    }

    public function show()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response(status: ResponseAlias::HTTP_NO_CONTENT);
    }
}
