<?php

namespace App\Repositories;

use App\Models\BlogPost as Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BlogPostRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * Отримати список статей.
     */
    public function getAllWithPaginate(): LengthAwarePaginator
    {
        $columns = [
            'id',
            'title',
            'slug',
            'is_published',
            'published_at',
            'user_id',
            'category_id',
        ];

        return $this
            ->startConditions()
            ->select($columns)
            ->orderBy('id', 'DESC')
            ->paginate(25);
    }

    /**
     * Отримати модель для редагування в адмінці.
     */
    public function getEdit($id): ?Model
    {
        return $this->startConditions()->find($id);
    }
}
