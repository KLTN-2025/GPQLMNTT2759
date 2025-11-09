<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteNhanVienRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'id' => 'required|exists:nhan_viens,id',
        ];
    }
    public function messages(): array
    {
        return [
            'id.required' => 'ID nhân viên không được để trống.',
            'id.exists'   => 'Nhân viên không tồn tại hoặc đã bị xoá.',
        ];
    }
}
