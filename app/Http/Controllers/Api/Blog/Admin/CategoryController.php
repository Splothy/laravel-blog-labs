<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Http\Controllers\Api\Blog\BaseController;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return BlogCategory::paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if (empty($data['slug']) && ! empty($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $validated = validator($data, [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:blog_categories,slug'],
            'parent_id' => ['sometimes', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
        ])->validate();

        $item = BlogCategory::create($validated);

        return response()->json($item, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $category)
    {
        $item = BlogCategory::find($category);

        if ($item === null) {
            return response()->json([
                'message' => "Запис id=[{$category}] не знайдено",
            ], 404);
        }

        $data = $request->all();

        if (empty($data['slug']) && ! empty($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $validated = validator($data, [
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('blog_categories', 'slug')->ignore($item->id),
            ],
            'parent_id' => ['sometimes', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
        ])->validate();

        $item->update($validated);

        return response()->json([
            'success' => 'Успішно збережено',
            'data' => $item->fresh(),
        ]);
    }
}
