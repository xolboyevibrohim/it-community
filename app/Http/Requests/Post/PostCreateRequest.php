<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array`
     */
    public function rules(): array
    {
        return [
            'title'=>'required|string',
            'description'=>'required|string',
            'file'=>'required|mimes:jpg,png,jpeg,svg|max:10240',
            'category_id'=>'required|integer|exists:categories,id'
        ];
    }
    public function bodyParameters(): array
    {
        return [
            'title' => [
                'description' => 'Postni sarlavhasi',
                'example' => 'chatGpt haqida',
            ],
            'description' => [
                'description' => 'Post texti',
                'example' => 'postni umumiy mazmuni',
            ],
            'file' => [
                'description' => 'Post uchun file',
                'example' => 'rasm.jpg',
            ],
            'category_id' => [
                'description' => 'categoriyani id si',
                'example' => '1',
            ],
        ];
    }
    public function failedValidation($validator){
        failedValidation($validator);
    }
}
