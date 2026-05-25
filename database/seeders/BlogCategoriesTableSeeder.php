<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class BlogCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [];

        $categoryName = 'Без категорії';
        $categories[] = [
            'title' => $categoryName,
            'slug' => Str::slug($categoryName),
            'parent_id' => 0,
        ];

        for ($i = 1; $i <= 10; $i++) {
            $categoryName = 'Категорія #'.$i;
            $parentId = ($i > 4) ? rand(1, 4) : 1;

            $categories[] = [
                'title' => $categoryName,
                'slug' => Str::slug($categoryName),
                'parent_id' => $parentId,
            ];
        }

        DB::table('blog_categories')->insert($categories);
    }
}
