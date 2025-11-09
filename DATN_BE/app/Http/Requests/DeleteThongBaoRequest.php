<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteThongBaoRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'id' => 'required|exists:thong_baos,id',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'ID thông báo không được để trống.',
            'id.exists' => 'Thông báo không tồn tại hoặc đã bị xóa.',
        ];
    }
}

