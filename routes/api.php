<?php

use App\Http\Controllers\Api\Blog\Admin\CategoryController;
use App\Http\Controllers\Api\Blog\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('blog')->group(function (): void {
    Route::apiResource('posts', PostController::class)->names('blog.posts');
});

Route::prefix('admin/blog')->group(function (): void {
    Route::apiResource('categories', CategoryController::class)
        ->only(['index', 'store', 'update'])
        ->names('blog.admin.categories');
});
