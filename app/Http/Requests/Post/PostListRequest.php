<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostListRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'per_page'=>'nullable|integer',
        ];
    }
    public function bodyParameters(): array
    {
        return [
            'per_page' => [
                'description' => 'page dagi postlar soni(default-10)',
                'example' => '12',
            ]
        ];
    }
}
