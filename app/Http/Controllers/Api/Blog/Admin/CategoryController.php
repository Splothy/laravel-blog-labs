<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Http\Controllers\Api\Blog\BaseController;
use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
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
        return $this->blogCategoryRepository->getAllWithPaginate(5);
    }

    public function store(BlogCategoryCreateRequest $request)
    {
        $item = BlogCategory::create($request->input());

        if ($item) {
            return [
                'success' => true,
                'message' => 'Успішно збережено',
                'data' => $item,
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

        return $item;
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
                'data' => $item->fresh(),
            ];
        }

        return ['message' => 'Помилка збереження'];
    }
}
