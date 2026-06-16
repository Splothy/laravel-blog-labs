<?php

namespace App\Repositories;

use App\Models\BlogCategory as Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class BlogCategoryRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * Отримати модель для редагування в адмінці.
     */
    public function getEdit($id): ?Model
    {
        return $this
            ->startConditions()
            ->with(['parentCategory:id,title'])
            ->find($id);
    }

    /**
     * Отримати список категорій для виводу в випадаючий список.
     */
    public function getForComboBox(): Collection
    {
        $columns = implode(', ', [
            'id',
            'CONCAT(id, ". ", title) AS id_title',
        ]);

        return $this
            ->startConditions()
            ->selectRaw($columns)
            ->toBase()
            ->get();
    }

    /**
     * Отримати категорії для виводу пагінатором.
     */
    public function getAllWithPaginate($perPage = null): LengthAwarePaginator
    {
        $columns = ['id', 'title', 'slug', 'parent_id'];

        return $this
            ->startConditions()
            ->select($columns)
            ->with(['parentCategory:id,title'])
            ->paginate($perPage);
    }
}
