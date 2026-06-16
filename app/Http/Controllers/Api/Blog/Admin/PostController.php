<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Http\Controllers\Api\Blog\BaseController;
use App\Http\Requests\BlogPostCreateRequest;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Jobs\BlogPostAfterCreateJob;
use App\Jobs\BlogPostAfterDeleteJob;
use App\Models\BlogPost;
use App\Repositories\BlogCategoryRepository;
use App\Repositories\BlogPostRepository;

class PostController extends BaseController
{
    public function __construct(
        private BlogPostRepository $blogPostRepository,
        private BlogCategoryRepository $blogCategoryRepository,
    ) {
        parent::__construct();
    }

    public function index()
    {
        return $this->blogPostRepository->getAllWithPaginate();
    }

    public function store(BlogPostCreateRequest $request)
    {
        $item = BlogPost::create($request->validated());

        if ($item) {
            BlogPostAfterCreateJob::dispatch($item);

            return [
                'success' => true,
                'message' => 'Успішно збережено',
                'data' => $item->fresh(['category:id,title', 'user:id,name']),
            ];
        }

        return ['message' => 'Помилка збереження'];
    }

    public function update(BlogPostUpdateRequest $request, string $id)
    {
        $item = $this->blogPostRepository->getEdit($id);

        if (empty($item)) {
            return response()->json([
                'message' => "Запис id=[{$id}] не знайдено",
            ], 404);
        }

        $result = $item->update($request->validated());

        if ($result) {
            return [
                'success' => true,
                'message' => 'Успішно збережено',
                'data' => $item->fresh(['category:id,title', 'user:id,name']),
            ];
        }

        return ['message' => 'Помилка збереження'];
    }

    public function destroy(string $id)
    {
        $result = BlogPost::destroy($id);

        if ($result) {
            BlogPostAfterDeleteJob::dispatch((int) $id)->delay(now()->addSeconds(20));

            return [
                'success' => true,
                'message' => 'Статтю видалено',
            ];
        }

        return response()->json([
            'success' => false,
            'message' => "Запис id=[{$id}] не знайдено",
        ], 404);
    }
}
