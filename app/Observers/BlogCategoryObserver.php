<?php

namespace App\Observers;

use App\Models\BlogCategory;
use Illuminate\Support\Str;

class BlogCategoryObserver
{
    /**
     * Обробка перед створенням запису.
     */
    public function creating(BlogCategory $blogCategory): void
    {
        $this->setSlug($blogCategory);
    }

    /**
     * Обробка перед оновленням запису.
     */
    public function updating(BlogCategory $blogCategory): void
    {
        $this->setSlug($blogCategory);
    }

    /**
     * Якщо псевдонім порожній, генеруємо його з title.
     */
    protected function setSlug(BlogCategory $blogCategory): void
    {
        if (empty($blogCategory->slug)) {
            $blogCategory->slug = Str::slug($blogCategory->title);
        }
    }
}
