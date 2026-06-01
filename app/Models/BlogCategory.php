<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const ROOT = 1;

    protected $fillable = [
        'title',
        'slug',
        'parent_id',
        'description',
    ];

    protected $appends = [
        'parent_title',
    ];

    /**
     * Батьківська категорія.
     */
    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'parent_id', 'id');
    }

    /**
     * Приклад аксесуара.
     */
    public function getParentTitleAttribute(): string
    {
        return $this->parentCategory->title
            ?? ($this->isRoot() ? 'Корінь' : '???');
    }

    /**
     * Перевірка чи об'єкт є кореневим.
     */
    public function isRoot(): bool
    {
        return $this->id === self::ROOT;
    }
}
