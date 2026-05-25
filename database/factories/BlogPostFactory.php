<?php

namespace Database\Factories;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<BlogPost>
 */
class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(rand(3, 8), true);
        $text = $this->faker->realText(rand(1000, 4000));
        $date = $this->faker->dateTimeBetween('-3 months', '-2 months');
        $isPublished = rand(1, 5) > 1;

        return [
            'category_id' => rand(1, 11),
            'user_id' => rand(1, 5) === 1 ? 1 : 2,
            'title' => $title,
            'slug' => Str::slug($title).'-'.$this->faker->unique()->randomNumber(6),
            'excerpt' => $this->faker->text(rand(40, 100)),
            'content_raw' => $text,
            'content_html' => $text,
            'is_published' => $isPublished,
            'published_at' => $isPublished ? $date : null,
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
