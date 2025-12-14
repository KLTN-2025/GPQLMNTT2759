<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteBaiVietRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'id' => 'required|exists:bai_viets,id',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'ID bài viết không được để trống.',
            'id.exists' => 'Bài viết không tồn tại hoặc đã bị xóa.',
        ];
    }
}


