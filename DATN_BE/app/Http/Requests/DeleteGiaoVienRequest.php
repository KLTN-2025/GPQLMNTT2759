<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteGiaoVienRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'id' => 'required|exists:giao_viens,id',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'ID giáo viên không được để trống.',
            'id.exists'   => 'Giáo viên không tồn tại trong hệ thống.',
        ];
    }
}
