<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Http\Controllers\Api\Blog\BaseController;
use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Http\Resources\Api\Blog\Admin\CategoryResource;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;

class CategoryController extends BaseController
{
    public function __construct(private BlogCategoryRepository $blogCategoryRepository)
    {
        parent::__construct();
    }

    public function index()
    {
        $paginator = $this->blogCategoryRepository->getAllWithPaginate(
            request()->integer('per_page', 5)
        );

        return CategoryResource::collection($paginator);
    }

    public function store(BlogCategoryCreateRequest $request)
    {
        $item = BlogCategory::create($request->input());

        if ($item) {
            return [
                'success' => true,
                'message' => 'Успішно збережено',
                'data' => new CategoryResource($item->fresh(['parentCategory:id,title'])),
            ];
        }

        return ['message' => 'Помилка збереження'];
    }

    public function show(string $id)
    {
        $item = $this->blogCategoryRepository->getEdit($id);

        if (empty($item)) {
            return response()->json([
                'message' => "Запис id=[{$id}] не знайдено",
            ], 404);
        }

        return new CategoryResource($item);
    }

    public function update(BlogCategoryUpdateRequest $request, string $id)
    {
        $item = $this->blogCategoryRepository->getEdit($id);

        if (empty($item)) {
            return response()->json([
                'message' => "Запис id=[{$id}] не знайдено",
            ], 404);
        }

        $result = $item->update($request->input());

        if ($result) {
            return [
                'success' => true,
                'message' => 'Успішно збережено',
                'data' => new CategoryResource($item->fresh(['parentCategory:id,title'])),
            ];
        }

        return ['message' => 'Помилка збереження'];
    }

    public function destroy(string $id)
    {
        $result = BlogCategory::destroy($id);

        if ($result) {
            return [
                'success' => true,
                'message' => 'Категорію видалено',
            ];
        }

        return response()->json([
            'success' => false,
            'message' => "Запис id=[{$id}] не знайдено",
        ], 404);
    }
}
