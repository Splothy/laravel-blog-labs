<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogPostCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|min:5|max:200|unique:blog_posts,title',
            'slug' => 'nullable|max:200|unique:blog_posts,slug',
            'excerpt' => 'nullable|max:500',
            'content_raw' => 'required|string|min:5|max:10000',
            'category_id' => 'required|integer|exists:blog_categories,id',
            'is_published' => 'sometimes|boolean',
            'published_at' => 'nullable|date',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Введіть заголовок статті',
            'slug.max' => 'Максимальна довжина [:max]',
            'content_raw.min' => 'Мінімальна довжина статті [:min] символів',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title' => 'Заголовок статті',
        ];
    }
}
