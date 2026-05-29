<?php

namespace App\Observers;

use App\Models\BlogPost;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BlogPostObserver
{
    /**
     * Обробка перед оновленням запису.
     */
    public function updating(BlogPost $blogPost): void
    {
        $this->setPublishedAt($blogPost);
        $this->setSlug($blogPost);
    }

    /**
     * Якщо поле published_at порожнє і is_published=true,
     * генеруємо поточну дату.
     */
    protected function setPublishedAt(BlogPost $blogPost): void
    {
        if (empty($blogPost->published_at) && $blogPost->is_published) {
            $blogPost->published_at = Carbon::now();
        }
    }

    /**
     * Якщо псевдонім порожній, генеруємо його з title.
     */
    protected function setSlug(BlogPost $blogPost): void
    {
        if (empty($blogPost->slug)) {
            $blogPost->slug = Str::slug($blogPost->title);
        }
    }
}
