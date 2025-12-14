<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeletePhuHuynhRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'id' => 'required|exists:phu_huynhs,id',
        ];
    }
    public function messages(): array
    {
        return [
            'id.required' => 'ID Phụ huynh không được để trống.',
            'id.exists'   => 'Phụ huynh không tồn tại hoặc đã bị xoá.',
        ];
    }
}
